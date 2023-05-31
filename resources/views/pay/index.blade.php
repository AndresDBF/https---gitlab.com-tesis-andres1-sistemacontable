@extends('adminlte::page')

@section('title', 'Registrar Pago')

@section('content_header')
    <h1>Ordenes de Pago Pendientes</h1>
@stop

@section('content')
    <table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">
        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">Numero de Relacion de Egreso</th>
                <th scope="col">Nombre del Beneficiario</th>
                <th scope="col">Moneda</th>
                <th scope="col">Tipo de Pago</th>
                <th scope="col">Monto de Orden de Pago</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registerPay as $index => $pay)
                <tr>
                    <th>{{ $pay->num_egre }}</th>
                    <th>{{ $pay->nombre }}</th>
                    <th>{{ $pay->moneda }}</th>
                    @switch($pay->tippago)
                        @case('EFE')
                            <th>EFECTIVO</th>
                            @break
                        @case('TRA')
                            <th>TRANSFERENCIA BANCARIA</th>
                            @break
                        @case('PMO')
                            <th>PAGO MOVIL</th>
                            @break
                        @case('TDE')
                            <th>TARJETA DE DEBITO</th>
                            @break
                        @case('TCR')
                            <th>TARJETA DE CREDITO</th>
                            @break
                    @endswitch
                    <th>{{ $detPayOrder[$index]->monto_total }}</th>
                    <td>
                        {{-- <a href="#" class="btn btn-info mb-2" onclick="confirmAutorizar('{{ route('createpayorder', ['idprov' => $purchase->idprov,'idorco' => $purchase->idorco]) }}')">Crear Orden</a> --}}                
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@stop