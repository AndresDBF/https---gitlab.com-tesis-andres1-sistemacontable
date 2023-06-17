<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="{{asset('css/retention/style.css')}}">
    <title>Comprobante de Retencion</title>
</head>
<body>
        <div class="img-principal">
            <img src="{{asset('icons/principal.img.jfif')}}" width="160px" height="130px">
        </div>
    
    <div class="primer-bloque">
        <div class="border-principal">
            <div class="titulo">
                <h2><b>COMPROBANTE DE RETENCION DE IMPUESTO AL VALOR AGREGADO</b></h2>
                <span><b>Decreto con Rango, Valor y Fuerza de Ley de Reforma de Ley del Impuesto al Valor Agregado N° 1436 del 17 de noviembre de 2014</b></span>
            </div> 
                    <div class="text">
                        Ley IVA - Art.11: "La administración Tributaria podrá designar como responsables del pago del impuesto, en calidad de
                        agentes de retencion a quienes por sus funciones públicas o por razón de sus actidades privadas intervengan en
                        operaciones gravadas con el impuesto establecido en este Decreto con Rango, Valor y Fuerza de Ley")
                    </div>
            <div class="label">
                <div class="Nro-de-comprobante">
                    <label for="Nro-de-comprobante">Nro de comprobante:</label>
                    <input id="Nro-de-comprobante">
                </div>
                    
                <div class="Fec-emisión">
                    <label for="Fec-emisión">Fecha de emisión:</label>
                    <input id="Fec-emisión">
                </div>
                    
                <div class="Per-fiscal">
                    <label for="Per-fiscal">Periodo fiscal:</label>
                    <input id="Per-fiscal" type="text"> 
                </div>
            </div>   
        </div>
    </div>  

    <div class="Segundo-bloque">
        <div class="Nombre-agente">
            <label for="Nom-agente">
              <b>NOMBRE O RAZÓN SOCIAL DEL AGENTE DE RETENCIÓN:</b> 
            </label> <br>
            <input id="Nom-agente">
       </div>
       
       <div class="direc-agente">
            <label for="direccion">
                <b>DIRECCIÓN FISCAL DEL AGENTE DE RETENCIÓN:</b>
            </label><br>
            <input id="direccion">
       </div>
       
       <div class="registro-agente">
            <label for="registro">
                <b>REGISTRO DE INFORMACION FISCAL DEL AGENTE DE RETENCIÓN:</b>
            </label>
            <input id="registro" > 
       </div>
    </div>  

    <div class="Tercer-bloque">
        <div class="Nombre-sujeto">
            <label for="Nom-sujetc">
              <b>NOMBRE O RAZÓN SOCIAL DEL SUJETO RETENIDO:</b> 
            </label> <br>
            <input id="Nom-sujetc">
       </div>
       
       <div class="direc-sujeto">
            <label for="direccion-sujeto">
                <b>DIRECCIÓN FISCAL DEL SUJETO RETENIDO:</b>
            </label><br>
            <input id="direccion-sujetc">
       </div>
       
       <div class="registro-sujeto">
            <label for="registro-sujetc">
                <b>REGISTRO DE INFORMACION FISCAL DEL SUJETO RETENIDO:</b>
            </label><br>
           <input id="registro-sujetc" > 
       </div>
   </div> 
    <div class="tabla">
   <table>
        <thead>
                <tr class="borde-inferior">
                    <th>Oper Nro</th>
                    <th>Fecha de la Factura</th>
                    <th>Numero de Factura</th>
                    <th>Numero de Control</th>
                    <th>Numero de Nota de Débito</th>
                    <th>Nuemero de Nota de Crédito</th>
                    <th>Tipo Trans</th>
                    <th>Numero de factura afectada</th>
                    <th>Total de Compras Incluyendo inpuesto</th>
                    <th>Compras sin derecho a Crédito Fiscal</th>
                    <th>Base Imponible</th>
                    <th>Cuota</th>
                    <th>Impuesto</th>
                    <th>Impuesto Retenido</th>
                </tr>

                <tr>
                    <td>1</td>
                    <td>12/06/2012</td>
                    <td>0002359</td>
                    <td>N/A</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>01</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>55,57</td>
                </tr>
        </thead>
   </table>
    </div>
    <div class="pie-pagina">
        <div class="agente"><b>Agente de retención:</b></div>
        <div class="Fecha-retencion"><b>Fecha recepción:</b></div>
        <div class="sujeto20"><b>Sujeto retenido:</b></div>
    </div>
</body>
</html>