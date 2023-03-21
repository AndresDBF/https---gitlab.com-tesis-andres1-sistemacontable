<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatGrupo extends Model
{
    use HasFactory;
    protected $fillable = [
        'idgru',
        'idcta',	
        'tipgrup',
        'descripcion',
    ];
}
