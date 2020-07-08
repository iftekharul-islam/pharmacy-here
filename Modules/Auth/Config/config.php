<?php

return [
    'name' => 'Auth',
    'password' => [
        'lifetime' => env('PASSWORD_RESET_LIFETIME_IN_SECONDS',5 * 60)
    ]
];
