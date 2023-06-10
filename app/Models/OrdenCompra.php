<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenCompra extends Model
{
    use HasFactory;
    protected $primaryKey = 'idorco';
    protected $fillable = [
        'idprov',
        'numorden',
        'stsorden',
        'stsorden',
        'tiempo_pago',
        'moneda',
        'autorizacion',
        'fec_autoriza'
    ];
}
