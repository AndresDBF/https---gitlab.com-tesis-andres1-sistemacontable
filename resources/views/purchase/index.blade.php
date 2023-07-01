@extends('adminlte::page')

@section('title', 'Orden de Compra')

@section('content_header')
    <h1>Registro de Ordenes de Compra</h1>
@stop

@section('content')

    <a href="{{route('findsupplier')}}" class="btn btn-primary mb-3">CREAR</a>
    @if(Session::has('error'))
    <div class="alert alert-danger">{{Session::get('error')}}</div>
    @endif
    <table id="purchase" class="table table-striped table-bordered shadow-lg mt-4" style="width: 100%">

        <thead class="bd-primary text-dark">
            <tr>
                <th scope="col">Numero de Orden</th>
                <th scope="col">Nombre del Beneficiario</th>
                <th scope="col">Identificación</th>
                <th scope="col">Status</th>
                <th scope="col">Tiempo de Pago</th>
                @can('autorizar')
                    <th scope="col">Acción</th>
                @endcan
               
            </tr>
        </thead>
        <tbody>
            @foreach ($registerPurchase as $purchase)
            <tr>
                <th>{{ $purchase->numorden }}</th>
                <th>{{ $purchase->nombre }}</th>
                @if ($purchase->tiprif != null)
                    <th>{{$purchase->tipid}}-{{ $purchase->identificacion}}-{{$purchase->tiprif}}</th>
                @else
                    <th>{{$purchase->tipid}}-{{ $purchase->identificacion}}</th>
                @endif
                <th>{{ $purchase->stsorden }}</th>
                <th>{{ $purchase->tiempo_pago }} Dias</th>
                @can('autorizar')
                    <td>
                        <a href="#" class="btn btn-info mb-2" data-bs-toggle="modal" data-bs-target="#retening" onclick="confirmAutorizar('{{ route('autorizar', ['idorco' => $purchase->idorco]) }}')">Autorizar</a>
                        <br>
                        <a href="#" class="btn btn-danger mb-2" onclick="confirmDelete('{{ route('deleteorderco', ['idorco' => $purchase->idorco]) }}')">Eliminar</a>
                    
                        
                    </td>
                @endcan
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
            text: '¿Estás seguro de autorizar la orden de compra?',
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

<script>
    function confirmDelete(url) {
        Swal.fire({
            title: 'Confirmación',
            text: '¿Estás seguro de borrar la orden de compra?',
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