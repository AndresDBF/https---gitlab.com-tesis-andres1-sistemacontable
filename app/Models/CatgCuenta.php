<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatgCuenta extends Model
{
    use HasFactory;
    protected $fillable = [
        'idgcu',
        'idcta',
        'tipcta',
        'descripcion',
    ];
}
