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
        'consumer_key' => '0',
        /*
         * Consumer secret from developer portal
         */
        'consumer_secret' => '0',
        /*
         * HTTP callback method [POST,GET]
         */
        'callback_method' => 'POST',
        /*
         * Your receiving paybill or till umber
         */
        'short_code' => 0,
        /*
         * Passkey , requested from mpesa
         */
        'passkey' => '0',
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
        'initiator' => 'mtransferltd',
        /*
         * The user security credential.
         * Go to https://developer.safaricom.co.ke/test_credentials and paste your initiator password to generate
         * security credential
         */
        'security_credential' => ''
    ],
    'b2c' => [
        /*
         * Sending app consumer key
         */
        'consumer_key' => '0',
        /*
         * Sending app consumer secret
         */
        'consumer_secret' => '0',
        /*
         * Shortcode sending funds
         */
        'short_code' => 0,
        /*
        * This is the user initiating the transaction, usually from the MobileMoney organization portal
        * Make sure this was the user who was used to 'GO LIVE'
        * https://org.ke.m-pesa.com/
        */
        'initiator' => 'testapi',
        /*
         * The user security credential.
         * Go to https://developer.safaricom.co.ke/test_credentials and paste your initiator password to generate
         * security credential
         */
        'security_credential' => ''
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