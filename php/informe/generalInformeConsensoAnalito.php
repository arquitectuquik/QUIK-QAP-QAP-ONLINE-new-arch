<?php

    // importación de la librería
    require_once("fpdf/fpdf.php");
    
    class generalInformeConsensoAnalito extends FPDF {
        
        var $B=0;
        var $I=0;
        var $U=0;
        var $HREF='';
        var $ALIGN='';
        var $widths;
        var $minimoResaltado = 8;
        var $aligns;
        var $con_inserto_incluido;
  

        function SetWidths($w)
        {
            //Set the array of column widths
            $this->widths=$w;
        }

        
        function SetAligns($a)
        {
            //Set the array of column alignments
            $this->aligns=$a;
        }

        
        function Row($data)
        {
            //Calculate the height of the row
            $nb=0;
            for($i=0;$i<count($data);$i++)
                $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
            $h=3.5*$nb;
            //Issue a page break first if needed
            $this->CheckPageBreak($h);
            //Draw the cells of the row
            for($i=0;$i<count($data);$i++)
            {

                $w=$this->widths[$i];
                $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
                //Save the current position
                $x=$this->GetX();
                $y=$this->GetY();
                //Draw the border
                // $this->SetFillColor(255, 255, 255);
                
                $this->SetTextColor(40, 40, 40);
                
                $this->SetLineWidth(0.2);

                $this->Cell($w,$h,"",0,0,0,1);
                $this->SetXY($x,$y);
                
                if($data[$i] == "\n" || $data[$i] == "N/A\n"){
                    $this->SetTextColor(147,183,196);
                    $data[$i] = "N/A";
                } else {
                    $this->SetTextColor(40, 40, 40);
                }

                $this->MultiCell($w,3.5,$data[$i],0,$a,false);
                $this->Rect($x,$y,$w,$h);
                
                
                $this->SetXY($x+$w,$y);
            }
            //Go to the next line
            $this->Ln($h);
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
                $this->SetLineWidth(0.4);
                $this->Line($x,$y,$x+$Width,$y);
                $this->SetLineWidth(0.2);
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
        
        
        function Header(){
        
            $this->SetLineWidth(0.2);

            // Recuadro ancho completo
            $this->SetXY(5,5);
            $this->SetDrawColor(28, 80, 164);
            $this->Cell(269.5,20,"",1,0,'L',0);
            
            // Recuadro imagen de logo de Quik
            $this->SetXY(5,5);
            $this->Cell(60,20,"",1,0,'L',0);

            // Logo Quik
            $this->Image('../../css/qlogo.png',10,10,18);

            // Linea divisora vertical
            $this->SetLineWidth(0.1);
            $this->line(34,10,34,20);
            
            // Logo de QAP-FOR-07
            $this->SetTextColor(28, 80, 164);
            $this->SetFont('Arial','B',11);
            $this->SetXY(37,8);
            $this->Cell(25,15,"QAP Online",0,0,'C',0);

            // Recuadro de convenciones del formato
            $this->SetXY(-65,5);
            $this->Cell(60,20,"",1,0,'L',0);

            // Titulo Principal
            $this->SetXY(65,5);
            $this->SetFont('Arial','B',11);
            $this->Cell(149.5,20,"Entradas para definir el consenso V.A.V.",1,0,'C',0);
            
            // Seccion de los valores fijos del formato
            $this->SetTextColor(28, 80, 164);
            $this->SetFont('Arial','B',8);
            $this->SetXY(-65,5);
            $this->Cell(30,5,"Código:",1,0,'L',0);
            
            $this->SetXY(-65,10);
            $this->Cell(30,5,"Vigente desde:",1,0,'L',0);
            
            $this->SetXY(-65,15);
            $this->Cell(30,5,"Versión:",1,0,'L',0);
            
            $this->SetXY(-65,20);
            $this->Cell(30,5,"Página:",1,0,'L',0);
            
            
            // Valores de los codigos fijos del formato
            $this->SetFont('Arial','B',7);
            $this->SetXY(-35,5);
            $this->Cell(30,5,"QAP-FOR-32",1,0,'C',0);

            $this->SetXY(-35,10);
            $this->Cell(30,5,"8-Septiembre-2020",1,0,'C',0);

            $this->SetXY(-35,15);
            $this->Cell(30,5,"1",1,0,'C',0);

            $this->SetXY(-35,20);
            $this->Cell(30,5,"Página " . $this->PageNo() . " de {nb}",1,0,'C',0);

            $this->Ln(10);
            $this->SetX(5);
        }
        
        
        function Footer(){
            // Sin nada
        }
    }


?>
