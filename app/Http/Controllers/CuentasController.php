<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\CatCuenta;


class CuentasController extends Controller
{
    public function index($account){
        $accounts = CatCuenta::where ('tipcta',$account)
                            ->get();

        return redirect('/clientes')
               ->with('accounts',$accounts);
    }
}
