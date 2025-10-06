function loaderPersonalizado(accion, mensaje = "Asignando valores..."){
    switch(accion){
        case "show":
            let loaderPersonalizado = $("<div class='loader_personalizado'>"+
                '<div class="spinner-border text-primary" role="status">'+
                    '<span class="sr-only">Loading...</span>' +
                '</div>' +
                '<label>'+mensaje+'</label>' +
            "</div>");
            $("body").append(loaderPersonalizado);
            loaderPersonalizado = null;
            break;
        case "hide":
            $(".loader_personalizado").remove();
            break;
    }
}