function initialize() {
  //--------------Registro de laboratorio y programa para digitacion --------------------------
  $("#formLabPrograma").bind("submit", function (event) {
    dataChangeHandler(
      "registroLabProgramaLoteDigitacion",
      "NULL",
      $("#formLabPrograma").get(0),
      "NULL",
      "NULL"
    );

    event.preventDefault();
  });
  $("#formLabProgramainput1").bind("change", function (event) {
    // alert("llega a formLabProgramainput1: " + this.value);

    functionHandler(
      "selectFillerProgramaLab",
      "formLabProgramainput2",
      "showAssignedProgramaLab&filter=" +
        this.value +
        "&filterid=id_laboratorio",
      " | ",
      "false"
    );

    statusBox("loading", "NULL", "NULL", "add", "NULL");

    var timer_11 = setInterval(function () {
      if ($("#formLabProgramainput2").attr("data-active") == "true") {
        statusBox("loading", "NULL", "NULL", "remove", "NULL");

        $("#formLabProgramainput2").change();

        clearInterval(timer_11);
      }
    }, 100);
  });

  $("#formLabProgramainput2").bind("change", function (event) {
    //esta me sirve para obtener la ronda o rondas
    functionHandler("selectFillerLabRoundLote","formLabProgramainput3","showAssignedLoteRound&filter=" +this.value +"|" +$("#formLabProgramainput1").val() +"&filterid=id_laboratorio"," | ");

    statusBox("loading", "NULL", "NULL", "add", "NULL");
    var timer_2 = setInterval(function () {
      if ($("#formLabProgramainput3").attr("data-active") == "true") {
        statusBox("loading", "NULL", "NULL", "remove", "NULL");
        $("#formLabProgramainput3").change();
        clearInterval(timer_2);
      }
    }, 100);
  });
  //este me sirve para obtener los lotes apartir de la ronda
  // $("#formLabProgramainput3").bind("change", function (event) {
  //   functionHandler(
  //     "selectFiller",
  //     "form1input4",
  //     "showAssignedRoundSample&filter=" + this.value + "&filterid=id_ronda",
  //     " | "
  //   );
  // });

  //-----------------------------------------------------------------------------------------

  $("#w1p").draggable();

  $("#w2p").draggable();

  var checkAmmountOfSamplesForRoundResponse = {};

  checkAmmountOfSamplesForRoundResponse = "";
}

function changeFrame(val) {
  var id = val.getAttribute("id");
  switch (id) {
    case "panel1":
      $("#page").attr("src", "uroanalisis/posiblesResultados.php");
      break;
  }
}

