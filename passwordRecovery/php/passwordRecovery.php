<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";	
	
	date_default_timezone_set("America/Bogota");		
	ini_set('max_execution_time', 300);		
	
	$header = $_POST['header'];
	
	switch ($header) {
		case 'checkMember':		
			
			$sitevalue = strtolower(stripcslashes(clean($_POST['sitevalue'])));			
			
			checkStringSize($sitevalue);
			checkSiteName($sitevalue);

			switch ($sitevalue) {
				case 'qap':
					
					//para trabajar en local
					// $dataBaseInfo = array(
					// 	"db_hostname"=>"localhost"
					// 	,"db_username"=>"panequik_qap"
					// 	,"db_password"=>"QuikSAS2019*"
					// 	,"db_name"=>"panequik_qaponline_v4"
					// );
					
					// en servidor
					$dataBaseInfo = array(
						"db_hostname"=>"localhost"
						,"db_username"=>"quikappspane_qaponline_user"
						,"db_password"=>"qaponline_v1"
						,"db_name"=>"quikappspane_qaponline_v1"
					);
					// para trabajar local con xampp
					// $dataBaseInfo = array(
					// 	"db_hostname"=>"localhost"
					// 	,"db_username"=>"root"
					// 	,"db_password"=>""
					// 	,"db_name"=>"u669796078_panequik_qap"
					// );
					//define the user table info
					$tableInfo = array(
						"tbl_name"=>"usuario"
						,"tbl_idColumnName"=>"id_usuario"
						,"tbl_userColumnName"=>"nombre_usuario"
						,"tbl_passwordColumnName"=>"contrasena"
						,"tbl_userEmailColumnName"=>"email_usuario"
					);
					
				break;
				default:
					echo'<response code="0">No se ha encontrado el sitio para el cual cambiar la contraseña, cierre la página e intente nuevamente</response>';
					exit;
				break;
			}									
			
			//start the connection to the sql database
			$con = mysql_connect($dataBaseInfo["db_hostname"],$dataBaseInfo["db_username"],$dataBaseInfo["db_password"]);
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x01");
			mysql_select_db($dataBaseInfo["db_name"],$con);
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x02");	
			
			//define the queries to check if the needed coulmns exist
			$qry_checkInfo = array(
				0=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_userEmailColumnName']."'"
			);	
			
			//define the queries to create the needed columns if they don't exist
			$qry_alterInfo = array(
				0=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_userEmailColumnName']." VARCHAR(255) NULL"
			);
			
			//check for the needed columns and add them if they don't exist
			for ($x = 0; $x < sizeof($qry_checkInfo); $x++) {
				$qry = $qry_checkInfo[$x];
				$qryRows = mysql_num_rows(mysql_query($qry));
				mysqlException(mysql_error(),$header."-".$sitevalue."-0x03");
				
				if ($qryRows == 0) {
					$qry = $qry_alterInfo[$x];
					mysql_query($qry);
					mysqlException(mysql_error(),$header."-".$sitevalue."-0x04");
				}
			}			
			
			$membervalue = mysql_real_escape_string(stripcslashes(clean($_POST['membervalue'])));
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x03");
			
			$qry = "SELECT ".$tableInfo['tbl_idColumnName'].",".$tableInfo['tbl_userEmailColumnName'].",".$tableInfo['tbl_userColumnName']." FROM ".$tableInfo['tbl_name']." WHERE ".$tableInfo['tbl_userEmailColumnName']." = '$membervalue' OR ".$tableInfo['tbl_userColumnName']." = '$membervalue'";
			
			$qryArray = mysql_query($qry);
			$qryArray2 = mysql_query($qry);
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x04");
			$qryData = mysql_fetch_array($qryArray);
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x05");
			$qryNumRows = mysql_num_rows($qryArray);
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x06");
			
			if ($qryNumRows > 0) {
				
				$hyperlinks = "";
				$tempCounter = 0;

				$sitevalueEncrypted = encryptControl("encrypt",$sitevalue,stringToSalt($sitevalue));
				
				while ($innerQryData_1 = mysql_fetch_array($qryArray2)) {
					
					$userName = $innerQryData_1[$tableInfo['tbl_userColumnName']];
					$userId = encryptControl("encrypt",$innerQryData_1[$tableInfo['tbl_idColumnName']],stringToSalt($sitevalueEncrypted));
					
					$passwordRestUrl = "https://qaponline.quik.com.co/passwordRecovery/passwordForm.php?header=resetMemberPassword&site=$sitevalue&siteCheckSum=$sitevalueEncrypted&key=".$userId;	
					
					$hyperlinks .= "<a href='$passwordRestUrl'>Restablecer contraseña</a> para usuario <b>$userName</b><br/>";
					
				}		
				
				$userEmail = $qryData[$tableInfo['tbl_userEmailColumnName']];
				
				if (is_null($userEmail)) {
					
					echo '<response code="1">2</response>';
					
				} else {

					require_once("PHPMailer/PHPMailerAutoload.php");
					
					$mail = new PHPMailer(true);
					$mail->SMTPDebug = 0;
					$mail->Port = 587;
					$mail->Host = "stmp.office365.com";
					
					$mail->SMTPAuth = true;                  
					$mail->SMTPSecure = "tls";
					
					$mail->Username = "no-reply@quik.com.co";
					$mail->Password = "Quik2019*";
					
				    $mail->setFrom('no-reply@quik.com.co', 'QAP Online | Quik S.A.S.');

					$mail->AddAddress($userEmail, "");
					$mail->CharSet =  "utf-8";
				
					$mail->Subject = "Restablecer contraseña QAP Online";
					$mail->IsHTML(true);
					$mail->Body = "<p>Estimado usuario:</p><p>Usted ha solicitado el restablecimiento de su contraseña en la aplicación de software <b>QAP Online</b> de Quik S.A.S., para ingresar una nueva contraseña haga clic en el siguiente enlace:</p>$hyperlinks<br/><p><b>Por favor tenga en cuenta que:</b><ul><li>Debe ingresar una contraseña que contenga como mínimo 8 caracteres.</li><li>Debe ingresar una contraseña que contenga números y letras.</li><li>Debe ingresar una contraseña que contenga al menos un caracter en mayuscula.</li><li>Debe ingresar una contraseña que contenga al menos un caracter especial.</li></ul><br/><p>**********************NO RESPONDER - Mensaje Generado Automáticamente**********************</p><p>Este correo es únicamente informativo y es de uso exclusivo del destinatario(a), puede contener información privilegiada y/o confidencial. Si no es usted el destinatario(a) deberá borrarlo inmediatamente. Queda notificado que el mal uso, divulgación no autorizada, alteración y/o  modificación malintencionada sobre este mensaje y sus anexos quedan estrictamente prohibidos y pueden ser legalmente sancionados. -Quik S.A.S.  no asume ninguna responsabilidad por estas circunstancias-</p><br/><br/><table border='0' cellspacing='0' cellpadding='0' style='border-collapse:collapse'><tbody><tr><td width='293' valign='top' style='width:219.75pt; border:none; border-right:solid #1C50A4 1.0pt; padding:0cm 5.4pt 0cm 5.4pt'><p ><b><span style='font-size: 10pt; font-family: Arial, sans-serif, serif, EmojiFont; color: rgb(28, 80, 164);'>Arquitectura de la infomación</span></b></p><p ><b><span style='font-size: 10pt; font-family: Arial, sans-serif, serif, EmojiFont; color: rgb(166, 166, 166);'>Soporte técnico Quik S.A.S.</span></b></p><p ><b><span style='font-size: 10pt; font-family: Arial, sans-serif, serif, EmojiFont; color: rgb(28, 80, 164);'>arquitectura.informatica@quik.com.co</span></b></p><p><b><span style='font-size: 10pt; font-family: Calibri, sans-serif, serif, EmojiFont;'></span></b></p><p ><b><i><span lang='ES' style='font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont; color: black;'>“Contact Center”:</span></i></b><b><span lang='ES' style='font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont; color: black;'> </span></b><span lang='ES' style='font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont; color: black;'>57+1 2229151 – 318 2711649</span></p><p ><b><span lang='ES' style='font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont; color: black;'>Línea Nacional:</span></b><span lang='ES' style='font-size: 9pt; font-family: Arial, sans-serif, serif, EmojiFont; color: black;'> 01 8000 413&nbsp;613</span></p><p ><b><span style='font-size: 10pt; font-family: Calibri, sans-serif, serif, EmojiFont;'>localhost</span></b><b><span style='font-size: 12pt; color: rgb(28, 80, 164); font-family: Calibri, sans-serif, serif, EmojiFont;'></span></b></p></td><td width='211' style='width:158.4pt; border:none; padding:0cm 5.4pt 0cm 5.4pt'><p ><img src='https://quik.com.co/images/qlogo_email.png' border='0' width='153' height='78' style='cursor: pointer;'><span style='font-size: 12pt; font-family: Calibri, sans-serif, serif, EmojiFont;'></span></p></td></tr></tbody></table>";
					
					if($mail->Send()) {
						
						echo '<response code="1">1|'.$userEmail.'</response>';
						
					} else {
						
						echo '<response code="0">Se ha encontrado el siguiente error enviando el correo electronico: '.$mail->ErrorInfo.'</response>';
					}							
				}				
				
			} else {
				
				echo'<response code="1">0</response>';
			}
			
		break;	
		case 'changePassword':
		
			$serverDateInfo = getdate();
			$logDate = $serverDateInfo['year']."-".$serverDateInfo['mon']."-".$serverDateInfo['mday'];
			$logHour = $serverDateInfo['hours'].":".$serverDateInfo['minutes'].":".$serverDateInfo['seconds'];					
		
			$sitevalue = strtolower(stripcslashes(clean($_POST['sitevalue'])));			
			
			checkStringSize($sitevalue);
			checkSiteName($sitevalue);

			switch ($sitevalue) {
				case 'qap':
					
					// en xampp
					// $dataBaseInfo = array(
					// 	"db_hostname"=>"localhost"
					// 	,"db_username"=>"root"
					// 	,"db_password"=>""
					// 	,"db_name"=>"u669796078_panequik_qap"
					// );
					//para trabajar en servidor
					$dataBaseInfo = array(
						"db_hostname"=>"localhost"
						,"db_username"=>"quikappspane_qaponline_user"
						,"db_password"=>"qaponline_v1"
						,"db_name"=>"quikappspane_qaponline_v1"
					);
					$db_host = "localhost";
					//define the user table info
					$tableInfo = array(
						"tbl_name"=>"usuario"
						,"tbl_idColumnName"=>"id_usuario"
						,"tbl_userColumnName"=>"nombre_usuario"
						,"tbl_passwordColumnName"=>"contrasena"
						,"tbl_dateColumnName"=>"passwordchange_lastupdateddate"
						,"tbl_hourColumnName"=>"passwordchange_lastupdatedhour"
						,"tbl_ipColumnName"=>"passwordchange_lastupdatedip"
						,"tbl_browserColumnName"=>"passwordchange_lastupdatedbrowser"						
						,"tbl_userEmailColumnName"=>"email_usuario"
					);
					
				break;
				default:
					echo'<response code="0">No se ha encontrado el sitio para el cual cambiar la contraseña, cierre la página e intente nuevamente</response>';
					exit;
				break;
			}
			
			//start the connection to the sql database
			$con = mysql_connect($dataBaseInfo["db_hostname"],$dataBaseInfo["db_username"],$dataBaseInfo["db_password"]);
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x01");
			mysql_select_db($dataBaseInfo["db_name"],$con);
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x02");
			
			//define the queries to check if the needed coulmns exist
			$qry_checkInfo = array(
				0=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_dateColumnName']."'"
				,1=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_hourColumnName']."'"
				,2=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_ipColumnName']."'"
				,3=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_browserColumnName']."'"
			);	
			
			//define the queries to create the needed columns if they don't exist
			$qry_alterInfo = array(
				0=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_dateColumnName']." DATE NULL"
				,1=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_hourColumnName']." TIME NULL"
				,2=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_ipColumnName']." CHAR(255) NULL"
				,3=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_browserColumnName']." VARCHAR(255) NULL"
			);
			
			//check for the needed columns and add them if they don't exist
			for ($x = 0; $x < sizeof($qry_checkInfo); $x++) {
				$qry = $qry_checkInfo[$x];
				$qryRows = mysql_num_rows(mysql_query($qry));
				mysqlException(mysql_error(),$header."-".$sitevalue."-0x03");
				
				if ($qryRows == 0) {
					$qry = $qry_alterInfo[$x];
					mysql_query($qry);
					mysqlException(mysql_error(),$header."-".$sitevalue."-0x04");
				}
			}	
				
			//get the POST data
			$siteChecksum = $_POST['sitechecksum'];
			$key = $_POST['key'];
		
			$userId = mysql_real_escape_string(stripslashes(encryptControl("decrypt",$key,stringToSalt($siteChecksum))));
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x06");			
			$newpassword = mysql_real_escape_string(stripslashes($_POST["newpassworda"]));
			mysqlException(mysql_error(),$header."-".$sitevalue."-0x07");
			$ip = getUserIP();
			$browserInfo = getBrowser();

			if (is_numeric($userId) || is_string($userId)) {
				//set the query to update the password and other values
				$qry = "UPDATE ".$tableInfo['tbl_name']." SET ".$tableInfo['tbl_passwordColumnName']." = '$newpassword',".$tableInfo['tbl_dateColumnName']." = '$logDate',".$tableInfo['tbl_hourColumnName']." = '$logHour',".$tableInfo['tbl_ipColumnName']." = '$ip',".$tableInfo['tbl_browserColumnName']." = '".$browserInfo['name']." ".$browserInfo['version']."' WHERE ".$tableInfo['tbl_idColumnName']." = '$userId'";
				
				//execute the query and check for errors
				mysql_query($qry);
				mysqlException(mysql_error(),$header."-".$sitevalue."-0x08");				
				
				//return whether the password got updated or something else happened
				echo '<response code="1">1</response>';
			} else {
				echo '<response code="1">0</response>';
			}
			
		break;
		default:
			echo'<response code="0">PHP error: id "'.$header.'" not found</response>';
		break;		
	}
	
	function checkStringSize($val) {
		if (strlen($val) > 255) {
			echo'<response code="0">El tamaño de alguno de los campos supera 255 caracteres, por favor verifique e intente nuevamente</response>';
			exit;
		}
	}
	function checkSiteName($val) {
	if ($val == strtolower("null")) {
			echo'<response code="0">Ha accedido al sistema de cambio de contraseñas por un medio no autorizado, por favor cierre la página e intente nuevamente</response>';
			exit;
		}	
	}
	function encryptControl($method,$string,$key) {
		
		$output = false;
	
		$encrypt_method = "AES-256-CBC";
	
		$key = hash('sha256', $key);
		
		$iv = substr(hash('sha256', $key), 0, 16);
	
		switch (strtolower($method)) {
			case 'encrypt':
				$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
				$output = base64_encode($output);			
			break;
			case 'decrypt':
				$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
			break;
		}
	
		return $output;
	}
	function clean($string) {
		$string = str_replace(array('<', '>', '&', '{', '}', '[', ']','"',"'"), array(''), $string);
		//$string = trim(preg_replace('/\s+/', '', $string));
		//$string = str_replace(array('á','é','í','ó','ú','Á','É','Í','Ó','Ú','ñ','Ñ'), array('a','e','i','o','u','A','E','I','O','U','n','N'), $string);
		return $string;		
	}
	function stringToSalt($val) {
		$salt = crypt($val,'l?#$E-C72!q4*$np5|mEJ-I-boH6SB#_bmn-=)@SU}5z9TBWWj+D+EDMv b;9wG7');
		return $salt;
	}
	function mysqlException($v,$v2) {
		if ($v) {
			
			global $con;
			
			$error = "Se ha encontrado una excepción:\n$v\n\nLugar de origen:\n".basename($_SERVER['PHP_SELF'])."\n\nReferencia:\n$v2";
			
			echo'<response code="0">';
				echo $error;
			echo'</response>';
			mysql_close($con);
			exit;
		}
	}
	function getUserIP() {
		$client  = @$_SERVER['HTTP_CLIENT_IP'];
		$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
		$remote  = $_SERVER['REMOTE_ADDR'];
	
		if (filter_var($client, FILTER_VALIDATE_IP)) {
			$ip = $client;
		} else if(filter_var($forward, FILTER_VALIDATE_IP)) {
			$ip = $forward;
		} else {
			$ip = $remote;
		}
	
		return $ip;
	}
	//define the browser function
	function getBrowser() { 
		$u_agent = $_SERVER['HTTP_USER_AGENT']; 
		$bname = 'Unknown';
		$platform = 'Unknown';
		$version= "";
	
		//First get the platform?
		if (preg_match('/linux/i', $u_agent)) {
			$platform = 'linux';
		} else if (preg_match('/macintosh|mac os x/i', $u_agent)) {
			$platform = 'mac';
		} else if (preg_match('/windows|win32/i', $u_agent)) {
			$platform = 'windows';
		}
		
		// Next get the name of the useragent yes seperately and for good reason
		if (preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) { 
			$bname = 'Internet Explorer'; 
			$ub = "MSIE"; 
		} else if(preg_match('/Firefox/i',$u_agent)) { 
			$bname = 'Mozilla Firefox'; 
			$ub = "Firefox"; 
		} else if(preg_match('/Chrome/i',$u_agent)) { 
			$bname = 'Google Chrome'; 
			$ub = "Chrome"; 
		} else if(preg_match('/Safari/i',$u_agent)) { 
			$bname = 'Apple Safari'; 
			$ub = "Safari"; 
		} else if(preg_match('/Opera/i',$u_agent)) { 
			$bname = 'Opera'; 
			$ub = "Opera"; 
		} else if(preg_match('/Netscape/i',$u_agent)) { 
			$bname = 'Netscape'; 
			$ub = "Netscape"; 
		} 
		
		// finally get the correct version number
		$known = array('Version', $ub, 'other');
		$pattern = '#(?<browser>'.join('|', $known).')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		
		if (!preg_match_all($pattern, $u_agent, $matches)) {
			// we have no matching number just continue
		}
		
		// see how many we have
		$i = count($matches['browser']);
		
		if ($i != 1) {
			//we will have two since we are not using 'other' argument yet
			//see if version is before or after the name
			if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
				$version= $matches['version'][0];
			} else {
				$version= $matches['version'][1];
			}
		} else {
			$version= $matches['version'][0];
		}
		
		// check if we have a number
		if ($version==null || $version=="") {$version="?";}
		
		return array(
			'userAgent' => $u_agent,
			'name'      => $bname,
			'version'   => $version,
			'platform'  => $platform,
			'pattern'    => $pattern
		);
	}	
	
	mysql_close($con);
	exit;
?>