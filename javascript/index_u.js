function initialize() {

	$("#form2input1").bind("mouseup",function(event){

		window.location.href = "php/cierra_sesion.php";

	});	



	callsHandler('showMaterial');



	$("#open_reports").click(function(e){

		e.preventDefault();

		window.open("reportes.php?filter="+$("#form1input1").val()+"&filterid=id_laboratorio", "Consultar reportes QAP", "width=1000, height=600")

		window.open("reportes.php?filter="+$("#form1input1").val()+"&filterid=id_laboratorio", "Consultar reportes QAP")

	})



	$("#table250input1").bind("click",function(event){

		dataChangeHandler("saveAnalitCualitativeTypeOfResult",$("#w250p").attr("data-id-holder"),"NULL","NULL","NULL");

		event.preventDefault();

	});	



	$("#form2Button1").bind("mouseup",function(event){

		var _confirm = confirm("¿Está seguro que desea reportar los valores ingresados?\n\nUna vez haya envíado los resultados solo podrá editarlos tras pasar el proceso de revaloración\n\n¿Está seguro que desea continuar?");

		

		if (_confirm) {

			dataChangeHandler("saveAnalitResults","NULL",$("#form3").get(0),"NULL","NULL");

		}

		

		event.preventDefault();

	});

	$("#form6").bind("submit",function(event){

		dataChangeHandler("labAnalitAssignation","NULL",$("#form6").get(0),"NULL","NULL");

		event.preventDefault();

	});	

	

	$("#form1input1").bind("change",function(event) {

		functionHandler("selectFiller","form1input2","showAssignedLabProgram&filter="+this.value+"&filterid=id_laboratorio"," | ");

		callsHandler("showLabData",this.value,"id_laboratorio","NULL","NULL");

		statusBox('loading','NULL','NULL','add','NULL');

		var timer_1 = setInterval(function() {

			if ($("#form1input2").attr("data-active") == "true") {

				statusBox('loading','NULL','NULL','remove','NULL');

				$("#form1input2").change();

				clearInterval(timer_1);							

			}

		},100);	

	});

	$("#form1input2").bind("change",function(event) {

		functionHandler("selectFiller","form1input3","showAssignedLabRound&filter="+this.value+"|"+$("#form1input1").val()+"&filterid=id_laboratorio"," | ");

		functionHandler("selectFiller","form6input3","showAnalit&filter="+this.value+"&filterid=id_programa"," | ","false");

		$("#form1input4").val("");

		callsHandler("showAssignedLabAnalitSimple",$("#form1input1").val()+"|"+$("#form1input2").val(),"id_array","NULL","NULL");

		callsHandler("showAssignedProgramType",this.value,"id_programa","form1input4","NULL");

		

		statusBox('loading','NULL','NULL','add','NULL');

		var timer_2 = setInterval(function() {

			if ($("#form1input3").attr("data-active") == "true") {

				statusBox('loading','NULL','NULL','remove','NULL');

				$("#form1input3").change();

				clearInterval(timer_2);	

			}

		},100);

		statusBox('loading','NULL','NULL','add','NULL');

		var timer_3 = setInterval(function() {

			if ($("#form6input3").attr("data-active") == "true") {

				statusBox('loading','NULL','NULL','remove','NULL');

				$("#form6input3").change();

				clearInterval(timer_3);							

			}

		},100);			

	});

	$("#form6input3").bind("change",function(event) {

		functionHandler("selectFiller","form6input4","showAnalyzer"," | ","false");

		functionHandler("selectFiller","form6input6","showReactive"," | ","false");

		

		statusBox('loading','NULL','NULL','add','NULL');

		var timer_4 = setInterval(function() {

			if ($("#form6input4").attr("data-active") == "true" && $("#form6input3").attr("data-active") == "true") {

				statusBox('loading','NULL','NULL','remove','NULL');

				$("#form6input4").change();

				clearInterval(timer_4);						

			}

		},100);

	});

	$("#form6input4").bind("change",function(event) {

		

		functionHandler("selectFiller","form6input5","showMethod&filter="+this.value+"&filterid=id_analizador"," | ","false");

		functionHandler("selectFiller","form6input7","showUnit&filter="+this.value+"&filterid=id_analizador"," | ","false");

		functionHandler("selectFiller","form6input8","showVitrosGen"," | ","false");

		

		var tempvalue = this.value;

		

		if (tempvalue == "") {

			//

		} else {

			var tempText = $("#"+this.id+" option[value="+tempvalue+"]"). text().toLowerCase();

			var tempTemplate = new RegExp("vitros","g");

			

			if (tempTemplate.test(tempText)) {

				$("#form6input8").removeAttr("disabled");

				$('#form6input8').button("enable");

			} else {

				$("#form6input8").attr("disabled","disabled");

				$("#form6input8").val($("#form6input8 option:first").val());

				$('#form6input8').button("disable");

			}				

		}	

				

	});	

	$("#form1input3").bind("change",function(event) {

		callsHandler("showAssignedRoundSample",this.value+"|"+$("#form1input2").val()+"|"+$("#form1input1").val(),"id_array","NULL","NULL");

	});

	var toEscape = '!@$^&*+=[]\\\'/{}|"<>`¨´';

	var permit = '()%#-_;.?!';

	$("#w1textarea1").alphanum({

		disallow : toEscape,

		allow : permit

	});

	$("#w1textarea1").bind("keyup",function(event) {

		$(this).attr("maxlength","150");

		functionHandler("badgeCounter",this);

	});

	$("#w3overlay1").bind("mouseup",function(event){

		functionHandler('windowHandler','close','window3');

		$("#w3iframe1").attr("src",$("#w3iframe1").attr("src"));

	});

	$("#w4p").find(".panel-heading").find("button").bind("mouseup",function(event){

		$("#w3iframe1").attr("src",$("#w3iframe1").attr("src"));

	});

	

	if ($("#form1input1").children().length == 0) {

		alert("ADVERTENCIA: El usuario con cual ha ingresado no posee un número de laboratorio asignado.\n\nPor favor pongase en contacto con el administrador del sistema.");

	} else {

		$("#form1input1").change();

	}



	$("#w1p").draggable();

	$("#w2p").draggable();

	$("#w3p").draggable();

	$("#w4p").draggable();

	$("#w250p").draggable();

	

	/*

	var numbers = [1,2,3,4,5];

	shuffle(numbers);

	

	$("body").vegas({

		slides: [

			{ src: '/qap/css/index_bg_'+numbers[0]+'.jpg' },

			{ src: '/qap/css/index_bg_'+numbers[1]+'.jpg' },

			{ src: '/qap/css/index_bg_'+numbers[2]+'.jpg' },

			{ src: '/qap/css/index_bg_'+numbers[3]+'.jpg' },

			{ src: '/qap/css/index_bg_'+numbers[4]+'.jpg' }

		],

		delay: 600000,

		timer: false,

		transition: 'fade'

	});

	*/

	

	var timer_5 = setInterval(function(){

		callsHandler("checkSession",timer_5,"NULL","NULL","NULL");

	},5000);

	

	function shuffle(array) {

	var currentIndex = array.length, temporaryValue, randomIndex;

	

		while (0 !== currentIndex) {

		

			randomIndex = Math.floor(Math.random() * currentIndex);

			currentIndex -= 1;

		

			temporaryValue = array[currentIndex];

			array[currentIndex] = array[randomIndex];

			array[randomIndex] = temporaryValue;

		}

		

		return array;

	}

}



