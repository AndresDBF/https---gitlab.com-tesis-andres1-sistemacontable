<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoAgente extends Model
{
    use HasFactory;
    protected $primaryKey = 'idage';
    protected $fillable = [
        'tippersona',	
        'concepto',	
        'porcentajebase',
        'porcentajereten',
        'mayorpago',
        'sustraendo'
    ];
}
