<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Benefit;

class Insurer extends Model
{
    /*public function benefits()
    {
        return $this->hasMany(Benefit::class);
    }*/

    public function benefits()
    {
        return $this->belongsToMany(Benefit::class,"benefit_insurers");
    }

    public function benefitsInsurer()
    {
        return $this->hasMany(BenefitInsurer::class);
    }

}
