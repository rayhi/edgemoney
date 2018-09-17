<?php

namespace Edgetech\Mpesa\Database\ModelEntities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class MpesaC2bCallback
 * @package Edgetech\MobileMoney\Database\ModelEntities
 */
class MpesaC2bCallback extends Model
{
    protected $guarded = [];

    public function getNameAttribute()
    {
        return $this->FirstName . ' ' . $this->MiddleName . ' ' . $this->LastName;
    }
}
