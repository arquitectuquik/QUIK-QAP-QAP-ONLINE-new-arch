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


    /* ****************************** */
    // Seccion de interpretacion
    /* ****************************** */

    $pdf->AddPage(); // Portada
    $pdf->SetAutoPageBreak(true,5);

    $pdf->Ln(5);
    $pdf->SetX(10);
    $pdf->SetFont("Arial","B",7);
    $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1], $pdf->blanco[2]);
    $pdf->Cell(20,4,"Interpretación",0,0,'C',1);
    $pdf->SetFont("Arial","B",7);
    $pdf->SetTextColor(16, 155, 0); //Verde Oscuro
    $pdf->Cell(20,4,"Concordante",0,0,'C',1);
    $pdf->SetTextColor(203, 11, 11); //Rogo Oscuro
    $pdf->Cell(20,4,"No concordante",0,0,'C',1);

    // Fecha de generacion de caso clinico
    $pdf->SetFont("Arial","B",7);
    $pdf->SetX($pdf->getX()+4);
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
    $pdf->Ln(10);
    
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
    $coloresFondo = [$pdf->blanco];
    
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

        $qryDistractor = "SELECT id_distractor,nombre
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
        $qryArrayDistractor = mysql_query($qryDistractor);  
        $ultimo_caso_insertado = (sizeof($casos_clinicos))-1;
        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
            array_push($casos_clinicos[$ultimo_caso_insertado]["diagnostico"], ["id_distractor" => $qryDataDistractor["id_distractor"], "nombre" => $qryDataDistractor["nombre"]]);
        }

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
            array_push($casos_clinicos[$ultimo_caso_insertado]["respuestas_patologos"], ["cod_patologo" => $qryDataDistractorPAT["cod_usuario"], "id_distractor" => $qryDataDistractorPAT["id_distractor"], "nombre" => $qryDataDistractorPAT["nombre"]]);
        }

        // Definir los nombres para la impresion de casos clinicos en ecabezado de la tabla
        array_push($nombres_casos_clinicos, $nom_caso_clinico . "\n" . $cod_caso_clinico);
        array_push($coloresFondo, $pdf->blanco);
        array_push($anchosRow, $anchoCasoClinico);
    }

    $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
    $pdf->SetWidths($anchosRow);
    $pdf->SetFont("Arial","B",7);
    $pdf->SetHeightRow(4);
    $pdf->SetFillColorsRow($coloresFondo);
    $pdf->RowPQ($nombres_casos_clinicos);

    /* ********************************* */
    // Impresion de respuestas correctas
    /* ********************************* */

    $anchosRow = [];
    $coloresFondo = [];
    $nombres_respuestas_correctas = [];
    array_push($anchosRow, $anchoColumn1);
    array_push($coloresFondo, $pdf->blanco);
    array_push($nombres_respuestas_correctas, "Valoración diagnóstica de referencia");
    
    for($i=0; $i<sizeof($casos_clinicos); $i++){
        $caso_clinico_actual = $casos_clinicos[$i];
        array_push($anchosRow, $anchoCasoClinico);
        array_push($coloresFondo, $pdf->blanco);
        $consolidado_correctas = "";
        for($x=0; $x<sizeof($caso_clinico_actual["diagnostico"]); $x++){
            if($x==0){ // Si es el promer distractor
                $consolidado_correctas = $pdf->SetDistractor($caso_clinico_actual["diagnostico"][$x]["nombre"]);
            } else {
                $consolidado_correctas = $consolidado_correctas . "\n" . $pdf->SetDistractor($caso_clinico_actual["diagnostico"][$x]["nombre"]);
            }
        }

        array_push($nombres_respuestas_correctas, $consolidado_correctas);
    }
    
    $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
    $pdf->SetWidths($anchosRow);
    $pdf->SetFont("Arial","B",7.5);
    $pdf->SetHeightRow(5);
    $pdf->SetFillColorsRow($coloresFondo);
    $pdf->RowPQ($nombres_respuestas_correctas);
    
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

    // Recorremos cada usuario ligado al laboratorio de patología
    for($count_pat=0; $count_pat<sizeof($usuarios_pat) ; $count_pat++){

        // Se agrega el código del patólogo
        $array_FCR = array();
        array_push($array_FCR, $pdf->blanco);

        $array_NR = array();
        array_push($array_NR,$usuarios_pat[$count_pat]["cod_usuario"]);
        $usuarios_pat[$count_pat]["concordantes"] = 0;
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
    
                $criterioAct = $pdf->obtenerCriterioPQ($id_respuesta_pat, $id_respuestas_correctas);
    
                if($criterioAct){
                    $usuarios_pat[$count_pat]["concordantes"]++;
                    $colorFondoAct = $pdf->verdeOscuro;
                    $diagnosticos_concordantes++;
                } else {
                    $colorFondoAct = $pdf->rojoOscuro;
                    $diagnosticos_noconcordantes++;
                    $usuarios_pat[$count_pat]["no_concordantes"]++;
                }
                $nom_fin_distractor = $pdf->SetDistractor($nombre_respuesta_pat);
                
                array_push($array_FCR, $colorFondoAct); // Color de fondo
                array_push($array_NR, $nom_fin_distractor);
    
            } else {
                // Se va a imprimir un N/A                   
                array_push($array_FCR, $pdf->blanco); // Color de fondo
                array_push($array_NR, "N/A"); 
            }
        }

        // $pdf->SetAligns(array("C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C","C"));
        // $pdf->SetWidths($anchosRow);
        // $pdf->SetFont("Arial","",7.5);
        // $pdf->SetHeightRow(5);
        // $pdf->SetFillColorsRow($array_FCR);
        // $pdf->RowPQ($array_NR);
        
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
            if($array_FCR[$i] == $pdf->verdeOscuro){ //verde

                $pdf->SetFont("Arial","B",7);
                $pdf->SetTextColor(16, 155, 0); //Verde
                $pdf->MultiCell($w,$pdf->heightRow,$array_NR[$i],0,$a,1);

            } else if ($array_FCR[$i] == $pdf->rojoOscuro){
        
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

    $pdf->Ln(3);
    
    /* ************************************* */
    // Código Consenso de valoraciones
     /* ************************************* */

    $qry = "SELECT id_caso_clinico, codigo, nombre, revision FROM caso_clinico where reto_id_reto = $pdf->id_reto_pat and estado = 1";
    $qryArray = mysql_query($qry);
    mysqlException(mysql_error(),"_01");
    $casos_clinicos = [];

    $pdf->SetFont('Arial','B',8);
    $pdf->SetDrawColor(0, 0, 0);
    $pdf->SetFillColor(198, 213, 221);
    $pdf->Cell(260,10,'Consenso de valoraciones','T',1,'C');

    $num_caso_clinico = 1;
    
    while($qryData = mysql_fetch_array($qryArray)) {

        $id_caso_clinico = $qryData["id_caso_clinico"];
        $cod_caso_clinico = $qryData["codigo"];

        $qryPregunta = "SELECT distinct
            pregunta.id_pregunta,
            pregunta.nombre
        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";
        $qryArrayPregunta = mysql_query($qryPregunta);
        mysqlException(mysql_error(),"_01");
        $qryDataPregunta = mysql_fetch_array($qryArrayPregunta);
        $id_pregunta = $qryDataPregunta["id_pregunta"];
       
        /* 
            Consulta SQL para contar el numero de distractores por caso clinico             
        */

        $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores FROM distractor                

                            INNER JOIN pregunta
                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta
                            INNER JOIN grupo
                            ON pregunta.grupo_id_grupo = grupo.id_grupo
                            INNER JOIN caso_clinico
                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico
                            
                            WHERE caso_clinico.reto_id_reto = $reto_pat && caso_clinico.codigo = '$cod_caso_clinico'";

        $qryArrayDistractoresCount = mysql_query($qryDistractoresCount);
        $qryDataDistractoresCount = mysql_fetch_array($qryArrayDistractoresCount);

        /* 
            Consulta SQL para traer todos los distractores por caso clinico             
        */

        $qryDistractores = "SELECT distractor.nombre FROM distractor                

                            INNER JOIN pregunta
                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta
                            INNER JOIN grupo
                            ON pregunta.grupo_id_grupo = grupo.id_grupo
                            INNER JOIN caso_clinico
                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico
                            
                            WHERE caso_clinico.reto_id_reto = $reto_pat && caso_clinico.codigo = '$cod_caso_clinico'";

        $qryArrayDistractores = mysql_query($qryDistractores);

        /* 
            Consulta SQL para obtener todas las respuestas reportadas por caso clinico
        */

        $queryPrueba = "SELECT distractor.id_distractor, distractor.nombre

                        from distractor 
        
                        join respuesta_lab 
                        on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                        join intento
                        on intento.id_intento = respuesta_lab.intento_id_intento
                                            
                        where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' && intento.usuario_id_usuario != '297'";
                        
        

        $qryArrayPrueba = mysql_query($queryPrueba);

        $arrayRespuestas = array();

        while($qryDataPrueba = mysql_fetch_array($qryArrayPrueba)) {

            array_push($arrayRespuestas, $qryDataPrueba['nombre']);
    
        }

        /*  
            Se guardan todos los distractores por caso clinico en un array
        */

        $nombreDistractoresArray = array();

        while($qryDataDistractores = mysql_fetch_array($qryArrayDistractores)) {

            array_push($nombreDistractoresArray, $qryDataDistractores['nombre']);
    
        }

        /*
            Se itera sobre el arreglo de distractores y dentro se itera sobre el arreglo de respuestas.

            Si el distractor es igual a la respuesta se suma 1.

            Se obtiene el porcentaje al final de laiteracion sobre las respuestas
        */

        $ArrayDiscriminado1= array();
        $ArrayDiscriminado2= array();
        $ArrayDiscriminado3= array();
        $arrayNumerosLimpios = array();

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
                array_push($arrayNumerosLimpios, $numeroLimpio);
                array_push($ArrayDiscriminado3, "C");
            }
        }
        
        $ArrayDiscriminado = array($ArrayDiscriminado1,$ArrayDiscriminado2,$ArrayDiscriminado3);

        /*  
            Se define el ancho de las celdas según la cantidad de distractores por caso clinico
        */

        $tamanoCeldaArray = array();

        for ($i=0; $i < count($ArrayDiscriminado[0]); $i++) { 

            $tamanoCeldaArray[] = (260 / count($ArrayDiscriminado[0]));

        }

        /*  
            Se imprimen los datos requeridos
        */
        
        $pdf->SetWidths_dos($tamanoCeldaArray);
        $pdf->SetAligns_dos($ArrayDiscriminado[2]);

        $pdf->SetFont('Arial','B',7);
        $pdf->SetDrawColor(143, 181, 201);
        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(260,5, "Caso clínico " . $num_caso_clinico . " - " . $cod_caso_clinico,1,1,'C',True);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetFont('Arial','',7);

        $pdf->Row_dos($ArrayDiscriminado[0]);
        // $pdf->Row_dos($ArrayDiscriminado[1]);

        for ($i=0; $i < $qryDataDistractoresCount['cantidadDistractores']; $i++) { 

            // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
            if ($ArrayDiscriminado2[$i] != max($arrayNumerosLimpios)) {

                $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
                $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                
            } else if ($ArrayDiscriminado2[$i] != ""){ // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                $pdf->SetFont('Arial','B',7);
                $pdf->SetTextColor(16, 155, 0); // Color verde
                $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                $pdf->SetTextColor(0, 0, 0); // Se restablece a color negro
                $pdf->SetFont('Arial','',7);
            }

        }
        
        $pdf->Ln(7);

        $num_caso_clinico++;
    }

    /* ************************************* */
    // Convenciones
    /* ************************************* */

    if(sizeof($pdf->distractoresGenerales) > 0){ // Si hay distractores por poner
        $pdf->Ln(5);
        
        $pdf->SetFont("Arial","B",7.5);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(198, 213, 221);
        $pdf->Cell(260,10,"Convenciones para diagnósticos",'T',1,'L',0);
        
        $pdf->SetFont("Arial","",7.5);
        for($xfr=0;$xfr<sizeof($pdf->distractoresGenerales); $xfr++){
            $pdf->WriteHTML("<span><b>[".($xfr+1)."]</b> " .$pdf->distractoresGenerales[$xfr]. " </span> ");
        }

    }

    
    /* ************************************* */
    // Seccion de calculos de resultados
    /* ************************************* */
    
    // Primer nivel
    // $pdf->Ln(11);
    // $pdf->SetFillColor(255,255,255);
    // $pdf->SetDrawColor(21, 67, 96);


    // $left_valest  = 48;
    // $anchoValEst = 102;
    // $anchoContGrafica = 93;
    // $altoContGrafica = 50;

    // $pdf->SetFont("Arial","B",7);
    // $pdf->SetDrawColor($pdf->azulClaro[0],$pdf->azulClaro[1],$pdf->azulClaro[2]);
    // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
    // $pdf->SetLineWidth($pdf->lineaDelgada);
    // $pdf->SetX($left_valest);
    // $pdf->Cell($anchoValEst,5,"Resultados intralaboratorio - ".$pdf->nombre_programa,1,0,'C',1);
    
    /* ******* */
    // Gráfica
    /* ******* */
    
    // $max_height_break = 0;
    // $pdf->SetFont("Arial","B",6);
    // if(!($diagnosticos_concordantes == 0 && $diagnosticos_noconcordantes == 0)){
    //     $ruta_image = $pdf->generarGraficoCITNG($diagnosticos_concordantes,$diagnosticos_noconcordantes);
    //     $xImage = $anchoValEst + $left_valest;
    //     $yImage = $pdf->GetY();
        
    //     $pdf->Image($ruta_image,$xImage,$yImage-4,$anchoContGrafica,$altoContGrafica);
    //     unlink($ruta_image);

    //     $max_height_break = ($pdf->GetY() + $altoContGrafica);
    // }

    
    // $anchoSeccionP = 30;
    
    /* ************************************* */
    // Valores estadisticos intralaboratorio
    /* ************************************* */
    
    // $pdf->Ln(5);
    // $pdf->SetX($left_valest);
    // $pdf->SetFillColor($pdf->gris[0],$pdf->gris[1],$pdf->gris[2]);
    // $pdf->Cell(50,4,"COD.\nPatólogo",1,0,'C',1);
    // $pdf->Cell(26,4,"Concordantes",1,0,'C',1);
    // $pdf->Cell(26,4,"No Concordantes",1,0,'C',1);

    // $pdf->SetFillColor($pdf->blanco[0],$pdf->blanco[1],$pdf->blanco[2]);
    // $pdf->SetFont("Arial","",6);
    
    // for($count_pat=0; $count_pat<sizeof($usuarios_pat) ; $count_pat++){
    //     $pdf->Ln(4);
    //     $pdf->SetX($left_valest);
    //     $pdf->SetFont("Arial","B",7);

    //     $pdf->Cell(50,4,$usuarios_pat[$count_pat]["cod_usuario"],1,0,'C',1);

    //     $pdf->SetFont("Arial","",6);
    //     $pdf->Cell(26,4,$usuarios_pat[$count_pat]["concordantes"],1,0,'C',1);
    //     $pdf->Cell(26,4,$usuarios_pat[$count_pat]["no_concordantes"],1,0,'C',1);
    // }

    // // Conteo de totales
    // $pdf->SetFillColor($pdf->azulFondoP[0],$pdf->azulFondoP[1],$pdf->azulFondoP[2]);
    // $pdf->Ln(4);
    // $pdf->SetX($left_valest);
    // $pdf->SetFont("Arial","B",7);

    // $pdf->Cell(50,4,"Total",1,0,'C',1);

    // $pdf->SetFont("Arial","",6);
    // $pdf->Cell(26,4,$pdf->contarNumsArray(array_column($usuarios_pat,"concordantes")),1,0,'C',1);
    // $pdf->Cell(26,4,$pdf->contarNumsArray(array_column($usuarios_pat,"no_concordantes")),1,0,'C',1);

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

    $pdf->MultiCell(260,3,"- Final del reporte -\n    Página ". $pdf->PageNo(). " de {nb}\n",0,'C',0);
    $pdf->MultiCell(260,3,"\n\n\n\n\n\n\n\n\n\nAprobado por:\nAída Porras. Magister en Biología. Doctor in management.\nCoordinadora Programas QAP PAT",0,'C',0);
    

    // Cerrar PDF
    $pdf->Close();
    $nomArchivo = utf8_decode("$num_laboratorio - Intralaboratorio CITNG $pdf->nom_reto $nom_laboratorio.pdf");
    $pdf->Output("I",$nomArchivo);

?>