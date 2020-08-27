<?php

return [
    'minimum_order_amount' => 100,
    'minimum_delivery_charge_amount' => 400,
    'normal_delivery_charge' => 20,
    'express_delivery_charge' => 40,
    'collect_from_pharmacy_charge' => 0,
    'collect_from_pharmacy_discount_percentage' => 3,
    'free_delivery_amount' => 5000,
    'cash_payment_charge_percentage' => 2,
    'ecash_payment_charge_percentage' => 2.3,
    'delivery_type' => [
        1 => [
            'name' => 'Normal Delivery',
            'charge' => 20,
        ],
        2 => [
            'name' => 'Express Delivery',
            'charge' => 40,
        ],
        3 => [
            'name' => 'Collect From Pharmacy',
            'charge' => 0
        ]
    ],
    'payment_method' => [
        1 => [
            'name' => 'Cash',
            'charge_percentage' => 2
        ],
        2 => [
            'name' => 'E-cash',
            'charge_percentage' => 2.3
        ]
    ]
];
