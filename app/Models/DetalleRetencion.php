<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleRetencion extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddret';
    protected $fillable  = [
        'iddret',
        'fecemifact',
        'numfact',
        'numctrl',
        'totalfact',
        'baseimponible',
        'montoimpuesto',
        'impuestoretenido'
    ];
}
