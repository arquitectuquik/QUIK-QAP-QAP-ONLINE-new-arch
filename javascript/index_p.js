// Listar los programas de patogologias que se encuentran asignados

$(function(){
    informacionProgramasPAT();
    eventoChangeLaboratorio();
    eventoChangeProgramaPAT();
    informacionLaboratorio();
    eventoCierreInesperado(true);

    $("#open_reports").click(function(e){
		e.preventDefault();
		// window.open("reportes.php?filter="+$("#form1input1").val()+"&filterid=id_laboratorio", "Consultar reportes QAP", "width=1000, height=600")
		window.open("reportes.php?filter="+$("#form1input1").val()+"&filterid=id_laboratorio", "Consultar reportes QAP")
	})
});

function eventoCierreInesperado(accion = true) {
    
    $(window).off("beforeunload",ventanaEmergente); // Eliminar eventos repetidos en dado caso que existan
    if(accion === true){
        $(window).on("beforeunload",ventanaEmergente);
        
        function ventanaEmergente() {
            if($("body input").length > 0){ // Si existen inputs dentro del cuerpo del documento
                return "¿Está seguro de cerrar la página?, recuerde que puede perder toda la información";
            }
        }
    }   
}


function eventoChangeLaboratorio(){
    $("#laboratorio").change(function(e){
        e.preventDefault();
        informacionProgramasPAT();
        informacionLaboratorio();
    })
}


function eventoChangeProgramaPAT(){
    $("#programa_pat").change(function(e){
        e.preventDefault();
        listarRetos();
    })
}


function informacionProgramasPAT(){
    let id_laboratorio = $("#laboratorio").val();
    let datos = {
        tabla: "programas_asignados_pat",
        id_filtro: id_laboratorio
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){
        
        if(validarSiJSON(data)){
            campoP = $("#programa_pat");
            campoP.html("");
            var resultado = JSON.parse(data);
            if(resultado.length > 0){
                for (i = 0; i < resultado.length; i++) {
                    var option = $("<option value=" + resultado[i][0] + ">" + resultado[i][1] + "</option>");
                    campoP.append(option);
                }
            } else {
                var option = $("<option disabled selected>No hay opciones disponbiles...</option>");
                campoP.append(option);
            }
            campoP.change();
        }
    });
}


function informacionLaboratorio(){ // Genera la infromacion del laboratorio
    let id_laboratorio = $("#laboratorio").val();
    let datos = {
        tabla: "info_laboratorio",
        id_filtro: id_laboratorio
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){
        
        if(validarSiJSON(data)){
            // Imprimir todos los valores
            var resultado = JSON.parse(data);

            if(resultado.length > 0){
                
                resultado = resultado[0];
                let camp_laboratorio = resultado.no_laboratorio + " - " + resultado.nombre_laboratorio;
                let camp_contacto = resultado.contacto_laboratorio;
                let camp_direccion = resultado.direccion_laboratorio;
                let camp_telefono = resultado.telefono_laboratorio;
                let camp_correo = resultado.correo_laboratorio;
                let camp_ciudad = resultado.nombre_ciudad + ", " + resultado.nombre_pais;
    
                $("#camp-laboratorio").html(camp_laboratorio);
                $("#camp-contacto").html(camp_contacto);
                $("#camp-direccion").html(camp_direccion);
                $("#camp-telefono").html(camp_telefono);
                $("#camp-correo").html(camp_correo);
                $("#camp-ciudad").html(camp_ciudad);

            } else {
                alert("No hay laboratorios asignados. Por favro comuniquese con el administrador del sistema.");
            }

        }
    });
}


