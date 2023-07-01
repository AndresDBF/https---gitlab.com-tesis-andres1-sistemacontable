<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nomina</title>
    <style>
      *{
        margin-bottom: 0;
         font-size: 11px;
      }
body{
    margin: 0px;
    font-family: Arial, Helvetica, sans-serif;
}

.margen{
    border: 4px solid black ;
    margin: 0px 0px 0px 0px;
}

.encabezado{
    text-align: center;
    margin-bottom: 30px;

}

.datos {
    margin-left: 50px;
    margin-bottom: 10PX;
   

}

.datos1{
    margin-top: 20px ;
    margin-bottom:20px  ;
}

input{
    border: none;
    border-bottom: 1px solid black ;
   
    width: 120px;
    
}

.empleado{
    text-align: center;
}


.sueldo {
    margin-left: 50px;
    margin-bottom: 10PX;
   

}

.sueldo1{
    margin-top: 20px ;
    margin-bottom:20px  ;
}

.flotador{
    position: absolute;

    right: 30px;
    top: 170px;
    border: 2px solid black ;
}
.a1{
    margin-left: 1px;
}
.a2{
    margin-left: 39px;
}

.a3{
    margin-left:32px ;
}

.a4{
    margin-left:39px ;
}

table {
    border-collapse: collapse;
    margin-top: 5px;
    margin-bottom: 10px;
  }
  table td, th {
    border: 2px solid black;
    padding: 10px;
  }

.final{
    margin-bottom: 30px;
    margin-left: 10px;
    font-size: 20px;
    
}
.recibo{
    padding-bottom: 10px
}
.cedula-recibo{
    padding-top: 12px;
}
.f1{
    margin-top: 10px;
    margin-right: 100px;
}
    </style>
