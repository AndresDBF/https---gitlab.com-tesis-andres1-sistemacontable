<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleOrdenCompra extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddord';
    protected $fillable = [
        'idorco',
        'descripcion',
        'monto_unit',
        'monto_bien',
        'monto_iva',
        'monto_total',
    ];
}
