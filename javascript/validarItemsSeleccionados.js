function validarItemsSeleccionados(){    
    if (
        $("#programa").val() == "" || $("#programa").val() == null ||
        $("#lote").val() == "" || $("#lote").val() == null ||
        $("#mes").val() == "" || $("#mes").val() == null
    ) {
        return true;  // Devolver verdadero para generar una alerta
    } else {
        return false;
    }
}