contTrsTable = 0;

function eventoAgregarFilaGestion(btnEvent, contTable){
    
    let table = $('<table class="table table-sm table-secondary text-center" style="min-width: 2000px;"></table>');

    btnEvent.click(function (e){

        let elementEvent = $(this);

        contTrsTable = contTable.find("table tbody tr").length;
        
        e.preventDefault();

        if(validarItemsSeleccionados()){
            
            statusBox('warning','NULL','Para realizar gestiones de medias antes debe seleccionar el programa, el lote y el mes','add','3000');
            
        } else {
            
            // Inicializacion de otras variables
            let table_cuerpo;
            let table_trGestion;
            
            if(tipoProgramaCualitativo(elementEvent)){ // Si es cualitativo
                
                // No hacer nada de momento
                statusBox('warning','NULL','Aún no esta disponible la funcionalidad para programas cualitativos...','add','3000');
    
            } else { // Si es cuantitativo
                table_cuerpo = $(
                    '<thead class="table-primary text-center">' +
                        '<tr>'+
                            '<th rowspan="2">Tipo</th>'+
                            '<th rowspan="2">Mensurando</th>'+
                            '<th rowspan="2">Analizador</th>'+
                            '<th rowspan="2">Reactivo</th>'+
                            '<th rowspan="2">Metodología</th>'+
                            '<th rowspan="2" style="width:150px">Unidades</th>'+
                            '<th rowspan="2" style="width:150px">U-MC <span class="badge badge-secondary" title="Esta unidad es la que se imprimirá en el reporte final, en la columna U-MC">New</span></th>'+
                            '<th rowspan="2">Generación</th>'+
                            '<th colspan="5" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">Mensual</th>'+
                            '<th colspan="5" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">Acumulada</th>'+
                            '<th colspan="2" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">JCTLM</th>'+
                            '<th colspan="4" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;">Inserto</th>'+
                            '<th colspan="1" style="border-bottom:0px solid transparent !important;text-align:center; font-size:10px;padding:5px !important;"></th>'+
                        '</tr>' +
    
                        '<tr>'+
                            '<th style="border-left: 2px solid #2471A3">Media</th>'+
                            '<th>D.E.</th>'+
                            '<th>C.V.</th>'+
                            '<th>#Lab</th>'+
                            '<th>#P</th>'+
    
                            '<th style="border-left: 2px solid #2471A3">Media</th>'+
                            '<th>D.E.</th>'+
                            '<th>C.V.</th>'+
                            '<th>#Lab</th>'+
                            '<th>#P</th>'+
    
                            '<th style="border-left: 2px solid #2471A3">Media</th>'+
                            '<th>ETmp%</th>'+
    
                            '<th style="border-left: 2px solid #2471A3">Media</th>'+
                            '<th>D.E.</th>'+
                            '<th>C.V.</th>'+
                            '<th style="border-right: 2px solid #2471A3;">N</th>'+
                            
                            '<th>Acciones</th>'+
                        '</tr>' + 
                    '</thead>' + 
                    '<tbody></tbody>'
                );
    
                table_trGestion = $(
                    '<tr>'+
                        '<td>'+
                            '<select class="tipo form-control input-sm">'+
                                '<option value="" disabled>Seleccione la acción que va a gestionar</option>'+
                                '<option value="1">Original (basado en reporte mundial)</option>'+
                                '<option value="2">Adaptación (configuración para unidad o laboratorio en específico)</option>'+
                            '</select>'+
                        '</td>' +
                        '<td>' +
                            '<select class="analito form-control input-sm"><option disabled selected>Seleccione un mensurando</option></select>' +
                        '</td>' +
                        '<td>' +
                            '<select class="analizador form-control input-sm"><option disabled selected>Seleccione un analizador</option></select>' +
                        '</td>' +
                        '<td>' +
                            '<select class="reactivo form-control input-sm"><option disabled selected>Seleccione un reactivo</option></select>' +
                        '</td>' +
                        '<td>' +
                            '<select class="metodologia form-control input-sm"><option disabled selected>Seleccione una metodología</option></select>' +
                        '</td>' +
                        '<td>' +
                            '<select class="unidad form-control input-sm"><option disabled selected>Seleccione una unidad</option></select>' +
                        '</td>' +
                        '<td>' +
                            '<select class="unidad_mc form-control input-sm"><option disabled selected>Seleccione una unidad</option></select>' +
                        '</td>' +
                        '<td>' +
                            '<select class="gen_vitros form-control input-sm" disabled><option disabled selected>Seleccione una generación vitros</option></select>' +
                        '</td>' +
                        '<td style="border-left: 2px solid #2471A3">' +
                            '<input class="media_mensual input_float change_cv form-control input-sm" data-fieldmedia="media_mensual" data-fieldde="de_mensual" data-fieldcv="cv_mensual" placeholder="M mensual">' +
                        '</td>' +
                        '<td>' +
                            '<input class="de_mensual input_float change_cv form-control input-sm" data-fieldmedia="media_mensual" data-fieldde="de_mensual" data-fieldcv="cv_mensual" placeholder="D.E. mensual">' +
                        '</td>' +
                        '<td>' +
                            '<input class="cv_mensual input_float form-control input-sm" placeholder="C.V. mensual">' +
                        '</td>' +
                        '<td>' +
                            '<input class="nlab_mensual form-control input-sm" placeholder="NLab mensual">' +
                        '</td>' +
                        '<td>' +
                            '<input class="npuntos_mensual form-control input-sm" placeholder="NPuntos mensual">' +
                        '</td>' +
                        '<td style="border-left: 2px solid #2471A3">' +
                            '<input class="media_acumulada input_float change_cv form-control input-sm" data-fieldmedia="media_acumulada" data-fieldde="de_acumulada" data-fieldcv="cv_acumulada" placeholder="M acumulada">' +
                        '</td>' +
                        '<td>' +
                            '<input class="de_acumulada input_float change_cv form-control input-sm" data-fieldmedia="media_acumulada" data-fieldde="de_acumulada" data-fieldcv="cv_acumulada" placeholder="D.E. acumulada">' +
                        '</td>' +
                        '<td>' +
                            '<input class="cv_acumulada input_float form-control input-sm" placeholder="C.V. acumulada">' +
                        '</td>' +
                        '<td>' +
                            '<input class="nlab_acumulada form-control input-sm" placeholder="NLab acumulada">' +
                        '</td>' +
                        '<td>' +
                            '<input class="npuntos_acumulada form-control input-sm" placeholder="NPuntos acumulada">' +
                        '</td>' +
                        '<td style="border-left: 2px solid #2471A3">' +
                            '<input class="media_jctlm input_float form-control input-sm" placeholder="M JCTLM">' +
                        '</td>' +
                        '<td>' +
                            '<input class="etmp_jctlm input_float form-control input-sm" placeholder="ETmp% JCTLM">' +
                        '</td>' +
                        '<td style="border-left: 2px solid #2471A3;">' +
                            '<input class="media_inserto change_cv input_float form-control input-sm" data-fieldmedia="media_inserto" data-fieldde="de_inserto" data-fieldcv="cv_inserto" placeholder="M inserto">' +
                        '</td>' +
                        '<td>' +
                            '<input class="de_inserto change_cv input_float form-control input-sm" data-fieldmedia="media_inserto" data-fieldde="de_inserto" data-fieldcv="cv_inserto" placeholder="D.E. inserto">' +
                        '</td>' +
                        '<td>' +
                            '<input class="cv_inserto input_float form-control input-sm" placeholder="CV inserto">' +
                        '</td>' +
                        '<td style="border-right: 2px solid #2471A3;">' +
                            '<input class="n_inserto form-control input-sm" placeholder="N inserto">' +
                        '</td>' +
                        '<td>' +
                            '<button class="btn btn-sm btn-danger btn-eliminar-fila"><span class="glyphicon glyphicon-remove" title="Clic para eliminar ésta fila"></span></button>' +
                        '</td>' +
                    '</tr>'
                );
    
                if (contTrsTable == 0) {
                    table.html(table_cuerpo);
                    contTable.html(table);
                }
    
                contTable.find("tbody").append(table_trGestion);
                gestionSelectsSolicitud(
                    elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores").find(".select-inactivo"),
                    "deshabilitar"
                );
                eventoEliminarFila(table_trGestion);
                listarElementos(table_trGestion);
                eventoAsignarFloat(table_trGestion);
                eventoCalcularCV(table_trGestion);
                
                // eventoCalculoCV();
                // eventoDuplicarMensurando(table_trGestion);
                // eventoDuplicarFila(table_trGestion);
                // eventoAsignarFloat(table_trGestion);
            }
        }
    
    });
}