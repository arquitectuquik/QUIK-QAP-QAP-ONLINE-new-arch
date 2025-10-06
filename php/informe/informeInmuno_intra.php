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
    $qry = "SELECT id_caso_clinico, codigo, nombre, revision FROM caso_clinico where reto_id_reto = $pdf->id_reto_pat and estado = 1";
    $qryArray = mysql_query($qry);
    mysqlException(mysql_error(),"_01");

    while($qryData = mysql_fetch_array($qryArray)) {
        
        $pdf->distractoresGenerales = array();

        $id_caso_clinico = $qryData["id_caso_clinico"];
        $nom_caso_clinico = $qryData["nombre"];
        $cod_caso_clinico = $qryData["codigo"];

        $pdf->num_marcadores = 0;
        $qryPregunta = "SELECT distinct
            pregunta.nombre
        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre != 'Diagnóstico'";
        $marcadores = array();
        $qryArrayPregunta = mysql_query($qryPregunta);
        mysqlException(mysql_error(),"_01");
        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
            $marcadores[] = $qryDataPregunta["nombre"];
        }
        $pdf->num_marcadores = sizeof($marcadores);
    
    
        $pdf->AddPage(); // Portada
        $pdf->SetAutoPageBreak(true,5);
        $pdf->Ln(5);
        // Impresion de caso clinico
        $pdf->SetFont('Arial','B',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(16,4,"Caso clínico:",0,0,'L',0);
    
        $pdf->SetFont('Arial','',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(22,4,$nom_caso_clinico,0,0,'L',0);

        // Impresion de codigo de caso clinico 
        $pdf->SetFont('Arial','B',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(10,4,"Código:",0,0,'L',0);
    
        $pdf->SetFont('Arial','',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(22,4,$cod_caso_clinico,0,0,'L',0);


        // Fecha de generacion de caso clinico
        $pdf->SetFont('Arial','B',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(25,4,"Fecha de generación:",0,0,'L',0);
        $pdf->SetFont('Arial','',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(26,4,Date("Y-m-d h:i"),0,0,'L',0);


        // Laboratorio
        $pdf->SetFont("Arial","B",6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(15,4,"Laboratorio:",0,0,'L',0);
        $pdf->SetFont("Arial","",6);
        $pdf->Cell(70,4,"$num_laboratorio - $nom_laboratorio",0,0,'L',0);
        
    
        // Impresion de la tabla de comparacion
        $ancho_total_marcadores = 197;
        $ancho_total_patron_tincion = 0.333;
        $ancho_total_intensidad_tincion = 0.333;
        $ancho_total_pcp = 0.333;
    
        $ancho_marcador_patron_tincion = ($ancho_total_marcadores * $ancho_total_patron_tincion) / $pdf->num_marcadores;
        $ancho_marcador_intensidad_tincion = ($ancho_total_marcadores * $ancho_total_intensidad_tincion) / $pdf->num_marcadores;
        $ancho_marcador_pcp = ($ancho_total_marcadores * $ancho_total_pcp) / $pdf->num_marcadores;
    
        $pdf->SetFont('Arial','B',6);
        $pdf->SetTextColor(40, 40, 40);
    
        $pdf->Ln(8);
    
        // Primer nivel
        $pdf->SetFillColor(255,255,255);
        $pdf->SetLineWidth($pdf->lineaGruesa);
        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        $pdf->Cell(18,5,"-","TLR",0,'C',1);

        $pdf->Cell(($ancho_marcador_patron_tincion * $pdf->num_marcadores),5,"Patrón de tinción","TL",0,'C',1);
        $pdf->Cell(($ancho_marcador_intensidad_tincion * $pdf->num_marcadores),5,"Intensidad de tinción","TL",0,'C',1);
        $pdf->Cell(($ancho_marcador_pcp * $pdf->num_marcadores),5,"% de células positivas","TL",0,'C',1);
    
        // Final
        $pdf->Cell(45,5,"-","TLR",0,'C',1);


        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        $pdf->SetLineWidth($pdf->lineaGruesa);
        
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
        
        array_push($nombresEncabezados, "Marcador");
        array_push($bordesIzqEncabezados, true);
        array_push($bordesDerEncabezados, false);
        array_push($coloresFondoEncabezados, $pdf->blanco);
        array_push($anchosEncabezados, 18);

        // Marcadores patron de tincion
        for($x=0; $x < sizeof($marcadores);$x++){
            array_push($nombresEncabezados, $marcadores[$x]);
            if($x==0){
                array_push($bordesIzqEncabezados, true);
            } else {
                array_push($bordesIzqEncabezados, false);
            }
            array_push($bordesDerEncabezados, false);
            array_push($coloresFondoEncabezados, $pdf->blanco);
            array_push($anchosEncabezados, $ancho_marcador_patron_tincion);
        }

        // Marcadores intensidad de tincion
        for($x=0; $x < sizeof($marcadores);$x++){
            array_push($nombresEncabezados, $marcadores[$x]);
            if($x==0){
                array_push($bordesIzqEncabezados, true);
            } else {
                array_push($bordesIzqEncabezados, false);
            }
            array_push($bordesDerEncabezados, false);
            array_push($coloresFondoEncabezados, $pdf->blanco);
            array_push($anchosEncabezados, $ancho_marcador_intensidad_tincion);
        }


        // Marcadores % de celulas positivas
        for($x=0; $x < sizeof($marcadores);$x++){
            array_push($nombresEncabezados, $marcadores[$x]);
            if($x==0){
                array_push($bordesIzqEncabezados, true);
            } else {
                array_push($bordesIzqEncabezados, false);
            }
            array_push($bordesDerEncabezados, false);
            array_push($coloresFondoEncabezados, $pdf->blanco);
            array_push($anchosEncabezados, $ancho_marcador_pcp);
        }
        
        array_push($nombresEncabezados, "Valoración diagnóstica de referencia");
        array_push($anchosEncabezados, 45);
        array_push($bordesIzqEncabezados, true);
        array_push($bordesDerEncabezados, true);
        array_push($coloresFondoEncabezados, $pdf->blanco);
        
        
        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosEncabezados);
        $pdf->SetHeightRow(4);
        $pdf->Ln(5);
        
        $pdf->SetFillColorsRow($coloresFondoEncabezados);
        $pdf->SetGrossLineLeftRow($bordesIzqEncabezados);
        $pdf->SetGrossLineRightRow($bordesDerEncabezados);
        $pdf->RowIHQ($nombresEncabezados);
        
        
        /* ********************* */
        // Tercer nivel
        /* ********************* */

        /* ****************************************************************** */
        // Definicion de respuestas correctas para cada uno de los marcadores  
        /* ****************************************************************** */

        $pdf->respuestas = array(
            "patron_tincion" => array(),
            "intensidad_tincion" => array(),
            "porcentaje_celulas_positivas" => array(),
            "diagnostico" => array()
        );

        for($dsb=0;$dsb<sizeof($marcadores);$dsb++){
            
            $nom_marcador_act = $marcadores[$dsb];

            /* *************************************************** */
            // Obtener preguntas correctas del patron de tinción
            /* *************************************************** */
            $qryPregunta = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Patrón de tinción' and pregunta.nombre = '".$nom_marcador_act."'";
            $qryDataPregunta = mysql_fetch_array((mysql_query($qryPregunta)));
            mysqlException(mysql_error(),"_03");
            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];
            array_push($pdf->respuestas["patron_tincion"], [
                "id_pregunta" => $id_pregunta, 
                "nombre_pregunta" => $nombre_pregunta, 
                "respuestas" => array(), 
                "respuestas_patologos" => array()
            ]);
            
            $sizeofmarcadores= sizeof($pdf->respuestas["patron_tincion"]);
            
            $qryDistractor = "SELECT id_distractor,nombre
                              from distractor
                              where pregunta_id_pregunta = $id_pregunta and valor > 0";
            $qryArrayDistractor = mysql_query($qryDistractor);  
            while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                array_push($pdf->respuestas["patron_tincion"][($sizeofmarcadores-1)]["respuestas"], ["id_distractor" => $qryDataDistractor["id_distractor"], "nombre" => $qryDataDistractor["nombre"]]);
            }

            // Aqui va a ir el query para obtener los intentos de patron de tincion para esta pregunta
            $qryArrayDistractorPAT = "SELECT
                usuario.cod_usuario,
                distractor.id_distractor,
                distractor.nombre
            from 
                intento
                join respuesta_lab on intento.id_intento = respuesta_lab.intento_id_intento
                join distractor on id_distractor = respuesta_lab.distractor_id_distractor
                join usuario on usuario.id_usuario = intento.usuario_id_usuario
            where respuesta_lab.pregunta_id_pregunta = $id_pregunta and intento.id_intento in (
                select max(id_intento)
                from intento
                where reto_id_reto = $reto_pat
                group by laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto
            )";
            $qryArrayDistractorPAT = mysql_query($qryArrayDistractorPAT);  
            while($qryDataDistractorPAT = mysql_fetch_array($qryArrayDistractorPAT)) {
                array_push($pdf->respuestas["patron_tincion"][($sizeofmarcadores-1)]["respuestas_patologos"], ["cod_patologo" => $qryDataDistractorPAT["cod_usuario"], "id_distractor" => $qryDataDistractorPAT["id_distractor"], "nombre" => $qryDataDistractorPAT["nombre"]]);
            }


            /* *********************************************** */
            // Obtener preguntas correctas de la intensidad de tinción
            /* *********************************************** */
            
            $qryPregunta = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de tinción' and pregunta.nombre = '".$nom_marcador_act."'";
            $qryDataPregunta = mysql_fetch_array((mysql_query($qryPregunta)));
            mysqlException(mysql_error(),"_03");
            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];
            array_push($pdf->respuestas["intensidad_tincion"], [
                "id_pregunta" => $id_pregunta, 
                "nombre_pregunta" => $nombre_pregunta, 
                "respuestas" => array(), 
                "respuestas_patologos" => array()
            ]);
            
            $sizeofmarcadores= sizeof($pdf->respuestas["intensidad_tincion"]);
            
            $qryDistractor = "SELECT id_distractor,nombre
                              from distractor
                              where pregunta_id_pregunta = $id_pregunta and valor > 0";
            $qryArrayDistractor = mysql_query($qryDistractor);  
            while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                array_push($pdf->respuestas["intensidad_tincion"][($sizeofmarcadores-1)]["respuestas"], ["id_distractor" => $qryDataDistractor["id_distractor"], "nombre" => $qryDataDistractor["nombre"]]);
            }

            // Aqui va a ir el query para obtener los intentos de intensidad de tincion para esta pregunta
            $qryArrayDistractorPAT = "SELECT
                usuario.cod_usuario,
                distractor.id_distractor,
                distractor.nombre
            from 
                intento
                join respuesta_lab on intento.id_intento = respuesta_lab.intento_id_intento
                join distractor on id_distractor = respuesta_lab.distractor_id_distractor
                join usuario on usuario.id_usuario = intento.usuario_id_usuario
            where respuesta_lab.pregunta_id_pregunta = $id_pregunta and intento.id_intento in (
                select max(id_intento)
                from intento
                where reto_id_reto = $reto_pat
                group by laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto
            )";
            $qryArrayDistractorPAT = mysql_query($qryArrayDistractorPAT);  
            while($qryDataDistractorPAT = mysql_fetch_array($qryArrayDistractorPAT)) {
                array_push($pdf->respuestas["intensidad_tincion"][($sizeofmarcadores-1)]["respuestas_patologos"], ["cod_patologo" => $qryDataDistractorPAT["cod_usuario"], "id_distractor" => $qryDataDistractorPAT["id_distractor"], "nombre" => $qryDataDistractorPAT["nombre"]]);
            }


            /* *************************************************************** */
            // Obtener preguntas correctas del procentaje de celulas positivas
            /* *************************************************************** */

            
            $qryPregunta = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Porcentaje de células positivas' and pregunta.nombre = '".$nom_marcador_act."'";
            $qryDataPregunta = mysql_fetch_array((mysql_query($qryPregunta)));
            mysqlException(mysql_error(),"_03");
            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];
            array_push($pdf->respuestas["porcentaje_celulas_positivas"], ["id_pregunta" => $id_pregunta, "nombre_pregunta" => $nombre_pregunta, "respuestas" => array(), "respuestas_patologos" => array()]);
            $sizeofmarcadores= sizeof($pdf->respuestas["porcentaje_celulas_positivas"]);
            $qryDistractor = "SELECT id_distractor,nombre
                              from distractor
                              where pregunta_id_pregunta = $id_pregunta and valor > 0";
            $qryArrayDistractor = mysql_query($qryDistractor);  
            while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                array_push($pdf->respuestas["porcentaje_celulas_positivas"][($sizeofmarcadores-1)]["respuestas"], ["id_distractor" => $qryDataDistractor["id_distractor"], "nombre" => $qryDataDistractor["nombre"]]);
            }


            // Aqui va a ir el query para obtener los intentos de patron de celulas positivas
            $qryArrayDistractorPAT = "SELECT
                usuario.cod_usuario,
                distractor.id_distractor,
                distractor.nombre
            from 
                intento
                join respuesta_lab on intento.id_intento = respuesta_lab.intento_id_intento
                join distractor on id_distractor = respuesta_lab.distractor_id_distractor
                join usuario on usuario.id_usuario = intento.usuario_id_usuario
            where respuesta_lab.pregunta_id_pregunta = $id_pregunta and intento.id_intento in (
                select max(id_intento)
                from intento
                where reto_id_reto = $reto_pat
                group by laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto
            )";
            $qryArrayDistractorPAT = mysql_query($qryArrayDistractorPAT);  
            while($qryDataDistractorPAT = mysql_fetch_array($qryArrayDistractorPAT)) {
                array_push($pdf->respuestas["porcentaje_celulas_positivas"][($sizeofmarcadores-1)]["respuestas_patologos"], ["cod_patologo" => $qryDataDistractorPAT["cod_usuario"], "id_distractor" => $qryDataDistractorPAT["id_distractor"], "nombre" => $qryDataDistractorPAT["nombre"]]);
            }
        }

        /* ************************************************************ */
        // Obtener preguntas correctas del diagnostico
        /* ************************************************************ */

        
        $qryPregunta = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";
        $qryDataPregunta = mysql_fetch_array((mysql_query($qryPregunta)));
        mysqlException(mysql_error(),"_03");
        $id_pregunta = $qryDataPregunta["id_pregunta"];
        $nombre_pregunta = $qryDataPregunta["nombre"];
        array_push($pdf->respuestas["diagnostico"], ["id_pregunta" => $id_pregunta, "nombre_pregunta" => $nombre_pregunta, "respuestas" => array(), "respuestas_patologos" => array()]);
        $sizeofmarcadores= sizeof($pdf->respuestas["diagnostico"]);
        $qryDistractor = "SELECT id_distractor,nombre
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
        $qryArrayDistractor = mysql_query($qryDistractor);  
        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
            array_push($pdf->respuestas["diagnostico"][($sizeofmarcadores-1)]["respuestas"], ["id_distractor" => $qryDataDistractor["id_distractor"], "nombre" => $qryDataDistractor["nombre"]]);
        }


        // Aqui va a ir el query para obtener los intentos de patrón de tinción para ésta pregunta
        $qryArrayDistractorPAT = "SELECT
            usuario.cod_usuario,
            distractor.id_distractor,
            distractor.nombre
        from 
            intento
            join respuesta_lab on intento.id_intento = respuesta_lab.intento_id_intento
            join distractor on id_distractor = respuesta_lab.distractor_id_distractor
            join usuario on usuario.id_usuario = intento.usuario_id_usuario
        where respuesta_lab.pregunta_id_pregunta = $id_pregunta and intento.id_intento in (
            select max(id_intento)
            from intento
            where reto_id_reto = $reto_pat
            group by laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto
        )";
        $qryArrayDistractorPAT = mysql_query($qryArrayDistractorPAT);  
        while($qryDataDistractorPAT = mysql_fetch_array($qryArrayDistractorPAT)) {
            array_push($pdf->respuestas["diagnostico"][($sizeofmarcadores-1)]["respuestas_patologos"], ["cod_patologo" => $qryDataDistractorPAT["cod_usuario"], "id_distractor" => $qryDataDistractorPAT["id_distractor"], "nombre" => $qryDataDistractorPAT["nombre"]]);
        }


        /* **************************************** */
        // Impresion de los valores predeterminados
        /* **************************************** */
        $array_FCR = array();
        $array_GLLR = array();
        $array_GLRR = array();
        $array_NR = array();
        array_push($array_FCR, $pdf->blanco);
        array_push($array_GLLR, true);
        array_push($array_GLRR, false);
        array_push($array_NR,"Resultados");
        
        // Recorder los marcadores y respuestas del patron de tincion
        for($xsdf=0; $xsdf<sizeof($pdf->respuestas["patron_tincion"]); $xsdf++){
            $pregunta_exacta_act = $pdf->respuestas["patron_tincion"][$xsdf];
            array_push($array_FCR, $pdf->blanco);
            if($xsdf==0){ 
                array_push($array_GLLR, true); 
            } else { 
                array_push($array_GLLR, false);
            }
            array_push($array_GLRR, false);
            
            $cadena_distractores_act = "";
            for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                $distractor_actual = $pregunta_exacta_act["respuestas"][$dfdd]["nombre"];
                
                if($dfdd==0){
                    $cadena_distractores_act = $pdf->SetDistractor($distractor_actual);
                } else {
                    $cadena_distractores_act = $cadena_distractores_act . "\n" . $pdf->SetDistractor($distractor_actual);
                }
            }
            array_push($array_NR, $cadena_distractores_act);
        }


        // Recorder los marcadores y respuestas de intensidad de tincion
        for($xsdf=0; $xsdf<sizeof($pdf->respuestas["intensidad_tincion"]); $xsdf++){
            $pregunta_exacta_act = $pdf->respuestas["intensidad_tincion"][$xsdf];
            array_push($array_FCR, $pdf->blanco);
            if($xsdf==0){ 
                array_push($array_GLLR, true); 
            } else { 
                array_push($array_GLLR, false);
            }
            array_push($array_GLRR, false);
            
            $cadena_distractores_act = "";
            for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                $distractor_actual = $pregunta_exacta_act["respuestas"][$dfdd]["nombre"];
                
                if($dfdd==0){
                    $cadena_distractores_act = $pdf->SetDistractor($distractor_actual);
                } else {
                    $cadena_distractores_act = $cadena_distractores_act . "\n" . $pdf->SetDistractor($distractor_actual);
                }
            }
            array_push($array_NR, $cadena_distractores_act);
        }


        // Recorder los marcadores y respuestas de porcentaje de celulas positivas
        for($xsdf=0; $xsdf<sizeof($pdf->respuestas["porcentaje_celulas_positivas"]); $xsdf++){
            $pregunta_exacta_act = $pdf->respuestas["porcentaje_celulas_positivas"][$xsdf];
            array_push($array_FCR, $pdf->blanco);
            if($xsdf==0){ 
                array_push($array_GLLR, true); 
            } else { 
                array_push($array_GLLR, false);
            }
            array_push($array_GLRR, false);
            
            $cadena_distractores_act = "";
            for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                $distractor_actual = $pregunta_exacta_act["respuestas"][$dfdd]["nombre"];
                
                if($dfdd==0){
                    $cadena_distractores_act = $pdf->SetDistractor($distractor_actual);
                } else {
                    $cadena_distractores_act = $cadena_distractores_act . "\n" . $pdf->SetDistractor($distractor_actual);
                }
            }
            array_push($array_NR, $cadena_distractores_act);
        }

        // Recorder los marcadores y respuestas de porcentaje de diagnóstico
        for($xsdf=0; $xsdf<sizeof($pdf->respuestas["diagnostico"]); $xsdf++){
            $pregunta_exacta_act = $pdf->respuestas["diagnostico"][$xsdf];
            array_push($array_FCR, $pdf->blanco);
            if($xsdf==0){ 
                array_push($array_GLLR, true); 
            } else { 
                array_push($array_GLLR, false);
            }
            array_push($array_GLRR, true);
            
            $cadena_distractores_act = "";
            for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                $distractor_actual = $pregunta_exacta_act["respuestas"][$dfdd]["nombre"];

                if($dfdd==0){
                    $cadena_distractores_act = $pdf->SetDistractor($distractor_actual);
                } else {
                    $cadena_distractores_act = $cadena_distractores_act . "\n" . $pdf->SetDistractor($distractor_actual);
                }
            }
            array_push($array_NR, $cadena_distractores_act);
        }
        
        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosEncabezados);
        $pdf->SetHeightRow(4);


        $pdf->SetFillColorsRow($array_FCR);
        $pdf->SetGrossLineLeftRow($array_GLLR);
        $pdf->SetGrossLineRightRow($array_GLRR);
        $pdf->RowIHQ($array_NR);
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
            $array_GLLR = array();
            $array_GLRR = array();
            $array_NR = array();
            array_push($array_FCR, $pdf->blanco);
            array_push($array_GLLR, true);
            array_push($array_GLRR, false);
            array_push($array_NR,$usuarios_pat[$count_pat]["cod_usuario"]);
            
            // Recorder los marcadores y respuestas del patrón de tinción
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas["patron_tincion"]); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas["patron_tincion"][$xsdf];

                if($xsdf==0){ 
                    array_push($array_GLLR, true); 
                } else { 
                    array_push($array_GLLR, false);
                }
                array_push($array_GLRR, false);
                
                // Definir las respuestas correctas
                $id_respuestas_correctas = array();
                for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                    array_push($id_respuestas_correctas,$pregunta_exacta_act["respuestas"][$dfdd]["id_distractor"]);
                }

                // Almacenar en el array de la fila, los valores respondidos por el patólogo
                // 1. Buscar al patologo en el array 
                if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($pregunta_exacta_act["respuestas_patologos"], "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                    // Obtendra la primera respuesta que encuentra de esa pregunta
                    $id_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["id_distractor"];
                    $nombre_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["nombre"];

                    $criterioAct = $pdf->obtenerCriterioIHQ($id_respuesta_pat, $id_respuestas_correctas);

                    if($criterioAct){
                        $colorFondoAct = $pdf->verde;
                    } else {
                        $colorFondoAct = $pdf->rojo;
                    }

                    array_push($array_FCR, $colorFondoAct); // Color de fondo
                    array_push($array_NR, $pdf->SetDistractor($nombre_respuesta_pat));

                } else {
                    // Se va a imprimir un N/A                   
                    array_push($array_FCR, $pdf->blanco); // Color de fondo
                    array_push($array_NR, "N/A"); 
                }
            }
        
        
            // Recorder los marcadores y respuestas del intensidad de tinción
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas["intensidad_tincion"]); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas["intensidad_tincion"][$xsdf];

                if($xsdf==0){ 
                    array_push($array_GLLR, true); 
                } else { 
                    array_push($array_GLLR, false);
                }
                array_push($array_GLRR, false);
                
                // Definir las respuestas correctas
                $id_respuestas_correctas = array();
                for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                    array_push($id_respuestas_correctas,$pregunta_exacta_act["respuestas"][$dfdd]["id_distractor"]);
                }


                // Almacenar en el array de la fila, los valores respondidos por el patólogo
                // 1. Buscar al patologo en el array 
                if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($pregunta_exacta_act["respuestas_patologos"], "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                    // Obtendra la primera respuesta que encuentra de esa pregunta
                    $id_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["id_distractor"];
                    $nombre_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["nombre"];

                    $criterioAct = $pdf->obtenerCriterioIHQ($id_respuesta_pat, $id_respuestas_correctas);

                    if($criterioAct){
                        $colorFondoAct = $pdf->verde;
                    } else {
                        $colorFondoAct = $pdf->rojo;
                    }

                    array_push($array_FCR, $colorFondoAct); // Color de fondo
                    array_push($array_NR, $pdf->SetDistractor($nombre_respuesta_pat));

                } else {
                    // Se va a imprimir un N/A                   
                    array_push($array_FCR, $pdf->blanco); // Color de fondo
                    array_push($array_NR, "N/A"); 
                }
            }
            
            // Recorrer porcentaje_celulas_positivas
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas["porcentaje_celulas_positivas"]); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas["porcentaje_celulas_positivas"][$xsdf];

                if($xsdf==0){ 
                    array_push($array_GLLR, true); 
                } else { 
                    array_push($array_GLLR, false);
                }
                array_push($array_GLRR, false);
                
                // Definir las respuestas correctas
                $id_respuestas_correctas = array();
                for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                    array_push($id_respuestas_correctas,$pregunta_exacta_act["respuestas"][$dfdd]["id_distractor"]);
                }


                // Almacenar en el array de la fila, los valores respondidos por el patólogo
                // 1. Buscar al patologo en el array 
                if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($pregunta_exacta_act["respuestas_patologos"], "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                    // Obtendra la primera respuesta que encuentra de esa pregunta
                    $id_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["id_distractor"];
                    $nombre_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["nombre"];

                    $criterioAct = $pdf->obtenerCriterioIHQ($id_respuesta_pat, $id_respuestas_correctas);

                    if($criterioAct){
                        $colorFondoAct = $pdf->verde;
                    } else {
                        $colorFondoAct = $pdf->rojo;
                    }

                    array_push($array_FCR, $colorFondoAct); // Color de fondo
                    array_push($array_NR, $pdf->SetDistractor($nombre_respuesta_pat));

                } else {
                    // Se va a imprimir un N/A                   
                    array_push($array_FCR, $pdf->blanco); // Color de fondo
                    array_push($array_NR, "N/A"); 
                }
            }

            // Recorrer el diagnostico
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas["diagnostico"]); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas["diagnostico"][$xsdf];

                if($xsdf==0){ 
                    array_push($array_GLLR, true); 
                } else { 
                    array_push($array_GLLR, false);
                }
                array_push($array_GLRR, true);
                
                // Definir las respuestas correctas
                $id_respuestas_correctas = array();
                for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                    array_push($id_respuestas_correctas,$pregunta_exacta_act["respuestas"][$dfdd]["id_distractor"]);
                }


                // Almacenar en el array de la fila, los valores respondidos por el patólogo
                // 1. Buscar al patologo en el array 
                if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($pregunta_exacta_act["respuestas_patologos"], "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                    // Obtendra la primera respuesta que encuentra de esa pregunta
                    $id_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["id_distractor"];
                    $nombre_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["nombre"];

                    $criterioAct = $pdf->obtenerCriterioIHQ($id_respuesta_pat, $id_respuestas_correctas);

                    if($criterioAct){
                        $colorFondoAct = $pdf->verde;
                        $diagnosticos_concordantes++;
                    } else {
                        $colorFondoAct = $pdf->rojo;
                        $diagnosticos_noconcordantes++;
                    }
                    array_push($array_FCR, $colorFondoAct); // Color de fondo
                    array_push($array_NR, $pdf->SetDistractor($nombre_respuesta_pat));

                } else {
                    // Se va a imprimir un N/A                   
                    array_push($array_FCR, $pdf->blanco); // Color de fondo
                    array_push($array_NR, "N/A"); 
                }
            }
            // $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
            // $pdf->SetWidths($anchosEncabezados);
            // $pdf->SetHeightRow(4);
            // $pdf->SetFillColorsRow($array_FCR);
            // $pdf->SetGrossLineLeftRow($array_GLLR);
            // $pdf->SetGrossLineRightRow($array_GLRR);
            // $pdf->RowIHQ($array_NR);

            /*
            Las anteriores lineas comentadas es la manera antigua en que se imprimen las respuestas de los patologos con fondo de color
            */

            /*
            Nueva forma de imprimir las respuestas de los patologos, solo cambiando el color del texto
            */

            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($array_NR);$i++)
                $nb=max($nb,$pdf->NbLines($pdf->widths[$i],$array_NR[$i]));
            $h=$pdf->heightRow*$nb;
 
            //Issue a page break first if needed
            $pdf->CheckPageBreak($h);
 
            //Draw the cells of the row
            for($i=0;$i<count($array_NR);$i++) {
 
                $pdf->SetLineWidth(0.1); //Linea delgada
                $pdf->SetDrawColor(143, 181, 201); //Azul claro
 
                $w=$pdf->widths[$i];
                $a=isset($pdf->aligns[$i]) ? $pdf->aligns[$i] : 'L';
            
                $pdf->SetFillColor(255, 255, 255); // Blanco
    
                //Save the current position
                $x=$pdf->GetX();
                $y=$pdf->GetY();
         
                $pdf->SetLineWidth(0.1);
    
                $pdf->Cell($w,$h,"",0,0,0,1);
                $pdf->SetXY($x,$y);
    
                // NUEVO
                if($array_FCR[$i] == $pdf->verde){ //verde
    
                    $pdf->SetFont("Arial","B",7);
                    $pdf->SetTextColor(16, 155, 0); //Verde
                    $pdf->MultiCell($w,$pdf->heightRow,$array_NR[$i],0,$a,1);
    
                } else if ($array_FCR[$i] == $pdf->rojo){
            
                    $pdf->SetFont("Arial","B",7);
                    $pdf->SetTextColor(203, 11, 11); //Rojo
                    $pdf->MultiCell($w,$pdf->heightRow,$array_NR[$i],0,$a,1);
    
                } else if ($array_FCR[$i] == $pdf->blanco){
                 
                    $pdf->SetFont("Arial","B",7);
                    $pdf->SetTextColor(0, 0, 0); //Negro
                    $pdf->MultiCell($w,$pdf->heightRow,$array_NR[$i],0,$a,1);
    
                }
     
                $pdf->Rect($x,$y,$w,$h);
 
                if(isset($pdf->grossLineLeft[$i]) && $pdf->grossLineLeft[$i] == true){ // Si esta definido el borde izquierdo y ademas es positivo
                    $pdf->SetLineWidth($pdf->lineaGruesa);
                    $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
                    $pdf->Line($x, $y, $x, $y + $h);
                }
                
                if(isset($pdf->grossLineRight[$i]) && $pdf->grossLineRight[$i] == true){ // Si esta definido el borde derecho y ademas es positivo
                    $pdf->SetLineWidth($pdf->lineaGruesa);
                    $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
                    $pdf->Line($x + $w, $y, $x + $w, $y + $h);
                }
         
                $pdf->SetXY($x+$w,$y);
     
            }
 
            //Go to the next line
            $pdf->Ln($h);
         
            // Restableces el color predeterminado del texto a negro
            $pdf->SetTextColor(0, 0, 0); //Negro
        }


        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        for($xdf=0;$xdf<sizeof($anchosEncabezados);$xdf++){
            $pdf->Cell($anchosEncabezados[$xdf],1,"","T",0,'C',0);
        }

        /* ************************************* */
        //  Código Consenso de valoraciones 1
        /* ************************************* */

        $pdf->Ln(2);
        $pdf->SetX(29);
        $pdf->SetFont("Arial","B",7);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(18,4,"Consenso de valoraciones - Grupo Diagnóstico",0,0,'C',1);
        $pdf->Ln(1);
        
        // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
        $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                    
                        FROM grupo 
                        JOIN pregunta
                        ON grupo.id_grupo = pregunta.grupo_id_grupo

                        WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

        $qryArrayPregunta = mysql_query($qryPregunta);

        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {

            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];

            // Consulta SQL para obtener el numero de distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores

                                FROM distractor 
                            
                                INNER JOIN pregunta 
                                ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                INNER JOIN grupo 
                                ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                INNER JOIN caso_clinico 
                                ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                            
                                WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Diagnóstico' and pregunta.nombre = '$nombre_pregunta'";


            $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
            $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

            // Consulta SQL para obtener los distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractores = "SELECT distractor.nombre

                            FROM distractor 
                        
                            INNER JOIN pregunta 
                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                            INNER JOIN grupo 
                            ON pregunta.grupo_id_grupo = grupo.id_grupo 
                            INNER JOIN caso_clinico 
                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                        
                            WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Diagnóstico' and pregunta.nombre = '$nombre_pregunta'";

            $qryArrayDistractores = mysql_query($qryDistractores);

            // Consulta SQL para obtener todas las respuestas reportadas por pregunta (Muestra)
            $queryRespuestas = "SELECT distractor.id_distractor, distractor.nombre

                            from distractor 

                            join respuesta_lab 
                            on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            join intento
                            on intento.id_intento = respuesta_lab.intento_id_intento
                                                
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' && intento.usuario_id_usuario != '297'";

            $qryArrayRespuestas = mysql_query($queryRespuestas);

            // Se guarda en un array las respuestas obtenidas de la consulta anterior
            $arrayRespuestas = array();
            while($qryDataRespuestas = mysql_fetch_array($qryArrayRespuestas)) {
                array_push($arrayRespuestas, $qryDataRespuestas['nombre']);
            }

            // Se guardan todos los distractores por caso clinico en un array
            $nombreDistractoresArray = array();
            while($qryDataDistractores = mysql_fetch_array($qryArrayDistractores)) {
                array_push($nombreDistractoresArray, $qryDataDistractores['nombre']);
            }

            // Se itera sobre el arreglo de distractores y dentro se itera sobre el arreglo de respuestas.
            // Si el distractor es igual a la respuesta se suma 1.
            // Se obtiene el porcentaje al final de laiteracion sobre las respuestas
            $ArrayDiscriminado1= array();
            $ArrayDiscriminado2= array();
            $ArrayDiscriminado3= array();
            $ArrayDiscriminado4= array();

            for ($i=0; $i < sizeof($nombreDistractoresArray); $i++) { 

                $nombre = $nombreDistractoresArray[$i];
                $numero = 0;
                $total = sizeof($arrayRespuestas);

                for ($j=0; $j < $total; $j++) { 
                    $resp = $arrayRespuestas[$j];
                    if ($resp == $nombre) {
                        $numero++;
                    }
                }

                $numeroLimpio = $numero;
                $dato = $numero . " (" . round($numero/$total * 100,2) . "%)";

                if ($dato != 0) {
                    array_push($ArrayDiscriminado1, $nombreDistractoresArray[$i]);
                    array_push($ArrayDiscriminado2, $dato);
                    array_push($ArrayDiscriminado3, "C");
                    array_push($ArrayDiscriminado4, $numeroLimpio);
                }
            }

            // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
            $tamanoCeldaArray = array();
            for ($i=0; $i < count($ArrayDiscriminado1); $i++) { 
                $tamanoCeldaArray[] = (261 / count($ArrayDiscriminado1));
            }

            // Se imprimen los datos requeridos
            $pdf->Ln();

            $pdf->SetFont('Arial','B',7);
            $pdf->SetFillColor(255,255,255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetDrawColor(61,123,162);
            $pdf->Cell(261,5,'Consenso de valoraciones - Diagnóstico',1,1,'C',1);

            $pdf->SetFont('Arial','',7);
            $pdf->SetWidths_dos($tamanoCeldaArray);
            $pdf->SetAligns_dos($ArrayDiscriminado3);
            $pdf->Row_dos($ArrayDiscriminado1);

            for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {

                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color blanco
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);

                } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetTextColor(16, 155, 0); // Color verde
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
                    $pdf->SetFont('Arial','',7);

                }

            }

            $pdf->Ln(4);

        }

        /* ************************************* */
        //  Código Consenso de valoraciones 2
        /* ************************************* */

        $pdf->Ln(2);
        $pdf->SetX(32);
        $pdf->SetFont("Arial","B",7);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(18,4,"Consenso de valoraciones - Grupo Patrón de tinción",0,0,'C',1);
        $pdf->Ln(1);
        
        // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
        $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                    
                        FROM grupo 
                        JOIN pregunta
                        ON grupo.id_grupo = pregunta.grupo_id_grupo

                        WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Patrón de tinción'";

        $qryArrayPregunta = mysql_query($qryPregunta);

        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {

            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];

            // Consulta SQL para obtener el numero de distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores

                                FROM distractor 
                            
                                INNER JOIN pregunta 
                                ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                INNER JOIN grupo 
                                ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                INNER JOIN caso_clinico 
                                ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                            
                                WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Patrón de tinción' and pregunta.nombre = '$nombre_pregunta'";


            $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
            $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

            // Consulta SQL para obtener los distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractores = "SELECT distractor.nombre

                            FROM distractor 
                        
                            INNER JOIN pregunta 
                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                            INNER JOIN grupo 
                            ON pregunta.grupo_id_grupo = grupo.id_grupo 
                            INNER JOIN caso_clinico 
                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                        
                            WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Patrón de tinción' and pregunta.nombre = '$nombre_pregunta'";

            $qryArrayDistractores = mysql_query($qryDistractores);

            // Consulta SQL para obtener todas las respuestas reportadas por pregunta (Muestra)
            $queryRespuestas = "SELECT distractor.id_distractor, distractor.nombre

                            from distractor 

                            join respuesta_lab 
                            on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            join intento
                            on intento.id_intento = respuesta_lab.intento_id_intento
                                                
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' && intento.usuario_id_usuario != '297'";

            $qryArrayRespuestas = mysql_query($queryRespuestas);

            // Se guarda en un array las respuestas obtenidas de la consulta anterior
            $arrayRespuestas = array();
            while($qryDataRespuestas = mysql_fetch_array($qryArrayRespuestas)) {
                array_push($arrayRespuestas, $qryDataRespuestas['nombre']);
            }

            // Se guardan todos los distractores por caso clinico en un array
            $nombreDistractoresArray = array();
            while($qryDataDistractores = mysql_fetch_array($qryArrayDistractores)) {
                array_push($nombreDistractoresArray, $qryDataDistractores['nombre']);
            }

            // Se itera sobre el arreglo de distractores y dentro se itera sobre el arreglo de respuestas.
            // Si el distractor es igual a la respuesta se suma 1.
            // Se obtiene el porcentaje al final de laiteracion sobre las respuestas
            $ArrayDiscriminado1= array();
            $ArrayDiscriminado2= array();
            $ArrayDiscriminado3= array();
            $ArrayDiscriminado4= array();

            for ($i=0; $i < sizeof($nombreDistractoresArray); $i++) { 

                $nombre = $nombreDistractoresArray[$i];
                $numero = 0;
                $total = sizeof($arrayRespuestas);

                for ($j=0; $j < $total; $j++) { 
                    $resp = $arrayRespuestas[$j];
                    if ($resp == $nombre) {
                        $numero++;
                    }
                }

                $numeroLimpio = $numero;
                $dato = $numero . " (" . round($numero/$total * 100,2) . "%)";

                if ($dato != 0) {
                    array_push($ArrayDiscriminado1, $nombreDistractoresArray[$i]);
                    array_push($ArrayDiscriminado2, $dato);
                    array_push($ArrayDiscriminado3, "C");
                    array_push($ArrayDiscriminado4, $numeroLimpio);
                }
            }

            // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
            $tamanoCeldaArray = array();
            for ($i=0; $i < count($ArrayDiscriminado1); $i++) { 
                $tamanoCeldaArray[] = (261 / count($ArrayDiscriminado1));
            }

            // Se imprimen los datos requeridos
            $pdf->Ln();

            $pdf->SetFont('Arial','B',7);
            $pdf->SetFillColor(255,255,255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetDrawColor(61,123,162);
            $pdf->Cell(261,5,'Consenso de valoraciones - Marcador '. $nombre_pregunta,1,1,'C',1);

            $pdf->SetFont('Arial','',7);
            $pdf->SetWidths_dos($tamanoCeldaArray);
            $pdf->SetAligns_dos($ArrayDiscriminado3);
            $pdf->Row_dos($ArrayDiscriminado1);

            for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {

                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color blanco
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);

                } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetTextColor(16, 155, 0); // Color verde
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
                    $pdf->SetFont('Arial','',7);

                }

            }

            $pdf->Ln(4);

        }

        /* ************************************* */
        //  Código Consenso de valoraciones 3
        /* ************************************* */

        $pdf->Ln(2);
        $pdf->SetX(34);
        $pdf->SetFont("Arial","B",7);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(18,4,"Consenso de valoraciones - Grupo Intensidad de tinción",0,0,'C',1);
        $pdf->Ln(1);
        
        // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
        $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                    
                        FROM grupo 
                        JOIN pregunta
                        ON grupo.id_grupo = pregunta.grupo_id_grupo

                        WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de tinción'";

        $qryArrayPregunta = mysql_query($qryPregunta);

        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {

            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];

            // Consulta SQL para obtener el numero de distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores

                                FROM distractor 
                            
                                INNER JOIN pregunta 
                                ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                INNER JOIN grupo 
                                ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                INNER JOIN caso_clinico 
                                ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                            
                                WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Intensidad de tinción' and pregunta.nombre = '$nombre_pregunta'";


            $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
            $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

            // Consulta SQL para obtener los distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractores = "SELECT distractor.nombre

                            FROM distractor 
                        
                            INNER JOIN pregunta 
                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                            INNER JOIN grupo 
                            ON pregunta.grupo_id_grupo = grupo.id_grupo 
                            INNER JOIN caso_clinico 
                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                        
                            WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Intensidad de tinción' and pregunta.nombre = '$nombre_pregunta'";

            $qryArrayDistractores = mysql_query($qryDistractores);

            // Consulta SQL para obtener todas las respuestas reportadas por pregunta (Muestra)
            $queryRespuestas = "SELECT distractor.id_distractor, distractor.nombre

                            from distractor 

                            join respuesta_lab 
                            on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            join intento
                            on intento.id_intento = respuesta_lab.intento_id_intento
                                                
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' && intento.usuario_id_usuario != '297'";

            $qryArrayRespuestas = mysql_query($queryRespuestas);

            // Se guarda en un array las respuestas obtenidas de la consulta anterior
            $arrayRespuestas = array();
            while($qryDataRespuestas = mysql_fetch_array($qryArrayRespuestas)) {
                array_push($arrayRespuestas, $qryDataRespuestas['nombre']);
            }

            // Se guardan todos los distractores por caso clinico en un array
            $nombreDistractoresArray = array();
            while($qryDataDistractores = mysql_fetch_array($qryArrayDistractores)) {
                array_push($nombreDistractoresArray, $qryDataDistractores['nombre']);
            }

            // Se itera sobre el arreglo de distractores y dentro se itera sobre el arreglo de respuestas.
            // Si el distractor es igual a la respuesta se suma 1.
            // Se obtiene el porcentaje al final de laiteracion sobre las respuestas
            $ArrayDiscriminado1= array();
            $ArrayDiscriminado2= array();
            $ArrayDiscriminado3= array();
            $ArrayDiscriminado4= array();

            for ($i=0; $i < sizeof($nombreDistractoresArray); $i++) { 

                $nombre = $nombreDistractoresArray[$i];
                $numero = 0;
                $total = sizeof($arrayRespuestas);

                for ($j=0; $j < $total; $j++) { 
                    $resp = $arrayRespuestas[$j];
                    if ($resp == $nombre) {
                        $numero++;
                    }
                }

                $numeroLimpio = $numero;
                $dato = $numero . " (" . round($numero/$total * 100,2) . "%)";

                if ($dato != 0) {
                    array_push($ArrayDiscriminado1, $nombreDistractoresArray[$i]);
                    array_push($ArrayDiscriminado2, $dato);
                    array_push($ArrayDiscriminado3, "C");
                    array_push($ArrayDiscriminado4, $numeroLimpio);
                }
            }

            // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
            $tamanoCeldaArray = array();
            for ($i=0; $i < count($ArrayDiscriminado1); $i++) { 
                $tamanoCeldaArray[] = (261 / count($ArrayDiscriminado1));
            }

            // Se imprimen los datos requeridos
            $pdf->Ln();

            $pdf->SetFont('Arial','B',7);
            $pdf->SetFillColor(255,255,255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetDrawColor(61,123,162);
            $pdf->Cell(261,5,'Consenso de valoraciones - Marcador '. $nombre_pregunta,1,1,'C',1);

            $pdf->SetFont('Arial','',7);
            $pdf->SetWidths_dos($tamanoCeldaArray);
            $pdf->SetAligns_dos($ArrayDiscriminado3);
            $pdf->Row_dos($ArrayDiscriminado1);

            for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {

                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color blanco
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);

                } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetTextColor(16, 155, 0); // Color verde
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
                    $pdf->SetFont('Arial','',7);

                }

            }

            $pdf->Ln(4);

        }

        /* ************************************* */
        //  Código Consenso de valoraciones 4
        /* ************************************* */

        $pdf->Ln(2);
        $pdf->SetX(40);
        $pdf->SetFont("Arial","B",7);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(18,4,"Consenso de valoraciones - Grupo Porcentaje de células positivas",0,0,'C',1);
        $pdf->Ln(1);
        
        // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
        $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                    
                        FROM grupo 
                        JOIN pregunta
                        ON grupo.id_grupo = pregunta.grupo_id_grupo

                        WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Porcentaje de células positivas'";

        $qryArrayPregunta = mysql_query($qryPregunta);

        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {

            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];

            // Consulta SQL para obtener el numero de distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores

                                FROM distractor 
                            
                                INNER JOIN pregunta 
                                ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                INNER JOIN grupo 
                                ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                INNER JOIN caso_clinico 
                                ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                            
                                WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Porcentaje de células positivas' and pregunta.nombre = '$nombre_pregunta'";


            $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
            $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

            // Consulta SQL para obtener los distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
            $qryDistractores = "SELECT distractor.nombre

                            FROM distractor 
                        
                            INNER JOIN pregunta 
                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                            INNER JOIN grupo 
                            ON pregunta.grupo_id_grupo = grupo.id_grupo 
                            INNER JOIN caso_clinico 
                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                        
                            WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Porcentaje de células positivas' and pregunta.nombre = '$nombre_pregunta'";

            $qryArrayDistractores = mysql_query($qryDistractores);

            // Consulta SQL para obtener todas las respuestas reportadas por pregunta (Muestra)
            $queryRespuestas = "SELECT distractor.id_distractor, distractor.nombre

                            from distractor 

                            join respuesta_lab 
                            on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            join intento
                            on intento.id_intento = respuesta_lab.intento_id_intento
                                                
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' && intento.usuario_id_usuario != '297'";

            $qryArrayRespuestas = mysql_query($queryRespuestas);

            // Se guarda en un array las respuestas obtenidas de la consulta anterior
            $arrayRespuestas = array();
            while($qryDataRespuestas = mysql_fetch_array($qryArrayRespuestas)) {
                array_push($arrayRespuestas, $qryDataRespuestas['nombre']);
            }

            // Se guardan todos los distractores por caso clinico en un array
            $nombreDistractoresArray = array();
            while($qryDataDistractores = mysql_fetch_array($qryArrayDistractores)) {
                array_push($nombreDistractoresArray, $qryDataDistractores['nombre']);
            }

            // Se itera sobre el arreglo de distractores y dentro se itera sobre el arreglo de respuestas.
            // Si el distractor es igual a la respuesta se suma 1.
            // Se obtiene el porcentaje al final de laiteracion sobre las respuestas
            $ArrayDiscriminado1= array();
            $ArrayDiscriminado2= array();
            $ArrayDiscriminado3= array();
            $ArrayDiscriminado4= array();

            for ($i=0; $i < sizeof($nombreDistractoresArray); $i++) { 

                $nombre = $nombreDistractoresArray[$i];
                $numero = 0;
                $total = sizeof($arrayRespuestas);

                for ($j=0; $j < $total; $j++) { 
                    $resp = $arrayRespuestas[$j];
                    if ($resp == $nombre) {
                        $numero++;
                    }
                }

                $numeroLimpio = $numero;
                $dato = $numero . " (" . round($numero/$total * 100,2) . "%)";

                if ($dato != 0) {
                    array_push($ArrayDiscriminado1, $nombreDistractoresArray[$i]);
                    array_push($ArrayDiscriminado2, $dato);
                    array_push($ArrayDiscriminado3, "C");
                    array_push($ArrayDiscriminado4, $numeroLimpio);
                }
            }

            // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
            $tamanoCeldaArray = array();
            for ($i=0; $i < count($ArrayDiscriminado1); $i++) { 
                $tamanoCeldaArray[] = (261 / count($ArrayDiscriminado1));
            }

            // Se imprimen los datos requeridos
            $pdf->Ln();

            $pdf->SetFont('Arial','B',7);
            $pdf->SetFillColor(255,255,255);
            $pdf->SetLineWidth(0.3);
            $pdf->SetDrawColor(61,123,162);
            $pdf->Cell(261,5,'Consenso de valoraciones - Marcador '. $nombre_pregunta,1,1,'C',1);

            $pdf->SetFont('Arial','',7);
            $pdf->SetWidths_dos($tamanoCeldaArray);
            $pdf->SetAligns_dos($ArrayDiscriminado3);
            $pdf->Row_dos($ArrayDiscriminado1);

            for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {

                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color blanco
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);

                } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                    $pdf->SetFont('Arial','B',7);
                    $pdf->SetTextColor(16, 155, 0); // Color verde
                    $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                    $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
                    $pdf->SetFont('Arial','',7);

                }

            }

            $pdf->Ln(4);

        }

        /* *************************************************** */
        // Seccion de interpretacion
        /* *************************************************** */
        $pdf->Ln(3);
        $pdf->SetX(10);
        $pdf->SetFont("Arial","B",7);
        $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
        $pdf->Cell(18,4,"Interpretación",0,0,'C',1);
        $pdf->SetFont("Arial","B",7);
        $pdf->SetTextColor(16, 155, 0); //Verde Oscuro
        $pdf->Cell(18,4,"Concordante",0,0,'C',1);
        $pdf->SetTextColor(203, 11, 11); //Rogo Oscuro
        $pdf->Cell(20,4,"No concordante",0,0,'C',1);
        
        

        /* ************************************* */
        // Convenciones
        /* ************************************* */

        $pdf->SetTextColor(0, 0, 0); //Restablecer color a negro

        if(sizeof($pdf->distractoresGenerales) > 0){ // Si hay distractores por poner
            $pdf->Ln(6);
            
            $pdf->SetX(10);
            $pdf->SetFont("Arial","B",7);
            $pdf->Cell(199,5,"Convenciones para diagnósticos",0,1,'L',0);
            
            $pdf->SetX(10);
            $pdf->SetFont("Arial","",7);
            for($xfr=0;$xfr<sizeof($pdf->distractoresGenerales); $xfr++){
                $pdf->WriteHTML("<span><b>[".($xfr+1)."]</b> " .$pdf->distractoresGenerales[$xfr]. " </span> ");
            }

        }

            
        /* *************************************************** */
        // Seccion de calculos de resultados
        /* *************************************************** */
        
        // Primer nivel
        // $pdf->Ln(11);
        // $pdf->SetFillColor(255,255,255);
        // $pdf->SetDrawColor(21, 67, 96);
    
    
        // $left_valest  = 40;
        // $anchoValEst = 120;

        // $anchoContGrafica = 93;
        // $altoContGrafica = 50; 

        // $pdf->SetFont("Arial","B",6);
        // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
        // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
        // $pdf->SetLineWidth($pdf->lineaDelgada);
        // $pdf->SetX($left_valest);
        // $pdf->Cell($anchoValEst,4,"Resultados intralaboratorio - ".$pdf->nombre_programa,1,0,'C',1);
        
        
        /* ***************************************************** */
        // Gráfica
        /* ***************************************************** */
  
        // $ruta_image = $pdf->generarGraficoIHQ($diagnosticos_concordantes,$diagnosticos_noconcordantes);
        // $xImage = $anchoValEst + $left_valest;
        // $yImage = $pdf->GetY();
        
        // $pdf->Image($ruta_image,$xImage,$yImage,$anchoContGrafica, $altoContGrafica);
        // unlink($ruta_image);
        
        // $pdf->Ln(4);
        // $anchoSeccionP = 40;
        // $anchoMarcador2 = ($anchoValEst - $anchoSeccionP) / ($pdf->num_marcadores);
        
        // // Encabezado Patron de tincion
        // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
        // $pdf->SetLineWidth($pdf->lineaDelgada);
        // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
        // $pdf->SetFont("Arial","B",6);
        // $pdf->SetX($left_valest);
        // $pdf->Cell($anchoSeccionP,3.5,"Patrón de tinción",1,0,'C',1);
        // for($dsb=0;$dsb<sizeof($marcadores);$dsb++){
        //     $nom_marcador_act = $marcadores[$dsb];
        //     $pdf->Cell($anchoMarcador2,3.5,$nom_marcador_act,1,0,'C',1);
        // }


        // Distractores patron de tinción
        // $qryRespuesta = "SELECT distinct 
        //         distractor.nombre
        //     from
        //         distractor
        //     join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
        //     join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
        //     where 
        //     grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Patrón de tinción'";
        // $posibles_respuestas = array();
        // $qryArrayRespuesta = mysql_query($qryRespuesta);
        // mysqlException(mysql_error(),"_01");
        // $pdf->SetFont("Arial","",6);
        // while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {
        //     $pdf->Ln();
        //     $pdf->SetX($left_valest);
        //     $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1],$pdf->blanco[2]);
        //     $pdf->Cell($anchoSeccionP,3.5,$qryDataRespuesta["nombre"],1,0,'C',1);
        //     for($dsb=0;$dsb<sizeof($marcadores);$dsb++){
        //         $num_conteo = $pdf->contarCoincidenciasArray($qryDataRespuesta["nombre"], array_column($pdf->respuestas["patron_tincion"][$dsb]["respuestas_patologos"], "nombre"));
        //         $pdf->Cell($anchoMarcador2,3.5,$num_conteo,1,0,'C',1);
        //     }
        // }



        // Encabezado intensidad de tincion
        // $pdf->Ln();
        // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
        // $pdf->SetLineWidth($pdf->lineaDelgada);
        // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
        // $pdf->SetFont("Arial","B",6);
        // $pdf->SetX($left_valest);
        // $pdf->Cell($anchoSeccionP,3.5,"Intensidad de tinción",1,0,'C',1);
        // for($dsb=0;$dsb<sizeof($marcadores);$dsb++){
        //     $nom_marcador_act = $marcadores[$dsb];
        //     $pdf->Cell($anchoMarcador2,3.5,$nom_marcador_act,1,0,'C',1);
        // }


        // Distractores intensidad de tincion
        // $qryRespuesta = "SELECT distinct 
        //         distractor.nombre
        //     from
        //         distractor
        //     join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
        //     join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
        //     where 
        //     grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de tinción'";
        // $posibles_respuestas = array();
        // $qryArrayRespuesta = mysql_query($qryRespuesta);
        // mysqlException(mysql_error(),"_01");
        // $pdf->SetFont("Arial","",6);
        // while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {
        //     $pdf->Ln();
        //     $pdf->SetX($left_valest);
        //     $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1],$pdf->blanco[2]);
        //     $pdf->Cell($anchoSeccionP,3.5,$qryDataRespuesta["nombre"],1,0,'C',1);
        //     for($dsb=0;$dsb<sizeof($marcadores);$dsb++){
        //         $num_conteo = $pdf->contarCoincidenciasArray($qryDataRespuesta["nombre"], array_column($pdf->respuestas["intensidad_tincion"][$dsb]["respuestas_patologos"], "nombre"));
        //         $pdf->Cell($anchoMarcador2,3.5,$num_conteo,1,0,'C',1);
        //     }
        // }


        // Encabezado Porcentaje de células positivas
        // $pdf->Ln();
        // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
        // $pdf->SetLineWidth($pdf->lineaDelgada);
        // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
        // $pdf->SetFont("Arial","B",6);
        // $pdf->SetX($left_valest);
        // $pdf->Cell($anchoSeccionP,3.5,"Porcentaje de células positivas",1,0,'C',1);
        // for($dsb=0;$dsb<sizeof($marcadores);$dsb++){
        //     $nom_marcador_act = $marcadores[$dsb];
        //     $pdf->Cell($anchoMarcador2,3.5,$nom_marcador_act,1,0,'C',1);
        // }


        // Distractores Porcentaje de células positivas
        // $qryRespuesta = "SELECT distinct 
        //         distractor.nombre
        //     from
        //         distractor
        //     join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
        //     join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
        //     where 
        //     grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Porcentaje de células positivas'";
        // $posibles_respuestas = array();
        // $qryArrayRespuesta = mysql_query($qryRespuesta);
        // mysqlException(mysql_error(),"_01");
        // $pdf->SetFont("Arial","",6);
        // while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {
        //     $pdf->Ln();
        //     $pdf->SetX($left_valest);
        //     $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1],$pdf->blanco[2]);
        //     $pdf->Cell($anchoSeccionP,3.5,$qryDataRespuesta["nombre"],1,0,'C',1);
        //     for($dsb=0;$dsb<sizeof($marcadores);$dsb++){
        //         $num_conteo = $pdf->contarCoincidenciasArray($qryDataRespuesta["nombre"], array_column($pdf->respuestas["porcentaje_celulas_positivas"][$dsb]["respuestas_patologos"], "nombre"));
        //         $pdf->Cell($anchoMarcador2,3.5,$num_conteo,1,0,'C',1);
        //     }
        // }
        
    }

    $pdf->SetX(12);
    $pdf->Ln(7);
    $pdf->SetFont("Arial","B",6.2);

    
    if($pdf->GetY() > 183.75){ // Si el alto es mayor al cupo para la firma
        $pdf->AddPage();
    }
    
    $pdf->Ln(60);
    $pdf->MultiCell(260,3,"- Final del reporte -\n    Página ". $pdf->PageNo(). " de {nb}\n",0,'C',0);
    $pdf->MultiCell(260,3,"\n\n\n\n\n\n\n\n\n\nAprobado por:\nAída Porras. Magister en Biología. Doctor in management.\nCoordinadora Programas QAP PAT",0,'C',0);
    




    // Cerrar PDF
    $pdf->Close();

    $nomArchivo = utf8_decode("$num_laboratorio - Intralaboratorio IHQ $pdf->nom_reto $nom_laboratorio.pdf");
    $pdf->Output("I",$nomArchivo);

?>