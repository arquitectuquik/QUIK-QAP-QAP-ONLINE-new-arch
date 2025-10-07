function initialize() {
	$("#form8").bind("submit", function (event) {
		dataChangeHandler("referenceValueRegistry", "NULL", $("#form8").get(0), "NULL", "NULL");
		event.preventDefault();
	});

	$("#boton-resumen-comentarios").bind("mouseup", function (event) {
		functionHandler('windowHandler', 'open', 'windowComentarios');
		event.preventDefault();
	});

	$("#form1input1").bind("change", function (event) {
		functionHandler("selectFiller", "form1input2", "showAssignedLabProgram&filter=" + this.value + "&filterid=id_laboratorio", " | ");

		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
		var timer_1 = setInterval(function () {
			if ($("#form1input2").attr("data-active") == "true") {
				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
				$("#form1input2").change();
				clearInterval(timer_1);
			}
		}, 100);
	});
	$("#fechas_corte_personalizadas").bind("change", function (event) {
		$("#fechas_corte").empty();
		if ($(this).prop('checked') == true) {
			$("#fechas_corte").empty();
			$("#form1input4").children().each(function () {
				appendFechaCorteMuestra($(this).text(), $(this).val());
			});

			var idLaboratorio = $("#form1input1").val();
			var idPrograma = $("#form1input2").val();
			var idRonda = $("#form1input3").val();

			// Llama a la función solo si los valores están definidos
			if (idLaboratorio && idPrograma && idRonda) {
				obtenerFechasDeDB(idLaboratorio, idPrograma, idRonda);
			}
		}
	});

	$("#form1input2").bind("change", function (event) {
		$("#form21input20").val("");
		callsHandler("showAssignedProgramType", this.value, "id_programa", "form21input20", "NULL");
		functionHandler("selectFiller", "form1input3", "showAssignedLabRound&filter=" + this.value + "|" + $("#form1input1").val() + "&filterid=id_laboratorio", " | ");
		functionHandler("selectFiller", "form8input6", "showAnalit&filter=" + this.value + "&filterid=id_programa", " | ", "false");

		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
		var timer_2 = setInterval(function () {
			if ($("#form1input3").attr("data-active") == "true") {
				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
				$("#form1input3").change();
				clearInterval(timer_2);
			}
		}, 100);
	});
	$("#form1input3").bind("change", function (event) {
		functionHandler("selectFiller", "form1input4", "showAssignedRoundSample&filter=" + this.value + "&filterid=id_ronda", " | ");
	});
	$("#form1input10").bind("mouseup", function (event) {

		var checkbox1 = 0;
		var checkbox2 = 0;
		var checkbox3 = 0;
		var checkbox4 = 0;
		var checkbox5 = 0;

		if ($("#form1input7").get(0).checked) {
			checkbox1 = 1;
		}
		if ($("#form1input8").get(0).checked) {
			checkbox2 = 1;
		}
		if ($("#form1input9").get(0).checked) {
			checkbox3 = 1;
		}
		if ($("#form1input11").get(0).checked) {
			checkbox4 = 1;
		}
		if ($("#form1input13").get(0).checked) {
			checkbox5 = 1;
		}

		var fechas_corte = '';
		if ($(".fecha_corte_muestra").length > 0) {
			fechas_corte = {};
			$(".fecha_corte_muestra").each(function (fechaCorteItem) {
				fechas_corte[$(this).data("muestraid")] = $(this).val();
			});
			fechas_corte = btoa(JSON.stringify(fechas_corte));
		}

		callsHandler("showResults", $("#form1input2").val() + "|" + $("#form1input1").val() + "|" + $("#form1input4").val() + "|" + $('#form1').find("[type=radio]:checked").val() + "|" + $("#form1input3").val() + "|" + checkbox1 + "|" + checkbox2 + "|" + checkbox3 + "|" + checkbox4 + "|" + checkbox5 + "|" + $("#form1input15").val() + "|" + fechas_corte, "id_array");
	});
	$("#form1input10general").bind("mouseup", function (event) {

		var checkbox1 = 0;
		var checkbox2 = 0;
		var checkbox3 = 0;
		var checkbox4 = 0;
		var checkbox5 = 0;

		if ($("#form1input7").get(0).checked) {
			checkbox1 = 1;
		}
		if ($("#form1input8").get(0).checked) {
			checkbox2 = 1;
		}
		if ($("#form1input9").get(0).checked) {
			checkbox3 = 1;
		}
		if ($("#form1input11").get(0).checked) {
			checkbox4 = 1;
		}
		if ($("#form1input13").get(0).checked) {
			checkbox5 = 1;
		}

		var fechas_corte = '';
		if ($(".fecha_corte_muestra").length > 0) {
			fechas_corte = {};
			$(".fecha_corte_muestra").each(function (fechaCorteItem) {
				fechas_corte[$(this).data("muestraid")] = $(this).val();
			});
			fechas_corte = btoa(JSON.stringify(fechas_corte));
		}

		callsHandler("showResultsGeneral", $("#form1input2").val() + "|" + $("#form1input1").val() + "|" + $("#form1input4").val() + "|" + $('#form1').find("[type=radio]:checked").val() + "|" + $("#form1input3").val() + "|" + checkbox1 + "|" + checkbox2 + "|" + checkbox3 + "|" + checkbox4 + "|" + checkbox5 + "|" + $("#form1input15").val() + "|" + fechas_corte, "id_array");
	});

	$("#form1input_QAPFOR07").bind("mouseup", function (event) {
		callsHandler("showQAP_FOR_07", $("#form1input2").val() + "|" + $("#form1input1").val() + "|" + $("#form1input4").val() + "|" + $("#form1input3").val() + "|");
	});

	$("#form1input12").bind("mouseup", function (event) {
		dataChangeHandler("deleteTempFiles", "NULL", "NULL", "NULL", "NULL");
		event.preventDefault();
	});
	$("#form23input3").bind("mouseup", function (event) {
		dataChangeHandler("saveAnalitMedia", "NULL", $("#table23").get(0), "NULL", "NULL");
		event.preventDefault();
	});

	$("#form1input1").change();
	$("#w1p").draggable();
	$("#w2p").draggable();
	setupVentanaResultadosConsenso();

	$("#form1input14").bind("mouseup", function (event) {
		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
		var timer_3 = setInterval(function () {
			if (parseInt($("#form21input20").val(), 10) != "") {
				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				callsHandler("showAssignedAnalitMedia", $("#form1input4").val() + "|" + $("#form1input2").val() + "|" + $("#form1input1").val(), "id_array&programtypeid=" + $("#form21input20").val(), "NULL", "NULL");

				clearInterval(timer_3);
			}
		}, 100);
	});
	$("#form1input16").bind("mouseup", function (event) {
		statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
		var timer_7 = setInterval(function () {
			if (parseInt($("#form1input4").val(), 10) != "") {
				statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

				callsHandler('showReferenceValue', $("#form1input2").val() + "|" + $("#form1input4").val() + "|" + $("#form1input1").val(), "id_array");

				clearInterval(timer_7);
			}
		}, 100);
	});
	functionHandler('selectFiller', 'form8input3', 'showAnalyzer', " | ", "false");
	statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
	var timer_8 = setInterval(function () {
		if ($("#form8input3").attr("data-active") == "true") {
			statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
			$("#form8input3").change();
			clearInterval(timer_8);
		}
	}, 100);
	$("#form8input3").bind("change", function (event) {
		functionHandler("selectFiller", "form8input4", "showMethod&filter=" + this.value + "&filterid=id_analizador", " | ", "false");
		functionHandler("selectFiller", "form8input7", "showUnit&filter=" + this.value + "&filterid=id_analizador", " | ", "false");
	});

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
			case "showResults":

				var tbody = $("#table1").find("tbody").get(0);
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
				var returnValues_14 = response.getElementsByTagName("returnvalues14")[0].textContent.split("|");
				var returnValues_15 = response.getElementsByTagName("returnvalues15")[0].textContent.split("|");

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

						td1.innerHTML = returnValues_2[x];
						td2.innerHTML = returnValues_3[x];
						td3.innerHTML = returnValues_4[x];
						td4.innerHTML = returnValues_5[x];
						td5.innerHTML = returnValues_6[x];
						td6.innerHTML = returnValues_7[x];
						td7.innerHTML = returnValues_8[x];
						td8.innerHTML = returnValues_9[x];
						td9.innerHTML = returnValues_10[x];
						td10.innerHTML = returnValues_11[x];
						td11.innerHTML = returnValues_12[x];
						td12.innerHTML = returnValues_13[x];
						td13.innerHTML = returnValues_14[x];
						td14.innerHTML = returnValues_15[x];

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
						tr.appendChild(td12);
						tr.appendChild(td13);
						tr.appendChild(td14);

						tr.dataset.id = returnValues_1[x];

						tbody.appendChild(tr);
					}
				}

				break;
			case "showResultsGeneral":

				var tbody = $("#table1").find("tbody").get(0);
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
				var returnValues_14 = response.getElementsByTagName("returnvalues14")[0].textContent.split("|");
				var returnValues_15 = response.getElementsByTagName("returnvalues15")[0].textContent.split("|");

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

						td1.innerHTML = returnValues_2[x];
						td2.innerHTML = returnValues_3[x];
						td3.innerHTML = returnValues_4[x];
						td4.innerHTML = returnValues_5[x];
						td5.innerHTML = returnValues_6[x];
						td6.innerHTML = returnValues_7[x];
						td7.innerHTML = returnValues_8[x];
						td8.innerHTML = returnValues_9[x];
						td9.innerHTML = returnValues_10[x];
						td10.innerHTML = returnValues_11[x];
						td11.innerHTML = returnValues_12[x];
						td12.innerHTML = returnValues_13[x];
						td13.innerHTML = returnValues_14[x];
						td14.innerHTML = returnValues_15[x];

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
						tr.appendChild(td12);
						tr.appendChild(td13);
						tr.appendChild(td14);

						tr.dataset.id = returnValues_1[x];

						tbody.appendChild(tr);
					}
				}

				break;

			case "deleteTempFiles":
				var answer = parseInt(response.textContent, 10);

				var boxType = "success";
				var txt = "Se eliminaron " + answer + " archivos";

				statusBox(boxType, 'NULL', txt, 'add', '4000');

				break;
			case "analitMediaAssignation":
				var answer = parseInt(response.textContent, 10);

				if (answer == 0) {
					var boxType = "warning";
					var txt = "Los datos ingresados ya existe en la base de datos";
				} else {
					var boxType = "success";
					var txt = "Los datos se han asignado correctamente";
					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
					var timer_4 = setInterval(function () {
						if (parseInt($("#form21input20").val(), 10) != "") {
							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							callsHandler("showAssignedAnalitMedia", $("#form1input4").val() + "|" + $("#form1input2").val() + "|" + $("#form1input1").val(), "id_array&programtypeid=" + $("#form21input20").val(), "NULL", "NULL");

							clearInterval(timer_4);
						}
					}, 100);
				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;
			case "showAssignedAnalitMedia":

				var tbody = $("#table23").find("tbody").get(0);
				tbody.innerHTML = "";

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");
				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|"); // Nombre de programa
				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|"); // Mensurando
				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|"); // Analizador
				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|"); // Metodología
				var returnValues_6 = response.getElementsByTagName("returnvalues6")[0].textContent.split("|"); // Reactivo
				var returnValues_7 = response.getElementsByTagName("returnvalues7")[0].textContent.split("|"); // Unidad
				var returnValues_9lvl0 = response.getElementsByTagName("returnvalues9lvl0")[0].textContent.split("|"); // Datos Nivel 0 (Cualitativo: desc_resultado_reporte_cualitativo)
				var returnValues_9lvl1 = response.getElementsByTagName("returnvalues9lvl1")[0].textContent.split("|"); // Datos Nivel 1 (P25, ME, P75, DE, CV%, N)
				var returnValues_9lvl2 = response.getElementsByTagName("returnvalues9lvl2")[0].textContent.split("|"); // Datos Nivel 2 (P25, ME, P75, DE, CV%, N)
				var returnValues_9lvl3 = response.getElementsByTagName("returnvalues9lvl3")[0].textContent.split("|"); // Datos Nivel 3 (P25, ME, P75, DE, CV%, N)
				var returnValues_10 = response.getElementsByTagName("returnvalues10")[0].textContent.split("|"); // Consenso
				var returnValues_11 = parseInt(response.getElementsByTagName("returnvalues11")[0].textContent, 10); // Lógica de visibilidad de columnas

				var level0Counter = 0; // Para el nivel cualitativo (incrementa de 1 en 1)
				var level1Counter = 0; // Para los niveles cuantitativos (incrementa de 6 en 6)
				var level2Counter = 0;
				var level3Counter = 0;

				// Esto ayuda a crear los TD e Inputs de forma más organizada para los niveles CUANTITATIVOS
				const quantitativeLevelColumns = [
					{ name: "P25", dataCol: "p25", isReadOnly: false, isCalculated: false },
					{ name: "ME", dataCol: "me", isReadOnly: false, isCalculated: false },
					{ name: "P75", dataCol: "p75", isReadOnly: false, isCalculated: false },
					{ name: "DE", dataCol: "de", isReadOnly: false, isCalculated: false },
					{ name: "CV%", dataCol: "cv", isReadOnly: true, isCalculated: true }, // CV% es calculado y readonly
					{ name: "N", dataCol: "n", isReadOnly: false, isCalculated: false }
				];

				if (returnValues_1 != "") {

					for (var x = 0; x < returnValues_1.length; x++) {

						var tr = document.createElement("tr");
						tr.dataset.id = returnValues_1[x]; // Asigna el ID de la fila

						// Columnas de información estática (no input)
						var td1 = document.createElement("td"); td1.setAttribute('class', 'unselectable center-text'); td1.innerHTML = returnValues_2[x]; tr.appendChild(td1);
						var td2 = document.createElement("td"); td2.setAttribute('class', 'unselectable center-text'); td2.innerHTML = returnValues_3[x]; tr.appendChild(td2);
						var td3 = document.createElement("td"); td3.setAttribute('class', 'unselectable center-text'); td3.innerHTML = returnValues_4[x]; tr.appendChild(td3);
						var td4 = document.createElement("td"); td4.setAttribute('class', 'unselectable center-text'); td4.innerHTML = returnValues_5[x]; tr.appendChild(td4);
						var td5 = document.createElement("td"); td5.setAttribute('class', 'unselectable center-text'); td5.innerHTML = returnValues_6[x]; tr.appendChild(td5);
						var td6 = document.createElement("td"); td6.setAttribute('class', 'unselectable center-text'); td6.innerHTML = returnValues_7[x]; tr.appendChild(td6);
						// Columna "Gen VITROS"
						var tdGenVitros = document.createElement("td"); tdGenVitros.setAttribute('class', 'unselectable center-text'); tdGenVitros.innerHTML = returnValues_10[x]; tr.appendChild(tdGenVitros);


						// Función auxiliar para crear y configurar una celda con input para datos CUANTITATIVOS
						function createInputCell(level, dataColName, value, isReadOnly, isCalculated) {
							var td = document.createElement("td");
							td.setAttribute('class', 'unselectable center-text');
							td.dataset.lvl = level;
							td.dataset.col = dataColName; // Nuevo atributo para identificar la columna (p25, me, p75, de, cv, n)

							var input = document.createElement("input");
							input.setAttribute("type", "text"); // o "number" si solo se permiten números
							input.setAttribute("class", "form-control input-sm");
							input.setAttribute("style", "width: 70px; padding-left: 5px !important;");
							input.value = (value !== undefined && value !== null && value !== '') ? value : 0; // Asigna el valor o 0 si está vacío

							if (isReadOnly) {
								input.setAttribute("readonly", "readonly");
								// Solo para campos calculados (CV%) permitir doble click para editar temporalmente
								if (isCalculated) {
									input.addEventListener("dblclick", function () { $(this).removeAttr("readonly"); });
									input.addEventListener("blur", function () { $(this).attr("readonly", "readonly"); });
									$(input).keypress(function (event) { if (event.keyCode == 13) { $(this).attr("readonly", "readonly"); } else { $(this).parent().parent().get(0).dataset.edited = "true"; } });
								}
							}

							// Eventos de focus/blur para limpiar/rellenar 0
							$(input).bind("focus", function () { if (this.value == '0') { this.value = ""; } });
							$(input).bind("blur", function () { if (this.value == "") { this.value = 0; } });

							// Valida y formatea a número (asumiendo que numericInput es un plugin jQuery)
							$(input).numericInput({ allowFloat: true, allowNegative: true });

							// Eventos de Keyup para marcar como editado y reemplazar comas por puntos
							input.addEventListener("keyup", function () {
								$(this).parent().parent().get(0).dataset.edited = "true";
								var tempValue = this.value + '';
								this.value = tempValue.replace(",", ".");
							});

							td.appendChild(input);
							return td;
						}

						// Construir las celdas para Nivel 1 (CUANTITATIVO)
						quantitativeLevelColumns.forEach((col, idx) => {
							const value = returnValues_9lvl1[level1Counter + idx];
							const cell = createInputCell("1", col.dataCol, value, col.isReadOnly, col.isCalculated);
							// Añadir listeners específicos para ME y DE para calcular CV%
							if (col.dataCol === "me" || col.dataCol === "de") {
								$(cell).find("input").on("keyup", function () {
									const $row = $(this).closest('tr');
									const meValue = parseFloat($row.find('td[data-lvl="1"][data-col="me"] input').val().replace(",", ".")) || 0;
									const deValue = parseFloat($row.find('td[data-lvl="1"][data-col="de"] input').val().replace(",", ".")) || 0;
									const cvInput = $row.find('td[data-lvl="1"][data-col="cv"] input');
									cvInput.val(functionHandler("cvCalculator", deValue, meValue)); // (DE, ME)
									$row.get(0).dataset.edited = "true";
								});
							}
							tr.appendChild(cell);
						});
						level1Counter += 6;


						// Construir las celdas para Nivel 2 (CUANTITATIVO)
						quantitativeLevelColumns.forEach((col, idx) => {
							const value = returnValues_9lvl2[level2Counter + idx];
							const cell = createInputCell("2", col.dataCol, value, col.isReadOnly, col.isCalculated);
							if (col.dataCol === "me" || col.dataCol === "de") {
								$(cell).find("input").on("keyup", function () {
									const $row = $(this).closest('tr');
									const meValue = parseFloat($row.find('td[data-lvl="2"][data-col="me"] input').val().replace(",", ".")) || 0;
									const deValue = parseFloat($row.find('td[data-lvl="2"][data-col="de"] input').val().replace(",", ".")) || 0;
									const cvInput = $row.find('td[data-lvl="2"][data-col="cv"] input');
									cvInput.val(functionHandler("cvCalculator", deValue, meValue));
									$row.get(0).dataset.edited = "true";
								});
							}
							tr.appendChild(cell);
						});
						level2Counter += 6;

						// Construir las celdas para Nivel 3 (CUANTITATIVO)
						quantitativeLevelColumns.forEach((col, idx) => {
							const value = returnValues_9lvl3[level3Counter + idx];
							const cell = createInputCell("3", col.dataCol, value, col.isReadOnly, col.isCalculated);
							if (col.dataCol === "me" || col.dataCol === "de") {
								$(cell).find("input").on("keyup", function () {
									const $row = $(this).closest('tr');
									const meValue = parseFloat($row.find('td[data-lvl="3"][data-col="me"] input').val().replace(",", ".")) || 0;
									const deValue = parseFloat($row.find('td[data-lvl="3"][data-col="de"] input').val().replace(",", ".")) || 0;
									const cvInput = $row.find('td[data-lvl="3"][data-col="cv"] input');
									cvInput.val(functionHandler("cvCalculator", deValue, meValue));
									$row.get(0).dataset.edited = "true";
								});
							}
							tr.appendChild(cell);
						});
						level3Counter += 6;


						// Construir la celda para Nivel 0 (CUALITATIVO)

						var tdQualitative = document.createElement("td");
						tdQualitative.setAttribute('class', 'unselectable center-text');
						tdQualitative.innerHTML = returnValues_9lvl0[level0Counter];
						tdQualitative.dataset.lvl = "0"; // Identificador de nivel
						tdQualitative.dataset.col = "cualitativo"; // Identificador de columna cualitativa
						tdQualitative.setAttribute('data-id', '0');
						tdQualitative.addEventListener('dblclick', function () {
							table23Editor(this);
						});
						tr.appendChild(tdQualitative);
						level0Counter++; // Incrementa en 1 para el valor cualitativo


						// Columnas de Consenso y Botones
						var tdButtonConsenso = document.createElement("td");
						tdButtonConsenso.style.display = "flex";
						tdButtonConsenso.style.gap = "5px";

						var button = document.createElement("button");
						button.innerHTML = "<span class='glyphicon glyphicon-indent-left'></span>";
						button.setAttribute("class", "btn btn-default btn-sm");
						button.addEventListener("mouseup", function () {
							dataChangeHandler("openReportPDFConsenso", this.parentNode.parentNode.getAttribute("data-id"), "NULL", "NULL", "NULL");
						});
						tdButtonConsenso.appendChild(button);

						var nuevoBoton = document.createElement("button");
						nuevoBoton.innerHTML = "<span class='glyphicon glyphicon-th-list'></span>";
						nuevoBoton.setAttribute("class", "btn btn-info btn-sm");
						nuevoBoton.title = "Seleccionar Resultados de Laboratorio para Consenso";
						nuevoBoton.addEventListener("mouseup", function () {
							var idConfigConsenso = this.parentNode.parentNode.getAttribute("data-id");
							cargarResultadosParaVentanaConsenso(idConfigConsenso);
							functionHandler('windowHandler', 'open', 'miVentanaResultadosConsenso');
						});
						tdButtonConsenso.appendChild(nuevoBoton);
						tr.appendChild(tdButtonConsenso);

						tbody.appendChild(tr);
					}
				}

				$("#table23").find("thead").find("input[data-search-input=true]").keyup();

				// Lógica para ocultar/mostrar columnas según returnValues_11 (nivel del lote)
				switch (returnValues_11) {
					case 0: // El caso 0 oculta todos los cuantitativos y solo deja el cualitativo
						functionHandler("hideColumn", "table23Input1", "table23", "1"); // Nivel 1
						functionHandler("hideColumn", "table23Input2", "table23", "1"); // Nivel 2
						functionHandler("hideColumn", "table23Input3", "table23", "1"); // Nivel 3
						functionHandler("hideColumn", "table23Input4", "table23", "0"); // Nivel 0 (cualitativo)
						break;
					case 1: // El caso 1 muestra Nivel 1 y oculta los demás
						functionHandler("hideColumn", "table23Input1", "table23", "0");
						functionHandler("hideColumn", "table23Input2", "table23", "1");
						functionHandler("hideColumn", "table23Input3", "table23", "1");
						functionHandler("hideColumn", "table23Input4", "table23", "1");
						break;
					case 2: // El caso 2 muestra Nivel 2 y oculta los demás
						functionHandler("hideColumn", "table23Input1", "table23", "1");
						functionHandler("hideColumn", "table23Input2", "table23", "0");
						functionHandler("hideColumn", "table23Input3", "table23", "1");
						functionHandler("hideColumn", "table23Input4", "table23", "1");
						break;
					case 3: // El caso 3 muestra Nivel 3 y oculta los demás
						functionHandler("hideColumn", "table23Input1", "table23", "1");
						functionHandler("hideColumn", "table23Input2", "table23", "1");
						functionHandler("hideColumn", "table23Input3", "table23", "0");
						functionHandler("hideColumn", "table23Input4", "table23", "1");
						break;

				}

				break;
			case 'saveAnalitMedia':
				var answer = parseInt(response.textContent, 10);

				if (answer == 0) {
					var boxType = "warning";
					var txt = "Ha ocurrido un error, por favor comuniquese con el administrador del sistema";
				} else {
					var boxType = "success";
					var txt = "Los datos se han guardado correctamente";
					statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
					var timer_5 = setInterval(function () {
						if (parseInt($("#form21input20").val(), 10) != "") {
							statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

							callsHandler("showAssignedAnalitMedia", $("#form1input4").val() + "|" + $("#form1input2").val() + "|" + $("#form1input1").val(), "id_array&programtypeid=" + $("#form21input20").val(), "NULL", "NULL");

							clearInterval(timer_5);
						}
					}, 100);
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
			case "mediaValueEditor":

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
				var timer_6 = setInterval(function () {
					if (parseInt($("#form21input20").val(), 10) != "") {
						statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');

						callsHandler("showAssignedAnalitMedia", $("#form1input4").val() + "|" + $("#form1input2").val() + "|" + $("#form1input1").val(), "id_array&programtypeid=" + $("#form21input20").val(), "NULL", "NULL");

						clearInterval(timer_6);
					}
				}, 100);

				break;
			case "referenceValueRegistry":
				if (code != 422) { // Si no se realizo una alerta de validacion
					var answer = parseInt(response.textContent, 10);

					if (answer == 0) {
						var boxType = "warning";
						var txt = "El valor de referencia ya existe en la base de datos";
					} else {
						var boxType = "success";
						var txt = "El valor de referencia se ha ingresado correctamente";
						callsHandler('showReferenceValue', $("#form1input2").val() + "|" + $("#form1input4").val() + "|" + $("#form1input1").val(), "id_array");
						$("#form8input5").val("");
					}

					statusBox(boxType, 'NULL', txt, 'add', 'NULL');
				}
				break;
			case "saveFechaCorte":
				var code = parseInt(response.getAttribute("code"), 10);
				if (code === 1) {
					statusBox('success', 'NULL', response.textContent, 'add', 'NULL');
				} else {
					statusBox('warning', 'NULL', response.textContent, 'add', 'NULL');
				}
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

						// td4.addEventListener("dblclick",function () { table26Editor(this) });
						td5.addEventListener("dblclick", function () { table26Editor(this) });
						// td6.addEventListener("dblclick",function () { table26Editor(this) });

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
			case "referenceValueValueEditor":

				callsHandler('showReferenceValue', $("#form1input2").val() + "|" + $("#form1input4").val() + "|" + $("#form1input1").val(), "id_array");

				break;
			case "referenceValueDeletion":

				var answer = parseInt(response.textContent, 10);

				if (answer == 0) {
					var txt = "La eliminación no ha sido exitosa.";
					var boxType = "warning";
				} else {
					var boxType = "success";
					var txt = "El valor de referencia se ha eliminado correctamente";
					callsHandler('showReferenceValue', $("#form1input2").val() + "|" + $("#form1input4").val() + "|" + $("#form1input1").val(), "id_array");
				}

				statusBox(boxType, 'NULL', txt, 'add', 'NULL');

				break;
		}
	}
}

