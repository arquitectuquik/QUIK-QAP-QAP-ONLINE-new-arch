<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	session_start();
	include_once"verifica_sesion.php";
	include_once "correo/envioCorreoLC.php";
	include_once "correo/enviarCorreoCambioAnalito.php";
	userRestriction();
	
	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";
	
	$header = mysql_real_escape_string(stripslashes(clean($_POST['header'])));
	
	switch ($header) {
		case 'assignedLabAnalitValueEditor':
			$which = $_POST['which'];
			$id = encryptControl('decrypt',(mysql_real_escape_string(stripslashes($_POST['id']))),$_SESSION['qap_token']);
			$value = $_POST['value'];

			switch ($which) {			
				case 9: // Estado

					$qry = "UPDATE configuracion_laboratorio_analito 
						SET activo = $value 
					WHERE id_configuracion = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x06");

					$qry = "SELECT 
							configuracion_laboratorio_analito.id_configuracion,
							laboratorio.id_laboratorio,
							programa.id_programa,
							nombre_analito,
							nombre_analizador,
							nombre_metodologia,
							nombre_reactivo,
							nombre_unidad,
							valor_gen_vitros,
							nombre_material,
							activo 
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
						where configuracion_laboratorio_analito.id_configuracion = $id";
					$qryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0125");
					
					$id_laboratorio_log = $qryData["id_laboratorio"];
					$id_programa_log = $qryData["id_programa"];
					$nombre_analito_log = $qryData["nombre_analito"];
					$nombre_analizador_log = $qryData["nombre_analizador"];
					$nombre_metodologia_log = $qryData["nombre_metodologia"];
					$nombre_reactivo_log = $qryData["nombre_reactivo"];
					$nombre_unidad_log = $qryData["nombre_unidad"];
					$nivel_generacion_log = $qryData["valor_gen_vitros"];
					$nombre_material_log = $qryData["nombre_material"];
					$fechaAct = Date("Y-m-d h:i:s");

					$qry = "SELECT nombre_usuario from usuario where id_usuario = '".$_SESSION['qap_userId']."'";
					$qryArray = mysql_query($qry);
					mysqlException(mysql_error(),"_02correo");
					$qryData = mysql_fetch_array($qryArray);
					$nombre_usuario = $qryData["nombre_usuario"];

					if($value == 1){ // Activacion
						
						$cadenaResumen = "Se Activa el mensurando $nombre_analito_log, analizador: $nombre_analizador_log, generación: $nivel_generacion_log, metodología: $nombre_metodologia_log, reactivo: $nombre_reactivo_log, unidad: $nombre_unidad_log, material: $nombre_material_log";
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
								VALUES ($id_laboratorio_log, $id_programa_log, '$fechaAct', '".$nombre_usuario."', 'Activación de mensurando', '".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");
						enviarCorreoCambioAnalito('Activación de mensurando', $id);

					} else if($value == 0) { // Deshabilitación
						$cadenaResumen = "Se deshabilita el mensurando $nombre_analito_log, analizador: $nombre_analizador_log, generación: $nivel_generacion_log, metodología: $nombre_metodologia_log, reactivo: $nombre_reactivo_log, unidad: $nombre_unidad_log, material: $nombre_material_log";
						$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
						VALUES ($id_laboratorio_log, $id_programa_log, '$fechaAct', '".$nombre_usuario."', 'Deshabilitación de mensurando','".$cadenaResumen."')"; 
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x25");
						enviarCorreoCambioAnalito('Deshabilitación de mensurando', $id);
					}
					echo'<response code="1">1</response>';	
				break;				
			}
			
		break;	

		case 'saveAnalitCualitativeTypeOfResult':
			
			$postValues_1 = encryptControl('decrypt',clean($_POST['configid']),$_SESSION['qap_token']);
			
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

		case 'labAnalitAssignation':
			
			actionRestriction_103();
			
			$postValues_1 = encryptControl('decrypt',(mysql_real_escape_string(stripslashes(clean($_POST['labid'])))),$_SESSION['qap_token']);
			$postValues_2 = mysql_real_escape_string(stripslashes(clean($_POST['programid'])));
			$postValues_3 = mysql_real_escape_string(stripslashes(clean($_POST['analitid'])));
			$postValues_4 = mysql_real_escape_string(stripslashes(clean($_POST['analyzerid'])));
			$postValues_5 = mysql_real_escape_string(stripslashes(clean($_POST['methodid'])));
			$postValues_6 = mysql_real_escape_string(stripslashes(clean($_POST['reactiveid'])));
			$postValues_7 = mysql_real_escape_string(stripslashes(clean($_POST['unitid'])));
			$postValues_8 = mysql_real_escape_string(stripslashes(clean($_POST['vitrosgenid'])));
			$postValues_9 = mysql_real_escape_string(stripslashes(clean($_POST['materialid'])));
			
			$insertedValues = 0;
			
			$tempValue_1 = $postValues_1;
			$tempValue_2 = $postValues_2;
			$tempValue_3 = $postValues_3;
			$tempValue_4 = $postValues_4;
			$tempValue_5 = $postValues_5;
			$tempValue_6 = $postValues_6;
			$tempValue_7 = $postValues_7;
			$tempValue_8 = $postValues_8;
			$tempValue_9 = $postValues_9;
			
			$qry = "SELECT id_configuracion 
				FROM configuracion_laboratorio_analito 
				WHERE id_laboratorio = $tempValue_1 
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

			if ($checkrows == 0) {
				$qry = "INSERT INTO configuracion_laboratorio_analito (
						id_laboratorio,
						id_programa,
						id_analito,
						id_analizador,
						id_metodologia,
						id_reactivo,
						id_unidad,
						id_gen_vitros,
						id_material,
						activo)
					VALUES (
						$tempValue_1,
						$tempValue_2,
						$tempValue_3,
						$tempValue_4,
						$tempValue_5,
						$tempValue_6,
						$tempValue_7,
						$tempValue_8,
						$tempValue_9,
						1)";
				
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x02".$qry);
				$iSum++;				
				$insertedValues++;


				// Ulitmo ID insertado
				$qry = "SELECT last_insert_id() as ultimo";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),"_01");
				$id = $qryData["ultimo"];
				
				// Insertar un log
				$fechaAct = Date("Y-m-d h:i:s");
				$qry = "SELECT nombre_analito FROM analito where id_analito = $postValues_3";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_analito_log = $qryData['nombre_analito'];

				$qry = "SELECT nombre_analizador FROM analizador where id_analizador = $postValues_4";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_analizador_log = $qryData['nombre_analizador'];

				// Generacion
				$qry = "SELECT valor_gen_vitros FROM gen_vitros where id_gen_vitros = $postValues_8";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nivel_generacion_log = $qryData['valor_gen_vitros'];

				// Metodologia
				$qry = "SELECT nombre_metodologia FROM metodologia where id_metodologia = $postValues_5";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_metodologia_log = $qryData['nombre_metodologia'];

				// Reactivo
				$qry = "SELECT nombre_reactivo FROM reactivo where id_reactivo = $postValues_6";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_reactivo_log = $qryData['nombre_reactivo'];

				// Unidad
				$qry = "SELECT nombre_unidad FROM unidad where id_unidad = $postValues_7";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_unidad_log = $qryData['nombre_unidad'];

				// Material
				$qry = "SELECT nombre_material FROM material where id_material = $postValues_9";
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01");			
				$nombre_material_log = $qryData['nombre_material'];

				// Nombre de usuario
				$qry = "SELECT nombre_usuario from usuario where id_usuario = '".$_SESSION['qap_userId']."'";
				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(),"_02correo");
				$qryData = mysql_fetch_array($qryArray);
				$nombre_usuario = $qryData["nombre_usuario"];

				$cadenaResumen = "Se crea $nombre_analito_log, analizador: $nombre_analizador_log, generación: $nivel_generacion_log, metodología: $nombre_metodologia_log, reactivo: $nombre_reactivo_log, unidad: $nombre_unidad_log, material: $nombre_material_log";
				$qry = "INSERT INTO log_configuracion_analito(id_laboratorio,id_programa,fecha,nombre_usuario,titulo,resumen) 
						VALUES ($postValues_1, $postValues_2, '$fechaAct', '".$nombre_usuario."', 'Nuevo mensurando','".$cadenaResumen."')"; 
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x25");

				enviarCorreoCambioAnalito('Nuevo mensurando', $id);
			}

			echo '<response code="1">';
			echo $insertedValues;
			echo '</response>';			
			
		break;

		

		case 'assignedLabAnalitDeletion':

			actionRestriction_103();
		
			$id = encryptControl('decrypt',(mysql_real_escape_string(stripslashes($_POST['ids']))),$_SESSION['qap_token']);
			
			$qry = "SELECT id_configuracion FROM configuracion_laboratorio_analito WHERE id_configuracion = $id LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			
			if ($checkrows > 0) {
				$qry = "DELETE FROM configuracion_laboratorio_analito WHERE id_configuracion = $id";
				mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x01");
				$logQuery['DELETE'][$dSum] = $qry;
				$dSum++;
	
			}

			echo'<response code="1">1</response>';
			
		break;
		case 'saveAnalitResults':
		
			actionRestriction_103();
			$postValues_1 = explode("|",mysql_real_escape_string(stripslashes(clean($_POST['ids']))));
			$postValues_2 = mysql_real_escape_string(stripslashes(clean($_POST['sampleid'])));
			$postValues_3 = explode("|",mysql_real_escape_string(stripslashes(clean($_POST['resuts']))));
			$postValues_4 = explode("|",mysql_real_escape_string(stripslashes(clean($_POST['comments']))));
			$postValues_5 = mysql_real_escape_string(stripslashes(clean($_POST['tempDate'])));
			$postValues_6 = mysql_real_escape_string(stripslashes(clean($_POST['typeofprogram'])));
			$insertedValues = 0;
			$id_config = 0;
			
			for ($x = 0; $x < sizeof($postValues_1); $x++) {
			
				$id_config = $tempValue_1; 
				$tempValue_1 = encryptControl('decrypt',$postValues_1[$x],$_SESSION['qap_token']);
				$tempValue_2 = encryptControl('decrypt',$postValues_2,$_SESSION['qap_token']);
				$tempValue_3 = str_replace(",",".",$postValues_3[$x]);
				$tempValue_4 = $postValues_4[$x];
				
				if ($postValues_5 == "NULL" || $_POST['tempDate'] == "") {
					$tempValue_5 = $logDate;
				} else {
					$tempValue_5 = $postValues_5;
				}
				
				$tempValue_6 = $postValues_6;
				
				$lvl = array(1,2,3);
				
				$qry = "SELECT id_configuracion FROM resultado WHERE id_configuracion = $tempValue_1 AND id_muestra = $tempValue_2 LIMIT 0,1";
				
				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(),$header."_0x01");			
				
				$checkrows = mysql_num_rows($qryArray);
				
				$qryData = mysql_fetch_array($qryArray);
				
				if ($checkrows == 0) {
					
					if ($tempValue_6 == 1) {
						$qry = "INSERT INTO resultado (id_muestra,id_configuracion,fecha_resultado,valor_resultado,observacion_resultado,id_usuario,editado,revalorado,id_analito_resultado_reporte_cualitativo) VALUES ($tempValue_2,$tempValue_1,'$tempValue_5','$tempValue_3','$tempValue_4',".$_SESSION['qap_userId'].",0,0,null)";
					} else if ($tempValue_6 == 2) {
						$qry = "INSERT INTO resultado (id_muestra,id_configuracion,fecha_resultado,valor_resultado,observacion_resultado,id_usuario,editado,revalorado,id_analito_resultado_reporte_cualitativo) VALUES ($tempValue_2,$tempValue_1,'$tempValue_5','N/A','$tempValue_4',".$_SESSION['qap_userId'].",0,0,$tempValue_3)";
					}
				
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['INSERT'][$iSum] = $qry;
					$iSum++;					
				
					$qry = "SELECT laboratorio.id_laboratorio FROM laboratorio INNER JOIN configuracion_laboratorio_analito ON laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio WHERE configuracion_laboratorio_analito.id_configuracion = $tempValue_1";
						
					$innerQryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x04");
					
					$qry = "SELECT id_fecha FROM fecha_reporte_muestra WHERE id_laboratorio = ".$innerQryData['id_laboratorio']." AND id_muestra = $tempValue_2";
					$innerCheckRows = mysql_num_rows(mysql_query($qry));
					
					if ($innerCheckRows == 0) {
						$qry = "INSERT INTO fecha_reporte_muestra (id_laboratorio,id_muestra,fecha_reporte) VALUES (".$innerQryData['id_laboratorio'].",$tempValue_2,'$tempValue_5')";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x05");
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;					
					} else {
						$qry = "UPDATE fecha_reporte_muestra SET fecha_reporte = '$tempValue_5' WHERE id_laboratorio = ".$innerQryData['id_laboratorio']." AND id_muestra = $tempValue_2";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x06");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;						
					}
				
				} else {
					
					if ($tempValue_6 == 1) {
						$qry = "UPDATE resultado SET valor_resultado = '$tempValue_3',fecha_resultado = '$tempValue_5', observacion_resultado = '$tempValue_4', editado = 1, revalorado = 0 WHERE id_configuracion = ".$qryData['id_configuracion']." AND id_muestra = $tempValue_2";
					} else if ($tempValue_6 == 2) {
						$qry = "UPDATE resultado SET id_analito_resultado_reporte_cualitativo = $tempValue_3,fecha_resultado = '$tempValue_5', observacion_resultado = '$tempValue_4', editado = 1, revalorado = 0 WHERE id_configuracion = ".$qryData['id_configuracion']." AND id_muestra = $tempValue_2";
					}

					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x03");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
					
					$qry = "SELECT laboratorio.id_laboratorio FROM laboratorio INNER JOIN configuracion_laboratorio_analito ON laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio WHERE configuracion_laboratorio_analito.id_configuracion = $tempValue_1";
						
					$innerQryData = mysql_fetch_array(mysql_query($qry));
					mysqlException(mysql_error(),$header."_0x07");
					
					$qry = "SELECT id_fecha FROM fecha_reporte_muestra WHERE id_laboratorio = ".$innerQryData['id_laboratorio']." AND id_muestra = $tempValue_2";
					$innerCheckRows = mysql_num_rows(mysql_query($qry));
					
					if ($innerCheckRows == 0) {
						$qry = "INSERT INTO fecha_reporte_muestra (id_laboratorio,id_muestra,fecha_reporte) VALUES (".$innerQryData['id_laboratorio'].",$tempValue_2,'$tempValue_5')";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x08");
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;					
					} else {
						$qry = "UPDATE fecha_reporte_muestra SET fecha_reporte = '$tempValue_5' WHERE id_laboratorio = ".$innerQryData['id_laboratorio']." AND id_muestra = $tempValue_2";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x09");
						$logQuery['UPDATE'][$uSum] = $qry;
						$uSum++;						
					}
				}	

				$insertedValues++;
			}

			$id_usuario = $_SESSION['qap_userId'];
			$fecha_actual = date("Y-m-d h:i:s");
			$id_muestra = mysql_real_escape_string(stripslashes(clean($_POST['sampleid'])));
			$id_muestra = encryptControl('decrypt',$id_muestra,$_SESSION['qap_token']);

			$qryLaboratory = "SELECT 
						laboratorio.id_laboratorio 
					FROM laboratorio 
					INNER JOIN configuracion_laboratorio_analito ON laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio 
					WHERE configuracion_laboratorio_analito.id_configuracion = $id_config";
			$innerQryDataLaboratory = mysql_fetch_array(mysql_query($qryLaboratory));
			mysqlException(mysql_error(),$header."_0x04");
			$id_laboratorio = $innerQryDataLaboratory['id_laboratorio'];
			
			enviarCorreoLC($id_laboratorio,$id_usuario,$id_muestra,$fecha_actual);
			
			echo '<response code="1">';
			echo $insertedValues;
			echo '</response>';			
		
		break;		
	}
	
	if (sizeof($logQuery['INSERT']) > 0) {
		for ($y = 0; $y < sizeof($logQuery['INSERT']); $y++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['INSERT'][$y]);
			$qry = "INSERT INTO log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Registro de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),$header."_LGQ_0x01_".$y);
		}
	}
	
	if (sizeof($logQuery['UPDATE']) > 0) {
		for ($y = 0; $y < sizeof($logQuery['UPDATE']); $y++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['UPDATE'][$y]);
			$qry = "INSERT INTO log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Actualización de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),$header."_LGQ_0x02_".$y);			
		}		
	}
	
	if (sizeof($logQuery['DELETE']) > 0) {
		for ($y = 0; $y < sizeof($logQuery['DELETE']); $y++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['DELETE'][$y]);
			$qry = "INSERT INTO log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Remoción de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),$header."_LGQ_0x03_".$y);			
		}		
	}
	
	mysql_close($con);
	exit;
?>