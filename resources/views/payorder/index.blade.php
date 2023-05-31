@extends('adminlte::page')

@section('title', 'Orden de Compra')

@section('content_header')
    <h1>Ordenes de Compra Aprobadas</h1>
@stop

@section('content')
    <table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">Numero de Orden</th>
                <th scope="col">Nombre del Beneficiario</th>
                <th scope="col">Dirección</th>
                <th scope="col">Tiempo de Pago</th>
                <th scope="col">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registerPurchase as $purchase)
            <tr>
                <th>{{ $purchase->numorden }}</th>
                <th>{{ $purchase->nombre }}</th>
                <th>{{ $purchase->direccion }}</th>
                <th>{{ $purchase->tiempo_pago }} Dias</th>
                <td>
                    <a href="#" class="btn btn-info mb-2" onclick="confirmAutorizar('{{ route('createpayorder', ['idprov' => $purchase->idprov,'idorco' => $purchase->idorco]) }}')">Crear Orden</a>                
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmAutorizar(url) {
            Swal.fire({
                title: 'Confirmación',
                text: '¿Estás seguro de crear la orden de pago?',
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