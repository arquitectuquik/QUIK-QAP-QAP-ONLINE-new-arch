<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

        
    $pdf = new generalInformePAT_Intra('L','mm','letter'); // Página vertical, tamaño carta, medición en Milímetros
    $pdf->AliasNbPages();


    // Inicializar las variables necesarias para la portada
    $pdf->id_laboratorio_pat = $laboratorio_pat;
    $pdf->id_programa_pat = $programa_pat;
    $pdf->id_reto_pat = $reto_pat;

    $pdf->sigla_programa = 0;
    $pdf->nombre_programa = 0;
    $qry = "SELECT sigla,nombre FROM $tbl_programa_pat WHERE id_programa = '$pdf->id_programa_pat'";
	$qryData = mysql_fetch_array(mysql_query($qry));
    $pdf->sigla_programa = $qryData['sigla'];
    $pdf->nombre_programa = $qryData['nombre'];
    
    $pdf->nom_reto = 0;
    $qry = "SELECT nombre FROM $tbl_reto WHERE id_reto = '$pdf->id_reto_pat'";
	$qryData = mysql_fetch_array(mysql_query($qry));
    $pdf->nom_reto = $qryData['nombre'];

    $qry = "SELECT no_laboratorio, nombre_laboratorio FROM $tbl_laboratorio WHERE id_laboratorio = '$pdf->id_laboratorio_pat'";
	$qryData = mysql_fetch_array(mysql_query($qry));
    $num_laboratorio = $qryData['no_laboratorio'];
    $nom_laboratorio = $qryData['nombre_laboratorio'];

    $qry = "SELECT envio FROM $tbl_reto_laboratorio WHERE laboratorio_id_laboratorio = '$pdf->id_laboratorio_pat' and reto_id_reto = '$pdf->id_reto_pat'";
	$qryData = mysql_fetch_array(mysql_query($qry));
    $envio_pat = $pdf->obtenerNomEnvio($qryData['envio']);
    $pdf->envio_pat = $envio_pat;

    // Consulta para obtener los casos clinicos de el reto diligenciado
    $qry = "SELECT id_caso_clinico, codigo, nombre, revision, enunciado, celulas_objetivo, tejido FROM caso_clinico where reto_id_reto = $pdf->id_reto_pat and estado = 1";
    $qryArray = mysql_query($qry);
    mysqlException(mysql_error(),"_01");

    while($qryData = mysql_fetch_array($qryArray)) {
        
        $pdf->distractoresGenerales = array();

        $id_caso_clinico = $qryData["id_caso_clinico"];
        $nom_caso_clinico = $qryData["nombre"];
        $cod_caso_clinico = $qryData["codigo"];
        $historia_clinica = $qryData["enunciado"];
        $celulas_objetivo = $qryData["celulas_objetivo"];
        $tejido = $qryData["tejido"];

        $pdf->num_muestras = 0;
        $qryPregunta = "SELECT distinct
            pregunta.nombre
        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre != 'Diagnóstico'";
        $muestras = array();
        $qryArrayPregunta = mysql_query($qryPregunta);
        mysqlException(mysql_error(),"_01");
        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
            $muestras[] = $qryDataPregunta["nombre"];
        }
        $pdf->num_muestras = sizeof($muestras);
    
    
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true,5);
        $pdf->Ln(5);
        // Impresion de caso clinico
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(17.5,4,"Caso clínico:",0,0,'L',0);
    
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(21,4,$nom_caso_clinico,0,0,'L',0);

        // Impresion de codigo de caso clinico 
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(11.5,4,"Código:",0,0,'L',0);
    
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(19.5,4,$cod_caso_clinico,0,0,'L',0);


        // Fecha de generacion de caso clinico
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(27,4,"Fecha de generación:",0,0,'L',0);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(24,4,Date("Y-m-d h:i"),0,0,'L',0);


        // Laboratorio
        $pdf->SetFont("Arial","B",7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(17,4,"Laboratorio:",0,0,'L',0);
        $pdf->SetFont("Arial","",7);
        $pdf->Cell(70,4,"$num_laboratorio - $nom_laboratorio",0,0,'L',0);
        

        $pdf->SetFont('Arial','B',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Ln(8);

        /* ********************* */
        // Primer nivel
        /* ********************* */
        $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
        $pdf->SetLineWidth($pdf->lineaGruesa);
        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);

        $widthTotalMuestras = 240;
        $widthMIndividual = $widthTotalMuestras / sizeof($muestras);
       
        $pdf->Cell(18,5,"-","TLR",0,'C',1);

        for($x=0; $x < sizeof($muestras);$x++){
            $pdf->Cell($widthMIndividual,5,$muestras[$x],"TLR",0,'C',1);
        }

        /* ********************* */
        // Segundo nivel
        /* ********************* */

        $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
        $pdf->SetX(28);

        $nombresEncabezados = array();
        $bordesIzqEncabezados = array();
        $bordesDerEncabezados = array();
        $coloresFondoEncabezados = array();
        $anchosEncabezados = array();
        $array_colores_texto = array();
        
        array_push($nombresEncabezados, "-");
        array_push($bordesIzqEncabezados, true);
        array_push($bordesDerEncabezados, false);
        array_push($coloresFondoEncabezados, $pdf->azulFondoP);
        array_push($anchosEncabezados, 18);

        // muestras patron de tincion
        for($x=0; $x < sizeof($muestras);$x++){
            array_push($bordesIzqEncabezados, true);
            array_push($bordesDerEncabezados, false);
            array_push($coloresFondoEncabezados, $pdf->azulFondoP);
            array_push($anchosEncabezados, ($widthMIndividual/3));
            array_push($array_colores_texto, $pdf->negro);
            array_push($nombresEncabezados, "Control Ratio");
            
            array_push($bordesDerEncabezados, false);
            array_push($bordesIzqEncabezados, false);
            array_push($coloresFondoEncabezados, $pdf->azulFondoP);
            array_push($anchosEncabezados, ($widthMIndividual/3));
            array_push($array_colores_texto, $pdf->negro);
            array_push($nombresEncabezados, "Avg/cell");
            
            array_push($bordesIzqEncabezados, false);
            array_push($bordesDerEncabezados, true);
            array_push($coloresFondoEncabezados, $pdf->azulFondoP);
            array_push($anchosEncabezados, ($widthMIndividual/3));
            array_push($array_colores_texto, $pdf->negro);
            array_push($nombresEncabezados, "Interpretation");
        }
        
        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosEncabezados);
        $pdf->SetHeightRow(5);
        $pdf->Ln(5);
        $pdf->SetFillColorsRow($coloresFondoEncabezados);
        $pdf->SetTextColorsRow($array_colores_texto);
        $pdf->SetGrossLineLeftRow($bordesIzqEncabezados);
        $pdf->SetGrossLineRightRow($bordesDerEncabezados);
        $pdf->RowCYH($nombresEncabezados);

        
        /* ********************* */
        // Tercer nivel
        /* ********************* */

        
        $pdf->respuestas = array();
    
        for($dsb=0;$dsb<sizeof($muestras);$dsb++){
            $nom_muestra_act = $muestras[$dsb];
            
            /* ********************************* */
            // CUANTITATIVA 1
            /* ********************************* */
            
            /* 
            
            ***** CONTROL DE CAMBIOS | 31 de agosto de 2021 *****
            Se cambia el valor 'HER2/Control Ratio' por 'HER2 Avg/cell' en la consulta: $qryPregunta1 dado que en la generación del informe de intralaboratorio PAT 
            los valores de las columnas Control Ratio y Avg/cell estaban intercambiados.
            
            */
            $qryPregunta1 = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'HER2 Avg/cell' and pregunta.nombre = '".$nom_muestra_act."'";
            $qryDataPregunta1 = mysql_fetch_array(mysql_query($qryPregunta1));
            mysqlException(mysql_error(),"_03");
            $id_pregunta1 = $qryDataPregunta1["id_pregunta"];
            $nombre_pregunta1 = $qryDataPregunta1["nombre"];
            array_push($pdf->respuestas, [
                "id_pregunta" => $id_pregunta1, 
                "nombre_pregunta" => $nombre_pregunta1, 
                "tipo_pregunta" => "cuantitativa_1", 
                "respuestas" => array(), 
                "respuestas_patologos" => array()
            ]);


            $sizeofmuestras1 = sizeof($pdf->respuestas);

            $qryPreguntaSub1 = "SELECT concat(intervalo_min, ' - ', intervalo_max) as intervalo
                                from pregunta
                                where id_pregunta = $id_pregunta1";
            $qryArrayPreguntaSub1 = mysql_query($qryPreguntaSub1);  
            while($qryDataPreguntaSub1 = mysql_fetch_array($qryArrayPreguntaSub1)) {
                array_push($pdf->respuestas[($sizeofmuestras1-1)]["respuestas"], $qryDataPreguntaSub1["intervalo"]);
            }

            $sizeofmuestras = sizeof($pdf->respuestas);
        
            // Query para obtener los intentos de cuantitativa_1
            $qryArrayCuantitativa1 = "SELECT
                usuario.cod_usuario,
                respuesta_cuantitativa
            from 
                intento
                join respuesta_lab on intento.id_intento = respuesta_lab.intento_id_intento
                join usuario on usuario.id_usuario = intento.usuario_id_usuario
            where respuesta_lab.pregunta_id_pregunta = $id_pregunta1 and intento.id_intento in (
                select max(id_intento)
                from intento
                where reto_id_reto = $reto_pat
                group by laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto
            )";

            $qryArrayCuantitativa1 = mysql_query($qryArrayCuantitativa1);  
            while($qryDataCuantitativa1 = mysql_fetch_array($qryArrayCuantitativa1)) {
                
                array_push($pdf->respuestas[($sizeofmuestras-1)]["respuestas_patologos"], [
                        "cod_patologo" => $qryDataCuantitativa1["cod_usuario"], 
                        "respuesta_cuantitativa" => $qryDataCuantitativa1["respuesta_cuantitativa"]
                    ]
                );
            }

            
            /* ********************************* */
            // CUANTITATIVA 2
            /* ********************************* */
            
            /* 
            
            ***** CONTROL DE CAMBIOS | 31 de agosto de 2021 *****
            Se cambia el valor 'HER2 Avg/cell' por 'HER2/Control Ratio' en la consulta: $qryPregunta2 dado que en la generación del informe de intralaboratorio PAT 
            los valores de las columnas Control Ratio y Avg/cell estaban intercambiados.
            
            */
            $qryPregunta2 = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'HER2/Control Ratio' and pregunta.nombre = '".$nom_muestra_act."'";
            $qryDataPregunta2 = mysql_fetch_array(mysql_query($qryPregunta2));
            mysqlException(mysql_error(),"_03");
            $id_pregunta2 = $qryDataPregunta2["id_pregunta"];
            $nombre_pregunta2 = $qryDataPregunta2["nombre"];
            array_push($pdf->respuestas, [
                "id_pregunta" => $id_pregunta2, 
                "nombre_pregunta" => $nombre_pregunta2, 
                "tipo_pregunta" => "cuantitativa_2", 
                "respuestas" => array(), 
                "respuestas_patologos" => array()
            ]);


            $sizeofmuestras2 = sizeof($pdf->respuestas);

            $qryPreguntaSub2 = "SELECT concat(intervalo_min, ' - ', intervalo_max) as intervalo
                                from pregunta
                                where id_pregunta = $id_pregunta2";
            $qryArrayPreguntaSub2 = mysql_query($qryPreguntaSub2);  
            while($qryDataPreguntaSub2 = mysql_fetch_array($qryArrayPreguntaSub2)) {
                array_push($pdf->respuestas[($sizeofmuestras2-1)]["respuestas"], $qryDataPreguntaSub2["intervalo"]);
            }

            $sizeofmuestras = sizeof($pdf->respuestas);
        
            // Query para obtener los intentos de cuantitativa_2
            $qryArrayCuantitativa2 = "SELECT
                usuario.cod_usuario,
                respuesta_cuantitativa
            from 
                intento
                join respuesta_lab on intento.id_intento = respuesta_lab.intento_id_intento
                join usuario on usuario.id_usuario = intento.usuario_id_usuario
            where respuesta_lab.pregunta_id_pregunta = $id_pregunta2 and intento.id_intento in (
                select max(id_intento)
                from intento
                where reto_id_reto = $reto_pat
                group by laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto
            )";

            $qryArrayCuantitativa2 = mysql_query($qryArrayCuantitativa2);  
            while($qryDataCuantitativa2 = mysql_fetch_array($qryArrayCuantitativa2)) {
                
                array_push($pdf->respuestas[($sizeofmuestras-1)]["respuestas_patologos"], [
                        "cod_patologo" => $qryDataCuantitativa2["cod_usuario"], 
                        "respuesta_cuantitativa" => $qryDataCuantitativa2["respuesta_cuantitativa"]
                    ]
                );
            }

            /* ********************************* */
            // CUANTITATIVA 3
            /* ********************************* */
            $qryPregunta3 = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Interpretation' and pregunta.nombre = '".$nom_muestra_act."'";
            $qryDataPregunta3 = mysql_fetch_array(mysql_query($qryPregunta3));
            mysqlException(mysql_error(),"_03");
            $id_pregunta3 = $qryDataPregunta3["id_pregunta"];
            $nombre_pregunta3 = $qryDataPregunta3["nombre"];
            array_push($pdf->respuestas, [
                "id_pregunta" => $id_pregunta3, 
                "nombre_pregunta" => $nombre_pregunta3, 
                "tipo_pregunta" => "diagnostico", 
                "respuestas" => array(), 
                "respuestas_patologos" => array()
            ]);


            $sizeofmuestras3 = sizeof($pdf->respuestas);

            $qryDistractor3 = "SELECT id_distractor,
                                        distractor.abreviatura as 'nombre',
                                        valor
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta3 and valor > 0
                    limit 1";
            $qryArrayDistractor3 = mysql_query($qryDistractor3);  
            while($qryDataDistractor3 = mysql_fetch_array($qryArrayDistractor3)) {
                array_push($pdf->respuestas[($sizeofmuestras3-1)]["respuestas"], [
                    "id_distractor" => $qryDataDistractor3["id_distractor"], 
                    "nombre" => $qryDataDistractor3["nombre"],
                    "valor" => $qryDataDistractor3["valor"]
                ]);
            }

            $sizeofmuestras3 = sizeof($pdf->respuestas);


            $qryArrayDistractorPAT3 = "SELECT
                    usuario.cod_usuario,
                    distractor.id_distractor,
                    distractor.abreviatura as nombre
            from 
                intento
                join respuesta_lab on intento.id_intento = respuesta_lab.intento_id_intento
                join distractor on id_distractor = respuesta_lab.distractor_id_distractor
                join usuario on usuario.id_usuario = intento.usuario_id_usuario
            where respuesta_lab.pregunta_id_pregunta = $id_pregunta3 and intento.id_intento in (
                select max(id_intento)
                from intento
                where reto_id_reto = $reto_pat
                group by laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto
            )";

            $qryArrayDistractorPAT3 = mysql_query($qryArrayDistractorPAT3);  
            while($qryDataDistractorPAT3 = mysql_fetch_array($qryArrayDistractorPAT3)) {
                
                array_push($pdf->respuestas[($sizeofmuestras3-1)]["respuestas_patologos"], [
                    "cod_patologo" => $qryDataDistractorPAT3["cod_usuario"], 
                    "id_distractor" => $qryDataDistractorPAT3["id_distractor"], 
                    "nombre" => $qryDataDistractorPAT3["nombre"]]
                );
            }
        }



        /* **************************************** */
        // Impresion de los valores predeterminados
        /* **************************************** */

        $array_FCR = array();
        $array_GLLR = array();
        $array_GLRR = array();
        $array_NR = array();
        array_push($array_FCR, $pdf->gris);
        array_push($array_GLLR, true);
        array_push($array_GLRR, false);
        array_push($array_NR,"Results");
        
        for($xsdf=0; $xsdf<sizeof($pdf->respuestas); $xsdf++){
            $pregunta_exacta_act = $pdf->respuestas[$xsdf];

            array_push($array_FCR, $pdf->gris);

            if(($xsdf%3) == 0){ 
                array_push($array_GLLR, true); 
            } else { 
                array_push($array_GLLR, false);
            }

            if(($xsdf+1)== sizeof($pdf->respuestas)){
                array_push($array_GLRR, true);
            } else {
                array_push($array_GLRR, false);
            }

            
            $cadena_distractores_act = "";

            switch($pregunta_exacta_act["tipo_pregunta"]){
                case "cuantitativa_1":
                case "cuantitativa_2":
                    for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                        $distractor_actual = $pregunta_exacta_act["respuestas"][$dfdd];
                        
                        if($dfdd==0){
                            $cadena_distractores_act = $distractor_actual;
                        } else {
                            $cadena_distractores_act = $cadena_distractores_act . "\n" . $distractor_actual;
                        }
                    }
                    break;

                case "diagnostico":
                    for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                        $distractor_actual = $pregunta_exacta_act["respuestas"][$dfdd]["nombre"];
                        $valor_distractor_actual = round($pregunta_exacta_act["respuestas"][$dfdd]["valor"],1);
                        
                        if($dfdd==0){
                            $cadena_distractores_act = $distractor_actual . " ($valor_distractor_actual%)";
                        } else {
                            $cadena_distractores_act = $cadena_distractores_act . "\n" . $distractor_actual . " ($valor_distractor_actual%)";
                        }
                    }
                    break;
            } 

            array_push($array_NR, $cadena_distractores_act);
        }

        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosEncabezados);
        $pdf->SetHeightRow(4);


        $pdf->SetFont('Arial','B',6);
        $pdf->SetFillColorsRow($array_FCR);
        $pdf->SetGrossLineLeftRow($array_GLLR);
        $pdf->SetGrossLineRightRow($array_GLRR);
        $pdf->RowCYH($array_NR);
        $pdf->SetFont('Arial','',6);

        /* ********************************************* */
        // Impresion de resultados de los laboratorios
        /* ********************************************* */

        // Obtener todos los patólogos que estén para habilitados para el laboratorio
        $qryArrayUsersPAT = "SELECT DISTINCT
            usuario.*
        from 
            laboratorio 
            join usuario_laboratorio on laboratorio.id_laboratorio = usuario_laboratorio.id_laboratorio 
            join usuario on usuario.id_usuario = usuario_laboratorio.id_usuario
            join intento on laboratorio.id_laboratorio = intento.laboratorio_id_laboratorio and usuario.id_usuario = intento.usuario_id_usuario    
        where laboratorio.id_laboratorio = $laboratorio_pat and intento.reto_id_reto = $reto_pat
        order by usuario.cod_usuario
        ";
        $qryArrayUsersPAT = mysql_query($qryArrayUsersPAT);
        mysqlException(mysql_error(),"_02");

        $usuarios_pat = array();

        while($qryDataUsuariosPAT = mysql_fetch_array($qryArrayUsersPAT)) {
            $usuario_pat = array();
            $usuario_pat["id_usuario"] = $qryDataUsuariosPAT["id_usuario"];
            $usuario_pat["nombre_usuario"] = $qryDataUsuariosPAT["nombre_usuario"];
            $usuario_pat["cod_usuario"] = $qryDataUsuariosPAT["cod_usuario"];
            $usuarios_pat[] = $usuario_pat;
        }


        $diagnosticos_concordantes = 0;
        $diagnosticos_noconcordantes = 0;

        for($count_pat=0; $count_pat<sizeof($usuarios_pat) ; $count_pat++){
            $array_FCR = array();
            $array_TCR = array();
            $array_GLLR = array();
            $array_GLRR = array();
            $array_NR = array();

            array_push($array_TCR, $pdf->negro);
            array_push($array_FCR, $pdf->blanco);

            array_push($array_GLLR, true);
            array_push($array_GLRR, false);

            array_push($array_NR,$usuarios_pat[$count_pat]["cod_usuario"]);


            // Recorrido de cada una de las preguntas
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas[$xsdf];
        
                if(($xsdf%3) == 0){ 
                    array_push($array_GLLR, true); 
                } else { 
                    array_push($array_GLLR, false);
                }
    
                if(($xsdf+1)== sizeof($pdf->respuestas)){
                    array_push($array_GLRR, true);
                } else {
                    array_push($array_GLRR, false);
                }
        
                switch($pregunta_exacta_act["tipo_pregunta"]){
                    case "cuantitativa_1":
                    case "cuantitativa_2":

                        if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($pregunta_exacta_act["respuestas_patologos"], "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos

                            // Esta linea imprime los valores que necesito modificar
                            $respuesta_cuantitativa = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["respuesta_cuantitativa"];
                            array_push($array_FCR, $pdf->blanco);
                            array_push($array_TCR, $pdf->negro);
                            array_push($array_NR, $respuesta_cuantitativa);

                        } else {
                            array_push($array_TCR, $pdf->negro);
                            array_push($array_FCR, $pdf->blanco);
                            array_push($array_NR, "N/A"); 
                        }

                        break;
    
                    case "diagnostico":

                        $id_respuestas_correctas = array();
                        for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                            array_push($id_respuestas_correctas,$pregunta_exacta_act["respuestas"][$dfdd]["id_distractor"]);
                        }
                        

                        if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($pregunta_exacta_act["respuestas_patologos"], "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                            // Obtendra la primera respuesta que encuentra de esa pregunta
                            $id_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["id_distractor"];
                            $nombre_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["nombre"];
        
                            $criterioAct = $pdf->obtenerCriterioCYH($id_respuesta_pat, $id_respuestas_correctas);
        
        
                            if($criterioAct){
                                $colorFondoAct = $pdf->verde;
                                $diagnosticos_concordantes++;
                            } else {
                                $colorFondoAct = $pdf->rojo;
                                $diagnosticos_noconcordantes++;
                            }
                            array_push($array_FCR, $colorFondoAct);
                            array_push($array_TCR, $pdf->negro);
                            array_push($array_NR, $nombre_respuesta_pat);
        
                        } else {
                            // Se va a imprimir un N/A                   
                            array_push($array_TCR, $pdf->negro);
                            array_push($array_FCR, $pdf->blanco);
                            array_push($array_NR, "N/A"); 
                        }
                        break;
                }

            } // Fin de bucle para el recorrdo de preguntas

            $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
            $pdf->SetWidths($anchosEncabezados);
            $pdf->SetHeightRow(5);
            $pdf->SetFillColorsRow($array_FCR);
            $pdf->SetTextColorsRow($array_TCR);
            $pdf->SetGrossLineLeftRow($array_GLLR);
            $pdf->SetGrossLineRightRow($array_GLRR);
            $pdf->RowCYH($array_NR);
        }


        /* *************************************************** */
        // Seccion de interpretacion
        /* *************************************************** */
        $pdf->Ln(3);
        $pdf->SetX(10);
        $pdf->SetTextColor($pdf->negro[0],$pdf->negro[1], $pdf->negro[2]);
        $pdf->SetFont("Arial","B",7);
        $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
        $pdf->Cell(21,3.5,"Interpretación:",0,0,'C',1);
        $pdf->SetFont("Arial","",7);
        $pdf->SetFillColor($pdf->verde[0],$pdf->verde[1], $pdf->verde[2]);
        $pdf->Cell(20,3.5,"Concordante",0,0,'C',1);
        $pdf->SetFillColor($pdf->rojo[0],$pdf->rojo[1], $pdf->rojo[2]);
        $pdf->Cell(20,3.5,"No concordante",0,0,'C',1);

        /* *************************************************** */
        // Seccion de calculos de resultados
        /* *************************************************** */
        
        // Primer nivel
        $pdf->Ln(11);
        $pdf->SetFillColor(255,255,255);
        $pdf->SetDrawColor(21, 67, 96);
    
    
        $left_valest  = 40;
        $anchoValEst = 100;

        $anchoContGrafica = 115;
        $altoContGrafica = 61.82; 

        $pdf->SetFont("Arial","B",6);
        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
        $pdf->SetLineWidth(0.3);
        $pdf->SetX($left_valest);
        $pdf->Cell($anchoValEst,5,"Todos los distractores del caso clínico",1,0,'C',1);


        /* ***************************************************** */
        // Gráfica
        /* ***************************************************** */
  
        $ruta_image = $pdf->generarGraficoCYH($diagnosticos_concordantes,$diagnosticos_noconcordantes);
        $xImage = $anchoValEst + $left_valest;
        $yImage = $pdf->GetY() - 5;
        
        $pdf->Image($ruta_image,$xImage,$yImage,$anchoContGrafica, $altoContGrafica);
        unlink($ruta_image);
        
        $pdf->Ln(5);
        $anchoSeccionP = 40;
        $anchoMarcador2 = ($anchoValEst - $anchoSeccionP) / ($pdf->num_muestras);

        /* ***************************************************** */
        // Continuacion de la informacion del resumen
        /* ***************************************************** */

        $pdf->SetFont("Arial","",6);
        $pdf->setX($left_valest);
        $pdf->SetAligns(array("C","C"));
        $pdf->SetWidths([35, 65]);
        $pdf->SetHeightRow(4);
        $pdf->SetFillColorsRow([$pdf->gris,$pdf->gris]);
        $pdf->SetTextColorsRow([$pdf->negro,$pdf->negro]);
        $pdf->SetGrossLineLeftRow([true, false]);
        $pdf->SetGrossLineRightRow([false, true]);
        $pdf->RowCYH(["Abreviatura", "Descripción"]);
        

        // Traer la pregunta del diagnostico
        $qryPreguntaRP = "SELECT
            pregunta.id_pregunta,
            pregunta.nombre
        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Interpretation'
        limit 1";

        $qryArrayPreguntaRP = mysql_query($qryPreguntaRP);
        mysqlException(mysql_error(),"_01");

        while($qryDataPregunta = mysql_fetch_array($qryArrayPreguntaRP)) {
            $id_pregunta = $qryDataPregunta["id_pregunta"];

            $qryDistractorRP = "SELECT
                    nombre,
                    abreviatura
                from distractor
                where pregunta_id_pregunta = $id_pregunta";

            $qryArrayDistractorRP = mysql_query($qryDistractorRP);
            mysqlException(mysql_error(),"_01");

            while($qryDataDistractorRP = mysql_fetch_array($qryArrayDistractorRP)) {
                $nombre = $qryDataDistractorRP["nombre"];
                $abreviatura = $qryDataDistractorRP["abreviatura"];

                $pdf->SetFont("Arial","",6);
                $pdf->setX($left_valest);
                $pdf->SetAligns(array("C","C"));
                $pdf->SetWidths([35, 65]);
                $pdf->SetHeightRow(4);
                $pdf->SetFillColorsRow([$pdf->blanco,$pdf->blanco]);
                $pdf->SetTextColorsRow([$pdf->negro,$pdf->negro]);
                $pdf->SetGrossLineLeftRow([true, false]);
                $pdf->SetGrossLineRightRow([false, true]);
                $pdf->RowCYH([$abreviatura, $nombre]);
            }
        }
        
        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        $pdf->SetX(40);
        $pdf->Cell(100,1,"","T",0,'C',0);
    }

    $pdf->SetX(12);
    $pdf->Ln(27);


    $pdf->SetFont("Arial","B",6.2);
    
    
    if($pdf->GetY() > 180.25){ // Si el alto es mayor al cupo para la firma
        $pdf->AddPage();
    }
    
    $pdf->SetFillColor(0,0,0);
    $pdf->MultiCell(260,3,"- Final del reporte -\n    Página ". $pdf->PageNo(). " de {nb}\n",0,'C',0);
    $pdf->MultiCell(260,3,"\n\n\n\nAprobado por:\nAída Porras. Magister en Biología. Doctor in management.\nCoordinadora Programas de Patología Anatómica Quik S.A.S.",0,'C',0);
    

    // Cerrar PDF
    $pdf->Close();

    $nomArchivo = utf8_decode("$num_laboratorio - Intralaboratorio CAP-CYH $pdf->nom_reto $nom_laboratorio.pdf");
    $pdf->Output("I",$nomArchivo);

?>