function eventoEliminarFila(tr){
    tr.find(".btn-eliminar-fila").click(function(e){

        var elementCliqued = $(this);

        e.preventDefault();

        let seleccionEliminacion = confirm(
            "Va a eliminar una fila de gestión de cambios... ¿esta seguro de continuar?"
        );

        if(seleccionEliminacion){ // Si se acepto la eliminacion
            
            if(typeof elementCliqued.data("idgestion") == "undefined"){ // Si esta indefinido el id de la gestion
                
                if(elementCliqued.parents("tbody").find("tr").length == 1){ // Verificar si se puede habilitar nuevamente el programa
                    
                    gestionSelectsSolicitud(
                        elementCliqued.parents(".cont-referencia-selectores").find(".select-inactivo"),
                        "habilitar"
                    );
                }

                // Módulo de registro de información
                eliminacionFilaExtend(elementCliqued);
                
            } else {
                let idgestion = elementCliqued.data("idgestion");
                let infoData = {
                    tipo: "eliminarGestion",
                    tipo_programa: "cuantitativo",
                    idreferencia: idgestion
                }
                
                infoData = JSON.stringify(infoData);
                
                $.post(
                    "php/digitacion_data_change_handler.php",
                    {data_ajax: infoData},
                    function(){ /* Informacion digitada */ }
                ).done(function(responseXML){
                    try {
                        var response = responseXML.getElementsByTagName("response")[0];
                        var code = parseInt(response.getAttribute("code"),10);
                        if(code == 0){
                            statusBox("warning",'NULL',"Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.",'add','NULL');
                        } else { // Si la respuesta fue exitosa
                            statusBox("success",'NULL',"Se ha eliminado la gestión del mensurando especificado, satisfactoriamente!...",'add','NULL');
                            listarInformacionDigitacion();
                            eliminacionFilaExtend(elementCliqued);

                        }
                    } catch (e) {
                        statusBox("warning",'NULL',"Ha ocurrido un error de javascript, por favor intente nuevamente...",'add','NULL');
                    }
                }).fail(function(){
                    statusBox("warning",'NULL',"Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...",'add','NULL');
                }).always(function(ssasas){
                });
            }
        }
    });
}

function eliminacionFilaExtend(elementCliqued){
    contTrsTable = elementCliqued.parents("table").find("tbody tr").length;
                            
    if (contTrsTable == 1) { // Si falta sólo un tr, eliminar la tabla completa
        elementCliqued.parents("table").remove();
    } else { // Si faltan varias eliminar la fila no más
        elementCliqued.parents("tr").remove();
    }
}