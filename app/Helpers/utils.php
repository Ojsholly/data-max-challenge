<?php

use Illuminate\Http\Request;

if (!function_exists('call')) {

    function call(Request $request): object
    {
        $request->headers->set('accept', 'application/json');

        $response = app()->handle($request);

        return (object) [
            'status_code' => $response->status(),
            'message' => json_decode($response->getContent())->message ?? '',
            'data' => json_decode($response->getContent())->data ?? ''
        ];
    }
}