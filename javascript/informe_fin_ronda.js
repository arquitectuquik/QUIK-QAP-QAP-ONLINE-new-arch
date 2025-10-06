$(function(){
    eventoChangeLaboratorio();
    eventoChangeProgramaFR();
    eventoChangeRetoFR();
    eventoGenerarInforme();
    $("#laboratorio_fin_ronda").change();
});

function eventoChangeLaboratorio(){
    $("#laboratorio_fin_ronda").change(function(e){
        e.preventDefault();
        informacionProgramasFR();
    });
}


function eventoChangeProgramaFR(){
    $("#programa_fin_ronda").change(function(e){
        e.preventDefault();
        informacionRetosFR();
    });
}

function eventoChangeRetoFR(){
    $("#ronda_fin_ronda").change(function(e){
        e.preventDefault();
        informacionIntentosFR();
        changeRonda($(this).val());
    }); 
}

function informacionProgramasFR(){
    let id_laboratorio = $("#laboratorio_fin_ronda").val();
    let datos = {
        tabla: "programas_asignados_fin_ronda_report",
        id_filtro: id_laboratorio
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){}
    ).always(function(data){
        if(validarSiJSON(data)){
            campoP = $("#programa_fin_ronda");
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


function informacionRetosFR(){
    let id_laboratorio = $("#laboratorio_fin_ronda").val();
    let id_filtro_programa = $("#programa_fin_ronda").val();
    let datos = {
        tabla: "rondas_asignadas_fin_ronda_report",
        id_filtro: id_laboratorio,
        id_filtro_programa: id_filtro_programa 
    }

    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){

        console.log(data);

        if(validarSiJSON(data)){
            campoP = $("#ronda_fin_ronda");
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

function informacionIntentosFR(){
    let id_laboratorio = $("#laboratorio_fin_ronda").val();
    let id_filtro_reto = $("#ronda_fin_ronda").val();
    let datos = {
        tabla: "intentos_fin_ronda_report",
        id_filtro: id_laboratorio,
        id_filtro_reto: id_filtro_reto 
    }
    $.post(
        "php/listar_select_basico.php",
        datos,
        function(){
            /* No hacer nada de momento */
        }
    ).always(function(data){
        if(validarSiJSON(data)){
            campoP = $("#intento_fin_ronda");
            campoP.html("");
            var resultado = JSON.parse(data);
            if(resultado.length > 0){
                for (i = 0; i < resultado.length; i++) {
                    var option = $("<option value=" + resultado[i][0] + ">(" + (i+1) + ") " + resultado[i][1] + " el " + resultado[i][2] + "</option>");
                    campoP.append(option);
                }
            } else {
                var option = $("<option disabled selected>No hay intentos realizados...</option>");
                campoP.append(option);
            }
        }
    });
}

function changeRonda(idRonda)
{
    $("#fechas_corte").empty();		
    var val4 = " | ";
    var values = "header=showAssignedRoundSample&filter="+idRonda+"&filterid=id_ronda";
    $.ajax({
        contentType: "application/x-www-form-urlencoded",
        url:"php/resultado_calls_handler.php",
        type:"POST",
        data: values,
        dataType:"xml",
        success: function(xml) {               
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
                
                if (idArray != "") {
                    for (x = 0; x < idArray.length; x++) {                       
                        appendFechaCorteMuestra(contentArray[x],idArray[x]);	
                    }
                    
                }
            }
        }
    });	
}
function appendFechaCorteMuestra(muestraLabel, muestraId)
{
	var child = '<div class="form-group">'+
		'<label for="fecha_corte">Fecha Corte ' +muestraLabel +'</label>' +
		'<input class="form-control input-sm fecha_corte_muestra" data-muestraid="'+muestraId+'" type="date" id="fecha_corte_'+muestraId+'"  name="fecha_corte[]">'+
	'</div>';
	$("#fechas_corte").append(child);		
}

function eventoGenerarInforme(){
    $("#generar_reporte").click(function(e){
        e.preventDefault();

        if(
            $("#laboratorio_fin_ronda").val() == null ||
            $("#programa_fin_ronda").val() == null ||
            $("#ronda_fin_ronda").val() == null
        ){
            alert("Debe seleccionar todos los campos: laboratorio, programa y reto");
        } else if($("#programa_fin_ronda").val() == 6){
            alert("Aún no se encuentra disponible el informe de fin de ronda para el programa de uroanálisis");
        } else {
            let laboratorio_fin_ronda = $("#laboratorio_fin_ronda").val();
            let programa_fin_ronda = $("#programa_fin_ronda").val();
            let ronda_fin_ronda = $("#ronda_fin_ronda").val();

           
            var fechas_corte = '';
            if($(".fecha_corte_muestra").length > 0) {
                fechas_corte = {};
                $(".fecha_corte_muestra").each(function(fechaCorteItem){
                    console.log("Fecha corte",$(this).val(),"id",$(this).data("muestraid"));
                    fechas_corte[$(this).data("muestraid")] =  $(this).val();
                });
                fechas_corte = btoa(JSON.stringify(fechas_corte));			
            }
            $("#box_iframe").attr("src","php/front_fin_ronda.php?laboratorio="+laboratorio_fin_ronda+"&programa="+programa_fin_ronda+"&ronda="+ronda_fin_ronda+"&fechas_corte="+fechas_corte);
        }
    })
}
function errorHandler(val) {
	alert(val);
}