<?php

// SSLCommerz configuration

return [
    'projectPath' => env('PROJECT_PATH'),
    // For Sandbox on apiDomain, use "https://sandbox.sslcommerz.com"
    // For Live on apiDomain, use "https://securepay.sslcommerz.com"
    'apiDomain' => env("API_DOMAIN_URL"),
    'apiCredentials' => [
        'store_id' => env("SSL_STORE_ID"),
        'store_password' => env("SSL_STORE_PASSWORD"),
    ],
    'apiUrl' => [
        'make_payment' => "/gwprocess/v4/api.php",
        'transaction_status' => "/validator/api/merchantTransIDvalidationAPI.php",
        'order_validate' => "/validator/api/validationserverAPI.php",
        'refund_payment' => "/validator/api/merchantTransIDvalidationAPI.php",
        'refund_status' => "/validator/api/merchantTransIDvalidationAPI.php",
    ],
    'connect_from_localhost' => env("SSL_IS_LOCALHOST", true), // For Sandbox, use "true", For Live, use "false"
    'success_url' => '/success',
    'failed_url' => '/fail',
    'cancel_url' => '/cancel',
    'ipn_url' => '/ipn',
];
