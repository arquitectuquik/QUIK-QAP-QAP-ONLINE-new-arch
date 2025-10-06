<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once __DIR__ . "/../mysql_compatibility.php";
}

/**
 * Verificación de sesión - Compatible con PHP 7+
 * Migrado de PHP 5.6 utilizando funciones de compatibilidad MySQL
 */

if (isset($_SESSION["qap_userId"]) && isset($_SESSION['qap_token'])) {
    include_once "sql_connection.php";
    
    $current = $_SERVER['PHP_SELF'];
    
    // Usar escape de string para seguridad
    $token = mysql_real_escape_string($_SESSION['qap_token']);
    $qry = "SELECT id_sesion FROM $tbl_sesion WHERE token_sesion = '$token'";
    
    $result = mysql_query($qry);
    $qryRows = mysql_num_rows($result);
        
    if ($qryRows > 0) {
        // Sesión válida
    } else {
        // Token inválido, redirigir al login
        redirectToLogin($current);
        closeConnectionAndExit();
    }
    
} else {
    // No hay sesión iniciada
    $current = isset($_SERVER['PHP_SELF']) ? $_SERVER['PHP_SELF'] : '';
    redirectToLogin($current);
    closeConnectionAndExit();
}

/**
 * Función para redirigir al login
 */
function redirectToLogin($current) {
    if (strpos($current, '/php/') !== false) {
        header("Location: ../login.php");
    } else {
        header("Location: login.php");
    }
}

/**
 * Función para cerrar conexión y finalizar
 */
function closeConnectionAndExit() {
    global $con;
    
    session_destroy();
    
    if (isset($con) && $con) {
        mysql_close($con);
    }
    
    exit;
}
