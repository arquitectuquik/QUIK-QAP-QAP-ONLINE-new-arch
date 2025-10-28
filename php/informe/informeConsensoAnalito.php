<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}




session_start();

/*

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

*/

include_once "../verifica_sesion.php";

include_once "../complementos/grubbs.php";

include_once "../complementos/dixon.php";

include_once "../complementos/intercuartil.php";

actionRestriction_102();



if (

    isset($_GET["id_configuracion"]) &&

    isset($_GET["fecha_corte"]) &&

    isset($_GET["muestra"]) &&

    isset($_GET["ronda"]) &&

    isset($_GET["programa"])

) {



    $id_configuracion = $_GET["id_configuracion"];

    $fecha_corte = $_GET["fecha_corte"];

    $muestra = $_GET["muestra"];

    $ronda = $_GET["ronda"];

    $programa = $_GET["programa"];



    require_once("generalInformeConsensoAnalito.php");



    $pdf = new generalInformeConsensoAnalito('L', 'mm', 'letter'); // Página vertical, tamaño carta, medición en Milímetros

    $pdf->AliasNbPages();

    $pdf->AddPage();



    // Obtener la informacion del lote

    $qry_lote_cs = "SELECT nombre_lote, nombre_programa FROM lote INNER JOIN muestra_programa ON lote.id_lote = muestra_programa.id_lote join programa on programa.id_programa = muestra_programa.id_programa 

                        WHERE muestra_programa.id_muestra = '" . $muestra . "'";

    $qryData_lote_cs = mysql_fetch_array(mysql_query($qry_lote_cs));

    mysqlException(mysql_error(), "_05_");



    $nombre_lote = $qryData_lote_cs['nombre_lote'];

    $nombre_programa = $qryData_lote_cs['nombre_programa'];



    // Consulta para obtener los casos clinicos de el reto diligenciado

    $qry = "SELECT 

            analito.nombre_analito,

            unidad.nombre_unidad

        from 

            configuracion_laboratorio_analito

            join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad 

            join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito 

        where configuracion_laboratorio_analito.id_configuracion = $id_configuracion

        limit 1";

    $qryArray = mysql_query($qry);

    mysqlException(mysql_error(), "_01");

    $qryData = mysql_fetch_array($qryArray);



    $nombre_analito = $qryData["nombre_analito"];

    $nombre_unidad = $qryData["nombre_unidad"];

    $id_config_consenso = $id_configuracion;
    $fecha_corte_escaped = mysql_real_escape_string($fecha_corte);

    // Consultar selecciones previas de la base de datos
    $sql_get_selected = "SELECT id_resultado
                        FROM selecciones_consenso
                        WHERE id_configuracion = '" . mysql_real_escape_string($id_config_consenso) . "'
                        AND id_muestra = '" . mysql_real_escape_string($muestra) . "'
                        AND DATE(fecha_seleccion) = DATE('" . $fecha_corte_escaped . "')";

    $result_selected = mysql_query($sql_get_selected);
    $previamente_seleccionados_db = array();

    if ($result_selected) {
        while ($row_selected = mysql_fetch_assoc($result_selected)) {
            $previamente_seleccionados_db[] = $row_selected['id_resultado'];
        }
    }

    // Convertir a un array asociativo para búsqueda rápida
    $previamente_seleccionados_map = array();
    foreach ($previamente_seleccionados_db as $id) {
        $previamente_seleccionados_map[$id] = true;
    }

    // Determinar si hay selecciones previas en la DB
    $hay_selecciones_db = !empty($previamente_seleccionados_map);


    $qryConsenso = "SELECT
            resultado.id_resultado as 'id_unico_resultado',
            resultado.valor_resultado as 'resultado',
            resultado.fecha_resultado as 'fecha_resultado',
            programa.nombre_programa as 'nombre_programa',
            ronda.no_ronda as no_ronda,
            contador_muestra.no_contador as no_contador,
            muestra.codigo_muestra as codigo_muestra,
            laboratorio.no_laboratorio as no_laboratorio,
            laboratorio.nombre_laboratorio as nombre_laboratorio,
            metodologia.nombre_metodologia as nombre_metodologia
        FROM programa
            join muestra_programa on programa.id_programa = muestra_programa.id_programa
            join muestra on muestra.id_muestra = muestra_programa.id_muestra
            join contador_muestra on muestra.id_muestra = contador_muestra.id_muestra
            join ronda on ronda.id_ronda = contador_muestra.id_ronda
            join lote on lote.id_lote = muestra_programa.id_lote
            join resultado on muestra.id_muestra = resultado.id_muestra
            join configuracion_laboratorio_analito on configuracion_laboratorio_analito.id_configuracion = resultado.id_configuracion
            join laboratorio on laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio
            join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad
            join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito
            join metodologia on metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia
        WHERE
            resultado.valor_resultado IS NOT NULL
            AND resultado.valor_resultado != ''
            AND lote.nombre_lote = '" . mysql_real_escape_string($nombre_lote) . "'
            AND analito.nombre_analito = '" . mysql_real_escape_string($nombre_analito) . "'
            AND unidad.nombre_unidad = '" . mysql_real_escape_string($nombre_unidad) . "'
            AND resultado.fecha_resultado <= '" . $fecha_corte . "'
        ORDER BY CAST(resultado.valor_resultado AS DECIMAL(10, 3))";

    // EJECUTAR LA CONSULTA Y GUARDAR TODOS LOS RESULTADOS EN UN ARRAY TEMPORAL ---
    $todos_los_resultados_db = array();
    $query_result = mysql_query($qryConsenso);
    mysqlException(mysql_error(), "_01");
    if ($query_result) {
        while ($row = mysql_fetch_assoc($query_result)) {
            $todos_los_resultados_db[] = $row;
        }
    }

    $qryArrayFinalConsenso = []; // Para los INCLUIDOS que se usarán en Grubbs
    $qryArrayConsensoExcluidos = []; // Para los EXCLUIDOS


    //  ITERAR Y SEPARAR LOS RESULTADOS EN LOS DOS ARRAYS ---
    foreach ($todos_los_resultados_db as $row) {
        $item_completo = [
            "id_unico_resultado" => $row["id_unico_resultado"],
            "resultado" => $row["resultado"],
            "fecha_resultado" => $row["fecha_resultado"],
            "nombre_programa" => $row["nombre_programa"],
            "no_ronda" => $row["no_ronda"],
            "no_contador" => $row["no_contador"],
            "codigo_muestra" => $row["codigo_muestra"],
            "no_laboratorio" => $row["no_laboratorio"],
            "nombre_laboratorio" => $row["nombre_laboratorio"],
            "nombre_metodologia" => $row["nombre_metodologia"]
        ];

        if ($hay_selecciones_db) {
            // Si hay selecciones previas en la DB
            if (isset($previamente_seleccionados_map[$row['id_unico_resultado']])) {
                // Si el ID de esta fila SÍ está en la lista de seleccionados de la DB, va al array principal.
                array_push($qryArrayFinalConsenso, $item_completo);
            } else {
                // Si el ID de esta fila NO está en la lista de seleccionados de la DB, va al array de excluidos.
                array_push($qryArrayConsensoExcluidos, $item_completo);
            }
        } else {
            // Si NO hay selecciones previas en la DB, todos los resultados van al array principal inicialmente.
            array_push($qryArrayFinalConsenso, $item_completo);
        }
    }

    $array_para_grubbs = [];
    foreach ($qryArrayFinalConsenso as $item) {
        // Intenta convertir a flotante (más seguro para números decimales)
        $resultado_convertido = (float) $item['resultado'];


        // Luego, verifica si el resultado de la conversión es un número válido 
        if (is_numeric($resultado_convertido)) {
            $array_para_grubbs[] = ['resultado' => $resultado_convertido];
        }
    }

    $objGrubbs = new Grubbs();
    $qryArrayConsenso = $objGrubbs->exclusionAtipicos($array_para_grubbs, "resultado");
    $qryData_participantesGrubbs = $objGrubbs->getPromediosNormales("resultado");


    $pdf->SetXY(5, 28);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->SetTextColor(40, 40, 40);

    $pdf->SetDrawColor(127, 179, 213);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);



    $pdf->SetFont('Arial', 'B', 7);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(9.5, 5, "Lote:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(20, 5, $nombre_lote, 1, 0, 'L', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(21, 5, "Fecha de corte:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(22, 5, "$fecha_corte", 1, 0, 'L', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(16, 5, "Programa:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(30, 5, "$nombre_programa", 1, 0, 'L', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(13, 5, "Analito:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(35, 5, "$nombre_analito", 1, 0, 'L', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(12, 5, "Unidad:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(25, 5, "$nombre_unidad", 1, 0, 'L', 1);



    $anchoItem = 10;

    $anchoPrograma = 30;

    $anchoResultado = 20;

    $anchoFechaResultado = 20;

    $anchoUnidad = 20;

    $anchoAnalito = 40;

    $anchoRonda = 20;

    $anchoMuestra = 20;

    $anchoNumLab = 30;

    $anchoNomLab = 90;

    $anchoNomMetod = 59;



    // Encabezado primer nivel

    //$pdf->SetXY(5, 40);

    //$pdf->SetFont('Arial','B',6);

    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->SetDrawColor(127, 179, 213);

    //$pdf->SetTextColor(40, 40, 40);

    //$pdf->Cell($anchoItem,6,"IT",1,0,'C',1);

    //$pdf->Cell($anchoResultado,6,"Resultado",1,0,'C',1);

    //$pdf->Cell($anchoFechaResultado,6,"Fecha",1,0,'C',1);

    //$pdf->Cell($anchoRonda,6,"Ronda",1,0,'C',1);

    //$pdf->Cell($anchoMuestra,6,"Muestra",1,0,'C',1);

    //$pdf->Cell($anchoNumLab,6,"ID Laboratorio",1,0,'C',1);

    //$pdf->Cell($anchoNomLab,6,"Nombre laboratorio",1,0,'C',1);

    //$pdf->Cell($anchoNomMetod,6,"Nombre Metodologia",1,0,'C',1);



    //$contador = 0;

    //$pdf->Ln(6);



    foreach ($qryArrayConsenso as $qryDataConsenso) {



        //$contador++;



        //$pdf->SetFillColor(245,245,245);

        //$pdf->SetDrawColor(171, 178, 185);

        //$pdf->SetTextColor(40, 40, 40);

        //$pdf->SetFont('Arial','',6);

        //$pdf->SetX(5);



        //$resultado = $qryDataConsenso["resultado"];

        //$nombre_programa = $qryDataConsenso["nombre_programa"];

        //$no_ronda = $qryDataConsenso["no_ronda"];

        //$codigo_muestra = $qryDataConsenso["codigo_muestra"];

        //$fecha_resultado = $qryDataConsenso["fecha_resultado"];

        //$no_contador = $qryDataConsenso["no_contador"];

        //$no_laboratorio = $qryDataConsenso["no_laboratorio"];

        //$nombre_laboratorio = $qryDataConsenso["nombre_laboratorio"];

        //$nombre_metodologia = $qryDataConsenso["nombre_metodologia"];



        $pdf->SetWidths(

            array(

                //$anchoItem,

                //$anchoResultado,

                //$anchoFechaResultado,

                //$anchoRonda,

                //$anchoMuestra,

                //$anchoNumLab,

                //$anchoNomLab,

                //$anchoNomMetod

            )
        );

        $pdf->SetAligns(

            array(

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

            )

        );



        $pdf->Row(array(

            //trim($contador) . "\n", // IT

            //trim($resultado) . "\n", // Resultado

            //trim($fecha_resultado) . "\n", // Resultado

            //trim($no_ronda) . "\n", // Ronda

            //"(" . $no_contador . ") " . trim($codigo_muestra) . "\n", // Muestra

            //trim($no_laboratorio) . "\n", // ID Laboratorio

            //trim($nombre_laboratorio) . "\n", // Nombre Laboratorio

            //trim($nombre_metodologia) . "\n", // Nombre metodologia

        ));

    }





    foreach ($qryArrayConsensoExcluidos as $qryDataConsensoExcluido) {



        $pdf->SetFillColor(242, 215, 213);

        $pdf->SetDrawColor(230, 176, 170);

        $pdf->SetTextColor(40, 40, 40);

        $pdf->SetFont('Arial', '', 6);

        $pdf->SetX(5);



        //$resultado = $qryDataConsensoExcluido["resultado"];

        //$nombre_programa = $qryDataConsensoExcluido["nombre_programa"];

        //$no_ronda = $qryDataConsensoExcluido["no_ronda"];

        //$codigo_muestra = $qryDataConsensoExcluido["codigo_muestra"];

        //$fecha_resultado = $qryDataConsensoExcluido["fecha_resultado"];

        //$no_contador = $qryDataConsensoExcluido["no_contador"];

        //$no_laboratorio = $qryDataConsensoExcluido["no_laboratorio"];

        //$nombre_laboratorio = $qryDataConsensoExcluido["nombre_laboratorio"];

        //$nombre_metodologia = $qryDataConsensoExcluido["nombre_metodologia"];



        $pdf->SetWidths(

            array(

                $anchoItem,

                $anchoResultado,

                $anchoFechaResultado,

                $anchoRonda,

                $anchoMuestra,

                $anchoNumLab,

                $anchoNomLab,

                $anchoNomMetod

            )
        );

        $pdf->SetAligns(

            array(

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

            )

        );



        $pdf->Row(array(

            //"Excluido\n", // IT

            //trim($resultado) . "\n", // Resultado

            //trim($fecha_resultado) . "\n", // Resultado

            //trim($no_ronda) . "\n", // Ronda

            //"(" . $no_contador . ") " . trim($codigo_muestra) . "\n", // Muestra

            //trim($no_laboratorio) . "\n", // ID Laboratorio

            //trim($nombre_laboratorio) . "\n", // Nombre Laboratorio

            //trim($nombre_metodologia) . "\n", // Nombre metodologia

        ));

    }





    // Variables de media de comparacion

    $media_general = round($qryData_participantesGrubbs['media'], 2);

    $de_general = round($qryData_participantesGrubbs['de'], 2);

    $cv_general = round($qryData_participantesGrubbs['cv'], 2);

    $n_general = $qryData_participantesGrubbs['n'];



    $pdf->Ln(6);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetDrawColor(171, 178, 185);

    $pdf->SetTextColor(40, 40, 40);



    $pdf->Cell(45, 2, "Valores estadísticos Grubbs:", 0, 0, 'L', 0);

    $pdf->Ln(3);



    $pdf->SetX(5);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "Media", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objGrubbs->get_media_general(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "D.E.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objGrubbs->get_desvest_general(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Factor Grubbs", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objGrubbs->get_factor_grubbs_utilizado(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Límite inferior", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objGrubbs->get_limite_inf(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Límite superior", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objGrubbs->get_limite_sup(), 1, 0, 'C', 1);



    $pdf->Ln(8);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetDrawColor(171, 178, 185);

    $pdf->SetTextColor(40, 40, 40);

    $pdf->Cell(45, 2, "Valores estadísticos Finales:", 0, 0, 'L', 0);



    $pdf->Ln(3);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(16, 4, "Media", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $media_general, 1, 0, 'C', 1);



    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(16, 4, "D.E.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $de_general, 1, 0, 'C', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "C.V.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$cv_general", 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "N", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$n_general", 1, 0, 'C', 1);

    $pdf->AliasNbPages();



    //nuevo test Dixon



    $objDixon = new Dixon();







    $qryArrayConsenso = $objDixon->exclusionAtipicos($qryArrayFinalConsenso, "resultado");

    $qryData_participantes = $objDixon->getPromediosNormales("resultado");






    //$pdf->SetXY(5,30);

    $pdf->SetFont('Arial', 'B', 7);

    //$pdf->SetTextColor(40, 40, 40);

    //$pdf->SetDrawColor(127, 179, 213);

    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->SetFillColor(230, 237, 242);

    //$pdf->SetFont('Arial','',7);



    //$pdf->SetFont('Arial','B',7);

    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->Cell(9.5,5,"Lote:",1,0,'L',1);

    //$pdf->SetFillColor(230, 237, 242);

    //$pdf->SetFont('Arial','',7);

    //$pdf->Cell(20,5,$nombre_lote,1,0,'L',1);



    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->SetFont('Arial','B',7);

    //$pdf->Cell(21,5,"Fecha de corte:",1,0,'L',1);

    //$pdf->SetFillColor(230, 237, 242);

    //$pdf->SetFont('Arial','',7);

    //$pdf->Cell(22,5,"$fecha_corte",1,0,'L',1);





    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->SetFont('Arial','B',7);

    //$pdf->Cell(16,5,"Programa:",1,0,'L',1);

    //$pdf->SetFillColor(230, 237, 242);

    //$pdf->SetFont('Arial','',7);

    //$pdf->Cell(30,5,"$nombre_programa",1,0,'L',1);



    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->SetFont('Arial','B',7);

    //$pdf->Cell(13,5,"Analito:",1,0,'L',1);

    //$pdf->SetFillColor(230, 237, 242);

    //$pdf->SetFont('Arial','',7);

    //$pdf->Cell(35,5,"$nombre_analito",1,0,'L',1);



    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->SetFont('Arial','B',7);

    //$pdf->Cell(12,5,"Unidad:",1,0,'L',1);

    //$pdf->SetFillColor(230, 237, 242);

    //$pdf->SetFont('Arial','',7);

    //$pdf->Cell(25,5,"$nombre_unidad",1,0,'L',1);



    $anchoItem = 10;

    $anchoPrograma = 30;

    $anchoResultado = 20;

    $anchoFechaResultado = 20;

    $anchoUnidad = 20;

    $anchoAnalito = 40;

    $anchoRonda = 20;

    $anchoMuestra = 20;

    $anchoNumLab = 30;

    $anchoNomLab = 90;

    $anchoNomMetod = 59;



    // Encabezado primer nivel

    //$pdf->SetXY(5, 40);

    //$pdf->SetFont('Arial','B',6);

    //$pdf->SetFillColor(200, 212, 221);

    //$pdf->SetDrawColor(127, 179, 213);

    //$pdf->SetTextColor(40, 40, 40);

    //$pdf->Cell($anchoItem,6,"IT",1,0,'C',1);

    //$pdf->Cell($anchoResultado,6,"Resultado",1,0,'C',1);

    //$pdf->Cell($anchoFechaResultado,6,"Fecha",1,0,'C',1);

    //$pdf->Cell($anchoRonda,6,"Ronda",1,0,'C',1);

    //$pdf->Cell($anchoMuestra,6,"Muestra",1,0,'C',1);

    //$pdf->Cell($anchoNumLab,6,"ID Laboratorio",1,0,'C',1);

    //$pdf->Cell($anchoNomLab,6,"Nombre laboratorio",1,0,'C',1);

    //$pdf->Cell($anchoNomMetod,6,"Nombre Metodologia",1,0,'C',1);



    $contador = 0;

    $pdf->Ln(6);



    foreach ($qryArrayConsenso as $qryDataConsenso) {



        $contador++;



        $pdf->SetFillColor(245, 245, 245);

        $pdf->SetDrawColor(171, 178, 185);

        $pdf->SetTextColor(40, 40, 40);

        $pdf->SetFont('Arial', '', 6);

        $pdf->SetX(5);



        //$resultado = $qryDataConsenso["resultado"];

        //$nombre_programa = $qryDataConsenso["nombre_programa"];

        //$no_ronda = $qryDataConsenso["no_ronda"];

        //$codigo_muestra = $qryDataConsenso["codigo_muestra"];

        //$fecha_resultado = $qryDataConsenso["fecha_resultado"];

        //$no_contador = $qryDataConsenso["no_contador"];

        //$no_laboratorio = $qryDataConsenso["no_laboratorio"];

        //$nombre_laboratorio = $qryDataConsenso["nombre_laboratorio"];

        //$nombre_metodologia = $qryDataConsenso["nombre_metodologia"];



        $pdf->SetWidths(

            array(

                //  $anchoItem,

                //$anchoResultado,

                // $anchoFechaResultado,

                // $anchoRonda,

                //$anchoMuestra,

                //$anchoNumLab,

                //$anchoNomLab,

                //$anchoNomMetod

            )
        );

        $pdf->SetAligns(

            array(

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

            )

        );



        $pdf->Row(array(

            //trim($contador) . "\n", // IT

            //trim($resultado) . "\n", // Resultado

            //trim($fecha_resultado) . "\n", // Resultado

            //trim($no_ronda) . "\n", // Ronda

            //"(" . $no_contador . ") " . trim($codigo_muestra) . "\n", // Muestra

            //trim($no_laboratorio) . "\n", // ID Laboratorio

            //trim($nombre_laboratorio) . "\n", // Nombre Laboratorio

            //trim($nombre_metodologia) . "\n", // Nombre metodologia

        ));

    }





    foreach ($qryArrayConsensoExcluidos as $qryDataConsensoExcluido) {



        $pdf->SetFillColor(242, 215, 213);

        $pdf->SetDrawColor(230, 176, 170);

        $pdf->SetTextColor(40, 40, 40);

        $pdf->SetFont('Arial', '', 6);

        $pdf->SetX(5);



        //$resultado = $qryDataConsensoExcluido["resultado"];

        //$nombre_programa = $qryDataConsensoExcluido["nombre_programa"];

        //$no_ronda = $qryDataConsensoExcluido["no_ronda"];

        //$codigo_muestra = $qryDataConsensoExcluido["codigo_muestra"];

        //$fecha_resultado = $qryDataConsensoExcluido["fecha_resultado"];

        //$no_contador = $qryDataConsensoExcluido["no_contador"];

        //$no_laboratorio = $qryDataConsensoExcluido["no_laboratorio"];

        //$nombre_laboratorio = $qryDataConsensoExcluido["nombre_laboratorio"];

        //$nombre_metodologia = $qryDataConsensoExcluido["nombre_metodologia"];



        $pdf->SetWidths(

            array(

                $anchoItem,

                $anchoResultado,

                $anchoFechaResultado,

                $anchoRonda,

                $anchoMuestra,

                $anchoNumLab,

                $anchoNomLab,

                $anchoNomMetod

            )
        );

        $pdf->SetAligns(

            array(

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

            )

        );



        $pdf->Row(array(

            // "Excluido\n", // IT

            //trim($resultado) . "\n", // Resultado

            //trim($fecha_resultado) . "\n", // Resultado

            //trim($no_ronda) . "\n", // Ronda

            //"(" . $no_contador . ") " . trim($codigo_muestra) . "\n", // Muestra

            //trim($no_laboratorio) . "\n", // ID Laboratorio

            //trim($nombre_laboratorio) . "\n", // Nombre Laboratorio

            //trim($nombre_metodologia) . "\n", // Nombre metodologia

        ));

    }





    // Variables de media de comparacion

    $media_general = round($qryData_participantes['media'], 2);

    $de_general = round($qryData_participantes['de'], 2);

    $cv_general = round($qryData_participantes['cv'], 2);

    $n_general = $qryData_participantes['n'];





    $pdf->Ln(4);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetDrawColor(171, 178, 185);

    $pdf->SetTextColor(40, 40, 40);



    $pdf->Cell(45, 2, "Valores estadísticos Dixon:", 0, 0, 'L', 0);

    $pdf->Ln(3);



    $pdf->SetX(5);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "Media", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objDixon->get_media_general(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "D.E.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objDixon->get_desvest_general(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Factor Dixon", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objDixon->get_factor_dixon_utilizado(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Dato menor", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objDixon->get_limite_inf(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Dato mayor", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objDixon->get_limite_sup(), 1, 0, 'C', 1);



    $pdf->Ln(8);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetDrawColor(171, 178, 185);

    $pdf->SetTextColor(40, 40, 40);

    $pdf->Cell(45, 2, "Valores estadísticos Finales:", 0, 0, 'L', 0);



    $pdf->Ln(3);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(16, 4, "Media", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $media_general, 1, 0, 'C', 1);



    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(16, 4, "D.E.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $de_general, 1, 0, 'C', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "C.V.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$cv_general", 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "N", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$n_general", 1, 0, 'C', 1);





    $pdf->AliasNbPages();

    $pdf->addpage();



    //Nuevo test intercuartil

    $objIntercuartil = new Intercuartil();





    $qryArrayConsenso = $objIntercuartil->test_intercuartil($qryArrayFinalConsenso, "resultado", false);

    $qryData_participantes = $objIntercuartil->getPromediosNormales("resultado");




    $pdf->SetXY(5, 30);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->SetTextColor(40, 40, 40);

    $pdf->SetDrawColor(127, 179, 213);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);



    $pdf->SetFont('Arial', 'B', 7);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(9.5, 5, "Lote:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(20, 5, $nombre_lote, 1, 0, 'L', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(21, 5, "Fecha de corte:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(22, 5, "$fecha_corte", 1, 0, 'L', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(16, 5, "Programa:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(30, 5, "$nombre_programa", 1, 0, 'L', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(13, 5, "Analito:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(35, 5, "$nombre_analito", 1, 0, 'L', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 7);

    $pdf->Cell(12, 5, "Unidad:", 1, 0, 'L', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 7);

    $pdf->Cell(25, 5, "$nombre_unidad", 1, 0, 'L', 1);



    $anchoItem = 10;

    $anchoPrograma = 30;

    $anchoResultado = 20;

    $anchoFechaResultado = 20;

    $anchoUnidad = 20;

    $anchoAnalito = 40;

    $anchoRonda = 20;

    $anchoMuestra = 20;

    $anchoNumLab = 30;

    $anchoNomLab = 90;

    $anchoNomMetod = 59;



    // Encabezado primer nivel

    $pdf->SetXY(5, 40);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetDrawColor(127, 179, 213);

    $pdf->SetTextColor(40, 40, 40);

    $pdf->Cell($anchoItem, 6, "IT", 1, 0, 'C', 1);

    $pdf->Cell($anchoResultado, 6, "Resultado", 1, 0, 'C', 1);

    $pdf->Cell($anchoFechaResultado, 6, "Fecha", 1, 0, 'C', 1);

    $pdf->Cell($anchoRonda, 6, "Ronda", 1, 0, 'C', 1);

    $pdf->Cell($anchoMuestra, 6, "Muestra", 1, 0, 'C', 1);

    $pdf->Cell($anchoNumLab, 6, "ID Laboratorio", 1, 0, 'C', 1);

    $pdf->Cell($anchoNomLab, 6, "Nombre laboratorio", 1, 0, 'C', 1);

    $pdf->Cell($anchoNomMetod, 6, "Nombre Metodologia", 1, 0, 'C', 1);



    $contador = 0;

    $pdf->Ln(6);



    foreach ($qryArrayConsenso as $qryDataConsenso) {



        $contador++;



        $pdf->SetFillColor(245, 245, 245);

        $pdf->SetDrawColor(171, 178, 185);

        $pdf->SetTextColor(40, 40, 40);

        $pdf->SetFont('Arial', '', 6);

        $pdf->SetX(5);



        $resultado = $qryDataConsenso["resultado"];

        $nombre_programa = $qryDataConsenso["nombre_programa"];

        $no_ronda = $qryDataConsenso["no_ronda"];

        $codigo_muestra = $qryDataConsenso["codigo_muestra"];

        $fecha_resultado = $qryDataConsenso["fecha_resultado"];

        $no_contador = $qryDataConsenso["no_contador"];

        $no_laboratorio = $qryDataConsenso["no_laboratorio"];

        $nombre_laboratorio = $qryDataConsenso["nombre_laboratorio"];

        $nombre_metodologia = $qryDataConsenso["nombre_metodologia"];



        $pdf->SetWidths(

            array(

                $anchoItem,

                $anchoResultado,

                $anchoFechaResultado,

                $anchoRonda,

                $anchoMuestra,

                $anchoNumLab,

                $anchoNomLab,

                $anchoNomMetod

            )
        );

        $pdf->SetAligns(

            array(

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

            )

        );



        $pdf->Row(array(

            trim($contador) . "\n", // IT

            trim($resultado) . "\n", // Resultado

            trim($fecha_resultado) . "\n", // Resultado

            trim($no_ronda) . "\n", // Ronda

            "(" . $no_contador . ") " . trim($codigo_muestra) . "\n", // Muestra

            trim($no_laboratorio) . "\n", // ID Laboratorio

            trim($nombre_laboratorio) . "\n", // Nombre Laboratorio

            trim($nombre_metodologia) . "\n", // Nombre metodologia

        ));

    }





    foreach ($qryArrayConsensoExcluidos as $qryDataConsensoExcluido) {



        $pdf->SetFillColor(242, 215, 213);

        $pdf->SetDrawColor(230, 176, 170);

        $pdf->SetTextColor(40, 40, 40);

        $pdf->SetFont('Arial', '', 6);

        $pdf->SetX(5);



        $resultado = $qryDataConsensoExcluido["resultado"];

        $nombre_programa = $qryDataConsensoExcluido["nombre_programa"];

        $no_ronda = $qryDataConsensoExcluido["no_ronda"];

        $codigo_muestra = $qryDataConsensoExcluido["codigo_muestra"];

        $fecha_resultado = $qryDataConsensoExcluido["fecha_resultado"];

        $no_contador = $qryDataConsensoExcluido["no_contador"];

        $no_laboratorio = $qryDataConsensoExcluido["no_laboratorio"];

        $nombre_laboratorio = $qryDataConsensoExcluido["nombre_laboratorio"];

        $nombre_metodologia = $qryDataConsensoExcluido["nombre_metodologia"];



        $pdf->SetWidths(

            array(

                $anchoItem,

                $anchoResultado,

                $anchoFechaResultado,

                $anchoRonda,

                $anchoMuestra,

                $anchoNumLab,

                $anchoNomLab,

                $anchoNomMetod

            )
        );

        $pdf->SetAligns(

            array(

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

                "C",

            )

        );



        $pdf->Row(array(

            "Excluido\n", // IT

            trim($resultado) . "\n", // Resultado

            trim($fecha_resultado) . "\n", // Resultado

            trim($no_ronda) . "\n", // Ronda

            "(" . $no_contador . ") " . trim($codigo_muestra) . "\n", // Muestra

            trim($no_laboratorio) . "\n", // ID Laboratorio

            trim($nombre_laboratorio) . "\n", // Nombre Laboratorio

            trim($nombre_metodologia) . "\n", // Nombre metodologia

        ));

    }





    // Variables de media de comparacion

    $mediana = round($qryData_participantesGrubbs['mediana'], 2);

    $s = round($qryData_participantesGrubbs['s'], 2);

    $cv_robusto = round($qryData_participantesGrubbs['cv_robusto'], 2);

    $n_general = $qryData_participantesGrubbs['n'];

    $p_25 = round($qryData_participantesGrubbs['q1'], 2);

    $p_75 = round($qryData_participantesGrubbs['q3'], 2);



    $pdf->Ln(4);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetDrawColor(171, 178, 185);

    $pdf->SetTextColor(40, 40, 40);



    $pdf->Cell(45, 2, "Valores estadísticos Intercuartil:", 0, 0, 'L', 0);

    $pdf->Ln(3);



    $pdf->SetX(5);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "Media", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objIntercuartil->get_media_general(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "D.E.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objIntercuartil->get_desvest_general(), 1, 0, 'C', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "Q1", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objIntercuartil->get_q1(), 1, 0, 'C', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "Q3", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objIntercuartil->get_q3(), 1, 0, 'C', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "RIC", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objIntercuartil->get_iqr(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Límite inferior", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objIntercuartil->get_limite_inf(), 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(20, 4, "Límite superior", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $objIntercuartil->get_limite_sup(), 1, 0, 'C', 1);



    $pdf->Ln(8);

    $pdf->SetX(5);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetDrawColor(171, 178, 185);

    $pdf->SetTextColor(40, 40, 40);

    $pdf->Cell(45, 2, "Valores estadísticos Finales:", 0, 0, 'L', 0);



    $pdf->Ln(3);

    $pdf->SetX(5);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "P25", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$p_25", 1, 0, 'C', 1);



    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(16, 4, "Mediana", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $mediana, 1, 0, 'C', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "P75", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$p_75", 1, 0, 'C', 1);



    $pdf->SetFont('Arial', 'B', 6);

    $pdf->SetFillColor(200, 212, 221);

    $pdf->Cell(16, 4, "D.E.*", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, $s, 1, 0, 'C', 1);



    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "C.V.", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$cv_robusto", 1, 0, 'C', 1);





    $pdf->SetFillColor(200, 212, 221);

    $pdf->SetFont('Arial', 'B', 6);

    $pdf->Cell(16, 4, "N", 1, 0, 'C', 1);

    $pdf->SetFillColor(230, 237, 242);

    $pdf->SetFont('Arial', '', 6);

    $pdf->Cell(15, 4, "$n_general", 1, 0, 'C', 1);




    // Cerrar PDF

    $pdf->Close();



    $nomArchivo = utf8_decode("Consenso Analito.pdf");

    $pdf->Output("I", $nomArchivo);

} else {

    echo "Información insuficiente para la generación del reporte...";

}

?>