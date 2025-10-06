const clicFormat = "clic_for_52";

eventoChangeCiudad();
eventoChangeLaboratorio();
eventoChangePrograma();
eventoChangeAno();
eventoGenerarInforme();
$("#ciudad").change();

function eventoChangeCiudad() {
  $("#ciudad").change(function (e) {
    e.preventDefault();
    informacionLaboratorio();
  });
}

function eventoChangeLaboratorio() {
  $("#laboratorio").change(function (e) {
    e.preventDefault();
    informacionPrograma();
  });
}

function eventoChangePrograma() {
  $("#programa").change(function (e) {
    e.preventDefault();
    informacionAno();
    informacionRonda();
    informacionAnalito();
    informacionMuestra();
  });
}

function eventoChangeAno() {
  $("#ano").change(function (e) {
    e.preventDefault();
    informacionMes();
  });
}

function informacionLaboratorio() {
  var entrada = $("#ciudad").val();
  let id_ciudad = entrada.join(",");
  let datos = {
    tabla: `laboratorio_${clicFormat}`,
    id_filtro: id_ciudad,
  };
  $.post("php/listar_select_basico.php", datos, function () {
    /* No hacer nada de momento */
  }).always(function (data) {
    if (validarSiJSON(data)) {
      campoP = $("#laboratorio");
      campoP.html("");
      var resultado = JSON.parse(data);
      if (resultado.length > 0) {
        for (i = 0; i < resultado.length; i++) {
          var option = $(
            "<option value='" +
            resultado[i][0] +
            "' selected>" +
            resultado[i][1] +
            " " +
            resultado[i][2] +
            "</option>"
          );
          campoP.append(option);
        }
      } else {
        var option = $(
          "<option disabled selected>No hay opciones disponbiles...</option>"
        );
        campoP.append(option);
      }
      campoP.change();
    }
  });
}

function informacionPrograma() {
  var entrada = $("#laboratorio").val();
  let id_laboratorio = entrada.join(",");
  let datos = {
    tabla: `programa_${clicFormat}`,
    id_filtro: id_laboratorio,
  };
  $.post("php/listar_select_basico.php", datos, function () {
    /* No hacer nada de momento */
  }).always(function (data) {
    if (validarSiJSON(data)) {
      campoP = $("#programa");
      campoP.html("");
      var resultado = JSON.parse(data);
      if (resultado.length > 0) {
        for (i = 0; i < resultado.length; i++) {
          var option = $(
            "<option value='" +
            resultado[i][0] +
            "' selected >" +
            resultado[i][1] +
            " | " +
            resultado[i][2] +
            "</option>"
          );
          campoP.append(option);
        }
      } else {
        var option = $(
          "<option disabled selected>No hay opciones disponbiles...</option>"
        );
        campoP.append(option);
      }
      campoP.change();
    }
  });
}

function informacionAno() {
  var entrada = $("#programa").val();
  let id_programa = entrada.join(",");
  var subentrada = $("#laboratorio").val();
  let id_laboratorio = subentrada.join(",");
  let datos = {
    tabla: `ano_${clicFormat}`,
    id_filtro: id_programa,
    id_subfiltro: id_laboratorio,
  };
  $.post("php/listar_select_basico.php", datos, function () {
    /* No hacer nada de momento */
  }).always(function (data) {
    if (validarSiJSON(data)) {
      campoP = $("#ano");
      campoP.html("");
      var resultado = JSON.parse(data);
      if (resultado.length > 0) {
        for (i = 0; i < resultado.length; i++) {
          var option = $(
            "<option value='" +
            resultado[i][0] +
            "' selected >" +
            resultado[i][0] +
            "</option>"
          );
          campoP.append(option);
        }
      } else {
        var option = $(
          "<option disabled selected>No hay opciones disponbiles...</option>"
        );
        campoP.append(option);
      }
      campoP.change();
    }
  });
}

function informacionRonda() {
  var entrada = $("#programa").val();
  let id_programa = entrada.join(",");
  var subentrada = $("#laboratorio").val();
  let id_laboratorio = subentrada.join(",");
  let datos = {
    tabla: `ronda_${clicFormat}`,
    id_filtro: id_programa,
    id_subfiltro: id_laboratorio,
  };
  $.post("php/listar_select_basico.php", datos, function () {
    /* No hacer nada de momento */
  }).always(function (data) {
    if (validarSiJSON(data)) {
      campoP = $("#ronda");
      campoP.html("");
      var resultado = JSON.parse(data);
      if (resultado.length > 0) {
        for (i = 0; i < resultado.length; i++) {
          var option = $(
            "<option value='" +
            resultado[i][0] +
            "' selected >" +
            resultado[i][1] +
            "</option>"
          );
          campoP.append(option);
        }
      } else {
        var option = $(
          "<option disabled selected>No hay opciones disponbiles...</option>"
        );
        campoP.append(option);
      }
      campoP.change();
    }
  });
}

