<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}

	session_start();
	include_once "php/verifica_sesion.php";
	// userRestriction();
	
	$id = encryptControl('decrypt',mysql_real_escape_string(stripcslashes(clean($_GET['id']))),$_SESSION['qap_token']);
	$action = $_GET['action'];

	$qry = "SELECT id_archivo,nombre_archivo,index_archivo,extencion_archivo FROM archivo WHERE id_archivo = $id LIMIT 0,1";
	$qryData = mysql_fetch_array(mysql_query($qry));
	mysqlException(mysql_error(),"visor_documento_0x01");
	
	$file = 'reportes/'.$qryData['index_archivo'].'.'.$qryData['extencion_archivo'];
	
	switch ($action) {
		case "view":
			if (file_exists($file)) {
				
				header('Content-Description: File Transfer');
				header('Content-type:');
				header('Content-Disposition: inline; filename="'.$qryData['nombre_archivo'].'.'.$qryData['extencion_archivo'].'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: '.filesize($file));
				readfile($file);		
				
			}		
		break;
		case "download":
		case "downloadMultiple":
			if (file_exists($file)) {
				
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename="'.$qryData['nombre_archivo'].'.'.$qryData['extencion_archivo'].'"');
				header('Expires: 0');
				header('Cache-Control: must-revalidate');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				readfile($file);
				
			}				
		break;
		default:
			//
		break;
	}
	
	mysql_close($con);
	exit;
?>	