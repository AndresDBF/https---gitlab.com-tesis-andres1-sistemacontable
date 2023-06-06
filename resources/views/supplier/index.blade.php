@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
    <h1>Registro de Proveedores</h1>
@stop

@section('content')
   
    <a href="supplier/create" class="btn btn-primary mb-3">CREAR</a>
    <table id="clientes" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Identificación</th>
                <th scope="col">Telefono</th>
                <th scope="col">Dirección</th>
                <th scope="col">Categoria</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registerSupplier as $supplier)
                <tr>
                    <th>{{$supplier->idprov}}</th>
                    <th>{{$supplier->nombre}}</th>
                    <th>{{$supplier->identificacion}}</th>
                    <th>{{$supplier->telefono}}</th>
                    <th>{{$supplier->direccion}}</th>
                    @foreach ($tipCategory as $tip)
                        @if ($supplier->categoria == $tip->tip_prove)
                            <th>{{$tip->descripcion}}</th>
                        @endif
                    @endforeach
                    <td>
                        <a href="/supplier/{{$supplier->idprov}}/edit" class="btn btn-info">Editar</a>
                        <form action="{{route('supplier.destroy',$supplier->idprov)}}" method="POST">
                            
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger pt-2">Borrar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    @if ($registerSupplier->hasPages())
    <tr>
        <td colspan="6" class="text-center">
           
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    
                    @if ($registerSupplier->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $registerSupplier->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                   
                    @foreach ($registerSupplier->getUrlRange(1, $registerSupplier->lastPage()) as $page => $url)
                        @if ($page == $registerSupplier->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                   
                    @if ($registerSupplier->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $registerSupplier->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                </ul>
            </nav>
        </td>
    </tr>
    @endif
@stop

@section('js')
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@stop
