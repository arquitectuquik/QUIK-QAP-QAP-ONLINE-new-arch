<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}


    use \setasign\Fpdi\Fpdi;

    require_once("generalInformePAT.php");
    require_once('fpdi/src/autoload.php');

    $pdf = new generalInformePAT('P','mm','letter'); // Página vertical, tamaño carta, medición en Milímetros
    $pdf->AliasNbPages();
    
    $pdf->laboratorio_pat = $laboratorio_pat; 
    $pdf->fecha_envio = $fecha_envio;
    $pdf->estado_reporte = $estado_reporte;
    $pdf->intento_pat = $intento_pat;

    $qry = "SELECT envio FROM $tbl_reto_laboratorio WHERE laboratorio_id_laboratorio = '$laboratorio_pat' and reto_id_reto = '$reto_pat'";
	$qryData = mysql_fetch_array(mysql_query($qry));
    $envio_pat = $pdf->obtenerNomEnvio($qryData['envio']);
    $pdf->envio_pat = $envio_pat;

    $qryProgramaPat = "SELECT 
                programa_pat.nombre,
                programa_pat.sigla
            FROM 
                programa_pat
            WHERE programa_pat.id_programa = '$programa_pat'
    ";

    $qryArrayProgramaPat = mysql_query($qryProgramaPat);
    mysqlException(mysql_error(),"_01");
    $array_qry_programa_pat = mysql_fetch_array($qryArrayProgramaPat);
    $pdf->tituloprograma = $array_qry_programa_pat["nombre"]; // Programa QAP PAT
    $pdf->siglaprograma = $array_qry_programa_pat["sigla"]; // Programa QAP PAT

    $qryRetoPat = "SELECT 
                reto.nombre
            FROM 
                reto
            WHERE reto.id_reto = '$reto_pat'
    ";

    $qryArrayRetoPat = mysql_query($qryRetoPat);
    mysqlException(mysql_error(),"_01");
    $array_qry_reto_pat = mysql_fetch_array($qryArrayRetoPat);
    $pdf->nombre_reto = $array_qry_reto_pat["nombre"]; // Nombre del reto de patologia

    $pdf->AddPage(); // Portada
    $pdf->SetAutoPageBreak(true,10);
    $pdf->AddPage(); // Contraportada
    $pdf->SetAutoPageBreak(true,10);
    
    // Consulta para obtener los casos clinicos de el reto diligenciado
    $qry = "SELECT id_caso_clinico, codigo, nombre, revision FROM caso_clinico where reto_id_reto = $reto_pat and estado = 1";
    $qryArray = mysql_query($qry);
    mysqlException(mysql_error(),"_01");
    $cont_caso_clinico = 0;

    while($qryData = mysql_fetch_array($qryArray)) {
        
        $cont_caso_clinico++;

        $id_caso_clinico = $qryData["id_caso_clinico"];
        $codigo = $qryData["codigo"];
        $nombre = $qryData["nombre"];
        $revision = $qryData["revision"];

        $pdf->AddPage(); // Una hoja por cada caso clínico
        $pdf->SetAutoPageBreak(true,10);
        $pdf->SetFont('Arial','B',10);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->Bookmark($nombre. " " . $codigo, false);
        $pdf->SetX(8);
        $pdf->MultiCell(200,4,"Evaluación diagnóstica\n" . $nombre. "\n" . $codigo,0,'C',0);

        $pdf->SetDrawColor(80,80,80);
        $pdf->SetLineWidth(0.2);

        switch($cont_caso_clinico){
            case 1: // Receptores de estrógenos
                // Generar la tabla de diagnostico
                $pdf->SetFont('Arial','B',8);
                $pdf->SetLineWidth(0.1);
                $pdf->SetFillColor(255,255,255);
                $pdf->Ln(10);
                $pdf->SetX(41);
                $pdf->Cell(35,9,"Muestra",1,0,'C',1);
                $pdf->Cell(100,4,"Interpretación","TLR",0,'C',1);
                
                $pdf->SetFont("Arial", "B", 7);
                $pdf->Ln();
                $pdf->SetX(76);
                $pdf->Cell(33.33,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(33.33,5,"Respuesta referenciada","B",0,'C',1);
                $pdf->Cell(33.33,5,"Valoración","BR",0,'C',1);
                
                $qryPregunta = "SELECT distinct
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico";
                $marcadores = array();
                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                $pdf->SetFont("Arial","",7);

                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $muestra = $qryDataPregunta["nombre"];

                    // Traer la pregunta de dicha muestra
                    $qryPreguntaEspecifica = "SELECT
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '".$muestra."'";

                    $qryArrayPreguntaEspecifica = mysql_query($qryPreguntaEspecifica);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPreguntaEspecifica = mysql_fetch_array($qryArrayPreguntaEspecifica)) {
                        $id_pregunta = $qryDataPreguntaEspecifica["id_pregunta"];
                        $nombre = $qryDataPreguntaEspecifica["nombre"];

                        // Posibles respuestas para discha muestra
                        $qryDistractor = "SELECT 
                                id_distractor,
                                nombre
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0 limit 1";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $categoriaRtaCorrecta = "Indefinido";
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($qryDataDistractor["nombre"] == "Sin tinción" || $qryDataDistractor["nombre"] == "&lt; 1%"){ // Si es negativo
                                $categoriaRtaCorrecta = "Negativo";
                            } else if($qryDataDistractor["nombre"] == "1% - 10%" || $qryDataDistractor["nombre"] == "11% - 50%" || $qryDataDistractor["nombre"] == "&gt; 50%"){ // Es positivo
                                $categoriaRtaCorrecta = "Positivo";
                            } else { // No identificado
                                $categoriaRtaCorrecta = "Indefinido";
                            }
                        }

                        // Respuesta dada para dicha muestra por el patologo
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                distractor.nombre
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        $categoriaRtaPatologo = "Indefinido";
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            if($qryDataDistractorIntento["nombre"] == "Sin tinción" || $qryDataDistractorIntento["nombre"] == "&lt; 1%"){ // Si es negativo
                                $categoriaRtaPatologo = "Negativo";
                            } else if($qryDataDistractorIntento["nombre"] == "1% - 10%" || $qryDataDistractorIntento["nombre"] == "11% - 50%" || $qryDataDistractorIntento["nombre"] == "&gt; 50%"){ // Es positivo
                                $categoriaRtaPatologo = "Positivo";
                            } else { // No identificado
                                $categoriaRtaPatologo = "Indefinido";
                            }
                        }

                        // Impresion de resultados
                        $pdf->SetFont("Arial", "", 7);
                        $pdf->Ln();
                        $pdf->SetX(41);
                        $pdf->Cell(35,4,$muestra,1,0,'C',1);
                        $pdf->Cell(33.33,4,$categoriaRtaPatologo,1,0,'C',1);
                        $pdf->Cell(33.33,4,$categoriaRtaCorrecta,1,0,'C',1);

                        if($categoriaRtaPatologo == $categoriaRtaCorrecta){
                            $pdf->SetFillColor(124, 221, 5);
                            $pdf->Cell(33.33,4,"Concordante",1,0,'C',1);
                        } else {
                            $pdf->SetFillColor(236, 112, 99);
                            $pdf->Cell(33.33,4,"No concordante",1,0,'C',1);
                        }
                        $pdf->SetFillColor(255,255,255);
                    }
                }


                $pdf->Ln(10);
                $pdf->SetX(18);
                $pdf->SetFont("Arial", "B", 7);
                $pdf->Cell(35,10,"Muestra",1,0,'C',1);
                $pdf->Cell(47.5,5,"% de carcinoma con tinción nuclear","TLR",0,'C',1);
                $pdf->Cell(47.5,5,"Intensidad de la tinción","TLR",0,'C',1);
                $pdf->Cell(47.5,5,"Otros","TLR",1,'C',1);
                $pdf->SetX(53);
                $pdf->Cell(23.75,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","BR",0,'C',1);
                $pdf->Cell(23.75,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","BR",0,'C',1);
                $pdf->Cell(23.75,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","BR",0,'C',1);
                // Traer las posbibles muestras para todas las secciones de interpretacion
                $qryPregunta = "SELECT distinct
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico";
                $muestras = array();
                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $muestras[] = $qryDataPregunta["nombre"];
                }
        
                $pdf->Ln();
                $pdf->SetFont("Arial","",7);
        
                for($dsb=0;$dsb<sizeof($muestras);$dsb++){
        
                    $pdf->SetWidths(
                        array(
                            35,
                            23.75,
                            23.75,
                            23.75,
                            23.75,
                            23.75,
                            23.75
                        ));
                    $pdf->SetAligns(
                        array(
                            "C",
                            "C",
                            "C",
                            "C",
                            "C",
                            "C",
                            "C"
                            )
                        );
                    $muestraAct = $muestras[$dsb];
        
                    $distractorPCTN = "";
                    $distractorIT = "";
                    $distractorO = "";
                    $respuestasCorrectasPCTN = "";
                    $respuestasCorrectasIT = "";
                    $respuestasCorrectasO = "";
                    
                    // El marcador exacto para el % de carcinoma con tinción nuclear
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas % de carcinoma con tinción nuclear
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasPT = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasPT = $respuestasCorrectasPT . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasPT = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorPT = $qryDataDistractorIntento["nombre"];
                        }
                    }
                    // El marcador exacto para la intensidad de tinción
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas intensidad tinción
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasIT = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasIT = $respuestasCorrectasIT . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasIT = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorIT = $qryDataDistractorIntento["nombre"];
                        }
                    }
                    // El marcador exacto para Otros
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas Patrón de tinción
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasCP = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasCP = $respuestasCorrectasCP . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasCP = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorCP = $qryDataDistractorIntento["nombre"];
                        }
                    }
        
                    // Imprimir todos los valores para el marcador especificado
                    $pdf->SetX(18);
                    $pdf->Row(array(
                        $muestraAct,
                        $distractorPT,
                        $respuestasCorrectasPT,
                        $distractorIT,
                        $respuestasCorrectasIT,
                        $distractorCP,
                        $respuestasCorrectasCP
                    ));        
                }

                // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
                $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                        
                                FROM grupo 
                                JOIN pregunta
                                ON grupo.id_grupo = pregunta.grupo_id_grupo
                            
                                WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";

                $qryArrayPregunta = mysql_query($qryPregunta);

                // Titulo del primer panel del consenso de valoraciones
                $pdf->Ln();
                $pdf->SetFont('Arial','B',10);
                $pdf->SetX(28);
                $pdf->Cell(160,5,"% de carcinoma con tinción nuclear",'',1,"C");

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
                                    
                                        WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";


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
                                    
                                        WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";

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

                $ArrayDiscriminado = array($ArrayDiscriminado1,$ArrayDiscriminado2,$ArrayDiscriminado3,$ArrayDiscriminado4);

                    // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
                    $tamanoCeldaArray = array();
                    for ($i=0; $i < count($ArrayDiscriminado[0]); $i++) { 
                        $tamanoCeldaArray[] = (160 / count($ArrayDiscriminado[0]));
                    }

                    // Se imprimen los datos requeridos
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Ln(5.5);
                    $pdf->SetX(28);
                    $pdf->Cell(160,10,'Consenso de valoraciones - Muestra '. $nombre_pregunta,'LTR',1,'C');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetWidths_dos($tamanoCeldaArray);
                    $pdf->SetAligns_dos($ArrayDiscriminado[2]);
                    $pdf->SetX(28);
                    $pdf->Row_dos($ArrayDiscriminado[0]);
                    $pdf->SetX(28);

                    for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                        // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                        if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {
                            
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            
                        } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                            $pdf->SetFillColor(124, 221, 5); // Color verde
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            $pdf->SetFillColor(255, 255, 255); // Se restablece a color blanco

                        }

                    }

                }

                /*******************************************************************************************************************************/
                /*******************************************************************************************************************************/
                /*******************************************************************************************************************************/

                // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
                $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                        
                                FROM grupo 
                                JOIN pregunta
                                ON grupo.id_grupo = pregunta.grupo_id_grupo
                            
                                WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción'";

                $qryArrayPregunta = mysql_query($qryPregunta);

                // Titulo del segundo panel del consenso de valoraciones
                $pdf->Line(15,167,200,167);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetFont('Arial','B',10);
                $pdf->SetX(28);
                $pdf->Cell(160,5,"Intensidad de la tinción",'',1,"C");

                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {

                    $id_pregunta = $qryDataPregunta["id_pregunta"];
                    $nombre_pregunta = $qryDataPregunta["nombre"];

                    $pdf->SetFont('Arial','B',8);
                    $pdf->Ln(5.5);
                    $pdf->SetX(28);
                    $pdf->Cell(160,10,'Consenso de valoraciones - Muestra '.$nombre_pregunta,'LTR',1,'C');

                    // Consulta SQL para obtener el numero de distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
                    $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores

                                        FROM distractor 
                                    
                                        INNER JOIN pregunta 
                                        ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                        INNER JOIN grupo 
                                        ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                        INNER JOIN caso_clinico 
                                        ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                                    
                                        WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = 'Intensidad de la tinción' and pregunta.nombre = '$nombre_pregunta'";


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
                                    
                                        WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = 'Intensidad de la tinción' and pregunta.nombre = '$nombre_pregunta'";

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

                    $ArrayDiscriminado = array($ArrayDiscriminado1,$ArrayDiscriminado2,$ArrayDiscriminado3,$ArrayDiscriminado4);

                    // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
                    $tamanoCeldaArray = array();
                    for ($i=0; $i < count($ArrayDiscriminado[0]); $i++) { 
                        $tamanoCeldaArray[] = (160 / count($ArrayDiscriminado[0]));
                    }

                    // Se imprimen los datos requeridos
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetWidths_dos($tamanoCeldaArray);
                    $pdf->SetAligns_dos($ArrayDiscriminado[2]);
                    $pdf->SetX(28);
                    $pdf->Row_dos($ArrayDiscriminado[0]);
                    $pdf->SetX(28);

                    for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                        // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                        if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {
                            
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            
                        } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                            $pdf->SetFillColor(124, 221, 5); // Color verde
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            $pdf->SetFillColor(255, 255, 255); // Se restablece a color blanco

                        }

                    }

                }

            break;
            case 2: // Receptores de progestágenos
                // Generar la tabla de diagnostico
                $pdf->SetFont('Arial','B',8);
                $pdf->SetLineWidth(0.1);
                $pdf->SetFillColor(255,255,255);
                // $pdf->Ln(6);
                $pdf->SetX(41);
                $pdf->Cell(35,9,"Muestra",1,0,'C',1);
                $pdf->Cell(100,4,"Interpretación","TLR",0,'C',1);

                $pdf->SetFont("Arial", "B", 7);
                $pdf->Ln();
                $pdf->SetX(76);
                $pdf->Cell(33.33,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(33.33,5,"Respuesta referenciada","B",0,'C',1);
                $pdf->Cell(33.33,5,"Valoración","BR",0,'C',1);

                $qryPregunta = "SELECT distinct
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico";
                $marcadores = array();
                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                $pdf->SetFont("Arial","",7);

                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $muestra = $qryDataPregunta["nombre"];

                    // Traer la pregunta de dicha muestra
                    $qryPreguntaEspecifica = "SELECT
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '".$muestra."'";

                    $qryArrayPreguntaEspecifica = mysql_query($qryPreguntaEspecifica);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPreguntaEspecifica = mysql_fetch_array($qryArrayPreguntaEspecifica)) {
                        $id_pregunta = $qryDataPreguntaEspecifica["id_pregunta"];
                        $nombre = $qryDataPreguntaEspecifica["nombre"];

                        // Posibles respuestas para discha muestra
                        $qryDistractor = "SELECT 
                                id_distractor,
                                nombre
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0 limit 1";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $categoriaRtaCorrecta = "Indefinido";
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($qryDataDistractor["nombre"] == "Sin tinción" || $qryDataDistractor["nombre"] == "&lt; 1%"){ // Si es negativo
                                $categoriaRtaCorrecta = "Negativo";
                            } else if($qryDataDistractor["nombre"] == "1% - 10%" || $qryDataDistractor["nombre"] == "11% - 50%" || $qryDataDistractor["nombre"] == "&gt; 50%"){ // Es positivo
                                $categoriaRtaCorrecta = "Positivo";
                            } else { // No identificado
                                $categoriaRtaCorrecta = "Indefinido";
                            }
                        }

                        // Respuesta dada para dicha muestra por el patologo
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                distractor.nombre
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        $categoriaRtaPatologo = "Indefinido";
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            if($qryDataDistractorIntento["nombre"] == "Sin tinción" || $qryDataDistractorIntento["nombre"] == "&lt; 1%"){ // Si es negativo
                                $categoriaRtaPatologo = "Negativo";
                            } else if($qryDataDistractorIntento["nombre"] == "1% - 10%" || $qryDataDistractorIntento["nombre"] == "11% - 50%" || $qryDataDistractorIntento["nombre"] == "&gt; 50%"){ // Es positivo
                                $categoriaRtaPatologo = "Positivo";
                            } else { // No identificado
                                $categoriaRtaPatologo = "Indefinido";
                            }
                        }

                        // Impresion de resultados
                        $pdf->SetFont("Arial", "", 7);
                        $pdf->Ln();
                        $pdf->SetX(41);
                        $pdf->Cell(35,4,$muestra,1,0,'C',1);
                        $pdf->Cell(33.33,4,$categoriaRtaPatologo,1,0,'C',1);
                        $pdf->Cell(33.33,4,$categoriaRtaCorrecta,1,0,'C',1);

                        if($categoriaRtaPatologo == $categoriaRtaCorrecta){
                            $pdf->SetFillColor(124, 221, 5);
                            $pdf->Cell(33.33,4,"Concordante",1,0,'C',1);
                        } else {
                            $pdf->SetFillColor(236, 112, 99);
                            $pdf->Cell(33.33,4,"No concordante",1,0,'C',1);
                        }
                        $pdf->SetFillColor(255,255,255);
                    }
                }


                $pdf->Ln(10);
                $pdf->SetX(18);
                $pdf->SetFont("Arial", "B", 7);
                $pdf->Cell(35,10,"Muestra",1,0,'C',1);
                $pdf->Cell(47.5,5,"% de carcinoma con tinción nuclear","TLR",0,'C',1);
                $pdf->Cell(47.5,5,"Intensidad de la tinción","TLR",0,'C',1);
                $pdf->Cell(47.5,5,"Otros","TLR",1,'C',1);
                $pdf->SetX(53);
                $pdf->Cell(23.75,5,"Su respuesta","BL",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","RB",0,'C',1);
                $pdf->Cell(23.75,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","RB",0,'C',1);
                $pdf->Cell(23.75,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","RB",0,'C',1);
                // Traer las posbibles muestras para todas las secciones de interpretacion
                $qryPregunta = "SELECT distinct
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico";
                $muestras = array();
                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $muestras[] = $qryDataPregunta["nombre"];
                }

                $pdf->Ln();
                $pdf->SetFont("Arial","",7);

                for($dsb=0;$dsb<sizeof($muestras);$dsb++){

                    $pdf->SetWidths(
                        array(
                            35,
                            23.75,
                            23.75,
                            23.75,
                            23.75,
                            23.75,
                            23.75
                        ));
                    $pdf->SetAligns(
                        array(
                            "C",
                            "C",
                            "C",
                            "C",
                            "C",
                            "C",
                            "C"
                            )
                        );
                    $muestraAct = $muestras[$dsb];

                    $distractorPCTN = "";
                    $distractorIT = "";
                    $distractorO = "";
                    $respuestasCorrectasPCTN = "";
                    $respuestasCorrectasIT = "";
                    $respuestasCorrectasO = "";
                    
                    // El marcador exacto para el % de carcinoma con tinción nuclear
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas % de carcinoma con tinción nuclear
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasPT = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasPT = $respuestasCorrectasPT . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasPT = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorPT = $qryDataDistractorIntento["nombre"];
                        }
                    }
                    // El marcador exacto para la intensidad de tinción
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas intensidad tinción
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasIT = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasIT = $respuestasCorrectasIT . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasIT = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorIT = $qryDataDistractorIntento["nombre"];
                        }
                    }
                    // El marcador exacto para Otros
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas Patrón de tinción
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasCP = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasCP = $respuestasCorrectasCP . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasCP = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorCP = $qryDataDistractorIntento["nombre"];
                        }
                    }

                    // Imprimir todos los valores para el marcador especificado
                    $pdf->SetX(18);
                    $pdf->Row(array(
                        $muestraAct,
                        $distractorPT,
                        $respuestasCorrectasPT,
                        $distractorIT,
                        $respuestasCorrectasIT,
                        $distractorCP,
                        $respuestasCorrectasCP
                    ));        
                }

                /*
                    ***NUEVO***
                */

                // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
                $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                        
                                FROM grupo 
                                JOIN pregunta
                                ON grupo.id_grupo = pregunta.grupo_id_grupo
                            
                                WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";

                $qryArrayPregunta = mysql_query($qryPregunta);

                // Titulo del primer panel del consenso de valoraciones
                $pdf->Ln();
                $pdf->SetFont('Arial','B',10);
                $pdf->SetX(28);
                $pdf->Cell(160,5,"% de carcinoma con tinción nuclear",'',1,"C");

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
                                        
                                             WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";

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
                                    
                                        WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = '% de carcinoma con tinción nuclear' and pregunta.nombre = '$nombre_pregunta'";

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

                    $ArrayDiscriminado = array($ArrayDiscriminado1,$ArrayDiscriminado2,$ArrayDiscriminado3,$ArrayDiscriminado4);

                    // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
                    $tamanoCeldaArray = array();
                    for ($i=0; $i < count($ArrayDiscriminado[0]); $i++) { 
                        $tamanoCeldaArray[] = (160 / count($ArrayDiscriminado[0]));
                    }

                    // Se imprimen los datos requeridos
                    $pdf->SetFont('Arial','B',8);
                    $pdf->Ln(5.5);
                    $pdf->SetX(28);
                    $pdf->Cell(160,10,'Consenso de valoraciones - Muestra '. $nombre_pregunta,'LTR',1,'C');

                    $pdf->SetFont('Arial','',8);
                    $pdf->SetWidths_dos($tamanoCeldaArray);
                    $pdf->SetAligns_dos($ArrayDiscriminado[2]);
                    $pdf->SetX(28);
                    $pdf->Row_dos($ArrayDiscriminado[0]);
                    $pdf->SetX(28);

                    for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                        // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                        if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {
                            
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            
                        } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                            $pdf->SetFillColor(124, 221, 5); // Color verde
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            $pdf->SetFillColor(255, 255, 255); // Se restablece a color blanco

                        }

                    }

                }

                /*******************************************************************************************************************************/
                /*******************************************************************************************************************************/
                /*******************************************************************************************************************************/

                // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
                $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                
                        FROM grupo 
                        JOIN pregunta
                        ON grupo.id_grupo = pregunta.grupo_id_grupo
                    
                        WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción'";

                $qryArrayPregunta = mysql_query($qryPregunta);

                // Titulo del segundo panel del consenso de valoraciones
                $pdf->Line(15,167,200,167);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetFont('Arial','B',10);
                $pdf->SetX(28);
                $pdf->Cell(160,5,"Intensidad de la tinción",'',1,"C");

                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {

                    $id_pregunta = $qryDataPregunta["id_pregunta"];
                    $nombre_pregunta = $qryDataPregunta["nombre"];

                    $pdf->SetFont('Arial','B',8);
                    $pdf->Ln(5.5);
                    $pdf->SetX(28);
                    $pdf->Cell(160,10,'Consenso de valoraciones - Muestra '.$nombre_pregunta,'LTR',1,'C');

                    // Consulta SQL para obtener el numero de distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
                    $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores

                                            FROM distractor 
                                        
                                            INNER JOIN pregunta 
                                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                            INNER JOIN grupo 
                                            ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                            INNER JOIN caso_clinico 
                                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                
                    WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = 'Intensidad de la tinción' and pregunta.nombre = '$nombre_pregunta'";

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
                                
                                        WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = 'Intensidad de la tinción' and pregunta.nombre = '$nombre_pregunta'";

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

                    $ArrayDiscriminado = array($ArrayDiscriminado1,$ArrayDiscriminado2,$ArrayDiscriminado3,$ArrayDiscriminado4);

                    // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
                    $tamanoCeldaArray = array();
                    for ($i=0; $i < count($ArrayDiscriminado[0]); $i++) { 
                    $tamanoCeldaArray[] = (160 / count($ArrayDiscriminado[0]));
                    }

                    // Se imprimen los datos requeridos
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetWidths_dos($tamanoCeldaArray);
                    $pdf->SetAligns_dos($ArrayDiscriminado[2]);
                    $pdf->SetX(28);
                    $pdf->Row_dos($ArrayDiscriminado[0]);
                    $pdf->SetX(28);

                    for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                        // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                        if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {
                            
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            
                        } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                            $pdf->SetFillColor(124, 221, 5); // Color verde
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            $pdf->SetFillColor(255, 255, 255); // Se restablece a color blanco

                        }

                    }

                }
                /*
                    ***FIN NUEVO***
                */
            break;
            case 3: // HER2
                // Generar la tabla de diagnostico
                $pdf->SetFont('Arial','B',8);
                $pdf->SetLineWidth(0.1);
                $pdf->SetFillColor(255,255,255);
                $pdf->Ln(10);
                $pdf->SetX(41);
                $pdf->Cell(35,9,"Muestra","TLR",0,'C',1);
                $pdf->Cell(100,4,"Interpretación","TLR",0,'C',1);

                $pdf->SetFont("Arial", "B", 7);
                $pdf->Ln();
                $pdf->SetX(76);
                $pdf->Cell(33.33,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(33.33,5,"Respuesta referenciada","B",0,'C',1);
                $pdf->Cell(33.33,5,"Valoración","BR",0,'C',1);

                $qryPregunta = "SELECT distinct
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico";
                $marcadores = array();
                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                $pdf->SetFont("Arial","",7);

                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $muestra = $qryDataPregunta["nombre"];

                    // Traer la pregunta de dicha muestra
                    $qryPreguntaEspecifica = "SELECT
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Grado' and pregunta.nombre = '".$muestra."'";

                    $qryArrayPreguntaEspecifica = mysql_query($qryPreguntaEspecifica);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPreguntaEspecifica = mysql_fetch_array($qryArrayPreguntaEspecifica)) {
                        $id_pregunta = $qryDataPreguntaEspecifica["id_pregunta"];
                        $nombre = $qryDataPreguntaEspecifica["nombre"];

                        // Posibles respuestas para discha muestra
                        $qryDistractor = "SELECT 
                                id_distractor,
                                nombre
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0 limit 1";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $categoriaRtaCorrecta = "Indefinido";
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($qryDataDistractor["nombre"] == "Grado 0"){ // Si es negativo
                                $categoriaRtaCorrecta = "Negativo";
                            } else if($qryDataDistractor["nombre"] == "Grado 1+" || $qryDataDistractor["nombre"] == "Grado 2+" || $qryDataDistractor["nombre"] == "Grado 3+"){ // Es positivo
                                $categoriaRtaCorrecta = "Positivo";
                            } else { // No identificado
                                $categoriaRtaCorrecta = "Indefinido";
                            }
                        }

                        // Respuesta dada para dicha muestra por el patologo
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                distractor.nombre
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        $categoriaRtaPatologo = "Indefinido";
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            if($qryDataDistractorIntento["nombre"] == "Grado 0"){ // Si es negativo
                                $categoriaRtaPatologo = "Negativo";
                            } else if($qryDataDistractorIntento["nombre"] == "Grado 1+" || $qryDataDistractorIntento["nombre"] == "Grado 2+" || $qryDataDistractorIntento["nombre"] == "Grado 3+"){ // Es positivo
                                $categoriaRtaPatologo = "Positivo";
                            } else { // No identificado
                                $categoriaRtaPatologo = "Indefinido";
                            }
                        }

                        // Impresion de resultados
                        $pdf->SetFont("Arial", "", 7);
                        $pdf->Ln();
                        $pdf->SetX(41);
                        $pdf->Cell(35,4,$muestra,1,0,'C',1);
                        $pdf->Cell(33.33,4,$categoriaRtaPatologo,1,0,'C',1);
                        $pdf->Cell(33.33,4,$categoriaRtaCorrecta,1,0,'C',1);

                        if($categoriaRtaPatologo == $categoriaRtaCorrecta){
                            $pdf->SetFillColor(124, 221, 5);
                            $pdf->Cell(33.33,4,"Concordante",1,0,'C',1);
                        } else {
                            $pdf->SetFillColor(236, 112, 99);
                            $pdf->Cell(33.33,4,"No concordante",1,0,'C',1);
                        }
                        $pdf->SetFillColor(255,255,255);
                    }
                }


                $pdf->Ln(10);
                $pdf->SetX(44);
                $pdf->SetFont("Arial", "B", 7);
                $pdf->Cell(35,10,"Muestra",1,0,'C',1);
                $pdf->Cell(47.5,5,"Grado","LTR",0,'C',1);
                $pdf->Cell(47.5,5,"Otros","LTR",1,'C',1);
                $pdf->SetX(79);
                $pdf->Cell(23.75,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","BR",0,'C',1);
                $pdf->Cell(23.75,5,"Su respuesta","LB",0,'C',1);
                $pdf->Cell(23.75,5,"Rta. referenciada","RB",0,'C',1);
                // Traer las posbibles muestras para todas las secciones de interpretacion
                $qryPregunta = "SELECT distinct
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico";
                $muestras = array();
                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $muestras[] = $qryDataPregunta["nombre"];
                }

                $pdf->Ln();
                $pdf->SetFont("Arial","",7);

                for($dsb=0;$dsb<sizeof($muestras);$dsb++){

                    $pdf->SetWidths(
                        array(
                            35,
                            23.75,
                            23.75,
                            23.75,
                            23.75,
                            23.75,
                            23.75
                        ));
                    $pdf->SetAligns(
                        array(
                            "C",
                            "C",
                            "C",
                            "C",
                            "C",
                            "C",
                            "C"
                            )
                        );
                    $muestraAct = $muestras[$dsb];

                    $distractorPCTN = "";
                    $distractorIT = "";
                    $distractorO = "";
                    $respuestasCorrectasPCTN = "";
                    $respuestasCorrectasIT = "";
                    $respuestasCorrectasO = "";
                    
                    // El marcador exacto para el Grado
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Grado' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas Grado
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasPT = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasPT = $respuestasCorrectasPT . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasPT = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorPT = $qryDataDistractorIntento["nombre"];
                        }
                    }
                    
                    // El marcador exacto para Otros
                    $qryPregunta = "SELECT distinct
                        pregunta.id_pregunta,
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros' and pregunta.nombre = '".$muestraAct."'";
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $id_pregunta = $qryDataPregunta["id_pregunta"];
                        $nombre_pregunta = $qryDataPregunta["nombre"];
                        
                        // Obtener las respuestas correctas Patrón de tinción
                        $qryDistractor = "SELECT 
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor
                            where pregunta_id_pregunta = $id_pregunta and valor > 0";
                        $qryArrayDistractor = mysql_query($qryDistractor);
                        mysqlException(mysql_error(),"_03");
                        $respuestasCorrectasCP = "";
                        $counter=1;
                        while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                            if($counter>1){
                                $respuestasCorrectasCP = $respuestasCorrectasCP . "\n". $qryDataDistractor["nombre"];
                            } else {
                                $respuestasCorrectasCP = $qryDataDistractor["nombre"];
                            }
                            $counter++;
                        }
                        // Distractor respondido por el laboratorio
                        $qryDistractorIntento = "SELECT 
                                distractor.id_distractor,
                                replace(replace(distractor.nombre,'&lt;','<'),'&gt;','>') as 'nombre'
                            from distractor join respuesta_lab on distractor.id_distractor = respuesta_lab.distractor_id_distractor
                            where respuesta_lab.pregunta_id_pregunta = '$id_pregunta' and intento_id_intento = $intento_pat limit 1";
                        $qryArrayDistractorIntento = mysql_query($qryDistractorIntento);
                        mysqlException(mysql_error(),"_04");
                        while($qryDataDistractorIntento = mysql_fetch_array($qryArrayDistractorIntento)) {
                            $distractorCP = $qryDataDistractorIntento["nombre"];
                        }
                    }

                    // Imprimir todos los valores para el marcador especificado
                    $pdf->SetX(44);
                    $pdf->Row(array(
                        $muestraAct,
                        $distractorPT,
                        $respuestasCorrectasPT,
                        $distractorCP,
                        $respuestasCorrectasCP
                    ));        
                }

                /*
                    ***NUEVO***
                */

                // Consulta SQL para obtener las pregunta (Muestras) del caso clinico
                $qryPregunta = "SELECT pregunta.id_pregunta, pregunta.nombre
                                                
                                FROM grupo 
                                JOIN pregunta
                                ON grupo.id_grupo = pregunta.grupo_id_grupo

                                WHERE grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Grado'";

                $qryArrayPregunta = mysql_query($qryPregunta);

                // Titulo del primer panel del consenso de valoraciones
                $pdf->Ln();
                $pdf->SetFont('Arial','B',10);
                $pdf->SetX(28);
                $pdf->Cell(160,5,"Grado",'',1,"C");

                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {

                    $id_pregunta = $qryDataPregunta["id_pregunta"];
                    $nombre_pregunta = $qryDataPregunta["nombre"];

                    $pdf->SetFont('Arial','B',8);
                    $pdf->Ln(5.5);
                    $pdf->SetX(28);
                    $pdf->Cell(160,10,'Consenso de valoraciones - Muestra '. $nombre_pregunta,'LTR',1,'C');

                    // Consulta SQL para obtener el numero de distractores de la pregunta (Muestra) que se esta evaluando dentro del reto especifico
                    $qryDistractoresCount = "SELECT COUNT(distractor.nombre) as cantidadDistractores

                                            FROM distractor 
                                        
                                            INNER JOIN pregunta 
                                            ON distractor.pregunta_id_pregunta = pregunta.id_pregunta 
                                            INNER JOIN grupo 
                                            ON pregunta.grupo_id_grupo = grupo.id_grupo 
                                            INNER JOIN caso_clinico 
                                            ON grupo.caso_clinico_id_caso_clinico = caso_clinico.id_caso_clinico 
                                        
                                            WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = 'Grado' and pregunta.nombre = '$nombre_pregunta'";


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
                                    
                                        WHERE caso_clinico.reto_id_reto = $reto_pat and caso_clinico.codigo = '$codigo' and grupo.nombre = 'Grado' and pregunta.nombre = '$nombre_pregunta'";

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

                    $ArrayDiscriminado = array($ArrayDiscriminado1,$ArrayDiscriminado2,$ArrayDiscriminado3,$ArrayDiscriminado4);

                    // Se define el ancho de las celdas según la cantidad de distractores por caso clinico de manera dinamica
                    $tamanoCeldaArray = array();
                    for ($i=0; $i < count($ArrayDiscriminado[0]); $i++) { 
                        $tamanoCeldaArray[] = (160 / count($ArrayDiscriminado[0]));
                    }

                    // Se imprimen los datos requeridos
                    $pdf->SetFont('Arial','',8);
                    $pdf->SetWidths_dos($tamanoCeldaArray);
                    $pdf->SetAligns_dos($ArrayDiscriminado[2]);
                    $pdf->SetX(28);
                    $pdf->Row_dos($ArrayDiscriminado[0]);
                    $pdf->SetX(28);

                    for ($i=0; $i < sizeof($ArrayDiscriminado1); $i++) { 

                        // Si el valor que se está evaluando es diferente al elemento mas alto del array, lo imprime normal
                        if ($ArrayDiscriminado2[$i] != max($ArrayDiscriminado4)) {

                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);

                        } else { // De lo contrario lo imprime de color verde (Sombrea de verde el elemento mayor)

                            $pdf->SetFillColor(124, 221, 5); // Color verde
                            $pdf->Cell($tamanoCeldaArray[$i],5,$ArrayDiscriminado2[$i],1,0,'C',1);
                            $pdf->SetFillColor(255, 255, 255); // Se restablece a color blanco

                        }

                    }

                }

                /*
                    ***FIN NUEVO***
                */

            break;
        }
 
    }

    if($see_observaciones == 1){ // Si esta habilitada la opcion de mostrar observaciones del cliente
        $qryObs = "SELECT * FROM intento where id_intento = $intento_pat";
        $qryArrayObs = mysql_query($qryObs);
        mysqlException(mysql_error(),"_01");
        $comentario = "";
        while($qryDataObs = mysql_fetch_array($qryArrayObs)) {
            $comentario = $qryDataObs["comentario"];
        }

        $pdf->Ln(14);
        $pdf->SetX(18);
        $pdf->SetFont('Arial','B',10);
        $pdf->MultiCell(178,4,"Comentarios del intento",0,'L',0);

        if($comentario != ""){ // Si hay observaciones del cliente
            $pdf->Ln(2);
            $pdf->SetX(18);
            $pdf->SetFont('Arial','',9);
            $pdf->MultiCell(178,4,$comentario,0,'J',0);
        } else { // No hay observaciones por mostrar
            $pdf->Ln(2);
            $pdf->SetX(18);
            $pdf->SetFont('Arial','',9);
            $pdf->MultiCell(178,4,"No hay observaciones para este intento.",0,'J',0);
        }
    
    }

    $pdf->Ln(8);
    $pdf->SetX(18);
    $pdf->SetFont('Arial','B',9);

    if($pdf->getY() > 215){
        $pdf->addPage(); // Ya que no cabe, agreguelo a una nueva hoja todo
        $pdf->SetAutoPageBreak(true,10);
    }

    $pdf->SetX(10);
    $pdf->MultiCell(196,4,"- Final del reporte -\n   Página ". ($pdf->PageNo() + 1). " de {nb}\n",0,'C',0);
    $pdf->MultiCell(196,4,"\n\n\n\n\n\n\n\nAprobado por:\nAída Porras. Magister en Biología. Doctor in management.\nCoordinadora Programas QAP PAT",0,'C',0);

    $pdf->CreateIndex();
    
    // Cerrar PDF
    $pdf->Close();

    $nomArchivo = "temp-pdf/".uniqid().".pdf";
    $pdf->Output("F",$nomArchivo,true);

    $pdf = new Fpdi('P','mm','letter');
    $pdf->AliasNbPages();
    $pageCount = $pdf->setSourceFile($nomArchivo);
    for($pageNumber=1; $pageNumber<$pageCount; $pageNumber++){
        
        if($pageNumber == 3){
            $templateID = $pdf->importPage($pageCount);
            $pdf->getTemplateSize($templateID);
            $pdf->addPage();
            $pdf->SetAutoPageBreak(true,10);
            $pdf->useTemplate($templateID);

            // Contador de paginas
            $pdf->SetXY(102,10);
            $pdf->SetFont('Arial','',7);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200,4,$pdf->PageNo() . " de {nb}",0,0,'C',0);
        }

        $templateID = $pdf->importPage($pageNumber);
        $pdf->getTemplateSize($templateID);
        $pdf->addPage();
        $pdf->SetAutoPageBreak(true,10);
        $pdf->useTemplate($templateID);
        
        if($pageNumber > 1){
            // Contador de paginas
            $pdf->SetXY(102,10);
            $pdf->SetFont('Arial','',7);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200,4,$pdf->PageNo() . " de {nb}",0,0,'C',0);
        }
    }

    // Consulta para obtener el nombre de usuario
    $qrySFR = "SELECT cod_usuario FROM intento join usuario on usuario.id_usuario = intento.usuario_id_usuario WHERE intento.id_intento = $intento_pat limit 1";
    $qryArraySRF = mysql_query($qrySFR);
    global $cod_usuario_srf;
    mysqlException(mysql_error(),"_01");
    while ($qryDataSRF = mysql_fetch_array($qryArraySRF)) {
        $cod_usuario_srf = $qryDataSRF["cod_usuario"];
    }

    $pdf->Output("I","$cod_usuario_srf.pdf");
    unlink($nomArchivo);

?>