<?php
return [

    'bcm_payment_option' => [
        "debit_card" => "Debit-card",
        "paypal"  => "Paypal",
    ],

    'bettercare_email' => env('BETTERCARE_EMAIL', 'bettercarendis@bettercaremarket.com.au'),
    'admin_email' => env('ADMIN_EMAIL', 'bettercarendis@bettercaremarket.com.au'),
    'allow_ip_address' => env('ALLOW_IP_ADDRESS', '35.213.165.216'),
    'error_order_status' => 99,
    'httpsallow' => env('HTTPS_ALLOW', 'https'),
    'maximum_trial' => env('MAXIMUM_TRIAL', 5),
    'deleteLogDays' => env('DELETE_LOG_DAYS', 45),
];
