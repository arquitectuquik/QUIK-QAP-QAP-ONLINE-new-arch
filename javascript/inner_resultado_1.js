function initialize() {
	
	$("#workbookBtn1").bind("mouseup",function(event) {
		dataChangeHandler("saveTempPdf",document.getElementById("workbook").innerHTML.replace(/\&/g,"amp;").replace(/\+/g,"plus"));
		event.preventDefault();
	});
	$("#workbookBtn3").bind("mouseup",function(event) {
		functionHandler('windowHandler','open','window2');
		event.preventDefault();
	});
	$("#workbook").find("div[data-sheet=true]").bind("dblclick",function(event) {
		functionHandler('windowHandler','open','window1');
		$("#w1p").attr("data-id-holder",this.id);
		
		tempWidth = this.title.split("|")[0];
		tempHeight = this.title.split("|")[1];
		
		$("#w1pinput1").val(tempWidth);
		$("#w1pinput2").val(tempHeight);
		
		event.preventDefault();
	});
	$("#w1pinput1").bind("keyup",function(event){
		$("#"+$("#w1p").attr("data-id-holder")).attr("title",$("#w1pinput1").val()+"|"+$("#w1pinput2").val());
		event.preventDefault();
	});
	$("#w1pinput2").bind("keyup",function(event){
		$("#"+$("#w1p").attr("data-id-holder")).attr("title",$("#w1pinput1").val()+"|"+$("#w1pinput2").val());
		event.preventDefault();
	});	

	//callsHandler("generateChartImages","chart1");
	callsHandler("generateChartImages","chart2");
	//callsHandler("generateChartImages","chart3");
	callsHandler("generateChartImages","chart4");
	callsHandler("generateChartImages","chart5");
	callsHandler("generateChartImages","chart6");
	callsHandler("generateChartImages","chart7");
	callsHandler("generateChartImages","chart8");
	callsHandler("generateChartImages","chart9");
	
	var tempCounter = 0;
	var errorCounter = 0;
	var errorItems = new Array();
	
	statusBox('loading','NULL','NULL','add','NULL');
	
	imageArraySize = $(document).find("img[data-chart-frame='1']").get().length;
	
	var timer_2 = setInterval(function(){
		
		var imageArray = $(document).find("img[data-chart-frame='1']:not([data-loaded=1])").get();
		var autoPdf = parseInt($("#autoPdfValue").val(),10);
		
		for (x = 0; x < imageArray.length; x++) {
			
			$(imageArray[x]).attr('src',$(imageArray[x]).attr('data-src'));
			
			if (functionHandler("imageChecker",imageArray[x])) {
				imageArray[x].dataset.loaded = 1;
				tempCounter++;
			}	
		}	
		
		if (tempCounter == imageArraySize) {
			clearInterval(timer_2);
			statusBox('loading','NULL','NULL','remove','NULL');
			$("#workbook").css("overflow", "auto");
			$("#workbookBtn1").removeAttr("disabled");
			$("#workbookBtn1").removeClass("disabled");
			
			$("#workbook").find("span[data-chart-container=1]").remove();
			$("#workbook").find("span[data-chart-container=2]").remove();
			$("#workbook").find("span[data-chart-container=3]").remove();
			$("#workbook").find("span[data-chart-container=4]").remove();
			$("#workbook").find("span[data-chart-container=5]").remove();
			$("#workbook").find("span[data-chart-container=6]").remove();
			
			if (autoPdf == 1) {
				dataChangeHandler("saveTempPdf",document.getElementById("workbook").innerHTML.replace(/\&/g,"amp;"));
			}
		} else {
			if (errorCounter > (imageArraySize * 20)) {
				clearInterval(timer_2);
				statusBox('loading','NULL','NULL','remove','NULL');
				statusBox('warning','NULL','Una o varias de las gráficas no se han generado correctamente, recargando...','add','9999999');
				setTimeout(function(){
					location.reload();
					return false;
				},4000);					
			}
		}
		
		errorCounter++;
		
	},1000);
	
	var totalPages = $(document).find("div [data-sheet=true]").get();
	var pageSpan = $(document).find("[data-page-counter=true]").get();
	$(document).find("[data-total-pages=true]").html(totalPages.length);
	
	for (x = 0; x < pageSpan.length; x++) {
		pageSpan[x].innerHTML = (x + 1);
	}
	
	$("#w1p").draggable();
	$("#w2p").draggable();
	
}

