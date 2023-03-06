<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\ContrCli;
use App\Models\ReglaStatus;

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
        $cliente = Cliente::all();
        return view('clientes.index')->with('cliente',$cliente);

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
            if ($cuantos ==0){
                $idesigue = 1;
    
            }
            else{
                $idesigue = $consulta[0]->idcli+1;
            }
        return view('clientes/create')
                ->with('idsigue',$idesigue);

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
        if ($request->get('tip_pag')==1){
            $contrCustomer->tip_pag = "Anual";
        }
        elseif ($request->get('tip_pag')==2) {
            $contrCustomer->tip_pag = "Mensual";
        }
        elseif ($request->get('tip_pag')==3) {
            $contrCustomer->tip_pag = "Trimestral";
        }
        elseif ($request->get('tip_pag')==4) {
            $contrCustomer->tip_pag = "Semestral";
        }

        $contrCustomer->monto_pag = $request->get('valueCont');
        if ($request->get('money')==1){
            $contrCustomer->moneda = "BOL";
        }
        elseif ($request->get('money')==2) {
            $contrCustomer->moneda = "USD";
        }
        elseif ($request->get('money')==3) {
            $contrCustomer->moneda = "COP";
        }
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
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = Cliente::where('idcli',$id);
        $cliente->delete();
        return redirect('/clientes');
    }
}