function callsHandler(val, val2, val3, val4, val5) {

	var id = val;

	switch (id) {
		case "showResults":

			if (typeof (val2) == 'undefined') {
				var values = "header=" + id;
			} else {
				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;
			}

			$("#form2InnerFrame1").attr("src", "inner_resultado_1.php?" + values);

			// Obtener los comentarios del reporte

			$("#boton-resumen-comentarios span").html("Cargando...");
			$("#modal-comentarios .panel-body").html("<strong>Cargando...</strong>");

			$.post(
				"php/comentarios_reporte_call_handler.php",
				{
					tipo: "showHTMLComentarios",
					programa: $("#form1input2").val(),
					muestra: $("#form1input4").val(),
					ronda: $("#form1input3").val(),
					laboratorio: $("#form1input1").val()
				},
				function () { /* No hacer nada por el momento */ }
			).done(function () {

			}).fail(function () {

			}).always(function (wewqewe) {
				try {

					let counterComentarios = $(wewqewe).find(".counter-comentarios").val();
					$("#boton-resumen-comentarios span").html(counterComentarios);
					$("#modal-comentarios .panel-body").html(wewqewe);

				} catch (e) {
					$("#modal-comentarios .panel-body").html("Ocurrio algo inesperado... por favor intente nuevamente.");
					$("#boton-resumen-comentarios span").html("N/A");
				}
			});

			break;

		case "showResultsGeneral":

			if (typeof (val2) == 'undefined') {
				var values = "header=" + id;
			} else {
				var values = "header=" + id + "&filter=" + val2 + "&filterid=" + val3;
			}

			$("#form2InnerFrame1").attr("src", "inner_resultado_1_general.php?" + values);

			// Obtener los comentarios del reporte

			$("#boton-resumen-comentarios span").html("Cargando...");
			$("#modal-comentarios .panel-body").html("<strong>Cargando...</strong>");

			$.post(
				"php/comentarios_reporte_call_handler.php",
				{
					tipo: "showHTMLComentarios",
					programa: $("#form1input2").val(),
					muestra: $("#form1input4").val(),
					ronda: $("#form1input3").val(),
					laboratorio: $("#form1input1").val()
				},
				function () { /* No hacer nada por el momento */ }
			).done(function () {

			}).fail(function () {

			}).always(function (wewqewe) {
				try {

					let counterComentarios = $(wewqewe).find(".counter-comentarios").val();
					$("#boton-resumen-comentarios span").html(counterComentarios);
					$("#modal-comentarios .panel-body").html(wewqewe);

				} catch (e) {
					$("#modal-comentarios .panel-body").html("Ocurrio algo inesperado... por favor intente nuevamente.");
					$("#boton-resumen-comentarios span").html("N/A");
				}
			});

			break;
		case "showQAP_FOR_07":

			let variablesFiltro = val2.split("|");
			let programa_cd = variablesFiltro[0];
			let laboratorio_cd = variablesFiltro[1];
			let muestra_cd = variablesFiltro[2];
			let ronda_cd = variablesFiltro[3];

			let direccion_url = "php/informe/informeResumenPorLaboratorio.php?id_programa=" + programa_cd + "&id_laboratorio=" + laboratorio_cd + "&id_muestra=" + muestra_cd + "&id_ronda=" + ronda_cd;

			window.open(direccion_url);
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
				url: "php/resultado_calls_handler.php",
				type: "POST",
				data: values,
				dataType: "xml",
				success: function (xml) {
					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
					responseHandler(xml, id, "NULL", "NULL", "NULL");
				}
			}).always(function (sadsd) {
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
				url: "php/resultado_calls_handler.php",
				type: "POST",
				data: values,
				dataType: "xml",
				success: function (xml) {
					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
					responseHandler(xml, id, val4, "NULL", "NULL");
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
				url: "php/resultado_calls_handler.php",
				type: "POST",
				data: values,
				dataType: "xml",
				success: function (xml) {
					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
					responseHandler(xml, id, "NULL", "NULL", "NULL");
				}
			}).always(function (xzcffewf) {
			});

			break;
	}
}

