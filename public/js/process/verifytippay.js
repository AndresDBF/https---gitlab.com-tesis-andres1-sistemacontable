document.getElementById('money-select').addEventListener('change', function() {
    var selectedOption = this.value;
    if (selectedOption !== 'BS') {
        var tasaCambio = prompt('Ingrese la tasa de cambio:');
        document.querySelector('input[name="tasa_cambio"]').value = tasaCambio;
    }
});

document.getElementById('reten').addEventListener('change', function() {
    var selectedOption = this.value;
    if (selectedOption == 'S') {
        var contribuyente = prompt('Ingrese el Porcentaje de Retención del proveedor');
        document.querySelector('input[name="porcreten"]').value = contribuyente;
    }
});

$(document).ready(function() {
        
    $("#horasdiurnas").hide();

    
    $("select[name='indhed']").change(function() {
       if ($(this).val() == "S") {
          
          $("#div-off").show();
       } else {
         
          $("#div-off").hide();
       }
    });
 });

 $(document).ready(function() {
        
    $("#diasferiados").hide();

    
    $("select[name='indfes']").change(function() {
       if ($(this).val() == "S") {
          
          $("#div-off").show();
       } else {
         
          $("#div-off").hide();
       }
    });
 });

 $(document).ready(function() {
        
    $("#horasnocturnas").hide();

    
    $("select[name='indhec']").change(function() {
       if ($(this).val() == "S") {
          
          $("#div-off").show();
       } else {
         
          $("#div-off").hide();
       }
    });
 });