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
		<link href="boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/jquery-ui.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/pagina.css?v12" rel="stylesheet" media="screen">		
        <link href="fontawesome/css/all.min.css?v12" rel="stylesheet">
		<link href="css/jquery.dataTables.min.css?v12" rel="stylesheet" media="screen">
		<link href="css/listado_digitacion.css?v12" rel="stylesheet" media="screen">
		<link href="css/skin-win8/ui.fancytree.css?v12" rel="stylesheet" media="screen">
		<link href="css/fancytree-custom.css?v12" rel="stylesheet" media="screen">
		<link href="jquery/jquery-ui/jquery-ui.css?v12" rel="stylesheet" media="screen">
	</head>
	<body class="transparent-body">
		<div class="col-xs-12 margin-top-1">
			<div class="col-xs-12">
				<div class="panel panel-default shadow no-margin no-padding">
					<div class="panel-heading cube-box">
						<span style="margin: 1%; font-size: 16pt;">Histórico de digitación</span>
					</div>
					<div class="panel-body cont-referencia-selectores">
						<div class="col-xs-12 no-margin no-padding cont-selectores" id="formDigitacion">

                            <div class="col-xs-3">
                                <div class="form-group">
                                    <label for="programa">Programa</label>
                                    <select id="programa" class="form-control input-sm">
                                    <?php
                                        $qry = "SELECT 
                                                $tbl_programa.id_programa,
                                                $tbl_programa.nombre_programa,
                                                $tbl_tipo_programa.desc_tipo_programa
                                            FROM 
                                                $tbl_programa 
                                                join $tbl_tipo_programa on tipo_programa.id_tipo_programa = programa.id_tipo_programa
                                                join $tbl_digitacion on digitacion.id_programa = programa.id_programa
                                            group by $tbl_programa.id_programa
                                            ORDER BY $tbl_programa.nombre_programa ASC
                                        ";
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
									<select id="lote" class="form-control input-sm change_list">
                                        <option value='0'>Todos los números de lote</option>
									</select>
								</div>
							</div>
							<div class="col-xs-2">
								<div class="form-group">
									<label for="mes_inicial">Mes inicial</label>
									<input type="month" class='form-control input-sm change_list' id='mes_inicial' value='<?php echo (date("Y")-1)  ."-". date("m") ?>'>
								</div>
							</div>

                            <div class="col-xs-2">
								<div class="form-group">
									<label for="mes_inicial">Mes final</label>
									<input type="month" class='form-control input-sm change_list' id='mes_final' value='<?php echo date("Y-m") ?>'>
								</div>
							</div>
						</div>
						
						<!-- Gestiones -->
                        <div class="main">
                            <div class="cont-digitaciones-realizadas"></div>
                        </div>
						
                        <hr>
						<!-- Fin de la seccion de gestiones -->
					</div>	
				</div>
			</div>
		</div>


	<div class='cont-modal-modificacion'></div>
	<div class='cont-modal-asignacion'></div>
	
	<script src="javascript/jquery-3.3.1.min.js?v12"></script>
	<script src="jquery/jquery-ui/jquery-ui.js?v12"></script>
	<script src="javascript/jquery.dataTables.min.js?v12"></script>
	<script src="javascript/moment.min.js?v12"></script>
	<script src="javascript/sweetalert.min.js?v12"></script>

	<!-- Eventos y funciones alternas -->
	<script src="javascript/eliminarOptions.js?v12"></script>
	<script src="javascript/evaluarGeneracionVitros.js?v12"></script>
	<script src="javascript/eventoAgregarFilaGestion.js?v12"></script>
	<script src="javascript/eventoAsignarFloat.js?v12"></script>
	<script src="javascript/eventoEliminarFila.js?v12"></script>
	<script src="javascript/gestionSelectsSolicitud.js?v12"></script>
	<script src="javascript/listarElementos.js?v12"></script>
	<script src="javascript/listarSelect.js?v12"></script>
	<script src="javascript/resaltarCampoDigitacion.js?v12"></script>
	<script src="javascript/validarDigitacion.js?v12"></script>
	<script src="javascript/alertarDigitacion.js?v12"></script>
	<script src="javascript/validarItemsSeleccionados.js?v12"></script>
	<script src="javascript/eventoChangeAnalizador.js?v12"></script>
	<script src="javascript/eliminarModal.js?v12"></script>
	<script src="javascript/eventoCalcularCV.js?v12"></script>
	<script src="javascript/loaderPersonalizado.js?v12"></script>

    <script src="javascript/bootstrap.min.js?v12"></script>
    <script src="javascript/automatizacion_qapfor07.js?v12"></script>
	<script src="jquery/jquery.statusBox.js?v12"></script>
	<script src="javascript/listado_digitacion.js?v12-1"></script>
    <script src="javascript/tipoProgramaCualitativo.js?v12"></script>
    <script src="javascript/validarSiJSON.js?v12"></script>
	<script src="jquery/jquery.fancytree.js?v12"></script>

	</body>
</html>