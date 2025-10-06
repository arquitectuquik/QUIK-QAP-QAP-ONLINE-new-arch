<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}




    // importación de la librería

    require_once("fpdf/fpdf.php");

    

    class generalInformePAT extends FPDF {



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

        var $siglaprograma;

        protected $outlines = array();

        protected $outlineRoot;

        public $laboratorio_pat;

        public $fecha_envio;

        public $estado_reporte;

        public $nombre_reto;

        public $intento_pat;

        public $envio_pat;



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

            $h=5*$nb;

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

                

                $this->SetTextColor(40, 40, 40);

                $this->SetLineWidth(0.1);



                $this->Cell($w,$h,"",0,0,0,1);

                $this->SetXY($x,$y);

                

                if($data[$i] == "\n" || $data[$i] == "N/A\n"){

                    $this->SetTextColor(147,183,196);

                    $data[$i] = "N/A";

                } else {

                    $this->SetTextColor(40, 40, 40);

                }



                $this->MultiCell($w,5,$data[$i],0,$a,false);

                $this->Rect($x,$y,$w,$h);



                

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



        function CreateIndex(){

            //Index title

            $this->AddPage();

            $this->SetMargins(25,10,25);

            $this->Ln(65);

            $this->SetFont('Arial','B',12);

            $this->MultiCell(0,5,"Descripción del reto\n\n". $this->envio_pat . " | " .$this->nombre_reto,0,'C',0);

            $this->SetFont('Arial','',12);

            $this->Ln(9);

        

            $size=sizeof($this->outlines);

            $PageCellSize=$this->GetStringWidth('p. '.$this->outlines[$size-1]['p'])+2;

            for ($i=0;$i<$size;$i++){

                //Offset

                $level=$this->outlines[$i]['l'];

                if($level>0)

                    $this->Cell($level*8);

        

                //Caption

                $str=utf8_decode($this->outlines[$i]['t']);

                $strsize=$this->GetStringWidth($str);

                $avail_size=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*8)-4;

                while ($strsize>=$avail_size){

                    $str=substr($str,0,-1);

                    $strsize=$this->GetStringWidth($str);

                }

                $this->Cell($strsize+2,$this->FontSize+5,$str);

        

                //Filling dots

                $w=$this->w-$this->lMargin-$this->rMargin-$PageCellSize-($level*8)-($strsize+2);

                $nb=$w/$this->GetStringWidth('.');

                $dots=str_repeat('.',$nb);

                $this->Cell($w,$this->FontSize+5,$dots,0,0,'R');

        

                //Page number

                $this->Cell($PageCellSize,$this->FontSize+5,'p. '.($this->outlines[$i]['p'] + 1),0,1,'R');

            }

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

            

            // Margenes fijas para todas las hojas

            $this->SetXY(8,8);

            $this->SetDrawColor(133, 146, 158);

            $this->Cell(200,263,"",1,0,'L',0);

            $this->SetXY(8,8);

            

            if($this->PageNo() == 1) {



                // Logo Quik

                $this->Image('../../css/qlogo.png',52,86,43);



                // Logo FSFB

                //$this->Image('../../css/logo-fsfb.jpg',66,116,32);



                // Linea divisora vertical

                $this->SetDrawColor(93, 109, 126);

                $this->SetLineWidth(0.5);

                $this->line(108,80,108,149);



                // Logo QAPPAT

                $this->Image('../../css/LOGO QAPPAT.png',118,81,30);



                // Titulo Principal

                $this->SetXY(118,96);

                $this->SetFont('Arial','B',14);

                $this->MultiCell(76,6,"Programa de\nAseguramiento de\nla Calidad de\nPatología Anatómica.",0,'L',0);





                // Obtener información del laboratorio

                $qryInfoLab = "SELECT 

                    laboratorio.no_laboratorio, 

                    laboratorio.nombre_laboratorio, 

                    laboratorio.direccion_laboratorio, 

                    laboratorio.telefono_laboratorio, 

                    laboratorio.correo_laboratorio, 

                    laboratorio.contacto_laboratorio, 

                    ciudad.nombre_ciudad,

                    pais.nombre_pais

                FROM 

                    laboratorio 

                    join ciudad on ciudad.id_ciudad = laboratorio.id_ciudad

                    join pais on pais.id_pais = ciudad.id_pais

                WHERE laboratorio.id_laboratorio = '$this->laboratorio_pat'";



                $qryArrayInfoLab = mysql_query($qryInfoLab);

                mysqlException(mysql_error(),"_01");

                $array_qry_lab_pat = mysql_fetch_array($qryArrayInfoLab);



                // Almacenar en variables los resultados de la consulta

                $no_laboratorio = $array_qry_lab_pat["no_laboratorio"];

                $nombre_laboratorio = $array_qry_lab_pat["nombre_laboratorio"];

                

                // Programa QAPPAT

                $this->SetXY(118,126);

                $this->SetTextColor(36, 113, 163);

                $this->SetFont('Arial','B',15);

                $this->Cell(70,6,$this->tituloprograma,0,0,'L',0);



                // Programa QAPPAT

                $this->SetXY(118,136);

                $this->SetTextColor(52, 73, 94);

                $this->SetFont('Arial','B',13);

                $this->MultiCell(70,6,"Laboratorio\n$no_laboratorio | $nombre_laboratorio",0,'L',0);



                // Portada renglon uno

                $this->SetXY(8,235);

                $this->SetTextColor(0,0,0);

                $this->SetFont('Arial','',10);

                $this->MultiCell(200,4,"\nQuik S.A.S.\nCalle 63 C N° 35-13 / (601) 222-91-51 -+57 318 271 1649 Bogotá D.C Colombia",0,'C',0);



            } else {



                // Imprimir el encabezado desde la segunda pagina

                // Logo Quik

                $this->Image('../../css/qlogo.png',15,12,28);



                // Forma para encerrar el logo de QAP PAT

                $this->SetFillColor(255,255,255);

                $this->SetDrawColor(104, 189, 0);

                $this->RoundedRect(87, 8, 41, 16, 8, '34', 'DF');

                

                // Logo QAPPAT

                $this->Image('../../css/LOGO QAPPAT.png',93,11,26);



                // Logo de la FSFB

                //$this->Image('../../css/logo-fsfb.jpg',179,9,21);



                if($this->PageNo() == 2){ // Si es la contraportada



                    // Titulo del programa

                    $this->SetXY(8,50);

                    $this->SetFont('Arial','B',12);

                    $this->SetTextColor(0,0,0);

                    $this->Cell(200,4,$this->siglaprograma . " | " . $this->tituloprograma,0,0,'C',0);



                    // Obtener información del laboratorio

                    $qryInfoLab = "SELECT 

                        laboratorio.no_laboratorio,

                        laboratorio.nombre_laboratorio,

                        laboratorio.direccion_laboratorio,

                        laboratorio.telefono_laboratorio,

                        laboratorio.correo_laboratorio,

                        laboratorio.contacto_laboratorio,

                        ciudad.nombre_ciudad,

                        pais.nombre_pais

                    FROM 

                        laboratorio 

                        join ciudad on ciudad.id_ciudad = laboratorio.id_ciudad

                        join pais on pais.id_pais = ciudad.id_pais

                    WHERE laboratorio.id_laboratorio = '$this->laboratorio_pat'";



                    $qryArrayInfoLab = mysql_query($qryInfoLab);

                    mysqlException(mysql_error(),"_01");

                    $array_qry_lab_pat = mysql_fetch_array($qryArrayInfoLab);



                    // Almacenar en variables los resultados de la consulta

                    $no_laboratorio = $array_qry_lab_pat["no_laboratorio"];

                    $nombre_laboratorio = $array_qry_lab_pat["nombre_laboratorio"];

                    $direccion_laboratorio = $array_qry_lab_pat["direccion_laboratorio"];

                    $telefono_laboratorio = $array_qry_lab_pat["telefono_laboratorio"];

                    $correo_laboratorio = $array_qry_lab_pat["correo_laboratorio"];

                    $contacto_laboratorio = $array_qry_lab_pat["contacto_laboratorio"];

                    $nombre_ciudad = $array_qry_lab_pat["nombre_ciudad"];

                    $nombre_pais = $array_qry_lab_pat["nombre_pais"];





                    $qrySFR = "SELECT usuario.nombre_completo, usuario.cod_usuario FROM intento join usuario on usuario.id_usuario = intento.usuario_id_usuario WHERE intento.id_intento = $this->intento_pat limit 1";

                    $qryArraySRF = mysql_query($qrySFR);

                    global $nombre_patologo_srf;

                    global $codusuario_patologo_srf;

                    mysqlException(mysql_error(),"_01");

                    while ($qryDataSRF = mysql_fetch_array($qryArraySRF)) {

                        $nombre_patologo_srf = $qryDataSRF["nombre_completo"];

                        $codusuario_patologo_srf = $qryDataSRF["cod_usuario"];

                    }



                    // Consulta para obtener el nombre de usuario

                    $qrySFR = "SELECT nombre_usuario FROM intento join usuario on usuario.id_usuario = intento.usuario_id_usuario WHERE intento.id_intento = $this->intento_pat limit 1";

                    $qryArraySRF = mysql_query($qrySFR);

                    global $nombre_usuario_srf;

                    mysqlException(mysql_error(),"_01");

                    while ($qryDataSRF = mysql_fetch_array($qryArraySRF)) {

                        $nombre_usuario_srf = $qryDataSRF["nombre_usuario"];

                    }

        



                    // Informacion del laboratorio

                    $this->SetXY(30,70);

                    $this->SetFont('Arial','',12);

                    $this->SetTextColor(0,0,0);

                    $this->MultiCell(200,8,

                        "Institución: " . $nombre_laboratorio . "\n".

                        "N° Laboratorio: " . $no_laboratorio . "\n".

                        "Reportado por el patólogo: " . $nombre_patologo_srf."\n".

                        "Código del patólogo: ".$codusuario_patologo_srf."\n".

                        "País: " . $nombre_pais . "\n".

                        "Ciudad: " . $nombre_ciudad . "\n".

                        "Dirección: " . $direccion_laboratorio . "\n".

                        "Teléfono: " . $telefono_laboratorio . "\n".

                        "Email: " . $correo_laboratorio . "\n".

                        $this->envio_pat . ': ' . $this->nombre_reto . "\n".

                        "\n" .

                        "Fecha de envío: " . $this->fecha_envio . "\n" .

                        "\n" .

                        "Fecha de emisión: " . (date("Y-m-d")) . "\n" .

                        "Estado de reporte: " . $this->estado_reporte



                    ,0,'L',0);





                    // Informacion del laboratorio

                    $this->SetXY(30,210);

                    $this->SetFont('Arial','',10);

                    $this->SetTextColor(0,0,0);

                    $this->MultiCell(160,4,"*Nuestro proveedor certificado de las muestras de los programas de ensayos de aptitud QAPPAT, garantiza que los materiales utilizados durante la producción se obtienen conforme a requisitos éticos y reglamentarios declarados en términos de estabilidad, trazabilidad y relevancia médica.\n\nEl presente informe es generado por Quik SAS, y ninguna actividad relacionada con su producción es subcontratada.\n\nLa información contenida en este reporte es confidencial y su divulgación se realiza únicamente al participante interesado, o a la autoridad competente en caso de ser requerido, con autorización expresa del mismo.",0,'J',0);

                }



                $this->SetXY(8,35); // Resetear posicionamiento

            }

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



        /*  

            Se agrega el siguiente script con nuevas funciones para que los MultiCell se ajusten de acuerdo al contenido de la celda.

        */



        var $widths_dos;

        var $aligns_dos;



        function SetWidths_dos($w)

        {

            //Set the array of column widths

            $this->widths_dos = $w;

        }



        function SetAligns_dos($a)

        {

            //Set the array of column alignments

            $this->aligns_dos = $a;

        }



        function Row_dos($data)

        {

            //Calculate the height of the row

            $nb = 0;

            for ($i = 0; $i < count($data); $i++)

                $nb = max($nb, $this->NbLines_dos($this->widths_dos[$i], $data[$i]));

            $h = 5 * $nb;

            //Issue a page break first if needed

            $this->CheckPageBreak_dos($h);

            //Draw the cells of the row

            for ($i = 0; $i < count($data); $i++) {

                $w = $this->widths_dos[$i];

                $a = isset($this->aligns_dos[$i]) ? $this->aligns_dos[$i] : 'L';

                //Save the current position

                $x = $this->GetX();

                $y = $this->GetY();

                //Draw the border

                $this->Rect($x, $y, $w, $h);

                //Print the text

                $this->MultiCell($w, 5, $data[$i], 0, $a);

                //Put the position to the right of the cell

                $this->SetXY($x + $w, $y);

            }

            //Go to the next line

            $this->Ln($h);

        }



        function CheckPageBreak_dos($h)

        {

            //If the height h would cause an overflow, add a new page immediately

            if ($this->GetY() + $h > $this->PageBreakTrigger)

                $this->AddPage($this->CurOrientation);

        }



        function NbLines_dos($w, $txt)

        {

            //Computes the number of lines a MultiCell of width w will take

            $cw = &$this->CurrentFont['cw'];

            if ($w == 0)

                $w = $this->w - $this->rMargin - $this->x;

            $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;

            $s = str_replace("\r", '', $txt);

            $nb = strlen($s);

            if ($nb > 0 and $s[$nb - 1] == "\n")

                $nb--;

            $sep = -1;

            $i = 0;

            $j = 0;

            $l = 0;

            $nl = 1;

            while ($i < $nb) {

                $c = $s[$i];

                if ($c == "\n") {

                    $i++;

                    $sep = -1;

                    $j = $i;

                    $l = 0;

                    $nl++;

                    continue;

                }

                if ($c == ' ')

                    $sep = $i;

                $l += $cw[$c];

                if ($l > $wmax) {

                    if ($sep == -1) {

                        if ($i == $j)

                            $i++;

                    } else

                        $i = $sep + 1;

                    $sep = -1;

                    $j = $i;

                    $l = 0;

                    $nl++;

                } else

                    $i++;

            }

            return $nl;

        }



    }





?>