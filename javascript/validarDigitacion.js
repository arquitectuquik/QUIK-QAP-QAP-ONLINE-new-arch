function validarDigitacion(elementEvent){
    
    if(tipoProgramaCualitativo(elementEvent)){ // Si es cualitativo
        
    } else { // Si es cuantitativo        
        let filasGestionValid = $("#cont-tabla-gestiones tbody tr");
        let datos_digitacion = [];
    
        for(x=0; x<filasGestionValid.length; x++){

            let trActual = filasGestionValid.eq(x);
            
            if(trActual.find(".tipo").val() == "" || trActual.find(".tipo").val() == undefined){
                statusBox('warning','NULL','Debe especificar el tipo de digitación','add','3000');
                resaltarCampoDigitacion(trActual.find(".tipo"));
                return false;
            } else if(trActual.find(".analito").val() == "" || trActual.find(".analito").val() == undefined){
                statusBox('warning','NULL','Debe especificar el analito','add','3000');
                resaltarCampoDigitacion(trActual.find(".analito"));
                return false;
            } else if(trActual.find(".analizador").val() == "" || trActual.find(".analizador").val() == undefined){
                statusBox('warning','NULL','Debe especificar el analizador','add','3000');
                resaltarCampoDigitacion(trActual.find(".analizador"));
                return false;
            } else if(trActual.find(".reactivo").val() == "" || trActual.find(".reactivo").val() == undefined){
                statusBox('warning','NULL','Debe especificar el reactivo','add','3000');
                resaltarCampoDigitacion(trActual.find(".reactivo"));
                return false;
            } else if(trActual.find(".metodologia").val() == "" || trActual.find(".metodologia").val() == undefined){
                statusBox('warning','NULL','Debe especificar la metodología','add','3000');
                resaltarCampoDigitacion(trActual.find(".metodologia"));
                return false;
            } else if(trActual.find(".unidad").val() == "" || trActual.find(".unidad").val() == undefined){
                statusBox('warning','NULL','Debe especificar la unidad','add','3000');
                resaltarCampoDigitacion(trActual.find(".unidad"));
                return false;
            } else if(trActual.find(".unidad_mc").val() == "" || trActual.find(".unidad_mc").val() == undefined){
                statusBox('warning','NULL','Debe especificar la unidad de la media de comparación','add','3000');
                resaltarCampoDigitacion(trActual.find(".unidad_mc"));
                return false;
            } else if(evaluarGeneracionVitros(trActual)){
                statusBox('warning','NULL','Debe especificar la generación vitros','add','3000');
                resaltarCampoDigitacion(trActual.find(".gen_vitros"));
                return false;
            } else if(!(trActual.find(".media_mensual").val() == "" || $.isNumeric(trActual.find(".media_mensual").val()))){
                statusBox('warning','NULL','La media mensual debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_mensual"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".media_mensual").val()) - parseInt(trActual.find(".media_mensual").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para la media mensual','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_mensual"));
                return false;
            } else if(trActual.find(".media_mensual").val() != "" && parseInt(trActual.find(".media_mensual").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para la media mensual','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_mensual"));
                return false;



            } else if(!(trActual.find(".de_mensual").val() == "" || $.isNumeric(trActual.find(".de_mensual").val()))){
                statusBox('warning','NULL','La D.E. mensual debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_mensual"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".de_mensual").val()) - parseInt(trActual.find(".de_mensual").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para la D.E. mensual','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_mensual"));
                return false;
            } else if(trActual.find(".de_mensual").val() != "" && parseInt(trActual.find(".de_mensual").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para la D.E. mensual','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_mensual"));
                return false;
            


            } else if(parseFloat(trActual.find(".de_mensual").val()) > parseFloat(trActual.find(".media_mensual").val())){
                statusBox('warning','NULL','La D.E. mensual no puede ser mayor a la media mensual','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_mensual"));
                return false;
            

            } else if(!(trActual.find(".cv_mensual").val() == "" || $.isNumeric(trActual.find(".cv_mensual").val()))){
                statusBox('warning','NULL','El C.V. mensual debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_mensual"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".cv_mensual").val()) - parseInt(trActual.find(".cv_mensual").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para el C.V. mensual','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_mensual"));
                return false;
            } else if(trActual.find(".cv_mensual").val() != "" && parseInt(trActual.find(".cv_mensual").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para el C.V. mensual','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_mensual"));
                return false;



            } else if(!(trActual.find(".nlab_mensual").val() == "" || $.isNumeric(trActual.find(".nlab_mensual").val()))){
                statusBox('warning','NULL','El número de laboratorios mensual debe ser un número o si no lo requiere debe estar vacío','add','3000');
                resaltarCampoDigitacion(trActual.find(".nlab_mensual"));
                return false;
            } else if(trActual.find(".nlab_mensual").val() != "" && parseInt(trActual.find(".nlab_mensual").val()) > 10000){
                statusBox('warning','NULL','No pueden haber más de 10 mil de números de laboratorios mensuales','add','3000');
                resaltarCampoDigitacion(trActual.find(".nlab_mensual"));
                return false;


            } else if(!(trActual.find(".npuntos_mensual").val() == "" || $.isNumeric(trActual.find(".npuntos_mensual").val()))){
                statusBox('warning','NULL','El número de puntos mensuales debe ser un número o si no lo requiere debe estar vacío','add','3000');
                resaltarCampoDigitacion(trActual.find(".npuntos_mensual"));
                return false;
            } else if(trActual.find(".npuntos_mensual").val() != "" && parseInt(trActual.find(".npuntos_mensual").val()) > 10000000){
                statusBox('warning','NULL','No pueden haber más de 10 millones de números de puntos mensuales','add','3000');
                resaltarCampoDigitacion(trActual.find(".npuntos_mensual"));
                return false;

                // Inicio de sSeccion de acumuladas



            } else if(!(trActual.find(".media_acumulada").val() == "" || $.isNumeric(trActual.find(".media_acumulada").val()))){
                statusBox('warning','NULL','La media acumulada debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_acumulada"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".media_acumulada").val()) - parseInt(trActual.find(".media_acumulada").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para la media acumulada','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_acumulada"));
                return false;
            } else if(trActual.find(".media_acumulada").val() != "" && parseInt(trActual.find(".media_acumulada").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para la media acumulada','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_acumulada"));
                return false;



            } else if(!(trActual.find(".de_acumulada").val() == "" || $.isNumeric(trActual.find(".de_acumulada").val()))){
                statusBox('warning','NULL','La D.E. acumulada debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_acumulada"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".de_acumulada").val()) - parseInt(trActual.find(".de_acumulada").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para la D.E. acumulada','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_acumulada"));
                return false;
            } else if(trActual.find(".de_acumulada").val() != "" && parseInt(trActual.find(".de_acumulada").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para la D.E. acumulada','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_acumulada"));
                return false;
            


            } else if(parseFloat(trActual.find(".de_acumulada").val()) > parseFloat(trActual.find(".media_acumulada").val())){
                statusBox('warning','NULL','La D.E. acumulada no puede ser mayor a la media acumulada','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_acumulada"));
                return false;
            

            } else if(!(trActual.find(".cv_acumulada").val() == "" || $.isNumeric(trActual.find(".cv_acumulada").val()))){
                statusBox('warning','NULL','El C.V. acumulada debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_acumulada"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".cv_acumulada").val()) - parseInt(trActual.find(".cv_acumulada").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para el C.V. acumulada','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_acumulada"));
                return false;
            } else if(trActual.find(".cv_acumulada").val() != "" && parseInt(trActual.find(".cv_acumulada").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para el C.V. acumulada','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_acumulada"));
                return false;



            } else if(!(trActual.find(".nlab_acumulada").val() == "" || $.isNumeric(trActual.find(".nlab_acumulada").val()))){
                statusBox('warning','NULL','El número de laboratorios acumulada debe ser un número o si no lo requiere debe estar vacío','add','3000');
                resaltarCampoDigitacion(trActual.find(".nlab_acumulada"));
                return false;
            } else if(trActual.find(".nlab_acumulada").val() != "" && parseInt(trActual.find(".nlab_acumulada").val()) > 10000){
                statusBox('warning','NULL','No pueden haber más de 10 mil de números de laboratorios acumulados','add','3000');
                resaltarCampoDigitacion(trActual.find(".nlab_acumulada"));
                return false;


            } else if(!(trActual.find(".npuntos_acumulada").val() == "" || $.isNumeric(trActual.find(".npuntos_acumulada").val()))){
                statusBox('warning','NULL','El número de puntos acumulados debe ser un número o si no lo requiere debe estar vacío','add','3000');
                resaltarCampoDigitacion(trActual.find(".npuntos_acumulada"));
                return false;
            } else if(trActual.find(".npuntos_acumulada").val() != "" && parseInt(trActual.find(".npuntos_acumulada").val()) > 10000000){
                statusBox('warning','NULL','No pueden haber más de 10 millones de números de puntos acumulados','add','3000');
                resaltarCampoDigitacion(trActual.find(".npuntos_acumulada"));
                return false;
                
                // Inicio de Seccion de JCTLM



            } else if(!(trActual.find(".media_jctlm").val() == "" || $.isNumeric(trActual.find(".media_jctlm").val()))){
                statusBox('warning','NULL','La media JCTLM debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_jctlm"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".media_jctlm").val()) - parseInt(trActual.find(".media_jctlm").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para la media JCTLM','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_jctlm"));
                return false;
            } else if(trActual.find(".media_jctlm").val() != "" && parseInt(trActual.find(".media_jctlm").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para la media JCTLM','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_jctlm"));
                return false;


            } else if(!(trActual.find(".etmp_jctlm").val() == "" || $.isNumeric(trActual.find(".etmp_jctlm").val()))){
                statusBox('warning','NULL','El ETmp% del JCTLM debe ser un número o si no la requiere debe estar vacío','add','3000');
                resaltarCampoDigitacion(trActual.find(".etmp_jctlm"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".etmp_jctlm").val()) - parseInt(trActual.find(".etmp_jctlm").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para el ETmp%','add','3000');
                resaltarCampoDigitacion(trActual.find(".etmp_jctlm"));
                return false;
            } else if(trActual.find(".etmp_jctlm").val() != "" && parseInt(trActual.find(".etmp_jctlm").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para el ETmp%','add','3000');
                resaltarCampoDigitacion(trActual.find(".etmp_jctlm"));
                return false;

            // Inicio de Seccion de Inserto



            } else if(!(trActual.find(".media_inserto").val() == "" || $.isNumeric(trActual.find(".media_inserto").val()))){
                statusBox('warning','NULL','La media inserto debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_inserto"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".media_inserto").val()) - parseInt(trActual.find(".media_inserto").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para la media inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_inserto"));
                return false;
            } else if(trActual.find(".media_inserto").val() != "" && parseInt(trActual.find(".media_inserto").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para la media inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".media_inserto"));
                return false;



            } else if(!(trActual.find(".de_inserto").val() == "" || $.isNumeric(trActual.find(".de_inserto").val()))){
                statusBox('warning','NULL','La D.E. inserto debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_inserto"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".de_inserto").val()) - parseInt(trActual.find(".de_inserto").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para la D.E. inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_inserto"));
                return false;
            } else if(trActual.find(".de_inserto").val() != "" && parseInt(trActual.find(".de_inserto").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para la D.E. inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_inserto"));
                return false;



            } else if(parseFloat(trActual.find(".de_inserto").val()) > parseFloat(trActual.find(".media_inserto").val())){
                statusBox('warning','NULL','La D.E. inserto no puede ser mayor a la media inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".de_inserto"));
                return false;


            } else if(!(trActual.find(".cv_inserto").val() == "" || $.isNumeric(trActual.find(".cv_inserto").val()))){
                statusBox('warning','NULL','El C.V. inserto debe ser un número o si no la requiere debe estar vacía','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_inserto"));
                return false;
            } else if(Math.round((parseFloat((trActual.find(".cv_inserto").val()) - parseInt(trActual.find(".cv_inserto").val()))) * 1000) > 999){
                statusBox('warning','NULL','No pueden haber más de 3 números decimales para el C.V. inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_inserto"));
                return false;
            } else if(trActual.find(".cv_inserto").val() != "" && parseInt(trActual.find(".cv_inserto").val()) > 99999){
                statusBox('warning','NULL','No pueden haber más de 5 números enteros para el C.V. inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".cv_inserto"));
                return false;



            } else if(!(trActual.find(".n_inserto").val() == "" || $.isNumeric(trActual.find(".n_inserto").val()))){
                statusBox('warning','NULL','El número de puntos inserto debe ser un número o si no lo requiere debe estar vacío','add','3000');
                resaltarCampoDigitacion(trActual.find(".n_inserto"));
                return false;
            } else if(trActual.find(".n_inserto").val() != "" && parseInt(trActual.find(".n_inserto").val()) > 10000){
                statusBox('warning','NULL','No pueden haber más de 10 mil de números de puntos inserto','add','3000');
                resaltarCampoDigitacion(trActual.find(".n_inserto"));
                return false;

            }
        }


        return true;
    }
}