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
    
    $max_height_break = 0;

    while($qryData = mysql_fetch_array($qryArray)) {
                
        $pdf->distractoresGenerales = array();

        $id_caso_clinico = $qryData["id_caso_clinico"];
        $nom_caso_clinico = $qryData["nombre"];
        $cod_caso_clinico = $qryData["codigo"];

        $pdf->num_muestras = 0;
        $qryPregunta = "SELECT distinct
            pregunta.nombre
        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico";
        $muestras = array();
        $qryArrayPregunta = mysql_query($qryPregunta);
        mysqlException(mysql_error(),"_01");
        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
            $muestras[] = [
                "nombre" => $qryDataPregunta["nombre"],
                "concordantes" => array(),
                "no_concordantes" => array()
            ];
        }
        $pdf->num_muestras = sizeof($muestras);
    
    
        $pdf->AddPage(); // Portada
        $pdf->SetAutoPageBreak(true,5);
        $pdf->Ln(5);

        // Impresion de caso clinico
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(25,4,$nom_caso_clinico,0,0,'L',0);

        // Impresion de codigo de caso clinico 
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(10,4,"Código:",0,0,'L',0);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(22,4,$cod_caso_clinico,0,0,'L',0);


        // Fecha de generacion de caso clinico
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(27,4,"Fecha de generación:",0,0,'L',0);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(26,4,Date("Y-m-d h:i"),0,0,'L',0);


        // Laboratorio
        $pdf->SetFont("Arial","B",7);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Cell(15,4,"Laboratorio:",0,0,'L',0);
        $pdf->SetFont("Arial","",7);
        $pdf->Cell(70,4,"$num_laboratorio - $nom_laboratorio",0,0,'L',0);
    
        // Impresion de la tabla de comparacion
        $ancho_total_muestras = 243;
        $ancho_muestra = $ancho_total_muestras / $pdf->num_muestras;

        $pdf->SetFont('Arial','B',6);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Ln(8);
    
        // Primer nivel
        $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
        $pdf->SetLineWidth($pdf->lineaGruesa);
        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        $pdf->Cell(18,4,"-","TLR",0,'C',1);
        $pdf->Cell(($ancho_muestra * $pdf->num_muestras),4,"Muestras","TLR",0,'C',1);
        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        $pdf->SetLineWidth($pdf->lineaGruesa);
        
        /* ************* */
        // Segundo nivel
        /* ************* */
        $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
        $pdf->SetX(28);

        $nombresEncabezados = array();
        $bordesIzqEncabezados = array();
        $bordesDerEncabezados = array();
        $coloresFondoEncabezados = array();
        $anchosEncabezados = array();

        array_push($nombresEncabezados, "Muestras");
        array_push($bordesIzqEncabezados, true);
        array_push($bordesDerEncabezados, true);
        array_push($coloresFondoEncabezados, $pdf->azulFondoP);
        array_push($anchosEncabezados, 18);

        // Muestras
        for($x=0; $x < sizeof($muestras);$x++){
            array_push($nombresEncabezados, $muestras[$x]["nombre"]);
            if($x==0){
                array_push($bordesIzqEncabezados, true);
            } else {
                array_push($bordesIzqEncabezados, false);
            }
            
            if(($x+1) == sizeof($muestras)){ // Si es la ultima muestra
                array_push($bordesDerEncabezados, true);
            } else {
                array_push($bordesDerEncabezados, false);
            }

            array_push($coloresFondoEncabezados, $pdf->azulFondoP);
            array_push($anchosEncabezados, $ancho_muestra);
        }
        
        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosEncabezados);
        $pdf->SetHeightRow(5);
        $pdf->Ln(4);
        
        $pdf->SetFillColorsRow($coloresFondoEncabezados);
        $pdf->SetGrossLineLeftRow($bordesIzqEncabezados);
        $pdf->SetGrossLineRightRow($bordesDerEncabezados);
        $pdf->RowHER2($nombresEncabezados);
        
        /* ********************* */
        // Tercer nivel
        /* ********************* */
        /* ****************************************************************** */
        // Definicion de respuestas correctas para cada uno de los muestras  
        /* ****************************************************************** */

        $pdf->respuestas = array();

        for($dsb=0;$dsb<sizeof($muestras);$dsb++){
            
            $nom_muestra_act = $muestras[$dsb]["nombre"];

            /* ***************************** */
            // Obtener preguntas correctas
            /* ***************************** */
            $qryPregunta = "SELECT distinct pregunta.id_pregunta,pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Score' and pregunta.nombre = '".$nom_muestra_act."'";

            $qryDataPregunta = mysql_fetch_array((mysql_query($qryPregunta)));
            mysqlException(mysql_error(),"_03");
            $id_pregunta = $qryDataPregunta["id_pregunta"];
            $nombre_pregunta = $qryDataPregunta["nombre"];
            array_push($pdf->respuestas, [
                "id_pregunta" => $id_pregunta, 
                "nombre_pregunta" => $nombre_pregunta, 
                "respuestas" => array(), 
                "respuestas_patologos" => array()
            ]);
            
            $sizeofmuestras = sizeof($pdf->respuestas);
            
            $qryDistractor = "SELECT 
                                id_distractor,
                                distractor.abreviatura as 'nombre'
                              from distractor
                              where pregunta_id_pregunta = $id_pregunta and valor > 0";

            $qryArrayDistractor = mysql_query($qryDistractor);  
            while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                array_push($pdf->respuestas[($sizeofmuestras-1)]["respuestas"], ["id_distractor" => $qryDataDistractor["id_distractor"], "nombre" => $qryDataDistractor["nombre"]]);
            }


            $sizeofmuestras = sizeof($pdf->respuestas);
            // Aqui va a ir el query para obtener los intentos de patron de tincion para esta pregunta
            $qryArrayDistractorPAT = "SELECT
                usuario.cod_usuario,
                distractor.id_distractor,
                distractor.abreviatura as 'nombre'
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
                
                array_push($pdf->respuestas[($sizeofmuestras-1)]["respuestas_patologos"], [
                    "cod_patologo" => $qryDataDistractorPAT["cod_usuario"], 
                    "id_distractor" => $qryDataDistractorPAT["id_distractor"], 
                    "nombre" => $qryDataDistractorPAT["nombre"]]
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
        array_push($array_NR,"Puntaje");
        
        // Recorder los marcadores y respuestas del patron de tincion
        for($xsdf=0; $xsdf<sizeof($pdf->respuestas); $xsdf++){
            $pregunta_exacta_act = $pdf->respuestas[$xsdf];

            array_push($array_FCR, $pdf->gris);
            if($xsdf==0){ 
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

            if(sizeof($pregunta_exacta_act["respuestas"]) == 0){ // Si no hay respuestas predefinidas
                $cadena_distractores_act = "N/A";
            } else {

                for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                    $distractor_actual = $pregunta_exacta_act["respuestas"][$dfdd]["nombre"];
                    
                    if($dfdd==0){
                        $cadena_distractores_act = $distractor_actual;
                    } else {
                        $cadena_distractores_act = $cadena_distractores_act . "\n" . $distractor_actual;
                    }
                }
            }
            array_push($array_NR, $cadena_distractores_act);
        }
        
        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosEncabezados);
        $pdf->SetHeightRow(3.5);


        $pdf->SetFillColorsRow($array_FCR);
        $pdf->SetGrossLineLeftRow($array_GLLR);
        $pdf->SetGrossLineRightRow($array_GLRR);
        $pdf->RowHER2($array_NR);
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
        order by usuario.cod_usuario";

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

            $usuarios_pat[$count_pat]["concordantes"] = 0;
            $usuarios_pat[$count_pat]["no_concordantes"] = 0;
            
            // Recorder las muestras y respuestas
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas[$xsdf];

                if($xsdf==0){ 
                    array_push($array_GLLR, true); 
                } else { 
                    array_push($array_GLLR, false);
                }

                if(($xsdf+1) == sizeof($pdf->respuestas)){ // Si es la ultima muestra
                    array_push($array_GLRR, true);
                } else {
                    array_push($array_GLRR, false);
                }
                
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

                    $criterioAct = $pdf->obtenerCriterioHER2($id_respuesta_pat, $id_respuestas_correctas);

                    if($criterioAct == true){
                        $colorFondoAct = $pdf->verde;
                        $diagnosticos_concordantes++;
                        $usuarios_pat[$count_pat]["concordantes"]++;
                    } else { // 0
                        $colorFondoAct = $pdf->rojo;
                        $diagnosticos_noconcordantes++;
                        $usuarios_pat[$count_pat]["no_concordantes"]++;
                    }

                    array_push($array_FCR, $colorFondoAct); // Color de fondo
                    array_push($array_NR, $nombre_respuesta_pat);

                } else {
                    // Se va a imprimir un N/A                   
                    array_push($array_FCR, $pdf->blanco); // Color de fondo
                    array_push($array_NR, "N/A"); 
                }
            }
        
            $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
            $pdf->SetWidths($anchosEncabezados);
            $pdf->SetHeightRow(5);
            $pdf->SetFillColorsRow($array_FCR);
            $pdf->SetGrossLineLeftRow($array_GLLR);
            $pdf->SetGrossLineRightRow($array_GLRR);
            $pdf->RowHER2($array_NR);
        }

        /* *************************************************** */
        // Seccion de interpretacion
        /* *************************************************** */
        $pdf->Ln(2);
        $pdf->SetFont("Arial","B",6);
        $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
        $pdf->SetX(10);
        $pdf->Cell(30,3,"Interpretación",0,0,'L',1);
        $pdf->SetX(30);
        $pdf->SetFont("Arial","",6);
        $pdf->SetFillColor($pdf->verde[0],$pdf->verde[1], $pdf->verde[2]);
        $pdf->Cell(17,3,"Concordante",0,0,'C',1);
        $pdf->SetFillColor($pdf->rojo[0],$pdf->rojo[1], $pdf->rojo[2]);
        $pdf->Cell(17,3,"No concordante",0,0,'C',1);

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
    if(!($diagnosticos_concordantes == 0 && $diagnosticos_noconcordantes == 0)){
        $ruta_image = $pdf->generarGraficoHER2(
            $diagnosticos_concordantes,
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
    $pdf->RowHER2(["Abreviatura", "Descripción"]);
    
    // Traer la pregunta del diagnostico
    $qryPreguntaRP = "SELECT
        pregunta.id_pregunta,
        pregunta.nombre
    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Score'
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
            $pdf->RowHER2([$abreviatura, $nombre]);
        }
    }




















    }


    if($pdf->GetY() > $max_height_break){ // Si el alto de la tabla es mayor al de los 
        $max_height_break = ($pdf->GetY() + 4);
    }
    
    $pdf->SetY($max_height_break);
    $pdf->SetX(12);
    $pdf->Ln(7);
    $pdf->SetFont("Arial","B",6.2);
    
    if($pdf->GetY() > 181.25){ // Si el alto es mayor al cupo para la firma
        $pdf->AddPage();
    }
    
    $pdf->MultiCell(260,3,"- Final del reporte -\n   Página ". $pdf->PageNo(). " de {nb}\n",0,'C',0);
    $pdf->MultiCell(260,3,"\n\n\n\nAprobado por:\nAída Porras. Magister en Biología. Doctor in management.\nCoordinadora Programas QAP PAT",0,'C',0);



    // Cerrar PDF
    $pdf->Close();
    $nomArchivo = utf8_decode("$num_laboratorio - Intralaboratorio CAP-HER2 $pdf->nom_reto $nom_laboratorio.pdf");
    $pdf->Output("I",$nomArchivo);

?>