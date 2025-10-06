function eventoAsignarFloat(table_trGestion){

    let inputs_float = table_trGestion.find(".input_float");

    inputs_float.change(function () {
            
        var valor = $(this).val();
        valor = valor.replace(/,/g, '.'); // Reemplazar todas las comas por puntos
                    
        if(valor == ""){
            $(this).val("");
        } else {
            var entrada = parseFloat(valor);
            var float = entrada.toFixed(3);
            $(this).val(float);
        }
    });
}