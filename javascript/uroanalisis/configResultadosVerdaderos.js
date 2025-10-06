$(function () {
  $(".btn-config-posibles-resultados").off("click");
  $(".btn-config-posibles-resultados").click(function (e) {
    let programa = $("#formLabProgramainput2").eq(0).val();
    let laboratorio = $("#formLabProgramainput1").eq(0).val();
    let lote = $("#formLabProgramainput3").eq(0).val();
    listarInformacionDigitacion(laboratorio, programa, lote);
  });
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

function listarInformacionDigitacion(laboratorio, programa, lote) {
  // console.log("laboratorioId: ",laboratorio," programaId: ",programa," loteId: ",lote);
  if (programa == "" || programa == undefined) {
    programa = 0;
  }

  let datos = {
    tipo: "visualizacion",
    laboratorio: laboratorio,
    programa: programa,
    lote: lote,
  };

  datos = JSON.stringify(datos);
  $.post(
    "../../php/uroanalisis/posiblesResultados/digitacion_data_change_handler.php",
    { data_ajax: datos },
    function () {
      /* No hacer nada temporalmente */
    }
  )
    .done(function (responseXML) {
      try {
        var response = responseXML.getElementsByTagName("response")[0];
        // console.log(response);
        var code = parseInt(response.getAttribute("code"), 10);
        if (code == 422) {
          statusBox("warning", "NULL", response.textContent, "add", "NULL");
        } else if (code == 0) {
          // alert("algo falló");

          statusBox(
            "warning",
            "NULL",
            "Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.",
            "add",
            "NULL"
          );
        } else {
          response = $(response).html();
          // console.log(response);
          if (validarSiJSON(response)) {
            var digitaciones = JSON.parse(response);
            let cont_digitaciones = $(".cont-digitaciones-realizadas");
            if (digitaciones.length == 0) {
              // Si no hay digitaciones para la busqueda
              let mensajeHTML = `
              <div>
                <hr>
                <div>
                  No hay digitación para el criterio de búsqueda...
                  <br><br>
                  Por favor, verifica lo siguiente:
                  <ul>
                    <li>Que el laboratorio y el programa seleccionado hayan sido registrados para esta digitación con ese lote.</li>
                  </ul>
                </div>
              </div>
            `;
              cont_digitaciones.html(mensajeHTML);
            } else {
              eventoModificarDigitacion(
                digitaciones[0]["id_digitaciones_uroanalisis"],
                "cualitativo",
                laboratorio,
                programa,
                lote
              );
            }
          } else {
            // Si no es JSON
            statusBox(
              "warning",
              "NULL",
              "Al parecer aún no hay resultados para la selección...",
              "add",
              "NULL"
            );
          }
        }
      } catch (e) {
        statusBox(
          "warning",
          "NULL",
          "Ha ocurrido un error de javascript, por favor intente nuevamente...",
          "add",
          "NULL"
        );
      }
    })
    .fail(function () {
      statusBox(
        "warning",
        "NULL",
        "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...",
        "add",
        "NULL"
      );
    })
    .always(function (sdsd) {
      console.log(sdsd);
    });
}

function eventoModificarDigitacion(
  idDigitacionUroanalisis,
  tipo_programa,
  laboratorio,
  programa,
  lote
) {
  let id_digitacion = idDigitacionUroanalisis;
  let tipoprograma = tipo_programa;

  let contModal = $(".cont-modal-modificacion");
  contModal.html(""); // Vaciar cualquier modal que se encuentre abierto

  let modalPersonalize = $(
    '<div class="modal cont-referencia-selectores" tabindex="-1" role="dialog">' +
      '                <div class="modal-dialog">' +
      '                    <div class="modal-content">' +
      '                    <div class="modal-header">' +
      '                        <h5 class="modal-title"><strong>Modificación de digitación</strong></h5>' +
      "</div>" +
      '<div class="modal-body">' +
      '<div class="col-xs-12 no-margin no-padding cont-selectores" id="formDigitacion">' +
      '<div class="col-xs-3">' +
      '<input type="hidden" class="form-control input-sm" id="id_digitacion">' +
      '<div class="form-group">' +
      '<label for="laboratorio">Laboratorio</label>' +
      '<select id="laboratorio" class="form-control input-sm"></select>' +
      "</div>" +
      "</div>" +
      '<div class="col-xs-3">' +
      '<div class="form-group">' +
      '<label for="programa">Programa</label>' +
      '<select id="programa" class="form-control input-sm"></select>' +
      "</div>" +
      "</div>" +
      '<div class="col-xs-3">' +
      '<div class="form-group">' +
      '<label for="lote">Lote</label>' +
      '<select id="lote" class="form-control input-sm"></select>' +
      "</div>" +
      "</div>" +
      "</div>" +
      "<hr>" +
      '<div class="datos" id="cont_valores_estadisticos">' +
      '<button class="btn btn-default"><i class="glyphicon glyphicon-plus"></i> Agregar gestión</button>' +
      '<div class="cont-tabla scroll" id="cont-tabla-gestiones">' +
      "<br /><h5><strong>Cargando información...</strong></h5>" +
      "</div>" +
      "</div>" +
      "</div>" +
      '<div class="modal-footer">' +
      '<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>' +
      '<button type="button" class="btn btn-primary btn-guardar-cambios" disabled="disabled">Guardar cambios</button>' +
      "</div>" +
      "</div>" +
      "</div>" +
      "</div>"
  );

  contModal.html(modalPersonalize);
  generarInfoModificacion(
    tipoprograma,
    id_digitacion,
    laboratorio,
    programa,
    lote
  );
  contModal.find(".modal").modal({
    backdrop: "static",
    keyboard: false,
    show: true,
  });

  modalPersonalize = null;
  // });
}

function generarInfoModificacion(
  tipoprograma,
  idDigitacionUroanalisis,
  laboratorio,
  programa,
  lote
) {
  switch (tipoprograma) {
    case "cualitativo":
      let dataAjax = {
        tipo: "SeeInfoModificacion",
        tipo_programa: "cualitativo",
        idreferencia: idDigitacionUroanalisis,
        laboratorio: laboratorio,
        programa: programa,
        lote: lote,
      };

      dataAjax = JSON.stringify(dataAjax);
      // console.log(dataAjax);
      $.post(
        "../../php/uroanalisis/posiblesResultados/digitacion_data_change_handler.php",
        {
          data_ajax: dataAjax,
        },
        function () {
          /* No hacer nada de momento */
        }
      )
        .done(function (responseXML) {
          // try {
          var response = responseXML.getElementsByTagName("response")[0];
          // console.log(response);
          var code = parseInt(response.getAttribute("code"), 10);
          if (code == 0) {
            statusBox(
              "warning",
              "NULL",
              "Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.",
              "add",
              "NULL"
            );
          } else {
            // Si la respuesta fue exitosa
            let resultadoJSON = JSON.parse($(response).html());
            console.log(resultadoJSON);
            // die();
            posicion =
              resultadoJSON.digitaciones[resultadoJSON.digitaciones.length - 1];
            // die();
            let idDigitacion = posicion.id_digitaciones_uroanalisis;
            let idLaboratorio = posicion.id_laboratorio;
            let noLaboratorio = posicion.no_laboratorio;
            let nombreLaboratorio = posicion.nombre_laboratorio;

            let idPrograma = posicion.id_programa;
            let nombrePrograma = posicion.nombre_programa;
            let desctipoPrograma = posicion.desc_tipo_programa;

            let idLote = posicion.id_lote;
            let nombreLote = posicion.nombre_lote;
            let nivelLote = posicion.nivel_lote;
            let fVencimientoLote = posicion.fecha_vencimiento;

            let contModal = $(".cont-modal-modificacion");

            // Fijar valor para el id_referencia
            contModal.find("#id_digitacion").val(idDigitacion);

            // Obtener opciones y seleccionar el laboratorio de control
            contModal.find("#laboratorio").html("");
            contModal
              .find("#laboratorio")
              .append(
                "<option value='" +
                  idLaboratorio +
                  "' selected>" +
                  noLaboratorio +
                  " | " +
                  nombreLaboratorio +
                  "</option>"
              );

            // Fijar valor para el programa
            contModal.find("#programa").html("");
            contModal
              .find("#programa")
              .append(
                "<option value='" +
                  idPrograma +
                  "' selected>" +
                  nombrePrograma +
                  " (" +
                  desctipoPrograma +
                  ")</option>"
              );
            // Fijar valor para el lote
            // contModal.find("#lote").html("");
            // contModal
            //   .find("#lote")
            //   .append(
            //     "<option value='" +
            //     idPrograma +
            //       "' selected>" +
            //       nombrePrograma +
            //       " (" +
            //       desctipoPrograma +
            //       ")</option>"
            //   );
            contModal.find("#lote").html("");

            let option = $("<option>", {
              value: idLote,
              text:
                nombreLote +
                " | nivel: " +
                nivelLote +
                " | fecha de vencimiento: " +
                fVencimientoLote,
            });

            contModal.find("#lote").append(option);

            //
            // Generar tabla valores cualitativos
            let table = $(
              // '<table class="table table-sm table-secondary"></table>'
              '<table class="table table-sm table-hover align-middle">'
            );
            let table_cuerpo = $(
              '<thead class="table-primary text-center">' +
                "<tr>" +
                '<th rowspan="2" style="text-align:center;">Mensurando</th>' +
                '<th rowspan="2" style="border-left: 2px text-align:center;">Valor Verdadero</th>' +
                '<th colspan="3" style="solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">Comparación Internacional</th>' +
                '<th colspan="2" style="solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">V.A.V</th>' +
                "</tr>" +
                "<tr>" +
                '<th style="text-align:center; border-left: 2px solid #2471A3;">Resultado Comparación</th>' +
                '<th style="text-align:center;">#Lab</th>' +
                '<th style="text-align:center;">#P</th>' +
                '<th style="text-align:center; border-left: 2px solid #2471A3;">Resultado Comparación</th>' +
                "</tr>" +
                "</thead>" +
                "<tbody></tbody>"
            );

            // Generar la estructura principal y el encabezado de la tabla
            $("#cont-tabla-gestiones").html(table);
            $("#cont-tabla-gestiones table").html(table_cuerpo);

            table_cuerpo = null;
            table = null;

            var mapaPosiblesResultados = {};
            var mapaPosiblesResultadosComparacionInternacional = {};
            var mapaPosiblesResultadosComparacionVAV = {};
            var mapaNumerosLab = {};
            var mapaNumerosPoints = {};
            var mapaAnalitosOptions = {};
            for (countanalitos = 0;countanalitos < resultadoJSON.analitos.length;countanalitos++) {
              let resultadosVerdaderosDB = (resultadoJSON.analitos[countanalitos].digitacion_resultados_verdaderos || []).map((obj) => obj.id_resultado_verdadero);
              let idsResultadosCompInternacionalDB = (resultadoJSON.analitos[countanalitos].result_comp_internacional || []).flatMap((obj) => obj.ids_resultados_verdaderos);
              let idsResultadosCompVAVDB = (resultadoJSON.analitos[countanalitos].result_comp_vav || []).flatMap((obj) => obj.ids_resultados_verdaderos);
              
        
              idAnalito = resultadoJSON.analitos[countanalitos].id_analito;
              id_configuracion =
                resultadoJSON.analitos[countanalitos].id_configuracion;
              let nombre_analito =
                resultadoJSON.analitos[countanalitos].nombre_analito;

              let nombre_analizador =
                resultadoJSON.analitos[countanalitos].nombre_analizador;
              
              let analitosOptions = `<option value="${escapeHtml(id_configuracion)}">${escapeHtml(nombre_analito)} | ${escapeHtml(nombre_analizador)}</option>`;
              mapaAnalitosOptions[id_configuracion] = analitosOptions;

              var posiblesResultadosHTML = "";
              var posiblesResultadosInternacionalHTML = "";
              var posiblesResultadosVAVHTML = "";
              for (
                let countResultados = 0;countResultados <resultadoJSON.analitos[countanalitos].descripcion_posibles_resultados.length;countResultados++) {
                let resultado =
                  resultadoJSON.analitos[countanalitos]
                    .descripcion_posibles_resultados[countResultados];
                // console.log(resultado);
                let isChecked = resultadosVerdaderosDB.includes(resultado.id);
                let isCheckedInternacional =
                  idsResultadosCompInternacionalDB.includes(resultado.id);
                let isCheckedResultadosVAV = idsResultadosCompVAVDB.includes(
                  resultado.id
                );
                posiblesResultadosHTML += `
                            <input class="form-check-input" type="checkbox"
                                  name="resultado_${
                                    resultado.id
                                  }_${countanalitos}_${countResultados}"
                                  value="${resultado.descripcion}"
                                  id="check_${
                                    resultado.id
                                  }_${countanalitos}_${countResultados}"
                                  ${isChecked ? "checked" : ""}>
                            <label class="form-check-label" for="check_${
                              resultado.id
                            }_${countanalitos}_${countResultados}">
                              ${resultado.descripcion}
                            </label>
  
                        `;
               

                posiblesResultadosInternacionalHTML += `
                  <input class="form-check-input" type="checkbox"
                        name="resultado_${
                          resultado.id
                        }_${countanalitos}_${countResultados}"
                        value="${resultado.descripcion}"
                        id="checkInter_${
                          resultado.id
                        }_${countanalitos}_${countResultados}"
                        ${isCheckedInternacional ? "checked" : ""}>
                  <label class="form-check-label" for="checkInter_${
                    resultado.id
                  }_${countanalitos}_${countResultados}">
                    ${resultado.descripcion}
                  </label>
  
              `;
                
                posiblesResultadosVAVHTML += `
              <input class="form-check-input" type="checkbox"
                    name="resultado_${
                      resultado.id
                    }_${countanalitos}_${countResultados}"
                    value="${resultado.descripcion}"
                    id="checkVAV_${
                      resultado.id
                    }_${countanalitos}_${countResultados}"
                    ${isCheckedResultadosVAV ? "checked" : ""}>
              <label class="form-check-label" for="checkVAV_${
                resultado.id
              }_${countanalitos}_${countResultados}">
                ${resultado.descripcion}
              </label>`;

              
              }
              let inputsNumeroLabHTML = `
              <input type="number" class="form-control form-control-sm n_lab placeholder="# Lab" style="min-width:50px; text-align:center;">
            `;

              let inputsNumeroPointsHTML = `
              <input type="number" class="form-control form-control-sm n_points placeholder="# Points" style="min-width:50px; text-align:center;">
            `;
             
              mapaPosiblesResultados[id_configuracion] = posiblesResultadosHTML;
              mapaPosiblesResultadosComparacionInternacional[id_configuracion] =
                posiblesResultadosInternacionalHTML;
              mapaPosiblesResultadosComparacionVAV[id_configuracion] =
                posiblesResultadosVAVHTML;
              mapaNumerosLab[id_configuracion] = inputsNumeroLabHTML;
              mapaNumerosPoints[id_configuracion] = inputsNumeroPointsHTML;

            }
            for (let gest = 0; gest < resultadoJSON.analitos.length; gest++) {
              let analito = resultadoJSON.analitos[gest];
              let id_configuracion = analito.id_configuracion;

              let table_trGestion = $(`
                      <tr data-idreferencia="${analito.id_analito}">
                        <td>
                          <select class="form-select form-select-sm id_configuracion" style="max-width:150px;">
                            <option disabled selected>Seleccione un mensurando</option>
                          </select>
                        </td>
                        <td style='min-width: 50px; border-left: 2px solid #2471A3'>
                          <div class="d-flex flex-wrap gap-2 valores_verdaderos"></div>
                        </td>
                        <td style='min-width: 50px; border-left: 2px solid #2471A3'>
                          <div class="d-flex flex-wrap gap-2 comparacion_internacional"></div>
                        </td>
                        <td style='min-width: 50px;'>
                          <div class="numero_lab"></div>
                        </td>
                        <td style='min-width: 50px;'>
                          <div class="numero_points"></div>
                        </td>
                        <td style='min-width: 50px; border-left: 2px solid #2471A3'>
                          <div class="d-flex flex-wrap gap-2 vav"></div>
                        </td>
                      </tr>
                    `);

              $("#cont-tabla-gestiones tbody").append(table_trGestion);

              table_trGestion
                .find(".id_configuracion")
                .append(Object.values(mapaAnalitosOptions))
                .find(`option[value='${id_configuracion}']`)
                .prop("selected", true);

              table_trGestion
                .find(".valores_verdaderos")
                .append(mapaPosiblesResultados[id_configuracion]);
              table_trGestion
                .find(".comparacion_internacional")
                .append(
                  mapaPosiblesResultadosComparacionInternacional[
                    id_configuracion
                  ]
                );
              table_trGestion
                .find(".vav")
                .append(
                  mapaPosiblesResultadosComparacionVAV[id_configuracion]
                );
              table_trGestion
                .find(".numero_lab")
                .append(mapaNumerosLab[id_configuracion]);
              table_trGestion
                .find(".numero_points")
                .append(mapaNumerosPoints[id_configuracion]);
            }

            let resultadosVerdaderosAnalitosVaciosDB = resultadoJSON.analitos.every(
              analito => !analito.digitacion_resultados_verdaderos || analito.digitacion_resultados_verdaderos.length === 0
            );

            if (resultadosVerdaderosAnalitosVaciosDB) {
              // Evento de registrar
              eventoGuardarModificacion();
            } else {
            

            let idsResultadosVerdaderosDB = resultadoJSON.analitos.map(analito => ({
            id_configuracion: analito.id_configuracion,
            ids_resultados_verdaderos: (analito.digitacion_resultados_verdaderos || [])
              .flatMap(obj => 
                obj.id_resultado_verdadero !== undefined && obj.id_resultado_verdadero !== null 
                  ? [obj.id_resultado_verdadero] 
                  : []
              )
          }));

          let idsResultadosCompInternacionalDB = resultadoJSON.analitos.map(analito => ({
            id_configuracion: analito.id_configuracion,
            ids_resultados_verdaderos: (analito.result_comp_internacional || [])
              .flatMap(obj => 
                obj.ids_resultados_verdaderos !== undefined && obj.ids_resultados_verdaderos !== null 
                  ? [obj.ids_resultados_verdaderos] 
                  : []
              )
          }));


           let idsResultadosCompVAVDB = resultadoJSON.analitos.map(analito => ({
            id_configuracion: analito.id_configuracion,
            ids_resultados_verdaderos: (analito.result_comp_vav || [])
              .flatMap(obj => obj.ids_resultados_verdaderos)  // 👈 aquí aplana directamente
          }));


              // Evento de actualizar
              eventoActualizarModificacion(
                idsResultadosVerdaderosDB,
                idsResultadosCompInternacionalDB,
                idsResultadosCompVAVDB
              );
              establecerValoresNlabNponitsInternacional(resultadoJSON);

            }

            $(".modal .btn-guardar-cambios").prop("disabled", false); // Habilitar nuevamente el boton de modificar
          }
        })
        .fail(function () {
          statusBox(
            "warning",
            "NULL",
            "Ha ocurrido algo inesperado en la consulta, por favor intente nuevamente...",
            "add",
            "NULL"
          );
        })
        .always(function (ssasas) {
          console.log(ssasas);
          $(".modal .btn-guardar-cambios").prop("disabled", false); // Habilitar nuevamente el boton de modificar
        });
      break;
    case "cualitativo":
      break;
  }
}
function establecerValoresNlabNponitsInternacional(resultadoJSON) {
  document.querySelectorAll("#cont-tabla-gestiones tbody tr").forEach((tr) => {
    const id_configuracion = tr.querySelector(".id_configuracion").value;
    resultadoJSON.analitos.forEach((analito) =>{
      const data = analito.result_comp_internacional.find(
        (r) => r.id_configuracion == id_configuracion
      );
      if (data) {
        tr.querySelector(".n_lab").value = data.nLab;
        tr.querySelector(".n_points").value = data.nPoints;
      }
    })
  });


}
// Evento registrar datos del modal
function eventoGuardarModificacion() {
  $(".btn-guardar-cambios").off("click");
  $(".btn-guardar-cambios").click(function (e) {
    e.preventDefault();
    let elementEvent = $(this);
    if (validarDigitacion(elementEvent)) {
      if (tipoProgramaCualitativo(elementEvent)) {
        ejecutarGuardado($(this));
      }
    }
  });
}
// Evento actualizar modal
function eventoActualizarModificacion(digitacion_resultados_verdaderos_db,result_comp_internacional_db,result_comp_vav_db) {
  $(".btn-guardar-cambios").off("click");
  $(".btn-guardar-cambios").click(function (e) {
    e.preventDefault();
    let elementEvent = $(this);
    if (validarDigitacion(elementEvent)) {
      if (tipoProgramaCualitativo(elementEvent)) {
        ejecutarActualizacion($(this), digitacion_resultados_verdaderos_db,result_comp_internacional_db,result_comp_vav_db);
      }
    }
  });
}

function ejecutarGuardado(elementEvent) {
  let laboratorio = elementEvent
    .parents(".cont-referencia-selectores")
    .find(".cont-selectores #laboratorio")
    .val();
  let programa = elementEvent
    .parents(".cont-referencia-selectores")
    .find(".cont-selectores #programa")
    .val();
  let lote = elementEvent
    .parents(".cont-referencia-selectores")
    .find(".cont-selectores #lote")
    .val();
  // Construir JSON para enviar a guardar
  let filasGestion = $("#cont-tabla-gestiones tbody tr");
  let datos_digitacion = [];

  filasGestion.each(function (index, val) {
    let trActual = filasGestion.eq(index);

    let checkboxesSeleccionadosResultadosVerdaderosAnalito =
      checkboxesSeleccionados(
        trActual,
        ".valores_verdaderos .form-check-input:checked"
      );
    let checkboxesSeleccionadosComparacionInternacional =
      checkboxesSeleccionados(
        trActual,
        ".comparacion_internacional .form-check-input:checked"
      );
    let checkboxesSeleccionadosComparacionVAV = checkboxesSeleccionados(
      trActual,
      ".vav .form-check-input:checked"
    );

    datos_digitacion.push({
      id_configuracion: trActual.find(".id_configuracion").val(),
      idAnalito: trActual.attr("data-idreferencia"),
      nLab: trActual.find(".numero_lab input.n_lab").val(),
      nPoints: trActual.find(".numero_points input.n_points").val(),
      resultados_verdaderos: checkboxesSeleccionadosResultadosVerdaderosAnalito,
      comparacion_internacional:
        checkboxesSeleccionadosComparacionInternacional,
      comparaciones_vav: checkboxesSeleccionadosComparacionVAV,
    });
  });

  let data_ajax = {
    tipo: "registro",
    id_digitacion: elementEvent
      .parents(".cont-referencia-selectores")
      .find(".cont-selectores #id_digitacion")
      .val(),
    laboratorio: laboratorio,
    programa: programa,
    datos_digitacion: datos_digitacion,
    tipo_programa: tipoProgramaCualitativo(elementEvent)
      ? "cualitativo"
      : "cuantitativo",
  };
  // console.log(data_ajax);
  // die();
  elementEvent.prop("disabled", true);
  elementEvent.text("Guardando cambios...");

  data_ajax = JSON.stringify(data_ajax);

  $.post(
    "../php/uroanalisis/posiblesResultados/digitacion_data_change_handler.php",
    {
      data_ajax: data_ajax,
    },
    function () {}
  )
    .done(function (responseXML) {
      var response = responseXML.getElementsByTagName("response")[0];
      var code = parseInt(response.getAttribute("code"), 10);

      if (code == 0) {
        statusBox(
          "warning",
          "NULL",
          "Ha ocurrido algo inesperado, por favor intente nuevamente...",
          "add",
          "NULL"
        );
      } else {
        statusBox(
          "success",
          "NULL",
          "¡Digitación guardada exitosamente!",
          "add",
          "NULL"
        );
        listarInformacionDigitacion(laboratorio, programa, lote);
        // eliminarModal($(".cont-modal-modificacion"));
      }
    })
    .fail(function () {
      statusBox(
        "warning",
        "NULL",
        "Ha ocurrido algo inesperado, por favor intente nuevamente...",
        "add",
        "NULL"
      );
    })
    .always(function (sdsd) {
      console.log(sdsd);
      elementEvent.prop("disabled", false);
      elementEvent.text("Guardar cambios");
    });
}
function ejecutarActualizacion(elementEvent,digitacion_resultados_verdaderos_db,result_comp_internacional_db,result_comp_vav_db
) {
  let laboratorio = elementEvent
    .parents(".cont-referencia-selectores")
    .find(".cont-selectores #laboratorio")
    .val();
  let programa = elementEvent
    .parents(".cont-referencia-selectores")
    .find(".cont-selectores #programa")
    .val();
  let lote = elementEvent
    .parents(".cont-referencia-selectores")
    .find(".cont-selectores #lote")
    .val();
  // Construir JSON para enviar a guardar
  let filasGestion = $("#cont-tabla-gestiones tbody tr");
  let datos_digitacion = [];

  filasGestion.each(function (index, val) {
    let trActual = filasGestion.eq(index);

    let checkboxesSeleccionadosResultadosVerdaderosAnalito = checkboxesSeleccionados(trActual,".valores_verdaderos .form-check-input:checked");
    let checkboxesSeleccionadosComparacionInternacional = checkboxesSeleccionados(trActual,".comparacion_internacional .form-check-input:checked");
    let checkboxesSeleccionadosComparacionVAV = checkboxesSeleccionados(trActual,".vav .form-check-input:checked");

    datos_digitacion.push({
      analito: trActual.attr("data-idreferencia"),
      id_configuracion: trActual.find(".id_configuracion").val(),
      nLab: trActual.find(".numero_lab input.n_lab").val(),
      nPoints: trActual.find(".numero_points input.n_points").val(),
      resultados_verdaderos: checkboxesSeleccionadosResultadosVerdaderosAnalito,
      comparacion_internacional: checkboxesSeleccionadosComparacionInternacional,
      comparaciones_vav: checkboxesSeleccionadosComparacionVAV,
    });
  });

  //-------------------------------------
  let idsResultadosVerdaderosAgregar = idsResultadosVerdaderosAnalitoAgregar(datos_digitacion,digitacion_resultados_verdaderos_db);
  let idsResultadosVerdaderosEliminar = idsResultadosVerdaderosAnalitoEliminar(datos_digitacion,digitacion_resultados_verdaderos_db);
  //----------------------------------------- 
  let idsVerdaderosComparacionInternacionalAgregar = idsResultadosVerdaderosAgregarComparacionInternacional(datos_digitacion,result_comp_internacional_db);
  let idsVerdaderosComparacionInternacionalEliminar = idsResultadosVerdaderosEliminarComparacionInternacional(datos_digitacion,result_comp_internacional_db);
  //-----------------------------------------
  let idsVerdaderosComparacionVAVAgregar = idsResultadosVerdaderosAgregarVAV(datos_digitacion,result_comp_vav_db);
  let idsVerdaderosComparacionVAVEliminar = idsResultadosVerdaderosEliminarVAV(datos_digitacion,result_comp_vav_db);

  let data_ajax = {
    tipo: "edicion",
    id_digitacion: elementEvent
      .parents(".cont-referencia-selectores")
      .find(".cont-selectores #id_digitacion")
      .val(),
    datos_digitacion: datos_digitacion,
    tipo_programa: tipoProgramaCualitativo(elementEvent)
      ? "cualitativo"
      : "cuantitativo",
    idsResultadosVerdaderosEliminar: idsResultadosVerdaderosEliminar,
    idsResultadosVerdaderosAgregar: idsResultadosVerdaderosAgregar,
    idsVerdaderosComparacionInternacionalAgregar:
      idsVerdaderosComparacionInternacionalAgregar,
    idsVerdaderosComparacionInternacionalEliminar:
      idsVerdaderosComparacionInternacionalEliminar,
    idsVerdaderosComparacionVAVAgregar: idsVerdaderosComparacionVAVAgregar,
    idsVerdaderosComparacionVAVEliminar: idsVerdaderosComparacionVAVEliminar,
  };
  // console.log(data_ajax);
  // die();
  elementEvent.prop("disabled", true);
  elementEvent.text("Guardando cambios...");

  data_ajax = JSON.stringify(data_ajax);

  $.post(
    "../php/uroanalisis/posiblesResultados/digitacion_data_change_handler.php",
    {
      data_ajax: data_ajax,
    },
    function () {}
  )
    .done(function (responseXML) {
      var response = responseXML.getElementsByTagName("response")[0];
      var code = parseInt(response.getAttribute("code"), 10);

      if (code == 0) {
        statusBox(
          "warning",
          "NULL",
          "Ha ocurrido algo inesperado, por favor intente nuevamente...",
          "add",
          "NULL"
        );
      } else {
        statusBox(
          "success",
          "NULL",
          "¡Digitación guardada exitosamente!",
          "add",
          "NULL"
        );
        listarInformacionDigitacion(laboratorio, programa, lote);
        // eliminarModal($(".cont-modal-modificacion"));
      }
    })
    .fail(function () {
      statusBox(
        "warning",
        "NULL",
        "Ha ocurrido algo inesperado, por favor intente nuevamente...",
        "add",
        "NULL"
      );
    })
    .always(function (sdsd) {
      console.log(sdsd);
      elementEvent.prop("disabled", false);
      elementEvent.text("Guardar cambios");
    });
}


function idsResultadosVerdaderosAnalitoAgregar(datos_digitacion, digitacion_resultados_verdaderos_db) {
  let idsResultadosVerdaderosSeleccionados = [];

  for (let i = 0; i < datos_digitacion.length; i++) {
    let idConfiguracion = datos_digitacion[i].id_configuracion;
    let idAnalito = datos_digitacion[i].analito;

    let idsSeleccionados = datos_digitacion[i].resultados_verdaderos.map(r => Number(r.id));

    // Encuentra en la base de datos los resultados ya existentes para esa configuración
    let existentesEnDB = [];
    let configEncontrada = digitacion_resultados_verdaderos_db.find(item => item.id_configuracion === idConfiguracion);
    if (configEncontrada) {
      existentesEnDB = configEncontrada.ids_resultados_verdaderos.map(Number);
    }

    // Filtrar los que aún no están en base de datos
    let faltantes = idsSeleccionados.filter(id => !existentesEnDB.includes(id));

    if (faltantes.length > 0) {
      idsResultadosVerdaderosSeleccionados.push({
        analito : idAnalito,
        id_configuracion: idConfiguracion,
        ids_resultados: faltantes
      });
    }
  }

  return idsResultadosVerdaderosSeleccionados;
}


function idsResultadosVerdaderosAnalitoEliminar(datos_digitacion, digitacion_resultados_verdaderos_db) {
  // Mapeo de resultados seleccionados por id_configuracion
  let resultadosSeleccionadosPorConfig = {};

  for (let i = 0; i < datos_digitacion.length; i++) {
    let idConfiguracion = datos_digitacion[i].id_configuracion;

    if (!resultadosSeleccionadosPorConfig[idConfiguracion]) {
      resultadosSeleccionadosPorConfig[idConfiguracion] = [];
    }

    for (let j = 0; j < datos_digitacion[i].resultados_verdaderos.length; j++) {
      let idResultado = datos_digitacion[i].resultados_verdaderos[j].id;
      resultadosSeleccionadosPorConfig[idConfiguracion].push(Number(idResultado));
    }
  }

  // Ahora comparar con digitacion_resultados_verdaderos_db
  let idsResultadosVerdaderosEliminar = [];

  for (let i = 0; i < digitacion_resultados_verdaderos_db.length; i++) {
    let idConfiguracion = digitacion_resultados_verdaderos_db[i].id_configuracion;
    let existentesEnDB = digitacion_resultados_verdaderos_db[i].ids_resultados_verdaderos.map(Number);
    let seleccionados = resultadosSeleccionadosPorConfig[idConfiguracion] || [];

    // Filtrar los que existen en DB pero no están seleccionados
    let aEliminar = existentesEnDB.filter(id => !seleccionados.includes(id));

    if (aEliminar.length > 0) {
      idsResultadosVerdaderosEliminar.push({
        id_configuracion: idConfiguracion,
        ids_resultados: aEliminar
      });
    }
  }

  return idsResultadosVerdaderosEliminar;
}


function idsResultadosVerdaderosAgregarComparacionInternacional(datos_digitacion, result_comp_internacional_db) {
  let resultadosSeleccionadosPorConfig = {};

  // Paso 1: Organizar las nuevas selecciones por configuración
  for (let i = 0; i < datos_digitacion.length; i++) {
    let idConfiguracion = datos_digitacion[i].id_configuracion;
    let analitoId = datos_digitacion[i].analito;

    if (!resultadosSeleccionadosPorConfig[idConfiguracion]) {
      resultadosSeleccionadosPorConfig[idConfiguracion] = {
        analito: analitoId,
        resultados: []
      };
    }

    for (let j = 0; j < datos_digitacion[i].comparacion_internacional.length; j++) {
      let idResultado = datos_digitacion[i].comparacion_internacional[j].id;
      if (idResultado && !isNaN(idResultado)) {
        resultadosSeleccionadosPorConfig[idConfiguracion].resultados.push(Number(idResultado));
      }
    }
  }

  let idsResultadosVerdaderosAgregar = [];

  // Paso 2: Comparar con la base de datos
  for (const idConfiguracion in resultadosSeleccionadosPorConfig) {
    const { analito, resultados } = resultadosSeleccionadosPorConfig[idConfiguracion];

    // Obtener IDs existentes en DB (teniendo en cuenta la estructura anidada)
    let existentesEnDB = [];

    let configEncontrada = result_comp_internacional_db.find(item => item.id_configuracion === idConfiguracion);
    if (configEncontrada && configEncontrada.ids_resultados_verdaderos) {
      // console.log(configEncontrada);
      // Aplanar el array de arrays y convertir a números
      existentesEnDB = configEncontrada.ids_resultados_verdaderos
        .flat()
        .map(Number)
        .filter(id => !isNaN(id));
    }

    // Filtrar solo los que no están en DB
    const faltantes = resultados.filter(id => !existentesEnDB.includes(id));

    if (faltantes.length > 0) {
      idsResultadosVerdaderosAgregar.push({
        id_configuracion: idConfiguracion,
        analito: analito,
        ids_resultados: faltantes
      });
    }
  }

  return idsResultadosVerdaderosAgregar;
}

function idsResultadosVerdaderosEliminarComparacionInternacional(datos_digitacion, result_comp_internacional_db) {
  let resultadosSeleccionadosPorConfig = {};
  
  // Paso 1: Recopilar todas las selecciones actuales por configuración
  for (let i = 0; i < datos_digitacion.length; i++) {
    let idConfiguracion = datos_digitacion[i].id_configuracion;

    if (!resultadosSeleccionadosPorConfig[idConfiguracion]) {
      resultadosSeleccionadosPorConfig[idConfiguracion] = new Set();
    }

    for (let j = 0; j < datos_digitacion[i].comparacion_internacional.length; j++) {
      let idResultado = datos_digitacion[i].comparacion_internacional[j].id;
      if (idResultado && !isNaN(idResultado)) {
        resultadosSeleccionadosPorConfig[idConfiguracion].add(Number(idResultado));
      }
    }
  }

  let idsResultadosVerdaderosEliminar = [];

  // Paso 2: Comparar con la base de datos
  for (let i = 0; i < result_comp_internacional_db.length; i++) {
    let item = result_comp_internacional_db[i];
    let idConfiguracion = item.id_configuracion; // Nota: propiedad es "id_configuracion" no "id_configuracion"
    
    // Obtener IDs existentes en DB (aplanar el array de arrays y convertir a números)
    let existentesEnDB = [];
    if (item.ids_resultados_verdaderos && Array.isArray(item.ids_resultados_verdaderos)) {
      existentesEnDB = item.ids_resultados_verdaderos
        .flat() // Aplanar el array de arrays
        .map(id => {
          let num = Number(id);
          return isNaN(num) ? null : num; // Manejar posibles valores no numéricos
        })
        .filter(id => id !== null); // Filtrar valores inválidos
    }

    // Obtener selecciones actuales para esta configuración
    let seleccionadosActuales = resultadosSeleccionadosPorConfig[idConfiguracion] || new Set();

    // Filtrar los que están en DB pero no en las selecciones actuales
    let aEliminar = existentesEnDB.filter(id => !seleccionadosActuales.has(id));

    if (aEliminar.length > 0) {
      idsResultadosVerdaderosEliminar.push({
        id_configuracion: idConfiguracion,
        ids_resultados: aEliminar
      });
    }
  }

  // Log de depuración final
  // console.log('Resultados a eliminar:', JSON.stringify(idsResultadosVerdaderosEliminar, null, 2));
  
  return idsResultadosVerdaderosEliminar;
}
function idsResultadosVerdaderosAgregarVAV(datos_digitacion, result_comp_vav_db) {
  let resultadosSeleccionadosPorConfig = {};

  for (let i = 0; i < datos_digitacion.length; i++) {
    let idConfiguracion = datos_digitacion[i].id_configuracion;
    let analitoId = datos_digitacion[i].analito;

    if (!resultadosSeleccionadosPorConfig[idConfiguracion]) {
      resultadosSeleccionadosPorConfig[idConfiguracion] = {
        analito: analitoId,
        resultados: []
      };
    }

    for (let j = 0; j < datos_digitacion[i].comparaciones_vav.length; j++) {
      let idResultado = datos_digitacion[i].comparaciones_vav[j].id;
      if (idResultado !== undefined && idResultado !== null && idResultado !== '' && !isNaN(idResultado)) {
        resultadosSeleccionadosPorConfig[idConfiguracion].resultados.push(Number(idResultado));
      }
    }
  }

  let idsResultadosVerdaderosAgregar = [];

  for (const idConfiguracion in resultadosSeleccionadosPorConfig) {
    const { analito, resultados } = resultadosSeleccionadosPorConfig[idConfiguracion];

    // Buscar en la base de datos los ya existentes para esa config
    let existentesEnDB = [];
    let configEncontrada = result_comp_vav_db.find(item => item.id_configuracion === idConfiguracion);
    if (configEncontrada) {
      existentesEnDB = configEncontrada.ids_resultados_verdaderos.map(Number);
    }

    // Filtrar los que aún no están en base de datos
    const faltantes = resultados.filter(id => !existentesEnDB.includes(id));

    if (faltantes.length > 0) {
      idsResultadosVerdaderosAgregar.push({
        id_configuracion: idConfiguracion,
        analito: analito,              
        ids_resultados: faltantes
      });
    }
  }

  return idsResultadosVerdaderosAgregar;
}

function idsResultadosVerdaderosEliminarVAV(datos_digitacion, result_comp_vav_db) {
  let resultadosSeleccionadosPorConfig = {};

  for (let i = 0; i < datos_digitacion.length; i++) {
    let idConfiguracion = datos_digitacion[i].id_configuracion;

    if (!resultadosSeleccionadosPorConfig[idConfiguracion]) {
      resultadosSeleccionadosPorConfig[idConfiguracion] = [];
    }

    for (let j = 0; j < datos_digitacion[i].comparaciones_vav.length; j++) {
      let idResultado = datos_digitacion[i].comparaciones_vav[j].id;

      if (idResultado !== undefined && idResultado !== null && idResultado !== '' && !isNaN(idResultado)) {
        resultadosSeleccionadosPorConfig[idConfiguracion].push(Number(idResultado));
      }
    }
  }

  let idsResultadosVerdaderosEliminar = [];

  for (let i = 0; i < result_comp_vav_db.length; i++) {
    let idConfiguracion = result_comp_vav_db[i].id_configuracion;

    let existentesEnDB = result_comp_vav_db[i].ids_resultados_verdaderos
      .filter(id => id !== undefined && id !== null && id !== '' && !isNaN(id))
      .map(Number);

    let seleccionados = resultadosSeleccionadosPorConfig[idConfiguracion] || [];

    // Filtrar los que están en DB pero no están seleccionados actualmente
    let aEliminar = existentesEnDB.filter(id => !seleccionados.includes(id));

    if (aEliminar.length > 0) {
      idsResultadosVerdaderosEliminar.push({
        id_configuracion: idConfiguracion,
        ids_resultados: aEliminar
      });
    }
  }

  return idsResultadosVerdaderosEliminar;
}



function checkboxesSeleccionados(trActual, selector) {
  let resultado = [];
  trActual.find(selector).each(function () {
    let idCompleto = $(this).attr("id");
    let idNumerico = idCompleto.split("_")[1];

    resultado.push({
      id: parseInt(idNumerico),
      descripcion: $(this).val(),
    });
  });
  return resultado;
}
function escapeHtml(unsafe) {
  return unsafe
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}