<?php

return [
    'api_url' => env('RPX_URL', 'http://api.rpxholding.com/wsdl/rpxwsdl.php?wsdl'),

    'account_number' => env('RPX_ACCOUNT_NUMBER', ''),

    'username' => env('RPX_USERNAME', 'demo'),

    'password' => env('RPX_PASSWORD', 'demo'),

    'format' => env('RPX_FORMAT', 'json'),
];
