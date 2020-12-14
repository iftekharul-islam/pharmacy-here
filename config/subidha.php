<?php

return [
    'minimum_order_amount' => 100,
    'minimum_delivery_charge_amount' => 400,
    'normal_delivery_charge' => 20,
    'express_delivery_charge' => 40,
    'collect_from_pharmacy_charge' => 0,
    'collect_from_pharmacy_discount_percentage' => 3,
    'ecash_payment_limit' => 5000,
    'free_cashon_delivery_limit' => 500,
    'cash_payment_charge_percentage' => 2,
    'ecash_payment_charge_percentage' => 2.3,
    'subidha_comission_cash_percentage' => 2,
    'subidha_comission_ecash_percentage' => 3,
    'subidha_delivery_percentage' => 25,
    'home_delivery' => 1,
    'pickup_from_pharmacy' => 2,
    'normal_delivery' => 'normal',
    'express_delivery' => 'express',
    'subidha_comission_collect_from_pharmacy_ecash_percentage' => 3.7,
    'subidha_comission_collect_from_pharmacy_cash_percentage' => 3,
    'customer_point_redeem' => 50,
    'point_redeem_discount_percentage' => 2,
    'point_on_first_use' => 10,
    'customer_referral_point' => 10,
    'new_customer_point' => 10,
    'google_playstore_rating_point' => 10,
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
    ],
    'cod_payment_type' => 1,
    'ecash_payment_type' => 2,

    'item_per_page' => 20,
    'bundle_item_per_page' => 1000,

    'free_delivery_limit' => 500,
];
