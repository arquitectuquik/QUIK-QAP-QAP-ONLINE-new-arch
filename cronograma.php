<?php
/**
 * QAP Online - Módulo de Cronograma
 * Migrado a PHP 7+ con compatibilidad MySQL mejorada
 */
session_start();
include_once "php/verifica_sesion.php";
actionRestriction_102();

// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}

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
	</head>
	<body onload="initialize();" class="transparent-body">
		<div class="col-xs-12 margin-top-1">
			<div class="col-xs-12">
				<div class="panel panel-default shadow no-margin no-padding">
					<div class="panel-heading cube-box">
						<span style="margin: 1%; font-size: 16pt;">Cronograma de muestras reportadas</span>
					</div>
					<div class="panel-body">
						<div class="col-xs-6 no-margin no-padding" id="form1">
							<div class="col-xs-6">
								<div class="form-group" >
									<label for="form1input1">Programa</label>
									<select id="form1input1" class="form-control input-sm">
<?php
// Consulta de programas con manejo de errores mejorado
$qry = "SELECT id_programa, nombre_programa FROM $tbl_programa ORDER BY nombre_programa ASC";
$qryArray = mysql_query($qry);

if (!$qryArray) {
    echo "<option value=''>Error al cargar programas: " . mysql_error() . "</option>";
} else {
    while ($qryData = mysql_fetch_array($qryArray)) {
        if ($qryData) {
            echo "<option value='" . htmlspecialchars($qryData['id_programa']) . "'>" . htmlspecialchars($qryData['nombre_programa']) . "</option>";
        }
    }
}

?>
									</select>
								</div>
							</div>
							<div class="col-xs-6">
								<div class="form-group">
									<label for="form1input2">Muestra</label>
									<select id="form1input2" class="form-control input-sm"></select>
								</div>
							</div>
						</div>
						<div class="col-xs-4">
							<div class="form-group">
								<button id="form1input3" class="btn btn-default input-block" title="Actualizar" style="margin-top: 22px;"><span class="glyphicon glyphicon-refresh"></span></button>
								<button id="form1input4" class="btn btn-default input-block" style="margin-top: 22px;">Generar informe de mensurandos reportados</button>
							</div>	
						</div>						
						<div class="row"></div>
						<hr/>
						<div class="col-xs-12 no-margin no-padding">
							<div class="col-xs-6 border-right" style="height: 75vh; max-height: 75vh; overflow: auto;">
								<table class="table table-default" id="table1">
									<thead>
										<tr>
											<th class="center-text" colspan="3">LABORATORIOS CON REPORTE DE MUESTRA</th>
										</tr>
										<tr>
											<th colspan="3"><input type="text" class="form-control input-sm" data-search-input="true" placeholder="Buscar..." onkeyup="functionHandler('tableSearch',this);"/></th>
										</tr>
										<tr>
											<th class="center-text">Número de laboratorio</th>
											<th class="center-text">Nombre de laboratorio</th>
											<th class="center-text">Fecha de reporte</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
							<div class="col-xs-6 border-left" style="height: 75vh; max-height: 75vh; overflow: auto;">
								<table class="table table-default" id="table2">
									<thead>
										<tr>
											<th class="center-text" colspan="2">LABORATORIOS SIN REPORTE DE MUESTRA</th>
										</tr>
										<tr>
											<th colspan="2"><input type="text" class="form-control input-sm" data-search-input="true" placeholder="Buscar..." onkeyup="functionHandler('tableSearch',this);"/></th>
										</tr>
										<tr>
											<th class="center-text">Número de laboratorio</th>
											<th class="center-text">Nombre de laboratorio</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>							
							</div>							
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12" id="tableToExcelWrapper" hidden="hidden">
				<table id="table3">
					<thead style="border: 1.25pt solid;">
					</thead>
					<tbody style="border: 1.25pt solid;">
					</tbody>
				</table>
			</div>
		</div>
	<script src="jquery/jquery-2.1.4.min.js?v12"></script>	
	<script src="jquery/jquery-ui.min.js?v12"></script>	
	<script src="javascript/bootstrap.min.js?v12"></script>
	<script src="jquery/jquery.table2excel.min.js?v12"></script>
	<script src="jquery/jquery.statusBox.js?v12"></script>
	<script src="javascript/cronograma.js?v12"></script>			
	</body>
</html>