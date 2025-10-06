<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

error_reporting(E_ERROR | E_PARSE);
ini_set('display_errors', 0);

session_start();
include_once "verifica_sesion.php";
require_once __DIR__ . "/repositorys/ResultadosRepository.php";

header('Content-Type: application/json; charset=utf-8');
$response_data = array();

// Recibir todos los parámetros
$id_config_consenso = isset($_POST['id_config_consenso']) ? $_POST['id_config_consenso'] : null;
$fecha_corte = isset($_POST['fecha_corte']) ? $_POST['fecha_corte'] : null;
$id_muestra = isset($_POST['id_muestra']) ? $_POST['id_muestra'] : null;

if (empty($id_config_consenso) || empty($fecha_corte) || empty($id_muestra)) {
    echo json_encode(array('error' => 'Parámetros incompletos para obtener resultados de consenso.'));
    exit;
}

// INSTANCIAR REPOSITORIO
$resultadosRepository = new ResultadosRepository();

try {
    // --- OBTENER LOS IDs DE RESULTADOS SELECCIONADOS PREVIAMENTE DESDE LA DB ---
    $id_config_consenso_escaped = mysql_real_escape_string($id_config_consenso);
    $id_muestra_escaped = mysql_real_escape_string($id_muestra);
    $fecha_corte_escaped = mysql_real_escape_string($fecha_corte);

    $sql_get_selected = "SELECT id_resultado
                            FROM selecciones_consenso
                            WHERE id_configuracion = '" . $id_config_consenso_escaped . "'
                            AND id_muestra = '" . $id_muestra_escaped . "'
                            AND DATE(fecha_seleccion) = DATE('" . $fecha_corte_escaped . "')";

    $result_selected = mysql_query($sql_get_selected);
    $previamente_seleccionados_db = array();

    if ($result_selected) {
        while ($row = mysql_fetch_assoc($result_selected)) {
            $previamente_seleccionados_db[] = $row['id_resultado'];
        }
    }

    // Convertir a un array asociativo para búsqueda rápida
    $previamente_seleccionados_map = array();
    foreach ($previamente_seleccionados_db as $id) {
        $previamente_seleccionados_map[$id] = true;
    }

    $id_analito_param = null; // Cambiado de nombre_analito
    $id_unidad_param = null;  // Cambiado de nombre_unidad
    $id_lote_repo = null;
    $id_programa = null;

    // Consulta para obtener los IDs de analito, unidad y programa
    $sql_get_config_info = "SELECT cla.id_analito, cla.id_unidad, cla.id_programa
                                FROM configuracion_laboratorio_analito cla
                                WHERE cla.id_configuracion = '" . $id_config_consenso_escaped . "'";


    $result_info = mysql_query($sql_get_config_info);

    if ($result_info && mysql_num_rows($result_info) > 0) {
        $config_info = mysql_fetch_assoc($result_info);
        $id_analito_param = $config_info['id_analito'];
        $id_unidad_param = $config_info['id_unidad'];
        $id_programa = $config_info['id_programa'];

        // Obtener el ID del lote
        $sql_get_lote = "SELECT l.id_lote FROM lote l
                         INNER JOIN muestra_programa mp ON l.id_lote = mp.id_lote
                         WHERE mp.id_muestra = '" . $id_muestra_escaped . "' LIMIT 1";

        $result_lote = mysql_query($sql_get_lote);
        if ($result_lote && mysql_num_rows($result_lote) > 0) {
            $lote_info = mysql_fetch_assoc($result_lote);
            $id_lote_repo = $lote_info['id_lote'];
        } else {
            $id_lote_repo = null;
        }

    } else {
        $mysql_error = mysql_error();

        echo json_encode(array(
            'error' => 'No se encontró información de analito/unidad/programa para la configuración de consenso.',
            'debug_info' => array(
                'mysql_error' => $mysql_error,
                'query_ejecutada' => $sql_get_config_info,
                'id_config_consenso' => $id_config_consenso
            )
        ));
        exit;
    }

    // Asegúrate de que $id_analito_param, $id_unidad_param, $id_lote_repo, $id_programa no sean null
    if (is_null($id_analito_param) || is_null($id_unidad_param) || is_null($id_lote_repo) || is_null($id_programa)) {
        echo json_encode(array('error' => 'Faltan parámetros clave para obtener resultados base.'));
        exit;
    }

    // Obtener TODOS los resultados de laboratorio candidatos para el consenso
    $resultados_crudos = $resultadosRepository->obtenerTodosLosResultadosBase(
        $id_programa,
        $id_unidad_param, // Pasar ID de la unidad
        $id_lote_repo,
        $id_analito_param, // Pasar ID del analito
        $fecha_corte
    );

    if (is_array($resultados_crudos)) {
        foreach ($resultados_crudos as $key => $row) {
            $id_unico = $row['id_resultado'];

            // Lógica para determinar si el checkbox debe estar marcado
            $seleccionado_previamente = isset($previamente_seleccionados_map[$id_unico]);

            $response_data[] = array(
                "id_unico_resultado" => $id_unico,
                "it" => (isset($row['no_contador']) && $row['no_contador'] !== '') ? $row['no_contador'] : ($key + 1),
                "resultado" => isset($row['valor_resultado']) ? $row['valor_resultado'] : '',
                "fecha" => isset($row['fecha_resultado']) ? date("Y-m-d", strtotime($row['fecha_resultado'])) : '',
                "ronda_nombre" => isset($row['no_ronda']) ? $row['no_ronda'] : '',
                "muestra_nombre" => isset($row['codigo_muestra']) ? $row['codigo_muestra'] : '',
                "id_laboratorio" => isset($row['no_laboratorio']) ? $row['no_laboratorio'] : '',
                "nombre_laboratorio" => isset($row['nombre_laboratorio']) ? $row['nombre_laboratorio'] : '',
                "nombre_metodologia" => isset($row['nombre_metodologia']) ? $row['nombre_metodologia'] : '',
                "nombre_programa" => isset($row['nombre_programa']) ? $row['nombre_programa'] : '',
                "seleccionado_previamente" => $seleccionado_previamente
            );
        }
    } else {
        $response_data = array('error' => 'El repositorio no devolvió un array de resultados o no se encontraron resultados.', 'debug_info' => $resultados_crudos);
    }

    echo json_encode($response_data);

} catch (Exception $e) {
    error_log("Error inesperado en obtener_resultados_lab_consenso: " . $e->getMessage());
    echo json_encode(array('error' => 'Error inesperado: ' . $e->getMessage()));
}

exit;
?>