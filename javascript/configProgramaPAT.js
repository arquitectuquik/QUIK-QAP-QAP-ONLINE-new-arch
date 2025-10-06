// Listar los programas PAT
$(function(){
    /*
    listarSelect("programa_pat", $("#newe_programa").add($("#le_programa")));
    eventoChangeProgramaPAT();
    eventoChangeProgramaPATDos();
    eventoAgregarSeccion();
    eventoAgregarSeccionInterna();
    eventoEliminarSeccion();

    // Si el valor de los data-habilitate es falso, deshabilitar cada campo de personalizacion
    let cajas_personalizacion = $(".group-input .caja");
    $.each(cajas_personalizacion, function(index, val){
        let cajaActual = cajas_personalizacion.eq(index);
        if(cajaActual.data("habilitate") == true){
            gestionarCaja(cajaActual, "habilitar");
        } else {
            gestionarCaja(cajaActual, "deshabilitar");
        }
    });

    $(".changeGestionCaja").change(function(e){
        e.preventDefault();
        if($(this).prop("checked") == true){ // Si esta habilitado el checkbox
            gestionarCaja($(this).parents(".caja"), "habilitar");
        } else {
            gestionarCaja($(this).parents(".caja"), "deshabilitar");
        }
    });
    */
});


function gestionarCaja(cajaActual, tipoGestion){
    if(tipoGestion == "habilitar"){
        cajaActual.removeClass("caja-deshabilitada");
        cajaActual.find(".contenido-input").find("input").prop("disabled", false);
        cajaActual.children("input").prop("checked", true);
    } else if(tipoGestion == "deshabilitar"){
        cajaActual.addClass("caja-deshabilitada");
        cajaActual.find(".contenido-input").find("input").prop("disabled", true);
        cajaActual.find(".contenido-input").find("input").val("");
        cajaActual.children("input").prop("checked", false); 
    }
}


