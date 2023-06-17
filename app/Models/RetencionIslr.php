<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetencionIslr extends Model
{
    use HasFactory;
    protected $primaryKey = 'idreti';
    protected $fillable = [
        'idpag',
        'idasi',
        'idprov',
        'idorpa',
        'idage',
    	'ncomprobante',
    	'fecemi'
    ];
}
