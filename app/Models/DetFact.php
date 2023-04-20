<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetFact extends Model
{
    use HasFactory;
    protected  $primaryKey = 'iddfact';
    protected $fillable = [
       
        'idfact',
        'numfact',
        'numctrl',
        'stsfact',
        'fec_emi',
        'monto',
        'mtoimponible',
        'mtoimpuesto',
        'mtototal',
    ];
}
