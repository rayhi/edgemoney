<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/14/2018
 * Time: 10:47 AM
 */

namespace Edgetech\MobileMoney\src\Mpesa\Library;
use Ixudra\Curl\Facades\Curl;
use Edgetech\MobileMoney\src\Mpesa\Library\CurlEngine;

class CommonClass
{
    public function formatPhoneNumber($number, $strip_plus = true)
    {
        $number = preg_replace('/\s+/', '', $number);
        $replace = function ($needle, $replacement) use (&$number) {
            if (starts_with($number, $needle)) {
                $pos = strpos($number, $needle);
                $length = strlen($needle);
                $number = substr_replace($number, $replacement, $pos, $length);
            }
        };
        $replace('2547', '+2547');
        $replace('07', '+2547');
        if ($strip_plus) {
            $replace('+254', '254');
        }
        return $number;
    }
    public function makeRequest($body, $endpoint)
    {
        if (!empty($key = CurlEngine::gettoken())) {
            $token = $key;
        }else{
            $token = CurlEngine::generatetoken();
        }
        return Curl::to($endpoint)
            ->withHeader('Authorization:Bearer '.$token.'')
            ->withResponseHeaders()
            ->returnResponseObject()
            ->withData($body)
            ->asJson()
            ->post();
    }
    public function sendRequest($data,$section){

        $endpoint = CurlEngine::build($section);
        $response = $this->makeRequest($data,$endpoint);
        return $response;

    }
}