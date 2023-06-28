<!DOCTYPE html>
<html>
<head>
    <style>
     /*    .borde-interno {
        background-color: rgb(242, 242, 242);
        border: 5px inset black ;
        padding: 20px;
        border-radius: 8px;
    } */
        

    .logo {
        position:absolute;
        margin: 30px;
        /* border-right: 6px solid rgb(54, 54, 54);
        border-bottom: 5px solid rgb(54, 54, 54); */
    }

    .primer-bloque {
        font-weight: bold;
        font-size: 22px;
        position:relative;
        top: 30px;
        left: 65%;
        
        
    }

    .recibo-pago {
        font-size: 30px;
        padding-top: 15px;
        text-align: center;
    }

    .border-superior {
        border-bottom: 8px inset rgb(186, 186, 186);
    }

    .todo-form {
        font-size: 25px;
        position: relative;
        margin: 60px;
        font-weight: bold;
    }

    div input {
        font-size: 22px;
        background-color: transparent;
        border:transparent;
        margin-top: 20px;
        margin-bottom: 20px;
        width: 20%;
        padding: 8px;
    }

    #Descripcion {
        margin-left: 20px;
        border: transparent;
        border-bottom: 3px inset black;
        font-size: 40px;
    }

    #metod-pago {
        margin-left: 90px;
        border: transparent;
        border-bottom: 3px inset black;
        font-size: 40px;
    }

    #vendedor {
        margin-left: 150px;
        border: transparent;
        border-bottom: 3px inset black;
        font-size: 40px;
        text-decoration: 
    
    }

    label {
        font-size: 22px;
        font-weight: bold;
    }
    @page {
        size: landscape;
    }
    </style>
    <title>Recibo de Pago</title>
</head>
<body>
   <div class="borde-interno">
        <div>
            <div class="logo">
            <img src="data:image/png;base64,{{$image}}" height="130px" width="130px">  
            </div>
                <div class="primer-bloque">
                    <p>Fecha de Transaccion: {{$detProofIncome->fec_trans}}</p>
                    <p>Numero de Recibo: {{$proofIncome->numconfirm}}</p>
                    <p>Cantidad: {{$proofIncome->mtolocal}} BS</p>
                </div>
        </div>

        <div class="recibo-pago">
            <h2>Recibo De Pago</h2>
        </div>
        <div class="border-superior"></div>

        <div class="todo-form">
                <div>
                    <p class="Descripcion"> Descripcion de Compra: {{$detProofIncome->descripcion}}</p>
                </div>
                <div>
                    @if ($detProofIncome->formpago == 'EFE')
                        <p class="metod-pago">Metodo de Pago: EFECTIVO</p> 
                    @elseif ($detProofIncome->formpago == 'TRA')
                        <p class="metod-pago">Metodo de Pago: TRANSFERENCIA BANCARIA </p>
                    @elseif ($detProofIncome->formpago == 'PMO')
                        <p class="metod-pago">Metodo de Pago: PAGO MOVIL</p>
                    @elseif ($detProofIncome->formpago == 'TDE')
                        <p class="metod-pago">Metodo de Pago: TARJETA DE DEBITO</p>
                    @else 
                        <p class="metod-pago">Metodo de Pago: TARJETA DE CREDITO</p>
                    @endif
                    
                </div>
                <div>
                    <p class="vendedor"> Cliente: {{$detProofIncome->nombre_cliente}}</p>
                </div>
        </div>
            

    </div>
</body>
</html>