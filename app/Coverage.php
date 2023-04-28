<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rate;
use App\Insurer;

class Coverage extends Model
{
    public function rates()
    {
        return $this->hasMany(Rate::class);
    }

    public function insurer()
    {
        return $this->belongsTo(Insurer::class);
    }
}
