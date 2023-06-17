document.getElementById('reten').addEventListener('change', function() {
    var selectedOption = this.value;
    if (selectedOption == 'S') {
        var contribuyente = prompt('Ingrese el Porcentaje de Retención del proveedor');
        document.querySelector('input[name="porcreten"]').value = contribuyente;
    }
});