function listarRetos(){
    let id_programa_pat = $("#programa_pat").val();
    let id_laboratorio = $("#laboratorio").val();
    let datos = {
        tabla: "info_retos_laboratorio",
        id_filtro: id_laboratorio,
        id_programa_pat: id_programa_pat
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){

        let contenedorRetos = $(".contenedor-retos");
        contenedorRetos.html("");
        
        if(validarSiJSON(data)){
            // Imprimir todos los valores
            var resultado = JSON.parse(data);

            if(resultado.length > 0){

                for(conyt=0;conyt<resultado.length;conyt++){
                    reto_act = resultado[conyt];
                    reto_act.nombre_lote_pat = ((reto_act.nombre_lote_pat == null) ? "Sin lote especificado" : reto_act.nombre_lote_pat);
                    reto_act.num_casos_clinicos = ((reto_act.num_casos_clinicos == 1) ? "Un caso clínico" : reto_act.num_casos_clinicos + " casos clínicos");

                    resumen_intentos = '';
                    
                    if(reto_act.num_intentos == 0){
                        resumen_intentos = 'Sin intentos previos';
                    } else {

                        if(reto_act.num_intentos == 1){
                            resumen_intentos = '(hecho '+reto_act.num_intentos+' vez) último el: '+reto_act.ultimo_intento;
                        } else {
                            resumen_intentos = '(hecho '+reto_act.num_intentos+' veces) último el: '+reto_act.ultimo_intento;
                        }
                    }
                    
                    if(reto_act.intento_temp){
                        card = $('<div class="card shadow m-2">'+
                        '<div class="card-body">'+
                            '<h5 class="card-title">'+reto_act.nombre_programa_pat+' - '+reto_act.nombre_reto_pat+'</h5>'+
                            '<p class="card-text">'+reto_act.num_casos_clinicos+' - '+reto_act.nombre_lote_pat+'</p>'+
                            '<a href="#" class="btn btn-success btn-sm btnRetoStart" data-temp="true" data-id_laboratorio="'+$("#laboratorio").val()+'" data-id_reto="'+reto_act.id_reto+'" data-nom_reto="'+reto_act.nombre_programa_pat+' - '+reto_act.nombre_reto_pat+'"><i class="fas fa-stream"></i> Continuar casos de estudio</a> '+ resumen_intentos +
                        '</div>'+
                    '</div>');
                    } else {
                        card = $('<div class="card shadow m-2">'+
                            '<div class="card-body">'+
                                '<h5 class="card-title">'+reto_act.nombre_programa_pat+' - '+reto_act.nombre_reto_pat+'</h5>'+
                                '<p class="card-text">'+reto_act.num_casos_clinicos+' - '+reto_act.nombre_lote_pat+'</p>'+
                                '<a href="#" class="btn btn-primary btn-sm btnRetoStart" data-temp="false" data-id_laboratorio="'+$("#laboratorio").val()+'" data-id_reto="'+reto_act.id_reto+'" data-nom_reto="'+reto_act.nombre_programa_pat+' - '+reto_act.nombre_reto_pat+'"><i class="fas fa-stream"></i> Presentar casos de estudio</a> '+ resumen_intentos +
                            '</div>'+
                        '</div>');
                    }
                    

                    contenedorRetos.append(card);
                }

                eventoPresentarExamen();
            }    
        }
    });
    
}


function eventoPresentarExamen(){
    let btnRetoStart = $(".btnRetoStart");
    btnRetoStart.off("click");
    btnRetoStart.click(function(sds){

        let nomReto = $(this).data("nom_reto");
        let id_reto = $(this).data("id_reto");
        let id_laboratorio = $(this).data("id_laboratorio");
        let presentacion_temp = $(this).data("temp");

        if(presentacion_temp){ // Si es para continuar un examen
            confirmIntent = confirm("¿Está seguro de continuar diligenciando las repuestas del reto ''" +nomReto+ "''?");
        } else {
            confirmIntent = confirm("¿Está seguro de iniciar un intento para el reto ''" +nomReto+ "''?");
        }

        if(confirmIntent){
            listarCasosClinicos(id_reto,id_laboratorio, presentacion_temp);
        }
    })
}


