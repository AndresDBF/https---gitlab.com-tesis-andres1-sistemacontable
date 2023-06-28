<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipCargoEmpleado extends Model
{
    use HasFactory;
    protected $primaryKey = 'idcarg';
    protected $fillable = [
        'concepto_cargo',	
        'tipcargo',
        'sueldo_cargo'
    ];
}
