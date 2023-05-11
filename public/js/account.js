// Obtener los elementos select y input
var subaccount_tipsubcta1 = document.getElementById("subaccount_tipsubcta1");
var subaccount_descripcion1 = document.getElementById("subaccount_descripcion1");
var subaccount_tipsubcta2 = document.getElementById("subaccount_tipsubcta2");
var subaccount_descripcion2 = document.getElementById("subaccount_descripcion2");
var account1 = document.getElementById("account1");
var account1 = document.getElementById("account1");
var nameaccount2 = document.getElementById("nameaccount2");
var nameaccount2 = document.getElementById("nameaccount2");


// Agregar eventos "change" a los select
subaccount_tipsubcta1.addEventListener("change", updateInputs);
subaccount_descripcion1.addEventListener("change", updateInputs);

function updateInputs() {
    // Obtener los valores seleccionados en los select
    var subaccount_tipsubcta1Value = subaccount_tipsubcta1.value;
    var subaccount_descripcion1Value = subaccount_descripcion1.value;
    var subaccount_tipsubcta2Value = subaccount_tipsubcta2.value;
    var subaccount_descripcion2Value = subaccount_descripcion2.value;

    // Asignar los valores a los inputs correspondientes
    account1.value = subaccount_tipsubcta1Value;
    nameaccount1.value = subaccount_descripcion1Value;
    account2.value = subaccount_tipsubcta2Value;
    nameaccount2.value = subaccount_descripcion2Value;
}