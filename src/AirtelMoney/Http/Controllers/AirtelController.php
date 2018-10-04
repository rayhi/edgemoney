<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/14/2018
 * Time: 12:46 PM
 */

namespace Edgetech\MobileMoney\src\AirtelMoney\Http\Controllers;
use App\Http\Controllers\Controller;
use Edgetech\MobileMoney\src\AirtelMoney\Library\AirtelMoney;
use Carbon\Carbon;
class AirtelController extends Controller
{
    private $referenceId;
    private $timeTo;
    private $timeFrom;
    /**
     * @var AirtelMoney
     */
    protected $airtel;
    public function __construct(AirtelMoney $airtel)
    {
        $this->airtel = $airtel;

    }

    public function request($referenceId=null,$timeTo=null,$timeFrom=null){
       // $request_type = "RequestTransaction";
        //$ref ="1601056579194";//$referenceId ?: $this->referenceId;
        $to = (int) str_replace(" ","",str_replace(":","",str_replace("-","",Carbon::now("Africa/Nairobi")->toDateTimeString())));
        $from = (int) str_replace(" ","",str_replace(":","",str_replace("-","",Carbon::now("Africa/Nairobi")->subHours(24)->toDateTimeString())));
        return $this->airtel->getTimeInterval($to,$from);
    }
    public function getbalance(){
        return $this->airtel->getBalance();
    }
    public function makepayment(){
        return $this->airtel->makepayment();
    }

}