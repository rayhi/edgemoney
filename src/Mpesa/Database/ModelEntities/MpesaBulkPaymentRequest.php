<?php
namespace Edgetech\Mpesa\Database\ModelEntities;
use Illuminate\Database\Eloquent\Model;

/**
 * Edgetech\MobileMoney\Database\ModelEntities\MpesaBulkPaymentRequest
 *
 * @property int $id
 * @property string $conversation_id
 * @property string $originator_conversation_id
 * @property float $amount
 * @property string $phone
 * @property string|null $remarks
 * @property string $CommandID
 * @property int|null $user_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \Edgetech\Mpesa\Database\ModelEntities\MpesaBulkPaymentResponse $response
 * @mixin \Eloquent
 */
class MpesaBulkPaymentRequest extends Model
{
    protected $guarded = [];

    public function response()
    {
        return $this->hasOne(MpesaBulkPaymentResponse::class, 'ConversationID', 'conversion_id');
    }
}