function responseHandler(val,val2,val3,val4,val5) {

	

	var response = val.getElementsByTagName("response")[0];

	

	var code = parseInt(response.getAttribute("code"),10);

	

	if (code == 0) {

		errorHandler(response.textContent);

	} else {

		switch (val2) {



			case "assignedLabAnalitValueEditor":

				callsHandler("showAssignedLabAnalitSimple",$("#form1input1").val()+"|"+$("#form1input2").val(),"id_array","NULL","NULL");

				// callsHandler("showAssignedLabAnalit",$("#form6input1").val()+"|"+$("#form6input2").val(),"id_array","NULL","NULL");

			

			break;





			case "showAnalitConfiguredCualitativeTypeOfResult":



				var tbody = $("#table250").find("tbody").get(0);

					tbody.innerHTML = "";

					

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				

				if (returnValues_1 != "") {

				

					for (var x = 0; x < returnValues_1.length; x++) {

						

						var tr = document.createElement("tr");

						

						var td1 = document.createElement("td");

						

							td1.setAttribute('class','unselectable');

							td1.setAttribute('colspan','2');

						

						uniqId = functionHandler("uniqId");

						

						td1.innerHTML = "<label for='"+uniqId+"' style='width:100%; height: 100%;'><input type='checkbox' checked='checked' id='"+uniqId+"' value='"+returnValues_1[x]+"'></input> "+returnValues_2[x]+"</label>";

						

						

						tr.appendChild(td1);



						tbody.appendChild(tr);

					}

				

				}

				

				if (returnValues_3 != "") {

				

					for (var x = 0; x < returnValues_3.length; x++) {

						

						var tr = document.createElement("tr");

						

						var td1 = document.createElement("td");

						

							td1.setAttribute('class','unselectable');

							td1.setAttribute('colspan','2');

						

						uniqId = functionHandler("uniqId");

						

						td1.innerHTML = "<label for='"+uniqId+"' style='width:100%; height: 100%;'><input type='checkbox' id='"+uniqId+"' value='"+returnValues_3[x]+"'></input> "+returnValues_4[x]+"</label>";

						

						tr.appendChild(td1);



						tbody.appendChild(tr);

					}

				

				}				

				

				if (val4 == "no_window_action") {

					//

				} else {

					functionHandler('windowHandler',"open",'window250');

				}

				

				$("#w250p").attr("data-id-holder",val3);

				$("#table250").find("thead").find("input[data-search-input=true]").keyup();

				

			break;	



			case'saveAnalitCualitativeTypeOfResult':

				var answer = parseInt(response.textContent,10);

				

				if (answer == 0) {

					var boxType = "warning";

					var txt = "Ha ocurrido un error, por favor comuniquese con el administrador del sistema";					

				} else {

					var boxType = "success";

					var txt = "Los datos se han guardado correctamente";

					callsHandler("showAnalitConfiguredCualitativeTypeOfResult",val3,"id_configuracion","no_window_action","NULL")

				}

				

				statusBox(boxType,'NULL',txt,'add','NULL');

							

			break;



			case "showAssignedRoundSample":

			

				var tbody = $("#table1").find("tbody").get(0);

					tbody.innerHTML = "";

					

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");

				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");

				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0].textContent.split("|");

				var returnValues_4 = response.getElementsByTagName("returnvalues4")[0].textContent.split("|");

				var returnValues_5 = response.getElementsByTagName("returnvalues5")[0].textContent.split("|");

				

				var oneDay = (24*60*60*1000);

				var today = new Date();

				

				if (returnValues_1 != "") {

					

					

for (var x = 0; x < returnValues_1.length; x++) {



   var sampleDateParts = returnValues_4[x].split("-");
    var sampleEndDate = new Date(
        parseInt(sampleDateParts[0], 10), 
        parseInt(sampleDateParts[1], 10) - 1, 
        parseInt(sampleDateParts[2], 10)
    );


    var dayDifference = Math.round((sampleEndDate - today) / oneDay);

	console.log("Fecha:", sampleEndDate, "Hoy:", today, "Diferencia:", dayDifference);



    // Mostrar solo las fechas dentro del rango de los 8 días calendario

    if (dayDifference >= -8 && dayDifference <= 0) {



        var tr = document.createElement("tr");



        var td1 = document.createElement("td");

        var td2 = document.createElement("td");

        var td3 = document.createElement("td");

        var td4 = document.createElement("td");



        td1.setAttribute('class', 'unselectable center-text pointer');

        td2.setAttribute('class', 'unselectable center-text pointer');

        td3.setAttribute('class', 'unselectable center-text pointer');

        td4.setAttribute('class', 'unselectable center-text pointer');



        td1.dataset.id = "1";

        td2.dataset.id = "2";

        td3.dataset.id = "3";

        td4.dataset.id = "4";



        td1.innerHTML = returnValues_2[x];

        td2.innerHTML = returnValues_3[x];

        td3.innerHTML = returnValues_4[x];





		if (dayDifference < 0 && parseInt(returnValues_5[x],10) == 0) {

			$(tr).addClass("sampleColor1");								

			$(tr).attr("title","Muestra vencida, muestra sin resultados");

			td4.innerHTML = "<span class='glyphicon glyphicon-remove'></span>";	

		} else if (dayDifference < 0 && parseInt(returnValues_5[x],10) == 1) {

			$(tr).addClass("sampleColor0");								

			$(tr).attr("title","Muestra vencida, muestra con resultados");

			td4.innerHTML = "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";	

		} else if (dayDifference == 0) {

			$(tr).addClass("sampleColor2");

			$(tr).attr("title","Muestra a reportar en la fecha");

			if (parseInt(returnValues_5[x],10) == 1) {

				td4.innerHTML = "<span class='glyphicon glyphicon-ok' style='color: green;'></span>";

			}

		} 			

						





        tr.appendChild(td1);

        tr.appendChild(td2);

        tr.appendChild(td3);

        tr.appendChild(td4);



        tr.dataset.id = returnValues_1[x];



        tr.addEventListener("mouseup", function () {

            callsHandler("showAssignedLabAnalit", $("#form1input1").val() + "|" + $("#form1input2").val() + "|" + this.getAttribute("data-id"), "id_array");

            functionHandler("highLightItem", this);

        });



        tbody.appendChild(tr);

    }

}				

}									

				

			break;

			case "showAssignedLabAnalit":

			

				var tbody = $("#table2").find("tbody").get(0);

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

				var returnValues_13 = response.getElementsByTagName("returnvalues13")[0].textContent;

				var returnValues_14 = response.getElementsByTagName("returnvalues14")[0].textContent.split("|");

				

				var isThereAnyResult = false;

				

				if (returnValues_1 != "") {

					

					for (var x = 0; x < returnValues_1.length; x++) {

						if (returnValues_7[x] != "") {

							isThereAnyResult = true;

							break;

						}

					}

					

					for (var x = 0; x < returnValues_1.length; x++) {

						

						var tr = document.createElement("tr");						

						

						var td1 = document.createElement("td");

						var td2 = document.createElement("td");

						var td3 = document.createElement("td");

						var td4 = document.createElement("td");

						var div = document.createElement("div");

						var span_1 = document.createElement("span");

						var span_2 = document.createElement("span");

						

						var textArea_1 = document.createElement("textarea");

							textArea_1.setAttribute("hidden","hidden");

							textArea_1.setAttribute("name","form2textarea_"+(x+1));

						

							div.setAttribute("style","margin: 0 auto; width: 90%;")

						

							span_1.setAttribute("class","pull-left");

						

						var button = document.createElement("button");

						

						button.innerHTML = "<span class='glyphicon glyphicon-comment' style='font-size: 11pt;'></span>";

						button.setAttribute("class","btn btn-default btn-sm btn-block");

						button.setAttribute("type","button");

						button.setAttribute("title","Agregar un comentario");

						button.addEventListener("mouseup",function() { 

							functionHandler("windowHandler","open","window1");

							$("#w1textarea1").val($(this).parent().parent().find("textarea").val());

							$("#w1textarea1").removeAttr("data-id-holder");

							$("#w1textarea1").get(0).dataset.idHolder = this.parentNode.parentNode.getAttribute("data-id");

							functionHandler("badgeCounter",$("#w1textarea1").get(0));

							$("#w1textarea1").focus();

						});

						

						td1.dataset.id = "1";

						td2.dataset.id = "2";

						td3.dataset.id = "3";

						td4.dataset.id = "4";

						

						td2.setAttribute("class","center-text");

						td4.setAttribute("class","center-text");

						

						td1.innerHTML = returnValues_2[x];

						

						if (returnValues_10[x] == "") {

							td4.innerHTML = "N/A";

						} else {

							td4.innerHTML = returnValues_10[x];

						}

						

						var spanContent = 0;

						

						if (parseInt(returnValues_12[x],10) == 1) {

							spanContent = 2;

						} else if (parseInt(returnValues_13,10) == 0) {

							spanContent = 2;

						} else if (!isThereAnyResult) {

							spanContent = 2;

						} else {

							spanContent = 1;

						}

						

						switch (spanContent) {

							case 1:

								

								if (parseInt($("#form1input4").val(),10) == 1) {

									span_1.innerHTML = returnValues_7[x];

								} else if (parseInt($("#form1input4").val(),10) == 2) {

									span_1.innerHTML = returnValues_14[x];

								}

							

							break;

							case 2:

								

								var tempId = functionHandler("uniqId","NULL","NULL","NULL","NULL");

								

								if (parseInt($("#form1input4").val(),10) == 1) {

									var input = document.createElement("input");

										input.setAttribute("style","width: 50px;");

										input.setAttribute("name","form2input_"+(x+1));

										input.id = tempId;



									if (returnValues_7[x] == "") {

										input.value = "";

									} else {

										input.value = returnValues_7[x];

									}

			

									$(input).numericInput({ allowNegative: true, allowFloat: true });

									

									input.addEventListener("keyup",function() { 

										if (this.value == "") {

											$(this).parent().parent().parent().parent().get(0).dataset.edited = "false";

										} else {

											var tempValue = this.value+'';

											this.value = tempValue.replace(",",".");

											$(this).parent().parent().parent().parent().get(0).dataset.edited = "true";

										} 

									});

									input.addEventListener("change",function() { 

										if (this.value == "") {

											$(this).parent().parent().parent().parent().get(0).dataset.edited = "false";

										} else {

											var tempValue = this.value+'';

											this.value = tempValue.replace(",",".");

											$(this).parent().parent().parent().parent().get(0).dataset.edited = "true";

										} 

									});

									

									span_1.appendChild(input);

									

								} else if (parseInt($("#form1input4").val(),10) == 2) {

									var input = document.createElement("select");

										input.setAttribute("style","width: 50px;");

										input.setAttribute("name","form2input_"+(x+1));

										input.id = tempId;

										

									input.addEventListener("change",function() { 

										if (this.value == "null") {

											$(this).parent().parent().parent().parent().get(0).dataset.edited = "false";

										} else {

											$(this).parent().parent().parent().parent().get(0).dataset.edited = "true";

										} 

									});										

										

									span_1.appendChild(input);

								}

							break;

						}

						

						span_2.innerHTML = returnValues_6[x];

						

						td3.appendChild(button);

						

						textArea_1.value = returnValues_8[x];

						

						div.appendChild(span_1);

						div.appendChild(span_2);

						div.appendChild(textArea_1);

						

						td2.appendChild(div);

						

						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td4);

						tr.appendChild(td3);

						

						if (parseInt(returnValues_11[x],10) == 0 || returnValues_11[x] == "") {

							var vitrosInfo = ""

						} else {

							var vitrosInfo = "Generación de VITROS n° "+returnValues_11[x]+" | ";

						}

						

						tr.setAttribute("title",returnValues_2[x]+" | "+returnValues_3[x]+" | "+vitrosInfo+returnValues_4[x]+" | "+returnValues_5[x]+" | "+returnValues_6[x]);

						tr.setAttribute("data-toggle","tooltip");

						tr.setAttribute("data-placement","bottom");

						tr.dataset.id = returnValues_1[x];

						

						tbody.appendChild(tr); 

						

						if (parseInt($("#form1input4").val(),10) == 2) {

							if (parseInt(returnValues_12[x],10) == 1) {

								functionHandler("selectFiller",tempId,"showAnalitCualitativeTypeOfResultForConfiguration&filter="+returnValues_1[x]+"&filterid=id_configuracion"," | ",returnValues_14[x]);

							} else if (parseInt(returnValues_13,10) == 0) {

								functionHandler("selectFiller",tempId,"showAnalitCualitativeTypeOfResultForConfiguration&filter="+returnValues_1[x]+"&filterid=id_configuracion"," | ",returnValues_14[x]);

							} else if (!isThereAnyResult) {

								functionHandler("selectFiller",tempId,"showAnalitCualitativeTypeOfResultForConfiguration&filter="+returnValues_1[x]+"&filterid=id_configuracion"," | ","false");

							}

						}

					}

					

					$("[data-toggle=tooltip]").tooltip();

					

				}

				

			break;

			case "saveAnalitResults":

				var answer = parseInt(response.textContent,10);

				

				if (answer == 0) {

					var boxType = "warning";

					var txt = "Algo ha salido mal, por favor contactese con el administrador del sistema";					

				} else {

					var boxType = "success";

					var txt = "Los resultados se han guardado exitosamente";

					//callsHandler("showAssignedLabAnalit",$("#form1input1").val()+"|"+$("#form1input2").val()+"|"+$("#table1").find("[data-active]").attr("data-id"),"id_array");

					callsHandler("showAssignedRoundSample",$("#form1input3").val()+"|"+$("#form1input2").val()+"|"+$("#form1input1").val(),"id_array","NULL","NULL");

				}

				

				statusBox(boxType,'NULL',txt,'add','NULL');

				

			break;

			case "showLabData":

			

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

				

				if (returnValues_1 != "") {

				

					for (var x = 0; x < returnValues_1.length; x++) {

						

						$("#labDataSpan1").html(returnValues_1[x]);

						$("#labDataSpan2").html(returnValues_2[x]);

						$("#labDataSpan3").html(returnValues_6[x]);

						$("#labDataSpan4").html(returnValues_3[x]);

						$("#labDataSpan5").html(returnValues_4[x]);

						$("#labDataSpan6").html(returnValues_5[x]);

						$("#labDataSpan7").html(returnValues_7[x]);

						$("#labDataSpan8").html(returnValues_8[x]);

						

					}

				}

				

			break;

			case "showAssignedLabAnalitSimple":

			

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

						

						var button2 = document.createElement("button");	

						button2.innerHTML = "<span><b>Ver posibles resultados</b></span>";

						button2.setAttribute("class","btn btn-default btn-block btn-pequeno");

						button2.addEventListener("mouseup",function() { callsHandler("showAnalitConfiguredCualitativeTypeOfResult",this.parentNode.parentNode.getAttribute("data-id"),"id_configuracion","NULL","NULL") });



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



						td1.setAttribute('class','unselectable center-text');

						td2.setAttribute('class','unselectable center-text');

						td3.setAttribute('class','unselectable center-text');

						td4.setAttribute('class','unselectable center-text');

						td5.setAttribute('class','unselectable center-text');

						td6.setAttribute('class','unselectable center-text');

						td7.setAttribute('class','unselectable center-text');

						td8.setAttribute('class','unselectable center-text');

						td9.setAttribute('class','unselectable center-text');

						td10.setAttribute('class','unselectable center-text');

						

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

						if (parseInt(returnValues_10[x],10) == 1) {

							td9.innerHTML = "SI";

							$(td9).addClass("estado_activo");

						} else {

							td9.innerHTML = "NO";

							$(td9).addClass("estado_inactivo");

						}



						td10.appendChild(button2);

						td9.addEventListener("dblclick",function () { table15Editor(this) });





						tr.appendChild(td1);

						tr.appendChild(td2);

						tr.appendChild(td3);

						tr.appendChild(td4);

						tr.appendChild(td5);

						tr.appendChild(td6);

						tr.appendChild(td7);

						tr.appendChild(td8);

						tr.appendChild(td10);

						tr.appendChild(td9);



						tr.dataset.id = returnValues_1[x];



						tbody.appendChild(tr);

					}

				}

				

				$("#table15").find("thead").find("input[data-search-input=true]").keyup();

				

			break;

			case "labAnalitAssignation":



				if(code != 422){ // Si no se realizo una alerta de validacion

					var answer = parseInt(response.textContent,10);

					

					if (answer == 0) {

						var boxType = "warning";

						var txt = "La configuración seleccionada ya existe en la base de datos";					

					} else {

						var boxType = "success";

						var txt = "La configuración se ha ingresado correctamente";

						callsHandler("showAssignedLabAnalitSimple",$("#form1input1").val()+"|"+$("#form1input2").val(),"id_array","NULL","NULL");

						functionHandler('formReset');

					}

					

					statusBox(boxType,'NULL',txt,'add','NULL');	

				}



			break;

			case "assignedLabAnalitDeletion":

			

				var answer = parseInt(response.textContent,10);

				

				if (answer == 0) {

					var txt = "La eliminación no ha sido exitosa.";

					var boxType = "warning";

				} else {

					var boxType = "success";

					var txt = "La configuración se ha eliminado correctamente";

					if ($("#table1").find("[data-active]").get().length > 0) {

						callsHandler("showAssignedLabAnalit",$("#form1input1").val()+"|"+$("#form1input2").val()+"|"+$("#table1").find("[data-active]").attr("data-id"),"id_array");

					}				

					callsHandler("showAssignedLabAnalitSimple",$("#form1input1").val(),"id_laboratorio","NULL","NULL");

				}

				

				statusBox(boxType,'NULL',txt,'add','NULL');			

			

			break;

			case "checkSession":

			

				var answer = parseInt(response.textContent,10);

				

				if (answer == 0) {

					clearInterval(val3);

					var txt = "Su sesión ha caducado, por favor actualice la página";

					var boxType = "warning";

					

					var div = document.createElement("div");

						div.setAttribute("style",

							"opacity:    0.5;"

							+"background: #000;" 

							+"width:      100%;"

							+"height:     100%;"

							+"z-index:    10;"

							+"top:        0;" 

							+"left:       0;" 

							+"position:   fixed"

						);

					

					document.getElementsByTagName("body")[0].appendChild(div);

					statusBox(boxType,'NULL',txt,'add','99999999');	

				}

				

			break;

			case "showAssignedProgramType":

					

				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent;

				

				if (returnValues_1 != "") {



					$("#"+val3).val(returnValues_1);

					$("#"+val3).change();

					

				}

				

			break;			

		}

	}	

}



