<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

    
    /*
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    */
    
    session_start();
	include_once"../verifica_sesion.php";
    actionRestriction_102();

    if(
        isset($_GET["laboratorio_pat"]) 
        && isset($_GET["programa_pat"]) 
        && isset($_GET["reto_pat"]) 
    ){
        $laboratorio_pat = $_GET["laboratorio_pat"];
        $programa_pat = $_GET["programa_pat"];
        $reto_pat = $_GET["reto_pat"];
        
        if($programa_pat == 1 || $programa_pat == 2 || $programa_pat == 3 || $programa_pat == 4 || $programa_pat == 5 || $programa_pat == 6){
            require_once("generalInformePAT_intra.php");
            
            if($programa_pat == 1){
                require_once("informeInmuno_intra.php");
            } else if($programa_pat == 2) {
                require_once("informePatologiaQ_intra.php");
            } else if($programa_pat == 3) {
                require_once("informeCitNG_intra.php");
            } else if($programa_pat == 4){
                require_once("informePCM_intra.php");
            } else if($programa_pat == 5){
                require_once("informeCITLBC_intra.php");
            } else if($programa_pat == 6){
                require_once("informeCITG_intra.php");
            }
        } else {
            require_once("generalInformeCAP_intra.php");
            
            $qry = "SELECT * FROM programa_pat WHERE id_programa = '$programa_pat'";
            $qryData = mysql_fetch_array(mysql_query($qry));
            $sigla_cap = $qryData['sigla'];
            $sigla_cap = substr($sigla_cap, 0, -5);
            
            switch($sigla_cap){
                case "CAP-MK":
                    require_once("informeCAPMK_intra.php");
                    break;
                case "CAP-CYH":
                    require_once("informeCAPCYH_intra.php");
                    break;
                case "CAP-PIP":
                    require_once("informeCAPPIP_intra.php");
                    break;
                case "CAP-PAP":
                    require_once("informeCAPPAP_intra.php");
                    break;
                case "CAP-PM2":
                    require_once("informeCAPPM2_intra.php");
                    break;
                case "CAP-HER2":
                    require_once("informeCAPHER2_intra.php");
                    break;
                case "CAP-NGC":
                    require_once("informeCAPNGC_intra.php");
                    break;
            }
        }
    } else {
        echo "Información insuficiente para la generación del reporte...";
    }
?>
