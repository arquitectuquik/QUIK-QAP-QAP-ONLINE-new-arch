<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}


	session_start();
	include_once"php/verifica_sesion.php";
	actionRestriction_125();
	
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
		<link href="boostrap/4-5/css/bootstrap.min.css?v12" rel="stylesheet">		
        <link href="css/index_p.css?v12" rel="stylesheet">
        <link href="fontawesome/css/all.min.css?v12" rel="stylesheet">	

	</head>
	<body>
        
        <div class="containter-fluid">

            <nav class='navbar nabvar-light bg-light border-bottom shadow-sm py-2'>
                <a href="index_p.php" class='navbar-brand text-secondary ml-2'>
                    <img src="css/qlogo.png" height='40' alt="Logo de Quik S.A.S." class='d-inline-block align-top mr-2 pr-3 border-right border-secondary '>
                    <img src="css/LOGO QAPPAT.png" height='40' alt="Logo de QAP-PAT" class='d-inline-block align-top pr-2'>
                </a>
                <ul class='navbar-nav mr-auto'>
                    <li class="nav-item active font-weight-bold">
                        <a class="nav-link text-secondary" href="index_p.php">Patología anatómica</a>
                    </li>
                </ul>

                <div class='d-inline'>
                    <a href="php/cierra_sesion.php" class='py-2 px-3 text-dark'>Cerrar sesión <i class="fas fa-sign-out-alt"></i></a>
                </div>
            </nav>


            <div class="container-fluid per-graund">
                
            <div class="row xl-nowrap contenedor_main pt-0 pl-1 pb-1 pr-1 overflow-auto">
                    <div class="col-xs-12 col-md-2 bd-sidebar border-right shadow-sm bg-white">
                        <nav class="bd-links mt-3">
                            <form>
                                <div class="form-group">
                                    <label for="laboratoryid" class='font-weight-bold'>Laboratorio</label>
                                    <select class='form-control form-control-sm' id='laboratorio'>
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
                                    <label for="programapatid" class='font-weight-bold'>Programa PAT <strong class='text-primary'>*</strong></label>
                                    <select class='form-control form-control-sm' id='programa_pat'>
                                    </select>
                                </div>
                                
                                <hr class='my-2'>

                                <div class="form-group">
                                    <a class="btn btn-primary btn-sm btn-block text-white"  id='open_reports' target="_blank"><i class="fas fa-external-link-alt"></i> Ver mis reportes QAP</a>
                                </div>

                                <hr class='my-2'>

                                <div class="form-group">
                                    <a href='multimedia/quik_sas_politicas_qap_y_relacionadas.pdf' target='_blank' class="btn btn-block btn-secondary btn-sm border">
                                        <i class="fas fa-info-circle"></i>
                                        Políticas Programas QAP
                                    </a>
                                </div>

                            </form>
                        </nav>
                    </div>
                    <main class="col-xs-12 col-md-10 bd-content per-graund">
                        <div class="row p-2 border-bottom bg-white">
                            <p class='p-2 m-0'>
                                <span class='badge font-weight-normal'><strong>Laboratorio:</strong> <span id='camp-laboratorio'></span></span>
                                <span class='badge font-weight-normal'><strong>Contacto:</strong> <span id='camp-contacto'></span></span>
                                <span class='badge font-weight-normal'><strong>Dirección:</strong> <span id='camp-direccion'></span></span>
                                <span class='badge font-weight-normal'><strong>Teléfono:</strong> <span id='camp-telefono'></span></span>
                                <span class='badge font-weight-normal'><strong>Correo:</strong> <span id='camp-correo'></span></span>
                                <span class='badge font-weight-normal'><strong>Ciudad:</strong> <span id='camp-ciudad'></span></span>
                            </p>
                        </div>
                        <div class="row p-2 contenedor-retos">
                        </div>
                    </main>
                </div>
            </div>
        </div>
    	
        <script src="javascript/jquery-3.3.1.min.js?v12"></script>	
        <script src="boostrap/4-5/js/bootstrap.min.js?v12"></script>
        <script src="javascript/index_p.js?v12"></script>
        <script src="javascript/validarSiJSON.js?v12"></script>
	</body>
</html>