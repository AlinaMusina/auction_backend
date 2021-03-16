<?php

namespace App\Http\Controllers;

use App\Models\MaximumBidAmounts;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigController extends ApiController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getConfig(Request $request)
    {
        return $this->response([
            'max_bid_value' => $request->user()->maximum_bid_amount->value ?? $this->getDefaultMaxBidAmount()
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateConfig(Request $request)
    {
        if($record = $request->user()->maximum_bid_amount){
            $record->value = $request->max_bid_value;
            $record->save();
        } else {
            MaximumBidAmounts::create([
                'value' => $request->max_bid_value,
                'user_id' => $request->user()->id
            ]);
        }

        return $this->successResponse('config updated');
    }

    /**
     * @return int
     */
    protected function getDefaultMaxBidAmount() : int
    {
        return 100;
    }
}
