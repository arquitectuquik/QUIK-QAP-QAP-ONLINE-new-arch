<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}

	session_start();
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('Access-Control-Allow-Headers: X-Requested-With');	
	include_once"php/verifica_sesion.php";
	
	actionRestriction_102();
	
	include("php/pchart/class/pData.class.php");
	include("php/pchart/class/pDraw.class.php");
	include("php/pchart/class/pImage.class.php");
	include("php/pchart/class/pScatter.class.php");
	include("php/pchart/class/pPie.class.php");

	$header = $_POST['header'];
	
	$chartWidth = 550;
	$chartHeight = 350;
	$chartLabelFontSize = 16;
	$chartPlotFontSize = 15;
	$chartPlotLabelFontSize = 12;
	
	
	switch ($header) {
		//case 'chart1':
		//
		//	$filename = $_POST['chartvalues1'];
		//	$xData = explode('|',$_POST['chartvalues2']);
		//	$pointData = explode('|', $_POST['chartvalues3']);
		//	
		//	for ($x = 0; $x < sizeof($pointData); $x++) {
		//		if ($pointData[$x] > 4) {
		//			$pointData[$x] = "+4";
		//		}
		//	}
		//	for ($x = 0; $x < sizeof($pointData); $x++) {
		//		if ($pointData[$x] < (-4)) {
		//			$pointData[$x] = "-4";
		//		}
		//	}
		//	
		//	$myData = new pData();
		//	for ($x = 0; $x < sizeof($pointData); $x++) {
		//		if ($pointData[$x] == "") {
		//			$myData->addPoints(VOID,"Serie1");
		//		} else {
		//			$myData->addPoints($pointData[$x],"Serie1");
		//		}
		//	}
		//	
		//	$myData->setSerieOnAxis("Serie1",0);
		//	
		//	$myData->addPoints($xData,"Absissa");
		//	$myData->setAbscissa("Absissa");
		//	
		//	$serieSettings = array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>100);
		//	$myData->setPalette("Serie1",$serieSettings);			
		//	
		//	$myData->setAxisPosition(0,AXIS_POSITION_LEFT);
		//	
		//	$myPicture = new pImage($chartWidth,$chartHeight,$myData);
		//	
		//	$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartLabelFontSize));
		//	$TextSettings = array(
		//		"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
		//		, "R"=>0
		//		, "G"=>0
		//		, "B"=>0
		//	);
		//	$myPicture->drawText(number_format($chartWidth / 2,0),25,"Gráfica Z-score vs No. m",$TextSettings); //total width / 2
		//	
		//	$myPicture->setShadow(FALSE);
		//	$myPicture->setGraphArea(50,50,($chartWidth - 25),($chartHeight  - 40)); //-25, 40
		//	$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotFontSize));			
		//	
		//	$Settings = array(
		//		"Pos"=>SCALE_POS_LEFTRIGHT
		//		, "Mode"=>SCALE_MODE_MANUAL
		//		, "ManualScale" => array(0=>array("Min"=>-4,"Max"=>4))
		//		, "Factors"=>array(1)
		//		, "GridR"=>255
		//		, "GridG"=>255
		//		, "GridB"=>255
		//		, "GridAlpha"=>50
		//		, "TickR"=>0
		//		, "TickG"=>0
		//		, "TickB"=>0
		//		, "TickAlpha"=>50
		//		, "DrawXLines"=>ALL
		//		, "DrawYLines"=>ALL				
		//		, "DrawSubTicks"=>1
		//		, "SubTickR"=>0
		//		, "SubTickG"=>0
		//		, "SubTickB"=>0
		//		, "SubTickAlpha"=>50
		//	);
		//	$myPicture->drawScale($Settings);
		//	
		//	$myPicture->drawThresholdArea(0,2,array("R"=>219,"G"=>237,"B"=>219,"Alpha"=>50,"NoMargin"=>TRUE));
		//	$myPicture->drawThresholdArea(0,-2,array("R"=>219,"G"=>237,"B"=>219,"Alpha"=>50,"NoMargin"=>TRUE));
		//	//$myPicture->drawThresholdArea(2,3,array("R"=>255,"G"=>255,"B"=>219,"Alpha"=>50,"NoMargin"=>TRUE));
		//	//$myPicture->drawThresholdArea(-2,-3,array("R"=>255,"G"=>255,"B"=>219,"Alpha"=>50,"NoMargin"=>TRUE));
		//	$myPicture->drawThresholdArea(2,4,array("R"=>255,"G"=>219,"B"=>219,"Alpha"=>50,"NoMargin"=>TRUE));
		//	$myPicture->drawThresholdArea(-2,-4,array("R"=>255,"G"=>219,"B"=>219,"Alpha"=>50,"NoMargin"=>TRUE));			
		//	
		//	$Config = array(
		//		"DisplayValues"=>TRUE
		//		, "PlotSize"=>2
		//		, "PlotBorder"=>0
		//		, "BorderSize"=>0
		//	);
		//	
		//	$myPicture->drawPlotChart($Config);
		//	
		//	$myPicture->drawLineChart(array(
		//		"DisplayValues"=>FALSE
		//		,"DisplayColor"=>DISPLAY_AUTO
		//		,"BreakVoid"=>FALSE
		//		,"VoidTicks"=>0)
		//	);
		//	
		//	$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotLabelFontSize));
		//
		//	$Config = array(
		//		"R"=>0
		//		, "G"=>0
		//		, "B"=>0
		//		, "Alpha"=>100
		//		, "AxisID"=>0
		//		, "Ticks"=>0
		//		, "NoMargin"=>TRUE
		//	);		
		//	
		//	$myPicture->drawThreshold(0,$Config);
		//	
		//	$myPicture->render("php/temp_chart/".$filename.".jpg");	
		//	
		//break;
		
		case 'chart1':
            // Define los datos para el diagrama de kernel
            $data = array(
                array("nombre" => "Módulo A", "tipo" => "Módulo", "tiempo" => 2),
                array("nombre" => "Módulo B", "tipo" => "Módulo", "tiempo" => 3),
                array("nombre" => "Módulo C", "tipo" => "Módulo", "tiempo" => 1),
                array("nombre" => "Módulo D", "tipo" => "Módulo", "tiempo" => 4),
                array("nombre" => "Proceso 1", "tipo" => "Proceso", "tiempo" => 2),
                array("nombre" => "Proceso 2", "tipo" => "Proceso", "tiempo" => 3),
                array("nombre" => "Proceso 3", "tipo" => "Proceso", "tiempo" => 1),
            );
            
            // Crea un nuevo objeto de gráfico de kernel
            $chart = new \PHPLot\Kernel\KernelGraph();
            
            // Establece el título del gráfico
            $chart->setTitle("Diagrama de Kernel");
            
            // Agrega los datos al gráfico
            $chart->addData($data);
            
            // Establece los colores de cada tipo de módulo/proceso
            $chart->setColors(array(
                "Módulo" => "#FF0000",
                "Proceso" => "#0000FF",
            ));
            
            // Dibuja el gráfico
            $chart->draw();
		
		
		
		case 'chart2':
		
			$filename = $_POST['chartvalues1'];
			$yData = explode('|',$_POST['chartvalues2']);
			$xData = explode('|',$_POST['chartvalues3']);
			$max = 0;
			
			for ($x = 0; $x < sizeof($yData); $x++) {
				if ($yData[$x] > 4) {
					$yData[$x] = "+4";
				}
			}
			for ($x = 0; $x < sizeof($yData); $x++) {
				if ($yData[$x] < (-4)) {
					$yData[$x] = "-4";
				}			
			}
        
			for ($x = 0; $x < sizeof($xData); $x++) {
				if ($xData[$x] > $max) {
					$max = $xData[$x];
				}
			}
			
			$myData = new pData();   
			
			for ($x = 0; $x < sizeof($xData); $x++) {
				if ($xData[$x] != "" && $yData[$x] != "") {
					$myData->addPoints($xData[$x],"Serie1");
				}
			}
			for ($x = 0; $x < sizeof($yData); $x++) {
				if ($xData[$x] != "" && $yData[$x] != "") {
					$myData->addPoints($yData[$x],"Serie2");
				}
			}
			
			$myData->setSerieOnAxis("Serie1",0);
			$myData->setAxisXY(0,AXIS_X); 
			$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM); 
			
			$myData->setSerieOnAxis("Serie2",1);
			$myData->addPoints($yData,"Serie2");
			$myData->setAxisXY(1,AXIS_Y); 
			$myData->setAxisPosition(1,AXIS_POSITION_LEFT);
        
			$serieSettings = array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>100);
			$myData->setPalette(array("Serie2","Serie1"),$serieSettings);				
			
			$myData->setScatterSerie("Serie1","Serie2",0);
        
			$myPicture = new pImage($chartWidth,($chartHeight + 30),$myData);
        
			$myPicture->setGraphArea(50,50,($chartWidth - 25),($chartHeight  - 40)); 
        
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartLabelFontSize)); 
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);			
			$myPicture->drawText(number_format($chartWidth / 2,0),25,"Gráfica Z-score vs concentración",$TextSettings);
			$myPicture->drawText(number_format($chartWidth / 2,0),($chartHeight + 10),"Concentración",$TextSettings);
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
				, "Angle"=>90
			);			
			$myPicture->drawText(10, number_format($chartHeight / 2,0),"Z-score",$TextSettings);
			$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotFontSize));				
			
			$myScatter = new pScatter($myPicture,$myData); 
        
			$scaleSettings = array(
				"Pos"=>SCALE_POS_LEFTRIGHT
				, "Mode"=>SCALE_MODE_MANUAL
				, "ManualScale" => array(0=>array("Min"=>0,"Max"=>($max + 5),"Rows"=>6),1=>array("Min"=>-4,"Max"=>4))
				, "GridR"=>0
				, "GridG"=>0
				, "GridB"=>0
				, "GridAlpha"=>50
				, "TickR"=>0
				, "TickG"=>0
				, "TickB"=>0
				, "TickAlpha"=>50
				, "DrawXLines"=>ALL
				, "DrawYLines"=>ALL
				, "DrawSubTicks"=>FALSE
				, "SubTickR"=>0
				, "SubTickG"=>0
				, "SubTickB"=>0
				, "SubTickAlpha"=>50
			);			
			
			$myScatter->drawScatterScale($scaleSettings); 
			
			$Config = array(
				"R"=>0
				, "G"=>0
				, "B"=>0
				, "Alpha"=>100
				, "AxisID"=>0
				, "Ticks"=>0
			);
			
			$myScatter->drawScatterThreshold(0,$Config);			
			
			$Config = array(
				"DisplayValues"=>TRUE
				, "PlotSize"=>2
				, "PlotBorder"=>0
				, "BorderSize"=>0
			);			 			
			
			$myScatter->drawScatterPlotChart($Config); 
        
			$myScatter->drawScatterThresholdArea(0,2,array("AxisID"=>1,"R"=>219,"G"=>237,"B"=>219,"Alpha"=>50));
			$myScatter->drawScatterThresholdArea(0,-2,array("AxisID"=>1,"R"=>219,"G"=>237,"B"=>219,"Alpha"=>50));
			$myScatter->drawScatterThresholdArea(2,3,array("AxisID"=>1,"R"=>255,"G"=>255,"B"=>219,"Alpha"=>50));
			$myScatter->drawScatterThresholdArea(-2,-3,array("AxisID"=>1,"R"=>255,"G"=>255,"B"=>219,"Alpha"=>50));
			$myScatter->drawScatterThresholdArea(3,4,array("AxisID"=>1,"R"=>255,"G"=>219,"B"=>219,"Alpha"=>50));
			$myScatter->drawScatterThresholdArea(-3,-4,array("AxisID"=>1,"R"=>255,"G"=>219,"B"=>219,"Alpha"=>50));		
			
			$myPicture->drawLine(50,(($chartHeight / 2) + 5),($chartWidth - 20),(($chartHeight / 2) + 5),$Config); //(x1,y1,x2,y2)
			
			$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotLabelFontSize));
			
			$tempSum = 0;
			
			for ($x = 0; $x < sizeof($xData); $x++) {
				if ($xData[$x] != "" && $yData[$x] != "") {
					$LabelSettings = array(
						"NoTitle"=>TRUE
						,"ForceLabels"=>"MX ".($x + 1)
						,"TitleR"=>0
						,"TitleG"=>0
						,"TitleB"=>0
						,"DrawPoint"=>LABEL_POINT_CIRCLE
						,"DrawSerieColor"=>FALSE
						,"TitleMode"=>LABEL_TITLE_NOBACKGROUND
					);
					$myData->setScatterSerieDescription(0,"Serie1");
					$myScatter->writeScatterLabel(0,$tempSum,$LabelSettings,"m".($x + 1)." (".$xData[$x].")");
					$tempSum++;
				}	
			}		
			
			$Config = array(
				"R"=>0
				, "G"=>0
				, "B"=>0
				, "Ticks"=>0
			);
			
				
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");
			
		break;
		case 'chart3':
			
			$filename = $_POST['chartvalues1'];
			$xData =  explode('|', $_POST['chartvalues2']);
			$pointData = explode('|', $_POST['chartvalues3']);			
			
			$MyData = new pData();
			for ($x = 0; $x < sizeof($pointData); $x++) {
				if ($pointData[$x] == "") {
					$MyData->addPoints(VOID,"Serie1");
				} else {
					if ($pointData[$x] > 100) {
						$MyData->addPoints("+100*","Serie1");
					} else if ($pointData[$x] < (-100)) {
						$MyData->addPoints("-100*","Serie1");
					} else {
						$MyData->addPoints($pointData[$x],"Serie1");
					}
					
				}
			}
			for ($x = 0; $x < sizeof($xData); $x++) {
				$MyData->addPoints("Muestra ".$xData[$x],"Absissa");
			}			
        
			$MyData->setAbscissa("Absissa"); 
			
			$myPicture = new pImage($chartWidth,$chartHeight,$MyData); 
			
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartLabelFontSize));
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);
			$myPicture->drawText(number_format($chartWidth / 2,0),25,"Gráfica desviación porcentual permitida",$TextSettings); //total width / 2			
			
			$myPicture->setGraphArea(50,50,($chartWidth - 25),($chartHeight  - 40));
			
			$Settings = array(
				"Pos"=>SCALE_POS_TOPBOTTOM
				, "Mode"=>SCALE_MODE_MANUAL
				, "ManualScale" => array(0=>array("Min"=>(-100),"Max"=>100))
				, "Factors"=>array(2)
				, "GridR"=>0
				, "GridG"=>0
				, "GridB"=>0
				, "GridAlpha"=>100
				, "TickR"=>0
				, "TickG"=>0
				, "TickB"=>0
				, "TickAlpha"=>50
				, "DrawXLines"=>FALSE
				, "DrawYLines"=>ALL				
				, "DrawSubTicks"=>0
				, "SubTickR"=>0
				, "SubTickG"=>0
				, "SubTickB"=>0
				, "SubTickAlpha"=>50
			);
			$myPicture->drawScale($Settings);
			
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotFontSize)); 
			
			$tempValue = array();
			
			for ($x = 0; $x < sizeof($pointData); $x++) {
				$tempValue[$x] = array("R"=>191,"G"=>191,"B"=>191,"Alpha"=>100);
			}				
        
			$settings = array(
				"Gradient"=>TRUE
				,"DisplayPos"=>LABEL_POS_INSIDE
				,"DisplayValues"=>TRUE
				,"DisplayShadow"=>FALSE
				,"Surrounding"=>10
			);
			
			$myPicture->drawBarChart($settings); 			
			
			$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/Calibri_Bold.ttf","FontSize"=>$chartPlotLabelFontSize));			
		
			$Config = array(
				"R"=>0
				, "G"=>0
				, "B"=>0
				, "Alpha"=>100
				, "AxisID"=>0
				, "Ticks"=>0
				, "NoMargin"=>TRUE
			);		
			
			$myPicture->drawThreshold(0,$Config);			
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");				
			
		break;
		case 'chart4':

			$filename = $_POST['chartvalues1'];
			$yLimit = str_replace(',','.',$_POST['chartvalues2']);
			$xStart = $_POST['chartvalues6'];
			$xLimit = str_replace(',','.',$_POST['chartvalues3']);
			$limitValue = $_POST['chartvalues7'];
			$yData = explode('|',str_replace(',','.',$_POST['chartvalues4']));
			$xData = explode('|',$_POST['chartvalues5']);
			$labeldata = explode('|',$_POST['chartvalues8']);
			
			$xStart = number_format(((80 * $xStart) / 100),2);
			
			$yLineLimit = abs($yLimit);
