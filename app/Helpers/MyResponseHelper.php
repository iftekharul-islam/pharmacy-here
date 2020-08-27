<?php

if (!function_exists('responseData')) {
    function responseData($message, $code = 200)
    {
        $response = [
            'message' => $message,
            'status_code' => $code
        ];

        return response()->json($response, $code); // Status code here
    }
}


if (!function_exists('responsePreparedData')) {
    function responsePreparedData($data, $code = 200)
    {
        $response = [
            'data' => $data,
            'status_code' => $code
        ];

        return response()->json($response, $code); // Status code here
    }
}
