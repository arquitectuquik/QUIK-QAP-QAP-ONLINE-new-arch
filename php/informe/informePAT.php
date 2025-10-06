<?php

    session_start();
	include_once"../verifica_sesion.php";
	actionRestriction_102();

    if(
        isset($_GET["laboratorio_pat"])
        && isset($_GET["programa_pat"])
        && isset($_GET["reto_pat"])
        && isset($_GET["intento_pat"])
        && isset($_GET["fecha_envio"])
        && isset($_GET["estado_reporte"])
        && isset($_GET["see_observaciones"])
    ){

        $laboratorio_pat = $_GET["laboratorio_pat"];
        $programa_pat = $_GET["programa_pat"];
        $reto_pat = $_GET["reto_pat"];
        $intento_pat = $_GET["intento_pat"];

        $fecha_envio = $_GET["fecha_envio"];
        $estado_reporte = $_GET["estado_reporte"];
        $see_observaciones = $_GET["see_observaciones"];
        
        if($programa_pat == 1){
            require_once("informeInmuno.php");
        } else if($programa_pat == 2) {
            require_once("informePatologiaQ.php");
        } else if($programa_pat == 3) {
            require_once("informeCitNG.php");
        } else if($programa_pat == 4){
            require_once("informePCM.php");
        } else if($programa_pat == 5){
            require_once("informeCITLBC.php");
        } else if($programa_pat == 6){
            require_once("informeCITG.php");
        }
        
    } else {
        echo "Información insuficiente para la generación del reporte...";
    }
?>
