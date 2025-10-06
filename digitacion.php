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
		<link href="css/jquery-ui.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/pagina.css?v12" rel="stylesheet" media="screen">		
		<link href="css/digitacion.css?v12" rel="stylesheet" media="screen">		
	</head>
	<body class="transparent-body">
		<div class="col-xs-12 margin-top-1">
			<div class="col-xs-12">
				<div class="panel panel-default shadow no-margin no-padding">
					<div class="panel-heading cube-box">
						<span style="margin: 1%; font-size: 16pt;">Digitación de medias de comparación</span>
					</div>
					<div class="panel-body cont-referencia-selectores">
						<div class="col-xs-12 no-margin no-padding cont-selectores" id="formDigitacion">
							<div class="col-xs-3">
								<div class="form-group">
									<label for="programa">Programa</label>
									<select id="programa" class="form-control input-sm select-inactivo">
									<?php

										$qry = "SELECT id_programa,nombre_programa,tipo_programa.desc_tipo_programa FROM $tbl_programa join $tbl_tipo_programa on $tbl_tipo_programa.id_tipo_programa = $tbl_programa.id_tipo_programa  ORDER BY nombre_programa ASC";
										$qryArray = mysql_query($qry);
										
										while ($qryData = mysql_fetch_array($qryArray)) {
											echo "<option value='".$qryData['id_programa']."'>".$qryData['nombre_programa']." (".$qryData["desc_tipo_programa"].")</option>";
										}

									?>									
									</select>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label for="lote">Lote</label>
									<select id="lote" class="form-control input-sm">
									<?php

										$qry = "SELECT id_lote,nombre_lote,nivel_lote,fecha_vencimiento FROM $tbl_lote ORDER BY nombre_lote ASC";
										$qryArray = mysql_query($qry);
										
										while ($qryData = mysql_fetch_array($qryArray)) {
											echo "<option value='".$qryData['id_lote']."'>".$qryData['nombre_lote']." | nivel: ".$qryData['nivel_lote']." | fecha de vencimiento: ".$qryData['fecha_vencimiento']."</option>";
										}

									?>
									</select>
								</div>
							</div>
							<div class="col-xs-3">
								<div class="form-group">
									<label for="mes">Mes</label>
									<input type="month" class='form-control input-sm' id='mes' value='<?php echo date("Y-m") ?>'>
								</div>
							</div>

						</div>
						<div class="row"></div>
						<hr/>
						
						<!-- Gestiones -->
						<div class="datos" id="cont_valores_estadisticos">
							<button id="btn-agregar-fila" class='btn btn-default'><i class="glyphicon glyphicon-plus"></i> Agregar gestión</button>
							<div class="cont-tabla scroll" id="cont-tabla-gestiones">
							</div>
						</div>


						<hr>

						<div class="cont-boton-enviar">
							<button class="boton-enviar btn btn-success" id='btn_enviar_digitacion'><i class="glyphicon glyphicon-floppy-disk"></i> Guardar información</button>
							<a href="listado_digitacion.php" class='btn btn-warning'><i class='glyphicon glyphicon-folder-open'></i> Ver registros</a>
						</div>

						<!-- Fin de la seccion de gestiones -->
					</div>	
				</div>
			</div>
		</div>
	<script src="jquery/jquery-2.1.4.min.js?v12"></script>	
	<script src="jquery/jquery-ui.min.js?v12"></script>	
	<script src="javascript/bootstrap.min.js?v12"></script>
	<script src="javascript/sweetalert.min.js?v12"></script>

	<!-- Eventos y funciones alternas -->
	<script src="javascript/eliminarOptions.js?v12"></script>
	<script src="javascript/evaluarGeneracionVitros.js?v12"></script>
	<script src="javascript/eventoAsignarFloat.js?v12"></script>
	<script src="javascript/eventoEliminarFila.js?v12"></script>
	<script src="javascript/gestionSelectsSolicitud.js?v12"></script>
	<script src="javascript/listarElementos.js?v12"></script>
	<script src="javascript/listarSelect.js?v12"></script>
	<script src="javascript/resaltarCampoDigitacion.js?v12"></script>
	<script src="javascript/validarDigitacion.js?v12"></script>
	<script src="javascript/alertarDigitacion.js?v12"></script>
	<script src="javascript/validarItemsSeleccionados.js?v12"></script>
	<script src="javascript/eventoAgregarFilaGestion.js?v12"></script>
	<script src="javascript/eventoChangeAnalizador.js?v12"></script>
	<script src="javascript/eventoCalcularCV.js?v12"></script>

	<script src="jquery/jquery.statusBox.js?v12"></script>
	<script src="javascript/digitacion.js?v12"></script>
	<script src="javascript/tipoProgramaCualitativo.js?v12"></script>
	<script src="javascript/validarSiJSON.js?v12"></script>
	</body>
</html>