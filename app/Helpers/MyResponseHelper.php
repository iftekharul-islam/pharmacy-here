<?php

use GuzzleHttp\Client;

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


if (!function_exists('sendPushNotification')) {
    function sendPushNotification($fcm_token, $title, $message, $id="") {
        $push_notification_key = "AAAAPzxd2Vc:APA91bGFaHMD4U3MIj0_m1tayV_mVdlct1oBU3QgGcwr1m-eogh1gCyXVvbkdkcAmMRZcKRKAYqlWgXq-BQAE2-xtZ1w59wc8fcVotPPfFpaUaKJV9M6ZK82Lc9Y6QQiPBu0WXtLuuuU";
        $url = "https://fcm.googleapis.com/fcm/send";

        logger('device id: ' .$fcm_token);

        $body = '{
            "to": "'. $fcm_token .'",
            "notification": {
                "title": "' . $title . '",
                "text": "Test message"
            },
            "data": {
                "id": 123,
                "title": "Test",
                "description": "test Title",
                "text": "hello world",
                "order": "Hello",
                "is_read": 0
            }
        }';

        $post = new Client([
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'key=' . $push_notification_key
            ],
        ]);



        $result = $post->request('POST', $url, [
            'body' => $body
        ]);


        logger('response: ' . $result->getBody());

        return $result->getBody()->getContents();
    }
}
