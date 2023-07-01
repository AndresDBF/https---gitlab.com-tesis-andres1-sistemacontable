@extends('adminlte::page')

@section('title', 'Categorias de Proveedores')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Lista de Categorias de Proveedores</h1>
@stop

@section('content')

    @if(session('message'))
    <div class="alert alert-success" role="alert">
        {{ session('message') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif

    @can('supplier.create')
        <a href="catsupplier/create" class="btn btn-primary mb-3">CREAR</a>
    @endcan
    <table id="catsupplier" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Abreviatura de Categoria</th>
                <th scope="col">Tipo de Categoria</th>
                @can('supplier.edit')
                <th scope="col">Acción</th>
                @endcan
            </tr>
        </thead>
        <tbody>
            @foreach ($catSupplier as $cat)
                <tr>
                    <th>{{$cat->id}}</th>
                    <th>{{$cat->tip_prove}}</th>
                    <th>{{$cat->descripcion}}</th>
                    <th class="text-center">
                        @can('supplier.edit')
                            <a href="/catsupplier/{{$cat->id}}/edit" class="btn btn-info"><i class="fas fa-pen-to-square"></i></a>  
                        @endcan
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Mostrar enlaces de paginación -->
    @if ($catSupplier->hasPages())
    <tr>
        <td colspan="6" class="text-center">
           
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    
                    @if ($catSupplier->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $catSupplier->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                   
                    @foreach ($catSupplier->getUrlRange(1, $catSupplier->lastPage()) as $page => $url)
                        @if ($page == $catSupplier->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                   
                    @if ($catSupplier->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $catSupplier->nextPageUrl() }}" rel="next">&raquo;</a></li>
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
