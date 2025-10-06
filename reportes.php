<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}


	session_start();
	include_once"php/verifica_sesion.php";

?>

<!DOCTYPE html>

<html lang="es">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Reportes QAP Online</title>
		<link rel="shortcut icon" href="css/qap_ico.png">
		<link href="boostrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
		<link href="jquery/jquery-ui/jquery-ui.min.css" rel="stylesheet" media="screen">
		<link href="jquery/jquery-ui/jquery-ui.structure.min.css" rel="stylesheet" media="screen">
		<link href="jquery/jquery-ui/jquery-ui.theme.min.css" rel="stylesheet" media="screen">
		<link href="css/pagina.css" rel="stylesheet" media="screen">
	</head>

	<body onload="initialize();">

		<div class="panel  cube-box no-margin no-padding inherit-height" id="panel1" data-id="mainDiv">

			<div class="panel-heading cube-box">

				<span class="glyphicon glyphicon-user"></span>
				<?php
					$qry = "SELECT nombre_usuario FROM $tbl_usuario WHERE id_usuario = ".$_SESSION['qap_userId'];
					$qryData = mysql_fetch_array(mysql_query($qry));
					$val_1 = $qryData['nombre_usuario'];
				?>
				<span style="font-weight: bold;"><?php echo $val_1 ?></span><span> | QAP Online</span>
			</div>

			<div class="panel-body cube-box no-margin no-padding">
				<nav class="navbar navbar-default cube-box no-margin no-padding">
					<ul class="nav navbar-nav inner-nav">
						<li class="pointer active-tab unselectable" style="font-size: 10pt" data-id="panel1innerDiv1" onmouseup="functionHandler('panelChooser',this, 'p1id');"><a>Consulta de reportes</a></li>					
					</ul>				

				</nav>

				<div id="panel1innerDiv1" data-id="p1id">
					<div class="col-xs-3 border-right vh-90 background-color-b">
						<form id="form1" class="margin-top-1">
							<div class="form-group">
								<label for="">Laboratorio</label>
								<select class="form-control input-sm" id="form1input1">
										<?php

                                            $qry = "SELECT $tbl_laboratorio.id_laboratorio,no_laboratorio,nombre_laboratorio 
													FROM $tbl_laboratorio 
													INNER JOIN $tbl_usuario_laboratorio ON $tbl_laboratorio.id_laboratorio = $tbl_usuario_laboratorio.id_laboratorio 
													WHERE $tbl_usuario_laboratorio.id_usuario = ".$_SESSION['qap_userId']." ORDER BY no_laboratorio ASC";
                                            
                                            $qryArray = mysql_query($qry);
                                            
                                            while ($qryData = mysql_fetch_array($qryArray)) {
                                                
                                                echo'<option value="'.encryptControl('encrypt',$qryData['id_laboratorio'],$_SESSION['qap_token']).'">'.$qryData['no_laboratorio'].' | '.$qryData['nombre_laboratorio'].'</option>';
                                            }

                                        ?>
								</select>
							</div>

							<div class="form-group">

								<label for="">Programa</label>

								<select class="form-control input-sm" id="form1input2"></select>

							</div>	
							
							<div class="form-group">

								<label for="">Ronda</label>

								<select class="form-control input-sm" id="form1input3"></select>

							</div>							

						</form>
					</div>

				</div>	

				<div id="panel1innerDiv2" data-id="p1id">

					<div class="col-xs-9 vh-90">

						<table class="table table-condensed" id="table8">
							<thead>
								<tr>
									<th colspan="4"><input type="text" class="form-control input-sm" data-search-input="true" placeholder="Buscar..." onkeyup="functionHandler('tableSearch',this);"/></th>
									<th colspan="1"><button type="button" class="btn btn-default btn-sm btn-block" id="table8btn1" data-parent="table8">Descargar seleccionados</button></th>
								</tr>
								<tr>
									<th class="center-text"><input type="checkbox" id="table8SelectAll" onmouseup="functionHandler('checkAll',this)"/></th>
									<th class="center-text">Nombre de documento</th>
									<th class="center-text">Fecha de carga</th>
									<th class="center-text" style='width:30px;'>Ver</th>
									<th class="center-text" style='width:30px;'>Descargar</th>
								</tr>	
							</thead>

							<tbody></tbody>
						</table>
					</div>
				</div>

			</div>

		</div>	

		<script src="javascript/jquery-3.3.1.min.js"></script>

		<script src="jquery/jquery-ui/jquery-ui.min.js"></script>

		<script src="javascript/bootstrap.min.js"></script>

		<script src="jquery/jquery.cookie.js"></script>

		<script src="jquery/jquery.statusBox.js"></script>

		<script src="javascript/reportes.js"></script>

	</body>

</html>