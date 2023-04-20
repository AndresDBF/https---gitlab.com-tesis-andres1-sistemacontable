<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;
    protected $primaryKey = 'idfact';
    protected $fillable = [
        'idfact',
        'idcfact',
        'nomacre',
        'dirfact',
        'tipid',
        'identificacion',
        'tiprif',
        'telefono',
        'tip_pago',
    ];
}
