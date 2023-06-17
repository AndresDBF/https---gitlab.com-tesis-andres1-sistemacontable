<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoNomina extends Model
{
    use HasFactory;
    protected $primaryKey = 'iddnom';
    protected $fillable = [
        'idnom',	
        'sueldo_men',	
        'ind_horas_ext_diurnas',	
        'ind_horas_ext_nocturnas',	
        'ind_feriado',	
        'ind_dias_no_laborados',	
        'montohorasextdiur',	
        'montohorasextnoct',	
        'montoferiado',	
        'cestaticket',	
        'montototalasignacion',	
        'montototaldeduccion',	
        'montotnetocobrar'
    ];
}
