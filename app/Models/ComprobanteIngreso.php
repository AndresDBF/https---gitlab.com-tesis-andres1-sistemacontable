<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComprobanteIngreso extends Model
{
    use HasFactory;
    protected $primaryKey = 'idcom';
    protected $fillable = [
        'idcom',
        'idfact',
        'numconfirm',
        'numfact',
        'mtolocal',
        'mtomoneda',
        'tasa_cambio',
    	'cantidad_escr',
    ];
}
