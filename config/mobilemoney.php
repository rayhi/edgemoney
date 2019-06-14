<?php

return [
    //
    'c2b' => [
        /*
         * Configure the minimum amount
         */
        'mimimum_amount'=>0,
        /*
         * Consumer Key from developer portal
         */
        'consumer_key' => '',
        /*
         * Consumer secret from developer portal
         */
        'consumer_secret' => '',
        /*
         * HTTP callback method [POST,GET]
         */
        'callback_method' => 'POST',
        /*
         * Your receiving paybill or till umber
         */
        'short_code' => ,
        /*
         * Passkey , requested from mpesa
         */
        'passkey' => '',
        /*
         * --------------------------------------------------------------------------------------
         * Callbacks:
         * ---------------------------------------------------------------------------------------
         * Please update your app url in .env file
         * Note: This package has already routes for handling this callback.
         * You should leave this values as they are unless you know what you are doing
         */
        /*
         * Stk callback URL
         */
        'stk_callback' => env('APP_URL') . '/stk_callback',
        /*
         * Data is sent to this URL for successful payment
         */
        'confirmation_url' => env('APP_URL') . '/confirmation',
        /*
         * MobileMoney validation URL.
         * NOTE: You need to email MPESA to enable validation
         */
        'validation_url' => env('APP_URL') . '/validate',
        /*
       * This is the user initiating the transaction, usually from the MobileMoney organization portal
       * Make sure this was the user who was used to 'GO LIVE'
       * https://org.ke.m-pesa.com/
       */
        'initiator' => '',
        /*
         * The user security credential.
         * Go to https://developer.safaricom.co.ke/test_credentials and paste your initiator password to generate
         * security credential
         */
        'security_credential' => 'Gm8PJxmllv+3XUR5TuuLgsje9W6JCK3MfTe9eWCqCxwVXvXyv6L1KCTDs/NgodxqtU9+ffiT69v7MBWwj4ieCRgq9kdBCEJSMoKUbZh+UPvILhfLC1OvDVYk3JFgipOYQNrFVn+xa25GJzHnaftEWQXaO7/0gA+RWBWqByju00Lbd74dwkAnSOWZEVbzdMXk+kLijKYIHm/iBCI+nIsBojN3CSSiHdr3lXVGVHOS4M+9EZfqRn/VaLSO3XQDCzO1P8CfZ9aSz7nCxxUt/w94MEGxYWP7xYQOyfkKU6kIOXXKN+bNDBW2UbGTJ8ovKbcoFUZy9iHcbbjccPwoS8DtwQ==',

    ],
    'b2c' => [
        /*
         * Sending app consumer key
         */
        'consumer_key' => '',
        /*
         * Sending app consumer secret
         */
        'consumer_secret' => '',
        /*
         * Shortcode sending funds
         */
        'short_code' => 0,
        /*
        * This is the user initiating the transaction, usually from the MobileMoney organization portal
        * Make sure this was the user who was used to 'GO LIVE'
        * https://org.ke.m-pesa.com/
        */
        'initiator' => '',
        /*
         * The user security credential.
         * Go to https://developer.safaricom.co.ke/test_credentials and paste your initiator password to generate
         * security credential
         */
        'security_credential' => 'GXiVXirQFaJvEFOQyn+VJ4Gp3Ccvpoq6aqzFiNgvH18UMU59Qxc+UTAX7Blzo6L0+tQG2wUJ1fKH4YlPagtzDHT37796uu0NysS85uPjxZMjnbGhPNeHnhJLzwyrjppl8mZpnmVg4CaVrEdcriuyifKIiF1hmc0A/RnjBMzY6yevbIV0kAgrn5cDvCN99O1rr1nl69GaVbP7a/6AWnRkVUldnalQmqQhfgLbOdxjGOVGU2arqjuvgQ6glo1uK9PUnp3UH2Vv66Lu99JglWyjlcWufZhJXUmFFB9tfoKAX2URnPGi4PvvJ6OgJNdsJmTsevnG2c/KKOa45rzdvwrwKA==',
        /*
         * Notification URL for timeout
         */
        'timeout_url' => env('APP_URL') . '/payments/callbacks/timeout/',
        /**
         * Result URL
         */
        'result_url' => env('APP_URL') . '/payments/callbacks/result/',
    ],
    'airtelm'=>[
        'url' => 'https://airtelmoneymq.ke.airtel.com:8446/MerchantQueryService.asmx?WSDL',
        'msisdn' =>'',
        'password' =>'',
        'username' => '',
    ],
    'airtelc2b'=>[
        'password' =>'',
        'username' => '',
        'nickname'=>'',
        'endpoint'=>'https://airtelmoneymqtest.ke.airtel.com:8443/MerchantQueryService.asmx?WSDL',
        // 'endpoint'=>'https://airtelmoneymq.ke.airtel.com:8446/MerchantQueryService.asmx?WSDL',
    ],
    'airtelb2c'=>[
        'password' =>'',
        'username' => '',
        'nickname'=>'',
        // 'endpoint'=>'https://airtelmoneymq.ke.airtel.com:8446/MerchantPaymentService.asmx?WSDL',
        'endpoint'=>'https://airtelmoneymqtest.ke.airtel.com:8443/MerchantPaymentService.asmx?WSDL',
    ],
];
