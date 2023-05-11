<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    use HasFactory;
    protected $primaryKey =  'iding';
    protected $fillable = [
        'iddcomp',	
        'idcli',	
        'iddfact',	
        'id',	
        'idcta',	
        'concepto_ing',	
        'moneda',	
        'stsing',	
        'fec_ing',	    
    ];
}