function functionHandler(val, val2, val3, val4, val5, val6) {
  var id = val;

  switch (id) {
    case "panelChooser":
      $(val2).parent().find("li").removeClass("active-tab");

      var id = val2.getAttribute("data-id");

      $("[data-id=" + val3 + "]").attr("hidden", "hidden");

      $("#" + id).removeAttr("hidden");

      $(val2).addClass("active-tab");

      break;

    case "selectFiller":
      $("input[type=submit]").attr("disabled", "disabled");
      $("input[type=submit]").addClass("disabled");

      var select = $("#" + val2).get(0);

      select.innerHTML = "";

      select.value = "";

      select.removeAttribute("data-active");

      select.dataset.active = "false";

      var values = "header=" + val3;

      statusBox("loading", "NULL", "NULL", "add", "NULL");

      $.ajax({
        contentType: "application/x-www-form-urlencoded",

        url: "../../php/uroanalisis/urinalysis_panel_control_calls_handler.php",

        type: "POST",

        data: values,

        dataType: "xml",

        success: function (xml) {
          statusBox("loading", "NULL", "NULL", "remove", "NULL");

          var response = xml.getElementsByTagName("response")[0];

          var code = parseInt(response.getAttribute("code"), 10);

          if (code == 0) {
            errorHandler(response.textContent);
          } else {
            var idArray = new Array();

            var contentArray = new Array();

            for (var x = 0; x < response.childNodes.length; x++) {
              var tempArray = response.childNodes[x].textContent.split("|");

              if (val5.toLowerCase() == "false") {
                var omit = parseInt(
                  response.childNodes[x].getAttribute("selectomit"),
                  10
                );
              } else {
                var omit = "NULL";
              }

              var content = response.childNodes[x].getAttribute("content");

              for (var y = 0; y < tempArray.length; y++) {
                if (isNaN(omit) && content == "id") {
                  idArray[y] = tempArray[y];
                } else {
                  if (isNaN(omit)) {
                    if (typeof contentArray[y] == "undefined") {
                      contentArray[y] = tempArray[y];
                    } else {
                      contentArray[y] = contentArray[y] + val4 + tempArray[y];
                    }
                  }
                }
              }
            }

            if (idArray != "") {
              for (x = 0; x < idArray.length; x++) {
                var option = document.createElement("option");

                option.setAttribute("value", idArray[x]);

                option.innerHTML = contentArray[x];

                select.appendChild(option);
              }
            }

            select.dataset.active = "true";

            $("input[type=submit]").removeAttr("disabled");

            $("input[type=submit]").removeClass("disabled");
          }
        },
      }).always(function (asdasd) {});

      break;
    case "selectFillerLabRoundLote":
      var select = $("#" + val2).get(0);
      select.innerHTML = "";
      select.value = "";
      select.removeAttribute("data-active");
      select.dataset.active = "false";

      var values = "header=" + val3;
      statusBox("loading", "NULL", "NULL", "add", "NULL");
      $("#fechas_corte").empty();
      $.ajax({
        contentType: "application/x-www-form-urlencoded",
        url: "../../php/uroanalisis/urinalysis_panel_control_calls_handler.php",
        type: "POST",
        data: values,
        dataType: "xml",
        success: function (xml) {
          statusBox("loading", "NULL", "NULL", "remove", "NULL");

          var response = xml.getElementsByTagName("response")[0];
          var code = parseInt(response.getAttribute("code"), 10);

          if (code == 0) {
            errorHandler(response.textContent);
          } else {

            var idArray = new Array();
            var contentArray = new Array();
            // console.log(response);
            for (var x = 0; x < response.childNodes.length; x++) {
              var tempArray = response.childNodes[x].textContent.split("|");
              var omit = parseInt( response.childNodes[x].getAttribute("selectomit"),10);
              var content = response.childNodes[x].getAttribute("content");

              for (var y = 0; y < tempArray.length; y++) {
                if (isNaN(omit) && content == "id") {
                  idArray[y] = tempArray[y];
                } else {
                  if (isNaN(omit)) {
                    if (typeof contentArray[y] == "undefined") {
                      contentArray[y] = tempArray[y];
                    } else {
                      contentArray[y] = contentArray[y] + val4 + tempArray[y];
                    }
                  }
                }
              }
            }

            if (idArray != "") {
              for (x = 0; x < idArray.length; x++) {
                var option = document.createElement("option");
                option.setAttribute("value", idArray[x]);
                option.innerHTML = contentArray[x];

                select.appendChild(option);
              }
            }

            select.dataset.active = "true";
          }
        },
      });

      break;

    case "selectFillerProgramaLab":
      $("input[type=submit]").attr("disabled", "disabled");

      $("input[type=submit]").addClass("disabled");

      var select = $("#" + val2).get(0);

      select.innerHTML = "";

      select.value = "";

      select.removeAttribute("data-active");

      select.dataset.active = "false";

      var values = "header=" + val3;

      statusBox("loading", "NULL", "NULL", "add", "NULL");

      $.ajax({
        contentType: "application/x-www-form-urlencoded",

        url: "../../php/uroanalisis/urinalysis_panel_control_calls_handler.php",

        type: "POST",

        data: values,

        dataType: "xml",

        success: function (xml) {
          statusBox("loading", "NULL", "NULL", "remove", "NULL");

          var response = xml.getElementsByTagName("response")[0];

          var code = parseInt(response.getAttribute("code"), 10);

          if (code == 0) {
            errorHandler(response.textContent);
          } else {
            var idArray = new Array();
            var contentArray = new Array();

            for (var x = 0; x < response.childNodes.length; x++) {
              var tempArray = response.childNodes[x].textContent.split("|");

              if (val5.toLowerCase() == "false") {
                var omit = parseInt(
                  response.childNodes[x].getAttribute("selectomit"),
                  10
                );
              } else {
                var omit = "NULL";
              }

              var content = response.childNodes[x].getAttribute("content");

              for (var y = 0; y < tempArray.length; y++) {
                if (isNaN(omit) && content == "id") {
                  idArray[y] = tempArray[y];
                } else {
                  if (isNaN(omit)) {
                    if (typeof contentArray[y] == "undefined") {
                      contentArray[y] = tempArray[y];
                    } else {
                      contentArray[y] = contentArray[y] + val4 + tempArray[y];
                    }
                  }
                }
              }
            }

            if (idArray != "") {
              for (x = 0; x < idArray.length; x++) {
                var option = document.createElement("option");

                option.setAttribute("value", idArray[x]);

                option.innerHTML = contentArray[x];

                select.appendChild(option);
              }
            }

            select.dataset.active = "true";

            $("input[type=submit]").removeAttr("disabled");

            $("input[type=submit]").removeClass("disabled");
          }
        },
      }).always(function (asdasd) {});

      break;

    default:
      alert('JS functionHandler error: id "' + id + '" not found');

      break;
  }
}

function errorHandler(val) {
  alert(val);
}

function dataChangeHandler(val, val2, val3, val4, val5) {
  var id = val;
  switch (id) {
    case "registroLabProgramaLoteDigitacion":
      let data_ajax = {
        tipo: "registroLabProgramaLoteDigitacion",
        laboratorio: $("#formLabProgramainput1").eq(0).val(),
        programa: $("#formLabProgramainput2").eq(0).val(),
        lote: $("#formLabProgramainput3").eq(0).val(),
        tipo_programa: "Cualitativo",
      };

      data_ajax = JSON.stringify(data_ajax);

      // $.post(
      //   "../../php/uroanalisis/posiblesResultados/digitacion_data_change_handler.php",
      //   { data_ajax: data_ajax },
      //   function () {
      //     /* No se hace nada por el momento */
      //   }
      // )
      $.ajax({
        url: "../../php/uroanalisis/posiblesResultados/digitacion_data_change_handler.php",
        type: "POST",
        data: { data_ajax: data_ajax },
        dataType: "xml",
      })
        .done(function (responseXML) {
          var response = responseXML.getElementsByTagName("response")[0];
          var code = parseInt(response.getAttribute("code"), 10);
          if (code == 422) {
            statusBox("warning", "NULL", response.textContent, "add", "NULL");
          } else if (code == 0) {
            statusBox(
              "warning",
              "NULL",
              "Ha ocurrido algo inesperado, por favor intente nuevamente",
              "add",
              "NULL"
            );
          } else {
            statusBox(
              "success",
              "NULL",
              "Información guardada exitosamente!",
              "add",
              "NULL"
            );
          }
        })
        .fail(function () {
          statusBox(
            "warning",
            "NULL",
            "Ha ocurrido algo inesperado, por favor intente nuevamente",
            "add",
            "NULL"
          );
        });
      break;

    default:
      alert('JS dataChangeHandler error: id "' + id + '" not found');

      break;
  }
}