function responseHandler(val,val2,val3,val4,val5) {
	
	var response = val.getElementsByTagName("response")[0];
	
	var code = parseInt(response.getAttribute("code"),10);
	
	if (code == 0) {
		errorHandler(response.textContent);
	} else {
		switch (val2) {
			case "":
			
			break;			
		}
	}	
}

function callsHandler(val,val2,val3,val4,val5) {
	
	var id = val;
	
	switch (id) {
		case "generateChartImages":
		
			switch (val2) {
				case "chart1":
				
					var spanArray = $(document).find("span[data-chart-container=1]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					var chartvalues3 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					var tempCounter3 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;
							case 3:
								chartvalues3[tempCounter3] = spanArray[x].innerHTML;
								tempCounter3++;
							break;							
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x]+"&chartvalues3="+chartvalues3[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
								//
							}
						});						
						
					}
				
				break;
				case "chart2":
				
					var spanArray = $(document).find("span[data-chart-container=2]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					var chartvalues3 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					var tempCounter3 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;
							case 3:
								chartvalues3[tempCounter3] = spanArray[x].innerHTML;
								tempCounter3++;
							break;							
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x]+"&chartvalues3="+chartvalues3[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
								//
							}
						});						
						
					}
				
				break;
				case "chart3":
				
					var spanArray = $(document).find("span[data-chart-container=3]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					var chartvalues3 = new Array();
					var chartvalues4 = new Array();
					var chartvalues5 = new Array();
					var chartvalues6 = new Array();
					var chartvalues7 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					var tempCounter3 = 0;
					var tempCounter4 = 0;
					var tempCounter5 = 0;
					var tempCounter6 = 0;
					var tempCounter7 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;
							case 3:
								chartvalues3[tempCounter3] = spanArray[x].innerHTML;
								tempCounter3++;
							break;								
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x]+"&chartvalues3="+chartvalues3[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
								//
							}
						});						
						
					}
				
				break;
				case "chart4":
				
					var spanArray = $(document).find("span[data-chart-container=4]").get();

					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					var chartvalues3 = new Array();
					var chartvalues4 = new Array();
					var chartvalues5 = new Array();
					var chartvalues6 = new Array();
					var chartvalues7 = new Array();
					var chartvalues8 = new Array();
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					var tempCounter3 = 0;
					var tempCounter4 = 0;
					var tempCounter5 = 0;
					var tempCounter6 = 0;
					var tempCounter7 = 0;
					var tempCounter8 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;
							case 3:
								chartvalues3[tempCounter3] = spanArray[x].innerHTML;
								tempCounter3++;
							break;
							case 4:
								chartvalues4[tempCounter4] = spanArray[x].innerHTML;
								tempCounter4++;
							break;	
							case 5:
								chartvalues5[tempCounter5] = spanArray[x].innerHTML;
								tempCounter5++;
							break;
							case 6:
								chartvalues6[tempCounter6] = spanArray[x].innerHTML;
								tempCounter6++;
							break;
							break;
							case 7:
								chartvalues7[tempCounter7] = spanArray[x].innerHTML;
								tempCounter7++;
							break;								
							case 8:
								chartvalues8[tempCounter8] = spanArray[x].innerHTML;
								tempCounter8++;
							break;	
						}
					}
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x]+"&chartvalues3="+chartvalues3[x]+"&chartvalues4="+chartvalues4[x]+"&chartvalues5="+chartvalues5[x]+"&chartvalues6="+chartvalues6[x]+"&chartvalues7="+chartvalues7[x]+"&chartvalues8="+chartvalues8[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
							}
						});						
						
					}
				
				break;				
				case "chart5":
				
					var spanArray = $(document).find("span[data-chart-container=5]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;								
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&programtype="+$("#programtype").val()+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
								//
							}
						});						
						
					}
				
				break;
				case "chart6":
				
					var spanArray = $(document).find("span[data-chart-container=6]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;								
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
								//
							}
						});						
						
					}
				
				break;
				case "chart7":
				
					var spanArray = $(document).find("span[data-chart-container=7]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;								
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
								//
							}
						});						
						
					}
				
				break;
				case "chart8":
				
					var spanArray = $(document).find("span[data-chart-container=8]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;								
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
								//
							}
						});						
						
					}
				
				break;
				
				case "chart9":
				
					var spanArray = $(document).find("span[data-chart-container=9]").get();
					
					var chartvalues1 = new Array();
					var chartvalues2 = new Array();
					
					var tempCounter1 = 0;
					var tempCounter2 = 0;
					
					for (var x = 0; x < spanArray.length; x++) {
						
						var tempAttr = parseInt(spanArray[x].getAttribute("data-chart-content"),10);
						
						switch (tempAttr) {
							case 1:
								chartvalues1[tempCounter1] = spanArray[x].innerHTML;
								tempCounter1++;
							break;
							case 2:
								chartvalues2[tempCounter2] = spanArray[x].innerHTML;
								tempCounter2++;
							break;								
						}
					}
					
					for (x = 0; x < chartvalues1.length; x++) {
						
						var values = "header="+val2+"&programtype="+$("#programtype").val()+"&chartvalues1="+chartvalues1[x]+"&chartvalues2="+chartvalues2[x];
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"inner_resultado_3.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function() {
							}
						});
					}
				break;
			}
		
		break;		
	}
}
	
