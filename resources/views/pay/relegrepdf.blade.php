<!DOCTYPE html>
<html>
<head>
    <style>
        * {
            padding: 0;
            margin-left: 10px;
            margin-right: 10px;
            box-sizing: border-box;
        }

        body {
            margin-top: 0;
            margin-bottom: 30px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .img {
            display: flex;
            align-items: flex-start;
            margin-left: 35px;
            margin-top: 40px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            
            margin-top: 0;
            margin-bottom: 0;
        }

        .border {
            border-bottom: 3px inset gray;
            padding: 0 35px;
            margin-top: 10px;
        }

        .block {
            margin-bottom: 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 10px;
        }

        .block-1 {
            flex: 1;
        }

        .block-2 {
            background-color: rgb(187, 187, 187);
            flex: 1;
            text-align: center;
        }

        .control {
            text-align: end;
            position: absolute;
            bottom: 20%;
            left: 75%;
            margin-bottom: 38%;
        }

        .gris {
            background-color: rgb(223, 221, 221);
        }

        .table {
            width: 100%;
            border: 2px inset black;
            border-radius: 10px;
            margin-top: 4px;
        }

        .th,
        td {
            background-size: 24px;
            border: 2px inset black;
        }
        tr{
            text-align: center;
        }

        .borde-total {
            float: right;
            margin-top: 5px;
            border: 2px inset grey;
            border-radius: 10px;
            padding: 15px;
        }

        #total {
            width: 265px;
        }

        @page {
            size: landscape;
        }
    </style>
    <title>Document</title>
</head>
<body>
    <div class="border">
        <div class="img">
            <img src="data:image/png;base64,{{$image}}" height="120px" width="120px">
        </div>
        <div class="title">
            <h1>FIX4U Solutions</h1>
        </div>
        <div class="control">
            <p>Fecha Hasta: {{$fecini->fec_emi}}</p>
            <p>Fecha Desde: {{$fecfin->fec_emi}}</p>
        </div>
    </div>
    

    <div class="block">
        <div class="block-1">
            <div class="direccion">
                <p><b>Dirección:</b> {{$supplier->direccion}}</p>
            </div>
            <div class="telefono">
                <p><b>Teléfono: </b>{{$supplier->telefono}}</p>
            </div>
            <div class="correo">
                <p><b>Correo: </b>{{$supplier->correo}}</p>
            </div>
        </div>
        <div class="block-2">
            <h3 class="datos">Relaciones de Egresos</h3>
        </div>
    </div>

    <div>
        <br>
        <table class="table">
            <thead class="gris">
                <th>Relación de Egreso</th>
                <th>Nombre del Cliente</th>
                <th>Fecha de Egreso</th>
                <th>Monto de ingreso</th>
            </thead>
            <tbody>
                @foreach ($payorder as $pay)
                    <tr>
                        <th>{{$pay->num_egre}}</th>
                        <th>{{$supplier->nombre}}</th>
                        <th>{{$pay->fec_emi}}</th>
                        <th>{{$pay->montototallocal}}</th>
                    </tr>  
                @endforeach              
            </tbody>
            
        </table>
    </div>
    <div class="borde-total">
        <div>
            <p>Total de Relaciones de Egresos: {{$sumegre}}</p>
            
        </div>
    </div>
</body>
</html>
