<?php

return [
    'name' => 'Auth',
    'password' => [
        'lifetime' => env('PASSWORD_RESET_LIFETIME_IN_SECONDS',5 * 60)
    ],
    'sms' => [
        'sms_user' => env('SMS_USER',''),
        'sms_pass' => env('SMS_PASS',''),
        'sms_sid' => env('SMS_SID',''),
        'lifetime' => env('OTP_LIFETIME_IN_SECONDS',5 * 60)
    ]
];
