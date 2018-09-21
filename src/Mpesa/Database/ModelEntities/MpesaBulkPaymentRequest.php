<?php
namespace Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MpesaBulkPaymentRequest
 * @package Edgetech\MobileMoney\src\Mpesa\Database\ModelEntities
 */
class MpesaBulkPaymentRequest extends Model
{
    protected $guarded = [];

    public function response()
    {
        return $this->hasOne(MpesaBulkPaymentResponse::class, 'ConversationID', 'conversion_id');
    }
}
