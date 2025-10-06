<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}


//passwordchange for javascript
//copyright AeZ - 2016.

//this is the PHP file that will verify whether the password needs to be reseted
//this file also expects you to be suing MySQL as your default database engine
//the next values must be configured to match your database connection and table values

//db_hostname						This is the URL of the host to access the database
//db_username						This is the username credeentials to acces the database in the server
//db_password						This is the password credeentials to acces the database in the server
//db_name							This is the name of the database
//tbl_name							This is the name of the table that contains the users and passwords
//tbl_userColumnName				This is the name of the colum in which the user names are located
//tbl_passwordColumnName			This is the name of the colum in which the passwords are located
//$daysLimit						This is the limit of days for the password to caducate

	//set the checksum
	session_start();
	
	date_default_timezone_set("America/Bogota");
	
	if (!isset($_SESSION["passwordchange_checksum"])) {
		$_SESSION["passwordchange_checksum"] = md5(uniqid(rand(), true));
	}
	
	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";
	
	date_default_timezone_set("America/Bogota");
	$serverDateInfo = getdate();
	$logDate = $serverDateInfo['year']."-".$serverDateInfo['mon']."-".$serverDateInfo['mday'];
	$logHour = $serverDateInfo['hours'].":".$serverDateInfo['minutes'].":".$serverDateInfo['seconds'];			
	ini_set('max_execution_time', 300);	
	
	//define the database info
						$dataBaseInfo = array(
						"db_hostname"=>"localhost"
						,"db_username"=>"quikappspane_qaponline_user"
						,"db_password"=>"qaponline_v1"
						,"db_name"=>"quikappspane_qaponline_v1"
					);
	// $dataBaseInfo = array(
	// 					"db_hostname"=>"localhost"
	// 					,"db_username"=>"root"
	// 					,"db_password"=>""
	// 					,"db_name"=>"u669796078_panequik_qap"
	// 				);
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
	);
	
	//define the limit of days for the password to caducate
	$daysLimit = 90;
	
	//start the connection to the sql database
	$con = mysql_connect($dataBaseInfo["db_hostname"],$dataBaseInfo["db_username"],$dataBaseInfo["db_password"]);
	mysql_select_db($dataBaseInfo["db_name"],$con);
	
	//define the queries to check if the needed coulmns exist
	$qry_checkInfo = array(
		0=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_dateColumnName']."'"
		,1=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_hourColumnName']."'"
		,2=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_ipColumnName']."'"
		,3=>"SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA = '".$dataBaseInfo["db_name"]."' AND TABLE_NAME = '".$tableInfo['tbl_name']."' AND COLUMN_NAME = '".$tableInfo['tbl_browserColumnName']."'"
	);	
	
	//define the queries to create the needed columns if aren't there
	$qry_alterInfo = array(
		0=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_dateColumnName']." DATE NULL"
		,1=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_hourColumnName']." TIME NULL"
		,2=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_ipColumnName']." CHAR(255) NULL"
		,3=>"ALTER TABLE ".$tableInfo['tbl_name']." ADD ".$tableInfo['tbl_browserColumnName']." VARCHAR(255) NULL"
	);

	//check for the needed columns and add them if these aren't there
	for ($x = 0; $x < sizeof($qry_checkInfo); $x++) {
		$qry = $qry_checkInfo[$x];
		$qryRows = mysql_num_rows(mysql_query($qry));
		
		if ($qryRows == 0) {
			$qry = $qry_alterInfo[$x];
			mysql_query($qry);
		}
	}	
	
	//get the header and decide what needs to be done	
	$header = stripcslashes($_POST["header"]);
	
	switch ($header) {
		case "datecheck":
		
			//get the username and its password
			$username = mysql_real_escape_string(stripslashes($_POST["username"]));
			$password = mysql_real_escape_string(stripslashes($_POST["password"]));
			
			//set the query to check for the date of the last password modification
			$qry = "SELECT ".$tableInfo['tbl_idColumnName'].",".$tableInfo['tbl_dateColumnName']." FROM ".$tableInfo['tbl_name']." WHERE ".$tableInfo['tbl_userColumnName']." = '$username' AND ".$tableInfo['tbl_passwordColumnName']." = '$password' LIMIT 0,1";		
			
			$qryData = mysql_fetch_array(mysql_query($qry));
			$checkrows = mysql_num_rows(mysql_query($qry));
			
			//get the date difference
			$date1 = new DateTime($logDate);
			$date2 = new DateTime($qryData[$tableInfo['tbl_dateColumnName']]);
			
			$dateDiff = date_diff($date1, $date2);
			
			$daysToExpire = $dateDiff->format('%a');			
			
			//compare the date difference
			if ($daysToExpire > $daysLimit || ($qryData[$tableInfo['tbl_dateColumnName']] == "NULL" || $qryData[$tableInfo['tbl_dateColumnName']] == "")) {
				$hasPasswordExpired = 1;
			} else {
				$hasPasswordExpired = 0;
			}
			
			//return the values
			if ($checkrows > 0) {
				echo "<response>";
					echo"<returnvalues1>$hasPasswordExpired</returnvalues1>";
					echo"<returnvalues2>".encryptControl("encrypt",$qryData[$tableInfo['tbl_idColumnName']],$_SESSION["passwordchange_checksum"])."</returnvalues2>";
					echo"<returnvalues3>".$_SESSION["passwordchange_checksum"]."</returnvalues3>";
				echo "</response>";					
			} else {
				echo "<response>";
					echo"<returnvalues1>0</returnvalues1>";
				echo "</response>";					
			}
		break;
		case "datachange":		
		
			//get the POST data
			$userid = mysql_real_escape_string(stripslashes(encryptControl("decrypt",$_POST["userid"],$_SESSION["passwordchange_checksum"])));
			$newpassword = mysql_real_escape_string(stripslashes($_POST["newpassword"]));
			$ip = getUserIP();
			$browserInfo = getBrowser();
			$checksum = mysql_real_escape_string(stripslashes($_POST["checksum"]));
			
			if ($checksum == $_SESSION["passwordchange_checksum"]) {
				//set the query to check if the password is the same as the last one
				$qry = "SELECT ".$tableInfo['tbl_passwordColumnName']." FROM ".$tableInfo['tbl_name']." WHERE ".$tableInfo['tbl_idColumnName']." = '$userid'";
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				
				if ($newpassword == $qryData[$tableInfo['tbl_passwordColumnName']]) {
					$returnValue = 3;
				} else {
					//set the query to update the password and other values
					$qry = "UPDATE ".$tableInfo['tbl_name']." SET ".$tableInfo['tbl_passwordColumnName']." = '$newpassword',".$tableInfo['tbl_dateColumnName']." = '$logDate',".$tableInfo['tbl_hourColumnName']." = '$logHour',".$tableInfo['tbl_ipColumnName']." = '$ip',".$tableInfo['tbl_browserColumnName']." = '".$browserInfo['name']." ".$browserInfo['version']."' WHERE ".$tableInfo['tbl_idColumnName']." = '$userid'";
					
					//execute the query and check for errors
					mysql_query($qry);
					if (mysql_error()) {
						$returnValue = 1;
					} else {
						$returnValue = 2;
						unset($_SESSION["passwordchange_checksum"]);
					}					
				}
			
			} else {
				$returnValue = 0;
			}
			
			//return whether the password got updated or something else happened
			echo "<response>";
				echo"<returnvalues1>$returnValue</returnvalues1>";
			echo "</response>";	
			
		break;		
	}
	
	//define the encryption function
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
	
	//define the ip function
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