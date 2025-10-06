$(function () {
    $(".change_list").change(function () {
        listarInformacionDigitacion();
    });

    $("#programa").change(function () {
        listarLotesDigitacion();
    });

    listarInformacionDigitacion();
    listarLotesDigitacion();
    eventoCierreInesperado(true);
});


function eventoCierreInesperado(accion = true) {

    $(window).off("beforeunload", ventanaEmergente); // Eliminar eventos repetidos en dado caso que existan
    if (accion === true) {
        $(window).on("beforeunload", ventanaEmergente);

        function ventanaEmergente() {
            if ($(".cont-modal-modificacion table tbody tr").length > 0) {
                return "¿Está seguro de cerrar la página?, recuerde que puede perder toda la información";
            }
        }
    }
}


function listarLotesDigitacion() {

    let programa = $("#programa").eq(0).val();

    if (programa == "" || programa == undefined) {
        programa == 0; // Todos los programas
    }

    let info_sbasico = {
        tabla: "lotes_digitacion",
        id_filtro: programa
    };

    $.post(
        "php/listar_select_basico.php",
        info_sbasico,
        function () {
            /* No hacer nada temoralmente */
        }
    ).done(function (data) {

        let campoP = $("#lote").eq(0);
        campoP.html("");

        if (validarSiJSON(data)) {

            campoP.html(campoP.find("option").eq(0));
            var resultado = JSON.parse(data);
            for (i = 0; i < resultado.length; i++) {
                var option = $("<option value=" + resultado[i][0] + ">" + resultado[i][1] + " | nivel: " + resultado[i][2] + " | fecha de vencimiento: " + resultado[i][3] + "</option>");
                campoP.append(option);
            }

            campoP.change();
        }

    }).fail(function () {
        statusBox("warning", 'NULL', "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...", 'add', 'NULL');
    }).always(function (sdsd) {
        console.log(sdsd);
    });

}

function listarInformacionDigitacion() {
    let programa = $("#programa").eq(0).val();
    let lote = $("#lote").eq(0).val();
    let mes_inicial = $("#mes_inicial").eq(0).val();
    let mes_final = $("#mes_final").eq(0).val();
    let fecha_temp = new Date();

    if (lote == "" || lote == undefined) {
        lote = 0;
    }

    if (mes_inicial == "" || mes_inicial == undefined) {
        mes_inicial = (fecha_temp.getFullYear() - 1) + "-" + fecha_temp.getMonth() + "-" + "01"; // Un año en el pasado
    }

    if (mes_final == "" || mes_final == undefined) {
        mes_final = fecha_temp.getFullYear() + "-" + fecha_temp.getMonth() + "-" + "01";
    }

    let datos = {
        tipo: "visualizacion",
        programa: programa,
        lote: lote,
        mes_inicial: mes_inicial,
        mes_final: mes_final,
        tipo_programa: (tipoProgramaCualitativo($("#programa").eq(0))) ? "cualitativo" : "cuantitativo"
    };

    datos = JSON.stringify(datos);

    $.post(
        "php/digitacion_data_change_handler.php", {
            data_ajax: datos
        },
        function () {
            /* No hacer nada temporalmente */
        }
    ).done(function (responseXML) {

        try {
            var response = responseXML.getElementsByTagName("response")[0];
            var code = parseInt(response.getAttribute("code"), 10);

            if (code == 0) {
                statusBox("warning", 'NULL', "Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.", 'add', 'NULL');
            } else {
                response = $(response).html();

                if (validarSiJSON(response)) { // Si es JSON
                    var digitaciones = JSON.parse(response);
                    let cont_digitaciones = $(".cont-digitaciones-realizadas");

                    if (digitaciones.length == 0) { // Si no hay digitaciones para la busqueda
                        cont_digitaciones.html(
                            "<div>" +
                            "<hr><div>No hay digitación para el criterio de búsqueda...</div>" +
                            "</div>"
                        );
                    } else {

                        $(".cont-digitaciones-realizadas").html("");

                        $(".cont-digitaciones-realizadas").append(
                            "<table id='tabla-dinamica' class='td-primero-oculto'>" +
                            "<thead>" +
                            "<tr>" +
                            "<td><span><i class='fas fa-sort-amount-down'></i> Viendo más antiguas primero</span></td>" +
                            "<td></td>" +
                            "</tr>" +
                            "</thead>" +
                            "<tbody>" +
                            "</tbody>" +
                            "</table>"
                        );

                        $(".numero-digitaciones p").html(
                            "<span><i class='far fa-eye'></i> Se han encontrado " + digitaciones.length + " digitaciones<span><hr />"
                        );

                        for (dig = 0; dig < digitaciones.length; dig++) {

                            var divDigitacion = $(
                                '<tr><td class="td_fecha"></td><td>' +
                                '<div class="digitacion">' +
                                '<div class="cont-laboratorio">' +
                                '<ul></ul>' +
                                '</div>' +
                                '<div class="cont-info-digitacion scroll">' +
                                '<div class="cont-info-gestiones">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</td></tr>'
                            );


                            divDigitacion.find(".cont-laboratorio ul").append(
                                "<li><i class='mr-2 icono-digitacion fas fa-archive'></i>" + digitaciones[dig]["nombre_programa"] + " - " + digitaciones[dig]["nombre_lote"] + "</li>" +
                                "<li><i class='mr-2 icono-digitacion fas fa-calendar-alt'></i>" + digitaciones[dig]["mes"] + "</li>"
                            );

                            divDigitacion.find(".td_fecha").html(
                                digitaciones[dig]["mes"]
                            );

                            divDigitacion.find(".cont-laboratorio").append('<nav class="adjuntos"></nav>');

                            // Deshabilitado termporalmente
                            divDigitacion.find(".cont-laboratorio .adjuntos").append(
                                '<a href="" title="Eliminar la digitacion especificada" class="btn-eliminar" data-idreferencia="' + digitaciones[dig]["id_digitacion"] + '">' +
                                '<span><i class="fas fa-file-pdf"></i> Eliminar</span>' +
                                '</a>'
                            );

                            divDigitacion.find(".cont-laboratorio .adjuntos").append(
                                '<a href="" title="Modificar valores de comparación" class="btn-modificar" data-tipoprograma="cuantitativo" data-idprograma="' + digitaciones[dig]["id_programa"] + '" data-idreferencia="' + digitaciones[dig]["id_digitacion"] + '">' +
                                '<span><i class="fas fa-file-pdf"></i> Modificar</span>' +
                                '</a>'
                            );

                            divDigitacion.find(".cont-laboratorio .adjuntos").append(
                                '<a href="" title="Asignar valores de comparación V.A.V." data-tipoprograma="cuantitativo" data-idprograma="' + digitaciones[dig]["id_programa"] + '" data-idreferencia="' + digitaciones[dig]["id_digitacion"] + '" class="btn-asignar-digitacion">' +
                                '<span><i class="fas fa-file-pdf"></i> Asignar V.A.V.</span>' +
                                '</a>'
                            );

                            divDigitacion.find(".cont-laboratorio .adjuntos").append(
                                '<a href="php/informe/informeResumen.php?tipoprograma=cuantitativo&idreferencia=' + digitaciones[dig]["id_digitacion"] + '" target="_blank" title="Generar informe en formato QAP-FOR-07" class="btn-exportar">' +
                                '<span><i class="fas fa-file-pdf"></i> Generar PDF</span>' +
                                '</a>'
                            );

                            divDigitacion.find(".cont-laboratorio .adjuntos").append('<button class="pliegue"><i class="fas fa-chevron-down"></i></button>');

                            if (digitaciones[dig]["digitacion_cuantitativa"].length > 0) {

                                divDigitacion.find(".cont-info-gestiones").html(
                                    "<table class='cont-resumen-table'>" +
                                    "<thead>" +
                                    "<tr>" +
                                    "<th rowspan='2'>Tipo</th>" +
                                    "<th rowspan='2'>Mensurando</th>" +
                                    "<th rowspan='2'>Analizador</th>" +
                                    "<th rowspan='2'>Reactivo</th>" +
                                    "<th rowspan='2'>Metodología</th>" +
                                    "<th rowspan='2'>Unidad</th>" +
                                    "<th rowspan='2'>Generación</th>" +
                                    "<th colspan='5'>Mensual</th>" +
                                    "<th colspan='5'>Acumulada</th>" +
                                    "<th colspan='2'>JCTLM</th>" +
                                    "<th colspan='4'>Inserto</th>" +
                                    "</tr>" +
                                    "<tr>" +
                                    "<th>Media</th>" +
                                    "<th>D.E.</th>" +
                                    "<th>C.V.</th>" +
                                    "<th>#Lab</th>" +
                                    "<th>#P</th>" +

                                    "<th>Media</th>" +
                                    "<th>D.E.</th>" +
                                    "<th>C.V.</th>" +
                                    "<th>#Lab</th>" +
                                    "<th>#P</th>" +

                                    "<th>Media</th>" +
                                    "<th>ETmp%</th>" +

                                    "<th>Media</th>" +
                                    "<th>D.E.</th>" +
                                    "<th>C.V.</th>" +
                                    "<th>N</th>" +
                                    "</tr>" +
                                    "</thead>" +
                                    "<tbody></tbody>" +
                                    "</table>"
                                );


                                for (gest = 0; gest < digitaciones[dig]["digitacion_cuantitativa"].length; gest++) {

                                    let tipo_gestion_text = "Original"; // Por defecto el tipo de gestion es original
                                    if (digitaciones[dig]["digitacion_cuantitativa"][gest]["tipo_digitacion"] == "") { // Si la digitcion es nula
                                        tipo_gestion_text = 'N/A';
                                    } else if (digitaciones[dig]["digitacion_cuantitativa"][gest]["tipo_digitacion"] == 1) {
                                        tipo_gestion_text = 'Original';
                                    } else if (digitaciones[dig]["digitacion_cuantitativa"][gest]["tipo_digitacion"] == 2) {
                                        tipo_gestion_text = 'Adaptación';
                                    }


                                    divDigitacion.find("table tbody").append(
                                        "<tr>" +
                                        "<td>" + tipo_gestion_text + "</td>" +
                                        "<td>" + tipo_gestion_text + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_analito"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_analito"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_analizador"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_analizador"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_reactivo"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_reactivo"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_metodologia"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_metodologia"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_unidad"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["nombre_unidad"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["valor_gen_vitros"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["valor_gen_vitros"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["media_mensual"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["media_mensual"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["de_mensual"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["de_mensual"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["cv_mensual"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["cv_mensual"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["n_lab_mensual"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["n_lab_mensual"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["n_puntos_mensual"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["n_puntos_mensual"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["media_acumulada"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["media_acumulada"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["de_acumulada"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["de_acumulada"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["cv_acumulada"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["cv_acumulada"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["n_lab_acumulada"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["n_lab_acumulada"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["n_puntos_acumulada"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["n_puntos_acumulada"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["media_jctlm"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["media_jctlm"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["etmp_jctlm"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["etmp_jctlm"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["media_inserto"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["media_inserto"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["de_inserto"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["de_inserto"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["cv_inserto"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["cv_inserto"]) + "</td>" +
                                        "<td>" + ((digitaciones[dig]["digitacion_cuantitativa"][gest]["n_inserto"] == "") ? "N/A" : digitaciones[dig]["digitacion_cuantitativa"][gest]["n_inserto"]) + "</td>" +
                                        "</tr>"
                                    );
                                }

                            } else {
                                divDigitacion.find(".cont-info-gestiones").html("<p pt-3 pl-3 pb-0 class='font-weight-bold'><i class='ml-1 mr-1 far fa-folder-open'></i> Sin medias digitadas...</p>");
                            }

                            $(".cont-digitaciones-realizadas table tbody").eq(0).append(divDigitacion);
                        }

                        $(".cont-info-digitacion").hide();

                        eventoEliminarDigitacion();
                        eventoModificarDigitacion();
                        eventoAsignarDigitacion();
                        eventoOrdenamiento();
                        eventoDespliegueSolicitudes();
                        $("#tabla-dinamica").DataTable();
                    }

                } else { // Si no es JSON
                    statusBox("warning", 'NULL', "Al parecer aún no hay resultados para la selección...", 'add', 'NULL');
                }
            }
        } catch (e) {
            statusBox("warning", 'NULL', "Ha ocurrido un error de javascript, por favor intente nuevamente...", 'add', 'NULL');
        }


    }).fail(function () {
        statusBox("warning", 'NULL', "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...", 'add', 'NULL');
    }).always(function (sdsd) {
        console.log(sdsd);
    });
}



