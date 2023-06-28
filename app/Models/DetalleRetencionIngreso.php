<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRetencionIngreso extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddrein';
    protected $fillable = [
        'idrein',
        'fecemifact',
        'numfact',
        'numctrl',
        'totalfact',
        'baseimponible',
        'montoimpuesto',
        'impuestoretenido'
    ];
}
