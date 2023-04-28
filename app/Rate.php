<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Coverage;

class Rate extends Model
{
    public function coverage()
    {
        return $this->belongsTo(Coverage::class);
    }
}
