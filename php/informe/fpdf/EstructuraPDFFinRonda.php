<?php
    
    include ("fpdf.php");
    include ("sql_connection.php");
    include ("complementos/grubbs.php");
    include ("complementos/intercuartil.php");
    include ("informe/informeFinRondaController.php");
    
    class EstructuraPDFFinRonda extends FPDF {
        
        var $B=0;
        var $I=0;
        var $U=0;
        var $HREF='';
        var $ALIGN='';
        var $widths;
        var $minimoResaltado = 8;
        var $aligns;
        var $con_inserto_incluido;
        public $gris_claro = [253, 253, 254];
        public $gris_oscuro = [240, 240, 241];
        public $borde_table = [174, 182, 191];
        public $fondo_table = [214, 219, 223];

        private $id_laboratorio;
        private $id_programa;
        private $id_ronda;
        
        private $programa;
        private $laboratorio;
        private $ronda;
        private $muestras;
        private $analitos;
        private $niveles;
        private $total_muestras;
        private $ancho_individual;
        private $ancho_total;

        /**
         * Controlador de media de comparacion de todos los participantes
         *
         * @var [type]
         */
        private $mediaTodosController;

        /**
         * Controlador de media de comparacion de misma metodologia de los participantes
         *
         * @var [type]
         */
        private $mediaMismMetodologiaController;

        function SetWidths($w){
            //Set the array of column widths
            $this->widths=$w;
        }

        
        function SetAligns($a){
            //Set the array of column alignments
            $this->aligns=$a;
        }


        function TextWithDirection($x, $y, $txt, $direction='R') {
            if ($direction=='R')
                $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',1,0,0,1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
            elseif ($direction=='L')
                $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',-1,0,0,-1,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
            elseif ($direction=='U')
                $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,1,-1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
            elseif ($direction=='D')
                $s=sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET',0,-1,1,0,$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
            else
                $s=sprintf('BT %.2F %.2F Td (%s) Tj ET',$x*$this->k,($this->h-$y)*$this->k,$this->_escape($txt));
            if ($this->ColorFlag)
                $s='q '.$this->TextColor.' '.$s.' Q';
            $this->_out($s);
        }
        

        function Row($data){
            //Calculate the height of the row
            $factor = 4.2;
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=$factor*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++){

                if($i == 0){
                    $this->SetFont('Arial','B',5);
                } else if($i == 1) {
                    $this->SetFont('Arial','',5);
                }

                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                $x=$this->GetX();
                $y=$this->GetY();
                // $this->SetTextColor(40, 40, 40);
                // $this->SetLineWidth(0.2);
                // $this->SetDrawColor(146, 169, 185);
                $this->Cell($w,$h,"",0,0,0,1);
                $this->SetXY($x,$y);

                if($i == 0){
                    $this->MultiCell($w,$factor,$data[$i],"L",$a,false);
                } else if(($i+1) == count($data)) { // Si es el ultimo
                    $this->MultiCell($w,$factor,$data[$i],"R",$a,false);
                } else {
                    $this->MultiCell($w,$factor,$data[$i],0,$a,false);
                }

                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
        }


        function CheckPageBreak($h){
            //If the height h would cause an overflow, add a new page immediately
            if($this->GetY()+$h>$this->PageBreakTrigger)
                $this->AddPage($this->CurOrientation);
        }

        
        function NbLines($w,$txt){
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

        
        function WriteHTML($html){
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

        
        function OpenTag($tag,$prop){
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
                $this->SetLineWidth(0.4);
                $this->Line($x,$y,$x+$Width,$y);
                $this->SetLineWidth(0.2);
                $this->Ln(2);
            }
        }

        
        function CloseTag($tag){
            //Closing tag
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,false);
            if($tag=='A')
                $this->HREF='';
            if($tag=='P')
                $this->ALIGN='';
        }

        
        function SetStyle($tag,$enable){
            //Modify style and select corresponding font
            $this->$tag+=($enable ? 1 : -1);
            $style='';
            foreach(array('B','I','U') as $s)
                if($this->$s>0)
                    $style.=$s;
            $this->SetFont('',$style);
        }

        
        function PutLink($URL,$txt){
            //Put a hyperlink
            $this->SetTextColor(0,0,255);
            $this->SetStyle('U',true);
            $this->Write(5,$txt,$URL);
            $this->SetStyle('U',false);
            $this->SetTextColor(0);
        }


        function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = ''){
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


        function _Arc($x1, $y1, $x2, $y2, $x3, $y3){
            $h = $this->h;
            $this->_out(sprintf('%.2F %.2F %.2F %.2F %.2F %.2F c ', $x1*$this->k, ($h-$y1)*$this->k,
                $x2*$this->k, ($h-$y2)*$this->k, $x3*$this->k, ($h-$y3)*$this->k));
        }
        
            
        function Header(){
            // Margenes fijas para todas las hojas
            $this->SetXY(8,8);
            $this->SetDrawColor(28, 80, 164);
            $this->SetLineWidth(0.3);
            // $this->SetDrawColor(133, 146, 158);
            $this->Cell(263,200,"",1,0,'L',0);
            $this->SetXY(8,8);

            $this->SetFont('Arial','',6.5);
            $this->SetXY(16, 196);
            $this->MultiCell(247, 4, "Información de contacto: Calle 63 C No. 35 - 13 / (601) 222-91-51 - +57 318 271 1649 / Bogotá - Colombia Coordinación de programas qap@quik.com.co Contact Center: contact.center@quik.com.co Página web: www.quik.com.co", 0, "C", 0);
            
            if($this->PageNo() == 1) {
                // Iconos de Quik y QAP
                //$this->Image('../css/qlogo.png',85,65,40);
                $this->Image('../css/qap_logo.png',145,58,54);

                // Linea divisora vertical
                $this->SetLineWidth(0.4);
                $this->line(139.5,60,139.5,90);

                // Linea divisora vertical
                $this->SetLineWidth(0.4);
                $this->line(139.5,110,139.5,150);
                
                // Información de laboratorio 
                $this->SetFont('Arial','B',10);
                $this->SetTextColor(48, 84, 150);
                $this->SetXY(145, 114);
                $this->Cell(120, 4, $this->laboratorio->no_laboratorio . " ". $this->laboratorio->nombre_laboratorio, 0, 0, "L", 0);
                
                $this->SetXY(145, 120);
                $this->SetTextColor(50, 50, 50);
                $this->SetFont('Arial','',9);
                $this->MultiCell(120, 4, "E-mail: ". $this->laboratorio->correo_laboratorio ."\nDirección: ".$this->laboratorio->direccion_laboratorio."\nCiudad: ".$this->laboratorio->nombre_ciudad."\nPaís: ".$this->laboratorio->nombre_pais."\nContacto: ".$this->laboratorio->contacto_laboratorio."\nTeléfono: ". $this->laboratorio->telefono_laboratorio, 0, "L", 0);

                $this->SetXY(16, 121);
                $this->SetTextColor(50, 50, 50);
                $this->SetFont('Arial','',9);
                $this->MultiCell(120, 4, "INFORME DE FIN DE RONDA\nPrograma de aseguramiento de la calidad\n".$this->programa->sigla_programa." ".$this->programa->nombre_programa."\nRonda ".$this->ronda->no_ronda."\n".$this->ronda->fecha_min_sample." - ".$this->ronda->fecha_max_sample, 0, "R", 0);
                
                $this->SetXY(82, 141);
                $this->SetTextColor(50, 50, 50);
                $this->SetFont('Arial','',9);
                $this->Cell(120, 4, "Código Reporte:"." ".$this->programa->sigla_programa." ".$this->laboratorio->no_laboratorio."-".$this->ronda->no_ronda, 0, 0, "L", 0);
                
                
            } else {
                // Recuadro ancho completo
                $this->SetXY(12,11);
                $this->Cell(255.5,17,"",1,0,'L',0);
                
                // Recuadro imagen de logo de Quik
                $this->SetXY(12,11);
                $this->Cell(55,17,"","R",0,'L',0);
                
                // Logo Quik
                $this->Image('../css/qlogo.png',16,14.5,18);
                
                // Linea divisora vertical
                $this->SetLineWidth(0.2);
                $this->SetDrawColor(174, 182, 191);
                $this->line(38,16,38,23);
                
                // Logo de QAP-PAT
                $this->Image('../css/qap_logo.png',40.5,11.5,24);
                
                // Recuadro de titulo
                $this->SetXY(67,11);
                $this->SetDrawColor(28, 80, 164);
                $this->Cell(140,17,"","R",0,'L',0);
                
                // Titulo Principal
                $this->SetXY(67,11);
                $this->SetTextColor(50,50,50);
                $this->SetFont('Arial','B',8);
                $this->MultiCell(140,(17/5),"\nInforme de fin de ronda\nPrograma de aseguramiento de la calidad",0,'C',0);
                
                
                $this->SetXY(67,11 + (17/5)*3);
                $this->SetTextColor(28, 80, 164);
                $this->SetFont('Arial','B',9);
                $this->Cell(140,(17/5),"\n".$this->programa->sigla_programa." ".$this->programa->nombre_programa,0,0,'C',0);


                // Seccion de los valores fijos del formato
                $this->SetFont('Arial','B',7);
                $this->SetXY(207,11);
                $this->Cell(30.3,(17/4),"Laboratorio:","R",0,'C',0);
                $this->Cell(30.3,(17/4),$this->laboratorio->no_laboratorio,0,0,'C',0);
                
                $this->SetXY(207,11 + (17/4));
                $this->Cell(30.3,(17/4),"Ronda:","RT",0,'C',0);
                $this->Cell(30.3,(17/4),$this->ronda->no_ronda,"T",0,'C',0);
                
                $this->SetXY(207,11 + (17/4)*2);
                $this->Cell(30.3,(17/4),"Fecha generación:","RT",0,'C',0);
                $this->Cell(30.3,(17/4),Date("Y/m/d"),"T",0,'C',0);

                $this->SetXY(207,11 + (17/4) * 3);
                $this->Cell(30.3,(17/4),"Página:","RT",0,'C',0);
                $this->Cell(30.3,(17/4),"     " .$this->PageNo() . " de {nb}","T",0,'C',0);
    


                $this->Ln(7);
            }
        }
            
        function CreateDocument($id_laboratorio, $id_programa, $id_ronda, $urlBases64,$mediaController,$mediaMismaMetodoController){
            
            $this->id_laboratorio = $id_laboratorio;
            $this->id_programa = $id_programa;
            $this->id_ronda = $id_ronda;

            $this->programa = informeFinRondaController::getPrograma($this->id_programa);
            $this->laboratorio = informeFinRondaController::getLaboratorio($this->id_laboratorio);
            $this->ronda = informeFinRondaController::getRonda($this->id_ronda, $this->id_programa);
            $this->muestras = informeFinRondaController::getMuestras($this->id_ronda, $this->id_programa);
            $this->niveles = informeFinRondaController::getNiveles($this->id_ronda, $this->id_programa);
            $this->total_muestras = sizeof($this->muestras);
            $this->ancho_total = 193.2;
            $this->ancho_individual = $this->ancho_total / $this->total_muestras;            
            $this->mediaTodosController = $mediaController;
            $this->mediaMismMetodologiaController = $mediaMismaMetodoController;

            // Portada
            $this->AliasNbPages();
            $this->SetAutoPageBreak(true,5);
            $this->AddPage("l", "letter");
            
            $this->analitos = informeFinRondaController::getAnalitos($this->id_laboratorio, $this->id_programa);
            
            foreach($this->analitos as $analito){
                $this->impresionAnalito($analito, $urlBases64);
            }
            $this->impresionfinal();
        }
        function impresionAnalito($analito, $urlBases64){
            $this->AddPage("l", "letter");
            $this->Ln(6);
            $this->SetX(18);
            $this->SetTextColor(50,50,50);
            $this->SetFont('Arial','B',11);
            $this->Cell(150,4,$analito->nombre_analito." (".$analito->nombre_unidad . ")",0,1,'L',0);
            $this->SetX(18);
            $this->SetFont('Arial','',8.5);
            $this->Cell(150,3.5,"Analizador: " . $analito->nombre_analizador . " | Generación vitros: " . (($analito->valor_gen_vitros == 0) ? "N/A" : $analito->valor_gen_vitros),0,1,'L',0);
            $this->SetX(18);
            $this->Cell(150,3.5,"Metodología: ".$analito->nombre_metodologia." | Reactivo: " . $analito->nombre_reactivo . " | Material: " . $analito->nombre_material,0,0,'L',0);
            $this->impresionTabla($analito);
            
            //Concenciones
            $this->Ln(3);
            $this->SetX(125);
            $this->SetFont('Arial','',6.5);
            $this->SetTextColor(50,50,50);
            $this->Cell(69,3,"Interpretación color evaluación con media de comparación: ",0,0,'L',0);
            $this->Cell(20.5,3,"WRR mensual",0,0,'L',0);
            $this->Cell(23.5,3,"WWR acumulada",0,0,'L',0);
            $this->Cell(12,3,"Inserto",0,0,'L',0);
            $this->Cell(16,3,"Consenso",0,0,'L',0);
            
            $this->SetXY(192.5, 85.5);
            $this->SetFillColor(informeFinRondaController::$verde[0], informeFinRondaController::$verde[1], informeFinRondaController::$verde[2]);
            $this->Cell(1.6,1.6,"",0,0,'C',1);

            $this->SetXY(213, 85.5);
            $this->SetFillColor(informeFinRondaController::$azul[0], informeFinRondaController::$azul[1], informeFinRondaController::$azul[2]);
            $this->Cell(1.6,1.6,"",0,0,'C',1);

            $this->SetXY(236.3, 85.5);
            $this->SetFillColor(informeFinRondaController::$rosa[0], informeFinRondaController::$rosa[1], informeFinRondaController::$rosa[2]);
            $this->Cell(1.6,1.6,"",0,0,'C',1);

            $this->SetXY(248.5, 85.5);
            $this->SetFillColor(informeFinRondaController::$gris_oscuro[0], informeFinRondaController::$gris_oscuro[1], informeFinRondaController::$gris_oscuro[2]);
            $this->Cell(1.6,1.6,"",0,0,'C',1);

            $this->impresionGraficas($analito, $urlBases64);
        }

        function impresionMuestras(){
            foreach($this->muestras as $muestra){
                $this->Cell($this->ancho_individual,4,$muestra->codigo_muestra . " [M" . $muestra->no_contador . "]",1,0,'C',1);
            }
        }


        function impresionNiveles(){
            foreach($this->niveles as $index => $nivel){
                $this->Cell($this->ancho_individual * $nivel->num_muestras,5,($index+1),1,0,'C',1);
            }
        }

        function impresionTabla($analito){

            // Primer nivel
            $this->SetLineWidth(0.2);
            $this->Ln(8);
            $this->SetX(18);
            $this->SetTextColor(50,50,50);
            $this->SetDrawColor(176, 190, 204);
            $this->SetFillColor(200, 215, 230);
            $this->SetFont('Arial','B',8.5);
            $this->Cell(51,5,"Material",1,0,'C',1);

            $this->impresionNiveles();

            $this->Ln(5);
            
            // Segundo nivel
            $this->SetX(18);
            $this->SetFont('Arial','',8);
            $this->Cell(51,4,"Muestra",1,0,'C',1);
            
            $this->impresionMuestras();
            
            $this->Ln(4);
            
            // Tercer nivel
            $this->SetX(18);
            $this->SetFont('Arial','',8);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(51,5,"Valor reportado por el laboratorio",1,0,'C',1);
            foreach($this->muestras as $muestra){
                $resultado = $this->mediaTodosController->getCalculoPorAnalitoIdMuestraId(
                    $analito->id_analito,
                    $muestra->id_muestra,
                    $analito->id_metodologia,
                    $analito->id_unidad,
                    $analito->id_analizador
                ); 
                $vav = ($resultado["valor_lab"] == "0" || $resultado["valor_lab"] == null) ? "N/A" : $resultado["valor_lab"];
                $this->Cell($this->ancho_individual,5,$vav,1,0,'C',1);
                //$this->Cell($this->ancho_individual,5,informeFinRondaController::getVRL($muestra, $analito),1,0,'C',1);
            }

            $this->Ln(5);
            
            // Cuarto nivel
            $this->SetX(18);
            $this->SetFont('Arial','',8);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(51,4,"Evaluación con media de comparación",1,0,'C',1);
            foreach($this->muestras as $muestra){
                $result = informeFinRondaController::getVAV_Principal($muestra, $analito);

                if($result->media_estandar == "N/A"){
                    $vav = "N/A";
                    $this->SetFont('Arial','',8);
                } else {
                    $vav = round($result->media_estandar,2);
                    $this->SetFont('Arial','B',8);
                }

                $this->SetTextColor($result->color[0], $result->color[1], $result->color[2]);
                $this->Cell($this->ancho_individual,4,$vav,1,0,'C',1);
            }
            
            $this->SetFont('Arial','',8);
            $this->SetTextColor(50,50,50);

            $this->Ln(4);


            // Quinto nivel
            $this->SetX(18);
            $this->SetFont('Arial','',8);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(51,4,"JCTLM",1,0,'C',1);
            
            foreach($this->muestras as $muestra){
                $result = informeFinRondaController::getVAV_JCTLM($muestra, $analito);
                $vav = ($result->valor_metodo_referencia == "N/A") ? "N/A" : round($result->valor_metodo_referencia,2);
                $this->Cell($this->ancho_individual,4,$vav,1,0,'C',1);
            }
            
            $this->Ln(4);
            
            // Sexto nivel
            $this->SetX(18);
            $this->SetFont('Arial','',8);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(51,4,"Participantes QAP",1,0,'C',1);

            foreach($this->muestras as $muestra){
               
               // $result = informeFinRondaController::getVAV_Consenso($muestra, $analito);
                //$vav = ($result->media == "N/A") ? "N/A" : round($result->media,2);
                
                $resultado = $this->mediaTodosController->getCalculoPorAnalitoIdMuestraId(
                    $analito->id_analito,
                    $muestra->id_muestra,
                    $analito->id_metodologia,
                    $analito->id_unidad,
                    $analito->id_analizador
                );           
                $vav = ($resultado["n"] < 1) ? "N/A" : $resultado["media"];
                $this->Cell($this->ancho_individual,4,$vav,1,0,'C',1);
            }
            
            $this->Ln(4);
            
            // Septimo nivel
            $this->SetX(18);
            $this->SetFont('Arial','',8);
            $this->SetFillColor(255, 255, 255);
            $this->Cell(51,4,"Participantes QAP misma metodología",1,0,'C',1);

            foreach($this->muestras as $muestra){                   
                $resultadoMisma = $this->mediaMismMetodologiaController->getCalculoPorAnalitoIdMuestraId(
                    $analito->id_analito,
                    $muestra->id_muestra,
                    $analito->id_metodologia,
                    $analito->id_unidad,
                    $analito->id_analizador
                );           
                $vavMisma = ($resultadoMisma["n"] < 1) ? "N/A" : $resultadoMisma["media"];
                //$result = informeFinRondaController::getVAV_ConsensoMetodologia($muestra, $analito);
                //$vav = ($result->media == "N/A") ? "N/A" : round($result->media,2);                
                
                $this->Cell($this->ancho_individual,4,$vavMisma,1,0,'C',1);
            }

            $this->Ln(4);
            
            // Recuadro de V.A.V.s
            $this->SetLineWidth(0.8);
            $this->SetDrawColor(41, 128, 185);
            $this->SetXY(18.35, 66.55);
            $this->Cell(244,15.4,"","L",1,'C',0);
            
            // Texto de V.A.V
            $this->SetLineWidth(0.2);
            $this->SetFont('Arial','B',7);
            $this->SetTextColor(41, 128, 185);
            $this->TextWithDirection(17,77,'V.A.V','U');
        }
        
        function impresionGraficas($analito, $urlBases64){

            $this->SetXY(18,94);
            $this->SetFont('Arial','B',9);
            $this->SetTextColor(52, 73, 94);
            $this->Cell(244,4,"Gráficas de correlación",0,0,'C',0);
            
            // Gráfica integrada del nivel
            $this->Image($urlBases64["base64_analito_" . $analito->id_configuracion . "_vav_principal"], 25, 97.5, 118);
            $this->Image($urlBases64["base64_analito_" . $analito->id_configuracion . "_vav_jctlm"], 142, 97.5, 118);
            $this->Image($urlBases64["base64_analito_" . $analito->id_configuracion . "_vav_consenso_qap"], 25, 139, 118);
            $this->Image($urlBases64["base64_analito_" . $analito->id_configuracion . "_vav_consenso_qap_metodologia"], 142, 139, 118);

            
            
        }
         function impresionfinal(){
            
            $this->AddPage('L');
            
            // Configuración de la nueva página en horizontal
            $this->SetXY(18, 20);  // Posición inicial en la nueva página
            $this->SetFont('Arial', 'B', 12);
            $this->SetTextColor(52, 73, 94);
            $this->SetXY(30, 60);
            
            // Dibujar la caja principal de Observaciones
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(100, 8, 'Observaciones:', 1, 0, 'L'); // Título Observaciones
            $this->Ln();
            $this->SetXY(30, 68);
            $this->Cell(100, 60, '', 1, 0, 'L'); // Caja de Observaciones vacía
            
            // Dibujar la caja para "Revisado por"
            $this->SetXY(130, 60); // Posicionar al lado de Observaciones
            $this->Cell(100, 8, 'Revisado por:', 1, 0, 'L'); // Título Revisado por
            $this->Ln();
            $this->SetXY(130, 68);
            $this->Cell(100, 30, '', 1, 0, 'L'); // Caja de Revisado por vacía
            
            // Dibujar la caja para "Fecha"
            $this->SetXY(130, 98); // Posicionar debajo de Revisado por
            $this->Cell(100, 8, 'Fecha:', 1, 0, 'L'); // Título Fecha
            $this->Ln();
            $this->SetX(130);
            $this->Cell(100, 22, '', 1, 0, 'L'); // Caja de Fecha vacía
            
            // Agregar texto "Final de reporte"
            $this->SetFont('Arial', 'I', 9);
            $this->SetXY(10, 130); 
            $this->Cell(0, 10, '-- Final de reporte --', 0, 0, 'C');
            
            $this->SetFont('Arial', 'I', 9);
            $this->SetXY(10, 140); 
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'Aprobado por:', 0, 0, 'C');
            $this->SetXY(10, 144); 
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'CoordinadorQAP', 0, 0, 'C');
            $this->SetXY(10, 147); 
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'Programas QAP', 0, 0, 'C');
            $this->SetXY(193, 160); 
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'Coordinador QAP:', 0, 0, 'C');
            $this->SetXY(180, 163); 
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'María Paula Mora Gamboa', 0, 0, 'C');
            $this->SetXY(168, 166); 
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(0, 10, 'Correo: maria.mora@quik.com.co', 0, 0, 'C');
           
         }
    }
?>