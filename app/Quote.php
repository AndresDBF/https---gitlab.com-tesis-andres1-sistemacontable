<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MemberQuote;
use App\Coverage;

class Quote extends Model
{
    public function memberquote()
    {
        return $this->hasMany(MemberQuote::class);
    }

    public function coverages()
    {
        return $this->hasMany(Coverage::class,"coverage","coverage");
    }
}
