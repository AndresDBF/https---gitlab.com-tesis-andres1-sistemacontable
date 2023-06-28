@extends('adminlte::page')

@section('title', 'Proyección de Gastos')

@section('content_header')
    <h1>Proyección de Gastos </h1>
@stop

@section('content')
    @if (session('message'))
        <div class="alert alert-warning">
            {{session('message')}}
        </div>
    @endif
    <a href="{{route('createproyectgast')}}" class="btn btn-primary mb-3">Crear Proyección <i class="fas fa-pen"></i></a>
    @if (isset($seats, $proyect, $amountGast))
       
            <table id="clientes" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
                <thead class="bd-primary text-dark">
                    <tr>
                        <th scope="col">Concepto de Gasto</th>
                        <th scope="col">Presupuesto Inicial</th>
                        <th scope="col">Movimientos de Gastos</th>
                        <th scope="col">Saldo Final</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $amountSald = $proyect->presupuesto_ini; // Valor inicial de la variable $amountSald
                    @endphp


                    @foreach ($seats as $seat)
                    @php
                        $amountSald = $amountSald - $seat->monto_deb; // Resta el movimiento de gastos a $amountSald
                    @endphp
                        <tr>
                            <td>{{ $seat->descripcion }}</td>
                            <td>{{ $proyect->presupuesto_ini }}</td>
                            <td>{{ $seat->monto_deb }}</td>
                            <td>{{ $amountSald }}</td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
            <!-- Mostrar enlaces de paginación -->
            @if ($seats->hasPages())
            <tr>
                <td colspan="6" class="text-center">
                
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">
                            
                            @if ($seats->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $seats->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                            @endif

                        
                            @foreach ($seats->getUrlRange(1, $seats->lastPage()) as $page => $url)
                                @if ($page == $seats->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                        
                            @if ($seats->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $seats->nextPageUrl() }}" rel="next">&raquo;</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                            @endif
                        </ul>
                    </nav>
                </td>
            </tr>
            @endif

    @endif
@stop

@section('js')
<script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
@endsection