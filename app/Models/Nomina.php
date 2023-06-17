<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nomina extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $primaryKey = 'idnom';
    protected $fillable = [
        'nombre',	
        'tipid',	
        'identificacion',	
        'tiprif',	
        'cargo',	
        'fec_ingr',	
        'fec_egre'
    ];
}