</head>
<body>
     <div class="margen">
        <div class="encabezado">
            <p>FIX4U C.A <br>
            RIF J-409185648 <br>
            RECIBO PAGO NOMINA <br>
            Periodo de Pago del {{$primerDia}} al {{$ultimoDia}}</p>
        </div>
    
            <div class="datos">
               <label for="Empleado">Empleado:</label>
               <input type="text" name="Empleado" value="{{$employee->nombre}}" size="45">
               <label for="Cedula">Nº De Cedula:</label>
               <input type="text" name="Cedula" value="{{$employee->tipid}}-{{$employee->identificacion}}" size="20">
               <label for="fechaingreso">Fecha de Ingreso:</label>
               <input type="text" name="fechaingreso" value="{{$employee->fec_ingr}}" size="20">
                <div class="datos1">
                     <label for="Cargo">Cargo:</label>
                     <input type="text" name="Cargo" value="{{$tipcarg->concepto_cargo}}" size="50">                    
                </div>
            </div>
            
            <div class="sueldo">
                <label for="sueldom">Sueldo Mensual:</label>
                <input type="text" name="sueldom" value="Bs. {{$salary->montopago}}" size="20">
                <label for="sueldod">Sueldo Diario:</label>
                <input type="text" name="sueldod" value="Bs. {{$salaryph}}" size="20">
                 <div class="sueldo1">
                      <label for="Incentivo">Incentivo por puntualidad</label>
                      <input type="text" name="Incentivo" value="0" size="20">
                 </div>
                 <div>
                      <label for="Incentivo2">Incentivo por asistencia</label>
                      <input type="text" name="Incentivo2" value="0" size="20">                       
                 </div>
             </div>
             <div class="flotador">
                  <div>
                     <label for="valor">Valor Hora:</label>
                     <input type="text" name="valor" style="padding-top: 20px;" value="Bs. {{$salaryph}}" size="10" class="a1">
                  </div>
                  <div>
                     <label for="HED">H.E.D</label>
                     <input type="text" name="HED" value="Bs. {{$valueHED->montopago}}" size="10" class="a2">
                  </div>
                  <div>
                     <label for="feriada">feriada</label>
                     <input type="text" name="feriada" value="Bs. {{$valueFer->montopago}}" size="10" class="a3">
                  </div>
                  <div>
                     <label for="HEN">H.E.N</label>
                     <input type="text" name="HEN" value="Bs. {{$valueHEN->montopago}}" size="10" class="a4">
                  </div>          
            </div>

            <div>
               <table align="center">
                  <thead>
                        <tr>
                           <th>CONCEPTO</th>
                           <th>Cantidad</th>
                           <th>Asigancion</th>
                           <th>Deduccion</th>
                           <th></th>  
                        </tr>
                        <tr>
                            <td>Sueldo Quincenal</td>
                            <td>{{$dayst}}</td>
                            <td>Bs. {{$salary->montopago}}</td>
                            <td></td>
                            <td></td>                           
                        </tr>
                        <tr>
                           <td>Incentivo por puntualidad</td>
                           <td>0%</td>
                           <td>Bs.0.00</td>
                           <td></td>
                           <td></td>                           
                       </tr>
                       <tr>
                           <td>Incentivo por asistencia</td>
                           <td>0%</td>
                           <td>Bs. 0.00</td>
                           <td></td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>Feriado o domingo Laborado Art.120 LOTTT</td>
                           <td>{{$valueFer->diast}}</td>
                           <td>Bs. {{$valueFer->montopago}}</td>
                           <td></td>
                           <td></td>                           
                       </tr>
                        <tr>
                           <td>Horas Extras diurnas 118 LOTTT</td>
                           <td>{{$valueHED->diast}}</td>
                           <td>Bs. {{$valueHED->montopago}}</td>
                           <td></td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>Horas Extras nocturnas 118 LOTTT</td>
                           <td>{{$valueHEN->diast}}</td>
                           <td>Bs. {{$valueHEN->montopago}}</td>
                           <td></td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>Bobo Alimentacion Cestaticket</td>
                           <td>{{$valueCest->diast}}</td>
                           <td>Bs. {{$valueCest->montopago}}</td>
                           <td></td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>Bono Nocturno</td>
                           <td>0</td>
                           <td>Bs. 0.00</td>
                           <td></td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>Otras Asignaciones</td>
                           <td>0</td>
                           <td>Bs. 0.00</td>
                           <td></td>
                           <td></td>                           
                        </tr>
                           <tr>
                           <th align="left">TOTAL ASIGNACION</th>
                           <td></td>
                           <td>Bs. {{$totalpay->totalasignacion}}</td>
                           <td></td>
                           <td></td>                           
                        </tr>
                           <tr>
                           <td>S.S.O Y PARO FORZOSO</td>
                           <td>4.5%</td>
                           <td></td>
                           <td>Bs. 9.55</td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>FAOV</td>
                           <td>1.0%</td>
                           <td></td>
                           <td>Bs. 1.15</td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>ISRL RETENIDO</td>
                           <td>0%</td>
                           <td></td>
                           <td>Bs. 0.00</td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>Dias no laborados</td>
                           <td>{{$daysNT}}</td>
                           <td></td>
                           <td>Bs. {{$restDays}}</td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <td>Otros Descuentos</td>
                           <td></td>
                           <td></td>
                           <td>0.00</td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <th align="left">TOTAL DEDUCCION</th>
                           <td></td>
                           <td></td>
                           <td>Bs. {{$totalpay->totaldeduccion}}</td>
                           <td></td>                           
                        </tr>
                        <tr>
                           <th align="left">NETO COBRAR</th>
                           <td></td>
                           <td></td>
                           <td></td>
                           <td>Bs. {{$totalpay->netocobrar}}</td>                           
                        </tr>

                  </thead> 
               </table>

            </div>
            <div class="final">
             <p class="recibo">Recibi Conforme</p>
                  <div class="nombre-recibo">
                     <label for="nombre">Nombre y apellido :</label>
                     <input type="text" name="nombre" size="45">
                  </div>
                  <div class="cedula-recibo">
                     <label for="cedula">Cedula:</label>
                     <input type="text" name="cedula" size="20" class="f1">
                  </div>
            </div>  
    </div>    
</body>
</html>