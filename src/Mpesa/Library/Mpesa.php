<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 9/14/2018
 * Time: 10:48 AM
 */

namespace Edgetech\MobileMoney\src\Mpesa\Library;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Edgetech\Mpesa\Database\ModelEntities\MpesaStkRequest;
use Edgetech\Mpesa\Database\ModelEntities\MpesaBulkPaymentRequest;
use Edgetech\Mpesa\Database\ModelEntities\MpesaBulkPaymentResponse;
use Edgetech\Mpesa\Database\ModelEntities\MpesaC2bCallback;
use Edgetech\Mpesa\Database\ModelEntities\MpesaStkCallback;
use Edgetech\Mpesa\Database\ModelEntities\MobilePayments;

class Mpesa
{
    public function StkPushCallback($json)
    {
        $object = json_decode($json);
        $data = $object->stkCallback;
        $real_data = [
            'MerchantRequestID' => $data->MerchantRequestID,
            'CheckoutRequestID' => $data->CheckoutRequestID,
            'ResultCode' => $data->ResultCode,
            'ResultDesc' => $data->ResultDesc,
        ];
        if ($data->ResultCode == 0) {
            $_payload = $data->CallbackMetadata->Item;
            foreach ($_payload as $callback) {
                $real_data[$callback->Name] = @$callback->Value;
            }
            $callback = MpesaStkCallback::create($real_data);
        } else {
            $callback = MpesaStkCallback::create($real_data);
        }
        return $callback;
    }
    public function saveB2cRequest($response, $body = [])
    {
        return MpesaBulkPaymentRequest::create([
            'conversation_id' => $response->ConversationID,
            'originator_conversation_id' => $response->OriginatorConversationID,
            'amount' => $body['Amount'],
            'phone' => $body['PartyB'],
            'remarks' => $body['Remarks'],
            'CommandID' => $body['CommandID'],
            'user_id' => Auth::id(),
        ]);
    }
    public function processConfirmation($json)
    {
        $data = json_decode($json, true);
        $callback = MpesaC2bCallback::create($data);
        return $callback;
    }

    /**
     * @param $data
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function processValidation($data){
        $data_array = json_decode($data, true);
        $validator = Validator::make($data_array, [
            "TransAmount"=> 'required|numeric',
            "BusinessShortCode" => 'required|numeric'
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }else{
            $minimum_amount = \config('mpesa.c2b.mimimum_amount');
            if($data_array['TransAmount'] >= $minimum_amount){
                $resp = [
                    'ResultCode' => 0,
                    'ResultDesc' => 'Validation passed successfully',
                ];
            }else{
                $resp = [
                    'ResultCode' => 1,
                    'ResultDesc' => 'Validation Failed',
                ];
            }
            //
            return $resp;
        }
    }

    private function handleB2cResult()
    {
        $data = json_decode(request('Result'), true);
        $common = [
            'ResultType', 'ResultCode', 'ResultDesc', 'OriginatorConversationID', 'ConversationID', 'TransactionID'
        ];
        $seek = ['OriginatorConversationID' => $data['OriginatorConversationID']];
        /** @var MpesaBulkPaymentResponse $response */
        $response = null;
        if ($data['ResultCode'] !== 0) {
            $response = MpesaBulkPaymentResponse::updateOrCreate($seek,
                array_only($data, $common));
            //  event(new B2cPaymentFailedEvent($response, $data));
            return $response;
        }
        $resultParameter = $data['ResultParameters'];
        $data['ResultParameters'] = json_encode($resultParameter);
        $response = MpesaBulkPaymentResponse::updateOrCreate($seek, array_except($data, ['ReferenceData']));
        return $response;
    }
    public function handleResult($initiator = null)
    {
        if ($initiator === 'b2c') {
            return $this->handleB2cResult();
        }
        return;
    }

    public function queryStkStatus()
    {
        /** @var MpesaStkRequest[] $stk */
        $stk = MpesaStkRequest::whereDoesntHave('response')->get();
        $success = $errors = [];
        foreach ($stk as $item) {
            try {
                $status = mpesa_stk_status($item->id);
                if (isset($status->errorMessage)) {
                    $errors[$item->CheckoutRequestID] = $status->errorMessage;
                    continue;
                }
                $attributes = [
                    'MerchantRequestID' => $status->MerchantRequestID,
                    'CheckoutRequestID' => $status->CheckoutRequestID,
                    'ResultCode' => $status->ResultCode,
                    'ResultDesc' => $status->ResultDesc,
                    'Amount' => $item->amount,
                ];
                $errors[$item->CheckoutRequestID] = $status->ResultDesc;
                $callback = MpesaStkCallback::create($attributes);
                // $this->fireStkEvent($callback, get_object_vars($status));
            } catch (\Exception $e) {
                $errors[$item->CheckoutRequestID] = $e->getMessage();
            }
        }
        return ['successful' => $success, 'errors' => $errors];
    }

    public function saverequest($data){
        //save the request as new
        MobilePayments::create($data);
    }
}