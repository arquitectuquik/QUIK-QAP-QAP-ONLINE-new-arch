$(function(){
    generarGraficasCorrelacion();    
});


function generarGraficasCorrelacion(){

    let contGraficas = $(".cont-graficas .contenedor_graficos_correlacion");
    let id_laboratorio = $("#id_laboratorio").val();
    let id_programa = $("#id_programa").val();
    let id_ronda = $("#id_ronda").val();
    let fechas_corte =  $("#fechas_corte").val();

    let graficasCargadas = 0;
    let totalAnalitos = contGraficas.length;
    let totalGraficas = totalAnalitos * 4;
    let part = (100 / totalGraficas);
    let progreso_act = 0;


    for(i=0; i<totalAnalitos; i++){
        let contGraficaAct = contGraficas.eq(i);
        let id_analito_lab = contGraficaAct.data("id_analito_lab");

        let datainfo = {
            accion: "get_info_correlacion",
            id_analito_lab: id_analito_lab,
            id_laboratorio: id_laboratorio,
            id_programa: id_programa,
            id_ronda: id_ronda,
            fechas_corte
        }

        $.ajax(
            "informe/informeFinRondaController.php",
            {
                type : "POST",
                cache: false,
                data : datainfo
            }
        ).done(function (response) {

            console.log(response);
            
            let obj_response = JSON.parse(response);

            google.charts.load('current', {
                'packages': ['corechart']
            });

            google.charts.setOnLoadCallback(generarGraficoWWR);
            google.charts.setOnLoadCallback(generarGraficoJCTLM);
            google.charts.setOnLoadCallback(generarGraficoConsenso);
            google.charts.setOnLoadCallback(generarGraficoMetodologia);
            
            function generarGraficoWWR(){

                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'x');
                dataTable.addColumn('number', 'y');
                dataTable.addColumn({type: 'string', role: 'annotation'});
                
                let dataElements = [];            
                let conjunto_x = [];
                let conjunto_y = [];
                let cont_mx_realsize = 0;
            
                for (i=0; i<obj_response.muestras.length; i++) {
                    if(obj_response.muestras[i].vrl != "N/A" && obj_response.muestras[i].vav_principal.media_estandar != "N/A"){
                        
                        cont_mx_realsize++;
                        dataTable.addColumn('number', "M" + obj_response.muestras[i].no_contador + ' (N=' + obj_response.muestras[i].vav_principal.n_evaluacion + ')');

                        dataElements.push([
                            parseFloat(obj_response.muestras[i].vrl),
                            parseFloat(obj_response.muestras[i].vav_principal.media_estandar),
                            "M" + obj_response.muestras[i].no_contador
                        ]);
                        conjunto_x.push(obj_response.muestras[i].vrl);
                        conjunto_y.push(obj_response.muestras[i].vav_principal.media_estandar);
                    }
                }

                dataElements = middlewareValuesChart(dataElements, cont_mx_realsize);
                dataTable.addRows(dataElements);

                let options = getOptionsChart('Evaluación con media de comparación', conjunto_x, conjunto_y);
                
                let id_config = obj_response.analito.id_configuracion;
                let id_dom = "analito_" + id_config + '_vav_principal';
                
                $(".contenedor_graficos_correlacion[data-id_analito_lab="+obj_response.analito.id_configuracion+"]").append("<div id="+id_dom+" class='contenedor-grafico'></div>")
                let chart = new google.visualization.ScatterChart(document.getElementById(id_dom));
                
                google.visualization.events.addListener(chart, 'ready', function () {
                    $(".cont-textareas").append("<textarea id='base64_"+id_dom+"'></textarea>");
                    $("#base64_"+id_dom).val(chart.getImageURI());
                    progreso_act = progreso_act + part;
                    $(".progreso").text(Math.round((progreso_act),1));
                    graficasCargadas++; 
                    if(graficasCargadas == totalGraficas){ // Si se alcanzo el 100% de los analitos generados
                        exportacionReporteGraficasCorrelacion();
                    }
                });
                
                chart.draw(dataTable, options);
            }

            function generarGraficoJCTLM(){

                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'x');
                dataTable.addColumn('number', 'y');
                dataTable.addColumn({type: 'string', role: 'annotation'});

                let dataElements = [];            
                let conjunto_x = [];
                let conjunto_y = [];
                let cont_mx_realsize = 0;   
            
                for (i=0; i<obj_response.muestras.length; i++) {
                    if(obj_response.muestras[i].vrl != "N/A" && obj_response.muestras[i].vav_jctlm.valor_metodo_referencia != "N/A"){

                        cont_mx_realsize++;
                        dataTable.addColumn('number', "M" + obj_response.muestras[i].no_contador + ' (N=1)');

                        dataElements.push([
                            parseFloat(obj_response.muestras[i].vrl),
                            parseFloat(obj_response.muestras[i].vav_jctlm.valor_metodo_referencia),
                            "M" + obj_response.muestras[i].no_contador
                        ]);
                        conjunto_x.push(obj_response.muestras[i].vrl);
                        conjunto_y.push(obj_response.muestras[i].vav_jctlm.valor_metodo_referencia);
                    }
                }

                dataElements = middlewareValuesChart(dataElements, cont_mx_realsize);
                dataTable.addRows(dataElements);

                let options = getOptionsChart('Evaluación JCTLM', conjunto_x, conjunto_y);
                
                let id_config = obj_response.analito.id_configuracion;
                let id_dom = "analito_" + id_config + '_vav_jctlm';
                
                $(".contenedor_graficos_correlacion[data-id_analito_lab="+obj_response.analito.id_configuracion+"]").append("<div id="+id_dom+" class='contenedor-grafico'></div>")
                let chart = new google.visualization.ScatterChart(document.getElementById(id_dom));
                
                google.visualization.events.addListener(chart, 'ready', function () {
                    $(".cont-textareas").append("<textarea id='base64_"+id_dom+"'></textarea>");
                    $("#base64_"+id_dom).val(chart.getImageURI());
                    progreso_act = progreso_act + part;
                    $(".progreso").text(Math.round((progreso_act),1));
                    graficasCargadas++; 
                    if(graficasCargadas == totalGraficas){ // Si se alcanzo el 100% de los analitos generados
                        exportacionReporteGraficasCorrelacion();
                    }
                });
                
                chart.draw(dataTable, options);
            }

            function generarGraficoConsenso(){
               
                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'x');
                dataTable.addColumn('number', 'y');
                dataTable.addColumn({type: 'string', role: 'annotation'});

                let dataElements = [];            
                let conjunto_x = [];
                let conjunto_y = [];
                let cont_mx_realsize = 0;
            
                for (i=0; i<obj_response.muestras.length; i++) {
                    if(obj_response.muestras[i].vrl != "N/A" && obj_response.muestras[i].vav_consenso.media != "N/A"){

                        cont_mx_realsize++;
                        dataTable.addColumn('number', "M" + obj_response.muestras[i].no_contador + ' (N=' + obj_response.muestras[i].vav_consenso.n + ')');

                        dataElements.push([
                            parseFloat(obj_response.muestras[i].vrl),
                            parseFloat(obj_response.muestras[i].vav_consenso.media),
                            "M" + obj_response.muestras[i].no_contador
                        ]);
                        conjunto_x.push(obj_response.muestras[i].vrl);
                        conjunto_y.push(obj_response.muestras[i].vav_consenso.media);
                    }
                }

                dataElements = middlewareValuesChart(dataElements, cont_mx_realsize);
                dataTable.addRows(dataElements);

                let options = getOptionsChart('Evaluación consenso QAP', conjunto_x, conjunto_y);
                
                let id_config = obj_response.analito.id_configuracion;
                let id_dom = "analito_" + id_config + '_vav_consenso_qap';
                
                $(".contenedor_graficos_correlacion[data-id_analito_lab="+obj_response.analito.id_configuracion+"]").append("<div id="+id_dom+" class='contenedor-grafico'></div>")
                let chart = new google.visualization.ScatterChart(document.getElementById(id_dom));
                
                google.visualization.events.addListener(chart, 'ready', function () {
                    $(".cont-textareas").append("<textarea id='base64_"+id_dom+"'></textarea>");
                    $("#base64_"+id_dom).val(chart.getImageURI());

                    progreso_act = progreso_act + part;
                    $(".progreso").text(Math.round((progreso_act),1));
                    graficasCargadas++; 
                    if(graficasCargadas == totalGraficas){ // Si se alcanzo el 100% de los analitos generados
                        exportacionReporteGraficasCorrelacion();
                    }
                });
                
                chart.draw(dataTable, options);
            }

            function generarGraficoMetodologia(){

                var dataTable = new google.visualization.DataTable();
                dataTable.addColumn('number', 'x');
                dataTable.addColumn('number', 'y');
                dataTable.addColumn({type: 'string', role: 'annotation'});

                let dataElements = [];            
                let conjunto_x = [];
                let conjunto_y = [];
                let cont_mx_realsize = 0;
            
                for (i=0; i<obj_response.muestras.length; i++) {
                    if(obj_response.muestras[i].vrl != "N/A" && obj_response.muestras[i].vav_consenso_metodologia.media != "N/A"){

                        cont_mx_realsize++;
                        dataTable.addColumn('number', "M" + obj_response.muestras[i].no_contador + ' (N=' + obj_response.muestras[i].vav_consenso_metodologia.n + ')');

                        dataElements.push([
                            parseFloat(obj_response.muestras[i].vrl),
                            parseFloat(obj_response.muestras[i].vav_consenso_metodologia.media),
                            "M" + obj_response.muestras[i].no_contador
                        ]);
                        conjunto_x.push(obj_response.muestras[i].vrl);
                        conjunto_y.push(obj_response.muestras[i].vav_consenso_metodologia.media);
                    }
                }

                dataElements = middlewareValuesChart(dataElements, cont_mx_realsize);
                dataTable.addRows(dataElements);

                let options = getOptionsChart('Evaluación consenso QAP misma metodología', conjunto_x, conjunto_y);
                
                let id_config = obj_response.analito.id_configuracion;
                let id_dom = "analito_" + id_config + '_vav_consenso_qap_metodologia';

                $(".contenedor_graficos_correlacion[data-id_analito_lab="+obj_response.analito.id_configuracion+"]").append("<div id="+id_dom+" class='contenedor-grafico'></div>")
                let chart = new google.visualization.ScatterChart(document.getElementById(id_dom));
                
                google.visualization.events.addListener(chart, 'ready', function () {
                    $(".cont-textareas").append("<textarea id='base64_"+id_dom+"'></textarea>");
                    $("#base64_"+id_dom).val(chart.getImageURI());
                    progreso_act = progreso_act + part;
                    $(".progreso").text(Math.round((progreso_act),1));
                    graficasCargadas++; 
                    if(graficasCargadas == totalGraficas){ // Si se alcanzo el 100% de los analitos generados
                        exportacionReporteGraficasCorrelacion();
                    }
                });
                
                chart.draw(dataTable, options);
            }

        }).fail(function (response) {
            alert("Error al generar las gráficas integradas de control de calidad, por favor intente nuevamente...");
        }).always(function (response){
        });
    }
}