function callsHandler(val,val2,val3,val4,val5) {

	

	var id = val;

	

	switch (id) {

		case "showAnalitConfiguredCualitativeTypeOfResult":

			

	

			if (typeof(val2) == 'undefined') {

				var values = "header="+id;

			} else {

				var values = "header="+id+"&filter="+val2+"&filterid="+val3;

			}

			

			statusBox('loading','NULL','NULL','add','NULL');

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/index_u_calls_handler.php",

				type:"POST",

				data: values,

				dataType:"xml",

				success: function(xml) { 

					statusBox('loading','NULL','NULL','remove','NULL');

					responseHandler(xml,id,val2,"NULL","NULL");

				}

			}).always(function(dsadsafe){

				console.log(dsadsafe);

			});

			

		break;	

		case "showMaterial":

			

			if (typeof(val2) == 'undefined') {

				var values = "header="+id;

			} else {

				var values = "header="+id+"&filter="+val2+"&filterid="+val3;

			}

			

			statusBox('loading','NULL','NULL','add','NULL');

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/index_u_calls_handler.php",

				type:"POST",

				data: values,

				dataType:"xml",

				success: function(xml) { 

					statusBox('loading','NULL','NULL','remove','NULL');					

					responseHandler(xml,id,"NULL","NULL","NULL");

					

					functionHandler('selectFiller','form6input9','showMaterial'," | ","false");

				}

			})			

			

		break;

		case "showAssignedRoundSample":

			

			if (typeof(val2) == 'undefined') {

				var values = "header="+id;

			} else {

				var values = "header="+id+"&filter="+val2+"&filterid="+val3;

			}

			

			statusBox('loading','NULL','NULL','add','NULL');

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/index_u_calls_handler.php",

				type:"POST",

				data: values,

				dataType:"xml",

				success: function(xml) { 

					statusBox('loading','NULL','NULL','remove','NULL');

					responseHandler(xml,id,"NULL","NULL","NULL");

					$("#table2").find("tbody").html("");

				}

			})			

			

		break;

		case "showAssignedLabAnalit":

			

		statusBox('loading','NULL','NULL','add','NULL');

			var timer_6 = setInterval(function() {

				if ($("#form1input4").val() != "") {

					

					statusBox('loading','NULL','NULL','remove','NULL');

					

					if (typeof(val2) == 'undefined') {

						var values = "header="+id;

					} else {

						var values = "header="+id+"&filter="+val2+"&filterid="+val3;

					}

					

					statusBox('loading','NULL','NULL','add','NULL');

					

					$.ajax({

						contentType: "application/x-www-form-urlencoded",

						url:"php/index_u_calls_handler.php",

						type:"POST",

						data: values,

						dataType:"xml",

						success: function(xml) { 

							statusBox('loading','NULL','NULL','remove','NULL');

							responseHandler(xml,id,"NULL","NULL","NULL");

						}

					});

					clearInterval(timer_6);

				}		

			},100);

			

		break;		

		case "showLabData":

			

			if (typeof(val2) == 'undefined') {

				var values = "header="+id;

			} else {

				var values = "header="+id+"&filter="+val2+"&filterid="+val3;

			}

			

			statusBox('loading','NULL','NULL','add','NULL');

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/index_u_calls_handler.php",

				type:"POST",

				data: values,

				dataType:"xml",

				success: function(xml) { 

					statusBox('loading','NULL','NULL','remove','NULL');

					responseHandler(xml,id,"NULL","NULL","NULL");

				}

			})			

			

		break;

		case "showAssignedLabAnalitSimple":

			

			if (typeof(val2) == 'undefined') {

				var values = "header="+id;

			} else {

				var values = "header="+id+"&filter="+val2+"&filterid="+val3;

			}

				

			statusBox('loading','NULL','NULL','add','NULL');

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/index_u_calls_handler.php",

				type:"POST",

				data: values,

				dataType:"xml",

				success: function(xml) { 

					statusBox('loading','NULL','NULL','remove','NULL');

					responseHandler(xml,id,"NULL","NULL","NULL"); 

				}

			}).always(function(asdsd){

				console.log(values);

				console.log(asdsd);

			})	

			

		break;

		case "checkSession":

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/verifica_estado_sesion.php",

				type:"POST",

				dataType:"xml",

				success: function(xml) { 

					responseHandler(xml,id,val2,"NULL","NULL");

				}

			});	

			

		break;	

		case "showAssignedProgramType":

			

			if (typeof(val2) == 'undefined') {

				var values = "header="+id;

			} else {

				var values = "header="+id+"&filter="+val2+"&filterid="+val3;

			}

			

			statusBox('loading','NULL','NULL','add','NULL');

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/index_u_calls_handler.php",

				type:"POST",

				data: values,

				dataType:"xml",

				success: function(xml) { 

					statusBox('loading','NULL','NULL','remove','NULL');

					responseHandler(xml,id,val4,"NULL","NULL");

				}

			})			

			

		break;			

	}

}

	

