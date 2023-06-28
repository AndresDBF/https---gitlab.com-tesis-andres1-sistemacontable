<!DOCTYPE html>
<html>
<head>
    <style>
* {
  padding: 0%;
  margin: 0;
  box-sizing: border-box;/* borra los estilos del navegador */
  /*para reiniciar las configuraciones del navegador*/
}

body {
  font-family: 'Roboto Mono', sans-serif;
  font-size: 10;
  margin: 0;
  padding: 0;
}

    .img-principal {
        position: absolute;
        margin: 10px;

    }

    .primer-bloque{
        position: relative;
        top: 15px;
        text-align: center;
        font-size: 15px;
    }

    .titulo{
       
        margin-bottom: 10px;
        margin-left:180px ;
        margin-right:300px ;
    }
    .titulocom{
        font-size: 18px;
    }

   /*  div>span{
        text-align: center;
        position: relative;
        bottom: 20px;
        font-size: 12px;
    } */
    .text{
        margin-left: 150px;
        margin-right: 380px;
        font-size: 12px;
    }
    .fechas {
        font-weight: bolder;
        position: absolute;
        top: 1px;
        right: 13px;
    }

    .Nro-de-comprobante {
        border: 2px solid black;
        margin-bottom: 10px;
        padding: 5px;
    }

    .fechas-fiscales {
        border: 2px solid black;
        position: absolute;
        left: 80%;
        bottom: 89%;
        font-weight: bold;
    }

    .Fec-emisión{
        padding-left: 25px;
    }
    .Per-fiscal{
        border: 2px solid black;
        position: absolute;
        left: 85%;
        bottom: 85%;
        font-weight: bold;
    }

    .numero {
        padding-top: 5px;
    }
    .Segundo-bloque {
        border: 2px inset black;
        position: relative;
        margin-top: 20px;
        margin-bottom: 5px;
        margin-left: 8px;
        margin-right: 8px;
    }

    .Nombre-agente,
    .direc-agente,
    .Nombre-sujeto,
    .direc-sujeto {
        padding: 6px 5px 6px 5px;
        text-align: left;
        
    }
    .registro-agente {
        position: absolute;
        top: 0px;
        margin-left: 620px;
        padding: 5px;
        text-align: right;

    }

    #Nom-agente,
    #direccion,
    #Nom-sujetc,
    #direccion-sujetc {
        width: 450px;
    }

    #registro {
        text-align: center;
        width: 532px;
    }
    .Tercer-bloque{
        border: 2px inset black;
        position: relative;
        margin-top: 5px;
        margin-bottom: 5px;
        margin-left: 8px;
        margin-right: 8px;
    }

    .registro-sujeto{
        position: absolute;
        top: 0px;
        right: 0px;
        padding: 5px;
        text-align: right;
    }

    #registro-sujetc {
        text-align: center;
        width: 490px;
    }

    .tabla{
        font-size: 1%;
        margin-top: 25px;
        margin-right: 10px ;
        margin-left: 20px;
    }

    table{
        margin-top:30px;
    }
    .borde-superior{
        text-align: center;
        font-size: 12px;
    }
    .borde-inferior{
        text-align: center;
        font-size: 12px;
        margin: 0;
    }


    th {
        border-bottom: 2px solid black;
    }
    .pie-pagina {
    position: absolute;
    bottom: 10%;
    left: 5px;
    right: 5px;
    width: 100%;
    padding: 10px;
    
    overflow: hidden; /* Limpiar el float */

    }

    .sujeto20{
        position: relative;
        left: 66%;
        top: 9px;
        bottom: 20px;
        border: 2px solid black;
    }

    .Fecha-retencion{
        position: relative;
        left: 40%;
        right: 10px;
        top: 11%;
        border: 2px solid black;
    }

    .agente{
        position: relative;
        top: 161px;
        margin-right: 60%;
        border: 2px solid black;

    }
    .div-agente{
        margin-left: 15px;
        padding-bottom: 20px;

    }
    .text-agente{
        margin-left: 15px;
        padding-bottom: 20px;

    }

    .div-fecha{
        margin-left: 85px;
        padding-bottom: 20px;

    }
    .text-fecha{
        margin-left: 95px;
        padding-bottom: 20px;
        

    }

    .div-sujeto{
        margin-left: 15px;
        padding-bottom: 20px;
    }
    .text-sujeto{
        margin-left: 15px;
        padding-bottom: 20px;

    }




    
    @page {
            size: landscape;
        }
    </style>
    <title>Document</title>
