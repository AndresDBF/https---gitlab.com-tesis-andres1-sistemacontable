<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ContrCli;
use App\Models\CatCuenta;
use App\Models\ReglaStatus;
use App\Models\lvalue;

class ContrCliController extends Controller
{
    /* public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $customer = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
        ->select('clientes.idcli','clientes.nombre','clientes.rif_cedula','clientes.telefono',
        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag')
        ->orderBy('clientes.nombre')
        ->get();
        return view('clientes.index')
             ->with('customer',$customer);

    } */

    public function createcli()
    {
            $consulta = Cliente::orderBy('idcli','desc')
                               ->take(1)
                               ->get();
            $cuantos = count($consulta);
            if ($cuantos == 0){
                $idesigue = 1;
    
            }
            else{
                $idesigue = $consulta[0]->idcli+1;
            }
            $accounts = CatCuenta::select('tipcta','tipmov')
                                 ->distinct()
                                 ->orderBy('tipcta')
                                 ->get();
                                 
            $nameaccount = CatCuenta::select('nombre_cuenta')
                                    ->distinct()
                                    
                                    ->get();
        return view('clientes/create')
                ->with('idsigue',$idesigue)
                ->with('accounts',$accounts)
                ->with('nameaccount',$nameaccount);

                /* $last2 = DB::table('items')->orderBy('id', 'DESC')->first(); */
                
    }

    public function storecli(Request $request)
    {
        
        $customer = new Cliente();
        $customer->idcli = $request->code;
        $customer->nombre = $request->get('name');
        $customer->rif_cedula = $request->get('identification');
        $customer->telefono = $request->get('phone');
        $customer->email = $request->get('email');
        $customer->direccion = $request->get('direction');
        $customer->save();

        $contrCustomer = new ContrCli();
        $contrCustomer->idcli = $customer->idcli;
        $contrCustomer->stscontr = $request->get('stscontr');
        $contrCustomer->tip_pag = $request->get('tip_pag');
        $contrCustomer->monto_pag = $request->get('valuecont');
        $contrCustomer->moneda = $request->get('money');
        $contrCustomer->idcta = $request->get('account');
        $contrCustomer->save();

        return redirect('/clientes');
    }

    public function editcli($idcli)
    {
        $dateCustom = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
                             ->select('clientes.idcli','clientes.nombre','clientes.rif_cedula','clientes.telefono','clientes.email',
                             'clientes.direccion','contr_clis.stscontr','contr_clis.tip_pag','contr_clis.monto_pag','contr_clis.moneda',
                             'contr_clis.idcta')
                             ->get();
                             
        $accounts = CatCuenta::join('contr_clis','cat_cuentas.idcta','=','contr_clis.idcta')
                             ->select('cat_cuentas.idcta','cat_cuentas.tipcta','cat_cuentas.tipmov','cat_cuentas.nombre_cuenta')
                             ->where('idcli',$idcli)
                             ->get();  

        $accountList = CatCuenta::WhereNotIn('idcta',$accounts)                   
                                ->get();
                                
        $status = ReglaStatus::where('nomtabla','contr_clis')
                            ->WhereNotIn('sts',$dateCustom)
                            ->get();

        $methodpag = lvalue::where('tipvalue','tippago')
                            ->get();

        $money = lvalue::where('tipvalue','moneda')
                        ->get();
        
        return view('clientes.edit')
             ->with('datecustom',$dateCustom[0])
             ->with('accounts',$accounts[0])
             ->with('accountlist',$accountList)
             ->with('status',$status)
             ->with('money',$money)
             ->with('methodpag',$methodpag);
    }

    public function updatecli(Request $request, $id)
    {
        dd($id);
        $customer = Cliente::find($request->idcli);
        dd($customer);
        $customer->nombre = $request->get('name');
        $customer->rif_cedula = $request->get('identification');
        $customer->telefono = $request->get('phone');
        $customer->email = $request->get('email');
        $customer->direccion = $request->get('direction');
        $customer->save();

        $contrCustomer = ContrCli::find($id);
        $contrCustomer->stscontr = $request->get('stscontr');
        $contrCustomer->tip_pag = $request->get('tip_pag');
        $contrCustomer->monto_pag = $request->get('valuecont');
        $contrCustomer->moneda = $request->get('money');
        $contrCustomer->idcta = $request->get('account');
        $contrCustomer->save();

        return redirect('/clientes');
    }

    public function deletecli($id)
    {
        $cliente = Cliente::where('idcli',$id);
        $cliente->delete();
        return redirect('/clientes');
    }
}
