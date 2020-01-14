<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/14/2018
 * Time: 10:47 AM
 */

namespace Edgetech\MobileMoney\src\Mpesa\Library;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Facades\Cache;

class CurlEngine
{
    public static  function generatetoken(){
        //
        $CONSUMER_KEY = "pTPNT1m5M7UJltMCGtJtXg9u187dDfNt";
        $CONSUMER_SECRET = "afEsVkXPSGUhO9Ic";
        $url = self::getEndpoint("auth");//'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        $credentials = base64_encode($CONSUMER_KEY.":".$CONSUMER_SECRET);
        $response = Curl::to($url)
            ->withHeader('Authorization: Basic '.$credentials)
            ->withResponseHeaders()
            ->returnResponseObject()
            //->asJson()
            ->get();
        if($response->status == 200){
            $token = json_decode($response->content)->access_token;
            self::savetoken($token);
            return $token;
        }else{
            $resp = ["status"=>$response->status,"Message"=>"An error occured"];
            return $resp;
        }

    }
    public static  function savetoken($token){
        Cache::put("token",$token,30);
    }
    public static function gettoken(){
        return Cache::get("token");
    }
    private static function getEndpoint($section): string
    {
        $list = [
            'auth' => 'oauth/v1/generate?grant_type=client_credentials',
            'id_check' => 'mpesa/checkidentity/v1/query',
            'register' => 'mpesa/c2b/v1/registerurl',
            'stk_push' => 'mpesa/stkpush/v1/processrequest',
            'stk_status' => 'mpesa/stkpushquery/v1/query',
            'b2c' => 'mpesa/b2c/v1/paymentrequest',
            'transaction_status' => 'mpesa/transactionstatus/v1/query',
            'account_balance' => 'mpesa/accountbalance/v1/query',
            'b2b' => 'mpesa/b2b/v1/paymentrequest',
            'simulate' => 'mpesa/c2b/v1/simulate',
        ];
        if ($item = $list[$section]) {
            return self::getUrl($item);
        }
        throw new \Exception('Unknown endpoint');
    }

    private static function getUrl($suffix): string
    {
        $baseEndpoint = 'https://api.safaricom.co.ke/';
//        if (\config('samerior.mpesa.sandbox')) {
//            $baseEndpoint = 'https://sandbox.safaricom.co.ke/';
//        }
        return $baseEndpoint . $suffix;
    }

    public static function build($endpoint)
    {
        return self::getEndpoint($endpoint);
    }
}