<?php

namespace Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MpesaBulkPaymentResponse
 * @package Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities
 */
class MpesaBulkPaymentResponse extends Model
{
    protected $guarded = [];

    public function request()
    {
        return $this->belongsTo(MpesaBulkPaymentRequest::class, 'ConversationID', 'conversation_id');
    }
}
