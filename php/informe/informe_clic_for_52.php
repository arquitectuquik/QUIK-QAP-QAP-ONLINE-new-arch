<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}


session_start();
include_once "../verifica_sesion.php";
actionRestriction_102();

include("../pchart/class/pData.class.php");
include("../pchart/class/pDraw.class.php");
include("../pchart/class/pImage.class.php");
include("../pchart/class/pScatter.class.php");
include("../pchart/class/pPie.class.php");

$chartWidth = 800;
$chartHeight = 500;
$chartLabelFontSize = 16;
$chartPlotFontSize = 15;
$chartPlotLabelFontSize = 12;

$idciudad = $_GET["ciudad"];
$idlaboratorio = $_GET["laboratorio"];
$programa = $_GET["programa"];
$idmuestra = $_GET["muestra"];
$idconexion = $_GET["conexion"];
$idanalito  = $_GET["analito"];
$fechaano = $_GET["ano"];
$fechames = $_GET["mes"];
$idronda = $_GET["ronda"];

if (isset($programa)) {

    require_once("fpdf/clic-for-52-pdf.php");
    $pdf = new CLICFOR52PDF("l", "mm", "letter"); // Página vertical, tamaño carta, medición en Milímetros

    $pdf->SetFont('Arial', '', 6);

    $qrySede = "SELECT analito.id_analito, analito.nombre_analito, laboratorio.id_laboratorio, laboratorio.nombre_laboratorio, laboratorio.no_laboratorio, ciudad.nombre_ciudad, 
    EXTRACT( YEAR FROM resultado.fecha_resultado) as 'fechaano', EXTRACT( MONTH FROM resultado.fecha_resultado) as 'fechames', ronda.no_ronda,
    muestra.codigo_muestra, resultado.valor_resultado, contador_muestra.no_contador, muestra.id_muestra, resultado.id_analito_resultado_reporte_cualitativo as 'reporteresultado',
    programa.no_muestras, resultado.revalorado, resultado.id_configuracion, analizador.nombre_analizador, unidad.nombre_unidad, programa.modalidad_muestra,
    mece.media_estandar, mece.desviacion_estandar 
    
    FROM configuracion_laboratorio_analito cla 
    
    INNER JOIN programa ON programa.id_programa = cla.id_programa
    INNER JOIN laboratorio ON laboratorio.id_laboratorio = cla.id_laboratorio 
    INNER JOIN ciudad ON ciudad.id_ciudad = laboratorio.id_ciudad
    INNER JOIN resultado ON resultado.id_configuracion = cla.id_configuracion
    INNER JOIN muestra ON muestra.id_muestra = resultado.id_muestra
    INNER JOIN contador_muestra ON contador_muestra.id_muestra = resultado.id_muestra
    INNER JOIN ronda ON ronda.id_ronda = contador_muestra.id_ronda
    LEFT JOIN analizador ON analizador.id_analizador = cla.id_analizador
    LEFT JOIN unidad ON unidad.id_unidad = cla.id_unidad
    LEFT JOIN analito ON analito.id_analito = cla.id_analito
    INNER JOIN media_evaluacion_caso_especial mece ON mece.id_configuracion = cla.id_configuracion 
    AND mece.id_muestra = muestra.id_muestra 
    WHERE ciudad.id_ciudad IN(" . $idciudad . ")
    AND laboratorio.id_laboratorio IN(" . $idlaboratorio . ")
    AND cla.id_programa IN(" . $programa . ")
    AND muestra.id_muestra IN(" . $idmuestra . ")
    AND contador_muestra.id_conexion IN(" . $idconexion . ")
    AND analito.id_analito IN(" . $idanalito . ")
    AND EXTRACT( YEAR FROM resultado.fecha_resultado) IN(" . $fechaano . ")
    AND EXTRACT( MONTH FROM resultado.fecha_resultado) IN(" . $fechames . ")
    AND ronda.id_ronda IN(" . $idronda . ")
    AND mece.media_estandar !='0' 
    AND mece.media_estandar !='' 
    AND mece.desviacion_estandar !='0'
    AND mece.desviacion_estandar !=''
    AND resultado.valor_resultado !='0'
    AND resultado.valor_resultado !=''  
    ORDER BY analito.nombre_analito,fechaano,fechames,laboratorio.no_laboratorio";

    $qrySedeData = mysql_query($qrySede);

    $pdf->SetLabels($idmuestra, $programa, $rondaLabel, $fechaano, $fechames, $idlaboratorio, $idronda, $idciudad);

    $pdf->AddPage();

    $i = 0;
    $subind = 0;
    $analito = '';
    $mes = '';
    $imagenes = false;
    $imagenescount = 0;
    $graficacount = 0;
    $zverde = 0;
    $zamarillo = 0;
    $zrojo = 0;
    $zscoregrafica = array();
    $resultado = array();
    $media = array();
    $laboratorios = array();

    while ($qryData = mysql_fetch_array($qrySedeData)) {

        $colorFondo = [];
        $colorFondo = [$pdf->blanclo];
        array_push($colorFondo, $pdf->blanclo, $pdf->blanclo, $pdf->blanclo, $pdf->blanclo, $pdf->blanclo, $pdf->blanclo, $pdf->blanclo, $pdf->blanclo);

        $i++;

        if ($qryData['nombre_analito'] != $analito) {

            $i = 1;

            if ($analito == '') {

                $pdf->Sety(29.33);
                $pdf->SetX(13);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, 10, 'Analito :', 0, 0, "L");
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(150, 10, $qryData['nombre_analito'], 0, 0, "L");

                $pdf->Sety(39.33);
                $pdf->SetX(13);
                $pdf->SetFont('Arial', '', 6);
                $subind = 0;
                $pdf->SetFillColor(200, 215, 240);
                $pdf->Cell(7, 10, 'IT', 1, 0, "C", true);
                $pdf->Cell(17, 10, '# laboratorio', 1, 0, "C", true);
                $pdf->MultiCell(55, 10, 'Sede', 1, "C", true);
                $pdf->SetXY(92, 39.33);
                $pdf->Cell(8, 10, 'año', 1, 0, "C", true);
                $pdf->Cell(15, 10, 'mes', 1, 0, "C", true);
                $pdf->Cell(35, 10, 'instrumento', 1, 0, "C", true);
                $pdf->Cell(12, 10, 'resultado', 1, 0, "C", true);
                $pdf->Cell(12, 10, 'unidad', 1, 0, "C", true);
                $pdf->MultiCell(20, 5, 'Media de comparación', 1, "C", true);
                $pdf->SetXY(194, 39.33);
                $pdf->Cell(10, 10, 'Zscore', 1, 0, "C", true);
                $pdf->ln();
            } else {

                $lab = '';

                foreach ($laboratorios as $idlab) {
                    $labdata = mysql_fetch_array(mysql_query("SELECT * FROM laboratorio 
                                INNER JOIN ciudad ON ciudad.id_ciudad = laboratorio.id_ciudad
                                WHERE laboratorio.id_laboratorio = '" . $idlab . "'"));
                    $lab .= ' ' . $labdata['no_laboratorio'] . ' ' . $labdata['nombre_laboratorio'] . ' ' . $labdata['nombre_ciudad'] . '. ';
                }

                $laboratorios = array();
                $pdf->SetFont('Arial', '', 1);
                $pdf->Cell(180, 3, '', 0, 0, "C", FALSE);
                $pdf->ln();
                $pdf->SetFillColor(150, 255, 150);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetX(40);
                $pdf->Cell(45, 3, 'Satisfactorio', 'LTR', 0, "C", TRUE);
                $pdf->SetFillColor(255, 255, 150);
                $pdf->Cell(52, 3, 'Alarma', 'LTR', 0, "C", TRUE);
                $pdf->SetFillColor(255, 150, 150);
                $pdf->Cell(62, 3, 'No satisfactorio', 'LTR', 0, "C", TRUE);
                $pdf->SetFont('Arial', '', 7);
                $pdf->ln();
                $pdf->SetFillColor(150, 255, 150);
                $pdf->SetX(40);
                $pdf->Cell(45, 3, 'Si su resultado esta entre +/- 2 Z-score', 'LRB', 0, "C", TRUE);
                $pdf->SetFillColor(255, 255, 150);
                $pdf->Cell(52, 3, 'Si su resultado esta entre +/- 2 y +/- 3 Z-score', 'LRB', 0, "C", TRUE);
                $pdf->SetFillColor(255, 150, 150);
                $pdf->Cell(62, 3, 'Si su resultado es mayor a +/- 3 Z-score', 'LRB', 0, "C", TRUE);


                $pdf->Ln(30);

                if ($pdf->GetY() > 155) {
                    $pdf->AddPage("P", "letter");
                }


                $yData = $zscoregrafica;
                $zscoregraficapor = sizeof($zscoregrafica);
                $zscoregrafica = array();
                $xData = array();
                for ($x = 0; $x < sizeof($yData); $x++) {
                    $xData[$x] = (rand(1, 1100)) / 100;
                }
                $max = 11;

                for ($x = 0; $x < sizeof($yData); $x++) {
                    if ($yData[$x] > 7) {
                        $yData[$x] = "+7";
                    }
                }
                for ($x = 0; $x < sizeof($yData); $x++) {
                    if ($yData[$x] < (-7)) {
                        $yData[$x] = "-7";
                    }
                }


                $myDataChart = new pData();

                $myDataChart->AddPoints($xData, 'Serie1');
                $myDataChart->AddPoints($yData, 'Serie2');


                $myDataChart->setSerieOnAxis("Serie1", 0);
                $myDataChart->setAxisXY(0, AXIS_X);
                $myDataChart->setAxisPosition(0, AXIS_POSITION_BOTTOM);

                $myDataChart->setSerieOnAxis("Serie2", 1);
                $myDataChart->setAxisXY(1, AXIS_Y);
                $myDataChart->setAxisPosition(1, AXIS_POSITION_LEFT);

                $myDataChart->setAxisColor(0, array("R" => 255, "G" => 255, "B" => 255));
                $myDataChart->setPalette(array("Serie2", "Serie1"), $serieSettings);

                $myDataChart->setScatterSerie("Serie1", "Serie2", 0);


                $myPicture = new pImage($chartWidth, ($chartHeight + 30), $myDataChart);

                $myPicture->setGraphArea(50, 50, ($chartWidth - 25), ($chartHeight  - 40));

                $myPicture->setFontProperties(array("FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartLabelFontSize));

                $TextSettings = array(
                    "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0
                );
                $graficacount++;
                $myPicture->drawText(number_format($chartWidth / 2, 0), 25, "Gráfica " . $graficacount . " Z-score", $TextSettings);
                $TextSettings = array(
                    "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0, "Angle" => 90
                );
                $myPicture->drawText(10, number_format($chartHeight / 2, 0), "Z-score", $TextSettings);
                $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotFontSize));


                $myScatter = new pScatter($myPicture, $myDataChart);

                $myDataChart->setScatterSerieShape(0, SERIE_SHAPE_FILLEDCIRCLE);

                $scaleSettings = array(
                    "Pos" => SCALE_POS_LEFTRIGHT, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => array("Min" => 0, "Max" => ($max + 1), "Rows" => 6), 1 => array("Min" => -7, "Max" => 7)), "GridR" => 0, "GridG" => 0, "GridB" => 0, "GridAlpha" => 50, "TickR" => 0, "TickG" => 0, "TickB" => 0, "TickAlpha" => 50, "DrawXLines" => false, "DrawYLines" => false, "DrawSubTicks" => FALSE, "SubTickR" => 0, "SubTickG" => 0, "SubTickB" => 0, "SubTickAlpha" => 50
                );

                $myScatter->drawScatterScale($scaleSettings);

                $Config = array(
                    "R" => 0, "G" => 0, "B" => 0, "Alpha" => 100, "AxisID" => 0, "Ticks" => 0
                );

                $myScatter->drawScatterThreshold(0, $Config);

                $Config = array(
                    "DisplayValues" => TRUE, "PlotSize" => 5, "PlotBorder" => 0, "BorderSize" => 0
                );

                $myScatter->drawScatterPlotChart($Config);

                $myScatter->drawScatterThresholdArea(0, 2, array("AxisID" => 1, "R" => 219, "G" => 237, "B" => 219, "Alpha" => 50));
                $myScatter->drawScatterThresholdArea(0, -2, array("AxisID" => 1, "R" => 219, "G" => 237, "B" => 219, "Alpha" => 50));
                $myScatter->drawScatterThresholdArea(2, 3, array("AxisID" => 1, "R" => 255, "G" => 255, "B" => 219, "Alpha" => 50));
                $myScatter->drawScatterThresholdArea(-2, -3, array("AxisID" => 1, "R" => 255, "G" => 255, "B" => 219, "Alpha" => 50));
                $myScatter->drawScatterThresholdArea(3, 7, array("AxisID" => 1, "R" => 255, "G" => 219, "B" => 219, "Alpha" => 50));
                $myScatter->drawScatterThresholdArea(-3, -7, array("AxisID" => 1, "R" => 255, "G" => 219, "B" => 219, "Alpha" => 50));

                $myPicture->drawLine(50, (($chartHeight / 2) + 5), ($chartWidth - 20), (($chartHeight / 2) + 5), $Config); //(x1,y1,x2,y2)

                $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotLabelFontSize));

                $tempSum = 0;

                $Config = array(
                    "R" => 0, "G" => 0, "B" => 0, "Ticks" => 0
                );

                $imagenescount++;

                $myPicture->render("../temp_chart/graficaclicfor521" . $imagenescount . ".PNG");

                $yDataM = $resultado;
                $resultado1 = $resultado;
                $resultado = array();
                $yDataR = $media;
                $media1 = $media;
                $media = array();
                $xData = array();
                for ($x = 0; $x < sizeof($yDataR); $x++) {
                    $xData[$x] = $x + 1;
                }
                $max = sizeof($yDataR);
                $maxy = 0;
                $miny = 0;

                for ($x = 0; $x < sizeof($yDataR); $x++) {
                    if ($maxy < $yDataR[$x]) {
                        $maxy  = $yDataR[$x];
                    }
                }
                for ($x = 0; $x < sizeof($yDataR); $x++) {
                    if ($miny > $yDataR[$x]) {
                        $miny = $yDataR[$x];
                    }
                }

                for ($x = 0; $x < sizeof($yDataM); $x++) {
                    if ($maxy < $yDataM[$x]) {
                        $maxy = $yDataM[$x];
                    }
                }
                for ($x = 0; $x < sizeof($yDataM); $x++) {
                    if ($miny > $yDataM[$x]) {
                        $miny = $yDataM[$x];
                    }
                }


                $myDataChart = new pData();

                $myDataChart->AddPoints($xData, 'Serie1');
                $myDataChart->AddPoints($yDataM, 'Serie2');

                $myDataChart->AddPoints($xData, 'Serie3');
                $myDataChart->AddPoints($yDataR, 'Serie4');

                $myDataChart->setSerieOnAxis(array("Serie1", "Serie3"), 0);
                $myDataChart->setAxisXY(0, AXIS_X);
                $myDataChart->setAxisPosition(0, AXIS_POSITION_BOTTOM);

                $myDataChart->setSerieOnAxis(array("Serie2", "Serie4"), 1);
                $myDataChart->setAxisXY(1, AXIS_Y);
                $myDataChart->setAxisPosition(1, AXIS_POSITION_LEFT);
                $myDataChart->setAxisColor(0, array("R" => 255, "G" => 255, "B" => 255));

                $myDataChart->setPalette(array("Serie2", "Serie1", "Serie3", "Serie4"), $serieSettings);

                $myDataChart->setScatterSerie("Serie1", "Serie2", 0);
                $myDataChart->setScatterSerie("Serie3", "Serie4", 1);


                $myPicture = new pImage($chartWidth, ($chartHeight + 30), $myDataChart);

                $myPicture->setGraphArea(50, 50, ($chartWidth - 25), ($chartHeight  - 40));

                $myPicture->setFontProperties(array("FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartLabelFontSize));
                $TextSettings = array(
                    "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0
                );
                $graficacount++;

                $myPicture->drawText(number_format($chartWidth / 2, 0), 25, "Gráfica " . $graficacount . " Resultado VS Media de comparación", $TextSettings);
                $TextSettings = array(
                    "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0, "Angle" => 90
                );

                $myPicture->drawText(10, number_format($chartHeight / 2, 0), "", $TextSettings);

                $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotFontSize));

                $myDataChart->setScatterSerieDescription(0, "Serie1");
                $myDataChart->setScatterSerieDescription(1, "Serie3");
                $myDataChart->setScatterSerieColor(1, array("R" => 0, "G" => 100, "B" => 0));
                $myDataChart->setScatterSerieShape(1, SERIE_SHAPE_TRIANGLE);


                $myScatter = new pScatter($myPicture, $myDataChart);

                $scaleSettings = array(
                    "Mode" => SCALE_MODE_MANUAL,"ManualScale" => array(0 => array("Min" => 0, "Max" => ($max + 2), "Rows" => 6), 1 => array("Min" => ($miny - 5), "Max" => ($maxy + 5))), "GridR" => 0, "GridG" => 0, "GridB" => 0, "GridAlpha" => 50, "TickR" => 0, "TickG" => 0, "TickB" => 0, "TickAlpha" => 50, "DrawXLines" => FALSE, "DrawYLines" => ALL, "DrawSubTicks" => FALSE, "SubTickR" => 0, "SubTickG" => 0, "SubTickB" => 0, "SubTickAlpha" => 50
                );

                $myScatter->drawScatterScale($scaleSettings);

                $Config = array(
                    "R" => 0, "G" => 0, "B" => 0, "Alpha" => 100, "AxisID" => 0, "Ticks" => 0
                );

                $myScatter->drawScatterThreshold(0, $Config);

                $Config = array(
                    "DisplayValues" => TRUE, "PlotSize" => 5, "PlotBorder" => 0, "BorderSize" => 0
                );

                $myScatter->drawScatterPlotChart($Config);


                $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotLabelFontSize));

                $tempSum = 0;

                for ($x = 0; $x < sizeof($xData); $x++) {
                    if ($xData[$x] != "" && $yData[$x] != "") {
                        $tempSum++;
                    }
                }


                $Config = array(
                    "R" => 0, "G" => 0, "B" => 0, "Ticks" => 0
                );

                $myPicture->render("../temp_chart/graficaclicfor522" . $imagenescount . ".PNG");

                $pdf->Image('../temp_chart/graficaclicfor521' . $imagenescount . '.PNG', 17, 120, 90, 90, 'PNG');
                $pdf->Image('../temp_chart/graficaclicfor522' . $imagenescount . '.PNG', 107, 120, 90, 90, 'PNG');

                unlink("../temp_chart/graficaclicfor521" . $imagenescount . ".PNG");
                unlink("../temp_chart/graficaclicfor522" . $imagenescount . ".PNG");

                $pdf->Image('../informe/fpdf/Imagenes/PuntoTriangular.PNG', 140, 209, 3, 3, 'PNG');
                $pdf->Image('fpdf/Imagenes/punto.PNG', 115, 209, 8, 3, 'PNG');

                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetXY(115, 207);
                $pdf->Cell(70, 8, 'Resultado           Media de comparación', 1, 0, "C", FALSE);


                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(255, 255, 255);
                $pdf->SetXY(20, 225);
                $pdf->SetFillColor(28, 80, 189);
                $pdf->Cell(35, 8, 'valor', 1, 0, "C", TRUE);
                $pdf->Cell(35, 8, 'entre +/- 2', 1, 0, "C", TRUE);
                $pdf->Cell(35, 8, 'entre +/- 2 y +/- 3', 1, 0, "C", TRUE);
                $pdf->Cell(35, 8, 'mayor +/- 3', 1, 0, "C", TRUE);
                $pdf->Cell(35, 8, 'Total', 1, 0, "C", TRUE);

                $pdf->SetFont('Arial', '', 7);
                $pdf->SetXY(20, 233);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(35, 8, "Valoración Z-score por sede", 1, 0, "C", FALSE);
                $pdf->SetFillColor(150, 255, 150);
                $pdf->Cell(35, 8, $zverde, 1, 0, "C", TRUE);
                $pdf->SetFillColor(255, 255, 150);
                $pdf->Cell(35, 8, $zamarillo, 1, 0, "C", TRUE);
                $pdf->SetFillColor(255, 150, 150);
                $pdf->Cell(35, 8, $zrojo, 1, 0, "C", TRUE);
                $pdf->SetFillColor(225, 225, 225);
                $pdf->Cell(35, 8, $zscoregraficapor, 1, 0, "C", TRUE);

                $pdf->SetFont('Arial', '', 9);
                $pdf->SetXY(20, 241);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(35, 8, 'Porcentaje', 1, 0, "C", FALSE);
                $pdf->SetFillColor(150, 255, 150);
                $pdf->Cell(35, 8, round(($zverde * 100 / $zscoregraficapor), 2) . '%', 1, 0, "C", TRUE);
                $pdf->SetFillColor(255, 255, 150);
                $pdf->Cell(35, 8, round(($zamarillo * 100 / $zscoregraficapor), 2) . '%', 1, 0, "C", TRUE);
                $pdf->SetFillColor(255, 150, 150);
                $pdf->Cell(35, 8, round(($zrojo * 100 / $zscoregraficapor), 2) . '%', 1, 0, "C", TRUE);
                $pdf->SetFillColor(225, 225, 225);
                $pdf->Cell(35, 8, '100%', 1, 0, "C", TRUE);

                $zverde = 0;
                $zamarillo = 0;
                $zrojo = 0;

                $pdf->SetFont('Arial', '', 10);

                $pdf->AddPage("P", "letter");
                $pdf->Sety(29.33);
                $pdf->SetX(13);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, 10, 'Analito :', 0, 0, "L");
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(150, 10, $qryData['nombre_analito'], 0, 0, "L");
                $pdf->ln();

                $pdf->Sety(39.33);
                $pdf->SetX(13);
                $pdf->SetFont('Arial', '', 6);
                $subind = 0;
                $pdf->SetFillColor(200, 215, 240);
                $pdf->Cell(7, 10, 'IT', 1, 0, "C", true);
                $pdf->Cell(17, 10, '# laboratorio', 1, 0, "C", true);
                $pdf->MultiCell(55, 10, 'Sede', 1, "C", true);
                $pdf->SetXY(92, 39.33);
                $pdf->Cell(8, 10, 'año', 1, 0, "C", true);
                $pdf->Cell(15, 10, 'mes', 1, 0, "C", true);
                $pdf->Cell(35, 10, 'instrumento', 1, 0, "C", true);
                $pdf->Cell(12, 10, 'resultado', 1, 0, "C", true);
                $pdf->Cell(12, 10, 'unidad', 1, 0, "C", true);
                $pdf->MultiCell(20, 5, 'Media de comparación', 1, "C", true);
                $pdf->SetXY(194, 39.33);
                $pdf->Cell(10, 10, 'Zscore', 1, 0, "C", true);
                $pdf->ln();
            }
            $analito = $qryData['nombre_analito'];
        }
        if (($subind % 2) == 0) {
            $pdf->SetFillColor(255, 255, 255);
        } else {
            $pdf->SetFillColor(255, 255, 255);
        }

        $pdf->SetX(13);

        $zscore = round((floatval($qryData['valor_resultado']) - floatval($qryData['media_estandar'])) / floatval($qryData['desviacion_estandar']), 2);

        switch ($qryData['fechames']) {
            case '1':
                $mes = "ENERO";
                break;
            case '2':
                $mes = "FEBRERO";
                break;
            case '3':
                $mes = "MARZO";
                break;
            case '4':
                $mes = "ABRIL";
                break;
            case '5':
                $mes = "MAYO";
                break;
            case '6':
                $mes = "JUNIO";
                break;
            case '7':
                $mes = "JULIO";
                break;
            case '8':
                $mes = "AGOSTO";
                break;
            case '9':
                $mes = "SEPTIEMBRE";
                break;
            case '10':
                $mes = "OCTUBRE";
                break;
            case '11':
                $mes = "NOVIEMBRE";
                break;
            case '12':
                $mes = "DICIEMBRE";
                break;
            default:
                $mes = "Sin especificar";
                break;
        }

        if ($zscore > -2 && $zscore < 2) {
            $zverde++;
            array_push($colorFondo, $pdf->verde);
        } elseif ($zscore > -3 && $zscore < 3) {
            $zamarillo++;
            array_push($colorFondo, $pdf->amarillo);
        } else {
            $zrojo++;
            array_push($colorFondo, $pdf->rojo);
        }

        $pdf->SetWidths_dos(array(7, 17, 55, 8, 15, 35, 12, 12, 20, 10));
        $pdf->SetFillColorsRow($colorFondo);
        $pdf->RowPersonalizado(array($i, $qryData['no_laboratorio'], $qryData['nombre_laboratorio'], $qryData['fechaano'], $mes, $qryData['nombre_analizador'], $qryData['valor_resultado'], $qryData['nombre_unidad'], $qryData['media_estandar'],  $zscore));

        $zscoregrafica[] = floatval($zscore);

        $resultado[] = floatval($qryData['valor_resultado']);
        $media[] = floatval($qryData['media_estandar']);
        $pdf->ln();
        $subind++;

        $validacionrepetidos = false;
        foreach ($laboratorios as $idlab) {
            if ($idlab == $qryData['id_laboratorio']) {
                $validacionrepetidos = true;
                break;
            }
        }
        if ($validacionrepetidos == false) {
            $laboratorios[] = $qryData['id_laboratorio'];
        }
    }

    $lab = '';
    foreach ($laboratorios as $idlab) {
        $labdata = mysql_fetch_array(mysql_query("SELECT * FROM laboratorio 
            INNER JOIN ciudad ON ciudad.id_ciudad = laboratorio.id_ciudad
            WHERE laboratorio.id_laboratorio = '" . $idlab . "'"));
        $lab .= ' ' . $labdata['no_laboratorio'] . ' ' . $labdata['nombre_laboratorio'] . ' ' . $labdata['nombre_ciudad'] . '. ';
    }
    $laboratorios = array();
    $pdf->SetFont('Arial', '', 1);
    $pdf->Cell(180, 3, '', 0, 0, "C", FALSE);
    $pdf->ln();
    $pdf->SetFillColor(150, 255, 150);
    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetX(40);
    $pdf->Cell(45, 3, 'Satisfactorio', 'LTR', 0, "C", TRUE);
    $pdf->SetFillColor(255, 255, 150);
    $pdf->Cell(52, 3, 'Alarma', 'LTR', 0, "C", TRUE);
    $pdf->SetFillColor(255, 150, 150);
    $pdf->Cell(62, 3, 'No satisfactorio', 'LTR', 0, "C", TRUE);
    $pdf->SetFont('Arial', '', 7);
    $pdf->ln();
    $pdf->SetFillColor(150, 255, 150);
    $pdf->SetX(40);
    $pdf->Cell(45, 3, 'Si su resultado esta etre +/- 2 Z-score', 'LRB', 0, "C", TRUE);
    $pdf->SetFillColor(255, 255, 150);
    $pdf->Cell(52, 3, 'Si su resultado esta entre +/- 2 y +/- 3 Z-score', 'LRB', 0, "C", TRUE);
    $pdf->SetFillColor(255, 150, 150);
    $pdf->Cell(62, 3, 'Si su resultado es mayor a +/- 3 Z-score', 'LRB', 0, "C", TRUE);


    $pdf->Ln(30);


    if ($pdf->GetY() > 155) {
        $pdf->AddPage("P", "letter");
    }


    $yData = $zscoregrafica;
    $zscoregraficapor = sizeof($zscoregrafica);
    $zscoregrafica = array();
    $xData = array();
    for ($x = 0; $x < sizeof($yData); $x++) {
        $xData[$x] = (rand(1, 1100)) / 100;
    }
    $max = 11;

    for ($x = 0; $x < sizeof($yData); $x++) {
        if ($yData[$x] > 7) {
            $yData[$x] = "+7";
        }
    }
    for ($x = 0; $x < sizeof($yData); $x++) {
        if ($yData[$x] < (-7)) {
            $yData[$x] = "-7";
        }
    }

    $myDataChart = new pData();

    $myDataChart->AddPoints($xData, 'Serie1');
    $myDataChart->AddPoints($yData, 'Serie2');

    $myDataChart->setSerieOnAxis("Serie1", 0);
    $myDataChart->setAxisXY(0, AXIS_X);
    $myDataChart->setAxisPosition(0, AXIS_POSITION_BOTTOM);

    $myDataChart->setSerieOnAxis("Serie2", 1);
    $myDataChart->setAxisXY(1, AXIS_Y);
    $myDataChart->setAxisPosition(1, AXIS_POSITION_LEFT);

    $myDataChart->setAxisColor(0, array("R" => 255, "G" => 255, "B" => 255));
    $myDataChart->setPalette(array("Serie2", "Serie1"), $serieSettings);

    $myDataChart->setScatterSerie("Serie1", "Serie2", 0);
    $myPicture = new pImage($chartWidth, ($chartHeight + 30), $myDataChart);

    $myPicture->setGraphArea(50, 50, ($chartWidth - 25), ($chartHeight  - 40));

    $myPicture->setFontProperties(array("FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartLabelFontSize));
    $TextSettings = array(
        "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0
    );
    $graficacount++;
    $myPicture->drawText(number_format($chartWidth / 2, 0), 25, "Gráfica " . $graficacount . " Z-score", $TextSettings);
    $TextSettings = array(
        "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0, "Angle" => 90
    );
    $myPicture->drawText(10, number_format($chartHeight / 2, 0), "Z-score", $TextSettings);
    $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotFontSize));

    $myScatter = new pScatter($myPicture, $myDataChart);
    $myDataChart->setScatterSerieShape(0, SERIE_SHAPE_FILLEDCIRCLE);

    $scaleSettings = array(
        "Pos" => SCALE_POS_LEFTRIGHT, "Mode" => SCALE_MODE_MANUAL, "ManualScale" => array(0 => array("Min" => 0, "Max" => ($max + 1), "Rows" => 6), 1 => array("Min" => -7, "Max" => 7)), "GridR" => 0, "GridG" => 0, "GridB" => 0, "GridAlpha" => 50, "TickR" => 0, "TickG" => 0, "TickB" => 0, "TickAlpha" => 50, "DrawXLines" => false, "DrawYLines" => false, "DrawSubTicks" => FALSE, "SubTickR" => 0, "SubTickG" => 0, "SubTickB" => 0, "SubTickAlpha" => 50
    );

    $myScatter->drawScatterScale($scaleSettings);

    $Config = array(
        "R" => 0, "G" => 0, "B" => 0, "Alpha" => 100, "AxisID" => 0, "Ticks" => 0
    );

    $myScatter->drawScatterThreshold(0, $Config);

    $Config = array(
        "DisplayValues" => TRUE, "PlotSize" => 5, "PlotBorder" => 0, "BorderSize" => 0
    );

    $myScatter->drawScatterPlotChart($Config);

    $myScatter->drawScatterThresholdArea(0, 2, array("AxisID" => 1, "R" => 219, "G" => 237, "B" => 219, "Alpha" => 50));
    $myScatter->drawScatterThresholdArea(0, -2, array("AxisID" => 1, "R" => 219, "G" => 237, "B" => 219, "Alpha" => 50));
    $myScatter->drawScatterThresholdArea(2, 3, array("AxisID" => 1, "R" => 255, "G" => 255, "B" => 219, "Alpha" => 50));
    $myScatter->drawScatterThresholdArea(-2, -3, array("AxisID" => 1, "R" => 255, "G" => 255, "B" => 219, "Alpha" => 50));
    $myScatter->drawScatterThresholdArea(3, 7, array("AxisID" => 1, "R" => 255, "G" => 219, "B" => 219, "Alpha" => 50));
    $myScatter->drawScatterThresholdArea(-3, -7, array("AxisID" => 1, "R" => 255, "G" => 219, "B" => 219, "Alpha" => 50));

    $myPicture->drawLine(50, (($chartHeight / 2) + 5), ($chartWidth - 20), (($chartHeight / 2) + 5), $Config); //(x1,y1,x2,y2)

    $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotLabelFontSize));

    $tempSum = 0;

    $Config = array(
        "R" => 0, "G" => 0, "B" => 0, "Ticks" => 0
    );


    $imagenescount++;
    $myPicture->render("../temp_chart/graficaclicfor521" . $imagenescount . ".PNG");

    $yDataM = $resultado;
    $resultado1 = $resultado;
    $resultado = array();
    $yDataR = $media;
    $media1 = $media;
    $media = array();
    $xData = array();
    for ($x = 0; $x < sizeof($yDataR); $x++) {
        $xData[$x] = $x + 1;
    }
    $max = sizeof($yDataR);
    $maxy = 0;
    $miny = 0;

    for ($x = 0; $x < sizeof($yDataR); $x++) {
        if ($maxy < $yDataR[$x]) {
            $maxy  = $yDataR[$x];
        }
    }
    for ($x = 0; $x < sizeof($yDataR); $x++) {
        if ($miny > $yDataR[$x]) {
            $miny = $yDataR[$x];
        }
    }

    for ($x = 0; $x < sizeof($yDataM); $x++) {
        if ($maxy < $yDataM[$x]) {
            $maxy = $yDataM[$x];
        }
    }
    for ($x = 0; $x < sizeof($yDataM); $x++) {
        if ($miny > $yDataM[$x]) {
            $miny = $yDataM[$x];
        }
    }

    // *********************************************************************************

    $myDataChart = new pData();


    $myDataChart->AddPoints($xData, 'Serie1');
    $myDataChart->AddPoints($yDataM, 'Serie2');

    $myDataChart->AddPoints($xData, 'Serie3');
    $myDataChart->AddPoints($yDataR, 'Serie4');


    $myDataChart->setSerieOnAxis(array("Serie1", "Serie3"), 0);
    $myDataChart->setAxisXY(0, AXIS_X);
    $myDataChart->setAxisPosition(0, AXIS_POSITION_BOTTOM);

    $myDataChart->setSerieOnAxis(array("Serie2", "Serie4"), 1);
    $myDataChart->setAxisXY(1, AXIS_Y);
    $myDataChart->setAxisPosition(1, AXIS_POSITION_LEFT);
    $myDataChart->setAxisColor(0, array("R" => 255, "G" => 255, "B" => 255));

    $myDataChart->setPalette(array("Serie2", "Serie1", "Serie3", "Serie4"), $serieSettings);

    $myDataChart->setScatterSerie("Serie1", "Serie2", 0);
    $myDataChart->setScatterSerie("Serie3", "Serie4", 1);
    $myPicture = new pImage($chartWidth, ($chartHeight + 30), $myDataChart);

    $myPicture->setGraphArea(50, 50, ($chartWidth - 25), ($chartHeight  - 40));

    $myPicture->setFontProperties(array("FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartLabelFontSize));
    $TextSettings = array(
        "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0
    );
    $graficacount++;
    $myPicture->drawText(number_format($chartWidth / 2, 0), 25, "Gráfica " . $graficacount . " Resultado VS Media de comparación", $TextSettings);
    $TextSettings = array(
        "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0, "Angle" => 90
    );
    $myPicture->drawText(10, number_format($chartHeight / 2, 0), "", $TextSettings);
    $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotFontSize));


    $myDataChart->setScatterSerieDescription(0, "Serie1");
    $myDataChart->setScatterSerieDescription(1, "Serie3");
    $myDataChart->setScatterSerieColor(1, array("R" => 0, "G" => 100, "B" => 0));
    $myDataChart->setScatterSerieShape(1, SERIE_SHAPE_TRIANGLE);


    $myScatter = new pScatter($myPicture, $myDataChart);

    $scaleSettings = array(
        "ManualScale" => array(0 => array("Min" => 0, "Max" => ($max + 2), "Rows" => 6), 1 => array("Min" => ($miny - 5), "Max" => ($maxy + 5))), "GridR" => 0, "GridG" => 0, "GridB" => 0, "GridAlpha" => 50, "TickR" => 0, "TickG" => 0, "TickB" => 0, "TickAlpha" => 50, "DrawXLines" => FALSE, "DrawYLines" => ALL, "DrawSubTicks" => FALSE, "SubTickR" => 0, "SubTickG" => 0, "SubTickB" => 0, "SubTickAlpha" => 50
    );

    $myScatter->drawScatterScale($scaleSettings);


    $Config = array(
        "R" => 0, "G" => 0, "B" => 0, "Alpha" => 100, "AxisID" => 0, "Ticks" => 0
    );

    $Config = array(
        "DisplayValues" => TRUE, "PlotSize" => 5, "PlotBorder" => 0, "BorderSize" => 0
    );

    $myScatter->drawScatterPlotChart($Config);
    $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotLabelFontSize));

    $tempSum = 0;

    for ($x = 0; $x < sizeof($xData); $x++) {
        if ($xData[$x] != "" && $yData[$x] != "") {
            $tempSum++;
        }
    }

    $Config = array(
        "R" => 0, "G" => 0, "B" => 0, "Ticks" => 0
    );



    $myPicture->render("../temp_chart/graficaclicfor522" . $imagenescount . ".PNG");

    $MyData = new pData();
    $MyData->addPoints(array(VOID, ($zverde * 100 / $zscoregraficapor), VOID, VOID, VOID), "Probe 1");
    $MyData->setPalette("Probe 1", array("R" => 150, "G" => 255, "B" => 150, "Alpha" => 100));
    $MyData->addPoints(array(VOID, VOID, ($zamarillo * 100  / $zscoregraficapor), VOID, VOID), "Probe 2");
    $MyData->setPalette("Probe 2", array("R" => 255, "G" => 255, "B" => 150, "Alpha" => 100));
    $MyData->addPoints(array(VOID, VOID, VOID, ($zrojo * 100  / $zscoregraficapor), VOID), "Probe 3");
    $MyData->setPalette("Probe 3", array("R" => 255, "G" => 150, "B" => 150, "Alpha" => 100));
    $MyData->addPoints(array(VOID, "entre +/- 2", "entre +/- 2 y +/- 3", "mayor +/- 3", VOID), "Labels");
    $MyData->setSerieDescription("Labels", "Months");
    $MyData->setAbscissa("Labels");

    $myPicture = new pImage($chartWidth, ($chartHeight  + 30), $MyData);

    $myPicture->setGraphArea(50, 50, ($chartWidth - 25), ($chartHeight  - 40));

    $myPicture->setFontProperties(array("FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartLabelFontSize));
    $TextSettings = array(
        "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0
    );
    $graficacount++;
    $myPicture->drawText(number_format($chartWidth / 2, 0), 25, "Gráfica " . $graficacount . " Porcentaje Z-score", $TextSettings);
    $TextSettings = array(
        "Align" => TEXT_ALIGN_MIDDLEMIDDLE, "R" => 0, "G" => 0, "B" => 0, "Angle" => 90
    );
    $myPicture->drawText(10, number_format($chartHeight / 2, 0), "Porcentaje %", $TextSettings);
    $myPicture->setFontProperties(array("R" => 0, "G" => 0, "B" => 0, "FontName" => "../pchart/fonts/calibri.ttf", "FontSize" => $chartPlotFontSize));
    $myPicture->drawScale(array("DrawSubTicks" => TRUE));
    $myPicture->setFontProperties(array("FontName" => "../fonts/pf_arma_five.ttf", "FontSize" => 6));
    $myPicture->drawBarChart(array("DisplayValues" => TRUE, "DisplayColor" => DISPLAY_AUTO, "Rounded" => TRUE, "Surrounding" => 60));

    $myPicture->render("../temp_chart/graficaclicfor523" . $imagenescount . ".PNG");

    $pdf->Image('../temp_chart/graficaclicfor521' . $imagenescount . '.PNG', 17, 120, 90, 90, 'PNG');
    $pdf->Image('../temp_chart/graficaclicfor522' . $imagenescount . '.PNG', 107, 120, 90, 90, 'PNG');

    unlink("../temp_chart/graficaclicfor521" . $imagenescount . ".PNG");
    unlink("../temp_chart/graficaclicfor522" . $imagenescount . ".PNG");
    unlink("../temp_chart/graficaclicfor523" . $imagenescount . ".PNG");

    $pdf->Image('../informe/fpdf/Imagenes/PuntoTriangular.PNG', 140, 209, 3, 3, 'PNG');
    $pdf->Image('fpdf/Imagenes/punto.PNG', 115, 209, 8, 3, 'PNG');

    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetXY(115, 207);
    $pdf->Cell(70, 8, 'Resultado           Media de comparación', 1, 0, "C", FALSE);


    $pdf->SetFont('Arial', '', 9);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->SetXY(20, 225);
    $pdf->SetFillColor(28, 80, 189);
    $pdf->Cell(35, 8, 'valor', 1, 0, "C", TRUE);
    $pdf->Cell(35, 8, 'entre +/- 2', 1, 0, "C", TRUE);
    $pdf->Cell(35, 8, 'entre +/- 2 y +/- 3', 1, 0, "C", TRUE);
    $pdf->Cell(35, 8, 'mayor +/- 3', 1, 0, "C", TRUE);
    $pdf->Cell(35, 8, 'Total', 1, 0, "C", TRUE);

    $pdf->SetFont('Arial', '', 7);
    $pdf->SetXY(20, 233);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35, 8, "Valoración Z-score por sede", 1, 0, "C", FALSE);
    $pdf->SetFillColor(150, 255, 150);
    $pdf->Cell(35, 8, $zverde, 1, 0, "C", TRUE);
    $pdf->SetFillColor(255, 255, 150);
    $pdf->Cell(35, 8, $zamarillo, 1, 0, "C", TRUE);
    $pdf->SetFillColor(255, 150, 150);
    $pdf->Cell(35, 8, $zrojo, 1, 0, "C", TRUE);
    $pdf->SetFillColor(225, 225, 225);
    $pdf->Cell(35, 8, $zscoregraficapor, 1, 0, "C", TRUE);


    $pdf->SetFont('Arial', '', 9);
    $pdf->SetXY(20, 241);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(35, 8, 'Porcentaje', 1, 0, "C", FALSE);
    $pdf->SetFillColor(150, 255, 150);
    $pdf->Cell(35, 8, round(($zverde * 100 / $zscoregraficapor), 2) . '%', 1, 0, "C", TRUE);
    $pdf->SetFillColor(255, 255, 150);
    $pdf->Cell(35, 8, round(($zamarillo * 100 / $zscoregraficapor), 2) . '%', 1, 0, "C", TRUE);
    $pdf->SetFillColor(255, 150, 150);
    $pdf->Cell(35, 8, round(($zrojo * 100 / $zscoregraficapor), 2) . '%', 1, 0, "C", TRUE);
    $pdf->SetFillColor(225, 225, 225);
    $pdf->Cell(35, 8, '100%', 1, 0, "C", TRUE);

    $zverde = 0;
    $zamarillo = 0;
    $zrojo = 0;
    $pdf->SetFont('Arial', '', 10);

    $pdf->Output();
} else {
    echo "Información insuficiente para la generación del reporte...";
}