function exportacionReporteGraficasCorrelacion(){
    
    let bases64 = [];


    $.each($(".cont-textareas textarea"), function(index, elemento){
        bases64.push({
            "id": $(elemento).attr("id"),
            "val": $(elemento).val()
        });
    });


    let data_xd = {
        laboratorio: $("#id_laboratorio").val(),
        programa: $("#id_programa").val(),
        ronda: $("#id_ronda").val(),
        fechas_corte: $("#fechas_corte").val(),
        bases64
    };

    $.ajax(
        {
            type : "POST",
            cache: false,
            url: "back_fin_ronda.php",
            data: data_xd,
            bases64
        }
    ).done(function(id_document){
        location.href = "../see_fin_ronda.php?referencia=" + id_document;
    }).fail(function(response){
        alert("Error al generar el reporte en PDF");
    }).always(function(response){
        console.log(response);
    });
}


function getOptionsChart(title, conjunto_x, conjunto_y){
    return {
        title: title,
        titleTextStyle: {
            color: '#2874A6',
            fontSize: 17,
            alignment: 'center'
        },
        enableInteractivity: false,
        annotations: {
            boxStyle: {
              rx: 3,
              ry: 3,
              stroke: '#888',
              strokeWidth: 0.8,
              gradient: {
                color1: '#ffffff',
                color2: '#ffffff',
                x1: '0%', y1: '0%',
                x2: '100%', y2: '100%',
                useObjectBoundingBoxUnits: true
              }
            },
            textStyle: {
                fontName: 'Arial',
                fontSize: 17,
                bold: true,
                color: '#333333',
            }
        },
        hAxis: {
            title: "Valor reportado por el laboratorio",
            viewWindow:{
                min:(isNaN(Math.min.apply(null,conjunto_x)) ? NaN : (Math.min.apply(null,conjunto_x) - (Math.max.apply(null,conjunto_x) - Math.min.apply(null,conjunto_x)) * 0.05)),
                max:(isNaN(Math.max.apply(null,conjunto_x)) ? NaN : (Math.max.apply(null,conjunto_x) + (Math.max.apply(null,conjunto_x) - Math.min.apply(null,conjunto_x)) * 0.05))
            }
        },
        vAxis: {
            title: "Valor aceptado como verdadero",
            viewWindow:{
                min:(isNaN(Math.min.apply(null,conjunto_y)) ? NaN : (Math.min.apply(null,conjunto_y) - (Math.max.apply(null,conjunto_y) - Math.min.apply(null,conjunto_y)) * 0.05)),
                max:(isNaN(Math.max.apply(null,conjunto_y)) ? NaN : (Math.max.apply(null,conjunto_y) + (Math.max.apply(null,conjunto_y) - Math.min.apply(null,conjunto_y)) * 0.05))
            }
        },
        series: {
            0: {
                visibleInLegend: false,
            },
            1: {
                visibleInLegend: true
            },
            2: {
                visibleInLegend: true,
                color: '#ffffff'
            },
            3: {
                visibleInLegend: true,
                color: '#ffffff'
            },
            4: {
                visibleInLegend: true,
                color: '#ffffff'
            },
            5: {
                visibleInLegend: true,
                color: '#ffffff'
            },
            6: {
                visibleInLegend: true,
                color: '#ffffff'
            }
        },
        chartArea: {
            width: '70%',
            height: '60%',
            left: '5%'
        },
        legend: {
            position: 'right',
            textStyle: {
                color: '#333',
                fontSize: 15,
            },
            alignment: 'start'
        },
        colors: ["#000"],
        pointShape: 'square',
        pointSize: 8,
        opacity: 0.8,
        trendlines: {
            0: {
                type: 'linear',
                showR2: true,
                visibleInLegend: true,
                color: '#2980B9'
            },
        },
        width: 1000,
        height: 400,
    };
}


function middlewareValuesChart(dataElements, num_muestras){
    if(dataElements.length == 0){
        let array_nan = [];
        for(xd=0; xd < num_muestras; xd++){
            array_nan.push(NaN);
        }
        dataElements.push(Array.prototype.concat([NaN,NaN,""], array_nan));
    } else {
        for(xf=0; xf<dataElements.length; xf++){
            for(xd=0; xd < num_muestras; xd++){
                dataElements[xf].push(NaN);
            }
        }
    }
    console.log(dataElements);
    return dataElements;
}