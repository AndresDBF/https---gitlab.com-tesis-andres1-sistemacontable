<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class PayBenefit extends Model
{
    public function benefitInsurer()
    {
        return $this->belongsTo(BenefitInsurer::class);
    }
}
