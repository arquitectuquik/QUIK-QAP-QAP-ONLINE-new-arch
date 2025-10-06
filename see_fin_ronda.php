<?php

	session_start();
	include_once"php/verifica_sesion.php";
	actionRestriction_102();

    $id_reporte = $_GET["referencia"];
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
	<body class='m-0 p-0'>
        <div>
            <iframe src="php/temp_chart/<?php echo $id_reporte ?>.pdf" id="embed" style="height: 100vh;width: 100%; border: none;"></iframe>
        </div>

        <input type="hidden" value='<?php echo $id_reporte ?>' id='id_reference'>

        <script src="javascript/jquery-3.3.1.min.js?v12"></script>
        <script src="javascript/see_fin_ronda.js?v12"></script>

	</body>
</html>