function informacionMes() {
  var entrada = $("#programa").val();
  let id_programa = entrada.join(",");
  var subentrada = $("#laboratorio").val();
  let id_laboratorio = subentrada.join(",");
  var subentradaano = $("#ano").val();
  let id_ano = subentradaano.join(",");
  let datos = {
    tabla: `mes_${clicFormat}`,
    id_filtro: id_programa,
    id_subfiltro: id_laboratorio,
    id_subfiltro2: id_ano,
  };
  $.post("php/listar_select_basico.php", datos, function () {
    /* No hacer nada de momento */
  }).always(function (data) {
    if (validarSiJSON(data)) {
      campoP = $("#mes");
      campoP.html("");
      var resultado = JSON.parse(data);
      if (resultado.length > 0) {
        for (i = 0; i < resultado.length; i++) {
          mesdeopcion = "";
          switch (resultado[i][0]) {
            case "1":
              mesdeopcion = "ENERO";
              break;
            case "2":
              mesdeopcion = "FEBRERO";
              break;
            case "3":
              mesdeopcion = "MARZO";
              break;
            case "4":
              mesdeopcion = "ABRIL";
              break;
            case "5":
              mesdeopcion = "MAYO";
              break;
            case "6":
              mesdeopcion = "JUNIO";
              break;
            case "7":
              mesdeopcion = "JULIO";
              break;
            case "8":
              mesdeopcion = "AGOSTO";
              break;
            case "9":
              mesdeopcion = "SEPTIEMBRE";
              break;
            case "10":
              mesdeopcion = "OCTUBRE";
              break;
            case "11":
              mesdeopcion = "NOVIEMBRE";
              break;
            case "12":
              mesdeopcion = "DICIEMBRE";
              break;
            default:
              mesdeopcion = "ENERO";
              break;
          }
          var option = $(
            "<option value='" +
            resultado[i][0] +
            "' selected >" +
            mesdeopcion +
            "</option>"
          );
          campoP.append(option);
        }
      } else {
        var option = $(
          "<option disabled selected>No hay opciones disponbiles...</option>"
        );
        campoP.append(option);
      }
      campoP.change();
    }
  });
}

function informacionAnalito() {
  var entrada = $("#programa").val();
  let id_programa = entrada.join(",");
  var subentrada = $("#laboratorio").val();
  let id_laboratorio = subentrada.join(",");
  let datos = {
    tabla: `analito_${clicFormat}`,
    id_filtro: id_programa,
    id_subfiltro: id_laboratorio,
  };
  $.post("php/listar_select_basico.php", datos, function () {
    /* No hacer nada de momento */
  }).always(function (data) {
    if (validarSiJSON(data)) {
      campoP = $("#analito");
      campoP.html("");
      var resultado = JSON.parse(data);
      if (resultado.length > 0) {
        for (i = 0; i < resultado.length; i++) {
          var option = $(
            "<option value='" +
            resultado[i][0] +
            "' selected >" +
            resultado[i][1] +
            "</option>"
          );
          campoP.append(option);
        }
      } else {
        var option = $(
          "<option disabled selected>No hay opciones disponbiles...</option>"
        );
        campoP.append(option);
      }
      campoP.change();
    }
  });
}

function informacionMuestra() {
  var entrada = $("#programa").val();
  let id_programa = entrada.join(",");
  var subentrada = $("#laboratorio").val();
  let id_laboratorio = subentrada.join(",");
  let datos = {
    tabla: `muestra_${clicFormat}`,
    id_filtro: id_programa,
    id_subfiltro: id_laboratorio,
  };
  $.post("php/listar_select_basico.php", datos, function () {
    /* No hacer nada de momento */
  }).always(function (data) {
    if (validarSiJSON(data)) {
      campoP = $("#muestra");
      campoP.html("");
      var resultado = JSON.parse(data);
      if (resultado.length > 0) {
        for (i = 0; i < resultado.length; i++) {
          var option = $(
            "<option value='" +
            resultado[i]["id_muestra"] +
            "|" +
            resultado[i]["id_conexion"] +
            "' selected >" +
            resultado[i]["codigo_muestra"] +
            " - MX" +
            resultado[i]["no_contador"] +
            "</option>"
          );
          campoP.append(option);
        }
      } else {
        var option = $(
          "<option disabled selected>No hay opciones disponbiles...</option>"
        );
        campoP.append(option);
      }
      campoP.change();
    }
  });
}

function eventoGenerarInforme() {
  $("#generar_reporte").click(function (e) {
    e.preventDefault();
    var entradaciudad = $("#ciudad").val();
    let ciudadId = entradaciudad.join(",");
    var entradalaboratorio = $("#laboratorio").val();
    let laboratorioId = entradalaboratorio.join(",");
    var entradaprograma = $("#programa").val();
    let programaId = entradaprograma.join(",");
    var entradamuestra = $("#muestra").val();
    submuestra1 = Array();
    submuestra2 = Array();
    entradamuestra.forEach(function (item) {
      subitem = item.split("|");
      submuestra1.push(subitem[0]);
      submuestra2.push(subitem[1]);
    });
    let mut = entradamuestra.join(",");
    let muestraId = submuestra1.join(",");
    let conexionId = submuestra2.join(",");
    var entradaanalito = $("#analito").val();
    let analitoId = entradaanalito.join(",");
    var entradaano = $("#ano").val();
    let anoId = entradaano.join(",");
    var entradames = $("#mes").val();
    let mesId = entradames.join(",");
    var entradaronda = $("#ronda").val();
    let rondaId = entradaronda.join(",");
    if (
      anoId == null ||
      mesId == null ||
      programaId == null ||
      laboratorioId == null ||
      muestraId == null ||
      conexionId == null ||
      rondaId == null ||
      ciudadId == null
    ) {
      alert(
        "Debe seleccionar todos los campos: Ciudad, laboratorio, programa, muestra, ronda, analito, ano y mes."
      );
    } else {
      $("#box_iframe").attr(
        "src",
        `php/informe/informe_clic_for_52.php?ciudad=${ciudadId}&laboratorio=${laboratorioId}&programa=${programaId}&muestra=${muestraId}&conexion=${conexionId}&analito=${analitoId}&ano=${anoId}&mes=${mesId}&ronda=${rondaId}`
      );
    }
  });
}
