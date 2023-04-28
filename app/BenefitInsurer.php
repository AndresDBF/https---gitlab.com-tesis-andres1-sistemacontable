<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class BenefitInsurer extends Model
{
    public function payBenefit()
    {
        return $this->hasMany(PayBenefit::class);
    }

    public function benefit()
    {
        return $this->belongsTo(Benefit::class);
    }
}
