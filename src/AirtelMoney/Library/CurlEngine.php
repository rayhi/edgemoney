<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/18/2018
 * Time: 12:17 PM
 */

namespace Edgetech\MobileMoney\src\AirtelMoney\Library;
use Ixudra\Curl\Facades\Curl;
use Mockery\Exception;
use SimpleXMLElement;

class CurlEngine
{
    public function getEndpoint($url){
        $config = 'mobilemoney.'.$url.'.endpoint';
        $endpoint = \config($config);
        return $endpoint;
    }
    public function formatresponse($response){
        $response = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $response);
        $xml = new SimpleXMLElement($response);
        $body = $xml->xpath('//envBody')[0];
        $array = json_decode(json_encode((array)$body),True);
        return $array;
    }
    public function SendRequest($body,$url){
        $endpoint = $this->getEndpoint($url);
        try{
            $response = $this->MakeRequest($body,$endpoint);
           if($response->status !== 200){
                throw new \Exception("An error Occured ".$response->content);
            }else{
           $response = $this->formatresponse($response->content);
            }
        }catch (\Exception $e){
            $response = $e;
        }
        return $response;
    }
    public function MakeRequest($body,$endpoint){
        return Curl::to($endpoint)
            ->withHeader('content-type: application/soap+xml')
            ->withResponseHeaders()
            ->returnResponseObject()
            ->withData($body)
            ->post();
    }
}