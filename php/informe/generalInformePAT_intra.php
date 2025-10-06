<?php

    // importación de la librería
    require_once("fpdf/fpdf.php");

    include("../pchart/class/pData.class.php");
    include("../pchart/class/pDraw.class.php");
    include("../pchart/class/pPie.class.php");
    include("../pchart/class/pImage.class.php");
    
    class generalInformePAT_Intra extends FPDF {
        
        var $B=0;
        var $I=0;
        var $U=0;
        var $HREF='';
        var $ALIGN='';
        var $widths;
        var $minimoResaltado = 8;
        var $aligns;
        var $con_inserto_incluido;
        var $tituloprograma;
        var $fillColorsRow;
        var $grossLineLeft;
        var $grossLineRight;

        public $azulOscuro = [61,123,162];
        public $azulClaro = [143, 181, 201];
        public $azulFondoP = [198, 213, 221];
        public $lineaDelgada = 0.1;
        public $lineaGruesa = 0.3;

        protected $outlines = array();
        protected $outlineRoot;
        public $laboratorio_pat;
        public $nombre_reto;
        public $heightRow = 5;
        
        public $sigla_programa;
        public $nombre_programa;
        public $nom_reto;

        public $verde = [149, 220, 161];
        public $rojo = [245, 134, 121];
        public $amarillo = [244, 208, 63];
        public $verdeOscuro = [118, 193, 130];
        public $amarilloOscuro = [224, 183, 45];
        public $rojoOscuro = [245, 121, 121];
        public $blanco = [255,255,255];
        public $gris = [213, 219, 222];
        public $grisClaro = [234, 237, 239];

        public $num_muestras;
        
        public $id_laboratorio_pat;
        public $id_programa_pat;
        public $id_reto_pat; 

        public $no_laboratorio;
        public $nombre_laboratorio;
        
        public $respuestas;

        public $distractoresGenerales = array();
        
        function SetWidths($w)
        {
            //Set the array of column widths
            $this->widths=$w;
        }


        function SetDistractor($nomDistractor){
            // Busca el nombre dentro del array
            $searchA = array_search($nomDistractor, $this->distractoresGenerales);
            
            if(is_numeric($searchA)){
                return ($searchA+1);
            } else {
                array_push($this->distractoresGenerales, $nomDistractor);
                return sizeof($this->distractoresGenerales);
            }
        }

        function GetDistractor($nomDistractor){
            // Busca el nombre dentro del array
            return $searchA = (array_search($nomDistractor, $this->distractoresGenerales)) + 1;
        }


        function SetHeightRow($h){
            $this->heightRow = $h;
        }

        function obtenerCriterioIHQ($id_respuesta_pat, $id_respuestas_correctas){
            if(is_numeric(array_search($id_respuesta_pat,$id_respuestas_correctas))){
                return true;
            } else {
                return false;
            }
        }


        function obtenerCriterioPQ($id_respuesta_pat, $id_respuestas_correctas){
            if(is_numeric(array_search($id_respuesta_pat,$id_respuestas_correctas))){
                return true;
            } else {
                return false;
            }
        }


        function obtenerCriterioCITLBC($valor){

            $valor = intval($valor);

            if($valor == 10){
                return 2; // verde
            } else if($valor == 5) {
                return 1; // amarillo
            } else {
                return 0; // rojo
            }
        }


        function obtenerCriterioPCM($nom_respuesta_pat, $nom_respuesta_correcta){

            $categoriaRtaCorrecta = "Indefinido";
            if($nom_respuesta_correcta == "Grado 0" || $nom_respuesta_correcta == "< 1%" || $nom_respuesta_correcta == "Sin tinción" || $nom_respuesta_correcta == "Negativo"){ // Si es negativo
                $categoriaRtaCorrecta = "Negativo";
            } else if($nom_respuesta_correcta == "Grado 1+" || $nom_respuesta_correcta == "Grado 2+" || $nom_respuesta_correcta == "Grado 3+" || $nom_respuesta_correcta == "1% - 10%" || $nom_respuesta_correcta == "11% - 50%" || $nom_respuesta_correcta == "> 50%"){ // Es positivo
                $categoriaRtaCorrecta = "Positivo";
            } else { // No identificado
                $categoriaRtaCorrecta = "Indefinido";
            }


            $categoriaRtaPatologo = "Indefinido";
            if($nom_respuesta_pat == "Grado 0" || $nom_respuesta_pat == "< 1%" || $nom_respuesta_pat == "Sin tinción" || $nom_respuesta_pat == "Negativo"){ // Si es negativo
                $categoriaRtaPatologo = "Negativo";
            } else if($nom_respuesta_pat == "Grado 1+" || $nom_respuesta_pat == "Grado 2+" || $nom_respuesta_pat == "Grado 3+" || $nom_respuesta_pat == "1% - 10%" || $nom_respuesta_pat == "11% - 50%" || $nom_respuesta_pat == "> 50%"){ // Es positivo
                $categoriaRtaPatologo = "Positivo";
            } else { // No identificado
                $categoriaRtaPatologo = "Indefinido";
            }


            if($categoriaRtaPatologo != "Indefinido" && $categoriaRtaPatologo == $categoriaRtaCorrecta){
                return true;
            } else {
                return false;
            }
        }

        function contarCoincidenciasArray($distractor, $arrayDistractores){
            $counter = 0;
            $array_temp = $arrayDistractores;

            for($sasf=0;$sasf<sizeof($array_temp); $sasf++){
                if($array_temp[$sasf] == $distractor){
                    $counter++;
                }
            }

            return $counter;
        }

        function contarNumsArray($array){
            $cont=0;
            for($w=0; $w<sizeof($array); $w++){
                $cont = $cont + $array[$w];
            }
            return $cont; 
        }

        
        function generarGraficoCITLBC($concordantes = 0, $discordanciamenor=0, $noconcordantes = 0){
            
            $fuente = "../pchart/fonts/calibri.ttf";
            $fuenteBold = "../pchart/fonts/Calibri_Bold.ttf";

            $MyData = new pData();
            $MyData->addPoints([$concordantes, $discordanciamenor, $noconcordantes],"ScoreA");  
            $MyData->setSerieDescription("ScoreA","Concordancia del diagnóstico");

            $MyData->addPoints(["Concordantes", "Discordancia menor", "No concordantes"],"Labels");
            $MyData->setAbscissa("Labels");
            
            $myPicture = new pImage(468,262,$MyData,TRUE);
            $myPicture->setFontProperties(array("FontName"=>$fuenteBold,"FontSize"=>9,"R"=>0,"G"=>0,"B"=>80));
            
            $TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE, "R"=>0, "G"=>0, "B"=>0);
            $myPicture->drawText(244,25,"Porcentaje de concordancia en el diagnóstico",$TextSettings);
            $PieChart = new pPie($myPicture,$MyData);
            
            $PieChart->setSliceColor(0,array("R"=>$this->verdeOscuro[0],"G"=>$this->verdeOscuro[1],"B"=>$this->verdeOscuro[2]));
            $PieChart->setSliceColor(1,array("R"=>$this->amarilloOscuro[0],"G"=>$this->amarilloOscuro[1],"B"=>$this->amarilloOscuro[2]));	
            $PieChart->setSliceColor(2,array("R"=>$this->rojoOscuro[0],"G"=>$this->rojoOscuro[1],"B"=>$this->rojoOscuro[2]));	
            
            $myPicture->setFontProperties(array("FontName"=>$fuente,"FontSize"=>8,"R"=>30,"G"=>30,"B"=>30));
            $PieChart->drawPieLegend(119,250,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
            
            $LabelSettings = array("TitleMode"=>LABEL_TITLE_BACKGROUND,"DrawSerieColor"=>FALSE,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255);
            $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>9));

            $PieChart->draw3DPie(244,150,array(
                "ValuePadding"=> 0,
                "Radius"=> 130,
                "WriteValues"=>TRUE,
                "DataGapAngle"=>6,
                "DataGapRadius"=>6,
                "Border"=>TRUE
            ));
            
            $ruta_image = "temp-image/".uniqid().".png";
            $myPicture->Render($ruta_image);

            return $ruta_image;
        }

        function generarGraficoIHQ($concordantes = 0, $noconcordantes = 0){
            
            $fuente = "../pchart/fonts/calibri.ttf";
            $fuenteBold = "../pchart/fonts/Calibri_Bold.ttf";

            $MyData = new pData();
            $MyData->addPoints([$concordantes,$noconcordantes],"ScoreA");  
            $MyData->setSerieDescription("ScoreA","Concordancia del diagnóstico");

            $MyData->addPoints(["Concordantes", "No concordantes"],"Labels");
            $MyData->setAbscissa("Labels");
            
            $myPicture = new pImage(468,262,$MyData,TRUE);
            $myPicture->setFontProperties(array("FontName"=>$fuenteBold,"FontSize"=>9,"R"=>0,"G"=>0,"B"=>80));
            
            $TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE, "R"=>0, "G"=>0, "B"=>0);
            $myPicture->drawText(244,25,"Porcentaje de concordancia en el diagnóstico",$TextSettings);
            $PieChart = new pPie($myPicture,$MyData);
 
            $PieChart->setSliceColor(0,array("R"=>$this->verdeOscuro[0],"G"=>$this->verdeOscuro[1],"B"=>$this->verdeOscuro[2]));
            $PieChart->setSliceColor(1,array("R"=>$this->rojoOscuro[0],"G"=>$this->rojoOscuro[1],"B"=>$this->rojoOscuro[2]));	
            
            $myPicture->setFontProperties(array("FontName"=>$fuente,"FontSize"=>8,"R"=>30,"G"=>30,"B"=>30));
            $PieChart->drawPieLegend(167,250,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
            
            $LabelSettings = array("TitleMode"=>LABEL_TITLE_BACKGROUND,"DrawSerieColor"=>FALSE,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255);
            
            $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>9));

            $PieChart->draw3DPie(244,150,array(
                "ValuePadding"=> 0,
                "Radius"=> 130,
                "WriteValues"=>TRUE,
                "DataGapAngle"=>6,
                "DataGapRadius"=>6,
                "Border"=>TRUE
            ));

            $ruta_image = "temp-image/".uniqid().".png";
            $myPicture->Render($ruta_image);

            return $ruta_image;
        }


        function generarGraficoPQ($concordantes = 0, $noconcordantes = 0){
            
            $fuente = "../pchart/fonts/calibri.ttf";
            $fuenteBold = "../pchart/fonts/Calibri_Bold.ttf";

            $MyData = new pData();
            $MyData->addPoints([$concordantes,$noconcordantes],"ScoreA");  
            $MyData->setSerieDescription("ScoreA","Concordancia del diagnóstico");

            $MyData->addPoints(["Concordantes", "No concordantes"],"Labels");
            $MyData->setAbscissa("Labels");
            
            $myPicture = new pImage(468,262,$MyData,TRUE);
            $myPicture->setFontProperties(array("FontName"=>$fuenteBold,"FontSize"=>9,"R"=>0,"G"=>0,"B"=>80));
            
            $TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE, "R"=>0, "G"=>0, "B"=>0);
            $myPicture->drawText(244,25,"Porcentaje de concordancia en el diagnóstico",$TextSettings);
            $PieChart = new pPie($myPicture,$MyData);
 
            $PieChart->setSliceColor(0,array("R"=>$this->verdeOscuro[0],"G"=>$this->verdeOscuro[1],"B"=>$this->verdeOscuro[2]));
            $PieChart->setSliceColor(1,array("R"=>$this->rojoOscuro[0],"G"=>$this->rojoOscuro[1],"B"=>$this->rojoOscuro[2]));	
            
            $myPicture->setFontProperties(array("FontName"=>$fuente,"FontSize"=>8,"R"=>30,"G"=>30,"B"=>30));
            $PieChart->drawPieLegend(167,250,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
            
            $LabelSettings = array("TitleMode"=>LABEL_TITLE_BACKGROUND,"DrawSerieColor"=>FALSE,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255);
            
            $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>9));

            $PieChart->draw3DPie(244,150,array(
                "ValuePadding"=> 0,
                "Radius"=> 130,
                "WriteValues"=>TRUE,
                "DataGapAngle"=>6,
                "DataGapRadius"=>6,
                "Border"=>TRUE
            ));

            $ruta_image = "temp-image/".uniqid().".png";
            $myPicture->Render($ruta_image);

            return $ruta_image;
        }

        function generarGraficoCITNG($concordantes = 0, $noconcordantes = 0){
            $fuente = "../pchart/fonts/calibri.ttf";
            $fuenteBold = "../pchart/fonts/Calibri_Bold.ttf";

            $MyData = new pData();
            $MyData->addPoints([$concordantes,$noconcordantes],"ScoreA");  
            $MyData->setSerieDescription("ScoreA","Concordancia del diagnóstico");

            $MyData->addPoints(["Concordantes", "No concordantes"],"Labels");
            $MyData->setAbscissa("Labels");
            
            $myPicture = new pImage(468,262,$MyData,TRUE);
            $myPicture->setFontProperties(array("FontName"=>$fuenteBold,"FontSize"=>9,"R"=>0,"G"=>0,"B"=>80));
            
            $TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE, "R"=>0, "G"=>0, "B"=>0);
            $myPicture->drawText(244,25,"Porcentaje de concordancia en el diagnóstico",$TextSettings);
            $PieChart = new pPie($myPicture,$MyData);
 
            $PieChart->setSliceColor(0,array("R"=>$this->verdeOscuro[0],"G"=>$this->verdeOscuro[1],"B"=>$this->verdeOscuro[2]));
            $PieChart->setSliceColor(1,array("R"=>$this->rojoOscuro[0],"G"=>$this->rojoOscuro[1],"B"=>$this->rojoOscuro[2]));	
            
            $myPicture->setFontProperties(array("FontName"=>$fuente,"FontSize"=>8,"R"=>30,"G"=>30,"B"=>30));
            $PieChart->drawPieLegend(167,250,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
            
            $LabelSettings = array("TitleMode"=>LABEL_TITLE_BACKGROUND,"DrawSerieColor"=>FALSE,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255);
            
            $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>9));

            $PieChart->draw3DPie(244,150,array(
                "ValuePadding"=> 0,
                "Radius"=> 130,
                "WriteValues"=>TRUE,
                "DataGapAngle"=>6,
                "DataGapRadius"=>6,
                "Border"=>TRUE
            ));

            $ruta_image = "temp-image/".uniqid().".png";
            $myPicture->Render($ruta_image);

            return $ruta_image;
        }


        function generarGraficoPCM($concordantes = 0, $noconcordantes = 0){
            $fuente = "../pchart/fonts/calibri.ttf";
            $fuenteBold = "../pchart/fonts/Calibri_Bold.ttf";

            $MyData = new pData();
            $MyData->addPoints([$concordantes,$noconcordantes],"ScoreA");  
            $MyData->setSerieDescription("ScoreA","Concordancia del diagnóstico");

            $MyData->addPoints(["Concordantes", "No concordantes"],"Labels");
            $MyData->setAbscissa("Labels");
            
            $myPicture = new pImage(468,262,$MyData,TRUE);
            $myPicture->setFontProperties(array("FontName"=>$fuenteBold,"FontSize"=>9,"R"=>0,"G"=>0,"B"=>80));
            
            $TextSettings = array("Align"=>TEXT_ALIGN_MIDDLEMIDDLE, "R"=>0, "G"=>0, "B"=>0);
            $myPicture->drawText(244,25,"Porcentaje de concordancia en el diagnóstico",$TextSettings);
            $PieChart = new pPie($myPicture,$MyData);
 
            $PieChart->setSliceColor(0,array("R"=>$this->verdeOscuro[0],"G"=>$this->verdeOscuro[1],"B"=>$this->verdeOscuro[2]));
            $PieChart->setSliceColor(1,array("R"=>$this->rojoOscuro[0],"G"=>$this->rojoOscuro[1],"B"=>$this->rojoOscuro[2]));	
            
            $myPicture->setFontProperties(array("FontName"=>$fuente,"FontSize"=>8,"R"=>30,"G"=>30,"B"=>30));
            $PieChart->drawPieLegend(167,250,array("Style"=>LEGEND_NOBORDER,"Mode"=>LEGEND_HORIZONTAL));
            
            $LabelSettings = array("TitleMode"=>LABEL_TITLE_BACKGROUND,"DrawSerieColor"=>FALSE,"TitleR"=>255,"TitleG"=>255,"TitleB"=>255);
            
            $myPicture->setShadow(TRUE,array("X"=>3,"Y"=>3,"R"=>0,"G"=>0,"B"=>0,"Alpha"=>9));

            $PieChart->draw3DPie(244,150,array(
                "ValuePadding"=> 0,
                "Radius"=> 130,
                "WriteValues"=>TRUE,
                "DataGapAngle"=>6,
                "DataGapRadius"=>6,
                "Border"=>TRUE
            ));

            $ruta_image = "temp-image/".uniqid().".png";
            $myPicture->Render($ruta_image);

            return $ruta_image;
        }

        function SetGrossLineLeftRow($array){
            $this->grossLineLeft = $array;
        }

        function SetGrossLineRightRow($array){
            $this->grossLineRight = $array;
        }

        
        function SetAligns($a)
        {
            //Set the array of column alignments
            $this->aligns=$a;
        }
        
        function SetFillColorsRow($array){
            $this->fillColorsRow = $array;
        }

        
        function RowIHQ($data)
        {
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=$this->heightRow*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {

                $this->SetLineWidth($this->lineaDelgada);
                $this->SetDrawColor($this->azulClaro[0],$this->azulClaro[1],$this->azulClaro[2]);


                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                $fillColorArray=isset($this->fillColorsRow[$i]) ? $this->fillColorsRow[$i] : [255,255,255];
                $fillR = $fillColorArray[0];
                $fillG = $fillColorArray[1];
                $fillB = $fillColorArray[2];

                $this->SetFillColor($fillR,$fillG,$fillB);

                //Save the current position
                $x=$this->GetX();
                $y=$this->GetY();
                
                $this->SetTextColor(40, 40, 40);
                $this->SetLineWidth(0.1);

                $this->Cell($w,$h,"",0,0,0,1);
                $this->SetXY($x,$y);

                $this->MultiCell($w,$this->heightRow,$data[$i],0,$a,1);
                $this->Rect($x,$y,$w,$h);


                if(isset($this->grossLineLeft[$i]) && $this->grossLineLeft[$i] == true){ // Si esta definido el borde izquierdo y ademas es positivo
                    $this->SetLineWidth($this->lineaGruesa);
                    $this->SetDrawColor($this->azulOscuro[0],$this->azulOscuro[1],$this->azulOscuro[2]);
                    $this->Line($x, $y, $x, $y + $h);
                }
                
                if(isset($this->grossLineRight[$i]) && $this->grossLineRight[$i] == true){ // Si esta definido el borde derecho y ademas es positivo
                    $this->SetLineWidth($this->lineaGruesa);
                    $this->SetDrawColor($this->azulOscuro[0],$this->azulOscuro[1],$this->azulOscuro[2]);
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }
                
                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
        }

        /* ************************************* */
        // Nuevas funciones
        /* ************************************* */

        function SetWidths_dos($w)
        {
            //Set the array of column widths
            $this->widths=$w;
        }
        
        function SetAligns_dos($a)
        {
            //Set the array of column alignments
            $this->aligns=$a;
        }

        function Row_dos($data)
        {
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=5*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak_dos($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {
                $this->SetLineWidth($this->lineaDelgada);
                $this->SetDrawColor($this->azulClaro[0],$this->azulClaro[1],$this->azulClaro[2]);


                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                $fillColorArray=isset($this->fillColorsRow[$i]) ? $this->fillColorsRow[$i] : [255,255,255];
                $fillR = $fillColorArray[0];
                $fillG = $fillColorArray[1];
                $fillB = $fillColorArray[2];

                $this->SetFillColor($fillR,$fillG,$fillB);

                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                //Save the current position
                $x=$this->GetX();
                $y=$this->GetY();
                //Draw the border
                $this->Rect($x,$y,$w,$h);
                //Print the text
                $this->MultiCell($w,5,$data[$i],0,$a);
                //Put the position to the right of the cell

                if(isset($this->grossLineLeft[$i]) && $this->grossLineLeft[$i] == true){ // Si esta definido el borde izquierdo y ademas es positivo
                    $this->SetLineWidth($this->lineaGruesa);
                    $this->SetDrawColor($this->azulOscuro[0],$this->azulOscuro[1],$this->azulOscuro[2]);
                    $this->Line($x, $y, $x, $y + $h);
                }
                
                if(isset($this->grossLineRight[$i]) && $this->grossLineRight[$i] == true){ // Si esta definido el borde derecho y ademas es positivo
                    $this->SetLineWidth($this->lineaGruesa);
                    $this->SetDrawColor($this->azulOscuro[0],$this->azulOscuro[1],$this->azulOscuro[2]);
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }

                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
        }
        
        function CheckPageBreak_dos($h)
        {
            //If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }
        
        function NbLines_dos($w,$txt)
        {
            //Computes the number of lines a MultiCell of width w will take
            $cw=&$this->CurrentFont['cw'];
            if($w==0)
                $w=$this->w-$this->rMargin-$this->x;
            $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
            $s=str_replace("\r",'',$txt);
            $nb=strlen($s);
            if($nb>0 and $s[$nb-1]=="\n")
                $nb--;
            $sep=-1;
            $i=0;
            $j=0;
            $l=0;
            $nl=1;
            while($i<$nb)
            {
                $c=$s[$i];
                if($c=="\n")
                {
                    $i++;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                    continue;
                }
                if($c==' ')
                    $sep=$i;
                $l+=$cw[$c];
                if($l>$wmax)
                {
                    if($sep==-1)
                    {
                        if($i==$j)
                            $i++;
                    }
                    else
                        $i=$sep+1;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                }
                else
                    $i++;
            }
            return $nl;
        }

        /* ************************************* */
        // Fin Nuevas funciones
        /* ************************************* */

        function RowPQ($data)
        {
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=$this->heightRow*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {

                $this->SetLineWidth($this->lineaDelgada);
                $this->SetDrawColor($this->azulClaro[0],$this->azulClaro[1],$this->azulClaro[2]);


                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                $fillColorArray=isset($this->fillColorsRow[$i]) ? $this->fillColorsRow[$i] : [255,255,255];
                $fillR = $fillColorArray[0];
                $fillG = $fillColorArray[1];
                $fillB = $fillColorArray[2];

                $this->SetFillColor($fillR,$fillG,$fillB);

                //Save the current position
                $x=$this->GetX();
                $y=$this->GetY();
                
                $this->SetTextColor(40, 40, 40);
                $this->SetLineWidth(0.1);

                $this->Cell($w,$h,"",0,0,0,1);
                $this->SetXY($x,$y);

                $this->MultiCell($w,$this->heightRow,$data[$i],0,$a,1);
                $this->Rect($x,$y,$w,$h);


                if(isset($this->grossLineLeft[$i]) && $this->grossLineLeft[$i] == true){ // Si esta definido el borde izquierdo y ademas es positivo
                    $this->SetLineWidth($this->lineaGruesa);
                    $this->SetDrawColor($this->azulOscuro[0],$this->azulOscuro[1],$this->azulOscuro[2]);
                    $this->Line($x, $y, $x, $y + $h);
                }
                
                if(isset($this->grossLineRight[$i]) && $this->grossLineRight[$i] == true){ // Si esta definido el borde derecho y ademas es positivo
                    $this->SetLineWidth($this->lineaGruesa);
                    $this->SetDrawColor($this->azulOscuro[0],$this->azulOscuro[1],$this->azulOscuro[2]);
                    $this->Line($x + $w, $y, $x + $w, $y + $h);
                }
                
                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
        }

        function validarSiRespuestaCorrecta($id, $arrayDistractores){
            for($idxf=0; $idxf<sizeof($arrayDistractores); $idxf++){
                $id_distractor_respuesta_c = $arrayDistractores[$idxf];
                if($id_distractor_respuesta_c == $id){
                    return true;
                }
            }
            return false;
        }

        function Bookmark($txt, $isUTF8=false, $level=0, $y=0)
        {
            if(!$isUTF8)
                $txt = utf8_encode($txt);
            if($y==-1)
                $y = $this->GetY();
            $this->outlines[] = array('t'=>$txt, 'l'=>$level, 'y'=>($this->h-$y)*$this->k, 'p'=>$this->PageNo());
        }
        
        function _putbookmarks()
        {
            $nb = count($this->outlines);
            if($nb==0)
                return;
            $lru = array();
            $level = 0;
            foreach($this->outlines as $i=>$o)
            {
                if($o['l']>0)
                {
                    $parent = $lru[$o['l']-1];
                    // Set parent and last pointers
                    $this->outlines[$i]['parent'] = $parent;
                    $this->outlines[$parent]['last'] = $i;
                    if($o['l']>$level)
                    {
                        // Level increasing: set first pointer
                        $this->outlines[$parent]['first'] = $i;
                    }
                }
                else
                    $this->outlines[$i]['parent'] = $nb;
                if($o['l']<=$level && $i>0)
                {
                    // Set prev and next pointers
                    $prev = $lru[$o['l']];
                    $this->outlines[$prev]['next'] = $i;
                    $this->outlines[$i]['prev'] = $prev;
                }
                $lru[$o['l']] = $i;
                $level = $o['l'];
            }
            // Outline items
            $n = $this->n+1;
            foreach($this->outlines as $i=>$o)
            {
                $this->_newobj();
                $this->_put('<</Title '.$this->_textstring($o['t']));
                $this->_put('/Parent '.($n+$o['parent']).' 0 R');
                if(isset($o['prev']))
                    $this->_put('/Prev '.($n+$o['prev']).' 0 R');
                if(isset($o['next']))
                    $this->_put('/Next '.($n+$o['next']).' 0 R');
                if(isset($o['first']))
                    $this->_put('/First '.($n+$o['first']).' 0 R');
                if(isset($o['last']))
                    $this->_put('/Last '.($n+$o['last']).' 0 R');
                $this->_put(sprintf('/Dest [%d 0 R /XYZ 0 %.2F null]',$this->PageInfo[$o['p']]['n'],$o['y']));
                $this->_put('/Count 0>>');
                $this->_put('endobj');
            }
            // Outline root
            $this->_newobj();
            $this->outlineRoot = $this->n;
            $this->_put('<</Type /Outlines /First '.$n.' 0 R');
            $this->_put('/Last '.($n+$lru[0]).' 0 R>>');
            $this->_put('endobj');
        }
        
        function _putresources()
        {
            parent::_putresources();
            $this->_putbookmarks();
        }
        
        function _putcatalog()
        {
            parent::_putcatalog();
            if(count($this->outlines)>0)
            {
                $this->_put('/Outlines '.$this->outlineRoot.' 0 R');
                $this->_put('/PageMode /UseOutlines');
            }
        }

        
        function CheckPageBreak($h)
        {
            //If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }

        
        function NbLines($w,$txt)
        {
            //Computes the number of lines a MultiCell of width w will take
            $cw=&$this->CurrentFont['cw'];
            if($w==0)
                $w=$this->w-$this->rMargin-$this->x;
            $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
            $s=str_replace("\r",'',$txt);
            $nb=strlen($s);
            if($nb>0 and $s[$nb-1]=="\n")
                $nb--;
            $sep=-1;
            $i=0;
            $j=0;
            $l=0;
            $nl=1;
            while($i<$nb)
            {
                $c=$s[$i];
                if($c=="\n")
                {
                    $i++;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                    continue;
                }
                if($c==' ')
                    $sep=$i;
                $l+=$cw[$c];
                if($l>$wmax)
                {
                    if($sep==-1)
                    {
                        if($i==$j)
                            $i++;
                    }
                    else
                        $i=$sep+1;
                    $sep=-1;
                    $j=$i;
                    $l=0;
                    $nl++;
                }
                else
                    $i++;
            }
            return $nl;
        }

        
        function WriteHTML($html)
        {
            //HTML parser
            $html=str_replace("\n",' ',$html);
            $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
            foreach($a as $i=>$e)
            {
                if($i%2==0)
                {
                    //Text
                    if($this->HREF)
                        $this->PutLink($this->HREF,$e);
                    elseif($this->ALIGN=='center')
                        $this->Cell(0,3,$e,0,1,'C');
                    else
                        $this->Write(3,$e);
                }
                else
                {
                    //Tag
                    if($e[0]=='/')
                        $this->CloseTag(strtoupper(substr($e,1)));
                    else
                    {
                        //Extract properties
                        $a2=explode(' ',$e);
                        $tag=strtoupper(array_shift($a2));
                        $prop=array();
                        foreach($a2 as $v)
                        {
                            if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                                $prop[strtoupper($a3[1])]=$a3[2];
                        }
                        $this->OpenTag($tag,$prop);
                    }
                }
            }
        }

        
        function OpenTag($tag,$prop)
        {
            //Opening tag
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,true);
            if($tag=='A')
                $this->HREF=$prop['HREF'];
            if($tag=='BR')
                $this->Ln(5);
            if($tag=='P')
                $this->ALIGN=$prop['ALIGN'];
            if($tag=='HR')
            {
                if( !empty($prop['WIDTH']) )
                    $Width = $prop['WIDTH'];
                else
                    $Width = $this->w - $this->lMargin-$this->rMargin;
                $this->Ln(2);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->SetLineWidth(0.1);
                $this->Line($x,$y,$x+$Width,$y);
                $this->SetLineWidth(0.1);
                $this->Ln(2);
            }
        }

        
        function CloseTag($tag)
        {
            //Closing tag
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,false);
            if($tag=='A')
                $this->HREF='';
            if($tag=='P')
                $this->ALIGN='';
        }

        
        function SetStyle($tag,$enable)
        {
            //Modify style and select corresponding font
            $this->$tag+=($enable ? 1 : -1);
            $style='';
            foreach(array('B','I','U') as $s)
                if($this->$s>0)
                    $style.=$s;
            $this->SetFont('',$style);
        }

        
        function PutLink($URL,$txt)
        {
            //Put a hyperlink
            $this->SetTextColor(0,0,255);
            $this->SetStyle('U',true);
            $this->Write(5,$txt,$URL);
            $this->SetStyle('U',false);
            $this->SetTextColor(0);
        }


        function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
        {
            $k = $this->k;
            $hp = $this->h;
            if($style=='F')
                $op='f';
            elseif($style=='FD' || $style=='DF')
                $op='B';
            else
                $op='S';
            $MyArc = 4/3 * (sqrt(2) - 1);
            $this->_out(sprintf('%.2F %.2F m',($x+$r)*$k,($hp-$y)*$k ));
    
            $xc = $x+$w-$r;
            $yc = $y+$r;
            $this->_out(sprintf('%.2F %.2F l', $xc*$k,($hp-$y)*$k ));
            if (strpos($corners, '2')===false)
                $this->_out(sprintf('%.2F %.2F l', ($x+$w)*$k,($hp-$y)*$k ));
            else
                $this->_Arc($xc + $r*$MyArc, $yc - $r, $xc + $r, $yc - $r*$MyArc, $xc + $r, $yc);
    
            $xc = $x+$w-$r;
            $yc = $y+$h-$r;
            $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-$yc)*$k));
            if (strpos($corners, '3')===false)
                $this->_out(sprintf('%.2F %.2F l',($x+$w)*$k,($hp-($y+$h))*$k));
            else
                $this->_Arc($xc + $r, $yc + $r*$MyArc, $xc + $r*$MyArc, $yc + $r, $xc, $yc + $r);
    
            $xc = $x+$r;
            $yc = $y+$h-$r;
            $this->_out(sprintf('%.2F %.2F l',$xc*$k,($hp-($y+$h))*$k));
            if (strpos($corners, '4')===false)
                $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-($y+$h))*$k));
            else
                $this->_Arc($xc - $r*$MyArc, $yc + $r, $xc - $r, $yc + $r*$MyArc, $xc - $r, $yc);
    
            $xc = $x+$r ;
            $yc = $y+$r;
            $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$yc)*$k ));
            if (strpos($corners, '1')===false)
            {
                $this->_out(sprintf('%.2F %.2F l',($x)*$k,($hp-$y)*$k ));
                $this->_out(sprintf('%.2F %.2F l',($x+$r)*$k,($hp-$y)*$k ));
            }
            else
                $this->_Arc($xc - $r, $yc - $r*$MyArc, $xc - $r*$MyArc, $yc - $r, $xc, $yc - $r);
            $this->_out($op);
        }
    
        function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
        {
            $h = $this->h;
            $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
                $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
        }
        
        
        function Header(){
            $this->SetLineWidth(0.2);

            // Borde para las paginas
            $this->SetXY(5,5);
            $this->SetDrawColor(28, 80, 164);
            $this->Cell(270,206.5,"",1,0,'L',0);
            
            // Recuadro ancho completo
            $this->SetXY(8,8);
            $this->Cell(264,17,"",1,0,'L',0);
            
            // Recuadro imagen de logo de Quik
            $this->SetXY(8,8);
            $this->Cell(60,17,"","R",0,'L',0);
            
            // Logo Quik
            $this->Image('../../css/qlogo.png',12,11,18);
            
            // Linea divisora vertical
            $this->SetLineWidth(0.1);
            $this->SetDrawColor(174, 182, 191);
            $this->line(38,13,38,20);
            
            // Logo de QAP-PAT
            $this->Image('../../css/LOGO QAPPAT.png',43,12,20);
            
            // Recuadro de convenciones del formato
            $this->SetXY(68,8);
            $this->SetDrawColor(28, 80, 164);
            $this->Cell(140,17,"","R",0,'L',0);
            
            // Titulo Principal
            $this->SetXY(68,8);
            $this->SetTextColor(28, 80, 164);
            $this->SetFont('Arial','B',9);
            $this->MultiCell(140,(17/4),"\nCOMPARACIÓN INTRALABORATORIO\n".$this->sigla_programa . " ". $this->envio_pat . " | " . $this->nom_reto,0,'C',0);
            
            // Seccion de los valores fijos del formato
            $this->SetFont('Arial','B',7);
            $this->SetXY(208,8);
            $this->Cell(32,4.25,"Código:","R",0,'C',0);
            $this->Cell(32,4.25,"ADI-FOR-57",0,1,'C',0);
            
            $this->SetXY(208,12.25);
            $this->Cell(32,4.25,"Vigente desde:","RT",0,'C',0);
            $this->Cell(32,4.25,"26-Enero-2022","T",1,'C',0);

            $this->SetXY(208,16.5);
            $this->Cell(32,4.25,"Versión:","RT",0,'C',0);
            $this->Cell(32,4.25,"2","T",1,'C',0);

            $this->SetXY(208,21);
            $this->Cell(32,4.25,"Página:","RT",0,'C',0);
            $this->Cell(32,4.25,"     " .$this->PageNo() . " de {nb}","T",1,'C',0);

            $this->Ln(3);
            $this->SetX(10);
        }
        
        function obtenerNomEnvio($numero){
            switch($numero){
                case "1":
                    return "Primer envío";
                    break;
                case "2":
                    return "Segundo envío";
                    break;
                case "3":
                    return "Tercer envío";
                    break;
                case "4":
                    return "Cuarto envío";
                    break;
            }
        }
        
        function Footer(){
            // Sin nada
        }
    }

?>