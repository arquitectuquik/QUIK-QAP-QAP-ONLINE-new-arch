function initialize() {
	$("#form1input1").bind("change",function(event) {
		functionHandler("selectFiller","form1input2","showSampleSimple&filter="+this.value+"&filterid=id_programa"," | ","false");
		
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
		callsHandler("showIfLabReportedResult",$("#form1input1").val()+"|"+this.value,"id_array","NULL","NULL");
	});
	$("#form1input3").bind("mouseup",function(event) {
		$("#form1input2").change();
	});
	$("#form1input4").bind("mouseup",function(event) {
		callsHandler("showReportedAnalitValues",$("#form1input1").val()+"|"+$("#form1input2").val(),"id_array","NULL","NULL");
	});	
	
	$("#form1input1").change();
	
	var excelName = {};
}

function responseHandler(val,val2,val3,val4,val5) {
	
	var response = val.getElementsByTagName("response")[0];
	
	var code = parseInt(response.getAttribute("code"),10);
	
	if (code == 0) {
		errorHandler(response.textContent);
	} else {
		switch (val2) {
			case "showIfLabReportedResult":
			
				var tbody1 = $("#table1").find("tbody").get(0);
					tbody1.innerHTML = "";
				var tbody2 = $("#table2").find("tbody").get(0);
					tbody2.innerHTML = "";					
					
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
						
							td1.setAttribute('style','font-weight:bold;');
							td1.setAttribute('class','center-text');
							td2.setAttribute('class','center-text');
							td3.setAttribute('class','center-text');
						
						td1.dataset.id = "1";
						td2.dataset.id = "2";
						td3.dataset.id = "3";
						
						td1.innerHTML = returnValues_1[x];
						td2.innerHTML = returnValues_2[x];
						td3.innerHTML = returnValues_3[x];
						
						tr.appendChild(td1);
						tr.appendChild(td2);
						tr.appendChild(td3);

						tbody1.appendChild(tr);
					}
				
				}
				if (returnValues_4 != "") {
				
					for (var x = 0; x < returnValues_4.length; x++) {
						
						var tr = document.createElement("tr");
						
						var td1 = document.createElement("td");
						var td2 = document.createElement("td");
						
							td1.setAttribute('style','font-weight:bold;');
							td1.setAttribute('class','center-text');
							td2.setAttribute('class','center-text');
						
						td1.dataset.id = "1";
						td2.dataset.id = "2";
						
						td1.innerHTML = returnValues_4[x];
						td2.innerHTML = returnValues_5[x];
						
						tr.appendChild(td1);
						tr.appendChild(td2);

						tbody2.appendChild(tr);
					}
				
				}				
				
				$("#table1").find("thead").find("input[data-search-input=true]").keyup();
				$("#table2").find("thead").find("input[data-search-input=true]").keyup();
				
			break;
			case "showReportedAnalitValues":
				var thead = $("#table3").find("thead").get(0);
					thead.innerHTML = "";				
				var tbody = $("#table3").find("tbody").get(0);
					tbody.innerHTML = "";				
					
				var returnValues_1 = response.getElementsByTagName("returnvalues1")[0].textContent.split("|");
				var returnValues_2 = response.getElementsByTagName("returnvalues2")[0].textContent.split("|");
				var returnValues_3 = response.getElementsByTagName("returnvalues3")[0];
				
				if (returnValues_1 != "") {
					
					$(thead).append("<tr></tr>");
					$(thead).find("tr").append("<td style='border: 0.75pt solid; text-align:center; vertical-align: middle; background-color: #70ad47; color: white;'></td>");
					
					for (x = 0; x < returnValues_1.length; x++) {
						$(thead).find("tr").append("<th style='border: 0.75pt solid; text-align:center; vertical-align: middle; background-color: #70ad47; color: white;'>"+returnValues_1[x]+"</th>");
					}
					
					for (x = 0; x < returnValues_2.length; x++) {
						$(tbody).append("<tr><td style='border: 0.75pt solid; text-align:left; vertical-align: middle; background-color: #c6e0b4; color: black;'>"+returnValues_2[x]+"</td></tr>");
					}
					
					for (x = 0; x < $(returnValues_3).children().length; x++) {
						var values = $(returnValues_3).children()[x].textContent.split("|");
						
						for (y = 0; y < values.length; y++) {
							var tempTr = $(tbody).find("tr").get(y);
							$(tempTr).append("<td style='border: 0.75pt solid; text-align:center; vertical-align: middle; color: black;'>"+values[y]+"</td>");
						}
					}
				
					functionHandler("exportTableToExcel","tableToExcelWrapper","Resultados de programa "+$("#form1input1 option:selected").text()+" muestra "+$("#form1input2 option:selected").text().split("|")[0].split(" ")[0]);
				
				}
		
			break;
		}
	}	
}

function callsHandler(val,val2,val3,val4,val5) {
	
	var id = val;
	
	switch (id) {
		case "showIfLabReportedResult":
			
			if (typeof(val2) == 'undefined') {
				var values = "header="+id;
			} else {
				var values = "header="+id+"&filter="+val2+"&filterid="+val3;
			}
				
			statusBox('loading','NULL','NULL','add','NULL');
			
			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url:"php/cronograma_calls_handler.php",
				type:"POST",
				data: values,
				dataType:"xml",
				success: function(xml) { 
					statusBox('loading','NULL','NULL','remove','NULL');
					responseHandler(xml,id,"NULL","NULL","NULL"); 
				}
			})			
			
		break;
		case "showReportedAnalitValues":
			
			if (typeof(val2) == 'undefined') {
				var values = "header="+id;
			} else {
				var values = "header="+id+"&filter="+val2+"&filterid="+val3;
			}
				
			statusBox('loading','NULL','NULL','add','NULL');
			
			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url:"php/cronograma_calls_handler.php",
				type:"POST",
				data: values,
				dataType:"xml",
				success: function(xml) { 
					statusBox('loading','NULL','NULL','remove','NULL');
					responseHandler(xml,id,"NULL","NULL","NULL"); 
				}
			})			
			
		break;			
	}
}
	
function dataChangeHandler(val,val2,val3,val4,val5) {
	var id = val;
	
	switch(id) {
		case "":
		
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
		case 'selectFiller':
			
			$("input[type=submit]").attr("disabled","disabled");
			$("input[type=submit]").addClass("disabled");
			
			var select = $("#"+val2).get(0);
				select.innerHTML = "";
				select.value = "";
				select.removeAttribute("data-active");
				select.dataset.active = "false";
			
			var values = "header="+val3;
			statusBox('loading','NULL','NULL','add','NULL');
			
			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url:"php/cronograma_calls_handler.php",
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
						
						$("input[type=submit]").removeAttr("disabled");
						$("input[type=submit]").removeClass("disabled");
						
					}
				}
			});

		break;
		case "exportTableToExcel":
			
			var table = $("#"+val2);
			excelName = val3;
			
			table.removeData();
			table.table2excel();
			
		break;
	}	
}	

function errorHandler(val) {
	alert(val);
}