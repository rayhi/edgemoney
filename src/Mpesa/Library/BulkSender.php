<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/14/2018
 * Time: 10:46 AM
 */

namespace Edgetech\MobileMoney\src\Mpesa\Library;
use Edgetech\MobileMoney\src\Mpesa\Library\Mpesa;
use Edgetech\MobileMoney\src\Mpesa\Library\CurlEngine;

class BulkSender extends CommonClass
{
    private $msisdn;
    private $remarks;
    private $amount;
    private $trials;
    public  $bulk;
    public $mpesa;

    /**
     * BulkSender constructor.
     * @param \Edgetech\MobileMoney\src\Mpesa\Library\Mpesa $mpesa
     */
    public function __construct(Mpesa $mpesa)
    {
        $this->mpesa = new Mpesa();
    }

    public function to($msisdn){
        //msisdn
        $this->msisdn = $this->formatPhoneNumber($msisdn);
        return $this;
    }
    public function withRemarks($remarks)
    {
        $this->remarks = $remarks;
        return $this;
    }
    public function amount($amount)
    {
        $this->amount = $amount;
        return $this;
    }
    public function send($number = null, $amount = null, $remarks = null)
    {

        $body = [
            'InitiatorName' => \config('mobilemoney.b2c.initiator'),
            'SecurityCredential' => \config('mobilemoney.b2c.security_credential'),
            'CommandID' => 'BusinessPayment', //SalaryPayment,BusinessPayment,PromotionPayment
            'Amount' => $amount ?: $this->amount,
            'PartyA' => \config('mobilemoney.b2c.short_code'),
            'PartyB' => $this->formatPhoneNumber($number ?: $this->msisdn),
            'Remarks' => $remarks ?: $this->remarks,
            'QueueTimeOutURL' => \config('mobilemoney.b2c.timeout_url') . 'b2c',
            'ResultURL' => \config('mobilemoney.b2c.result_url') . 'b2c',
            'Occasion' => ' '
        ];

        $this->bulk = true;
        //var_dump($this->sendRequest($body, 'b2c'));
        try {
            $response = $this->sendRequest($body, 'b2c');
            return $this->mpesa->saveB2cRequest($response->content, $body);
        } catch (ServerException $exception) {
            if ($this->trials > 0) {
                $this->trials--;
                return $this->send($number, $amount, $remarks);
            }
            throw new \Exception('Server Error');
        }
    }
    public function balance()
    {
        $body = [
            'CommandID' => 'AccountBalance',
            'Initiator' => \config('mobilemoney.b2c.initiator'),
            'SecurityCredential' => \config('mobilemoney.b2c.security_credential'),
            'PartyA' => \config('mobilemoney.b2c.short_code'),
            'IdentifierType' => 4,
            'Remarks' => 'Checking Balance',
            'QueueTimeOutURL' => \config('mobilemoney.b2c.timeout_url') . 'bulk_balance',
            'ResultURL' => \config('mobilemoney.b2c.result_url') . 'bulk_balance',
        ];
        /** @var TYPE_NAME $this */
        $this->bulk = true;
        return $this->sendRequest($body, 'account_balance');
    }

}