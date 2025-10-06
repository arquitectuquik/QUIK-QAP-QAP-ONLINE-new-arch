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

    // Obtener la informacion del laboratorio
    $qry = "SELECT no_laboratorio, nombre_laboratorio FROM $tbl_laboratorio WHERE id_laboratorio = '$pdf->id_laboratorio_pat'";
	$qryData = mysql_fetch_array(mysql_query($qry));
    $pdf->no_laboratorio = $qryData['no_laboratorio'];
    $pdf->nombre_laboratorio = $qryData['nombre_laboratorio'];


    $qry = "SELECT envio FROM $tbl_reto_laboratorio WHERE laboratorio_id_laboratorio = '$pdf->id_laboratorio_pat' and reto_id_reto = '$pdf->id_reto_pat'";
	$qryData = mysql_fetch_array(mysql_query($qry));
    $envio_pat = $pdf->obtenerNomEnvio($qryData['envio']);
    $pdf->envio_pat = $envio_pat;

    /* ****************************** */
    // Seccion de interpretacion
    /* ****************************** */

    $pdf->AddPage(); // Portada
    $pdf->SetAutoPageBreak(true,4);


    // Fecha de generacion de caso clinico
    $pdf->SetFont("Arial","B",7);
    $pdf->SetX(10);
    $pdf->SetTextColor(40, 40, 40);
    $pdf->Cell(23,4,"Fecha de generación:",0,0,'L',0);
    $pdf->SetFont("Arial","",7);
    $pdf->Cell(30,4,Date("Y-m-d h:i"),0,0,'C',0);
    
    // Laboratorio
    $pdf->SetFont("Arial","B",7);
    $pdf->SetTextColor(40, 40, 40);
    $pdf->Cell(15,4,"Laboratorio:",0,0,'L',0);
    $pdf->SetFont("Arial","",7);
    $pdf->Cell(70,4,"$num_laboratorio - $nom_laboratorio",0,0,'L',0);
    $pdf->Ln(7);
    

    /* ************************* */
    // Seccion de casos clínicos
    /* ************************* */
    
    $qry = "SELECT id_caso_clinico, codigo, nombre, revision FROM caso_clinico where reto_id_reto = $pdf->id_reto_pat and estado = 1";
    $qryArray = mysql_query($qry);
    mysqlException(mysql_error(),"_01");
    $casos_clinicos = [];
    
    $anchoTotalCasosClinicos = 260;
    $anchoColumn1 = 51;
    $num_casos_clinicos = mysql_num_rows(mysql_query($qry));
    $anchoCasoClinico = ($anchoTotalCasosClinicos - $anchoColumn1) / $num_casos_clinicos;
    
    $nombres_casos_clinicos = ["COD.\nPatólogo"];
    $anchosRow = [$anchoColumn1];
    $coloresFondo = [$pdf->azulFondoP];
    
    while($qryData = mysql_fetch_array($qryArray)) {
        $id_caso_clinico = $qryData["id_caso_clinico"];
        $nom_caso_clinico = $qryData["nombre"];
        $cod_caso_clinico = $qryData["codigo"];

        array_push($casos_clinicos, [
            "id_caso_clinico" => $id_caso_clinico, 
            "nombre" => $nom_caso_clinico, 
            "cod_caso_clinico" => $cod_caso_clinico, 
            "diagnostico" => [],
            "respuestas_patologos" => []
        ]);

        $qryPregunta = "SELECT distinct
            pregunta.id_pregunta,
            pregunta.nombre
        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";
        $qryArrayPregunta = mysql_query($qryPregunta);
        mysqlException(mysql_error(),"_01");
        $qryDataPregunta = mysql_fetch_array($qryArrayPregunta);
        $id_pregunta = $qryDataPregunta["id_pregunta"];
        $nombre_pregunta = $qryDataPregunta["nombre"];

        $qryDistractor = "SELECT id_distractor,abreviatura as nombre
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor = 10";
        $qryArrayDistractor = mysql_query($qryDistractor);  
        $ultimo_caso_insertado = (sizeof($casos_clinicos))-1;
        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
            array_push($casos_clinicos[$ultimo_caso_insertado]["diagnostico"], [
                "id_distractor" => $qryDataDistractor["id_distractor"], 
                "nombre" => $qryDataDistractor["nombre"]
            ]);
        }

        $qryArrayDistractorPAT = "SELECT
            usuario.cod_usuario,
            distractor.id_distractor,
            distractor.abreviatura as nombre,
            distractor.valor
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
            array_push($casos_clinicos[$ultimo_caso_insertado]["respuestas_patologos"], [
                "cod_patologo" => $qryDataDistractorPAT["cod_usuario"], 
                "id_distractor" => $qryDataDistractorPAT["id_distractor"], 
                "nombre" => $qryDataDistractorPAT["nombre"],
                "valor" => $qryDataDistractorPAT["valor"]
            ]);
        }

        // Definir los nombres para la impresion de casos clinicos en ecabezado de la tabla
        array_push($nombres_casos_clinicos, $nom_caso_clinico . "\n" . $cod_caso_clinico);
        array_push($coloresFondo, $pdf->azulFondoP);
        array_push($anchosRow, $anchoCasoClinico);
    }

    $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
    $pdf->SetWidths($anchosRow);
    $pdf->SetFont("Arial","B",7);
    $pdf->SetHeightRow(4);
    $pdf->SetFillColorsRow($coloresFondo);
    $pdf->rowPAP($nombres_casos_clinicos);

    /* ********************************* */
    // Impresion de respuestas correctas
    /* ********************************* */

    $anchosRow = [];
    $coloresFondo = [];
    $nombres_respuestas_correctas = [];
    array_push($anchosRow, $anchoColumn1);
    array_push($coloresFondo, $pdf->gris);
    array_push($nombres_respuestas_correctas, "Results");
    
    for($i=0; $i<sizeof($casos_clinicos); $i++){
        $caso_clinico_actual = $casos_clinicos[$i];
        array_push($anchosRow, $anchoCasoClinico);
        array_push($coloresFondo, $pdf->gris);
        $consolidado_correctas = "";
        for($x=0; $x<sizeof($caso_clinico_actual["diagnostico"]); $x++){
            if($x==0){ // Si es el promer distractor
                $consolidado_correctas = $caso_clinico_actual["diagnostico"][$x]["nombre"];
            } else {
                $consolidado_correctas = $consolidado_correctas . "\n" . $caso_clinico_actual["diagnostico"][$x]["nombre"];
            }
        }

        array_push($nombres_respuestas_correctas, $consolidado_correctas);
    }
    
    $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
    $pdf->SetWidths($anchosRow);
    $pdf->SetFont("Arial","B",7);
    $pdf->SetHeightRow(4.2);
    $pdf->SetFillColorsRow($coloresFondo);
    $pdf->rowPAP($nombres_respuestas_correctas);
    
    /* ************************************ */
    // Impresion de respuestas de patólogos
    /* ************************************ */


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
    $diagnosticos_discordanciamenor = 0;

    // Recorremos cada usuario ligado al laboratorio de patología
    for($count_pat=0; $count_pat<sizeof($usuarios_pat) ; $count_pat++){

        // Se agrega el código del patólogo
        $array_FCR = array();
        array_push($array_FCR, $pdf->blanco);

        $array_NR = array();
        array_push($array_NR,$usuarios_pat[$count_pat]["cod_usuario"]);
        $usuarios_pat[$count_pat]["concordantes"] = 0;
        $usuarios_pat[$count_pat]["discordancia_menor"] = 0;
        $usuarios_pat[$count_pat]["no_concordantes"] = 0;

        // Recorrer cada caso clínico del reto a identificar
        for($o=0; $o<sizeof($casos_clinicos); $o++){
            
            $caso_clinico_actual = $casos_clinicos[$o];
            $respuestas_patologos = $caso_clinico_actual["respuestas_patologos"];
            $id_respuestas_correctas = array_column($caso_clinico_actual["diagnostico"], "id_distractor");

            if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($respuestas_patologos, "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                
                // Obtendrá la primera respuesta que encuentra de esa pregunta
                $id_respuesta_pat = $respuestas_patologos[$search_cod]["id_distractor"];
                $nombre_respuesta_pat = $respuestas_patologos[$search_cod]["nombre"];
                $valor_respuesta_pat = $respuestas_patologos[$search_cod]["valor"];
    
                $criterioAct = $pdf->obtenerCriterioPAP($valor_respuesta_pat);
    
                if($criterioAct == 2){ // concordante
                    $usuarios_pat[$count_pat]["concordantes"]++;
                    $diagnosticos_concordantes++;
                    $colorFondoAct = $pdf->verde;
                } else if($criterioAct == 1){ // con discordancia menor
                    $usuarios_pat[$count_pat]["discordancia_menor"]++;
                    $diagnosticos_discordanciamenor++;
                    $colorFondoAct = $pdf->amarillo;
                } else { // No concordantes
                    $colorFondoAct = $pdf->rojo;
                    $diagnosticos_noconcordantes++;
                    $usuarios_pat[$count_pat]["no_concordantes"]++;
                }

                $nom_fin_distractor = $nombre_respuesta_pat;
                
                array_push($array_FCR, $colorFondoAct); // Color de fondo
                array_push($array_NR, $nom_fin_distractor);
            } else {
                // Se va a imprimir un N/A                   
                array_push($array_FCR, $pdf->blanco); // Color de fondo
                array_push($array_NR, "N/A"); 
            }
            
        }

        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosRow);
        $pdf->SetFont("Arial","",6.8);
        $pdf->SetHeightRow(4);
        $pdf->SetFillColorsRow($array_FCR);
        $pdf->rowPAP($array_NR);
    }

    
    /* ************************** */
    /* Seccion de la convenciones */
    /* ************************** */
    $pdf->Ln(4);
    $pdf->SetX(10);
    $pdf->SetFont("Arial","B",6.5);
    $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
    $pdf->Cell(20,4,"Interpretación",0,0,'C',1);
    $pdf->SetFont("Arial","",7);
    $pdf->SetFillColor($pdf->verde[0],$pdf->verde[1], $pdf->verde[2]);
    $pdf->Cell(19,4,"Concordante",0,0,'C',1);
    $pdf->SetFillColor($pdf->amarillo[0],$pdf->amarillo[1], $pdf->amarillo[2]);
    $pdf->Cell(25,4,"Discordancia menor",0,0,'C',1);
    $pdf->SetFillColor($pdf->rojo[0],$pdf->rojo[1], $pdf->rojo[2]);
    $pdf->Cell(20,4,"No concordante",0,0,'C',1);

    /* *************************************************** */
    // Seccion de calculos de resultados
    /* *************************************************** */

    // Primer nivel
    $pdf->Ln(10);
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
    $pdf->Cell($anchoValEst,4,"Todos los distractores",1,0,'C',1);


    /* ******* */
    // Gráfica
    /* ******* */


    $max_height_break = 0;
    $pdf->SetFont("Arial","B",6);
    if(!($diagnosticos_concordantes == 0 && $diagnosticos_discordanciamenor == 0 && $diagnosticos_noconcordantes == 0)){
        $ruta_image = $pdf->generarGraficoPAP(
            $diagnosticos_concordantes,
            $diagnosticos_discordanciamenor,
            $diagnosticos_noconcordantes
        );
        
        $xImage = $anchoValEst + $left_valest;
        $yImage = $pdf->GetY();
        
        $pdf->Image($ruta_image,$xImage,($yImage-4),$anchoContGrafica, $altoContGrafica);
        unlink($ruta_image);

        $max_height_break = ($pdf->GetY() + $altoContGrafica);
    }
    
    $anchoSeccionP = 30;

    /* ***************************************************** */
    // Continuacion de la informacion del resumen
    /* ***************************************************** */

    $pdf->Ln(4);
    $pdf->SetFont("Arial","",6);
    $pdf->setX($left_valest);
    $pdf->SetAligns(array("C","C"));
    $pdf->SetWidths([35, 65]);
    $pdf->SetHeightRow(3.8);
    $pdf->SetFillColorsRow([$pdf->gris,$pdf->gris]);
    $pdf->SetTextColorsRow([$pdf->negro,$pdf->negro]);
    $pdf->SetGrossLineLeftRow([true, false]);
    $pdf->SetGrossLineRightRow([false, true]);
    $pdf->RowPAP(["Abreviatura", "Descripción"]);
    
    // Traer la pregunta del diagnostico
    $qryPreguntaRP = "SELECT
        pregunta.id_pregunta,
        pregunta.nombre
    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'
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

            $pdf->SetFont("Arial","",5.8);
            $pdf->setX($left_valest);
            $pdf->SetAligns(array("C","C"));
            $pdf->SetWidths([35, 65]);
            $pdf->SetHeightRow(3.8);
            $pdf->SetFillColorsRow([$pdf->blanco,$pdf->blanco]);
            $pdf->SetTextColorsRow([$pdf->negro,$pdf->negro]);
            $pdf->SetGrossLineLeftRow([true, false]);
            $pdf->SetGrossLineRightRow([false, true]);
            $pdf->RowPAP([$abreviatura, $nombre]);
        }
    }
    
    $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
    $pdf->SetX(40);
    $pdf->Cell(100,1,"","T",0,'C',0);

    $pdf->SetY($max_height_break);
    $pdf->SetX(10);
    $pdf->Ln(3);

    if($pdf->GetY() > 184.27){ // Si el alto es mayor al cupo para la firma
        $pdf->AddPage();
    }
    $pdf->SetFont("Arial","B",6.2);
    $pdf->MultiCell(260,3,"- Final del reporte -\n   Página ". $pdf->PageNo(). " de {nb}\n",0,'C',0);
    $pdf->MultiCell(260,3,"\n\n\n\nAprobado por:\nAída Porras. Magister en Biología. Doctor in management.\nCoordinadora Programas QAP PAT",0,'C',0);

    // Cerrar PDF
    $pdf->Close();
    $nomArchivo = utf8_decode("$num_laboratorio - Intralaboratorio PAP $pdf->nom_reto $nom_laboratorio.pdf");
    $pdf->Output("I",$nomArchivo);

?>