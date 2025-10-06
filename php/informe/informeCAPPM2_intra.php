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
        $pdf->RowPM2($nombresEncabezados);
        
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
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% Tinción' and pregunta.nombre = '".$nom_muestra_act."'";

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
            
            $qryDistractor = "SELECT id_distractor,
                                replace(replace(distractor.abreviatura,'&lt;','<'),'&gt;','>') as 'nombre'
                              from distractor
                              where pregunta_id_pregunta = $id_pregunta and valor > 0
                              limit 1";

            $qryArrayDistractor = mysql_query($qryDistractor);  
            while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                array_push($pdf->respuestas[($sizeofmuestras-1)]["respuestas"], ["id_distractor" => $qryDataDistractor["id_distractor"], "nombre" => $qryDataDistractor["nombre"]]);
            }


            $sizeofmuestras = sizeof($pdf->respuestas);
            // Aqui va a ir el query para obtener los intentos de patron de tincion para esta pregunta
            $qryArrayDistractorPAT = "SELECT
                usuario.cod_usuario,
                distractor.id_distractor,
                replace(replace(distractor.abreviatura,'&lt;','<'),'&gt;','>') as 'nombre'
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
                        $cadena_distractores_act = $pdf->GetTypeDistractorPM2($distractor_actual);
                    } else {
                        $cadena_distractores_act = $cadena_distractores_act . "\n" . $pdf->GetTypeDistractorPM2($distractor_actual);
                    }
                }
            }
            array_push($array_NR, $cadena_distractores_act);
        }
        
        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosEncabezados);
        $pdf->SetHeightRow(5);


        $pdf->SetFillColorsRow($array_FCR);
        $pdf->SetGrossLineLeftRow($array_GLLR);
        $pdf->SetGrossLineRightRow($array_GLRR);
        $pdf->RowPM2($array_NR);
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
                $nom_respuestas_correctas = array();
                for($dfdd=0; $dfdd<sizeof($pregunta_exacta_act["respuestas"]); $dfdd++){
                    array_push($nom_respuestas_correctas,$pregunta_exacta_act["respuestas"][$dfdd]["nombre"]);
                }

                // Almacenar en el array de la fila, los valores respondidos por el patólogo
                // 1. Buscar al patologo en el array 
                if(is_numeric($search_cod = array_search($usuarios_pat[$count_pat]["cod_usuario"], array_column($pregunta_exacta_act["respuestas_patologos"], "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                    // Obtendra la primera respuesta que encuentra de esa pregunta
                    $id_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["id_distractor"];
                    $nombre_respuesta_pat = $pregunta_exacta_act["respuestas_patologos"][$search_cod]["nombre"];

                    $criterioAct = $pdf->obtenerCriterioPM2($nombre_respuesta_pat, (isset($nom_respuestas_correctas[0]) ? $nom_respuestas_correctas[0] : "N/A"));

                    if($criterioAct == 2){
                        $colorFondoAct = $pdf->blanco;
                    } else if($criterioAct == 1){
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
            $pdf->RowPM2($array_NR);
        }

        /* *************************************************** */
        // Seccion de interpretacion
        /* *************************************************** */
        $pdf->Ln(2);
        $pdf->SetFont("Arial","B",6);
        $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
        $pdf->SetX(20);
        $pdf->Cell(30,3,"Interpretación con base a positividad (% tinción)",0,0,'C',1);
        $pdf->SetX(62);
        $pdf->SetFont("Arial","",6);
        $pdf->SetFillColor($pdf->verde[0],$pdf->verde[1], $pdf->verde[2]);
        $pdf->Cell(17,3,"Concordante",0,0,'C',1);
        $pdf->SetFillColor($pdf->rojo[0],$pdf->rojo[1], $pdf->rojo[2]);
        $pdf->Cell(17,3,"No concordante",0,0,'C',1);


        /* *************************************************** */
        // Nomeclatura
        /* *************************************************** */
        $pdf->Ln(4);
        $pdf->SetX(10);
        $pdf->Cell(100,3,"ST = Sin tinción; POSITIVOS= 1% - 10%, 11% - 50%, >50%; NEGATIVOS= ST, <1%;",0,0,'L',0);
        $pdf->Ln(2);


        /* ********************************************** */
        // Seccion de grafica y valoracion de calidad
        /* ********************************************** */
        
        // Primer nivel
        $pdf->SetFillColor(255,255,255);
        $pdf->SetDrawColor(21, 67, 96);


        $left_valest  = 10;
        $anchoValEst = 152;
        $anchoContGrafica = 120;
        $altoContGrafica = 64.5;
        
        $pdf->Ln(10);
        $pdf->SetFont("Arial","B",6);
        $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
        $pdf->SetX($left_valest);
        $pdf->SetLineWidth($pdf->lineaGruesa);
        $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
        $pdf->Cell($anchoValEst,4,"Intensity response table","TLR",0,'C',1);
        
        /* ******* */
        // Gráfica
        /* ******* */
        
        $pdf->SetLineWidth($pdf->lineaDelgada);
        $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
        $max_height_break = 0;
        $pdf->SetFont("Arial","B",6);

        if(!($diagnosticos_concordantes == 0 && $diagnosticos_noconcordantes == 0)){
            
            $ruta_image = $pdf->generarGraficoPM2($diagnosticos_concordantes,$diagnosticos_noconcordantes);
            $xImage = $anchoValEst + $left_valest;
            $yImage = $pdf->GetY();
            
            $pdf->Image($ruta_image,$xImage+4,$yImage-4,$anchoContGrafica, $altoContGrafica);
            unlink($ruta_image);
            $max_height_break = ($pdf->GetY() + $altoContGrafica);
        }

        $anchoSeccionP = 30;
        $pdf->Ln();


        /* ************************************************ */
        // Impresion de la seccion de intensidad de tincion 
        /* ************************************************ */
        $ancho_total_muestras = 152;
        $anchoColumn1 = 21;
        $muestras_patologos = array();
        $ancho_muestra = ($ancho_total_muestras - $anchoColumn1) / $pdf->num_muestras;
        
        $nombres_muestras_sub = ["Muestras"];
        $anchosRow = [$anchoColumn1];
        $coloresFondo = [$pdf->azulFondoP];
        
        $qryPreguntaSub = "SELECT distinct
            pregunta.id_pregunta,
            pregunta.nombre
        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad'";
        $qryArrayPreguntaSub = mysql_query($qryPreguntaSub);
        mysqlException(mysql_error(),"_01");
        
        $aux_increment = -1;

        while($qryDataPreguntaSub = mysql_fetch_array($qryArrayPreguntaSub)) {
            // Muestras de la 1 a la 10 para INTENSIDAD
            $id_pregunta = $qryDataPreguntaSub["id_pregunta"];
            $nombre_pregunta = $qryDataPreguntaSub["nombre"];
            $aux_increment++;
            $muestras_patologos[$aux_increment] = array();

            // Definir los nombres para la impresion de casos clinicos en ecabezado de la tabla
            array_push($nombres_muestras_sub, $nombre_pregunta);
            array_push($anchosRow, $ancho_muestra);
            array_push($coloresFondo, $pdf->azulFondoP);
            

            $qryArrayDistractorPAT = "SELECT
                usuario.cod_usuario,
                distractor.id_distractor,
                distractor.nombre,
                distractor.abreviatura
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
                array_push($muestras_patologos[$aux_increment], [
                    "cod_patologo" => $qryDataDistractorPAT["cod_usuario"], 
                    "id_distractor" => $qryDataDistractorPAT["id_distractor"], 
                    "nombre" => $qryDataDistractorPAT["abreviatura"]
                    ]
                );
            }
        }


        $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        $pdf->SetWidths($anchosRow);
        $pdf->SetFont("Arial","B",6);
        $pdf->SetHeightRow(4);
        $pdf->SetFillColorsRow($coloresFondo);
        $pdf->RowPIP($nombres_muestras_sub);


        /* ************************************ */
        // Impresion de respuestas de patólogos
        /* ************************************ */
        $qryArrayUsersPATSub = "SELECT DISTINCT
            usuario.*
        from 
            laboratorio 
            join usuario_laboratorio on laboratorio.id_laboratorio = usuario_laboratorio.id_laboratorio 
            join usuario on usuario.id_usuario = usuario_laboratorio.id_usuario
            join intento on laboratorio.id_laboratorio = intento.laboratorio_id_laboratorio and usuario.id_usuario = intento.usuario_id_usuario    
        where laboratorio.id_laboratorio = $laboratorio_pat and intento.reto_id_reto = $reto_pat
        order by usuario.cod_usuario
        ";
        $qryArrayUsersPATSub = mysql_query($qryArrayUsersPATSub);
        mysqlException(mysql_error(),"_02");

        $usuarios_pat_sub = array();

        while($qryDataUsuariosPATSub = mysql_fetch_array($qryArrayUsersPATSub)) {
            $usuario_pat_sub = array();
            $usuario_pat_sub["id_usuario"] = $qryDataUsuariosPATSub["id_usuario"];
            $usuario_pat_sub["nombre_usuario"] = $qryDataUsuariosPATSub["nombre_usuario"];
            $usuario_pat_sub["cod_usuario"] = $qryDataUsuariosPATSub["cod_usuario"];
            $usuarios_pat_sub[] = $usuario_pat_sub;
        }

        // Recorremos cada usuario ligado al laboratorio de patología
        for($count_pat_sub=0; $count_pat_sub<sizeof($usuarios_pat_sub); $count_pat_sub++){

            // Se agrega el código del patólogo
            $array_FCR = array();
            array_push($array_FCR, $pdf->blanco);

            $array_NR = array();
            array_push($array_NR,$usuarios_pat_sub[$count_pat_sub]["cod_usuario"]);
            $usuarios_pat_sub[$count_pat_sub]["concordantes"] = 0;
            $usuarios_pat_sub[$count_pat_sub]["no_concordantes"] = 0;

            // Recorrer cada muestra del reto a identificar
            for($o=0; $o<sizeof($muestras_patologos); $o++){
                
                $respuestas_patologos = $muestras_patologos[$o];

                if(is_numeric($search_cod = array_search($usuarios_pat_sub[$count_pat_sub]["cod_usuario"], array_column($respuestas_patologos, "cod_patologo")))){ // Si encuentra el patologo en la lista de intentos
                    // Obtendrá la primera respuesta que encuentra de esa pregunta
                    $id_respuesta_pat = $respuestas_patologos[$search_cod]["id_distractor"];
                    $nombre_respuesta_pat = $respuestas_patologos[$search_cod]["nombre"];
                    $nom_fin_distractor = $nombre_respuesta_pat;
                    array_push($array_NR, $nom_fin_distractor);
                } else {
                    array_push($array_NR, "N/A"); 
                }
                array_push($array_FCR, $pdf->blanco); // Color de fondo
                
            }

            $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
            $pdf->SetWidths($anchosRow);
            $pdf->SetFont("Arial","",5);
            $pdf->SetHeightRow(4);
            $pdf->SetFillColorsRow($array_FCR);
            $pdf->RowPM2($array_NR);
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
    $nomArchivo = utf8_decode("$num_laboratorio - Intralaboratorio PM2 $pdf->nom_reto $nom_laboratorio.pdf");
    $pdf->Output("I",$nomArchivo);

?>