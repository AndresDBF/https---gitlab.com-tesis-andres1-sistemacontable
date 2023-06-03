<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleComprobantePago extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddpag';
    protected $fillable = [
        'idpag'	,
        'idprov'	,
        'fec_trans'	,
        'formpago'	,
        'descripcion',	
    ];
}
