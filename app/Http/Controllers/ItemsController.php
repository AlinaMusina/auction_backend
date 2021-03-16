<?php

namespace App\Http\Controllers;

use App\Models\AutoBids;
use App\Models\Bids;
use App\Models\Items;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemsController extends ApiController
{
    /**
     * @return JsonResponse
     */
    public function getAll()
    {
        return $this->response(Items::all()->toArray());
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function getById(int $id, Request $request)
    {
        $record = Items::with(['bids'])->findOrFail($id);
        $arr = $record->toArray();
        $arr['bids'] = array_column($arr['bids'], 'price');
        $arr['auto_bidding'] = (bool)AutoBids::where('user_id', $request->user()->id)->where('item_id', $id)->count();

        return $this->response($arr);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function createBid(int $id, Request $request)
    {
        $item = Items::findOrFail($id);

        if($betterBid = Bids::where('item_id', $id)->where('price', '>=', $request->value)->orderBy('price', 'desc')->first()) {
            return $this->errorResponse('Your bid must be > than '.$betterBid->price);
        }

        $price = $this->makeBid($request->user()->id, $id, $request->value);

        $item->price = $price;
        $item->save();

        return $this->successResponse('Bid created');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function createAutoBid(int $id, Request $request)
    {
        AutoBids::updateOrCreate([
            'user_id' => $request->user()->id,
            'item_id' => $id
        ]);

        return $this->successResponse('Auto bidding set');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return JsonResponse
     */
    public function removeAutoBid(int $id, Request $request)
    {
        AutoBids::where('user_id', $request->user()->id)->where('item_id', $id)->delete();

        return $this->successResponse('Auto bidding removed');
    }

    /**
     * @param Bids $bid
     * @return mixed
     */
    protected function makeAutoBidding(Bids $bid) : float
    {
        $autoBid = AutoBids::where('item_id',$bid->item_id)->where('user_id', '<>', $bid->user_id)->whereHas('user', function($query) use ($bid){
            $query->whereHas('maximum_bid_amount', function($query) use ($bid) {
                $query->where('value', '>', $bid->price);
            });
        })->orderBy('created_at', 'asc')->first();

        if(!$autoBid){
            return $bid->price;
        }

        return $this->makeBid($autoBid->user_id, $autoBid->item_id, $bid->price+1);
    }

    /**
     * @param int $userId
     * @param int $itemId
     * @param float $price
     * @return mixed
     */
    protected function makeBid(int $userId, int $itemId, float $price) : float
    {
        $bid = Bids::create([
            'user_id' => $userId,
            'item_id' => $itemId,
            'price' => $price
        ]);

        return $this->makeAutoBidding($bid);
    }
}
