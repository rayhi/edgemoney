<?php

namespace Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MpesaStkCallback
 * @package Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities
 */
class MpesaStkCallback extends Model
{
    protected $guarded = [];

    public function request()
    {
        return $this->belongsTo(MpesaStkRequest::class, 'CheckoutRequestID', 'CheckoutRequestID');
    }
}
