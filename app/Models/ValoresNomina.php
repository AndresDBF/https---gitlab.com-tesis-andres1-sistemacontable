<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoresNomina extends Model
{
    use HasFactory;
    protected $primaryKey = 'idval';
    protected $fillable = [
        'concepto_valor',
        'monto_valor',
        'fecsts'
    ];
}
