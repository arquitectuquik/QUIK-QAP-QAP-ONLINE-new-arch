<?php
require_once __DIR__ . "/Repository.php";
include_once __DIR__ . "/../complementos/intercuartil.php";


class ResultadosRepository extends Repository
{
    /**
     * Devuelve los valores de resultado de una configuracion y una muestra
     * (asume que es para casos generales sin consenso personalizado)
     *
     * @param int $idConfiguracion
     * @param int $idMuestra
     * @return array
     */
    public function resultadosPorConfigMuestra($idConfiguracion, $idMuestra)
    {
        $idConfiguracion_escaped = mysql_real_escape_string($idConfiguracion);
        $idMuestra_escaped = mysql_real_escape_string($idMuestra);

        $query = "
            SELECT * FROM resultado
            WHERE id_configuracion = '$idConfiguracion_escaped' AND id_muestra = '$idMuestra_escaped'
        ";
        return $this->ejecutarQuery($query);
    }

    /**
     * Obtiene TODOS los resultados base para una configuración dada,
     * SIN aplicar ningún filtro de selección de consenso guardada.
     * Diseñado para la ventana modal.
     *
     * @param string $idPrograma
     * @param string $idUnidad
     * @param string $idLote
     * @param string $idAnalito
     * @param string $fechaCorte
     * @return array
     */
    public function obtenerTodosLosResultadosBase(
        $idPrograma,
        $idUnidad,
        $idLote,
        $idAnalito,
        $fechaCorte
    ) {
        $idPrograma_escaped = mysql_real_escape_string($idPrograma);
        $idUnidad_escaped = mysql_real_escape_string($idUnidad);
        $idLote_escaped = mysql_real_escape_string($idLote);
        $idAnalito_escaped = mysql_real_escape_string($idAnalito);
        $fechaCorte_escaped = mysql_real_escape_string($fechaCorte);


        $query = "SELECT
        r.id_resultado,
        r.id_configuracion,
        r.valor_resultado,
        cla.id_laboratorio,
        cla.id_unidad,
        r.fecha_resultado,
        cla.id_analito,
        r.id_muestra,
        ro.no_ronda,
        m.codigo_muestra AS muestra_nombre,
        l.nombre_laboratorio,
        l.no_laboratorio,
        met.nombre_metodologia,
        p.nombre_programa,
        m.codigo_muestra,
        cm.no_contador
    FROM resultado r
    JOIN configuracion_laboratorio_analito cla ON cla.id_configuracion = r.id_configuracion
    JOIN muestra_programa mp ON mp.id_programa = cla.id_programa AND mp.id_muestra = r.id_muestra
    JOIN muestra m ON m.id_muestra = r.id_muestra
    LEFT JOIN contador_muestra cm ON cm.id_muestra = m.id_muestra
    LEFT JOIN ronda ro ON ro.id_ronda = cm.id_ronda 
    LEFT JOIN laboratorio l ON l.id_laboratorio = cla.id_laboratorio
    LEFT JOIN metodologia met ON met.id_metodologia = cla.id_metodologia
    LEFT JOIN programa p ON p.id_programa = cla.id_programa
    WHERE cla.id_programa = '" . $idPrograma_escaped . "' AND
    cla.id_unidad = '" . $idUnidad_escaped . "' AND
    cla.id_analito = '" . $idAnalito_escaped . "' AND
    mp.id_lote = '" . $idLote_escaped . "' AND
    r.fecha_resultado <= '" . $fechaCorte_escaped . "' AND
    r.valor_resultado IS NOT NULL AND
    r.valor_resultado != ''
    ";


        $query .= " ORDER BY CAST(r.valor_resultado AS DECIMAL(10, 4))";

        error_log("Query para obtener todos los resultados base: " . $query);

        return $this->ejecutarQuery($query);
    }
    /**
     * Se encarga de obtener los resultado de todos los participantes
     * Aplica filtro por selecciones de consenso guardadas si existen.
     * Si no hay selecciones guardadas, devuelve todos los resultados base.
     *
     * @param string $idPrograma
     * @param string $idUnidad
     * @param string $idLote
     * @param string $idAnalito
     * @param string $fechaCorte
     * @param int|null $idConfigConsensoActual
     * @param int|null $idMuestraConsenso 
     * @param string|null $fechaSeleccionConsenso 
     * @return array
     */
    public function todoLosParticipantesPorAnalito(
        $idPrograma,
        $idUnidad,
        $idLote,
        $idAnalito,
        $fechaCorte,
        $idConfigConsensoActual = null,
        $idMuestraConsenso = null,
        $fechaSeleccionConsenso = null
    ) {

        $idPrograma_escaped = mysql_real_escape_string($idPrograma);
        $idUnidad_escaped = mysql_real_escape_string($idUnidad);
        $idLote_escaped = mysql_real_escape_string($idLote);
        $idAnalito_escaped = mysql_real_escape_string($idAnalito);
        $fechaCorte_escaped = mysql_real_escape_string($fechaCorte);

        $base_query = "SELECT 
        r.id_resultado ,
        r.id_configuracion ,					
        r.valor_resultado,
        cla.id_laboratorio ,
        cla.id_unidad,
        r.fecha_resultado,
        cla.id_analito,
        cla.id_laboratorio,
        r.id_muestra
        from resultado r 
        join configuracion_laboratorio_analito cla on cla.id_configuracion  = r.id_configuracion
        join muestra_programa mp on mp.id_programa = cla.id_programa  and mp.id_muestra = r.id_muestra 
                WHERE cla.id_programa  = '" . $idPrograma_escaped . "' AND 
        cla.id_unidad = '" . $idUnidad_escaped . "' AND
        cla.id_analito = '" . $idAnalito_escaped . "' AND
        mp.id_lote = '" . $idLote_escaped . "' AND
        r.fecha_resultado <= '" . $fechaCorte_escaped . "' AND

        r.valor_resultado is not null and 
        r.valor_resultado != '' 
        ";


        // ---- Lógica para aplicar filtro de selecciones personalizadas desde la DB ----
        $ids_filtrar = [];
        if (
            $idConfigConsensoActual !== null &&
            $idMuestraConsenso !== null &&
            $fechaSeleccionConsenso !== null
        ) {
            $idConfigConsensoActual_escaped = mysql_real_escape_string($idConfigConsensoActual);
            $idMuestraConsenso_escaped = mysql_real_escape_string($idMuestraConsenso);
            $fechaSeleccionConsenso_escaped = mysql_real_escape_string($fechaSeleccionConsenso);

            $query_get_selected = "
            SELECT id_resultado 
            FROM selecciones_consenso 
            WHERE id_configuracion = '$idConfigConsensoActual_escaped' 
            AND id_muestra = '$idMuestraConsenso_escaped' 
            AND DATE(fecha_seleccion) = DATE('$fechaSeleccionConsenso_escaped')
        ";


            $result_selected = $this->ejecutarQuery($query_get_selected);


            if ($result_selected && is_array($result_selected) && count($result_selected) > 0) {
                foreach ($result_selected as $row) {
                    $ids_filtrar[] = $row['id_resultado'];
                }
            }


            // Si se encontraron selecciones guardadas, aplicar el filtro.
            // SI NO SE ENCONTRARON SELECCIONES GUARDADAS, NO SE APLICA FILTRO,
            // LO CUAL RESULTA EN QUE SE CARGUEN TODOS LOS DATOS BASE (EL COMPORTAMIENTO DESEADO).
            if (!empty($ids_filtrar)) {
                $ids_string = implode(',', array_map('mysql_real_escape_string', $ids_filtrar));
                $base_query .= " AND r.id_resultado IN ($ids_string)";
            }
        }
        // El resultado final de la query
        $base_query .= " ORDER BY CAST(r.valor_resultado AS DECIMAL(10, 4))";
        $final_result = $this->ejecutarQuery($base_query);

        // --- INICIO: CONVERSIÓN DE TIPO A FLOAT ---
        $resultados_convertidos = [];
        if (is_array($final_result)) {
            foreach ($final_result as $row) {
                $valor_original = $row['valor_resultado'];

                // Aplicamos el casting directo a float
                $valor_procesado = (float) $valor_original;

                // Mantenemos la verificación para evitar nulos o cadenas vacías que
                // se convierten a 0.0 cuando el valor original no tenía intención de ser 0.
                if ($valor_original !== '' && $valor_original !== null) {
                    // Actualizamos el valor_resultado en el array con el tipo float
                    $row['valor_resultado'] = $valor_procesado;
                    $resultados_convertidos[] = $row;
                }
            }
        }
        $final_result = $resultados_convertidos;
        // --- FIN: CONVERSIÓN DE TIPO A FLOAT ---

        $FECHA_INICIO_NUEVA_FORMULA_ZSCORE = strtotime("2025-06-01");
        // la siguiente comparacion puede fallar luego del 2038 por el overflow de la unix epoch
        if (isset($fechaCorte) && strtotime($fechaCorte) < $FECHA_INICIO_NUEVA_FORMULA_ZSCORE) {
            $filtroIntercuartil = new Intercuartil();
            $final_result = $filtroIntercuartil->test_intercuartil(
                $final_result,
                "valor_resultado",
                true
            );
        }

        return $final_result;
    }
    /**
     * Se encarga de obtener los resultado de los participantes de una misma metodologia
     * Aplica filtro por selecciones de consenso guardadas si existen.
     * Si no hay selecciones guardadas, devuelve todos los resultados base.
     *
     * @param string $idPrograma
     * @param string $idUnidad
     * @param string $idLote
     * @param string $idAnalito
     * @param string $idMetodologia
     * @param string $fechaCorte
     * @param int|null $idConfigConsensoActual
     * @param int|null $idMuestraConsenso 
     * @param string|null $fechaSeleccionConsenso 
     * @return array
     */
    public function todosLosParticipantesMismaMetodologia(
        $idPrograma,
        $idUnidad,
        $idLote,
        $idAnalito,
        $idMetodologia,
        $fechaCorte,
        $idConfigConsensoActual = null,
        $idMuestraConsenso = null,
        $fechaSeleccionConsenso = null
    ) {
        $idPrograma_escaped = mysql_real_escape_string($idPrograma);
        $idUnidad_escaped = mysql_real_escape_string($idUnidad);
        $idLote_escaped = mysql_real_escape_string($idLote);
        $idAnalito_escaped = mysql_real_escape_string($idAnalito);
        $idMetodologia_escaped = mysql_real_escape_string($idMetodologia);
        $fechaCorte_escaped = mysql_real_escape_string($fechaCorte);

        $base_query = "SELECT 
        r.id_resultado,
        r.id_configuracion,                   
        r.valor_resultado,
        cla.id_laboratorio,
        cla.id_unidad,
        r.fecha_resultado,
        cla.id_analito,
        r.id_muestra
            FROM resultado r
        JOIN configuracion_laboratorio_analito cla ON cla.id_configuracion  = r.id_configuracion
            JOIN muestra_programa mp ON mp.id_programa = cla.id_programa AND mp.id_muestra = r.id_muestra
        WHERE cla.id_programa  = '" . $idPrograma_escaped . "' AND 
        cla.id_unidad = '" . $idUnidad_escaped . "' AND
        cla.id_analito = '" . $idAnalito_escaped . "' AND
        cla.id_metodologia = '" . $idMetodologia_escaped . "' AND
        mp.id_lote = '" . $idLote_escaped . "' AND
        r.fecha_resultado <= '" . $fechaCorte_escaped . "' AND
        r.valor_resultado IS NOT NULL AND 
        r.valor_resultado != '' 
    ";

        // ---- Lógica para aplicar filtro de selecciones personalizadas desde la DB ----
        $ids_filtrar = [];
        if (
            $idConfigConsensoActual !== null &&
            $idMuestraConsenso !== null &&
            $fechaSeleccionConsenso !== null
        ) {
            $idConfigConsensoActual_escaped = mysql_real_escape_string($idConfigConsensoActual);
            $idMuestraConsenso_escaped = mysql_real_escape_string($idMuestraConsenso);
            $fechaSeleccionConsenso_escaped = mysql_real_escape_string($fechaSeleccionConsenso);

            $query_get_selected = "
                SELECT id_resultado 
                FROM selecciones_consenso 
                WHERE id_configuracion = '$idConfigConsensoActual_escaped' 
                AND id_muestra = '$idMuestraConsenso_escaped' 
                AND DATE(fecha_seleccion) = DATE('$fechaSeleccionConsenso_escaped')
            ";

            $result_selected = $this->ejecutarQuery($query_get_selected);

            if ($result_selected && is_array($result_selected) && count($result_selected) > 0) {
                foreach ($result_selected as $row) {
                    $ids_filtrar[] = $row['id_resultado'];
                }
            }

            // Si se encontraron selecciones guardadas, aplicar el filtro.
            // SI NO SE ENCONTRARON SELECCIONES GUARDADAS, NO SE APLICA FILTRO.
            if (!empty($ids_filtrar)) {
                $ids_string = implode(',', array_map('mysql_real_escape_string', $ids_filtrar));
                $base_query .= " AND r.id_resultado IN ($ids_string)";
            }
        }


        // El resultado final de la query
        $base_query .= " ORDER BY CAST(r.valor_resultado AS DECIMAL(10, 3))";
        $final_result = $this->ejecutarQuery($base_query);

        // --- INICIO: CONVERSIÓN DE TIPO A FLOAT ---
        $resultados_convertidos = [];
        if (is_array($final_result)) {
            foreach ($final_result as $row) {
                $valor_original = $row['valor_resultado'];

                // Aplicamos el casting directo a float
                $valor_procesado = (float) $valor_original;

                // Mantenemos la verificación para evitar nulos o cadenas vacías
                if ($valor_original !== '' && $valor_original !== null) {
                    // Actualizamos el valor_resultado en el array con el tipo float
                    $row['valor_resultado'] = $valor_procesado;
                    $resultados_convertidos[] = $row;
                }
            }
        }
        $final_result = $resultados_convertidos;
        // --- FIN: CONVERSIÓN DE TIPO A FLOAT ---

        return $final_result;
    }
}