document.getElementById('money-select').addEventListener('change', function() {
    var selectedOption = this.value;
    if (selectedOption !== 'BS') {
        var tasaCambio = prompt('Ingrese la tasa de cambio:');
        document.querySelector('input[name="tasa_cambio"]').value = tasaCambio;
    }
});