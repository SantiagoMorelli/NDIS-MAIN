<?php
return [
    'activate' => [
        'keyId'             => env('DEVICE_ID', 'BettercareNDISDevice'),
        'organizationId'    => env('PRODA_ORGANIZATION_ID', '5529384008'),
        'aud'               => env('AUD', 'https://proda.humanservices.gov.au'),
        'token_aud'         => env('TOKEN_AUD', 'https://www.ndis.gov.au/'),
        'activationCode'    => env('ACTIVATION_CODE', 'zsaIFYQIqb'),
        'deviceId'          => env('DEVICE_ID', 'BettercareNDISDevice'),
        'auditId'           => env('AUDIT_ID', 'http://humanservices.gov.au/PRODA/org'),
        'subjectId'         => env('SUBJECT_ID', 'http://humanservices.gov.au/PRODA/device'),
        'activationURL'     => env('ACTIVATION_URL', 'https://test.5.rsp.humanservices.gov.au/piaweb/api/b2b/v1/devices/'),
        'activationURLEnd'  => env('ACTIVATION_URL_END', '/jwk'),
    ],
    'auth' => [
        'clientId'          => env('CLIENT_ID', 'BETTERCARENDIS_VND_DEVICE_CLIENT_ID'),
        'grantType'         => env('GRANT_TYPE', 'urn:ietf:params:oauth:grant-type:jwt-bearer'),
        'authenticate_URL'  => env('AUTHENICATE_URL', 'https://vnd.proda.humanservices.gov.au/mga/sps/oauth/oauth20/token'),
    ],
    'refresh' => [
        'refreshUrl'        => env('REFRESH_URL', 'https://test.5.rsp.humanservices.gov.au/piaweb/api/b2b/v1/orgs/'),
        'proda_ra'          => env('PRODA_ORGANIZATION_ID', '5529384008'),
        'refreshUrlMiddle'  => env('REFRESH_URL_MIDDLE', '/devices/'),
        'refreshUrlEnd'     => env('REFRESH_URL_END', '/jwk'),
    ],
    'dhs' => [
        'auditIdType'   => env('AUDIT_ID', 'http://humanservices.gov.au/PRODA/org'),
        'subjectIdType' => env('SUBJECT_ID', 'http://humanservices.gov.au/PRODA/device'),
        'productId'     => env('PRODUCT_ID', 'API Test 1.0'),
    ],

    'hostUrl'           => env('HOST_URL', 'https://test.api.ndis.gov.au/sharedservices/ndis-api-test'),
    'planUrl'           => env('PLAN_URL', '/ndis/3.0/plans/'),
    'x_ibm_client_id'   => env('X_IBM_CLIENT_ID', '6c4510fc-4df6-48aa-98ad-0c737d843bf3'),
    'referenceURL'      => env('REFERENCE_URL', '/ndis/2.0/reference-data'),
    'attributeName'     => env('ATTRIBUTE_NAME', 'claim_status'),
    'serviceBookingUrl' => env('SERVICE_BOOKING_URL', '/ndis/3.0/service-bookings/'),
    'paymentUrl'        => env('PAYMENT_URL', '/ndis/3.0/payments/'),

    'encrypt_decrypt_secret_key' => env('ENCRYPT_DECRPT_SECRET_KEY', 'BETTERZYXCARE987SECRET654KEY'),
    'secret_iv'         => env('SECRET_IV', '123secret45iv'),
    'product_category'  => env('PRODUCT_CATEGORY', 'CONSUMABLES'),
    'booking_type'      => env('BOOKING_TYPE', 'ZSAG'),
    'tax_code'          => env('TAX_CODE', 'P2'),

    'claimStatus' => [
        0   => "Rejected",    
        1   => "Incomplete",    
        4   => "Pending Payment",    
        41  => "Paid",    
        42  => "Cancelled",    
        7   => "Awaiting Approval",
        99  => "Error",    
    ],

    'orderStatus' => [
        "Error"     => 0,    
        "Submited"  => 1,    
        "Resubmited"  => 2,    
        "Paid"  => 3,   
    ],

    'newOrderStatus' => ['status_0' => 'Error', 'status_1' => 'Pending', 'status_2' => 'Paid',
     'status_3' => 'Processed By BCM', 'status_4' => 'Supplier Order Pending ', 'status_5' => 'Processed by Supplier',
      'status_6' => 'Tracking Code Received', 'status_7' => 'Delivered', 'status_8' => 'Returned',
      'status_9' => 'on BackOrder', 'status_10' => 'Completed', 'status_11' => 'Refund'],
    'newOrderStatus1' => ['0' => 'Error', '1' => 'Pending', '2' => 'Paid',
     '3' => 'Processed By BCM', '4' => 'Supplier Order Pending ', 
     '5' => 'Processed by Supplier', '6' => 'Tracking Code Received', 
     '7' => 'Delivered', '8' => 'Returned',
    '9' => 'on BackOrder', '10' => 'Completed', '11' => 'Refund'],
    "newNidsType" => ['ndia_order', 'plan_managed_order', 'self_managed_order'],
    "checkOrderProgressInterval"=>'10',
    'plan_management_option' => [
        "plan_managed" => "Plan-managed",    
        "ndia_managed"  => "NDIA-managed",
    ],

    'payment_invoice' => [
        'ndis_registration_no'     => env('NDIS_REGISTRATION_NO', '4050069517'),
        'accountName'   => env('ACCOUNT_NAME', 'BETTERCARE4U PTY LTD'),
        'bsb'           => env('BSB', '062-000'),
        'accountNo'     => env('ACCOUNT_NO', '17202393'),
        'website'       => env('WEBSITE', 'https://www.bettercarendis.com.au'),
    ],

    'email' => [
        'from_email' => env('FROM_EMAIL', 'customercare@bettercaremarket.com.au'),
        'sender'       => env('EMAIL_SENDER_NAME', 'BetterCare Team'),
        'sendgrid_key' => env('SENDGRID_API_KEY'),
        'cc_user_email' => env('CC_USER_EMAIL','bettercarendis@bettercaremarket.com.au'),
    ],
    'bettercare_email' => env('BETTERCARE_EMAIL', 'bettercarendis@bettercaremarket.com.au'),
    'admin_email' => env('ADMIN_EMAIL', 'bettercarendis@bettercaremarket.com.au'),
    'allow_ip_address' => env('ALLOW_IP_ADDRESS','35.213.165.216'),
    'error_order_status' => 99,
    'httpsallow' => env('HTTPS_ALLOW', 'https'),
    'maximum_trial' => env('MAXIMUM_TRIAL', 5),
    'deleteLogDays' => env('DELETE_LOG_DAYS', 45),
];  