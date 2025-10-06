<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../../mysql_compatibility.php';
}


session_start();
include_once "../../verifica_sesion.php";
// include_once "../../php/complementos/grubbs.php";
include_once "../../complementos/grubbs.php";

header('Content-Type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";

// Se convierte la infromacion del Ajax a un json
$data_ajax = json_decode($_POST["data_ajax"]);

$tipo = $data_ajax->tipo; // Tipo de operacion

if (isset($data_ajax->tipo_programa)) {
    $tipo_programa = $data_ajax->tipo_programa; // Tipo de programa
} else {
    $tipo_programa = null; // Tipo de programa
}

switch ($tipo) {
    case 'registroLabProgramaLoteDigitacion':
        actionRestriction_102();
        if ($tipo_programa == "Cualitativo") { // Si es Cualitativo
            // $datos_digitacion = $data_ajax->datos_digitacion;
            $laboratorio = $data_ajax->laboratorio;
            $programa = $data_ajax->programa;
            $lote = $data_ajax->lote;
            if (empty($laboratorio) || empty($programa) || empty($lote)) {
                echo '<response code="422">Verifica antes que toda la información este completa</response>';
            } else {
                $qry = "SELECT id_digitaciones_uroanalisis FROM digitaciones_uroanalisis WHERE id_laboratorio = $laboratorio AND id_programa = $programa AND id_lote = $lote";
                $resultado = mysql_query($qry);
                if (!$resultado) {
                    die("Error en la consulta: " . mysql_error());
                }
                $checkrows = mysql_num_rows($resultado);
                // $checkrows = mysql_num_rows(mysql_query($qry));

                mysqlException(mysql_error(), "_00");
                if ($checkrows > 0) {
                    echo '<response code="422">La información a registrar ya existe</response>';
                } else {
                    // Insercion de la digitacion normal
                    $qry = "INSERT INTO digitaciones_uroanalisis(id_laboratorio, id_programa, id_lote) VALUES($laboratorio, $programa, $lote)";
                    mysql_query($qry);
                    mysqlException(mysql_error(), "_01");
                    echo '<response code="1">1</response>';
                }
            }
        }
        break;
    case 'visualizacion':
        actionRestriction_102();
        $programa = $data_ajax->programa;
        $tipo_programa = "";
        $qry = "SELECT tipo_programa.desc_tipo_programa 
                FROM programa
                INNER JOIN tipo_programa ON programa.id_tipo_programa = tipo_programa.id_tipo_programa
                WHERE programa.id_programa = $programa";

        $qryRes = mysql_query($qry);
        if ($rowRes = mysql_fetch_array($qryRes)) {
            $tipo_programa = $rowRes["desc_tipo_programa"];
        } else {
            $tipo_programa = null;
        }

        if ($tipo_programa == "Cualitativo") { // Si el programa es Cualitativo
            $laboratorio = $data_ajax->laboratorio;
            $lote = $data_ajax->lote;

            if ($laboratorio == "" || $programa == "" || $lote == "") {
                echo '<response code="422">Verifica antes que toda la información este completa</response>';
            } else {
                // $filtro_where = "where digitacion.estado = 1 ";
                $filtro_where = "";

                if ($laboratorio != 0) {
                    $filtro_where .= "$tbl_laboratorio.id_laboratorio = $laboratorio";
                }

                if ($programa != 0) {
                    if (!empty($filtro_where)) {
                        $filtro_where .= " AND ";
                    }
                    $filtro_where .= "$tbl_programa.id_programa = $programa";
                }
                if ($lote != 0) {
                    if (!empty($filtro_where)) {
                        $filtro_where .= " AND ";
                    }
                    $filtro_where .= "$tbl_lote.id_lote = $lote";
                }

                if (!empty($filtro_where)) {
                    $filtro_where = "WHERE " . $filtro_where;
                }

                // Consulta de digitación para uroanalisis
                $qry_principal = "SELECT 
                    $tbl_digitaciones_uroanalisis.id_digitaciones_uroanalisis
                FROM 
                    $tbl_digitaciones_uroanalisis
                    JOIN $tbl_laboratorio ON $tbl_laboratorio.id_laboratorio = $tbl_digitaciones_uroanalisis.id_laboratorio
                    JOIN $tbl_programa ON $tbl_programa.id_programa = $tbl_digitaciones_uroanalisis.id_programa
                    JOIN $tbl_lote ON $tbl_lote.id_lote = $tbl_digitaciones_uroanalisis.id_lote
                $filtro_where";

                $qryArrayPrincipal = mysql_query($qry_principal);
                mysqlException(mysql_error(), "_02");
                $digitacion = array();
                while ($qryDataPrincipal = mysql_fetch_array($qryArrayPrincipal)) {

                    $digitacionActual = [];

                    $digitacionActual["id_digitaciones_uroanalisis"] = $qryDataPrincipal["id_digitaciones_uroanalisis"];

                    $digitacion[] = $digitacionActual;
                }


                echo '<response code="1">' . json_encode($digitacion) . '</response>';
            }
            // response_all_principal
            // echo json_encode($response_all_principal);

            /* ************************** */
        } else {
            echo '<response code="422">El programa no es Cualitativo</response>';
        }
        break;

    case "SeeInfoModificacion":
        actionRestriction_102();
        if ($tipo_programa == "cualitativo") {

            // Id de digitacion
            $idreferencia = intval($data_ajax->idreferencia);
            $idLaboratorio = $data_ajax->laboratorio;
            $idprograma = $data_ajax->programa;
            $idLote = $data_ajax->lote;

            // Estructura de futuro JSON
            $estructura_general = array();


            // $qryAnalitos = "SELECT cla.id_configuracion, cla.id_analito, a.nombre_analito FROM configuracion_laboratorio_analito cla
            //                 JOIN analito a On a.id_analito = cla.id_analito
            //                 WHERE id_laboratorio = $idLaboratorio AND id_programa = $idprograma";

            $qryAnalitos = "SELECT      cla.id_configuracion, 
                                        cla.id_analito, 
                                        a.nombre_analito ,
                                        ana.nombre_analizador
                                        FROM configuracion_laboratorio_analito cla
                                        JOIN analito a ON a.id_analito = cla.id_analito
                                        JOIN analizador ana ON ana.id_analizador = cla.id_analizador
                                        WHERE id_laboratorio = $idLaboratorio AND id_programa = $idprograma";

            $qryArrayAnalitos = mysql_query($qryAnalitos);
            mysqlException(mysql_error(), "_03");
            while ($qryData = mysql_fetch_array($qryArrayAnalitos)) {
                $idAnalito = $qryData["id_analito"];
                $idConfiguracion = intval($qryData["id_configuracion"]);
                $analitoActual = [];
                $analitoActual["id_analito"] = $idAnalito;
                $analitoActual["nombre_analito"] = $qryData["nombre_analito"];
                $analitoActual["nombre_analizador"] = $qryData["nombre_analizador"];
                $analitoActual["id_configuracion"] = $qryData["id_configuracion"];

                $digitacionActual = [];
                $digitacionActualInfo = [];


                $qryPosiblesResultados = "SELECT carrc.id_analito_resultado_reporte_cualitativo , arrc.desc_resultado_reporte_cualitativo
                                            FROM configuracion_analito_resultado_reporte_cualitativo carrc 
                                            JOIN analito_resultado_reporte_cualitativo arrc ON arrc.id_analito_resultado_reporte_cualitativo = carrc.id_analito_resultado_reporte_cualitativo
                                            WHERE carrc.id_configuracion = $idConfiguracion";

                $qryArrayPosiblesResultado = mysql_query($qryPosiblesResultados);
                mysqlException(mysql_error(), "_04");
                $desc_posibles_resultados = array();
                while ($qryDataPosibles = mysql_fetch_array($qryArrayPosiblesResultado)) {
                    $descripcion = array();
                    $descripcion["id"] = $qryDataPosibles["id_analito_resultado_reporte_cualitativo"];
                    $descripcion["descripcion"] = $qryDataPosibles["desc_resultado_reporte_cualitativo"];
                    $desc_posibles_resultados[] = $descripcion;
                }
                $analitoActual["descripcion_posibles_resultados"] = $desc_posibles_resultados;
                // $estructura_general["analitos"][] = $analitoActual;


                // Consulta de digitacion general
                $qryDigitacion = "SELECT DISTINCT  dig.id_digitaciones_uroanalisis, 
                                dig.id_laboratorio,
                                lab.no_laboratorio,
                                lab.nombre_laboratorio, 
                                dig.id_programa, 
                                prog.nombre_programa,
                                tipo.desc_tipo_programa,
                                dig.id_lote,
                                lote.nombre_lote,
                                lote.nivel_lote,
                                lote.fecha_vencimiento
                                FROM digitaciones_uroanalisis dig
                                JOIN laboratorio lab ON lab.id_laboratorio = dig.id_laboratorio
                                JOIN programa prog ON prog.id_programa = dig.id_programa
                                JOIN lote ON lote.id_lote = dig.id_lote
                                JOIN tipo_programa tipo on tipo.id_tipo_programa = prog.id_tipo_programa
                                WHERE dig.id_digitaciones_uroanalisis = $idreferencia";

                $qryArrayDigitacion = mysql_query($qryDigitacion);
                mysqlException(mysql_error(), "_05");
                while ($qryDataPrincipal = mysql_fetch_array($qryArrayDigitacion)) {

                    $digitacionActualInfo["id_digitaciones_uroanalisis"] = $qryDataPrincipal["id_digitaciones_uroanalisis"];
                    $digitacionActualInfo["id_laboratorio"] = $qryDataPrincipal["id_laboratorio"];
                    $digitacionActualInfo["no_laboratorio"] = $qryDataPrincipal["no_laboratorio"];
                    $digitacionActualInfo["nombre_laboratorio"] = $qryDataPrincipal["nombre_laboratorio"];
                    $digitacionActualInfo["id_programa"] = $qryDataPrincipal["id_programa"];
                    $digitacionActualInfo["nombre_programa"] = $qryDataPrincipal["nombre_programa"];
                    $digitacionActualInfo["desc_tipo_programa"] = $qryDataPrincipal["desc_tipo_programa"];

                    $digitacionActualInfo["id_lote"] = $qryDataPrincipal["id_lote"];
                    $digitacionActualInfo["nombre_lote"] = $qryDataPrincipal["nombre_lote"];
                    $digitacionActualInfo["nivel_lote"] = $qryDataPrincipal["nivel_lote"];
                    $digitacionActualInfo["fecha_vencimiento"] = $qryDataPrincipal["fecha_vencimiento"];
                }

                // Consulta de digitación resultados verdaderos
                $qryResultadosVerdaderos = "SELECT 
                    digitacion_resultados_verdaderos.mesurando_resultado_reporte_cualitativo_id
                    FROM 
                    digitacion_resultados_verdaderos
                    join analito on analito.id_analito = digitacion_resultados_verdaderos.mesurando_id
                    WHERE
                    digitacion_resultados_verdaderos.id_digitacion_uroanalisis = $idreferencia AND
                    digitacion_resultados_verdaderos.id_configuracion = $idConfiguracion
                    ORDER BY analito.nombre_analito";

                $qryArrayVerdaderos = mysql_query($qryResultadosVerdaderos);
                mysqlException(mysql_error(), "_06");
                $digitacion_resultados_verdaderos = array();

                while ($qryData = mysql_fetch_array($qryArrayVerdaderos)) {
                    $consolidado_tbl_temp = array();
                    $consolidado_tbl_temp["id_resultado_verdadero"] = $qryData["mesurando_resultado_reporte_cualitativo_id"];
                    $digitacion_resultados_verdaderos[] = $consolidado_tbl_temp;
                }
                $analitoActual["digitacion_resultados_verdaderos"] = $digitacion_resultados_verdaderos;

                // $primeraQryCompInternacional = "SELECT DISTINCT
                //         ci.id_mesurando,
                //         mv.numero_lab,
                //         mv.numero_points
                //     FROM 
                //         comparaciones_internacionales ci
                //     JOIN mesurando_valores mv ON ci.id_mesurando = mv.id_mesurando
                //     WHERE
                //         ci.id_digitacion_uroanalisis = $idreferencia AND mv.id_digitaciones_uroanalisis = $idreferencia
                //         AND ci.id_configuracion = $idConfiguracion AND mv.id_configuracion = $idConfiguracion";
                $primeraQryCompInternacional = "SELECT DISTINCT
                        drv.mesurando_id,
                        mv.numero_lab,
                        mv.numero_points
                    FROM 
                        digitacion_resultados_verdaderos drv
                    JOIN mesurando_valores mv ON drv.id_configuracion = mv.id_configuracion
                    WHERE
                        drv.id_digitacion_uroanalisis = $idreferencia AND mv.id_digitaciones_uroanalisis = $idreferencia AND drv.mesurando_id = $idAnalito AND 
                        mv.id_mesurando = $idAnalito AND mv.id_configuracion = $idConfiguracion";

                $qryArrayInternacional1 = mysql_query($primeraQryCompInternacional);
                mysqlException(mysql_error(), "_07");

                $dig_result_internacional = array();

                while ($qryData = mysql_fetch_array($qryArrayInternacional1)) {
                    $id_analito = $qryData["mesurando_id"];

                    // array temporal
                    $consolidado_tbl_temp = array();
                    $consolidado_tbl_temp["idAnalito"] = $id_analito;
                    $consolidado_tbl_temp["id_configuracion"] = $idConfiguracion;
                    $consolidado_tbl_temp["nLab"] = $qryData["numero_lab"];
                    $consolidado_tbl_temp["nPoints"] = $qryData["numero_points"];

                    // Consulta para resultados verdaderos
                    $segundaQryCompInternacional = "SELECT
                            ci.id_mesurando_resultado_reporte_cualitativo
                            FROM 
                            comparaciones_internacionales ci
                            WHERE
                            ci.id_mesurando = $id_analito AND id_digitacion_uroanalisis  = $idreferencia
                            AND ci.id_configuracion = $idConfiguracion";


                    $qryArrayInternacional2 = mysql_query($segundaQryCompInternacional);
                    mysqlException(mysql_error(), "_08");

                    $idsResultadosVerdaderos = array();
                    while ($qryData2 = mysql_fetch_array($qryArrayInternacional2)) {
                        $idsResultadosVerdaderos[] = $qryData2["id_mesurando_resultado_reporte_cualitativo"];
                    }

                    // Agregamos resultados verdaderos al consolidado
                    $consolidado_tbl_temp["ids_resultados_verdaderos"] = $idsResultadosVerdaderos;

                    // Agregamos todo al array final
                    $dig_result_internacional[] = $consolidado_tbl_temp;
                }

                $dig_result_vav = array();

                // while ($qryData = mysql_fetch_array($qryArrayVAV1)) {
                    // $id_analito = $qryData["id_mesurando"];

                    $consolidado_tbl_temp = array();
                    // $consolidado_tbl_temp["idAnalito"] = $qryData["id_mesurando"];

                    // Consulta para resultados verdaderos vav por cada analito
                    $segundaQryCompVAV = "SELECT
                            rvav.id_mesurando_resultado_reporte_cualitativo
                            FROM 
                            $tbl_resultados_vav rvav
                            WHERE
                            rvav.id_mesurando  = $idAnalito AND id_digitaciones_uroanalisis = $idreferencia
                            AND rvav.id_configuracion = $idConfiguracion";


                    $qryArrayVAV2 = mysql_query($segundaQryCompVAV);
                    mysqlException(mysql_error(), "_x10");

                    $idsResultadosVerdaderos = array();
                    while ($qryData2 = mysql_fetch_array($qryArrayVAV2)) {
                        $idsResultadosVerdaderos[] = $qryData2["id_mesurando_resultado_reporte_cualitativo"];
                    }

                    // Agregamos resultados verdaderos al consolidado
                    $consolidado_tbl_temp["ids_resultados_verdaderos"] = $idsResultadosVerdaderos;

                    // Agregamos todo al array final
                    $dig_result_vav[] = $consolidado_tbl_temp;
                // }
                $analitoActual["result_comp_internacional"] = $dig_result_internacional;
                $analitoActual["result_comp_vav"] = $dig_result_vav;
                // $estructura_general["analitos"]["digitaciones"][] = $digitacionActual;

                $estructura_general["analitos"][] = $analitoActual;
            }

                $estructura_general["digitaciones"][] = $digitacionActualInfo;

            // $estructura_general["digitaciones"][] = $digitacionActual;
            // $estructura_general["digitaciones"][] = $digitacionActual;
            // }

            echo '<response code="1">' . json_encode($estructura_general) . '</response>';
        }
        break;

    case 'registro':
        actionRestriction_102();
        if ($tipo_programa == "cualitativo") {
            $datos_digitacion = $data_ajax->datos_digitacion;
            $iddigitacion = $data_ajax->id_digitacion;
            $laboratorio = $data_ajax->laboratorio;
            $programa = $data_ajax->programa;

            for ($a = 0; $a < sizeof($datos_digitacion); $a++) {
                $fila_actual = $datos_digitacion[$a];
                $analito = $fila_actual->idAnalito;
                $id_configuracion = $fila_actual->id_configuracion;
                $nLab = $fila_actual->nLab;
                $nPoints = $fila_actual->nPoints;
                for ($b = 0; $b < sizeof($fila_actual->resultados_verdaderos); $b++) {
                    $idResultadoVerdadero = $fila_actual->resultados_verdaderos[$b]->id;
                    $qry = "INSERT INTO digitacion_resultados_verdaderos(
                        id_digitacion_uroanalisis,
                        id_configuracion,
                        mesurando_id, 
                        mesurando_resultado_reporte_cualitativo_id
                    ) 
                    VALUES(
                        $iddigitacion,
                        $id_configuracion,
                        $analito,
                        $idResultadoVerdadero
                    );";
                    mysql_query($qry);
                    mysqlException(mysql_error(), "_x11");
                    $logQuery['INSERT'][$uSum] = $qry;
                    $uSum++;
                }
                if (isset($fila_actual->comparacion_internacional)) {
                    for ($c = 0; $c < sizeof($fila_actual->comparacion_internacional); $c++) {
                        $idResultadoComparacion = $fila_actual->comparacion_internacional[$c]->id;
                        $qry = "INSERT INTO comparaciones_internacionales(
                                id_digitacion_uroanalisis,
                                id_configuracion,
                                id_mesurando,
                                id_mesurando_resultado_reporte_cualitativo) 
                            VALUES(
                                $iddigitacion,
                                $id_configuracion,
                                $analito,
                                $idResultadoComparacion
                            );";
                        mysql_query($qry);
                        mysqlException(mysql_error(), "_x12");
                        $logQuery['INSERT'][$uSum] = $qry;
                        $uSum++;
                    }
                }
                for ($d = 0; $d < sizeof($fila_actual->comparaciones_vav); $d++) {
                    $idResultadoComparacion = $fila_actual->comparaciones_vav[$d]->id;
                    $qry = "INSERT INTO $tbl_resultados_vav(
                            id_digitaciones_uroanalisis,
                            id_configuracion,
                            id_mesurando,
                            id_mesurando_resultado_reporte_cualitativo) 
                        VALUES(
                            $iddigitacion,
                            $id_configuracion,
                            $analito,
                            $idResultadoComparacion
                        );";
                    mysql_query($qry);
                    mysqlException(mysql_error(), "_x13");
                    $logQuery['INSERT'][$uSum] = $qry;
                    $uSum++;
                }
                if ($nLab != "" && $nPoints != "") {
                    $qry = "INSERT INTO mesurando_valores(
                            id_digitaciones_uroanalisis,
                            id_configuracion,
                            id_mesurando,
                            numero_lab,
                            numero_points) 
                        VALUES(
                            $iddigitacion,
                            $id_configuracion,
                            $analito,
                            $nLab,
                            $nPoints);";
                    mysql_query($qry);
                    mysqlException(mysql_error(), "_x14");
                    $logQuery['INSERT'][$uSum] = $qry;
                    $uSum++;
                }
            }

            echo '<response code="1">1</response>';
        }
        break;

    case 'edicion':
        actionRestriction_102();
        if ($tipo_programa == "cualitativo") { // Si es cualitativo
            $datos_digitacion = $data_ajax->datos_digitacion;
            $iddigitacion = intval($data_ajax->id_digitacion);
            $idsResultadosVerdaderosEliminar = $data_ajax->idsResultadosVerdaderosEliminar;
            $idsResultadosVerdaderosAgregar = $data_ajax->idsResultadosVerdaderosAgregar;
            $idsVerdaderosComparacionInternacionalAgregar = $data_ajax->idsVerdaderosComparacionInternacionalAgregar;
            $idsVerdaderosComparacionInternacionalEliminar = $data_ajax->idsVerdaderosComparacionInternacionalEliminar;
            $idsVerdaderosComparacionVAVAgregar = $data_ajax->idsVerdaderosComparacionVAVAgregar;
            $idsVerdaderosComparacionVAVEliminar = $data_ajax->idsVerdaderosComparacionVAVEliminar;
            //se eliminan resultados cualitativos que se tenian como verdaderos
            // if (!empty($idsResultadosVerdaderosEliminar)) {
            //     for ($i = 0; $i < sizeof($idsResultadosVerdaderosEliminar); $i++) {
            //         $idConfiguracion = $idsResultadosVerdaderosEliminar [$i]->id_configuracion;
            //         for($j = 0; $j < sizeof($idsResultadosVerdaderosEliminar->ids_resultados); $j++){
            //             $idResultado = intval($idsResultadosVerdaderosEliminar[$i]->ids_resultados[$j]);
    
            //             $qry = "DELETE FROM $tbl_digitacion_resultados_verdaderos 
            //                         WHERE mesurando_resultado_reporte_cualitativo_id = $idResultado 
            //                         AND id_digitacion_uroanalisis = $iddigitacion AND id_configuracion = $idConfiguracion";
    
            //             mysql_query($qry);
            //             mysqlException(mysql_error(), "_x15");
            //             $logQuery['DELETE'][$i] = $qry;
            //         }
            //     }    
            // }
            if (!empty($idsResultadosVerdaderosEliminar)) {
                for ($i = 0; $i < sizeof($idsResultadosVerdaderosEliminar); $i++) {
                    $idConfiguracion = $idsResultadosVerdaderosEliminar[$i]->id_configuracion;
                    $resultados = $idsResultadosVerdaderosEliminar[$i]->ids_resultados;
                    
                    for($j = 0; $j < sizeof($resultados); $j++) {
                        $idResultado = intval($resultados[$j]);

                        $qry = "DELETE FROM $tbl_digitacion_resultados_verdaderos 
                                WHERE mesurando_resultado_reporte_cualitativo_id = $idResultado 
                                AND id_digitacion_uroanalisis = $iddigitacion 
                                AND id_configuracion = $idConfiguracion";

                        mysql_query($qry);
                        mysqlException(mysql_error(), "_x15");
                        $logQuery['DELETE'][$i] = $qry;
                    }
                }    
            }
            //se agregan nuevos resultados cualitativos como verdaderos
            if (!empty($idsResultadosVerdaderosAgregar)) {
                for ($i = 0; $i < sizeof($idsResultadosVerdaderosAgregar); $i++) {
                    $idConfiguracion = $idsResultadosVerdaderosAgregar[$i]->id_configuracion;
                    $id_analito = intval($idsResultadosVerdaderosAgregar[$i]->analito);
                    $resultados = $idsResultadosVerdaderosAgregar[$i]->ids_resultados;
        
                    for ($j = 0; $j < sizeof($resultados); $j++) {
                            $id_resultado = intval($resultados[$j]);
        
                            $qry = "INSERT INTO digitacion_resultados_verdaderos (
                                            id_digitacion_uroanalisis,
                                            id_configuracion,
                                            mesurando_id,
                                            mesurando_resultado_reporte_cualitativo_id
                                        ) VALUES (
                                            $iddigitacion,
                                            $idConfiguracion,
                                            $id_analito,
                                            $id_resultado
                                        )";
        
                            mysql_query($qry);
                            mysqlException(mysql_error(), "_x16");
                            $logQuery['INSERT'][$i . '-' . $j] = $qry;
                    }
                }
            }
            //se eliminan resultados cualitativos que se tenian como verdaderos en comparacion internacional
            // if (!empty($idsVerdaderosComparacionInternacionalEliminar)) {
            //     for ($a = 0; $a < count($datos_digitacion); $a++) {
            //         $idConfiguracion = $datos_digitacion[$a]->id_configuracion;
            //         for ($b = 0; $b < sizeof($idsVerdaderosComparacionInternacionalEliminar); $b++) {
            //             $idResultadoEliminar = $idsVerdaderosComparacionInternacionalEliminar[$b];
            //             $qry = "DELETE FROM $tbl_comparaciones_internacionales 
            //                     WHERE id_mesurando_resultado_reporte_cualitativo = $idResultadoEliminar 
            //                     AND id_digitacion_uroanalisis = $iddigitacion AND id_configuracion = $idConfiguracion";

            //             mysql_query($qry);
            //             mysqlException(mysql_error(), "_x17");
            //             $logQuery['DELETE'][$b] = $qry;
            //         }
            //     }
            // }
            if (!empty($idsVerdaderosComparacionInternacionalEliminar)) {
                for ($b = 0; $b < sizeof($idsVerdaderosComparacionInternacionalEliminar); $b++) {
                    $idConfiguracion = $idsVerdaderosComparacionInternacionalEliminar[$b]->id_configuracion;
                    $idsResultados = $idsVerdaderosComparacionInternacionalEliminar[$b]->ids_resultados;
    
                    foreach ($idsResultados as $idResultadoEliminar) {
                        $qry = "DELETE FROM $tbl_comparaciones_internacionales 
                                WHERE id_mesurando_resultado_reporte_cualitativo = $idResultadoEliminar 
                                AND id_digitacion_uroanalisis = $iddigitacion 
                                AND id_configuracion = $idConfiguracion";
                        mysql_query($qry);
                        mysqlException(mysql_error(), "_x17");
                    }
                }
            }


            $i = 0;
            $j = 0;
            $iUpdate = 0;
            $iInsert = 0;
            //se agregan nuevos resultados cualitativos como verdaderos para comparacion internacional
            for ($a = 0; $a < count($datos_digitacion); $a++) {
                $idAnalito = intval($datos_digitacion[$a]->analito);
                $idConfiguracion = $datos_digitacion[$a]->id_configuracion;
                $nLab = intval($datos_digitacion[$a]->nLab);
                $nPoints = intval($datos_digitacion[$a]->nPoints);
                if (isset($idsVerdaderosComparacionInternacionalAgregar[$a]->ids_resultados)) {
                    $id_analito = intval($idsVerdaderosComparacionInternacionalAgregar[$a]->analito);
                    $id_Configuracion = intval($idsVerdaderosComparacionInternacionalAgregar[$a]->id_configuracion);
                    $idsResultados = $idsVerdaderosComparacionInternacionalAgregar[$a]->ids_resultados;
                    for ($b = 0; $b < sizeof($idsResultados); $b++) {
                        $idResultado = $idsResultados[$b];
                        $qry = "INSERT INTO comparaciones_internacionales (
                            id_digitacion_uroanalisis,
                            id_configuracion,
                            id_mesurando,
                            id_mesurando_resultado_reporte_cualitativo
                        ) VALUES (
                            $iddigitacion,
                            $id_Configuracion,
                            $id_analito,
                            $idResultado
                        )";

                        mysql_query($qry);
                        mysqlException(mysql_error(), "_x18");
                        $logQuery['INSERT'][$i . '-' . $j] = $qry;
                        $j++;
                    }
                }

                $qry = "SELECT id_mesurando_valores  FROM mesurando_valores WHERE id_digitaciones_uroanalisis  = $iddigitacion AND id_mesurando  = $idAnalito AND id_configuracion = $idConfiguracion";

                $resultado = mysql_query($qry);
                if (!$resultado) {
                    die("Error en la consulta: " . mysql_error());
                }
                $checkrows = mysql_num_rows($resultado);
                mysqlException(mysql_error(), "_19");

                if ($checkrows > 0) {
                    $qryUpdate = "UPDATE mesurando_valores 
                                SET numero_lab='$nLab', numero_points='$nPoints'
                                WHERE id_mesurando = '$idAnalito' AND id_digitaciones_uroanalisis = $iddigitacion AND id_configuracion = $idConfiguracion";
                    mysql_query($qryUpdate);
                    mysqlException(mysql_error(), "_x20");
                    $logQuery['UPDATE'][$iUpdate] = $qryUpdate;
                    $iUpdate++;
                } else {

                    $qryInsert = "INSERT INTO mesurando_valores(id_digitaciones_uroanalisis, id_configuracion, id_mesurando , numero_lab, numero_points) 
                    VALUES($iddigitacion, $idConfiguracion, $idAnalito, '$nLab','$nPoints')";
                    mysql_query($qryInsert);
                    mysqlException(mysql_error(), "_21");
                    $logQuery['INSERT'][$iInsert] = $qryInsert;
                    $iInsert++;
                }
            }
            //se eliminan resultados cualitativos que se tenian como verdaderos en comparacion vav
            if (!empty($idsVerdaderosComparacionVAVEliminar)) {
                for ($i = 0; $i < sizeof($idsVerdaderosComparacionVAVEliminar); $i++) {
                    $idConfiguracion = $idsVerdaderosComparacionVAVEliminar[$i]->id_configuracion;
                    $resultados = $idsVerdaderosComparacionVAVEliminar[$i]->ids_resultados;
                    for($j = 0; $j < sizeof($resultados); $j++) {
                        $idResultado = intval($resultados[$j]);
                        $qry = "DELETE FROM $tbl_resultados_vav 
                                WHERE id_mesurando_resultado_reporte_cualitativo = $idResultado 
                                AND id_digitaciones_uroanalisis = $iddigitacion AND id_configuracion = $idConfiguracion";
                        mysql_query($qry);
                        mysqlException(mysql_error(), "_x20");
                    }
                }
                
            }
            //se agregan nuevos resultados cualitativos como verdaderos para vav
            if (!empty($idsVerdaderosComparacionVAVAgregar)) {
                for ($i = 0; $i < sizeof($idsVerdaderosComparacionVAVAgregar); $i++) {
                    $idConfiguracion = $idsVerdaderosComparacionVAVAgregar[$i]->id_configuracion;
                    $id_analito = intval($idsVerdaderosComparacionVAVAgregar[$i]->analito);
                    $resultados = $idsVerdaderosComparacionVAVAgregar[$i]->ids_resultados;
    
                    for ($j = 0; $j < sizeof($resultados); $j++) {
                        $id_resultado = intval($resultados[$j]);
    
                        $qry = "INSERT INTO $tbl_resultados_vav (
                                        id_digitaciones_uroanalisis,
                                        id_configuracion,
                                        id_mesurando,
                                        id_mesurando_resultado_reporte_cualitativo
                                    ) VALUES (
                                        $iddigitacion,
                                        $idConfiguracion,
                                        $id_analito,
                                        $id_resultado
                                    )";
    
                        mysql_query($qry);
                        mysqlException(mysql_error(), "_x21");
                        // $logQuery['INSERT'][$i . '-' . $j] = $qry;
                    }
                }
            }

            echo '<response code="1">1</response>';
        }
        break;

    default:
        echo '<response code="0">PHP dataChangeHandler error: not found</response>';
        break;
}
exit;