function dataChangeHandler(val,val2,val3,val4,val5) {

	var id = val;

	

	switch(id) {



		case "assignedLabAnalitValueEditor":

		

			var node = val3;		



			if (parseInt(node.getAttribute("data-edited")) == 0) {

			

				if (node.type == "text" || node.type == "password" || node.type == "date" || node.type == "number" || node.type == "textarea") {

					var txt = node.value;

				} else {

					var txt = node.options[node.selectedIndex].value;

				}

				

				var nodeId = node.getAttribute("data-id");

				

				var values = "header="+id+"&id="+nodeId+"&value="+txt+"&which="+val2;

				

				node.setAttribute("class","form-control loading");

				node.setAttribute("disabled","disabled");

			

				statusBox('loading','NULL','NULL','add','NULL');

			

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url:"php/index_u_data_change_handler.php",

					type:"POST",

					data: values,

					dataType:"xml",

					success: function(xml) { 

						statusBox('loading','NULL','NULL','remove','NULL');

						responseHandler(xml,id,"NULL","NULL","NULL");

					

 

					}

				}).always(function(asdsfds){

					console.log(asdsfds);

				})

				

				node.dataset.edited = 1;			

				

			}

		

		break;



		case "saveAnalitCualitativeTypeOfResult":

		

				var ids1 = new Array();

				var ids2 = new Array();

				var idSum1 = 0;

				var idSum2 = 0;

				

				var trArray = $("#table250").find("tbody").find("tr").get();

				

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

				

				var values = "header="+id+"&configid="+val2+"&toinsert="+ids1.join("|")+"&todelete="+ids2.join("|");

				

				statusBox('loading','NULL','NULL','add','NULL');

				

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url:"php/index_u_data_change_handler.php",

					type:"POST",

					data: values,

					dataType:"xml",

					success: function(xml) { 

						statusBox('loading','NULL','NULL','remove','NULL');

						responseHandler(xml,id,val2,"NULL","NULL");

					}

				}).always(function(asdsd){

					console.log(asdsd);

				});

		

		break;



		case "saveAnalitResults":

			

			var sampleId = $("#table1").find("[data-active]").attr("data-id");

			

			var idArray = new Array();

			var resultArray = new Array();

			var commentArray = new Array();

			

			if (document.getElementById("tempDateInput")) {

				var tempDate = $("#tempDateInput").val();

			} else {

				var tempDate = 'NULL';

			}

			

			// Antes

			// var trArray = $(val3).find("tbody").find("tr[data-edited=true]").get();



			var trArray = $("");

			var trArrayPrev = $(val3).find("tbody").find("tr");

			for(itterC=0; itterC<trArrayPrev.length; itterC++){ // Iteración para los comentarios encontrados

				

				let trActual = trArrayPrev.eq(itterC);

				let dataEdited = trActual.data("edited");

				let inputsInternos = trActual.find("input").add(trActual.find("select"));

				let textareaComentario = trActual.find("textarea").eq(0);



				if(

					dataEdited == true ||

					(

						inputsInternos.length > 0 &&

						textareaComentario.val() != "" &&

						textareaComentario.prop("comentario-modificado") == "true"

					)

				){

					trArray = trArray.add(trActual);

				}



			}



			trArray = trArray.get();



			for (x = 0; x < trArray.length; x++) {

				idArray[x] = trArray[x].getAttribute("data-id");

				if (parseInt($("#form1input4").val(),10) == 1) {

					resultArray[x] = trArray[x].getElementsByTagName("input")[0].value;

				} else if (parseInt($("#form1input4").val(),10) == 2) {

					resultArray[x] = trArray[x].getElementsByTagName("select")[0].value;

				}

				commentArray[x] = trArray[x].getElementsByTagName("textarea")[0].value;

			}

			

			idArray = idArray.join("|");

			resultArray = resultArray.join("|");

			commentArray = commentArray.join("|");

			
			// console.log(idArray);

			if (idArray.length == 0) {

				statusBox("info","NULL","No se ha detectado ningún item","ADD","3000");

			} else {

				var values = "header="+id+"&typeofprogram="+$("#form1input4").val()+"&sampleid="+sampleId+"&ids="+idArray+"&resuts="+resultArray+"&comments="+commentArray+"&tempDate="+tempDate;

				

				statusBox('loading','NULL','NULL','add','NULL');

				

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url:"php/index_u_data_change_handler.php",

					type:"POST",

					data: values,

					dataType:"xml",

					success: function(xml) { 

						statusBox('loading','NULL','NULL','remove','NULL');

						responseHandler(xml,id,"NULL","NULL","NULL");

	

					}

				});					

			}

		

		break;

		case "labAnalitAssignation":

		

			if (functionHandler('inputChecker',val3)) {

				

				if ($("#form6input8").attr("disabled") == "disabled") {

					$("#form6input8").removeAttr("disabled");

					$('#form6input8').button("enable");

					var values = "header="+id+"&labid="+$("#form1input1").val()+"&programid="+$("#form1input2").val()+"&"+$(val3).serialize();					

					$("#form6input8").attr("disabled","disabled");

					$('#form6input8').button("disable");

				} else {

					var values = "header="+id+"&labid="+$("#form1input1").val()+"&programid="+$("#form1input2").val()+"&"+$(val3).serialize();

				}				

				

				

				

				statusBox('loading','NULL','NULL','add','NULL');

				

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url:"php/index_u_data_change_handler.php",

					type:"POST",

					data: values,

					dataType:"xml",

					success: function(xml) { 

						statusBox('loading','NULL','NULL','remove','NULL');

						responseHandler(xml,id,"NULL","NULL","NULL");

					}

				});

			}

		

		break;

		case "assignedLabAnalitDeletion":

		

			var question = confirm("¿Está seguro que desea eliminar la configuración?\n\nTodos los resultados que se reportaron con esta configuración también serán eliminados.\n\n¿Está seguro que desea continuar?");

			if (question) {

				var values = "header="+id+"&ids="+val2;

				

				statusBox('loading','NULL','NULL','add','NULL');

				

				$.ajax({

					contentType: "application/x-www-form-urlencoded",

					url:"php/index_u_data_change_handler.php",

					type:"POST",

					data: values,

					dataType:"xml",

					success: function(xml) { 

						statusBox('loading','NULL','NULL','remove','NULL');

						responseHandler(xml,id,"NULL","NULL","NULL");

					

 

					}

				});

			}	

		

		break;			

	}

}



