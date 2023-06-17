
    // Obtener referencias a los elementos HTML
    var baseInput = document.getElementById('base');
    var retenInput = document.getElementById('reten');
    var sustraInput = document.getElementById('sustra');
    var taxesRetenInput = document.getElementById('taxesreten');

    // Agregar un evento de escucha para actualizar los cálculos
    baseInput.addEventListener('input', calculateTotals);
    retenInput.addEventListener('input', calculateTotals);
    sustraInput.addEventListener('input', calculateTotals);
    

    function calculateTotals() {
        // Obtener los valores de base e iva
        var baseValue = parseFloat(baseInput.value) || 0;
        var retenValue = parseFloat(retenInput.value / 100) || 0;
        var sustraValue = parseFloat(sustraInput.value) || 0;


        //calcula el impuesto retenido
        var taxesRetenValue = (baseValue * retenValue) - sustraValue;
        // Actualizar los valores en los elementos HTML
        taxesRetenInput.value = taxesRetenValue.toFixed(2);
    }
