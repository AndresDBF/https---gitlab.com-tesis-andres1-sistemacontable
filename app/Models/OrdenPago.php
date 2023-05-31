<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenPago extends Model
{
    use HasFactory;
    protected $primaryKey = 'idorpa';
    protected $fillable = [
        'idorco',
        'idprov',
        'num_egre',
        'stsorpa',
        'numfact',
        'numctrl',
        'fec_emi',
        'fec_vencimiento',
        'tippago',
        'moneda',
    ];
}
