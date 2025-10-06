<?php

	session_start();
	include ("verifica_sesion.php");
	include ("informe/informeFinRondaController.php");
	actionRestriction_102();

?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="../boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">
		<link href="../css/pagina.css?v12" rel="stylesheet" media="screen">			
	</head>
	<body>
        <div class="cont-graficas">
            <?php 
                $id_laboratorio = $_GET["laboratorio"];
                $id_programa = $_GET["programa"];
                $id_ronda = $_GET["ronda"];
                $fechas_corte = $_GET["fechas_corte"];

                $analitos_lab = informeFinRondaController::getAnalitos($id_laboratorio, $id_programa);
                foreach($analitos_lab as $analito_lab){
            ?>

                <div class='contenedor_graficos_correlacion' data-id_analito_lab='<?php echo $analito_lab->id_configuracion ?>'></div>

            <?php
                }
            ?>
        </div>

        <input type="hidden" value="<?php echo $id_laboratorio ?>" id='id_laboratorio'>
        <input type="hidden" value="<?php echo $id_programa ?>" id='id_programa'>
        <input type="hidden" value="<?php echo $id_ronda ?>" id='id_ronda'>
        <input type="hidden" value="<?php echo $id_ronda ?>" id='id_ronda'>
        <input type="hidden" value="<?php echo $fechas_corte ?>" id='fechas_corte'>
        
        <div class="progreso-envio-graficas">
            <h1 class='h3'>Generando información <span class='progreso'>0</span>%...</span>
        </div>
        
        <div class="cont-textareas"></div>

        <script src="../javascript/jquery-3.3.1.min.js?v12"></script>
        <script src="../chart/GoogleChart.min.js?v12"></script>
        <script src="../javascript/front_fin_ronda.js?v12"></script>
		<script src="../javascript/validarSiJSON.js?v12"></script>

	</body>
</html>