function gestionSelectsSolicitud(selects,accion){

    switch(accion) {
        case "deshabilitar":
            selects
                .addClass("input-deshabilitado")
                .prop("disabled",true);
            
            break;
        case "habilitar":
            selects
                .removeClass("input-deshabilitado")
                .prop("disabled",false);
            
            break;
    }
}