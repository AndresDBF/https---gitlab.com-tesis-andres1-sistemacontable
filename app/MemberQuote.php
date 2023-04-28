<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Quote;

class MemberQuote extends Model
{
    public function quote()
    {
        return $this->belongsTo(Quote::class);
    }
}
