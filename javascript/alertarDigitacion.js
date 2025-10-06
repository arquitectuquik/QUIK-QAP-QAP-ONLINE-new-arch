function alertarDigitacion(elementEvent){
    
    if(tipoProgramaCualitativo(elementEvent)){ // Si es cualitativo
        
    } else { // Si es cuantitativo
        
        let filasGestionValid = $("#cont-tabla-gestiones tbody tr");
        
        // Eliminar todos los campos resaltados
        $(".resaltado_alerta_input").removeClass("resaltado_alerta_input");
        $(".resaltado_error_input").removeClass("resaltado_error_input");

        // Recorrer todos los campos y guardarlos en una variable
        let consolidado_inputs = $(""); // Objeto jQuery vacío

        for(x=0; x<filasGestionValid.length; x++){

            let trActual = filasGestionValid.eq(x);

            // Si el CV mensual supera el 10%
            if(trActual.find(".cv_mensual").val() != "" && parseFloat(trActual.find(".cv_mensual").val()) > 10){
                consolidado_inputs = consolidado_inputs.add(trActual.find(".cv_mensual"));
            }

            // Si el CV acumulado supera el 10%
            if(trActual.find(".cv_acumulada").val() != "" && parseFloat(trActual.find(".cv_acumulada").val()) > 10){
                consolidado_inputs = consolidado_inputs.add(trActual.find(".cv_acumulada"));
            }

            // Si el CV del inserto supera el 10%
            if(trActual.find(".cv_inserto").val() != "" && parseFloat(trActual.find(".cv_inserto").val()) > 10){
                consolidado_inputs = consolidado_inputs.add(trActual.find(".cv_inserto"));
            }


            // Si el #P mensual en menor a 10
            if(trActual.find(".npuntos_mensual").val() != "" && parseInt(trActual.find(".npuntos_mensual").val()) < 10){
                consolidado_inputs = consolidado_inputs.add(trActual.find(".npuntos_mensual"));
            }

            // Si el #P acumulado en menor a 10
            if(trActual.find(".npuntos_acumulada").val() != "" && parseInt(trActual.find(".npuntos_acumulada").val()) < 10){
                consolidado_inputs = consolidado_inputs.add(trActual.find(".npuntos_acumulada"));
            }
        }

        // Verificar si se paso la validacion
        if(consolidado_inputs.length > 0){ // Existen campos por validar
            consolidado_inputs.addClass("resaltado_alerta_input");
            return false;
        }

        return true;

    }
}