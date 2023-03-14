<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ContrCli;
use App\Models\CatCuenta;
use App\Models\ReglaStatus;
use App\Models\Tipocuenta;
use App\Models\Tipomovimiento; 
use App\Models\Nombrecuenta;
use App\Models\lvalue;

class ClientesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
        ->select('clientes.idcli','clientes.nombre','clientes.rif_cedula','clientes.telefono',
        'clientes.email','contr_clis.stscontr','contr_clis.tip_pag')
        ->orderBy('clientes.nombre')
        ->get();
        return view('clientes.index')
             ->with('customer',$customer);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            $accounts = CatCuenta::orderBy('tipcta')
                                 ->get();
                                 
            
        return view('clientes/create')
                ->with('idsigue',$idesigue)
                ->with('accounts',$accounts);
                

                /* $last2 = DB::table('items')->orderBy('id', 'DESC')->first(); */
                
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($idcli)
    {        
        
        $dateCustom = Cliente::join('contr_clis','clientes.idcli','=','contr_clis.idcli')
                             ->select('clientes.idcli','clientes.nombre','clientes.rif_cedula','clientes.telefono','clientes.email',
                                      'clientes.direccion','contr_clis.stscontr','contr_clis.tip_pag','contr_clis.monto_pag','contr_clis.moneda',
                                      'contr_clis.idcta')
                             ->where('clientes.idcli',$idcli)
                             ->get();   
                             
        $accounts = CatCuenta::join('contr_clis','contr_clis.idcta','=','cat_cuentas.idcta')
                             ->select('cat_cuentas.idcta','cat_cuentas.tipcta','cat_cuentas.tipmov','cat_cuentas.nombre_cuenta')
                             ->whereNotIn('contr_clis.idcli',$idcli)
                             ->get();
                             

        $accounttip = CatCuenta::join('contr_clis','contr_clis.idcta','=','cat_cuentas.idcta')
                                ->select('cat_cuentas.idcta','cat_cuentas.tipcta')
                                ->distinct()
                                ->whereNotIn('cat_cuentas.tipcta',[$idcli->idcta])
                                ->get();
        $accountList = CatCuenta::WhereNotIn('idcta',$accounts)                   
                                ->get();
                                
        /* if ($accounts->tipcta = 'Activo') {
            
            $accounts = CatCuenta::join('contr_clis','contr_clis.idcta','=','cat_cuentas.idcta')
                             ->select('cat_cuentas.idcta','cat_cuentas.tipcta','cat_cuentas.tipmov','cat_cuentas.nombre_cuenta')
                             ->distinct()
                             ->get();  
                             dd($accounts);
                             
        }         */    
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $customer = Cliente::find($request->idcli);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contrcli = ContrCli::where('idcli',$id);
        $contrcli->delete();
        $cliente = Cliente::where('idcli',$id);
        $cliente->delete();
        
        return redirect('/clientes');
    }
    public function tipocuenta()
    {
        return Tipocuenta::all();
    }
    public function tipomovimiento(Request $request)
    {
        return Tipomovimiento::where("tipocuenta",$request->id)->get();
    }
    public function nombrecuenta(Request $request)
    {
        return Nombrecuenta::where("tipomovimiento",$request->id)->get();
    }
    
}
