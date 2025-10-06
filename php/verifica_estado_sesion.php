<?php

	session_start();
	
	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";
	
	if (isset($_SESSION['qap_token'])) {
		$response = 1;
	} else {
		$response = 0;
	}
	
	echo '<response code="1">';
	echo $response;
	echo '</response>';
	exit;

?>