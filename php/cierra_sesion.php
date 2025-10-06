<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	session_start();
	include_once"verifica_sesion.php";

	$qry = "DELETE FROM $tbl_sesion WHERE token_sesion = '".$_SESSION['qap_token']."'";
	
	mysql_query($qry);
	mysqlException(mysql_error(),"001");
	
	session_destroy();
	header("location:../login.php");
	
	mysql_close($con);
	exit;
?>