function dataChangeHandler(val,val2,val3,val4,val5) {
	var id = val;
	
	switch(id) {
		case "saveTempPdf":

			var paused = false;
			var stopPropagation = true;
			
			var sheets = val2.split("<!-- sheet separator -->");
			
			if (sheets.length == 0) {
				statusBox('info','NULL','No se ha encontrado ninguna página para procesar','add','3000');
			} else {		
				
				var x = 0; 
				
				var hash_001 = Math.floor(Math.random()*11);
				var hash_002 = Math.floor(Math.random()* 1000000);
				var hash_003 = Math.floor(hash_002 + hash_001);			
				
				var pdfToken = $.md5(hash_003);
				
				statusBox('loading','NULL','<span id="loadingBoxInfoText">Cargando...</span>','add','NULL');
				
				var timer_1 = setInterval(function(){
					
					if (!paused) {
						
						if (x == ((sheets.length) - 1)) {
							var pdfStatus = 1;
						} else {
							var pdfStatus = 0;
						}				
						
						$("#loadingBoxInfoText").html("Procesando hoja "+(x + 1)+" de "+sheets.length);
						
						var values = "header="+val+"&filename="+$("#filenameInput").val()+"&pdfstatus="+pdfStatus+"&pdftoken="+pdfToken+"&html="+encodeURIComponent(sheets[x]);						
						
						paused = true;
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"php/resultado_data_change_handler.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function(xml) { 

								var tempId = xml.getElementsByTagName("response")[0].textContent;											
								var values = "header=checkPdfStatus&filter="+tempId+"&filterid=id_temp_pdf";
								
								$.ajax({
									contentType: "application/x-www-form-urlencoded",
									url:"php/resultado_calls_handler.php",
									type:"POST",
									data: values,
									dataType:"xml",
									success: function(xml) {
										var returnValues_1 = parseInt(xml.getElementsByTagName("response")[0].getElementsByTagName("returnvalues1")[0].textContent,10);
										if (returnValues_1 == 1) {
											if (stopPropagation) {
												stopPropagation = false;
												clearInterval(timer_1);
												statusBox('loading','NULL','NULL','remove','NULL');
												window.location.href = "inner_resultado_2.php?id="+tempId+"&reportidoriginal="+$("#reportid1").val()+"&reportidupdated="+$("#reportid2").val()+"&labid="+$("#labid").val();
											}
										}
									}
								});															
								
								if (pdfStatus != 1) {
									paused = false;
									x++;
								}
							}
						});						
					}
					
				},50);
				
			}
		
		break;
		case 'deleteTempCharts':
		
			var sheets = val2.split("<!-- sheet separator -->");
			
			var tempCounter = 0;
			var indexNameArray = new Array();
			
			for (x = 0; (sheets.length); x++) {
				var tempSpanArray = $(document).find("span[data-chart-container="+(x + 1)+"]").get();
				
				for (var y = 0; y < tempSpanArray.length; y++) {
					if (parseInt(tempSpanArray[y].getAttribute("data-chart-content"),10)) {
						indexNameArray[tempCounter] = tempSpanArray[y].innerHTML;
						tempCounter++;
						break;
					}
				}
			}
			
			var values = "&filenamearray="+indexNameArray.split("|");
			
			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url:"php/resultado_data_change_handler.php",
				type:"POST",
				data: values,
				dataType:"xml",
				success: function(xml) { 
					return false;
				}
			});			
			
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
				alert("Por favor complete todos los campos.");
				var answer = false;
			} else {
				var answer = true;
			}
			
			return answer;			
		break;
		case 'panelChooser':
			var id = val2.getAttribute("data-id");
			
			$("[data-id=mainDiv]").attr("hidden","hidden");
			$("#"+id).removeAttr("hidden");		
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
		case 'imageChecker':
			if (!val2.complete) {
				return false;
			}
			if (typeof val2.naturalWidth !== "undefined" && val2.naturalWidth === 0) {
				return false;
			}
			return true;
		break;
		case 'changeSheetSize':
			tempid = "#"+val2;
			$(tempid).attr("title",$("#w1pinput2").val()+"|"+$("#w1pinput1").val());
		break;
	}	
}

