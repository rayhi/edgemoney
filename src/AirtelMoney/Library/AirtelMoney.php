<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/18/2018
 * Time: 12:49 PM
 */

namespace Edgetech\MobileMoney\src\AirtelMoney\Library;
use Edgetech\MobileMoney\src\AirtelMoney\Library\GeneratorC2B;
use Edgetech\MobileMoney\src\AirtelMoney\Library\GeneratorB2C;
class AirtelMoney extends CurlEngine
{
    /**
     * @var GeneratorC2B
     */
    public  $c2bgenerator;
    /**
     * @var GeneratorB2C
     */
    protected $b2cgenerator;
    public  function __construct(GeneratorC2B $c2bgenerator,GeneratorB2C $b2cgenerator)
    {
        $this->c2bgenerator = $c2bgenerator;
        $this->b2cgenerator = $b2cgenerator;
    }

    public function getTransaction(){

    }
    public function getTimeInterval($to,$from){
        $body = $this->c2bgenerator->TimeIntervalDetailed($from,$to);
        $endpoint = "airtelc2b";
        $response = $this->SendRequest($body,$endpoint);
        return $response;
    }
    public function getIntervalDetail(){

    }
    public function getBalance(){
        $body = $this->b2cgenerator->CheckBalance();
        $endpoint= "airtelb2c";
        $response = $this->SendRequest($body,$endpoint);
        return $response;
    }
    public function getReversal(){

    }
    public function makepayment(){
        $referenceID =23;
        $msisdn = 254736355183;
        $amount = 100;
        $batchref = "123";
        $narrative = "Test Payment";
        $body = $this->b2cgenerator->TrxPayment($referenceID,$msisdn,$amount,$batchref,$narrative);
        $endpoint= "airtelb2c";
        $response = $this->SendRequest($body,$endpoint);
        return $response;

    }

}