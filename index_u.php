<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}


	session_start();
	include_once"php/verifica_sesion.php";
	userRestriction();
	
	$qry = "SELECT nombre_usuario FROM $tbl_usuario WHERE id_usuario = ".$_SESSION['qap_userId'];
	$qryData = mysql_fetch_array(mysql_query($qry));
	$val_1 = $qryData['nombre_usuario'];

	$qry = "SELECT valor_misc FROM $tbl_misc WHERE titulo_misc = 'version'";
	$qryData = mysql_fetch_array(mysql_query($qry));
	$val_2 = $qryData['valor_misc'];	
	
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Quality Assurance Program</title>
		<link rel="shortcut icon" href="css/qap_ico.png">
		<link href="boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/jquery-ui.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/vegas.css?v12" rel="stylesheet" media="screen">
		<link href="css/pagina.css?v12" rel="stylesheet" media="screen">			
	</head>
	<body onload="initialize()">
		<div class='fondo-principal-2' style='top: 0 !important; bottom: 0 !important; height: 100vh;'>
		</div>

		<div class="col-xs-12 no-margin no-padding">
			<div class="col-xs-2 bg-white" style="height: 100vh; overflow: auto; z-index:100">
				<span class="glass"></span>
				<div class="margin-top-5"></div>
				<div class="col-xs-12">
					<center>
						<span><a href="index_u.php"><img style="width: 100%; border-radius: 150px; border: 2px solid #1c50a4;" src="css/qap_logo.png"></img></a></span>
						<span style="font-size: 8pt;">v<?php echo $val_2; ?></span>
					</center>	
				</div>
				<div class="row"></div>
				<div class="margin-top-5"></div>
				<div class="col-xs-12 no-padding" id="form1">
					<hr/>
					<input type="text" id="form1input4" hidden="hidden"/>
					<div class="form-group">
						<label for="form1input1">Número de laboratorio</label>
						<select class="form-control input-sm" id="form1input1" name="labid">
						<?php
							$qry = "SELECT $tbl_laboratorio.id_laboratorio,no_laboratorio,nombre_laboratorio FROM $tbl_laboratorio INNER JOIN $tbl_usuario_laboratorio ON $tbl_laboratorio.id_laboratorio = $tbl_usuario_laboratorio.id_laboratorio WHERE $tbl_usuario_laboratorio.id_usuario = ".$_SESSION['qap_userId']." ORDER BY no_laboratorio ASC";
							$qryArray = mysql_query($qry);
							while ($qryData = mysql_fetch_array($qryArray)) {
								echo'<option value="'.encryptControl('encrypt',$qryData['id_laboratorio'],$_SESSION['qap_token']).'">'.$qryData['no_laboratorio'].' | '.$qryData['nombre_laboratorio'].'</option>';
							}
						?>						
						</select>
					</div>
					<div class="form-group">
						<label for="form1input2">Programa</label>
						<select class="form-control input-sm" id="form1input2" name="programid"></select>
					</div>
					<div class="form-group">
						<label for="form1input3">Ronda</label>
						<select class="form-control input-sm" id="form1input3" name="roundid"></select>
					</div>					
					<hr/>
					<div class="form-group">
						<button type="button" id='btn-config-analitos' class="btn btn-secondary btn-block" onmouseup="functionHandler('windowHandler','open','window2');" title="Configurar mensurandos"><i class="glyphicon glyphicon-pencil"></i> Configurar mis mensurandos</button>
						
						<a type="button" target='_blank' href='multimedia/quik_sas_politicas_qap_y_relacionadas.pdf' id='btn_panel_ayuda' class="btn btn-block">
							<i class="glyphicon glyphicon-info-sign"></i> Políticas Programas QAP
						</a>

						<a class="btn btn-primary btn-block"  id='open_reports' target="_blank"><i class="glyphicon glyphicon-new-window"></i> Ver mis reportes QAP</a>

					</div>					
					<hr/>
				</div>
				<div class="col-xs-12 no-padding">
					<ul class="list-group" id="form2">
						<li class="list-group-item pointer" id="form2input1"><b>Cerrar sesión <span class="glyphicon glyphicon-off pull-right"></span></b></li>
					</ul>
				</div>
			</div>
			<div class="col-xs-10 no-margin no-padding" style="height: 100vh; max-height: 100vh; max-width: 100%; overflow: auto;">
				<div class="col-xs-12 no-margin no-padding">
					<nav class="navbar navbar-default cube-box no-margin no-padding transparent-body">
						<span class="glass"></span>
						<ul class="nav navbar-nav inner-nav" style="padding: 5px 10px 5px 10px; font-size: 8pt; z-index:100; background-color: #fff;">
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Número de laboratorio:</label>
							<span style="padding: 0px 5px 0px 5px;" class="border-right" id="labDataSpan1"></span>
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Nombre de laboratorio:</label>
							<span style="padding: 0px 5px 0px 5px;" class="border-right" id="labDataSpan2"></span>
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Contacto de laboratorio:</label>
							<span style="padding: 0px 5px 0px 5px;" class="border-right" id="labDataSpan3"></span>
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Dirección de laboratorio:</label>
							<span style="padding: 0px 5px 0px 5px;" class="border-right" id="labDataSpan4"></span>	
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Teléfono de laboratorio:</label>
							<span style="padding: 0px 5px 0px 5px;" class="border-right" id="labDataSpan5"></span>	
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Correo de laboratorio:</label>
							<span style="padding: 0px 5px 0px 5px;" class="border-right" id="labDataSpan6"></span>	
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Ciudad:</label>
							<span style="padding: 0px 5px 0px 5px;" class="border-right" id="labDataSpan7"></span>	
							<label style="padding: 0px 5px 0px 5px;" class="control-label ">Pais:</label>
							<span style="padding: 0px 5px 0px 5px;" id="labDataSpan8"></span>											
						</ul>
					</nav>
				</div>			
				<div class="col-xs-10 col-xs-offset-1 margin-top-1">
					<div class="panel panel-default cube-box no-margin sombra-tenue" id="w3p">
						<div class="panel-heading cube-box bg-title">
							<span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;&nbsp;
							<span>
