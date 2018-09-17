<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/14/2018
 * Time: 12:46 PM
 */

namespace Edgetech\MobileMoney\src\AirtelMoney\Http\Controllers;
use App\Http\Controllers\Controller;
use Edgetech\MobileMoney\src\AirtelMoney\Library\AirtelLib;
use Carbon\Carbon;
class AirtelController extends Controller
{
    private $referenceId;
    private $timeTo;
    private $timeFrom;
    /**
     * @var AirtelLib
     */
    protected $airtel;
    public function __construct(AirtelLib $airtel)
    {
        $this->airtel = $airtel;

    }

    public function request($referenceId=null,$timeTo=null,$timeFrom=null){
        $request_type = "RequestTransaction";
        $ref ="1601056579194";//$referenceId ?: $this->referenceId;
        $to = str_replace(" ","",str_replace(":","",str_replace("-","",Carbon::now("Africa/Nairobi")->toDateTimeString())));
        $from = ($to-120);//$timeTo ?: $this->timeTo;
        return $this->airtel->processMerchantQuery($ref,$request_type,$to,$from);
    }

}