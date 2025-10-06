function initialize() {





	$("#form1").bind("submit", function (event) {

		dataChangeHandler("catRegistry", "NULL", $("#form1").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form2").bind("submit", function (event) {

		dataChangeHandler("lotRegistry", "NULL", $("#form2").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form3").bind("submit", function (event) {

		dataChangeHandler("analitRegistry", "NULL", $("#form3").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form4").bind("submit", function (event) {

		dataChangeHandler("labRegistry", "NULL", $("#form4").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form5").bind("submit", function (event) {

		dataChangeHandler("labProgramAssignation", "NULL", $("#form5").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#formAsignarReto").bind("submit", function (event) {

		dataChangeHandler("labRetoAssignation", "NULL", $("#formAsignarReto").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form6").bind("submit", function (event) {

		dataChangeHandler("labAnalitAssignation", "NULL", $("#form6").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	// Código nuevo para el botón de descarga de Excel
	$("#descargarExcelBtn").on("click", function () {
		// Llama a la función que ya maneja toda la lógica de tu aplicación
		dataChangeHandler("labAnalitDownload", "NULL", $("#form6").get(0), "NULL", "NULL");
	});


	$("#form7").bind("submit", function (event) {

		dataChangeHandler("sampleRegistry", "NULL", $("#form7").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form9").bind("submit", function (event) {

		dataChangeHandler("methodRegistry", "NULL", $("#form9").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form10").bind("submit", function (event) {

		dataChangeHandler("analyzerRegistry", "NULL", $("#form10").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formMetodologia").bind("submit", function (event) {

		dataChangeHandler("metodologiaRegistry", "NULL", $("#formMetodologia").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formReportes").bind("submit", function (event) {

		event.preventDefault();

		dataChangeHandler("documentRegistry", "NULL", $("#formReportes").get(0), "NULL", "NULL");

	});



	$("#formMagnitud").bind("submit", function (event) {

		dataChangeHandler("magnitudRegistry", "NULL", $("#formMagnitud").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formUnidad").bind("submit", function (event) {

		dataChangeHandler("unidadRegistry", "NULL", $("#formUnidad").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formRetoPAT").bind("submit", function (event) {

		dataChangeHandler("retoPATRegistry", "NULL", $("#formRetoPAT").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#form11").bind("submit", function (event) {

		dataChangeHandler("reactiveRegistry", "NULL", $("#form11").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form12").bind("submit", function (event) {

		dataChangeHandler("unitRegistry", "NULL", $("#form12").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form13").bind("submit", function (event) {

		dataChangeHandler("userRegistry", "NULL", $("#form13").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form14").bind("submit", function (event) {

		dataChangeHandler("programRegistry", "NULL", $("#form14").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form15").bind("submit", function (event) {

		dataChangeHandler("labUserAssignation", "NULL", $("#form15").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form16").bind("submit", function (event) {

		dataChangeHandler("countryRegistry", "NULL", $("#form16").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form17").bind("submit", function (event) {

		dataChangeHandler("cityRegistry", "NULL", $("#form17").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form18").bind("submit", function (event) {

		callsHandler("showLog", $("#form18").get(0));

		event.preventDefault();

	});

	$("#form190").bind("submit", function (event) {

		callsHandler("showLogEnrolamiento", $("#form190").get(0));

		event.preventDefault();

	});

	$("#form19").bind("submit", function (event) {

		dataChangeHandler("copyProgram", "NULL", $("#form19").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form20").bind("submit", function (event) {

		dataChangeHandler("disRegistry", "NULL", $("#form20").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form22").bind("submit", function (event) {

		dataChangeHandler("labRoundAssignation", "NULL", $("#form22").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form23").bind("submit", function (event) {

		dataChangeHandler("analitMediaAssignation", "NULL", $("#form23").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form27").bind("submit", function (event) {

		if ($("#form27input3").val() != "") {

			dataChangeHandler("jctlmMethodRegistry", "NULL", $("#form27").get(0), "NULL", "NULL");

		}

		if ($("#form27input4").val() != "") {

			dataChangeHandler("jctlmMaterialRegistry", "NULL", $("#form27").get(0), "NULL", "NULL");

		}



		event.preventDefault();

	});

	$("#form28").bind("submit", function (event) {

		dataChangeHandler("pairJctlmMethods", "NULL", $("#form28").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form29").bind("submit", function (event) {

		dataChangeHandler("pairJctlmMaterials", "NULL", $("#form29").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form30").bind("submit", function (event) {

		dataChangeHandler("materialRegistry", "NULL", $("#form30").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form31").bind("submit", function (event) {

		dataChangeHandler("analitCualitativeTypeOfResultRegistry", "NULL", $("#form31").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#table35input1").bind("click", function (event) {

		dataChangeHandler("saveAnalitCualitativeTypeOfResult", $("#w2p").attr("data-id-holder"), "NULL", "NULL", "NULL");

		event.preventDefault();

	});

	$("#table36input1").bind("click", function (event) {

		dataChangeHandler("saveGlobalUnit", "NULL", "#table36", "NULL", "NULL");

		event.preventDefault();

	});

	$("#formCasoClinicoPAT").bind("submit", function (event) {

		dataChangeHandler("casoClinicoRegistry", "NULL", $("#formCasoClinicoPAT").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formPregunta").bind("submit", function (event) {

		dataChangeHandler("preguntaRegistry", "NULL", $("#formPregunta").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formDistractor").bind("submit", function (event) {

		dataChangeHandler("distractorRegistry", "NULL", $("#formDistractor").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formReferenciaPAT").bind("submit", function (event) {

		dataChangeHandler("referenciaRegistry", "NULL", $("#formReferenciaPAT").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formImagenPAT").bind("submit", function (event) {

		dataChangeHandler("imagenRegistry", "NULL", $("#formImagenPAT").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	$("#formGrupo").bind("submit", function (event) {

		dataChangeHandler("grupoRegistry", "NULL", $("#formGrupo").get(0), "NULL", "NULL");

		event.preventDefault();

	});



	callsHandler("showDis");

	callsHandler('showProgram');

	callsHandler('showAnalyzer');

	callsHandler('showReactive');

	callsHandler('showMaterial');

	callsHandler('showLab');

	callsHandler('showCountry');

	callsHandler('showUser');

	callsHandler('showAssignedLabUser');

	callsHandler('showRetoPAT');



	// Shows metodologia y unidad, y mensurando

	callsHandler('showMetodologia');

	callsHandler('showUnidad');

	callsHandler('showMagnitud');



	// Listar información de QAP-PAT y CAP

	functionHandler("selectFiller", "formRetoPATinput1", "showProgramPAT", " | ", "false");

	functionHandler("selectFiller", "formRetoPATinput2", "showLotePAT", " | ", "false");





	$("#form1input2").bind("change", function (event) {

		callsHandler("showCat", this.value, "id_distribuidor", "NULL", "NULL");

	});

	$("#form2input2").bind("change", function (event) {

		callsHandler("showLot", this.value, "id_catalogo", "NULL", "NULL");

		callsHandler("showAllLots", this.value, "id_catalogo", "NULL", "NULL");

	});

	$("#form9input2").bind("change", function (event) {

		callsHandler("showMethod", this.value, "id_analizador", "NULL", "NULL");

	});

	$("#form12input2").bind("change", function (event) {

		callsHandler("showUnit", this.value, "id_analizador", "NULL", "NULL");

	});

	$("#form7input2").bind("change", function (event) {

		callsHandler("showSample", this.value, "id_programa", "NULL", "NULL");

	});

	$("#form3input1").bind("change", function (event) {

		callsHandler("showAnalit", this.value, "id_programa", "NULL", "NULL");

	});



	$("#formRetoPATinput1").bind("change", function (event) {

		callsHandler("showRetoPAT", this.value, "id_programa_pat", "NULL", "NULL");

	});



	$("#formCasoClinicoPATinput1").bind("change", function (event) {

		callsHandler("showCasoClinicoPAT", this.value, "id_reto_pat", "NULL", "NULL");

	});



	$("#formDistractorinput4").bind("change", function (event) {

		callsHandler("showDistractor", this.value, "id_pregunta", "NULL", "NULL");

	});



	$("#formReferenciaPATinput2").bind("change", function (event) {

		callsHandler("showReferenciaPAT", this.value, "id_caso_clinico", "NULL", "NULL");

	});



	$("#formReferenciaPATinput1").bind("change", function (event) {

		functionHandler("selectFiller", "formReferenciaPATinput2", "showCasoClinicoPAT&filter=" + this.value + "&filterid=id_reto_pat_and_activo", " | ", "false");

	});



	$("#formImagenPATinput1").bind("change", function (event) {

		functionHandler("selectFiller", "formImagenPATinput2", "showCasoClinicoPAT&filter=" + this.value + "&filterid=id_reto_pat_and_activo", " | ", "false");

	});



	$("#formGrupoinput1").bind("change", function (event) {

		functionHandler("selectFiller", "formGrupoinput2", "showCasoClinicoPAT&filter=" + this.value + "&filterid=id_reto_pat_and_activo", " | ", "false");

	});



	$("#formPreguntainput1").bind("change", function (event) {

		functionHandler("selectFiller", "formPreguntainput2", "showCasoClinicoPAT&filter=" + this.value + "&filterid=id_reto_pat_and_activo", " | ", "false");

	});



	$("#formDistractorinput1").bind("change", function (event) {

		functionHandler("selectFiller", "formDistractorinput2", "showCasoClinicoPAT&filter=" + this.value + "&filterid=id_reto_pat_and_activo", " | ", "false");

	});



	$("#formPreguntainput2").bind("change", function (event) {

		functionHandler("selectFiller", "formPreguntainput3", "showGrupo&filter=" + this.value + "&filterid=id_caso_clinico_pat", " | ", "false");

	});



	$("#formDistractorinput2").bind("change", function (event) {

		functionHandler("selectFiller", "formDistractorinput3", "showGrupo&filter=" + this.value + "&filterid=id_caso_clinico_pat", " | ", "false");

	});



	$("#formDistractorinput3").bind("change", function (event) {

		functionHandler("selectFiller", "formDistractorinput4", "showPregunta&filter=" + this.value + "&filterid=id_grupo", " | ", "false");

	});



	$("#formImagenPATinput2").bind("change", function (event) {

		callsHandler("showImagen", this.value, "id_caso_clinico_pat", "NULL", "NULL");

	});



	$("#formGrupoinput2").bind("change", function (event) {

		callsHandler("showGrupo", this.value, "id_caso_clinico_pat", "NULL", "NULL");

	});



	$("#formPreguntainput3").bind("change", function (event) {

		callsHandler("showPregunta", this.value, "id_grupo", "NULL", "NULL");

	});



	$("#formRevalPatinput1").bind("change", function (event) {

		callsHandler("showIntentos", this.value, "id_reto", "NULL", "NULL");

	});



	$("#formReportesinput4").change(function () {

		functionHandler("showTempFiles", this, $("#formReportestable1").find("tbody")[0], "NULL", "NULL");

	});



	$("#formReportesinput3").bind("change", function (event) {

		callsHandler("showDocuments", $("#formReportesinput1").val() + "|" + $("#formReportesinput3").val(), "id_array", "NULL", "NULL");

	});





	$("#tableReportesbtn1").bind("click", function () {



		var tableId = $(this).attr("data-parent");

		var trArray = $("#" + tableId).find("tbody").find("tr").get();

		var idArray = new Array();

		var counter = 0;



		for (x = 0; x < trArray.length; x++) {

			if ($(trArray[x]).find("input[type=checkbox]").get(0).checked) {

				idArray[counter] = $(trArray[x]).attr("data-id");

				counter++;

			}

		}



		if (idArray.length > 0) {

			functionHandler("viewDocument", idArray.join("|"), "downloadMultiple");

		}

	});





	$("#form22input1").bind("change", function (event) {

		callsHandler("showAssignedLabRound", this.value, "id_laboratorio", "NULL", "NULL");

		functionHandler("selectFiller", "form22input2", "showAssignedLabProgram&filter=" + this.value + "&filterid=id_laboratorio", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_15 = setInterval(function () {

			if ($("#form22input2").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form22input2").change();

				clearInterval(timer_15);

			}

		}, 100);

	});

	$("#form22input2").bind("change", function (event) {

		functionHandler("selectFiller", "form22input3", "showAssignedProgramRound&filter=" + this.value + "&filterid=id_programa", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_16 = setInterval(function () {

			if ($("#form22input3").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form22input3").change();

				clearInterval(timer_16);

			}

		}, 100);

	});

	$("#form22input3").bind("change", function (event) {

		callsHandler("showAssignedProgramRound", this.value, "id_ronda", "NULL", "NULL");

	});

	$("#form31input1").bind("change", function (event) {

		functionHandler("selectFiller", "form31input2", "showAnalit&filter=" + this.value + "&filterid=id_programa", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_38 = setInterval(function () {

			if ($("#form31input2").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form31input2").change();

				clearInterval(timer_38);

			}

		}, 100);

	});

	$("#form31input2").bind("change", function (event) {

		callsHandler("showAnalitCualitativeTypeOfResult", this.value, "id_analito", "NULL", "NULL");

	});

	$("#form17input1").bind("change", function (event) {

		callsHandler("showCity", this.value, "id_pais", "NULL", "NULL");

	});

	$("#form5input1").bind("change", function (event) {

		callsHandler("showAssignedLabProgram", this.value, "id_laboratorio", "NULL", "NULL");

	});

	$("#AsignarRetoinput1").bind("change", function (event) {

		callsHandler("showAssignedLabReto", this.value, "id_laboratorio", "NULL", "NULL");

	});

	$("#form6input1").bind("change", function (event) {

		// alert("llega a form6input1");
		functionHandler("selectFiller", "form6input2", "showAssignedLabProgram&filter=" + this.value + "&filterid=id_laboratorio", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_11 = setInterval(function () {

			if ($("#form6input2").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form6input2").change();

				clearInterval(timer_11);

			}

		}, 100);

	});

	$("#form6input2").bind("change", function (event) {

		functionHandler("selectFiller", "form6input3", "showAnalit&filter=" + this.value + "&filterid=id_programa", " | ", "false");

		callsHandler("showAssignedLabAnalit", $("#form6input1").val() + "|" + this.value, "id_array", "NULL", "NULL");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_12 = setInterval(function () {

			if ($("#form6input3").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form6input3").change();

				clearInterval(timer_12);

			}

		}, 100);

	});

	$("#form6input3").bind("change", function (event) {

		functionHandler("selectFiller", "form6input4", "showAnalyzer", " | ", "false");

		functionHandler("selectFiller", "form6input6", "showReactive", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_13 = setInterval(function () {

			if ($("#form6input4").attr("data-active") == "true" && $("#form6input3").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form6input4").change();

				clearInterval(timer_13);

			}

		}, 100);

	});

	$("#form6input4").bind("change", function (event) {

		functionHandler("selectFiller", "form6input5", "showMethod&filter=" + this.value + "&filterid=id_analizador", " | ", "false");

		functionHandler("selectFiller", "form6input7", "showUnit&filter=" + this.value + "&filterid=id_analizador", " | ", "false");

		functionHandler("selectFiller", "form6input8", "showVitrosGen", " | ", "false");



		var tempValue = this.value;



		if (tempValue == "") {

			//

		} else {

			var tempText = $("#" + this.id + " option[value=" + tempValue + "]").text().toLowerCase();

			var tempTemplate = new RegExp("vitros", "g");



			if (tempTemplate.test(tempText)) {

				$("#form6input8").removeAttr("disabled");

				$('#form6input8').button("enable");

			} else {

				$("#form6input8").attr("disabled", "disabled");

				$("#form6input8").val($("#form6input8 option:first").val());

				$('#form6input8').button("disable");

			}

		}



	});

	$("#form6input10").bind("click", function (event) {

		statusBox("info", "NULL", "Su reporte será generado dentro de poco, este puede tardar varios minutos, por favor espere...", "add", "8000");

		window.location.href = "php/panelcontrol_excel_printer.php?header=" + $(this).attr("data-id") + "&filter=" + $("#form6input1").val() + "|" + $("#form6input2").val() + "&filterid=id_array";

	});

	$("#form24input1").bind("change", function (event) {

		callsHandler("showAssignedAnalitLimit", this.value + "|" + $("#form24input2").val(), "id_array", "NULL", "NULL");

	});

	$("#form24input2").bind("change", function (event) {

		callsHandler("showAssignedAnalitLimit", $("#form24input1").val() + "|" + this.value, "id_array", "NULL", "NULL");

	});

	$("#form25input1").bind("change", function (event) {

		callsHandler("showAssignedLabRound", this.value, "id_laboratorio", "NULL", "NULL");

		functionHandler("selectFiller", "form25input2", "showAssignedLabProgram&filter=" + this.value + "&filterid=id_laboratorio", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_20 = setInterval(function () {

			if ($("#form25input2").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form25input2").change();

				clearInterval(timer_20);

			}

		}, 100);

	});



	$("#formReportesinput2").bind("change", function (event) {

		functionHandler("selectFiller", "formReportesinput3", "showAssignedCiclosProgram&filter=" + this.value + "|" + $("#formReportesinput1").val() + "&filterid=programa_laboratorio", " | ", "false");

		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_20 = setInterval(function () {

			if ($("#formReportesinput3").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#formReportesinput3").change();

				clearInterval(timer_20);

			}

		}, 100);

	});



	$("#formReportesinput1").bind("change", function (event) {

		functionHandler("selectFiller", "formReportesinput2", "showAssignedLabProgramGeneral&filter=" + this.value + "&filterid=id_laboratorio", " | ", "false");

		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_sxsaudi = setInterval(function () {

			if ($("#formReportesinput2").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#formReportesinput2").change();

				clearInterval(timer_sxsaudi);

			}

		}, 100);

	});





	$("#form25input2").bind("change", function (event) {

		functionHandler("selectFiller", "form25input3", "showAssignedLabRoundSimple&filter=" + this.value + "|" + $("#form25input1").val() + "&filterid=id_laboratorio", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_21 = setInterval(function () {

			if ($("#form25input3").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form25input3").change();

				clearInterval(timer_21);

			}

		}, 100);

	});

	$("#form25input3").bind("change", function (event) {

		functionHandler("selectFiller", "form25input4", "showAssignedRoundSample&filter=" + this.value + "&filterid=id_ronda", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_23 = setInterval(function () {

			if ($("#form25input4").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form25input4").change();

				clearInterval(timer_23);

			}

		}, 100);

	});

	$("#form25input4").bind("change", function (event) {

		callsHandler("showAssignedLabAnalitWithResult", $("#form25input1").val() + "|" + $("#form25input2").val() + "|" + this.value, "id_array");

	});

	$("#panel16input1").bind("click", function (event) {

		dataChangeHandler("databaseDebug", "1", "NULL", "NULL", "NULL");

	});

	$("#form19input1").bind("change", function (event) {

		functionHandler("selectFiller", "form19input2", "showSampleSimple&filter=" + this.value + "&filterid=id_programa", " | ", "false");

	});

	$("#form19input3").bind("change", function (event) {

		functionHandler("selectFiller", "form19input4", "showSampleSimple&filter=" + this.value + "&filterid=id_programa", " | ", "false");

	});

	$("#form13input3").bind("keyup", function (event) {

		functionHandler('matchPassword', $('#form13input3'), $('#form13input4'), $('#passDiv1').get(0), $('#passDiv2').get(0));

		event.preventDefault();

	});

	$("#form13input4").bind("keyup", function (event) {

		functionHandler('matchPassword', $('#form13input3'), $('#form13input4'), $('#passDiv1').get(0), $('#passDiv2').get(0));

		event.preventDefault();

	});

	$("#form24input3").bind("mouseup", function (event) {

		dataChangeHandler("saveAnalitLimit", "NULL", $("#table24").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#logTab").bind("mouseup", function (event) {

		callsHandler("showLog", $("#form18").get(0));

		event.preventDefault();

	});

	$("#logTabEnrolamiento").bind("mouseup", function (event) {

		callsHandler("showLogEnrolamiento", $("#form190").get(0));

		event.preventDefault();

	});

	$("#table23Input1").bind("mouseup", function (event) {

		functionHandler("hideColumn", this.id, "table23", "NULL");

		event.preventDefault();

	});

	$("#table23Input2").bind("mouseup", function (event) {

		functionHandler("hideColumn", this.id, "table23", "NULL");

		event.preventDefault();

	});

	$("#table23Input3").bind("mouseup", function (event) {

		functionHandler("hideColumn", this.id, "table23", "NULL");

		event.preventDefault();

	});

	$("#table23Input4").bind("mouseup", function (event) {

		functionHandler("hideColumn", this.id, "table23", "NULL");

		event.preventDefault();

	});

	$("#form23input3").bind("mouseup", function (event) {

		dataChangeHandler("saveAnalitMedia", "NULL", $("#table23").get(0), "NULL", "NULL");

		event.preventDefault();

	});

	$("#form25input5").bind("mouseup", function (event) {

		dataChangeHandler("massAnalitRevalorationEditor", $("#table25").get(0), "NULL", "NULL", "NULL");

		event.preventDefault();

	});

	$("#form27input1").bind("change", function (event) {

		callsHandler('showJctlmMethod', this.value, "id_programa");

		callsHandler('showJctlmMaterial', this.value, "id_programa");

		functionHandler("selectFiller", "form27input2", "showAnalit&filter=" + this.value + "&filterid=id_programa", " | ", "false");

	});

	$("#form28input1").bind("change", function (event) {

		functionHandler("selectFiller", "form28input2", "showAnalit&filter=" + this.value + "&filterid=id_programa", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_36 = setInterval(function () {

			if ($("#form28input2").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form28input2").change();

				clearInterval(timer_36);

			}

		}, 100);

	});

	$("#form28input2").bind("change", function (event) {

		callsHandler('showPairedJctlmMethods', this.value, 'id_analito');

		functionHandler("selectFiller", "form28input3", "showInUseMethods&filter=" + this.value + "&filterid=id_analito", " | ", "false");

		functionHandler("selectFiller", "form28input4", "showJctlmMethod&filter=" + this.value + "&filterid=id_analito", " | ", "false");

	});

	$("#form29input1").bind("change", function (event) {

		functionHandler("selectFiller", "form29input2", "showAnalit&filter=" + this.value + "&filterid=id_programa", " | ", "false");



		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

		var timer_36 = setInterval(function () {

			if ($("#form29input2").attr("data-active") == "true") {

				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				$("#form29input2").change();

				clearInterval(timer_36);

			}

		}, 100);

	});

	$("#form29input2").bind("change", function (event) {

		callsHandler('showPairedJctlmMaterials', this.value, 'id_analito');

		functionHandler("selectFiller", "form29input3", "showInUseMaterials&filter=" + this.value + "&filterid=id_analito", " | ", "false");

		functionHandler("selectFiller", "form29input4", "showJctlmMaterial&filter=" + this.value + "&filterid=id_analito", " | ", "false");

	});

	$("#table36input2").bind("change", function (event) {

		callsHandler("showGlobalUnits", this.value, "id_programa", "NULL", "NULL");

	});

	if ($("#panel4").find("nav").find("li[data-id=panel4innerDiv6]").get(0)) {

		$("#panel4").find("nav").find("li[data-id=panel4innerDiv6]").bind("mouseup", function () {

			functionHandler('panelChooser', $(this).get(0), 'p4id');

			$("#form26frame1").attr("src", "index_u.php");

		});

	}

	$("#w1p").draggable();

	$("#w2p").draggable();



	var checkAmmountOfSamplesForRoundResponse = {};

	checkAmmountOfSamplesForRoundResponse = "";

}


function responseHandler(val, val2, val3, val4, val5) {



	var response = val.getElementsByTagName("response")[0];

	var code = parseInt(response.getAttribute("code"), 10);



	if (code == 422) {

		statusBox("warning", 'NULL', response.textContent, 'add', 'NULL');

	}



	if (code == 0) {

		errorHandler(response.textContent);

	} else {

		switch (val2) {

			case "catRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showCat", $("#form1input2").val(), "id_distribuidor", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "referenciaRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showReferenciaPAT", $("#formReferenciaPATinput2").val(), "id_caso_clinico", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "imagenRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showImagen", $("#formImagenPATinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;





			case "grupoRegistry":

				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showGrupo", $("#formGrupoinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}

				break;



			case "documentValueEditor":



				callsHandler("showDocuments", $("#formReportesinput1").val() + "|" + $("#formReportesinput3").val(), "id_array", "NULL", "NULL");



				break;



			case "documentDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El documento ha sido eliminado";

					callsHandler("showDocuments", $("#formReportesinput1").val() + "|" + $("#formReportesinput3").val(), "id_array", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;



			case "retoPATDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El reto PAT ha sido eliminado satisfactoriamente";

					callsHandler("showRetoPAT", $("#formRetoPATinput1").val(), "id_programa_pat", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;



			case "casoClinicoPATDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El caso clínico PAT ha sido eliminado satisfactoriamente";

					callsHandler("showCasoClinicoPAT", $("#formCasoClinicoPATinput1").val(), "id_reto_pat", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;



			case "distractorDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El distractor ha sido eliminado satisfactoriamente";

					callsHandler("showDistractor", $("#formDistractorinput4").val(), "id_pregunta", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;



			case "preguntaDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La pregunta ha sido eliminada satisfactoriamente";

					callsHandler("showPregunta", $("#formPreguntainput3").val(), "id_grupo", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;



			case "referenciaPATDeletion":

				var answer = parseInt(response.textContent, 10);

				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La referencia ha sido eliminada satisfactoriamente";

					callsHandler("showReferenciaPAT", $("#formReferenciaPATinput2").val(), "id_caso_clinico", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;



			case "imagenDeletion":

				var answer = parseInt(response.textContent, 10);

				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La referencia ha sido eliminada satisfactoriamente";

					callsHandler("showImagen", $("#formImagenPATinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;





			case "grupoDeletion":

				var answer = parseInt(response.textContent, 10);

				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El grupo ha sido eliminado satisfactoriamente";

					callsHandler("showGrupo", $("#formGrupoinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;



			case "showDocuments":



				var tbody = $("#tableReportes").find("tbody").get(0);

				tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var input = document.createElement("input");

						var button = document.createElement("button");

						var button2 = document.createElement("button");

						var button3 = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-eye-open'></span>";

						button.setAttribute("class", "btn btn-default btn-sm btn-block");

						button.setAttribute("title", "Ver");

						button.addEventListener("click", function () { functionHandler("viewDocument", $(this).parents("tr").attr("data-id"), "view"); });



						button2.innerHTML = "<span class='glyphicon glyphicon-save-file'></span>";

						button2.setAttribute("class", "btn btn-default btn-sm btn-block");

						button2.setAttribute("title", "Descargar");

						button2.addEventListener("click", function () { functionHandler("viewDocument", $(this).parents("tr").attr("data-id"), "download"); });



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("documentDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");

						var td8 = document.createElement("td");



						td1.setAttribute('class', 'unselectable left-text');

						td2.setAttribute('class', 'unselectable left-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');

						td8.setAttribute('class', 'unselectable center-text');



						input.setAttribute("type", "checkbox");



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";

						td7.dataset.id = "7";

						td8.dataset.id = "8";



						td2.dataset.text = returnValues_2[x];

						td5.dataset.text = returnValues_6[x];



						td1.appendChild(input);

						td2.innerHTML = "<img src='" + functionHandler("iconChoser", returnValues_3[x]) + "' alt='document icon' width='28' height='28'></img><span style='margin-left: 1%;' data-text='" + returnValues_2[x] + "' data-id='2'>" + returnValues_2[x] + "</span>";

						td3.innerHTML = returnValues_4[x];



						if (parseInt(returnValues_5[x], 10) == 1) {

							td4.innerHTML = "Si";

							td4.dataset.text = "Si";

						} else {

							td4.innerHTML = "No";

							td4.dataset.text = "No";

						}



						td5.innerHTML = returnValues_6[x];

						td6.appendChild(button);

						td7.appendChild(button2);

						td8.appendChild(button3);

						$(td2).find("span")[0].addEventListener("dblclick", function () { functionHandler("tableEditor", this, "input", "text", "documentValueEditor", "NULL"); });

						td4.addEventListener("dblclick", function () { functionHandler("tableEditor", this, "select", "NULL", "documentValueEditor", "showActiveStatusOptions"); });

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td7);

						tr.appendChild(td8);

						tr.dataset.id = returnValues_1[x];

						tbody.appendChild(tr);

					}

				}



				$("#tableReportes").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "showRetoPAT":



				var tbody = $("#tableRetosPAT").find("tbody").get(0);

				tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button3 = document.createElement("button");



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("retoPATDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";



						td1.innerHTML = returnValues_2[x]; // Programa

						td2.innerHTML = returnValues_4[x]; // Lote

						td3.innerHTML = returnValues_3[x]; // Nombre



						if (parseInt(returnValues_5[x], 10) == 1) { // Estado

							td4.innerHTML = "Si";

							td4.dataset.text = "Si";

						} else {

							td4.innerHTML = "No";

							td4.dataset.text = "No";

						}



						td5.appendChild(button3);

						td4.addEventListener("dblclick", function () { functionHandler("tableEditor", this, "select", "NULL", "retoPATValueEditor", "showActiveStatusOptions"); });

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);



						// td1.addEventListener("dblclick",function () { tableRetoPATEditor(this) });

						td2.addEventListener("dblclick", function () { tableRetoPATEditor(this) });

						td3.addEventListener("dblclick", function () { tableRetoPATEditor(this) });



						tr.dataset.id = returnValues_1[x];

						tbody.appendChild(tr);

					}

				}



				$("#tableReportes").find("thead").find("input[data-search-input=true]").keyup();

				break;



			case "showReferenciaPAT":

				var tbody = $("#tableReferenciasPAT").find("tbody").get(0);

				tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button3 = document.createElement("button");



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("referenciaPATDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";



						td1.innerHTML = returnValues_4[x];

						td2.innerHTML = returnValues_2[x];



						if (parseInt(returnValues_3[x], 10) == 1) { // Estado

							td3.innerHTML = "Si";

							td3.dataset.text = "Si";

						} else {

							td3.innerHTML = "No";

							td3.dataset.text = "No";

						}



						td4.appendChild(button3);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);



						td2.addEventListener("dblclick", function () { tableReferenciaPATEditor(this) });

						td3.addEventListener("dblclick", function () { functionHandler("tableEditor", this, "select", "NULL", "referenciaPATValueEditor", "showActiveStatusOptions"); }); // Estado



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableReportes").find("thead").find("input[data-search-input=true]").keyup();

				break;



			case "showCasoClinicoPAT":

				var tbody = $("#tableCasosClinicosPAT").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");

				var returnValues_8 = response.getElementsByTagName("returnvalues8")[0].textContent.split("|");

				var returnValues_9 = response.getElementsByTagName("returnvalues9")[0].textContent.split("|");

				var returnValues_10 = response.getElementsByTagName("returnvalues10")[0].textContent.split("|");

				var returnValues_11 = response.getElementsByTagName("returnvalues11")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button3 = document.createElement("button");



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("casoClinicoPATDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");

						var td8 = document.createElement("td");

						var td9 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');

						td8.setAttribute('class', 'unselectable center-text');

						td9.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";

						td7.dataset.id = "7";

						td8.dataset.id = "8";



						td1.innerHTML = returnValues_10[x] + " - " + returnValues_11[x]; // Reto PAT

						td2.innerHTML = returnValues_3[x]; // Codigo

						td3.innerHTML = returnValues_4[x]; // Nombre

						td4.innerHTML = returnValues_5[x]; // Enunciado

						td5.innerHTML = returnValues_6[x]; // Revision

						td6.innerHTML = returnValues_7[x]; // Tejido

						td7.innerHTML = returnValues_8[x]; // Celulas objetivo



						if (parseInt(returnValues_9[x], 10) == 1) { // Estado

							td8.innerHTML = "Si";

							td8.dataset.text = "Si";

						} else {

							td8.innerHTML = "No";

							td8.dataset.text = "No";

						}



						td9.appendChild(button3);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td7);

						tr.appendChild(td8);

						tr.appendChild(td9);



						td8.addEventListener("dblclick", function () { functionHandler("tableEditor", this, "select", "NULL", "casoClinicoPATValueEditor", "showActiveStatusOptions"); }); // Estado



						// td1.addEventListener("dblclick",function () { tableCasoClinicoPATEditor(this) });

						td2.addEventListener("dblclick", function () { tableCasoClinicoPATEditor(this) });

						td3.addEventListener("dblclick", function () { tableCasoClinicoPATEditor(this) });

						td4.addEventListener("dblclick", function () { tableCasoClinicoPATEditor(this) });

						td5.addEventListener("dblclick", function () { tableCasoClinicoPATEditor(this) });

						td6.addEventListener("dblclick", function () { tableCasoClinicoPATEditor(this) });

						td7.addEventListener("dblclick", function () { tableCasoClinicoPATEditor(this) });





						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableReportes").find("thead").find("input[data-search-input=true]").keyup();

				break;



			case "showDistractor":

				var tbody = $("#tableDistractoresPAT").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button3 = document.createElement("button");



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("distractorDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";



						td1.innerHTML = returnValues_6[x];

						td2.innerHTML = returnValues_2[x];

						td3.innerHTML = returnValues_3[x];

						td4.innerHTML = returnValues_4[x];



						if (parseInt(returnValues_5[x], 10) == 1) { // Estado

							td5.innerHTML = "Si";

							td5.dataset.text = "Si";

						} else {

							td5.innerHTML = "No";

							td5.dataset.text = "No";

						}



						td6.appendChild(button3);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);



						td5.addEventListener("dblclick", function () { functionHandler("tableEditor", this, "select", "NULL", "distractorValueEditor", "showActiveStatusOptions"); }); // Estado



						td2.addEventListener("dblclick", function () { tableDistractorEditor(this) });

						td3.addEventListener("dblclick", function () { tableDistractorEditor(this) });

						td4.addEventListener("dblclick", function () { tableDistractorEditor(this) });



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableReportes").find("thead").find("input[data-search-input=true]").keyup();

				break;



			case "showImagen":

				var tbody = $("#tableImagenesPAT").find("tbody").get(0);

				tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button3 = document.createElement("button");



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("imagenDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";



						td1.innerHTML = returnValues_7[x];



						console.log(returnValues_3[x]);



						switch (returnValues_3[x]) {

							case "1":

								td2.innerHTML = "Aparecerá en el formulario";

								break;

							case "2":

								td2.innerHTML = "Aparecerá en el reporte";

								break;

						}



						td3.innerHTML = returnValues_4[x];

						td4.innerHTML = returnValues_5[x];



						if (parseInt(returnValues_6[x], 10) == 1) { // Estado

							td5.innerHTML = "Si";

							td5.dataset.text = "Si";

						} else {

							td5.innerHTML = "No";

							td5.dataset.text = "No";

						}

						td6.appendChild(button3);





						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);



						td5.addEventListener("dblclick", function () { functionHandler("tableEditor", this, "select", "NULL", "imagenValueEditor", "showActiveStatusOptions"); }); // Estado

						td2.addEventListener("dblclick", function () { tableImagenEditor(this) });

						td3.addEventListener("dblclick", function () { tableImagenEditor(this) });

						td4.addEventListener("dblclick", function () { tableImagenEditor(this) });



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableImagenesPAT").find("thead").find("input[data-search-input=true]").keyup();

				break;



			case "showGrupo":

				var tbody = $("#tableGruposPAT").find("tbody").get(0);

				tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button3 = document.createElement("button");



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("grupoDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_3[x];

						td2.innerHTML = returnValues_2[x];

						td3.appendChild(button3);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						td2.addEventListener("dblclick", function () { tableGrupoEditor(this) });



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}

				$("#tableGruposPAT").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "showPregunta":

				var tbody = $("#tablePreguntasPAT").find("tbody").get(0);

				tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button3 = document.createElement("button");



						button3.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button3.setAttribute("class", "btn btn-default btn-sm btn-block");

						button3.setAttribute("title", "Eliminar");

						button3.addEventListener("click", function () { dataChangeHandler("preguntaDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');



						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";



						td1.innerHTML = returnValues_6[x];

						td2.innerHTML = returnValues_5[x];

						td3.innerHTML = returnValues_2[x];

						td4.innerHTML = returnValues_3[x];

						td5.innerHTML = returnValues_4[x];

						td6.appendChild(button3);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);



						td3.addEventListener("dblclick", function () { tablePreguntaEditor(this) });

						td4.addEventListener("dblclick", function () { tablePreguntaEditor(this) });

						td5.addEventListener("dblclick", function () { tablePreguntaEditor(this) });



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}

				$("#tableGruposPAT").find("thead").find("input[data-search-input=true]").keyup();

				break;



			case "showCat":



				var tbody = $("#table1").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("catDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { table1Editor(this) });

						td2.addEventListener("dblclick", function () { table1Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}



				}



				$("#table1").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "showIntentos":



				var tbody = $("#tableIntentosPAT").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnValues_1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnValues_2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnValues_3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnValues_4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnValues_5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnValues_6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnValues_7")[0].textContent.split("|");

				var returnValues_8 = response.getElementsByTagName("returnValues_8")[0].textContent.split("|");

				var returnValues_9 = response.getElementsByTagName("returnValues_9")[0].textContent.split("|");

				var returnValues_10 = response.getElementsByTagName("returnValues_10")[0].textContent.split("|");

				var returnValues_11 = response.getElementsByTagName("returnValues_11")[0].textContent.split("|");

				var returnValues_12 = response.getElementsByTagName("returnValues_12")[0].textContent.split("|");



				if (returnValues_11 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');



						td1.innerHTML = returnValues_6[x] + " - " + returnValues_5[x];

						td2.innerHTML = returnValues_2[x] + " - " + returnValues_3[x];

						td3.innerHTML = returnValues_8[x];

						td4.innerHTML = returnValues_9[x];

						td5.innerHTML = returnValues_10[x];



						if (parseInt(returnValues_12[x], 10) == 1) { // Si no hay revaloraacion para el ultimo intento

							td6.innerHTML = "SI";

						} else {

							td6.innerHTML = "NO";

						}



						td6.dataset.id = "6";

						td6.addEventListener("dblclick", function () { tableIntentosPATEditor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);



						tr.dataset.id = returnValues_11[x];



						tbody.appendChild(tr);

					}



				}



				$("#tableIntentosPAT").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "catValueEditor":

				callsHandler("showCat", $("#form1input2").val(), "id_distribuidor", "NULL", "NULL");

				break;





			case "retoPATValueEditor":

				callsHandler("showRetoPAT", $("#formRetoPATinput1").val(), "id_programa_pat", "NULL", "NULL");

				break;



			case "imagenValueEditor":

				callsHandler("showImagen", $("#formImagenPATinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

				break;



			case "grupoValueEditor":

				callsHandler("showGrupo", $("#formGrupoinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

				break;





			case "casoClinicoPATValueEditor":

				callsHandler("showCasoClinicoPAT", $("#formCasoClinicoPATinput1").val(), "id_reto_pat", "NULL", "NULL");

				break;



			case "preguntaValueEditor":

				callsHandler("showPregunta", $("#formPreguntainput3").val(), "id_grupo", "NULL", "NULL");

				break;



			case "distractorValueEditor":

				callsHandler("showDistractor", $("#formDistractorinput4").val(), "id_pregunta", "NULL", "NULL");

				break;



			case "referenciaPATValueEditor":

				callsHandler("showReferenciaPAT", $("#formReferenciaPATinput2").val(), "id_caso_clinico", "NULL", "NULL");

				break;



			case "formImagenPATinput2":

				callsHandler("showImagen", $("#formImagenPATinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

				break;



			case "assignedRetoLabvalueEditor":



				callsHandler("showAssignedLabReto", $("#AsignarRetoinput1").val(), "id_laboratorio", "NULL", "NULL");



				break;



			case "catDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El catalogo se ha eliminado correctamente";

					callsHandler("showCat", $("#form1input2").val(), "id_distribuidor", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "lotRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					if (answer == 0) {

						var boxType = "warning";

						var txt = "El lote ya existe en la base de datos";

					} else {

						var boxType = "success";

						var txt = "El lote se ha ingresado correctamente";

						callsHandler('showLot', $("#form2input2").val(), "id_catalogo");

						callsHandler('showAllLots', $("#form2input2").val(), "id_catalogo");

						functionHandler('formReset');

					}



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showLot":



				var tbody = $("#table2").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.innerHTML = returnValues_5[x];



						td1.addEventListener("dblclick", function () { table2Editor(this) });

						td2.addEventListener("dblclick", function () { table2Editor(this) });

						td3.addEventListener("dblclick", function () { table2Editor(this) });

						td4.addEventListener("dblclick", function () { table2Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);



					}

				}



				$("#table2").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "lotValueEditor":



				callsHandler('showLot', $("#form2input2").val(), "id_catalogo");

				callsHandler('showAllLots', $("#form2input2").val(), "id_catalogo");



				break;



			case "intentosPATValueEditor":



				callsHandler('showIntentos', $("#formRevalPatinput1").val(), "id_reto");



				break;

			case "showAllLots":



				var tbody = $("#table3").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("lotDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');



						td4.dataset.id = "5";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];



						if (parseInt(returnValues_5[x], 10) == 0) {

							td4.innerHTML = "SI";

						} else {

							td4.innerHTML = "NO";

						}



						td5.appendChild(button);



						td4.addEventListener("dblclick", function () { table3Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table3").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "lotDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El lote se ha eliminado correctamente";

					callsHandler("showLot", $("#form2input2").val(), "id_catalogo");

					callsHandler('showAllLots', $("#form2input2").val(), "id_catalogo");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "programRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showProgram", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showProgram":



				var tbody = $("#table4").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("programDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td5.dataset.id = "4";

						td6.dataset.id = "5";

						td7.dataset.id = "6";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td5.innerHTML = returnValues_5[x];

						td6.innerHTML = returnValues_6[x];

						td7.innerHTML = returnValues_7[x];

						td4.appendChild(button);



						td1.addEventListener("dblclick", function () { table4Editor(this) });

						td2.addEventListener("dblclick", function () { table4Editor(this) });

						td3.addEventListener("dblclick", function () { table4Editor(this) });

						td5.addEventListener("dblclick", function () { table4Editor(this) });

						td6.addEventListener("dblclick", function () { table4Editor(this) });

						td7.addEventListener("dblclick", function () { table4Editor(this) });



						tr.appendChild(td7);

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td3);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}



				}



				$("#table4").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "programValueEditor":



				callsHandler("showProgram", "NULL", "NULL", "NULL", "NULL");



				break;

			case "programDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El programa se ha eliminado correctamente";

					callsHandler("showProgram", "NULL", "NULL", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "analitRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showAnalit", $("#form3input1").val(), "id_programa", "NULL", "NULL");

					// $("#form21input2").change();

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showAnalit":



				var tbody = $("#table5").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("analitDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_4[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { table5Editor(this) });

						td2.addEventListener("dblclick", function () { table5Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table5").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "analitValueEditor":



				callsHandler("showAnalit", $("#form3input1").val(), "id_programa", "NULL", "NULL");

				// $("#form21input2").change();			



				break;

			case "analitDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El mensurando se ha eliminado correctamente";

					callsHandler("showAnalit", $("#form3input1").val(), "id_programa", "NULL", "NULL");

					// $("#form21input2").change();

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "sampleRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showSample", $("#form7input2").val(), "id_programa", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showSample":



				var tbody = $("#table6").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");

				var returnValues_8 = response.getElementsByTagName("returnvalues8")[0].textContent.split("|");

				var returnValues_9 = response.getElementsByTagName("returnvalues9")[0].textContent.split("|");

				var returnValues_10 = response.getElementsByTagName("returnvalues10")[0].textContent.split("|");

				var returnValues_11 = response.getElementsByTagName("returnvalues11")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("sampleDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");

						var td8 = document.createElement("td");

						var td9 = document.createElement("td");

						var td10 = document.createElement("td");

						var td11 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');

						td8.setAttribute('class', 'unselectable center-text');

						td9.setAttribute('class', 'unselectable center-text');

						td10.setAttribute('class', 'unselectable center-text');

						td11.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";

						td7.dataset.id = "7";

						td8.dataset.id = "8";

						td10.dataset.id = "9";

						td11.dataset.id = "10";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.innerHTML = returnValues_5[x];

						td5.innerHTML = returnValues_6[x];

						td6.innerHTML = returnValues_7[x];

						td7.innerHTML = returnValues_8[x];

						td8.innerHTML = returnValues_9[x];

						td10.innerHTML = returnValues_10[x];

						td11.innerHTML = returnValues_11[x];



						td9.appendChild(button);



						td1.addEventListener("dblclick", function () { table6Editor(this) });

						td3.addEventListener("dblclick", function () { table6Editor(this) });

						td4.addEventListener("dblclick", function () { table6Editor(this) });

						td5.addEventListener("dblclick", function () { table6Editor(this) });

						td6.addEventListener("dblclick", function () { table6Editor(this) });

						td7.addEventListener("dblclick", function () { table6Editor(this) });

						td8.addEventListener("dblclick", function () { table6Editor(this) });

						td9.addEventListener("dblclick", function () { table6Editor(this) });



						tr.appendChild(td11);

						tr.appendChild(td10);

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td7);

						tr.appendChild(td8);

						tr.appendChild(td9);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table6").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "sampleValueEditor":



				callsHandler("showSample", $("#form7input2").val(), "id_programa", "NULL", "NULL");



				break;

			case "sampleDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La muestra se ha eliminado correctamente";

					callsHandler("showSample", $("#form7input2").val(), "id_programa", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "analyzerRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showAnalyzer", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "metodologiaRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showMetodologia", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "magnitudRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showMagnitud", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;







			case "unidadRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showUnidad", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;





			case "retoPATRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresó un nuevo reto de patología anatómica a la base de datos";

					callsHandler("showRetoPAT", $("#formRetoPATinput1").val(), "id_programa_pat", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "showAnalyzer":



				var tbody = $("#table7").find("tbody").get(0); tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") {

					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("analyzerDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { table7Editor(this) });

						td2.addEventListener("dblclick", function () { table7Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}





				$("#table7").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "showMetodologia":

				var tbody = $("#tableMetodologia").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") { // Si hay resultados para la busqueda



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("metodologiaDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { tableMetodologiaEditor(this) });

						td2.addEventListener("dblclick", function () { tableMetodologiaEditor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableMetodologia").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "showMagnitud":

				var tbody = $("#tableMagnitud").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") { // Si hay resultados para la busqueda



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("magnitudDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { tableMagnitudEditor(this) });

						td2.addEventListener("dblclick", function () { tableMagnitudEditor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableMagnitud").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "showUnidad":

				var tbody = $("#tableUnidad").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") { // Si hay resultados para la busqueda



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("unidadDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { tableUnidadEditor(this) });

						td2.addEventListener("dblclick", function () { tableUnidadEditor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableUnidad").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "analyzerValueEditor":



				callsHandler("showAnalyzer", "NULL", "NULL", "NULL", "NULL");



				break;



			case "metodologiaValueEditor":



				callsHandler("showMetodologia", "NULL", "NULL", "NULL", "NULL");



				break;



			case "magnitudValueEditor":



				callsHandler("showMagnitud", "NULL", "NULL", "NULL", "NULL");



				break;



			case "unidadValueEditor":



				callsHandler("showUnidad", "NULL", "NULL", "NULL", "NULL");



				break;



			case "analyzerDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El analizador se ha eliminado correctamente";

					callsHandler("showAnalyzer", "NULL", "NULL", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;



			case "metodologiaDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La metodologia se ha eliminado correctamente";

					callsHandler("showMetodologia", "NULL", "NULL", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;



			case "magnitudDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El mensurando se ha eliminado correctamente";

					callsHandler("showMagnitud", "NULL", "NULL", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;





			case "unidadDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La unidad se ha eliminado correctamente";

					callsHandler("showUnidad", "NULL", "NULL", "NULL", "NULL");

				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;



			case "methodRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showMethod", $("#form9input2").val(), "id_analizador", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showMethod":



				var tbody = $("#table8").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("methodDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_4[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { table8Editor(this) });

						td2.addEventListener("dblclick", function () { table8Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table8").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "methodValueEditor":



				callsHandler("showMethod", $("#form9input2").val(), "id_analizador", "NULL", "NULL");



				break;

			case "methodDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El metodo se ha eliminado correctamente";

					callsHandler("showMethod", $("#form9input2").val(), "id_analizador", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "reactiveRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showReactive", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showReactive":



				var tbody = $("#table9").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("reactiveDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { table9Editor(this) });

						td2.addEventListener("dblclick", function () { table9Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table9").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "reactiveValueEditor":



				callsHandler("showReactive", "NULL", "NULL", "NULL", "NULL");



				break;

			case "reactiveDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El reactivo se ha eliminado correctamente";

					callsHandler("showReactive", "NULL", "NULL", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "unitRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showUnit", $("#form12input2").val(), "id_analizador", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showUnit":



				var tbody = $("#table10").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("unitDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_4[x];

						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { table10Editor(this) });

						td2.addEventListener("dblclick", function () { table10Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table10").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "unitValueEditor":



				callsHandler("showUnit", $("#form12input2").val(), "id_analizador", "NULL", "NULL");



				break;

			case "unitDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La unidad se ha eliminado correctamente";

					callsHandler("showUnit", $("#form12input2").val(), "id_analizador", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "labRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					if (answer == 0) {

						var boxType = "warning";

						var txt = "El número de laboratorio ingresado ya existe en la base de datos";

					} else {

						var boxType = "success";

						var txt = "El laboratorio se ha ingresado correctamente";

						callsHandler('showLab');

						functionHandler('formReset');

					}



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showLab":



				var tbody = $("#table11").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");

				var returnValues_8 = response.getElementsByTagName("returnvalues8")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("labDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");

						var td8 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');

						td8.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";

						td7.dataset.id = "7";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.innerHTML = returnValues_5[x];

						td5.innerHTML = returnValues_6[x];

						td6.innerHTML = returnValues_7[x];

						td7.innerHTML = returnValues_8[x];



						td8.appendChild(button);



						td1.addEventListener("dblclick", function () { table11Editor(this) });

						td2.addEventListener("dblclick", function () { table11Editor(this) });

						td3.addEventListener("dblclick", function () { table11Editor(this) });

						td4.addEventListener("dblclick", function () { table11Editor(this) });

						td5.addEventListener("dblclick", function () { table11Editor(this) });

						td6.addEventListener("dblclick", function () { table11Editor(this) });

						td7.addEventListener("dblclick", function () { table11Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td7);

						tr.appendChild(td8);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table11").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "labValueEditor":



				callsHandler("showLab", "NULL", "NULL", "NULL", "NULL");



				break;

			case "labDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El laboratorio se ha eliminado correctamente";

					callsHandler("showLab", "NULL", "NULL", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "labProgramAssignation":

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "El laboratorio ya tiene el programa seleccionado asignado";

				} else {

					var boxType = "success";

					var txt = "El programa se ha asignado correctamente";

					callsHandler('showAssignedLabProgram', $("#form5input1").val(), "id_laboratorio");

					$("#form25input1").change();

					$("#form22input1").change();

					$("#form6input1").change();

					functionHandler('formReset');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "labRetoAssignation":

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "El laboratorio ya tiene el reto seleccionado asignado";

				} else {

					var boxType = "success";

					var txt = "El reto de patología se ha asignado correctamente";

					callsHandler('showAssignedLabReto', $("#AsignarRetoinput1").val(), "id_laboratorio");

					functionHandler('formReset');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showAssignedLabProgram":



				var tbody = $("#table14").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("assignedLabProgramDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");



						var option = document.createElement("option");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];



						if (parseInt(returnValues_6[x], 10) == 1) {

							td5.innerHTML = "SI";

						} else {

							td5.innerHTML = "NO";

						}





						td4.appendChild(button);



						// td3.addEventListener("dblclick",function () { table14Editor(this) });

						td5.addEventListener("dblclick", function () { table14Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td5);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table14").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "showAssignedLabReto":



				var tbody = $("#tableAsignarReto").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("assignedLabRetoDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td7 = document.createElement("td");



						var option = document.createElement("option");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td4.dataset.id = "4";

						td7.dataset.id = "7";



						td1.innerHTML = returnValues_3[x];

						td2.innerHTML = returnValues_4[x];

						td3.innerHTML = returnValues_6[x];

						td4.innerHTML = returnValues_2[x];



						switch (returnValues_7[x]) {

							case "1":

								returnValues_7[x] = "Primer envío";

								break;

							case "2":

								returnValues_7[x] = "Segundo envío";

								break;

							case "3":

								returnValues_7[x] = "Tercer envío";

								break;

							case "4":

								returnValues_7[x] = "Cuarto envío";

								break;

						}



						td7.innerHTML = returnValues_7[x];

						td5.appendChild(button);



						td7.addEventListener("dblclick", function () { tableAsignarRetoEditor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td7);

						tr.appendChild(td5);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#tableAsignarReto").find("thead").find("input[data-search-input=true]").keyup();



				break;



			case "assignedLabProgramValueEditor":



				callsHandler("showAssignedLabProgram", $("#form5input1").val(), "id_laboratorio", "NULL", "NULL");

				$("#form25input1").change();

				$("#form22input1").change();

				$("#form6input1").change();



				break;

			case "assignedLabProgramDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El programa asignado se ha eliminado correctamente";

					callsHandler("showAssignedLabProgram", $("#form5input1").val(), "id_laboratorio", "NULL", "NULL");

					$("#form25input1").change();

					$("#form22input1").change();

					$("#form6input1").change();

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "assignedLabRetoDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El reto asignado se ha eliminado correctamente";

					callsHandler("showAssignedLabReto", $("#AsignarRetoinput1").val(), "id_laboratorio", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "labAnalitAssignation":

				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					if (answer == 0) {

						var boxType = "warning";

						var txt = "La configuración seleccionada ya existe en la base de datos";

					} else {

						var boxType = "success";

						var txt = "La configuración se ha ingresado correctamente";

						callsHandler("showAssignedLabAnalit", $("#form6input1").val() + "|" + $("#form6input2").val(), "id_array", "NULL", "NULL");

						functionHandler('formReset');

					}



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showAssignedLabAnalit": // listar tabla para la configuracion de analitos de laboratorio



				var tbody = $("#table15").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");

				var returnValues_8 = response.getElementsByTagName("returnvalues8")[0].textContent.split("|");

				var returnValues_9 = response.getElementsByTagName("returnvalues9")[0].textContent.split("|");

				var returnValues_10 = response.getElementsByTagName("returnvalues10")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");

						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("assignedLabAnalitDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var button2 = document.createElement("button");

						button2.innerHTML = "<span><b>Ver posibles resultados</b></span>";

						button2.setAttribute("class", "btn btn-default btn-sm btn-block");

						button2.addEventListener("mouseup", function () { callsHandler("showAnalitConfiguredCualitativeTypeOfResult", this.parentNode.parentNode.getAttribute("data-id"), "id_configuracion", "NULL", "NULL") });



						var td1 = document.createElement("td"); // Programa

						var td2 = document.createElement("td"); // Analito

						var td3 = document.createElement("td"); // Analizador

						var td4 = document.createElement("td"); // Generacion vitros

						var td5 = document.createElement("td"); // Metodologia

						var td6 = document.createElement("td"); // Reactivo

						var td7 = document.createElement("td"); // Unidad

						var td8 = document.createElement("td"); // Material

						var td9 = document.createElement("td"); // Estado

						var td10 = document.createElement("td"); // Ver posibles resultados

						var td11 = document.createElement("td"); // Eliminar



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');

						td8.setAttribute('class', 'unselectable center-text');

						td9.setAttribute('class', 'unselectable center-text');

						td10.setAttribute('class', 'unselectable center-text');

						td11.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";

						td7.dataset.id = "7";

						td8.dataset.id = "8";

						td9.dataset.id = "9";



						td1.innerHTML = returnValues_2[x]; // Programa

						td2.innerHTML = returnValues_3[x]; // Analito

						td3.innerHTML = returnValues_4[x]; // Analizador

						td4.innerHTML = returnValues_8[x]; // Generacion vitros

						td5.innerHTML = returnValues_5[x]; // Metodologia

						td6.innerHTML = returnValues_6[x]; // Reactivo

						td7.innerHTML = returnValues_7[x]; // Unidad

						td8.innerHTML = returnValues_9[x]; // Material



						// Estado

						if (parseInt(returnValues_10[x], 10) == 1) {

							td9.innerHTML = "SI";

						} else {

							td9.innerHTML = "NO";

						}

						td10.appendChild(button2);

						td11.appendChild(button);



						td2.addEventListener("dblclick", function () { table15Editor(this) });

						td3.addEventListener("dblclick", function () { table15Editor(this) });

						td4.addEventListener("dblclick", function () { table15Editor(this) });

						td5.addEventListener("dblclick", function () { table15Editor(this) });

						td6.addEventListener("dblclick", function () { table15Editor(this) });

						td7.addEventListener("dblclick", function () { table15Editor(this) });

						td8.addEventListener("dblclick", function () { table15Editor(this) });

						td9.addEventListener("dblclick", function () { table15Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td7);

						tr.appendChild(td8);

						tr.appendChild(td9);

						tr.appendChild(td10);

						tr.appendChild(td11);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table15").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "assignedLabAnalitValueEditor":



				callsHandler("showAssignedLabAnalit", $("#form6input1").val() + "|" + $("#form6input2").val(), "id_array", "NULL", "NULL");



				break;

			case "assignedLabAnalitDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La configuración se ha eliminado correctamente";

					callsHandler("showAssignedLabAnalit", $("#form6input1").val() + "|" + $("#form6input2").val(), "id_array", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showAssignedLabAnalitToDuplicate":



				var tbody = $("#table18").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");

				var returnValues_8 = response.getElementsByTagName("returnvalues8")[0].textContent.split("|");

				var returnValues_9 = response.getElementsByTagName("returnvalues9")[0].textContent.split("|");

				var returnValues_10 = response.getElementsByTagName("returnvalues10")[0].textContent.split("|");

				var returnValues_11 = response.getElementsByTagName("returnvalues11")[0].textContent.split("|");

				var returnValues_12 = response.getElementsByTagName("returnvalues12")[0].textContent.split("|");

				var returnValues_13 = response.getElementsByTagName("returnvalues13")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var input = document.createElement("input");

						input.setAttribute("type", "checkbox");

						input.checked = true;



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");

						var td8 = document.createElement("td");

						var td9 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');

						td8.setAttribute('class', 'unselectable center-text');

						td9.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";

						td7.dataset.id = "7";

						td8.dataset.id = "8";

						td9.dataset.id = "9";



						//td1.innerHTML = returnValues_2[x];

						//td2.innerHTML = returnValues_3[x];

						td1.innerHTML = returnValues_4[x];

						td2.innerHTML = returnValues_5[x];

						td3.innerHTML = returnValues_6[x];

						td4.innerHTML = returnValues_7[x];

						td5.innerHTML = returnValues_8[x];

						td6.innerHTML = returnValues_9[x];

						td7.innerHTML = returnValues_10[x];

						td8.innerHTML = returnValues_11[x];



						td9.appendChild(input);



						tr.appendChild(td9);

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td7);

						tr.appendChild(td8);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table18").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "countryRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showCountry", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showCountry":



				var tbody = $("#table12").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("countryDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";



						td1.innerHTML = returnValues_2[x];

						td2.appendChild(button);



						td1.addEventListener("dblclick", function () { table12Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table12").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "countryValueEditor":



				callsHandler("showCountry", "NULL", "NULL", "NULL", "NULL");



				break;

			case "countryDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El pais se ha eliminado correctamente";

					callsHandler("showCountry", "NULL", "NULL", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "cityRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					if (answer == 0) {

						var boxType = "warning";

						var txt = "La ciudad ya existe en la base de datos";

					} else {

						var boxType = "success";

						var txt = "la ciudad se ha ingresado correctamente";

						callsHandler('showCity', $("#form17input1").val(), "id_pais");

						functionHandler('formReset');

					}



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}





				break;

			case "showCity":



				var tbody = $("#table13").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("cityDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];



						td3.appendChild(button);



						td1.addEventListener("dblclick", function () { table13Editor(this) });

						td2.addEventListener("dblclick", function () { table13Editor(this) });

						td3.addEventListener("dblclick", function () { table13Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table13").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "cityValueEditor":



				callsHandler('showCity', $("#form17input1").val(), "id_pais");



				break;

			case "cityDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La ciudad se ha eliminado correctamente";

					callsHandler("showCity", $("#form17input1").val(), "id_pais", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "userRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					if (answer == 0) {

						var boxType = "warning";

						var txt = "El usuario ya existe en la base de datos";

					} else {

						var boxType = "success";

						var txt = "El usuario se ha ingresado correctamente";

						callsHandler('showUser');

						callsHandler('showAssignedLabUser');

						functionHandler('formReset');

						$("#form13input3").keyup();

					}



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}





				break;

			case "showUser":



				var tbody = $("#table16").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("userDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td5.dataset.id = "5";

						td6.dataset.id = "6";

						td7.dataset.id = "7";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td5.innerHTML = returnValues_5[x];

						td6.innerHTML = returnValues_6[x];

						td7.innerHTML = returnValues_7[x];



						switch (parseInt(returnValues_4[x], 10)) {

							case 1:

								td3.innerHTML = "Laboratorio";

								break;

							case 0:

								td3.innerHTML = "Administrador total";

								break;

							case 100:

								td3.innerHTML = "Coordinador QAP";

								break;

							case 102:

								td3.innerHTML = "Generación de informes";

								break;

							case 103:

								td3.innerHTML = "Usuario de laboratorio";

								break;

							case 125:

								td3.innerHTML = "Patólogo";

								break;

							case 126:

								td3.innerHTML = "Patólogo coordinador";

								break;

						}



						td4.appendChild(button);



						td1.addEventListener("dblclick", function () { table16Editor(this) });

						td2.addEventListener("dblclick", function () { table16Editor(this) });

						td3.addEventListener("dblclick", function () { table16Editor(this) });

						td5.addEventListener("dblclick", function () { table16Editor(this) });

						td6.addEventListener("dblclick", function () { table16Editor(this) });

						td7.addEventListener("dblclick", function () { table16Editor(this) });



						tr.appendChild(td3);

						tr.appendChild(td1);

						tr.appendChild(td7);

						tr.appendChild(td2);

						tr.appendChild(td6);

						tr.appendChild(td5);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table16").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "userValueEditor":



				callsHandler('showUser');

				callsHandler('showAssignedLabUser');



				break;

			case "userDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El usuario se ha eliminado correctamente";

					callsHandler('showUser');

					callsHandler('showAssignedLabUser');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "labUserAssignation":

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "La asignación ya existe en la base de datos";

				} else {

					var boxType = "success";

					var txt = "La asignación se ha ingresado correctamente";

					callsHandler('showAssignedLabUser');

					functionHandler('formReset');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showAssignedLabUser":



				var tbody = $("#table17").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("assignedLabUserDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td4.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];



						td4.appendChild(button);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table17").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "assignedLabUserDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La asignación se ha eliminado correctamente";

					callsHandler('showAssignedLabUser');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showLogEnrolamiento":



				var tbody = $("#tableLogEnrolamiento").find("tbody").get(0);

				tbody.innerHTML = "";



				var no_laboratorio = response.getElementsByTagName("no_laboratorio")[0].textContent.split("|");

				var nombre_programa = response.getElementsByTagName("nombre_programa")[0].textContent.split("|");

				var fecha = response.getElementsByTagName("fecha")[0].textContent.split("|");

				var nombre_usuario = response.getElementsByTagName("nombre_usuario")[0].textContent.split("|");

				var titulo = response.getElementsByTagName("titulo")[0].textContent.split("|");

				var resumen = response.getElementsByTagName("resumen")[0].textContent.split("|");



				if (no_laboratorio != "") {



					for (var x = 0; x < no_laboratorio.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");



						td1.innerHTML = no_laboratorio[x];

						td2.innerHTML = nombre_programa[x];

						td3.innerHTML = fecha[x];

						td4.innerHTML = nombre_usuario[x];

						td5.innerHTML = titulo[x];

						td6.innerHTML = resumen[x];



						tr.appendChild(td3);

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);



						tbody.appendChild(tr);

					}

				}



				$("#tableLogEnrolamiento").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "showLog":



				var tbody = $("#tableLog").find("tbody").get(0);

				tbody.innerHTML = "";



				var logid = response.getElementsByTagName("logid")[0].textContent.split("|");

				var logdate = response.getElementsByTagName("logdate")[0].textContent.split("|");

				var loghour = response.getElementsByTagName("loghour")[0].textContent.split("|");

				var loguser = response.getElementsByTagName("loguser")[0].textContent.split("|");

				var logaction = response.getElementsByTagName("logaction")[0].textContent.split("|");

				var logquery = response.getElementsByTagName("logquery")[0].textContent.split("|");



				if (logid != "") {



					for (var x = 0; x < logid.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");



						td1.innerHTML = logdate[x];

						td2.innerHTML = loghour[x];

						td3.innerHTML = loguser[x];

						td4.innerHTML = logaction[x];

						td5.innerHTML = logquery[x];



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);



						tbody.appendChild(tr);

					}

				}



				$("#tableLog").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case 'labAnalitDuplication':

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "No fue posible duplicar los analitos seleccionados, es posible que las muestras estén duplicadas";

				} else {

					var boxType = "success";

					var txt = "Los analitos se han diplucado correctamente";

					callsHandler('showAssignedLabAnalit', $("#form6input1").val(), "id_laboratorio");

					functionHandler('formReset');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;

			case "disRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showDis", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showDis":



				var tbody = $("#table19").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("disDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";



						td1.innerHTML = returnValues_2[x];

						td2.appendChild(button);



						td1.addEventListener("dblclick", function () { table19Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table19").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "disValueEditor":



				callsHandler("showDis", "NULL", "NULL", "NULL", "NULL");



				break;

			case "disDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El distribuidor se ha eliminado correctamente";

					callsHandler("showDis", "NULL", "NULL", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showAssignedProgramRound":



				var tbody = $("#table22").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table22").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "labRoundAssignation":

				if (code != 422) {

					var answer = parseInt(response.textContent, 10);



					if (answer == 0) {

						var boxType = "warning";

						var txt = "El laboratorio ya tiene la ronda seleccionada asignada";

					} else {

						var boxType = "success";

						var txt = "La ronda se ha asignado correctamente";

						callsHandler('showAssignedLabRound', $("#form22input1").val(), "id_laboratorio");

						functionHandler('formReset');

					}



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showAssignedLabRound":



				var tbody = $("#table21").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("assignedLabRoundDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.innerHTML = returnValues_5[x];



						td5.appendChild(button);

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table21").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "assignedLabRoundValueEditor":



				callsHandler('showAssignedLabRound', $("#form22input1").val(), "id_laboratorio");



				break;

			case "assignedLabRoundDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "Le asignación de ronda se ha eliminado correctamente";

					callsHandler('showAssignedLabRound', $("#form22input1").val(), "id_laboratorio");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showAssignedAnalitMedia":



				var tbody = $("#table23").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");

				var returnValues_9lvl0 = response.getElementsByTagName("returnvalues9lvl0")[0].textContent.split("|");

				var returnValues_9lvl1 = response.getElementsByTagName("returnvalues9lvl1")[0].textContent.split("|");

				var returnValues_9lvl2 = response.getElementsByTagName("returnvalues9lvl2")[0].textContent.split("|");

				var returnValues_9lvl3 = response.getElementsByTagName("returnvalues9lvl3")[0].textContent.split("|");

				var returnValues_10 = response.getElementsByTagName("returnvalues10")[0].textContent.split("|");

				var returnValues_11 = parseInt(response.getElementsByTagName("returnvalues11")[0].textContent, 10);



				var level0Counter = 0;

				var level1Counter = 0;

				var level2Counter = 0;

				var level3Counter = 0;



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");

						var td8 = document.createElement("td");

						var td9 = document.createElement("td");

						var td10 = document.createElement("td");

						var td11 = document.createElement("td");

						var td12 = document.createElement("td");

						var td13 = document.createElement("td");

						var td14 = document.createElement("td");

						var td15 = document.createElement("td");

						var td16 = document.createElement("td");

						var td17 = document.createElement("td");

						var td18 = document.createElement("td");

						var td19 = document.createElement("td");

						var td20 = document.createElement("td");



						var input1 = document.createElement("input");

						var input2 = document.createElement("input");

						var input3 = document.createElement("input");

						var input4 = document.createElement("input");

						var input5 = document.createElement("input");

						var input6 = document.createElement("input");

						var input7 = document.createElement("input");

						var input8 = document.createElement("input");

						var input9 = document.createElement("input");

						var input10 = document.createElement("input");

						var input11 = document.createElement("input");

						var input12 = document.createElement("input");



						input1.setAttribute("class", "form-control input-sm");

						input2.setAttribute("class", "form-control input-sm");

						input3.setAttribute("class", "form-control input-sm");

						input4.setAttribute("class", "form-control input-sm");

						input5.setAttribute("class", "form-control input-sm");

						input6.setAttribute("class", "form-control input-sm");

						input7.setAttribute("class", "form-control input-sm");

						input8.setAttribute("class", "form-control input-sm");

						input9.setAttribute("class", "form-control input-sm");

						input10.setAttribute("class", "form-control input-sm");

						input11.setAttribute("class", "form-control input-sm");

						input12.setAttribute("class", "form-control input-sm");



						input1.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input2.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input3.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input4.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input5.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input6.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input7.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input8.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input9.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input10.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input11.setAttribute("style", "width: 70px; padding-left: 5px !important;");

						input12.setAttribute("style", "width: 70px; padding-left: 5px !important;");



						input3.setAttribute("readonly", "readonly");

						input6.setAttribute("readonly", "readonly");

						input9.setAttribute("readonly", "readonly");



						input3.addEventListener("dblclick", function () { $(this).removeAttr("readonly"); });

						input6.addEventListener("dblclick", function () { $(this).removeAttr("readonly"); });

						input9.addEventListener("dblclick", function () { $(this).removeAttr("readonly"); });



						input3.addEventListener("blur", function () { $(this).attr("readonly", "readonly"); });

						input9.addEventListener("blur", function () { $(this).attr("readonly", "readonly"); });

						input6.addEventListener("blur", function () { $(this).attr("readonly", "readonly"); });



						$(input3).keyup(function (event) { if (event.keyCode == 13) { $(this).attr("readonly", "readonly"); } else { $(this).parent().parent().get(0).dataset.edited = "true"; } });

						$(input9).keyup(function (event) { if (event.keyCode == 13) { $(this).attr("readonly", "readonly"); } else { $(this).parent().parent().get(0).dataset.edited = "true"; } });

						$(input6).keyup(function (event) { if (event.keyCode == 13) { $(this).attr("readonly", "readonly"); } else { $(this).parent().parent().get(0).dataset.edited = "true"; } });



						input1.addEventListener("keyup", function () { $(this).parent().next().next().find("input").val(functionHandler("cvCalculator", this.value, $(this).parent().next().find("input").val())); $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

						input2.addEventListener("keyup", function () { $(this).parent().next().find("input").val(functionHandler("cvCalculator", $(this).parent().prev().find("input").val(), this.value)); $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

						input4.addEventListener("keyup", function () { $(this).parent().next().next().find("input").val(functionHandler("cvCalculator", this.value, $(this).parent().next().find("input").val())); $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

						input5.addEventListener("keyup", function () { $(this).parent().next().find("input").val(functionHandler("cvCalculator", $(this).parent().prev().find("input").val(), this.value)); $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

						input7.addEventListener("keyup", function () { $(this).parent().next().next().find("input").val(functionHandler("cvCalculator", this.value, $(this).parent().next().find("input").val())); $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

						input8.addEventListener("keyup", function () { $(this).parent().next().find("input").val(functionHandler("cvCalculator", $(this).parent().prev().find("input").val(), this.value)); $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });



						input10.addEventListener("keyup", function () { $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

						input11.addEventListener("keyup", function () { $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

						input12.addEventListener("keyup", function () { $(this).parent().parent().get(0).dataset.edited = "true"; var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });



						$(input1).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input2).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input3).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input4).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input5).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input6).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input7).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input8).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input9).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input10).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input11).bind("focus", function () { if (this.value == '0') { this.value = ""; } });

						$(input12).bind("focus", function () { if (this.value == '0') { this.value = ""; } });



						$(input1).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input2).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input3).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input4).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input5).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input6).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input7).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input8).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input9).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input10).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input11).bind("blur", function () { if (this.value == "") { this.value = 0; } });

						$(input12).bind("blur", function () { if (this.value == "") { this.value = 0; } });



						$(input1).numericInput({ allowFloat: true, allowNegative: true });

						$(input2).numericInput({ allowFloat: true, allowNegative: true });

						$(input3).numericInput({ allowFloat: true, allowNegative: true });

						$(input4).numericInput({ allowFloat: true, allowNegative: true });

						$(input5).numericInput({ allowFloat: true, allowNegative: true });

						$(input6).numericInput({ allowFloat: true, allowNegative: true });

						$(input7).numericInput({ allowFloat: true, allowNegative: true });

						$(input8).numericInput({ allowFloat: true, allowNegative: true });

						$(input9).numericInput({ allowFloat: true, allowNegative: true });

						$(input10).numericInput({ allowFloat: true, allowNegative: true });

						$(input11).numericInput({ allowFloat: true, allowNegative: true });

						$(input12).numericInput({ allowFloat: true, allowNegative: true });



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');

						td7.setAttribute('class', 'unselectable center-text');

						td8.setAttribute('class', 'unselectable center-text');

						td9.setAttribute('class', 'unselectable center-text');

						td10.setAttribute('class', 'unselectable center-text');

						td11.setAttribute('class', 'unselectable center-text');

						td12.setAttribute('class', 'unselectable center-text');

						td13.setAttribute('class', 'unselectable center-text');

						td14.setAttribute('class', 'unselectable center-text');

						td15.setAttribute('class', 'unselectable center-text');

						td16.setAttribute('class', 'unselectable center-text');

						td17.setAttribute('class', 'unselectable center-text');

						td18.setAttribute('class', 'unselectable center-text');

						td19.setAttribute('class', 'unselectable center-text');

						td20.setAttribute('class', 'unselectable center-text');



						td20.setAttribute("colspan", "4");



						td7.setAttribute("style", "border-left-width: 3px;");

						td10.setAttribute("style", "border-left-width: 3px;");

						td13.setAttribute("style", "border-left-width: 3px;");

						td16.setAttribute("style", "border-right-width: 3px;");

						td17.setAttribute("style", "border-right-width: 3px;");

						td18.setAttribute("style", "border-right-width: 3px;");

						td20.setAttribute("style", "width: 30vw;");



						td7.dataset.lvl = "1";

						td8.dataset.lvl = "1";

						td9.dataset.lvl = "1";

						td16.dataset.lvl = "1";

						td10.dataset.lvl = "2";

						td11.dataset.lvl = "2";

						td12.dataset.lvl = "2";

						td17.dataset.lvl = "2";

						td13.dataset.lvl = "3";

						td14.dataset.lvl = "3";

						td15.dataset.lvl = "3";

						td18.dataset.lvl = "3";

						td20.dataset.lvl = "0";



						td7.dataset.item = "1";

						td8.dataset.item = "2";

						td9.dataset.item = "3";

						td16.dataset.item = "4";

						td10.dataset.item = "1";

						td11.dataset.item = "2";

						td12.dataset.item = "3";

						td17.dataset.item = "4";

						td13.dataset.item = "1";

						td14.dataset.item = "2";

						td15.dataset.item = "3";

						td18.dataset.item = "4";

						td20.dataset.item = "1";



						td20.dataset.id = "1";



						input1.value = returnValues_9lvl1[level1Counter];

						input2.value = returnValues_9lvl1[(level1Counter + 1)];

						input3.value = returnValues_9lvl1[(level1Counter + 2)];

						input10.value = returnValues_9lvl1[(level1Counter + 3)];



						input4.value = returnValues_9lvl2[level2Counter];

						input5.value = returnValues_9lvl2[(level2Counter + 1)];

						input6.value = returnValues_9lvl2[(level2Counter + 2)];

						input11.value = returnValues_9lvl2[(level2Counter + 3)];



						input7.value = returnValues_9lvl3[level3Counter];

						input8.value = returnValues_9lvl3[(level3Counter + 1)];

						input9.value = returnValues_9lvl3[(level3Counter + 2)];

						input12.value = returnValues_9lvl3[(level3Counter + 3)];



						td20.innerHTML = returnValues_9lvl0[level0Counter];

						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.innerHTML = returnValues_5[x];

						td5.innerHTML = returnValues_6[x];

						td6.innerHTML = returnValues_7[x];

						td19.innerHTML = returnValues_10[x];



						td7.appendChild(input1);

						td8.appendChild(input2);

						td9.appendChild(input3);

						td10.appendChild(input4);

						td11.appendChild(input5);

						td12.appendChild(input6);

						td13.appendChild(input7);

						td14.appendChild(input8);

						td15.appendChild(input9);

						td16.appendChild(input10);

						td17.appendChild(input11);

						td18.appendChild(input12);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td19);

						tr.appendChild(td7);

						tr.appendChild(td8);

						tr.appendChild(td9);

						tr.appendChild(td16);

						tr.appendChild(td10);

						tr.appendChild(td11);

						tr.appendChild(td12);

						tr.appendChild(td17);

						tr.appendChild(td13);

						tr.appendChild(td14);

						tr.appendChild(td15);

						tr.appendChild(td18);

						tr.appendChild(td20);



						var tempInputArrya = $(tr).find("input").get();



						for (var y = 0; y < tempInputArrya.length; y++) {

							if (tempInputArrya[y].value == 'undefined' || tempInputArrya[y].value == '') {

								tempInputArrya[y].value = 0;

							}

						}



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);



						level0Counter++;

						level1Counter = (level1Counter + 4);

						level2Counter = (level2Counter + 4);

						level3Counter = (level3Counter + 4);



					}

				}



				$("#table23").find("thead").find("input[data-search-input=true]").keyup();



				switch (returnValues_11) {

					case 0:

						functionHandler("hideColumn", "table23Input1", "table23", "1");

						functionHandler("hideColumn", "table23Input2", "table23", "1");

						functionHandler("hideColumn", "table23Input3", "table23", "1");

						functionHandler("hideColumn", "table23Input4", "table23", "0");

						break;

					case 1:

						functionHandler("hideColumn", "table23Input1", "table23", "0");

						functionHandler("hideColumn", "table23Input2", "table23", "1");

						functionHandler("hideColumn", "table23Input3", "table23", "1");

						functionHandler("hideColumn", "table23Input4", "table23", "1");

						break;

					case 2:

						functionHandler("hideColumn", "table23Input1", "table23", "1");

						functionHandler("hideColumn", "table23Input2", "table23", "0");

						functionHandler("hideColumn", "table23Input3", "table23", "1");

						functionHandler("hideColumn", "table23Input4", "table23", "1");

						break;

					case 3:

						functionHandler("hideColumn", "table23Input1", "table23", "1");

						functionHandler("hideColumn", "table23Input2", "table23", "1");

						functionHandler("hideColumn", "table23Input3", "table23", "0");

						functionHandler("hideColumn", "table23Input4", "table23", "1");

						break;

				}



				break;

			case "showAssignedAnalitLimit":



				var tbody = $("#table24").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					var tempId = functionHandler("uniqId");



					var tempSelect = document.createElement("select");



					tempSelect.setAttribute("class", "form-control input-sm");

					tempSelect.setAttribute("style", "display:none;");

					tempSelect.id = tempId;



					tbody.appendChild(tempSelect);



					functionHandler("selectFiller", tempId, "showAssignedAnalitLimitType", " | ", "false");



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_32 = setInterval(function () {

						if ($("#" + tempId).attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



							for (var x = 0; x < returnValues_1.length; x++) {



								var tr = document.createElement("tr");



								var td1 = document.createElement("td");

								var td2 = document.createElement("td");

								var td3 = document.createElement("td");

								var td4 = document.createElement("td");



								var input1 = document.createElement("input");



								input1.setAttribute("class", "form-control input-sm");



								input1.addEventListener("keyup", function () { $(this).parent().parent().get(0).dataset.edited = "true"; });



								$(input1).numericInput({ allowFloat: true, allowNegative: true });



								td1.setAttribute('class', 'unselectable center-text');

								td2.setAttribute('class', 'unselectable center-text');

								td3.setAttribute('class', 'unselectable center-text');

								td4.setAttribute('class', 'unselectable center-text');



								td1.innerHTML = returnValues_2[x];

								td2.innerHTML = returnValues_3[x];



								if (returnValues_4[x] == "") {

									input1.value = 0;

								} else {

									input1.value = returnValues_4[x]

								}



								td3.appendChild(input1);



								$(tempSelect).clone().removeAttr("id style").appendTo(td4);



								var tempOptionArray = $(td4).find("select").find("option").get();

								$(td4).find("select").bind("change", function () { $(this).parent().parent().get(0).dataset.edited = "true"; });



								for (y = 0; y < tempOptionArray.length; y++) {

									if (parseInt(tempOptionArray[y].value, 10) == parseInt(returnValues_5[x], 10)) {

										tempOptionArray[y].selected = "selected";

										break;

									}

								}



								tr.appendChild(td1);

								tr.appendChild(td2);

								tr.appendChild(td3);

								tr.appendChild(td4);



								tr.dataset.id = returnValues_1[x];



								tbody.appendChild(tr);



							}



							$("#table24").find("thead").find("input[data-search-input=true]").keyup();

							$("#" + tempId).remove();

							clearInterval(timer_32);



						}

					}, 100);





				}



				break;

			case 'saveAnalitLimit':

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "Ha ocurrido un error, por favor comuniquese con el administrador del sistema";

				} else {

					var boxType = "success";

					var txt = "Los datos se han guardado correctamente";

					callsHandler('showAssignedAnalitLimit', $('#form24input1').val() + "|" + $('#form24input2').val(), "id_array");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showAssignedLabAnalitWithResult":



				var tbody = $("#table25").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");

				var returnValues_8 = response.getElementsByTagName("returnvalues8")[0].textContent.split("|");

				var returnValues_10 = response.getElementsByTagName("returnvalues10")[0].textContent.split("|");

				var returnValues_11 = response.getElementsByTagName("returnvalues11")[0].textContent.split("|");

				var returnValues_12 = response.getElementsByTagName("returnvalues12")[0].textContent.split("|");

				var returnValues_13 = response.getElementsByTagName("returnvalues13")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var td0 = document.createElement("td");

						var td1 = document.createElement("td");

						var td2 = document.createElement("td");



						var input = document.createElement("input");



						td0.setAttribute('class', 'center-text');

						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');



						input.setAttribute("type", "checkbox");



						td1.dataset.id = "1";

						td2.dataset.id = "2";



						td0.appendChild(input);

						td1.innerHTML = returnValues_2[x];



						if (parseInt(returnValues_12[x], 10) == 0) {

							td2.innerHTML = "NO";

							td2.addEventListener("dblclick", function () { table25Editor(this) });

						} else if (parseInt(returnValues_12[x], 10) == 1) {

							td2.innerHTML = "SI";

							td2.addEventListener("dblclick", function () { table25Editor(this) });

						} else {

							td2.innerHTML = "No se ha registrado resultado";

							td2.addEventListener("dblclick", function () { table25Editor(this) });

						}

						tr.appendChild(td0);

						tr.appendChild(td1);

						tr.appendChild(td2);

						if (parseInt(returnValues_11[x], 10) == 0 || returnValues_11[x] == "") {

							var vitrosInfo = ""

						} else {

							var vitrosInfo = "Generación de VITROS n° " + returnValues_11[x] + " | ";

						}



						tr.setAttribute("title", returnValues_2[x] + " | " + returnValues_3[x] + " | " + vitrosInfo + returnValues_4[x] + " | " + returnValues_5[x] + " | " + returnValues_6[x] + " | Resultado " + returnValues_7[x] + " | Fecha de resultado " + returnValues_10[x]);

						tr.setAttribute("data-toggle", "tooltip");

						tr.setAttribute("data-placement", "bottom");

						tr.setAttribute("data-idconfiguracion", returnValues_13[x]);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}



					if ($("#form25input6").get(0).checked == true) {

						$("#form25input6").get(0).checked = false;

					}



					$("[data-toggle=tooltip]").tooltip();

				}



				break;

			case "analitRevalorationEditor":



				callsHandler("showAssignedLabAnalitWithResult", $("#form25input1").val() + "|" + $("#form25input2").val() + "|" + $("#form25input4").val(), "id_array");

				break;

			case "massAnalitRevalorationEditor":



				callsHandler("showAssignedLabAnalitWithResult", $("#form25input1").val() + "|" + $("#form25input2").val() + "|" + $("#form25input4").val(), "id_array");

				break;

			case "databaseDebug":

				var step = parseInt(response.textContent.split("|")[0], 10);

				var statusText = response.textContent.split("|")[1];



				switch (step) {

					case 1:

					case 2:

					case 3:

					case 4:

					case 5:

					case 6:

					case 7:

					case 8:

					case 9:

						$("#p16Console").html($("#p16Console").html() + statusText + "<br/><br/>");

						dataChangeHandler("databaseDebug", (step + 1), "NULL", "NULL", "NULL");

						break;

					case 10:

						$("#p16Console").html($("#p16Console").html() + statusText + "<br/><br/>Actualizando listas... ");

						$(document).find("select").change();

						$("#p16Console").html($("#p16Console").html() + "Hecho.<br/><br/>Depuración finalizada.<br/><br/>");

						break;

				}



				$('#p16Console').animate({ scrollTop: $('#p16Console').prop("scrollHeight") }, 50);



				break;

			case "copyProgram":

				statusBox("success", 'NULL', "Clonado finalizado.", 'add', 'NULL');

				break;

			case "showReferenceValue":



				var tbody = $("#table26").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|");

				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("referenceValueDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");

						var td6 = document.createElement("td");

						var td7 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');

						td6.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						td5.dataset.id = "5";

						td6.dataset.id = "6";



						td4.addEventListener("dblclick", function () { table26Editor(this) });

						td5.addEventListener("dblclick", function () { table26Editor(this) });

						td6.addEventListener("dblclick", function () { table26Editor(this) });



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.innerHTML = returnValues_5[x];

						td5.innerHTML = returnValues_6[x];

						td6.innerHTML = returnValues_7[x];



						td7.appendChild(button);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td6);

						tr.appendChild(td5);

						tr.appendChild(td7);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table26").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "jctlmMethodRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler('showJctlmMethod', $("#form27input1").val(), "id_programa");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showJctlmMethod":



				var tbody = $("#table27").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("jctlmMethodDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";



						td3.addEventListener("dblclick", function () { table27Editor(this) });

						td4.addEventListener("dblclick", function () { table27Editor(this) });



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];



						if (parseInt(returnValues_5[x], 10) == 1) {

							td4.innerHTML = "SI";

						} else {

							td4.innerHTML = "NO";

						}



						td5.appendChild(button);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table27").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "jctlmMethodValueEditor":



				callsHandler('showJctlmMethod', $("#form27input1").val(), "id_programa");



				break;

			case "jctlmMethodDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El método se ha eliminado correctamente";

					callsHandler('showJctlmMethod', $("#form27input1").val(), "id_programa");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "jctlmMaterialRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler('showJctlmMaterial', $("#form27input1").val(), "id_programa");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showJctlmMaterial":



				var tbody = $("#table28").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("jctlmMaterialDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var td5 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						td5.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";



						td3.addEventListener("dblclick", function () { table28Editor(this) });

						td4.addEventListener("dblclick", function () { table28Editor(this) });



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];



						if (parseInt(returnValues_5[x], 10) == 1) {

							td4.innerHTML = "SI";

						} else {

							td4.innerHTML = "NO";

						}



						td5.appendChild(button);



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table28").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "jctlmMaterialValueEditor":



				callsHandler('showJctlmMaterial', $("#form27input1").val(), "id_programa");



				break;

			case "jctlmMaterialDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El material se ha eliminado correctamente";

					callsHandler('showJctlmMaterial', $("#form27input1").val(), "id_programa");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "materialRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showMaterial", "NULL", "NULL", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "casoClinicoRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";



					callsHandler("showCasoClinicoPAT", $("#formCasoClinicoPATinput1").val(), "id_reto_pat", "NULL", "NULL");



					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "preguntaRegistry":

				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showPregunta", $("#formPreguntainput3").val(), "id_grupo", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}

				break;



			case "distractorRegistry":

				if (code != 422) {

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showDistractor", $("#formDistractorinput4").val(), "id_pregunta", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}

				break;



			case "imagenRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showImagen", $("#formImagenPATinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "grupoRegistry":

				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showGrupo", $("#formGrupoinput2").val(), "id_caso_clinico_pat", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}

				break;



			case "formReferenciaPAT":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);

					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showReferenciaPAT", $("#formReferenciaPATinput2").val(), "id_caso_clinico", "NULL", "NULL");

					functionHandler('formReset');

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;



			case "showMaterial":



				var tbody = $("#table29").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("materialDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "1";



						td1.innerHTML = returnValues_2[x];

						td2.appendChild(button);



						td1.addEventListener("dblclick", function () { table29Editor(this) });



						tr.appendChild(td1);

						tr.appendChild(td2);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}



				$("#table29").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "materialValueEditor":



				callsHandler("showMaterial", "NULL", "NULL", "NULL", "NULL");



				break;

			case "materialDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El material se ha eliminado correctamente";

					callsHandler("showMaterial", "NULL", "NULL", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "pairJctlmMethods":

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "Los valores seleccionados ya existe en la base de datos";

				} else {

					var boxType = "success";

					var txt = "Los valores seleccionados se han ingresado correctamente";

					callsHandler('showPairedJctlmMethods', $("#form28input2").val(), 'id_analito');

					functionHandler('formReset');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showPairedJctlmMethods":



				var tbody = $("#table31").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("pairedJctlmMethodDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');



						td1.dataset.id = "3";

						td2.dataset.id = "1";

						td3.dataset.id = "2";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.appendChild(button);



						tr.appendChild(td3);

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}



				}



				$("#table31").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "pairedJctlmMethodDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El valor se ha eliminado correctamente";

					callsHandler('showPairedJctlmMethods', $("#form28input2").val(), 'id_analito');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "pairJctlmMaterials":

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "Los valores seleccionados ya existe en la base de datos";

				} else {

					var boxType = "success";

					var txt = "Los valores seleccionados se han ingresado correctamente";

					callsHandler('showPairedJctlmMaterials', $("#form29input2").val(), 'id_analito');

					functionHandler('formReset');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showPairedJctlmMaterials":



				var tbody = $("#table32").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("pairedJctlmMaterialDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');



						td3.dataset.id = "1";

						td1.dataset.id = "2";

						td2.dataset.id = "3";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						td4.appendChild(button);



						tr.appendChild(td3);

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}



				}



				$("#table32").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "pairedJctlmMaterialDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El valor se ha eliminado correctamente";

					callsHandler('showPairedJctlmMaterials', $("#form29input2").val(), 'id_analito');

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "analitCualitativeTypeOfResultRegistry":



				if (code != 422) { // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent, 10);



					var boxType = "success";

					var txt = "Se ingresaron " + answer + " valores a la base de datos.";

					callsHandler("showAnalitCualitativeTypeOfResult", $("#form31input2").val(), "id_analito", "NULL", "NULL");

					functionHandler('formReset');



					statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				}



				break;

			case "showAnalitCualitativeTypeOfResult":



				var tbody = $("#table33").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");

						var button = document.createElement("button");



						button.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";

						button.setAttribute("class", "btn btn-default btn-sm");

						button.addEventListener("mouseup", function () { dataChangeHandler("analitCualitativeTypeOfResultDeletion", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL"); });



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						// var td3 = document.createElement("td");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						// td3.setAttribute('class','unselectable center-text');



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						td3.innerHTML = returnValues_4[x];

						// td3.appendChild(button);



						td2.addEventListener("dblclick", function () { table33Editor(this) });
						td3.addEventListener("dblclick", function () { table33Editor(this) });




						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						// tr.appendChild(td3);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}



				}



				$("#table33").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "showAnalitConfiguredCualitativeTypeOfResult":



				var tbody = $("#table35").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");



						td1.setAttribute('class', 'unselectable');

						td1.setAttribute('colspan', '2');



						uniqId = functionHandler("uniqId");



						td1.innerHTML = "<label for='" + uniqId + "' style='width:100%; height: 100%;'><input type='checkbox' checked='checked' id='" + uniqId + "' value='" + returnValues_1[x] + "'></input> " + returnValues_2[x] + "</label>";





						tr.appendChild(td1);



						tbody.appendChild(tr);

					}



				}



				if (returnValues_3 != "") {



					for (var x = 0; x < returnValues_3.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");



						td1.setAttribute('class', 'unselectable');

						td1.setAttribute('colspan', '2');



						uniqId = functionHandler("uniqId");



						td1.innerHTML = "<label for='" + uniqId + "' style='width:100%; height: 100%;'><input type='checkbox' id='" + uniqId + "' value='" + returnValues_3[x] + "'></input> " + returnValues_4[x] + "</label>";



						tr.appendChild(td1);



						tbody.appendChild(tr);

					}



				}



				if (val4 == "no_window_action") {

					//

				} else {

					functionHandler('windowHandler', 'window2');

				}



				$("#w2p").attr("data-id-holder", val3);

				$("#table35").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case "analitCualitativeTypeOfResultValueEditor":



				callsHandler("showAnalitCualitativeTypeOfResult", $("#form31input2").val(), "id_analito", "NULL", "NULL");



				break;

			case "analitCualitativeTypeOfResultDeletion":



				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "El valor se ha eliminado correctamente";

					callsHandler("showAnalitCualitativeTypeOfResult", $("#form31input2").val(), "id_analito", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showAssignedProgramType":



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent;



				if (returnValues_1 != "") {



					$("#" + val3).val(returnValues_1);

					$("#" + val3).change();



				}



				break;

			case 'saveAnalitCualitativeTypeOfResult':

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "Ha ocurrido un error, por favor comuniquese con el administrador del sistema";

				} else {

					var boxType = "success";

					var txt = "Los datos se han guardado correctamente";

					callsHandler("showAnalitConfiguredCualitativeTypeOfResult", val3, "id_configuracion", "no_window_action", "NULL")

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			case "showGlobalUnits":



				var tbody = $("#table36").find("tbody").get(0);

				tbody.innerHTML = "";



				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



				if (returnValues_1 != "") {



					for (var x = 0; x < returnValues_1.length; x++) {



						var tr = document.createElement("tr");



						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");



						var input = document.createElement("input");

						var input2 = document.createElement("input");



						td1.setAttribute('class', 'unselectable center-text');

						td2.setAttribute('class', 'unselectable center-text');

						td3.setAttribute('class', 'unselectable center-text');

						td4.setAttribute('class', 'unselectable center-text');

						input.setAttribute("class", "form-control input-sm");

						input2.setAttribute("class", "form-control input-sm");



						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";



						td1.innerHTML = returnValues_2[x];

						td2.innerHTML = returnValues_3[x];

						input.value = returnValues_4[x];

						input2.value = returnValues_5[x];



						td3.appendChild(input);

						td4.appendChild(input2);



						$(td3).find("input").bind("change", function () { $(this).parent().parent().get(0).dataset.edited = "true"; });



						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}

				$("#table36").find("thead").find("input[data-search-input=true]").keyup();



				break;

			case 'saveGlobalUnit':

				var answer = parseInt(response.textContent, 10);



				if (answer == 0) {

					var boxType = "warning";

					var txt = "Ha ocurrido un error, por favor comuniquese con el administrador del sistema";

				} else {

					var boxType = "success";

					var txt = "Los datos se han guardado correctamente";

					callsHandler("showGlobalUnits", $("#table36input2").val(), "id_programa", "NULL", "NULL");

				}



				statusBox(boxType, 'NULL', txt, 'add', 'NULL');



				break;

			default:

				alert('JS responseHandler error: id "' + val2 + '" not found');

				break;

		}

	}

}



function callsHandler(val, val2, val3, val4, val5) {



	var id = val;

	switch (id) {



		case "showRetoPAT":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, "showRetoPAT", "NULL", "NULL", "NULL");

					functionHandler('selectFiller', 'AsignarRetoinput2', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

					functionHandler('selectFiller', 'formRevalPatinput1', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

					functionHandler('selectFiller', 'formCasoClinicoPATinput1', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

					functionHandler('selectFiller', 'formReferenciaPATinput1', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

					functionHandler('selectFiller', 'formImagenPATinput1', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

					functionHandler('selectFiller', 'formGrupoinput1', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

					functionHandler('selectFiller', 'formPreguntainput1', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

					functionHandler('selectFiller', 'formDistractorinput1', 'showRetoPAT&filter=1&filterid=activos', " | ", "false");

				}

			});



			break;



		case "showCasoClinicoPAT":

			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, "showCasoClinicoPAT", "NULL", "NULL", "NULL");

				}

			}).always(function (asdsd) {

				// console.log(asdsd);

			});

			break;



		case "showDistractor":

			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, "showDistractor", "NULL", "NULL", "NULL");

				}

			}).always(function (asdsd) {

				// console.log(asdsd);

			});

			break;



		case "showImagen":

			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, "showImagen", "NULL", "NULL", "NULL");

				}

			}).always(function (asdsd) {

				console.log(asdsd);

			});

			break;



		case "showGrupo":

			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, "showGrupo", "NULL", "NULL", "NULL");

				}

			}).always(function (asdsd) {

				console.log(asdsd);

			});

			break;



		case "showPregunta":

			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, "showPregunta", "NULL", "NULL", "NULL");

				}

			}).always(function (asdsd) {

				console.log(asdsd);

			});

			break;



		case "showReferenciaPAT":

			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, "showReferenciaPAT", "NULL", "NULL", "NULL");

				}

			}).always(function (asdsd) {

				console.log(asdsd);

			});

			break;



		case "showDocuments":



			if (val4 == "uploadResponse") {

				var timer = '4000';

			} else {

				var timer = 0;

			}



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			setTimeout(function () {

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_calls_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, "showDocuments", "NULL", "NULL", "NULL");

					}

				}).always(function (saddasd) {

				});

			}, timer);



			break;



		case "showIntentos":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			}).always(function (sda) {

			});



			break;

		case "showDis":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form1input2', 'showDis', " | ", "false");



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_1 = setInterval(function () {

						if ($("#form1input2").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form1input2").change();

							clearInterval(timer_1);

						}

					}, 100);



					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});



			break;

		case "showCat":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form2input2', 'showCat', " | ", "false");



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_2 = setInterval(function () {

						if ($("#form2input2").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form2input2").change();

							clearInterval(timer_2);

						}

					}, 100);



					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showLot":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form7input3', 'showLot&filter=1&filterid=estado_lote', " | ", "false");



					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAllLots":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showProgram":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form7input2', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form3input1', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form5input2', 'showProgram', " | ", "false");

					// functionHandler('selectFiller','form21input8','showProgram&filterid=id_tipo_programa&filter=2'," | ","false");

					functionHandler('selectFiller', 'form24input1', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form19input1', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'formEnrolamientoLoginput2', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form19input3', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form27input1', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form28input1', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form29input1', 'showProgram', " | ", "false");

					functionHandler('selectFiller', 'form31input1', 'showProgram&filterid=id_tipo_programa&filter=2', " | ", "false");

					functionHandler('selectFiller', 'table36input2', 'showProgram', " | ", "false");



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_5 = setInterval(function () {

						if ($("#form7input2").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form7input2").change();

							clearInterval(timer_5);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_6 = setInterval(function () {

						if ($("#form3input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form3input1").change();

							clearInterval(timer_6);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_19 = setInterval(function () {

						if ($("#form24input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form24input1").change();

							clearInterval(timer_19);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_27 = setInterval(function () {

						if ($("#form19input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form19input1").change();

							clearInterval(timer_27);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_28 = setInterval(function () {

						if ($("#form19input3").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form19input3").change();

							clearInterval(timer_28);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_33 = setInterval(function () {

						if ($("#form27input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form27input1").change();

							clearInterval(timer_33);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_34 = setInterval(function () {

						if ($("#form28input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form28input1").change();

							clearInterval(timer_34);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_35 = setInterval(function () {

						if ($("#form29input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form29input1").change();

							clearInterval(timer_35);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_37 = setInterval(function () {

						if ($("#form31input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form31input1").change();

							clearInterval(timer_37);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_42 = setInterval(function () {

						if ($("#table36input2").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#table36input2").change();

							clearInterval(timer_42);

						}

					}, 100);



					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAnalit":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showSample":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAnalyzer":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form6input4', 'showAnalyzer', " | ", "false");

					functionHandler('selectFiller', 'form9input2', 'showAnalyzer', " | ", "false");

					functionHandler('selectFiller', 'form12input2', 'showAnalyzer', " | ", "false");

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_3 = setInterval(function () {

						if ($("#form9input2").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form9input2").change();

							clearInterval(timer_3);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_4 = setInterval(function () {

						if ($("#form12input2").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form12input2").change();

							clearInterval(timer_4);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");



				}

			});



			break;



		case "showMetodologia":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form9input1', 'showMetodologia', " | ", "false"); // Valor de referencia

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});

			break;





		case "showUnidad":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {



					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form12input1', 'showUnidad', " | ", "false"); // Valor de referencia					

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});

			break;





		case "showMagnitud":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {



					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form3input2', 'showMagnitud', " | ", "false");

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});

			break;





		case "showMethod":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showReactive":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form6input6', 'showReactive', " | ", "false");

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showUnit":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showLab":


			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form5input1', 'showLab', " | ", "false");

					functionHandler('selectFiller', 'form6input1', 'showLab', " | ", "false");

					functionHandler('selectFiller', 'form15input2', 'showLab', " | ", "false");

					functionHandler('selectFiller', 'form22input1', 'showLab', " | ", "false");

					functionHandler('selectFiller', 'form25input1', 'showLab', " | ", "false");

					functionHandler('selectFiller', 'formEnrolamientoLoginput1', 'showLab', " | ", "false");

					functionHandler('selectFiller', 'formReportesinput1', 'showLab', " | ", "false");

					functionHandler('selectFiller', 'AsignarRetoinput1', 'showLab&filterid=patologia', " | ", "false");



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_9 = setInterval(function () {

						if ($("#form5input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form5input1").change();

							clearInterval(timer_9);

						}

					}, 100);



					var timer_2569 = setInterval(function () {

						if ($("#AsignarRetoinput1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#AsignarRetoinput1").change();

							clearInterval(timer_2569);

						}

					}, 100);



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_10 = setInterval(function () {

						if ($("#form6input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form6input1").change();

							clearInterval(timer_10);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_14 = setInterval(function () {

						if ($("#form22input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form22input1").change();

							clearInterval(timer_14);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_22 = setInterval(function () {

						if ($("#form25input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form25input1").change();

							clearInterval(timer_22);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_sdasdeq = setInterval(function () {

						if ($("#formReportesinput1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#formReportesinput1").change();

							clearInterval(timer_sdasdeq);

						}

					}, 100);

					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");



				}

			});



			break;

		case "showAssignedLabProgram":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;





		case "showAssignedLabReto":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;



		case "showAssignedLabAnalit":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showCountry":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form17input1', 'showCountry', " | ", "false");



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_8 = setInterval(function () {

						if ($("#form17input1").attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							$("#form17input1").change();

							clearInterval(timer_8);

						}

					}, 100);



					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showCity":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form4input5', 'showCity', " | ", "false");

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showUser":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					functionHandler('selectFiller', 'form15input1', 'showUser', " | ", "false");



					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAssignedLabUser":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showLog":



			var values = "header=" + id + "&" + $(val2).serialize();

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showLogEnrolamiento":



			var values = "header=" + id + "&" + $(val2).serialize();

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			}).always(function (asds) {

			});



			break;

		case "showAssignedLabAnalitToDuplicate":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAssignedProgramAnalit":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAssignedProgramRound":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAssignedLabRound":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAssignedAnalitMedia":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});



			break;

		case "showAssignedAnalitLimit":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showAssignedLabAnalitWithResult":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showReferenceValue":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showJctlmMethod":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showJctlmMaterial":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			})



			break;

		case "showMaterial":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");



					functionHandler('selectFiller', 'form6input9', 'showMaterial', " | ", "false");

				}

			})



			break;

		case "showPairedJctlmMethods":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});



			break;

		case "showPairedJctlmMaterials":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});



			break;

		case "showAnalitCualitativeTypeOfResult":

		case "showAnalitCualitativeTypeOfResult2":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			}).always(function (asfefdsf) {

			});



			break;

		case "showAnalitConfiguredCualitativeTypeOfResult":





			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, val2, "NULL", "NULL");

				}

			}).always(function (dsadsafe) {

			});



			break;

		case "showAssignedProgramType":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, val4, "NULL", "NULL");

				}

			})



			break;

		case "checkAmmountOfSamplesForRound":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					checkAmmountOfSamplesForRoundResponse = xml.getElementsByTagName("response")[0].textContent;

				}

			});



			break;

		case "showGlobalUnits":



			if (typeof (val2) == 'undefined') {

				var values = "header=" + id;

			} else {

				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;

			}



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});



			break;

		default:

			alert('JS callsHandler error: id "' + id + '" not found');

			break;

	}

}



function dataChangeHandler(val, val2, val3, val4, val5) {

	var id = val;



	switch (id) {

		case "catRegistry":

			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (fsffd) {

				});

			}

			break;



		case "documentValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadasf) {

				});



				node.dataset.edited = 1;

			}



			break;


		case "documentRegistry":



			var maxFileSize = 104857600;

			var fileInput = $("#formReportesinput4")[0];



			var itemCounter = {};

			itemCounter = 0;

			var errorCounter = {};

			errorCounter = 0;

			var errorTxtCounter = {};



			var max = {};

			max = fileInput.files.length;



			var error = false;

			var errorTxt = "";

			var progress = 0;



			if (window.File && window.FileReader && window.FileList && window.Blob) {

				if (max == 0) {

					errorTxt = errorTxt + " No ha seleccionado ningún archivo.<br/>";

					error = true;

				} else {

					for (var x = 0; x < max; x++) {

						var fsize = fileInput.files[x].size;

						var ftype = fileInput.files[x].type;



						if (functionHandler("mimeChecker", ftype)) {

							errorTxt = errorTxt + "No es posible cargar este tipo de archivo para '" + fileInput.files[x].name + "'.<br/>";

							error = true;

						}



						if (fsize > maxFileSize) {

							errorTxt = errorTxt + "El tamaño del archivo es demasiado grande para '" + fileInput.files[x].name + "'. El tamañaximo permitido es 100 MB.<br/>";

							error = true;

						}



						if (error) {

							break;

						}

					}

				}

			} else {



				errorTxt = errorTxt + "El buscador web que actualmente usa no sporta los plug-in necesarios para utlizar esta aplicación, por favor cambie de buscador.<br/>";

				error = true;



			}



			if (error) {



				var boxType = "warning";



				statusBox(boxType, 'NULL', errorTxt, "add", '5000');



			} else {



				$("#statusBox").remove();

				var errorTxtCounter = new Array();

				var loadingBars = "<span>Cargando archivos...</span>"

					+ "<br/>"

					+ "<div class='progress'>"

					+ "<div class='progress-bar' role='progressbar' data-id='progressbar1'></div>"

					+ "</div>"

					+ "<div class='progress'>"

					+ "<div class='progress-bar' role='progressbar' data-id='progressbar2'></div>"

					+ "</div>";

				statusBox("loading", 'NULL', loadingBars, "add", 'null');



				for (x = 0; x < max; x++) {



					var data = new FormData();



					data.append('header', id);

					data.append('documentfiles', fileInput.files[x], fileInput.files[x].name);

					data.append('clientid', $("#formReportesinput1").val());

					data.append('programid', $("#formReportesinput2").val());

					data.append('cicloid', $("#formReportesinput3").val());

					data.append('item', (x + 1));



					$.ajax({

						url: 'php/panelcontrol_data_change_handler.php',

						type: 'POST',

						xhr: function () {



							var xhr = $.ajaxSettings.xhr();

							if (xhr.upload) {

								xhr.upload.onprogress = updateProgress1;

							}



							return xhr;



						},

						data: data,

						cache: false,

						dataType: 'xml',

						processData: false,

						contentType: false,

						success: function (xml) {

							if (parseInt(xml.getElementsByTagName("response")[0].getAttribute("code"), 10) == 0) {

								errorTxtCounter[errorCounter] = xml.getElementsByTagName("response")[0].textContent;

								errorCounter++;

							}

						}

					}).always(function (asdsadsa) {

					});

				}



				function updateProgress1(e) {



					if (e.lengthComputable) {

						var innerMax = e.total;

						var current = e.loaded;



						var percentage = Math.floor((current * 100) / innerMax);



						$("[data-id=progressbar1]").attr("style", "width: " + percentage + "%");

						$("[data-id=progressbar1]").html(percentage + "%");



						if (percentage >= 100) {



							itemCounter++;



							$("#formReportestable1").find("tbody").find("[data-item=" + itemCounter + "]").remove();



							var fileProgress = Math.round((itemCounter * 100) / max);



							$("[data-id=progressbar2]").attr("style", "width: " + fileProgress + "%");

							$("[data-id=progressbar2]").html(fileProgress + "%");



							if (itemCounter == max) {



								setTimeout(function () {



									if (errorCounter > 0) {

										alert("Se han encontrado los siguientes errores durante la carga:\n\n" + errorTxtCounter.join("\n"));

										var boxType = "warning";

										var txt = "Carga completa con errores";

									} else {

										var boxType = "success";

										var txt = "Carga completa";

									}



									callsHandler("showDocuments", $("#formReportesinput1").val() + "|" + $("#formReportesinput3").val(), "id_array", "uploadResponse", "NULL");

									statusBox(boxType, 'NULL', txt, 'add', 'NULL');



								}, 4000);



								$("#formReportestable1").find("tbody").html("");

								functionHandler("fieldReset", "formReportesinput4");

								statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



							}

						}

					}

				}

			}



			break;



		case "catValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "assignedRetoLabvalueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sdsadsd) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "catDeletion":



			var question = confirm("¿Está seguro que desea eliminar el catalogo?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "lotRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

				});

			}



			break;

		case "lotValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

				});

				node.dataset.edited = 1;

			}

			break;



		case "intentosPATValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

				});

				node.dataset.edited = 1;

			}

			break;



		case "retoPATValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					// console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "imagenValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "grupoValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "casoClinicoPATValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "preguntaValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "distractorValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "referenciaPATValueEditor":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "formImagenPATinput2":

			var node = val3;

			if (parseInt(node.getAttribute("data-edited")) == 0) {

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;

				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

					console.log(sadsad);

				});

				node.dataset.edited = 1;

			}

			break;



		case "lotDeletion":

			var question = confirm("¿Está seguro que desea eliminar el lote?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}

			break;



		case "programRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sdsf) {

				});

			}



			break;

		case "programValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "documentDeletion":



			var question = confirm("¿Está seguro que desea eliminar este documento?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

				});

			}



			break;



		case "retoPATDeletion":



			var question = confirm("¿Está seguro que desea eliminar el reto de patología anatómica? esto borrará permanentemente toda su información relacionada");



			if (question) {



				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

				});

			}



			break;



		case "casoClinicoPATDeletion":



			var question = confirm("¿Está seguro que desea eliminar un caso clínico de patología anatómica? esto borrará permanentemente toda su información relacionada");



			if (question) {

				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

				});

			}



			break;



		case "distractorDeletion":



			var question = confirm("¿Está seguro que desea eliminar un distractor de patología anatómica? esto borrará permanentemente toda su información relacionada");



			if (question) {

				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

				});

			}



			break;



		case "preguntaDeletion":



			var question = confirm("¿Está seguro que desea eliminar la pregunta de patología anatómica? esto borrará permanentemente toda su información relacionada");



			if (question) {

				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

				});

			}



			break;



		case "referenciaPATDeletion":

			var question = confirm("¿Está seguro que desea eliminar la referencia de patología anatómica?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

					console.log(asdsd);

				});

			}

			break;





		case "imagenDeletion":

			var question = confirm("¿Está seguro que desea eliminar la imagen de patología anatómica?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

					console.log(asdsd);

				});

			}

			break;



		case "grupoDeletion":

			var question = confirm("¿Está seguro que desea eliminar el grupo de patología anatómica?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

					console.log(asdsd);

				});

			}

			break;





		case "programDeletion":



			var question = confirm("¿Está seguro que desea eliminar el programa?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "analitRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

				});

			}



			break;

		case "analitValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsad) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "analitDeletion":



			var question = confirm("¿Está seguro que desea eliminar el analito?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "sampleRegistry":



			if (functionHandler('inputChecker', val3)) {



				callsHandler("checkAmmountOfSamplesForRound", $("#form7input2").val() + "|" + $("#form7input5").val(), "id_array", "NULL", "NULL")



				var timer_39 = setInterval(function () {

					if (checkAmmountOfSamplesForRoundResponse != "") {

						if (parseInt(checkAmmountOfSamplesForRoundResponse, 10) == 1) {

							var values = "header=" + id + "&" + $(val3).serialize();



							statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



							$.ajax({

								contentType: "application/x-www-form-urlencoded",

								url: "php/panelcontrol_data_change_handler.php",

								type: "POST",

								data: values,

								dataType: "xml",

								success: function (xml) {

									statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

									responseHandler(xml, id, "NULL", "NULL", "NULL");

								}

							}).always(function (sdad) {

							});



							checkAmmountOfSamplesForRoundResponse = "";

							clearInterval(timer_39);



						} else {

							statusBox('warning', 'NULL', 'Esta ronda ya contiene el número máximo permitido de muestras', 'add', '4000');

							checkAmmountOfSamplesForRoundResponse = "";

							clearInterval(timer_39);

						}

					}

				}, 100);

			}



			break;

		case "sampleValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "sampleDeletion":



			var question = confirm("¿Está seguro que desea eliminar la muestra?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "analyzerRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).done(function (sdsfrg) {

				});

			}



			break;

		case "metodologiaRegistry":



			if (functionHandler('inputChecker', val3)) {



				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (result) {

				});

			}



			break;



		case "magnitudRegistry":



			if (functionHandler('inputChecker', val3)) {



				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (result) {

				});

			}



			break;



		case "unidadRegistry":



			if (functionHandler('inputChecker', val3)) {



				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (result) {

				});

			}



			break;





		case "retoPATRegistry":



			if (functionHandler('inputChecker', val3)) {



				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (result) {

				});

			}



			break;



		case "analyzerValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {



						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");



					}

				})



				node.dataset.edited = 1;



			}



			break;



		case "metodologiaValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading"); // Mostrar el cargando

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (result) {

				})



				node.dataset.edited = 1;

			}



			break;



		case "magnitudValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading"); // Mostrar el cargando

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (result) {

				})



				node.dataset.edited = 1;

			}



			break;



		case "unidadValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading"); // Mostrar el cargando

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (result) {

				})



				node.dataset.edited = 1;

			}



			break;



		case "analyzerDeletion":



			var question = confirm("¿Está seguro que desea eliminar el analizador?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "metodologiaDeletion":



			var question = confirm("¿Está seguro que desea eliminar la metodología seleccionada?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;



		case "magnitudDeletion":



			var question = confirm("¿Está seguro que desea eliminar el mensurando seleccionado?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;



		case "unidadDeletion":



			var question = confirm("¿Está seguro que desea eliminar la unidad seleccionada?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "methodRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadas) {

				});

			}



			break;

		case "methodValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "methodDeletion":



			var question = confirm("¿Está seguro que desea eliminar el metodo?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "reactiveRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sdsfe) {

				});

			}



			break;

		case "reactiveValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "reactiveDeletion":



			var question = confirm("¿Está seguro que desea eliminar el reactivo?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "unitRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadas) {

				});

			}



			break;

		case "unitValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sdadsa) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "unitDeletion":



			var question = confirm("¿Está seguro que desea eliminar la unidad?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "labRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsd) {

				});

			}



			break;

		case "labValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsd) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "labDeletion":



			var question = confirm("¿Está seguro que desea eliminar el laboratorio?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "labProgramAssignation":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (dssadsad) {

				});

			}



			break;



		case "labRetoAssignation":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (dssadsad) {

				});

			}



			break;



		case "assignedLabProgramValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "assignedLabProgramDeletion":



			var question = confirm("¿Está seguro que desea eliminar el programa asignado?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;



		case "assignedLabRetoDeletion":



			var question = confirm("¿Está seguro que desea eliminar el reto asignado?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				}).always(function (sads) {

				});

			}



			break;

		case "labAnalitAssignation":



			if (functionHandler('inputChecker', val3)) {



				if ($("#form6input8").attr("disabled") == "disabled") {

					$("#form6input8").removeAttr("disabled");

					$('#form6input8').button("enable");

					var values = "header=" + id + "&" + $(val3).serialize();

					$("#form6input8").attr("disabled", "disabled");

					$('#form6input8').button("disable");

				} else {

					var values = "header=" + id + "&" + $(val3).serialize();

				}



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;
		case "labAnalitDownload":
			// Lógica para el botón de descarga del enrolamiento de los laboratorios
			var formData = new FormData();
			formData.append('labid', document.getElementById('form6input1').value);
			formData.append('programid', document.getElementById('form6input2').value);


			// Muestra una caja de carga
			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

			fetch("php/download_excel_enrolamiento.php", {
				method: "POST",
				body: formData,
			})
				.then(response => {
					// Store the response object to use it later
					if (!response.ok) {
						return response.text().then(text => {
							throw new Error(text || 'Error desconocido del servidor');
						});
					}
					// Return both the response and the blob
					return response.blob().then(blob => ({ response, blob }));
				})
				.then(({ response, blob }) => { // Destructure the object to get both variables
					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					var url = window.URL.createObjectURL(blob);
					var a = document.createElement('a');
					a.style.display = 'none';
					a.href = url;

					// Now 'response' is available here
					var disposition = response.headers.get('Content-Disposition');
					var filename = 'reporte_' + new Date().toISOString().slice(0, 10) + '.xlsx';

					if (disposition && disposition.indexOf('attachment') !== -1) {
						var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
						var matches = filenameRegex.exec(disposition);
						if (matches != null && matches[1]) {
							filename = decodeURIComponent(matches[1].replace(/['"]/g, ''));
						}
					}
					a.download = filename;

					document.body.appendChild(a);
					a.click();
					window.URL.revokeObjectURL(url);
					document.body.removeChild(a);
				})
				.catch(error => {
					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
					console.error("Error al descargar el archivo:", error.message);
					alert("Error: " + error.message);
				});

			break;
		case "assignedLabAnalitValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				}).always(function (asdsfds) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "assignedProgramAnalitValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "assignedLabAnalitDeletion":



			var question = confirm("¿Está seguro que desea eliminar la configuración?\n\nTodos los resultados que se reportaron con esta configuración también serán eliminados.\n\n¿Está seguro que desea continuar?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

				});

			}



			break;

		case "countryRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

				});

			}



			break;

		case "countryValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (fsfeer) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "countryDeletion":



			var question = confirm("¿Está seguro que desea eliminar el pais?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "cityRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsads) {

				});

			}



			break;

		case "cityValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsads) {

				});

				node.dataset.edited = 1;



			}



			break;

		case "cityDeletion":



			var question = confirm("¿Está seguro que desea eliminar la ciudad?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "userRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&username=" + $("#form13input2").val() + "&userpassword=" + $.md5($("#form13input4").val()) + "&usertype=" + $("#form13input1").val() + "&codigo=" + $("#cod_user_registry").val() + "&email=" + $("#email_user_registry").val() + "&fullname=" + $("#form13inputNombre").val();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "userValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					if (node.type == "password") {

						var txt = $.md5(node.value);

					} else {

						var txt = node.value;

					}

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadsd) {

				});



				node.dataset.edited = 1;



			}



			break;

		case "userDeletion":



			var question = confirm("¿Está seguro que desea eliminar el usuario?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "labUserAssignation":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "assignedLabUserDeletion":



			var question = confirm("¿Está seguro que desea eliminar la asignación?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "labAnalitDuplication":



			if (functionHandler('inputChecker', val3)) {



				var ids = new Array();

				var idSum = 0;



				var trArray = $("#table18").find("tbody").find("tr").get();

				for (var x = 0; x < trArray.length; x++) {

					var input = trArray[x].getElementsByTagName("input")[0];



					if (input.checked == true) {

						ids[idSum] = trArray[x].getAttribute("data-id");

						idSum++;

					}

				}



				var idArray = "&ids=" + ids.join("|");

				if (idArray == "&ids=") {

					alert("No ha seleccionado ningún item.");

				} else {



					var values = "header=" + id + "&" + $(val3).serialize() + idArray;



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



					$.ajax({

						contentType: "application/x-www-form-urlencoded",

						url: "php/panelcontrol_data_change_handler.php",

						type: "POST",

						data: values,

						dataType: "xml",

						success: function (xml) {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							responseHandler(xml, id, "NULL", "NULL", "NULL");





						}

					});

				}

			}



			break;

		case "disRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsads) {

				});

			}



			break;

		case "disValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sdsd) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "disDeletion":



			var question = confirm("¿Está seguro que desea eliminar el distribuidor?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "assignedProgramAnalitValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "assignedProgramAnalitDeletion":



			var question = confirm("¿Está seguro que desea eliminar la configuración?\n\nTodos los resultados que se reportaron con esta configuración también serán eliminados.\n\n¿Está seguro que desea continuar?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "labRoundAssignation":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "assignedLabRoundValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "assignedLabRoundDeletion":



			var question = confirm("¿Está seguro que desea eliminar la asignación de ronda?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "analitMediaAssignation":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "saveAnalitLimit":



			var idArray = new Array();

			var limitArray = new Array();

			var limitTypeArray = new Array();



			var trArray = $(val3).find("tbody").find("tr[data-edited=true]").get();



			if (trArray.length > 0) {

				for (x = 0; x < trArray.length; x++) {

					idArray[x] = trArray[x].getAttribute("data-id");

					limitArray[x] = $(trArray[x]).find("input").get(0).value;

					limitTypeArray[x] = $(trArray[x]).find("select").get(0).value;

				}



				idArray = idArray.join("|");

				limitArray = limitArray.join("|");

				limitTypeArray = limitTypeArray.join("|");



				var values = "header=" + id + "&limitid=" + $("#form24input2").val() + "&ids=" + idArray + "&limits=" + limitArray + "&limittypes=" + limitTypeArray;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			} else {

				statusBox('info', 'NULL', 'No se ha modificado ningún dato', 'add', '3000');

			}



			break;

		case "analitRevalorationEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");

				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2 + "&filterconfig=" + val4;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

				})



				node.dataset.edited = 1;

			}



			break;

		case "massAnalitRevalorationEditor":



			var ids = new Array();

			var id_configs = new Array();

			var idSum = 0;



			var trArray = $(val2).find("tbody").find("tr").get();

			for (var x = 0; x < trArray.length; x++) {

				var input = $(trArray[x]).find("input[type=checkbox]").get(0);



				if (input.checked == true) {

					ids[idSum] = trArray[x].getAttribute("data-id");

					id_configs[idSum] = trArray[x].getAttribute("data-idconfiguracion");

					idSum++;

				}

			}



			var values = "header=" + id + "&id=" + ids.join("|") + "&value=1&which=2&configs_values=" + id_configs.join("|") + "&muestravalue=" + $("#form25input4").val();



			if (idSum == 0) {

				alert("No ha seleccionado ningún item.");

			} else {



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsd) {

				})

			}



			break;

		case "databaseDebug":



			var values = "header=" + id + "&step=" + val2;



			switch (parseInt(val2)) {

				case 1:

					$("#p16Console").html($("#p16Console").html() + "Eliminando archivos PDF temporales... ");

					break;

				case 2:

					$("#p16Console").html($("#p16Console").html() + "Realizando copia de seguridad... ");

					break;

				case 3:

					$("#p16Console").html($("#p16Console").html() + "Eliminando analizadores no utilizados... ");

					break;

				case 4:

					$("#p16Console").html($("#p16Console").html() + "Eliminando metodologias no utilizadas... ");

					break;

				case 5:

					$("#p16Console").html($("#p16Console").html() + "Eliminando unidades no utilizadas... ");

					break;

				case 6:

					$("#p16Console").html($("#p16Console").html() + "Eliminando reactivos no utilizados... ");

					break;

				case 7:

					$("#p16Console").html($("#p16Console").html() + "Eliminando asignaciones usuario -> laboratorio no utilizadas... ");

					break;

				case 8:

					$("#p16Console").html($("#p16Console").html() + "Eliminando historial de acciones... ");

					break;

				case 9:

					$("#p16Console").html($("#p16Console").html() + "Eliminando historial de sesión de usuarios... ");

					break;

				case 10:

					$("#p16Console").html($("#p16Console").html() + "Eliminando gráficas temporales... ");

					break;

			}



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_data_change_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			});



			break;

		case "copyProgram":



			if (functionHandler('inputChecker', val3)) {



				var checkboxValues = "";



				var checkboxArray = new Array(

					$("#form19input5").get(0)

					, $("#form19input6").get(0)

					, $("#form19input7").get(0)

					, $("#form19input8").get(0)

					, $("#form19input9").get(0)

				);



				for (var x = 0; x < checkboxArray.length; x++) {

					if (checkboxArray[x].checked) {

						if (x == 0) {

							checkboxValues += checkboxArray[x].value;

						} else {

							checkboxValues += "|" + checkboxArray[x].value;

						}



					}

				}



				if (checkboxValues == "") {

					statusBox("info", "NULL", "No se ha seleccionado ningún dato para clonar", "add", "NULL");

				} else {



					var values = "header=" + id + "&fromprogram=" + $("#form19input1").val() + "&fromsample=" + $("#form19input2").val() + "&toprogram=" + $("#form19input3").val() + "&tosample=" + $("#form19input4").val() + "&items=" +

						checkboxValues



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



					$.ajax({

						contentType: "application/x-www-form-urlencoded",

						url: "php/panelcontrol_data_change_handler.php",

						type: "POST",

						data: values,

						dataType: "xml",

						success: function (xml) {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							responseHandler(xml, id, "NULL", "NULL", "NULL");

						}

					});

				}

			}



			break;

		case "referenceValueRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "referenceValueValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "referenceValueDeletion":



			var question = confirm("¿Está seguro que desea eliminar el valor de referencia?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "jctlmMethodRegistry":



			var values = "header=" + id + "&" + $(val3).serialize();



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_data_change_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			}).always(function (sdsads) {

			});



			break;

		case "jctlmMethodValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				}).always(function (sdsads) {

				});



				node.dataset.edited = 1;



			}



			break;

		case "jctlmMethodDeletion":



			var question = confirm("¿Está seguro que desea eliminar el método?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "jctlmMaterialRegistry":



			var values = "header=" + id + "&" + $(val3).serialize();



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_data_change_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, "NULL", "NULL", "NULL");

				}

			}).always(function (asdsad) {

			});



			break;

		case "jctlmMaterialValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				}).always(function (sdsads) {

				});



				node.dataset.edited = 1;



			}



			break;

		case "jctlmMaterialDeletion":



			var question = confirm("¿Está seguro que desea eliminar el material?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "materialRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				}).always(function (asdsad) {

				});

			}



			break;



		case "casoClinicoRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;



		case "preguntaRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;



		case "distractorRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;



		case "imagenRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;





		case "grupoRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;



		case "referenciaRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;





		case "imagenRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;





		case "grupoRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (asdsad) {

					console.log(asdsad);

				});

			}



			break;





		case "materialValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sdsads) {

				});



				node.dataset.edited = 1;



			}



			break;

		case "materialDeletion":



			var question = confirm("¿Está seguro que desea eliminar el material?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "pairJctlmMethods":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "pairedJctlmMethodDeletion":



			var question = confirm("¿Está seguro que desea eliminar el valor?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "pairJctlmMaterials":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");





					}

				});

			}



			break;

		case "pairedJctlmMaterialDeletion":



			var question = confirm("¿Está seguro que desea eliminar el valor?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "analitCualitativeTypeOfResultRegistry":



			if (functionHandler('inputChecker', val3)) {

				var values = "header=" + id + "&" + $(val3).serialize();



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sadasd) {

				});

			}



			break;

		case "analitCualitativeTypeOfResultValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				}).always(function (sdsadsd) {

				})



				node.dataset.edited = 1;



			}



			break;

		case "analitCualitativeTypeOfResultDeletion":



			var question = confirm("¿Está seguro que desea eliminar el valor?");

			if (question) {

				var values = "header=" + id + "&ids=" + val2;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			}



			break;

		case "mediaValueEditor":



			var node = val3;



			if (parseInt(node.getAttribute("data-edited")) == 0) {



				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}



				var nodeId = node.getAttribute("data-id");



				var values = "header=" + id + "&id=" + nodeId + "&value=" + txt + "&which=" + val2 + "&otherids=" + val4;



				node.setAttribute("class", "form-control loading");

				node.setAttribute("disabled", "disabled");



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				})



				node.dataset.edited = 1;



			}



			break;

		case "saveAnalitCualitativeTypeOfResult":



			var ids1 = new Array();

			var ids2 = new Array();

			var idSum1 = 0;

			var idSum2 = 0;



			var trArray = $("#table35").find("tbody").find("tr").get();



			for (var x = 0; x < trArray.length; x++) {

				var input = trArray[x].getElementsByTagName("input")[0];



				if (input.checked == true) {

					ids1[idSum1] = input.value;

					idSum1++;

				} else {

					ids2[idSum2] = input.value;

					idSum2++;

				}

			}



			var values = "header=" + id + "&configid=" + val2 + "&toinsert=" + ids1.join("|") + "&todelete=" + ids2.join("|");



			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_data_change_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					responseHandler(xml, id, val2, "NULL", "NULL");

				}

			});



			break;

		case "saveGlobalUnit":



			var idArray = new Array();

			var globalUnitArray = new Array();

			var conversionFactortArray = new Array();



			var trArray = $(val3).find("tbody").find("tr[data-edited=true]").get();



			if (trArray.length > 0) {

				for (x = 0; x < trArray.length; x++) {

					idArray[x] = trArray[x].getAttribute("data-id");

					globalUnitArray[x] = $(trArray[x]).find("input").get(0).value;

					conversionFactortArray[x] = $(trArray[x]).find("input").get(1).value;

				}



				idArray = idArray.join("|");

				globalUnitArray = globalUnitArray.join("|");

				conversionFactortArray = conversionFactortArray.join("|");



				var values = "header=" + id + "&ids=" + idArray + "&globalunits=" + globalUnitArray + "&conversionfactors=" + conversionFactortArray;



				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url: "php/panelcontrol_data_change_handler.php",

					type: "POST",

					data: values,

					dataType: "xml",

					success: function (xml) {

						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						responseHandler(xml, id, "NULL", "NULL", "NULL");

					}

				});

			} else {

				statusBox('info', 'NULL', 'No se ha modificado ningún dato', 'add', '3000');

			}



			break;

		default:

			alert('JS dataChangeHandler error: id "' + id + '" not found');

			break;

	}



}



