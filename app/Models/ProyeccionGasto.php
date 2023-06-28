<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProyeccionGasto extends Model
{
    use HasFactory;
    protected $primaryKey = 'idpro';
    protected $fillable = [
        'idpro',
        'presupuesto',
        'presupuesto_ini',
        'fecstsini',
        'fecstsfin'
    ];
}