function errorHandler(val) {
	alert(val);
}

function table11Editor(val) {
	
	var td = val;
	
	tdId = parseInt(td.getAttribute("data-id"),10);
			
	switch (tdId) {
		case 1:
		case 2:
				
			var txt = val.innerHTML;
			
			var input = document.createElement("textarea");
			
			input.setAttribute("class","form-control unselectedInput");
			input.setAttribute("style","height: 100%;");
			input.value = txt;
			
			input.dataset.edited = 0;			
			
			input.addEventListener("blur",function() { td.innerHTML = input.value; });
			td.innerHTML = "";
			
			td.appendChild(input);
			
			input.focus();

		break;
		case 3:
		
			var select = document.createElement("select");
			var txt = new RegExp(val.innerHTML);			
			
			select.setAttribute("class","form-control unselectedInput");
			var ids = new Array();
			var names = new Array();
			
				ids[0] = "Reporte preliminar";
				ids[1] = "Reporte revalorado";
				ids[2] = "Reporte provisional";
				ids[3] = "Reporte final";
				names[0] = "Reporte preliminar";
				names[1] = "Reporte revalorado";
				names[2] = "Reporte provisional";
				names[3] = "Reporte final";
			
				if (ids != "") {
				
					for (var x = 0; x < ids.length; x++) {

						var option = document.createElement("option");
							option.value = ids[x];
							option.innerHTML = names[x];
							
						if (txt.test(option.innerHTML)) {
							option.setAttribute("selected","selected");
						}										
					
						select.appendChild(option);
					}
				}					

			select.dataset.edited = 0;			
			select.addEventListener("blur",function() { 
				td.innerHTML = select.value;
			});
			$(select).keypress(function(event) {
				
				if (event.keyCode == 13) {
					td.innerHTML = select.value;
				} else if (event.keyCode == 27) {
					td.innerHTML = backupvalue;
				}
				
			});
			
			td.innerHTML = "";
			td.appendChild(select);
			select.focus();
		
		break;		
	}
}