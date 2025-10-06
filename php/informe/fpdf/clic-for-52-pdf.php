<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../../mysql_compatibility.php';
}


include("fpdf.php");
include("sql_connection.php");
include("complementos/grubbs.php");

class CLICFOR52PDF extends FPDF
{

    var $B = 0;
    var $I = 0;
    var $U = 0;
    var $HREF = '';
    var $ALIGN = '';
    var $widths;
    var $minimoResaltado = 8;
    var $aligns;
    var $con_inserto_incluido;
    var $fillColorsRow;
    public $gris_claro = [253, 253, 254];
    public $gris_oscuro = [240, 240, 241];
    public $borde_table = [174, 182, 191];
    public $fondo_table = [214, 219, 223];
    public $blanclo = [255, 255, 255];
    public $verde = [150, 255, 150];
    public $rojo = [255, 150, 150];
    public $amarillo = [255, 255, 150];

    private $idmuestra;
    private $programa;
    private $fechaano;
    private $fechames;
    private $idlaboratorio;
    private $idronda;
    private $idciudad;

    function  SetLabels($id_muestra, $id_programa, $id_ronda, $fechaano, $fechames, $idlaboratorio, $idronda, $idciudad)
    {
        $this->idmuestra = $id_muestra;
        $this->programa = $id_programa;
        $this->ronda = $id_ronda;
        $this->fechaano = $fechaano;
        $this->fechames = $fechames;
        $this->idlaboratorio = $idlaboratorio;
        $this->idronda = $idronda;
        $this->idciudad = $idciudad;
    }

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }


    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }


    function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'R')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'L')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'U')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'D')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        else
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }


    function Row($data)
    {
        //Calculate the height of the row
        $factor = 4.2;
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = $factor * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {

            if ($i == 0) {
                $this->SetFont('Arial', 'B', 5);
            } else if ($i == 1) {
                $this->SetFont('Arial', '', 5);
            }

            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            $x = $this->GetX();
            $y = $this->GetY();
            $this->Cell($w, $h, "", 0, 0, 0, 1);
            $this->SetXY($x, $y);

            if ($i == 0) {
                $this->MultiCell($w, $factor, $data[$i], "L", $a, false);
            } else if (($i + 1) == count($data)) { // Si es el ultimo
                $this->MultiCell($w, $factor, $data[$i], "R", $a, false);
            } else {
                $this->MultiCell($w, $factor, $data[$i], 0, $a, false);
            }

            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }


    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }


    function NbLines($w, $txt)
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


    function WriteHTML($html)
    {
        //HTML parser
        $html = str_replace("\n", ' ', $html);
        $a = preg_split('/<(.*)>/U', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        foreach ($a as $i => $e) {
            if ($i % 2 == 0) {
                //Text
                if ($this->HREF)
                    $this->PutLink($this->HREF, $e);
                elseif ($this->ALIGN == 'center')
                    $this->Cell(0, 3, $e, 0, 1, 'C');
                else
                    $this->Write(3, $e);
            } else {
                //Tag
                if ($e[0] == '/')
                    $this->CloseTag(strtoupper(substr($e, 1)));
                else {
                    //Extract properties
                    $a2 = explode(' ', $e);
                    $tag = strtoupper(array_shift($a2));
                    $prop = array();
                    foreach ($a2 as $v) {
                        if (preg_match('/([^=]*)=["\']?([^"\']*)/', $v, $a3))
                            $prop[strtoupper($a3[1])] = $a3[2];
                    }
                    $this->OpenTag($tag, $prop);
                }
            }
        }
    }


    function OpenTag($tag, $prop)
    {
        //Opening tag
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, true);
        if ($tag == 'A')
            $this->HREF = $prop['HREF'];
        if ($tag == 'BR')
            $this->Ln(5);
        if ($tag == 'P')
            $this->ALIGN = $prop['ALIGN'];
        if ($tag == 'HR') {
            if (!empty($prop['WIDTH']))
                $Width = $prop['WIDTH'];
            else
                $Width = $this->w - $this->lMargin - $this->rMargin;
            $this->Ln(2);
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetLineWidth(0.4);
            $this->Line($x, $y, $x + $Width, $y);
            $this->SetLineWidth(0.2);
            $this->Ln(2);
        }
    }


    function CloseTag($tag)
    {
        //Closing tag
        if ($tag == 'B' || $tag == 'I' || $tag == 'U')
            $this->SetStyle($tag, false);
        if ($tag == 'A')
            $this->HREF = '';
        if ($tag == 'P')
            $this->ALIGN = '';
    }


    function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag += ($enable ? 1 : -1);
        $style = '';
        foreach (array('B', 'I', 'U') as $s)
            if ($this->$s > 0)
                $style .= $s;
        $this->SetFont('', $style);
    }


    function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0, 0, 255);
        $this->SetStyle('U', true);
        $this->Write(5, $txt, $URL);
        $this->SetStyle('U', false);
        $this->SetTextColor(0);
    }


    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        if (strpos($corners, '2') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '3') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($corners, '4') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '1') === false) {
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - $y) * $k));
        } else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }


    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }

    // Codigo nuevo

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
            $nb = max($nb, $this->NbLines_dow($this->widths_dos[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak_dos($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths_dos[$i];
            $a = isset($this->aligns_dos[$i]) ? $this->aligns_dos[$i] : 'C';
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

    function SetFillColorsRow($array)
    {
        $this->fillColorsRow = $array;
    }

    function RowPersonalizado($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines_dow($this->widths_dos[$i], $data[$i]));
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak_dos($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {

            $w = $this->widths_dos[$i];
            $a = isset($this->aligns_dos[$i]) ? $this->aligns_dos[$i] : 'C';

            $fillColorArray = isset($this->fillColorsRow[$i]) ? $this->fillColorsRow[$i] : [255, 255, 255];
            $fillR = $fillColorArray[0];
            $fillG = $fillColorArray[1];
            $fillB = $fillColorArray[2];

            $this->SetFillColor($fillR, $fillG, $fillB);

            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();

            $this->Cell($w, $h, "", 0, 0, 0, 1);
            $this->SetXY($x, $y);

            $this->Rect($x, $y, $w, $h);

            $this->MultiCell($w, 5, $data[$i], 0, $a);

            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln();
    }

    function CheckPageBreak_dos($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines_dow($w, $txt)
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

    // Fin codigo nuevo


    function Header()
    {

        if ($this->PageNo() == 1) {

            // Programa
            $qryPrograma = "SELECT DISTINCT * FROM programa
                WHERE id_programa IN(" . $this->programa . ")";
            $qrydataprograma = mysql_query($qryPrograma);
            $arrayprograma = '';

            while ($qryProgramaData = mysql_fetch_array($qrydataprograma)) {
                $arrayprograma .= ', ' . $qryProgramaData['sigla_programa'] . '-' . $qryProgramaData['nombre_programa'];
            }

            // Laboratorio
            $qryLaboratorio = "SELECT DISTINCT * FROM laboratorio
                WHERE id_laboratorio IN(" . $this->idlaboratorio . ")";
            $qrydatalaboratorio = mysql_query($qryLaboratorio);
            $arraylaboratorio = '';

            while ($qryLaboratorioData = mysql_fetch_array($qrydatalaboratorio)) {
                $arraylaboratorio .= ', ' . $qryLaboratorioData['no_laboratorio'] . ' - ' . $qryLaboratorioData['nombre_laboratorio'];
            }

            $array = explode(",", $arraylaboratorio);

            // Muestra
            $qryMuestra = "SELECT DISTINCT * FROM muestra
                WHERE id_muestra IN(" . $this->idmuestra . ")";
            $qrydatamuestra = mysql_query($qryMuestra);
            $arraymuestra = '';

            while ($qryMuestraData = mysql_fetch_array($qrydatamuestra)) {
                $arraymuestra .= ', ' . $qryMuestraData['codigo_muestra'];
            }

            $stringToArrayMuestra = explode(",", $arraymuestra);
            $arrayDistinctDataMuestra = array_unique($stringToArrayMuestra);
            $arrayToStringMuestra = implode(",", $arrayDistinctDataMuestra);

            // Contador Muestra
            $qryContadorMuestra = "SELECT DISTINCT * FROM contador_muestra
                WHERE id_muestra IN(" . $this->idmuestra . ")";
            $qrydataContadorMuestra = mysql_query($qryContadorMuestra);
            $arrayContadorMuestra = '';

            while ($qryContadorMuestraData = mysql_fetch_array($qrydataContadorMuestra)) {
                $arrayContadorMuestra .= ', ' . $qryContadorMuestraData['no_contador'];
            }

            $stringToArrayContadorMuestra = explode(",", $arrayContadorMuestra);
            $arrayDistinctDataContadorMuestra = array_unique($stringToArrayContadorMuestra);
            $arrayToStringContadorMuestra = implode(",", $arrayDistinctDataContadorMuestra);

            // Ronda
            $qryRonda = "SELECT DISTINCT * FROM ronda
                WHERE id_ronda IN(" . $this->idronda . ")";
            $qrydataronda = mysql_query($qryRonda);
            $arrayronda = '';

            while ($qryRondaData = mysql_fetch_array($qrydataronda)) {
                $arrayronda .= ', ' . $qryRondaData['no_ronda'];
            }

            $stringToArrayRonda = explode(",", $arrayronda);
            $arrayDistinctDataRonda = array_unique($stringToArrayRonda);
            $arrayToStringRonda = implode(",", $arrayDistinctDataRonda);

            // Ciudad
            $qryCiudad = "SELECT DISTINCT * FROM ciudad
                WHERE id_ciudad IN(" . $this->idciudad . ")";
            $qrydataCiudad = mysql_query($qryCiudad);
            $arrayCiudad = '';

            while ($qryCiudadData = mysql_fetch_array($qrydataCiudad)) {
                $arrayCiudad .= ', ' . $qryCiudadData['nombre_ciudad'];
            }

            // Convertir numero a mes en español (Ejemplo: 1->Enero)
            $mesesArray = explode(",", $this->fechames);
            $monthName = '';
            foreach ($mesesArray as $mesArray) {
                setlocale(LC_ALL, 'es_CO');
                $monthName .= ', ' . ucfirst(strftime("%B", mktime(0, 0, 0, $mesArray, 10)));
            }

            // Margenes fijas para todas las hojas
            $this->SetXY(8, 8);
            $this->SetDrawColor(28, 80, 164);
            $this->SetLineWidth(0.3);
            $this->Cell(263, 200, "", 1, 0, 'L', 0);
            $this->SetXY(8, 8);

            $this->SetFont('Arial', '', 6.5);
            $this->SetXY(16, 196);
            $this->MultiCell(247, 4, "Información de contacto: Calle 63 C No. 35 - 13 / (6011) 222-91-51 - +57 318 271 1649 / Bogotá - Colombia Coordinación de programas qap@quik.com.co Contact Center: contact.center@quik.com.co Página web: www.quik.com.co", 0, "C", 0);

            // Iconos de Quik y QAP
            $this->Image('../../css/qlogo.png', 85, 65, 40);
            $this->Image('../../css/qap_logo.png', 145, 58, 54);

            // Linea divisora vertical No.1
            $this->SetLineWidth(0.4);
            $this->line(139.5, 60, 139.5, 90);

            // Linea divisora vertical No. 2
            $this->SetLineWidth(0.4);
            $this->line(139.5, 100, 139.5, 150);

            // Información de laboratorio 
            $this->SetFont('Arial', 'B', 7);
            $this->SetTextColor(48, 84, 150);

            $aux = 2;

            for ($i = 0; $i < count($array); $i++) {

                $this->SetXY(145, 100 + $aux);
                $this->Cell(120, 4, $array[$i], 0, 0, "L");
                $aux += 4;
            }

            $this->SetXY(16, 106);
            $this->SetTextColor(50, 50, 50);
            $this->SetFont('Arial', '', 9);
            $this->MultiCell(120, 4, "Reporte Subgrupo\nPrograma de aseguramiento de la calidad\n" . trim($arrayprograma, ', ') . "\nCódigo de muestra: " . trim($arrayToStringMuestra, ', ') . "\nRonda: " . trim($arrayToStringRonda, ', ') . "\nMuestra: " . trim($arrayToStringContadorMuestra, ', ') . "\n" . trim($monthName, ', ')  . " " . $this->fechaano . "\nCiudad : " . trim($arrayCiudad, ', '), 0, "R", 0);

            $this->AddPage("P", "letter");
        } else {

            // Margenes fijas para todas las hojas
            $this->SetXY(8, 8);
            $this->SetDrawColor(28, 80, 164);
            $this->SetLineWidth(0.3);
            $this->Cell(200, 263, "", 1, 0, 'L', 0);
            $this->SetXY(8, 8);

            $this->SetFont('Arial', '', 6.5);
            $this->SetXY(16, 259);
            $this->MultiCell(184, 4, "Información de contacto: Calle 63 C No. 35 - 13 / (57-1) 222-91-51 - 318 271 1649 / Bogotá - Colombia Coordinación de programas qap@quik.com.co Contact Center: contact.center@quik.com.co Página web: www.quik.com.co", 0, "C", 0);


            // Recuadro ancho completo
            $this->SetXY(12, 11);
            $this->Cell(192.5, 17, "", 1, 0, 'L', 0);

            // Recuadro imagen de logo de Quik
            $this->SetXY(12, 11);
            $this->Cell(55, 17, "", "R", 0, 'L', 0);

            // Logo Quik
            $this->Image('../../css/qlogo.png', 16, 14.5, 18);

            // Linea divisora vertical
            $this->SetLineWidth(0.2);
            $this->SetDrawColor(174, 182, 191);
            $this->line(38, 16, 38, 23);

            // Logo de QAP-PAT
            $this->Image('../../css/qap_logo.png', 40.5, 11.5, 24);

            // Recuadro de titulo
            $this->SetXY(67, 11);
            $this->SetDrawColor(28, 80, 164);
            $this->Cell(87, 17, "", "R", 0, 'L', 0);

            // Titulo Principal
            $qryPrograma = "SELECT DISTINCT * FROM programa
                WHERE id_programa IN(" . $this->programa . ")";
            $qrydataprograma = mysql_query($qryPrograma);
            $arrayprograma = '';
            $arrayprogramasiglas = '';
            $countarray = 0;
            while ($qryProgramaData = mysql_fetch_array($qrydataprograma)) {
                $arrayprograma .= ', ' . $qryProgramaData['sigla_programa'] . '-' . $qryProgramaData['nombre_programa'];
                $arrayprogramasiglas .= ', ' . $qryProgramaData['sigla_programa'];
                $countarray++;
            }

            if ($countarray <= 3) {
                $this->SetXY(67, 11);
                $this->SetTextColor(50, 50, 50);
                $this->SetFont('Arial', 'B', 8);
                $this->MultiCell(87, (17 / 5), "\nInforme Subgrupo QAP\nPrograma de aseguramiento de la calidad\n" . trim($arrayprograma, ', '), 0, 'C', 0);
            } else {
                $this->SetXY(67, 11);
                $this->SetTextColor(50, 50, 50);
                $this->SetFont('Arial', 'B', 8);
                $this->MultiCell(87, (17 / 5), "\nInforme Subgrupo QAP\nPrograma de aseguramiento de la calidad\n" . trim($arrayprogramasiglas, ', '), 0, 'C', 0);
            }


            $this->SetXY(67, 11 + (17 / 5) * 3);
            $this->SetTextColor(28, 80, 164);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(140, (17 / 5), "\n" . "" . " " . "", 0, 0, 'C', 0);

            $last_cell_beginning = 154;
            // Seccion de los valores fijos del formato
            $this->SetFont('Arial', 'B', 7);
            $this->SetXY($last_cell_beginning, 11);
            // $this->Cell(25, (17 / 4), "Muestra:", "R", 0, 'C', 0);
            // $this->Cell(25, (17 / 4), $this->muestra, 0, 0, 'C', 0);

            // $this->SetXY($last_cell_beginning, 11 + (17 / 4));
            // $this->Cell(25, (17 / 3), "Código:", 0, 0, 'C', 0);
            // $this->Cell(25, (17 / 3), trim($arrayprograma,','), "T", 0, 'C', 0);

            $this->SetXY($last_cell_beginning, 11 + (11 / 3));
            // $this->Cell(25, (17 / 3), "Fecha generación:", 0, 0, 'C', 0);
            $this->multiCell(54, (11 / 3), "CLIC-FOR-52 V7\nVigente 10 de mayo de 2022\nPágina:  " . $this->PageNo() . " de {nb}" . $this->AliasNbPages(), 0, 'C', 0);
            // $this->Cell(25, (17 / 3), Date("d/m/Y"), 0, 0, 'C', 0);

            // $this->SetXY($last_cell_beginning, 11 + (17 / 3) * 2);
            // $this->Cell(25, (17 / 3), "Página:", 0, 0, 'C', 0);
            // $this->Cell(25, (17 / 3), "     " . $this->PageNo() . " de {nb}", 0, 0, 'C', 0);
            $this->Ln(7);
        }
    }
}
