<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}


	session_start();
	include_once"php/verifica_sesion.php";
	actionRestriction_102();

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/pagina.css?v12" rel="stylesheet" media="screen">			
	</head>
	<body>
		<div class="col-xs-12 no-margin no-padding">
			<div class="col-xs-2" style="height: 100vh; overflow: auto;">
				<span class="glass"></span>
				<div class="col-xs-12 margin-top-6 no-padding" id="formReportePAT">
					<div class="form-group">
						<label for="laboratorio_pat">Laboratorio</label>
						<select class="form-control input-sm" id="laboratorio_pat" name="laboratorio_pat">
						<?php
							$qry = "SELECT id_laboratorio,no_laboratorio,nombre_laboratorio FROM $tbl_laboratorio where no_laboratorio like '200%' ORDER BY no_laboratorio ASC";
							$qryArray = mysql_query($qry);
							while ($qryData = mysql_fetch_array($qryArray)) {
								
								echo"<option value='".$qryData['id_laboratorio']."'>".$qryData['no_laboratorio']." | ".$qryData['nombre_laboratorio']."</option>";
								
							}
						?>						
						</select>
					</div>
					<div class="form-group">
						<label for="programa_pat">Programa <strong>PAT</strong></label>
						<select class="form-control input-sm" id="programa_pat" name="programa_pat"></select>
					</div>
					<div class="form-group">
						<label for="reto_pat">Reto</label>
						<select class="form-control input-sm" id="reto_pat" name="reto_pat"></select>
					</div>
					<hr/>					
					<div class="form-group">
						<button type="button" class="btn btn-success btn-sm btn-block" id="generar_reporte">Generar informe</button>
					</div>						
				</div>
			</div>
					
			<div class="col-xs-10 no-margin no-padding" style="height: 100vh; overflow: auto; background-color: #525659;">
				<div class="col-xs-12 no-padding" id="form2" style="height: inherit;">
					<iframe frameborder="0" style="position: absolute; width: 100%; height: 100vh; bottom: 0; left: 0; right: 0; top: 0px; z-index: 1;" id="box_iframe" allowtransparency="true"></iframe>
				</div>
			</div>
		</div>

		<script src="javascript/jquery-3.3.1.min.js?v12"></script>	
		<script src="javascript/resultado_pat_intra.js?v12"></script>
		<script src="javascript/validarSiJSON.js?v12"></script>
	</body>
</html>