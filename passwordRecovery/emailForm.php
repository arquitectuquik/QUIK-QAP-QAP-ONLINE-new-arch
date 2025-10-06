<?php
	
	if (isset($_GET['site'])) {
		$site = htmlspecialchars($_GET['site'], ENT_QUOTES, 'UTF-8');
	} else {
		$site = "NULL";
	}
	
	if (isset($_GET['useremail'])) {
		$useremail = htmlspecialchars($_GET['useremail'], ENT_QUOTES, 'UTF-8');
	} else {
		$useremail = "";
	}	

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Recupera contraseña</title>
		<link rel="shortcut icon" href="#">
		<link href="css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="css/bootstrap-theme.css" rel="stylesheet" media="screen">
		<link href="css/jquery-ui.css" rel="stylesheet" media="screen">
		<link href="css/jquery-ui.structure.css" rel="stylesheet" media="screen">
		<link href="css/jquery-ui.theme.css" rel="stylesheet" media="screen">
		<link href="css/pagina.css" rel="stylesheet" media="screen">
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<!--[endif]-->
	</head>
	<body class="body-color" onload="initialize();">
		<div class="col-xs-12 vertical-center">
			<div class="panel panel-default" id="panel1">
				<div class="panel-body">
					<form id="form1">
						<div class="form-group">
							<label>Nombre de usuario o correo electrónico</label>
							<input type="text" class="form-control" id="form1input1" maxlength="255" name="membervalue" value="<?php echo $useremail; ?>" required/>
							<input type="text" class="form-control" id="form1input2" maxlength="255" name="sitevalue" value="<?php echo $site ?>" style="display: none;"/>
						</div>
						<div class="form-group">
							<input type="submit" class="btn btn-default" value="Verificar"/>
						</div>
					</form>
				</div>	
			</div>
			<div class="panel panel-default" id="panel2" style="display: none;">
				<div class="panel-body">
					<p>El nombre de usuario ingresado no posee una cuenta de correo electrónico asignado, por favor comuniquese con una de las siguientes lineas de atención para registrar la cuenta de correo electrónico.</p>
					<p><b>Contact center (Bogotá):</b> [+57] (1) 222-9151</p>
					<p><b>Contact center (celular):</b> [+57] 318-271-1649</p>
				</div>
			</div>
		</div>
		<script src="jquery/jquery-3.2.1.min.js"></script>	
		<script src="jquery/jquery-ui.min.js"></script>
		<script src="jquery/bootstrap.js"></script>
		<script src="jquery/jquery.statusBox.js"></script>
		<script src="javascript/emailForm.js"></script>
	</body>
</html>