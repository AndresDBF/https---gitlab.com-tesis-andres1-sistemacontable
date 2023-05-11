<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetComprobanteIng extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddcomp';
    protected $fillable = [
        
        'iddcomp',
        'idcom',
        'idcli',
        'nombre_cliente',
        'fec_trans',
        'stscom',
        'formpago',
        'descripcion',
    ];
}
