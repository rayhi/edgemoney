<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/13/2018
 * Time: 1:35 PM
 */

namespace Edgetech\MobileMoney\src\Mpesa\Http\Controllers;
use App\Http\Controllers\Controller;
use Edgetech\MobileMoney\src\Mpesa\Library\Mpesa;
use Edgetech\MobileMoney\src\Mpesa\Library\BulkSender;
use Illuminate\Http\Request;
use Illuminate\Http\Request as Newrequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
class MpesaController extends Controller
{
    /**
     * @var Mpesa
     */
    private $repository;
    private $bulksender;

    /**
     * MpesaController constructor.
     * @param Mpesa $repository
     * @param BulkSender $bulkSender
     */
    public function __construct(Mpesa $repository,BulkSender $bulkSender)
    {
        $this->repository = $repository;
        $this->bulksender = $bulkSender;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(){
        return view('edgetech::welcome');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function confirmation(Request $request){
        $resp = $this->repository->processConfirmation(json_encode($request->all()));
        return response()->json($resp);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function  validatepayment(Request $request){
        //log the same in the logs
        log::debug(json_encode($request->all()));

        $resp = $this->repository->processValidation(json_encode($request->all()));

        return response()->json($resp);
    }

    /**
     * @return string
     */
    public function stkCallback(Request $request)
    {
        //var_dump($request->all()['Body']);
        // exit;
        $this->repository->StkPushCallback(json_encode($request->all()['Body']));
        // return $this->repository->StkPushCallback($request);
        $resp = [
            'ResultCode' => 0,
            'ResultDesc' => 'STK Callback received successfully',
        ];
        return response()->json($resp);
    }
    public function initiateb2c(Request $request){
        //receive the B2C Request
        $data = $request->all();
        $validator = Validator::make($data,[
            'amount' => 'required|numeric',
            'phone' => 'required|numeric',
            'remarks' => 'required'
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }
        //get the params
        try {
            $bulk = $this->bulksender->to($data['phone'])
                ->amount($data['amount'])
                ->withRemarks($data['remarks'])
                ->send();
        } catch (\Exception $exception) {
            $bulk = ['ResponseCode' => 900, 'ResponseDescription' => 'Invalid request', 'extra' => $exception->getMessage()];
        }
        return $bulk;

    }
    //handles MPESA Timeout for B2C
    public function queuetimeout(){
        return "Received";
    }

    public function callback(Request $request){
        //the callback data to logged
        log::debug(json_encode($request));
        $resp = [
            'ResultCode' => 0,
            'ResultDesc' => 'Callback received successfully',
        ];
        return response()->json($resp);
    }
}