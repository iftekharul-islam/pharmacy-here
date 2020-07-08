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
