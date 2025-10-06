<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

session_start();
include_once "../php/verifica_sesion.php";
actionRestriction_102();
?>
<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="../boostrap/css/bootstrap.min.css?v12-0" rel="stylesheet" media="screen">

    <link href="../css/jquery-ui.min.css?v12-0" rel="stylesheet" media="screen">

    <link href="../css/listado_digitacion.css?v12-0" rel="stylesheet" media="screen">

    <link href="../css/pagina.css?v12-0" rel="stylesheet" media="screen">

</head>

<body onload="initialize();" class="transparent-body">
    <div class="col-xs-12 no-margin no-padding">
        <div class="col-xs-2" style="height: 100vh; overflow: auto;">
            <span class="glass"></span>
            <ul class="list-group">
                <li class="list-group-item pointer unselectable posibles" data-id="panel1" onmouseup="functionHandler('panelChooser',this, 'mainDiv');"><b title="Configurar Posibles resultados">Asignación de resultados<span class="pull-right glyphicon icon-icon-4" style="width: 24px; height: 24px;"></span></b></li>
            </ul>

        </div>
        <div class="col-xs-10 no-margin no-padding" style="height: 100vh; overflow: auto;">
            <!-- Asignación de resultados  -->
            <div class="panel panel-default cube-box no-margin" id="panel1" data-id="mainDiv" hidden="hidden">
                <div class="panel-heading cube-box">

                    <span title="Posibles resultados">Asignación de resultados</span>
                </div>
                <div style="height: 90.3vh; max-height: 90.3vh; overflow: auto;" id="panel1innerDiv4" data-id="p1id">
                    <div class="col-xs-4 border-right" style="max-height: inherit; overflow: auto;">
                        <form class="margin-top-2" id="formLabPrograma">
                            <div class="form-group">
                                <label for="formLabProgramainput1">Número de laboratorio</label>
                                <select class="form-control input-sm" id="formLabProgramainput1" name="labid">
                                    <?php
                                    $qry = "SELECT $tbl_laboratorio.id_laboratorio,no_laboratorio,nombre_laboratorio FROM $tbl_laboratorio ORDER BY no_laboratorio ASC";
                                    $qryArray = mysql_query($qry);
                                    while ($qryData = mysql_fetch_array($qryArray)) {
                                        echo '<option value="' . $qryData['id_laboratorio'] . '">' . $qryData['no_laboratorio'] . ' | ' . $qryData['nombre_laboratorio'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">

                                <label for="formLabProgramainput2">Programa</label>

                                <select class="form-control input-sm" id="formLabProgramainput2" name="programid"></select>

                            </div>
                            <div class="form-group">
						        <label for="formLabProgramainput3">Lote</label>
						        <select class="form-control input-sm" id="formLabProgramainput3" name="loteId"></select>
					        </div>
                            <div class="cont-boton-enviar">
                                <button class="btn btn-success" id='btn_guardar_digitacion'><i class="glyphicon glyphicon-floppy-disk"></i> Guardar información</button>
                                <i class='glyphicon glyphicon-folder-open btn btn-warning btn-config-posibles-resultados'>Ver registros</i>
                            </div>
                        </form>
                        <div class="main">
                            <div class="cont-digitaciones-realizadas"></div>
                        </div>
                    </div>
                </div>
                <div class='cont-modal-modificacion'></div>
            </div>
        </div>
    </div>
    <script src="../jquery/jquery-2.1.4.min.js?v12-0"></script>

    <script src="../jquery/jquery.md5.js?v12-0"></script>

    <script src="../jquery/jquery-ui.min.js?v12-0"></script>

    <script src="../jquery/jquery.statusBox.js?v12-0"></script>

    <script src="../jquery/jquery.numericInput.min.js?v12-0"></script>

    <script src="../jquery/jquery.mathjs.js?v12-0"></script>

    <script src="../javascript/bootstrap.min.js?v12-0"></script>


    <!-- <script src="../javascript/configProgramaPAT.js?v12-0"></script> -->
    <script src="../javascript/eliminarModal.js?v12"></script>
    <script src="../javascript/validarSiJSON.js?v12-0"></script>
    <script src="../javascript/uroanalisis/validarDigitacion.js"></script>
    <script src="../javascript/uroanalisis/digitacion.js?v12-0"></script>
    <script src="../javascript/uroanalisis/configResultadosVerdaderos.js?v12-1"></script>
    <script src="../javascript/resaltarCampoDigitacion.js?v12"></script>
    <script src="../javascript/tipoProgramaCualitativo.js?v12"></script>
    <script src="../javascript/alertarDigitacion.js?v12"></script>
</body>

</html>