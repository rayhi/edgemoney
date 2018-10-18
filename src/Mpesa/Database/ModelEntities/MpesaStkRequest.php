<?php

namespace Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MpesaStkRequest
 * @package Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities
 */
class MpesaStkRequest extends Model
{
    protected $guarded = [];
    protected $table = "mpesa_stk_request";

    public function response()
    {
        return $this->hasOne(MpesaStkCallback::class, 'CheckoutRequestID', 'CheckoutRequestID');
    }
}
