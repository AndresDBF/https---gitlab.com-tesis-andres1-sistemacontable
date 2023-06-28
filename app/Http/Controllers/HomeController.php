<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ContrCli;
use App\Models\Nomina;
use App\Models\Proveedor;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $supplier = Proveedor::all();
        $customer = Cliente::all();
        $employee = Nomina::all();

        $employeeAct = Nomina::where('stsemp', 'ACT')->get();
        $employeeAct = Nomina::where('stsemp', 'RET')->get();
        $contrCliAct = ContrCli::where('stscontr', 'ACT')->get();
        
        $countSupplier = count($supplier);
        $countCustomer = count($customer);
        $countemployee = count($employee);
        
        $countemployeeAct = count($employeeAct);
        $countCliAct = count($contrCliAct);
        

        return view('home',compact('countSupplier','countCustomer','countemployee','contrCliAct','countemployeeAct','countCliAct'));
    }
}
