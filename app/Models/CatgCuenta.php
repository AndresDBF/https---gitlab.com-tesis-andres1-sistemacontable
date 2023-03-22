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
<<<<<<< HEAD
        'idsgr',
=======
        'tipsubg',
>>>>>>> 4a51ac9c67a34874a99c2b62bd7b65a48004bf06
        'tipcta',
        'descripcion',
    ];
}
