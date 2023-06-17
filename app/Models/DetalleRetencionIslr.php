<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRetencionIslr extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddreti';
    protected $fillable = [ 
        'idreti',	
        'fecemifact',	
        'numfact',
        'numctrl',	
        'concepto',	
        'baseimponible',	
        'porcentajeret',	
        'montoretenido'
    ];
}
