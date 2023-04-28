<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Insurer;

class Benefit extends Model
{
    public function insurers()
    {
        return $this->belongsToMany(Insurer::class,"benefit_insurers");
    }
}