// 			$yLineLimit = ($yLimit);
			
			for ($x = 0; $x < sizeof($xData); $x++) {
				if ($xData[$x] >= $xLimit) {
					$xLimit = $xData[$x];
				}
			}
			for ($x = 0; $x < sizeof($yData); $x++) {
				if (abs($yData[$x]) >= abs($yLimit)) {
					$yLimit = abs($yData[$x]);
				}
			}		
			if(round($yLimit*1.3)!=0)
			{
			    $yLimit = round($yLimit*1.3);
			} 
			else
			{
			    $yLimit = 1;
			} 
			
			$myData = new pData();   
			$myData2 = new pData();   
			
			for ($x = 0; $x < sizeof($xData); $x++) {
				if (($xData[$x] != "" && $yData[$x] != "")) {
					$myData->addPoints($xData[$x],"Serie1");
				}
			}
			for ($x = 0; $x < sizeof($yData); $x++) {
				if (($xData[$x] != "" && $yData[$x] != "")) {
					$myData->addPoints($yData[$x],"Serie2");
				}
			}			
			
			$myData2->addPoints(0,"Serie3");
			$myData2->addPoints(0,"Serie4");
			
			$myData2->addPoints(0,"Serie5");
			$myData2->addPoints(0,"Serie6");

			$myData2->addPoints($xLimit,"Serie3");
			$myData2->addPoints($xLimit,"Serie4");
			
			$myData2->addPoints($yLineLimit,"Serie5");
			$myData2->addPoints("-".$yLineLimit,"Serie6");			
			
			$myData->setSerieOnAxis("Serie1",0);
			$myData2->setSerieOnAxis("Serie3",0);
			$myData2->setSerieOnAxis("Serie4",0);
			$myData->setAxisXY(0,AXIS_X); 
			$myData2->setAxisXY(0,AXIS_X); 
			$myData->setAxisPosition(0,AXIS_POSITION_BOTTOM); 
			$myData2->setAxisPosition(0,AXIS_POSITION_BOTTOM); 
			
			$myData->setSerieOnAxis("Serie2",1);
			$myData2->setSerieOnAxis("Serie5",1);
			$myData2->setSerieOnAxis("Serie6",1);
			$myData->setAxisXY(1,AXIS_Y); 
			$myData2->setAxisXY(1,AXIS_Y); 
			$myData->setAxisPosition(1,AXIS_POSITION_LEFT);
			$myData2->setAxisPosition(1,AXIS_POSITION_LEFT);
		
			$myData->setSerieDescription("Serie1","%ETmp/APS");
			$myData->setSerieDescription("Serie2","");
		
			$serieSettings = array("R"=>0,"G"=>0,"B"=>0,"Alpha"=>100);
			
			$myData->setPalette(array("Serie2","Serie1"),$serieSettings);	
			$myData->setScatterSerie("Serie1","Serie2",0);
			
			$serieSettings = array("R"=>255,"G"=>0,"B"=>0,"Alpha"=>100);
			$myData2->setPalette(array("Serie5","Serie3"),$serieSettings);	
			$myData2->setScatterSerie("Serie3","Serie5",0);
			
			$serieSettings = array("R"=>255,"G"=>0,"B"=>0,"Alpha"=>100);
			$myData2->setPalette(array("Serie6","Serie4"),$serieSettings);
			$myData2->setScatterSerie("Serie4","Serie6",1);

			$myPicture = new pImage(($chartWidth + 95),($chartHeight+30),$myData);

			$myPicture->setGraphArea(70,50,($chartWidth - 25),($chartHeight  - 40)); 

			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartLabelFontSize)); 
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);			
			$myPicture->drawText(number_format($chartWidth / 2,0),($chartHeight+15),"Concentración",$TextSettings);

			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);

			$myPicture->drawText(number_format($chartWidth / 2,0),25,"Gráfica ETmp/APS (Diferencia VS Concentración)",$TextSettings);

			//$myPicture->drawText(number_format($chartWidth / 2,0),35,$limitValue);

			$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotFontSize));				
			
			$myScatter = new pScatter($myPicture,$myData); 
			$myScatter2 = new pScatter($myPicture,$myData2); 

			$scaleSettings = array(
				"Pos"=>SCALE_POS_LEFTRIGHT
				, "Mode"=>SCALE_MODE_MANUAL
				, "ManualScale" => array(0=>array("Min"=>$xStart,"Max"=>($xLimit)),1=>array("Min"=>"-".$yLimit,"Max"=>$yLimit))
				, "GridR"=>0
				, "GridG"=>0
				, "GridB"=>0
				, "GridAlpha"=>50
				, "TickR"=>0
				, "TickG"=>0
				, "TickB"=>0
				, "TickAlpha"=>50
				, "DrawXLines"=>FALSE
				, "DrawYLines"=>ALL
				, "DrawSubTicks"=>FALSE
				, "SubTickR"=>0
				, "SubTickG"=>0
				, "SubTickB"=>0
				, "SubTickAlpha"=>50
			);			
			
			$myScatter->drawScatterScale($scaleSettings); 
			$myScatter2->drawScatterScale($scaleSettings); 
			
			$myScatter2->drawScatterBestFit();
			
			$Config = array(
				"R"=>0
				, "G"=>0
				, "B"=>0
				, "Alpha"=>100
				, "AxisID"=>0
				, "Ticks"=>0
			);
			
			$myScatter->drawScatterThreshold(0,$Config);			
			
			$Config = array(
				"DisplayValues"=>TRUE
				, "PlotSize"=>2
				, "PlotBorder"=>0
				, "BorderSize"=>0
			);			 			
			
			$myScatter->drawScatterPlotChart($Config); 

			$Config = array(
				"DisplayValues"=>TRUE
				, "PlotSize"=>0
				, "PlotBorder"=>0
				, "BorderSize"=>0
			);	
			
			$myScatter2->drawScatterPlotChart($Config); 		
			
			$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotLabelFontSize));
			
			$Config = array(
				"R"=>0
				, "G"=>0
				, "B"=>0
				, "Ticks"=>0
			);
			$myPicture->drawLine(70,(($chartHeight / 2) + 5),($chartWidth - 20),(($chartHeight / 2) + 5),$Config); //(x1,y1,x2,y2)	
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
				, "Angle"=>90
			);			
			$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotFontSize));
			$myPicture->drawText(6, number_format($chartHeight / 2,0),"Diferencia",$TextSettings);		
			
			$tempSum = 0;
			
			for ($x = 0; $x < sizeof($xData); $x++) {
				if ($xData[$x] != "" && $yData[$x] != "") {
					$LabelSettings = array(
						"NoTitle"=>TRUE
						,"ForceLabels"=>"MX ".($x + 1)
						,"TitleR"=>0
						,"TitleG"=>0
						,"TitleB"=>0
						,"DrawPoint"=>FALSE
						,"DrawSerieColor"=>FALSE
						,"TitleMode"=>LABEL_TITLE_NOBACKGROUND
					);
					$myData->setScatterSerieDescription(0,"Serie1");
					//$myScatter->writeScatterLabel(0,$tempSum,$LabelSettings,"m".($x + 1)." (".$xData[$x].")");
					$myScatter->writeScatterLabel(0,$tempSum,$LabelSettings,$labeldata[$x]);
					$tempSum++;
				}	
			}
			
			$Config = array(
				"R"=>255
				, "G"=>0
				, "B"=>0
				, "Ticks"=>0
			);
			
			$myPicture->setFontProperties(array("R"=>0,"G"=>0,"B"=>0,"FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>$chartPlotLabelFontSize));
			$myPicture->drawLegend(($chartWidth - 10),($chartHeight / 2),array(
				"Style"=>LEGEND_NOBORDER
				,"Mode"=>LEGEND_HORIZONTAL
				,"Family"=>LEGEND_FAMILY_LINE
			));
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");
			
		break;		
		case 'chart5':
			$filename = $_POST['chartvalues1'];
			$pointData = explode("|",$_POST['chartvalues2']);
			$programtype = $_POST['programtype'];
			
			$MyData = new pData();    
			$MyData->addPoints($pointData,"ScoreA");   
			
			for ($x = 0; $x < sizeof($pointData); $x++) {
				$MyData->addPoints($pointData[$x]."%","Labels"); 
			}
			
			$MyData->setAbscissa("Labels"); 
			
			$myPicture = new pImage(468,370,$MyData);
			
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>12)); 
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);			
			$myPicture->drawText(234,25,"EVALUACIÓN CON MEDIA DE COMPARACIÓN",$TextSettings);
	
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>14));
			
			$PieChart = new pPie($myPicture,$MyData); 
			
			switch ($programtype) {
				case 1:
					$PieChart->setSliceColor(0,array("R"=>175,"G"=>255,"B"=>175));
					$PieChart->setSliceColor(1,array("R"=>255,"G"=>255,"B"=>125));
					$PieChart->setSliceColor(2,array("R"=>255,"G"=>125,"B"=>125));					
				break;
				case 2:
					$PieChart->setSliceColor(0,array("R"=>175,"G"=>255,"B"=>175));
					$PieChart->setSliceColor(1,array("R"=>255,"G"=>125,"B"=>125));					
				break;
			}

			
			$PieChart->draw2DPie(234,185,array(
				"Radius"=>120
				,"DrawLabels"=>TRUE
				,"LabelStacked"=>TRUE
				,"Border"=>TRUE
			));
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");
			
		break;
		case 'chart6':
			$filename = $_POST['chartvalues1'];
			$pointData = explode("|",$_POST['chartvalues2']);
			
			$MyData = new pData();    
			$MyData->addPoints($pointData,"ScoreA");   
			
			for ($x = 0; $x < sizeof($pointData); $x++) {
				$MyData->addPoints($pointData[$x]."%","Labels"); 
			}
			
			$MyData->setAbscissa("Labels"); 
			
			$myPicture = new pImage(468,370,$MyData);
			
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>12)); 
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);			
			$myPicture->drawText(234,25,"EVALUACIÓN CON RL-MMT-JCTLM.",$TextSettings);
	
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>14));
			
			$PieChart = new pPie($myPicture,$MyData); 
	
			$PieChart->setSliceColor(0,array("R"=>175,"G"=>255,"B"=>175));
			$PieChart->setSliceColor(1,array("R"=>255,"G"=>125,"B"=>125));	
			
			$PieChart->draw2DPie(234,185,array(
				"Radius"=>120
				,"DrawLabels"=>TRUE
				,"LabelStacked"=>TRUE
				,"Border"=>TRUE
			));
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");
			
		break;
		case 'chart7':
			$filename = $_POST['chartvalues1'];
			$pointData = explode("|",$_POST['chartvalues2']);
			
			$MyData = new pData();    
			$MyData->addPoints($pointData,"ScoreA");   
			
			for ($x = 0; $x < sizeof($pointData); $x++) {
				$MyData->addPoints($pointData[$x]."%","Labels"); 
			}
			
			$MyData->setAbscissa("Labels"); 
			
			$myPicture = new pImage(468,370,$MyData);
			
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>12)); 
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);			
			$myPicture->drawText(234,25,"ANÁLISIS FÍSICO QUÍMICO",$TextSettings);
	
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>14));
			
			$PieChart = new pPie($myPicture,$MyData); 
	
			$PieChart->setSliceColor(0,array("R"=>175,"G"=>255,"B"=>175));
			$PieChart->setSliceColor(1,array("R"=>255,"G"=>125,"B"=>125));	
			
			$PieChart->draw2DPie(234,185,array(
				"Radius"=>120
				,"DrawLabels"=>TRUE
				,"LabelStacked"=>TRUE
				,"Border"=>TRUE
			));
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");
			
		break;
		case 'chart8':
			$filename = $_POST['chartvalues1'];
			$pointData = explode("|",$_POST['chartvalues2']);
			
			$MyData = new pData();    
			$MyData->addPoints($pointData,"ScoreA");   
			
			for ($x = 0; $x < sizeof($pointData); $x++) {
				$MyData->addPoints($pointData[$x]."%","Labels"); 
			}
			
			$MyData->setAbscissa("Labels"); 
			
			$myPicture = new pImage(468,370,$MyData);
			
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>12)); 
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);			
			$myPicture->drawText(234,25,"ANÁLISIS MICROSCÓPICO",$TextSettings);
	
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>14));
			
			$PieChart = new pPie($myPicture,$MyData); 
	
			$PieChart->setSliceColor(0,array("R"=>175,"G"=>255,"B"=>175));
			$PieChart->setSliceColor(1,array("R"=>255,"G"=>125,"B"=>125));	
			
			$PieChart->draw2DPie(234,185,array(
				"Radius"=>120
				,"DrawLabels"=>TRUE
				,"LabelStacked"=>TRUE
				,"Border"=>TRUE
			));
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");
			
		break;
		case 'chart9':
			$filename = $_POST['chartvalues1'];
			$pointData = explode("|",$_POST['chartvalues2']);
			$programtype = $_POST['programtype'];
			
			$MyData = new pData();    
			$MyData->addPoints($pointData,"ScoreA");   
			
			for ($x = 0; $x < sizeof($pointData); $x++) {
				$MyData->addPoints($pointData[$x]."%","Labels"); 
			}
			
			$MyData->setAbscissa("Labels"); 
			
			$myPicture = new pImage(468,370,$MyData);
			
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>12)); 
			$TextSettings = array(
				"Align"=>TEXT_ALIGN_MIDDLEMIDDLE
				, "R"=>0
				, "G"=>0
				, "B"=>0
			);			
			$myPicture->drawText(234,25,"EVALUACIÓN PARTICIPANTES QAP",$TextSettings);
	
			$myPicture->setFontProperties(array("FontName"=>"php/pchart/fonts/calibri.ttf","FontSize"=>14));
			
			$PieChart = new pPie($myPicture,$MyData); 
			
			switch ($programtype) {
				case 1:
					$PieChart->setSliceColor(0,array("R"=>175,"G"=>255,"B"=>175));
					$PieChart->setSliceColor(1,array("R"=>255,"G"=>255,"B"=>125));
					$PieChart->setSliceColor(2,array("R"=>255,"G"=>125,"B"=>125));					
				break;
				case 2:
					$PieChart->setSliceColor(0,array("R"=>175,"G"=>255,"B"=>175));
					$PieChart->setSliceColor(1,array("R"=>255,"G"=>125,"B"=>125));					
				break;
			}

			
			$PieChart->draw2DPie(234,185,array(
				"Radius"=>120
				,"DrawLabels"=>TRUE
				,"LabelStacked"=>TRUE
				,"Border"=>TRUE
			));
			
			$myPicture->render("php/temp_chart/".$filename.".jpg");
			
		break;				
	}	
	
	mysql_close($con);
	exit;	
	
?>		