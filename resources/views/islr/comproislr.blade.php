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
        font-size: 25px;
        margin-top: 25px;
        margin-right: 0px;
        margin-left: 90px;
    }

    table{
        margin-top:30px;
    }
    .borde-superior{
        text-align: center;
        padding: 10px;
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
        left: 0;
        width: 100%;
        padding: 10px;
        margin-left: 45px;
        overflow: hidden; 
    }

    .agente {
        display: inline-block;
        width: 40%;
    }

    .agente {
        text-align: center;
    }

    .sujeto20 {
        position: relative;
        left: 48%;
        bottom: 3%;
        width: 40%;
        text-align: center;
    }

/* .div-agente,
.div-sujeto {
  margin: 0;
}


.pie-pagina::before,
.pie-pagina::after {
  content: "";
  display: table;
  clear: both;
} */
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
                <h2 class="titulocom"><b>COMPROBANTE DE RETENCION DE IMPUESTO SOBRE LA RENTA</b></h2>
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
                <p>Nro de comprobante:</p>
                <p class="numero">{{$retenislr->ncomprobante}}</p>
            </div> 
        </div>
        <div class="fechas-fiscales">
            <div class="Fec-emisión">
                <p>Fecha de Emision:     {{$retenislr->fecemi}}</p>
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
            <p>{{$supplier->nombre}}</p>
       </div>
       
       <div class="direc-sujeto">
            <label for="direccion-sujeto">
                <b>DIRECCIÓN FISCAL DEL SUJETO RETENIDO:</b>
            </label><br>
            <p>{{$supplier->direccion}}</p>
       </div>
       
       <div class="registro-sujeto">
            <label for="registro-sujetc">
                <b>REGISTRO DE INFORMACION FISCAL DEL SUJETO RETENIDO:</b>
            </label><br>
            @if ($supplier->tiprif != null)
                <p>{{$supplier->tipid}}-{{$supplier->identificacion}}-{{$supplier->tiprif}}</p>
            @else
                <p>{{$supplier->tipid}}-{{$supplier->identificacion}}</p> 
            @endif
       </div>
    </div> 
    <div class="tabla">
        <table>
            <thead>
                <tr class="borde-superior">
                    <th>Oper Nro</th>
                    <th>Fecha Doc. Relacionado</th>
                    <th>Número Doc. Relacionado</th>
                    <th>Número de Control</th>
                    <th>Concepto Descripción</th>
                    <th>Monto Base</th>
                    <th>Sustraendo</th>
                    <th>% Retención</th>
                    <th>Monto Retenido</th>
                </tr>

                <tr class="borde-inferior">
                    <td>{{$retenislr->idrein}}</td>
                    <td>{{$detRetenislr->fecemifact}}</td>
                    <td>{{$detRetenislr->numfact}}</td>
                    <td>{{$detRetenislr->numctrl}}</td>
                    <td>{{$detRetenislr->concepto}}</td>
                    <td>{{$detRetenislr->baseimponible}}</td>
                    <td>{{$detRetenislr->sustraendo}}</td>
                    <td>{{$detRetenislr->porcentajeret}}</td>
                    <td>{{$detRetenislr->montoretenido}}</td>
                </tr>
        </thead>
        </table>
    </div>
    <div class="pie-pagina">
        <div class="agente">
            <hr>
            <p class="div-agente"><b>Agente de retención:</b></p>
        </div>
        <div class="sujeto20">
            <hr>
            <p class="text-sujeto">{{$supplier->nombre}}</p>
            @if ($supplier->tiprif != null)
                <p>{{$supplier->tipid}}{{$supplier->identificacion}}-{{$supplier->tiprif}}</p>
            @else
                <p>{{$supplier->tipid}}{{$supplier->identificacion}}</p> 
            @endif
            <p class="div-sujeto"><b>Sujeto retenido:</b></p>
        </div>
    </div>
</body>
</html>