function listarCasosClinicos(id_reto,id_laboratorio, presentacion_temp){
    let datos = {
        accion: "listar_casos_clinicos",
        id_reto: id_reto,
        id_laboratorio: id_laboratorio
    }
    
    $.post(
        "php/index_p_data_change_handler.php",
        datos
    ).done(function(responseXML){
        try {
            var response = responseXML.getElementsByTagName("response")[0];
            var code = parseInt(response.getAttribute("code"),10);
    
            if (code == 0) {
                alert("Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.");
            } else if (code == 422) {
                alert("Debe solicitar una revaloración a Quik S.A.S. para poder presentar estos casos clínicos.");
            } else {
                response = $(response).html();
                $(".contenedor_main").html(response);


                // Listar las respuestas guardas previamente
                console.log(presentacion_temp);
                if(presentacion_temp){
                    $.post(
                        "php/listar_select_basico.php",
                        {
                            tabla: "listar_respuestas_temp",
                            id_reto: id_reto,
                            id_laboratorio: id_laboratorio
                        }
                    ).always(function(data){
                        console.log(data);
                        if(validarSiJSON(data)){
                            campoP.html("");
                            var resultado = JSON.parse(data);

                            console.log(resultado);

                            if(resultado.respuestas.length > 0){
                                for (i = 0; i < resultado.respuestas.length; i++) {
                                    $("input[value="+resultado.respuestas[i]+"]").prop("checked",true)
                                }
                            }

                            let respuesta_act;
                            if(resultado.respuestas_abiertas.length > 0){
                                for (i = 0; i < resultado.respuestas_abiertas.length; i++) {
                                    respuesta_act = resultado.respuestas_abiertas[i];
                                    $("input[name="+respuesta_act["id_pregunta"]+"]").val(respuesta_act["respuesta_cuantitativa"]);
                                }
                            }

                            

                            // Agregar comentario previo
                            $("#comentarios_reto").val(resultado.comentario);
                        }
                    });

                }             

                eventoEnvioForm();
                eventoSaveTemp();
            }
        } catch(e){
           alert("Ha ocurrido un error de javascript, por favor intente nuevamente...");
        }
    }).fail(function(saasd){
        alert("Ha ocurrido algo inesperado al listar los casos clínicos, por favor intente de nuevo más tarde");
    }).always(function(sadsdsa){
        console.log(sadsdsa);
    });
}


function eventoSaveTemp(){
    let form = $("#form-reto");
    let btnSubmit = form.find("button[type=submit]");
    let btnSaveTemp = $("#btn-save-temp");

    btnSaveTemp.click(function(e){
        e.preventDefault();

        btnSubmit.prop("disabled",true);
        btnSaveTemp.prop("disabled",true);

        btnSaveTemp.html('<i class="fas fa-check"></i> Guardando respuestas...');

        let datosAjax = {
            accion: "guardarIntentoTemp",
            respuestas: form.serialize() 
        };

        $.post(
            "php/index_p_data_change_handler.php",
            datosAjax
        ).always(function(responseXML){

            btnSubmit.prop("disabled",false);
            btnSaveTemp.prop("disabled",false);
            
            btnSubmit.html('<i class="fas fa-check"></i> Terminar intento');
            btnSaveTemp.html('<i class="fas fa-save"></i> Guardar mis respuestas para continuar después');

            try {
                var response = responseXML.getElementsByTagName("response")[0];
                var code = parseInt(response.getAttribute("code"),10);
        
                if (code == 0) {
                    alert("Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.");
                } else {
                    alert("¡Las respuestas han sido guardadas de manera satisfactoria!. Será dirigido a la página principal...");
                    $("#form-reto").html('');
                    $("#form-reto").append('<h3 class="text-center h5">RETO GUARDADO</h3>');
                    $("#form-reto").append('<br />');
                    $("#form-reto").append('<br />');
                    $("#form-reto").append('<h4 class="h5 border-bottom border-info pb-2">Las respuestas han sido guardadas de manera satisfactoria.</h4>');
                    window.location.href = "index_p.php";
                }

            } catch(e){
                alert("Ha ocurrido un error de javascript, por favor intente nuevamente...");
            }
        });
    })
}


