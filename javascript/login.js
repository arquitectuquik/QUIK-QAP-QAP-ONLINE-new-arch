function initialize() {
	
	checkHash();
	
	$("#form1").bind("submit",function(event){
		checkUser();
		event.preventDefault();
	});
}

function checkUser() {
	
	var values = "hash=NULL&username="+$("#userName").val()+"&userpassword="+$.md5($("#userPassword").val());
	statusBox("loading","null","null","add","null");
	
	$.ajax({
		contentType: "application/x-www-form-urlencoded",
		url:"php/verifica_usuario.php",
		type:"POST",
		data: values,
		dataType:"xml",
		success: function(xml) { 
			statusBox("loading","null","null","remove","null");
			responseHandler(xml,"checkUser"); 
		}
	})
	
}
function checkHash() {
	
	var values = 'hash='+$.cookie('user_hash')+"&username="+$("#userName").val()+"&userpassword="+$.md5($("#userPassword").val());
	statusBox("loading","null","null","add","null");
	
	$.ajax({
		contentType: "application/x-www-form-urlencoded",
		url:"php/verifica_usuario.php",
		type:"POST",
		data: values,
		dataType:"xml",
		success: function(xml) { 
			console.log(xml);
			statusBox("loading","null","null","remove","null");
			responseHandler(xml,"checkUser"); 
		}
	});
	
}

function responseHandler(val,val2) {
	var response = val.getElementsByTagName("response")[0];
	
	var code = parseInt(response.getAttribute("code"),10);
	var type = parseInt(response.getAttribute("type"),10);
	var hash = response.getAttribute("hash");
	
	if (code == 0) {
		errorHandler(response.textContent);
	} else {
		switch (val2) {
			case "checkUser":
				if (parseInt(response.textContent,10) == 0) {
					statusBox('warning','NULL','Usuario o contraseña incorrectos','ADD','NULL');
				} else  if (parseInt(response.textContent,10) == 2) {
					$("#mainContainer").removeAttr("hidden");
				} else if (parseInt(response.textContent,10) == 1) {	
					statusBox('loading','NULL','NULL','ADD','NULL');
					
					if ($("#f1cb1").get(0).checked) {
						$.removeCookie('user_hash');
						$.cookie('user_hash',hash);
					}
					
					if ((type == 0 || type == 100) || (type == 101 || type == 102)) {
						window.location.assign("index_a.php");
					} else if (type == 125 || type == 126) { // Si es un usuario de patologia anatomica
						window.location.assign("index_p.php");					
					} else if (type == 103 || type == 104) {			
						window.location.assign("index_u.php");					
					}
				} else {
					statusBox('info','NULL','Ha ocurrido un error procesando la petición','ADD','3000');
				}
			break;
		}
	}
}

function errorHandler(val) {
	alert(val);
}