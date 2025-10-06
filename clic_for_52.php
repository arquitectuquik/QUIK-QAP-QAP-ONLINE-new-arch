<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}


session_start();
include_once "php/verifica_sesion.php";
actionRestriction_102();

?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="javascript/jquery-3.3.1.js?v12"></script>
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script> -->

	<script src="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.js"></script>



	<link href="boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous"> -->
	<!-- <link href="css/pagina.css?v12-0" rel="stylesheet" media="screen"> -->

    <link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.rawgit.com/wenzhixin/multiple-select/e14b36de/multiple-select.css">
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



</head>

<body>
	<div class="col-xs-12 no-margin no-padding">
		<div class="col-xs-2" style="height: 100vh !important;">
			<span class="glass"></span>
			<div class="col-xs-12 margin-top-6" id="formReportePAT">
				<div class="form-group">
					<label for="ciudad">Ciudad</label><br>
					<select style="width:90% !important;" id="ciudad" name="ciudad[]"multiple >
						<?php
						$qry = "SELECT * FROM $tbl_ciudad ORDER BY $tbl_ciudad.nombre_ciudad ASC";
						$qryArray = mysql_query($qry);
						while ($qryData = mysql_fetch_array($qryArray)) {
							echo "<option value='" . $qryData['id_ciudad'] . "' selected>" . $qryData['nombre_ciudad'] . "</option>";
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="laboratorio">Laboratorio</label><br>
					<select style="width:90% !important;" id="laboratorio" name="laboratorio[]"multiple ></select>
				</div>
				<div class="form-group">
					<label for="programa">Programa</label><br>
					<select style="width:90% !important;" id="programa" name="programa[]"multiple ></select>
				</div>
				<div class="form-group">
					<label for="muestra">Muestra</label><br>
					<select style="width:90% !important;" id="muestra" name="muestra[]" multiple></select>
				</div>
				<div class="form-group">
					<label for="ronda">Ronda</label><br>
					<select style="width:90% !important;" id="ronda" name="ronda[]" multiple></select>
				</div>
				<div class="form-group">
					<label for="analito">Analito</label><br>
					<select style="width:90% !important;" id="analito" name="analito[]" multiple></select>
				</div>
				<div class="form-group">
					<label for="ano">A&ntildeo</label><br>
					<select style="width:90% !important;" id="ano" name="ano[]" multiple></select>
				</div>
				<div class="form-group">
					<label for="mes">Mes</label><br>
					<select style="width:90% !important;" id="mes" name="mes[]"multiple ></select>
				</div>
				<hr />
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

	<!-- <script src="https://code.jquery.com/jquery-3.3.1.js?v12" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script> -->
	<script src="javascript/clic_for_52.js?v12"></script>
	<script src="javascript/validarSiJSON.js?v12"></script>
</body>

</html>