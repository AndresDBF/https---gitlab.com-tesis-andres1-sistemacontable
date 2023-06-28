@extends('adminlte::page')

@section('title', 'Comprobante de Ingreso')

@section('content_header')
    <h1 class="fw-bolder">Comprobante de Ingreso</h1>
@stop

@section('content')
<div class="container">
    @if(session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="card">
        <div class="card-body pl-6">
        <h3 class="text-center fw-bolder pb-4">Ingresa la Identificación del Beneficiario de la Factura</h3>
            <div class="well">
                <div class="row">
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <div class="form-label">
                            <label for="dni">Tipo de Identificación</label>
                            <select name = 'tipid' class="custom-select">
                                <option value="{{$nameCli->tipid}}">{{$nameCli->tipid}}</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Rif o Cedula del Cliente</label>
                        <input type="number" name="identification" id="identification" value="{{$nameCli->identificacion}}" class="form-control text-decoration-none" tabindex="6" readonly="readonly">
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Numero de Chequeo</label>
                        <select name = 'numcheck' class="custom-select">
                            <option value="{{$nameCli->tiprif}}">{{$nameCli->tiprif}}</option>
                           
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body pl-6">
        <h3 class="text-center fw-bolder pb-2">Facturas Pendientes</h3>
        <table id="invoice" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

            <thead class="bd-primary text-dark">
                <tr>
                    <th scope="col">Fecha de Emision</th>
                    <th scope="col">Número de Factura</th>
                    <th scope="col">Número de Control</th>
                    <th scope="col">Forma de Pago</th>
                    <th scope="col">Monto Total de Factura</th>
                    <th scope="col">Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($findDetInvoice as $Invoice)
                    <tr>
                        <th>{{ $Invoice->fec_emi }}</th>
                        <th>{{ $Invoice->numfact }}</th>
                        <th>{{ $Invoice->numctrl }}</th>
                        @if ($Invoice->tip_pago == 'EFE')
                            <th>EFECTIVO</th>
                        @elseif ($Invoice->tip_pago == 'TRA')
                            <th>TRANSFERENCIA BANCARIA</th>
                        @elseif ($Invoice->tip_pago == 'PMO')
                            <th>PAGO MOVIL</th>
                        @elseif ($Invoice->tip_pago == 'TDE')
                            <th>TARJETA DE DEBITO</th>
                        @else
                            <th>TARJETA DE CREDITO</th>
                        @endif

                        @if ($Invoice->moneda != 'BS')
                            <th>{{ $Invoice->mtototalmoneda }}</th> 
                        @else
                            <th>{{ $Invoice->mtototallocal }}</th> 
                        @endif

                        <th class="text-center">
                            <a href="#" class="btn btn-info mb-2" onclick="confirmCreate('{{ route('createIncome', ['idfact' => $Invoice->idfact, 'idcli' => $nameCli->idcli]) }}')">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </th>
                    </tr>
                @endforeach


            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCreate(url) {
            Swal.fire({
                title: 'Confirmación',
                text: '¿Crear Comprobante de Ingreso?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection