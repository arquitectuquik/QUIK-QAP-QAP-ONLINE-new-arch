function initialize() {
	$("#form1").bind("submit",function(event){
		callsHandler("checkMember","NULL","NULL","NULL","NULL");
		event.preventDefault();
	});
	$("#form2").bind("submit",function(event){
		dataChangeHandler("memberEmailRegistry","NULL",$("#form2").get(0),"NULL","NULL");
		event.preventDefault();
	});
	
	$("#form2input1").bind("keyup",function(event){
		functionHandler('matchPassword',$('#form2input1'),$('#form2input2'),$('#emailDiv1').get(0),$('#emailDiv2').get(0));
		event.preventDefault();
	});
	$("#form2input2").bind("keyup",function(event){
		functionHandler('matchPassword',$('#form2input1'),$('#form2input2'),$('#emailDiv1').get(0),$('#emailDiv2').get(0));
		event.preventDefault();
	});
	
	if ($("#form1input1").val() != "") {
		$("#form1").submit();
	}
}

function responseHandler(val,val2,val3,val4,val5) {
	
	var response = val.getElementsByTagName("response")[0];
	
	var code = parseInt(response.getAttribute("code"),10);
	
	if (code == 0) {
		errorHandler(response.textContent);
	} else {
		switch (val2) {
			case "checkMember":
				var answer = parseInt(response.textContent.split("|")[0],10);
				
				if (answer == 0) {
					var boxType = "warning";
					var txt = "No se ha encontrado el valor ingresado";					
				} else if (answer == 2) {
					var boxType = "info";
					var txt = "No se ha encontrado email asociado a este nombre de usuario";					
					functionHandler("divToggle","panel1");
					functionHandler("divToggle","panel2");
					
					$("#form2input3").val(response.textContent.split("|")[1]);
					
				} else {
					var boxType = "success";
					functionHandler("fieldReset","form1input1");
					var txt = "Se ha enviado un correo electronico a la dirección <b style='color: black;'>"+response.textContent.split("|")[1]+"</b> para restablecer la contraseña";
					setTimeout(function(){
						window.close();
						self.close();
					},6000);
				}
				
				statusBox(boxType,'NULL',txt,'add','6000');
				
			break;
			case "memberEmailRegistry":
				var answer = parseInt(response.textContent,10);
				
				if (answer == 1) {
					var boxType = "success";
					var txt = "El correo electrónico ha sido registrado; recargando...";
					
					setTimeout(function(){
						window.location.href = window.location.href+"&useremail="+$("#form2input2").val();
					},4000);
					
				} else {
					var boxType = "warning";
					var txt = "El correo electrónico ya está registrado";					
				}
				
				statusBox(boxType,'NULL',txt,'add','NULL');
				
			break;			
		}
	}
}

function callsHandler(val,val2,val3,val4,val5) {
	
	var id = val;
	
	switch (id) {
		case "checkMember":
			
			var values = "header="+id+"&"+$("#form1").serialize();
			
			statusBox('loading','NULL','NULL','add','NULL');
			
			$.ajax({
				contentType: "application/x-www-form-urlencoded",
				url:"php/passwordRecovery.php",
				type:"POST",
				data: values,
				dataType:"xml",
				success: function(xml) { 
					statusBox('loading','NULL','NULL','remove','NULL');
					responseHandler(xml,id,"NULL","NULL","NULL");
				}
			});		
			
		break;		
	}
}
	
function dataChangeHandler(val,val2,val3,val4,val5) {
	var id = val;
	
	switch(id) {
		case "memberEmailRegistry":
		
			if (functionHandler('inputChecker',val3)) {
				if (functionHandler('matchPassword',$('#form2input1'),$('#form2input2'),$('#emailDiv1').get(0),$('#emailDiv2').get(0))) {
					if (functionHandler('isEmail',$('#form2input2').val())) {
						
						var values = "header="+id+"&"+$(val3).serialize();
						
						statusBox('loading','NULL','NULL','add','NULL');
						
						$.ajax({
							contentType: "application/x-www-form-urlencoded",
							url:"php/passwordRecovery.php",
							type:"POST",
							data: values,
							dataType:"xml",
							success: function(xml) { 
								statusBox('loading','NULL','NULL','remove','NULL');
								responseHandler(xml,id,"NULL","NULL","NULL");
							}
						});						
					} else {
						statusBox('warning','NULL','Correo electrónico no valido, por favor verifique e intente nuevamente','add','NULL');
					}
				} else {
					statusBox('warning','NULL','Los correos electrónicos escritos no coinciden, por favor verifique e intente nuevamente','add','NULL');
				}
			}
		
		break;		
	}
}

function functionHandler(val,val2,val3,val4,val5,val6) {
	var id = val;
	
	switch(id) {
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
		case "divToggle":
			$("#"+val2).toggle();
		break;
		case "isEmail":
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			return regex.test(val2);
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
	}	
}

function errorHandler(val) {
	alert(val);
}