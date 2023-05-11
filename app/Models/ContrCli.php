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
        'tip_pag',
        'monto_pag',
        'moneda',
        'idasi',

    ];
}
