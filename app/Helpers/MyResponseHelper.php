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


if (!function_exists('sendPushNotification')) {
    function sendPushNotification($fcm_token, $title, $message, $id="") {
        $push_notification_key = ENV(PUSH_NOTIFICATION_KEY);
        $url = "https://fcm.googleapis.com/fcm/send";
        $header = array("authorization: key=" . $push_notification_key . "",
            "content-type: application/json"
        );

        $postdata = '{
            "to" : $deviceToken,
            "notification" : {
                "title":"Notification title",
                "text" : "Test Message"
            },
            "data" : {
                "id" : "123",
                "title":"test",
                "description" : "test",
                "text" : "message",
                "order" : 12,
                "is_read": 0
            }
        }';

        $ch = curl_init();
        $timeout = 120;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        // Get URL content
        $result = curl_exec($ch);
        // close handle to release resources
        curl_close($ch);

        return $result;
    }
}
