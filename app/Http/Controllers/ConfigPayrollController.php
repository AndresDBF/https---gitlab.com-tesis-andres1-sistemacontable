<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nomina;
use App\Models\TipCargoEmpleado;
use App\Models\ValoresNomina;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class ConfigPayrollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:chargescreate')->only('chargescreate','chargesStore');
        $this->middleware('can:chargeedit')->only('chargeedit','chargesupdate');
        $this->middleware('can:chargesdelete')->only('chargesdelete');
        $this->middleware('can:valueedit')->only('valueedit','valueupdate');

    }
    //cargos de empleado
    public function chargescreate(){
        return view('payroll.charge.create');
    }
    public function chargesStore(Request $request){

        $this->validate($request,[
            'concepto_cargo' => 'required',
            'sueldo_cargo' => 'required|numeric'
        ]); 
        $charge = TipCargoEmpleado::create($request->all());
        Session::flash('charge','se ha creado el cargo correctamente');
        return redirect('/payroll');
    }
    public function chargeedit($idcarg){
        $charge = TipCargoEmpleado::find($idcarg);

        $tipcarg = ['AGE' => 'Agente',
        'ADM' => 'Administrador',
        'CON' => 'Contador',
        'DIR' => 'Director',
        'DIG' => 'Diseñador Gráfico',
        'GER' => 'Gerente', 
        'PRO' => 'Programador',
        'IT' => 'Soporte Tecnico', 
        'SUP' => 'Supervisor'];
        return view('payroll.charge.edit',compact('charge','tipcarg'));
        
    }
    public function chargesupdate(Request $request,$idcarg){
        $this->validate($request,[
            'concepto_cargo' => 'required',
            'sueldo_cargo' => 'required|numeric'
        ]); 
        TipCargoEmpleado::where('idcarg',$idcarg)->update([
            'concepto_cargo' => $request->get('concepto_cargo'),
            'sueldo_cargo' => $request->get('sueldo_cargo')
        ]);
        Session::flash('charge','Se ha actualizado el Cargo correctamente');
        return redirect('/payroll');
    }
    public function chargesdelete($idcarg){
        $charge = TipCargoEmpleado::find($idcarg)->delete();
        Session::flash('destroy','Se ha Eliminado el cargo correctamente');
        return redirect('/payroll');
    }
    //valores de pago
    public function createvalue(){
        $fecsts = Carbon::now()->format('Y-m-d');
        return view('payroll.valuepay.create',compact('fecsts'));
    }
    public function storevalue(Request $request){
        $this->validate($request,[
            'concepto_valor' => 'required',
            'monto_valor' => 'required|numeric',

        ]);
        $value = ValoresNomina::create($request->all());
        Session::flash('value','Se ha agregado el valor de pago correctamente');
        return redirect('/payroll');
    }

    public function valueedit($idval){
        $valuePay = ValoresNomina::find($idval);
        $fecsts = Carbon::now()->format('Y-m-d');
        return view('payroll.valuepay.edit',compact('valuePay','fecsts'));
    }
    public function valueupdate(Request $request,$idval){
        $this->validate($request,[
            'concepto_valor' => 'required',
            'monto_valor' => 'required|numeric',

        ]);

        ValoresNomina::where('idval',$idval)->update([
            'concepto_valor' => $request->get('concepto_valor'),
            'monto_valor' => $request->get('monto_valor'),
            'fecsts' => $request->get('fecsts')
        ]);
        Session::flash('value','Se ha agregado el valor de pago correctamente');
        return redirect('/payroll');
    }
    public function valuedelete($idval){
        $value = ValoresNomina::find($idval)->delete();
        return redirect('/payroll');
    }
}
