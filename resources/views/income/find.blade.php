@extends('adminlte::page')

@section('title', 'Ingreso')

@section('content_header')
    <h1>Ingreso</h1>
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
                                <option value="{{$customer->tipid}}">{{$customer->tipid}}</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Rif o Cedula del Cliente</label>
                        <input type="number" name="identification" id="identification" value="{{$customer->identificacion}}" class="form-control text-decoration-none" tabindex="6" readonly="readonly">
                    </div>
                    <div class="col-xs-3 col-sm-6 col-md-4">
                        <label for="" class="form-label">Numero de Chequeo</label>
                        <select name = 'numcheck' class="custom-select">
                            <option value="{{$customer->tiprif}}">{{$customer->tiprif}}</option>
                           
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body pl-6">
        <h3 class="text-center fw-bolder pb-2">Cobros Pendientes</h3>
        <table id="invoice" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

            <thead class="bd-primary text-dark">
                <tr>
                    <th scope="col">Fecha de Emisión de Cobro</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Forma de Pago</th>
                    <th scope="col">Monto Total de Factura</th>
                    <th scope="col">Seleccionar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($findDetInvoice as $index => $detInvoice)
                    <tr>
                        <td>{{ $detInvoice->fec_emi }}</td>
                        <td>{{ $nameCli[$index]->nombre }}</td>
                        @if ($detInvoice->tip_pago == 'EFE')
                            <td>EFECTIVO</td>
                        @elseif ($detInvoice->tip_pago == 'TRA')
                            <td>TRANSFERENCIA BANCARIA</td>
                        @elseif ($detInvoice->tip_pago == 'PMO')
                            <td>PAGO MOVIL</td>
                        @elseif ($detInvoice->tip_pago == 'TDE')
                            <td>TARJETA DE DEBITO</td>
                        @else
                            <td>TARJETA DE CREDITO</td>
                        @endif

                        @if ($detInvoice->moneda != 'BS')
                            <td>{{ $detInvoice->mtototalmoneda }}</td> 
                        @else
                            <td>{{ $detInvoice->mtototallocal }}</td> 
                        @endif

                        <td class="text-center">
                            <a href="#" class="btn btn-info mb-2" onclick="confirmCreate('{{ route('createIng', ['idfact' => $findInvoice[$index]->idfact, 'idcli' => $customer->idcli]) }}')">
                                <i class="fas fa-plus-circle"></i>
                            </a>
                        </td>
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
                text: '¿Crear Ingreso?',
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