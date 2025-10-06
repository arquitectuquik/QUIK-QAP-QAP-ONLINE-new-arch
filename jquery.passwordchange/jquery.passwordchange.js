//passwordchange for javascript
//copyright AeZ - 2016.

//the next values must be set to your form, your username input and your password input
//<script src="jquery.passwordchange/jquery.passwordchange.js" type="text/javascript"></script>		Set this to your login file
//data-passwordchange-dataform="true"																Set this to your form
//data-passwordchange-userinput="true"																Set this to your username input
//data-passwordchange-password="true"																Set this to your password input

	//function initiealize
	
	//create the script name array
	var scriptNames = [
		//"jquery.passwordchange/jquery-3.2.1.min.js"
		//,"jquery.passwordchange/jquery.md5.js"
		//,"jquery.passwordchange/bootstrap.min.js"
		//,"jquery.passwordchange/jquery.statusBox.js"
	];
	
	//create the css name array
	var cssNames = [
		//"jquery.passwordchange/bootstrap/css/bootstrap.min.css"
	];

	//get the document head DOM
	var documentHead = document.getElementsByTagName("head")[0];
	
	var x = 0;
	
	//inject the css sheets
	for (x = 0; x < cssNames.length; x++) {
		//create the link DOM element
		var tempLink = document.createElement("link");
		
		//assign the attributes to the link DOM element
			tempLink.setAttribute("rel","stylesheet");
			tempLink.setAttribute("media","screen");
			tempLink.setAttribute("href",cssNames[x]);
			
		//add the link DOM elemnt to the head DOM element
		documentHead.appendChild(tempLink);			
	}	
	
	//inject the script DOM element
	//if(!window.jQuery) {
		for (x = 0; x < scriptNames.length; x++) {
			//create the script DOM element
			var tempScript = document.createElement("script");
			
			//assign the attributes to the script DOM element
				tempScript.setAttribute("type","text/javascript");
				tempScript.setAttribute("async","true");
				tempScript.setAttribute("src",scriptNames[x]);
				tempScript.dataset.loaded = false;		
			
			//add the script DOM elemnt to the body DOM element
			documentHead.appendChild(tempScript);		
		}
	//}
	
	//wait for the scripts and start the data capture function
	var timer_1 = setInterval(function(){
		
		if (!window.jQuery) {
			return false;
		} else {
			clearInterval(timer_1);
		}		
		
		//get the user,password form and interupt its default behaviour		
		var dataForm = $(document).find("form[data-passwordchange-dataform=true]");
		
		//copy the form and its events
		var cloneForm = dataForm.clone(true);
			
			//unbind the current submit functions
			dataForm.unbind("submit");
			dataForm.off();
			
			//bind the new submit function
			dataForm.bind("submit",function(event){
				
				event.stopPropagation();
				event.stopImmediatePropagation()
				event.preventDefault();
				
				//get the username and its password
				var userData = dataForm.find("input[data-passwordchange-userinput=true]").val();
				var passwordData = dataForm.find("input[data-passwordchange-password=true]").val();
				
				//send the data and verify whether it needs to be changed
				var values = "username="+userData+"&password="+$.md5(passwordData)+"&header=datecheck";
				
				statusBox("loading","NULL","NULL","add","NULL");
				
				$.ajax({
					contentType: "application/x-www-form-urlencoded",
					url:"jquery.passwordchange/data_handler.php",
					type:"POST",
					data: values,
					dataType:"xml",
					success: function(xml) {
						
						statusBox("loading","NULL","NULL","remove","NULL");
						
						//get the returned values
						var returnvalues1 = parseInt(xml.getElementsByTagName("response")[0].getElementsByTagName("returnvalues1")[0].textContent,10);
						
						//verify if the password has expired
						if (returnvalues1 == 1) {
							
							var returnvalues2 = xml.getElementsByTagName("response")[0].getElementsByTagName("returnvalues2")[0].textContent;
							var returnvalues3 = xml.getElementsByTagName("response")[0].getElementsByTagName("returnvalues3")[0].textContent;							
							
							//initialize the password change module
							//check if the main div already exists, if not, create it and assign it's id and css
							var cssClass = [{
								"position":"fixed"
								,"z_index":"9999"
								,"width":"100%"
								,"height":"100%"
							}];
							
							if (document.getElementById('passwordchangeContainer')) {
								var mainDiv = document.getElementById('passwordchangeContainer');
								var isMainDivOnUse = true;
							} else {
								var mainDiv = document.createElement("div");
									mainDiv.setAttribute('id','passwordchangeContainer');
									mainDiv.setAttribute('style','position:'+cssClass[0].position+';z-index:'+cssClass[0].z_index+';width:'+cssClass[0].width+';height:'+cssClass[0].height+';');
								var isMainDivOnUse = false;
								
								//inject the main div
								document.getElementsByTagName('body')[0].appendChild(mainDiv);
								
							}
							
							//create the inner div with the password changing items and assign it's id and css
							var cssClass = [{
								"position":"fixed"
								,"z_index":"9999"								
								,"box_shadow_a":"0px 0px 29px -1px rgba(0,0,0,0.75)"
								,"box_shadow_b":"0px 0px 29px -1px rgba(0,0,0,0.75)"
								,"box_shadow_c":"0px 0px 29px -1px rgba(0,0,0,0.75)"
								,"margin":"auto"
								,"top":"20%"
								,"left":"0"
								,"bottom":"0"
								,"right":"0"
							}];
							
							var innerDiv = document.createElement("div");
								innerDiv.setAttribute('id','passwordchangeBox');
								innerDiv.setAttribute("class","col-xs-12 col-md-8");
								innerDiv.setAttribute("style","position:"+cssClass[0].position+";z_index:"+cssClass[0].z_index+";margin:"+cssClass[0].margin+";top:"+cssClass[0].top+";left:"+cssClass[0].left+";bottom:"+cssClass[0].bottom+";right:"+cssClass[0].right+";");
						
							//write the innerdiv's content
							$(innerDiv).html(
								"<div class='panel panel-primary' style='-webkit-box-shadow:"+cssClass[0].box_shadow_a+";-moz-box-shadow:"+cssClass[0].box_shadow_b+";box-shadow:"+cssClass[0].box_shadow_c+";'>"
									+"<div class='panel-heading'>"
										+"<span>Por favor cambie su contrase\u00f1a</span>"
									+"</div>"
									+"<div class='panel-body'>"
										+"<h3 style='margin-top: 1%;'>Su contrase\u00f1a ha caducado, por favor ingrese una nueva contrase\u00f1a</h3>"
										+"<form id='passwordchangeMainForm'>"
											+"<div class='form-group' id='passwordchange_passwordContainerA'>"
												+"<label for='passwordchange_passwordInputA'>Nueva contrase\u00f1a (minimo 8 car\u00E1cteres, n\u00FAmeros y letras, minimo una mayuscula, minimo un caracter especial)</label>"
												+"<input type='password' class='form-control input-sm' id='passwordchange_passwordInputA'/>"
											+"</div>"
											+"<div class='form-group' id='passwordchange_passwordContainerB'>"
												+"<label for='passwordchange_passwordInputB'>Repita la contrase\u00f1a (minimo 8 car\u00E1cteres, n\u00FAmeros y letras, minimo una mayuscula, minimo un caracter especial)</label>"
												+"<input type='password' class='form-control input-sm' id='passwordchange_passwordInputB'/>"
											+"</div>"
											+"<div class='row' style='margin-top:1%'></div>"
											+"<center>"
												+"<input type='submit' class='btn btn-primary btn-sm' value='Continuar'/>"
											+"</center>"
										+"</form>"
									+"</div>"	
								+"</div>"
							);
							
							//assign the password match function
							$(innerDiv).find("#passwordchange_passwordInputA").bind("keyup",function(event){
								functionHandler('matchPassword',$(innerDiv).find('#passwordchange_passwordInputA'),$(innerDiv).find('#passwordchange_passwordInputB'),$(innerDiv).find('#passwordchange_passwordContainerA').get(0),$(innerDiv).find('#passwordchange_passwordContainerB').get(0));
								event.preventDefault();
							});	
							$(innerDiv).find("#passwordchange_passwordInputB").bind("keyup",function(event){
								functionHandler('matchPassword',$(innerDiv).find('#passwordchange_passwordInputA'),$(innerDiv).find('#passwordchange_passwordInputB'),$(innerDiv).find('#passwordchange_passwordContainerA').get(0),$(innerDiv).find('#passwordchange_passwordContainerB').get(0));
								event.preventDefault();
							});	

							//get the password form and bind the passwordchange submit function
							var passwordForm = $(innerDiv).find("#passwordchangeMainForm");
							
								passwordForm.bind("submit",function(event){
									event.preventDefault();
									
									//check for the password match
									if (functionHandler('matchPassword',$(innerDiv).find('#passwordchange_passwordInputA'),$(innerDiv).find('#passwordchange_passwordInputB'),$(innerDiv).find('#passwordchange_passwordContainerA').get(0),$(innerDiv).find('#passwordchange_passwordContainerB').get(0)) && ($(innerDiv).find('#passwordchange_passwordInputA').val().length >= 8 && $(innerDiv).find('#passwordchange_passwordInputB').val().length >= 8) && (functionHandler("aplhanumeric",$("#passwordchange_passwordInputB").val()))) {
										//send the data and change the password if everything matches
										var newpassword = $("#passwordchange_passwordInputB").val();
										var values = "userid="+returnvalues2+"&newpassword="+$.md5(newpassword)+"&header=datachange&checksum="+returnvalues3;
										
										statusBox("loading","NULL","NULL","add","NULL");
										
										$.ajax({
											contentType: "application/x-www-form-urlencoded",
											url:"jquery.passwordchange/data_handler.php",
											type:"POST",
											data: values,
											dataType:"xml",
											success: function(xml) {
												
												statusBox("loading","NULL","NULL","remove","NULL");
												
												//get the returned values
												var returnvalues1 = parseInt(xml.getElementsByTagName("response")[0].getElementsByTagName("returnvalues1")[0].textContent,10);
												
												//check for the password upadte or error in the process
												if (returnvalues1 == 0) {
													alert("Las llaves de control no coinciden, por favor actualice la p\u00E1gina e intente nuevamente");
												} else if (returnvalues1 == 1) {
													alert("Algo ha salido mal, por favor comun\u00EDquese con el administrador de la aplicaci\u00F3n");
												} else if (returnvalues1 == 3) {
													alert("Por favor ingrese una contrase\u00f1a diferente a la que actualmente existe");														
												} else if (returnvalues1 == 2){
													
													statusBox("loading","NULL","NULL","add","NULL");
													
													//continue to the application
													$("#passwordchangeBox").find("div[class=panel-body]").html(
														"<div class='alert alert-success col-xs-12'>"
															+"<h2>\u00A1Su contrase\u00f1a ha sido actualizada exitosamente!</h2>"
															+"<br/>"
															+"<br/>"
															+"<h2>Redireccionando...</h2>"
														+"</div>"
													);
													setTimeout(function(){
														statusBox("loading","NULL","NULL","remove","NULL");
														dataForm.find("input[data-passwordchange-userinput=true]").val(userData);
														dataForm.find("input[data-passwordchange-password=true]").val(newpassword);
														cloneForm.find("input[data-passwordchange-userinput=true]").val(userData);
														cloneForm.find("input[data-passwordchange-password=true]").val(newpassword);												
														cloneForm.attr("hidden","hidden").appendTo("body").submit();
													},3500);
												}
											}
										});
										
									} else {
										alert("Verifique los siguientes errores:\n\nLas contrase\u00f1as no coinciden\nLa contrase\u00f1a no contiene minimo 8 car\u00E1cteres\nLa contrase\u00f1a no es alfanum\u00E9rica\nLa contrase\u00f1a no contiene al menos una letra mayuscula\nLa contrase\u00f1a no contiene al menos un car\u00E1cter especial\n\nPor favor verifique antes de continuar");
									}
								});									
							
							//add the innerdiv to the main div
							mainDiv.appendChild(innerDiv);							
							
						} else {
							//continue to the application
							dataForm.find("input[data-passwordchange-userinput=true]").val(userData);
							dataForm.find("input[data-passwordchange-password=true]").val(passwordData);
							cloneForm.find("input[data-passwordchange-userinput=true]").val(userData);
							cloneForm.find("input[data-passwordchange-password=true]").val(passwordData);	
							cloneForm.attr("hidden","hidden").appendTo("body").submit();
						}
						
					}			
				});
			});	
		
	},500);
	
	//define the password match function and the regexp function
	function functionHandler(val,val2,val3,val4,val5) {
		var id = val;
		
		switch(id) {
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
			case "aplhanumeric":
				var toCheck = val2;
				
				var lowerCase = /[a-z]/; 
				var upperCase = /[A-Z]/; 
				var number = /[0-9]/;
				var especialCharacters = /[~`!#$%\^&*+=\-\[\]\\';,/{}|\\":<>\?]/;
				
				var valid = (lowerCase.test(toCheck) && upperCase.test(toCheck)) && (number.test(toCheck) && especialCharacters.test(toCheck));
				return valid;
			break;
			default:
				alert('JS functionHandler error: id "'+id+'" not found');
			break;
		}
	}