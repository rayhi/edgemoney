<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/18/2018
 * Time: 11:22 AM
 */

namespace Edgetech\MobileMoney\src\AirtelMoney\Library;


class GeneratorC2B
{
    protected $password;
    protected $nickname;
    protected $username;
    public function __construct()
    {
        $this->nickname = \config("mobilemoney.airtelc2b.nickname");
        $this->password = \config("mobilemoney.airtelc2b.password");
        $this->username = \config("mobilemoney.airtelc2b.username");
    }
    public  function TimeIntervalDetailed($timefrom,$timeto){
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:zain="http://www.zain.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <zain:RequestTransactionByTimeIntervalDetailed>
         <zain:userName>'.$this->username.'</zain:userName>
         <zain:passWord>'.$this->password.'</zain:passWord>
         <zain:timeFrom>'.$timefrom.'</zain:timeFrom>
         <zain:timeTo>'.$timeto.'</zain:timeTo>
      </zain:RequestTransactionByTimeIntervalDetailed>
   </soapenv:Body>
</soapenv:Envelope>';
    }
    public function TimeInterval($timefrom,$timeto){
    return '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:zain="http://www.zain.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <zain:RequestTransactionByTimeInterval>
          <zain:userName>'.$this->username.'</zain:userName>
         <zain:passWord>'.$this->password.'</zain:passWord>
         <zain:timeFrom>'.$timefrom.'</zain:timeFrom>
         <zain:timeTo>'.$timeto.'</zain:timeTo>
      </zain:RequestTransactionByTimeInterval>
   </soapenv:Body>
</soapenv:Envelope>
    ';
    }
    public function RequestTransaction($referenceID,$msisdn){
    return '
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:zain="http://www.zain.com/">
   <soapenv:Header/>
   <soapenv:Body>
      <zain:RequestTransaction>
        <zain:userName>'.$this->username.'</zain:userName>
         <zain:passWord>'.$this->password.'</zain:passWord>
         <zain:referenceId>'.$referenceID.'</zain:referenceId>
         <zain:msisdn>'.$msisdn.'</zain:msisdn>
      </zain:RequestTransaction>
   </soapenv:Body>
</soapenv:Envelope>
    ';
    }

}