function listarSelect(tabla, campoP, idfiltro = null) {

    datosEMP = {
        tabla: tabla,
        id_filtro: idfiltro
    }
    
    $.post(
        "php/listar_select_basico.php", 
        datosEMP
    ).always(function(data){
        if(validarSiJSON(data)){
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



function eventoChangeProgramaPAT(){
    $("#newe_programa").change(function(e){
        e.preventDefault();
        let elementEvent = $(this);
        listarSelect("reto_pat", $("#newe_reto"), elementEvent.val())
    });
}


function eventoChangeProgramaPATDos(){
    $("#le_programa").change(function(e){
        e.preventDefault();
        let elementEvent = $(this);
        listarSelect("reto_pat", $("#le_reto"), elementEvent.val())
    });
}

function eventoAgregarSeccion(){
    $(".btn-add-seccion").off("click");
    $(".btn-add-seccion").click(function(e){
        e.preventDefault();
        let elementEvent = $(this);
        let cont_seccion = $(
            '<div class="seccion">							'+
                '<h5>Sección</h5>'+
                '<div class="desc_seccion">'+
                    '<div class="items-group">'+
                        '<input type="text" class="form-control input-sm" value="" placeholder="Nombre sección">'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<select class="form-control input-sm">'+
                            '<option value="">1</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<button class="btn btn-sm btn-success btn-add-seccion" title="Agregar una seccion nueva al lado de ésta sección">'+
                            '<i class="glyphicon glyphicon-plus"></i>'+
                        '</button>'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<button class="btn btn-sm btn-warning btn-add-seccion-interna">'+
                            '<i class="glyphicon glyphicon-chevron-down" title="Agregar una seccion nueva, dentro de ésta sección"></i>'+
                        '</button>'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<button class="btn btn-sm btn-danger btn-delete-seccion">'+
                            '<i class="glyphicon glyphicon-trash"></i>'+
                        '</button>'+
                    '</div>'+
                '</div>'+
                '<div class="sub_seccion">'+
                    '<div class="cuestion">'+
                        '<div class="form-row form_cuestion">'+
                            '<div class="form-group col-1">'+
                                '<label>Cuestión</label>'+
                                '<input type="text" class="form-control nombre_cuestion input-sm" placeholder="Nombre cuestión">'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Tipo calificación</label>'+
                                '<select class="form-control input-sm tipo_calificacion">'+
                                    '<option value="1">Correcto / incorrecto</option>'+
                                    '<option value="2">Mediante valores decimales</option>'+
                                    '<option value="3">Mediante misma categoría</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Orden</label>'+
                                '<select class="form-control input-sm orden_cuestion">'+
                                    '<option value="1">1</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Valoración</label>'+
                                '<div class="custom-control custom-switch">'+
                                    '<input type="checkbox" class="custom-control-input" id="customSwitch1">'+
                                    '<label class="custom-control-label" for="customSwitch1">Activar</label>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Permitir "otros"</label>'+
                                '<div class="custom-control custom-switch">'+
                                    '<input type="checkbox" class="custom-control-input" id="customSwitch2">'+
                                    '<label class="custom-control-label" for="customSwitch2">Activar</label>'+
                                '</div>'+
                            '</div>'+
                            '<div class="items-group">'+
                                '<button class="btn btn-sm btn-success btn-add-seccion" title="Agregar una seccion nueva al lado de ésta sección">'+
                                    '<i class="glyphicon glyphicon-plus"></i>'+
                                '</button>'+
                            '</div>'+
                            '<div class="items-group">'+
                                '<button class="btn btn-sm btn-warning btn-add-seccion-interna">'+
                                    '<i class="glyphicon glyphicon-chevron-down" title="Agregar una seccion nueva, dentro de ésta sección"></i>'+
                                '</button>'+
                            '</div>'+
                            '<div class="items-group">'+
                                '<button class="btn btn-sm btn-danger btn-delete-seccion">'+
                                    '<i class="glyphicon glyphicon-trash"></i>'+
                                '</button>'+
                            '</div>'+
                        '</div>'+
                        '<div class="sub_cuestion"></div>'+
                    '</div>'+
                '</div>'+
            '</div>'
        );

        elementEvent.parents(".seccion").after(cont_seccion);
    
        eventoAgregarSeccion();
        eventoAgregarSeccionInterna();
        eventoEliminarSeccion();
    });
}

function eventoAgregarSeccionInterna(){
    $(".btn-add-seccion-interna").off("click");
    $(".btn-add-seccion-interna").click(function(e){
        e.preventDefault();
        let elementEvent = $(this);
        let cont_seccion = $(
            '<div class="seccion">							'+
                '<h5>Sección</h5>'+
                '<div class="desc_seccion">'+
                    '<div class="items-group">'+
                        '<input type="text" class="form-control input-sm" value="" placeholder="Nombre sección">'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<select class="form-control input-sm">'+
                            '<option value="">1</option>'+
                        '</select>'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<button class="btn btn-sm btn-success btn-add-seccion" title="Agregar una seccion nueva al lado de ésta sección">'+
                            '<i class="glyphicon glyphicon-plus"></i>'+
                        '</button>'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<button class="btn btn-sm btn-warning btn-add-seccion-interna">'+
                            '<i class="glyphicon glyphicon-chevron-down" title="Agregar una seccion nueva, dentro de ésta sección"></i>'+
                        '</button>'+
                    '</div>'+
                    '<div class="items-group">'+
                        '<button class="btn btn-sm btn-danger btn-delete-seccion">'+
                            '<i class="glyphicon glyphicon-trash"></i>'+
                        '</button>'+
                    '</div>'+
                '</div>'+
                '<div class="sub_seccion">'+
                    '<div class="cuestion">'+
                        '<div class="form-row form_cuestion">'+
                            '<div class="form-group col-1">'+
                                '<label>Cuestión</label>'+
                                '<input type="text" class="form-control nombre_cuestion input-sm" placeholder="Nombre cuestión">'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Tipo calificación</label>'+
                                '<select class="form-control input-sm tipo_calificacion">'+
                                    '<option value="1">Correcto / incorrecto</option>'+
                                    '<option value="2">Mediante valores decimales</option>'+
                                    '<option value="3">Mediante misma categoría</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Orden</label>'+
                                '<select class="form-control input-sm orden_cuestion">'+
                                    '<option value="1">1</option>'+
                                '</select>'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Valoración</label>'+
                                '<div class="custom-control custom-switch">'+
                                    '<input type="checkbox" class="custom-control-input" id="customSwitch1">'+
                                    '<label class="custom-control-label" for="customSwitch1">Activar</label>'+
                                '</div>'+
                            '</div>'+
                            '<div class="form-group col-1">'+
                                '<label>Permitir "otros"</label>'+
                                '<div class="custom-control custom-switch">'+
                                    '<input type="checkbox" class="custom-control-input" id="customSwitch2">'+
                                    '<label class="custom-control-label" for="customSwitch2">Activar</label>'+
                                '</div>'+
                            '</div>'+
                            '<div class="items-group">'+
                                '<button class="btn btn-sm btn-success btn-add-seccion" title="Agregar una seccion nueva al lado de ésta sección">'+
                                    '<i class="glyphicon glyphicon-plus"></i>'+
                                '</button>'+
                            '</div>'+
                            '<div class="items-group">'+
                                '<button class="btn btn-sm btn-warning btn-add-seccion-interna">'+
                                    '<i class="glyphicon glyphicon-chevron-down" title="Agregar una seccion nueva, dentro de ésta sección"></i>'+
                                '</button>'+
                            '</div>'+
                            '<div class="items-group">'+
                                '<button class="btn btn-sm btn-danger btn-delete-seccion">'+
                                    '<i class="glyphicon glyphicon-trash"></i>'+
                                '</button>'+
                            '</div>'+
                        '</div>'+
                        '<div class="sub_cuestion"></div>'+
                    '</div>'+
                '</div>'+
            '</div>'
        );

        elementEvent.parents(".seccion").append(cont_seccion);
    
        eventoAgregarSeccion();
        eventoAgregarSeccionInterna();
        eventoEliminarSeccion();
    });
}

function eventoEliminarSeccion(){

    $(".btn-delete-seccion").off("click");
    $(".btn-delete-seccion").click(function(e){
        e.preventDefault();
        let elementEvent = $(this);
        let parentSeccion = elementEvent.parents(".seccion");

        // Primeramente pide la confirmacion
        let confirm_response = confirm("¿Está seguro que desea eliminar la sección especificada?");

        if(confirm_response){
            // Primeramente verificar si se puede realizar la eliminación
            let numSiblings = parentSeccion.siblings(".seccion").length;

            if(numSiblings == 0){
                alert("No puede eliminar la sección ya que es la única en su nivel.");
            } else {
                parentSeccion.remove();
            }
        }
    });
}