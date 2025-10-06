$(function(){
    eventoChangeLaboratorio();
    eventoChangeProgramaPAT();
    eventoChangeRetoPAT();
    eventoGenerarInforme();
    $("#laboratorio_pat").change();
});

function eventoChangeLaboratorio(){
    $("#laboratorio_pat").change(function(e){
        e.preventDefault();
        informacionProgramasPAT();
    });
}


function eventoChangeProgramaPAT(){
    $("#programa_pat").change(function(e){
        e.preventDefault();
        informacionRetosPAT();
    });
}

function eventoChangeRetoPAT(){
    $("#reto_pat").change(function(e){
        e.preventDefault();
        informacionIntentosPAT();
    });
}

function informacionProgramasPAT(){
    let id_laboratorio = $("#laboratorio_pat").val();
    let datos = {
        tabla: "programas_asignados_pat_report",
        id_filtro: id_laboratorio
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){
        if(validarSiJSON(data)){
            campoP = $("#programa_pat");
            campoP.html("");
            var resultado = JSON.parse(data);
            if(resultado.length > 0){
                for (i = 0; i < resultado.length; i++) {
                    var option = $("<option value=" + resultado[i][0] + ">" + resultado[i][1] + "</option>");
                    campoP.append(option);
                }
            } else {
                var option = $("<option disabled selected>No hay opciones disponbiles...</option>");
                campoP.append(option);
            }
            campoP.change();
        }
    });
}


function informacionRetosPAT(){
    let id_laboratorio = $("#laboratorio_pat").val();
    let id_filtro_programa = $("#programa_pat").val();
    let datos = {
        tabla: "retos_asignados_pat_report",
        id_filtro: id_laboratorio,
        id_filtro_programa: id_filtro_programa 
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){

        if(validarSiJSON(data)){
            campoP = $("#reto_pat");
            campoP.html("");
            var resultado = JSON.parse(data);
            if(resultado.length > 0){
                for (i = 0; i < resultado.length; i++) {
                    var option = $("<option value=" + resultado[i][0] + ">" + resultado[i][1] + "</option>");
                    campoP.append(option);
                }
            } else {
                var option = $("<option disabled selected>No hay opciones disponbiles...</option>");
                campoP.append(option);
            }
            campoP.change();
        }
    });
}

function informacionIntentosPAT(){
    let id_laboratorio = $("#laboratorio_pat").val();
    let id_filtro_reto = $("#reto_pat").val();
    let datos = {
        tabla: "intentos_pat_report",
        id_filtro: id_laboratorio,
        id_filtro_reto: id_filtro_reto 
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){
        if(validarSiJSON(data)){
            campoP = $("#intento_pat");
            campoP.html("");
            var resultado = JSON.parse(data);
            if(resultado.length > 0){
                for (i = 0; i < resultado.length; i++) {
                    var option = $("<option value=" + resultado[i][0] + ">(" + (i+1) + ") " + resultado[i][1] + " el " + resultado[i][2] + "</option>");
                    campoP.append(option);
                }
            } else {
                var option = $("<option disabled selected>No hay intentos realizados...</option>");
                campoP.append(option);
            }
        }
    });
}


function eventoGenerarInforme(){
    $("#generar_reporte").click(function(e){
        e.preventDefault();

        if(
            $("#laboratorio_pat").val() === null ||
            $("#programa_pat").val() === null ||
            $("#reto_pat").val() === null ||
            $("#intento_pat").val() === null ||
            $("#fecha_envio").val() === null ||
            $("#fecha_envio").val() === "" ||
            $("#estado_reporte").val() === null
        ){
            alert("Debe seleccionar todos los campos: laboratorio, programa, reto, intento, fecha envío y estado del reporte");
        } else {
            let laboratorio_pat = $("#laboratorio_pat").val();
            let programa_pat = $("#programa_pat").val();
            let reto_pat = $("#reto_pat").val();
            let intento_pat = $("#intento_pat").val();
            let fecha_envio = $("#fecha_envio").val();
            let estado_reporte = $("#estado_reporte").val();
            let see_observaciones = (($("#see_observaciones").prop("checked") === true) ? 1 : 0);

            $("#box_iframe").attr("src","php/informe/informePAT.php?laboratorio_pat="+laboratorio_pat+"&programa_pat="+programa_pat+"&reto_pat="+reto_pat+"&intento_pat="+intento_pat+"&fecha_envio="+fecha_envio+"&estado_reporte="+estado_reporte+"&see_observaciones="+see_observaciones);
        }
    })
}