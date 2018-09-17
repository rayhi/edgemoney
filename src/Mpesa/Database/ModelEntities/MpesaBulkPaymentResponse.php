<?php

namespace Edgetech\Mpesa\Database\ModelEntities;
use Illuminate\Database\Eloquent\Model;

/**
 * Edgetech\MobileMoney\Database\ModelEntities\MpesaBulkPaymentResponse
 *
 * @property int $id
 * @property int $ResultType
 * @property int $ResultCode
 * @property string $ResultDesc
 * @property string $OriginatorConversationID
 * @property string $ConversationID
 * @property string $TransactionID
 * @property string|null $ResultParameters
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Edgetech\Mpesa\Database\ModelEntities\MpesaBulkPaymentRequest $request
 * @mixin \Eloquent
 */
class MpesaBulkPaymentResponse extends Model
{
    protected $guarded = [];

    public function request()
    {
        return $this->belongsTo(MpesaBulkPaymentRequest::class, 'ConversationID', 'conversation_id');
    }
}
