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
                <th scope="col">Codigo</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Cantidad</th>
                <th scope="col">Precios</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clientes as $cli)
                <tr>
                    <th>{{$cli->id}}</th>
                    <th>{{$cli->codigo}}</th>
                    <th>{{$cli->descripcion}}</th>
                    <th>{{$cli->cantidad}}</th>
                    <th>{{$cli->precio}}</th>
                    <td>
                        <form action="{{route('clientes.destroy',$cli->id)}}" method="POST">
                            <a href="/articulos/{{$cli->id}}/edit" class="btn btn-info">Editar</a>
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Borrar</button>
                        </form>

                        
                    </td>
                </tr>

            @endforeach
        </tbody>
    </table>
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@stop
