<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenPago extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddorp';
    protected $fillable = [ 
        'idorpa',	
        'idcon'	,
        'baseimponible'	,
        'monto_iva'	,
        'monto_total',	
    ];
}
