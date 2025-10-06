<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}


	

	/*

	ini_set('display_errors', 1);

	ini_set('display_startup_errors', 1);

	error_reporting(E_ALL);

	*/



	// header("Content-type: application/pdf");

	session_start();



	include_once "php/verifica_sesion.php";



	// Restriccion de permisos

	actionRestriction_102();

	ini_set('memory_limit', '256M');

	

	$id = $_GET['id'];

	$reportidoriginal = clean($_GET['reportidoriginal']);



	$reportidupdated = clean($_GET['reportidupdated']);

	$labid = clean($_GET['labid']);



	$qry = "SELECT filename,html_content FROM $tbl_temp_pdf WHERE id_temp_pdf = $id";

	

	$data = mysql_fetch_array(mysql_query($qry));

	

	$filename = $data['filename'];

	

	$html = $data['html_content'];

	$html = str_replace("amp;lt;","<",$html);

	$html = str_replace("amp;gt;",">",$html);

	$html = str_replace("amp;nbsp;"," ",$html);

	$html = str_replace("<!-- sheet separator --><!-- sheet separator -->","<!-- sheet separator -->",$html); // Impedir dos saltos de pagina

	

	$html = explode("<!-- sheet separator -->",$html);

	

	ob_start(); // Libreria de generacion de graficos y excel



	require_once('php/tcpdf/tcpdf_include.php');

	require_once('php/dom_parse/simple_html_dom.php');

	

	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

	

	// Definicion de variables globales de configuracion

	$pdf->SetAuthor('Quik S.A.S.');

	$pdf->SetTitle($filename);

	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);	

	$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

	$pdf->SetPrintHeader(false);

	$pdf->SetPrintFooter(true);	

	

	for ($x = 0; $x < sizeof($html); $x++) {

		

		$dom_html = str_get_html($html[$x]);



		/*

		echo $dom_html;

		echo "(((Hoja numero ".($x+1)." )))";

		*/



		$tempDiv = $dom_html->find('div[data-sheet=true]',0);

		// $tempDiv = $dom_html->find();



		$tempDivAttr = $tempDiv->title;

		$tempDivAlt = $tempDiv->alt;

		$tempDivAttrArray = explode("|",$tempDivAttr);

		

		$layout = array($tempDivAttrArray[0],$tempDivAttrArray[1]);

		$pageOrientation = $tempDivAlt;

		

		$pdf->AddPage($pageOrientation,$layout);



		$pdf->writeHTML($html[$x], true, false, true, false, '');

	

		if ($x == (sizeof($html) - 1)) {

			

			$pdf->lastPage();

			

		}

		

		$dom_html->clear(); 

		unset($dom_html);

	

	}

	

	$qry = "DELETE FROM $tbl_temp_pdf WHERE fecha < DATE_SUB(NOW(),INTERVAL 1 day)";

	mysql_query($qry);

	

	$qry = "SELECT id_contador FROM $tbl_contador_informe WHERE id_laboratorio = $labid LIMIT 0,1";

	$qryRows = mysql_num_rows(mysql_query($qry));

	$qryData = mysql_fetch_array(mysql_query($qry));

	

	if ($qryRows == 0) {

		$qry = "INSERT INTO $tbl_contador_informe (id_laboratorio,valor_contador_original,valor_contador_actualizado) VALUES ($labid,$reportidoriginal,$reportidupdated)";

	} else {

		$qry = "UPDATE $tbl_contador_informe SET valor_contador_original = $reportidoriginal, valor_contador_actualizado = $reportidupdated WHERE id_laboratorio = $labid";

	}

	

	mysql_query($qry);

	$pdf->Output($filename.'.pdf', 'I');

	mysql_close($con);

	

	exit;



?>