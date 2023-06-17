
    // Obtener referencias a los elementos HTML
    const baseInput = document.getElementById('base');
    const ivaInput = document.getElementById('iva');
    const totalTaxesInput = document.getElementById('totaltaxes');
    const taxesInput = document.getElementById('taxes');
    const taxesRetenInput = document.getElementById('taxesreten');

    // Agregar un evento de escucha para actualizar los cálculos
    baseInput.addEventListener('input', calculateTotals);
    ivaInput.addEventListener('input', calculateTotals);

    function calculateTotals() {
        // Obtener los valores de base e iva
        const baseValue = parseFloat(baseInput.value) || 0;
        const ivaValue = parseFloat(ivaInput.value / 100) || 0;


        // Calcular el total de compras incluyendo impuestos
        const totalTaxesValue = baseValue + (baseValue * ivaValue);

        // Calcular el impuesto y el impuesto retenido
        const taxesValue = (baseValue * ivaValue);
        const taxesRetenValue = (baseValue * ivaValue) * 0.75;

        // Actualizar los valores en los elementos HTML
        totalTaxesInput.value = totalTaxesValue.toFixed(2);
        taxesInput.value = taxesValue.toFixed(2);
        taxesRetenInput.value = taxesRetenValue.toFixed(2);
    }
