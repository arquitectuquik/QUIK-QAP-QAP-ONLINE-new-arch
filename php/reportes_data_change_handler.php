<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	session_start();

	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";

	include_once"verifica_sesion.php";	
	
	actionRestriction_4_only();
	error_reporting(0);
	
	$header = $_POST['header'];
	
	switch ($header) {
		case 'documentRegistry':

			actionRestriction_4_only();

			$postValues_1 = $_POST['clientid'];
			$postValues_2 = $_POST['clienthqid'];
			$postValues_3 = $_FILES['documentfiles'];
			$postValues_4 = $_POST['item'];
			$postValues_5 = $_POST['fileassignedmonth'];
			$postValues_6 = $_POST['fileassignedyear'];
			
			$tempValue_1 = mysql_real_escape_string(stripcslashes(clean(encryptControl('decrypt',$postValues_1,$_SESSION['qap_userId']))));
			$tempValue_2 = mysql_real_escape_string(stripcslashes(clean(encryptControl('decrypt',$postValues_2,$_SESSION['qap_userId']))));
			$tempValue_5 = mysql_real_escape_string(stripcslashes(clean($postValues_5)));
			$tempValue_6 = mysql_real_escape_string(stripcslashes(clean($postValues_6)));
			
			$maxFileSize = 104857600;
			
			if (isset($postValues_3) && $postValues_3["error"]== UPLOAD_ERR_OK) {
		
				$uploadDirectory = '../reportes/asesorias_quikscc/';
		
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
				
				//--SQL section--//
				
				$qry = "SELECT $tbl_archivo_asesoria_sede.id_archivo FROM $tbl_archivo_asesoria_sede WHERE nombre_archivo = '$file_Name' AND extencion_archivo = '$file_Ext' AND id_sede = '$tempValue_2'";
				
				$qryRows = mysql_num_rows(mysql_query($qry));
				mysqlException(mysql_error(),$header."_0x01");
				
				if ($qryRows > 0) {
					echo('<response code="0" item="'.$postValues_4.'">El archivo "'.$postValues_3['name'].'" ya existe en la base de datos.</response>');
					mysql_close($con);
					exit;			
				} else {
					
					$indexName = md5(uniqid(rand(), true));
					
					//-- file upload --//
					
					$newFileName = $indexName.".".$file_Ext;
				
					if(move_uploaded_file($postValues_3['tmp_name'], $uploadDirectory.$newFileName )) {
						
						$qry = "INSERT INTO $tbl_archivo_asesoria_sede (id_sede,nombre_archivo,extencion_archivo,activo,index_archivo,fecha_carga,fecha_asignada) VALUES ('$tempValue_2','$file_Name','$file_Ext',1,'$indexName','$logDate','".$tempValue_6."-".$tempValue_5."-01')";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['INSERT'][$iSum] = $qry;
						$iSum++;						
						
						echo('<response code="1" item="'.$postValues_4.'">Carga exitosa</response>');
						
					} else {
						
						echo('<response code="0" item="'.$postValues_4.'">Error al cargar el archivo "'.$postValues_3['name'].'".</response>');	
						
					}			
					
					//-- --//					
					
				}
				
				//-- --//
				
			} else {
				echo('<response code="0" item="'.$postValues_4.'">Algo salió mal con la carga. Por favor verifique que "upload_max_filesize" esté correctamente configurado en su php.ini.</response>');
				mysql_close($con);
				exit;		
			}			
			
		break;
		case 'documentValueEditor':

			actionRestriction_4_only();

			$which = $_POST['which'];
			$id = encryptControl('decrypt',$_POST['id'],$_SESSION['qap_userId']);
			$value = $_POST['value'];
			
			switch ($which) {
				case 2:
					$qry = "UPDATE $tbl_archivo_asesoria_sede SET nombre_archivo = '".clean($value)."' WHERE id_archivo = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x01");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;
				case 4:
					$qry = "UPDATE $tbl_archivo_asesoria_sede SET activo = ".clean($value)." WHERE id_archivo = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x02");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;
				case 5:
					$qry = "UPDATE $tbl_archivo_asesoria_sede SET fecha_asignada = '".clean($value)."' WHERE id_archivo = $id";
					mysql_query($qry);
					mysqlException(mysql_error(),$header."_0x03");
					$logQuery['UPDATE'][$uSum] = $qry;
					$uSum++;
				
				break;					
			}
			
			echo'<response code="1"></response>';
			
		break;
		case 'documentDeletion':

			actionRestriction_4_only();

			$id = encryptControl('decrypt',$_POST['ids'],$_SESSION['qap_userId']);
			
			$qry = "SELECT id_archivo,index_archivo,extencion_archivo FROM $tbl_archivo_asesoria_sede WHERE id_archivo = $id LIMIT 0,1";
			
			$checkrows = mysql_num_rows(mysql_query($qry));
			$qryData = mysql_fetch_array(mysql_query($qry));
			
			if ($checkrows > 0) {
				
				$path = '../reportes/asesorias_quikscc/'.$qryData['index_archivo'].'.'.$qryData['extencion_archivo'];
				
				if (file_exists($path)) {
					unlink($path);
					if (file_exists($path)) {
						$error++;
					} else {
						$qry = "DELETE FROM $tbl_archivo_asesoria_sede WHERE id_archivo = $id";
						mysql_query($qry);
						mysqlException(mysql_error(),$header."_0x01");
						$logQuery['DELETE'][$dSum] = $qry;
						$dSum++;					
					}				
				}
			}

			echo'<response code="1">1</response>';
			
		break;		
		default:
			echo'<response code="0">PHP dataChangeHandler error: id "'.$header.'" not found</response>';
		break;		
	}	
	
	if (sizeof($logQuery['INSERT']) > 0) {
		for ($x = 0; $x < sizeof($logQuery['INSERT']); $x++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['INSERT'][$x]);
			$qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ('$userId','$logDate','$logHour','Registro de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),"001_".$x);
		}
	}
	
	if (sizeof($logQuery['UPDATE']) > 0) {
		for ($x = 0; $x < sizeof($logQuery['UPDATE']); $x++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['UPDATE'][$x]);
			$qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ('$userId','$logDate','$logHour','Actualización de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),"002_".$x);			
		}		
	}
	
	if (sizeof($logQuery['DELETE']) > 0) {
		for ($x = 0; $x < sizeof($logQuery['DELETE']); $x++) {
			$tempLogQuery = mysql_real_escape_string($logQuery['DELETE'][$x]);
			$qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ('$userId','$logDate','$logHour','Remoción de información','$tempLogQuery')";
			mysql_query($qry);
			mysqlException(mysql_error(),"003_".$x);			
		}		
	}	
	
	mysql_close($con);
	exit;
?>	