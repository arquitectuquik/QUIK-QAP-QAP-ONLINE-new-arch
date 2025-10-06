function validarDigitacion(elementEvent){
    if(tipoProgramaCualitativo(elementEvent)){ // Si es cualitativo
        let filasGestionValid = $("#cont-tabla-gestiones tbody tr");
        let datos_digitacion = [];
        
        for(x=0; x<filasGestionValid.length; x++){
            
            let trActual = filasGestionValid.eq(x);            
            if(trActual.find(".id_configuracion").val() == "" || trActual.find(".id_configuracion").val() == undefined){
                statusBox('warning','NULL','Debe especificar el analito','add','3000');
                resaltarCampoDigitacion(trActual.find(".id_configuracion"));
                return false;
            }
            let checkboxesValoresVerdaderos = trActual.find(".valores_verdaderos input[type='checkbox']");
            if(checkboxesValoresVerdaderos.length > 0){
                let seleccionados = checkboxesValoresVerdaderos.filter(":checked");
                // let resultadosVerdaderosSeleccionados = trActual.find(".valores_verdaderos input[type='checkbox']:checked")
                if(seleccionados.length == 0){
                    statusBox('warning','NULL','Debe seleccionar al menos un resultado verdadero para el analito','add','3000');
                    resaltarCampoDigitacion(trActual.find(".valores_verdaderos"));
                    return false;
                }
            }
            // let resultadosComparacionInternacionalSeleccionados = trActual.find(".comparacion_internacional input[type='checkbox']:checked")
            // if(resultadosComparacionInternacionalSeleccionados.length == 0){
            //     statusBox('warning','NULL','Debe seleccionar un resultado de comparación internacional','add','3000');
            //     resaltarCampoDigitacion(trActual.find(".comparacion_internacional"));
            //     return false;
            // }
            // if(trActual.find(".n_lab").val() == "" || trActual.find(".n_lab").val() == undefined){
            //     statusBox('warning','NULL','Debe ingresar el número de laboratorio','add','3000');
            //     resaltarCampoDigitacion(trActual.find(".n_lab"));
            //     return false;
            // }
            // if(trActual.find(".n_points").val() == "" || trActual.find(".n_points").val() == undefined){
            //     statusBox('warning','NULL','Debe ingresar el número de puntos','add','3000');
            //     resaltarCampoDigitacion(trActual.find(".n_points"));
            //     return false;
            // }
            let checkboxesVAV = trActual.find(".vav input[type='checkbox']");
            if(checkboxesVAV.length > 0){
                // let resultadosComparacionVAVSeleccionados = trActual.find(".vav input[type='checkbox']:checked")
                let seleccionados = checkboxesVAV.filter(":checked");
                if(seleccionados.length == 0){
                    statusBox('warning','NULL','Debe seleccionar un resultado de comparación vav','add','3000');
                    resaltarCampoDigitacion(trActual.find(".vav"));
                    return false;
                }
            }
        }
        return true;
    }
}