<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Nomina extends Model
{
    use HasFactory;

    protected $primaryKey = 'idnom';
    protected $fillable = [
        'idcarg',
        'nombre',	
        'tipid',	
        'identificacion',	
        'tiprif',
        'telefono',
        'direccion',
        'correo',	
        'stsemp',	
        'sueldo',
        'fec_ingr',	
        'fec_egre'
    ];
}
