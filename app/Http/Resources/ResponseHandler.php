<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Response;

trait ResponseHandler
{
    public function response($data = null, $message = null, $code = null)
    {

        $response = [
            'data' => $data,
            'message' => $message,
            'code' => $code
        ];

        return response()->json($response)
            ->setStatusCode($code);
    }
}
