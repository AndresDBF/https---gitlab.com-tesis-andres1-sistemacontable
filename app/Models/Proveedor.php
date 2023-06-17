<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;
    protected $primaryKey = 'idprov';
    protected $fillable = [
        'nombre',
        'tipid',
        'identificacion',
        'tiprif',
        'direccion',
        'telefono',
        'correo',
        'categoria',
        'indcontribuyente',
        'porcentajereten'


    ];
}
