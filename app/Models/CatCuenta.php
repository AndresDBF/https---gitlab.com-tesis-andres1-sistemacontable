<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatCuenta extends Model
{
    use HasFactory;
    protected $primaryKey = 'idcta';
    protected $fillable = [     
        'idcta'	,
        'nombre_cuenta',
        'tipcta',
        'tipmov',
        'stscta',	
        'cta1'	,
        'cta2'	,
        'cta3'	,
        'cta4'	,
        'cta5'];
}