</head>
<body>
        <div class="img-principal">
            <img src="data:image/png;base64,{{$image}}" height="120px" width="120px">
        </div>
    
    <div class="primer-bloque">
        <div class="border-principal">
            <div class="titulo">
                <h2 class="titulocom"><b>COMPROBANTE DE RETENCION DE IMPUESTO AL VALOR AGREGADO</b></h2>
                <span><b>Decreto con Rango, Valor y Fuerza de Ley de Reforma de Ley del Impuesto al Valor Agregado N° 1436 del 17 de noviembre de 2014</b></span>
            </div> 
            <div class="text">
                Ley IVA - Art.11: "La administración Tributaria podrá designar como responsables del pago del impuesto, en calidad de
                agentes de retencion a quienes por sus funciones públicas o por razón de sus actidades privadas intervengan en
                operaciones gravadas con el impuesto establecido en este Decreto con Rango, Valor y Fuerza de Ley")
            </div>
        </div>
        <div class="fechas">
            <div class="Nro-de-comprobante">
                <p>Nro de comprobante: </p>
                <p class="numero"> {{$retention->ncomprobante}}</p>
            </div> 
        </div>
        <div class="fechas-fiscales">
            <div class="Fec-emisión">
                <p>Fecha de Emision:     {{$retention->fecemi}}</p>
            </div>
        </div>
            <div class="Per-fiscal">
                <p>Periodo Fiscal:      {{$year}}</p>
            </div>
        
    </div>  

    <div class="Segundo-bloque">
        <div class="Nombre-agente">
            <label for="Nom-agente">
              <b>NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN:</b> 
            </label> <br>
            <p>FIX4U Solutions C.A</p>
       </div>
       
       <div class="direc-agente">
            <label for="direccion">
                <b>DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN:</b>
            </label><br>
            <p>Edifcio Primo Centro, Avenida Libertador, San Cristóbal 5001, Táchira</p>
       </div>
       
       <div class="registro-agente">
            <label for="registro">
                <b>REGISTRO DE INFORMACION FISCAL DEL AGENTE DE RETENCIÓN:</b>
            </label>
            <p>J-40918564-8</p>
       </div>
    </div>  

    <div class="Tercer-bloque">
        <div class="Nombre-sujeto">
            <label for="Nom-sujetc">
              <b>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO:</b> 
            </label> <br>
            <p>{{$suject->nombre}}</p>
       </div>
       
       <div class="direc-sujeto">
            <label for="direccion-sujeto">
                <b>DIRECCIÓN FISCAL DEL SUJETO RETENIDO:</b>
            </label><br>
            <p>{{$suject->direccion}}</p>
       </div>
       
       <div class="registro-sujeto">
            <label for="registro-sujetc">
                <b>REGISTRO DE INFORMACION FISCAL DEL SUJETO RETENIDO:</b>
            </label><br>
            @if ($suject->tiprif != null)
                <p>{{$suject->tipid}}-{{$suject->identificacion}}-{{$suject->tiprif}} </p>
            @else
                <p>{{$suject->tipid}}-{{$suject->identificacion}}</p>
            @endif

           
       </div>
    </div> 
    <div class="tabla">
        <table>
            <thead>
                <tr class="borde-superior">
                    <th>Oper Nro</th>
                    <th>Fecha de la Factura</th>
                    <th>Numero de Factura</th>
                    <th>Numero de Control</th>
                    <th>Tipo Trans</th>
                    <th>Total de Compras Incluyendo inpuesto</th>
                    <th>Compras sin derecho a Crédito Fiscal</th>
                    <th>Base Imponible</th>
                    <th>Cuota</th>
                    <th>Impuesto</th>
                    <th>Impuesto Retenido</th>
                </tr>

                <tr class="borde-inferior">
                    <td>{{$retention->idrein}}</td>
                    <td>{{$detRetention->fecemifact}}</td>
                    <td>{{$detRetention->numfact}}</td>
                    <td>{{$detRetention->numctrl}}</td>
                    <td></td>
                    <td>{{$detRetention->totalfact}}</td>
                    <td>0,00</td>
                    <td>{{$detRetention->baseimponible}}</td>
                    <td>16</td>
                    <td>{{$detRetention->montoimpuesto}}</td>
                    <td>{{$detRetention->impuestoretenido}}</td>
                </tr>
        </thead>
        </table>
    </div>
    <div class="pie-pagina">
        <div class="agente">
            <p class="div-agente"><b>Agente de retención:</b></p>
            <p class="text-agente">FIX4U Solutions C.A  J-40918564-8</p>
        </div>
        <div class="Fecha-retencion">
           <p class="div-fecha"><b>Fecha recepción:</b></p>
           <p class="text-fecha">{{$retention->fecrecep}}</p>

        </div>
        <div class="sujeto20">
            <p class="div-sujeto"><b>Sujeto retenido:</b></p>
            @if ($suject->tiprif != null)
                <p class="text-sujeto">{{$suject->nombre}}  {{$suject->tipid}}-{{$suject->identificacion}}-{{$suject->tiprif}} </p>
            @else
                <p class="text-sujeto">{{$suject->nombre}}  {{$suject->tipid}}-{{$suject->identificacion}}</p>
            @endif

        </div>
    </div>
</body>
</html>