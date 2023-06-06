<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConceptoFact extends Model
{
    use HasFactory;
    protected $primaryKey = 'idcfact';
    protected $fillable = [
        'idcfact',
        'num_ing',
        'num_egre'
    ];
    
}
