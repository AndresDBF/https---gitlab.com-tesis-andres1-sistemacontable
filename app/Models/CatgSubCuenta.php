<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatgSubCuenta extends Model
{
    use HasFactory;
    protected $fillable = [
        'idscu',	
        'idcta',	
        'idgcu',
        'tipsubcta',	
        'descripcion',
    ];
}