function eventoModificarDigitacion() {
    $(".adjuntos .btn-modificar").off("click");
    $(".adjuntos .btn-modificar").click(function (e) {

        e.preventDefault();

        let id_digitacion = $(this).data("idreferencia");
        let tipoprograma = $(this).data("tipoprograma");
        let idprograma = $(this).data("idprograma");

        let contModal = $(".cont-modal-modificacion");
        contModal.html(""); // Vaciar cualquier modal que se encuentre abierto

        let modalPersonalize = $(
            '<div class="modal cont-referencia-selectores" tabindex="-1" role="dialog">' +
            '                <div class="modal-dialog">' +
            '                    <div class="modal-content">' +
            '                    <div class="modal-header">' +
            '                        <h5 class="modal-title"><strong>Modificación de digitación</strong></h5>' +
            '</div>' +
            '<div class="modal-body">' +

            '<div class="col-xs-12 no-margin no-padding cont-selectores" id="formDigitacion">' +
            '<div class="col-xs-3">' +
            '<input type="hidden" class="form-control input-sm" id="id_digitacion">' +
            '<div class="form-group">' +
            '<label for="programa">Programa</label>' +
            '<select id="programa" class="form-control input-sm"></select>' +
            '</div>' +
            '</div>' +
            '<div class="col-xs-3">' +
            '<div class="form-group">' +
            '<label for="lote">Lote</label>' +
            '<select id="lote" class="form-control input-sm"></select>' +
            '</div>' +
            '</div>' +
            '<div class="col-xs-3">' +
            '<div class="form-group">' +
            '<label for="mes">Mes</label>' +
            '<input type="month" class="form-control input-sm" id="mes" value="">' +
            '</div>' +
            '</div>' +
            '</div>' +

            '<hr>' +

            '<div class="datos" id="cont_valores_estadisticos">' +
            '<button id="btn-agregar-fila" class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> Agregar gestión</button>' +
            '<div class="cont-tabla scroll" id="cont-tabla-gestiones">' +
            "<br /><h5><strong>Cargando información...</strong></h5>" +
            '</div>' +
            '</div>' +

            '</div>' +
            '                    <div class="modal-footer">' +
            '                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>' +
            '                        <button type="button" class="btn btn-primary btn-guardar-cambios" disabled="disabled">Guardar cambios</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );

        contModal.html(modalPersonalize);
        generarInfoModificacion(tipoprograma, id_digitacion, idprograma);
        contModal.find(".modal").modal({
            backdrop: "static",
            keyboard: false,
            show: true
        });

        modalPersonalize = null;
    });
}


function generarInfoModificacion(tipoprograma, idreferencia, idprograma) {

    switch (tipoprograma) {
        case "cuantitativo":

            let dataAjax = {
                tipo: "SeeInfoModificacion",
                tipo_programa: "cuantitativo",
                idreferencia: idreferencia,
                idprograma: idprograma
            }

            dataAjax = JSON.stringify(dataAjax);

            $.post(
                "php/digitacion_data_change_handler.php", {
                    data_ajax: dataAjax
                },
                function () {
                    /* No hacer nada de momento */
                }
            ).done(function (responseXML) {

                // try {
                var response = responseXML.getElementsByTagName("response")[0];
                var code = parseInt(response.getAttribute("code"), 10);
                if (code == 0) {
                    statusBox("warning", 'NULL', "Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.", 'add', 'NULL');
                } else { // Si la respuesta fue exitosa

                    let resultadoJSON = JSON.parse($(response).html());
                    let contModal = $(".cont-modal-modificacion");

                    // Fijar valor para el id_referencia
                    contModal.find("#id_digitacion").val(resultadoJSON.digitaciones[0].id_digitacion);


                    // Fijar valor para el programa
                    contModal.find("#programa").html("");
                    contModal.find("#programa").append("<option value='" + resultadoJSON.digitaciones[0].id_programa + "' selected>" + resultadoJSON.digitaciones[0].nombre_programa + " (" + resultadoJSON.digitaciones[0].desc_tipo_programa + ")</option>")

                    // Obtener opciones y seleccionar el lote de control
                    contModal.find("#lote").html("");
                    for (i = 0; i < resultadoJSON.lotes.length; i++) {
                        if (resultadoJSON.lotes[i].id_lote == resultadoJSON.digitaciones[0].id_lote) {
                            contModal.find("#lote").append("<option value='" + resultadoJSON.lotes[i].id_lote + "' selected>" + resultadoJSON.lotes[i].nombre_lote + " | nivel: " + resultadoJSON.lotes[i].nombre_lote + " | fecha de vencimiento: " + resultadoJSON.lotes[i].fecha_vencimiento + "</option>");
                        } else {
                            contModal.find("#lote").append("<option value='" + resultadoJSON.lotes[i].id_lote + "'>" + resultadoJSON.lotes[i].nombre_lote + " | nivel: " + resultadoJSON.lotes[i].nombre_lote + " | fecha de vencimiento: " + resultadoJSON.lotes[i].fecha_vencimiento + "</option>");
                        }
                    };

                    // Fijar el valor para el mes
                    let mesBD = resultadoJSON.digitaciones[0].mes;
                    let arrayMes = mesBD.split("-");
                    contModal.find("#mes").val(arrayMes[0] + "-" + arrayMes[1]);

                    // Generar tabla valores cuantitativos
                    let table = $('<table class="table table-sm table-secondary text-center" style="min-width: 2000px;"></table>');
                    let table_cuerpo = $(
                        '<thead class="table-primary text-center">' +
                        '<tr>' +
                        '<th rowspan="2">Tipo</th>' +
                        '<th rowspan="2">Mensurando</th>' +
                        '<th rowspan="2">Analizador</th>' +
                        '<th rowspan="2">Reactivo</th>' +
                        '<th rowspan="2">Metodología</th>' +
                        '<th rowspan="2" style="width:100px">Unidades</th>' +
                        '<th rowspan="2" style="width:100px">U-MC <span class="badge badge-secondary" title="Esta unidad es la que se imprimirá en el reporte final, en la columna U-MC">New</span></th>' +
                        '<th rowspan="2">Generación</th>' +
                        '<th colspan="5" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">Mensual</th>' +
                        '<th colspan="5" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">Acumulada</th>' +
                        '<th colspan="2" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">JCTLM</th>' +
                        '<th colspan="4" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">Inserto</th>' +
                        '<th colspan="1" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;"></th>' +
                        '</tr>' +

                        '<tr>' +
                        '<th style="border-left: 2px solid #2471A3">Media</th>' +
                        '<th>D.E.</th>' +
                        '<th>C.V.</th>' +
                        '<th>#Lab</th>' +
                        '<th>#P</th>' +

                        '<th style="border-left: 2px solid #2471A3">Media</th>' +
                        '<th>D.E.</th>' +
                        '<th>C.V.</th>' +
                        '<th>#Lab</th>' +
                        '<th>#P</th>' +

                        '<th style="border-left: 2px solid #2471A3">Media</th>' +
                        '<th>ETmp%</th>' +

                        '<th style="border-left: 2px solid #2471A3">Media</th>' +
                        '<th>D.E.</th>' +
                        '<th>C.V.</th>' +
                        '<th style="border-right: 2px solid #2471A3;">N</th>' +

                        '<th>Acciones</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody></tbody>'
                    );

                    // Evento de agregar nueva fila de gestión
                    eventoAgregarFilaGestion($("#btn-agregar-fila"), $("#cont-tabla-gestiones"));

                    // Evento de guardar la modificacion
                    eventoGuardarModificacion();

                    // Generar la estructura principal y el encabezado de la tabla
                    $("#cont-tabla-gestiones").html(table)
                    $("#cont-tabla-gestiones table").html(table_cuerpo);

                    table_cuerpo = null;
                    table = null;

                    // Recorrer cada gestion realizada
                    // Definir todos los posibles analitos
                    var analitosOptions = "";
                    for (countanalitos = 0; countanalitos < resultadoJSON.analitos.length; countanalitos++) {
                        analitosOptions = analitosOptions + "<option value='" + resultadoJSON.analitos[countanalitos].id_analito + "'>" + resultadoJSON.analitos[countanalitos].nombre_analito + "</option>";
                    }

                    // Definir los posibles analizadores
                    var analizadoresOptions = "";
                    for (countanalizadores = 0; countanalizadores < resultadoJSON.analizadores.length; countanalizadores++) {
                        analizadoresOptions = analizadoresOptions + "<option value='" + resultadoJSON.analizadores[countanalizadores].id_analizador + "'>" + resultadoJSON.analizadores[countanalizadores].nombre_analizador + "</option>";
                    }

                    // Definir los posibles reactivos
                    var reactivosOptions = "";
                    for (countreactivos = 0; countreactivos < resultadoJSON.reactivos.length; countreactivos++) {
                        reactivosOptions = reactivosOptions + "<option value='" + resultadoJSON.reactivos[countreactivos].id_reactivo + "'>" + resultadoJSON.reactivos[countreactivos].nombre_reactivo + "</option>";
                    }

                    for (gest = 0; gest < resultadoJSON.digitaciones[0].digitacion_cuantitativa.length; gest++) {

                        let table_trGestion = $(
                            '<tr data-idreferencia="' + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_digitacion_cuantitativa + '">' +
                            '<td>' +
                            '<select class="tipo form-control input-sm">' +
                            '<option value="" disabled>Seleccione la acción que va a gestionar</option>' +
                            '<option value="1">Original (basado en reporte mundial)</option>' +
                            '<option value="2">Adaptación (configuración para unidad o laboratorio en específico)</option>' +
                            '</select>' +
                            '</td>' +
                            '<td>' +
                            '<select class="analito form-control input-sm"><option disabled selected>Seleccione un mensurando</option></select>' +
                            '</td>' +
                            '<td>' +
                            '<select class="analizador form-control input-sm"><option disabled selected>Seleccione un analizador</option></select>' +
                            '</td>' +
                            '<td>' +
                            '<select class="reactivo form-control input-sm"><option disabled selected>Seleccione un reactivo</option></select>' +
                            '</td>' +
                            '<td>' +
                            '<select class="metodologia form-control input-sm"><option disabled selected>Seleccione una metodología</option></select>' +
                            '</td>' +
                            '<td>' +
                            '<select class="unidad form-control input-sm"><option disabled selected>Seleccione una unidad</option></select>' +
                            '</td>' +
                            '<td>' +
                            '<select class="unidad_mc form-control input-sm"><option disabled selected>Seleccione una unidad</option></select>' +
                            '</td>' +
                            '<td>' +
                            '<select class="gen_vitros form-control input-sm"><option disabled selected>Seleccione una generación vitros</option></select>' +
                            '</td>' +
                            '<td style="border-left: 2px solid #2471A3">' +
                            '<input class="media_mensual input_float form-control input-sm" data-fieldmedia="media_mensual" data-fieldde="de_mensual" data-fieldcv="cv_mensual" placeholder="M mensual">' +
                            '</td>' +
                            '<td>' +
                            '<input class="de_mensual input_float change_cv form-control input-sm" data-fieldmedia="media_mensual" data-fieldde="de_mensual" data-fieldcv="cv_mensual" placeholder="D.E. mensual">' +
                            '</td>' +
                            '<td>' +
                            '<input class="cv_mensual input_float change_cv form-control input-sm" placeholder="C.V. mensual">' +
                            '</td>' +
                            '<td>' +
                            '<input class="nlab_mensual form-control input-sm" placeholder="NLab mensual">' +
                            '</td>' +
                            '<td>' +
                            '<input class="npuntos_mensual form-control input-sm" placeholder="NPuntos mensual">' +
                            '</td>' +
                            '<td style="border-left: 2px solid #2471A3">' +
                            '<input class="media_acumulada change_cv input_float form-control input-sm" data-fieldmedia="media_acumulada" data-fieldde="de_acumulada" data-fieldcv="cv_acumulada" placeholder="M acumulada">' +
                            '</td>' +
                            '<td>' +
                            '<input class="de_acumulada change_cv input_float form-control input-sm" data-fieldmedia="media_acumulada" data-fieldde="de_acumulada" data-fieldcv="cv_acumulada" placeholder="D.E. acumulada">' +
                            '</td>' +
                            '<td>' +
                            '<input class="cv_acumulada input_float form-control input-sm" placeholder="C.V. acumulada">' +
                            '</td>' +
                            '<td>' +
                            '<input class="nlab_acumulada form-control input-sm" placeholder="NLab acumulada">' +
                            '</td>' +
                            '<td>' +
                            '<input class="npuntos_acumulada form-control input-sm" placeholder="NPuntos acumulada">' +
                            '</td>' +
                            '<td style="border-left: 2px solid #2471A3">' +
                            '<input class="media_jctlm input_float form-control input-sm" placeholder="M JCTLM">' +
                            '</td>' +
                            '<td>' +
                            '<input class="etmp_jctlm input_float form-control input-sm" placeholder="ETmp% JCTLM">' +
                            '</td>' +
                            '<td style="border-left: 2px solid #2471A3;">' +
                            '<input class="media_inserto change_cv input_float form-control input-sm" data-fieldmedia="media_inserto" data-fieldde="de_inserto" data-fieldcv="cv_inserto" placeholder="M inserto">' +
                            '</td>' +
                            '<td>' +
                            '<input class="de_inserto change_cv input_float form-control input-sm" data-fieldmedia="media_inserto" data-fieldde="de_inserto" data-fieldcv="cv_inserto" placeholder="D.E. inserto">' +
                            '</td>' +
                            '<td>' +
                            '<input class="cv_inserto input_float form-control input-sm" placeholder="CV inserto">' +
                            '</td>' +
                            '<td style="border-right: 2px solid #2471A3;">' +
                            '<input class="n_inserto form-control input-sm" placeholder="N inserto">' +
                            '</td>' +
                            '<td>' +
                            '<button class="btn btn-sm btn-danger btn-eliminar-fila"><span class="glyphicon glyphicon-remove" title="Clic para eliminar ésta fila"></span></button>' +
                            '</td>' +
                            '</tr>'
                        );
                        $("#cont-tabla-gestiones tbody").append(table_trGestion);

                        // Definicion del tipo de gestion
                        table_trGestion
                            .find(".tipo")
                            .find("option[value=" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].tipo_digitacion + "]")
                            .prop("selected", true);


                        // Definicion del analito
                        table_trGestion
                            .find(".analito")
                            .append(analitosOptions)
                            .find("option[value=" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_analito + "]")
                            .prop("selected", true);

                        // Definicion del analizador
                        table_trGestion
                            .find(".analizador")
                            .append(analizadoresOptions)
                            .find("option[value=" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_analizador + "]")
                            .prop("selected", true);

                        // Definicion del reactivo
                        table_trGestion
                            .find(".reactivo")
                            .append(reactivosOptions)
                            .find("option[value=" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_reactivo + "]")
                            .prop("selected", true);


                        // Definicion de metodologia
                        table_trGestion
                            .find(".metodologia").html("")
                            .append("<option value='" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_metodologia + "'>" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].nombre_metodologia + "</option>");

                        // Definicion de unidad
                        table_trGestion.find(".unidad")
                            .html("")
                            .append("<option value='" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_unidad + "'>" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].nombre_unidad + "</option>");

                        // Definicion de unidad de la media de comparación
                        table_trGestion.find(".unidad_mc")
                            .html("")
                            .append("<option value='" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_unidad_mc + "'>" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].nombre_unidad_mc + "</option>");

                        // Definicion ed generaciones vitros
                        table_trGestion.find(".gen_vitros")
                            .html("")
                            .append("<option value='" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_gen_vitros + "'>" + resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].valor_gen_vitros + "</option>");

                        // Definicion de valores estadisticos

                        // Mensual
                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_mensual != "") {
                            table_trGestion.find(".media_mensual").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_mensual);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].de_mensual != "") {
                            table_trGestion.find(".de_mensual").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].de_mensual);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].cv_mensual != "") {
                            table_trGestion.find(".cv_mensual").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].cv_mensual);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_lab_mensual != "") {
                            table_trGestion.find(".nlab_mensual").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_lab_mensual);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_puntos_mensual != "") {
                            table_trGestion.find(".npuntos_mensual").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_puntos_mensual);
                        }

                        // Acumulada    
                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_acumulada != "") {
                            table_trGestion.find(".media_acumulada").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_acumulada);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].de_acumulada != "") {
                            table_trGestion.find(".de_acumulada").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].de_acumulada);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].cv_acumulada != "") {
                            table_trGestion.find(".cv_acumulada").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].cv_acumulada);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_lab_acumulada != "") {
                            table_trGestion.find(".nlab_acumulada").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_lab_acumulada);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_puntos_acumulada != "") {
                            table_trGestion.find(".npuntos_acumulada").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_puntos_acumulada);
                        }

                        // JCTLM
                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_jctlm != "") {
                            table_trGestion.find(".media_jctlm").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_jctlm);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].etmp_jctlm != "") {
                            table_trGestion.find(".etmp_jctlm").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].etmp_jctlm);
                        }

                        // Inserto
                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_inserto != "") {
                            table_trGestion.find(".media_inserto").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].media_inserto);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].de_inserto != "") {
                            table_trGestion.find(".de_inserto").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].de_inserto);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].cv_inserto != "") {
                            table_trGestion.find(".cv_inserto").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].cv_inserto);
                        }

                        if (resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_inserto != "") {
                            table_trGestion.find(".n_inserto").val(resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].n_inserto);
                        }

                        // Eliminacion
                        table_trGestion.find(".btn-eliminar-fila").data("idgestion", resultadoJSON.digitaciones[0].digitacion_cuantitativa[gest].id_digitacion_cuantitativa);

                        eventoEliminarFila(table_trGestion);
                        eventoAsignarFloat(table_trGestion);
                        eventoCalcularCV(table_trGestion);
                        eventoChangeAnalizador(table_trGestion.find(".analizador"), table_trGestion);
                        table_trGestion = null;
                    }

                    $(".modal .btn-guardar-cambios").prop("disabled", false); // Habilitar nuevamente el boton de modificar
                }
                // } catch (e) {
                // statusBox("warning",'NULL',"Ha ocurrido un error de javascript, por favor intente nuevamente...",'add','NULL');
                // }
            }).fail(function () {
                statusBox("warning", 'NULL', "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...", 'add', 'NULL');
            }).always(function (ssasas) {
                console.log(ssasas);
                $(".modal .btn-guardar-cambios").prop("disabled", false); // Habilitar nuevamente el boton de modificar
            });
            break;
        case "cualitativo":
            break;
    }

}


