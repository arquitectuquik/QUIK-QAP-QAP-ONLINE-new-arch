
<?php
	
	if (isset($_GET['site'])) {
		$site = strtolower(stripcslashes(strip_tags($_GET['site'])));
	} else {
		$site = "NULL";
	}

	if (isset($_GET['siteCheckSum'])) {
		$siteCheckSum = $_GET['siteCheckSum'];
	} else {
		$siteCheckSum = "NULL";
	}	
	
	if (isset($_GET['key'])) {
		$key = $_GET['key'];
	} else {
		$key = "NULL";
	}
	
?>
<!DOCTYPE html>
<html lang="es">
	<head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
	</head>
	<body class="body-color" onload="initialize();">
		<div class=" col-xs-6 col-xs-offset-3 vertical-center">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-xs-6 border-right">
						<center>
							<img src="css/qlogo.png" style="width: 100%;border-radius: 10px;"></img>
						</center>
						<center>
							<h4><b>Restablecer contraseña</b></h4>
							<p><b>QAP Online</p>
						<center>
					</div>
					<div class="col-xs-6">
						<form id="form1">
							<div class="form-group" id="passDiv1">
								<label>Escriba la nueva contraseña</label>
								<input type="password" class="form-control" id="form1input1" name="newpassworda"/>
							</div>
							<div class="form-group" id="passDiv2">
								<label>Repita la contraseña</label>
								<input type="password" class="form-control" id="form1input2" name="newpasswordb"/>
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="form1input3" style="display: none;" name="sitevalue" value="<?php echo $site; ?>"/>
								<input type="text" class="form-control" id="form1input4" style="display: none;" name="sitechecksum" value="<?php echo $siteCheckSum; ?>"/>
								<input type="text" class="form-control" id="form1input5" style="display: none;" name="key" value="<?php echo $key; ?>"/>
								<input type="submit" class="btn btn-default" value="Cambiar"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<script src="jquery/jquery-3.2.1.min.js"></script>	
		<script src="jquery/jquery.md5.js"></script>	
		<script src="jquery/jquery-ui.min.js"></script>
		<script src="jquery/bootstrap.js"></script>
		<script src="jquery/jquery.statusBox.js"></script>
		<script src="javascript/passwordForm.js"></script>
	</body>
</html>