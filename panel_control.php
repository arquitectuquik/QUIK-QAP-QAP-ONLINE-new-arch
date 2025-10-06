<?php

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

	<link href="boostrap/css/bootstrap.min.css?v12-0" rel="stylesheet" media="screen">

	<link href="css/jquery-ui.min.css?v12-0" rel="stylesheet" media="screen">

	<link href="css/listado_digitacion.css?v12-0" rel="stylesheet" media="screen">

	<link href="css/pagina.css?v12-0" rel="stylesheet" media="screen">

</head>

<body onload="initialize();" class="transparent-body">

	<div class="col-xs-12 no-margin no-padding">

		<div class="col-xs-2" style="height: 100vh; overflow: auto;">

			<span class="glass"></span>

			<ul class="list-group">

				<hr />

				<li class="list-group-item pointer unselectable" data-id="panel1"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b
						title="Proveedor del material de CC usado en la ronda">Proveedor<span
							class="pull-right glyphicon icon-icon-4" style="width: 24px; height: 24px;"></span></b></li>

				<li class="list-group-item pointer unselectable" data-id="panel6"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Analizador<span
							class="pull-right glyphicon icon-icon-2" style="width: 24px; height: 24px;"></span></b></li>

				<li class="list-group-item pointer unselectable" data-id="panel14"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Programa<span
							class="pull-right glyphicon icon-icon-3" style="width: 24px; height: 24px;"></span></b></li>

				<li class="list-group-item pointer unselectable" data-id="panelProgramaPAT"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Programa <strong
							class='text-primary'>PAT</strong><span class="pull-right glyphicon icon-icon-15"
							style="width: 24px; height: 24px;"></span></b></li>

				<li class="list-group-item pointer unselectable" data-id="panel4"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Laboratorio<span
							class="pull-right glyphicon icon-icon-1" style="width: 24px; height: 24px;"></span></b></li>

				<hr />

				<li class="list-group-item pointer unselectable" data-id="panel10"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Usuario<span
							class="pull-right glyphicon icon-icon-7" style="width: 24px; height: 24px;"></span></b></li>

				<li class="list-group-item pointer unselectable" data-id="panel11"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Pais<span
							class="pull-right glyphicon icon-icon-5" style="width: 24px; height: 24px;"></span></b></li>

				<li id="logTab" class="list-group-item pointer unselectable" data-id="panel15"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Historial<span
							class="pull-right glyphicon icon-icon-6" style="width: 24px; height: 24px;"></span></b></li>

				<li id="logTabEnrolamiento" class="list-group-item pointer unselectable" data-id="panel16"
					onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b>Historial de enrolamiento<span
							class="pull-right glyphicon icon-icon-6" style="width: 24px; height: 24px;"></span></b></li>

			</ul>

		</div>

		<div class="col-xs-10 no-margin no-padding" style="height: 100vh; overflow: auto;">



			<div class="panel panel-default cube-box no-margin" id="panelProgramaPAT" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Programa <strong>PAT</strong> (Patología anatómica)</span>

				</div>

				<div class="panel-body cube-box no-padding">

					<nav class="navbar navbar-default cube-box no-margin no-padding">

						<ul class="nav navbar-nav inner-nav">

							<li class="pointer active-tab" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv1"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Asignar programa
									<strong>PAT</strong></a></li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv2"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Revaloración
									<strong>PAT</strong></a></li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv3"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Agregar reto</a>
							</li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv4"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Agregar caso
									clínico</a></li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv8"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Agregar
									referencia</a></li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv9"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Agregar
									imagen</a></li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv5"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Agregar grupo</a>
							</li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv6"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Agregar
									pregunta</a></li>

							<li class="pointer" style="font-size: 10pt" data-id="panelProgramaPATinnerDiv7"
								onmouseup="functionHandler('panelChooser',this, 'pProgramaPATid');"><a>Agregar
									distractor</a></li>

						</ul>

					</nav>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv1"
						data-id="pProgramaPATid">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formAsignarReto">

								<div class="form-group">

									<label for="AsignarRetoinput1">Laboratorio</label>

									<select class="form-control input-sm" id="AsignarRetoinput1" data-default="true"
										name="labid"></select>

								</div>

								<div class="form-group">

									<label for="AsignarRetoinput2">Reto PAT <strong
											class='text-primary'>*</strong></label>

									<select class="form-control input-sm" id="AsignarRetoinput2" data-default="true"
										name="retoid"></select>

								</div>

								<div class="form-group">

									<label for="AsignarRetoinput3">Envío</label>

									<select class="form-control input-sm" id="AsignarRetoinput3" data-default="true"
										name="envio">

										<option value="1">Primer envío</option>

										<option value="2">Segundo envío</option>

										<option value="3">Tercer envío</option>

										<option value="4">Cuarto envío</option>

									</select>

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

							<table class="table table-condensed" id="tableAsignarReto">

								<thead>

									<tr>

										<th colspan="6"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Número de laboratorio</th>

										<th class="center-text">Nombre de laboratorio</th>

										<th class="center-text">Nombre de programa PAT <strong
												class='text-primary'>*</strong></th>

										<th class="center-text">Nombre de reto <strong class='text-primary'>*</strong>
										</th>

										<th class="center-text">Envío de reto<strong class='text-primary'>*</strong>
										</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv2"
						data-id="pProgramaPATid" hidden="hidden">



						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formRevalPat">

								<div class="form-group">

									<label for="formRevalPatinput1">Reto PAT <strong
											class='text-primary'>*</strong></label>

									<select class="form-control input-sm" id="formRevalPatinput1" data-default="true"
										name="retoid"></select>

								</div>

								<hr />

								<p>Mediante esta función, permitirá al usuario patólogo presentar su examen en una
									<strong>nueva oportunidad</strong> (o lo que se conoce dentro de QAP Online como
									<strong>"intento"</strong>)
								</p>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tableIntentosPAT">

								<thead>

									<tr>

										<th colspan="6"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Reto <strong class='text-primary'>*</strong></th>

										<th class="center-text">Laboratorio</th>

										<th class="center-text">Usuario</th>

										<th class="center-text">#Intentos</th>

										<th class="center-text">Ultima fecha</th>

										<th class="center-text">Permitir nuevo intento</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv3"
						data-id="pProgramaPATid" hidden="hidden">



						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formRetoPAT">

								<div class="form-group">

									<label for="formRetoPATinput1">Programa PAT <strong
											class='text-primary'>*</strong></label>

									<select class="form-control input-sm" id="formRetoPATinput1"
										name="programa_pat_id"></select>

									<small>Si un programa de patología anatómica NO existe en este listado, por favor
										comuníquese en con un superadministrador para que lo ingrese directamente en la
										base de datos</small>

								</div>

								<div class="form-group">

									<label for="formRetoPATinput2">Lote</label>

									<select class="form-control input-sm" id="formRetoPATinput2"
										name="lote_id"></select>

									<small>Si un lote NO existe en este listado, por favor comuníquese en con un
										superadministrador para que lo ingrese directamente en la base de datos</small>

								</div>

								<div class="form-group">

									<label for="formRetoPATinput3">Nombre del reto</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formRetoPATinput3" name="nom_lote">

								</div>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar">

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tableRetosPAT">

								<thead>

									<tr>

										<th colspan="6"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Programa PAT</th>

										<th class="center-text">Lote PAT</th>

										<th class="center-text">Nombre</th>

										<th class="center-text">Estado</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv4"
						data-id="pProgramaPATid" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formCasoClinicoPAT">

								<div class="form-group">

									<label for="formCasoClinicoPATinput1">Reto <strong
											class='text-primary'>*</strong></label>

									<select class="form-control input-sm" id="formCasoClinicoPATinput1"
										name="reto_id"></select>

								</div>

								<div class="form-group">

									<label for="formCasoClinicoPATinput2">Código</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formCasoClinicoPATinput2" name="codigo">

								</div>

								<div class="form-group">

									<label for="formCasoClinicoPATinput3">Nombre</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formCasoClinicoPATinput3" name="nombre">

								</div>

								<div class="form-group">

									<label for="formCasoClinicoPATinput4">Enunciado</label>

									<textarea class="form-control input-sm" name="enunciado"
										id="formCasoClinicoPATinput4" data-form-reset="true" cols="30"
										rows="5"></textarea>

									<small>Si este campo no aplica, ingrese un cero "0"</small>

								</div>

								<div class="form-group">

									<label for="formCasoClinicoPATinput5">Revisión</label>

									<textarea class="form-control input-sm" name="revision"
										id="formCasoClinicoPATinput5" data-form-reset="true" cols="30"
										rows="5"></textarea>

									<small>Si este campo no aplica, ingrese un cero "0"</small>

								</div>

								<div class="form-group">

									<label for="formCasoClinicoPATinput6">Tejido</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formCasoClinicoPATinput6" name="tejido">

									<small>Si este campo no aplica, ingrese un cero "0"</small>

								</div>

								<div class="form-group">

									<label for="formCasoClinicoPATinput7">Células objetivo</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formCasoClinicoPATinput7" name="celulas_objetivo">

									<small>Si este campo no aplica, ingrese un cero "0"</small>

								</div>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar">

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tableCasosClinicosPAT">

								<thead>

									<tr>

										<th colspan="9"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Reto PAT</th>

										<th class="center-text">Código</th>

										<th class="center-text">Nombre</th>

										<th class="center-text">Enunciado</th>

										<th class="center-text">Revisión</th>

										<th class="center-text">Tejido</th>

										<th class="center-text">Células objetivo</th>

										<th class="center-text">Estado</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv8"
						data-id="pProgramaPATid" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formReferenciaPAT">

								<div class="form-group">

									<label for="formReferenciaPATinput1">Reto</label>

									<select class="form-control input-sm" id="formReferenciaPATinput1"
										name="reto_id"></select>

								</div>

								<div class="form-group">

									<label for="formReferenciaPATinput2">Caso clínico</label>

									<select class="form-control input-sm" id="formReferenciaPATinput2"
										name="caso_clinico_id"></select>

								</div>

								<div class="form-group">

									<label for="formReferenciaPATinput3">Descripción</label>

									<textarea data-form-reset="true" class="form-control input-sm"
										id="formReferenciaPATinput3" name="descripcion" cols="30" rows="5"></textarea>

								</div>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar">

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tableReferenciasPAT">

								<thead>

									<tr>

										<th colspan="5"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Caso clínico</th>

										<th class="center-text">Descripción</th>

										<th class="center-text">Estado</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv9"
						data-id="pProgramaPATid" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formImagenPAT">

								<div class="form-group">

									<label for="formImagenPATinput1">Reto</label>

									<select class="form-control input-sm" id="formImagenPATinput1"
										name="reto_id"></select>

								</div>

								<div class="form-group">

									<label for="formImagenPATinput2">Caso clínico</label>

									<select class="form-control input-sm" id="formImagenPATinput2"
										name="caso_clinico_id"></select>

								</div>

								<div class="form-group">

									<label for="formImagenPATinput3">Tipo</label>

									<select id="formImagenPATinput3" class="form-control input-sm" name="tipo">

										<option value="1">Aparecerá en el formulario</option>

										<option value="2">Aparecerá en el reporte</option>

									</select>

								</div>

								<div class="form-group">

									<label for="formImagenPATinput4">Ruta</label>

									<input data-form-reset="true" type="text" class="form-control input-sm"
										id="formImagenPATinput4" name="ruta">

									<small>El nombre de la imagen con extensión (ej: imagenes/P1CITNG98.jpg)</small>

									<small>La imagen debe encontrarse en la ruta "php/informe/" (solicite previamente a
										el superadministrador que carge la imagen en el servidor)</small>

								</div>

								<div class="form-group">

									<label for="formImagenPATinput5">Nombre</label>

									<input data-form-reset="true" type="text" class="form-control input-sm"
										id="formImagenPATinput5" name="nombre">

								</div>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar">

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tableImagenesPAT">

								<thead>

									<tr>

										<th colspan="6"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Caso clínico</th>

										<th class="center-text">Tipo</th>

										<th class="center-text">Ruta</th>

										<th class="center-text">Nombre</th>

										<th class="center-text">Estado</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv5"
						data-id="pProgramaPATid" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formGrupo">

								<div class="form-group">

									<label for="formGrupoinput1">Reto</label>

									<select class="form-control input-sm" id="formGrupoinput1" name="reto_id"></select>

								</div>

								<div class="form-group">

									<label for="formGrupoinput2">Caso clínico</label>

									<select class="form-control input-sm" id="formGrupoinput2"
										name="caso_clinico_id"></select>

								</div>

								<div class="form-group">

									<label for="formGrupoinput5">Nombre</label>

									<input data-form-reset="true" type="text" class="form-control input-sm"
										id="formGrupoinput5" name="nombre">

								</div>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar">

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tableGruposPAT">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Caso clínico</th>

										<th class="center-text">Nombre</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv6"
						data-id="pProgramaPATid" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formPregunta">

								<div class="form-group">

									<label for="formPreguntainput1">Reto</label>

									<select class="form-control input-sm" id="formPreguntainput1"
										name="reto_id"></select>

								</div>

								<div class="form-group">

									<label for="formPreguntainput2">Caso clínico</label>

									<select class="form-control input-sm" id="formPreguntainput2"
										name="caso_clinico_id"></select>

								</div>

								<div class="form-group">

									<label for="formPreguntainput3">Grupo</label>

									<select class="form-control input-sm" id="formPreguntainput3"
										name="grupo_id"></select>

								</div>

								<div class="form-group">

									<label for="formPreguntainput4">Nombre</label>

									<input data-form-reset="true" type="text" class="form-control input-sm"
										id="formPreguntainput4" name="nombre">

								</div>

								<div class="form-group">

									<label for="formPreguntainput5">Minimo</label>

									<input type="text" class="form-control input-sm" id="formPreguntainput5" value="0"
										name="minimo">

									<small>Si este campo no aplica, ingrese un cero "0"</small>

								</div>

								<div class="form-group">

									<label for="formPreguntainput6">Máximo</label>

									<input type="text" class="form-control input-sm" id="formPreguntainput6" value="0"
										name="maximo">

									<small>Si este campo no aplica, ingrese un cero "0"</small>

								</div>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar">

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tablePreguntasPAT">

								<thead>

									<tr>

										<th colspan="6"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Caso clínico</th>

										<th class="center-text">Grupo</th>

										<th class="center-text">Nombre</th>

										<th class="center-text">Mínimo</th>

										<th class="center-text">Máximo</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panelProgramaPATinnerDiv7"
						data-id="pProgramaPATid" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formDistractor">

								<div class="form-group">

									<label for="formDistractorinput1">Reto</label>

									<select class="form-control input-sm" id="formDistractorinput1"
										name="reto_id"></select>

								</div>

								<div class="form-group">

									<label for="formDistractorinput2">Caso clínico</label>

									<select class="form-control input-sm" id="formDistractorinput2"
										name="caso_clinico_id"></select>

								</div>

								<div class="form-group">

									<label for="formDistractorinput3">Grupo</label>

									<select class="form-control input-sm" id="formDistractorinput3"
										name="grupo_id"></select>

								</div>

								<div class="form-group">

									<label for="formDistractorinput4">Pregunta</label>

									<select class="form-control input-sm" id="formDistractorinput4"
										name="pregunta_id"></select>

								</div>

								<div class="form-group">

									<label for="formDistractorinput5">Abreviatura</label>

									<input type="text" class="form-control input-sm" id="formDistractorinput5" value="0"
										name="abreviatura">

									<small>Si este campo no aplica, ingrese un cero "0"</small>

								</div>

								<div class="form-group">

									<label for="formDistractorinput6">Nombre</label>

									<input data-form-reset="true" type="text" class="form-control input-sm"
										id="formDistractorinput6" name="nombre">

								</div>

								<div class="form-group">

									<label for="formDistractorinput7">Valor</label>

									<input data-form-reset="true" type="text" class="form-control input-sm"
										id="formDistractorinput7" name="valor">

								</div>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar">

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="tableDistractoresPAT">

								<thead>

									<tr>

										<th colspan="6"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Pregunta</th>

										<th class="center-text">Abreviatura</th>

										<th class="center-text">Nombre</th>

										<th class="center-text">Valor</th>

										<th class="center-text">Estado</th>

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







			<div class="panel panel-default cube-box no-margin" id="panel1" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span title="Proveedor del material de CC usado en la Ronda">Proveedor del material de CC usado en
						la ronda</span>

				</div>

				<div class="panel-body cube-box no-padding no-padding transparent-body">

					<nav class="navbar navbar-default cube-box no-margin no-padding">

						<ul class="nav navbar-nav inner-nav">

							<li class="pointer active-tab" style="font-size: 10pt" data-id="panel1innerDiv4"
								onmouseup="functionHandler('panelChooser',this, 'p1id');"><a>Agregar Proveedor</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel1innerDiv1"
								onmouseup="functionHandler('panelChooser',this, 'p1id');"><a>Agregar catálogo</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel1innerDiv2"
								onmouseup="functionHandler('panelChooser',this, 'p1id');"><a>Agregar lote</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel1innerDiv3"
								onmouseup="functionHandler('panelChooser',this, 'p1id');"><a>Abrir o cerrar lote</a>
							</li>

						</ul>

					</nav>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel1innerDiv4"
						data-id="p1id">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form20">

								<div class="form-group">

									<label for="form1input1"
										title="Proveedor del material de CC usado en la ronda">Nombre de
										proveedor</label>

									<input data-form-reset="true" id="form1input4" name="disname"
										class="form-control input-sm" />

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

							<table class="table table-condensed" id="table19">

								<thead>

									<tr>

										<th colspan="2"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text" title="Proveedor del material de CC usado en la ronda">
											Nombre de proveedor</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel1innerDiv1" data-id="p1id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form1">

								<div class="form-group">

									<label for="form2input2"
										title="Proveedor del material de CC usado en la ronda">Proveedor
										perteneciente</label>

									<select class="form-control input-sm" id="form1input2" data-default="true"
										name="disid"></select>

								</div>

								<div class="form-group">

									<label for="form1input1">Nombre de catálogo</label>

									<input data-form-reset="true" id="form1input1" name="catname"
										class="form-control input-sm" />

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

							<table class="table table-condensed" id="table1">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text" title="Proveedor del material de CC usado en la ronda">
											Nombre de proveedor</th>

										<th class="center-text">Nombre de catálogo</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel1innerDiv2" data-id="p1id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form2">

								<div class="form-group">

									<label for="form2input2">Catálogo perteneciente</label>

									<select class="form-control input-sm" id="form2input2" data-default="true"
										name="catid"></select>

								</div>

								<div class="form-group">

									<label for="form2input1">Número de lote</label>

									<input type="text" data-form-reset="true" id="form2input1" name="lotnumber"
										class="form-control input-sm" />

								</div>

								<div class="form-group">

									<label for="form2input4">Fecha de vencimiento</label>

									<input type="date" data-form-reset="true" id="form2input4" name="lotdate"
										class="form-control input-sm" />

								</div>

								<div class="form-group">

									<label for="form2input3">Nivel de lote</label>

									<select class="form-control input-sm" id="form2input3" name="lotlevel">

										<option value="1">1</option>

										<option value="2">2</option>

										<option value="3">3</option>

									</select>

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

							<table class="table table-condensed" id="table2">

								<thead>

									<tr>

										<th colspan="4"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Nombre de catálogo</th>

										<th class="center-text">Número de lote</th>

										<th class="center-text">Fecha de vencimiento</th>

										<th class="center-text">Nivel de lote</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel1innerDiv3" data-id="p1id"
						hidden="hidden">

						<div class="col-xs-12">

							<table class="table table-condensed" id="table3">

								<thead>

									<tr>

										<th colspan="5"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Nombre de catálogo</th>

										<th class="center-text">Número de lote</th>

										<th class="center-text">Nivel de lote</th>

										<th class="center-text">Cerrado</th>

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

			<div class="panel panel-default cube-box no-margin" id="panel14" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Programa</span>

				</div>

				<div class="panel-body cube-box no-padding">

					<nav class="navbar navbar-default cube-box no-margin no-padding">

						<ul class="nav navbar-nav inner-nav">

							<li class="pointer active-tab" style="font-size: 10pt" data-id="panel14innerDiv1"
								onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Agregar programa</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv3"
								onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Agregar muestra</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv2"
								onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Agregar mensurando</a>
							</li>

							<!--<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv4" onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Configurar mensurando</a></li>-->

							<!--<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv5" onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Fijar medias</a></li>-->

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv6"
								onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Fijar ETmp /  APS </a>
							</li>

							<!--<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv8" onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Fijar valor de referencia</a></li>-->

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv9"
								onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Agregar valor de JCTLM</a>
							</li>

							<!-- <li class="pointer unselectable" style="font-size: 10pt" data-id="panel14innerDiv7" onmouseup="functionHandler('panelChooser',this, 'p14id');"><a>Clonar programa</a></li> -->

						</ul>

					</nav>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel14innerDiv1"
						data-id="p14id">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form14">

								<div class="form-group">

									<label for="form14input6">Tipo de programa</label>

									<select class="form-control input-sm" id="form14input6" name="programtype">

										<?php



										$qry = "SELECT id_tipo_programa,desc_tipo_programa FROM $tbl_tipo_programa ORDER BY id_tipo_programa ASC";

										$qryArray = mysql_query($qry);



										while ($qryData = mysql_fetch_array($qryArray)) {

											echo "<option value='" . $qryData['id_tipo_programa'] . "'>" . $qryData['desc_tipo_programa'] . "</option>";
										}



										?>

									</select>

								</div>

								<div class="form-group">

									<label for="form14input1">Nombre de programa</label>

									<input data-form-reset="true" id="form14input1" name="programname"
										class="form-control input-sm" />

								</div>

								<div class="form-group">

									<label for="form14input2">Sigla de programa</label>

									<input data-form-reset="true" id="form14input2" name="programabbr"
										class="form-control input-sm" />

								</div>

								<div class="form-group">

									<label for="form14input4">Tipo de muestra</label>

									<input data-form-reset="true" id="form14input4" name="sampletype"
										class="form-control input-sm" />

								</div>

								<div class="form-group">

									<label for="form14input5">Modalidad</label>

									<input data-form-reset="true" id="form14input5" name="programmodality"
										class="form-control input-sm" />

								</div>

								<div class="form-group">

									<label>Número de muestras</label>

									<input type="number" class="form-control input-sm" id="form14input3"
										name="programnosamples" value="6" />

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

							<table class="table table-condensed" id="table4">

								<thead>

									<tr>

										<th colspan="7"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Tipo de programa</th>

										<th class="center-text">Nombre de programa</th>

										<th class="center-text">Sigla de programa</th>

										<th class="center-text">Tipo de muestra</th>

										<th class="center-text">Modalidad</th>

										<th class="center-text">Número de muestras</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel14innerDiv2"
						data-id="p14id" hidden="hidden">

						<hr />

						<nav class="navbar navbar-default cube-box no-margin no-padding">

							<ul class="nav navbar-nav inner-nav">

								<li class="pointer unselectable active-tab" style="font-size: 10pt"
									data-id="panel14form3innerDiv3"
									onmouseup="functionHandler('panelChooser',this, 'p14_form3id');"><a>Agregar
										mensurando</a></li>

								<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14form3innerDiv1"
									onmouseup="functionHandler('panelChooser',this, 'p14_form3id');"><a>Asignar
										mensurando <span class='font-weight-bold text-primary'>*</span></a></li>

								<li class="pointer unselectable" style="font-size: 10pt" data-id="panel14form3innerDiv2"
									onmouseup="functionHandler('panelChooser',this, 'p14_form3id');"><a>Agregar
										resultado cualitativo</a></li>

							</ul>

						</nav>



						<div id="panel14form3innerDiv1" data-id="p14_form3id" hidden='hidden'>

							<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

								<form class="margin-top-2" id="form3">



									<div class="form-group">

										<label for="form3input1">Programa perteneciente</label>

										<select class="form-control input-sm" id="form3input1" data-default="true"
											name="programid"></select>

									</div>



									<div class="form-group">

										<label for="form3input2">Nombre de mensurando</label>

										<select class="form-control input-sm" id="form3input2" data-form-reset="true"
											name="analitid"></select>

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

								<table class="table table-condensed" id="table5">

									<thead>

										<tr>

											<th colspan="4"><input type="text" class="form-control input-sm"
													data-search-input="true" placeholder="Buscar..."
													onkeyup="functionHandler('tableSearch',this);" /></th>

										</tr>

										<tr>

											<th class="center-text">Nombre de programa</th>

											<th class="center-text">Nombre de mensurando</th>

											<th class="center-text">Eliminar</th>

										</tr>

									</thead>

									<tbody>

									</tbody>

								</table>

							</div>

						</div>


						<!-- es este -->
						<div id="panel14form3innerDiv2" data-id="p14_form3id" hidden="hidden">

							<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

								<form class="margin-top-2" id="form31">

									<div class="form-group">

										<label for="form31input1">Programa</label>

										<select class="form-control input-sm" id="form31input1" data-default="true"
											name="programid"></select>

									</div>

									<div class="form-group">

										<label for="form31input2">Mensurando</label>

										<select class="form-control input-sm" id="form31input2" data-default="true"
											name="analitid"></select>

									</div>

									<div class="form-group">

										<label for="form31input3">Descripción de resultado</label>

										<input data-form-reset="true" id="form31input3" name="analitresult"
											class="form-control input-sm" />

									</div>
									<div class="form-group">

										<label for="form31input4">Asignar Puntuación</label>

										<select class="form-control input-sm" id="form31input4" data-default="true"
											name="puntuacionid">
											<?php

											$qry = "SELECT id,valor FROM $tbl_puntuaciones ORDER BY valor ASC";
											$qryArray = mysql_query($qry);

											while ($qryData = mysql_fetch_array($qryArray)) {
												echo "<option value='" . $qryData['id'] . "'>" . $qryData['valor'] . " </option>";
											}
											?>
										</select>

									</div>

									<div class="alert alert-info margin-top-1" role="alert">



										<?php



										$qry = "SELECT valor_misc FROM $tbl_misc WHERE titulo_misc = 'separador_analito_resultado_reporte_cualitativo'";

										$qryData = mysql_fetch_array(mysql_query($qry));



										?>



										<p><strong>Tenga en cuenta las siguientes recomendaciones, antes de agregar
												resultados cualitativos:</strong></p>

										<ul>

											<li>Un rango se crea con dos numeros que se separan con un
												<kbd><?php echo $qryData['valor_misc']; ?></kbd>
											</li>

											<li>Si el rango es hasta el infinito no debe colocar el segundo numero,
												ejemplo: <kbd>25<?php echo $qryData['valor_misc']; ?></kbd></li>

											<li>Si el resultado cualitativo siempre va a ser verdadero, debe especificar
												que es universal mediante el simbolo <kbd>*</kbd> al final</li>

											<li>Si desea registrar una cadena de texto, no debe utilizar ningún carácter
												especial (pero sí puede utilizar tíldes)</li>

										</ul>

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

								<table class="table table-condensed" id="table33">

									<thead>

										<tr>

											<th colspan="3"><input type="text" class="form-control input-sm"
													data-search-input="true" placeholder="Buscar..."
													onkeyup="functionHandler('tableSearch',this);" /></th>

										</tr>

										<tr>

											<th class="center-text">Nombre de mensurando</th>

											<th class="center-text">Descripción de resultado</th>

											<th class="center-text">Puntuacion</th>


											<!-- <th class="center-text">Eliminar</th> -->

										</tr>

									</thead>

									<tbody>

									</tbody>

								</table>

							</div>

						</div>
						<!-- ------- -->



						<div id="panel14form3innerDiv3" data-id="p14_form3id">

							<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

								<form class="margin-top-2" id="formMagnitud">



									<div class="form-group">

										<label for="formMagnitudinput1">Código BioRAD</label>

										<input type="text" data-form-reset="true" class="form-control input-sm"
											id="formMagnitudinput1" name="codigo">

									</div>



									<div class="form-group">

										<label for="formMagnitudinput2">Nombre de mensurando</label>

										<input data-form-reset="true" id="formMagnitudinput2" name="nombre"
											class="form-control input-sm" />

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

								<table class="table table-condensed" id="tableMagnitud">

									<thead>

										<tr>

											<th colspan="4"><input type="text" class="form-control input-sm"
													data-search-input="true" placeholder="Buscar..."
													onkeyup="functionHandler('tableSearch',this);" /></th>

										</tr>

										<tr>

											<th class="center-text">Código</th>

											<th class="center-text">Nombre de mensurando</th>

											<th class="center-text">Eliminar</th>

										</tr>

									</thead>

									<tbody>

									</tbody>

								</table>

							</div>

						</div>



					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel14innerDiv3"
						data-id="p14id" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form7">

								<div class="form-group">

									<label for="form7input2">Programa</label>

									<select class="form-control input-sm" id="form7input2" data-default="true"
										name="programid"></select>

								</div>

								<div class="form-group">

									<label for="form7input1">Código de muestra</label>

									<input data-form-reset="true" id="form7input1" name="samplenumber"
										class="form-control input-sm" />

								</div>

								<div class="form-group">

									<label class="form7input5">Número de ronda</label>

									<input type="number" class="form-control input-sm" id="form7input5"
										name="roundnumber" value="1" />

								</div>

								<div class="form-group">

									<label for="form7input3">Lote proveedor</label>

									<select class="form-control input-sm" id="form7input3" data-default="true"
										name="lotid"></select>

								</div>

								<div class="form-group">

									<label for="form7input4">Fecha de reporte del resultado</label>

									<input type="date" data-form-reset="true" class="form-control input-sm"
										id="form7input4" name="sampledate" />

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

							<table class="table table-condensed" id="table6">

								<thead>

									<tr>

										<th colspan="11"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Ronda #</th>

										<th class="center-text">Muestra #</th>

										<th class="center-text">Muestra</th>

										<th class="center-text">Programa</th>

										<th class="center-text">Lote QAP</th>

										<th class="center-text">Fecha de reporte del resultado</th>

										<th class="center-text">Catálogo de lote</th>

										<th class="center-text">Lote</th>

										<th class="center-text">Nivel de lote</th>

										<th class="center-text">Fecha de vencimiento del lote</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel14innerDiv6"
						data-id="p14id" hidden="hidden" style="max-height: inherit;">

						<div class="col-xs-12" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed table-bordered" id="table24">

								<thead>

									<tr>

										<th><input type="text" class="form-control input-sm" data-search-input="true"
												placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

										<th><select class="form-control input-sm" title="Programa" id="form24input1"
												name="programid"></select></th>

										<th><select class="form-control input-sm" title="Opción de límite"
												id="form24input2" name="limitid">

												<?php



												$qry = "SELECT id_opcion_limite, nombre_opcion_limite FROM $tbl_opcion_limite ORDER BY id_opcion_limite ASC";

												$qryArray = mysql_query($qry);



												while ($qryData = mysql_fetch_array($qryArray)) {

													echo "<option value='" . $qryData['id_opcion_limite'] . "'>" . $qryData['nombre_opcion_limite'] . "</option>";
												}



												?>

											</select></th>

										<th><button id="form24input3" class="btn btn-default btn-sm btn-block"
												type="button"><span class="glyphicon glyphicon-floppy-disk"></span>
												Guardar</button></th>

									</tr>

									<tr>

										<th class="center-text">Mensurando</th>

										<th class="center-text">Nombre de programa</th>

										<th colspan='2' class="center-text">Límite</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel14innerDiv7"
						data-id="p14id" hidden="hidden">

						<div class="col-xs-6 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form19">

								<div class="col-xs-6 no-margin">

									<center>

										<h4>Programa de origen</h4>

									</center>

									<div class="form-group">

										<label for="form19input1">Programa</label>

										<select class="form-control input-sm" id="form19input1"
											name="fromprogram"></select>

									</div>

									<div class="form-group">

										<label for="form19input2">Muestra</label>

										<select class="form-control input-sm" id="form19input2"
											name="fromsample"></select>

									</div>

								</div>

								<div class="col-xs-6 no-margin border-left">

									<center>

										<h4>Programa de destino</h4>

									</center>

									<div class="form-group">

										<label for="form19input3">Programa</label>

										<select class="form-control input-sm" id="form19input3"
											name="toprogram"></select>

									</div>

									<div class="form-group">

										<label for="form19input4">Muestra</label>

										<select class="form-control input-sm" id="form19input4"
											name="tosample"></select>

									</div>

								</div>

								<div class="row"></div>

								<hr />

								<center>

									<h4>Datos a clonar</h4>

								</center>

								<div class="form-group">

									<input type="checkbox" value="1" id="form19input5" checked="checked">

									<label for="form19input5" class="unselectable pointer">Mensurando asignados al
										programa</label>

								</div>

								<div class="form-group">

									<input type="checkbox" value="2" id="form19input6" checked="checked">

									<label for="form19input6" class="unselectable pointer">Configuración de mensurandos
										para el programa</label>

								</div>

								<div class="form-group">

									<input type="checkbox" value="3" id="form19input7" checked="checked">

									<label for="form19input7" class="unselectable pointer">Configuración de mensurandos
										para el laboratorio</label>

								</div>

								<div class="form-group">

									<input type="checkbox" value="4" id="form19input8" checked="checked">

									<label for="form19input8" class="unselectable pointer">Medias estádisticas fijas
										para la muestra</label>

								</div>

								<div class="form-group">

									<input type="checkbox" value="5" id="form19input9" checked="checked">

									<label for="form19input9" class="unselectable pointer">Resultados digitados para la
										muestra</label>

								</div>

								<hr />

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Clonar" />

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-6" style="max-height: inherit; overflow: auto;">

						</div>

					</div>



					<!--

						<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel14innerDiv8" data-id="p14id" hidden="hidden">

							<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

								<form class="margin-top-2" id="form8">

								<div class="form-group">

									<label for="form8input1">Programa</label>

									<select class="form-control input-sm" id="form8input1" name="programid"></select>

								</div>								

								<div class="form-group">

									<label for="form8input2">Muestra</label>

									<select class="form-control input-sm" id="form8input2" name="sampleid"></select>

								</div>

								<div class="form-group">

									<label for="form8input3">Mensurando</label>

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

									<input type="text" class="form-control input-sm" id="form8input5" name="referencevalue" data-default="true"/>

								</div>								

								<hr/>

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar"/>

									</center>

								</div>

								</form>

							</div>

							<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

								<table class="table table-condensed" id="table26">

									<thead>

										<tr>

											<th colspan="7"><input type="text" class="form-control input-sm" data-search-input="true" placeholder="Buscar..." onkeyup="functionHandler('tableSearch',this);"/></th>

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

						-->



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel14innerDiv9"
						data-id="p14id" hidden="hidden">

						<hr />

						<nav class="navbar navbar-default cube-box no-margin no-padding">

							<ul class="nav navbar-nav inner-nav">

								<li class="pointer unselectable active-tab" style="font-size: 10pt"
									data-id="panel14form27innerDiv1"
									onmouseup="functionHandler('panelChooser',this, 'p14_form27id');"><a>Agregar método
										/ material</a></li>

								<li class="pointer unselectable" style="font-size: 10pt"
									data-id="panel14form27innerDiv2"
									onmouseup="functionHandler('panelChooser',this, 'p14_form27id');"><a>Emparejar
										método</a></li>

								<li class="pointer unselectable" style="font-size: 10pt"
									data-id="panel14form27innerDiv3"
									onmouseup="functionHandler('panelChooser',this, 'p14_form27id');"><a>Emparejar
										material</a></li>

							</ul>

						</nav>

						<div id="panel14form27innerDiv1" data-id="p14_form27id">

							<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

								<form class="margin-top-2" id="form27">

									<div class="form-group">

										<label for="form27input1">Programa</label>

										<select class="form-control input-sm" id="form27input1"
											name="programid"></select>

									</div>

									<div class="form-group">

										<label for="form27input2">Mensurando</label>

										<select class="form-control input-sm" id="form27input2"
											name="analitid"></select>

									</div>

									<hr />

									<div class="form-group">

										<label for="form27input3">Método de referencia JCTLM</label>

										<input type="text" class="form-control input-sm" id="form27input3"
											name="jctlmmethod" data-default="true" data-form-reset="true" />

									</div>

									<hr />

									<div class="form-group">

										<label for="form27input4">Material de referencia JCTLM</label>

										<input type="text" class="form-control input-sm" id="form27input4"
											name="jctlmmaterial" data-default="true" data-form-reset="true" />

									</div>

									<hr />

									<div class="form-group">

										<center>

											<input type="submit" class="btn btn-default" value="Agregar" />

										</center>

									</div>

								</form>

							</div>

							<div class="col-xs-8">

								<div class="col-xs-12 no-margin no-padding"
									style="height: 45vh; max-height: 45vh; overflow: auto;">

									<table class="table table-condensed" id="table27">

										<thead>

											<tr>

												<th colspan="6"><input type="text" class="form-control input-sm"
														data-search-input="true" placeholder="Buscar..."
														onkeyup="functionHandler('tableSearch',this);" /></th>

											</tr>

											<tr>

												<th class="center-text">Programa</th>

												<th class="center-text">Mensurando</th>

												<th class="center-text">Método de referencia JCTLM</th>

												<th class="center-text">Activo</th>

												<th class="center-text">Eliminar</th>

											</tr>

										</thead>

										<tbody>

										</tbody>

									</table>

								</div>

								<div class="row"></div>

								<hr />

								<div class="col-xs-12 no-margin no-padding"
									style="height: 45vh; max-height: 45vh; overflow: auto;">

									<table class="table table-condensed" id="table28">

										<thead>

											<tr>

												<th colspan="6"><input type="text" class="form-control input-sm"
														data-search-input="true" placeholder="Buscar..."
														onkeyup="functionHandler('tableSearch',this);" /></th>

											</tr>

											<tr>

												<th class="center-text">Programa</th>

												<th class="center-text">Mensurando</th>

												<th class="center-text">Material de referencia JCTLM</th>

												<th class="center-text">Activo</th>

												<th class="center-text">Eliminar</th>

											</tr>

										</thead>

										<tbody>

										</tbody>

									</table>

								</div>

							</div>

						</div>

						<div id="panel14form27innerDiv2" data-id="p14_form27id" hidden="hidden">

							<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

								<form class="margin-top-2" id="form28">

									<div class="form-group">

										<label for="form28input1">Programa</label>

										<select class="form-control input-sm" id="form28input1"
											name="analitid"></select>

									</div>

									<div class="form-group">

										<label for="form28input2">Mensurando</label>

										<select class="form-control input-sm" id="form28input2"
											name="analitid"></select>

									</div>

									<div class="form-group">

										<label for="form28input3">Métodos declarados por manufacturador</label>

										<select class="form-control input-sm" id="form28input3"
											name="methodid1"></select>

									</div>

									<div class="form-group">

										<label for="form28input4">Métodos avalados por el JCTLM</label>

										<select class="form-control input-sm" id="form28input4"
											name="methodid2"></select>

									</div>

									<hr />

									<div class="form-group">

										<p><strong>NOTA: </strong> En dado caso de aparecer mas de una vez la misma
											metodología, puede seleccionar cualquiera de las opciones idénticas, esto no
											afecta en nada la base de datos. Es debido a que el mensurando seleccionado
											puede estar en más de una área a la vez.</p>

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

								<table class="table table-condensed" id="table31">

									<thead>

										<tr>

											<th colspan="4"><input type="text" class="form-control input-sm"
													data-search-input="true" placeholder="Buscar..."
													onkeyup="functionHandler('tableSearch',this);" /></th>

										</tr>

										<tr>

											<th class="center-text">Mensurando</th>

											<th class="center-text">Métodos declarados por manufacturador</th>

											<th class="center-text">Métodos avalados por el JCTLM</th>

											<th class="center-text">Eliminar</th>

										</tr>

									</thead>

									<tbody>

									</tbody>

								</table>

							</div>

						</div>

						<div id="panel14form27innerDiv3" data-id="p14_form27id" hidden="hidden">

							<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

								<form class="margin-top-2" id="form29">

									<div class="form-group">

										<label for="form29input1">Programa</label>

										<select class="form-control input-sm" id="form29input1"
											name="analitid"></select>

									</div>

									<div class="form-group">

										<label for="form29input2">Mensurando</label>

										<select class="form-control input-sm" id="form29input2"
											name="analitid"></select>

									</div>

									<div class="form-group">

										<label for="form29input3">Materiales declarados por manufacturador</label>

										<select class="form-control input-sm" id="form29input3"
											name="materialid1"></select>

									</div>

									<div class="form-group">

										<label for="form29input4">Materiales avalados por el JCTLM</label>

										<select class="form-control input-sm" id="form29input4"
											name="materialid2"></select>

									</div>

									<hr />

									<div class="form-group">

										<p><strong>NOTA: </strong> En dado caso de aparecer mas de una vez el mismo
											material, puede seleccionar cualquiera de las opciones idénticas, esto no
											afecta en nada la base de datos. Es debido a que el mensurando seleccionado
											puede estar en más de una área a la vez.</p>

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

								<table class="table table-condensed" id="table32">

									<thead>

										<tr>

											<th colspan="4"><input type="text" class="form-control input-sm"
													data-search-input="true" placeholder="Buscar..."
													onkeyup="functionHandler('tableSearch',this);" /></th>

										</tr>

										<tr>

											<th class="center-text">Mensurando</th>

											<th class="center-text">Materiales declarados por manufacturador</th>

											<th class="center-text">Materiales avalados por el JCTLM</th>

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

			</div>

			<div class="panel panel-default cube-box no-margin" id="panel4" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Laboratorio</span>

				</div>

				<div class="panel-body cube-box no-padding">

					<nav class="navbar navbar-default cube-box no-margin no-padding">

						<ul class="nav navbar-nav inner-nav">
							<li class="pointer active-tab" style="font-size: 10pt" data-id="panel4innerDiv1"
								onmouseup="functionHandler('panelChooser',this, 'p4id');"><a>Agregar laboratorio</a>
							</li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel4innerDiv2"
								onmouseup="functionHandler('panelChooser',this, 'p4id');"><a>Asignar programa</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel4innerDiv4"
								onmouseup="functionHandler('panelChooser',this, 'p4id');"><a>Asignar ronda</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel4innerDiv3"
								onmouseup="functionHandler('panelChooser',this, 'p4id');"><a>Asignar mensurando</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel4innerDiv5"
								onmouseup="functionHandler('panelChooser',this, 'p4id');"><a>Habilitar revaloración</a>
							</li>

							<?php

							if ($_SESSION['qap_key'] == 0) { // Administrador total o coordinador QAP
							
								echo '<li class="pointer unselectable" style="font-size: 10pt" data-id="panel4innerDiv6"><a>Reporte de resultados</a></li>';
							}

							?>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel4innerDivReportes"
								onmouseup="functionHandler('panelChooser',this, 'p4id');"><a>Cargar reportes</a></li>

						</ul>

					</nav>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel4innerDiv1"
						data-id="p4id">

						<div class="col-xs-3 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form4">

								<div class="form-group">

									<label for="form4input1">Número de laboratorio</label>

									<input type="number" data-form-reset="true" class="form-control input-sm"
										id="form4input1" name="labnumber" maxlength="6" />

								</div>

								<div class="form-group">

									<label for="form4input2">Nombre de laboratorio</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form4input2" name="labname" />

								</div>

								<div class="form-group">

									<label for="form4input3">Contacto</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form4input3" name="labcontact" />

								</div>

								<div class="form-group">

									<label for="form4input4">Dirección</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form4input4" name="labaddress" />

								</div>

								<div class="form-group">

									<label for="form4input5">Ciudad</label>

									<select class="form-control input-sm" id="form4input5" name="labcityid"></select>

								</div>

								<div class="form-group">

									<label for="form4input6">Teléfono</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form4input6" name="labphone" />

								</div>

								<div class="form-group">

									<label for="form4input7">Correo de laboratorio</label>

									<input type="email" data-form-reset="true" class="form-control input-sm"
										id="form4input7" name="labemail" />

								</div>

								<hr />

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar" />

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-9" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="table11">

								<thead>

									<tr>

										<th colspan="8"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Número de laboratorio</th>

										<th class="center-text">Nombre de laboratorio</th>

										<th class="center-text">Contacto</th>

										<th class="center-text">Dirección</th>

										<th class="center-text">Ciudad</th>

										<th class="center-text">Teléfono</th>

										<th class="center-text">Correo de laboratorio</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel4innerDiv2" data-id="p4id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form5">

								<div class="form-group">

									<label for="form5input1">Laboratorio</label>

									<select class="form-control input-sm" id="form5input1" data-default="true"
										name="labid"></select>

								</div>

								<div class="form-group">

									<label for="form5input2">Programa</label>

									<select class="form-control input-sm" id="form5input2" data-default="true"
										name="programid"></select>

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

							<table class="table table-condensed" id="table14">

								<thead>

									<tr>

										<th colspan="5"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Número de laboratorio</th>

										<th class="center-text">Nombre de laboratorio</th>

										<th class="center-text">Nombre de programa</th>

										<th class="center-text">Activo</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel4innerDiv3" data-id="p4id"
						hidden="hidden">

						<div class="col-xs-3 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form6">

								<div class="form-group">

									<label for="form6input1">Laboratorio</label>

									<select class="form-control input-sm" id="form6input1" data-default="true"
										name="labid"></select>

								</div>

								<div class="form-group">

									<label for="form6input2">Programa</label>

									<select class="form-control input-sm" id="form6input2" name="programid"></select>

								</div>

								<div class="form-group">

									<label for="form6input3">Mensurando</label>

									<select class="form-control input-sm" id="form6input3" name="analitid"></select>

								</div>

								<div class="form-group">

									<label for="form6input4">Analizador</label>

									<select class="form-control input-sm" id="form6input4" name="analyzerid"></select>

								</div>

								<div class="form-group">

									<label for="form6input5">Metodología</label>

									<select class="form-control input-sm" id="form6input5" name="methodid"></select>

								</div>

								<div class="form-group">

									<label for="form6input6">Reactivo</label>

									<select class="form-control input-sm" id="form6input6" name="reactiveid"></select>

								</div>

								<div class="form-group">

									<label for="form6input7">Unidad</label>

									<select class="form-control input-sm" id="form6input7" name="unitid"></select>

								</div>

								<div class="form-group">

									<label for="form6input8">N° de gen de tira VITROS</label>

									<select class="form-control input-sm" id="form6input8" name="vitrosgenid"
										disabled="disabled"></select>

								</div>

								<div class="form-group">

									<label for="form6input9">Material o calibrador</label>

									<select class="form-control input-sm" id="form6input9" name="materialid"></select>

								</div>

								<hr />

								<div class="form-group">
									<center>
        <button type="button" id="descargarExcelBtn" class="btn btn-success">
            Descargar Enrolamiento
        </button>
    </center>
								</div>


						</div>


						<div class="col-xs-9" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="table15">

								<thead>

									<tr>

										<th colspan="11"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Programa</th>

										<th class="center-text">Mensurando</th>

										<th class="center-text">Analizador</th>

										<th class="center-text">Generación</th>

										<th class="center-text">Metodología</th>

										<th class="center-text">Reactivo</th>

										<th class="center-text">Unidad</th>

										<th class="center-text">Material</th>

										<th class="center-text">Activo</th>

										<th class="center-text">Posibles resultados</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>





						<div class="col-xs-3 floating center" id="window1" data-item="window" style="display:none;">

							<div class="panel panel-default shadow" id="w1p">

								<div class="panel-heading">

									Seleccionar posibles resultados para configuración <b><span
											id="window1title1"></span></b>

									<button onmouseup="functionHandler('windowHandler','window1');" type="button"
										class="close">

										<span aria-hidden="true">&times;</span>

										<span class="sr-only">Close</span>

									</button>

								</div>

								<div class="panel-body no-padding" style="height: 75vh; max-height: 75vh;">

									<div class="col-xs-12" style="height: 69vh; max-height: 69vh; overflow: auto;">

										<table class="table table-condensed table-hover" id="table34">

											<thead>

												<tr>

													<th colspan="1"><input type="text" class="form-control input-sm"
															data-search-input="true" placeholder="Buscar..."
															onkeyup="functionHandler('tableSearch',this);" /></th>

												</tr>

												<tr>

													<th class="center-text">Descripción de resultado</th>

												</tr>

											</thead>

											<tbody>

											</tbody>

										</table>

									</div>

									<hr />

									<center>

										<button type="button" class="btn btn-default btn-sm"
											onmouseup="functionHandler('windowHandler','window1');">Aceptar</button>

									</center>

								</div>

							</div>

						</div>

						<div class="col-xs-3 floating center" id="window2" data-item="window" style="display:none;">

							<div class="panel panel-default shadow" id="w2p" data-id-holder="NULL">

								<div class="panel-heading">

									Seleccionar posibles resultados para configuración <b><span
											id="window1title1"></span></b>

									<button onmouseup="functionHandler('windowHandler','window2');" type="button"
										class="close">

										<span aria-hidden="true">&times;</span>

										<span class="sr-only">Close</span>

									</button>

								</div>

								<div class="panel-body no-padding" style="height: 75vh; max-height: 75vh;">

									<div class="col-xs-12" style="max-height: inherit; overflow: auto;">

										<table class="table table-condensed table-hover" id="table35">

											<thead>

												<tr>

													<th colspan="2"><input type="text" class="form-control input-sm"
															data-search-input="true" placeholder="Buscar..."
															onkeyup="functionHandler('tableSearch',this);" /></th>

												</tr>

												<tr>

													<th class="center-text">Descripción de resultado</th>

													<th class="center-text"><button id="table35input1"
															class="btn btn-default btn-sm" type="button"
															style="width: 83%;"><span
																class="glyphicon glyphicon-floppy-disk"></span>
															Guardar</button></th>

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



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel4innerDiv4" data-id="p4id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form22">

								<div class="form-group">

									<label for="form22input1">Laboratorio</label>

									<select class="form-control input-sm" id="form22input1" data-default="true"
										name="labid"></select>

								</div>

								<div class="form-group">

									<label for="form22input2">Programa</label>

									<select class="form-control input-sm" id="form22input2" name="programid"></select>

								</div>

								<div class="form-group">

									<label for="form22input3">Ronda</label>

									<select class="form-control input-sm" id="form22input3" name="roundid"></select>

								</div>

								<hr />

								<label for="table22">Ítems a asignar</label>

								<div class="col-xs-12 no-margin no-padding"
									style="height: 30vh; max-height: 30vh; overflow:auto;">

									<table class="table table-condensed" id="table22">

										<thead>

											<tr>

												<th class="center-text">Ronda #</th>

												<th class="center-text">Muestra #</th>

												<th class="center-text">Número de muestra</th>

											</tr>

										</thead>

										<tbody>

										</tbody>

									</table>

								</div>

								<div class="row"></div>

								<hr />

								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar" />

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="table21">

								<thead>

									<tr>

										<th colspan="5"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Número de laboratorio</th>

										<th class="center-text">Nombre de laboratorio</th>

										<th class="center-text">Nombre de programa</th>

										<th class="center-text">Número de ronda</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel4innerDiv5" data-id="p4id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form25">

								<div class="form-group">

									<label for="form25input1">Laboratorio</label>

									<select class="form-control input-sm" id="form25input1" data-default="true"
										name="labid"></select>

								</div>

								<div class="form-group">

									<label for="form25input2">Programa</label>

									<select class="form-control input-sm" id="form25input2" name="programid"></select>

								</div>

								<div class="form-group">

									<label for="form25input3">Ronda</label>

									<select class="form-control input-sm" id="form25input3" name="roundid"></select>

								</div>

								<div class="form-group">

									<label for="form25input4">Muestra</label>

									<select class="form-control input-sm" id="form25input4" name="sampleid"></select>

								</div>

								<hr />

							</form>

						</div>

						<div class="col-xs-8" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="table25">

								<thead>

									<tr>

										<th colspan="2"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

										<th colspan="1"><input type="button" class="btn btn-default btn-sm btn-block"
												value="Habilitar seleccionados" id="form25input5" /></th>

									</tr>

									<tr>

										<th class="center-text"><input type="checkbox" id="form25input6"
												onmouseup="functionHandler('checkboxCheckAll','form25input6','table25');">
										</th>

										<th class="center-text">Mensurando</th>

										<th class="center-text">Revaloración</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel4innerDivReportes"
						data-id="p4id" hidden="hidden">

						<div class="col-xs-3 border-right vh-90">

							<form class="margin-top-2" enctype="multipart/form-data" id="formReportes">



								<div class="form-group">

									<label>Laboratorio</label>

									<select class="form-control input-sm" id="formReportesinput1"
										name="clientid"></select>

								</div>



								<div class="form-group">

									<label>Programa</label>

									<select class="form-control input-sm" id="formReportesinput2"
										name="programid"></select>

								</div>



								<div class="form-group">

									<label>Ciclo</label>

									<select class="form-control input-sm" id="formReportesinput3"
										name="cicloid"></select>

								</div>



								<div class="form-group">

									<label>Selección de reporte</label>

									<input type="file" class="form-control input-sm" id="formReportesinput4"
										name="documentfiles" />

								</div>



								<div class="form-group" style="height: 25px;">

									<input type="submit" class="btn btn-default btn-sm btn-block" value="Cargar" />

								</div>



								<hr />



								<div class="form-group" style="height: 10vw; max-height: 10vw; overflow: auto;">

									<table id="formReportestable1"
										class="table table-hover table-condensed margin-top-2">

										<thead>

											<tr>

												<th>Item</th>

												<th>Nombre de documento</th>

												<th>Tamaño</th>

											</tr>

										</thead>

										<tbody>

										</tbody>

									</table>

								</div>



								<br>

								<hr>

								<br>

								<p class='bg-danger'><strong>Importante:</strong></p>

								<p class='bg-danger'><strong>1.</strong> Si va a cargar reportes QAP-PAT
									intralaboratorio. El nombre del archivo debe contener la palabra
									<strong>Intralaboratorio</strong>. Por ejemplo: <strong>200100 - Intralaboratorio
										Código C Quik SAS</strong> (Para que el coordinador del laboratorio de
									patología. Sea el único quien pueda ver los reportes intralaboratorio)
								</p>

								<p class='bg-danger'><strong>2.</strong> Si va a cargar reportes QAP-PAT individuales.
									El nombre del archivo debe ser el <strong>código del usuario</strong> Por ejemplo:
									<strong>QUIK-001</strong> (Para que el cada usuario pueda ver su respectivo reporte
									y no todos)
								</p>

								<p class='bg-danger'><strong>3.</strong> Si va a cargar reportes con trazabilidad,
									siempre asegurese de que estos reportes estén inactivos y contengan la palabra
									"Trazabilidad" en el nombre del archivo. (esto para que el sistema entienda que es
									un arcivo interno y no envíe correos a los clientes)</p>

								<br>



								<div class="row margin-top-1"></div>

								<hr />



							</form>



						</div>



						<div class="col-xs-9 vh-90">



							<table class="table table-condensed" id="tableReportes">



								<thead>



									<tr>

										<th colspan="7"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

										<th colspan="1"><button type="button" class="btn btn-default btn-sm btn-block"
												id="tableReportesbtn1" data-parent="tableReportes">Descargar
												seleccionados</button></th>

									</tr>



									<tr>



										<th class="center-text"><input type="checkbox" id="tableReportesSelectAll"
												onmouseup="functionHandler('checkAll',this)" /></th>



										<th class="center-text">Nombre de documento</th>



										<th class="center-text">Index de documento</th>



										<th class="center-text">Activo</th>



										<th class="center-text">Fecha asignada</th>



										<th class="center-text">Ver</th>



										<th class="center-text">Descargar</th>



										<th class="center-text">Eliminar</th>



									</tr>



								</thead>



								<tbody>

								</tbody>

							</table>

						</div>



					</div>


					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel4innerDiv6" data-id="p4id"
						hidden="hidden">

						<form id="form26">

							<iframe frameborder="0"
								style="position: absolute; width: 100%; height: 91%; top: 70px; bottom: 0; left: 0; right: 0; z-index: 1"
								id="form26frame1" allowtransparency="true"></iframe>

						</form>

					</div>

				</div>

			</div>

			<div class="panel panel-default cube-box no-margin" id="panel6" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Analizador</span>

				</div>

				<div class="panel-body cube-box no-padding">

					<nav class="navbar navbar-default cube-box no-margin no-padding">

						<ul class="nav navbar-nav inner-nav">

							<li class="pointer active-tab" style="font-size: 10pt" data-id="panel6innerDiv1"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Agregar analizador</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel6innerDiv7"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Agregar metodología</a>
							</li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel6innerDiv8"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Agregar unidad</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel6innerDiv2"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Asignar metodología <strong
										class='font-weight-bold text-primary'>*</strong></a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel6innerDiv3"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Asignar unidad <strong
										class='font-weight-bold text-primary'>*</strong></a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel6innerDiv4"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Agregar reactivo</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel6innerDiv5"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Agregar material o
									calibrador</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel6innerDiv6"
								onmouseup="functionHandler('panelChooser',this, 'p6id');"><a>Agregar unidad
									internacional</a></li>

						</ul>

					</nav>





					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv1"
						data-id="p6id">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form10">

								<div class="form-group">

									<label for="form10input1">Código BioRAD</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form10input1" name="codigo">

								</div>



								<div class="form-group">

									<label for="form10input2">Nombre de analizador</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form10input2" name="nombre">

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

							<table class="table table-condensed" id="table7">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Código</th>

										<th class="center-text">Nombre de analizador</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>









					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv2" data-id="p6id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form9">

								<div class="form-group">

									<label for="form9input2">Analizador perteneciente</label>

									<select class="form-control input-sm" id="form9input2" data-default="true"
										name="analyzerid"></select>

								</div>

								<div class="form-group">

									<label for="form9input1">Nombre de metodología</label>

									<select class="form-control input-sm" id="form9input1" data-default="true"
										name="methodid"></select>

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

							<table class="table table-condensed" id="table8">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Nombre de analizador</th>

										<th class="center-text">Nombre de metodología</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv3" data-id="p6id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form12">

								<div class="form-group">

									<label for="form12input2">Analizador perteneciente</label>

									<select class="form-control input-sm" id="form12input2" data-default="true"
										name="analyzerid"></select>

								</div>

								<div class="form-group">

									<label for="form12input1">Nombre de unidad</label>

									<select class="form-control input-sm" id="form12input1" data-default="true"
										name="unitid"></select>

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

							<table class="table table-condensed" id="table10">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Nombre de analizador</th>

										<th class="center-text">Nombre de unidad</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>





					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv4" data-id="p6id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form11">



								<div class="form-group">

									<label for="form11input2">Código BioRAD</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form11input2" name="codigo">

								</div>



								<div class="form-group">

									<label for="form11input1">Nombre de reactivo</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form11input1" name="nombre">

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

							<table class="table table-condensed" id="table9">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Código</th>

										<th class="center-text">Nombre de reactivo</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv5" data-id="p6id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form30">

								<div class="form-group">

									<label for="form30input1">Nombre de material</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="form30input1" name="materialname">

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

							<table class="table table-condensed" id="table29">

								<thead>

									<tr>

										<th colspan="2"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Nombre de material</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv6" data-id="p6id"
						hidden="hidden">

						<div class="col-xs-12" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="table36">

								<thead>

									<tr>

										<th colspan="2"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

										<th class="center-text"><select class="form-control input-sm" id="table36input2"
												title="programa"></select></th>

										<th class="center-text"><button id="table36input1"
												class="btn btn-default btn-sm btn-block" type="button"><span
													class="glyphicon glyphicon-floppy-disk"></span> Guardar</button>
										</th>

									</tr>

									<tr>

										<th class="center-text">Nombre de analito</th>

										<th class="center-text">Nombre de unidad</th>

										<th class="center-text">Nombre de unidad global</th>

										<th class="center-text">Factor de conversión</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<!-- Nueva seccion de metodologia -->

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv7" data-id="p6id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formMetodologia">



								<div class="form-group">

									<label for="formMetodologiainput1">Código BioRAD</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formMetodologiainput1" name="codigo">

								</div>



								<div class="form-group">

									<label for="formMetodologiainput2">Nombre de metodología</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formMetodologiainput2" name="nombre">

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

							<table class="table table-condensed" id="tableMetodologia">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Código</th>

										<th class="center-text">Nombre de metodología</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>



					<!-- Nueva seccion de unidad -->

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel6innerDiv8" data-id="p6id"
						hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="formUnidad">



								<div class="form-group">

									<label for="formUnidadinput1">Código BioRAD</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formUnidadinput1" name="codigo">

								</div>



								<div class="form-group">

									<label for="formUnidadinput2">Nombre de unidad</label>

									<input type="text" data-form-reset="true" class="form-control input-sm"
										id="formUnidadinput2" name="nombre">

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

							<table class="table table-condensed" id="tableUnidad">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Código</th>

										<th class="center-text">Nombre de unidad</th>

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

			<div class="panel panel-default cube-box no-margin" id="panel10" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Usuario</span>

				</div>

				<div class="panel-body cube-box no-padding">

					<nav class="navbar navbar-default cube-box no-margin no-padding">

						<ul class="nav navbar-nav inner-nav">

							<li class="pointer active-tab" style="font-size: 10pt" data-id="panel10innerDiv1"
								onmouseup="functionHandler('panelChooser',this, 'p10id');"><a>Agregar usuario</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel10innerDiv2"
								onmouseup="functionHandler('panelChooser',this, 'p10id');"><a>Asignar laboratorio</a>
							</li>

						</ul>

					</nav>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel10innerDiv1"
						data-id="p10id">

						<div class="col-xs-3 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form13">

								<div class="form-group">

									<label for="form13input1">Atributos de usuario</label>

									<select class="form-control" id="form13input1" name="usertype">

										<option value="0">Administrador total</option>

										<option value="100">Coordinador QAP</option>

										<option value="102">Generador de informes</option>

										<option value="103" selected="selected">Usuario de laboratorio</option>

										<option value="125">Patólogo</option>

										<option value="126">Patólogo coordinador</option>

									</select>

								</div>

								<div class="form-group">

									<label for="form13input2">Nombre de usuario</label>

									<input type="text" data-form-reset="true" id="form13input2" name="username"
										class="form-control input-sm" />

								</div>



								<div class="form-group">

									<label for="email_user_registry">Correo electrónico <span
											class='text-primary'>*</span></label>

									<input type="email" data-form-reset="true" id="email_user_registry"
										name="email_user_registry" class="form-control input-sm" />

								</div>



								<div class="form-group" id="passDiv1">

									<label for="form13input3">Contraseña</label>

									<input type="password" data-form-reset="true" id="form13input3" name="userpassword"
										class="form-control input-sm" />

								</div>

								<div class="form-group" id="passDiv2">

									<label for="form13input4">Repita la contraseña</label>

									<input type="password" data-form-reset="true" id="form13input4"
										class="form-control input-sm" />

								</div>



								<br />

								<hr />



								<div class="form-group">

									<label for="cod_user_registry">Código patólogo

										<br />

										<span><sub>Este campo sólo será tenido en cuenta para los usuarios patólogos
												(ingrese "0" si no aplica)</sub></span>

									</label>

									<input type="text" data-form-reset="true" id="cod_user_registry"
										name="cod_user_registry" class="form-control input-sm" />

								</div>



								<div class="form-group">

									<label for="form13inputNombre">Nombre patólogo

										<br />

										<span><sub>Este campo sólo será tenido en cuenta para los usuarios patólogos
												(ingrese "0" si no aplica)</sub></span>

									</label>

									<input type="text" data-form-reset="true" id="form13inputNombre" name="fullname"
										class="form-control input-sm" />

								</div>



								<hr />

								<br />



								<div class="form-group">

									<center>

										<input type="submit" class="btn btn-default" value="Agregar" />

									</center>

								</div>

							</form>

						</div>

						<div class="col-xs-9" style="max-height: inherit; overflow: auto;">

							<table class="table table-condensed" id="table16">

								<thead>

									<tr>

										<th colspan="7"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text" style="min-width: 210px;">Atributos de usuario</th>

										<th class="center-text">Usuario</th>

										<th class="center-text">Correo electrónico</th>

										<th class="center-text">Contraseña</th>

										<th class="center-text">Nombre PAT</th>

										<th class="center-text">Código PAT</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel10innerDiv2"
						data-id="p10id" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form15">

								<div class="form-group">

									<label for="form15input1">Usuario</label>

									<select class="form-control input-sm" id="form15input1" data-default="true"
										name="userid"></select>

								</div>

								<div class="form-group">

									<label for="form15input2">Laboratorio</label>

									<select class="form-control input-sm" id="form15input2" data-default="true"
										name="labid"></select>

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

							<table class="table table-condensed" id="table17">

								<thead>

									<tr>

										<th colspan="4"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Usuario</th>

										<th class="center-text">Número de laboratorio</th>

										<th class="center-text">Nombre de laboratorio</th>

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

			<div class="panel panel-default cube-box no-margin" id="panel11" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Pais</span>

				</div>

				<div class="panel-body cube-box no-padding">

					<nav class="navbar navbar-default cube-box no-margin no-padding">

						<ul class="nav navbar-nav inner-nav">

							<li class="pointer active-tab" style="font-size: 10pt" data-id="panel11innerDiv1"
								onmouseup="functionHandler('panelChooser',this, 'p11id');"><a>Agregar pais</a></li>

							<li class="pointer unselectable" style="font-size: 10pt" data-id="panel11innerDiv2"
								onmouseup="functionHandler('panelChooser',this, 'p11id');"><a>Agregar ciudad</a></li>

						</ul>

					</nav>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel11innerDiv1"
						data-id="p11id">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form16">

								<div class="form-group">

									<label for="form16input1">Nombre de pais</label>

									<input data-form-reset="true" id="form16input1" name="countryname"
										class="form-control input-sm" />

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

							<table class="table table-condensed" id="table12">

								<thead>

									<tr>

										<th colspan="2"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Nombre de pais</th>

										<th class="center-text">Eliminar</th>

									</tr>

								</thead>

								<tbody>

								</tbody>

							</table>

						</div>

					</div>

					<div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel11innerDiv2"
						data-id="p11id" hidden="hidden">

						<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">

							<form class="margin-top-2" id="form17">

								<div class="form-group">

									<label for="">Pais perteneciente</label>

									<select id="form17input1" data-default="true" class="form-control input-sm"
										name="countryid"></select>

								</div>

								<div class="form-group">

									<label for="form17input2">Nombre de ciudad</label>

									<input data-form-reset="true" id="form17input2" name="cityname"
										class="form-control input-sm" />

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

							<table class="table table-condensed" id="table13">

								<thead>

									<tr>

										<th colspan="3"><input type="text" class="form-control input-sm"
												data-search-input="true" placeholder="Buscar..."
												onkeyup="functionHandler('tableSearch',this);" /></th>

									</tr>

									<tr>

										<th class="center-text">Nombre de pais</th>

										<th class="center-text">Nombre de ciudad</th>

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

			<div class="panel panel-default cube-box no-margin" id="panel15" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Historial</span>

				</div>

				<div class="panel-body cube-box no-padding" style="height: 94.4vh; max-height: 94.4vh; overflow: auto;">

					<div class="col-xs-12 margin-top-2">

						<form id="form18" class="form-inline">

							<div class="form-group">

								<label for="form18input1">Valores a mostrar</label>

								<input type="number" id="form18input1" class="form-control input-sm" value="100"
									name="querylimit" />

							</div>

							<div class="form-group">

								<input type="submit" class="btn btn-default btn-sm" value="Buscar" />

							</div>

						</form>

					</div>

					<div class="col-xs-12 margin-top-1">

						<table class="table" id="tableLog">

							<thead>

								<tr>

									<th colspan="5"><input type="text" class="form-control input-sm"
											data-search-input="true" placeholder="Buscar..."
											onkeyup="functionHandler('tableSearch',this);" /></th>

								</tr>

								<tr>

									<th class="center-text">Fecha</th>

									<th class="center-text">Hora</th>

									<th class="center-text">Usuario</th>

									<th class="center-text">Acción</th>

									<th class="center-text">Query realizada</th>

								</tr>

							</thead>

							<tbody>

							</tbody>

						</table>

					</div>

				</div>

			</div>

			<div class="panel panel-default cube-box no-margin" id="panel16" data-id="mainDiv" hidden="hidden">

				<div class="panel-heading cube-box">

					<span>Historial de enrolamiento</span>

				</div>

				<div class="panel-body cube-box no-padding" style="height: 94.4vh; max-height: 94.4vh; overflow: auto;">

					<div class="col-xs-12 margin-top-2">

						<form id="form190" class="form-inline">

							<div class="form-group">

								<label for="formEnrolamientoLoginput1">Laboratorio</label>

								<select id="formEnrolamientoLoginput1" class="form-control input-sm"
									name="laboratorioid"></select>

							</div>

							<div class="form-group">

								<label for="formEnrolamientoLoginput2">Programa</label>

								<select id="formEnrolamientoLoginput2" class="form-control input-sm"
									name="programaid"></select>

							</div>

							<div class="form-group">

								<label for="formEnrolamientoLoginput3">Fecha inicio</label>

								<input type="date" id="formEnrolamientoLoginput3" class="form-control input-sm"
									value="<?php echo Date("Y-m-d") ?>" name="fechainicial" />

							</div>

							<div class="form-group">

								<label for="formEnrolamientoLoginput4">Fecha final</label>

								<input type="date" id="formEnrolamientoLoginput4" class="form-control input-sm"
									value="<?php echo Date("Y-m-d") ?>" name="fechafinal" />

							</div>

							<div class="form-group">

								<input type="submit" class="btn btn-default btn-sm" value="Buscar" />

							</div>

						</form>

					</div>

					<div class="col-xs-12 margin-top-1">

						<table class="table table-enrolamiento" id="tableLogEnrolamiento">

							<thead>

								<tr>

									<th colspan="6"><input type="text" class="form-control input-sm"
											data-search-input="true" placeholder="Buscar..."
											onkeyup="functionHandler('tableSearch',this);" /></th>

								</tr>

								<tr>

									<th class="center-text">Fecha</th>

									<th class="center-text">Laboratorio</th>

									<th class="center-text">Programa</th>

									<th class="center-text">Usuario</th>

									<th class="center-text">Acción</th>

									<th class="center-text">Descripción</th>

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

	<script src="jquery/jquery-2.1.4.min.js?v12-0"></script>

	<script src="javascript/loaderPersonalizado.js?v12-0"></script>

	<script>
		loaderPersonalizado("show", "Cargando configuraciones...");

		setTimeout(function () {

			loaderPersonalizado("hide");

		}, 2000);
	</script>

	<script src="jquery/jquery.md5.js?v12-0"></script>

	<script src="jquery/jquery-ui.min.js?v12-0"></script>

	<script src="jquery/jquery.statusBox.js?v12-0"></script>

	<script src="jquery/jquery.numericInput.min.js?v12-0"></script>

	<script src="jquery/jquery.mathjs.js?v12-0"></script>

	<script src="javascript/bootstrap.min.js?v12-0"></script>

	<script src="javascript/panel_control.js?v12-0"></script>

	<script src="javascript/configProgramaPAT.js?v12-0"></script>

	<script src="javascript/validarSiJSON.js?v12-0"></script>



</body>

</html>