function eventoEliminarDigitacion() {
    $(".adjuntos .btn-eliminar").off("click");
    $(".adjuntos .btn-eliminar").click(function (e) { // Eliminar digitación

        e.preventDefault();

        let id_digitacion = $(this).data("idreferencia");

        swal({
            text: "¿Está seguro de eliminar la digitación realizada? Esto no eliminará las medias previamente asignadas...",
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
            if (eleccion) {

                data_delete = {
                    tipo: "eliminacion",
                    idreferencia: id_digitacion
                };

                data_delete = JSON.stringify(data_delete);

                $.post(
                    "php/digitacion_data_change_handler.php", {
                        data_ajax: data_delete
                    },
                    function () {
                        /* No realizar nada de momento */
                    }
                ).done(function (responseXML) {
                    try {
                        var response = responseXML.getElementsByTagName("response")[0];
                        var code = parseInt(response.getAttribute("code"), 10);
                        if (code == 0) {
                            statusBox("warning", 'NULL', "Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.", 'add', 'NULL');
                        } else { // Si la respuesta fue exitosa
                            statusBox("success", 'NULL', "Se ha eliminado la digitacion especificada satisfactoriamente!...", 'add', 'NULL');
                            listarInformacionDigitacion();
                        }
                    } catch (e) {
                        statusBox("warning", 'NULL', "Ha ocurrido un error de javascript, por favor intente nuevamente...", 'add', 'NULL');
                    }
                }).fail(function () {
                    statusBox("warning", 'NULL', "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...", 'add', 'NULL');
                }).always(function (ssasas) {
                    console.log(ssasas);
                });
            }
        });
    });
}


