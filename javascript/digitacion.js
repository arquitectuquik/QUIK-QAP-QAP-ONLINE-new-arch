$(function(){
    eventoGuardar();
    eventoAgregarFilaGestion($("#btn-agregar-fila"), $("#cont-tabla-gestiones"));
    eventoCierreInesperado(true);
});

function eventoCierreInesperado(accion = true) {
    
    $(window).off("beforeunload",ventanaEmergente); // Eliminar eventos repetidos en dado caso que existan
    if(accion === true){
        $(window).on("beforeunload",ventanaEmergente);
        function ventanaEmergente() {
            if($("#cont-tabla-gestiones table tbody tr").length > 0){
                return "¿Está seguro de cerrar la página?, recuerde que puede perder toda la información";
            }
        }
    }   
}

function eventoGuardar(){
    $("#btn_enviar_digitacion").click(function(e){

        e.preventDefault();

        let elementEvent = $(this);

        if(validarDigitacion(elementEvent)){ // Si la digitacion es positiva
            
            if(tipoProgramaCualitativo(elementEvent)){ // Si es cualitativo
                // No hacer nada
            } else {
                // Construir JSON para enviar a guardar
                if(!alertarDigitacion(elementEvent)){
                    // Si existen valores en alerta 
                    swal({
                        text: "Existen analitos con CV superior a 10% y/o N inferiores a 10 ¿Desea continuar de todas maneras?",
                        buttons: {
                            cancel: {
                                text: "NO",
                                value: false,
                                visible: true,
                                className: "",
                                closeModal: true,
                            },
                            confirm: {
                                text: "SI",
                                value: true,
                                visible: true,
                                className: "",
                                closeModal: true
                            }
                        },
                        dangerMode: true,
                        closeOnEsc: false,
                        closeOnClickOutside: false
                    }).then((eleccion) => {
                        if (eleccion) { // Si el usuario desea continuar
                            ejecutarGuardado($(this));
                        }
                    });
                } else {
                    // Si todo esta bien
                    ejecutarGuardado($(this));
                }
            }
        }
    });
}


function ejecutarGuardado(elementEvent){
    let filasGestion = $("#cont-tabla-gestiones tbody tr");
    let datos_digitacion = [];

    filasGestion.each(function(index,val){

        let trActual = filasGestion.eq(index);

        datos_digitacion.push({
            tipo: trActual.find(".tipo").val(),
            analito: trActual.find(".analito").val(),
            analizador: trActual.find(".analizador").val(),
            reactivo: trActual.find(".reactivo").val(),
            metodologia: trActual.find(".metodologia").val(),
            unidad: trActual.find(".unidad").val(),
            unidad_mc: trActual.find(".unidad_mc").val(),
            gen_vitros: trActual.find(".gen_vitros").val(),
            media_mensual: trActual.find(".media_mensual").val(),
            de_mensual: trActual.find(".de_mensual").val(),
            cv_mensual: trActual.find(".cv_mensual").val(),
            nlab_mensual: trActual.find(".nlab_mensual").val(),
            npuntos_mensual: trActual.find(".npuntos_mensual").val(),
            media_acumulada: trActual.find(".media_acumulada").val(),
            de_acumulada: trActual.find(".de_acumulada").val(),
            cv_acumulada: trActual.find(".cv_acumulada").val(),
            nlab_acumulada: trActual.find(".nlab_acumulada").val(),
            npuntos_acumulada: trActual.find(".npuntos_acumulada").val(),
            media_jctlm: trActual.find(".media_jctlm").val(),
            etmp_jctlm: trActual.find(".etmp_jctlm").val(),
            media_inserto: trActual.find(".media_inserto").val(),
            de_inserto: trActual.find(".de_inserto").val(),
            cv_inserto: trActual.find(".cv_inserto").val(),
            n_inserto: trActual.find(".n_inserto").val()
        });
    });

    let data_ajax = {
        tipo: "registro",
        programa: elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #programa").val(),
        lote: elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #lote").val(),
        mes: elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #mes").val() + "-01",
        datos_digitacion: datos_digitacion,
        tipo_programa: (tipoProgramaCualitativo(elementEvent)) ? "cualitativo" : "cuantitativo"
    };
    

    if(datos_digitacion.length > 0){
        // Deshabilitar boton de guardar
        elementEvent.prop("disabled", true);
        elementEvent.text("Guardando información...");

        data_ajax = JSON.stringify(data_ajax);

        $.post(
            "php/digitacion_data_change_handler.php",
            {data_ajax: data_ajax},
            function(){ /* No se hace nada por el momento */ }
        ).done(function(responseXML){

            var response = responseXML.getElementsByTagName("response")[0];
            var code = parseInt(response.getAttribute("code"),10);

            if (code == 0) {
                statusBox("warning",'NULL',"Ha ocurrido algo inesperado, por favor intente nuevamente...",'add','NULL');
            } else {
                statusBox("success",'NULL',"¡Digitación guardada exitosamente!",'add','NULL');
                gestionSelectsSolicitud(
                    elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores").find(".select-inactivo"),
                    "habilitar"
                );
                $("#cont-tabla-gestiones table tbody").html("");
            }

        }).fail(function(){
            statusBox("warning",'NULL',"Ha ocurrido algo inesperado, por favor intente nuevamente...",'add','NULL');
        }).always(function(sdsd){
            elementEvent.prop("disabled", false);
            elementEvent.html("<i class='glyphicon glyphicon-floppy-disk'></i> Guardar infromación");
        });
    } else {
        statusBox("info",'NULL',"No hay datos suficientes...",'add','NULL');
    }
}