function table1Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showDis";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("catValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("catValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 2:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("catValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("catValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table2Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showCat";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

						var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_3[x] + " | " + returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 2:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 3:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "date");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 2;

			ids[2] = 3;

			names[0] = "1";

			names[1] = "2";

			names[2] = "3";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table3Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 5:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 0;

			ids[1] = 1;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("lotValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function tableReferenciaPATEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 2:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("textarea");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput w-100");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("referenciaPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("referenciaPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;



		case 3:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("referenciaPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("referenciaPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;

	}

}



function tableDistractorEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 2:

		case 3:

		case 4:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("input");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("distractorValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("distractorValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("distractorValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("distractorValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function tablePreguntaEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 3:

		case 4:

		case 5:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("input");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("preguntaValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("preguntaValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;

	}

}



function tableCasoClinicoPATEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:

			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showRetoPAT&filter=1&filterid=activos";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);

					if (code == 0) {

						errorHandler(response.textContent);

					} else {

						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

						var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



						if (returnValues_1 != "") {

							for (var x = 0; x < returnValues_1.length; x++) {

								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x] + " - " + returnValues_3[x];

								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}

								input.appendChild(option);

							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("casoClinicoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("casoClinicoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 4:

		case 5:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("textarea");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput w-100");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("casoClinicoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("casoClinicoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;

		case 2:

		case 3:

		case 6:

		case 7:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("input");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("casoClinicoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("casoClinicoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;



		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}





function tableGrupoEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 2:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("input");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("grupoValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("grupoValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;

	}

}



function tableImagenEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 2: // Tipo de la imagen



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");





			var option = document.createElement("option");

			option.value = 1;

			option.innerHTML = "Aparecerá en el formulario";

			if (txt.test(option.innerHTML)) {

				option.setAttribute("selected", "selected");

			}

			input.appendChild(option);





			var option2 = document.createElement("option");

			option2.value = 2;

			option2.innerHTML = "Aparecerá en el reporte";

			if (txt.test(option2.innerHTML)) {

				option2.setAttribute("selected", "selected");

			}

			input.appendChild(option2);





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("imagenValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("imagenValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;



		case 3:

		case 4:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("input");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("imagenValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("imagenValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;



		case 5: // Estado



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("imagenValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("imagenValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}





function tableRetoPATEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showProgramPAT";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);

					if (code == 0) {

						errorHandler(response.textContent);

					} else {

						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

						if (returnValues_1 != "") {

							for (var x = 0; x < returnValues_1.length; x++) {

								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];

								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}

								input.appendChild(option);

							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 2:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showLotePAT";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);

					if (code == 0) {

						errorHandler(response.textContent);

					} else {

						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

						if (returnValues_1 != "") {

							for (var x = 0; x < returnValues_1.length; x++) {

								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];

								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}

								input.appendChild(option);

							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;



		case 3:

			var txt = new RegExp(val.innerHTML, "g");

			var input = document.createElement("input");

			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});

			td.innerHTML = "";

			td.appendChild(input);

			input.focus();

			break;



		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("retoPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}

			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function tableIntentosPATEditor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 6:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("intentosPATValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("intentosPATValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function tableAsignarReto(val) {

	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 3:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showProgram";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 5:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;



	}

}



function table4Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:

		case 2:

		case 4:

		case 5:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("programValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("programValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 3:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "number");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("programValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("programValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 6:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showProgramTypes";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("programValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("programValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table5Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showProgram";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("analitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("analitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 2:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showMagnitud";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("analitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("analitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();

	}

}



function table6Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:

		case 3:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 2:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showProgram";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 4:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "date");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 6:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showLot&filter=1&filterid=estado_lote";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

						var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

						var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x] + " - " + returnValues_3[x] + " nivel " + returnValues_5[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("sampleValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table7Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1: // Codigo



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("analyzerValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("analyzerValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 2: // Nombre de analizador



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("analyzerValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("analyzerValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}



}



function tableMetodologiaEditor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1: // Codigo



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("metodologiaValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("metodologiaValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 2: // Nombre de metodologia



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("metodologiaValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("metodologiaValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function tableMagnitudEditor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1: // Codigo



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("magnitudValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("magnitudValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 2: // Nombre del mensurando



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("magnitudValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("magnitudValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function tableUnidadEditor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1: // Codigo



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("unidadValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("unidadValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 2: // Nombre de unidad				

			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("unidadValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("unidadValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table8Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:

			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAnalyzer";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("methodValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("methodValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 2:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showMetodologia";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("methodValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("methodValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table9Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("reactiveValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("reactiveValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;



		case 2:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("reactiveValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("reactiveValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table10Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

			var values = "header=showAnalyzer";

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);

					if (code == 0) {

						errorHandler(response.textContent);

					} else {

						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

						if (returnValues_1 != "") {

							for (var x = 0; x < returnValues_1.length; x++) {

								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];

								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}

								input.appendChild(option);

							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("unitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("unitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 2:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

			var values = "header=showUnidad";

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);

					if (code == 0) {

						errorHandler(response.textContent);

					} else {

						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

						if (returnValues_1 != "") {

							for (var x = 0; x < returnValues_1.length; x++) {

								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];

								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}

								input.appendChild(option);

							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("unitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("unitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table11Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:

		case 2:

		case 3:

		case 4:

		case 6:

		case 7:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("labValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("labValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 5:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showCity";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

						var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_3[x] + " - " + returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("labValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("labValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table12Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("countryValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("countryValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});

			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table13Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showCountry";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("cityValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("cityValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 2:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("cityValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("cityValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}





function table14Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 3:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showProgram";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 5:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabProgramValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;



	}

}



function table15Editor(val) { // Edicion de configuracion de mensurando de laboratorio



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 2:

			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllMagnitudes&filterid=analitolaboratorio&filter=" + td.parentNode.getAttribute("data-id");



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			}).always(function (sdsd) {

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 3:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllAnalyzers";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllVitrosGen&filterid=analitolaboratorio&filter=" + td.parentNode.getAttribute("data-id");



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt == option.innerHTML) {

									option.setAttribute("selected", "selected");

								}

								input.appendChild(option);



							}

						}

					}

				}

			}).always(function (sdfsefd) {

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 5:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllMethods&filterid=analitolaboratorio&filter=" + td.parentNode.getAttribute("data-id");



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 6:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllReactives";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 7:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllUnits&filterid=analitolaboratorio&filter=" + td.parentNode.getAttribute("data-id");



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 8:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllMaterials";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 9:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table16Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 2:



			var txt = val.innerHTML;



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = "";

			input.dataset.id = id;

			input.setAttribute("type", "password");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 3:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 0;

			ids[1] = 100;

			ids[2] = 102;

			ids[3] = 103;

			ids[4] = 125;

			ids[5] = 126;

			names[0] = "Administrador total";

			names[1] = "Coordinador QAP";

			names[2] = "Generación de informes";

			names[3] = "Usuario de laboratorio";

			names[4] = "Patólogo";

			names[5] = "Patólogo coordinador";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 5:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 6:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 7:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("userValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table19Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("disValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("disValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table20Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 3:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllAnalyzers";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllMethods";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 5:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllReactives";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 6:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllUnits";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedProgramAnalitValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table21Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAssignedProgramRound&filter=null&filterid=no_id";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

						var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_5[x] + " | " + returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedLabRoundValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});



			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedLabRoundValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table25Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);

	id_configlab = td.parentNode.getAttribute("data-idconfiguracion");



	switch (tdId) {

		case 2:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("analitRevalorationEditor", tdId, input, id_configlab + "|" + $("#form25input1").val() + "|" + $("#form25input2").val() + "|" + $("#form25input3").val() + "|" + $("#form25input4").val(), "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("analitRevalorationEditor", tdId, input, id_configlab + "|" + $("#form25input1").val() + "|" + $("#form25input2").val() + "|" + $("#form25input3").val() + "|" + $("#form25input4").val(), "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table26Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&"), "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllMethods";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("referenceValueValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("referenceValueValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

		case 5:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).keyup(function () { var tempValue = this.value + ''; this.value = tempValue.replace(",", ".") });

			$(input).numericInput({ allowFloat: true, allowNegative: true });



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("referenceValueValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("referenceValueValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 6:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&"), "g");

			input.setAttribute("class", "form-control unselectedInput");

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			var values = "header=showAllUnits";



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

						var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");



						if (returnValues_1 != "") {



							for (var x = 0; x < returnValues_1.length; x++) {



								var option = document.createElement("option");

								option.value = returnValues_1[x];

								option.innerHTML = returnValues_2[x];



								if (txt.test(option.innerHTML)) {

									option.setAttribute("selected", "selected");

								}



								input.appendChild(option);



							}

						}

					}

				}

			});



			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("referenceValueValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("referenceValueValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";



			td.appendChild(input);



			input.focus();



			break;

	}

}



function table27Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 3:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("textarea");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("jctlmMethodValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("jctlmMethodValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("jctlmMethodValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("jctlmMethodValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table28Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 3:



			var txt = new RegExp(val.innerHTML.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&"), "g");



			var input = document.createElement("textarea");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML

			input.dataset.id = id;



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("jctlmMaterialValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("jctlmMaterialValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

		case 4:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&"), "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 0;

			names[0] = "SI";

			names[1] = "NO";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("jctlmMaterialValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("jctlmMaterialValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table29Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 1:



			var txt = new RegExp(val.innerHTML, "g");



			var input = document.createElement("input");



			var id = td.parentNode.getAttribute("data-id");



			input.setAttribute("class", "form-control unselectedInput");

			input.value = val.innerHTML;

			input.dataset.id = id;

			input.setAttribute("type", "text");



			input.dataset.edited = 0;



			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("materialValueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("materialValueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function tableAsignarRetoEditor(val) {

	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {

		case 7:



			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML, "g");



			input.setAttribute("class", "form-control unselectedInput");

			var ids = new Array();

			var names = new Array();



			ids[0] = 1;

			ids[1] = 2;

			ids[2] = 3;

			ids[3] = 4;

			names[0] = "Primer envío";

			names[1] = "Segundo envío";

			names[2] = "Tercer envío";

			names[3] = "Cuarto envío";



			if (ids != "") {



				for (var x = 0; x < ids.length; x++) {



					var option = document.createElement("option");

					option.value = ids[x];

					option.innerHTML = names[x];



					if (txt.test(option.innerHTML)) {

						option.setAttribute("selected", "selected");

					}



					input.appendChild(option);

				}

			}





			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;

			$(input).bind("blur", function () {

				setTimeout(function () {

					dataChangeHandler("assignedRetoLabvalueEditor", tdId, input, "NULL", "NULL");

				}, 2);

			});

			$(input).keyup(function (event) {



				if (event.keyCode == 13) {

					setTimeout(function () {

						dataChangeHandler("assignedRetoLabvalueEditor", tdId, input, "NULL", "NULL");

					}, 2);

				} else if (event.keyCode == 27) {

					$(input).off("blur");

					$(input).remove();

					td.innerHTML = backupvalue;

				}



			});



			td.innerHTML = "";

			td.appendChild(input);

			input.focus();



			break;

	}

}



function table33Editor(val) {



	var td = val;

	var backupvalue = val.innerHTML;



	tdId = parseInt(td.getAttribute("data-id"), 10);



	switch (tdId) {
		case 2:
			var txt = new RegExp(val.innerHTML, "g");
			var input = document.createElement("input");
			var id = td.parentNode.getAttribute("data-id");

			input.setAttribute("class", "form-control unselectedInput");
			input.value = val.innerHTML;
			input.dataset.id = id;
			input.setAttribute("type", "text");
			input.dataset.edited = 0;

			$(input).bind("blur", function () {
				setTimeout(function () {
					dataChangeHandler("analitCualitativeTypeOfResultValueEditor", tdId, input, "NULL", "NULL");
				}, 2);
			});

			$(input).keyup(function (event) {
				if (event.keyCode == 13) {
					setTimeout(function () {
						dataChangeHandler("analitCualitativeTypeOfResultValueEditor", tdId, input, "NULL", "NULL");
					}, 2);
				} else if (event.keyCode == 27) {
					$(input).off("blur");
					$(input).remove();
					td.innerHTML = backupvalue;
				}
			});

			td.innerHTML = "";
			td.appendChild(input);
			input.focus();
			break;

		case 3:
			var txt = new RegExp(val.innerHTML, "g");
			var input = document.createElement("input");
			var id = td.parentNode.getAttribute("data-id");

			input.setAttribute("class", "form-control unselectedInput");
			input.value = val.innerHTML;
			input.dataset.id = id;
			input.setAttribute("type", "number"); // solo permite números
			input.dataset.edited = 0;

			$(input).bind("blur", function () {
				setTimeout(function () {
					dataChangeHandler("analitCualitativeTypeOfResultValueEditor", tdId, input, input.value, "NULL");
				}, 2);
			});

			$(input).keyup(function (event) {
				if (event.keyCode == 13) {
					setTimeout(function () {
						dataChangeHandler("analitCualitativeTypeOfResultValueEditor", tdId, input, input.value, "NULL");
					}, 2);
				} else if (event.keyCode == 27) {
					$(input).off("blur");
					$(input).remove();
					td.innerHTML = backupvalue;
				}
			});

			td.innerHTML = "";
			td.appendChild(input);
			input.focus();
			break;
	}

}



function functionHandler(val, val2, val3, val4, val5, val6) {

	var id = val;



	switch (id) {

		case "viewDocument":



			switch (val3) {

				case "view":

					window.open('visor_documento.php?id=' + val2 + "&action=" + val3, 'PDF viewer', 'height=640,width=768');

					break;

				case "download":

					window.location.href = 'visor_documento.php?id=' + val2 + "&action=" + val3;

					break;

				case "downloadMultiple":



					idArray = val2.split("|");

					counter = 0;



					var intervalCicle = setInterval(function () {



						if (counter < idArray.length) {

							window.open('visor_documento.php?id=' + idArray[counter] + "&action=" + val3, '_blank');

							counter++;

						} else {

							clearInterval(intervalCicle);

						}



					}, 1);



					break;

				default:

					//

					break;

			}





			break;



		case 'checkAll':

			tbody = val2.parentNode.parentNode.parentNode.nextSibling.nextSibling;



			if (val2.checked == false) {



				var trArray = tbody.getElementsByTagName("tr");



				for (var x = 0; x < trArray.length; x++) {

					var input = trArray[x].getElementsByTagName("input")[0];



					input.checked = true;



				}



			} else {



				var trArray = tbody.getElementsByTagName("tr");



				for (var x = 0; x < trArray.length; x++) {

					var input = trArray[x].getElementsByTagName("input")[0];



					input.checked = false;



				}

			}

			break;



		case "tableSearch":



			var search = $.trim($(val2).val()).replace(/ +/g, ' ').toLowerCase().split("|");

			var rows = $(val2).parent().parent().parent().next().find("tr").get();



			for (var x = 0; x < search.length; x++) {



				if (search[x].split(":").length > 1) {



					var searchColumn = (parseInt(search[x].split(":")[0], 10) - 1);

					var searchValue = search[x].split(":")[1].replace(/\s+/g, ' ').toLowerCase();



					for (var y = 0; y < rows.length; y++) {

						var tdText = $(rows[y]).find("td")[searchColumn].innerHTML.replace(/\s+/g, ' ').toLowerCase();



						if (~tdText.indexOf(searchValue)) {

							$(rows[y]).find("td")[searchColumn].dataset.found = 1;

						} else {

							$(rows[y]).find("td")[searchColumn].removeAttribute("data-found");

						}



					}



				} else {



					var $rows = $(val2).parent().parent().parent().next().find("tr");

					var val = $.trim($(val2).val()).replace(/ +/g, ' ').toLowerCase();

					$rows.find("td").removeAttr("data-found");

					$rows.show().filter(function () {

						var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();

						return !~text.indexOf(val);

					}).hide();



				}

			}



			if ($(rows).find("td[data-found]").get().length > 0) {

				for (x = 0; x < rows.length; x++) {

					if ($(rows[x]).find("td[data-found]").get().length == search.length) {

						$(rows[x]).show();

					} else {

						$(rows[x]).hide();

					}

				}

			}



			break;

		case "tableEditor":



			var td = val2;

			var fieldType = val3.toLowerCase();

			var fieldName = val4.toLowerCase();



			switch (fieldType) {

				case "input":



					var txt = td.getAttribute("data-text");

					var input = document.createElement("input");

					var id = $(td).parents("tr").attr("data-id");

					var tdId = td.getAttribute("data-id");



					input.setAttribute("class", "form-control unselectedInput");



					if (txt == "**********") {

						input.value = "";

					} else {

						input.value = txt;

					}



					input.dataset.id = id;

					input.setAttribute("type", fieldName);

					input.dataset.edited = 0;



					$(input).bind("blur", function () {

						setTimeout(function () {

							dataChangeHandler(val5, tdId, input, "NULL", "NULL");

						}, 2);

					});



					$(input).keyup(function (event) {



						if (event.keyCode == 13) {

							setTimeout(function () {

								dataChangeHandler(val5, tdId, input, "NULL", "NULL");

							}, 1);

						} else if (event.keyCode == 27) {



							$(input).off("blur");

							$(input).remove();

							td.innerHTML = txt;

						}



					});



					td.innerHTML = "";

					td.appendChild(input);

					input.focus();



					break;

				case "select":



					var select = document.createElement("select");

					var txt = $(val2).attr("data-text");

					var id = $(td).parents("tr").attr("data-id");

					var tdId = td.getAttribute("data-id");

					var uniqId = functionHandler("uniqId");



					select.setAttribute("class", "form-control unselectedInput");

					select.dataset.id = id;

					select.dataset.edited = 0;

					select.id = uniqId;



					$(select).bind("blur", function () {

						setTimeout(function () {

							dataChangeHandler(val5, tdId, select, "NULL", "NULL");

						}, 2);

					});



					$(select).keyup(function (event) {



						if (event.keyCode == 13) {

							setTimeout(function () {

								dataChangeHandler(val5, tdId, select, "NULL", "NULL");

							}, 1);

						} else if (event.keyCode == 27) {

							$(select).off("blur");

							$(select).remove();

							td.innerHTML = txt;

						}

					});



					td.innerHTML = "";

					td.appendChild(select);

					select.focus();



					functionHandler('selectFiller', uniqId, val6, " | ", "false");



					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

					var timer_1 = setInterval(function () {

						if ($("#" + uniqId).attr("data-active") == "true") {

							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							clearInterval(timer_1);



							var optionArray = $("#" + uniqId).find("option").get();



							var regExpTxt = new RegExp(txt, "g");



							for (x = 0; x < optionArray.length; x++) {

								if (regExpTxt.test(optionArray[x].innerHTML)) {

									optionArray[x].setAttribute("selected", "selected");

								}

							}

						}

					}, 100);

					break;

			}



			break;

		case "mimeChecker":

			switch (val2) {

				case 'image/png':

				case 'image/gif':

				case 'image/jpeg':

				case 'image/pjpeg':

				case 'text/plain':

				case 'text/html':

				case 'application/x-zip-compressed':

				case 'application/pdf':

				case 'application/msword':

				case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':

				case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template':

				case 'application/vnd.ms-word.document.macroEnabled.12':

				case 'application/vnd.ms-word.template.macroEnabled.12':

				case 'application/vnd.ms-excel':

				case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':

				case 'application/vnd.openxmlformats-officedocument.spreadsheetml.template':

				case 'application/vnd.ms-excel.sheet.macroEnabled.12':

				case 'application/vnd.ms-excel.template.macroEnabled.12':

				case 'application/vnd.ms-excel.addin.macroEnabled.12':

				case 'application/vnd.ms-excel.sheet.binary.macroEnabled.12':

				case 'application/vnd.ms-powerpoint':

				case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':

				case 'application/vnd.openxmlformats-officedocument.presentationml.template':

				case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow':

				case 'application/vnd.ms-powerpoint.addin.macroEnabled.12':

				case 'application/vnd.ms-powerpoint.presentation.macroEnabled.12':

				case 'application/vnd.ms-powerpoint.template.macroEnabled.12':

				case 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12':

				case 'video/mp4':

					return false;

					break;

				default:

					return true;

					break;

			}

			break;

		case "fieldReset":



			var field = $("#" + val2).get(0);



			switch (field.tagName) {

				case "INPUT":

				case "TEXTAREA":

					field.value = "";

					break;

				case "SELECT":

					$(field).children().removeAttr("selected");

					$(field).find("option:nth-child(1)").attr("selected", "selected");

					break;

			}



			break;

		case "iconChoser":

			switch (val2.toLowerCase()) {

				case 'doc':

				case 'dot':

				case 'docx':

				case 'docm':

				case 'dotx':

				case 'dotm':

				case 'docb':

					var icon = "css/word_icon.png";

					break;

				case 'xls':

				case 'xlt':

				case 'xlm':

				case 'xlsx':

				case 'xlsm':

				case 'xltx':

				case 'xltm':

				case 'xlsb':

				case 'xla':

				case 'xlam':

				case 'xll':

				case 'xlw':

					var icon = "css/excel_icon.png";

					break;

				case 'ppt':

				case 'pptx':

				case 'pptm':

				case 'potx':

				case 'potm':

				case 'ppam':

				case 'ppsx':

				case 'ppsm':

				case 'sldx':

				case 'sldm':

					var icon = "css/pp_icon.png";

					break;

				case 'pdf':

					var icon = "css/pdf_icon.png";

					break;

				default:

					var icon = "css/default_icon.png";

					break;

			}



			return icon;



			break;

		case "formatSizeUnits":



			var bytes = val2;



			if (bytes >= 1073741824) { bytes = (bytes / 1073741824).toFixed(2) + ' GB'; }

			else if (bytes >= 1048576) { bytes = (bytes / 1048576).toFixed(2) + ' MB'; }

			else if (bytes >= 1024) { bytes = (bytes / 1024).toFixed(2) + ' KB'; }

			else if (bytes > 1) { bytes = bytes + ' bytes'; }

			else if (bytes == 1) { bytes = bytes + ' byte'; }

			else { bytes = '0 byte'; }

			return bytes;



			break;

		case "showTempFiles":



			var files = val2.files;

			var tbody = val3;

			tbody.innerHTML = "";



			for (var x = 0; x < files.length; x++) {



				var tr = document.createElement("tr");



				var td0 = document.createElement("td");

				var td1 = document.createElement("td");

				var td2 = document.createElement("td");



				td1.setAttribute("style", "font-weight:bold;");

				td2.setAttribute("style", "text-align:center;");



				td0.innerHTML = (x + 1);

				td1.innerHTML = "<img src='" + functionHandler("iconChoser", files[x].name.split(".")[1]) + "' alt='document icon' width='28' height='28'></img><span style='margin-left: 1%;'>" + files[x].name.split(".")[0] + "." + files[x].name.split(".")[1] + "</span>";

				td2.innerHTML = functionHandler("formatSizeUnits", files[x].size);



				tr.appendChild(td0);

				tr.appendChild(td1);

				tr.appendChild(td2);



				tr.dataset.item = (x + 1);



				tbody.appendChild(tr);



			}



			break;

		case "matchPassword":

			var v1 = val2.val();

			var v2 = val3.val();



			if (v1 == "" || v2 == "") {

				var match = false;

				$(val4).attr("class", " form-group");

				$(val5).attr("class", " form-group");



			} else if (v1 == v2) {

				var match = true;

				$(val4).attr("class", " form-group has-success");

				$(val5).attr("class", " form-group has-success");



			} else {

				var match = false;

				$(val4).attr("class", " form-group has-error");

				$(val5).attr("class", " form-group has-error");



			}



			return match;

			break;

		case "inputChecker":

			var sum = 0;

			var inputTextArray = val2.getElementsByTagName("input");

			var select = val2.getElementsByTagName("select");



			for (var x = 0; x < inputTextArray.length; x++) {



				switch (inputTextArray[x].type) {

					case "text":

						if (inputTextArray[x].value == "") {

							sum++;

						}

						break;

					case "password":

						if (inputTextArray[x].value == "") {

							sum++;

						}

						break;

					case "date":

						if (inputTextArray[x].value == "") {

							sum++;

						}

						break;

					case "number":

						if (inputTextArray[x].value == "") {

							sum++;

						}

						break;

					case "time":

						if (inputTextArray[x].value == "") {

							sum++;

						}

						break;

				}



			}



			for (var x = 0; x < select.length; x++) {

				if (select[x].value == "") {

					sum++;

				}

			}



			if (sum > 0) {

				statusBox("warning", "NULL", "Por favor complete todos los campos", "add", "NULL");

				var answer = false;

			} else {

				var answer = true;

			}



			return answer;

			break;

		case 'panelChooser':



			$(val2).parent().find("li").removeClass("active-tab");



			var id = val2.getAttribute("data-id");



			$("[data-id=" + val3 + "]").attr("hidden", "hidden");

			$("#" + id).removeAttr("hidden");



			$(val2).addClass("active-tab");



			break;

		case 'badgeCounter':

			var a = val2.value.split("|").length;

			var b = val2;

			var c = next(b);

			c.value = a;

			d = next(c);

			d.innerHTML = a;



			function next(elem) {

				do {

					elem = elem.nextSibling;

				} while (elem && elem.nodeType !== 1);



				return elem;

			}

			break;

		case 'windowHandler':



			$("#" + val2).toggle();



			break;

		case 'formReset':

			$('[data-form-reset=true]').val("");

			break;

		case 'selectFiller':

			$("input[type=submit]").attr("disabled", "disabled");

			$("input[type=submit]").addClass("disabled");



			var select = $("#" + val2).get(0);

			select.innerHTML = "";

			select.value = "";

			select.removeAttribute("data-active");

			select.dataset.active = "false";



			var values = "header=" + val3;

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');



			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url: "php/panelcontrol_calls_handler.php",

				type: "POST",

				data: values,

				dataType: "xml",

				success: function (xml) {

					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');



					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"), 10);



					if (code == 0) {

						errorHandler(response.textContent);

					} else {



						var idArray = new Array();

						var contentArray = new Array();



						for (var x = 0; x < response.childNodes.length; x++) {



							var tempArray = response.childNodes[x].textContent.split("|");



							if (val5.toLowerCase() == 'false') {

								var omit = parseInt(response.childNodes[x].getAttribute("selectomit"), 10);

							} else {

								var omit = 'NULL';

							}



							var content = response.childNodes[x].getAttribute("content");



							for (var y = 0; y < tempArray.length; y++) {

								if (isNaN(omit) && content == "id") {

									idArray[y] = tempArray[y];

								} else {

									if (isNaN(omit)) {

										if (typeof (contentArray[y]) == 'undefined') {

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



						if (val2 == "showAssignedLabReto") {

							select.change();

						}



						if (val3 == "showRetoPAT" && val2 == "formRevalPatinput1") {

							$("#formRevalPatinput1").change();

						}



						if (val3 == "showProgramPAT") {

							$("#formRetoPATinput1").change();

						}



						if (val2 == "formCasoClinicoPATinput1") {

							$("#formCasoClinicoPATinput1").change();

						}





						if (val2 == "formReferenciaPATinput1") {

							$("#formReferenciaPATinput1").change();

						}



						if (val2 == "formReferenciaPATinput2") {

							$("#formReferenciaPATinput2").change();

						}



						if (val2 == "formImagenPATinput1") {

							$("#formImagenPATinput1").change();

						}



						if (val2 == "formImagenPATinput2") {

							$("#formImagenPATinput2").change();

						}





						if (val2 == "formGrupoinput1") {

							$("#formGrupoinput1").change();

						}



						if (val2 == "formPreguntainput1") {

							$("#formPreguntainput1").change();

						}



						if (val2 == "formDistractorinput1") {

							$("#formDistractorinput1").change();

						}



						if (val2 == "formPreguntainput2") {

							$("#formPreguntainput2").change();

						}



						if (val2 == "formDistractorinput2") {

							$("#formDistractorinput2").change();

						}



						if (val2 == "formDistractorinput3") {

							$("#formDistractorinput3").change();

						}



						if (val2 == "formDistractorinput4") {

							$("#formDistractorinput4").change();

						}



						if (val2 == "formGrupoinput2") {

							$("#formGrupoinput2").change();

						}



						if (val2 == "formPreguntainput3") {

							$("#formPreguntainput3").change();

						}

					}

				}

			}).always(function (asdasd) {

			});



			break;

		case 'cvCalculator':

			var item1 = val2;

			var item2 = val3;



			if ((item1 == 0 || item1 == '') || (item2 == 0 || item2 == '')) {

				result = 0;

			} else {

				var result = math.round(((item2 / item1) * 100), 2);



				if (isNaN(result) || !isFinite(result)) {

					result = 0;

				}

			}



			return result;



			break;

		case "hideColumn":

			var button = $("#" + val2).get(0);

			var table = $("#" + val3).get(0);

			if (typeof (val4) == "undefined" || val4.toLowerCase() == "null") {

				var status = parseInt(button.getAttribute("data-status"), 10);

			} else {

				var status = parseInt(val4, 10);

			}



			var lvl = parseInt(button.getAttribute("data-btn-lvl"), 10);



			if (status == 1) {

				$(table).find("thead").find("tr").find("th[data-lvl=" + lvl + "]").hide();

				$(table).find("tbody").find("tr").find("td[data-lvl=" + lvl + "]").hide();

			} else {

				$(table).find("thead").find("tr").find("th[data-lvl=" + lvl + "]").show();

				$(table).find("tbody").find("tr").find("td[data-lvl=" + lvl + "]").show();

			}



			break;

		case "checkboxCheckAll":



			tbody = $("#" + val3).find("tbody").get(0);



			if ($("#" + val2).get(0).checked == false) {



				var trArray = tbody.getElementsByTagName("tr");



				for (var x = 0; x < trArray.length; x++) {

					var input = $(trArray[x]).find("input[type=checkbox]").get(0);



					input.checked = true;



				}



			} else {



				var trArray = tbody.getElementsByTagName("tr");



				for (var x = 0; x < trArray.length; x++) {

					var input = $(trArray[x]).find("input[type=checkbox]").get(0);



					input.checked = false;



				}

			}



			break;

		case "uniqId":

			if (typeof val2 === 'undefined') {

				val2 = "";

			}



			var retId;

			var formatSeed = function (seed, reqWidth) {

				seed = parseInt(seed, 10).toString(16); // to hex str

				if (reqWidth < seed.length) { // so long we split

					return seed.slice(seed.length - reqWidth);

				}

				if (reqWidth > seed.length) { // so short we pad

					return Array(1 + (reqWidth - seed.length)).join('0') + seed;

				}

				return seed;

			};



			// BEGIN REDUNDANT

			if (!this.php_js) {

				this.php_js = {};

			}

			// END REDUNDANT

			if (!this.php_js.uniqidSeed) { // init seed with big random int

				this.php_js.uniqidSeed = Math.floor(Math.random() * 0x75bcd15);

			}

			this.php_js.uniqidSeed++;



			retId = val2; // start with prefix, add current milliseconds hex string

			retId += formatSeed(parseInt(new Date().getTime() / 1000, 10), 8);

			retId += formatSeed(this.php_js.uniqidSeed, 5); // add seed hex string

			if (val3 == "true") {

				// for more entropy we add a float lower to 10

				retId += (Math.random() * 10).toFixed(8).toString();

			}



			return retId;

			break;

		default:

			alert('JS functionHandler error: id "' + id + '" not found');

			break;

	}

}



function errorHandler(val) {

	alert(val);

}