function initialize() {
	
	$("#form1").bind("submit",function(event){
		dataChangeHandler("changePassword","NULL",$("#form1").get(0),"NULL","NULL");
		event.preventDefault();
	});
	
	$("#form1input1").bind("keyup",function(event){
		functionHandler('matchPassword',$('#form1input1'),$('#form1input2'),$('#passDiv1').get(0),$('#passDiv2').get(0));
		event.preventDefault();
	});
	$("#form1input2").bind("keyup",function(event){
		functionHandler('matchPassword',$('#form1input1'),$('#form1input2'),$('#passDiv1').get(0),$('#passDiv2').get(0));
		event.preventDefault();
	});	
}

function responseHandler(val,val2,val3,val4,val5) {
	
	var response = val.getElementsByTagName("response")[0];
	
	var code = parseInt(response.getAttribute("code"),10);
	
	if (code == 0) {
		errorHandler(response.textContent);
	} else {
		switch (val2) {
			case "changePassword":
				var answer = parseInt(response.textContent,10);
				
				if (answer == 0) {
					var boxType = "warning";
					var txt = "El hipervinculo de cambio no está completo, por favor verifique e intente nuevamente";					
				} else {
					var boxType = "success";
					functionHandler("fieldReset","form1input1");
					functionHandler("fieldReset","form1input2");
					var txt = "La contraseña ha sido cambiada, redireccionando...";
					setTimeout(function(){
						window.location.href = "https://qaponline.quik.com.co";
					},4000);
				}
				
				statusBox(boxType,'NULL',txt,'add','4000');
				
			break;			
		}
	}	
}

function callsHandler(val,val2,val3,val4,val5) {
	
	var id = val;
	
	switch (id) {
		case "":
		
		break;
	}
}
	
function dataChangeHandler(val,val2,val3,val4,val5) {
	var id = val;
	
	switch(id) {
		case "changePassword":
		
			if (functionHandler('inputChecker',val3)) {
				if ((functionHandler('matchPassword',$('#form1input1'),$('#form1input2'),$('#passDiv1').get(0),$('#passDiv2').get(0))) && ($('#form1input1').val().length >= 8 && $('#form1input2').val().length >= 8) && (functionHandler("aplhanumeric",$("#form1input2").val()))) {
					var values = "header="+id+"&newpassworda="+$.md5($("#form1input1").val())+"&sitevalue="+$("#form1input3").val()+"&sitechecksum="+$("#form1input4").val()+"&key="+$("#form1input5").val();
					
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
					statusBox('warning','NULL','<p>Por favor verifique los siguientes errores:</p><p>Las contraseñas no coinciden</p><p>La contraseña no contiene minimo 8 carácteres</p><p>La contraseña no es alfanumérica</p><p>La contraseña no contiene al menos una letra mayuscula</p><p>La contraseña no contiene al menos una letra minúscula</p><p>La contraseña no contiene al menos un carácter especial</p><p>Por favor verifique antes de continuar</p>','add','15000');
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
		case "aplhanumeric":
		
			var toCheck = val2;
			
			var lowerCase = /[a-z]/; 
			var upperCase = /[A-Z]/; 
			var number = /[0-9]/;
			var especialCharacters = /[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/;
			
			var valid = (lowerCase.test(toCheck) && upperCase.test(toCheck)) && (number.test(toCheck) && especialCharacters.test(toCheck));
			return valid;
			
		break;
	}	
}

function errorHandler(val) {
	alert(val);
}