<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

session_start();
include_once "verifica_sesion.php";

require_once __DIR__ . "/repositorys/ResultadosRepository.php";

header('Content-Type: application/json; charset=utf-8');

$id_config_consenso = isset($_POST['id_config_consenso']) ? $_POST['id_config_consenso'] : null;
$id_muestra = isset($_POST['id_muestra']) ? $_POST['id_muestra'] : null;
$fecha_corte = isset($_POST['fecha_corte']) ? $_POST['fecha_corte'] : null;
$ids_resultados_seleccionados = isset($_POST['ids_resultados_seleccionados']) ? $_POST['ids_resultados_seleccionados'] : array();

// Valida que todos los parámetros necesarios estén presentes
if (empty($id_config_consenso) || empty($id_muestra) || empty($fecha_corte)) {
    echo json_encode(array('status' => 'error', 'message' => 'Parámetros incompletos para guardar selecciones.'));
    exit;
}

try {


    // 1. Limpiar selecciones existentes para esta configuración, muestra y fecha_corte
    $sql_delete = "DELETE FROM selecciones_consenso 
                   WHERE id_configuracion = '" . mysql_real_escape_string($id_config_consenso) . "' 
                   AND id_muestra = '" . mysql_real_escape_string($id_muestra) . "' 
                   AND DATE(fecha_seleccion) = DATE('" . mysql_real_escape_string($fecha_corte) . "')";

    $delete_result = mysql_query($sql_delete);

    if (!$delete_result) {
        throw new Exception("Error al eliminar selecciones anteriores: " . mysql_error());
    }

    // 2. Insertar las nuevas selecciones si hay resultados seleccionados
    if (!empty($ids_resultados_seleccionados)) {
        $values = array();

        foreach ($ids_resultados_seleccionados as $id_resultado) {
            if (!is_numeric($id_resultado)) {
                continue;
            }

            $values[] = "('" . mysql_real_escape_string($id_config_consenso) . "', " .
                "'" . mysql_real_escape_string($id_muestra) . "', " .
                "'" . mysql_real_escape_string($id_resultado) . "', " .
                "'" . mysql_real_escape_string($fecha_corte) . "')";
        }

        if (!empty($values)) {
            $sql_insert = "INSERT INTO selecciones_consenso 
                          (id_configuracion, id_muestra, id_resultado, fecha_seleccion) 
                          VALUES " . implode(", ", $values);

            $insert_result = mysql_query($sql_insert);

            if (!$insert_result) {
                throw new Exception("Error al insertar nuevas selecciones: " . mysql_error());
            }
        }
    }

    echo json_encode(array('status' => 'success', 'message' => 'Selecciones guardadas'));

} catch (Exception $e) {
    error_log("Error al guardar selecciones de consenso: " . $e->getMessage());
    echo json_encode(array('status' => 'error', 'message' => 'Error de base de datos al guardar selecciones.'));
}


exit;