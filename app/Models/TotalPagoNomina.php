<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalPagoNomina extends Model
{
    use HasFactory;
    protected $primaryKey = 'idtnom';
    protected $fillable = [
        'idnom',
        'idasi',
        'totalasignacion',
        'totaldeduccion',
        'netocobrar',
        'fecpag'

    ];
}
