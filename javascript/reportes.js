function initialize() {
    $(function(){

        $("#form1input1").bind("change",function(event) {
            functionHandler("selectFiller","form1input2","showAssignedLabProgramGeneral&filter="+this.value+"&filterid=id_laboratorio"," | ","false");
            statusBox('loading','NULL','NULL','add','NULL');
        });
        
        $("#form1input2").bind("change",function(event) {
            functionHandler("selectFiller","form1input3","showAssignedCiclosProgram&filter=" + this.value + "|" + $("#form1input1").val() + "&filterid=programa_laboratorio"," | ","false");
            statusBox('loading','NULL','NULL','add','NULL');
        });

        $("#form1input1").change();
        
        $("#form1input3").change(function(event) {
            callsHandler("showDocuments",$("#form1input1").val()+"|"+$("#form1input3").val(),"id_array","NULL","NULL");
        });


        var timer_1 = setInterval(function(){
		
            $.ajax({
                contentType: "application/x-www-form-urlencoded",
                url:"php/verifica_estado_sesion.php",
                type:"POST",
                dataType:"xml",
                success: function(xml) { 
                    var answer = parseInt(xml.getElementsByTagName("response")[0].textContent,10);
                    
                    if (answer == 0) {
                        clearInterval(timer_1);
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
                }
            });	
        },5000);
    });

   $("#table8btn1").bind("click",function() {
		
    var tableId = $(this).attr("data-parent");
    var trArray = $("#"+tableId).find("tbody").find("tr").get();
    var idArray = new Array();
    var counter = 0;
    
    for (x = 0; x < trArray.length; x++) {
        if ($(trArray[x]).find("input[type=checkbox]").get(0).checked) {
            idArray[counter] = $(trArray[x]).attr("data-id");
            counter++;
        }
    }
    
    if (idArray.length > 0) {
        functionHandler("viewDocument",idArray.join("|"),"downloadMultiple");
    }
    
});
}

function responseHandler(val,val2,val3,val4,val5) {
	
	var response = val.getElementsByTagName("response")[0];
	
	var code = parseInt(response.getAttribute("code"),10);
	
	if (code == 0) {
		errorHandler(response.textContent);
	} else {
		switch (val2) {
			case "showDocuments":
			
				var tbody = $("#table8").find("tbody").get(0);
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
						button.setAttribute("class","btn btn-default btn-sm btn-block");
						button.setAttribute("title","Ver");
						button.addEventListener("click",function() { functionHandler("viewDocument",$(this).parents("tr").attr("data-id"),"view"); });				
						
						button2.innerHTML = "<span class='glyphicon glyphicon-save-file'></span>";
						button2.setAttribute("class","btn btn-default btn-sm btn-block");
						button2.setAttribute("title","Descargar");
						button2.addEventListener("click",function() { functionHandler("viewDocument",$(this).parents("tr").attr("data-id"),"download"); });						
								
						var td1 = document.createElement("td");
						var td2 = document.createElement("td");
						var td3 = document.createElement("td");
						var td4 = document.createElement("td");
						var td5 = document.createElement("td");
						var td6 = document.createElement("td");
						var td7 = document.createElement("td");
						var td8 = document.createElement("td");
						
                        td1.setAttribute('class','unselectable center-text');
                        td2.setAttribute('class','unselectable center-text');
                        td3.setAttribute('class','unselectable center-text');
                        td4.setAttribute('class','unselectable center-text');
                        td5.setAttribute('class','unselectable center-text');
                        td6.setAttribute('class','unselectable center-text');
                        td7.setAttribute('class','unselectable center-text');
                        td8.setAttribute('class','unselectable center-text');
						
						input.setAttribute("type","checkbox");
						
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
						td2.innerHTML = "<img src='"+functionHandler("iconChoser",returnValues_3[x])+"' alt='document icon' width='28' height='28'></img><span style='margin-left: 1%;' data-text='"+returnValues_2[x]+"' data-id='2'>"+returnValues_2[x]+"</span>";
						td3.innerHTML = returnValues_4[x];
						
						td5.innerHTML = returnValues_6[x];
						
						td6.appendChild(button);
						td7.appendChild(button2);
						
						tr.appendChild(td1);
						tr.appendChild(td2);
						tr.appendChild(td5);
						tr.appendChild(td6);
						tr.appendChild(td7);
						
						tr.dataset.id = returnValues_1[x];

						tbody.appendChild(tr);
					}
				}
				
				$("#table8").find("thead").find("input[data-search-input=true]").keyup();
				
			break;			
		}
	}	
}

