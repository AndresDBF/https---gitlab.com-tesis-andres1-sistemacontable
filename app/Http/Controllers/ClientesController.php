<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
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
            $estatus = ReglaStatus::orderBy('sts')
                                  ->where('nomtabla','clientes')
                                  ->get();
        return view('clientes/create')
                ->with('idsigue',$idesigue)
                ->with('estatus',$estatus);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $clientes = new Cliente();
        $clientes->idcli = $request->code;
        $clientes->nombre = $request->get('name');
        $clientes->rif_cedula = $request->get('identification');
        $clientes->stscontr = $request->get('idd');
        $clientes->telefono = $request->get('phone');
        $clientes->email = $request->get('email');
        $clientes->direccion = $request->get('direction');
        $clientes->save();

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
