<?php
/**
 * QAP Online - Módulo de Resultados
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
	<link href="fontawesome/css/all.min.css?v12" rel="stylesheet">
	<link href="css/pagina.css?v12" rel="stylesheet" media="screen">
</head>

<body onload="initialize();">

	<div class="col-xs-12 no-margin no-padding">
		<div class="col-xs-2" style="height: 100vh; overflow: auto;">
			<span class="glass"></span>
			<div class="col-xs-12 margin-top-6 no-padding" id="form1">
				<div class="form-group">
					<label for="form1input1">Laboratorio</label>
					<select class="form-control input-sm" id="form1input1" name="labid">
						<?php
						// Consulta mejorada con manejo de errores
						$qry = "SELECT id_laboratorio, no_laboratorio, nombre_laboratorio FROM $tbl_laboratorio WHERE no_laboratorio LIKE '%100%' OR no_laboratorio LIKE '%300%' ORDER BY no_laboratorio ASC";

						$qryArray = mysql_query($qry);
						if (!$qryArray) {
							echo "<option value=''>Error al cargar laboratorios</option>";
						} else {
							while ($qryData = mysql_fetch_array($qryArray)) {
								if ($qryData) {
									echo "<option value='" . htmlspecialchars($qryData['id_laboratorio']) . "'>" . htmlspecialchars($qryData['no_laboratorio']) . " | " . htmlspecialchars($qryData['nombre_laboratorio']) . "</option>";
								}
							}
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="form1input2">Programa</label>
					<select class="form-control input-sm" id="form1input2" name="programid"></select>
					<input type="text" id="form21input20" hidden="hidden" name="programtypeid" />
				</div>
				<div class="form-group">
					<label for="form1input3">Ronda</label>
					<select class="form-control input-sm" id="form1input3" name="roundid"></select>
				</div>
				<div class="form-group">
					<label for="form1input4">Muestra</label>
					<select class="form-control input-sm" id="form1input4" name="sampleid"></select>
				</div>
				<div class="checkbox">
					<label for="fechas_corte_personalizadas">
						<input type="checkbox" id="fechas_corte_personalizadas" value="0" />Fechas de corte
						personalizadas
					</label>
				</div>
				<div id="fechas_corte">
					<!--<div class="form-group">
							<label for="form1input_fecha_corte">Fecha Corte</label>
							<input class="form-control input-sm" type="date" id='form1input_fecha_corte'  name="fecha_corte">
						</div>
						-->
				</div>

				<div class="form-group">
					<input type="button" class="btn btn-default btn-sm btn-block" value="Editar media de comparación"
						onmouseup="functionHandler('windowHandler','open','window1');" id="form1input14" />
				</div>
				<div class="form-group">
					<input type="button" class="btn btn-default btn-sm btn-block" value="Editar valor de referencia"
						onmouseup="functionHandler('windowHandler','open','window2');" id="form1input16" />
				</div>
				<hr />
				<div class="col-xs-12 no-padding" style='display:none'>
					<b>Generar N, ME, DE basado en:</b>
				</div>
				<div class="form-group" style='display:none'>
					<div class="radio">
						<label for="form1input5"><input type="radio" id="form1input5" name="ntype" value="1" />Grupo
							par</label>
					</div>
					<div class="radio">
						<label for="form1input6"><input type="radio" id="form1input6" name="ntype" checked="true"
								value="2" />Grupo método</label>
					</div>
					<div class="checkbox">
						<label for="form1input11" style='display: none'><input type="checkbox" id="form1input11"
								value="1" />Contar valores QAP</label>
					</div>
				</div>
				<hr />
				<div class="col-xs-12 no-padding">
					<b>Alarmas:</b>
				</div>
				<div class="form-group">
					<div class="checkbox">
						<label for="form1input7"><input type="checkbox" id="form1input7" checked="true"
								value="1" />Resultado tardío</label>
					</div>
					<div class="checkbox">
						<label for="form1input8"><input type="checkbox" id="form1input8" checked="true"
								value="1" />Resultado ausente</label>
					</div>
					<div class="checkbox">
						<label for="form1input9"><input type="checkbox" id="form1input9" checked="true"
								value="1" />Resultado revalorado</label>
					</div>
				</div>
				<hr />
				<div class="form-group">
					<label for="form1input15">Estado de reporte</label>
					<select class="form-control input-sm" id="form1input15" name="reportsatus">
						<?php
						// Consulta de estados de reporte con manejo de errores
						$qry = "SELECT id_tipo_estado_reporte, desc_tipo_estado_reporte FROM $tbl_tipo_estado_reporte ORDER BY id_tipo_estado_reporte ASC";
						$qryArray = mysql_query($qry);
						if (!$qryArray) {
							echo "<option value=''>Error al cargar estados</option>";
						} else {
							while ($qryData = mysql_fetch_array($qryArray)) {
								if ($qryData) {
									echo "<option value='" . htmlspecialchars($qryData['id_tipo_estado_reporte']) . "'>" . htmlspecialchars($qryData['desc_tipo_estado_reporte']) . "</option>";
								}
							}
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<button type="button" class="btn btn-success btn-sm btn-block" id="form1input10general">Generar
						informe</button>
				</div>

				<div class="form-group">
					<button type="button" class="btn btn-success btn-sm btn-block" id="form1input10">Generar
						informe Uroanalisis</button>
				</div>

				<div class="form-group">
					<button type="button" class="btn btn-sm btn-block" id="form1input_QAPFOR07"
						style='color:#fff; background-color: #3f4c57 !important;'>
						<i class="fas fa-file-pdf" style='margin-right: 5px;'></i> Generar QAP-FOR-07
					</button>
				</div>

				

				<div class="form-group" style='display:none'>
					<div class="checkbox">
						<label for="form1input13"><input type="checkbox" id="form1input13" checked />Exportar PDF
							directamente</label>
					</div>
				</div>
				<hr />
				<div class="form-group">
					<button type="button" class="btn btn-default btn-sm btn-block" id="form1input12">Eliminar archivos
						temporales</button>
				</div>
			</div>
		</div>
		<div class="col-xs-10 floating center" id="window1" hidden="hidden" data-item="window">
			<div class="panel panel-default shadow" id="w1p">
				<div class="panel-heading">
					Editar media de comparación
					<button onmouseup="functionHandler('windowHandler','close','window1');" type="button" class="close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="panel-body no-padding" style="height: 75vh; max-height: 75vh;">
					<div class="col-xs-12" style="max-height: inherit; overflow: auto;">
						<div class="col-xs-6">
							<br>
							<label for="fecha-corte">Fecha de corte para consenso</label>
							<input type="date" id='fecha-corte' value='<?php echo Date('Y-m-d') ?>'>
						</div>
						<div class="col-xs-6 border-left">
							<div class="form-group margin-top-1">
								<button id="form23input3" class="btn btn-success btn-lg btn-block" type="button"><span
										class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
							</div>
							<div class="form-group" style='display: none'>
								<label for="form21input21">Método de guardado</label>
								<select class="form-control input-sm" id="form21input21" name="labid">
									<option value="1">Configuración exacta (Mensurando, Analizador, Método, Reactivo,
										Unidades, Gen VITROS)</option>
									<option value="2" selected="selected">Grupo método 1 (Mensurando, Método, Reactivo,
										Unidades)</option>
									<option value="4">Grupo método 2 (Mensurando, Método, Unidades)</option>
									<option value="3">Grupo par (Mensurando, Analizador, Método, Reactivo, Unidades)
									</option>
								</select>
							</div>
							<div class="form-group" style='display: none'>
								<input type="checkbox" checked="true" id="form21input12" />
								<label for="form21input12">Guardar estos valores para el laboratorio
									seleccionado</label>
								<br />
								<span style="font-size: 8pt;">(Si esta opción está seleccionada, la lista 'Método de
									guardado' no tendrá efecto)</span>
							</div>
						</div>
						<div class="row"></div>
						<hr />
						<table class="table table-condensed table-bordered" id="table23">
							<thead>
								<tr>
									<th colspan="27"><input type="text" class="form-control input-sm"
											data-search-input="true" placeholder="Buscar..."
											onkeyup="functionHandler('tableSearch',this);" /></th>
								</tr>
								<tr>
									<th class="center-text" rowspan="2">Nombre de programa</th>
									<th class="center-text" rowspan="2">Mensurando</th>
									<th class="center-text" rowspan="2">Analizador</th>
									<th class="center-text" rowspan="2">Metodología</th>
									<th class="center-text" rowspan="2">Reactivo</th>
									<th class="center-text" rowspan="2">Unidad</th>
									<th class="center-text" rowspan="2">Gen VITROS</th>
									<th class="center-text" rowspan="1" colspan="6" data-lvl="1" style="display: none;">
										<span>Nivel 1 </span><button id="table23Input1" type="button"
											class="pull-right hidden" title="Ocultar" data-status="1"
											data-btn-lvl="1"><span
												class="glyphicon glyphicon-triangle-left"></span></button>
									</th>
									<th class="center-text" rowspan="1" colspan="6" data-lvl="2" style="display: none;">
										<span>Nivel 2 </span><button id="table23Input2" type="button"
											class="pull-right hidden" title="Ocultar" data-status="1"
											data-btn-lvl="2"><span
												class="glyphicon glyphicon-triangle-left"></span></button>
									</th>
									<th class="center-text" rowspan="1" colspan="6" data-lvl="3" style="display: none;">
										<span>Nivel 3 </span><button id="table23Input3" type="button"
											class="pull-right hidden" title="Ocultar" data-status="1"
											data-btn-lvl="3"><span
												class="glyphicon glyphicon-triangle-left"></span></button>
									</th>
									<th class="center-text" rowspan="1" colspan="1" data-lvl="0" style="display: none;">
										<span>Nivel 0 </span><button id="table23Input4" type="button"
											class="pull-right hidden" title="Ocultar" data-status="1"
											data-btn-lvl="0"><span
												class="glyphicon glyphicon-triangle-left"></span></button>
									</th>
									<th class="center-text" rowspan="2">Consenso</th>
								</tr>
								<tr>
									<th class="center-text" data-lvl="1" style="display: none;"><span>P25</span></th>
									<th class="center-text" data-lvl="1" style="display: none;"><span>ME</span></th>
									<th class="center-text" data-lvl="1" style="display: none;"><span>P75</span></th>
									<th class="center-text" data-lvl="1" style="display: none;"><span>DE</span></th>
									<th class="center-text" data-lvl="1" style="display: none;"><span>CV %</span></th>
									<th class="center-text" data-lvl="1" style="display: none;"><span>N</span></th>
									<th class="center-text" data-lvl="2" style="display: none;"><span>P25</span></th>
									<th class="center-text" data-lvl="2" style="display: none;"><span>ME</span></th>
									<th class="center-text" data-lvl="2" style="display: none;"><span>P75</span></th>
									<th class="center-text" data-lvl="2" style="display: none;"><span>DE</span></th>
									<th class="center-text" data-lvl="2" style="display: none;"><span>CV %</span></th>
									<th class="center-text" data-lvl="2" style="display: none;"><span>N</span></th>
									<th class="center-text" data-lvl="3" style="display: none;"><span>P25</span></th>
									<th class="center-text" data-lvl="3" style="display: none;"><span>ME</span></th>
									<th class="center-text" data-lvl="3" style="display: none;"><span>P75</span></th>
									<th class="center-text" data-lvl="3" style="display: none;"><span>DE</span></th>
									<th class="center-text" data-lvl="3" style="display: none;"><span>CV %</span></th>
									<th class="center-text" data-lvl="3" style="display: none;"><span>N</span></th>
									<th class="center-text" data-lvl="0" style="display: none;">
										<span>Resultado de referencia</span>
									</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-10 floating center" id="window2" hidden="hidden" data-item="window">
			<div class="panel panel-default shadow" id="w2p">
				<div class="panel-heading">
					Editar valor de referencia
					<button onmouseup="functionHandler('windowHandler','close','window2');" type="button" class="close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="panel-body no-padding" style="height: 75vh; max-height: 75vh;">
					<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">
						<form class="margin-top-2" id="form8">
							<div class="form-group">
								<label for="form8input6">Mensurando</label>
								<select class="form-control input-sm" id="form8input6" name="analitid"></select>
							</div>
							<div class="form-group">
								<label for="form8input3">Analizador</label>
								<select class="form-control input-sm" id="form8input3" name="analyzerid"></select>
							</div>
							<div class="form-group">
								<label for="form8input4">Metodología</label>
								<select class="form-control input-sm" id="form8input4" name="methodid"></select>
							</div>
							<div class="form-group">
								<label for="form8input7">Unidad</label>
								<select class="form-control input-sm" id="form8input7" name="unitid"></select>
							</div>
							<div class="form-group">
								<label for="form8input5">Valor de referencia</label>
								<input type="text" class="form-control input-sm" id="form8input5" name="referencevalue"
									data-default="true" />
							</div>
							<hr />
							<div class="form-group">
								<center>
									<input type="submit" class="btn btn-default" value="Agregar" />
								</center>
							</div>
						</form>
					</div>
					<div class="col-xs-8" style="max-height: inherit; overflow: auto;">
						<table class="table table-condensed" id="table26">
							<thead>
								<tr>
									<th colspan="7"><input type="text" class="form-control input-sm"
											data-search-input="true" placeholder="Buscar..."
											onkeyup="functionHandler('tableSearch',this);" /></th>
								</tr>
								<tr>
									<th class="center-text">Programa</th>
									<th class="center-text">Muestra</th>
									<th class="center-text">Mensurando</th>
									<th class="center-text">Metodología</th>
									<th class="center-text">Unidad</th>
									<th class="center-text">Valor de referencia</th>
									<th class="center-text">Eliminar</th>
								</tr>
							</thead>
							<tbody>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-10 no-margin no-padding" style="height: 100vh; overflow: auto; background-color: #525659;">
			<div class="col-xs-12 no-padding" id="form2" style="height: inherit;">
				<div style="position: absolute; width: 100%; height: 40px; top: 0; left: 0; right: 0; z-index: 1;"
					class="cont-comentarios-reporte">
					<nav class="navbar navbar-default cube-box no-margin no-padding transparent-body">
						<span class="glass"></span>
						<ul class="nav navbar-nav inner-nav" style="padding: 5px 0px 5px 0px;">
							<button type="button" class="btn btn-primary btn-sm" id="boton-resumen-comentarios"
								style='margin-left: 8px'>Comentarios de resultados <span class="badge">0</span></button>
						</ul>
					</nav>
				</div>
				<iframe frameborder="0"
					style="position: absolute; width: 100%; height: calc(100vh - 40px); bottom: 0; left: 0; right: 0; top: 40px; z-index: 1;"
					id="form2InnerFrame1" allowtransparency="true"></iframe>
			</div>
		</div>
		<div class="col-xs-10 floating center" id="miVentanaResultadosConsenso" hidden="hidden" data-item="window">
			<div class="panel panel-default shadow" id="miVentanaResultadosConsensoPanel">
				<div class="panel-heading title-bar-custom">
					<span class="title-text">Resultados de Laboratorio para Consenso</span>
					<button onmouseup="functionHandler('windowHandler','close','miVentanaResultadosConsenso');"
						type="button" class="close" aria-label="Cerrar">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="panel-body">
					<p>ID Configuración de Consenso (Fila Origen): <span id="infoIdConfigConsenso">N/A</span></p>
					<hr>

					<table class="table-resultados-lab">
						<thead>
							<tr>
								<th class="select-checkbox-header">
									<input type="checkbox" id="selectAllResultadosConsenso" title="Seleccionar todos">
								</th>
								<th>IT</th>
								<th>Resultado</th>
								<th>Fecha</th>
								<th>Ronda</th>
								<th>Muestra</th>
								<th>ID Laboratorio</th>
								<th>Nombre Laboratorio</th>
								<th>Nombre Metodología</th>
							</tr>
						</thead>
						<tbody id="tbodyResultadosConsenso">
							<tr>
								<td class="select-checkbox-cell"><input type="checkbox"
										name="seleccion_resultado_consenso[]" value="1"></td>
								<td>1</td>
								<td>11.0</td>
								<td>2024-11-08</td>
								<td>44</td>
								<td>(L) DG1223</td>
								<td>100270</td>
								<td>E.S.E Gámeza Municipio Saludable</td>
								<td>Calculado</td>
							</tr>
							<tr>
								<td class="select-checkbox-cell"><input type="checkbox"
										name="seleccion_resultado_consenso[]" value="2" checked></td>
								<td>2</td>
								<td>15.5</td>
								<td>2024-11-09</td>
								<td>44</td>
								<td>(L) DG1224</td>
								<td>100271</td>
								<td>Laboratorio Central Ejemplo</td>
								<td>Fotométrico</td>
							</tr>
						</tbody>
					</table>

					<button class="action-button-custom" id="btnProcesarSeleccionConsenso">Procesar
						Seleccionados</button>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-10 floating center" id="windowComentarios" hidden="hidden" data-item="window">
		<div class="panel panel-default shadow" id="modal-comentarios">
			<div class="panel-heading">
				Comentarios de resultados
				<button onmouseup="functionHandler('windowHandler','close','windowComentarios');" type="button"
					class="close">
					<span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span>
				</button>
			</div>
			<div class="panel-body no-padding body-color" style="height: 65vh; max-height: 65vh;"></div>
		</div>
	</div>


	<script src="jquery/jquery-2.1.4.min.js?v12"></script>
	<script src="jquery/jquery-ui.min.js?v12"></script>
	<script src="jquery/jquery.statusBox.js?v12"></script>
	<script src="jquery/jquery.numericInput.min.js?v12"></script>
	<script src="jquery/jquery.mathjs.js?v12"></script>
	<script src="javascript/bootstrap.min.js?v12"></script>
	<script src="javascript/resultado.js?v12"></script>
</body>

</html>