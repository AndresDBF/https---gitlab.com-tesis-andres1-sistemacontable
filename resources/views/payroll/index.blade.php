@extends('adminlte::page')

@section('title', 'Nomina')

@section('content_header')
    <h1 class="text-secondary fs-5 shadow-lg p-2 mb-5 bg-body rounded text-center">Registro de Empleados</h1>
@stop

@section('content')
<div class="container">
    <div>
        @if (session('charge'))
        <div class="alert alert-success">
            {{session('charge')}}
        </div>
        @endif
        @if (session('employee'))
            <div class="alert alert-success">
                {{session('employee')}}
            </div>
        @endif
        @if (session('message'))
            <div class="alert alert-success">
                {{session('message')}}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{session('error')}}
            </div>
        @endif
        @if (session('destroy'))
            <div class="alert alert-warning">
                {{session('destroy')}}
            </div>
        @endif
        @if (session('value'))
            <div class="alert alert-success">
                {{session('value')}}
            </div>
        @endif
    </div>  
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #dcecff;"> 
        <div class="container-fluid">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="payroll/create">
                <i class="fas fa-plus"></i> Nuevo empleado
              </a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="modal" data-bs-target="#cargos" href="#"><i class="fas fa-address-card"></i>Cargos de Empleados</a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="modal" data-bs-target="#pago" href="#"><i class="fas fa-plus-circle"></i>Realizar pago</a>
            </li>
          </ul>
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="modal" data-bs-target="#valorpagohora" href="#"><i class="fas fa-comment-dollar"></i>Valores de pago</a>
            </li>
          </ul>          
        </div>
    </nav>
    <table id="nomina" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Identificación</th>
                <th scope="col">Telefono</th>
                <th scope="col">Cargo</th>
                <th scope="col">Fecha de Ingreso</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($registerEmployee as $employee)
                    <tr>
                        <th>{{$employee->idnom}}</th>
                        <th>{{$employee->nombre}}</th>
                        <th>{{$employee->tipid}}-{{$employee->identificacion}}-{{$employee->tiprif}}</th>
                        <th>{{$employee->telefono}}</th>
                        <th>{{$employee->concepto_cargo}}</th>
                        <th>{{$employee->fec_ingr}}</th>
                        <td>
                            <button type="button" class="btn btn-info" onclick="editEmployee('payroll/{{$employee->idnom}}/edit')">
                                <i class="fas fa-pen-alt"></i>
                            </button>
                        
                            <button type="button" class="btn btn-danger" onclick="deleteEmployee('{{ route('payroll.destroy', $employee->idnom) }}?_token={{ csrf_token() }}')">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </td>
                        
                        
                    </tr>                   
                @endforeach
            </tr>
        </tbody>
    </table>

    @if ($registerEmployee->hasPages())
    <tr>
        <td colspan="6" class="text-center">
           
            <nav aria-label="Page navigation example">
                <ul class="pagination">
                    
                    @if ($registerEmployee->onFirstPage())
                        <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $registerEmployee->previousPageUrl() }}" rel="prev">&laquo;</a></li>
                    @endif

                   
                    @foreach ($registerEmployee->getUrlRange(1, $registerEmployee->lastPage()) as $page => $url)
                        @if ($page == $registerEmployee->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach

                   
                    @if ($registerEmployee->hasMorePages())
                        <li class="page-item"><a class="page-link" href="{{ $registerEmployee->nextPageUrl() }}" rel="next">&raquo;</a></li>
                    @else
                        <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
                    @endif
                </ul>
            </nav>
        </td>
    </tr>
    @endif
    {{-- MODAL PARA VALORES DE PAGO --}}
    <div class="modal fade" id="valorpagohora" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="valorpagohoraLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">Valor Pago Por Hora</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-body">
                <table id="nomina" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
                    <thead class="bd-primary text-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Concepto de Pago</th>
                            <th scope="col">Valor de Pago</th>
                            <th scope="col">Ultima Fecha de modificación</th>   
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($registerValuePay as $value)
                                <tr>
                                    <th>{{$value->idval}}</th>
                                    <th>{{$value->concepto_valor}}</th>
                                    <th>{{$value->monto_valor}}</th>
                                    <th>{{$value->fecsts}}</th>
                                    <th>
                                        <a href="{{route('valueedit',['idval' => $value->idval])}}" class="btn btn-info"><i class="fas fa-pen-alt"></i></a>
                                    </th>
                                </tr>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
              <a href="{{route('createvalue')}}">
                <button type="button" class="btn btn-primary">Crear</button>
              </a>
            </div>
          </div>
        </div>
    </div>

    {{-- MODAL PARA LISTA DE CARGOS DE EMPLEADOS  --}}
    <div class="modal fade" id="cargos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="cargosLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Listado de Cargos</h5>
                </div>
                <div class="modal-body">
                    <table id="nomina" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
                        <thead class="bd-primary text-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">Sueldo del Cargo</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($registerCharges as $charges)
                                    <tr>
                                        <th>{{$charges->idcarg}}</th>
                                        <th>{{$charges->concepto_cargo}}</th>
                                        <th>{{$charges->sueldo_cargo}}</th>
                                        <th>
                                            <a href="{{route('chargeedit',['idcarg' => $charges->idcarg])}}" class="btn btn-info"><i class="fas fa-pen-alt"></i></a>
                                            <a href="{{route('chargesdelete',['idcarg' => $charges->idcarg])}}"  class="btn btn-danger"><i class="fas fa-trash-alt"></i></a>
                                        </th>
                                    </tr>
                                    
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <a href="{{route('chargescreate')}}">
                        <button type="button" class="btn btn-primary">Crear</button>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL PARA REALIZAR PAGO  --}}
    <div class="modal fade" id="pago" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="pagoLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Listado de Cargos</h5>
                </div>
                <div class="modal-body">
                    <table id="nomina" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
                        <thead class="bd-primary text-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Identificación</th>
                                <th scope="col">Telefono</th>
                                <th scope="col">Cargo</th>
                                <th scope="col">Fecha de Ingreso</th>
                                <th scope="col">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @foreach ($registerEmployee as $employee)
                                    <tr>
                                        <th>{{$employee->idnom}}</th>
                                        <th>{{$employee->nombre}}</th>
                                        <th>{{$employee->tipid}}-{{$employee->identificacion}}-{{$employee->tiprif}}</th>
                                        <th>{{$employee->telefono}}</th>
                                        <th>{{$employee->concepto_cargo}}</th>
                                        <th>{{$employee->fec_ingr}}</th>
                                        <td>
                                            <button type="button" class="btn btn-primary" onclick="confirmPag('{{route('payemployee',['idnom' => $employee->idnom])}}')"> <i class="fas fa-coins"></i></button>
                                        </td> 
                                    </tr>                   
                                @endforeach
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

</div>
  
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>   
    <script src="https://kit.fontawesome.com/d2c478c6c0.js" crossorigin="anonymous"></script>
    <script src="{{asset('js/process/validationpayroll.js')}}"></script>
@endsection