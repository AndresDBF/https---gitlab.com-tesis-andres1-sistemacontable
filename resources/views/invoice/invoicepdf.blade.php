<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="factura.css">
    <title>Factura</title>
</head>
<body>
      <div class="border">
            <h1 id="title">
                <img id="img" src="../Trabajos en HTML/Imagenes/principal.img.jfif" height="100px" width="120px">
                Nombre de la Empresa
            </h1>
             <div>
                <div class="control"><p>N-control</p></div>
            </div>
            <div class="nom-empresa">
                <div class="direccion"><p>Direccion</p></div>
                <div class="telefono"><p>Telefono</p></div>
                <div class="correo"><p>Correo</p></div>
            </div>
     </div>
     <h3 class="datos">Factura</h3>
        <br>
     <div class="derecho">
       <p>Nro.:</p> 
       <p>Fecha:</p>
     </div>   
     <div class="formulario">
        <form >
            <label>Nombre y apellido o Razón social:</label>
                <input class="nombre" name="nombre">
        <br>    
            <label>C.I./RIF o pasaporte:</label>
                <input class="cedula" name="cedula">
        <br>
            <label>Oficina de Cobranza:</label>
                <input class="oficina" name="oficina">
        <br>
            <label>Intermediario:</label>
                <input class="inter" name="inter">
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
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    
                </tr>
            </tbody>
        </table>
     </div>
     <div class="borde-total"> 
        <form >
            <label>Base imponible</label>
                <input id="base" name="base">
    <br>
            <label>IVA(16.00%)</label>
                <input id="IVA" name="IVA">
    <br>
            <label><b>Total</b></label>
                <input id="total" name="total">
    <br>
        </form>
     </div>
     <div class="formas">
        <div class="los-input">
            <label>Forma de pago:</label>
                <input id="form-pago">
            <label>Caja:</label>
                <input id="caja">
            <label>Cajero:</label>
                <input id="cajero">
                <label>Relación de Ingreso:</label>
            <input id="relining">    
        </div>
     </div> 
</body>
</html>