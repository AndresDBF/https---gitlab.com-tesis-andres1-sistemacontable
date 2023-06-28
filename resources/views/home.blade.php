@extends('adminlte::page')

@section('title', 'Inicio')

@section('content_header')
    <h1>Página Principal</h1>
@stop

@section('content')
<div class="container">
    <div class="well">
        <div class="row justify-content-center">
          <div class="card text-white bg-warning mb-3" style="max-width: 17rem;">
            <div class="card-header text-center fw-bold">Cantidad de Clientes</div>
            <div class="card-body">
              <h4 class="card-title">Clientes Registrados</h4>
              <p class="card-text text-center pt-2 display-4">{{$countCustomer}}</p>
              <h4 class="card-title">Contratos de Clientes Activos</h4>
              <p class="card-text text-center pt-2 display-4 fw-bold">{{$countCustomer}}</p>
            </div>
          </div>
      
          <div class="card text-white bg-success ml-3" style="max-width: 17rem;">
            <div class="card-header text-center fw-bold">Cantidad de Proveedores</div>
            <div class="card-body">
              <h4 class="card-title">Ultimos Proveedores Registrados</h4>
              <p class="card-text text-center pt-2 display-4">{{$countSupplier}}</p>
            </div>
          </div>
      
          <div class="card text-white bg-info ml-3" style="max-width: 17rem;">
            <div class="card-header">Cantidad de Empleados</div>
            <div class="card-body">
              <h4 class="card-title">Empleados Activos</h4>
              <p class="card-text text-center pt-2 display-4">{{$countemployee}}</p>
              <h4 class="card-title">Empleados Retirados</h4>
              <p class="card-text text-center pt-2 display-4">{{$countemployee}}</p>
            </div>
          </div>
        </div>
    </div>      
</div>

    <div>

        <div class="progress">
            @php
            $montoInicial = 5000;
            $montoActual = 3000; // Obtén el valor actual de la columna de tu tabla
            $porcentaje = ($montoActual / $montoInicial) * 100;
            $porcentajeFormateado = number_format($porcentaje, 2);
            @endphp

            <div class="progress-bar" role="progressbar" style="width: {{ $porcentaje }}%; height: 20px;" aria-valuenow="{{ $porcentaje }}" aria-valuemin="0" aria-valuemax="100">
                {{ $porcentajeFormateado }}%
            </div>
        </div>
    </div>

    <canvas id="myChart"></canvas>
    @php
    $data = [30, 50, 20];
    $labels = ['Sección 1', 'Sección 2', 'Sección 3'];
    @endphp
@stop


@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.0/dist/chart.min.js"></script>
   {{--  <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: @json($labels),
                datasets: [{
                    data: @json($data),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                        text: 'Ejemplo de gráfico de torta'
                    }
                }
            }
        });
      </script> --}}
      

@endsection