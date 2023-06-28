<!DOCTYPE html>
<html>
<head>
    <style>
        body {

       
        margin-bottom:30px;
        
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    #img {
        position:absolute;
        left: 40px;
        top: 35px;
        bottom: 20px;

    }

    #title {
        position: relative;
        left: 150px;
    }
    #titlel {
        
        margin-left: 150px;
    }

    .nom-empresa {
        text-align:justify;
        margin-left: 10px;
        margin-right: 10px;

    }

    .border {
        border-bottom: 5px inset gray;
    }

    .datos {
        text-align: center;
        margin-top: 45px;
        font-size: 30px;
        background-color: rgb(223, 221, 221);
    }

    .derecho {
        position: absolute;
        top: 410px;
        right: 50px;
        margin-bottom: 5px;
    }

    .control {
        float: right;
        margin-top: 50px;
        margin-right: 40px;
    }

    div input {
        border: transparent;
        border-bottom: 1px inset gray;
        margin-bottom: 2px;


    }

    form {
        border: 5px inset gray;
        border-radius: 10px;
        margin-top: 10px;
    }

    .nombre {
        margin-left: 3px;
    }

    .cedula {
        margin-left: 3px;
    }
    .gris {
        background-color:rgb(223, 221, 221);
    }

    .table {
        width: 100%;
        border: 2px inset black;
        border-radius: 10px;
        margin-top: 4px;
    }

    .th, td {
    background-size: 24px ;
        
        border: 2px inset black;
    }

    .borde-total {
        float: right;
        margin-top: 50px;
        border: 2px inset grey;
        border-radius: 10px;
        padding: 15px;
        clear: right; /* Agrega esta línea */
    }

    #total {
    position: absolute;
    margin-left: 5.3%;
    }

    #IVA {
        position: absolute;
        margin-left: 2%;
    }

    .los-input {
    position: absolute;
    margin-top: 10%;
    padding-top: 18px;
    padding-bottom: 18px;
    padding-left: 10px;
    }
    .los-input {
        border: 3px inset grey;
        border-radius: 10px;
    }

    .formas {
        display: flex;
        justify-content: center;
        align-items: flex-end;
        margin-top: 30%;
    }

    .formas .los-input {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    .formas p {
        margin: 0;
        text-align: center;
        flex: 1;
    }
    </style>
    <title>Factura</title>
</head>
<body>
      <div class="border">
            <h1 id="titlel">
      
                    <img src="data:image/png;base64,{{$image}}" height="100px" width="100px">  

                    FIX4U Solutions
            </h1>
             <div>
                <div class="control"><p>N-control: {{$detInvoice->numctrl}}</p></div>
            </div>
            <div class="nom-empresa">

                <div class="direccion"><p>Direccion: {{$customer->direccion}}</p></div>
                <div class="telefono"><p>Telefono: {{$customer->telefono}}</p></div>
                <div class="correo"><p>Correo: {{$customer->email}}</p></div>
            </div>
     </div>
     <h3 class="datos">Factura</h3>
        <br>
     <div class="derecho">
      {{--  <p>Nro.: {{$detInvoice->numfact}}</p>  --}}
       <p>Fecha: {{$detInvoice->fec_emi}} </p>
     </div>   
     <div class="formulario">
        <form >
           
                <p class="nombre">Nombre y apellido o Razón social: {{$customer->nombre}}</p>
                {{-- <input class="nombre" name="nombre" value="{{$customer->nombre}}"> --}}
 
           
                <p class="cedula">C.I./RIF o pasaporte: {{$customer->tipid}}-{{$customer->identificacion}}-{{$customer->tiprif}}</p>
                {{-- <input class="cedula" name="cedula" value="{{$customer->tipid}}-{{$customer->identificacion}}-{{$customer->tiprif}}"> --}}
        </form>
     </div>
     <div>
        <br>
        <table class="table">
            <thead class="gris">
                <th>Cantidad</th>
                <th>Descripcion</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </thead>
            <tbody>
                @php
                    $countFiles = 1;
                @endphp
                <tr>
                    @foreach ($descripInvoice as $desc)
                        
                    
                    <td>{{$countFiles}}</td>
                    <td>{{$desc->descripcion}}</td>
                    <td>{{$desc->montounitariolocal}}</td>
                    <td>{{$desc->montobienlocal}}</td>
                    
                    </tr>

                    @php
                        $countFiles = $countFiles + 1;
                    @endphp
                @endforeach
            </tbody>
        </table>
     </div>
     <div class="borde-total"> 
        <form >

            <p class="base">Base imponible: {{$detInvoice->mtoimponiblelocal}}</p>
             


            <p class="IVA">IVA(16.00%): {{$detInvoice->mtoimpuestolocal}} </p>
           


            <p class="total">Total Factura: {{$detInvoice->mtototallocal}} </p>


        </form>
     </div>
     <div class="formas">
        <div class="los-input">
            <p class="form-pago">Forma de pago: {{$invoice->tip_pago}}</p>
            <p class="relining">Relación de Ingreso: {{$numreling->num_ing}}</p>
        </div>
    </div>
    
</body>
</html>