function callsHandler(val,val2,val3,val4,val5) {
	
	var id = val;
	
	switch (id) {
		case "showDocuments":

			if (val4 == "uploadResponse") {
				var timer = '5000';
			} else {
				var timer = 0;
			}

			if (typeof(val2) == 'undefined') {
				var values = "header="+id;
			} else {
				var values = "header="+id+"&filter="+val2+"&filterid="+val3;
			}

			statusBox('loading','NULL','NULL','add','NULL');			
			
			setTimeout(function() {
				$.ajax({
					contentType: "application/x-www-form-urlencoded",
					url:"php/reportes_calls_handler.php",
					type:"POST",
					data: values,
					dataType:"xml",
					success: function(xml) { 
						statusBox('loading','NULL','NULL','remove','NULL');
						responseHandler(xml,"showDocuments","NULL","NULL","NULL");  
					}
				}).always(function(asdsfds){
                });				
			},timer);		
		
		break;	
	}
}
	
function dataChangeHandler(val,val2,val3,val4,val5) {
	var id = val;
	
	switch(id) {
		case "documentRegistry":
			
			var maxFileSize = 104857600;
			var fileInput = $("#form9input3")[0];
			
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
					errorTxt = errorTxt + "No ha seleccionado ningún archivo.<br/>";
					error = true;
				} else {
					for (var x = 0; x < max; x++) {
						var fsize = fileInput.files[x].size;
						var ftype = fileInput.files[x].type;
						
						if (functionHandler("mimeChecker",ftype)) {
							errorTxt = errorTxt + "No es posible cargar este tipo de archivo para '"+fileInput.files[x].name+"'.<br/>";
							error = true;
						}
			
						if (fsize > maxFileSize) {
							errorTxt = errorTxt + "El tamaño del archivo es demasiado grande para '"+fileInput.files[x].name+"'. El tamañaximo permitido es 100 MB.<br/>";
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
	
				statusBox(boxType,'NULL',errorTxt,"add",'5000');
					
			} else {
				
				var errorTxtCounter = new Array();
				
				var loadingBars = 	"<span>Cargando archivos...</span>"
									+"<br/>"
									+"<div class='progress'>"
										+"<div class='progress-bar' role='progressbar' data-id='progressbar1'></div>"
									+"</div>"
									+"<div class='progress'>"
										+"<div class='progress-bar' role='progressbar' data-id='progressbar2'></div>"
									+"</div>";
				
				statusBox("loading",'NULL',loadingBars,"add",'null');				
				
				for (x = 0; x < max; x++) {
					
					var data = new FormData();
					
					data.append('header',id);
					data.append('documentfiles',fileInput.files[x],fileInput.files[x].name);
					data.append('clientid',$("#form9input1").val());
					data.append('clienthqid',$("#form9input2").val());
					data.append('fileassignedmonth',$("#form9input4").val());
					data.append('fileassignedyear',$("#form9input5").val());
					data.append('item',(x + 1));
					
					$.ajax({
						url: 'php/reportes_data_change_handler.php',
						type: 'POST',
						xhr: function() {

							var xhr = $.ajaxSettings.xhr();
							if(xhr.upload){
								xhr.upload.onprogress = updateProgress1;
							}
							
							return xhr;
							
						},						
						data: data,						
						cache: false,
						dataType: 'xml',
						processData: false,
						contentType: false,
						success: function(xml) {
							
							if (parseInt(xml.getElementsByTagName("response")[0].getAttribute("code"),10) == 0) {
								errorTxtCounter[errorCounter] = xml.getElementsByTagName("response")[0].textContent;
								errorCounter++;
							}
						}
					});
				}
				
				function updateProgress1(e) {
				
					if(e.lengthComputable) {
						var innerMax = e.total;
						var current = e.loaded;
				
						var percentage = Math.floor((current * 100) / innerMax);
							
						$("[data-id=progressbar1]").attr("style","width: "+percentage+"%");
						$("[data-id=progressbar1]").html(percentage+"%");
				
						if (percentage >= 100) {
							
							itemCounter++;
							
							$("#form9table1").find("tbody").find("[data-item="+itemCounter+"]").remove();
							
							var fileProgress = Math.round((itemCounter * 100) / max);
							
							$("[data-id=progressbar2]").attr("style","width: "+fileProgress+"%");
							$("[data-id=progressbar2]").html(fileProgress+"%");			
							
							if (itemCounter == max) {
								
								setTimeout(function () {
									
									if (errorCounter > 0) {
										alert("Se han encontrado los siguientes errores durante la carga:\n\n"+errorTxtCounter.join("\n"));
										var boxType = "warning";
										var txt = "Carga completa con errores";
									} else {
										var boxType = "success";
										var txt = "Carga completa";
									}

									callsHandler("showDocuments",$("#form9input2").val()+"|"+$("#form9input5").val(),"id_array","uploadResponse","NULL");
									statusBox(boxType,'NULL',txt,'add','NULL');
									
								},1000);
								
								$("#form9table1").find("tbody").html("");
								functionHandler("fieldReset","form9input3");
								statusBox('loading','NULL','NULL','remove','NULL');									
							
							}	
						}							
					}
				}
			}		
		
		break;	
	}
}

function functionHandler(val,val2,val3,val4,val5,val6) {
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
		case "inputChecker":
			var sum = 0;
			var inputTextArray = val2.getElementsByTagName("input");
		
			for (var x = 0; x < inputTextArray.length; x++) {
				
				switch (inputTextArray[x].type) {
					case "text":
						if (inputTextArray[x].value == "") {
							if ($(inputTextArray[x]).attr("data-required") != "false") { 
								sum++;
							}
						}
					break;
					case "password":
						if (inputTextArray[x].value == "") {
							if ($(inputTextArray[x]).attr("data-required") != "false") { 
								sum++;
							}
						}
					break;
					case "date":
						if (inputTextArray[x].value == "") {
							if ($(inputTextArray[x]).attr("data-required") != "false") { 
								sum++;
							}
						}
					break;
					case "number":
						if (inputTextArray[x].value == "") {
							if ($(inputTextArray[x]).attr("data-required") != "false") { 
								sum++;
							}
						}
					break;
					case "time":
						if (inputTextArray[x].value == "") {
							if ($(inputTextArray[x]).attr("data-required") != "false") { 
								sum++;
							}
						}
					break;
				}
			}	
			
			if (sum > 0) {
				alert("Por favor complete todos los campos");
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
		case 'badgerCounter':
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
			
			$("#"+val2).toggle("fast",function(){
				this.focus();
			});
		
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
				url:"php/reportes_calls_handler.php",
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
							
							if (val5.toLowerCase() == 'false') {
								var omit = parseInt(response.childNodes[x].getAttribute("selectomit"),10);
							} else {
								var omit = 'NULL';
							}
							
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
						
						if (idArray != "") {
							for (x = 0; x < idArray.length; x++) {
								var option = document.createElement("option");
									option.setAttribute("value",idArray[x]);
									option.innerHTML = contentArray[x];
									
									select.appendChild(option);
							}
						}
						
                        select.dataset.active = "true";
                        $(select).change();
						
					}
				}
			}).always(function(asdsad){
            });

		break;
		case "dateDiff":
		
			var date1 = "0"+val2+"/01/2000 "+val3+":00";
			var date2 = "0"+val4+"/01/2000 "+val5+":00";
			
			var ms = moment(date2,"DD/MM/YYYY HH:mm:ss").diff(moment(date1,"DD/MM/YYYY HH:mm:ss"));
			var d = moment.duration(ms);
			if (val6) {
				var s = Math.floor(d.asHours() - 1) + moment.utc(ms).format(":mm:ss");
			} else {
				var s = Math.floor(d.asHours()) + moment.utc(ms).format(":mm:ss");
			}
			
			return s;

		break;
		case "hoursAdder":
		
			if (val2 == "") {
				val2 = "00:00:00";
			}
			
			if (val3 == "") {
				val3 = "00:00:00";
			}
			
			var actualTime = val3.split(":");
			var totalHours = val2.split(":");
			
			var h1h = parseInt(totalHours[0]);
			var h2h = parseInt(actualTime[0]);
			
			var h1m = ((h1h * 60) / 1);
			var h2m = ((h2h * 60) / 1);
			
			var hsubs = (h1m + h2m);
			
			var hours = ((hsubs / 60) * 1);
			
			var m1m = parseInt(totalHours[1]);
			var m2m = parseInt(actualTime[1]);
			
			var msubs = (m1m + m2m);
			
			if (msubs > 60) {
				hours++;
				msubs = (msubs - 60);
			} else if(msubs == 60) {
				hours++;
				msubs = "00";
			} else if (msubs < 0) {
				hours--;
				msubs = (msubs + 60);
			} else if (msubs == 0) {
				msubs = "00";
			}
		
			if ((msubs < 10) && (msubs != "00")) {
				msubs = "0" + msubs;
			}	
			
			var minutes = msubs;
			
			var TT = hours + ":" + minutes + ":00";
			
			return TT;		
		
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
					
					input.setAttribute("class","form-control unselectedInput");
					
					if (txt == "**********") {
						input.value = "";
					} else {
						input.value = txt;
					}
					
					input.dataset.id = id;
					input.setAttribute("type",fieldName);
					input.dataset.edited = 0;
					
					$(input).bind("blur",function() {
						setTimeout(function(){
							dataChangeHandler(val5,tdId,input,"NULL","NULL"); 
						},2);
					});					
					
					$(input).keyup(function(event) {
						
						if (event.keyCode == 13) {
							setTimeout(function(){
								dataChangeHandler(val5,tdId,input,"NULL","NULL"); 
							},1);
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
					
					select.setAttribute("class","form-control unselectedInput");
					select.dataset.id = id;
					select.dataset.edited = 0;			
					select.id = uniqId;
					
					$(select).bind("blur",function() { 
						setTimeout(function(){
							dataChangeHandler(val5,tdId,select,"NULL","NULL"); 
						},2);
					});						
					
					$(select).keyup(function(event) {
						
						if (event.keyCode == 13) {
							setTimeout(function(){
								dataChangeHandler(val5,tdId,select,"NULL","NULL"); 
							},1);
						} else if (event.keyCode == 27) {
							$(select).off("blur");
							$(select).remove();
							td.innerHTML = txt;
						}
					});			
					
					td.innerHTML = "";
					td.appendChild(select);
					select.focus();
				
					functionHandler('selectFiller',uniqId,val6," | ","false");
					
					statusBox('loading','NULL','NULL','add','NULL');
					var timer_1 = setInterval(function() {
						if ($("#"+uniqId).attr("data-active") == "true") {
							statusBox('loading','NULL','NULL','remove','NULL');
							clearInterval(timer_1);
							
							var optionArray = $("#"+uniqId).find("option").get();
							
							var regExpTxt = new RegExp(txt,"g");
							
							for (x = 0; x < optionArray.length; x++) {
								if (regExpTxt.test(optionArray[x].innerHTML)) {
									optionArray[x].setAttribute("selected","selected");
								}
							}						
						}
					},100);
				break;		
			}		
		
		break;
		case "fieldReset":
			
			var field = $("#"+val2).get(0);
			
			switch (field.tagName) {
				case "INPUT":
				case "TEXTAREA":
					field.value = "";
				break;
				case "SELECT":
					$(field).children().removeAttr("selected");
					$(field).find("option:nth-child(1)").attr("selected","selected");
				break;
			}
			
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
		case "showSearchForm":
			
			var tempSpan = document.createElement("span");
			$("#searchFormTitle").html(val3);
			
			switch (val2) {
				case "afiliado_serologia":
				case "analisis":
				case "cada":
				case "comparativo":
				case "reporte_afiliados":
				case "siget":
				case "multisiget":
				case "unity":
				case "uroanalisis":
					tempSpan.dataset.id = "form2";
					functionHandler('panelChooser',tempSpan, 'searchForm');
					
					$("#form1input3_container").show();
					$("#searchFormDocumentType1_container").show();
					$("#searchFormDocumentType2_container").show();

					$("#searchFormDownload,#searchFormView").bind("click",function(){
						
						$("#fileFrame").attr(
							"src",
							"busca_archivo.php?"
							+"action="+$(this).attr("data-action")+"&"
							+"searchvalues="
							+$("#form1input4").val()+"|"
							+$("#form1input3").val()+"|"
							+$("#form2input1").val()+"|"
							+$("#form2input2").val()+"|"
							+$('input[name=documentfiletype]:checked','#form5').val()
						);
						
					});
					
				break;
				case "documentos_compartidos":
					tempSpan.dataset.id = "form2";
					functionHandler('panelChooser',tempSpan, 'searchForm');
					
					$("#form1input3_container").hide();
					$("#searchFormDocumentType1_container").hide();
					$("#searchFormDocumentType2_container").hide();					
					
					$("#searchFormView").bind("click",function(){
						
						$("#fileFrame").attr(
							"src",
							"listado_documento.php?"
							+"action="+$(this).attr("data-action")+"&"
							+"searchvalues="
							+$("#form1input2").val()+"|"
							+$("#form2input1").val()+"|"
							+$("#form2input2").val()
						);
						
					});
					$("#searchFormDownload").bind("click",function(){
						
						$("#fileFrame").attr(
							"src",
							"listado_documento.php?"
							+"action="+$(this).attr("data-action")+"&"
							+"searchvalues="
							+$("#form1input2").val()+"|"
							+$("#form2input1").val()+"|"
							+$("#form2input2").val()
						);
						
					});						
				break;	
				case "eqas":
					tempSpan.dataset.id = "form3";
					functionHandler('panelChooser',tempSpan, 'searchForm');
					
					$("#form1input3_container").show();
					$("#searchFormDocumentType1_container").show();
					$("#searchFormDocumentType2_container").show();					
					
					$("#searchFormDownload,#searchFormView").bind("click",function(){
						
						$("#fileFrame").attr(
							"src",
							"busca_archivo.php?"
							+"action="+$(this).attr("data-action")+"&"
							+"searchvalues="
							+$("#form1input4").val()+"|"
							+$("#form1input3").val()+"|"
							+$("#form3input1").val()+"|"
							+$("#form3input2").val()+"|"
							+$("#form3input3").val()+"|"
							+$("#form3input4").val()+"|"
							+$('input[name=documentfiletype]:checked','#form5').val()
						);
						
					});					
					
				break;
				case "qap":
				case "qap_anterior":
					tempSpan.dataset.id = "form4";
					functionHandler('panelChooser',tempSpan, 'searchForm');
					
					$("#form1input3_container").show();
					$("#searchFormDocumentType1_container").show();
					$("#searchFormDocumentType2_container").show();					
					
					$("#searchFormDownload,#searchFormView").bind("click",function(){
						
						$("#fileFrame").attr(
							"src",
							"busca_archivo.php?"
							+"action="+$(this).attr("data-action")+"&"
							+"searchvalues="
							+$("#form1input4").val()+"|"
							+$("#form1input3").val()+"|"
							+$("#form4input1").val()+"|"
							+$("#form4input2").val()+"|"
							+$("#form4input3").val()+"|"
							+$('input[name=documentfiletype]:checked','#form5').val()

						);
						
					});						
					
				break;
				
			}
		break;
		case "mimeChecker":
			switch(val2) {
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
			
				if      (bytes>=1073741824) {bytes=(bytes/1073741824).toFixed(2)+' GB';}
				else if (bytes>=1048576)    {bytes=(bytes/1048576).toFixed(2)+' MB';}
				else if (bytes>=1024)       {bytes=(bytes/1024).toFixed(2)+' KB';}
				else if (bytes>1)           {bytes=bytes+' bytes';}
				else if (bytes==1)          {bytes=bytes+' byte';}
				else                        {bytes='0 byte';}
				return bytes;
				
		break;
		case "checkAll":
			
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
		case "showTempFiles":
			
			var files = val2.files;
			var tbody = val3;
				tbody.innerHTML = "";
			
			for (var x = 0; x < files.length; x++) {
				
				var tr = document.createElement("tr");
				
				var td0 = document.createElement("td");
				var td1 = document.createElement("td");
				var td2 = document.createElement("td");
					
					td1.setAttribute("style","font-weight:bold;");
					td2.setAttribute("style","text-align:center;");					
					
				td0.innerHTML = (x + 1);
				td1.innerHTML = "<img src='"+functionHandler("iconChoser",files[x].name.split(".")[1])+"' alt='document icon' width='28' height='28'></img><span style='margin-left: 1%;'>"+files[x].name.split(".")[0]+"."+files[x].name.split(".")[1]+"</span>";
				td2.innerHTML = functionHandler("formatSizeUnits",files[x].size);
				
				tr.appendChild(td0);
				tr.appendChild(td1);
				tr.appendChild(td2);
				
				tr.dataset.item = (x + 1);
				
				tbody.appendChild(tr);
				
			}
		
		break;
		case "viewDocument":
			
			switch (val3) {
				case "view":
					window.open('visor_documento.php?id='+val2+"&action="+val3,'PDF viewer','height=640,width=768');
				break;
				case "download":
					window.location.href = 'visor_documento.php?id='+val2+"&action="+val3;
				break;
				case "downloadMultiple":
					
					idArray = val2.split("|");
					counter = 0;
					
					var intervalCicle = setInterval(function(){
						
						if (counter < idArray.length) {
							window.open('visor_documento.php?id='+idArray[counter]+"&action="+val3,'_blank');
							counter++;
						} else {
							clearInterval(intervalCicle);
						}
						
					},1);
					
				break;
				default:
					//
				break;
			}
			
		
		break;		
	}	
}

function errorHandler(val) {
	alert(val);
}