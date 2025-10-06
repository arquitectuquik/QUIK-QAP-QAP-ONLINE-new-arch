<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}

/**
 * QAP Online - Página principal
 * Migrado a PHP 7+ con compatibilidad MySQL mejorada
 */
session_start();
include_once "php/verifica_sesion.php";
actionRestriction_102();

// Obtener versión del sistema
$qry = "SELECT valor_misc FROM $tbl_misc WHERE titulo_misc = 'version'";
$result = mysql_query($qry);
if ($result && mysql_num_rows($result) > 0) {
    $qryData = mysql_fetch_array($result);
    $val_1 = isset($qryData['valor_misc']) ? $qryData['valor_misc'] : '1.0';
} else {
    $val_1 = '1.0'; // Versión por defecto
}

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Quality Assurance Program</title>
		<link rel="shortcut icon" href="css/qap_ico.png?v12">
		<link href="boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/jquery-ui.min.css?v12" rel="stylesheet" media="screen">	
		<link href="css/vegas.css?v12" rel="stylesheet" media="screen">		
		<link href="css/pagina.css?v12" rel="stylesheet" media="screen">			
	</head>
	<body onload="initialize()">
			<div class='fondo-principal'>
				<div class="contenedores-app">
					<img src="css/qap_logo.png" class='img1'  alt="Logo de QAP">
					<img src="css/LOGO QAPPAT.png" class='img2'  alt="Logo de QAPPAT">
				</div>
				<div class="cont-logo-quik">
					<img src="css/qlogo.png" alt="Logo de Quik">
				</div>
			</div>
	
			<?php 
				switch($_SESSION["qap_key"]){
					case 0: // Si es administrador total
			?>
						<nav class="navbar navbar-default cube-box" style="background-color: #1950a8;">
			<?php
						break;
					case 100: // Si es coordinador QAP Online
			?>
						<nav class="navbar navbar-default cube-box" style="background-color: #4c9bd3;">
			<?php
						break;
					case 102: // Si es Generador de informes
			?>
						<nav class="navbar navbar-default cube-box" style="background-color: #679707;">
			<?php
						break;
				}
			?>

			<span class="glass"></span>
			<ul class="nav navbar-nav">
				 <li><a	class="pointer unselectable" id="btn4" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-home"></span> Inicio</a></li>
				 <li><a	class="pointer unselectable" id="btn1" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-list-alt"></span> Resultados</a></li>
				 <li><a	class="pointer unselectable" id="btn5" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-calendar"></span> Cronograma</a></li>
				 <li><a	class="pointer unselectable" id="btn2" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-cog"></span> Configuraci贸n</a></li>
				 <li><a	class="pointer unselectable" id="btnDigitacion" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-object-align-horizontal"></span> QAP-FOR-07</a></li>
				 <li><a	class="pointer unselectable" id="btnPatologia" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-list-alt"></span> Resultados <strong>PAT</strong></a></li>
				 <li><a	class="pointer unselectable" id="btnPatologiaIntra" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-th-large"></span> Intralaboratorio <strong>PAT</strong></a></li>
				 <li><a	class="pointer unselectable" id="btnFinRonda" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-th-list"></span> Fin de ronda</a></li>
				 <li><a	class="pointer unselectable" id="btnClic" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-object-align-horizontal"></span> Reporte subgrupo</a></li>
				 <li><a	class="pointer unselectable" id="btn3" onmouseup="changeFrame(this);" style="color: white;"><span style="font-size: 12pt;" class="glyphicon glyphicon-log-out"></span> Cerrar sesi贸n</a></li>						 
			</ul>

			<?php 
				switch($_SESSION["qap_key"]){
					case 0: // Si es administrador total
			?>
						<a class="navbar-brand navbar-right" href="index_a.php" style="margin-right: 0px; color: white;">QAP Online v<?php echo $val_1; ?> | <span style='color:#ccc; font-size: 1.5rem; text-shadow: 0px 0px 1px #fff'>Administraci贸n</span></a>
			<?php
						break;
					case 100: // Si es coordinador QAP Online
			?>
						<a class="navbar-brand navbar-right" href="index_a.php" style="margin-right: 0px; color: white;">QAP Online v<?php echo $val_1; ?> | <span style='color:#ccc; font-size: 1.5rem; text-shadow: 0px 0px 1px #fff'>Coordinaci贸n</span></a>
			<?php
						break;
					case 102: // Si es Generador de informes
			?>
						<a class="navbar-brand navbar-right" href="index_a.php" style="margin-right: 0px; color: white;">QAP Online v<?php echo $val_1; ?> | <span style='color:#ccc; font-size: 1.5rem; text-shadow: 0px 0px 1px #fff'>Informes</span></a>
			<?php
						break;
				}
			?>
		</nav>
		<iframe frameborder="0" style="position: absolute; width: 100%; height: calc(100vh - 50px); top: 50px; bottom: 0; left: 0; right: 0; z-index: 1" id="page" allowtransparency="true"></iframe>
	<script src="jquery/jquery-2.1.4.min.js?v12"></script>	
	<script src="jquery/jquery.form.min.js?v12"></script>
	<script src="jquery/jquery.vegas.js?v12"></script>	
	<script src="jquery/jquery-ui.min.js?v12"></script>
	<script src="jquery/jquery.cookie.js?v12"></script>	
	<script src="jquery/jquery.statusBox.js?v12"></script>
	<script src="javascript/bootstrap.min.js?v12"></script>
	<script src="javascript/index_a.js?v12"></script>
	</body>
</html>