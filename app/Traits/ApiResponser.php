<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponser
{
    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function successResponse(string $message)
    {
        return $this->response(['success'=> $message]);
    }

    /**
     * @param string $message
     * @return JsonResponse
     */
    protected function errorResponse(string $message)
    {
        return $this->response(['error'=> $message]);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function response(array $data)
    {
        return response()->json($data);
    }
}
