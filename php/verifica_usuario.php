<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	ob_start();
	session_start();
	include_once "sql_connection.php";

	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";	

	$name = $_POST['username'];
	$pass = $_POST['userpassword'];
	$hash = mysql_real_escape_string(stripslashes(clean($_POST['hash'])));
	
	$name =  mysql_real_escape_string(stripslashes($name));
	$pass = mysql_real_escape_string(stripslashes($pass));
	
	$qry = "SELECT $tbl_usuario.id_usuario,nombre_usuario,tipo_usuario FROM $tbl_usuario LEFT OUTER JOIN $tbl_sesion ON $tbl_usuario.id_usuario = $tbl_sesion.id_usuario WHERE (nombre_usuario = '$name' AND contrasena = '$pass' AND usuario.estado = 1) OR (token_sesion = '$hash') LIMIT 0,1";
	
	$array = mysql_query($qry);
	mysqlException(mysql_error(),"001");

	if (mysql_num_rows($array) == 0) {
		if ($hash == 'NULL') {
			echo '<response code="1">';
			echo 0;
			echo '</response>';			
		} else {
			echo '<response code="1">';
			echo 2;
			echo '</response>';				
		}
	} else {
		
		$reg = mysql_fetch_array($array);
		mysqlException(mysql_error(),"002");
		$_SESSION['qap_userId'] = $reg['id_usuario'];
		$_SESSION['qap_key'] = $reg['tipo_usuario'];
		$_SESSION['qap_userName'] = $reg['nombre_usuario'];
		
		if (isset($_SESSION['qap_token'])) {
			
			$qry = "SELECT id_sesion FROM $tbl_sesion WHERE token_sesion = '".$_SESSION['qap_token']."'";
			
			$qryRows = mysql_num_rows(mysql_query($qry));
			
			if ($qryRows > 0) {
				echo '<response code="1" type="'.$_SESSION['qap_key'].'" hash="'.$_SESSION['qap_token'].'">';
				echo 1;
				echo '</response>';	
			} else {
				header("location:cierra_sesion.php");
				mysql_close($con);
				exit;				
			}
			
		} else {
			
			$token = md5(uniqid(rand(), true));
			
			$qry = "INSERT INTO $tbl_sesion (token_sesion,id_usuario) VALUES('$token',".$reg['id_usuario'].")";
			mysql_query($qry);
			mysqlException(mysql_error(),"003");
			
			$_SESSION['qap_token'] = $token;
			
			echo '<response code="1" type="'.$_SESSION['qap_key'].'" hash="'.$token.'">';
			echo 1;
			echo '</response>';				
			
		}
		
	}		
	
	mysql_close($con);
	exit;
?>