function dataChangeHandler(val, val2, val3, val4, val5) {
	var id = val;

	switch (id) {
		case "deleteTempFiles":

			var values = "header=" + id;

			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url: "php/resultado_data_change_handler.php",
				type: "POST",
				data: values,
				dataType: "xml",
				success: function (xml) {
					statusBox('loading', 'NULL', 'NULL', 'remove', 'NULL');
					responseHandler(xml, id, "NULL", "NULL", "NULL");
				}
			});

			break;

		case "openReportPDFConsenso":
			let direccion_url = "php/informe/informeConsensoAnalito.php?id_configuracion=" + val2 + "&fecha_corte=" + $("#fecha-corte").val() + "&muestra=" + $("#form1input4").val() + "&ronda=" + $("#form1input3").val() + "&programa=" + $("#form21input20").val();
			window.open(direccion_url);
			break;
		case "saveAnalitMedia":

			var idArray = new Array();
			var melvl1 = new Array();
			var delvl1 = new Array();
			var cvlvl1 = new Array();
			var nlvl1 = new Array();
			var melvl2 = new Array();
			var delvl2 = new Array();
			var cvlvl2 = new Array();
			var nlvl2 = new Array();
			var melvl3 = new Array();
			var delvl3 = new Array();
			var cvlvl3 = new Array();
			var nlvl3 = new Array();
			var p25lvl1 = new Array();
			var p75lvl1 = new Array();
			var p25lvl2 = new Array();
			var p75lvl2 = new Array();
			var p25lvl3 = new Array();
			var p75lvl3 = new Array();

			var trArray = $(val3).find("tbody").find("tr[data-edited=true]").get();

			if (trArray.length > 0) {
				for (x = 0; x < trArray.length; x++) {
					idArray[x] = trArray[x].getAttribute("data-id");

					p25lvl1[x] = $(trArray[x]).find("td[data-lvl=1][data-col=p25] input").val();
					melvl1[x] = $(trArray[x]).find("td[data-lvl=1][data-col=me] input").val();
					p75lvl1[x] = $(trArray[x]).find("td[data-lvl=1][data-col=p75] input").val();
					delvl1[x] = $(trArray[x]).find("td[data-lvl=1][data-col=de] input").val();
					cvlvl1[x] = $(trArray[x]).find("td[data-lvl=1][data-col=cv] input").val();
					nlvl1[x] = $(trArray[x]).find("td[data-lvl=1][data-col=n] input").val();

					p25lvl2[x] = $(trArray[x]).find("td[data-lvl=2][data-col=p25] input").val();
					melvl2[x] = $(trArray[x]).find("td[data-lvl=2][data-col=me] input").val();
					p75lvl2[x] = $(trArray[x]).find("td[data-lvl=2][data-col=p75] input").val();
					delvl2[x] = $(trArray[x]).find("td[data-lvl=2][data-col=de] input").val();
					cvlvl2[x] = $(trArray[x]).find("td[data-lvl=2][data-col=cv] input").val();
					nlvl2[x] = $(trArray[x]).find("td[data-lvl=2][data-col=n] input").val();

					p25lvl3[x] = $(trArray[x]).find("td[data-lvl=3][data-col=p25] input").val();
					melvl3[x] = $(trArray[x]).find("td[data-lvl=3][data-col=me] input").val();
					p75lvl3[x] = $(trArray[x]).find("td[data-lvl=3][data-col=p75] input").val();
					delvl3[x] = $(trArray[x]).find("td[data-lvl=3][data-col=de] input").val();
					cvlvl3[x] = $(trArray[x]).find("td[data-lvl=3][data-col=cv] input").val();
					nlvl3[x] = $(trArray[x]).find("td[data-lvl=3][data-col=n] input").val();

				}

				if ($("#form21input12").get(0).checked) {
					var labId = $("#form1input1").val();
				} else {
					var labId = "NULL";
				}

				// Unir los arrays en cadenas separadas por "|"

				idArray = idArray.join("|");
				p25lvl1 = p25lvl1.join("|");
				melvl1 = melvl1.join("|");
				p75lvl1 = p75lvl1.join("|");
				delvl1 = delvl1.join("|");
				cvlvl1 = cvlvl1.join("|");
				nlvl1 = nlvl1.join("|");
				p25lvl2 = p25lvl2.join("|");
				melvl2 = melvl2.join("|");
				p75lvl2 = p75lvl2.join("|");
				delvl2 = delvl2.join("|");
				cvlvl2 = cvlvl2.join("|");
				nlvl2 = nlvl2.join("|");
				p25lvl3 = p25lvl3.join("|");
				melvl3 = melvl3.join("|");
				p75lvl3 = p75lvl3.join("|");
				delvl3 = delvl3.join("|");
				cvlvl3 = cvlvl3.join("|");
				nlvl3 = nlvl3.join("|");

				var values = "header=" + id +
					"&programid=" + $("#form1input2").val() +
					"&programtypeid=" + $("#form21input20").val() +
					"&sampleid=" + $("#form1input4").val() +
					"&ids=" + idArray +
					"&labid=" + labId +
					"&savemethod=" + $("#form21input21").val() +
					"&p25lvl1=" + p25lvl1 +
					"&melvl1=" + melvl1 +
					"&p75lvl1=" + p75lvl1 +
					"&delvl1=" + delvl1 +
					"&cvlvl1=" + cvlvl1 +
					"&nlvl1=" + nlvl1 +
					"&p25lvl2=" + p25lvl2 +
					"&melvl2=" + melvl2 +
					"&p75lvl2=" + p75lvl2 +
					"&delvl2=" + delvl2 +
					"&cvlvl2=" + cvlvl2 +
					"&nlvl2=" + nlvl2 +
					"&p25lvl3=" + p25lvl3 +
					"&melvl3=" + melvl3 +
					"&p75lvl3=" + p75lvl3 +
					"&delvl3=" + delvl3 +
					"&cvlvl3=" + cvlvl3 +
					"&nlvl3=" + nlvl3;

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({
					contentType: "application/x-www-form-urlencoded",
					url: "php/resultado_data_change_handler.php",
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
					url: "php/resultado_data_change_handler.php",
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
		case "referenceValueRegistry":

			if (functionHandler('inputChecker', val3)) {
				var values = "header=" + id + "&programid=" + $("#form1input2").val() + "&sampleid=" + $("#form1input4").val() + "&labid=" + $("#form1input1").val() + "&" + $(val3).serialize();

				statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

				$.ajax({
					contentType: "application/x-www-form-urlencoded",
					url: "php/resultado_data_change_handler.php",
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
					url: "php/resultado_data_change_handler.php",
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
					url: "php/resultado_data_change_handler.php",
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
	}
}

function table23Editor(val) {

	var td = val;
	var backupvalue = val.innerHTML;

	tdId = parseInt(td.getAttribute("data-id"), 10);

	switch (tdId) {
		case 0:

			var input = document.createElement("select");
			var txt = new RegExp(val.innerHTML.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&"), "g");
			input.setAttribute("class", "form-control unselectedInput");
			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');

			var values = "header=showAnalitCualitativeTypeOfResultForConfiguration&filterid=id_configuracion&filter=" + td.parentNode.getAttribute("data-id");

			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url: "php/resultado_calls_handler.php",
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

			if ($("#form21input12").get(0).checked) {
				var tempChecked = 1;
			} else {
				var tempChecked = 0;
			}

			$(input).bind("blur", function () {
				setTimeout(function () {
					dataChangeHandler("mediaValueEditor", tdId, input, $("#form1input1").val() + "|" + $("#form1input4").val() + "|" + tempChecked, "NULL");
				}, 2);
			});

			$(input).keyup(function (event) {

				if (event.keyCode == 13) {
					setTimeout(function () {
						dataChangeHandler("mediaValueEditor", tdId, input, $("#form1input1").val() + "|" + $("#form1input4").val() + "|" + tempChecked, "NULL");
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
				url: "php/resultado_calls_handler.php",
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

			$(input).keyup(function () { var tempValue = input.value + ''; input.value = tempValue.replace(",", ".") });
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
				url: "php/resultado_calls_handler.php",
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

function functionHandler(val, val2, val3, val4, val5) {
	var id = val;

	switch (id) {
		case "tableSearch":
			var $rows = $(val2).parent().parent().parent().next().find("tr");
			var val = $.trim($(val2).val()).replace(/ +/g, ' ').toLowerCase();
			$rows.show().filter(function () {
				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
				return !~text.indexOf(val);
			}).hide();
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
		case 'windowChecker':

			id = "#" + val2;

			var status = $(id).attr("hidden");

			if (status == "hidden") {
				$(id).removeAttr("hidden");
				$(id).get(0).dataset.active = 1;
			} else {
				$(id).attr("hidden", "hidden");
				$(id).get(0).dataset.active = 0;
			}

			break;
		case 'formReset':
			$('[data-form-reset=true]').val("");
			break;
		case 'selectFiller':

			var select = $("#" + val2).get(0);
			select.innerHTML = "";
			select.value = "";
			select.removeAttribute("data-active");
			select.dataset.active = "false";

			var values = "header=" + val3;
			statusBox('loading', 'NULL', 'NULL', 'add', 'NULL');
			$("#fechas_corte").empty();
			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url: "php/resultado_calls_handler.php",
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
							var omit = parseInt(response.childNodes[x].getAttribute("selectomit"), 10);
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
								if (val2 === 'form1input4' && $("#fechas_corte_personalizadas").prop('checked') == true) {
									appendFechaCorteMuestra(contentArray[x], idArray[x]);
								}
							}

						}

						select.dataset.active = "true";

					}
				}
			});

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
		case 'windowHandler':

			var item = val3;

			switch (val2.toLowerCase()) {
				case 'open':
					$("#" + item).removeAttr("hidden");
					break;
				case 'close':
					$("#" + item).attr("hidden", "hidden");
					break;
			}

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
				/*$(table).find("tbody").find("tr").find("td[data-lvl="+lvl+"]").children().hide();
				$(table).find("thead").find("tr").find("th[data-lvl="+lvl+"]").children().not(button).hide();
				button.removeAttribute("data-status");
				button.dataset.status = "0";
				$(button).find("span").attr("class","glyphicon glyphicon-triangle-right");
				$(button).attr("title","Mostrar");*/
			} else {
				$(table).find("thead").find("tr").find("th[data-lvl=" + lvl + "]").show();
				$(table).find("tbody").find("tr").find("td[data-lvl=" + lvl + "]").show();
				/*$(table).find("tbody").find("tr").find("td[data-lvl="+lvl+"]").children().show();
				$(table).find("thead").find("tr").find("th[data-lvl="+lvl+"]").children().not(button).show();
				button.removeAttribute("data-status");
				button.dataset.status = "1";
				$(button).find("span").attr("class","glyphicon glyphicon-triangle-left");
				$(button).attr("title","Ocultar");*/
			}

			break;
		default:
			alert('JS functionHandler error: id "' + id + '" not found');
			break;
	}
}
// Función appendFechaCorteMuestra corregida
function appendFechaCorteMuestra(muestraLabel, muestraId) {
	// Verificar si ya existe para evitar duplicados
	if ($('#fecha_corte_' + muestraId).length > 0) {
		return;
	}

	var child = '<div class="form-group fecha-corte-group" data-muestra-id="' + muestraId + '">' +
		'<label for="fecha_corte_' + muestraId + '">Fecha Corte ' + muestraLabel + '</label>' +
		'<input class="form-control input-sm fecha_corte_muestra" ' +
		'data-muestraid="' + muestraId + '" ' +
		'type="date" ' +
		'id="fecha_corte_' + muestraId + '" ' +
		'name="fecha_corte[]">' +
		'</div>';

	$("#fechas_corte").append(child);



	// Asociar el evento change al nuevo input
	$('#fecha_corte_' + muestraId).off('change').on('change', function () {
		var fecha = $(this).val();
		var idMuestra = $(this).data('muestraid');

		// Verificar que tenemos todos los valores necesarios
		var idLaboratorio = $("#form1input1").val();
		var idPrograma = $("#form1input2").val();
		var idRonda = $("#form1input3").val();

		// Validar que todos los campos tienen valor
		if (!fecha || !idMuestra || !idLaboratorio || !idPrograma || !idRonda) {
			alert('Error: Faltan datos necesarios para guardar la fecha. Verifique que haya seleccionado laboratorio, programa y ronda.');
			return;
		}

		// Llamar a la función para guardar
		guardarFechaEnDB(fecha, idMuestra, idLaboratorio, idRonda, idPrograma);

	});
}

// Función guardarFechaEnDB mejorada
function guardarFechaEnDB(fecha, idMuestra, idLaboratorio, idRonda, idPrograma) {
	// Verificación adicional
	if (!fecha || !idMuestra || !idLaboratorio || !idRonda || !idPrograma) {
		return;
	}

	var datos = {
		header: 'saveFechaCorte',
		fecha: fecha,
		id_muestra: idMuestra,
		id_laboratorio: idLaboratorio,
		id_ronda: idRonda,
		id_programa: idPrograma
	};

	$.ajax({
		url: 'php/resultado_data_change_handler.php',
		type: 'POST',
		data: datos,
		dataType: 'xml'
	});
}
// También añade un log en la función de llenado para verificar el proceso
function obtenerFechasDeDB(idLaboratorio, idPrograma, idRonda) {
	var datos = {
		header: 'getFechasCorte',
		id_laboratorio: idLaboratorio,
		id_programa: idPrograma,
		id_ronda: idRonda
	};

	$.ajax({
		url: 'php/resultado_data_change_handler.php',
		type: 'POST',
		data: datos,
		dataType: 'xml',
		success: function (xml) {
			$(xml).find('fecha_corte').each(function () {
				var idMuestra = $(this).find('id_muestra').text();
				var fecha = $(this).find('fecha').text();
				// Llenar el campo de fecha correspondiente
				$('#fecha_corte_' + idMuestra).val(fecha);
			});
		},
		error: function (jqXHR, textStatus, errorThrown) {
			console.log('AJAX ERROR:', textStatus, errorThrown);
		}
	});
}
function errorHandler(val) {
	alert(val);
}
function setupVentanaResultadosConsenso() {
	var modalId = 'miVentanaResultadosConsenso';

	// --- 1. Seleccionar todos los checkboxes al iniciar ---
	function marcarTodosLosCheckboxes() {
		var tbodyResultados = document.querySelector('#' + modalId + ' #tbodyResultadosConsenso');
		var selectAllCheckbox = document.querySelector('#' + modalId + ' #selectAllResultadosConsenso');

		if (tbodyResultados) {
			var checkboxes = tbodyResultados.querySelectorAll('input[type="checkbox"][name="seleccion_resultado_consenso[]"]');

			checkboxes.forEach(checkbox => {
				checkbox.checked = true;
			});

			if (selectAllCheckbox) {
				selectAllCheckbox.checked = true;
			}
		}
	}

	marcarTodosLosCheckboxes();

	var selectAllCheckbox = document.querySelector('#' + modalId + ' #selectAllResultadosConsenso');
	var tbodyResultados = document.querySelector('#' + modalId + ' #tbodyResultadosConsenso');

	if (selectAllCheckbox && tbodyResultados) {
		selectAllCheckbox.addEventListener('change', function (event) {
			let checkboxes = tbodyResultados.querySelectorAll('input[type="checkbox"][name="seleccion_resultado_consenso[]"]');
			checkboxes.forEach(checkbox => {
				checkbox.checked = event.target.checked;
			});
		});

		// Actualizar "Seleccionar todos" cuando cambian checkboxes individuales
		tbodyResultados.addEventListener('change', function (e) {
			if (e.target.matches('input[type="checkbox"][name="seleccion_resultado_consenso[]"]')) {
				var allChecked = true;
				var checkboxes = tbodyResultados.querySelectorAll('input[type="checkbox"][name="seleccion_resultado_consenso[]"]');

				checkboxes.forEach(checkbox => {
					if (!checkbox.checked) {
						allChecked = false;
					}
				});

				selectAllCheckbox.checked = allChecked;
			}
		});
	}

	// --- 3. Funcionalidad del botón "Procesar Seleccionados" ---
	var procesarBtn = document.querySelector('#' + modalId + ' #btnProcesarSeleccionConsenso');
	if (procesarBtn && tbodyResultados) {
		procesarBtn.addEventListener('click', function () {
			let seleccionados_ids = [];
			let checkboxesSeleccionados = tbodyResultados.querySelectorAll('input[type="checkbox"][name="seleccion_resultado_consenso[]"]:checked');

			checkboxesSeleccionados.forEach(checkbox => {
				seleccionados_ids.push(checkbox.value); // 'value' es el id_unico_resultado
			});

			// Obtener el idConfigConsenso para el cual se están guardando estas selecciones
			var idConfigElement = document.getElementById('infoIdConfigConsenso');
			var idConfigConsensoActual = idConfigElement ? idConfigElement.textContent : null;

			var fechaCorteSeleccionada = $("#fecha-corte").val();
			var idMuestraSeleccionada = $("#form1input4").val();
			// ************************************************************

			if (!idConfigConsensoActual || idConfigConsensoActual === 'N/A') {
				alert("Error: No se pudo identificar la configuración de consenso actual.");
				return;
			}

			// *** Añadir validación para los nuevos parámetros ***
			if (!idMuestraSeleccionada || !fechaCorteSeleccionada) {
				alert("Error: La información de Muestra o Fecha de Corte no está disponible. No se pueden guardar las selecciones.");
				return;
			}
			// ****************************************************

			if (seleccionados_ids.length > 0) {
				// Enviar selecciones al servidor para guardarlas en la base de datos
				$.ajax({
					url: 'php/guardar_selecciones_consenso.php',
					type: 'POST',
					data: {
						id_config_consenso: idConfigConsensoActual,
						id_muestra: idMuestraSeleccionada,
						fecha_corte: fechaCorteSeleccionada,
						ids_resultados_seleccionados: seleccionados_ids
					},
					dataType: 'json',
					success: function (response) {
						if (response && response.status === 'success') {
							statusBox('success', 'NULL', response.message || 'Selecciones guardadas', 'add', '3000');
							functionHandler('windowHandler', 'close', modalId);
						} else {
							statusBox('warning', 'NULL', response.message || 'Error al guardar las selecciones.', 'add', 'NULL');
						}
					},
					error: function () {
						statusBox('error', 'NULL', 'Error de comunicación al guardar selecciones.', 'add', 'NULL');
					}
				});
			} else {
				// Si no se seleccionó nada, enviar array vacío para limpiar selecciones previas para este idConfigConsenso, idMuestra, fechaCorte
				$.ajax({
					url: 'php/guardar_selecciones_consenso.php',
					type: 'POST',
					data: {
						id_config_consenso: idConfigConsensoActual,
						id_muestra: idMuestraSeleccionada,
						fecha_corte: fechaCorteSeleccionada,
						ids_resultados_seleccionados: [] // Enviar array vacío para indicar limpieza
					},
					dataType: 'json',
					success: function (response) {
						statusBox('info', 'NULL', response.message || 'No se seleccionaron resultados. Se limpiaron selecciones previas si existían.', 'add', '3000');
						functionHandler('windowHandler', 'close', modalId);
					},
					error: function () {
						statusBox('error', 'NULL', 'Error de comunicación al limpiar selecciones.', 'add', 'NULL');
					}
				});
			}
		});
	}


	// --- Funcionalidad arrastrable ---
	var panelParaArrastrar = document.getElementById('miVentanaResultadosConsensoPanel');
	if (panelParaArrastrar && typeof $ !== 'undefined' && typeof $.ui !== 'undefined') {
		$(panelParaArrastrar).draggable({
			handle: ".panel-heading"
		});
	}
}
/**
 * Carga dinámicamente los resultados de laboratorio para una configuración de consenso específica
 * en la ventana modal 'miVentanaResultadosConsenso'.
 * @param {string} idConfigConsenso - El ID de la configuración de consenso.
 */
function cargarResultadosParaVentanaConsenso(idConfigConsenso) {
	var modalId = 'miVentanaResultadosConsenso';
	var tbody = document.querySelector('#' + modalId + ' #tbodyResultadosConsenso');
	var spanInfoId = document.getElementById('infoIdConfigConsenso');

	if (spanInfoId) {
		spanInfoId.textContent = idConfigConsenso || 'N/A';
	}

	// Muestra un mensaje de "cargando" en la tabla
	tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;">Cargando resultados... <span class="glyphicon glyphicon-refresh glyphicon-spin"></span></td></tr>';

	// Desmarcar el checkbox "Seleccionar todos" de la modal
	var selectAllChk = document.querySelector('#' + modalId + ' #selectAllResultadosConsenso');
	if (selectAllChk) {
		selectAllChk.checked = false;
	}
	var fechaCorteSeleccionada = $("#fecha-corte").val();
	var idMuestraSeleccionada = $("#form1input4").val();
	console.log("Muestra seleccionada:", idMuestraSeleccionada);



	var urlCompleta = window.location.origin + window.location.pathname.replace(/[^/]*$/, '') + 'php/obtener_resultados_lab_consenso.php';

	if (!fechaCorteSeleccionada) {
		console.warn("Advertencia: No se encontró un valor para #fecha-corte. La consulta podría fallar o usar un default en PHP.");
	}

	statusBox('loading', 'NULL', 'Cargando datos para consenso...', 'add', 'NULL');



	$.ajax({
		url: 'php/obtener_resultados_lab_consenso.php',
		type: 'POST',
		data: {
			id_config_consenso: idConfigConsenso,
			fecha_corte: fechaCorteSeleccionada,
			id_muestra: idMuestraSeleccionada
		},
		dataType: 'json',
		success: function (response) {
			statusBox('loading', 'NULL', '', 'remove', 'NULL');
			tbody.innerHTML = '';

			if (response && response.error) {
				tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; color:red;">Error: ' + response.error + '</td></tr>';
				console.error("Error devuelto por PHP:", response.error);
				return;
			}

			if (response && response.length > 0) {
				response.forEach(function (item, index) {
					var tr = document.createElement('tr');

					var tdCheckbox = document.createElement('td');
					tdCheckbox.className = 'select-checkbox-cell';
					var checkbox = document.createElement('input');
					checkbox.type = 'checkbox';
					checkbox.name = 'seleccion_resultado_consenso[]';
					checkbox.value = item.id_unico_resultado;
					if (item.seleccionado_previamente === true || String(item.seleccionado_previamente) === "1") {
						checkbox.checked = true;
					}
					tdCheckbox.appendChild(checkbox);
					tr.appendChild(tdCheckbox);

					// Celda "IT" - Es una secuencia simple: 1, 2, 3, ...
					var tdIt = document.createElement('td');
					tdIt.textContent = index + 1;
					tr.appendChild(tdIt);

					// Celda "Resultado" 
					var tdResultado = document.createElement('td');
					tdResultado.textContent = item.resultado !== undefined ? item.resultado : '';
					tr.appendChild(tdResultado);

					// Celda "Fecha" 
					var tdFecha = document.createElement('td');
					tdFecha.textContent = item.fecha !== undefined ? item.fecha : '';
					tr.appendChild(tdFecha);

					// Celda "Ronda" 
					var tdRonda = document.createElement('td');
					tdRonda.textContent = item.ronda_nombre !== undefined ? item.ronda_nombre : '';
					tr.appendChild(tdRonda);

					// Celda "Muestra" 
					var tdMuestra = document.createElement('td');
					var noContadorParaMuestra = item.it !== undefined ? item.it : '';
					var nombreMuestra = item.muestra_nombre !== undefined ? item.muestra_nombre : '';
					tdMuestra.textContent = "(" + noContadorParaMuestra + ") " + nombreMuestra;
					tr.appendChild(tdMuestra);

					// Celda "ID Laboratorio"
					var tdIdLab = document.createElement('td');
					tdIdLab.textContent = item.id_laboratorio !== undefined ? item.id_laboratorio : '';
					tr.appendChild(tdIdLab);

					// Celda "Nombre Laboratorio"
					var tdNombreLab = document.createElement('td');
					tdNombreLab.textContent = item.nombre_laboratorio !== undefined ? item.nombre_laboratorio : '';
					tr.appendChild(tdNombreLab);

					// Celda "Nombre Metodología"
					var tdMetodologia = document.createElement('td');
					tdMetodologia.textContent = item.nombre_metodologia !== undefined ? item.nombre_metodologia : '';
					tr.appendChild(tdMetodologia);

					tbody.appendChild(tr);
				});
			} else {
				tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;">No se encontraron resultados individuales para esta configuración.</td></tr>';
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			statusBox('loading', 'NULL', '', 'remove', 'NULL');
			tbody.innerHTML = '<tr><td colspan="9" style="text-align:center; color:red;">Error al cargar los resultados (AJAX): ' + textStatus + ' - ' + errorThrown + '</td></tr>';
			console.error("Error en llamada AJAX:", textStatus, errorThrown, jqXHR.responseText);
		}
	});
}