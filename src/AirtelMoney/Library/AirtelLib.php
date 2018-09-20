<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/14/2018
 * Time: 2:11 PM
 */

namespace Edgetech\MobileMoney\src\AirtelMoney\Library;
use SoapClient;

class AirtelLib
{

    public function __construct()
    {
      //  ini_set("soap.wsdl_cache_enabled", "0");
    }

    /**
     * @param $REFERENCE_ID
     * @param $request_type
     * @param $timeTo
     * @param $timeFrom
     * @return \Exception|mixed|string
     */
    public function processMerchantQuery($REFERENCE_ID,$request_type,$timeTo,$timeFrom){

        $username = \config('mobilemoney.airtelm.username');
        $password = \config('mobilemoney.airtelm.password');
        $MSISDN = \config('mobilemoney.airtelm.msisdn');
        $URL = \config('mobilemoney.airtelm.url');
        $params = array(
            'userName'=>$username,
            'passWord'=>$password,
            'referenceId'=>$REFERENCE_ID,
            'msisdn'=>$MSISDN,
            /*
            Optional fields when checking by tranaction id. And note that the time interval should not exceed 24hrs
             */

            // Time should be in this format and within the last 24 hrs 20160115050700

            'timeFrom'=>$timeFrom,
            'timeTo'=>$timeTo,
            //	)


        );
        try {
            $soap = new SOAPClient(dirname(__FILE__)."\MERCHANT_QUERY.wsdl",array("trace"  => 0, "exceptions" => 1,
                "stream_context" => stream_context_create(
                    array(
                        'ssl' => array(
                            'verify_peer'       => false,
                            'verify_peer_name'  => false,
                            'ciphers'=>'RC4-SHA',
                        )

                    )
                ),'location'=>$URL,'soap_version'=> SOAP_1_2,
                'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP
            ));


            $response=$soap->__call($request_type,array($params));
            var_dump($response);
            exit;
            $amount=$response->RequestTransactionResult->Amount;
            $firstname=$response->RequestTransactionResult->FirstName;
            $lastname=$response->RequestTransactionResult->LastName;
            $message=$response->RequestTransactionResult->Message;
            $msisdn=$response->RequestTransactionResult->Msisdn;
            $referenceId=$response->RequestTransactionResult->Referenceld;
            $status=$response->RequestTransactionResult->Status;
            $transactionId=$response->RequestTransactionResult->TransactionId;

            $transaction = array(
                'amount' =>$amount ,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'message' => $message,
                'msisdn' => $msisdn,
                'referenceId' => $referenceId,
                'status' => $status,
                'transactionId' => $transactionId,
            );

            if($transaction["amount"]!="" || $transaction["amount"] !=null){
                //Insert values to the database
                $this->SaveRequest($transaction);
                return "Succes";
            }
            else{
                //	echo "no data received";
                $response=$soap->__call($request_type,array($params));
                return $response;
            }



        } catch (\Exception $e) {
            return $e;
        }

    }
    public function SaveRequest($transaction){
        //save the request from Airtel

    }
}