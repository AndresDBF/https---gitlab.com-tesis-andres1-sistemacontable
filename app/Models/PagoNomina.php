<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoNomina extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddnom';
    protected $fillable = [
        'idnom',
        'concepto_pago',
        'montopago',
        'fecpag'
    ];
}
