<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContrCli extends Model
{
    use HasFactory;
    protected $primaryKey = 'idcont';
    protected $fillable = [
        'idcont',
        'idcli',
        'stscontr',
        'ind_girosre',
        'tip_pag',
        'fec_emi',
        'montopaglocal',
        'montolocalmoneda',
        'moneda',
        'tasa_cambio'

    ];
}
