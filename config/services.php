<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
       // 'key' => env('AWS_ACCESS_KEY_ID'),
       // 'secret' => env('AWS_SECRET_ACCESS_KEY'),
       // 'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
        
        'key'    => env('SES_KEY', ''),
        'secret' => env('SES_KEY_SECRET', ''),
        'region' => env('SES_REGION', 'ap-south-1'),
        'host' => env('SES_EMAIL_HOST', 'email-smtp.ap-south-1.amazonaws.com'),
        'email' => env('SES_SENDER_EMAIL', ''),
        'username'=> env('SES_USERNAME', ''),
        'password'=> env('SES_PASSWORD', ''),
        'fromname'=> env('SES_FROM_NAME', ''),

    ],

];
