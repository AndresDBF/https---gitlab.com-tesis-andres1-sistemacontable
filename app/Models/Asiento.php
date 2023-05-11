<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asiento extends Model
{
    use HasFactory;
    protected $primaryKey = 'idasi';
    protected $fillable = [
        
        'idasi',
        'fec_asi',	
        'observacion',	
        'idcta1',	
        'idcta2',	
        'descripcion',	
        'monto_deb',	
        'monto_hab',	
    ];
}
