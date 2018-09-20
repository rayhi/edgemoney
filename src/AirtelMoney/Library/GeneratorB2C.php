<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/18/2018
 * Time: 11:27 AM
 */

namespace Edgetech\MobileMoney\src\AirtelMoney\Library;


class GeneratorB2C
{
    protected $password;
    protected $nickname;
    protected $username;
    public function __construct()
    {
        $this->nickname = \config("mobilemoney.airtelb2c.nickname");
        $this->password = \config("mobilemoney.airtelb2c.password");
        $this->username = \config("mobilemoney.airtelb2c.username");
    }

    public function CheckBalance(){
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://www.obopay.com/xml/bulkpayment/v1">
   <soapenv:Header/>
   <soapenv:Body>
      <v1:CheckBalance>
         <v1:username>'.$this->username.'</v1:username>
         <v1:password>'.$this->password.'</v1:password>
         <v1:nickname>'.$this->nickname.'</v1:nickname>
      </v1:CheckBalance>
   </soapenv:Body>
</soapenv:Envelope>';

    }
    public function TrxPayment($referenceID,$msisdn,$amount,$batchref,$narrative){
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://www.obopay.com/xml/bulkpayment/v1">
        <soapenv:Header/>
   <soapenv:Body>
      <v1:TrxPayment>
         <v1:referenceid>'.$referenceID.'</v1:referenceid>
         <v1:customermsisdn>'.$msisdn.'</v1:customermsisdn>
         <v1:nickname>'.$this->nickname.'</v1:nickname>
         <v1:amount>'.$amount.'</v1:amount>
         <v1:batchref>'.$batchref.'</v1:batchref>
         <v1:username>'.$this->username.'</v1:username>
         <v1:password>'.$this->password.'</v1:password>
         <v1:narrative>'.$narrative.'</v1:narrative>
      </v1:TrxPayment>
   </soapenv:Body>
    </soapenv:Envelope>';
    }
    public function TrxRevert($referenceid,$narration){
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:v1="http://www.obopay.com/xml/bulkpayment/v1">
   <soapenv:Header/>
   <soapenv:Body>
      <v1:TrxRevert>
         <v1:referenceid>'.$referenceid.'</v1:referenceid>
         <v1:narration>'.$narration.'</v1:narration>
         <v1:nickname>'.$this->nickname.'</v1:nickname>
         <v1:username>'.$this->username.'</v1:username>
         <v1:password>'.$this->password.'</v1:password>
      </v1:TrxRevert>
   </soapenv:Body>
</soapenv:Envelope>';
    }
}