<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	
	/*
	ini_set('display_errors', 0);
	ini_set('display_startup_errors', 0);
	error_reporting(E_ALL);
	*/

	session_start();

	include_once"verifica_sesion.php";
	include_once "correo/enviarCorreoReporteLC.php";
	include_once "correo/enviarCorreoReportePAT.php";
	
	actionRestriction_102();
	
	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";
	
	$header = $_POST['header'];
	
	switch ($header) {

		case 'catRegistry':
			actionRestriction_101();

			$disid = $_POST['disid'];
			$catname = $_POST['catname']; // Nombre de material

			// Consulta para validar la metodologia
			$qry = "SELECT id_catalogo FROM $tbl_catalogo WHERE id_distribuidor = '".clean($disid)."' and nombre_catalogo = '".clean($catname)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay catalogos ya registrados
				echo '<response code="422">El nombre del catalogo ya esta registrado</response>';
			} else if(strlen($catname) < 1 || strlen($catname) > 255) {
				echo '<response code="422">El nombre del catálogo debe tener entre 1 y 255 carácteres</response>';
			} else {
				$qry = "INSERT INTO $tbl_catalogo (id_distribuidor,nombre_catalogo) VALUES ('".clean($disid)."','".clean($catname)."')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02_");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';	
			}		
			
		break;
		case 'catValueEditor':
			
			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					
					// Consulta para validar la duplicicidad de la informacion
					// Obtiene el id
					$qry = "SELECT nombre_catalogo FROM $tbl_catalogo WHERE id_catalogo = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$nombre_catalogo = $qryData["nombre_catalogo"];
						$x++;
					}

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_distribuidor FROM $tbl_catalogo WHERE id_distribuidor = '".clean($value)."' and nombre_catalogo = '".clean($nombre_catalogo)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					
					if ($checkrows > 0) { // Si hay ya registradas
						echo '<response code="422">EL catalogo especificada, ya existe para el proveedor indicado</response>';
					} else {

						$qry = "UPDATE $tbl_catalogo SET id_distribuidor = '".clean($value)."' WHERE id_catalogo = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;				
				case 2:

					// Consulta para validar la duplicicidad de la informacion
					// Obtiene el id
					$qry = "SELECT id_distribuidor FROM $tbl_catalogo WHERE id_catalogo = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$id_distribuidor = $qryData["id_distribuidor"];
						$x++;
					}

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_distribuidor FROM $tbl_catalogo WHERE id_distribuidor = '".clean($id_distribuidor)."' and nombre_catalogo = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					
					if ($checkrows > 0) { // Si hay ya registradas
						echo '<response code="422">EL catalogo especificada, ya existe para el proveedor indicado</response>';
					} else if(strlen(clean($value)) < 1 || strlen(clean($value)) > 255) {
						echo '<response code="422">El nombre del catálogo debe tener entre 1 y 255 carácteres</response>';
					} else {

						$qry = "UPDATE $tbl_catalogo SET nombre_catalogo = '".clean($value)."' WHERE id_catalogo = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}

				break;
			}

		break;
		case 'catDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_catalogo FROM $tbl_catalogo WHERE id_catalogo = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_catalogo WHERE id_catalogo = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'lotRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['catid'];
			$postValues_2 = $_POST['lotnumber'];
			$postValues_3 = $_POST['lotdate'];
			$postValues_4 = $_POST['lotlevel'];
			$ultimoCaracter = substr(clean($postValues_2),-1);
			// Consulta para validar
			$qry = "SELECT id_lote FROM $tbl_lote WHERE nombre_lote = '".clean($postValues_2)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay ya registrados
				echo '<response code="422">El numero de lote ya esta registrado para el mismo u otro catalogo</response>';
			} else if(strlen($postValues_2) < 1 || strlen($postValues_2) > 255) {
				echo '<response code="422">El numero del lote debe tener entre 1 y 255 carácteres</response>';
			} else if($postValues_3 == "") {
				echo '<response code="422">Debe especificar una fecha de vencimiento</response>';
			} else if($ultimoCaracter != 1 && $ultimoCaracter != 2 && $ultimoCaracter != 3){ // El ultimo digito debe ser del numero de nivel
				echo '<response code="422">El último número de lote debe indicar el NIVEL del control</response>';
			} else {
				$qry = "INSERT INTO $tbl_lote (nombre_lote,nivel_lote,estado_lote,id_catalogo,fecha_vencimiento) VALUES ('$postValues_2','$postValues_4',1,$postValues_1,'$postValues_3')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';	
			}
			
		break;
		case 'lotValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {

				case 1:
					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT * FROM $tbl_lote WHERE id_lote = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$id_catalogo = $qryData["id_catalogo"];
						$nombre_lote = $qryData["nombre_lote"];
						$nivel_lote = $qryData["nivel_lote"];
						$x++;
					}

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_lote FROM $tbl_lote WHERE id_catalogo = '".clean($value)."' and nombre_lote = '".clean($nombre_lote)."' and nivel_lote = '".clean($nivel_lote)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si ya hay lotes exactamente iguales
						echo '<response code="422">EL lote especificada, ya se encuentra registrado con el mismo catalogo y el mismo nivel</response>';
					} else {
						$qry = "UPDATE $tbl_lote SET id_catalogo = $value WHERE id_lote = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;
				case 2:
					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_lote FROM $tbl_lote WHERE nombre_lote = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					$ultimoCaracter = substr(clean($value),-1);
					
					if ($checkrows > 0) { // Si ya hay lotes exactamente iguales
						echo '<response code="422">EL nombre de lote, ya se encuentra registrado</response>';
					} else if(strlen(clean($value)) < 1 || strlen(clean($value)) > 255) {
						echo '<response code="422">El numero del lote debe tener entre 1 y 255 carácteres</response>';
					} else if($ultimoCaracter != 1 && $ultimoCaracter != 2 && $ultimoCaracter != 3){ // El ultimo digito debe ser del numero de nivel
						echo '<response code="422">El último número de lote debe indicar el NIVEL del control</response>';
					} else {
						$qry = "UPDATE $tbl_lote SET nombre_lote = '".clean($value)."' WHERE id_lote = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;	
				case 3:
					if(clean($value) == "") {
						echo '<response code="422">Debe especificar una fecha de vencimiento</response>';
					} else {
						$qry = "UPDATE $tbl_lote SET fecha_vencimiento = '".clean($value)."' WHERE id_lote = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				break;	
				case 4:
					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT * FROM $tbl_lote WHERE id_lote = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$id_catalogo = $qryData["id_catalogo"];
						$nombre_lote = $qryData["nombre_lote"];
						$nivel_lote = $qryData["nivel_lote"];
						$x++;
					}

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_lote FROM $tbl_lote WHERE id_catalogo = '".clean($id_catalogo)."' and nombre_lote = '".clean($nombre_lote)."' and nivel_lote = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si ya hay lotes exactamente iguales
						echo '<response code="422">EL lote especificada, ya se encuentra registrado con el mismo catalogo y el mismo nivel</response>';
					} else {
						$qry = "UPDATE $tbl_lote SET nivel_lote = '".clean($value)."' WHERE id_lote = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x04");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;
				case 5:
					$qry = "UPDATE $tbl_lote SET estado_lote = '".clean($value)."' WHERE id_lote = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x05");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					echo'<response code="1"></response>';
				break;				
			}
			
		break;


		case 'intentosPATValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 6:
					$qry = "UPDATE $tbl_intento SET revaloracion = $value WHERE id_intento = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x05");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					echo'<response code="1"></response>';
				break;				
			}
			
		break;
		case 'lotDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_lote FROM $tbl_lote WHERE id_lote = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_lote WHERE id_lote = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'programRegistry':

			actionRestriction_101();
			$postValues_1 = $_POST['programname'];
			$postValues_2 = $_POST['programabbr'];
			$postValues_4 = $_POST['sampletype'];
			$postValues_5 = $_POST['programmodality'];
			$postValues_3 = $_POST['programnosamples'];
			$postValues_6 = $_POST['programtype'];
			
			// Consulta para validar
			$qry = "SELECT id_programa FROM $tbl_programa WHERE nombre_programa = '".clean($postValues_1)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");

			// Consulta para validar la duplicicidad de la informacion
			$qry2 = "SELECT id_programa FROM $tbl_programa WHERE sigla_programa = '".clean($postValues_2)."' LIMIT 1";
			$checkrows2 = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");
		
			if ($checkrows > 0) { // Si hay ya registrados
				echo '<response code="422">El nombre del programa ya esta registrado en la base de datos</response>';
			} else if($checkrows2 > 0){
				echo '<response code="422">La sigla de programa, ya se encuentra registrada</response>';
			} else if(strlen(clean($postValues_1)) < 1 || strlen(clean($postValues_1)) > 255){
				echo '<response code="422">La nombre del programa debe tener minimo un carácter y máximo 255</response>';
			} else if(strlen(clean($postValues_2)) < 1 || strlen(clean($postValues_2)) > 255){
				echo '<response code="422">La sigla de programa debe tener minimo un carácter y máximo 255</response>';
			} else if($postValues_3 < 1 || $postValues_3 > 15){
				echo '<response code="422">El numero de muestras debe estar entre 1 y 15</response>';
			} else if($postValues_4 == ""){
				echo '<response code="422">El tipo de muestra es obligatorio</response>';
			} else if(strlen(clean($postValues_5)) < 1 || strlen(clean($postValues_5)) > 255){
				echo '<response code="422">La modalidad del programa debe tener minimo un carácter y máximo 255</response>';
			} else if($postValues_6 == ""){
				echo '<response code="422">El tipo de programa es obligatorio</response>';
			} else {
				$qry = "INSERT INTO $tbl_programa (nombre_programa,sigla_programa,no_muestras,tipo_muestra,modalidad_muestra,id_tipo_programa) VALUES ('$postValues_1','$postValues_2','$postValues_3','$postValues_4','$postValues_5',$postValues_6)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';	
			}
			
		break;
		case 'programValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {

				case 1:
					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_programa FROM $tbl_programa WHERE nombre_programa = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows > 0) { // Si ya hay lotes exactamente iguales
						echo '<response code="422">EL nombre de programa, ya se encuentra registrado</response>';
					} else if(strlen(clean($value)) < 1 || strlen(clean($value)) > 255){
						echo '<response code="422">La nombre del programa debe tener minimo un carácter y máximo 255</response>';
					} else {
						$qry = "UPDATE $tbl_programa SET nombre_programa = '".clean($value)."' WHERE id_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;
				case 2:

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_programa FROM $tbl_programa WHERE sigla_programa = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows > 0) { // Si ya hay lotes exactamente iguales
						echo '<response code="422">La sigla de programa, ya se encuentra registrada</response>';
					} else if(strlen(clean($value)) < 1 || strlen(clean($value)) > 255){
						echo '<response code="422">La sigla de programa debe tener minimo un carácter y máximo 255</response>';
					} else {
						$qry = "UPDATE $tbl_programa SET sigla_programa = '".clean($value)."' WHERE id_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;
				case 3:
					// Consulta para validar la duplicicidad de la informacion
					if($value < 1 || $value > 15){
						echo '<response code="422">El numero de muestras debe estar entre 1 y 15</response>';
					} else {
						$qry = "UPDATE $tbl_programa SET no_muestras = '".clean($value)."' WHERE id_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				break;
				case 4:
					if($value == ""){
						echo '<response code="422">El tipo de muestra es obligatorio</response>';
					} else {
						$qry = "UPDATE $tbl_programa SET tipo_muestra = '".clean($value)."' WHERE id_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x04");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;	
				case 5:
					if(strlen(clean($value)) < 1 || strlen(clean($value)) > 255){
						echo '<response code="422">La modalidad del programa debe tener minimo un carácter y máximo 255</response>';
					} else {
						$qry = "UPDATE $tbl_programa SET modalidad_muestra = '".clean($value)."' WHERE id_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x05");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				break;
				case 6:

					if($value == ""){
						echo '<response code="422">El tipo de programa es obligatorio</response>';
					} else {
						$qry = "UPDATE $tbl_programa SET id_tipo_programa = ".clean($value)." WHERE id_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x06");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;					
			}
			
		break;
		case 'programDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_programa FROM $tbl_programa WHERE id_programa = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					
					$qry = "DELETE $tbl_ronda.* FROM $tbl_ronda INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra WHERE $tbl_muestra_programa.id_programa = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;					
					
					$qry = "DELETE $tbl_muestra.* FROM $tbl_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra WHERE $tbl_muestra_programa.id_programa = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;					
					
					$qry = "DELETE FROM $tbl_programa WHERE id_programa = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x03");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'analitRegistry':

			actionRestriction_101(); // Permisos de la accion de registro

			$programid = clean($_POST['programid']);
			$analitid = clean($_POST['analitid']);

			// Consulta para validar duplicidad
			$qry = "SELECT * 
				FROM programa_analito  
				WHERE id_analito = '".clean($analitid)."' AND id_programa = '".clean($programid)."'
			LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
		

			if ($checkrows > 0) { // Si hay analitos para el mismo programa registradas
				echo '<response code="422">Ya existe un mensurando registrado para el mismo programa</response>';
			} else if($programid == ''){
				echo '<response code="422">Debe especificar el programa</response>';
			} else if($analitid == ''){
				echo '<response code="422">Debe especificar el analito</response>';
			} else {
					
				$qry = "INSERT INTO $tbl_programa_analito (id_programa,id_analito) VALUES ($programid,$analitid)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x08_");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;	
				
				echo '<response code="1">1</response>';
			}
			
		break;
		case 'analitValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1: // Programa

					// Se obtiene la informacion de la conexion a modificar
					$qry = "SELECT * 
					FROM programa_analito  
					WHERE id_conexion = '".clean($id)."'
					LIMIT 1";
					$qryData = mysql_fetch_array(mysql_query($qry));
					$id_analito = $qryData["id_analito"];

					// Consulta para validar duplicidad
					$qry = "SELECT * 
					FROM programa_analito  
					WHERE id_analito = $id_analito AND id_programa = '".clean($value)."'
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows > 0) { // Si hay analitos para el mismo programa registradas
						echo '<response code="422">Ya existe un mensurando registrado para el programa indicado</response>';
					} else if($value == ''){
						echo '<response code="422">Debe especificar el programa</response>';
					} else {
						$qry = "UPDATE $tbl_programa_analito SET id_programa = $value WHERE id_conexion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
					
				break;

				case 2: // Nombre de analito

					// Se obtiene la informacion de la conexion a modificar
					$qry = "SELECT * 
					FROM programa_analito  
					WHERE id_conexion = '".clean($id)."'
					LIMIT 1";
					$qryData = mysql_fetch_array(mysql_query($qry));
					$id_programa = $qryData["id_programa"];

					// Consulta para validar duplicidad
					$qry = "SELECT * 
					FROM programa_analito  
					WHERE id_analito = '".clean($value)."' AND id_programa = $id_programa
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows > 0) { // Si hay analitos para el mismo programa registradas
						echo '<response code="422">Ya existe un mensurando registrado para el programa indicado</response>';
					} else if($value == ''){
						echo '<response code="422">Debe especificar el analito</response>';
					} else {
						$qry = "UPDATE $tbl_programa_analito SET id_analito = $value WHERE id_conexion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;
			}
			
		break;
		case 'analitDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_analito FROM $tbl_programa_analito WHERE id_conexion = $ids[$x]";
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_0x04");
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_analito WHERE id_analito = ".$qryData['id_analito'];
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x05");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'documentRegistry':

			// actionRestriction_100();

			$postValues_1 = $_POST['clientid'];
			$postValues_2 = $_POST['programid'];
			$postValues_3 = $_FILES['documentfiles'];
			$postValues_4 = $_POST['item'];
			$postValues_5 = $_POST['cicloid'];
			$tempValue_1 = mysql_real_escape_string(stripcslashes(clean($postValues_1)));
			$tempValue_2 = mysql_real_escape_string(stripcslashes(clean($postValues_2)));
			$tempValue_5 = mysql_real_escape_string(stripcslashes(clean($postValues_5)));
			$maxFileSize = 104857600;
			
			if (isset($postValues_3) && $postValues_3["error"]== UPLOAD_ERR_OK) {
		
				$uploadDirectory = '../reportes/';
		
				if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
					echo('<response code="0" item="'.$postValues_4.'">Acceso denegado.</response>');
					mysql_close($con);
					exit;			
				}
				
				if ($postValues_3["size"] > $maxFileSize) {
					echo('<response code="0" item="'.$postValues_4.'">El tamaño del archivo es demasiado grande para "'.$postValues_3['name'].'". El tamaño maximo permitido es 100 MB.</response>');
					mysql_close($con);
					exit;			
				}
				
				switch(strtolower($postValues_3['type'])) {
		
						case 'image/png': 
						case 'image/gif': 
						case 'image/jpeg': 
						case 'image/pjpeg':
						case 'text/plain':
						case 'text/html':
						case 'application/x-zip-compressed':
						case 'application/pdf':
						case 'application/msword':
						case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
						case 'application/vnd.openxmlformats-officedocument.wordprocessingml.template':
						case 'application/vnd.ms-word.document.macroenabled.12':
						case 'application/vnd.ms-word.template.macroenabled.12':
						case 'application/vnd.ms-excel':
						case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
						case 'application/vnd.openxmlformats-officedocument.spreadsheetml.template':
						case 'application/vnd.ms-excel.sheet.macroenabled.12':
						case 'application/vnd.ms-excel.template.macroenabled.12':
						case 'application/vnd.ms-excel.addin.macroenabled.12':
						case 'application/vnd.ms-excel.sheet.binary.macroenabled.12':
						case 'application/vnd.ms-powerpoint':
						case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
						case 'application/vnd.openxmlformats-officedocument.presentationml.template':
						case 'application/vnd.openxmlformats-officedocument.presentationml.slideshow':
						case 'application/vnd.ms-powerpoint.addin.macroenabled.12':
						case 'application/vnd.ms-powerpoint.presentation.macroenabled.12':
						case 'application/vnd.ms-powerpoint.template.macroenabled.12':
						case 'application/vnd.ms-powerpoint.slideshow.macroenabled.12':
						case 'video/mp4':
						break;
						default:
							echo('<response code="0" item="'.$postValues_4.'">No es posible cargar este tipo de archivo para "'.$postValues_3['name'].'".</response>');
							mysql_close($con);
							exit;					
						break;	
				}
				
				$fileNameControl = explode(".",$postValues_3['name']);		
				
				if (sizeof($fileNameControl) > 2) {
					echo('<response code="0" item="'.$postValues_4.'">El archivo "'.$postValues_3['name'].'" posee un nombre invalido: (más de dos puntos).</response>');
					mysql_close($con);
					exit;				
				}	
				
				$file_Name = explode(".",$postValues_3['name']);
				$file_Name = mysql_real_escape_string(stripcslashes(clean($file_Name[0])));
				
				$file_Ext = explode(".",$postValues_3['name']);
				$file_Ext = mysql_real_escape_string(stripcslashes(clean(strtolower($file_Ext[1]))));
				
				$qryLab = "SELECT no_laboratorio FROM laboratorio where id_laboratorio = ". $tempValue_1;
				$qryLabArray = mysql_query($qryLab);
				$qryDataLab = mysql_fetch_array($qryLabArray);
				$no_laboratorio = $qryDataLab['no_laboratorio'];

				if(strpos($no_laboratorio, "200") === 0){			
					$qry = "SELECT archivo.id_archivo FROM archivo WHERE nombre_archivo = '$file_Name' AND extencion_archivo = '$file_Ext' AND id_laboratorio = '$tempValue_1' AND id_reto = '$tempValue_5'";
					
					$qryRows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");
					
					if ($qryRows > 0) {
						echo('<response code="0" item="'.$postValues_4.'">El archivo "'.$postValues_3['name'].'" ya existe en la base de datos.</response>');
						mysql_close($con);
						exit;			
					} else {
						
						$indexName = md5(uniqid(rand(), true));
											
						$newFileName = $indexName.".".$file_Ext;
					
						if(move_uploaded_file($postValues_3['tmp_name'], $uploadDirectory.$newFileName )) {
							
							$qry = "INSERT INTO archivo (id_laboratorio,id_reto,nombre_archivo,extencion_archivo,activo,index_archivo,fecha_carga) VALUES ('$tempValue_1','$tempValue_5','$file_Name','$file_Ext',1,'$indexName','$logDate')";
							mysql_query($qry);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qry;
							$iSum++;		
							
							if(strpos($file_Name, 'razabilidad') === false){ // Si el nombre del documento no contiene la palabra "Trazabilidad"
								enviarCorreoReportePAT($tempValue_1,$tempValue_5,$file_Name,$file_Ext);
							}
							
							echo('<response code="1" item="'.$postValues_4.'">Carga exitosa</response>');
						} else {
							echo('<response code="0" item="'.$postValues_4.'">Error al cargar el archivo "'.$postValues_3['name'].'".</response>');
						}			
											
					}
				} else if(strpos($no_laboratorio, "100") === 0) { // Cuando es de laboratorio clinico
					$qry = "SELECT archivo.id_archivo FROM archivo WHERE nombre_archivo = '$file_Name' AND extencion_archivo = '$file_Ext' AND id_laboratorio = '$tempValue_1' AND id_ronda = '$tempValue_5'";
					
					$qryRows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");
					
					if ($qryRows > 0) {
						echo('<response code="0" item="'.$postValues_4.'">El archivo "'.$postValues_3['name'].'" ya existe en la base de datos.</response>');
						mysql_close($con);
						exit;			
					} else {
						$indexName = md5(uniqid(rand(), true));
						$newFileName = $indexName.".".$file_Ext;
						if(move_uploaded_file($postValues_3['tmp_name'], $uploadDirectory.$newFileName )) {
							$qry = "INSERT INTO archivo (id_laboratorio,id_ronda,nombre_archivo,extencion_archivo,activo,index_archivo,fecha_carga) VALUES ('$tempValue_1','$tempValue_5','$file_Name','$file_Ext',1,'$indexName','$logDate')";
							mysql_query($qry);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qry;
							$iSum++;					

							if(strpos($file_Name, 'razabilidad') === false){ // Si el nombre del documento no contiene la palabra "Trazabilidad"
								enviarCorreoReporteLC($tempValue_1, $tempValue_5, $file_Name, $file_Ext);
							}

							echo('<response code="1" item="'.$postValues_4.'">Carga exitosa</response>');
						} else {
							echo('<response code="0" item="'.$postValues_4.'">Error al cargar el archivo "'.$postValues_3['name'].'".</response>');		
						}	
					}				
					
				} else {
					echo('<response code="0" item="'.$postValues_4.'">Algo salió mal con la carga. Por favor verifique que "upload_max_filesize" esté correctamente configurado en su php.ini.</response>');
					mysql_close($con);
					exit;		
				}			
		}
		break;

		case 'documentValueEditor':

			// actionRestriction_100();

			$which = $_POST['which'];
			$id = encryptControl('decrypt',$_POST['id'],$_SESSION['qap_token']);
			$value = $_POST['value'];
			
			switch ($which) {
				case 2:
					$qry = "UPDATE archivo SET nombre_archivo = '".clean($value)."' WHERE id_archivo = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;
				case 4:
					$qry = "UPDATE archivo SET activo = ".clean($value)." WHERE id_archivo = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;
					
			}
			
			echo'<response code="1"></response>';
			
		break;

		case 'casoClinicoPATValueEditor':

			actionRestriction_0();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = trim($_POST['value']);

			switch ($which) {

				case 1: // Reto
					$qryR = "UPDATE caso_clinico SET reto_id_reto = '".$value."' WHERE id_caso_clinico = $id";
					mysql_query($qryR);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['INSERT'][$iSum] = $qryR;
					echo '<response code="1">1</response>';
				break;

				case 2: // Codigo
					$qry = "SELECT * FROM caso_clinico WHERE codigo = '".$value."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) {
						echo '<response code="422">El codigo de caso clinico ya esta registrado</response>';
					} else if(strlen($value) < 2 || strlen($value) > 45){
						echo '<response code="422">El codigo de caso clinico debe tener entre 2 y 45 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE caso_clinico SET codigo = '".$value."' WHERE id_caso_clinico = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;

				case 3: // Nombre del caso clinico
					if(strlen($value) < 2 || strlen($value) > 200){
						echo '<response code="422">El campo de nombre debe tener entre 2 y 200 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE caso_clinico SET nombre = '".$value."' WHERE id_caso_clinico = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;
				
				case 4: // Enunciado
					if($value == "0"){ // Si el valor es NULO
						$qryR = "UPDATE caso_clinico SET enunciado = NULL WHERE id_caso_clinico = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					} else {
						if(strlen($value) < 4 || strlen($value) > 20000){
							echo '<response code="422">El campo de enunciado debe tener entre 2 y 20.000 carácteres de longitud</response>';
						} else {
							$qryR = "UPDATE caso_clinico SET enunciado = '".$value."' WHERE id_caso_clinico = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					}
				break;
				
				case 5: // Revision
					if($value == "0"){ // Si el valor es NULO
						$qryR = "UPDATE caso_clinico SET revision = NULL WHERE id_caso_clinico = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					} else {
						if(strlen($value) < 4 || strlen($value) > 20000){
							echo '<response code="422">El campo de revisión debe tener entre 2 y 20.000 carácteres de longitud</response>';
						} else {
							$qryR = "UPDATE caso_clinico SET revision = '".$value."' WHERE id_caso_clinico = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					}
				break;

				case 6: // Tejido
					if($value == "0"){ // Si el valor es NULO
						$qryR = "UPDATE caso_clinico SET tejido = NULL WHERE id_caso_clinico = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					} else {
						if(strlen($value) < 4 || strlen($value) > 45){
							echo '<response code="422">El campo de tejido debe tener entre 2 y 45 carácteres de longitud</response>';
						} else {
							$qryR = "UPDATE caso_clinico SET tejido = '".$value."' WHERE id_caso_clinico = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					}
				break;

				case 7: // Celulas objetivo
					if($value == "0"){ // Si el valor es NULO
						$qryR = "UPDATE caso_clinico SET celulas_objetivo = NULL WHERE id_caso_clinico = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					} else {
						if(strlen($value) < 4 || strlen($value) > 45){
							echo '<response code="422">El campo de células objetivo debe tener entre 2 y 45 carácteres de longitud</response>';
						} else {
							$qryR = "UPDATE caso_clinico SET celulas_objetivo = '".$value."' WHERE id_caso_clinico = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					}
				break;

				case 8: // Estado
					$qry = "UPDATE caso_clinico SET estado = ".clean($value)." WHERE id_caso_clinico = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x45888");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					echo'<response code="1"></response>';
				break;				
			}

			break;

		case 'preguntaValueEditor':

			actionRestriction_0();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = trim($_POST['value']);

			switch ($which) {

				case 3:
					if(strlen($value) < 2 || strlen($value) > 400){
						echo '<response code="422">El nombre de la pregunta debe tener entre 2 y 400 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE pregunta SET nombre = '".$value."' WHERE id_pregunta = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;
				
				case 4:
					if($value == "0"){ // Si el valor es NULO
						$qryR = "UPDATE pregunta SET intervalo_min = NULL WHERE id_pregunta = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					} else {
						if(!is_numeric($value)){
							echo '<response code="422">El campo mínimo debe ser un valor numérico</response>';
						} else {
							$qryR = "UPDATE pregunta SET intervalo_min = '".$value."' WHERE id_pregunta = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					}
				break;
				
				case 5:
					if($value == "0"){ // Si el valor es NULO
						$qryR = "UPDATE pregunta SET intervalo_max = NULL WHERE id_pregunta = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					} else {
						if(!is_numeric($value)){
							echo '<response code="422">El campo máximo debe ser un valor numérico</response>';
						} else {
							$qryR = "UPDATE pregunta SET intervalo_max = '".$value."' WHERE id_pregunta = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					}
				break;			
			}

			break;

			case 'preguntaValueEditor':

				actionRestriction_0();
	
				$which = $_POST['which'];
				$id = $_POST['id'];
				$value = trim($_POST['value']);
	
				switch ($which) {
	
					case 3:
						if(strlen($value) < 2 || strlen($value) > 400){
							echo '<response code="422">El nombre de la pregunta debe tener entre 2 y 400 carácteres de longitud</response>';
						} else {
							$qryR = "UPDATE pregunta SET nombre = '".$value."' WHERE id_pregunta = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					break;
					
					case 4:
						if($value == "0"){ // Si el valor es NULO
							$qryR = "UPDATE pregunta SET intervalo_min = NULL WHERE id_pregunta = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						} else {
							if(!is_numeric($value)){
								echo '<response code="422">El campo mínimo debe ser un valor numérico</response>';
							} else {
								$qryR = "UPDATE pregunta SET intervalo_min = '".$value."' WHERE id_pregunta = $id";
								mysql_query($qryR);
								mysqlException(mysql_error(),$header."_0x02");
								$logQuery['INSERT'][$iSum] = $qryR;
								echo '<response code="1">1</response>';
							}
						}
					break;
					
					case 5:
						if($value == "0"){ // Si el valor es NULO
							$qryR = "UPDATE pregunta SET intervalo_max = NULL WHERE id_pregunta = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						} else {
							if(!is_numeric($value)){
								echo '<response code="422">El campo máximo debe ser un valor numérico</response>';
							} else {
								$qryR = "UPDATE pregunta SET intervalo_max = '".$value."' WHERE id_pregunta = $id";
								mysql_query($qryR);
								mysqlException(mysql_error(),$header."_0x02");
								$logQuery['INSERT'][$iSum] = $qryR;
								echo '<response code="1">1</response>';
							}
						}
					break;			
				}
	
				break;


			case 'distractorValueEditor':
				actionRestriction_0();
	
				$which = $_POST['which'];
				$id = $_POST['id'];
				$value = trim($_POST['value']);
	
				switch ($which) {
					case 2:
						if($value == "0"){ // Si el valor es NULO
							$qryR = "UPDATE distractor SET abreviatura = NULL WHERE id_distractor = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						} else {
							if(strlen($value) < 2 || strlen($value) > 45){
								echo '<response code="422">La abreviatura debe tener entre 2 y 45 carácteres de longitud</response>';
							} else {
								$qryR = "UPDATE distractor SET abreviatura = '".$value."' WHERE id_distractor = $id";
								mysql_query($qryR);
								mysqlException(mysql_error(),$header."_0x02");
								$logQuery['INSERT'][$iSum] = $qryR;
								echo '<response code="1">1</response>';
							}
						}
					break;

					case 3:
						if(strlen($value) < 2 || strlen($value) > 400){
							echo '<response code="422">El nombre del distractor debe tener entre 2 y 400 carácteres de longitud</response>';
						} else {
							$qryR = "UPDATE distractor SET nombre = '".$value."' WHERE id_distractor = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					break;

					case 4:
						if(!is_numeric($value)){
							echo '<response code="422">El valor del distractor debe ser un valor numérico</response>';
						} else {
							$qryR = "UPDATE distractor SET valor = '".$value."' WHERE id_distractor = $id";
							mysql_query($qryR);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qryR;
							echo '<response code="1">1</response>';
						}
					break;

					case 5: // Estado
						$qry = "UPDATE distractor SET estado = ".clean($value)." WHERE id_distractor = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x45889");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					break;	
				}
	
				break;
			
		case 'referenciaPATValueEditor':

			actionRestriction_0();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = trim($_POST['value']);

			switch ($which) {

				case 2: // Descripcion
					$qry = "SELECT * FROM referencia WHERE descripcion = '".$value."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) {
						echo '<response code="422">La descripcion de la referencia ya esta registrado</response>';
					} else if(strlen($value) < 2 || strlen($value) > 450){
						echo '<response code="422">La descripcion de la referencia debe tener entre 2 y 450 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE referencia SET descripcion = '".$value."' WHERE id_referencia = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;

				case 3: // Estado
					$qry = "UPDATE referencia SET estado = ".clean($value)." WHERE id_referencia = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x45889");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					echo'<response code="1"></response>';
				break;				
			}

			break;


		case 'retoPATValueEditor':

			actionRestriction_0();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1: // Programa PAT
					$qry = "SELECT * FROM reto WHERE id_reto = '".clean($id)."' LIMIT 1";
					$qryData = mysql_fetch_array(mysql_query($qry));
					$programa_pat_id = clean($value);
					$lote_id = $qryData["lote_pat_id_lote_pat"];
					$nom_lote = $qryData["nombre"];

					$qry = "SELECT * FROM reto WHERE programa_pat_id_programa = '".$programa_pat_id."' AND lote_pat_id_lote_pat = '".$lote_id."' AND nombre = '".$nom_lote."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">El reto de patología anatómica ya esta registrado</response>';
					} else if($programa_pat_id == "" || $programa_pat_id == null || $programa_pat_id == 0){
						echo '<response code="422">Debe especificar un programa PAT correcto</response>';
					} else if($lote_id == "" || $lote_id == null || $lote_id == 0){
						echo '<response code="422">Debe especificar un lote PAT correcto</response>';
					} else if(strlen($nom_lote) < 4 || strlen($nom_lote) > 45){
						echo '<response code="422">El nombre del reto debe tener entre 4 y 45 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE reto SET programa_pat_id_programa = ".$programa_pat_id." WHERE id_reto = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x2589636");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;
				
				case 2: // Lote
					$qry = "SELECT * FROM reto WHERE id_reto = '".clean($id)."' LIMIT 1";
					$qryData = mysql_fetch_array(mysql_query($qry));
					$programa_pat_id = $qryData["programa_pat_id_programa"];
					$lote_id = clean($value); // id_lote
					$nom_lote = $qryData["nombre"];

					$qry = "SELECT * FROM reto WHERE programa_pat_id_programa = '".$programa_pat_id."' AND lote_pat_id_lote_pat = '".$lote_id."' AND nombre = '".$nom_lote."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">El reto de patología anatómica ya esta registrado</response>';
					} else if($programa_pat_id == "" || $programa_pat_id == null || $programa_pat_id == 0){
						echo '<response code="422">Debe especificar un programa PAT correcto</response>';
					} else if($lote_id == "" || $lote_id == null || $lote_id == 0){
						echo '<response code="422">Debe especificar un lote PAT correcto</response>';
					} else if(strlen($nom_lote) < 4 || strlen($nom_lote) > 45){
						echo '<response code="422">El nombre del reto debe tener entre 4 y 45 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE reto SET lote_pat_id_lote_pat = ".$lote_id." WHERE id_reto = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x2589636");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;

				case 3: // Nombre
					$qry = "SELECT * 
					FROM reto
					WHERE id_reto = '".clean($id)."'
					LIMIT 1";
					$qryData = mysql_fetch_array(mysql_query($qry));
					$programa_pat_id = $qryData["programa_pat_id_programa"];
					$lote_id = $qryData["lote_pat_id_lote_pat"];
					$nom_lote = clean($value);

					$qry = "SELECT * FROM reto WHERE programa_pat_id_programa = '".$programa_pat_id."' AND lote_pat_id_lote_pat = '".$lote_id."' AND nombre = '".$nom_lote."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">El reto de patología anatómica ya esta registrado</response>';
					} else if($programa_pat_id == "" || $programa_pat_id == null || $programa_pat_id == 0){
						echo '<response code="422">Debe especificar un programa PAT correcto</response>';
					} else if($lote_id == "" || $lote_id == null || $lote_id == 0){
						echo '<response code="422">Debe especificar un lote PAT correcto</response>';
					} else if(strlen($nom_lote) < 4 || strlen($nom_lote) > 45){
						echo '<response code="422">El nombre del reto debe tener entre 4 y 45 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE reto SET nombre = '".$nom_lote."' WHERE id_reto = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;

				case 4: // Estado
					$qry = "UPDATE reto SET estado = ".clean($value)." WHERE id_reto = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x45887");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					echo'<response code="1"></response>';
				break;				
			}
		break;

		case 'grupoValueEditor':
			actionRestriction_0();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 2:
					if(strlen($value) < 2 || strlen($value) > 200){
						echo '<response code="422">el nombre del grupo debe tener entre 2 y 200 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE grupo SET nombre = '".$value."' WHERE id_grupo = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;			
			}

			break;

		case 'imagenValueEditor':

			actionRestriction_0();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 2: // Tipo de imagen
					$qryR = "UPDATE imagen_adjunta SET tipo = ".$value." WHERE id_imagen_adjunta = $id";
					mysql_query($qryR);
					mysqlException(mysql_error(),$header."_0x258978");
					$logQuery['INSERT'][$iSum] = $qryR;
					echo '<response code="1">1</response>';
				break;

				case 3: // Ruta de la imagen
					$qry = "SELECT * FROM imagen_adjunta WHERE ruta = '".$value."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">Ya existe una imagen con la misma ruta</response>';
					} else if(strlen($value) < 2 || strlen($value) > 450){
						echo '<response code="422">La ruta de la imagen debe tener entre 2 y 450 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE imagen_adjunta SET ruta = '".$value."' WHERE id_imagen_adjunta = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;

				case 4: // Nombre de la imagen
					$qry = "SELECT * FROM imagen_adjunta WHERE nombre = '".$value."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">Ya existe una imagen con el mismo nombre</response>';
					} else if(strlen($value) < 2 || strlen($value) > 450){
						echo '<response code="422">el nombre de la imagen debe tener entre 2 y 450 carácteres de longitud</response>';
					} else {
						$qryR = "UPDATE imagen_adjunta SET nombre = '".$value."' WHERE id_imagen_adjunta = $id";
						mysql_query($qryR);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qryR;
						echo '<response code="1">1</response>';
					}
				break;

				case 5: // Estado
					$qry = "UPDATE imagen_adjunta SET estado = ".clean($value)." WHERE id_imagen_adjunta = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x45887");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					echo'<response code="1"></response>';
				break;				
			}
		break;

		case "casoClinicoRegistry":
			actionRestriction_101();
			$reto_id = $_POST["reto_id"];
			$codigo = $_POST["codigo"];
			$nombre = $_POST["nombre"];
			$enunciado = $_POST["enunciado"];
			$revision = $_POST["revision"];
			$tejido = $_POST["tejido"];
			$celulas_objetivo = $_POST["celulas_objetivo"];

			$qry2 = "SELECT * 
					FROM caso_clinico 
					WHERE codigo = '".$codigo."' 
					LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");
			
			if ($checkrows > 0) {
				echo '<response code="422">El código de caso clínico ya se encuentra registrado</response>';
			} else if(strlen($codigo) < 2 || strlen($codigo) > 45) {
				echo '<response code="422">El código del caso clínico debe tener entre 2 y 45 carácteres</response>';
			} else if(strlen($nombre) < 4 || strlen($nombre) > 200) {
				echo '<response code="422">El nombre del caso clínico debe tener entre 4 y 200 carácteres</response>';
			} else if($enunciado != "0" && (strlen($enunciado) < 4 || strlen($enunciado) > 20000)) {
				echo '<response code="422">El nombre del caso clínico debe tener entre 4 y 20.000 carácteres</response>';
			} else if($revision != "0" && (strlen($revision) < 4 || strlen($revision) > 20000)) {
				echo '<response code="422">El nombre del caso clínico debe tener entre 4 y 20.000 carácteres</response>';
			} else if($tejido != "0" && (strlen($tejido) < 4 || strlen($tejido) > 255)) {
				echo '<response code="422">El nombre del caso clínico debe tener entre 4 y 255 carácteres</response>';
			} else if($celulas_objetivo != "0" && (strlen($celulas_objetivo) < 4 || strlen($celulas_objetivo) > 255)) {
				echo '<response code="422">El nombre del caso clínico debe tener entre 4 y 255 carácteres</response>';
			} else {
				$reto_id = trim($reto_id);
				$codigo = trim($codigo);
				$nombre = trim($nombre);
				$enunciado = trim($enunciado);
				$revision = trim($revision);
				$tejido = trim($tejido);
				$celulas_objetivo = trim($celulas_objetivo);

				$reto_id = ("'".$reto_id."'");
				$codigo = ("'".$codigo."'");
				$nombre = ("'".$nombre."'");
				$enunciado = ($enunciado == "0") ? ("NULL") : ("'" . $enunciado . "'");
				$revision = ($revision == "0") ? ("NULL") : ("'" . $revision . "'");
				$tejido = ($tejido == "0") ? ("NULL") : ("'" . $tejido . "'");
				$celulas_objetivo = ($celulas_objetivo == "0") ? ("NULL") : ("'" . $celulas_objetivo . "'");

				$qryR = "INSERT INTO caso_clinico(reto_id_reto, codigo, nombre, enunciado, revision, tejido, celulas_objetivo) VALUES ($reto_id, $codigo, $nombre, $enunciado, $revision, $tejido, $celulas_objetivo)";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}
			break;

		case "preguntaRegistry":
			actionRestriction_101();
			$reto_id = $_POST["reto_id"];
			$caso_clinico_id = $_POST["caso_clinico_id"];
			$grupo_id = $_POST["grupo_id"];
			$nombre = $_POST["nombre"];
			$minimo = $_POST["minimo"];
			$maximo = $_POST["maximo"];

			$qry2 = "SELECT * 
					FROM pregunta 
					WHERE nombre = '".$nombre."' AND grupo_id_grupo = '".$grupo_id."'
					LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x0433435_");
			
			if ($checkrows > 0) {
				echo '<response code="422">El nombre de la pregunta ya se encuentra registrada</response>';
			} else if(strlen($nombre) < 2 || strlen($nombre) > 400) {
				echo '<response code="422">El nombre de la pregunta debe tener entre 2 y 400 carácteres</response>';
			} else if($minimo != "0" && !is_numeric($minimo)) {
				echo '<response code="422">El valor mínimo debe ser un valor numérico</response>';
			} else if($maximo != "0" && !is_numeric($maximo)) {
				echo '<response code="422">El valor máximo debe ser un valor numérico</response>';
			} else {
				$grupo_id = trim($grupo_id);
				$nombre = trim($nombre);
				$minimo = trim($minimo);
				$maximo = trim($maximo);

				$grupo_id = ("'".$grupo_id."'");
				$nombre = ("'".$nombre."'");
				$minimo = ($minimo == "0") ? ("NULL") : ("'" . $minimo . "'");
				$maximo = ($maximo == "0") ? ("NULL") : ("'" . $maximo . "'");
				
				$qryR = "INSERT INTO pregunta(grupo_id_grupo, nombre, intervalo_min, intervalo_max) VALUES ($grupo_id, $nombre, $minimo, $maximo)";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}
			break;


		case "distractorRegistry":
			actionRestriction_101();
			$pregunta_id = $_POST["pregunta_id"];
			$abreviatura = $_POST["abreviatura"];
			$nombre = $_POST["nombre"];
			$valor = $_POST["valor"];

			$qry2 = "SELECT * FROM distractor WHERE nombre = '".$nombre."' AND pregunta_id_pregunta = '".$pregunta_id."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x043343589");
			
			if ($checkrows > 0) {
				echo '<response code="422">El nombre del distractor ya se encuentra registrado</response>';
			} else if($abreviatura != "0" && (strlen($abreviatura) < 2 || strlen($abreviatura) > 45)) {
				echo '<response code="422">La abreviatura del distractor debe tener entre 2 y 45 carácteres de longitud</response>';
			} else if(strlen($nombre) < 2 || strlen($nombre) > 400) {
				echo '<response code="422">El nombre del distractor debe tener entre 2 y 400 carácteres de longitud</response>';
			} else if(!is_numeric($valor)) {
				echo '<response code="422">El valor del distractor debe ser numérico</response>';
			} else {
				$pregunta_id = trim($pregunta_id);
				$abreviatura = trim($abreviatura);
				$nombre = trim($nombre);
				$valor = trim($valor);
				
				$pregunta_id = ("'".$pregunta_id."'");
				$abreviatura = ($abreviatura == "0") ? ("NULL") : ("'" . $abreviatura . "'");
				$nombre = ("'".$nombre."'");
				$valor = ("'".$valor."'");
				
				$qryR = "INSERT INTO distractor(pregunta_id_pregunta, abreviatura, nombre, valor) VALUES ($pregunta_id, $abreviatura, $nombre, $valor)";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x07852");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}
			break;

		case "referenciaRegistry":
			actionRestriction_101();
			$caso_clinico_id = trim($_POST["caso_clinico_id"]);
			$descripcion = trim($_POST["descripcion"]);

			$qry2 = "SELECT *  FROM referencia WHERE caso_clinico_id_caso_clinico = '".$caso_clinico_id."' AND descripcion = '".$descripcion."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x0879_");
			
			if ($checkrows > 0) {
				echo '<response code="422">La referencia ya se encuentra registrada</response>';
			} else if(strlen($descripcion) < 2 || strlen($descripcion) > 450) {
				echo '<response code="422">La descripción de la referencia debe tener entre 2 y 450 carácteres</response>';
			} else {
				$qryR = "INSERT INTO referencia(caso_clinico_id_caso_clinico,descripcion) VALUES ('$caso_clinico_id', '$descripcion')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x03212");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}
			break;

		case "imagenRegistry":
			actionRestriction_101();
			$reto_id = trim($_POST["reto_id"]);
			$caso_clinico_id = trim($_POST["caso_clinico_id"]);
			$tipo = trim($_POST["tipo"]);
			$ruta = trim($_POST["ruta"]);
			$nombre = trim($_POST["nombre"]);

			$qry = "SELECT * FROM imagen_adjunta WHERE ruta='".$ruta."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."0x087901");

			$qry2 = "SELECT * FROM imagen_adjunta WHERE nombre='".$nombre."' LIMIT 1";
			$checkrows2 = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."0x087903");
			
			if ($checkrows > 0) {
				echo '<response code="422">La ruta de la imagen ya se encuentra registrada en la base de datos</response>';
			} else if ($checkrows2 > 0) {
				echo '<response code="422">El nombre de la imagen ya se encuentra registrada en la base de datos</response>';
			} else if(strlen($ruta) < 2 || strlen($ruta) > 450) {
				echo '<response code="422">La ruta de la imagen debe tener entre 2 y 450 carácteres</response>';
			} else if(strlen($nombre) < 2 || strlen($nombre) > 450) {
				echo '<response code="422">El nombre de la imagen debe tener entre 2 y 450 carácteres</response>';
			} else {
				$qryR = "INSERT INTO imagen_adjunta(caso_clinico_id_caso_clinico, tipo, ruta, nombre) VALUES ('$caso_clinico_id', '$tipo', '$ruta', '$nombre')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x03212");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}
			break;

		case "grupoRegistry":
			actionRestriction_101();
			$reto_id = trim($_POST["reto_id"]);
			$caso_clinico_id = trim($_POST["caso_clinico_id"]);
			$nombre = trim($_POST["nombre"]);

			$qry = "SELECT * FROM grupo WHERE nombre='".$nombre."' AND caso_clinico_id_caso_clinico = '".$caso_clinico_id."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."0x087901");

			if ($checkrows > 0) {
				echo '<response code="422">El nombre del grupo ya se encuentra registrada en la base de datos</response>';
			} else if(strlen($nombre) < 2 || strlen($nombre) > 200) {
				echo '<response code="422">El nombre del grupo debe tener entre 2 y 200 carácteres</response>';
			} else {
				$qryR = "INSERT INTO grupo(caso_clinico_id_caso_clinico, nombre) VALUES ('$caso_clinico_id', '$nombre')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x0321258");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}
			break;

		case 'sampleRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['samplenumber'];
			$postValues_2 = $_POST['programid'];
			$postValues_3 = $_POST['lotid'];
			$postValues_4 = $_POST['sampledate'];
			$postValues_5 = $_POST['roundnumber'];
		
			$tempValue_1 = clean($postValues_1);
			$tempValue_2 = clean($postValues_2);
			$tempValue_3 = clean($postValues_3);
			$tempValue_4 = clean($postValues_4);
			$tempValue_5 = mysql_real_escape_string(clean($postValues_5));
			
			if(strlen($postValues_1) < 1 || strlen($postValues_1) > 255) {
				echo '<response code="422">La muestra debe tener entre 0 y 255 caracteres</response>';
			} else if($postValues_5 < 1 || $postValues_5 > 100) {
				echo '<response code="422">El numero de ronda debe ser entre 1 y 100</response>';
			} else if($postValues_4 == "") {
				echo '<response code="422">Debe especificar la fecha de reporte de resultado</response>';
			} else {
				
				$insertedValues = 0;

				$qry = "SELECT id_muestra FROM $tbl_muestra WHERE codigo_muestra = '$tempValue_1'"; // Se busca una muestra que tenga el mismo codigo
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				mysqlException(mysql_error(),$header."_0x01_");	

				if ($checkrows >= 1) { // Si hay una muestra que tenga el mismo codigo
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02_");					
					
					while ($qryData = mysql_fetch_array($qryArray)) {
						$qry = "SELECT id_muestra_programa FROM $tbl_muestra_programa WHERE id_muestra = ".$qryData['id_muestra']." AND id_programa = $tempValue_2 AND id_lote = $tempValue_3 AND fecha_vencimiento = '$tempValue_4'"; // Busca una muestra que tenga el mismo numero de lote, y que pertenezca al mismo programa
						
						$checkrows = mysql_num_rows(mysql_query($qry));
						mysqlException(mysql_error(),$header."_0x03_");
						
						if ($checkrows > 0) { // Si hay una muestra configurada para el mismo programa y lote
							$qry = "SELECT id_ronda FROM $tbl_ronda WHERE no_ronda = $tempValue_5 LIMIT 0,1"; // Busca una ronda que este registrada con el mismo numero de ronda indicado en el formulario
							$checkrows = mysql_num_rows(mysql_query($qry));
							mysqlException(mysql_error(),$header."_0x03_02_");								
							
							if ($checkrows > 0) { // Si hay una ronda como la indicada en el formulario
								$innerQryData1 = mysql_fetch_array(mysql_query($qry));
								mysqlException(mysql_error(),$header."_0x03_01_");				
								
								$qry = "SELECT id_conexion FROM $tbl_contador_muestra WHERE id_muestra = ".$qryData['id_muestra']." AND id_ronda = ".$innerQryData1['id_ronda']." LIMIT 0,1"; // Busca  una muestra que este asignada para la misma ronda del formulario
								$checkrows = mysql_num_rows(mysql_query($qry));
								mysqlException(mysql_error(),$header."_0x03_03_");							
								
								if ($checkrows > 0) { // Si hay muestras asignadas para la muestra
									break;
								}								
							}
						}
					}
					
				}
				
				if ($checkrows == 0) { // Si no hay muestras asignadas.
					
					$qry = "SELECT no_muestras FROM $tbl_programa WHERE id_programa = $tempValue_2"; // Obtiene el maximo numero de muestras para el programa
					$qryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x04_");
					
					$sampleLimit = $qryData['no_muestras'];			
					
					$qry = "INSERT INTO $tbl_muestra (codigo_muestra) VALUES ('$tempValue_1')"; // Registra el codigo de la muestra 
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x05_");
					$logQuery['INSERT'][$iSum] = $qry;
					$iSum++;
					
					$qry = "SELECT id_muestra FROM $tbl_muestra WHERE codigo_muestra = '$tempValue_1' AND id_muestra NOT 
							IN (SELECT id_muestra FROM $tbl_muestra_programa WHERE id_programa = $tempValue_2 AND id_lote = $tempValue_3 AND fecha_vencimiento = '$tempValue_4') ORDER BY id_muestra DESC"; // Obtiene el id de la muestra ingresado
					$qryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x06_");

					$sampleId = $qryData['id_muestra']; // Asigna en una variable el id de la muestra
					
					$qry = "SELECT no_ronda FROM $tbl_ronda WHERE id_programa = $tempValue_2 AND no_ronda = $tempValue_5 LIMIT 0,1"; // Obtiene la ronda indicada en el formulario
					$qryRows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x07_");

					if ($qryRows == 0) { // Si la ronda no existe entonces la crea 
						$qry = "INSERT INTO $tbl_ronda (no_ronda,id_programa) VALUES ($tempValue_5,$tempValue_2)";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x08_");
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;
					}
					
					$qry = "SELECT id_ronda FROM $tbl_ronda WHERE id_programa = $tempValue_2 AND no_ronda = $tempValue_5 ORDER BY no_ronda DESC LIMIT 0,1"; // Toma le id de la ronda que se haya creado para el mismo programa
					$qryData = mysql_fetch_array(mysql_query($qry));
					$tempId = $qryData['id_ronda'];
						 
					$qry = "SELECT no_contador FROM $tbl_contador_muestra WHERE id_ronda = $tempId ORDER BY no_contador DESC LIMIT 0,1"; // Se obtiene el contador para la muestra actual que se esta intentando ingresar
					$innerQryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x09_");						
					
					if ($innerQryData['no_contador'] == "") { // Si no se habian igresado anteriormente numeros de muestra, se inicia en 1
						$sampleNumber = 1;
					} else { // Si ya hay valores ingresados se aumenta en uno, el valor del contador
						$sampleNumber = ($innerQryData['no_contador'] + 1);
					}
					
					$qry = "INSERT INTO $tbl_contador_muestra (id_ronda,id_muestra,no_contador) VALUES ($tempId,$sampleId,$sampleNumber)"; // Se registra en la BD el numero de muestra para la ronda indicada en el formulario
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x10_");
					$logQuery['INSERT'][$iSum] = $qry;
					$iSum++;						
					
					$qry = "SELECT sigla_programa FROM $tbl_programa WHERE id_programa = $tempValue_2"; // Se obtiene la sigla del programa
					
					$qryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x06");
					
					$qapLotName = $qryData['sigla_programa'];
					
					$qry = "SELECT nombre_lote,nombre_lote_qap,nivel_lote FROM $tbl_lote WHERE id_lote = $tempValue_3"; // Se obtiene la informacion del lote indicado en el formulario
					
					$qryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x07");					
					
					$qapLotName = $qapLotName.substr($qryData['nombre_lote'], -3); // Se asigna un nombre automatico para el nombre del codigo de QAP
					
					if ($qryData['nombre_lote'] == $qapLotName) { // Si el nombre del lote de BioRAD es el mismo que se genero automaticamente 
						// No hacer nada
					} else { // Si el codigo es distinto al codigo de BioRAD, se actualiza el codigo de QAP para el lote de BioRAD
						$qry = "UPDATE lote SET nombre_lote_qap = '$qapLotName' WHERE id_lote = $tempValue_3";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x08");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
					}				
					
					// Finalmente se registra la tabla final, con la infromacion de la muestra del formulario
					$qry = "INSERT INTO $tbl_muestra_programa (id_muestra,id_programa,id_lote,fecha_vencimiento) VALUE ($sampleId,$tempValue_2,$tempValue_3,'$tempValue_4')";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x10");
					$logQuery['INSERT'][$iSum] = $qry;
					$iSum++;
				}
	
				echo '<response code="1">1</response>';		
			}

		break;
		case 'sampleValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1: // Codigo de la muestra
					if(strlen($value) < 1 || strlen($value) > 255) {
						echo '<response code="422">La muestra debe tener entre 1 y 255 caracteres</response>';
					} else {
						$qry = "SELECT id_muestra FROM $tbl_muestra_programa WHERE id_muestra_programa = $id";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_0x01");
						$qry = "UPDATE $tbl_muestra SET codigo_muestra = '".clean($value)."' WHERE id_muestra = ".$qryData['id_muestra'];
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}
				
				break;
				case 2: // Programa
					if($value == ""){
						echo '<response code="422">Debe especificar un programa</response>';
					} else {
						$qry = "UPDATE $tbl_muestra_programa SET id_programa = $value WHERE id_muestra_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}
				break;
				case 3: // Nombre de lote de QAP

					if($value == ""){
						echo '<response code="422">Debe especificar un nombre para el lote de QAP</response>';
					} else if(strlen($value) < 1 || strlen($value) > 255) {
						echo '<response code="422">El nombre de lote de QAP debe tener entre 1 y 255 carácteres</response>';
					} else {
						$qry = "SELECT id_lote FROM $tbl_muestra_programa WHERE id_muestra_programa = $id";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_0x05");
						$qry = "UPDATE $tbl_lote SET nombre_lote_qap = '".clean($value)."' WHERE id_lote = ".$qryData['id_lote'];
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x06");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}
				
				break;
				case 4: // Fecha de vencimiento

					if($value == ""){
						echo '<response code="422">Debe especificar la fecha de reporte de resultado</response>';
					} else {
						$qry = "UPDATE $tbl_muestra_programa SET fecha_vencimiento = '$value' WHERE id_muestra_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x04");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}

				break;				
				case 6: // Numero de Lote

					if($value == ""){
						echo '<response code="422">Debe especificar el numero de lote</response>';
					} else {
						$qry = "UPDATE $tbl_muestra_programa SET id_lote = $value WHERE id_muestra_programa = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x04");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}
				break;				
			}
			
		break;

		case 'sampleDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_muestra FROM $tbl_muestra_programa WHERE id_muestra_programa = $ids[$x]";
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_0x01");
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_muestra WHERE id_muestra = ".$qryData['id_muestra'];
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
				}
				
				$qry = "SELECT id_ronda FROM $tbl_ronda WHERE id_ronda NOT IN (SELECT id_ronda FROM $tbl_contador_muestra)";
				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02_".$x);
				
				while ($qryData = mysql_fetch_array($qryArray)) {
					
					$qry = "DELETE FROM $tbl_ronda WHERE id_ronda = ".$qryData['id_ronda'];
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
					
				}
				
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'analyzerRegistry':

			actionRestriction_101(); // Permisos de la accion de registro

			$codigo = clean($_POST['codigo']);
			$nombre = clean($_POST['nombre']);

			// Consulta para validar el nombre de analizador
			$qry = "SELECT nombre_analizador FROM $tbl_analizador WHERE nombre_analizador = '".clean($nombre)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			// Consulta para validar el codigo de analizador
			$qry2 = "SELECT cod_analizador FROM $tbl_analizador WHERE cod_analizador = '".clean($codigo)."' LIMIT 1";
			$checkrowsCod = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay analizador ya registradas
				echo '<response code="422">El nombre del analizador ya esta registrado</response>';
			} else if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
				echo '<response code="422">El código del analizador ya se encuentra registrado</response>';
			} else if(!is_numeric(clean($_POST['codigo'])) || (clean($_POST['codigo'])) < 1 || (clean($_POST['codigo'])) > 1000000) { // Si el codigo NO es numerico
				echo '<response code="422">El código del analizador debe ser numerico, entero entre 1 y 1.000.000</response>';
			} else if(strlen(clean($_POST['nombre'])) < 4 || strlen(clean($_POST['nombre'])) > 255) {
				echo '<response code="422">El nombre del analizador debe tener una longitud entre 4 y 255 carácteres</response>';
			} else {
				$qryR = "INSERT INTO $tbl_analizador (cod_analizador,nombre_analizador) VALUES (".clean($codigo).",'".clean($nombre)."')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}
			
		break;
		
		case 'metodologiaRegistry':
			
			actionRestriction_101(); // Permisos de la accion de registro

			$codigo = clean($_POST['codigo']);
			$nombre = clean($_POST['nombre']);

			// Consulta para validar el nombre de metodologia
			$qry = "SELECT nombre_metodologia FROM $tbl_metodologia WHERE nombre_metodologia = '".clean($nombre)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			// Consulta para validar el codigo de metodologia
			$qry2 = "SELECT cod_metodologia FROM $tbl_metodologia WHERE cod_metodologia = '".clean($codigo)."' LIMIT 1";
			$checkrowsCod = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay metodologias ya registradas
				echo '<response code="422">El nombre de la metodología ya esta registrado</response>';
			} else if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
				echo '<response code="422">El código de la metodología ya se encuentra registrado</response>';
			} else if(!is_numeric(clean($_POST['codigo'])) || (clean($_POST['codigo'])) < 1 || (clean($_POST['codigo'])) > 1000000) { // Si el codigo NO es numerico
				echo '<response code="422">El código de la metodología debe ser numerico, entero entre 1 y 1.000.000</response>';
			} else if(strlen(clean($_POST['nombre'])) < 4 || strlen(clean($_POST['nombre'])) > 255) {
				echo '<response code="422">El nombre de la metodología debe tener una longitud entre 4 y 255 carácteres</response>';
			} else {
				$qryR = "INSERT INTO $tbl_metodologia (cod_metodologia,nombre_metodologia) VALUES (".clean($codigo).",'".clean($nombre)."')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}	
		break;
		

		case 'unidadRegistry':
			
			actionRestriction_101(); // Permisos de la accion de registro

			$codigo = clean($_POST['codigo']);
			$nombre = clean($_POST['nombre']);

			// Consulta para validar el nombre de unidad
			$qry = "SELECT nombre_unidad FROM $tbl_unidad WHERE nombre_unidad = '".clean($nombre)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			// Consulta para validar el codigo de unidad
			$qry2 = "SELECT cod_unidad FROM $tbl_unidad WHERE cod_unidad = '".clean($codigo)."' LIMIT 1";
			$checkrowsCod = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay unidades ya registradas
				echo '<response code="422">El nombre de la unidad ya esta registrado</response>';
			} else if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
				echo '<response code="422">El código de la unidad ya se encuentra registrado</response>';
			} else if(!is_numeric(clean($_POST['codigo'])) || (clean($_POST['codigo'])) < 1 || (clean($_POST['codigo'])) > 1000000) { // Si el codigo NO es numerico
				echo '<response code="422">El código de la unidad debe ser numerico, entero entre 1 y 1.000.000</response>';
			} else if(strlen(clean($_POST['nombre'])) < 1 || strlen(clean($_POST['nombre'])) > 255) {
				echo '<response code="422">El nombre de la unidad debe tener una longitud entre 1 y 255 carácteres</response>';
			} else {
				$qryR = "INSERT INTO $tbl_unidad (cod_unidad,nombre_unidad) VALUES (".clean($codigo).",'".clean($nombre)."')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}	
		break;


		case "retoPATRegistry":
			actionRestriction_101(); // Permisos de la accion de registro

			$programa_pat_id = clean($_POST['programa_pat_id']);
			$lote_id = clean($_POST['lote_id']);
			$nom_lote = clean($_POST['nom_lote']);

			// Consulta para validar el nombre de unidad
			$qry = "SELECT * FROM reto WHERE programa_pat_id_programa = '".$programa_pat_id."' AND lote_pat_id_lote_pat = '".$lote_id."' AND nombre = '".$nom_lote."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			if ($checkrows > 0) { // Si hay unidades ya registradas
				echo '<response code="422">El reto de patología anatómica ya esta registrado</response>';
			} else if($programa_pat_id == "" || $programa_pat_id == null || $programa_pat_id == 0){
				echo '<response code="422">Debe especificar un programa PAT correcto</response>';
			} else if($lote_id == "" || $lote_id == null || $lote_id == 0){
				echo '<response code="422">Debe especificar un lote PAT correcto</response>';
			} else if(strlen($nom_lote) < 4 || strlen($nom_lote) > 45){
				echo '<response code="422">El nombre del reto debe tener entre 4 y 45 carácteres de longitud</response>';
			} else {
				$qryR = "INSERT INTO reto (programa_pat_id_programa, lote_pat_id_lote_pat, nombre) VALUES (".$programa_pat_id.",'".$lote_id."','".$nom_lote."')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}	
			break;

		case 'magnitudRegistry':
			
			actionRestriction_101(); // Permisos de la accion de registro

			$codigo = clean($_POST['codigo']);
			$nombre = clean($_POST['nombre']);

			// Consulta para validar el nombre del mensurando
			$qry = "SELECT nombre_analito FROM $tbl_analito WHERE nombre_analito = '".clean($nombre)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			// Consulta para validar el codigo del mensurando
			$qry2 = "SELECT cod_analito FROM $tbl_analito WHERE cod_analito = '".clean($codigo)."' LIMIT 1";
			$checkrowsCod = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay mensurandos ya registrados
				echo '<response code="422">El nombre del mensurando ya esta registrado</response>';
			} else if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
				echo '<response code="422">El código del mensurando ya se encuentra registrado</response>';
			} else if(!is_numeric(clean($_POST['codigo'])) || (clean($_POST['codigo'])) < 1 || (clean($_POST['codigo'])) > 1000000) { // Si el codigo NO es numerico
				echo '<response code="422">El código del mensurando debe ser numerico, entero entre 1 y 1.000.000</response>';
			} else if(strlen(clean($_POST['nombre'])) < 1 || strlen(clean($_POST['nombre'])) > 255) {
				echo '<response code="422">El nombre del mensurando debe tener una longitud entre 1 y 255 carácteres</response>';
			} else {
				$qryR = "INSERT INTO $tbl_analito (cod_analito,nombre_analito) VALUES (".clean($codigo).",'".clean($nombre)."')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}	
		break;

		case 'analyzerValueEditor':
			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					// Consulta para validar el codigo de analizador
					$qry2 = "SELECT cod_analizador FROM $tbl_analizador WHERE cod_analizador = '".clean($value)."' LIMIT 1";
					$checkrowsCod = mysql_num_rows(mysql_query($qry2));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
						echo '<response code="422">El código de la analizador ya se encuentra registrado</response>';
					} else if(!is_numeric(clean($value)) || (clean($value)) < 1 || (clean($value)) > 1000000) { // Si el codigo NO es numerico
						echo '<response code="422">El código de la analizador debe ser numerico, entero entre 1 y 1.000.000</response>';
					} else {
						$qry = "UPDATE $tbl_analizador SET cod_analizador = '".clean($value)."' WHERE id_analizador = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				break;			

				case 2:

					$qry = "SELECT nombre_analizador FROM $tbl_analizador WHERE nombre_analizador = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay analizador ya registradas
						echo '<response code="422">El nombre de la analizador ya esta registrado</response>';
					} else if(strlen(clean($value)) < 4 || strlen(clean($value)) > 255) {
						echo '<response code="422">El nombre de la analizador debe tener una longitud entre 4 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_analizador SET nombre_analizador = '".clean($value)."' WHERE id_analizador = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				
				break;	
			}

		break;

		case 'metodologiaValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					// Consulta para validar el codigo de metodología
					$qry2 = "SELECT cod_metodologia FROM $tbl_metodologia WHERE cod_metodologia = '".clean($value)."' LIMIT 1";
					$checkrowsCod = mysql_num_rows(mysql_query($qry2));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
						echo '<response code="422">El código de la metodología ya se encuentra registrado</response>';
					} else if(!is_numeric(clean($value)) || (clean($value)) < 1 || (clean($value)) > 1000000) { // Si el codigo NO es numerico
						echo '<response code="422">El código de la metodología debe ser numerico, entero entre 1 y 1.000.000</response>';
					} else {
						$qry = "UPDATE $tbl_metodologia SET cod_metodologia = '".clean($value)."' WHERE id_metodologia = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				break;			

				case 2:

					$qry = "SELECT nombre_metodologia FROM $tbl_metodologia WHERE nombre_metodologia = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay metodologias ya registradas
						echo '<response code="422">El nombre de la metodología ya esta registrado</response>';
					} else if(strlen(clean($value)) < 4 || strlen(clean($value)) > 255) {
						echo '<response code="422">El nombre de la metodología debe tener una longitud entre 4 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_metodologia SET nombre_metodologia = '".clean($value)."' WHERE id_metodologia = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				
				break;	
			}
			
		break;
		case 'unidadValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					// Consulta para validar el codigo de unidad
					$qry2 = "SELECT cod_unidad FROM $tbl_unidad WHERE cod_unidad = '".clean($value)."' LIMIT 1";
					$checkrowsCod = mysql_num_rows(mysql_query($qry2));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
						echo '<response code="422">El código de la unidad ya se encuentra registrado</response>';
					} else if(!is_numeric(clean($value)) || (clean($value)) < 1 || (clean($value)) > 1000000) { // Si el codigo NO es numerico
						echo '<response code="422">El código de la unidad debe ser numerico, entero entre 1 y 1.000.000</response>';
					} else {
						$qry = "UPDATE $tbl_unidad SET cod_unidad = '".clean($value)."' WHERE id_unidad = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				break;			

				case 2:

					$qry = "SELECT nombre_unidad FROM $tbl_unidad WHERE nombre_unidad = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay unidad ya registradas
						echo '<response code="422">El nombre de la unidad ya esta registrado</response>';
					} else if(strlen(clean($value)) < 1 || strlen(clean($value)) > 255) {
						echo '<response code="422">El nombre de la unidad debe tener una longitud entre 1 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_unidad SET nombre_unidad = '".clean($value)."' WHERE id_unidad = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				
				break;	
			}
			
		break;

		case 'magnitudValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					// Consulta para validar el codigo de analito
					$qry2 = "SELECT cod_analito FROM $tbl_analito WHERE cod_analito = '".clean($value)."' LIMIT 1";
					$checkrowsCod = mysql_num_rows(mysql_query($qry2));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
						echo '<response code="422">El código del mensurando ya se encuentra registrado</response>';
					} else if(!is_numeric(clean($value)) || (clean($value)) < 1 || (clean($value)) > 1000000) { // Si el codigo NO es numerico
						echo '<response code="422">El código del mensurando debe ser numerico, entero entre 1 y 1.000.000</response>';
					} else {
						$qry = "UPDATE $tbl_analito SET cod_analito = '".clean($value)."' WHERE id_analito = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				break;			

				case 2:

					$qry = "SELECT nombre_analito FROM $tbl_analito WHERE nombre_analito = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay mensurandos ya registrados
						echo '<response code="422">El nombre del mensurando ya esta registrado</response>';
					} else if(strlen(clean($value)) < 1 || strlen(clean($value)) > 255) {
						echo '<response code="422">El nombre del mensurando debe tener una longitud entre 1 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_analito SET nombre_analito = '".clean($value)."' WHERE id_analito = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				
				break;	
			}
			
		break;

		case 'analyzerDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_analizador FROM $tbl_analizador WHERE id_analizador = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_analizador WHERE id_analizador = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;

		case 'metodologiaDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM $tbl_metodologia WHERE id_metodologia = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x01");
				$logQuery['DELETE'][$dSum] = $qry;
			}

			echo'<response code="1">1</response>';
			
		break;


		case 'unidadDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM $tbl_unidad WHERE id_unidad = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x01");
				$logQuery['DELETE'][$dSum] = $qry;
			}

			echo'<response code="1">1</response>';
			
		break;

		case 'magnitudDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM $tbl_analito WHERE id_analito = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x01");
				$logQuery['DELETE'][$dSum] = $qry;
			}

			echo'<response code="1">1</response>';
			
		break;

		case 'methodRegistry':

			actionRestriction_101();

			$analyzerid = clean($_POST['analyzerid']);
			$methodid = clean($_POST['methodid']);

			// Consulta para validar la duplicicidad de la informacion
			$qry = "SELECT id_analizador FROM $tbl_metodologia_analizador WHERE id_analizador = '".clean($_POST['analyzerid'])."' and id_metodologia = '".clean($_POST['methodid'])."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			
			if ($checkrows > 0) { // Si hay unidades ya registradas
				echo '<response code="422">La metodología especificada, ya existe para el analizador indicado</response>';
			} else {
				$qry = "INSERT INTO $tbl_metodologia_analizador (id_analizador,id_metodologia) VALUES (".clean($_POST['analyzerid']).",".clean($_POST['methodid']).")";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x05_");
				$logQuery['INSERT'][$iSum] = $qry;
				echo '<response code="1">1</response>';
			}
			
		break;
		case 'methodValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					// Consulta para validar la duplicicidad de la informacion
					// Obtiene el id de la metodologia de la conexion
					$qry = "SELECT id_metodologia FROM $tbl_metodologia_analizador WHERE id_conexion = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$id_metodologia = $qryData["id_metodologia"];
						$x++;
					}

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_metodologia FROM $tbl_metodologia_analizador WHERE id_analizador = '".clean($value)."' and id_metodologia = '".clean($id_metodologia)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">La metodología especificada, ya existe para el analizador indicado</response>';
					} else {
						$qry = "UPDATE $tbl_metodologia_analizador SET id_analizador = $value WHERE id_conexion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;				
				case 2:

					// Consulta para validar la duplicicidad de la informacion
					// Obtiene el id del analizador de la conexion
					$qry = "SELECT id_analizador FROM $tbl_metodologia_analizador WHERE id_conexion = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$id_analizador = $qryData["id_analizador"];
						$x++;
					}


					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_analizador FROM $tbl_metodologia_analizador WHERE id_analizador = '".clean($id_analizador)."' and id_metodologia = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">La metodología especificada, ya existe para el analizador indicado</response>';
					} else {
						$qry = "UPDATE $tbl_metodologia_analizador SET id_metodologia = $value WHERE id_conexion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;	
						echo'<response code="1"></response>';
					}
				
				break;
			}
			
			
		break;
		case 'methodDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_conexion FROM $tbl_metodologia_analizador WHERE id_conexion = $ids[$x]";
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_0x01");
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_metodologia_analizador WHERE id_conexion = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'reactiveRegistry':

			actionRestriction_101(); // Permisos de la accion de registro

			$codigo = clean($_POST['codigo']);
			$nombre = clean($_POST['nombre']);

			// Consulta para validar el nombre de reactivo
			$qry = "SELECT nombre_reactivo FROM $tbl_reactivo WHERE nombre_reactivo = '".clean($nombre)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			// Consulta para validar el codigo de reactivo
			$qry2 = "SELECT cod_reactivo FROM $tbl_reactivo WHERE cod_reactivo = '".clean($codigo)."' LIMIT 1";
			$checkrowsCod = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay reactivos ya registradas
				echo '<response code="422">El nombre del reactivo ya esta registrado</response>';
			} else if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
				echo '<response code="422">El código del reactivo ya se encuentra registrado</response>';
			} else if(!is_numeric(clean($_POST['codigo'])) || (clean($_POST['codigo'])) < 1 || (clean($_POST['codigo'])) > 1000000) { // Si el codigo NO es numerico
				echo '<response code="422">El código del reactivo debe ser numerico, entero entre 1 y 1.000.000</response>';
			} else if(strlen(clean($_POST['nombre'])) < 4 || strlen(clean($_POST['nombre'])) > 255) {
				echo '<response code="422">El nombre del reactivo debe tener una longitud entre 4 y 255 carácteres</response>';
			} else {
				$qryR = "INSERT INTO $tbl_reactivo (cod_reactivo,nombre_reactivo) VALUES (".clean($codigo).",'".clean($nombre)."')";
				mysql_query($qryR);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qryR;
				echo '<response code="1">1</response>';
			}	
			
		break;
		case 'reactiveValueEditor':
			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					// Consulta para validar el codigol reactivo
					$qry2 = "SELECT cod_reactivo FROM $tbl_reactivo WHERE cod_reactivo = '".clean($value)."' LIMIT 1";
					$checkrowsCod = mysql_num_rows(mysql_query($qry2));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrowsCod > 0) { // Si hay codigo ya utilizados
						echo '<response code="422">El código del reactivo ya se encuentra registrado</response>';
					} else if(!is_numeric(clean($value)) || (clean($value)) < 1 || (clean($value)) > 1000000) { // Si el codigo NO es numerico
						echo '<response code="422">El código del reactivo debe ser numerico, entero entre 1 y 1.000.000</response>';
					} else {
						$qry = "UPDATE $tbl_reactivo SET cod_reactivo = '".clean($value)."' WHERE id_reactivo = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
				break;			

				case 2:

					$qry = "SELECT nombre_reactivo FROM $tbl_reactivo WHERE nombre_reactivo = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay reactivos ya registrados
						echo '<response code="422">El nombre del reactivo ya esta registrado</response>';
					} else if(strlen(clean($value)) < 4 || strlen(clean($value)) > 255) {
						echo '<response code="422">El nombre del reactivo debe tener una longitud entre 4 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_reactivo SET nombre_reactivo = '".clean($value)."' WHERE id_reactivo = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						echo'<response code="1"></response>';
					}
			}
			
		break;
		case 'reactiveDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_reactivo FROM $tbl_reactivo WHERE id_reactivo = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_reactivo WHERE id_reactivo = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'unitRegistry':

			actionRestriction_101();

			$analyzerid = clean($_POST['analyzerid']);
			$unitid = clean($_POST['unitid']);

			// Consulta para validar la duplicicidad de la informacion
			$qry = "SELECT id_analizador FROM $tbl_unidad_analizador WHERE id_analizador = '".clean($_POST['analyzerid'])."' and id_unidad = '".clean($_POST['unitid'])."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			
			if ($checkrows > 0) { // Si hay unidades ya registradas
				echo '<response code="422">La unidad especificada, ya existe para el analizador indicado</response>';
			} else {
				$qry = "INSERT INTO $tbl_unidad_analizador (id_analizador,id_unidad) VALUES (".clean($_POST['analyzerid']).",".clean($_POST['unitid']).")";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x05_");
				$logQuery['INSERT'][$iSum] = $qry;
				echo '<response code="1">1</response>';
			}

			
		break;
		case 'unitValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					
					// Consulta para validar la duplicicidad de la informacion
					// Obtiene el id de la unidad de la conexion
					$qry = "SELECT id_unidad FROM $tbl_unidad_analizador WHERE id_conexion = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$id_unidad = $qryData["id_unidad"];
						$x++;
					}

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_unidad FROM $tbl_unidad_analizador WHERE id_analizador = '".clean($value)."' and id_unidad = '".clean($id_unidad)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">La unidad especificada, ya existe para el analizador indicado</response>';
					} else {
						$qry = "UPDATE $tbl_unidad_analizador SET id_analizador = $value WHERE id_conexion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;				
				case 2:


					// Consulta para validar la duplicicidad de la informacion
					// Obtiene el id de la unidad de la conexion
					$qry = "SELECT id_analizador FROM $tbl_unidad_analizador WHERE id_conexion = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$x = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$id_analizador = $qryData["id_analizador"];
						$x++;
					}

					// Consulta para validar la duplicicidad de la informacion
					$qry = "SELECT id_analizador FROM $tbl_unidad_analizador WHERE id_analizador = '".clean($id_analizador)."' and id_unidad = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					
					if ($checkrows > 0) { // Si hay unidades ya registradas
						echo '<response code="422">La metodología especificada, ya existe para el analizador indicado</response>';
					} else {
						$qry = "UPDATE $tbl_unidad_analizador SET id_unidad = $value WHERE id_conexion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}

				break;
			}
			
		break;
		case 'unitDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_conexion FROM $tbl_unidad_analizador WHERE id_conexion = $ids[$x]";
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_0x01");
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_unidad_analizador WHERE id_conexion = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'labRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['labnumber'];
			$postValues_2 = $_POST['labname'];
			$postValues_3 = $_POST['labcontact'];
			$postValues_4 = $_POST['labaddress'];
			$postValues_5 = $_POST['labcityid'];
			$postValues_6 = $_POST['labphone'];
			$postValues_7 = $_POST['labemail'];
			
			$tempValue_1 = clean($postValues_1);
			$tempValue_2 = clean($postValues_2);
			$tempValue_3 = clean($postValues_3);
			$tempValue_4 = clean($postValues_4);
			$tempValue_5 = clean($postValues_5);
			$tempValue_6 = clean($postValues_6);
			$tempValue_7 = clean($postValues_7);
				
			$qry1 = "SELECT id_laboratorio FROM $tbl_laboratorio WHERE no_laboratorio = '$tempValue_1' LIMIT 1";
			$checkrows1 = mysql_num_rows(mysql_query($qry1));
			mysqlException(mysql_error(),$header."_0x01_");

			$qry2 = "SELECT id_laboratorio FROM $tbl_laboratorio WHERE nombre_laboratorio = '$tempValue_2' LIMIT 1";
			$checkrows2 = mysql_num_rows(mysql_query($qry2));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows1 > 0) {
				echo '<response code="422">Ya existe un laboratorio registrado con el mismo número</response>';				
			} else if(strlen(clean($tempValue_1)) < 4 || strlen(clean($tempValue_1)) > 100){
				echo '<response code="422">El numero de laboratorio debe tener entre 4 y 100 carácteres</response>';
			} else if ($checkrows2 > 0) {
				echo '<response code="422">Ya existe un laboratorio registrado con el mismo nombre</response>';				
			} else if(strlen(clean($tempValue_2)) < 4 || strlen(clean($tempValue_2)) > 255){
				echo '<response code="422">El nombre de laboratorio debe tener entre 4 y 255 carácteres</response>';
			} else if(strlen(clean($tempValue_3)) < 4 || strlen(clean($tempValue_3)) > 255){
				echo '<response code="422">El contacto debe tener entre 4 y 255 carácteres</response>';
			} else if(strlen(clean($tempValue_4)) < 4 || strlen(clean($tempValue_4)) > 255){
				echo '<response code="422">La direccion de contacto debe tener entre 4 y 255 carácteres</response>';
			} else if(clean($tempValue_5) == ""){
				echo '<response code="422">Debe especificar una ciudad</response>';
			} else if(strlen(clean($tempValue_6)) < 10 || strlen(clean($tempValue_6)) > 255){
				echo '<response code="422">El numero de telefono de contacto puede ser una cadena de texto de 10 a 255 carácteres</response>';
			} else if(strlen(clean($tempValue_7)) < 10 || strlen(clean($tempValue_7)) > 255){
				echo '<response code="422">El correo electronico debe ser tener entre 10 a 255 carácteres</response>';
			}  else {
				$qry = "INSERT INTO $tbl_laboratorio (no_laboratorio,nombre_laboratorio,direccion_laboratorio,telefono_laboratorio,correo_laboratorio,contacto_laboratorio,id_ciudad) VALUES ('$tempValue_1','$tempValue_2','$tempValue_4','$tempValue_6 ','$tempValue_7','$tempValue_3',$tempValue_5)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';
			}
			
		break;
		case 'labValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					$qry1 = "SELECT id_laboratorio FROM $tbl_laboratorio WHERE no_laboratorio = '".clean($value)."' LIMIT 1";
					$checkrows1 = mysql_num_rows(mysql_query($qry1));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows1 > 0) {
						echo '<response code="422">Ya existe un laboratorio registrado con el mismo número</response>';				
					} else if(strlen(clean($value)) < 4 || strlen(clean($value)) > 100){
						echo '<response code="422">El numero de laboratorio debe tener entre 4 y 100 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_laboratorio SET no_laboratorio = '".clean($value)."' WHERE id_laboratorio = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}

				break;
				case 2:
					$qry1 = "SELECT id_laboratorio FROM $tbl_laboratorio WHERE nombre_laboratorio = '".clean($value)."' LIMIT 1";
					$checkrows1 = mysql_num_rows(mysql_query($qry1));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows1 > 0) {
						echo '<response code="422">Ya existe un laboratorio registrado con el mismo nombre</response>';				
					} else if(strlen(clean($value)) < 4 || strlen(clean($value)) > 255){
						echo '<response code="422">El nombre de laboratorio debe tener entre 4 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_laboratorio SET nombre_laboratorio = '".clean($value)."' WHERE id_laboratorio = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}

				break;	
				case 3:
					if(strlen(clean($value)) < 4 || strlen(clean($value)) > 255){
						echo '<response code="422">El contacto debe tener entre 4 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_laboratorio SET contacto_laboratorio = '".clean($value)."' WHERE id_laboratorio = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}
				break;	
				case 4:
					if(strlen(clean($value)) < 4 || strlen(clean($value)) > 255){
						echo '<response code="422">La direccion de contacto debe tener entre 4 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_laboratorio SET direccion_laboratorio = '".clean($value)."' WHERE id_laboratorio = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x04");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}

				break;
				case 5:
					if(clean($value) == ""){
						echo '<response code="422">Debe especificar una ciudad</response>';
					} else {
						$qry = "UPDATE $tbl_laboratorio SET id_ciudad = $value WHERE id_laboratorio = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x05");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}

				break;					
				case 6:
					if(strlen(clean($value)) < 10 || strlen(clean($value)) > 255){
						echo '<response code="422">El numero de telefono de contacto puede ser una cadena de texto de 10 a 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_laboratorio SET telefono_laboratorio = '".clean($value)."' WHERE id_laboratorio = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x06");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}
				break;				
				case 7:
					if(strlen(clean($value)) < 10 || strlen(clean($value)) > 255){
						echo '<response code="422">El correo electronico debe ser tener entre 10 a 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_laboratorio SET correo_laboratorio = '".clean($value)."' WHERE id_laboratorio = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x07");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1">1</response>';
					}
				break;					
			}
			
		break;
		case 'labDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_laboratorio FROM $tbl_laboratorio WHERE id_laboratorio = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_laboratorio WHERE id_laboratorio = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'labProgramAssignation':
		
			actionRestriction_101();
		
			$postValues_1 = $_POST['labid'];
			$postValues_2 = $_POST['programid'];
			
			$insertedValues = 0;
			
			$tempValue_1 = clean($postValues_1);
			$tempValue_2 = clean($postValues_2);
			
			$qry = "SELECT id_conexion FROM $tbl_programa_laboratorio WHERE id_programa = $tempValue_2 AND id_laboratorio = $postValues_1 LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");	

			if ($checkrows == 0) {
				$qry = "INSERT INTO $tbl_programa_laboratorio (id_programa,id_laboratorio,activo) VALUES ($tempValue_2,$tempValue_1,1)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;

				$insertedValues++;
				
			}

			echo '<response code="1">';
			echo $insertedValues;
			echo '</response>';			
			
		break;	
		case 'labRetoAssignation':
		
			actionRestriction_101();
		
			$postValues_1 = $_POST['labid'];
			$postValues_2 = $_POST['retoid'];
			$postValues_3 = $_POST['envio'];
			
			$insertedValues = 0;
			
			$tempValue_1 = clean($postValues_1);
			$tempValue_2 = clean($postValues_2);
			$tempValue_3 = clean($postValues_3);
			
			$qry = "SELECT $tbl_reto_laboratorio.id_reto_laboratorio FROM $tbl_reto_laboratorio WHERE reto_id_reto = $tempValue_2 AND laboratorio_id_laboratorio = $postValues_1 LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");	

			if ($checkrows == 0) {
				$qry = "INSERT INTO $tbl_reto_laboratorio (reto_id_reto,laboratorio_id_laboratorio, envio) VALUES ($tempValue_2,$tempValue_1,$tempValue_3)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				$insertedValues++;
			}

			echo '<response code="1">';
			echo $insertedValues;
			echo '</response>';			
			
		break;	
		
		case 'assignedLabProgramValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 3:
					$qry = "UPDATE $tbl_programa_laboratorio SET id_programa = $value WHERE id_conexion = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;
				case 5:
					$qry = "UPDATE $tbl_programa_laboratorio SET activo = $value WHERE id_conexion = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;				
			}
			
			echo'<response code="1"></response>';
			
		break;

		case 'assignedRetoLabvalueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 7:
					$qry = "UPDATE $tbl_reto_laboratorio SET envio = $value WHERE id_reto_laboratorio = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;				
			}
			
			echo'<response code="1"></response>';
			
		break;

		case 'assignedLabProgramDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_conexion FROM $tbl_programa_laboratorio WHERE id_conexion = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_programa_laboratorio WHERE id_conexion = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;

		case 'assignedLabRetoDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_reto_laboratorio FROM $tbl_reto_laboratorio WHERE id_reto_laboratorio = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_reto_laboratorio WHERE id_reto_laboratorio = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;

		case 'labAnalitAssignation':
		
			actionRestriction_101();
		
			$postValues_1 = $_POST['labid'];
			$postValues_2 = $_POST['programid'];
			$postValues_3 = $_POST['analitid'];
			$postValues_4 = $_POST['analyzerid'];
			$postValues_5 = $_POST['methodid'];
			$postValues_6 = $_POST['reactiveid'];
			$postValues_7 = $_POST['unitid'];
			$postValues_8 = $_POST['vitrosgenid'];
			$postValues_9 = $_POST['materialid'];
			$tempValue_1 = $postValues_1;
			$tempValue_2 = $postValues_2;
			$tempValue_3 = $postValues_3;
			$tempValue_4 = $postValues_4;
			$tempValue_5 = $postValues_5;
			$tempValue_6 = $postValues_6;
			$tempValue_7 = $postValues_7;
			$tempValue_8 = $postValues_8;
			$tempValue_9 = $postValues_9;
			
			$qry = "SELECT 
				id_configuracion 
			FROM 
				$tbl_configuracion_laboratorio_analito 
			WHERE 
				id_laboratorio = $tempValue_1 
				AND id_programa = $tempValue_2 
				AND id_analito = $tempValue_3 
				AND id_analizador = $tempValue_4 
				AND id_metodologia = $tempValue_5 
				AND id_reactivo = $tempValue_6 
				AND id_unidad = $tempValue_7 
				AND id_gen_vitros = $tempValue_8 
				AND id_material = $tempValue_9 
			LIMIT 1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01");	

			if ($checkrows > 0) {
				echo '<response code="422">Ya existe la misma configuracion para el mismo laboratorio</response>';
			} else {
				
				// Insertar un log
				$fechaAct = Date("Y-m-d h:i:s");
				$qry = "SELECT nombre_analito FROM analito where id_analito = $tempValue_3";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_analito_log = $qryData['nombre_analito'];

				$qry = "SELECT nombre_analizador FROM analizador where id_analizador = $tempValue_4";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_analizador_log = $qryData['nombre_analizador'];

				// Generacion
				$qry = "SELECT valor_gen_vitros FROM gen_vitros where id_gen_vitros = $tempValue_8";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nivel_generacion_log = $qryData['valor_gen_vitros'];

				// Metodologia
				$qry = "SELECT nombre_metodologia FROM metodologia where id_metodologia = $tempValue_5";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_metodologia_log = $qryData['nombre_metodologia'];

				// Reactivo
				$qry = "SELECT nombre_reactivo FROM reactivo where id_reactivo = $tempValue_6";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_reactivo_log = $qryData['nombre_reactivo'];

				// Unidad
				$qry = "SELECT nombre_unidad FROM unidad where id_unidad = $tempValue_7";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_unidad_log = $qryData['nombre_unidad'];

				// Material
				$qry = "SELECT nombre_material FROM material where id_material = $tempValue_9";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_material_log = $qryData['nombre_material'];

				// Nombre de usuario
				$qry = "SELECT nombre_usuario from usuario where id_usuario = '".$_SESSION['qap_userId']."'";
				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(),"_02correo");
				$qryData = mysql_fetch_array($qryArray);
				$nombre_usuario = $qryData["nombre_usuario"];

				$qry = "INSERT INTO $tbl_configuracion_laboratorio_analito (id_laboratorio,id_programa,id_analito,id_analizador,id_metodologia,id_reactivo,id_unidad,id_gen_vitros,id_material,activo) VALUES ($tempValue_1,$tempValue_2,$tempValue_3,$tempValue_4,$tempValue_5,$tempValue_6,$tempValue_7,$tempValue_8,$tempValue_9,1)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$iSum++;

				$cadenaResumen = "Se crea $nombre_analito_log, analizador: $nombre_analizador_log, generación: $nivel_generacion_log, metodología: $nombre_metodologia_log, reactivo: $nombre_reactivo_log, unidad: $nombre_unidad_log, material: $nombre_material_log";
				$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
						VALUES ($tempValue_1, $tempValue_2, '$fechaAct', '".$nombre_usuario."', 'Nuevo mensurando','".$cadenaResumen."')"; 
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x25");

				echo '<response code="1">1</response>';
			}
			
		break;
		case 'assignedLabAnalitValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];

			// Obtiene toda la informacion de la configuracion del mensurando de laboratorio
			$qryCheck = "SELECT 
						id_laboratorio, 
						id_programa,
						id_analito,
						id_analizador,
						id_metodologia,
						id_reactivo,
						id_unidad,
						id_gen_vitros,
						id_material
					FROM $tbl_configuracion_laboratorio_analito
					where id_configuracion = $id";
			$qryData = mysql_fetch_array(mysql_query($qryCheck));
			mysqlException(mysql_error(),$header."_01");

			$id_laboratorio = $qryData["id_laboratorio"];
			$id_programa = $qryData["id_programa"];
			$id_analito = $qryData["id_analito"];
			$id_analizador = $qryData["id_analizador"];
			$id_metodologia = $qryData["id_metodologia"];
			$id_reactivo = $qryData["id_reactivo"];
			$id_unidad = $qryData["id_unidad"];
			$id_gen_vitros = $qryData["id_gen_vitros"];
			$id_material = $qryData["id_material"];

			$qry = "SELECT nombre_usuario from usuario where id_usuario = '".$_SESSION['qap_userId']."'";
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),"_02correo");
			$qryData = mysql_fetch_array($qryArray);
			$nombre_usuario = $qryData["nombre_usuario"];
			$fechaAct = Date("Y-m-d h:i:s");
	
			switch ($which) {
				case 2: // Analito
					$qry = "SELECT 
						id_configuracion 
					FROM 
						$tbl_configuracion_laboratorio_analito 
					WHERE 
						id_laboratorio = $id_laboratorio 
						AND id_programa = $id_programa 
						AND id_analito = $value 
						AND id_analizador = $id_analizador
						AND id_metodologia = $id_metodologia 
						AND id_reactivo = $id_reactivo 
						AND id_unidad = $id_unidad 
						AND id_gen_vitros = $id_gen_vitros 
						AND id_material = $id_material 
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if($checkrows > 0){
						echo'<response code="422">Ya existe una configuración exactamente igual</response>';
					} else {


						$qry = "SELECT nombre_analito FROM analito where id_analito = $id_analito";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log = $qryData['nombre_analito'];

						$qry = "SELECT nombre_analito FROM analito where id_analito = $value";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log2 = $qryData['nombre_analito'];
						
						$cadenaResumen = "Se Actualiza el mensurando $nombre_analito_log a $nombre_analito_log2";

						$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET id_analito = $value WHERE id_configuracion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						
						// Log de enrolamiento
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', 'Modificación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");

						$uSum++;
						echo'<response code="1">1</response>';
					}
				break;
				case 3: // Analizador
					$qry = "SELECT 
						id_configuracion 
					FROM 
						$tbl_configuracion_laboratorio_analito 
					WHERE 
						id_laboratorio = $id_laboratorio 
						AND id_programa = $id_programa 
						AND id_analito = $id_analito 
						AND id_analizador = $value 
						AND id_metodologia = $id_metodologia 
						AND id_reactivo = $id_reactivo 
						AND id_unidad = $id_unidad 
						AND id_gen_vitros = $id_gen_vitros 
						AND id_material = $id_material 
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if($checkrows > 0){
						echo'<response code="422">Ya existe una configuración exactamente igual</response>';
					} else {

						$qry = "SELECT nombre_analizador FROM analizador where id_analizador = $id_analizador";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analizador_log = $qryData['nombre_analizador'];

						$qry = "SELECT nombre_analizador FROM analizador where id_analizador = $value";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analizador_log2 = $qryData['nombre_analizador'];

						$qry = "SELECT nombre_analito FROM analito where id_analito = $id_analito";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log = $qryData['nombre_analito'];

						$cadenaResumen = "Se Actualiza el analizador $nombre_analizador_log a $nombre_analizador_log2 para el mensurando $nombre_analito_log";

						$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET id_analizador = $value WHERE id_configuracion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$uSum++;

						// Log de enrolamiento
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', 'Modificación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");

						echo'<response code="1">1</response>';
					}
				break;

				case 4: // Generacion vitros
					$qry = "SELECT 
						id_configuracion 
					FROM 
						$tbl_configuracion_laboratorio_analito 
					WHERE 
						id_laboratorio = $id_laboratorio 
						AND id_programa = $id_programa 
						AND id_analito = $id_analito 
						AND id_analizador = $id_analizador
						AND id_metodologia = $id_metodologia 
						AND id_reactivo = $id_reactivo 
						AND id_unidad = $id_unidad 
						AND id_gen_vitros = $value 
						AND id_material = $id_material 
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if($checkrows > 0){
						echo'<response code="422">Ya existe una configuración exactamente igual</response>';
					} else {

						$qry = "SELECT valor_gen_vitros FROM gen_vitros where id_gen_vitros = $id_gen_vitros";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$valor_gen_vitros_log = $qryData['valor_gen_vitros'];

						$qry = "SELECT valor_gen_vitros FROM gen_vitros where id_gen_vitros = $value";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$valor_gen_vitros_log2 = $qryData['valor_gen_vitros'];

						$qry = "SELECT nombre_analito FROM analito where id_analito = $id_analito";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log = $qryData['nombre_analito'];

						$cadenaResumen = "Se Actualiza la generación vitros $valor_gen_vitros_log a $valor_gen_vitros_log2 para en analito $nombre_analito_log";

						$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET id_gen_vitros = $value WHERE id_configuracion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$uSum++;
						
						// Log de enrolamiento
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', 'Modificación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");

						echo'<response code="1">1</response>';
					}
				break;

				case 5: // Metodologia

					$qry = "SELECT 
						id_configuracion 
					FROM 
						$tbl_configuracion_laboratorio_analito 
					WHERE 
						id_laboratorio = $id_laboratorio 
						AND id_programa = $id_programa 
						AND id_analito = $id_analito 
						AND id_analizador = $id_analizador 
						AND id_metodologia = $value 
						AND id_reactivo = $id_reactivo 
						AND id_unidad = $id_unidad 
						AND id_gen_vitros = $id_gen_vitros 
						AND id_material = $id_material 
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if($checkrows > 0){
						echo'<response code="422">Ya existe una configuración exactamente igual</response>';
					} else {

						$qry = "SELECT nombre_metodologia FROM metodologia where id_metodologia = $id_metodologia";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_metodologia_log = $qryData['nombre_metodologia'];

						$qry = "SELECT nombre_metodologia FROM metodologia where id_metodologia = $value";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_metodologia_log2 = $qryData['nombre_metodologia'];

						$qry = "SELECT nombre_analito FROM analito where id_analito = $id_analito";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log = $qryData['nombre_analito'];

						$cadenaResumen = "Se Actualiza la metodología $nombre_metodologia_log a $nombre_metodologia_log2 para el mensurando $nombre_analito_log";

						$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET id_metodologia = $value WHERE id_configuracion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$uSum++;

						// Log de enrolamiento
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', 'Modificación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");

						echo'<response code="1">1</response>';
					}
				break;

				case 6: // Reactivo
					$qry = "SELECT 
						id_configuracion 
					FROM 
						$tbl_configuracion_laboratorio_analito 
					WHERE 
						id_laboratorio = $id_laboratorio 
						AND id_programa = $id_programa 
						AND id_analito = $id_analito 
						AND id_analizador = $id_analizador 
						AND id_metodologia = $id_metodologia 
						AND id_reactivo = $value 
						AND id_unidad = $id_unidad 
						AND id_gen_vitros = $id_gen_vitros 
						AND id_material = $id_material 
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if($checkrows > 0){
						echo'<response code="422">Ya existe una configuración exactamente igual</response>';
					} else {
						$qry = "SELECT nombre_reactivo FROM reactivo where id_reactivo = $id_reactivo";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_reactivo_log = $qryData['nombre_reactivo'];

						$qry = "SELECT nombre_reactivo FROM reactivo where id_reactivo = $value";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_reactivo_log2 = $qryData['nombre_reactivo'];

						$qry = "SELECT nombre_analito FROM analito where id_analito = $id_analito";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log = $qryData['nombre_analito'];

						$cadenaResumen = "Se Actualiza el reactivo $nombre_reactivo_log a $nombre_reactivo_log2 para en analito $nombre_analito_log";

						$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET id_reactivo = $value WHERE id_configuracion = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$uSum++;
						
						// Log de enrolamiento
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', 'Modificación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");

						echo'<response code="1">1</response>';
					}
					
				break;					
				case 7: // Unidad
					$qry = "SELECT 
						id_configuracion 
					FROM 
						$tbl_configuracion_laboratorio_analito 
					WHERE 
						id_laboratorio = $id_laboratorio 
						AND id_programa = $id_programa 
						AND id_analito = $id_analito 
						AND id_analizador = $id_analizador 
						AND id_metodologia = $id_metodologia 
						AND id_reactivo = $id_reactivo
						AND id_unidad = $value 
						AND id_gen_vitros = $id_gen_vitros 
						AND id_material = $id_material 
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if($checkrows > 0){
						echo'<response code="422">Ya existe una configuración exactamente igual</response>';
					} else {

						$qry = "SELECT nombre_unidad FROM unidad where id_unidad = $id_unidad";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_unidad_log = $qryData['nombre_unidad'];

						$qry = "SELECT nombre_unidad FROM unidad where id_unidad = $value";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_unidad_log2 = $qryData['nombre_unidad'];

						$qry = "SELECT nombre_analito FROM analito where id_analito = $id_analito";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log = $qryData['nombre_analito'];

						$cadenaResumen = "Se Actualiza el reactivo $nombre_unidad_log a $nombre_unidad_log2 para en analito $nombre_analito_log";

						$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET id_unidad = $value WHERE id_configuracion = $id";;
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$uSum++;

						// Log de enrolamiento
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', 'Modificación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");

						echo'<response code="1">1</response>';
					}
					
				break;
				case 8: // Material
					$qry = "SELECT 
						id_configuracion 
					FROM 
						$tbl_configuracion_laboratorio_analito 
					WHERE 
						id_laboratorio = $id_laboratorio 
						AND id_programa = $id_programa 
						AND id_analito = $id_analito 
						AND id_analizador = $id_analizador 
						AND id_metodologia = $id_metodologia 
						AND id_reactivo = $id_reactivo
						AND id_unidad = $id_unidad
						AND id_gen_vitros = $id_gen_vitros 
						AND id_material = $value 
					LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if($checkrows > 0){
						echo'<response code="422">Ya existe una configuración exactamente igual</response>';
					} else {
						$qry = "SELECT nombre_material FROM material where id_material = $id_material";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_material_log = $qryData['nombre_material'];

						$qry = "SELECT nombre_material FROM material where id_material = $value";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_material_log2 = $qryData['nombre_material'];

						$qry = "SELECT nombre_analito FROM analito where id_analito = $id_analito";
						$qryData = mysql_fetch_array(mysql_query($qry));
						mysqlException(mysql_error(),$header."_01");			
						$nombre_analito_log = $qryData['nombre_analito'];

						$cadenaResumen = "Se Actualiza el reactivo $nombre_material_log a $nombre_material_log2 para el mensurando $nombre_analito_log";

						$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET id_material = $value WHERE id_configuracion = $id";;
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$uSum++;

						// Log de enrolamiento
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', 'Modificación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");

						echo'<response code="1">1</response>';
					}

				break;				
				case 9: // Estado

					$qry = "SELECT 
						nombre_programa,
						laboratorio.no_laboratorio,
						laboratorio.nombre_laboratorio,
						nombre_analito,
						nombre_analizador,
						nombre_metodologia,
						nombre_reactivo,
						nombre_unidad,
						valor_gen_vitros,
						nombre_material
					FROM configuracion_laboratorio_analito 
					INNER JOIN programa ON configuracion_laboratorio_analito.id_programa = programa.id_programa 
					INNER JOIN laboratorio ON configuracion_laboratorio_analito.id_laboratorio = laboratorio.id_laboratorio 
					INNER JOIN analito ON configuracion_laboratorio_analito.id_analito = analito.id_analito 
					INNER JOIN analizador ON configuracion_laboratorio_analito.id_analizador = analizador.id_analizador 
					INNER JOIN metodologia ON configuracion_laboratorio_analito.id_metodologia = metodologia.id_metodologia 
					INNER JOIN reactivo ON configuracion_laboratorio_analito.id_reactivo = reactivo.id_reactivo 
					INNER JOIN unidad ON configuracion_laboratorio_analito.id_unidad = unidad.id_unidad 
					INNER JOIN gen_vitros ON configuracion_laboratorio_analito.id_gen_vitros = gen_vitros.id_gen_vitros 
					LEFT JOIN material ON configuracion_laboratorio_analito.id_material = material.id_material
					WHERE configuracion_laboratorio_analito.id_configuracion = $id";

					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),"_103");
					$qryData = mysql_fetch_array($qryArray);
					$nombre_programa_log = $qryData["nombre_programa"];
					$no_laboratorio_log = $qryData["no_laboratorio"];
					$nombre_laboratorio_log = $qryData["nombre_laboratorio"];
					$nombre_analito_log = $qryData["nombre_analito"];
					$nombre_analizador_log = $qryData["nombre_analizador"];
					$nombre_metodologia_log = $qryData["nombre_metodologia"];
					$nombre_reactivo_log = $qryData["nombre_reactivo"];
					$nombre_unidad_log = $qryData["nombre_unidad"];
					$valor_gen_vitros_log = $qryData["valor_gen_vitros"];
					$nombre_material_log = $qryData["nombre_material"];

					if($value == 1){ // Se va a activa
						$inicioCadena = "Se activa el mensurando ";
						$inicioCadena2 = "Activación de mensurando";
					} else { // Se va a deshabilitar
						$inicioCadena = "Se deshabilita el mensurando ";
						$inicioCadena2 = "Deshabilitación de mensurando";
					}
					$cadenaResumen = $inicioCadena."$nombre_analito_log, analizador: $nombre_analizador_log, generación: $valor_gen_vitros_log, metodología: $nombre_metodologia_log, reactivo: $nombre_reactivo_log, unidad: $nombre_unidad_log, material: $nombre_material_log";
					
					// Para esta opcion no hay configuracion
					$qry = "UPDATE $tbl_configuracion_laboratorio_analito SET activo = $value WHERE id_configuracion = $id";;
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$uSum++;

					// Log de enrolamiento
					$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen)
					VALUES ($id_laboratorio, $id_programa, '$fechaAct', '".$nombre_usuario."', '".$inicioCadena2."', '".$cadenaResumen."')"; 
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x25");


					echo'<response code="1">1</response>';	
				break;				
			}
			
		break;	
		case 'assignedLabAnalitDeletion':

			actionRestriction_0();
			$qry = "SELECT nombre_usuario from usuario where id_usuario = '".$_SESSION['qap_userId']."'";
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),"_02correo");
			$qryData = mysql_fetch_array($qryArray);
			$nombre_usuario = $qryData["nombre_usuario"];
			$fechaAct = Date("Y-m-d h:i:s");
			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_configuracion = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {

					$qry = "SELECT 
						nombre_programa,
						programa.id_programa,
						laboratorio.id_laboratorio,
						laboratorio.no_laboratorio,
						laboratorio.nombre_laboratorio,
						nombre_analito,
						nombre_analizador,
						nombre_metodologia,
						nombre_reactivo,
						nombre_unidad,
						valor_gen_vitros,
						nombre_material
					FROM configuracion_laboratorio_analito 
					INNER JOIN programa ON configuracion_laboratorio_analito.id_programa = programa.id_programa 
					INNER JOIN laboratorio ON configuracion_laboratorio_analito.id_laboratorio = laboratorio.id_laboratorio 
					INNER JOIN analito ON configuracion_laboratorio_analito.id_analito = analito.id_analito 
					INNER JOIN analizador ON configuracion_laboratorio_analito.id_analizador = analizador.id_analizador 
					INNER JOIN metodologia ON configuracion_laboratorio_analito.id_metodologia = metodologia.id_metodologia 
					INNER JOIN reactivo ON configuracion_laboratorio_analito.id_reactivo = reactivo.id_reactivo 
					INNER JOIN unidad ON configuracion_laboratorio_analito.id_unidad = unidad.id_unidad 
					INNER JOIN gen_vitros ON configuracion_laboratorio_analito.id_gen_vitros = gen_vitros.id_gen_vitros 
					LEFT JOIN material ON configuracion_laboratorio_analito.id_material = material.id_material
					WHERE configuracion_laboratorio_analito.id_configuracion = ".$ids[$x];

					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),"_103");
					$qryData = mysql_fetch_array($qryArray);
					$id_programa_log = $qryData["id_programa"];
					$nombre_programa_log = $qryData["nombre_programa"];
					$no_laboratorio_log = $qryData["no_laboratorio"];
					$id_laboratorio_log = $qryData["id_laboratorio"];
					$nombre_laboratorio_log = $qryData["nombre_laboratorio"];
					$nombre_analito_log = $qryData["nombre_analito"];
					$nombre_analizador_log = $qryData["nombre_analizador"];
					$nombre_metodologia_log = $qryData["nombre_metodologia"];
					$nombre_reactivo_log = $qryData["nombre_reactivo"];
					$nombre_unidad_log = $qryData["nombre_unidad"];
					$valor_gen_vitros_log = $qryData["valor_gen_vitros"];
					$nombre_material_log = $qryData["nombre_material"];

					$cadenaResumen = "Se elimina el mensurando $nombre_analito_log, analizador: $nombre_analizador_log, generación: $valor_gen_vitros_log, metodología: $nombre_metodologia_log, reactivo: $nombre_reactivo_log, unidad: $nombre_unidad_log, material: $nombre_material_log";


					$qry = "DELETE FROM $tbl_configuracion_laboratorio_analito WHERE id_configuracion = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$dSum++;

					// Log de enrolamiento
					$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen)
					VALUES ($id_laboratorio_log, $id_programa_log, '$fechaAct', '".$nombre_usuario."', 'Eliminación de mensurando', '".$cadenaResumen."')"; 
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x25");
				}
			}

			echo'<response code="1">1</response>';
			
		break;		
		case 'countryRegistry':

			actionRestriction_101();
			$postValues_1 = $_POST['countryname'];
			$tempValue_1 = clean($postValues_1);
			$qry = "SELECT id_pais FROM $tbl_pais WHERE nombre_pais = '$tempValue_1' LIMIT 0,1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");	

			if ($checkrows > 0) {
				echo '<response code="422">Ya existe un pais con el mismo nombre en la base de datos</response>';
			} else if(strlen($tempValue_1) < 4 || strlen($tempValue_1) > 255) {
				echo '<response code="422">El nombre del pais debe tener entre 4 y 255 carácteres de longitud</response>';
			} else {
				$qry = "INSERT INTO $tbl_pais (nombre_pais) VALUES ('$tempValue_1')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';
			}
			
		break;
		case 'countryValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = clean($_POST['value']);
			
			switch ($which) {
				case 1:

					$qry = "SELECT id_pais FROM $tbl_pais WHERE nombre_pais = '$value' LIMIT 0,1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");	

					if ($checkrows > 0) {
						echo '<response code="422">Ya existe un pais con el mismo nombre en la base de datos</response>';
					} else if(strlen($value) < 4 || strlen($value) > 255) {
						echo '<response code="422">El nombre del pais debe tener entre 4 y 255 carácteres de longitud</response>';
					} else {
						$qry = "UPDATE $tbl_pais SET nombre_pais = '".clean($value)."' WHERE id_pais = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo '<response code="1">1</response>';
					}
				break;	
			}
			
		break;
		case 'countryDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_pais FROM $tbl_pais WHERE id_pais = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_pais WHERE id_pais = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'cityRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['countryid'];
			$postValues_2 = $_POST['cityname'];
			$tempValue_1 = clean($postValues_1);
			$tempValue_2 = clean($postValues_2);
			
			$qry = "SELECT id_ciudad FROM $tbl_ciudad WHERE id_pais = $tempValue_1 AND nombre_ciudad = '$tempValue_2' LIMIT 0,1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");	

			if ($checkrows > 0) {
				echo '<response code="422">La ciudad ya existe para el pais indicado</response>';
			} else if($tempValue_1 == ""){
				echo '<response code="422">Debe especificar el pais</response>';
			} else if(strlen($tempValue_2) < 4 || strlen($tempValue_2) > 255){
				echo '<response code="422">El nombre de la ciudad debe tener entre 4 y 255 carácteres de longitud</response>';
			} else {
				$qry = "INSERT INTO $tbl_ciudad (id_pais,nombre_ciudad) VALUES ($tempValue_1,'$tempValue_2')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';
			}
			
		break;
		case 'cityValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
						
					$qry = "SELECT nombre_ciudad FROM $tbl_ciudad WHERE id_ciudad = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$qryData = mysql_fetch_array($qryArray);
					$nombre_ciudad = $qryData["nombre_ciudad"];

					$qry = "SELECT * FROM $tbl_ciudad WHERE id_pais = $value AND nombre_ciudad = '$nombre_ciudad' LIMIT 0,1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows > 0) {
						echo '<response code="422">La ciudad ya existe para el pais indicado</response>';
					} else if($value == ""){
						echo '<response code="422">Debe especificar el pais</response>';
					} else {
						$qry = "UPDATE $tbl_ciudad SET id_pais = $value WHERE id_ciudad = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo '<response code="1">1</response>';
					}
				
				break;
				case 2:

					$qry = "SELECT id_pais FROM $tbl_ciudad WHERE id_ciudad = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$qryData = mysql_fetch_array($qryArray);
					$id_pais = $qryData["id_pais"];

					$qry = "SELECT * FROM $tbl_ciudad WHERE id_pais = $id_pais AND nombre_ciudad = '$value' LIMIT 0,1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows > 0) {
						echo '<response code="422">La ciudad ya existe para el pais indicado</response>';
					} else if(strlen($value) < 4 || strlen($value) > 255){
						echo '<response code="422">El nombre de la ciudad debe tener entre 4 y 255 carácteres de longitud</response>';
					} else {
						$qry = "UPDATE $tbl_ciudad SET nombre_ciudad = '".clean($value)."' WHERE id_ciudad = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo '<response code="1">1</response>';
					}
				
				break;		
			}
			
		break;
		case 'cityDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_ciudad FROM $tbl_ciudad WHERE id_ciudad = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_ciudad WHERE id_ciudad = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'userRegistry':

			$postValues_1 = $_POST['usertype'];
			
			switch ($postValues_1) {
				case 0:
					actionRestriction_0();
				break;
				case 100:
					actionRestriction_100();
				break;
				case 101:
					actionRestriction_100();
				break;
				case 102:
					actionRestriction_100();
				break;
				case 103:
					actionRestriction_101();
				break;
				case 104:
					actionRestriction_101();
				break;
				case 125: // Patologo
					actionRestriction_101();
				break;		
				default:
					actionRestriction_0();
				break;
			}
			
			$postValues_2 = $_POST['username'];
			$postValues_3 = $_POST['userpassword'];
			$codigo_usuario = $_POST['codigo'];
			$email_user = $_POST['email'];
			$fullname = $_POST['fullname'];
	
			$tempValue_1 = clean($postValues_1);
			$tempValue_2 = clean($postValues_2);
			$tempValue_3 = clean($postValues_3);
			
			$qry = "SELECT id_usuario FROM $tbl_usuario WHERE nombre_usuario = '$tempValue_2' LIMIT 0,1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) {
				echo '<response code="422">Ya existe el mismo nombre de usuario dentro de la base de datos</response>';
			} else if($tempValue_1 == ""){
				echo '<response code="422">Debe especificar el tipo de usuario</response>';
			} else if(strlen($tempValue_2) < 4 || strlen($tempValue_2) > 45){
				echo '<response code="422">El nombre de usuario debe tener entre 4 y 45 carácteres de longitud</response>';
			} else if(strlen($tempValue_3) < 4 || strlen($tempValue_3) > 45){
				echo '<response code="422">La contraseña temporal debe tener entre 4 y 45 carácteres</response>';
			} else {
				
				if($tempValue_1 == "125"){ // Si el tipo de usuario es patólogo
					// Verificar si el codigo de usuario esta repetido
					$qry2 = "SELECT id_usuario FROM $tbl_usuario WHERE cod_usuario = '$codigo_usuario'";
					$checkrows2 = mysql_num_rows(mysql_query($qry2));
					mysqlException(mysql_error(),$header."_0x02_");
					
					if($codigo_usuario == ""){
						echo '<response code="422">Debe especificar el codigo de usuario</response>';
					} else if(strlen($codigo_usuario) < 4 || strlen($codigo_usuario) > 45){
						echo '<response code="422">El código de usuario debe tener entre 4 y 45 carácteres de longitud</response>';
					} else if(strlen($email_user) < 10 || strlen($email_user) > 60){
						echo '<response code="422">El nombre del correo debe tener entre 10 y 60 carácteres de longitud</response>';
					} else if($checkrows2>0) {
						echo '<response code="422">El código de usuario ya ha sido asignado</response>';
					} else if(strlen($fullname)<4 || strlen($fullname)>60) {
						echo '<response code="422">El nombre completo del usuario debe tener entre 4 y 60 carácteres</response>';
					} else {
						$qry = "INSERT INTO $tbl_usuario (nombre_usuario,nombre_completo,email_usuario,contrasena,tipo_usuario, cod_usuario) VALUES ('$tempValue_2','$fullname','$email_user','$tempValue_3',$tempValue_1, '$codigo_usuario')";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;
						echo '<response code="1">1</response>';
					}
				} else { // Si son usuarios convencionales
					$qry = "INSERT INTO $tbl_usuario (nombre_usuario,email_usuario,contrasena,tipo_usuario) VALUES ('$tempValue_2','$email_user','$tempValue_3',$tempValue_1)";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x04");
					$logQuery['INSERT'][$iSum] = $qry;
					$iSum++;
					echo '<response code="1">1</response>';
				}
			}

			
		break;


		case 'documentDeletion':

			//actionRestriction_100();

			$id = encryptControl('decrypt',$_POST['ids'],$_SESSION['qap_token']);
			
			$qry = "SELECT id_archivo,index_archivo,extencion_archivo FROM archivo WHERE id_archivo = $id LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			$qryData = mysql_fetch_array(mysql_query($qry));
			
			if ($checkrows > 0) {
				
				$path = '../reportes/'.$qryData['index_archivo'].'.'.$qryData['extencion_archivo'];
				
				if (file_exists($path)) {
					unlink($path);
					if (file_exists($path)) {
						$error++;
					} else {
						$qry = "DELETE FROM archivo WHERE id_archivo = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['DELETE'][$dSum] = $qry;
						$dSum++;					
					}				
				}
			}

			echo'<response code="1">1</response>';
			
		break;	

		case "retoPATDeletion":
			
			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM reto WHERE id_reto = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
			}
			echo'<response code="1">1</response>';
			break;


		case "casoClinicoPATDeletion":
			actionRestriction_0();
			$ids = explode("|",$_POST['ids']);			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM caso_clinico WHERE id_caso_clinico = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x0486879");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
			}
			echo'<response code="1">1</response>';
			break;

		case "distractorDeletion":
			actionRestriction_0();
			$ids = explode("|",$_POST['ids']);			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM distractor WHERE id_distractor = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x0486879");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
			}
			echo'<response code="1">1</response>';
			break;

		case "preguntaDeletion":
			actionRestriction_0();
			$ids = explode("|",$_POST['ids']);			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM pregunta WHERE id_pregunta = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x04868755");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
			}
			echo'<response code="1">1</response>';
			break;


		case "referenciaPATDeletion":
			actionRestriction_0();
			$ids = explode("|",$_POST['ids']);			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM referencia WHERE id_referencia = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x0486879");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
			}
			echo'<response code="1">1</response>';
			break;

		case "imagenDeletion":
			actionRestriction_0();
			$ids = explode("|",$_POST['ids']);			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM imagen_adjunta WHERE id_imagen_adjunta = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x0486887");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
			}
			echo'<response code="1">1</response>';
			break;

		case "grupoDeletion":
			actionRestriction_0();
			$ids = explode("|",$_POST['ids']);			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "DELETE FROM grupo WHERE id_grupo = $ids[$x]";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x0486890");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
			}
			echo'<response code="1">1</response>';
			break;

		case 'userValueEditor':

			actionRestriction_0();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 1:
					$qry = "SELECT id_usuario FROM $tbl_usuario WHERE nombre_usuario = '".clean($value)."' LIMIT 0,1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");

					if ($checkrows > 0) {
						echo '<response code="422">Ya existe el mismo nombre de usuario dentro de la base de datos</response>';
					} else if(strlen(clean($value)) < 4 || strlen(clean($value)) > 45){
						echo '<response code="422">El nombre de usuario debe tener entre 4 y 45 carácteres de longitud</response>';
					} else {
						$qry = "UPDATE $tbl_usuario SET nombre_usuario = '".clean($value)."' WHERE id_usuario = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo '<response code="1">1</response>';
					}
				
				break;
				case 2:
					if(strlen(clean($value)) < 4 || strlen(clean($value)) > 45){
						echo '<response code="422">La contraseña temporal debe tener entre 4 y 45 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_usuario SET contrasena = '".clean($value)."', passwordchange_lastupdateddate = '2001-01-01' WHERE id_usuario = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo '<response code="1">1</response>';
					}
				
				break;
				case 3:
					if(strlen(clean($value)) == ""){
						echo '<response code="422">Debe especificar el tipo de usuario</response>';
					} else {
						$qry = "UPDATE $tbl_usuario SET tipo_usuario = $value WHERE id_usuario = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo '<response code="1">1</response>';
					}
				
				break;		
				case 5:
					// Obtener el tipo de usuario del id relacionado
					$qry = "SELECT tipo_usuario from $tbl_usuario where id_usuario = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");
					
					$tipo_usuario = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$tipo_usuario = $qryData["tipo_usuario"];
					}

					if($tipo_usuario == 125){ // Si es un usuario patologo

						$qry2 = "SELECT id_usuario FROM $tbl_usuario WHERE cod_usuario = '$value' LIMIT 1";
						$checkrows2 = mysql_num_rows(mysql_query($qry2));
						mysqlException(mysql_error(),$header."_0x01_");
						
						if(strlen($value) < 4 || strlen($value) > 45){
							echo '<response code="422">El código de usuario debe tener entre 4 y 45 carácteres de longitud</response>';
						} else if($checkrows2 > 0){
							echo '<response code="422">El código ya ha sido asignado para otro laboratorio</response>';
						} else {
							$qry = "UPDATE $tbl_usuario SET cod_usuario = '$value' WHERE id_usuario = $id";
							mysql_query($qry);
							mysqlException(mysql_error(),$header."_0x03");
							$logQuery['UPDATE'][$uSum] = $qry;
							$uSum++;
							echo '<response code="1">1</response>';
						}	
					} else {
						echo '<response code="422">El codigo sólo aplica para patólogos</response>';
					}
				break;
				case 6:
					// Obtener el tipo de usuario del id relacionado
					$qry = "SELECT tipo_usuario from $tbl_usuario where id_usuario = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");
					
					$tipo_usuario = 0;
					while ($qryData = mysql_fetch_array($qryArray)) {
						$tipo_usuario = $qryData["tipo_usuario"];
					}

					if($tipo_usuario == 125){ // Si es un usuario patologo

						if(strlen($value) < 4 || strlen($value) > 45){
							echo '<response code="422">El nombre completo del patólogo debe tener entre 4 y 60 carácteres de longitud</response>';
						} else {
							$qry = "UPDATE $tbl_usuario SET nombre_completo = '$value' WHERE id_usuario = $id";
							mysql_query($qry);
							mysqlException(mysql_error(),$header."_0x03");
							$logQuery['UPDATE'][$uSum] = $qry;
							$uSum++;
							echo '<response code="1">1</response>';
						}	
					} else {
						echo '<response code="422">El nombre sólo aplica para patólogos</response>';
					}
				break;	
				case 7:
					// Obtener el tipo de usuario del id relacionado
					if(strlen($value) < 10 || strlen($value) > 60){
						echo '<response code="422">El nombre del correo debe tener entre 10 y 60 carácteres de longitud</response>';
					} else {
						$qry = "UPDATE $tbl_usuario SET email_usuario = '$value' WHERE id_usuario = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo '<response code="1">1</response>';
					}
				break;		
			}
			
		break;
		case 'userDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_usuario FROM $tbl_usuario WHERE id_usuario = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_usuario WHERE id_usuario = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'labUserAssignation':
		
			actionRestriction_101();
		
			$postValues_1 = $_POST['userid'];
			$postValues_2 = $_POST['labid'];
			
			$insertedValues = 0;
			
			$tempValue_1 = $postValues_1;
			$tempValue_2 = $postValues_2;
			
			$qry = "SELECT id_conexion FROM $tbl_usuario_laboratorio WHERE id_usuario = $tempValue_1 AND id_laboratorio = $tempValue_2 LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01");	

			if ($checkrows == 0) {
				
				$qry = "INSERT INTO $tbl_usuario_laboratorio (id_usuario,id_laboratorio) VALUES ($tempValue_1,$tempValue_2)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				
				$insertedValues++;
				
			}


			echo '<response code="1">';
			echo $insertedValues;
			echo '</response>';
			
		break;
		case 'assignedLabUserDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_conexion FROM $tbl_usuario_laboratorio WHERE id_conexion = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_usuario_laboratorio WHERE id_conexion = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'disRegistry':

			actionRestriction_101(); // Permisos de la accion de registro

			$disname = clean($_POST['disname']);

			// Consulta para validar el nombre de analizador
			$qry = "SELECT id_distribuidor FROM $tbl_distribuidor WHERE nombre_distribuidor = '".clean($disname)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");
			
			if ($checkrows > 0) { // Si hay analizador ya registradas
				echo '<response code="422">El nombre del distribuidor ya esta registrado</response>';
			} else if(strlen($disname) < 1 || strlen($disname) > 255) {
				echo '<response code="422">El nombre del distribuidor debe tener entre 1 y 255 carácteres</response>';
			} else {
				$qry = "INSERT INTO $tbl_distribuidor (nombre_distribuidor) VALUES ('$disname')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02_");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';
			}

		break;
		case 'disValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
					
				case 1:
					$qry = "SELECT nombre_distribuidor FROM $tbl_distribuidor WHERE nombre_distribuidor = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay material ya registrado
						echo '<response code="422">El nombre de la distribuidor ya esta registrado</response>';
					} else if(strlen($value) < 1 || strlen($value) > 255) {
						echo '<response code="422">El nombre del distribuidor debe tener entre 1 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_distribuidor SET nombre_distribuidor = '".clean($value)."' WHERE id_distribuidor = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;	
			}
		break;

		case 'disDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_distribuidor FROM $tbl_distribuidor WHERE id_distribuidor = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_distribuidor WHERE id_distribuidor = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'labRoundAssignation':
		
			actionRestriction_101();
		
			$postValues_1 = $_POST['labid'];
			$postValues_2 = $_POST['roundid'];
			$tempValue_1 = $postValues_1;
			$tempValue_2 = $postValues_2;
			
			$qry = "SELECT id_ronda_laboratorio FROM $tbl_ronda_laboratorio WHERE id_ronda = $tempValue_2 AND id_laboratorio = $tempValue_1 LIMIT 0,1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01");	

			if ($checkrows > 0) {
				echo '<response code="422">La ronda indicada, ya se encuentra asignada para el mismo laboratorio</response>';	
			} else {
				$qry = "INSERT INTO $tbl_ronda_laboratorio (id_ronda,id_laboratorio) VALUES ($tempValue_2,$tempValue_1)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';
			}
			
		break;
		case 'assignedLabRoundValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 4:
					$qry = "UPDATE $tbl_ronda_laboratorio SET id_ronda = $value WHERE id_ronda_laboratorio = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;			
			}
			
			echo'<response code="1"></response>';
			
		break;
		case 'assignedLabRoundDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_ronda_laboratorio FROM $tbl_ronda_laboratorio WHERE id_ronda_laboratorio = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_ronda_laboratorio WHERE id_ronda_laboratorio = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;

		case 'saveAnalitLimit':
		
			actionRestriction_101();
		
			$postValues_1 = explode("|",clean($_POST['ids']));
			$postValues_2 = explode("|",clean($_POST['limits']));
			$postValues_4 = explode("|",clean($_POST['limittypes']));
			$postValues_3 = clean($_POST['limitid']);
			
			$insertedValues = 0;
			
			for ($x = 0; $x < sizeof($postValues_1); $x++) {
			
				$tempValue_1 = $postValues_1[$x];
				$tempValue_2 = $postValues_2[$x];
				$tempValue_4 = $postValues_4[$x];
				$tempValue_3 = $postValues_3;
				
				$qry = "SELECT id_limite FROM $tbl_limite_evaluacion WHERE id_analito = $tempValue_1 AND id_opcion_limite = $tempValue_3";
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				
				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x01");			
				
				$checkrows = mysql_num_rows($qryArray);
				
				if ($checkrows == 0) {
					
					$qry = "INSERT INTO $tbl_limite_evaluacion (id_analito,id_opcion_limite,id_calculo_limite_evaluacion,limite) VALUES ($tempValue_1,$tempValue_3,$tempValue_4,'$tempValue_2')";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['INSERT'][$iSum] = $qry;
					$iSum++;					
					
				} else {
					
					$qry = "UPDATE $tbl_limite_evaluacion SET limite = '$tempValue_2', id_calculo_limite_evaluacion = $tempValue_4 WHERE id_limite = ".$qryData['id_limite'];
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x03");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;	
					
				}		
			
				$insertedValues++;
			
			}
		
			echo '<response code="1">';
			echo $insertedValues;
			echo '</response>';			
		
		break;
		case 'analitRevalorationEditor':

			actionRestriction_100();

			$filterconfig = explode("|",$_POST["filterconfig"]);
			$id_config_lab_sm = $filterconfig[0];
			$id_laboratorio_sm = $filterconfig[1];
			$id_programa_sm = $filterconfig[2];
			$id_ronda_sm = $filterconfig[3];
			$id_muestra_sm = $filterconfig[4];

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];

			switch ($which) {
				case 2:

					$qry = "SELECT id_resultado FROM $tbl_resultado WHERE id_configuracion = $id_config_lab_sm AND id_muestra = $id_muestra_sm";

					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");	

					if ($checkrows == 0) { // Si no hay resultados con dica configuracion
						$qry = "INSERT INTO $tbl_resultado (id_muestra, id_configuracion, fecha_resultado, valor_resultado, observacion_resultado, editado, id_usuario, revalorado, id_analito_resultado_reporte_cualitativo) 
								VALUES ($id_muestra_sm, $id_config_lab_sm, '". Date("Y-m-d")."', NULL, '', 0, ".$_SESSION['qap_userId'].", 0, NULL)";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['INSERT'][$iSum] = $qry;
						 
						$qry = "SELECT last_insert_id() as ultimo";
						$qryArray = mysql_query($qry);
						mysqlException(mysql_error(),"_01");
						while($qryData = mysql_fetch_array($qryArray)) {
							$id = $qryData["ultimo"];
						}
					}
					
					$qry = "UPDATE $tbl_resultado SET revalorado = $value WHERE id_resultado = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				break;	
			}
			
			echo'<response code="1"></response>';
			
		break;
		case 'massAnalitRevalorationEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = explode("|",$_POST['id']);
			$value = $_POST['value'];
			$configs_values = explode("|",$_POST['configs_values']);
			$muestravalue = $_POST['muestravalue'];
			
			switch ($which) {			
				case 2:
					for ($x = 0; $x < sizeof($id); $x++) {

						$qry = "SELECT id_resultado FROM $tbl_resultado WHERE id_configuracion = '".$configs_values[$x]."' AND id_muestra = '".$muestravalue."'";

						$checkrows = mysql_num_rows(mysql_query($qry));
						mysqlException(mysql_error(),$header."_0x01");	
	
						if ($checkrows == 0) { // Si no hay resultados con dicha configuracion
							$qry = "INSERT INTO $tbl_resultado (id_muestra, id_configuracion, fecha_resultado, valor_resultado, observacion_resultado, editado, id_usuario, revalorado, id_analito_resultado_reporte_cualitativo) 
									VALUES ($muestravalue, $configs_values[$x], '". Date("Y-m-d")."', NULL, '', 0, ".$_SESSION['qap_userId'].", 0, NULL)";
							mysql_query($qry);
							mysqlException(mysql_error(),$header."_0x02");
							$logQuery['INSERT'][$iSum] = $qry;
							 
							$qry = "SELECT last_insert_id() as ultimo";
							$qryArray = mysql_query($qry);
							mysqlException(mysql_error(),"_01");
							while($qryData = mysql_fetch_array($qryArray)) {
								$id[$x] = $qryData["ultimo"];
							}
	
						}
						
						$qry = "UPDATE $tbl_resultado SET revalorado = 1 WHERE id_resultado = ".$id[$x];
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
					}	
				break;	
			}
			
			echo'<response code="1"></response>';
			
		break;
		case 'referenceValueRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['sampleid'];
			$postValues_2 = $_POST['analyzerid'];
			$postValues_3 = $_POST['methodid'];
			$postValues_4 = $_POST['referencevalue'];
			$postValues_5 = $_POST['analitid'];
			$postValues_6 = $_POST['programid'];
			$postValues_7 = $_POST['unitid'];
			
			$tempValue_1 = $postValues_1;
			$tempValue_2 = $postValues_2;
			$tempValue_3 = $postValues_3;
			$tempValue_4 = clean($postValues_4);
			$tempValue_5 = $postValues_5;
			$tempValue_6 = $postValues_6;
			$tempValue_7 = $postValues_7;
			
			$qry = "SELECT id_valor_metodo_referencia FROM $tbl_valor_metodo_referencia WHERE id_metodologia = $tempValue_1 AND id_unidad = $tempValue_7 AND id_muestra = $tempValue_3 AND id_analito = $tempValue_5 LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01");	

			if ($checkrows == 0) {
				$qry = "INSERT INTO $tbl_valor_metodo_referencia (id_analito,id_metodologia,id_unidad,id_muestra,valor_metodo_referencia) VALUES ($tempValue_5,$tempValue_3,$tempValue_7,$tempValue_1,'$tempValue_4')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				
				$qry = "SELECT $tbl_muestra.id_muestra FROM $tbl_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra WHERE $tbl_muestra.id_muestra NOT IN (SELECT $tbl_valor_metodo_referencia.id_muestra FROM $tbl_valor_metodo_referencia INNER JOIN $tbl_muestra_programa ON $tbl_valor_metodo_referencia.id_muestra = $tbl_muestra_programa.id_muestra WHERE $tbl_muestra_programa.id_programa = $tempValue_6 AND id_analito = $tempValue_5 AND id_metodologia = $tempValue_3 AND id_unidad = $tempValue_7) AND $tbl_muestra_programa.id_programa = $tempValue_6";
				
				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x03");
				
				while ($qryData = mysql_fetch_array($qryArray)) {
					$qry = "INSERT INTO $tbl_valor_metodo_referencia (id_analito,id_metodologia,id_unidad,id_muestra,valor_metodo_referencia) VALUES ($tempValue_5,$tempValue_3,$tempValue_7,".$qryData['id_muestra'].",'0')";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x04");
					$logQuery['INSERT'][$iSum] = $qry;
					$iSum++;					
				}
				
				$response = 1;
			} else {
				$response = 0;
			}

			echo '<response code="1">';
			echo $response;
			echo '</response>';			
			
		break;
		case 'referenceValueValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 4:
					$qry = "UPDATE $tbl_valor_metodo_referencia SET id_metodologia = $value WHERE id_valor_metodo_referencia = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;					
				case 5:
					$qry = "UPDATE $tbl_valor_metodo_referencia SET valor_metodo_referencia = '".clean($value)."' WHERE id_valor_metodo_referencia = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;
				case 6:
					$qry = "UPDATE $tbl_valor_metodo_referencia SET id_unidad = $value WHERE id_valor_metodo_referencia = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;					
			}
			
			echo'<response code="1"></response>';
			
		break;
		case 'referenceValueDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_valor_metodo_referencia FROM $tbl_valor_metodo_referencia WHERE id_valor_metodo_referencia = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_valor_metodo_referencia WHERE id_valor_metodo_referencia = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'jctlmMethodRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['analitid'];
			$postValues_2 = $_POST['jctlmmethod'];
			$tempValue_1 = $postValues_1;
			$tempValue_2 = clean($postValues_2);
			$contadorRegistro = 0;

			$qry = "SELECT id_metodo_jctlm FROM $tbl_metodo_jctlm WHERE id_analito = $tempValue_1 AND desc_metodo_jctlm = '$tempValue_2'";
			
			$qryData = mysql_fetch_array(mysql_query($qry));
			
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_0x01");			
			
			$checkrows = mysql_num_rows($qryArray);
			
			if ($checkrows == 0) {
				
				$qry = "INSERT INTO $tbl_metodo_jctlm (id_analito,desc_metodo_jctlm,activo) VALUES ($tempValue_1,'$tempValue_2',1)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;					
				$contadorRegistro++;
			}
		
			echo '<response code="1">'.$contadorRegistro.'</response>';			
			
		break;
		case 'jctlmMethodValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = clean($_POST['value']);
			
			switch ($which) {
				case 3:
					// Se obtiene el id del analito
					$qry = "SELECT * FROM $tbl_metodo_jctlm WHERE id_metodo_jctlm = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$qryData = mysql_fetch_array($qryArray);
					$id_analito = $qryData["id_analito"];
					
					$qry = "SELECT id_metodo_jctlm FROM $tbl_metodo_jctlm WHERE id_analito = $id_analito AND desc_metodo_jctlm = '$value'";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_01");			
			
					if ($checkrows > 0) {
						echo'<response code="422">Ya existe una metodlogía de JCTLM para el mismo analito</response>';
					} else if(strlen($value) < 4 || strlen($value) > 255) {

					} else {
						$qry = "UPDATE $tbl_metodo_jctlm SET desc_metodo_jctlm = '$value' WHERE id_metodo_jctlm = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;
				case 4:
					$qry = "UPDATE $tbl_metodo_jctlm SET activo = $value WHERE id_metodo_jctlm = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					echo'<response code="1"></response>';
				break;
			}
			
			
		break;
		case 'jctlmMethodDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_metodo_jctlm FROM $tbl_metodo_jctlm WHERE id_metodo_jctlm = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_metodo_jctlm WHERE id_metodo_jctlm = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'jctlmMaterialRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['analitid'];
			$postValues_2 = $_POST['jctlmmaterial'];
			$tempValue_1 = $postValues_1;
			$tempValue_2 = clean($postValues_2);
			$contadorRegistro = 0;
			
			$qry = "SELECT id_material_jctlm FROM $tbl_material_jctlm WHERE id_analito = $tempValue_1 AND desc_material_jctlm = '$tempValue_2'";
			
			$qryData = mysql_fetch_array(mysql_query($qry));
			
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_0x01");			
			
			$checkrows = mysql_num_rows($qryArray);
			
			if ($checkrows == 0) {
				
				$qry = "INSERT INTO $tbl_material_jctlm (id_analito,desc_material_jctlm,activo) VALUES ($tempValue_1,'$tempValue_2',1)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;				
				$contadorRegistro++;				
			}		
			
		
			echo '<response code="1">'.$contadorRegistro.'</response>';		
			
		break;
		case 'jctlmMaterialValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
				case 3:

					// Se obtiene el id del analito
					$qry = "SELECT * FROM $tbl_material_jctlm WHERE id_material_jctlm = $id";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),$header."_01");			
					$qryData = mysql_fetch_array($qryArray);
					$id_analito = $qryData["id_analito"];
					
					$qry = "SELECT id_material_jctlm FROM $tbl_material_jctlm WHERE id_analito = $id_analito AND desc_material_jctlm = '$value'";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_01");			
			
					if ($checkrows > 0) {
						echo'<response code="422">Ya existe un material de JCTLM para el mismo analito</response>';
					} else if(strlen($value) < 4 || strlen($value) > 255) {

					} else {
						$qry = "UPDATE $tbl_material_jctlm SET desc_material_jctlm = '$value' WHERE id_material_jctlm = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				
				break;
				case 4:
					$qry = "UPDATE $tbl_material_jctlm SET activo = $value WHERE id_material_jctlm = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;
			}
			
		break;
		case 'jctlmMaterialDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_material_jctlm FROM $tbl_material_jctlm WHERE id_material_jctlm = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_material_jctlm WHERE id_material_jctlm = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'materialRegistry':

			actionRestriction_101();

			$materialname = $_POST['materialname']; // Nombre de material

			// Consulta para validar la metodologia
			$qry = "SELECT id_material FROM $tbl_material WHERE nombre_material = '".clean($materialname)."' LIMIT 1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");

			if ($checkrows > 0) { // Si hay materiales ya registrados
				echo '<response code="422">El nombre del material ya esta registrado</response>';
			} else if(strlen(clean($materialname)) < 4 || strlen(clean($materialname)) > 255) {
				echo '<response code="422">El nombre del material debe tener entre  4 y 255 carácteres</response>';
			} else {
				$qry = "INSERT INTO $tbl_material (nombre_material) VALUES ('".clean($materialname)."')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';	
			}		
			
		break;
		case 'materialValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			
			switch ($which) {
					
				case 1:
					$qry = "SELECT nombre_material FROM $tbl_material WHERE nombre_material = '".clean($value)."' LIMIT 1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_");
					
					if ($checkrows > 0) { // Si hay material ya registrado
						echo '<response code="422">El nombre de la analizador ya esta registrado</response>';
					} else if(strlen(clean($value)) < 4 || strlen(clean($value)) > 255) {
						echo '<response code="422">El nombre del material debe tener entre  4 y 255 carácteres</response>';
					} else {
						$qry = "UPDATE $tbl_material SET nombre_material = '".clean($value)."' WHERE id_material = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;
						echo'<response code="1"></response>';
					}
				break;	
			}

		break;
		case 'materialDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_material FROM $tbl_material WHERE id_material = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_material WHERE id_material = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'pairJctlmMethods':

			actionRestriction_101();

			$postValues_1 = $_POST['methodid1'];
			$postValues_2 = $_POST['methodid2'];
			
			$tempValue_1 = $postValues_1;
			$tempValue_2 = $postValues_2;
			
			$qry = "SELECT id_conexion FROM $tbl_metodo_jctlm_emparejado WHERE id_metodologia = $tempValue_1 AND id_metodo_jctlm = $tempValue_2 LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01");	

			if ($checkrows == 0) {
				$qry = "INSERT INTO $tbl_metodo_jctlm_emparejado (id_metodologia,id_metodo_jctlm) VALUES ($tempValue_1,$tempValue_2)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				
				$response = 1;
			} else {
				$response = 0;
			}

			echo '<response code="1">';
			echo $response;
			echo '</response>';			
			
		break;
		case 'pairedJctlmMethodDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_conexion FROM $tbl_metodo_jctlm_emparejado WHERE id_conexion = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_metodo_jctlm_emparejado WHERE id_conexion = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'pairJctlmMaterials':

			actionRestriction_101();

			$postValues_1 = $_POST['materialid1'];
			$postValues_2 = $_POST['materialid2'];
			
			$tempValue_1 = $postValues_1;
			$tempValue_2 = $postValues_2;
			
			$qry = "SELECT id_conexion FROM $tbl_material_jctlm_emparejado WHERE id_material = $tempValue_1 AND id_material_jctlm = $tempValue_2 LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01");	

			if ($checkrows == 0) {
				$qry = "INSERT INTO $tbl_material_jctlm_emparejado (id_material,id_material_jctlm) VALUES ($tempValue_1,$tempValue_2)";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				
				$response = 1;
			} else {
				$response = 0;
			}

			echo '<response code="1">';
			echo $response;
			echo '</response>';			
			
		break;
		case 'pairedJctlmMaterialDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_conexion FROM $tbl_material_jctlm_emparejado WHERE id_conexion = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_material_jctlm_emparejado WHERE id_conexion = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'analitCualitativeTypeOfResultRegistry':

			actionRestriction_101();

			$postValues_1 = $_POST['analitid'];
			$postValues_2 = str_replace(",",".",$_POST['analitresult']);
			$postValues_3 = $_POST['puntuacionid'];
			$tempValue_1 = clean($postValues_1);
			$tempValue_2 = clean($postValues_2);
			$tempValue_3 = clean($postValues_3);
			
			$qry = "SELECT id_analito_resultado_reporte_cualitativo FROM $tbl_analito_resultado_reporte_cualitativo WHERE id_analito = $tempValue_1 AND desc_resultado_reporte_cualitativo = '$tempValue_2' AND id_puntuacion = $tempValue_3 LIMIT 0,1";
			$checkrows = mysql_num_rows(mysql_query($qry));
			mysqlException(mysql_error(),$header."_0x01_");	
			
			if ($checkrows > 0) {
				echo '<response code="422">El resultado indicado ya existe para el mensurando seleccionado</response>';			
			} else if ($tempValue_1 == "") {
				echo '<response code="422">Debe especificar un programa</response>';			
			} else if ($tempValue_2 == "") {
				echo '<response code="422">Debe especificar un analito</response>';			
			}else if ($tempValue_3 == "") {
				echo '<response code="422">Debe especificar una puntuación</response>';
			}else {
				$qry = "INSERT INTO $tbl_analito_resultado_reporte_cualitativo (id_analito,desc_resultado_reporte_cualitativo,id_puntuacion) VALUES ($tempValue_1,'$tempValue_2','$tempValue_3')";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02_");
				$logQuery['INSERT'][$iSum] = $qry;
				$iSum++;
				echo '<response code="1">1</response>';			
			}
			
		break;
		case 'analitCualitativeTypeOfResultValueEditor':

    actionRestriction_100();

    $which = $_POST['which'];
    $id = $_POST['id'];
    $value = str_replace(",", ".", $_POST['value']);

    switch ($which) {

        case 2:
            // Validación para la descripción del resultado
            $qry = "SELECT * 
                    FROM $tbl_analito_resultado_reporte_cualitativo  
                    WHERE id_analito_resultado_reporte_cualitativo = '".clean($id)."'
                    LIMIT 1";
            $qryData = mysql_fetch_array(mysql_query($qry));
            $id_analito = $qryData["id_analito"];

            $qry = "SELECT id_analito_resultado_reporte_cualitativo 
                    FROM $tbl_analito_resultado_reporte_cualitativo 
                    WHERE id_analito = $id_analito AND desc_resultado_reporte_cualitativo = '".clean($value)."' 
                    LIMIT 1";
            $checkrows = mysql_num_rows(mysql_query($qry));
            mysqlException(mysql_error(), $header."_0x01_");

            if ($checkrows > 0) {
                echo '<response code="422">El resultado indicado ya existe para el mensurando seleccionado</response>';
            } else if ($value == "") {
                echo '<response code="422">Debe especificar una descripción</response>';
            } else {
                $qry = "UPDATE $tbl_analito_resultado_reporte_cualitativo 
                        SET desc_resultado_reporte_cualitativo = '".clean($value)."' 
                        WHERE id_analito_resultado_reporte_cualitativo = $id";
                mysql_query($qry);
                mysqlException(mysql_error(), $header."_0x01");
                $logQuery['UPDATE'][$uSum] = $qry;
                $uSum++;
                echo '<response code="1">1</response>';
            }
            break;

        case 3:
    // Nuevo comportamiento: ingresar puntuación manualmente
    if (!is_numeric($value)) {
        echo '<response code="422">Debe ingresar un valor numérico</response>';
        break;
    }

    $valor = floatval($value);
    $now = date('Y-m-d H:i:s');

    // Verificar si el valor ya existe en la tabla de puntuaciones
    $qryCheck = "SELECT id FROM puntuaciones WHERE valor = $valor LIMIT 1";
    $resCheck = mysql_query($qryCheck);
    mysqlException(mysql_error(), $header."_0x03_check");

    if (mysql_num_rows($resCheck) > 0) {
        // Si existe, obtener su ID
        $row = mysql_fetch_assoc($resCheck);
        $existingId = $row['id'];
    } else {
        // Insertar nueva puntuación
        $qryInsert = "INSERT INTO puntuaciones (valor, created_at, updated_at)
                      VALUES ($valor, '$now', '$now')";
        mysql_query($qryInsert);
        mysqlException(mysql_error(), $header."_0x03_insert");

        $existingId = mysql_insert_id();

        $logQuery['INSERT'][$uSum] = $qryInsert;
    }

    // Actualizar el registro original con el ID de puntuación
    $qryUpdate = "UPDATE $tbl_analito_resultado_reporte_cualitativo 
                  SET id_puntuacion = $existingId 
                  WHERE id_analito_resultado_reporte_cualitativo = $id";
    mysql_query($qryUpdate);
    mysqlException(mysql_error(), $header."_0x03_update");

    $logQuery['UPDATE'][$uSum] = $qryUpdate;
    $uSum++;

    echo '<response code="1">Valor asignado correctamente</response>';
    break;

	
		}

    break;
		
		case 'analitCualitativeTypeOfResultDeletion':

			actionRestriction_0();

			$ids = explode("|",$_POST['ids']);
			
			for ($x = 0; $x < sizeof($ids); $x++) {
				$qry = "SELECT id_analito_resultado_reporte_cualitativo FROM $tbl_analito_resultado_reporte_cualitativo WHERE id_analito_resultado_reporte_cualitativo = $ids[$x] LIMIT 0,1";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {
					$qry = "DELETE FROM $tbl_analito_resultado_reporte_cualitativo WHERE id_analito_resultado_reporte_cualitativo = $ids[$x]";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01_".$x);
					$logQuery['DELETE'][$dSum] = $qry;
					$dSum++;
	
				}
			}

			echo'<response code="1">1</response>';
			
		break;	
		case 'mediaValueEditor':

			actionRestriction_100();

			$which = $_POST['which'];
			$id = $_POST['id'];
			$value = $_POST['value'];
			$otherIds = explode("|",$_POST['otherids']);
			
			if ($otherIds[0] != "") {
				$labid = $otherIds[0];
			} else {
				$labid = "NULL";
			}
			
			if ($otherIds[1] != "") {
				$sampleid = $otherIds[1];
			} else {
				$sampleid = "NULL";
			}			
			
			if ($otherIds[2] != "") {
				$saveValueForAllConfigurations = $otherIds[2];
			} else {
				$saveValueForAllConfigurations = "NULL";
			}			
			
			if ($labid == "NULL" || $saveValueForAllConfigurations == 0) {
				$tableToEdit = $tbl_media_evaluacion;
				$tableToInsert = "(id_configuracion,media_estandar,desviacion_estandar,coeficiente_variacion,n_evaluacion,id_muestra,nivel,id_analito_resultado_reporte_cualitativo) VALUES ($id,0,0,0,0,$sampleid,0,$value)";
				$wichTable = 0;
			} else {
				$tableToEdit = $tbl_media_evaluacion_caso_especial;
				$tableToInsert = "(id_configuracion,media_estandar,desviacion_estandar,coeficiente_variacion,n_evaluacion,id_muestra,nivel,id_laboratorio,id_analito_resultado_reporte_cualitativo) VALUES ($id,0,0,0,0,$sampleid,0,$labid,$value)";
				$wichTable = 1;
			}
			
			switch ($which) {				
				case 1:
				
					if ($wichTable == 1) {
						$qry = "SELECT id_media_analito FROM $tableToEdit WHERE id_configuracion = $id AND id_muestra = $sampleid AND id_laboratorio = $labid";
					} else {
						$qry = "SELECT id_media_analito FROM $tableToEdit WHERE id_configuracion = $id AND id_muestra = $sampleid";
					}
					
					$qryRows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01");
					
					if ($qryRows > 0) {
						if ($wichTable == 1) {
							$qry = "UPDATE $tableToEdit SET id_analito_resultado_reporte_cualitativo = $value WHERE id_configuracion = $id AND id_muestra = $sampleid AND id_laboratorio = $labid";
						} else {
							$qry = "UPDATE $tableToEdit SET id_analito_resultado_reporte_cualitativo = $value WHERE id_configuracion = $id AND id_muestra = $sampleid";
						}
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;						
					} else {
						$qry = "INSERT INTO $tableToEdit $tableToInsert";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;							
					}
				
				break;	
			}
			
			echo'<response code="1"></response>';
			
		break;
		case 'saveAnalitCualitativeTypeOfResult':

			actionRestriction_101();

			$postValues_1 = clean($_POST['configid']);
			
			if ($_POST['toinsert'] == "") {
				$postValues_2 = "";
			} else {
				$postValues_2 = explode('|',$_POST['toinsert']);
			}
			if ($_POST['todelete'] == "") {
				$postValues_3 = "";
			} else {
				$postValues_3 = explode('|',$_POST['todelete']);
			}
			
			if ($postValues_2 != "") {
				for ($x = 0; $x < sizeof($postValues_2); $x++) {
					$tempValue_1 = $postValues_1;
					$tempValue_2 = $postValues_2[$x];
					
					$qry = "SELECT id_conexion FROM $tbl_configuracion_analito_resultado_reporte_cualitativo WHERE id_configuracion = $tempValue_1 AND id_analito_resultado_reporte_cualitativo = $tempValue_2";
					
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x01_".$x);	
	
					if ($checkrows == 0) {
						$qry = "INSERT INTO $tbl_configuracion_analito_resultado_reporte_cualitativo (id_configuracion,id_analito_resultado_reporte_cualitativo) VALUES ($tempValue_1,$tempValue_2)";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x02_".$x);
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;
						
					}
				}				
			}
			
			if ($postValues_3 != "") {
				for ($x = 0; $x < sizeof($postValues_3); $x++) {
					$tempValue_1 = $postValues_1;
					$tempValue_3 = $postValues_3[$x];
					
					$qry = "SELECT id_conexion FROM $tbl_configuracion_analito_resultado_reporte_cualitativo WHERE id_configuracion = $tempValue_1 AND id_analito_resultado_reporte_cualitativo = $tempValue_3";
					
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x03_".$x);	
	
					if ($checkrows > 0) {
						$qry = "DELETE FROM $tbl_configuracion_analito_resultado_reporte_cualitativo WHERE id_configuracion = $tempValue_1 AND id_analito_resultado_reporte_cualitativo = $tempValue_3";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x04_".$x);
						$logQuery['DELETE'][$dSum] = $qry;
						$dSum++;
						
					}
				}				
			}

			echo '<response code="1">';
			echo 1;
			echo '</response>';			
			
		break;
		case 'saveGlobalUnit':
		
			actionRestriction_101();
		
			$postValues_1 = explode("|",clean($_POST['ids']));
			$postValues_2 = explode("|",clean($_POST['globalunits']));
			$postValues_3 = explode("|",clean($_POST['conversionfactors']));
			
			for ($x = 0; $x < sizeof($postValues_1); $x++) {
			
				$tempValue_1 = explode("-",$postValues_1[$x]);
				$tempValue_2 = $postValues_2[$x];
				$tempValue_3 = $postValues_3[$x];
				
				$connectionId = $tempValue_1[0];
				$analitId = $tempValue_1[1];
				$unitId = $tempValue_1[2];
				
				$qry = "SELECT id_conexion FROM $tbl_unidad_global_analito WHERE id_conexion = $connectionId";
				$checkrows = mysql_num_rows(mysql_query($qry));
				mysqlException(mysql_error(),$header."_0x01");
				
				if ($checkrows > 0) {
					
					$qry = "UPDATE $tbl_unidad_global_analito SET nombre_unidad_global = '$tempValue_2', factor_conversion = '$tempValue_3' WHERE id_conexion = $connectionId";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					
					
				} else {
					
					$qry = "SELECT id_conexion FROM $tbl_unidad_global_analito WHERE id_unidad = $unitId AND id_analito = $analitId LIMIT 0,1";
					$checkrows = mysql_num_rows(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x02");					
					
					if ($checkrows > 0) {
						
						$qry = "UPDATE $tbl_unidad_global_analito SET nombre_unidad_global = '$tempValue_2', factor_conversion = '$tempValue_3' WHERE id_unidad = $unitId AND id_analito = $analitId";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x03");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;							
						
					} else {
						
						$qry = "INSERT INTO $tbl_unidad_global_analito (id_analito,id_unidad,nombre_unidad_global,factor_conversion) VALUES ($analitId,$unitId,'$tempValue_2','$tempValue_3')";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x04");
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;
						
					}
					
				}
		
			}
		
			echo '<response code="1">';
			echo 1;
			echo '</response>';			
		
		break;
				
		default:
			echo'<response code="0">PHP dataChangeHandler error: id "'.$header.'" not found</response>';
		break;
	}
	
	if (sizeof($logQuery['INSERT']) > 0) {
		for ($y = 0; $y < sizeof($logQuery['INSERT']); $y++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['INSERT'][$y]);
			$qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Registro de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),$header."_LGQ_0x01_".$y);
		}
	}
	
	if (sizeof($logQuery['UPDATE']) > 0) {
		for ($y = 0; $y < sizeof($logQuery['UPDATE']); $y++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['UPDATE'][$y]);
			$qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Actualización de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),$header."_LGQ_0x02_".$y);			
		}		
	}
	
	if (sizeof($logQuery['DELETE']) > 0) {
		for ($y = 0; $y < sizeof($logQuery['DELETE']); $y++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['DELETE'][$y]);
			$qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Remoción de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),$header."_LGQ_0x03_".$y);			
		}		
	}
	
	mysql_close($con);
	exit;
?>