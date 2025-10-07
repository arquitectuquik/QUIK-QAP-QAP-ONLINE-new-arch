<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

include_once __DIR__ . '/../sql_connection.php';
class Repository
{
    /**
     * Se encarga de ejcuta el query en la db y convertir el resultado en un array
     *
     * @param string $query
     * @return array
     */
    protected function ejecutarQuery($query)
    {

        $resultadoQuery = mysql_query($query);

        // Verificar si hay errores en la consulta
        if (!$resultadoQuery) {
            $error = mysql_error();

            $dataArray = array('error' => 'Error en la consulta SQL: ' . $error);
            return $dataArray;
        }

        $dataArray = array();
        //Se convierte el valor de mysql en valor array
        while ($data = mysql_fetch_assoc($resultadoQuery)) {
            array_push(
                $dataArray,
                $data
            );
        }

        return $dataArray;
    }
}