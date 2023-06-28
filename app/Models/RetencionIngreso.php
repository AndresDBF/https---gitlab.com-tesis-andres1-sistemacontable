<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetencionIngreso extends Model
{
    use HasFactory;
    protected $primaryKey = 'idrein';
    protected $fillable = [
        'iding',	
        'idasi',	
        'idcli',	
        'idfact',
        'ncomprobante',
        'fecemi',
        'fecrecep'
    ];
}
