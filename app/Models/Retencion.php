<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retencion extends Model
{
    use HasFactory;
    protected $primaryKey = 'idret' ;
    protected $fillable = [
        'idret',	
        'idpag',
        'idasi'	,
        'idprov',	
        'idorpa',	
        'ncomprobante',	
        'fecemi',	
        'fecrecep'
    ];

}
