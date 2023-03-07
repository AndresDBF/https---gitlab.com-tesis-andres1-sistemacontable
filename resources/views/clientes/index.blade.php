@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Registro de Clientes</h1>
@stop

@section('content')
    <a href="clientes/create" class="btn btn-primary mb-3">CREAR</a>
    <table id="articulos" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Identificación</th>
                <th scope="col">Status de Contrato</th>
                <th scope="col">Monto del Contrato</th>
                <th scope="col">Moneda</th>
                <th scope="col">Correo Electrónico</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customer as $cli)
                @foreach ($contrcustomer as $contr)
                    <tr>
                        <th>{{$cli->idcli}}</th>
                        <th>{{$cli->nombre}}</th>
                        <th>{{$cli->rif_cedula}}</th>
                        <th>{{$contr->stscontr}}</th>
                        <th>{{$contr->monto_pag}}</th>
                        <th>{{$contr->moneda}}</th>
                        <th>{{$cli->email}}</th>
                        <td>
                            <form action="{{route('clientes.destroy',$cli->idcli)}}" method="POST">
                                <a href="/clientes/{{$cli->id}}/edit" class="btn btn-info">Editar</a>
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger">Borrar</button>
                            </form>

                            
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@stop