function eventoEnvioForm(){
    let form = $("#form-reto");

    form.submit(function(e){

        e.preventDefault();
        
        confirmForm = confirm("¿Está seguro de enviar los resultados?");
        if(confirmForm){

            let elementsText = $("input[type=text]");
            for(dsadsa=0; dsadsa<elementsText.length; dsadsa++){
                elementTextAct = elementsText.eq(dsadsa);
                var valor = elementTextAct.val();     
                if(valor == "" || valor == null || typeof valor == "undefined"){
                    elementTextAct.val("");
                } else {
                    var entrada = parseFloat(valor);
                    var float = entrada.toFixed(3);
                    elementTextAct.val(float);
                }
            }

            if(validarInputsForm(form)){
                let btnSubmit = form.find("button[type=submit]");
                btnSubmit.prop("disabled",true);
                btnSubmit.html('<i class="fas fa-check"></i> Terminando intento...');

                let datosAjax = {
                    accion: "guardarIntento",
                    respuestas: form.serialize() 
                };

                console.log(datosAjax);

                $.post(
                    "php/index_p_data_change_handler.php",
                    datosAjax
                ).always(function(responseXML){
                    btnSubmit.prop("disabled",false);
                    btnSubmit.html('<i class="fas fa-check"></i> Terminar intento');
                    try {
                        var response = responseXML.getElementsByTagName("response")[0];
                        var code = parseInt(response.getAttribute("code"),10);
                        if (code == 0) {
                            alert("Ha ocurrido algo inesperado con la respuesta de la consulta, o no tiene los permisos necesarios.");
                        } else {
                            alert("¡El intento ha sido enviado de manera satisfactoria!. Será dirigido a la página principal...");
                            $("#form-reto").html('');
                            $("#form-reto").append('<h3 class="text-center h5">RETO ENVIADO</h3>');
                            $("#form-reto").append('<br />');
                            $("#form-reto").append('<br />');
                            $("#form-reto").append('<h4 class="h5 border-bottom border-info pb-2">El intento ha sido enviado de manera satisfactoria.</h4>');
                            window.location.href = "index_p.php";
                        }
                    } catch(e){
                        alert("Ha ocurrido un error de javascript, por favor intente nuevamente...");
                    }
                });
            }
        }
    });
}


function eventoCancelarForm(){
    let btnCancel = $("#btn-cancel");
}


function validarInputsForm(form){

    let inputsForm = form.find("input").not(form.find("input[type=hidden]"));
    let namesInputs = [];

    for(ifi=0; ifi<inputsForm.length; ifi++){
        let inputFormAct = inputsForm.eq(ifi);
        let searchArr = namesInputs.indexOf(inputFormAct.attr("name"));

        if(searchArr === -1){ // Si no existe
            namesInputs.push(inputFormAct.attr("name")); // Agrega el nuevo nombre
        }
    }


    for(ctni=0; ctni<namesInputs.length; ctni++){
        let nameInputAct = namesInputs[ctni];
        let elementFocus;
        let inputNameS = form.find("input[name="+nameInputAct+"]");
        
        if(inputNameS.prop("type") == "text"){
            if(inputNameS.val() == "" || inputNameS.val() == null || typeof inputNameS.val() == "undefined"){
                elementFocus = inputNameS;
                alert("Debe responder todas las preguntas");
                $(".preguntaNula").removeClass("preguntaNula");
                elementFocus.addClass("preguntaNula");
                return false;
            } else if(inputNameS.val().match("^([0-9]{1,5})$") == null && inputNameS.val().match("^([0-9]{1,5}(\.[0-9]{1,3}))$") == null) {
                elementFocus = inputNameS;
                alert("El valor debe ser numérico, y debe ser hasta máximo 99.999,999 (máximo 5 enteros y 3 decimales)");
                $(".preguntaNula").removeClass("preguntaNula");
                elementFocus.addClass("preguntaNula");
                return false;
            }
        } else { // Si es un tipo radio
            if(verificarCheckRadio(inputNameS) != true){ // Si el input no estaba seleccionado

                if(inputNameS.parents("td").length > 0){ // Si es un contenido dentro de una tabla
                    elementFocus = inputNameS.parents("td");
                } else if(inputNameS.parents("ol").length > 0){ // Si es un elemento que esta dentro de una lista
                    elementFocus = inputNameS.parents("ol").eq(0);
                }

                alert("Debe responder todas las preguntas");
                $(".preguntaNula").removeClass("preguntaNula");
                elementFocus.addClass("preguntaNula");
                return false;
            }
        }
    }
    
    return true;
}


function verificarCheckRadio(inputNameS){
    for(cntAument=0; cntAument<inputNameS.length; cntAument++){
        if(inputNameS.eq(cntAument).prop("checked")){
            return true;
        }
    }
    return false;
}