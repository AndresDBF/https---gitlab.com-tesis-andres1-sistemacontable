<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DescripcionFactura extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddfact';
    protected $fillable = [
        'idfact',	
        'descripcion',	
        'monto_unitario	',
        'monto_bien',
    ];

}
