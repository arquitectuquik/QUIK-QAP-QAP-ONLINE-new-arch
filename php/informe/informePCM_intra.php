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

    $count_caso_clinico = 0;

    while($qryData = mysql_fetch_array($qryArray)) {
        
        $count_caso_clinico++;

        $pdf->distractoresGenerales = array();

        if($count_caso_clinico==1){

            
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
            $pdf->Cell(60,4,$nom_caso_clinico,0,0,'L',0);
    
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
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetLineWidth($pdf->lineaGruesa);
            $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
            $pdf->Cell(18,4,"-","TLR",0,'C',1);
    
            $pdf->Cell(($ancho_muestra * $pdf->num_muestras),4,"Muestras","TLR",0,'C',1);
            
    
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
            
            array_push($nombresEncabezados, "Muestras");
            array_push($bordesIzqEncabezados, true);
            array_push($bordesDerEncabezados, true);
            array_push($coloresFondoEncabezados, $pdf->blanco);
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
    
                array_push($coloresFondoEncabezados, $pdf->blanco);
                array_push($anchosEncabezados, $ancho_muestra);
            }
            
            $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
            $pdf->SetWidths($anchosEncabezados);
            $pdf->SetHeightRow(5);
            $pdf->Ln(4);
            
            $pdf->SetFillColorsRow($coloresFondoEncabezados);
            $pdf->SetGrossLineLeftRow($bordesIzqEncabezados);
            $pdf->SetGrossLineRightRow($bordesDerEncabezados);
            $pdf->RowIHQ($nombresEncabezados);
            
            
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
                                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '".$nom_muestra_act."'";
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
                                    replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
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
                    replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
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
            array_push($array_FCR, $pdf->blanco);
            array_push($array_GLLR, true);
            array_push($array_GLRR, false);
            array_push($array_NR,"Puntaje");
            
            // Recorder los marcadores y respuestas del patron de tincion
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas[$xsdf];
    
                array_push($array_FCR, $pdf->blanco);
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
            $pdf->SetHeightRow(5);
    
    
            $pdf->SetFillColorsRow($array_FCR);
            $pdf->SetGrossLineLeftRow($array_GLLR);
            $pdf->SetGrossLineRightRow($array_GLRR);
            $pdf->RowIHQ($array_NR);
            $pdf->SetFont('Arial','',6);
    
    
            /* ********************************************* */
            // Impresion de resultados de los laboratorios
            /* ********************************************* */
    
            // Obtener todos los patólogos que estén para habilitados para el laboratorio
            $qryArrayUsersPAT = "SELECT 
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
    
                        $criterioAct = $pdf->obtenerCriterioPCM($nombre_respuesta_pat, $nom_respuestas_correctas[0]);
    
                        if($criterioAct){
                            $colorFondoAct = $pdf->verde;
                            $diagnosticos_concordantes++;
                            $usuarios_pat[$count_pat]["concordantes"]++;
                        } else {
                            $colorFondoAct = $pdf->rojo;
                            $diagnosticos_noconcordantes++;
                            $usuarios_pat[$count_pat]["no_concordantes"]++;
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
                // $pdf->SetHeightRow(5);
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
            // Código Consenso de valoraciones
            /* ************************************* */

            // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
            $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                    
                            FROM grupo 
                            JOIN pregunta
                            ON grupo.id_grupo = pregunta.grupo_id_grupo

                            WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";

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
                                    
                                         WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";


                $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
                $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

                // Consulta SQL para obtener los distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
                $qryDistractores = "SELECT replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'

                                    FROM distractor 
                                
                                    INNER JOIN pregunta 
                                    ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                    INNER JOIN grupo 
                                    ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                    INNER JOIN caso_clinico 
                                    ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                                
                                    WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";

                $qryArrayDistractores = mysql_query($qryDistractores);

                // Consulta SQL para obtener todas las respuestas reportadas por pregunta (Muestra)
                $queryRespuestas = "SELECT distractor.id_distractor, replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'

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

                $pdf->SetFont('Arial','B',8);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetLineWidth(0.3);
                $pdf->SetDrawColor(61,123,162);
                $pdf->Cell(261,5,'Consenso de valoraciones - Muestra '. $nombre_pregunta,1,1,'C',1);

                $pdf->SetFont('Arial','',8);
                $pdf->SetWidths_dos($tamanoCeldaArray);
                $pdf->SetAligns_dos($ArrayDiscriminado3);
                $pdf->Row_dos($ArrayDiscriminado1);

                for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                    // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                    if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {

                        $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
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
            $pdf->Ln(2);
            $pdf->SetFont("Arial","B",6);
            $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
            $pdf->SetX(10);
            $pdf->Cell(75,3,"Interpretación con base a positividad (% de carcinoma con tinción nuclear)",0,0,'C',1);
            $pdf->SetX(90);
            $pdf->SetFont("Arial","",6);
            $pdf->SetTextColor(16, 155, 0); //Verde Oscuro
            $pdf->Cell(17,3,"Concordante",0,0,'C',1);
            $pdf->SetTextColor(203, 11, 11); //Rogo Oscuro
            $pdf->Cell(17,3,"No concordante",0,0,'C',1);
            
            /* ************************************* */
            // Convenciones
            /* ************************************* */

            $pdf->SetTextColor(0, 0, 0); //Restablecer color a negro

            if(sizeof($pdf->distractoresGenerales) > 0){ // Si hay distractores por poner
                $pdf->Ln(6);
                
                $pdf->SetX(9);
                $pdf->SetFont("Arial","B",6.5);
                $pdf->Cell(199,5,"Convenciones para diagnósticos",0,1,'L',0);
                
                $pdf->SetX(10);
                $pdf->SetFont("Arial","",7);
                for($xfr=0;$xfr<sizeof($pdf->distractoresGenerales); $xfr++){
                    $pdf->WriteHTML("<span><b>[".($xfr+1)."]</b> " .$pdf->distractoresGenerales[$xfr]. " </span> ");
                }

            }
            
            /* ************************************* */
            // Seccion de calculos de resultados
            /* ************************************* */
            
            // Primer nivel
            // $pdf->Ln(10);
            // $pdf->SetFillColor(255,255,255);
            // $pdf->SetDrawColor(21, 67, 96);
    
    
            // $left_valest  = 50;
            // $anchoValEst = 100;
    
            // $anchoContGrafica = 200 - $anchoValEst;
            // $pdf->SetFont("Arial","B",6);
            // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
            // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
            // $pdf->SetLineWidth($pdf->lineaDelgada);
            // $pdf->SetX($left_valest);
            // $pdf->Cell($anchoValEst,5,"Resultados intralaboratorio ".$pdf->nombre_programa,1,0,'C',1);
            
            /* ******* */
            // Gráfica
            /* ******* */
            
            // $ruta_image = $pdf->generarGraficoPQ($diagnosticos_concordantes,$diagnosticos_noconcordantes);
            // $xImage = $anchoValEst + $left_valest;
            // $yImage = $pdf->GetY();
            
            // $pdf->Image($ruta_image,$xImage,$yImage-4,$anchoContGrafica);
            // unlink($ruta_image);
            
            // $anchoSeccionP = 30;            
            // $pdf->Ln(5);
            // $pdf->SetX($left_valest);
            // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
            // $pdf->Cell(50,5,"COD.\nPatólogo",1,0,'C',1);
            // $pdf->Cell(25,5,"Concordantes",1,0,'C',1);
            // $pdf->Cell(25,5,"No concordantes",1,0,'C',1);
    
            // $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1],$pdf->blanco[2]);
            // $pdf->SetFont("Arial","",6);
            
            // for($count_pat=0; $count_pat<sizeof($usuarios_pat) ; $count_pat++){
            //     $pdf->Ln(5);
            //     $pdf->SetX($left_valest);
            //     $pdf->SetFont("Arial","B",6);
    
            //     $pdf->Cell(50,5,$usuarios_pat[$count_pat]["cod_usuario"],1,0,'C',1);
    
            //     $pdf->SetFont("Arial","",6);
            //     $pdf->Cell(25,5,$usuarios_pat[$count_pat]["concordantes"],1,0,'C',1);
            //     $pdf->Cell(25,5,$usuarios_pat[$count_pat]["no_concordantes"],1,0,'C',1);
            // }
    
            // Conteo de totales
            // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
            // $pdf->Ln(5);
            // $pdf->SetX($left_valest);
            // $pdf->SetFont("Arial","B",6);
    
            // $pdf->Cell(50,5,"Total",1,0,'C',1);
    
            // $pdf->SetFont("Arial","",6);
            // $pdf->Cell(25,5,$pdf->contarNumsArray(array_column($usuarios_pat,"concordantes")),1,0,'C',1);
            // $pdf->Cell(25,5,$pdf->contarNumsArray(array_column($usuarios_pat,"no_concordantes")),1,0,'C',1);

        } else if($count_caso_clinico==2){
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
            $pdf->Cell(60,4,$nom_caso_clinico,0,0,'L',0);
    
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
            
            array_push($nombresEncabezados, "Muestras");
            array_push($bordesIzqEncabezados, true);
            array_push($bordesDerEncabezados, true);
            array_push($coloresFondoEncabezados, $pdf->blanco);
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

                array_push($coloresFondoEncabezados, $pdf->blanco);
                array_push($anchosEncabezados, $ancho_muestra);
            }
            
            $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
            $pdf->SetWidths($anchosEncabezados);
            $pdf->SetHeightRow(5);
            $pdf->Ln(4);
            
            $pdf->SetFillColorsRow($coloresFondoEncabezados);
            $pdf->SetGrossLineLeftRow($bordesIzqEncabezados);
            $pdf->SetGrossLineRightRow($bordesDerEncabezados);
            $pdf->RowIHQ($nombresEncabezados);
            
            
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
                                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '".$nom_muestra_act."'";
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
                                    replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
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
                    replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
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
            array_push($array_FCR, $pdf->blanco);
            array_push($array_GLLR, true);
            array_push($array_GLRR, false);
            array_push($array_NR,"Puntaje");
            
            // Recorder los marcadores y respuestas del patron de tincion
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas[$xsdf];

                array_push($array_FCR, $pdf->blanco);
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
            $pdf->SetHeightRow(5);


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

                        $criterioAct = $pdf->obtenerCriterioPCM($nombre_respuesta_pat, $nom_respuestas_correctas[0]);

                        if($criterioAct){
                            $colorFondoAct = $pdf->verde;
                            $diagnosticos_concordantes++;
                            $usuarios_pat[$count_pat]["concordantes"]++;
                        } else {
                            $colorFondoAct = $pdf->rojo;
                            $diagnosticos_noconcordantes++;
                            $usuarios_pat[$count_pat]["no_concordantes"]++;
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
                // $pdf->SetHeightRow(5);
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
            // Código Consenso de valoraciones
            /* ************************************* */

            // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
            $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                    
                            FROM grupo 
                            JOIN pregunta
                            ON grupo.id_grupo = pregunta.grupo_id_grupo

                            WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";

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
                                    
                                         WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";


                $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
                $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

                // Consulta SQL para obtener los distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
                $qryDistractores = "SELECT replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'

                                    FROM distractor 
                                
                                    INNER JOIN pregunta 
                                    ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                    INNER JOIN grupo 
                                    ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                    INNER JOIN caso_clinico 
                                    ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                                
                                    WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";

                $qryArrayDistractores = mysql_query($qryDistractores);

                // Consulta SQL para obtener todas las respuestas reportadas por pregunta (Muestra)
                $queryRespuestas = "SELECT distractor.id_distractor, replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'

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

                $pdf->SetFont('Arial','B',8);
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetLineWidth(0.3);
                $pdf->SetDrawColor(61,123,162);
                $pdf->Cell(261,5,'Consenso de valoraciones - Muestra '. $nombre_pregunta,1,1,'C',1);

                $pdf->SetFont('Arial','',8);
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
            $pdf->Ln(2);
            $pdf->SetFont("Arial","B",6);
            $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
            $pdf->SetX(10);
            $pdf->Cell(75,3,"Interpretación con base a positividad (% de carcinoma con tinción nuclear)",0,0,'C',1);
            $pdf->SetX(90);
            $pdf->SetFont("Arial","",6);
            $pdf->SetTextColor(16, 155, 0); //Verde Oscuro
            $pdf->Cell(17,3,"Concordante",0,0,'C',1);
            $pdf->SetTextColor(203, 11, 11); //Rogo Oscuro
            $pdf->Cell(17,3,"No concordante",0,0,'C',1);
            
            /* ************************************* */
            // Convenciones
            /* ************************************* */

            $pdf->SetTextColor(0, 0, 0); //Restablecer color a negro

            if(sizeof($pdf->distractoresGenerales) > 0){ // Si hay distractores por poner
                $pdf->Ln(6);
                
                $pdf->SetX(9);
                $pdf->SetFont("Arial","B",6.5);
                $pdf->Cell(199,5,"Convenciones para diagnósticos",0,1,'L',0);
                
                $pdf->SetX(10);
                $pdf->SetFont("Arial","",7);
                for($xfr=0;$xfr<sizeof($pdf->distractoresGenerales); $xfr++){
                    $pdf->WriteHTML("<span><b>[".($xfr+1)."]</b> " .$pdf->distractoresGenerales[$xfr]. " </span> ");
                }

            }
            
            /* ************************************* */
            // Seccion de calculos de resultados
            /* ************************************* */
            
            // Primer nivel
            // $pdf->Ln(10);
            // $pdf->SetFillColor(255,255,255);
            // $pdf->SetDrawColor(21, 67, 96);


            // $left_valest  = 50;
            // $anchoValEst = 100;

            // $anchoContGrafica = 200 - $anchoValEst;
            // $pdf->SetFont("Arial","B",6);
            // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
            // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
            // $pdf->SetLineWidth($pdf->lineaDelgada);
            // $pdf->SetX($left_valest);
            // $pdf->Cell($anchoValEst,5,"Resultados intralaboratorio ".$pdf->nombre_programa,1,0,'C',1);
            
            /* ******* */
            // Gráfica
            /* ******* */
            
            // $ruta_image = $pdf->generarGraficoPQ($diagnosticos_concordantes,$diagnosticos_noconcordantes);
            // $xImage = $anchoValEst + $left_valest;
            // $yImage = $pdf->GetY();
            
            // $pdf->Image($ruta_image,$xImage,$yImage-4,$anchoContGrafica);
            // unlink($ruta_image);
            
            // $anchoSeccionP = 30;
            
            // $pdf->Ln(5);
            // $pdf->SetX($left_valest);
            // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
            // $pdf->Cell(50,5,"COD.\nPatólogo",1,0,'C',1);
            // $pdf->Cell(25,5,"Concordantes",1,0,'C',1);
            // $pdf->Cell(25,5,"No concordantes",1,0,'C',1);

            // $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1],$pdf->blanco[2]);
            // $pdf->SetFont("Arial","",6);
            
            // for($count_pat=0; $count_pat<sizeof($usuarios_pat) ; $count_pat++){
            //     $pdf->Ln(5);
            //     $pdf->SetX($left_valest);
            //     $pdf->SetFont("Arial","B",6);

            //     $pdf->Cell(50,5,$usuarios_pat[$count_pat]["cod_usuario"],1,0,'C',1);

            //     $pdf->SetFont("Arial","",6);
            //     $pdf->Cell(25,5,$usuarios_pat[$count_pat]["concordantes"],1,0,'C',1);
            //     $pdf->Cell(25,5,$usuarios_pat[$count_pat]["no_concordantes"],1,0,'C',1);
            // }

            // Conteo de totales
            // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
            // $pdf->Ln(5);
            // $pdf->SetX($left_valest);
            // $pdf->SetFont("Arial","B",6);

            // $pdf->Cell(50,5,"Total",1,0,'C',1);

            // $pdf->SetFont("Arial","",6);
            // $pdf->Cell(25,5,$pdf->contarNumsArray(array_column($usuarios_pat,"concordantes")),1,0,'C',1);
            // $pdf->Cell(25,5,$pdf->contarNumsArray(array_column($usuarios_pat,"no_concordantes")),1,0,'C',1);
        } else if($count_caso_clinico==3) {
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
            $pdf->Cell(60,4,$nom_caso_clinico,0,0,'L',0);
    
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
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetLineWidth($pdf->lineaGruesa);
            $pdf->SetDrawColor($pdf->azulOscuro[0],$pdf->azulOscuro[1],$pdf->azulOscuro[2]);
            $pdf->Cell(18,4,"-","TLR",0,'C',1);
    
            $pdf->Cell(($ancho_muestra * $pdf->num_muestras),4,"Muestras","TLR",0,'C',1);
            
    
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
            
            array_push($nombresEncabezados, "Muestras");
            array_push($bordesIzqEncabezados, true);
            array_push($bordesDerEncabezados, true);
            array_push($coloresFondoEncabezados, $pdf->blanco);
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
    
                array_push($coloresFondoEncabezados, $pdf->blanco);
                array_push($anchosEncabezados, $ancho_muestra);
            }
            
            $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
            $pdf->SetWidths($anchosEncabezados);
            $pdf->SetHeightRow(5);
            $pdf->Ln(4);
            
            $pdf->SetFillColorsRow($coloresFondoEncabezados);
            $pdf->SetGrossLineLeftRow($bordesIzqEncabezados);
            $pdf->SetGrossLineRightRow($bordesDerEncabezados);
            $pdf->RowIHQ($nombresEncabezados);
            
            
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
                                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Grado' and pregunta.nombre = '".$nom_muestra_act."'";
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
                                    replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
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
                    replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
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
            array_push($array_FCR, $pdf->blanco);
            array_push($array_GLLR, true);
            array_push($array_GLRR, false);
            array_push($array_NR,"Puntaje");
            
            // Recorder los marcadores y respuestas del patron de tincion
            for($xsdf=0; $xsdf<sizeof($pdf->respuestas); $xsdf++){
                $pregunta_exacta_act = $pdf->respuestas[$xsdf];
    
                array_push($array_FCR, $pdf->blanco);
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
            $pdf->SetHeightRow(5);
    
    
            $pdf->SetFillColorsRow($array_FCR);
            $pdf->SetGrossLineLeftRow($array_GLLR);
            $pdf->SetGrossLineRightRow($array_GLRR);
            $pdf->RowIHQ($array_NR);
            $pdf->SetFont('Arial','',6);
    
    
            /* ********************************************* */
            // Impresion de resultados de los laboratorios
            /* ********************************************* */
    
            // Obtener todos los patólogos que estén para habilitados para el laboratorio
            $qryArrayUsersPAT = "SELECT 
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
    
                        $criterioAct = $pdf->obtenerCriterioPCM($nombre_respuesta_pat, $nom_respuestas_correctas[0]);
    
                        if($criterioAct){
                            $colorFondoAct = $pdf->verde;
                            $diagnosticos_concordantes++;
                            $usuarios_pat[$count_pat]["concordantes"]++;
                        } else {
                            $colorFondoAct = $pdf->rojo;
                            $diagnosticos_noconcordantes++;
                            $usuarios_pat[$count_pat]["no_concordantes"]++;
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
                // $pdf->SetHeightRow(5);
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
            // Código Consenso de valoraciones
            /* ************************************* */

            // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
            $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                    
                            FROM grupo 
                            JOIN pregunta
                            ON grupo.id_grupo = pregunta.grupo_id_grupo

                            WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Grado'";

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
                                    
                                         WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Grado' and pregunta.nombre = '$nombre_pregunta'";


                $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
                $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

                // Consulta SQL para obtener los distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
                $qryDistractores = "SELECT replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'

                                    FROM distractor 
                                
                                    INNER JOIN pregunta 
                                    ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                    INNER JOIN grupo 
                                    ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                    INNER JOIN caso_clinico 
                                    ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                                
                                    WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$cod_caso_clinico' and grupo.nombre = 'Grado' and pregunta.nombre = '$nombre_pregunta'";

                $qryArrayDistractores = mysql_query($qryDistractores);

                // Consulta SQL para obtener todas las respuestas reportadas por pregunta (Muestra)
                $queryRespuestas = "SELECT distractor.id_distractor, replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'

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
                $pdf->SetFillColor(255, 255, 255);
                $pdf->SetLineWidth(0.3);
                $pdf->SetDrawColor(61,123,162);
                $pdf->Cell(261,5,'Consenso de valoraciones - Muestra '. $nombre_pregunta,1,1,'C',1);

                $pdf->SetFont('Arial','',7);
                $pdf->SetWidths_dos($tamanoCeldaArray);
                $pdf->SetAligns_dos($ArrayDiscriminado3);
                $pdf->Row_dos($ArrayDiscriminado1);

                for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                    // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                    if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {

                        $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
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
            $pdf->Ln(2);
            $pdf->SetFont("Arial","B",6);
            $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
            $pdf->SetX(10);
            $pdf->Cell(48,3,"Interpretación con base a positividad (puntaje)",0,0,'C',1);
            $pdf->SetFont("Arial","",6);
            $pdf->SetX(62);
            $pdf->SetTextColor(16, 155, 0); //Verde Oscuro
            $pdf->Cell(17,3,"Concordante",0,0,'C',1);
            $pdf->SetTextColor(203, 11, 11); //Rogo Oscuro
            $pdf->Cell(17,3,"No concordante",0,0,'C',1);
            
            /* ************************************* */
            // Convenciones
            /* ************************************* */
            
            $pdf->SetTextColor(0, 0, 0); //Restablecer color a negro

            if(sizeof($pdf->distractoresGenerales) > 0){ // Si hay distractores por poner
                $pdf->Ln(6);
                
                $pdf->SetX(9);
                $pdf->SetFont("Arial","B",6.5);
                $pdf->Cell(199,5,"Convenciones para diagnósticos",0,1,'L',0);
                
                $pdf->SetX(10);
                $pdf->SetFont("Arial","",7);
                for($xfr=0;$xfr<sizeof($pdf->distractoresGenerales); $xfr++){
                    $pdf->WriteHTML("<span><b>[".($xfr+1)."]</b> " .$pdf->distractoresGenerales[$xfr]. " </span> ");
                }

            }

            /* ************************************* */
            // Seccion de calculos de resultados
            /* ************************************* */
            
            // Primer nivel
            // $pdf->Ln(10);
            // $pdf->SetFillColor(255,255,255);
            // $pdf->SetDrawColor(21, 67, 96);
    
    
            // $left_valest  = 50;
            // $anchoValEst = 100;
    
            // $anchoContGrafica = 93;
            // $altoContGrafica = 50;

            // $pdf->SetFont("Arial","B",6);
            // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
            // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
            // $pdf->SetLineWidth($pdf->lineaDelgada);
            // $pdf->SetX($left_valest);
            // $pdf->Cell($anchoValEst,5,"Resultados intralaboratorio ".$pdf->nombre_programa,1,0,'C',1);
            
            /* ******* */
            // Gráfica
            /* ******* */


            // $max_height_break = 0;
            // $pdf->SetFont("Arial","B",6);
            // if(!($diagnosticos_concordantes == 0 && $diagnosticos_noconcordantes == 0)){
            //     $ruta_image = $pdf->generarGraficoPQ($diagnosticos_concordantes,$diagnosticos_noconcordantes);
            //     $xImage = $anchoValEst + $left_valest;
            //     $yImage = $pdf->GetY();
                
            //     $pdf->Image($ruta_image,$xImage,$yImage-4,$anchoContGrafica, $altoContGrafica);
            //     unlink($ruta_image);
                
            //     $max_height_break = ($pdf->GetY() + $altoContGrafica);
            // }
            
            
            // $anchoSeccionP = 30;
            
            // $pdf->Ln(5);
            // $pdf->SetX($left_valest);
            // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
            // $pdf->Cell(50,5,"COD.\nPatólogo",1,0,'C',1);
            // $pdf->Cell(25,5,"Concordantes",1,0,'C',1);
            // $pdf->Cell(25,5,"No concordantes",1,0,'C',1);
    
            // $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1],$pdf->blanco[2]);
            // $pdf->SetFont("Arial","",6);
            
            // for($count_pat=0; $count_pat<sizeof($usuarios_pat) ; $count_pat++){
            //     $pdf->Ln(5);
            //     $pdf->SetX($left_valest);
            //     $pdf->SetFont("Arial","B",6);
    
            //     $pdf->Cell(50,5,$usuarios_pat[$count_pat]["cod_usuario"],1,0,'C',1);
    
            //     $pdf->SetFont("Arial","",6);
            //     $pdf->Cell(25,5,$usuarios_pat[$count_pat]["concordantes"],1,0,'C',1);
            //     $pdf->Cell(25,5,$usuarios_pat[$count_pat]["no_concordantes"],1,0,'C',1);
            // }
    
            // Conteo de totales
            // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
            // $pdf->Ln(5);
            // $pdf->SetX($left_valest);
            // $pdf->SetFont("Arial","B",6);
    
            // $pdf->Cell(50,5,"Total",1,0,'C',1);
    
            // $pdf->SetFont("Arial","",6);
            // $pdf->Cell(25,5,$pdf->contarNumsArray(array_column($usuarios_pat,"concordantes")),1,0,'C',1);
            // $pdf->Cell(25,5,$pdf->contarNumsArray(array_column($usuarios_pat,"no_concordantes")),1,0,'C',1);


            if($pdf->GetY() > $max_height_break){ // Si el alto de la tabla es mayor al de los 
                $max_height_break = ($pdf->GetY() + 60);
            }
            
            $pdf->SetY($max_height_break);
            $pdf->SetX(12);
            $pdf->Ln(7);
            $pdf->SetFont("Arial","B",6.2);
        
            if($pdf->GetY() > 181.25){ // Si el alto es mayor al cupo para la firma
                $pdf->AddPage();
            }
        
            $pdf->MultiCell(260,3,"- Final del reporte -\n   Página ". $pdf->PageNo(). " de {nb}\n",0,'C',0);
            $pdf->MultiCell(260,3,"\n\n\n\n\n\n\n\n\n\nAprobado por:\nAída Porras. Magister en Biología. Doctor in management.\nCoordinadora Programas QAP PAT",0,'C',0);
        }
        
    }



    // Cerrar PDF
    $pdf->Close();
    $nomArchivo = utf8_decode("$num_laboratorio - Intralaboratorio PCM $pdf->nom_reto $nom_laboratorio.pdf");
    $pdf->Output("I",$nomArchivo);

?>