<?php
	echo $val_1;
	
	if ($_SESSION['qap_key'] == 0) {
		echo '<input type="date" class="sides-margin-1" id="tempDateInput" style="width: 150px; color: black;">';
	}

?>
							</span>
						</div>
						<div class="panel-body cube-box no-padding no-padding" style="height: 80vh; max-height: 80vh; overflow: auto;">
							<div class="col-xs-4 margin-top-2 border-right" style="max-height: inherit;">
								<table class="table table-condensed" id="table1">
									<thead>
										<tr>
											<th class="center-text">Muestra #</th>
											<th class="center-text">Código de muestra</th>
											<th class="center-text">Fecha de reporte de muestra</th>
											<th class="center-text"></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>								
							</div>
							<div class="col-xs-8 margin-top-2" style="max-height: inherit;">
								<form id="form3">
								<table class="table table-condensed" id="table2">
									<thead>
										<tr>
											<th class="center-text">Mensurando</th>
											<th class="center-text">Resultado</th>
											<th class="center-text">Posible Resultado</th>
											<th class="center-text">Fecha de reporte</th>
											<th class="center-text"><button id="form2Button1" class="btn btn-default btn-sm btn-block" type="button"><span class="glyphicon glyphicon-send"></span> Reportar</button></th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>	
		</div>
		<div class="col-xs-4 floating center" id="window1" hidden="hidden" data-item="window">
			<div class="panel panel-default shadow" id="w1p">
				<div class="panel-heading">
					Agregar comentario
					<button onmouseup="functionHandler('windowHandler','close','window1');" type="button" class="close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>						
				</div>
				<div class="panel-body">
					<div class="form-group margin-top-1">
						<label for="w1textarea1">Comentario</label>
						<textarea class="form-control input-sm" id="w1textarea1" data-id-holder="NULL"></textarea>
						<input type="input" id="w1textarea1counter" hidden="hidden">
						<span class="badge" style="margin-top:1%;">0 / 150</span>	
					</div>
					<hr/>
					<center>
						<input type="button" class="btn btn-default" value="Agregar" onmouseup="functionHandler('addAnalitResultComment','w1textarea1','table2','window1')">
					</center>
				</div>					
			</div>
		</div>
		<div class="col-xs-10 floating center" id="window2" hidden="hidden" data-item="window">
			<div class="panel panel-default shadow" id="w2p">
				<div class="panel-heading">
					Configurar mensurando
					<button onmouseup="functionHandler('windowHandler','close','window2');" type="button" class="close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>						
				</div>
				<div class="panel-body no-padding" style="height: 75vh; max-height: 75vh;">
					<div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">
					<!--<a target='_blank' id='btn-tutorial-enrolamiento' href="https://qaponline.quik.com.co/reportes/0039a3ee5574ce7072deb08ca6c279d7.pdf" class='btn btn-success'><i class="glyphicon glyphicon-new-window"></i>Video tutorial para configurar mensurandos</a>-->
					<form class="margin-top-2" id="form6">
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
							<select class="form-control input-sm" id="form6input8" name="vitrosgenid" disabled="disabled"></select>
						</div>	
						<div class="form-group">
							<label for="form6input9">Material o calibrador</label>
							<select class="form-control input-sm" id="form6input9" name="materialid"></select>
						</div>						
						<hr/>
						<div class="form-group">
							<center>
								<input type="submit" class="btn btn-default" value="Agregar nueva configuración"/>
							</center>	
						</div>									
					</form>
					</div>
					<div class="col-xs-8" style="max-height: inherit; overflow: auto;">
						<table class="table table-condensed" id="table15">
							<thead>
								<tr>
									<th colspan="10"><input type="text" class="form-control input-sm" data-search-input="true" placeholder="Buscar..." onkeyup="functionHandler('tableSearch',this);"/></th>
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
									<th class="center-text">Posibles resultados</th>
									<th class="center-text">Activo</th>
								</tr>	
							</thead>
							<tbody>
							</tbody>
						</table>							
					</div>
					
				</div>					
			</div>
		</div>

		<div class="col-xs-3 floating center" id="window250" data-item="window" hidden="hidden">
			<div class="panel panel-default shadow" id="w250p" data-id-holder="NULL">
				<div class="panel-heading">
					Seleccionar posibles resultados para configuración <b><span id="window1title1"></span></b>
					<button onmouseup="functionHandler('windowHandler','close','window250');" type="button" class="close">
						<span aria-hidden="true">&times;</span>
						<span class="sr-only">Close</span>
					</button>	
				</div>
				<div class="panel-body no-padding" style="height: 75vh; max-height: 75vh;">
					<div class="col-xs-12" style="max-height: inherit; overflow: auto;">
						<table class="table table-condensed table-hover" id="table250">
							<thead>
								<tr>
									<th colspan="2"><input type="text" class="form-control input-sm" data-search-input="true" placeholder="Buscar..." onkeyup="functionHandler('tableSearch',this);"/></th>
								</tr>
								<tr>
									<th class="center-text">Descripción de resultado</th>
									<th class="center-text"><button id="table250input1" class="btn btn-default btn-sm" type="button" style="width: 83%;"><span class="glyphicon glyphicon-floppy-disk"></span> Guardar</button></th>
								</tr>	
							</thead>
							<tbody>
							</tbody>
						</table>											
					</div>
				</div>					
			</div>
		</div>		
			
	<script src="jquery/jquery-2.1.4.min.js?v12"></script>	
	<script src="jquery/jquery.form.min.js?v12"></script>
	<script src="jquery/jquery.vegas.js?v12"></script>
	<script src="jquery/jquery-ui.min.js?v12"></script>
	<script src="jquery/jquery.statusBox.js?v12"></script>
	<script src="jquery/jquery.numericInput.min.js?v12"></script>
	<script src="jquery/jquery.alphanum.js?v12"></script>
	<script src="jquery/jquery.cookie.js?v12"></script>
	<script src="javascript/bootstrap.min.js?v12"></script>
	<script src="javascript/index_u.js?v12"></script>
	</body>
</html>