function eventoOrdenamiento() {
    var evn = false;
    $("#tabla-dinamica thead tr").off("click");
    $("#tabla-dinamica thead tr").click(function () {

        if (evn) {
            $(this).find("td").html("<span><i class='fas fa-sort-amount-down'></i> Viendo más antiguas primero</span>");
            evn = false;
        } else {
            $(this).find("td").html("<span><i class='fas fa-sort-amount-up'></i> Viendo más recientes primero</span>");
            evn = true;
        }

    });
}


function eventoDespliegueSolicitudes() {
    $(".pliegue").off("click");
    $(".pliegue").click(function () {
        $(this).parents(".digitacion").find(".cont-info-digitacion").slideToggle(300);
    });
}


// Evento guardar modificacion
function eventoGuardarModificacion() {
    $(".btn-guardar-cambios").off("click");
    $(".btn-guardar-cambios").click(function (e) {

        e.preventDefault();
        let elementEvent = $(this);

        if (validarDigitacion(elementEvent)) { // Si la digitacion es positiva

            if (tipoProgramaCualitativo(elementEvent)) { // Si es cualitativo
                // No hacer nada
            } else {
                if (!alertarDigitacion(elementEvent)) {
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


function ejecutarGuardado(elementEvent) {
    // Construir JSON para enviar a guardar
    let filasGestion = $("#cont-tabla-gestiones tbody tr");
    let datos_digitacion = [];

    filasGestion.each(function (index, val) {

        let trActual = filasGestion.eq(index);

        datos_digitacion.push({
            id_digitacion_cuantitativa: ((typeof trActual.data("idreferencia") == "undefined") ? 0 : trActual.data("idreferencia")),
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
        tipo: "modificacion",
        id_digitacion: elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #id_digitacion").val(),
        programa: elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #programa").val(),
        lote: elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #lote").val(),
        mes: elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #mes").val() + "-01",
        datos_digitacion: datos_digitacion,
        tipo_programa: (tipoProgramaCualitativo(elementEvent)) ? "cualitativo" : "cuantitativo"
    };

    elementEvent.prop("disabled", true);
    elementEvent.text("Guardando cambios...");

    data_ajax = JSON.stringify(data_ajax);

    $.post(
        "php/digitacion_data_change_handler.php", {
            data_ajax: data_ajax
        },
        function () {}
    ).done(function (responseXML) {

        var response = responseXML.getElementsByTagName("response")[0];
        var code = parseInt(response.getAttribute("code"), 10);

        if (code == 0) {
            statusBox("warning", 'NULL', "Ha ocurrido algo inesperado, por favor intente nuevamente...", 'add', 'NULL');
        } else {
            statusBox("success", 'NULL', "¡Digitación guardada exitosamente!", 'add', 'NULL');
            listarInformacionDigitacion();
            eliminarModal($(".cont-modal-modificacion"));
        }

    }).fail(function () {
        statusBox("warning", 'NULL', "Ha ocurrido algo inesperado, por favor intente nuevamente...", 'add', 'NULL');
    }).always(function (sdsd) {
        console.log(sdsd);
        elementEvent.prop("disabled", false);
        elementEvent.text("Guardar cambios");
    });
}

function eventoAsignarDigitacion() {
    $(".adjuntos .btn-asignar-digitacion").off("click");
    $(".adjuntos .btn-asignar-digitacion").click(function (e) {

        e.preventDefault();

        let id_digitacion = $(this).data("idreferencia");
        let tipoprograma = $(this).data("tipoprograma");
        let idprograma = $(this).data("idprograma");

        let contModal = $(".cont-modal-asignacion");
        contModal.html(""); // Vaciar cualquier modal que se encuentre abierto

        let modalPersonalize = $(
            '<div class="modal cont-referencia-selectores" tabindex="-1" role="dialog">' +
            '                <div class="modal-dialog">' +
            '                    <div class="modal-content">' +
            '                    <div class="modal-header">' +
            '                        <h5 class="modal-title"><strong>Asignación de digitación</strong><span id="titulo-modal"></span></h5>' +
            '</div>' +
            '<div class="modal-body">' +
            'Cargando información...' +
            '</div>' +
            '                    <div class="modal-footer">' +
            '                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>' +
            '                        <button type="button" class="btn btn-primary btn-guardar-asig-for7" data-idreferencia="' + id_digitacion + '" data-idprograma="' + idprograma + '">Guardar todos los cambios</button>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>'
        );

        contModal.html(modalPersonalize);

        generarInfoAsignacion(tipoprograma, id_digitacion, idprograma);

        contModal.find(".modal").modal({
            backdrop: "static",
            keyboard: false,
            show: true
        });


        id_digitacion = null;
        tipoprograma = null;
        idprograma = null;
        contModal = null;
        modalPersonalize = null;
    });
}


function generarInfoAsignacion(tipoprograma, idreferencia, idprograma) {

    switch (tipoprograma) {
        case "cuantitativo":

            let data_ajax = {
                tipo: "SeeInfoAsignacion",
                tipo_programa: "cuantitativo",
                idreferencia: idreferencia
            }

            data_ajax = JSON.stringify(data_ajax);

            $.post(
                "php/digitacion_data_change_handler.php", {
                    data_ajax: data_ajax
                },
                function () {
                    /* No hacer nada de momento */
                }
            ).done(function (responseXML) {
                try {
                    var response = responseXML.getElementsByTagName("response")[0];
                    var code = parseInt(response.getAttribute("code"), 10);
                    if (code == 0) {
                        statusBox("warning", 'NULL', "Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.", 'add', 'NULL');
                    } else { // Si la respuesta fue exitosa

                        let dataChangeSecond = {
                            tipo: "SeeInfoModificacion",
                            tipo_programa: "cuantitativo",
                            idreferencia: idreferencia,
                            idprograma: idprograma
                        }

                        dataChangeSecond = JSON.stringify(dataChangeSecond);

                        $.post(
                            "php/digitacion_data_change_handler.php", {
                                data_ajax: dataChangeSecond
                            },
                            function () {
                                /* No hacer nada por el momento... */
                            }
                        ).done(function (responseXMLSub) {
                            var responseSub = responseXMLSub.getElementsByTagName("response")[0];
                            var codeSub = parseInt(responseSub.getAttribute("code"), 10);
                            if (codeSub == 0) {
                                statusBox("warning", 'NULL', "Ha ocurrido algo inesperado con la respuesta de la consulta para las gestiones de la digitación, por favor intente nuevamente...", 'add', 'NULL');
                            } else {

                                // Asignar a una variable global la informacion de la digitacion
                                let info_digitacion = JSON.parse($(responseSub).html());
                                window.info_digitacion = info_digitacion.digitaciones[0];

                                // Agregar los analitos mediante una lista
                                let contModal = $(".cont-modal-asignacion");
                                contModal.find(".modal-body").html($(response).html());
                                contModal.find("#arbol-muestras").fancytree({
                                    checkbox: true,
                                    selectMode: 3
                                });
                                let targetNode = document.querySelector('.ui-fancytree');
        
                                if (targetNode) {
                                    let observer = new MutationObserver(function (mutationsList) {
                                        for (let mutation of mutationsList) {
                                            if (mutation.type === 'childList') {
                                                eventoChangeAnalito(); // Llamar la función cuando haya cambios
                                            }
                                        }
                                    });
                        
                                    observer.observe(targetNode, { childList: true, subtree: true });
                                }

                                // Generar eventos para los botones de asignacion
                                eventoAsignarMensual();
                                eventoAsignarAcumulada();
                                eventoAsignarInserto();
                                eventoAsignarConsenso();
                                eventoAsignarJCTLM();
                                eventoGuardarCambios();
                            }
                        }).fail(function () {
                            statusBox("warning", 'NULL', "Ha ocurrido algo inesperado en la consulta de las gestiones de digitación, por favor intente nuevamente...", 'add', 'NULL');
                        }).always(function (asASQW) {
                            console.log(asASQW);
                        });
                    }
                } catch (e) {
                    statusBox("warning", 'NULL', "Ha ocurrido un error de javascript, por favor intente nuevamente...", 'add', 'NULL');
                }
            }).fail(function () {
                statusBox("warning", 'NULL', "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...", 'add', 'NULL');
            }).always(function (ssasas) {
                console.log(ssasas);
            });
            break;
        case "cualitativo":
            break;

            data_ajax = null;
    }

}



function eventoChangeAnalito() {
    let analitosDigitacion = $(".cont-modal-asignacion").find(".analito-digitacion");
    analitosDigitacion.off("change");
    analitosDigitacion.on("change", function (e) {
        e.preventDefault();
        listarMediasGeneralesAnalito($(this));
        listarMediasJCTLMAnalito($(this));
    });
}


function listarMediasGeneralesAnalito(elemento, predeterminadoMedia = null) {

    let val = elemento.val();
    let hermanoMedias = elemento.siblings(".m-wwr");
    let hermanoTipoConsenso = elemento.siblings(".tipo_consenso");
    let primerOptionHermano = hermanoMedias.find("option").eq(0);
    let optionTemp;

    // Igualar el hermano de medias a su primera opcion *la predeterminada
    hermanoMedias.html(primerOptionHermano);

    if (val != 0) { // Si ya esta definido
        // Buscar id en variable global
        for (let contDMGA = 0; contDMGA < window.info_digitacion.digitacion_cuantitativa.length; contDMGA++) {
            var gDigitacionAct = window.info_digitacion.digitacion_cuantitativa[contDMGA];
            if (gDigitacionAct.id_digitacion_cuantitativa == val) {
                // Desfragmenta las medias en tres partes diferentes

                // Al cambiar la informacion del analito, por defecto aplicar el tipo  de par
                hermanoTipoConsenso.find("option[value=1]").prop("selected", true);

                // Se realiza el proceso con las medias mensuales
                if (gDigitacionAct.media_mensual != "" && gDigitacionAct.de_mensual != "" && gDigitacionAct.cv_mensual != "" && gDigitacionAct.n_puntos_mensual != "") { // Debe estar la informacion completa

                    optionTemp = $("<option value='1'>(Mensual) Media: " + gDigitacionAct.media_mensual + " | D.E.: " + gDigitacionAct.de_mensual + " | C.V. " + gDigitacionAct.cv_mensual + " | N: " + gDigitacionAct.n_puntos_mensual + "</option>");

                    if (predeterminadoMedia == 1) { // Si el predeterminado es mensual
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoMedias.append(optionTemp);
                } else {
                    optionTemp = $("<option value='1'>(Mensual) (Informacion incompleta) Media: " + gDigitacionAct.media_mensual + " | D.E.: " + gDigitacionAct.de_mensual + " | C.V. " + gDigitacionAct.cv_mensual + " | N: " + gDigitacionAct.n_puntos_mensual + "</option>");

                    if (predeterminadoMedia == 1) { // Si el predeterminado es mensual
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoMedias.append(optionTemp);
                }

                // Se realiza el proceso con las medias acumuladas
                if (gDigitacionAct.media_acumulada != "" && gDigitacionAct.de_acumulada != "" && gDigitacionAct.cv_acumulada != "" && gDigitacionAct.n_puntos_acumulada != "") { // Debe estar la informacion completa

                    optionTemp = $("<option value='2'>(Acumulada) Media: " + gDigitacionAct.media_acumulada + " | D.E.: " + gDigitacionAct.de_acumulada + " | C.V.: " + gDigitacionAct.cv_acumulada + " | N: " + gDigitacionAct.n_puntos_acumulada + "</option>");

                    if (predeterminadoMedia == 2) { // Si el predeterminado es acumulada
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoMedias.append(optionTemp);
                } else {
                    optionTemp = $("<option value='2'>(Acumulada) (Informacion incompleta) Media: " + gDigitacionAct.media_acumulada + " | D.E.: " + gDigitacionAct.de_acumulada + " | C.V.: " + gDigitacionAct.cv_acumulada + " | N: " + gDigitacionAct.n_puntos_acumulada + "</option>");

                    if (predeterminadoMedia == 2) { // Si el predeterminado es acumulada
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoMedias.append(optionTemp);
                }

                // Se realiza el proceso con las medias de inserto
                if (gDigitacionAct.media_inserto != "" && gDigitacionAct.de_inserto != "" && gDigitacionAct.cv_inserto != "" && gDigitacionAct.n_inserto != "") { // Debe estar la informacion completa

                    optionTemp = $("<option value='3'>(Inserto) Media: " + gDigitacionAct.media_inserto + " | D.E.: " + gDigitacionAct.de_inserto + " | C.V.: " + gDigitacionAct.cv_inserto + " | N: " + gDigitacionAct.n_inserto + "</option>");

                    if (predeterminadoMedia == 3) { // Si el predeterminado es acumulada
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoMedias.append(optionTemp);
                } else {
                    optionTemp = $("<option value='3'>(Inserto) (Informacion incompleta) Media: " + gDigitacionAct.media_inserto + " | D.E.: " + gDigitacionAct.de_inserto + " | C.V.: " + gDigitacionAct.cv_inserto + " | N: " + gDigitacionAct.n_inserto + "</option>");

                    if (predeterminadoMedia == 3) { // Si el predeterminado es acumulada
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoMedias.append(optionTemp);
                }

                contDMGA = window.info_digitacion.digitacion_cuantitativa.length; // Para salir del bucle
            }
        }


        // Siempre imprimir el valor de media por consenso
        optionTemp = $("<option value='4'>*** (Consenso) Los valores se generarán automáticamente al exportar el reporte ***</option>");

        if (predeterminadoMedia == 4) { // Si el predeterminado es consenso
            optionTemp.prop("selected", true); // Selecciona el campo

            // Si se asigna un valor de consenso, aplicar por defecto el valor de todos los laboratorios
            hermanoTipoConsenso.find("option[value=3]").prop("selected", true);
        }

        hermanoMedias.append(optionTemp);

    }
}


function listarMediasJCTLMAnalito(elemento, predeterminadoJTCLM = false) {
    let val = elemento.val();
    let hermanoETmp = elemento.siblings(".m-jctlm");
    let primerOptionHermanoJCTLM = hermanoETmp.find("option").eq(0);
    let optionTemp;

    // Igualar el hermano de medias a su primera opcion *la predeterminada
    hermanoETmp.html(primerOptionHermanoJCTLM);

    if (val != 0) { // Si ya esta definido
        // Buscar id en variable global
        for (let contDMGA = 0; contDMGA < window.info_digitacion.digitacion_cuantitativa.length; contDMGA++) {
            var gDigitacionAct = window.info_digitacion.digitacion_cuantitativa[contDMGA];
            if (gDigitacionAct.id_digitacion_cuantitativa == val) {

                // Se realiza el proceso con las medias de JCTLM
                if (gDigitacionAct.media_jctlm != "" && gDigitacionAct.etmp_jctlm != "") { // Debe estar la informacion completa

                    optionTemp = $("<option value='1'>Media: " + gDigitacionAct.media_jctlm + " | ETmp%: " + gDigitacionAct.etmp_jctlm + "</option>");

                    if (predeterminadoJTCLM == true) {
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoETmp.append(optionTemp);
                } else {
                    optionTemp = $("<option value='1'>(Informacion incompleta) Media: " + gDigitacionAct.media_jctlm + " | ETmp%: " + gDigitacionAct.etmp_jctlm + "</option>");

                    if (predeterminadoJTCLM == true) {
                        optionTemp.prop("selected", true); // Selecciona el campo
                    }

                    hermanoETmp.append(optionTemp);
                }

                contDMGA = window.info_digitacion.digitacion_cuantitativa.length; // Para salir del bucle
            }
        }
    }
}

function eventoAsignarMensual() {
    $("#btn-asignar-mensual").off("click");
    $("#btn-asignar-mensual").click(function (e) {
        let analitosVisibles = $(".cont-modal-asignacion .modal-body .ui-fancytree li[aria-selected=true]").children(".fancytree-node").children(".fancytree-title").children(".contenedor-config:visible");
        let counterAnalites = analitosVisibles.length;
        if (counterAnalites == 0) {
            statusBox("info", 'NULL', "No hay analitos por asignar...", 'add', 'NULL');
        } else {
            swal({
                text: "Esta apunto de empalmar una asignación con la media MENSUAL para (" + counterAnalites + ") analitos ¿Desea continuar?",
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
                if (eleccion) {
                    loaderPersonalizado("show");
                    setTimeout(function () {
                        let contadorAsignaciones = 0;

                        // Por cada mensurando visible hace un recorrido
                        for (countAV = 0; countAV < analitosVisibles.length; countAV++) {

                            let analitoVisibleActual = analitosVisibles.eq(countAV);

                            // Mensurando del laboratorio
                            let id_analito_av = analitoVisibleActual.find(".analito").data("idreferencia");
                            let id_analizador_av = analitoVisibleActual.find(".analizador").data("idreferencia");
                            let id_gen_vitros_av = analitoVisibleActual.find(".gen_vitros").data("idreferencia");
                            let id_metodologia_av = analitoVisibleActual.find(".metodologia").data("idreferencia");
                            let id_unidad_av = analitoVisibleActual.find(".unidad").data("idreferencia");
                            let info_lab = {
                                id_analito_av: id_analito_av,
                                id_analizador_av: id_analizador_av,
                                id_gen_vitros_av: id_gen_vitros_av,
                                id_metodologia_av: id_metodologia_av,
                                id_unidad_av: id_unidad_av
                            };

                            if (id_analito_similitud = automatizacion_qapfor07("par", info_lab, window.info_digitacion.digitacion_cuantitativa)) { // buscar un mensurando digitado es exactamente igual al del laboratorio (GRUPO PAR)

                                contadorAsignaciones++;
                                // Seleccionar el mensurando en el desplegable
                                analitoVisibleActual.find(".analito-digitacion").find("option[value=" + id_analito_similitud + "]").prop("selected", true);
                                listarMediasGeneralesAnalito(analitoVisibleActual.find(".analito-digitacion"), 1);


                            } else if (id_analito_similitud = automatizacion_qapfor07("método", info_lab, window.info_digitacion.digitacion_cuantitativa)) { // buscar un mensurando digitado igual sin el mismo equipo al del laboratorio (GRUPO MÉTODO)
                                contadorAsignaciones++;
                                // Seleccionar el mensurando en el desplegable
                                analitoVisibleActual.find(".analito-digitacion").find("option[value=" + id_analito_similitud + "]").prop("selected", true);
                                listarMediasGeneralesAnalito(analitoVisibleActual.find(".analito-digitacion"), 1);
                            }

                            analitoVisibleActual = null;
                            id_analito_av = null;
                            id_analizador_av = null;
                            id_gen_vitros_av = null;
                            id_metodologia_av = null;
                            id_unidad_av = null;
                            info_lab = null;
                        }

                        statusBox("success", 'NULL', "(" + contadorAsignaciones + ") Analitos fueron asignados...", 'add', 'NULL');
                        loaderPersonalizado("hide");
                    }, 100);
                }
            });
        }
    });
}


function eventoAsignarAcumulada() {
    $("#btn-asignar-acumulada").off("click");
    $("#btn-asignar-acumulada").click(function (e) {
        let analitosVisibles = $(".cont-modal-asignacion .modal-body .ui-fancytree li[aria-selected=true]").children(".fancytree-node").children(".fancytree-title").children(".contenedor-config:visible");
        let counterAnalites = analitosVisibles.length;
        if (counterAnalites == 0) {
            statusBox("info", 'NULL', "No hay analitos por asignar...", 'add', 'NULL');
        } else {
            swal({
                text: "Esta apunto de empalmar una asignación con la media ACUMULADA para (" + counterAnalites + ") analitos ¿Desea continuar?",
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
                if (eleccion) {
                    loaderPersonalizado("show");
                    setTimeout(function () {

                        let contadorAsignaciones = 0;

                        for (countAV = 0; countAV < analitosVisibles.length; countAV++) {

                            let analitoVisibleActual = analitosVisibles.eq(countAV);

                            // Mensurando del laboratorio
                            let id_analito_av = analitoVisibleActual.find(".analito").data("idreferencia");
                            let id_analizador_av = analitoVisibleActual.find(".analizador").data("idreferencia");
                            let id_gen_vitros_av = analitoVisibleActual.find(".gen_vitros").data("idreferencia");
                            let id_metodologia_av = analitoVisibleActual.find(".metodologia").data("idreferencia");
                            let id_unidad_av = analitoVisibleActual.find(".unidad").data("idreferencia");
                            let info_lab = {
                                id_analito_av: id_analito_av,
                                id_analizador_av: id_analizador_av,
                                id_gen_vitros_av: id_gen_vitros_av,
                                id_metodologia_av: id_metodologia_av,
                                id_unidad_av: id_unidad_av
                            }


                            if (id_analito_similitud = automatizacion_qapfor07("par", info_lab, window.info_digitacion.digitacion_cuantitativa)) { // buscar un mensurando digitado es exactamente igual al del laboratorio (GRUPO PAR)

                                contadorAsignaciones++;
                                // Seleccionar el mensurando en el desplegable
                                analitoVisibleActual.find(".analito-digitacion").find("option[value=" + id_analito_similitud + "]").prop("selected", true);
                                listarMediasGeneralesAnalito(analitoVisibleActual.find(".analito-digitacion"), 2);


                            } else if (id_analito_similitud = automatizacion_qapfor07("método", info_lab, window.info_digitacion.digitacion_cuantitativa)) { // buscar un mensurando digitado igual sin el mismo equipo al del laboratorio (GRUPO MÉTODO)
                                contadorAsignaciones++;
                                // Seleccionar el mensurando en el desplegable
                                analitoVisibleActual.find(".analito-digitacion").find("option[value=" + id_analito_similitud + "]").prop("selected", true);
                                listarMediasGeneralesAnalito(analitoVisibleActual.find(".analito-digitacion"), 2);
                            }

                            analitoVisibleActual = null;
                            id_analito_av = null;
                            id_analizador_av = null;
                            id_gen_vitros_av = null;
                            id_metodologia_av = null;
                            id_unidad_av = null;
                            info_lab = null;
                        }
                        statusBox("success", 'NULL', "(" + contadorAsignaciones + ") Analitos fueron asignados...", 'add', 'NULL');
                        loaderPersonalizado("hide");
                    }, 100);
                }
            });
        }
    });
}


function eventoAsignarInserto() {
    $("#btn-asignar-inserto").off("click");
    $("#btn-asignar-inserto").click(function (e) {

        let analitosVisibles = $(".cont-modal-asignacion .modal-body .ui-fancytree li[aria-selected=true]").children(".fancytree-node").children(".fancytree-title").children(".contenedor-config:visible");

        let counterAnalites = analitosVisibles.length;

        if (counterAnalites == 0) {
            statusBox("info", 'NULL', "No hay analitos por asignar...", 'add', 'NULL');
        } else {
            swal({
                text: "Esta apunto de empalmar una asignación con la media de inserto para (" + counterAnalites + ") analitos ¿Desea continuar?",
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
                if (eleccion) {

                    loaderPersonalizado("show");
                    setTimeout(function () {
                        let contadorAsignaciones = 0;

                        for (countAV = 0; countAV < analitosVisibles.length; countAV++) {

                            let analitoVisibleActual = analitosVisibles.eq(countAV);

                            // Mensurando del laboratorio
                            let id_analito_av = analitoVisibleActual.find(".analito").data("idreferencia");
                            let id_analizador_av = analitoVisibleActual.find(".analizador").data("idreferencia");
                            let id_gen_vitros_av = analitoVisibleActual.find(".gen_vitros").data("idreferencia");
                            let id_metodologia_av = analitoVisibleActual.find(".metodologia").data("idreferencia");
                            let id_unidad_av = analitoVisibleActual.find(".unidad").data("idreferencia");
                            let info_lab = {
                                id_analito_av: id_analito_av,
                                id_analizador_av: id_analizador_av,
                                id_gen_vitros_av: id_gen_vitros_av,
                                id_metodologia_av: id_metodologia_av,
                                id_unidad_av: id_unidad_av
                            };

                            if (id_analito_similitud = automatizacion_qapfor07("par", info_lab, window.info_digitacion.digitacion_cuantitativa)) { // buscar un mensurando digitado es exactamente igual al del laboratorio (GRUPO PAR)

                                contadorAsignaciones++;
                                // Seleccionar el mensurando en el desplegable
                                analitoVisibleActual.find(".analito-digitacion").find("option[value=" + id_analito_similitud + "]").prop("selected", true);
                                listarMediasGeneralesAnalito(analitoVisibleActual.find(".analito-digitacion"), 3);


                            } else if (id_analito_similitud = automatizacion_qapfor07("método", info_lab, window.info_digitacion.digitacion_cuantitativa)) { // buscar un mensurando digitado igual sin el mismo equipo al del laboratorio (GRUPO MÉTODO)
                                contadorAsignaciones++;
                                // Seleccionar el mensurando en el desplegable
                                analitoVisibleActual.find(".analito-digitacion").find("option[value=" + id_analito_similitud + "]").prop("selected", true);
                                listarMediasGeneralesAnalito(analitoVisibleActual.find(".analito-digitacion"), 3);
                            }

                            analitoVisibleActual = null;
                            id_analito_av = null;
                            id_analizador_av = null;
                            id_gen_vitros_av = null;
                            id_metodologia_av = null;
                            id_unidad_av = null;
                            info_lab = null;
                        }

                        statusBox("success", 'NULL', "(" + contadorAsignaciones + ") Analitos fueron asignados...", 'add', 'NULL');
                        loaderPersonalizado("hide");
                    }, 100);
                }
            });
        }
    });
}

function eventoAsignarConsenso() {
    $("#btn-asignar-consenso").off("click");
    $("#btn-asignar-consenso").click(function (e) {

        let analitosVisibles = $(".cont-modal-asignacion .modal-body .ui-fancytree li[aria-selected=true]").children(".fancytree-node").children(".fancytree-title").children(".contenedor-config:visible");
        let counterAnalites = analitosVisibles.length;

        if (counterAnalites == 0) {
            statusBox("info", 'NULL', "No hay analitos por asignar...", 'add', 'NULL');
        } else {
            swal({
                text: "Esta apunto de empalmar una asignación con la media de consenso para (" + counterAnalites + ") analitos ¿Desea continuar?",
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
                if (eleccion) {

                    loaderPersonalizado("show");
                    setTimeout(function () {
                        let contadorAsignaciones = 0;
                        for (countAV = 0; countAV < analitosVisibles.length; countAV++) {

                            let analitoVisibleActual = analitosVisibles.eq(countAV);
                            // Selecciona por defecto al mensurando que contiene la opcion del consenso
                            analitoVisibleActual.find(".analito-digitacion").find("option[value=val_analit_consenso]").prop("selected", true);
                            listarMediasGeneralesAnalito(analitoVisibleActual.find(".analito-digitacion"), 4);
                            contadorAsignaciones++;
                        }
                        statusBox("success", 'NULL', "(" + contadorAsignaciones + ") Analitos fueron asignados...", 'add', 'NULL');
                        loaderPersonalizado("hide");
                    }, 100);


                }
            });
        }
    });
}

function eventoAsignarJCTLM() {
    $("#btn-asignar-jctlm").off("click");
    $("#btn-asignar-jctlm").click(function (e) {

        let analitosVisibles = $(".cont-modal-asignacion .modal-body .ui-fancytree li[aria-selected=true]").children(".fancytree-node").children(".fancytree-title").children(".contenedor-config:visible");
        let counterAnalites = analitosVisibles.length;

        if (counterAnalites == 0) {
            statusBox("info", 'NULL', "No hay analitos por asignar...", 'add', 'NULL');
        } else {
            swal({
                text: "Esta apunto de empalmar una asignación con la media del JCTLM para (" + counterAnalites + ") analitos ¿Desea continuar?",
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
                if (eleccion) {

                    loaderPersonalizado("show");
                    setTimeout(function () {
                        let contadorAsignaciones = 0;

                        for (countAV = 0; countAV < analitosVisibles.length; countAV++) {

                            let analitoVisibleActual = analitosVisibles.eq(countAV);

                            let id_analito_av = analitoVisibleActual.find(".analito").data("idreferencia");
                            let id_analizador_av = analitoVisibleActual.find(".analizador").data("idreferencia");
                            let id_gen_vitros_av = analitoVisibleActual.find(".gen_vitros").data("idreferencia");
                            let id_metodologia_av = analitoVisibleActual.find(".metodologia").data("idreferencia");
                            let id_unidad_av = analitoVisibleActual.find(".unidad").data("idreferencia");
                            let info_lab = {
                                id_analito_av: id_analito_av,
                                id_analizador_av: id_analizador_av,
                                id_gen_vitros_av: id_gen_vitros_av,
                                id_metodologia_av: id_metodologia_av,
                                id_unidad_av: id_unidad_av
                            };

                            if (id_analito_similitud = automatizacion_qapfor07("unidad", info_lab, window.info_digitacion.digitacion_cuantitativa)) { // buscar un mensurando digitado es exactamente igual al del laboratorio (GRUPO PAR)

                                contadorAsignaciones++;
                                // Seleccionar el mensurando en el desplegable
                                analitoVisibleActual.find(".analito-digitacion").find("option[value=" + id_analito_similitud + "]").prop("selected", true);
                                listarMediasJCTLMAnalito(analitoVisibleActual.find(".analito-digitacion"), true);


                            }

                            analitoVisibleActual = null;
                            id_analito_av = null;
                            id_analizador_av = null;
                            id_gen_vitros_av = null;
                            id_metodologia_av = null;
                            id_unidad_av = null;
                            info_lab = null;
                        }
                        statusBox("success", 'NULL', "(" + contadorAsignaciones + ") Analitos fueron asignados...", 'add', 'NULL');
                        loaderPersonalizado("hide");
                    }, 100);
                }
            });
        }
    });
}


function ejecutarGuardarCambios(elementEvent, ejecutarAlertasBackend, id_digitacion, idprograma, e) {
    elementEvent.prop("disabled", true);
    elementEvent.html("Guardando...");

    e.preventDefault();
    let analitosVisibles = $(".cont-modal-asignacion .modal-body .ui-fancytree li").children(".fancytree-node").children(".fancytree-title").children(".contenedor-config");

    let obj_json_save = [];

    $.each(analitosVisibles, function (index, val) {

        let analitoVisibleActual = analitosVisibles.eq(index);

        if (analitoVisibleActual.find(".analito-digitacion").val() != 0) { // Debe haberse definido un mensurando distinto al predeterminado
            if (analitoVisibleActual.find(".m-wwr").val() != 0 || analitoVisibleActual.find(".m-jctlm").val() != 0) { // Con que una sola este definida basta
                obj_json_save.push({
                    id_laboratorio_av: analitoVisibleActual.data("idlaboratorio"),
                    id_muestra_av: analitoVisibleActual.data("idmuestra"),
                    id_configuracion_laboratorio_analito: analitoVisibleActual.data("id_configuracion_laboratorio_analito"),
                    nivel_lote_av: analitoVisibleActual.data("nivellote"),
                    id_analito_av: analitoVisibleActual.find(".analito").data("idreferencia"),
                    id_analizador_av: analitoVisibleActual.find(".analizador").data("idreferencia"),
                    id_gen_vitros_av: analitoVisibleActual.find(".gen_vitros").data("idreferencia"),
                    id_reactivo_av: analitoVisibleActual.find(".reactivo").data("idreferencia"),
                    id_metodologia_av: analitoVisibleActual.find(".metodologia").data("idreferencia"),
                    id_unidad_av: analitoVisibleActual.find(".unidad").data("idreferencia"),
                    analito_digitacion: analitoVisibleActual.find(".analito-digitacion").val(),
                    m_wwr: analitoVisibleActual.find(".m-wwr").val(),
                    m_jctlm: analitoVisibleActual.find(".m-jctlm").val()
                });
            }
        }
    });

    if (obj_json_save.length > 0) {

        let data_ajax_s = {
            tipo: "guardarAsignacion",
            tipo_programa: "cuantitativo",
            idprograma: idprograma,
            obj_json_save: obj_json_save,
            ejecutar_alertas_backend: ejecutarAlertasBackend,
            fecha_corte: $("#fecha_corte_asignacion_consenso").val()
        }

        data_ajax_s = JSON.stringify(data_ajax_s);

        $.post(
            "php/digitacion_data_change_handler.php", {
                data_ajax: data_ajax_s
            },
            function () {
                /* No hacer nada por el momento */
            }
        ).done(function (responseXML) {
            try {
                var response = responseXML.getElementsByTagName("response")[0];
                var code = parseInt(response.getAttribute("code"), 10);

                console.log(code);
                console.log(response);

                if (code == 0) {
                    statusBox("warning", 'NULL', "Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.", 'add', 'NULL');
                } else if (code == 422) {

                    response = $(response).html();
                    console.log(response);

                    swal({
                        title: "Alerta de asignación",
                        content: $(
                            "<div>" +
                            response +
                            "<br />" +
                            "<p><strong>¿Está seguro de continuar? Esto puede generar conflictos en el reporte final de QAP</strong></p>" +
                            "</div>")[0],
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
                        if (eleccion) {
                            ejecutarGuardarCambios(elementEvent, false, id_digitacion, idprograma, e)
                        }
                    });
                } else { // Si la respuesta fue exitosa
                    statusBox("success", 'NULL', "¡Se ha guardado la información de manera satisfactoria!", 'add', 'NULL');
                    generarInfoAsignacion("cuantitativo", id_digitacion, idprograma);
                }
            } catch (e) {
                statusBox("warning", 'NULL', "Ha ocurrido un error de javascript, por favor intente nuevamente...", 'add', 'NULL');
            }
        }).fail(function () {
            statusBox("warning", 'NULL', "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...", 'add', 'NULL');
        }).always(function (ssasas) {
            console.log(ssasas);
            elementEvent.prop("disabled", false);
            elementEvent.html("Guardar todos los cambios");
        });
    } else {
        statusBox("warning", 'NULL', "No hay informacion por guardar...", 'add', 'NULL');
        elementEvent.prop("disabled", false);
        elementEvent.html("Guardar todos los cambios");
    }
}

function eventoGuardarCambios() {
    $(".btn-guardar-asig-for7").off("click");
    $(".btn-guardar-asig-for7").click(function (e) {
        let id_digitacion = $(this).data("idreferencia");
        let idprograma = $(this).data("idprograma");
        ejecutarGuardarCambios($(this), true, id_digitacion, idprograma, e);
    });
}