function functionHandler(val,val2,val3,val4,val5) {

	var id = val;

	

	switch(id) {

		case "tableSearch":

			var $rows = $(val2).parent().parent().parent().next().find("tr");

			var val = $.trim($(val2).val()).replace(/ +/g, ' ').toLowerCase();

			$rows.show().filter(function() {

				var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();

				return !~text.indexOf(val);

			}).hide();		

		break;

		case "matchPassword":

			var v1 = val2.val();

			var v2 = val3.val();



			if (v1 == "" || v2 == "") {

				var match = false;

				$(val4).attr("class"," form-group");

				$(val5).attr("class"," form-group");	

				

			} else if (v1 == v2) {

				var match = true;

				$(val4).attr("class"," form-group has-success");

				$(val5).attr("class"," form-group has-success");			

				

			} else {

				var match = false;

				$(val4).attr("class"," form-group has-error");

				$(val5).attr("class"," form-group has-error");

				

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

				statusBox("warning","NULL","Por favor complete todos los campos","add","NULL");

				var answer = false;

			} else {

				var answer = true;

			}

			

			return answer;			

		break;

		case 'panelChooser':

			

			$(val2).parent().find("li").removeClass("active-tab");

			

			var id = val2.getAttribute("data-id");

			

			$("[data-id="+val3+"]").attr("hidden","hidden");

			$("#"+id).removeAttr("hidden");

			

			$(val2).addClass("active-tab");

			

		break;

		case 'badgeCounter':

			var a = val2.value.split("").length;

			var b = val2;

			var c = next(b);

				c.value = a;

				d = next(c);

				d.innerHTML = a+" / 150";

			

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

		

			id = "#"+val2;

			

			var status = $(id).attr("hidden");

			

			if (status == "hidden") {

				$(id).removeAttr("hidden");

				$(id).get(0).dataset.active = 1;

			} else {

				$(id).attr("hidden","hidden");

				$(id).get(0).dataset.active = 0;

			}		

		

		break;

		case 'formReset':

			$('[data-form-reset=true]').val("");

		break;

		case 'selectFiller':

		

			var select = $("#"+val2).get(0);

				select.innerHTML = "";

				select.value = "";

				select.removeAttribute("data-active");

				select.dataset.active = "false";

			

			var values = "header="+val3;

			statusBox('loading','NULL','NULL','add','NULL');

			

			$.ajax({

				contentType: "application/x-www-form-urlencoded",

				url:"php/index_u_calls_handler.php",

				type:"POST",

				data: values,

				dataType:"xml",

				success: function(xml) {

					statusBox('loading','NULL','NULL','remove','NULL');

					

					var response = xml.getElementsByTagName("response")[0];

					var code = parseInt(response.getAttribute("code"),10);

					

					if (code == 0) {

						errorHandler(response.textContent);

					} else {

						

						var idArray = new Array();

						var contentArray = new Array();

						

						for (var x = 0; x < response.childNodes.length; x++) {

							

							var tempArray = response.childNodes[x].textContent.split("|");

							var omit = parseInt(response.childNodes[x].getAttribute("selectomit"),10);

							var content = response.childNodes[x].getAttribute("content");

							

							for (var y = 0; y < tempArray.length; y++) {

								if (isNaN(omit) && content == "id") {

									idArray[y] = tempArray[y];

								} else {

									if (isNaN(omit)) {

										if (typeof(contentArray[y]) == 'undefined') {

											contentArray[y] = tempArray[y];

										} else {

											contentArray[y] = contentArray[y]+val4+tempArray[y];

										}										

									}

									

								}

								

							}

							

						}

			

						if (typeof(val5) != "undefined" && val4 != "NULL" && val4 != "null" && val4 != "false" && val4 != "") {

							var txt = new RegExp(val5.replace(/[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, "\\$&"),"g");	

						} else {

							var txt = "null";

						}					

						

						if (idArray != "") {

							for (x = 0; x < idArray.length; x++) {

								var option = document.createElement("option");

									option.setAttribute("value",idArray[x]);

									option.innerHTML = contentArray[x];

									

								if (txt != "null") {

									if (txt.test(option.innerHTML)) {

										option.setAttribute("selected","selected");

									}	

								}



								select.appendChild(option);

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

			var item1 = parseInt(val2,10);

			var item2 = parseInt(val3,10);

			

			if (isNaN(item1)) {

				item1 = 0;

			}

			if (isNaN(item2)) {

				item2 = 0;

			}

			

			var result = Math.floor((item2 / item1)*100);

			

			if (isNaN(result) || !isFinite(result)) {

				result = 0;

			}

			

			return result;

			

		break;

		case 'highLightItem':

					

			$(val2).parent().children().removeClass("active-tab");

			$(val2).parent().children().removeAttr("data-active");

			

			$(val2).addClass("active-tab");

			$(val2).get(0).dataset.active = "true";

			

		break;

		case 'windowHandler':

		

			var item = val3;			

		

			switch(val2.toLowerCase()) {

				case 'open':

					$("#"+item).removeAttr("hidden");				

				break;

				case 'close':

					$("#"+item).attr("hidden","hidden");

				break;

			}



		break;

		case 'addAnalitResultComment':

			

			var txt = $("#"+val2).val();

			var id = $("#"+val2).attr("data-id-holder");

			

			$("#"+val3).find("tbody").find("[data-id="+id+"]").find("textarea").val(txt);

			$("#"+val3).find("tbody").find("[data-id="+id+"]").find("textarea").prop("comentario-modificado","true");

			

			$("#"+val2).val("");

			functionHandler("windowHandler","close",val4);

			

		break;

		case "uniqId":



			// +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)

			// +    revised by: Kankrelune (http://www.webfaktory.info/)

			// %        note 1: Uses an internal counter (in php_js global) to avoid collision

			// *     example 1: uniqid();

			// *     returns 1: 'a30285b160c14'

			// *     example 2: uniqid('foo');

			// *     returns 2: 'fooa30285b1cd361'

			// *     example 3: uniqid('bar', true);

			// *     returns 3: 'bara20285b23dfd1.31879087'

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

			alert('JS functionHandler error: id "'+id+'" not found');

		break;		

	}	

}





function table15Editor(val) { // Edicion de configuracion de mensurando de laboratorio

	

	var td = val;

	var backupvalue = val.innerHTML;

	

	tdId = parseInt(td.getAttribute("data-id"),10);

			

	switch (tdId) {	

		case 9:

		

			var input = document.createElement("select");

			var txt = new RegExp(val.innerHTML,"g");			

			

			input.setAttribute("class","form-control unselectedInput");

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

							option.setAttribute("selected","selected");

						}										

					

						input.appendChild(option);

					}

				}					



			

			var id = td.parentNode.getAttribute("data-id");

			input.dataset.id = id;

			input.dataset.edited = 0;			

			

			$(input).bind("change",function() {

				setTimeout(function(){

					dataChangeHandler("assignedLabAnalitValueEditor",tdId,input,"NULL","NULL");

				},2);

			});

			$(input).keyup(function(event) {

				

				if (event.keyCode == 13) {

					setTimeout(function(){

						dataChangeHandler("assignedLabAnalitValueEditor",tdId,input,"NULL","NULL");

					},2);

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



function errorHandler(val) {

	alert(val);

}