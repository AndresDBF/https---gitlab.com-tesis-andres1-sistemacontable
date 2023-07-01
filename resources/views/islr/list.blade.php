@extends('adminlte::page')

@section('title', 'Retenciones de Impuestos sobre la Renta')

@section('content_header')
    <h1>Retencion I.S.L.R Pendientes</h1>
    <hr>
@stop

@section('content')

<div class="container">
    <div class="mt-2">
        <h4 class="text-center fw-bold"> Lista de Contribuyentes Especiales en base a {{$tipagent->concepto}}</h4>
    </div>
    <table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">Fecha de Factura</th>
                <th scope="col">Nombre del Beneficiario</th>
                <th scope="col">Número de factura </th>
                <th scope="col">Número de Control</th>
                <th scope="col">Base Imponible de la Factura</th>
                @can('createislr')
                    <th scope="col">Acción</th>
                @endcan
                
            </tr>
        </thead>
        <tbody>
            <tr>
                @foreach ($registerOrderPay as $index => $pay)
                    <tr>
                        <th>{{ $pay->fec_emi }}</th>
                        <th>{{ $supplier[$index]->nombre }}</th>
                        <th>{{ $pay->numfact}}</th>
                        <th>{{ $pay->numctrl}}</th>
                        <th>{{ $pay->baseimponiblelocal}}</th> 
                        @can('createislr')
                            <td>       
                                <a href="#" class="btn btn-info mb-2" onclick="confirmCrear('{{route('createislr',['idorpa' => $pay->idorpa , 'idprov' => $pay->idprov, 'idage' => $tipagent->idage])}}')"><i class="fas fa-check"></i></a>
                            </td>
                        @endcan
                    </tr>
                @endforeach
            </tr>
        </tbody>
    </table>
</div>

@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCrear(url) {
            Swal.fire({
                title: 'Confirmación',
                text: '¿Realiza la Retención de I.S.L.R?',
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