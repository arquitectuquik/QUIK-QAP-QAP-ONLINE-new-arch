<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}


session_start();
include_once "verifica_sesion.php";
include_once "complementos/grubbs.php";

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
    case "eliminarGestion":
        actionRestriction_100(); // Solo pueden eliminar los analitos los coordinadores
        if ($tipo_programa == "cuantitativo") { // Si el programa es cuantitativo
            $idreferencia = $data_ajax->idreferencia;
            $qry = "DELETE FROM $tbl_digitacion_cuantitativa WHERE id_digitacion_cuantitativa = $idreferencia";
            mysql_query($qry);
            mysqlException(mysql_error(), "_0x20");
            $logQuery['DELETE'][$dSum] = $qry;
            $dSum++;
            echo '<response code="1">1</response>';
        } else { // Si el programa es cualitativo

        }
        break;

    case 'registro':
        actionRestriction_102();

        if ($tipo_programa == "cuantitativo") { // Si es cuantitativo
            $datos_digitacion = $data_ajax->datos_digitacion;
            $programa = $data_ajax->programa;
            $lote = $data_ajax->lote;
            $mes = $data_ajax->mes;

            // Insercion de la digitacion normal
            $qry = "INSERT INTO digitacion(id_programa, id_lote, mes) VALUES($programa, $lote, '$mes')";
            mysql_query($qry);
            mysqlException(mysql_error(), "_0x21");

            $qry = "SELECT last_insert_id() as ultimo";
            $qryArray = mysql_query($qry);
            mysqlException(mysql_error(), "_01");
            while ($qryData = mysql_fetch_array($qryArray)) {
                $ultimo_id = $qryData["ultimo"];
            }

            for ($i = 0; $i < sizeof($datos_digitacion); $i++) {
                $fila_actual = $datos_digitacion[$i];
                $tipo = $fila_actual->tipo;
                $analito = $fila_actual->analito;
                $analizador = $fila_actual->analizador;
                $reactivo = $fila_actual->reactivo;
                $metodologia = $fila_actual->metodologia;
                $unidad = $fila_actual->unidad;
                $unidad_mc = $fila_actual->unidad_mc;
                $gen_vitros = ((isset($fila_actual->gen_vitros) && $fila_actual->gen_vitros != "" && $fila_actual->gen_vitros != "NULL") ? $fila_actual->gen_vitros : 1);
                $media_mensual = $fila_actual->media_mensual;
                $de_mensual = $fila_actual->de_mensual;
                $cv_mensual = $fila_actual->cv_mensual;
                $nlab_mensual = $fila_actual->nlab_mensual;
                $npuntos_mensual = $fila_actual->npuntos_mensual;
                $media_acumulada = $fila_actual->media_acumulada;
                $de_acumulada = $fila_actual->de_acumulada;
                $cv_acumulada = $fila_actual->cv_acumulada;
                $nlab_acumulada = $fila_actual->nlab_acumulada;
                $npuntos_acumulada = $fila_actual->npuntos_acumulada;
                $media_jctlm = $fila_actual->media_jctlm;
                $etmp_jctlm = $fila_actual->etmp_jctlm;
                $media_inserto = $fila_actual->media_inserto;
                $de_inserto = $fila_actual->de_inserto;
                $cv_inserto = $fila_actual->cv_inserto;
                $n_inserto = $fila_actual->n_inserto;
                $qry = "INSERT INTO digitacion_cuantitativa(
                                tipo_digitacion, 
                                id_digitacion,
                                id_analito, 
                                id_analizador, 
                                id_reactivo, 
                                id_metodologia, 
                                id_unidad, 
                                id_unidad_mc, 
                                id_gen_vitros,
                                media_mensual,
                                de_mensual,
                                cv_mensual,
                                n_lab_mensual,
                                n_puntos_mensual,
                                media_acumulada,
                                de_acumulada,
                                cv_acumulada,
                                n_lab_acumulada,
                                n_puntos_acumulada,
                                media_jctlm,
                                etmp_jctlm,
                                media_inserto,
                                de_inserto,
                                cv_inserto,
                                n_inserto
                            ) 
                            VALUES(
                                $tipo,
                                $ultimo_id,
                                $analito,
                                $analizador,
                                $reactivo,
                                $metodologia,
                                $unidad,
                                $unidad_mc,
                                $gen_vitros,
                                '$media_mensual',
                                '$de_mensual',
                                '$cv_mensual',
                                '$nlab_mensual',
                                '$npuntos_mensual',
                                '$media_acumulada',
                                '$de_acumulada',
                                '$cv_acumulada',
                                '$nlab_acumulada',
                                '$npuntos_acumulada',
                                '$media_jctlm',
                                '$etmp_jctlm',
                                '$media_inserto',
                                '$de_inserto',
                                '$cv_inserto',    
                                '$n_inserto'
                            );";
                mysql_query($qry);
                mysqlException(mysql_error(), "_0x22");
                $logQuery['INSERT'][$iSum] = $qry;
                $iSum++;
            }
            echo '<response code="1">1</response>';
        } else if ($tipo_programa == "cualitativo") {
            // Si el programa es cualitativo
        }
        break;

    case "eliminacion":

        actionRestriction_0();
        $idreferencia = $data_ajax->idreferencia;
        $qry = "DELETE FROM $tbl_digitacion WHERE id_digitacion = $idreferencia";
        mysql_query($qry);
        mysqlException(mysql_error(), "_0x23");
        $logQuery['DELETE'][$dSum] = $qry;
        $dSum++;
        // $qry = "UPDATE $tbl_digitacion SET estado = 0 WHERE id_digitacion = $idreferencia";
        echo '<response code="1">1</response>';

        break;

    case 'visualizacion':
        actionRestriction_102();
        if ($tipo_programa == "cuantitativo") { // Si el programa es cuantitativo

            $programa = $data_ajax->programa;
            $lote = $data_ajax->lote; // Si es todos es 0
            $mes_inicial = $data_ajax->mes_inicial . "-01"; // Siempre esta definido 
            $mes_final = $data_ajax->mes_final . "-01"; // Siempre esta definido

            $filtro_where = "where digitacion.estado = 1 ";

            // Selección de valores registrados
            if ($programa != 0) {
                $filtro_where = $filtro_where . " and $tbl_programa.id_programa = $programa";
            }

            if ($lote != 0) {
                $filtro_where = $filtro_where . " and $tbl_lote.id_lote = $lote";
            }

            $filtro_where = $filtro_where . " and ($tbl_digitacion.mes >= '$mes_inicial' and $tbl_digitacion.mes <= '$mes_final')";


            // Consulta de digitación
            $qry_principal = "SELECT 
                    digitacion.id_digitacion,
                    programa.id_programa,
                    programa.nombre_programa,
                    lote.nombre_lote,
                    digitacion.mes,
                    digitacion.estado
                FROM 
                    digitacion
                    join programa on programa.id_programa = digitacion.id_programa
                    join lote on lote.id_lote = digitacion.id_lote
                $filtro_where
                ";

            $qryArrayPrincipal = mysql_query($qry_principal);
            mysqlException(mysql_error(), "_01");

            $digitacion = array();

            while ($qryDataPrincipal = mysql_fetch_array($qryArrayPrincipal)) {

                $digitacionActual = [];

                $digitacionActual["id_digitacion"] = $qryDataPrincipal["id_digitacion"];
                $digitacionActual["id_programa"] = $qryDataPrincipal["id_programa"];
                $digitacionActual["nombre_programa"] = $qryDataPrincipal["nombre_programa"];
                $digitacionActual["nombre_lote"] = $qryDataPrincipal["nombre_lote"];
                $digitacionActual["mes"] = $qryDataPrincipal["mes"];
                $digitacionActual["estado"] = $qryDataPrincipal["nombre_lote"];

                $id_digitacion = $qryDataPrincipal["id_digitacion"];

                // Consulta de digitación
                $qry_secundaria = "SELECT 
                            digitacion_cuantitativa.id_digitacion_cuantitativa,
                            digitacion_cuantitativa.id_digitacion,
                            digitacion_cuantitativa.tipo_digitacion,
                            analito.nombre_analito,
                            analizador.nombre_analizador,
                            reactivo.nombre_reactivo,
                            metodologia.nombre_metodologia,
                            unidad.nombre_unidad,
                            gen_vitros.valor_gen_vitros,
                            digitacion_cuantitativa.media_mensual,
                            digitacion_cuantitativa.de_mensual,
                            digitacion_cuantitativa.cv_mensual,
                            digitacion_cuantitativa.n_lab_mensual,
                            digitacion_cuantitativa.n_puntos_mensual,
                            
                            digitacion_cuantitativa.media_acumulada,
                            digitacion_cuantitativa.de_acumulada,
                            digitacion_cuantitativa.cv_acumulada,
                            digitacion_cuantitativa.n_lab_acumulada,
                            digitacion_cuantitativa.n_puntos_acumulada,
                            
                            digitacion_cuantitativa.media_jctlm,
                            digitacion_cuantitativa.etmp_jctlm,
                            
                            digitacion_cuantitativa.media_inserto,
                            digitacion_cuantitativa.de_inserto,
                            digitacion_cuantitativa.cv_inserto,
                            digitacion_cuantitativa.n_inserto
                        FROM 
                            digitacion_cuantitativa
                            join analito on analito.id_analito = digitacion_cuantitativa.id_analito
                            join analizador on analizador.id_analizador = digitacion_cuantitativa.id_analizador
                            join reactivo on reactivo.id_reactivo = digitacion_cuantitativa.id_reactivo
                            join metodologia on metodologia.id_metodologia = digitacion_cuantitativa.id_metodologia
                            join unidad on unidad.id_unidad = digitacion_cuantitativa.id_unidad
                            join gen_vitros on gen_vitros.id_gen_vitros = digitacion_cuantitativa.id_gen_vitros 

                        WHERE
                            digitacion_cuantitativa.id_digitacion = $id_digitacion
                        ORDER BY analito.nombre_analito
                    ";

                $qryArraySecundaria = mysql_query($qry_secundaria);
                mysqlException(mysql_error(), "_01");

                $digitacion_cuantitativa = array();

                while ($qryDataSecundaria = mysql_fetch_array($qryArraySecundaria)) {

                    $consolidado_tbl_temp = array();

                    $consolidado_tbl_temp["id_digitacion_cuantitativa"] = $qryDataSecundaria["id_digitacion_cuantitativa"];
                    $consolidado_tbl_temp["id_digitacion"] = $qryDataSecundaria["id_digitacion"];
                    $consolidado_tbl_temp["tipo_digitacion"] = $qryDataSecundaria["tipo_digitacion"];
                    $consolidado_tbl_temp["nombre_analito"] = $qryDataSecundaria["nombre_analito"];
                    $consolidado_tbl_temp["nombre_analizador"] = $qryDataSecundaria["nombre_analizador"];
                    $consolidado_tbl_temp["nombre_reactivo"] = $qryDataSecundaria["nombre_reactivo"];
                    $consolidado_tbl_temp["nombre_metodologia"] = $qryDataSecundaria["nombre_metodologia"];
                    $consolidado_tbl_temp["nombre_unidad"] = $qryDataSecundaria["nombre_unidad"];
                    $consolidado_tbl_temp["valor_gen_vitros"] = $qryDataSecundaria["valor_gen_vitros"];
                    $consolidado_tbl_temp["media_mensual"] = $qryDataSecundaria["media_mensual"];
                    $consolidado_tbl_temp["de_mensual"] = $qryDataSecundaria["de_mensual"];
                    $consolidado_tbl_temp["cv_mensual"] = $qryDataSecundaria["cv_mensual"];
                    $consolidado_tbl_temp["n_lab_mensual"] = $qryDataSecundaria["n_lab_mensual"];
                    $consolidado_tbl_temp["n_puntos_mensual"] = $qryDataSecundaria["n_puntos_mensual"];
                    $consolidado_tbl_temp["media_acumulada"] = $qryDataSecundaria["media_acumulada"];
                    $consolidado_tbl_temp["de_acumulada"] = $qryDataSecundaria["de_acumulada"];
                    $consolidado_tbl_temp["cv_acumulada"] = $qryDataSecundaria["cv_acumulada"];
                    $consolidado_tbl_temp["n_lab_acumulada"] = $qryDataSecundaria["n_lab_acumulada"];
                    $consolidado_tbl_temp["n_puntos_acumulada"] = $qryDataSecundaria["n_puntos_acumulada"];
                    $consolidado_tbl_temp["media_jctlm"] = $qryDataSecundaria["media_jctlm"];
                    $consolidado_tbl_temp["etmp_jctlm"] = $qryDataSecundaria["etmp_jctlm"];
                    $consolidado_tbl_temp["media_inserto"] = $qryDataSecundaria["media_inserto"];
                    $consolidado_tbl_temp["de_inserto"] = $qryDataSecundaria["de_inserto"];
                    $consolidado_tbl_temp["cv_inserto"] = $qryDataSecundaria["cv_inserto"];
                    $consolidado_tbl_temp["n_inserto"] = $qryDataSecundaria["n_inserto"];

                    $digitacion_cuantitativa[] = $consolidado_tbl_temp;

                }

                $digitacionActual["digitacion_cuantitativa"] = $digitacion_cuantitativa;
                $digitacion[] = $digitacionActual;
            }


            echo '<response code="1">' . json_encode($digitacion) . '</response>';

            // response_all_principal
            // echo json_encode($response_all_principal);

            /* ************************** */

        } else if ($tipo_programa == "cualitativo") { // Si el programa es cualitativo

        }
        break;

    case "SeeInfoModificacion":
        actionRestriction_102();
        if ($tipo_programa == "cuantitativo") { // Si es cuantitativo

            // Id de digitacion
            $idreferencia = $data_ajax->idreferencia;
            $idprograma = $data_ajax->idprograma;

            // Estructura de futuro JSON
            $estructura_general = array();


            // Consulta de lotes
            $qryLotes = "SELECT 
                        $tbl_lote.id_lote,
                        $tbl_lote.nombre_lote,
                        $tbl_lote.nivel_lote,
                        $tbl_lote.fecha_vencimiento 
                    FROM 
                        $tbl_lote 
                    ORDER BY $tbl_lote.nombre_lote ASC";
            $qryArrayLotes = mysql_query($qryLotes);
            mysqlException(mysql_error(), "_01");
            while ($qryData = mysql_fetch_array($qryArrayLotes)) {
                $estructura_general["lotes"][] = $qryData;
            }

            // Consulta de analitos
            $qryAnalitos = "SELECT 
                        $tbl_analito.id_analito,
                        $tbl_analito.nombre_analito 
                    FROM $tbl_analito 
                    JOIN $tbl_programa_analito on $tbl_programa_analito.id_analito = $tbl_analito.id_analito
                    WHERE $tbl_programa_analito.id_programa = $idprograma
                    order by $tbl_analito.nombre_analito";
            $qryArrayAnalitos = mysql_query($qryAnalitos);
            mysqlException(mysql_error(), "_01");
            while ($qryData = mysql_fetch_array($qryArrayAnalitos)) {
                $estructura_general["analitos"][] = $qryData;
            }


            // Consulta de analizadores
            $qryAnalizador = "SELECT 
                        $tbl_analizador.id_analizador,
                        $tbl_analizador.nombre_analizador 
                    FROM $tbl_analizador 
                    order by $tbl_analizador.nombre_analizador";
            $qryArrayAnalizador = mysql_query($qryAnalizador);
            mysqlException(mysql_error(), "_01");
            while ($qryData = mysql_fetch_array($qryArrayAnalizador)) {
                $estructura_general["analizadores"][] = $qryData;
            }


            // Consulta de reactivos
            $qryReactivo = "SELECT 
                        $tbl_reactivo.id_reactivo,
                        $tbl_reactivo.nombre_reactivo 
                    FROM $tbl_reactivo 
                    order by $tbl_reactivo.nombre_reactivo";
            $qryArrayReactivo = mysql_query($qryReactivo);
            mysqlException(mysql_error(), "_01");
            while ($qryData = mysql_fetch_array($qryArrayReactivo)) {
                $estructura_general["reactivos"][] = $qryData;
            }


            // Consulta de digitacion general
            $qryDigitacion = "SELECT 
                        digitacion.id_digitacion,
                        programa.id_programa,
                        programa.nombre_programa,
                        lote.id_lote,
                        lote.nombre_lote,
                        digitacion.mes,
                        digitacion.estado,
                        tipo_programa.desc_tipo_programa
                    FROM 
                        digitacion
                        join programa on programa.id_programa = digitacion.id_programa
                        join lote on lote.id_lote = digitacion.id_lote
                        join tipo_programa on tipo_programa.id_tipo_programa = programa.id_tipo_programa
                    WHERE digitacion.id_digitacion = $idreferencia;
                ";
            $qryArrayDigitacion = mysql_query($qryDigitacion);
            mysqlException(mysql_error(), "_01");
            while ($qryDataPrincipal = mysql_fetch_array($qryArrayDigitacion)) {

                $digitacionActual = [];

                $digitacionActual["id_digitacion"] = $qryDataPrincipal["id_digitacion"];
                $digitacionActual["id_programa"] = $qryDataPrincipal["id_programa"];
                $digitacionActual["nombre_programa"] = $qryDataPrincipal["nombre_programa"];
                $digitacionActual["desc_tipo_programa"] = $qryDataPrincipal["desc_tipo_programa"];
                $digitacionActual["id_lote"] = $qryDataPrincipal["id_lote"];
                $digitacionActual["nombre_lote"] = $qryDataPrincipal["nombre_lote"];
                $digitacionActual["mes"] = $qryDataPrincipal["mes"];
                $digitacionActual["estado"] = $qryDataPrincipal["nombre_lote"];

                $id_digitacion = $qryDataPrincipal["id_digitacion"];

                // Consulta de digitación
                $qry_secundaria = "SELECT 
                            digitacion_cuantitativa.id_digitacion_cuantitativa,
                            digitacion_cuantitativa.id_digitacion,
                            digitacion_cuantitativa.tipo_digitacion,
                            
                            analito.id_analito,
                            analito.nombre_analito,
                            analizador.id_analizador,
                            analizador.nombre_analizador,
                            reactivo.id_reactivo,
                            reactivo.nombre_reactivo,
                            metodologia.id_metodologia,
                            metodologia.nombre_metodologia,
                            unidad.id_unidad,
                            unidad.nombre_unidad,
                            IF(unidad_mc.id_unidad is null, '', unidad_mc.id_unidad) as id_unidad_mc,
                            IF(unidad_mc.nombre_unidad is null, '', unidad_mc.nombre_unidad) as nombre_unidad_mc,
                            gen_vitros.id_gen_vitros,
                            gen_vitros.valor_gen_vitros,

                            digitacion_cuantitativa.media_mensual,
                            digitacion_cuantitativa.de_mensual,
                            digitacion_cuantitativa.cv_mensual,
                            digitacion_cuantitativa.n_lab_mensual,
                            digitacion_cuantitativa.n_puntos_mensual,
                            
                            digitacion_cuantitativa.media_acumulada,
                            digitacion_cuantitativa.de_acumulada,
                            digitacion_cuantitativa.cv_acumulada,
                            digitacion_cuantitativa.n_lab_acumulada,
                            digitacion_cuantitativa.n_puntos_acumulada,
                            
                            digitacion_cuantitativa.media_jctlm,
                            digitacion_cuantitativa.etmp_jctlm,
                            
                            digitacion_cuantitativa.media_inserto,
                            digitacion_cuantitativa.de_inserto,
                            digitacion_cuantitativa.cv_inserto,
                            digitacion_cuantitativa.n_inserto
                        FROM 
                            digitacion_cuantitativa
                            join analito on analito.id_analito = digitacion_cuantitativa.id_analito
                            join analizador on analizador.id_analizador = digitacion_cuantitativa.id_analizador
                            join reactivo on reactivo.id_reactivo = digitacion_cuantitativa.id_reactivo
                            join metodologia on metodologia.id_metodologia = digitacion_cuantitativa.id_metodologia
                            join unidad on unidad.id_unidad = digitacion_cuantitativa.id_unidad
                            left join unidad unidad_mc on unidad_mc.id_unidad = digitacion_cuantitativa.id_unidad_mc
                            join gen_vitros on gen_vitros.id_gen_vitros = digitacion_cuantitativa.id_gen_vitros 

                        WHERE
                            digitacion_cuantitativa.id_digitacion = $id_digitacion
                        ORDER BY analito.nombre_analito, unidad.id_unidad, digitacion_cuantitativa.media_jctlm desc,  metodologia.id_metodologia, analizador.id_analizador
                    ";

                $qryArraySecundaria = mysql_query($qry_secundaria);
                mysqlException(mysql_error(), "_01");
                $digitacion_cuantitativa = array();

                while ($qryDataSecundaria = mysql_fetch_array($qryArraySecundaria)) {
                    $consolidado_tbl_temp = array();
                    $consolidado_tbl_temp["id_digitacion_cuantitativa"] = $qryDataSecundaria["id_digitacion_cuantitativa"];
                    $consolidado_tbl_temp["id_digitacion"] = $qryDataSecundaria["id_digitacion"];
                    $consolidado_tbl_temp["tipo_digitacion"] = $qryDataSecundaria["tipo_digitacion"];
                    $consolidado_tbl_temp["id_analito"] = $qryDataSecundaria["id_analito"];
                    $consolidado_tbl_temp["nombre_analito"] = $qryDataSecundaria["nombre_analito"];
                    $consolidado_tbl_temp["id_analizador"] = $qryDataSecundaria["id_analizador"];
                    $consolidado_tbl_temp["nombre_analizador"] = $qryDataSecundaria["nombre_analizador"];
                    $consolidado_tbl_temp["id_reactivo"] = $qryDataSecundaria["id_reactivo"];
                    $consolidado_tbl_temp["nombre_reactivo"] = $qryDataSecundaria["nombre_reactivo"];
                    $consolidado_tbl_temp["id_metodologia"] = $qryDataSecundaria["id_metodologia"];
                    $consolidado_tbl_temp["nombre_metodologia"] = $qryDataSecundaria["nombre_metodologia"];
                    $consolidado_tbl_temp["id_unidad"] = $qryDataSecundaria["id_unidad"];
                    $consolidado_tbl_temp["nombre_unidad"] = $qryDataSecundaria["nombre_unidad"];
                    $consolidado_tbl_temp["id_unidad_mc"] = $qryDataSecundaria["id_unidad_mc"];
                    $consolidado_tbl_temp["nombre_unidad_mc"] = $qryDataSecundaria["nombre_unidad_mc"];
                    $consolidado_tbl_temp["id_gen_vitros"] = $qryDataSecundaria["id_gen_vitros"];
                    $consolidado_tbl_temp["valor_gen_vitros"] = $qryDataSecundaria["valor_gen_vitros"];
                    $consolidado_tbl_temp["media_mensual"] = $qryDataSecundaria["media_mensual"];
                    $consolidado_tbl_temp["de_mensual"] = $qryDataSecundaria["de_mensual"];
                    $consolidado_tbl_temp["cv_mensual"] = $qryDataSecundaria["cv_mensual"];
                    $consolidado_tbl_temp["n_lab_mensual"] = $qryDataSecundaria["n_lab_mensual"];
                    $consolidado_tbl_temp["n_puntos_mensual"] = $qryDataSecundaria["n_puntos_mensual"];
                    $consolidado_tbl_temp["media_acumulada"] = $qryDataSecundaria["media_acumulada"];
                    $consolidado_tbl_temp["de_acumulada"] = $qryDataSecundaria["de_acumulada"];
                    $consolidado_tbl_temp["cv_acumulada"] = $qryDataSecundaria["cv_acumulada"];
                    $consolidado_tbl_temp["n_lab_acumulada"] = $qryDataSecundaria["n_lab_acumulada"];
                    $consolidado_tbl_temp["n_puntos_acumulada"] = $qryDataSecundaria["n_puntos_acumulada"];
                    $consolidado_tbl_temp["media_jctlm"] = $qryDataSecundaria["media_jctlm"];
                    $consolidado_tbl_temp["etmp_jctlm"] = $qryDataSecundaria["etmp_jctlm"];
                    $consolidado_tbl_temp["media_inserto"] = $qryDataSecundaria["media_inserto"];
                    $consolidado_tbl_temp["de_inserto"] = $qryDataSecundaria["de_inserto"];
                    $consolidado_tbl_temp["cv_inserto"] = $qryDataSecundaria["cv_inserto"];
                    $consolidado_tbl_temp["n_inserto"] = $qryDataSecundaria["n_inserto"];
                    $digitacion_cuantitativa[] = $consolidado_tbl_temp;
                }
                $digitacionActual["digitacion_cuantitativa"] = $digitacion_cuantitativa;
                $estructura_general["digitaciones"][] = $digitacionActual;
            }

            echo '<response code="1">' . json_encode($estructura_general) . '</response>';

        } else if ($tipo_programa == "cualitativo") {

        }
        break;

    case 'modificacion':
        actionRestriction_102();
        if ($tipo_programa == "cuantitativo") { // Si es cuantitativo
            $datos_digitacion = $data_ajax->datos_digitacion;
            $iddigitacion = $data_ajax->id_digitacion;
            $programa = $data_ajax->programa;
            $lote = $data_ajax->lote;
            $mes = $data_ajax->mes;

            // Insercion de la digitacion normal
            $qry = "UPDATE digitacion SET id_programa = $programa, id_lote = $lote, mes = '" . $mes . "'  WHERE id_digitacion = $iddigitacion";
            mysql_query($qry);
            mysqlException(mysql_error(), "_0x24");
            $logQuery['UPDATE'][$uSum] = $qry;
            $uSum++;

            for ($i = 0; $i < sizeof($datos_digitacion); $i++) {
                $fila_actual = $datos_digitacion[$i];
                $id_digitacion_cuantitativa = $fila_actual->id_digitacion_cuantitativa;
                $tipo = $fila_actual->tipo;
                $analito = $fila_actual->analito;
                $analizador = $fila_actual->analizador;
                $reactivo = $fila_actual->reactivo;
                $metodologia = $fila_actual->metodologia;
                $unidad = $fila_actual->unidad;
                $unidad_mc = $fila_actual->unidad_mc;
                $gen_vitros = ((isset($fila_actual->gen_vitros) && $fila_actual->gen_vitros != "" && $fila_actual->gen_vitros != "NULL") ? $fila_actual->gen_vitros : 1);
                $media_mensual = $fila_actual->media_mensual;
                $de_mensual = $fila_actual->de_mensual;
                $cv_mensual = $fila_actual->cv_mensual;
                $nlab_mensual = $fila_actual->nlab_mensual;
                $npuntos_mensual = $fila_actual->npuntos_mensual;
                $media_acumulada = $fila_actual->media_acumulada;
                $de_acumulada = $fila_actual->de_acumulada;
                $cv_acumulada = $fila_actual->cv_acumulada;
                $nlab_acumulada = $fila_actual->nlab_acumulada;
                $npuntos_acumulada = $fila_actual->npuntos_acumulada;
                $media_jctlm = $fila_actual->media_jctlm;
                $etmp_jctlm = $fila_actual->etmp_jctlm;
                $media_inserto = $fila_actual->media_inserto;
                $de_inserto = $fila_actual->de_inserto;
                $cv_inserto = $fila_actual->cv_inserto;
                $n_inserto = $fila_actual->n_inserto;

                // Realizar una modificacion o una insercion dependiendo del caso
                if ($id_digitacion_cuantitativa == 0) { // Se trata de un registro
                    $qry = "INSERT INTO digitacion_cuantitativa(
                            tipo_digitacion, 
                            id_digitacion,
                            id_analito, 
                            id_analizador, 
                            id_reactivo, 
                            id_metodologia, 
                            id_unidad, 
                            id_unidad_mc, 
                            id_gen_vitros,
                            media_mensual,
                            de_mensual,
                            cv_mensual,
                            n_lab_mensual,
                            n_puntos_mensual,
                            media_acumulada,
                            de_acumulada,
                            cv_acumulada,
                            n_lab_acumulada,
                            n_puntos_acumulada,
                            media_jctlm,
                            etmp_jctlm,
                            media_inserto,
                            de_inserto,
                            cv_inserto,
                            n_inserto
                        ) 
                        VALUES(
                            $tipo,
                            $iddigitacion,
                            $analito,
                            $analizador,
                            $reactivo,
                            $metodologia,
                            $unidad,
                            $unidad_mc,
                            $gen_vitros,
                            '$media_mensual',
                            '$de_mensual',
                            '$cv_mensual',
                            '$nlab_mensual',
                            '$npuntos_mensual',
                            '$media_acumulada',
                            '$de_acumulada',
                            '$cv_acumulada',
                            '$nlab_acumulada',
                            '$npuntos_acumulada',
                            '$media_jctlm',
                            '$etmp_jctlm',
                            '$media_inserto',
                            '$de_inserto',
                            '$cv_inserto',    
                            '$n_inserto'
                        );";
                    mysql_query($qry);
                    mysqlException(mysql_error(), "_0x14");
                    $logQuery['UPDATE'][$uSum] = $qry;
                    $uSum++;

                } else { // Se trata de una modificacion
                    $qry = "UPDATE digitacion_cuantitativa
                            SET 
                                tipo_digitacion = $tipo, 
                                id_digitacion = $iddigitacion,
                                id_analito = $analito, 
                                id_analizador = $analizador, 
                                id_reactivo = $reactivo, 
                                id_metodologia = $metodologia, 
                                id_unidad = $unidad, 
                                id_unidad_mc = $unidad_mc, 
                                id_gen_vitros = $gen_vitros,
                                media_mensual = '$media_mensual',
                                de_mensual = '$de_mensual',
                                cv_mensual = '$cv_mensual',
                                n_lab_mensual = '$nlab_mensual',
                                n_puntos_mensual = '$npuntos_mensual',
                                media_acumulada = '$media_acumulada',
                                de_acumulada = '$de_acumulada',
                                cv_acumulada = '$cv_acumulada',
                                n_lab_acumulada = '$nlab_acumulada',
                                n_puntos_acumulada = '$npuntos_acumulada',
                                media_jctlm = '$media_jctlm',
                                etmp_jctlm = '$etmp_jctlm',
                                media_inserto = '$media_inserto',
                                de_inserto = '$de_inserto',
                                cv_inserto = '$cv_inserto',
                                n_inserto = '$n_inserto'
                            WHERE id_digitacion_cuantitativa = $id_digitacion_cuantitativa;";
                    mysql_query($qry);
                    mysqlException(mysql_error(), "_0x15");
                    $logQuery['UPDATE'][$uSum] = $qry;
                    $uSum++;
                }
            }
            echo '<response code="1">1</response>';
        } else if ($tipo_programa == "cualitativo") {
            // Si el programa es cualitativo
        }
        break;

    case "SeeInfoAsignacion":
        actionRestriction_102();
        if ($tipo_programa == "cuantitativo") { // Si es cuantitativo

            // Id de digitacion
            $idreferencia = $data_ajax->idreferencia;
            $info_digitacion = array();

            // Consulta de digitacion general
            $qryDigitacion = "SELECT 
                        digitacion.id_digitacion,
                        programa.id_programa,
                        programa.nombre_programa,
                        lote.id_lote,
                        lote.nombre_lote,
                        digitacion.mes,
                        digitacion.estado,
                        tipo_programa.desc_tipo_programa
                    FROM 
                        digitacion
                        join programa on programa.id_programa = digitacion.id_programa
                        join lote on lote.id_lote = digitacion.id_lote
                        join tipo_programa on tipo_programa.id_tipo_programa = programa.id_tipo_programa
                    WHERE digitacion.id_digitacion = $idreferencia;
                ";
            $qryArrayDigitacion = mysql_query($qryDigitacion);
            mysqlException(mysql_error(), "_01");
            while ($qryDataPrincipal = mysql_fetch_array($qryArrayDigitacion)) {

                $digitacionActual = [];

                $digitacionActual["id_digitacion"] = $qryDataPrincipal["id_digitacion"];
                $digitacionActual["id_programa"] = $qryDataPrincipal["id_programa"];
                $digitacionActual["nombre_programa"] = $qryDataPrincipal["nombre_programa"];
                $digitacionActual["desc_tipo_programa"] = $qryDataPrincipal["desc_tipo_programa"];
                $digitacionActual["id_lote"] = $qryDataPrincipal["id_lote"];
                $digitacionActual["nombre_lote"] = $qryDataPrincipal["nombre_lote"];
                $digitacionActual["mes"] = $qryDataPrincipal["mes"];
                $digitacionActual["estado"] = $qryDataPrincipal["nombre_lote"];

                $id_digitacion = $qryDataPrincipal["id_digitacion"];

                // Consulta de digitación
                $qry_secundaria = "SELECT 
                            digitacion_cuantitativa.id_digitacion_cuantitativa,
                            digitacion_cuantitativa.id_digitacion,
                            digitacion_cuantitativa.tipo_digitacion,
                            
                            analito.id_analito,
                            analito.nombre_analito,
                            analizador.id_analizador,
                            analizador.nombre_analizador,
                            reactivo.id_reactivo,
                            reactivo.nombre_reactivo,
                            metodologia.id_metodologia,
                            metodologia.nombre_metodologia,
                            unidad.id_unidad,
                            unidad.nombre_unidad,
                            gen_vitros.id_gen_vitros,
                            gen_vitros.valor_gen_vitros,

                            digitacion_cuantitativa.media_mensual,
                            digitacion_cuantitativa.de_mensual,
                            digitacion_cuantitativa.cv_mensual,
                            digitacion_cuantitativa.n_lab_mensual,
                            digitacion_cuantitativa.n_puntos_mensual,
                            
                            digitacion_cuantitativa.media_acumulada,
                            digitacion_cuantitativa.de_acumulada,
                            digitacion_cuantitativa.cv_acumulada,
                            digitacion_cuantitativa.n_lab_acumulada,
                            digitacion_cuantitativa.n_puntos_acumulada,
                            
                            digitacion_cuantitativa.media_jctlm,
                            digitacion_cuantitativa.etmp_jctlm,
                            
                            digitacion_cuantitativa.media_inserto,
                            digitacion_cuantitativa.de_inserto,
                            digitacion_cuantitativa.cv_inserto,
                            digitacion_cuantitativa.n_inserto
                        FROM 
                            digitacion_cuantitativa
                            join analito on analito.id_analito = digitacion_cuantitativa.id_analito
                            join analizador on analizador.id_analizador = digitacion_cuantitativa.id_analizador
                            join reactivo on reactivo.id_reactivo = digitacion_cuantitativa.id_reactivo
                            join metodologia on metodologia.id_metodologia = digitacion_cuantitativa.id_metodologia
                            join unidad on unidad.id_unidad = digitacion_cuantitativa.id_unidad
                            join gen_vitros on gen_vitros.id_gen_vitros = digitacion_cuantitativa.id_gen_vitros 

                        WHERE
                            digitacion_cuantitativa.id_digitacion = $id_digitacion
                        ORDER BY analito.nombre_analito, metodologia.nombre_metodologia, analizador.nombre_analizador
                    ";

                $qryArraySecundaria = mysql_query($qry_secundaria);
                mysqlException(mysql_error(), "_01");
                $digitacion_cuantitativa = array();

                while ($qryDataSecundaria = mysql_fetch_array($qryArraySecundaria)) {
                    $consolidado_tbl_temp = array();
                    $consolidado_tbl_temp["id_digitacion_cuantitativa"] = $qryDataSecundaria["id_digitacion_cuantitativa"];
                    $consolidado_tbl_temp["id_digitacion"] = $qryDataSecundaria["id_digitacion"];
                    $consolidado_tbl_temp["tipo_digitacion"] = $qryDataSecundaria["tipo_digitacion"];
                    $consolidado_tbl_temp["id_analito"] = $qryDataSecundaria["id_analito"];
                    $consolidado_tbl_temp["nombre_analito"] = $qryDataSecundaria["nombre_analito"];
                    $consolidado_tbl_temp["id_analizador"] = $qryDataSecundaria["id_analizador"];
                    $consolidado_tbl_temp["nombre_analizador"] = $qryDataSecundaria["nombre_analizador"];
                    $consolidado_tbl_temp["id_reactivo"] = $qryDataSecundaria["id_reactivo"];
                    $consolidado_tbl_temp["nombre_reactivo"] = $qryDataSecundaria["nombre_reactivo"];
                    $consolidado_tbl_temp["id_metodologia"] = $qryDataSecundaria["id_metodologia"];
                    $consolidado_tbl_temp["nombre_metodologia"] = $qryDataSecundaria["nombre_metodologia"];
                    $consolidado_tbl_temp["id_unidad"] = $qryDataSecundaria["id_unidad"];
                    $consolidado_tbl_temp["nombre_unidad"] = $qryDataSecundaria["nombre_unidad"];
                    $consolidado_tbl_temp["id_gen_vitros"] = $qryDataSecundaria["id_gen_vitros"];
                    $consolidado_tbl_temp["valor_gen_vitros"] = $qryDataSecundaria["valor_gen_vitros"];
                    $consolidado_tbl_temp["media_mensual"] = $qryDataSecundaria["media_mensual"];
                    $consolidado_tbl_temp["de_mensual"] = $qryDataSecundaria["de_mensual"];
                    $consolidado_tbl_temp["cv_mensual"] = $qryDataSecundaria["cv_mensual"];
                    $consolidado_tbl_temp["n_lab_mensual"] = $qryDataSecundaria["n_lab_mensual"];
                    $consolidado_tbl_temp["n_puntos_mensual"] = $qryDataSecundaria["n_puntos_mensual"];
                    $consolidado_tbl_temp["media_acumulada"] = $qryDataSecundaria["media_acumulada"];
                    $consolidado_tbl_temp["de_acumulada"] = $qryDataSecundaria["de_acumulada"];
                    $consolidado_tbl_temp["cv_acumulada"] = $qryDataSecundaria["cv_acumulada"];
                    $consolidado_tbl_temp["n_lab_acumulada"] = $qryDataSecundaria["n_lab_acumulada"];
                    $consolidado_tbl_temp["n_puntos_acumulada"] = $qryDataSecundaria["n_puntos_acumulada"];
                    $consolidado_tbl_temp["media_jctlm"] = $qryDataSecundaria["media_jctlm"];
                    $consolidado_tbl_temp["etmp_jctlm"] = $qryDataSecundaria["etmp_jctlm"];
                    $consolidado_tbl_temp["media_inserto"] = $qryDataSecundaria["media_inserto"];
                    $consolidado_tbl_temp["de_inserto"] = $qryDataSecundaria["de_inserto"];
                    $consolidado_tbl_temp["cv_inserto"] = $qryDataSecundaria["cv_inserto"];
                    $consolidado_tbl_temp["n_inserto"] = $qryDataSecundaria["n_inserto"];
                    $digitacion_cuantitativa[] = $consolidado_tbl_temp;
                }
                $digitacionActual["digitacion_cuantitativa"] = $digitacion_cuantitativa;
                $info_digitacion["digitaciones"][] = $digitacionActual;
            }


            // Generar options para la impresion de los analitos
            $digitaciones_cuantiativas = $info_digitacion["digitaciones"][0]["digitacion_cuantitativa"];

            // Consulta de id lote
            $id_lote = 0; // Predeterminadamente 0
            $nivel_lote = 0; // Predeterminadamente 0
            $qryLote = "SELECT
                    lote.id_lote,
                    lote.nivel_lote
                FROM
                    lote 
                    join digitacion on lote.id_lote = digitacion.id_lote
                WHERE digitacion.id_digitacion = $idreferencia";
            $qryArrayLote = mysql_query($qryLote);
            // mysqlException(mysql_error(),"_01");
            while ($qryData = mysql_fetch_array($qryArrayLote)) {
                $id_lote = $qryData["id_lote"];
                $nivel_lote = $qryData["nivel_lote"];
            }


            // Obtener los programas que tengan las muestras del control
            $qryProgramas = "SELECT
                    programa.id_programa,
                    programa.nombre_programa,
                    lote.nombre_lote,
                    lote.nivel_lote
                FROM
                    muestra_programa 
                    join muestra on muestra.id_muestra = muestra_programa.id_muestra
                    join programa on programa.id_programa = muestra_programa.id_programa
                    join lote on lote.id_lote = muestra_programa.id_lote
                WHERE muestra_programa.id_lote = $id_lote
                GROUP BY programa.id_programa
                ORDER BY programa.nombre_programa";
            $qryArrayProgramas = mysql_query($qryProgramas);


            echo '<response code="1">';

            // Generar los botones de asignacion predeterminada
            echo "<div>";
            echo "<button class='btn btn-sm btn-default btn-asignacion bg-mensual' id='btn-asignar-mensual'>Asignar media mensual</button>";
            echo "<button class='btn btn-sm btn-default btn-asignacion bg-acumulada' id='btn-asignar-acumulada'>Asignar media acumulada</button>";
            echo "<button class='btn btn-sm btn-default btn-asignacion bg-inserto' id='btn-asignar-inserto'>Asignar media Inserto</button>";
            echo "<button class='btn btn-sm btn-default btn-asignacion bg-consenso' id='btn-asignar-consenso'>Asignar media consenso</button>";
            echo "<button class='btn btn-sm btn-default btn-asignacion bg-jctlm' id='btn-asignar-jctlm'>Asignar media JCTLM</button>";
            echo "</div>";

            echo "<hr />";

            echo "<p><strong>NOTA:</strong> Para asignar las medias debe seleccionar los analitos a evaluar <strong>y mantenerlos visibles</strong>, 
                        el sistema detectará los que tengan <strong>exactamente la misma configuración</strong> y seleccionará los campos que se encuentran a 
                        la derecha de cada mensurando (de manera automática), por lo cual restará que haga una revisión detallada de este procedimiento. 
                        <strong>No se olvide de guardar los cambios.</strong></p>";

            echo "<label>Fecha de corte para los consensos de QAP Online</label><br/>";
            echo "<input title='Fecha de corte para los consensos de QAP Online' type='date' id='fecha_corte_asignacion_consenso' value='" . Date("Y-m-d") . "' />";

            /*
            echo "<p>Al almacenar los cambios en la base de datos, se asignarán colores para los analitos, dependiendo de cual fue la asignación se verán: </p>";
            echo "<span class='bg-mensual'>Color verde, los asignados con media mensual</span> <br />";
            echo "<span class='bg-acumulada'>Color azul, los asignados con media acumulada</span> <br />";
            echo "<span class='bg-inserto'>Color morado, los asignados con media de inserto</span><br />";
            echo "<span class='bg-consenso'>Color gris, los asignados con media de consenso</span><br />";
            echo "<span class='bg-jctlm'>Borde rojo y punteado, los asignados con JTCLM</span><br />";
            */

            echo "<hr />";

            echo "<div id='arbol-muestras' style='overflow: auto;'>";

            echo "<ul data-prueba='este es un valor de prueba para el data'>";

            while ($qryDataProgramas = mysql_fetch_array($qryArrayProgramas)) {

                $id_programa = $qryDataProgramas["id_programa"];

                echo "<li>" . $qryDataProgramas["nombre_programa"] . " - Lote :" . $qryDataProgramas["nombre_lote"] . " | Nivel: " . $qryDataProgramas["nivel_lote"] .
                    "<ul>";

                // Obtener las rondas que tengan las muestras del control y sean de ese programa
                $qryRondas = "SELECT
                        ronda.id_ronda,
                        ronda.no_ronda
                    FROM
                        muestra_programa 
                        join muestra on muestra.id_muestra = muestra_programa.id_muestra
                        join programa on programa.id_programa = muestra_programa.id_programa
                        join contador_muestra on muestra.id_muestra = contador_muestra.id_muestra
                        join ronda on ronda.id_ronda = contador_muestra.id_ronda
                    where muestra_programa.id_lote = $id_lote and programa.id_programa = $id_programa
                    group by programa.id_programa, ronda.id_ronda
                    order by ronda.no_ronda desc
                    ";
                $qryArrayRondas = mysql_query($qryRondas);

                // mysqlException(mysql_error(),"_01");
                while ($qryDataRondas = mysql_fetch_array($qryArrayRondas)) {

                    $id_ronda = $qryDataRondas["id_ronda"];

                    echo "<li>Ronda " . $qryDataRondas["no_ronda"] . "<ul>";

                    // Laboratorios de la ronda
                    $labs_ronda = array();

                    // Obtener las muestras que pertenecen a esa ronda y a este programa
                    $qryMuestras = "SELECT
                            muestra.id_muestra,
                            muestra.codigo_muestra,
                            contador_muestra.no_contador
                        FROM
                            muestra_programa 
                            join muestra on muestra.id_muestra = muestra_programa.id_muestra
                            join programa on programa.id_programa = muestra_programa.id_programa
                            join contador_muestra on muestra.id_muestra = contador_muestra.id_muestra
                            join ronda on ronda.id_ronda = contador_muestra.id_ronda
                        where muestra_programa.id_lote = $id_lote and programa.id_programa = $id_programa and ronda.id_ronda = $id_ronda
                        group by programa.id_programa, ronda.id_ronda, contador_muestra.id_conexion, muestra.id_muestra
                        order by contador_muestra.no_contador
                        ";
                    $qryArrayMuestras = mysql_query($qryMuestras);
                    // mysqlException(mysql_error(),"_01");

                    while ($qryDataMuestras = mysql_fetch_array($qryArrayMuestras)) {

                        echo "<li> Muestra " . $qryDataMuestras["no_contador"] . " - <strong>" . $qryDataMuestras["codigo_muestra"] . "</strong>" .
                            "<ul>";

                        $options_dig_html = "";

                        imprimirLaboratoriosConfiguracion($id_lote, $id_programa, $id_ronda, $qryDataMuestras["id_muestra"], $nivel_lote, $options_dig_html, $digitaciones_cuantiativas);

                        echo "</ul>
                            </li>";
                    }

                    echo "</ul></li>";
                }

                echo "</ul></li>";
            }

            echo "</ul>";

            echo "</div>";

            echo '</response>';

        } else if ($tipo_programa == "cualitativo") {

        }

        break;

    case "guardarAsignacion":
        actionRestriction_102();
        if ($tipo_programa == "cuantitativo") {

            // Validación de consensos
            if (validacionConsenso($data_ajax)) {

                $idprograma = $data_ajax->idprograma;
                $fecha_corte_procesada = $data_ajax->fecha_corte;

                for ($count = 0; $count < sizeof($data_ajax->obj_json_save); $count++) {

                    // Traemos las variables de la configuracion de los laboratorios a guardar
                    $id_laboratorio_av = $data_ajax->obj_json_save[$count]->id_laboratorio_av;
                    $id_muestra_av = $data_ajax->obj_json_save[$count]->id_muestra_av;
                    $nivel_lote_av = $data_ajax->obj_json_save[$count]->nivel_lote_av;
                    $id_analito_av = $data_ajax->obj_json_save[$count]->id_analito_av;
                    $id_reactivo_av = $data_ajax->obj_json_save[$count]->id_reactivo_av;
                    $id_analizador_av = $data_ajax->obj_json_save[$count]->id_analizador_av;
                    $id_gen_vitros_av = $data_ajax->obj_json_save[$count]->id_gen_vitros_av;
                    $id_metodologia_av = $data_ajax->obj_json_save[$count]->id_metodologia_av;
                    $id_unidad_av = $data_ajax->obj_json_save[$count]->id_unidad_av;
                    $analito_digitacion = $data_ajax->obj_json_save[$count]->analito_digitacion;
                    $m_wwr = $data_ajax->obj_json_save[$count]->m_wwr;
                    $m_jctlm = $data_ajax->obj_json_save[$count]->m_jctlm;
                    $id_configlab_av = $data_ajax->obj_json_save[$count]->id_configuracion_laboratorio_analito;


                    if ($data_ajax->obj_json_save[$count]->analito_digitacion == "val_analit_consenso") {
                        // Consulta para las digitaciones
                        $qryDigitacionCuantitativa = "SELECT
                                *
                            FROM
                            digitacion_cuantitativa
                            WHERE 
                            id_digitacion_cuantitativa = 0";

                    } else {
                        // Consulta para las digitaciones
                        $qryDigitacionCuantitativa = "SELECT
                                *
                            FROM
                            digitacion_cuantitativa
                            WHERE 
                            id_digitacion_cuantitativa = $analito_digitacion";
                    }
                    $p_25_ce = 0;
                    $p_75_ce = 0;

                    $qryArrayDigitacionCuantitativa = mysql_query($qryDigitacionCuantitativa);
                    while ($qryDataDigitacionCuantitativa = mysql_fetch_array($qryArrayDigitacionCuantitativa)) {
                        switch ($m_wwr) { // Entra solo cuando encuentre digitaciones QAP-FOR-07
                            case 1: // Si es media mensual 
                                $media_ce = (isset($qryDataDigitacionCuantitativa["media_mensual"])) ? $qryDataDigitacionCuantitativa["media_mensual"] : null;
                                $de_ce = (isset($qryDataDigitacionCuantitativa["de_mensual"])) ? $qryDataDigitacionCuantitativa["de_mensual"] : null;
                                $cv_ce = (isset($qryDataDigitacionCuantitativa["cv_mensual"])) ? $qryDataDigitacionCuantitativa["cv_mensual"] : null;
                                $n_ce = (isset($qryDataDigitacionCuantitativa["n_puntos_mensual"])) ? $qryDataDigitacionCuantitativa["n_puntos_mensual"] : null;
                                break;
                            case 2: // Acumulada
                                $media_ce = (isset($qryDataDigitacionCuantitativa["media_acumulada"])) ? $qryDataDigitacionCuantitativa["media_acumulada"] : null;
                                $de_ce = (isset($qryDataDigitacionCuantitativa["de_acumulada"])) ? $qryDataDigitacionCuantitativa["de_acumulada"] : null;
                                $cv_ce = (isset($qryDataDigitacionCuantitativa["cv_acumulada"])) ? $qryDataDigitacionCuantitativa["cv_acumulada"] : null;
                                $n_ce = (isset($qryDataDigitacionCuantitativa["n_puntos_acumulada"])) ? $qryDataDigitacionCuantitativa["n_puntos_acumulada"] : null;
                                break;
                            case 3: // Inserto
                                $media_ce = (isset($qryDataDigitacionCuantitativa["media_inserto"])) ? $qryDataDigitacionCuantitativa["media_inserto"] : null;
                                $de_ce = (isset($qryDataDigitacionCuantitativa["de_inserto"])) ? $qryDataDigitacionCuantitativa["de_inserto"] : null;
                                $cv_ce = (isset($qryDataDigitacionCuantitativa["cv_inserto"])) ? $qryDataDigitacionCuantitativa["cv_inserto"] : null;
                                $n_ce = (isset($qryDataDigitacionCuantitativa["n_inserto"])) ? $qryDataDigitacionCuantitativa["n_inserto"] : null;
                                break;
                        }

                        if ($m_jctlm == 1) { // Si se va a cambiar un JCTLM
                            if (!isset($qryDataDigitacionCuantitativa["media_jctlm"]) || $qryDataDigitacionCuantitativa["media_jctlm"] == 0 || $qryDataDigitacionCuantitativa["media_jctlm"] == "") { // Si la media de JCTLM está vacía. No permitir la ejecución de la consulta
                                $m_jctlm = 0;
                            } else {
                                $media_jctlm = $qryDataDigitacionCuantitativa["media_jctlm"];
                                $etmp_jctlm = $qryDataDigitacionCuantitativa["etmp_jctlm"];
                            }

                        }
                    }


                    if ($m_wwr == 4) { // Consenso si el mensurando es para calcularse con media de consenso
                        $analito_digitacion = 'NULL';

                        // Obtener el nombre del lote
                        $qry_sub = "SELECT nombre_lote FROM $tbl_lote INNER JOIN $tbl_muestra_programa ON $tbl_lote.id_lote = $tbl_muestra_programa.id_lote WHERE $tbl_muestra_programa.id_muestra = $id_muestra_av limit 1";
                        $qryData_sub = mysql_fetch_array(mysql_query($qry_sub));
                        mysqlException(mysql_error(), "_21_");
                        $lotNombre = $qryData_sub["nombre_lote"];

                        // Obtener el nombre del analito
                        $qry_sub = "SELECT nombre_analito FROM $tbl_analito WHERE $tbl_analito.id_analito = $id_analito_av limit 1";
                        $qryData_sub = mysql_fetch_array(mysql_query($qry_sub));
                        mysqlException(mysql_error(), "_22_");
                        $nom_analito_cs = $qryData_sub["nombre_analito"];

                        // Obtener el nombre de las unidades
                        $qry_sub = "SELECT nombre_unidad FROM $tbl_unidad WHERE $tbl_unidad.id_unidad = $id_unidad_av limit 1";
                        $qryData_sub = mysql_fetch_array(mysql_query($qry_sub));
                        mysqlException(mysql_error(), "_23_");
                        $nom_unidad_cs = $qryData_sub["nombre_unidad"];

                        $objGrubbs = new Grubbs();

                        $qry_participantes = "SELECT 
                                resultado.valor_resultado as 'resultado'
                            from programa 
                                join muestra_programa on programa.id_programa = muestra_programa.id_programa 
                                join muestra on muestra.id_muestra = muestra_programa.id_muestra 
                                join lote on lote.id_lote = muestra_programa.id_lote 
                                join resultado on muestra.id_muestra = resultado.id_muestra 
                                join configuracion_laboratorio_analito on configuracion_laboratorio_analito.id_configuracion = resultado.id_configuracion 
                                join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad 
                                join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito 
                            where 
                                resultado.valor_resultado is not null 
                                and resultado.valor_resultado != ''
                                and lote.nombre_lote = '" . $lotNombre . "' 
                                and analito.nombre_analito = '" . $nom_analito_cs . "' 
                                and unidad.nombre_unidad = '" . $nom_unidad_cs . "'
                                and resultado.fecha_resultado <= '" . $fecha_corte_procesada . "'
                            ";

                        $qryArrayFinalConsenso = array();
                        $qryArrayConsenso = mysql_query($qry_participantes);
                        while ($qryDataConsenso = mysql_fetch_array($qryArrayConsenso)) {
                            array_push(
                                $qryArrayFinalConsenso,
                                array("resultado" => $qryDataConsenso["resultado"])
                            );
                        }
                        // Realizar consenso para dicho analito
                        $objGrubbs->exclusionAtipicos($qryArrayFinalConsenso, "resultado");
                        $qryData_participantes = $objGrubbs->getPromediosNormales("resultado");

                        $p_25_ce = $qryData_participantes["q1"];
                        $media_ce = $qryData_participantes["mediana"];
                        $p_75_ce = $qryData_participantes["q3"];
                        $de_ce = $qryData_participantes["s"];
                        $cv_ce = $qryData_participantes["cv_robusto"];
                        $n_ce = $qryData_participantes["n"];
                    }

                    $id_configuracion_pa = $id_configlab_av; // Identifica la configuracion del laboratorio

                    if ($analito_digitacion != '0' && $m_wwr != '0') { // Si los analitos se han especificado con los valores de cambio en los selects
                        $qryMediaCasoEspecial = "SELECT
                                id_media_analito
                            FROM
                                media_evaluacion_caso_especial
                            WHERE 
                                id_configuracion = $id_configuracion_pa 
                                and id_muestra = $id_muestra_av
                                and id_laboratorio = $id_laboratorio_av
                                and nivel = $nivel_lote_av
                            LIMIT 0,1
                            ";
                        $qryArrayMediaCasoEspecial = mysql_query($qryMediaCasoEspecial);
                        $id_media_analito = null;

                        while ($qryDataMediaCasoEspecial = mysql_fetch_array($qryArrayMediaCasoEspecial)) {
                            $id_media_analito = $qryDataMediaCasoEspecial["id_media_analito"];
                        }


                        // Si no existe, crearla con los valores de la digitacion especificada
                        if (!isset($id_media_analito) || $id_media_analito == null) {
                            $qry = "INSERT INTO media_evaluacion_caso_especial(id_configuracion, percentil_25, media_estandar, percentil_75, desviacion_estandar, coeficiente_variacion, n_evaluacion, id_muestra, nivel, id_laboratorio, id_digitacion_wwr, tipo_digitacion_wwr) 
                                    VALUES('$id_configuracion_pa', '$p_25_ce', '$media_ce', '$p_75_ce', '$de_ce', '$cv_ce', '$n_ce', '$id_muestra_av', '$nivel_lote_av', '$id_laboratorio_av', $analito_digitacion, '$m_wwr')";
                            mysql_query($qry);
                            mysqlException(mysql_error(), "_0x16");
                            $logQuery['INSERT'][$iSum] = $qry;
                            $iSum++;

                        } else { // Si existe, actualizarla con los nuevos valores de la digitacion especificada
                            $qry = "UPDATE media_evaluacion_caso_especial 
                                    SET percentil_25='$p_25_ce', media_estandar='$media_ce', percentil_75='$p_75_ce', desviacion_estandar='$de_ce', coeficiente_variacion='$cv_ce', n_evaluacion = '$n_ce',  id_digitacion_wwr = $analito_digitacion, tipo_digitacion_wwr = '$m_wwr'
                                    WHERE id_media_analito = '$id_media_analito'";
                            mysql_query($qry);
                            mysqlException(mysql_error(), "_0x17");
                            $logQuery['UPDATE'][$iSum] = $qry;
                            $iSum++;
                        }

                    }

                    if ($analito_digitacion != 0 && $m_jctlm != 0) { // Si se va a asignar un valor de referencia del JCTLM

                        // Por defecto asignar los valores del mensurando de laboratorio
                        $id_analito_aasig = $id_analito_av;
                        $id_metodologia_aasig = $id_metodologia_av;
                        $id_unidad_aasig = $id_unidad_av;

                        $qryDigigMRef = "SELECT
                                id_analito,
                                id_metodologia,
                                id_unidad
                            FROM
                                digitacion_cuantitativa
                            WHERE 
                                id_digitacion_cuantitativa = '$analito_digitacion'
                            LIMIT 1";

                        $qryArrayDigCuanti = mysql_query($qryDigigMRef);

                        // Asigne la información del mensurando de la digitación
                        while ($qryDataDigCuanti = mysql_fetch_array($qryArrayDigCuanti)) {
                            $id_analito_aasig = $qryDataDigCuanti["id_analito"];
                            $id_metodologia_aasig = $qryDataDigCuanti["id_metodologia"];
                            $id_unidad_aasig = $qryDataDigCuanti["id_unidad"];
                        }

                        // Buscar un valor de referencia que tenga la información
                        $id_valor_metodo_referencia = null;
                        $qryValorMRef = "SELECT
                                id_valor_metodo_referencia
                            FROM
                                valor_metodo_referencia
                            WHERE 
                                id_analito = $id_analito_aasig 
                                and id_metodologia = $id_metodologia_aasig
                                and id_muestra = $id_muestra_av
                                and id_unidad = $id_unidad_aasig
                                and id_laboratorio = $id_laboratorio_av
                            LIMIT 1";
                        $qryArrayValorMRef = mysql_query($qryValorMRef);
                        while ($qryDataValorMRef = mysql_fetch_array($qryArrayValorMRef)) {
                            $id_valor_metodo_referencia = (isset($qryDataValorMRef["id_valor_metodo_referencia"])) ? $qryDataValorMRef["id_valor_metodo_referencia"] : null;
                        }

                        // Si no existe crearlo
                        if (!isset($id_valor_metodo_referencia) || $id_valor_metodo_referencia == null) {
                            $qry = "INSERT INTO 
                                        valor_metodo_referencia(id_configuracion, id_analito, id_metodologia, id_muestra, valor_metodo_referencia, id_unidad, id_laboratorio, id_digitacion_jctlm) 
                                    VALUES('$id_configuracion_pa', '$id_analito_aasig', '$id_metodologia_aasig', '$id_muestra_av', '$media_jctlm', '$id_unidad_aasig', $id_laboratorio_av,'$analito_digitacion')";
                            mysql_query($qry);
                            mysqlException(mysql_error(), "_0x18");
                            $logQuery['INSERT'][$iSum] = $qry;
                            $iSum++;
                        } else { // // Si ya existe, actualizar su valor
                            $qry = "UPDATE 
                                        valor_metodo_referencia 
                                    SET id_configuracion ='$id_configuracion_pa', valor_metodo_referencia = '$media_jctlm', id_digitacion_jctlm = '$analito_digitacion'
                                    WHERE id_valor_metodo_referencia = $id_valor_metodo_referencia";
                            mysql_query($qry);
                            mysqlException(mysql_error(), "_0x19");
                            $logQuery['UPDATE'][$uSum] = $qry;
                            $uSum++;
                        }
                    }
                }

                echo '<response code="1">1</response>';
            }

        } else if ($tipo_programa == "cualitativo") {

        }
        break;

    default:
        echo '<response code="0">PHP dataChangeHandler error: not found</response>';
        break;
}


function validacionConsenso($data_ajax)
{

    if ($data_ajax->ejecutar_alertas_backend == true) {
        $idprograma = $data_ajax->idprograma;
        $fecha_corte_procesada = $data_ajax->fecha_corte;
        $consolidado_errores = [];

        for ($count = 0; $count < sizeof($data_ajax->obj_json_save); $count++) {
            if ($data_ajax->obj_json_save[$count]->m_wwr == 4) {

                // Traemos las variables de la configuracion de los laboratorios a guardar
                $id_laboratorio_av = $data_ajax->obj_json_save[$count]->id_laboratorio_av;
                $id_muestra_av = $data_ajax->obj_json_save[$count]->id_muestra_av;
                $nivel_lote_av = $data_ajax->obj_json_save[$count]->nivel_lote_av;
                $id_analito_av = $data_ajax->obj_json_save[$count]->id_analito_av;
                $id_reactivo_av = $data_ajax->obj_json_save[$count]->id_reactivo_av;
                $id_analizador_av = $data_ajax->obj_json_save[$count]->id_analizador_av;
                $id_gen_vitros_av = $data_ajax->obj_json_save[$count]->id_gen_vitros_av;
                $id_metodologia_av = $data_ajax->obj_json_save[$count]->id_metodologia_av;
                $id_unidad_av = $data_ajax->obj_json_save[$count]->id_unidad_av;
                $analito_digitacion = $data_ajax->obj_json_save[$count]->analito_digitacion;
                $m_wwr = $data_ajax->obj_json_save[$count]->m_wwr;
                $m_jctlm = $data_ajax->obj_json_save[$count]->m_jctlm;
                $id_configlab_av = $data_ajax->obj_json_save[$count]->id_configuracion_laboratorio_analito;

                $analito_digitacion = 'NULL';

                // Obtener el nombre del lote
                $qry_sub2 = "SELECT nombre_lote FROM lote INNER JOIN muestra_programa ON lote.id_lote = muestra_programa.id_lote WHERE muestra_programa.id_muestra = $id_muestra_av limit 1";
                $qryData_sub2 = mysql_fetch_array(mysql_query($qry_sub2));
                mysqlException(mysql_error(), "_24_");
                $lotNombre = $qryData_sub2["nombre_lote"];

                // Obtener el nombre del analito
                $qry_sub2 = "SELECT nombre_analito FROM analito WHERE analito.id_analito = $id_analito_av limit 1";
                $qryData_sub2 = mysql_fetch_array(mysql_query($qry_sub2));
                mysqlException(mysql_error(), "_25_");
                $nom_analito_cs = $qryData_sub2["nombre_analito"];

                // Obtener el nombre de las unidades
                $qry_sub2 = "SELECT nombre_unidad FROM unidad WHERE unidad.id_unidad = $id_unidad_av limit 1";
                $qryData_sub2 = mysql_fetch_array(mysql_query($qry_sub2));
                mysqlException(mysql_error(), "_26_");
                $nom_unidad_cs = $qryData_sub2["nombre_unidad"];

                // include_once "complementos/grubbs.php";
                $objGrubbs = new Grubbs();

                $qry_participantes = "SELECT 
                        resultado.valor_resultado as 'resultado'
                    from programa 
                        join muestra_programa on programa.id_programa = muestra_programa.id_programa 
                        join muestra on muestra.id_muestra = muestra_programa.id_muestra 
                        join lote on lote.id_lote = muestra_programa.id_lote 
                        join resultado on muestra.id_muestra = resultado.id_muestra 
                        join configuracion_laboratorio_analito on configuracion_laboratorio_analito.id_configuracion = resultado.id_configuracion 
                        join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad 
                        join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito 
                    where 
                        resultado.valor_resultado is not null 
                        and resultado.valor_resultado != ''
                        and lote.nombre_lote = '" . $lotNombre . "' 
                        and analito.nombre_analito = '" . $nom_analito_cs . "' 
                        and unidad.nombre_unidad = '" . $nom_unidad_cs . "'
                        and resultado.fecha_resultado <= '" . $fecha_corte_procesada . "'
                    ";

                $qryArrayFinalConsenso = array();
                $qryArrayConsenso = mysql_query($qry_participantes);
                while ($qryDataConsenso = mysql_fetch_array($qryArrayConsenso)) {
                    array_push(
                        $qryArrayFinalConsenso,
                        array("resultado" => $qryDataConsenso["resultado"])
                    );
                }

                // Realizar consenso para dicho analito
                $objGrubbs->exclusionAtipicos($qryArrayFinalConsenso, "resultado");
                $qryData_participantes = $objGrubbs->getPromediosNormales("resultado");

                $media_ce = round($qryData_participantes["media"], 2);
                $de_ce = round($qryData_participantes["de"], 2);
                $cv_ce = round($qryData_participantes["cv"], 2);
                $n_ce = round($qryData_participantes["n"], 2);

                if ($analito_digitacion != '0' && $m_wwr != '0') { // Si los analitos se han especificado con los valores de cambio en los selects
                    if ($media_ce == "") {
                        $desc_analito = obtenerDescAnalito($id_configlab_av);
                        array_push($consolidado_errores, "<strong>Media de consenso NULA</strong> <i><br />($desc_analito)<br /><br /></i>");
                    } else if ($cv_ce == "") {
                        $desc_analito = obtenerDescAnalito($id_configlab_av);
                        array_push($consolidado_errores, "<strong>CV de consenso NULO</strong> <i><br />($desc_analito)<br /><br /></i>");
                    } else if (intval($n_ce) < 10) {
                        $desc_analito = obtenerDescAnalito($id_configlab_av);
                        array_push($consolidado_errores, "<strong>N de consenso inferior a 10</strong> <i><br />($desc_analito)<br /><br /></i>");
                    } else if (floatval($cv_ce) > 10) {
                        $desc_analito = obtenerDescAnalito($id_configlab_av);
                        array_push($consolidado_errores, "<strong>CV superior al 10%</strong> <i><br />($desc_analito)<br /><br /></i>");
                    }
                }
            }
        }

        if (sizeof($consolidado_errores) > 0) {
            echo '<response code="422">';
            echo '<ul>';
            for ($xfv = 0; $xfv < sizeof($consolidado_errores); $xfv++) {
                echo "<li>" . $consolidado_errores[$xfv] . "</li>";
            }
            echo '</ul>';
            echo '</response>';
            return false;
        } else {
            return true;
        }

    } else {
        return true;
    }
}


function obtenerDescAnalito($id_configlab_av)
{

    $qryConfiguracionesSup = "SELECT DISTINCT
            configuracion_laboratorio_analito.id_configuracion,
            laboratorio.no_laboratorio,
            laboratorio.nombre_laboratorio,
            analito.id_analito,
            analito.nombre_analito,
            analizador.id_analizador,
            analizador.nombre_analizador,
            metodologia.id_metodologia,
            metodologia.nombre_metodologia,
            reactivo.id_reactivo,
            reactivo.nombre_reactivo,
            unidad.id_unidad,
            unidad.nombre_unidad,
            gen_vitros.id_gen_vitros,
            gen_vitros.valor_gen_vitros
        FROM
            configuracion_laboratorio_analito 
            join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito
            join analizador on analizador.id_analizador = configuracion_laboratorio_analito.id_analizador
            join metodologia on metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia
            join reactivo on reactivo.id_reactivo = configuracion_laboratorio_analito.id_reactivo
            join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad
            join gen_vitros on gen_vitros.id_gen_vitros =  configuracion_laboratorio_analito.id_gen_vitros
            join laboratorio on laboratorio.id_laboratorio =  configuracion_laboratorio_analito.id_laboratorio
        where configuracion_laboratorio_analito.id_configuracion = $id_configlab_av  
        limit 1";

    $qryDataConfiguracionesSup = mysql_fetch_array(mysql_query($qryConfiguracionesSup));

    return "Lab: " . $qryDataConfiguracionesSup["no_laboratorio"] . " - " . $qryDataConfiguracionesSup["no_laboratorio"] . " " .
        "Analit: " . $qryDataConfiguracionesSup["nombre_analito"] . " " .
        "Analz: " . $qryDataConfiguracionesSup["nombre_analizador"] . " " .
        "Met: " . $qryDataConfiguracionesSup["nombre_metodologia"] . " " .
        "React: " . $qryDataConfiguracionesSup["nombre_reactivo"] . " " .
        "Unid" . $qryDataConfiguracionesSup["nombre_unidad"];




    /*
    $options_dig_html = $options_dig_html . "<option value='".$digitaciones_cuantiativas[$conGestDig]["id_digitacion_cuantitativa"]."'>".$digitaciones_cuantiativas[$conGestDig]["nombre_analito"]
    ." | Metodología: " .$digitaciones_cuantiativas[$conGestDig]["nombre_metodologia"]
    ." | ". $digitaciones_cuantiativas[$conGestDig]["nombre_analizador"] . " (GEN: ". $digitaciones_cuantiativas[$conGestDig]["valor_gen_vitros"] ." )"
    ." | Reactivo: " . $digitaciones_cuantiativas[$conGestDig]["nombre_reactivo"] 
    ." | Unidad: ".$digitaciones_cuantiativas[$conGestDig]["nombre_unidad"]."</option>";
    */
}


function imprimirLaboratoriosConfiguracion($id_lote, $id_programa, $id_ronda, $id_muestra, $nivel_lote, $options_dig_html, $digitaciones_cuantiativas)
{

    // Obtener los laboratorios que tiene asignada esta ronda
    $qryLaboratoriosAsignados = "SELECT
            laboratorio.id_laboratorio,
            programa.id_programa,
            laboratorio.no_laboratorio,
            laboratorio.nombre_laboratorio
        FROM
            muestra_programa 
            join muestra on muestra.id_muestra = muestra_programa.id_muestra
            join programa on programa.id_programa = muestra_programa.id_programa
            join contador_muestra on muestra.id_muestra = contador_muestra.id_muestra
            join ronda on ronda.id_ronda = contador_muestra.id_ronda
            join ronda_laboratorio on ronda.id_ronda = ronda_laboratorio.id_ronda
            join laboratorio on laboratorio.id_laboratorio = ronda_laboratorio.id_laboratorio
        where muestra_programa.id_lote = $id_lote and programa.id_programa = $id_programa and ronda.id_ronda = $id_ronda
        group by laboratorio.id_laboratorio
        order by laboratorio.no_laboratorio";
    $qryArrayLabAsignados = mysql_query($qryLaboratoriosAsignados);

    while ($qryDataLabAsignados = mysql_fetch_array($qryArrayLabAsignados)) {
        echo "<li>" .
            "<strong>" . $qryDataLabAsignados["no_laboratorio"] . "</strong> - " . $qryDataLabAsignados["nombre_laboratorio"]
            . "<ul>";

        $id_laboratorio = $qryDataLabAsignados["id_laboratorio"];
        $id_programa_lab_asignados = $qryDataLabAsignados["id_programa"];

        $qryConfiguraciones = "SELECT DISTINCT
                configuracion_laboratorio_analito.id_configuracion,
                analito.id_analito,
                analito.nombre_analito,
                analizador.id_analizador,
                analizador.nombre_analizador,
                metodologia.id_metodologia,
                metodologia.nombre_metodologia,
                reactivo.id_reactivo,
                reactivo.nombre_reactivo,
                unidad.id_unidad,
                unidad.nombre_unidad,
                gen_vitros.id_gen_vitros,
                gen_vitros.valor_gen_vitros
            FROM
                configuracion_laboratorio_analito 
                join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito
                join analizador on analizador.id_analizador = configuracion_laboratorio_analito.id_analizador
                join metodologia on metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia
                join reactivo on reactivo.id_reactivo = configuracion_laboratorio_analito.id_reactivo
                join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad
                join gen_vitros on gen_vitros.id_gen_vitros =  configuracion_laboratorio_analito.id_gen_vitros
            where configuracion_laboratorio_analito.id_programa = $id_programa_lab_asignados and configuracion_laboratorio_analito.id_laboratorio = $id_laboratorio and configuracion_laboratorio_analito.activo = 1 
            order by analito.nombre_analito";

        $qryArrayConfiguraciones = mysql_query($qryConfiguraciones);
        while ($qryDataConfiguraciones = mysql_fetch_array($qryArrayConfiguraciones)) {

            // Obtener el ID de la configuracion del programa analito
            $media_estandar = null;
            $desviacion_estandar = null;
            $coeficiente_variacion = null;
            $n_evaluacion = null;
            $id_media_analito = null;
            $id_digitacion_wwr = null;
            $tipo_digitacion_wwr = null;
            $id_digitacion_jctlm = null;

            echo "<li>";
            if (isset($qryDataConfiguraciones["id_configuracion"])) {

                $id_config_pro_analito = $qryDataConfiguraciones["id_configuracion"];

                // Obtener la configuracion de media evaluacion caso especial
                $qryMediaCasoEspecial = "SELECT
                            media_estandar,
                            desviacion_estandar,
                            coeficiente_variacion,
                            n_evaluacion,
                            id_media_analito,
                            id_digitacion_wwr,
                            tipo_digitacion_wwr,
                            tipo_consenso_wwr
                        FROM
                            media_evaluacion_caso_especial
                        WHERE 
                            id_configuracion = $id_config_pro_analito 
                            and id_muestra = $id_muestra
                            and id_laboratorio = $id_laboratorio
                            and nivel = $nivel_lote
                        LIMIT 0,1
                        ";
                $qryArrayMediaCasoEspecial = mysql_query($qryMediaCasoEspecial);
                while ($qryDataMediaCasoEspecial = mysql_fetch_array($qryArrayMediaCasoEspecial)) {
                    $media_estandar = (isset($qryDataMediaCasoEspecial["media_estandar"])) ? $qryDataMediaCasoEspecial["media_estandar"] : null;
                    $desviacion_estandar = (isset($qryDataMediaCasoEspecial["desviacion_estandar"])) ? $qryDataMediaCasoEspecial["desviacion_estandar"] : null;
                    $coeficiente_variacion = (isset($qryDataMediaCasoEspecial["coeficiente_variacion"])) ? $qryDataMediaCasoEspecial["coeficiente_variacion"] : null;
                    $n_evaluacion = (isset($qryDataMediaCasoEspecial["n_evaluacion"])) ? $qryDataMediaCasoEspecial["n_evaluacion"] : null;
                    $id_media_analito = (isset($qryDataMediaCasoEspecial["id_media_analito"])) ? $qryDataMediaCasoEspecial["id_media_analito"] : null;
                    $id_digitacion_wwr = (isset($qryDataMediaCasoEspecial["id_digitacion_wwr"])) ? $qryDataMediaCasoEspecial["id_digitacion_wwr"] : null;
                    $tipo_digitacion_wwr = (isset($qryDataMediaCasoEspecial["tipo_digitacion_wwr"])) ? $qryDataMediaCasoEspecial["tipo_digitacion_wwr"] : null;
                }

                // Obtener la configuracion de valor_metodo_referencia
                // Obtener el ultimo valor asignado en la tabla de valor de referencia con coincida con la configuracion
                $qryValorMetodoReferencia = "SELECT
                            id_valor_metodo_referencia,
                            id_analito,
                            id_metodologia,
                            id_muestra,
                            valor_metodo_referencia,
                            id_unidad,
                            id_digitacion_jctlm
                        FROM
                            valor_metodo_referencia
                        WHERE
                            id_analito = '" . $qryDataConfiguraciones["id_analito"] . "' 
                            and id_laboratorio = '" . $id_laboratorio . "'
                            and id_muestra = '" . $id_muestra . "'
                            and id_unidad = '" . $qryDataConfiguraciones["id_unidad"] . "'
                        LIMIT 1";

                $qryArrayValorMetodoReferencia = mysql_query($qryValorMetodoReferencia);
                while ($qryDataValorMetodoReferencia = mysql_fetch_array($qryArrayValorMetodoReferencia)) {
                    $id_digitacion_jctlm = (isset($qryDataValorMetodoReferencia["id_digitacion_jctlm"])) ? $qryDataValorMetodoReferencia["id_digitacion_jctlm"] : null; // Se deshabilita por que de momento no se hace en la presente tabla
                    $valor_metodo_referencia = (isset($qryDataValorMetodoReferencia["valor_metodo_referencia"])) ? $qryDataValorMetodoReferencia["valor_metodo_referencia"] : null; // Se deshabilita por que de momento no se hace en la presente tabla
                }
            }

            // Si existe una asignacion de valor de metodo de referencia
            $class_jctlm = "";
            if (isset($id_digitacion_jctlm) && $id_digitacion_jctlm != null) {
                $class_jctlm = "bg-jctlm";
            }

            $datafields = "data-idlaboratorio='" . $id_laboratorio . "' data-idmuestra='" . $id_muestra . "' data-nivellote='" . $nivel_lote . "' data-id_configuracion_laboratorio_analito='" . $qryDataConfiguraciones["id_configuracion"] . "'";

            switch ($tipo_digitacion_wwr) {
                case 1: // Mensual
                    echo "<i class='contenedor-config bg-mensual $class_jctlm' $datafields>";
                    $txt_asignacion_wwr = "Previa asignación de media mensual";
                    break;
                case 2: // Acumulada
                    echo "<i class='contenedor-config bg-acumulada $class_jctlm' $datafields>";
                    $txt_asignacion_wwr = "Previa asignación de media acumulada";
                    break;
                case 3: // Inserto
                    echo "<i class='contenedor-config bg-inserto $class_jctlm' $datafields>";
                    $txt_asignacion_wwr = "Previa asignación de media por inserto";
                    break;
                case 4: // Consenso
                    echo "<i class='contenedor-config bg-consenso $class_jctlm' $datafields>";
                    $txt_asignacion_wwr = "Previa asignación de media por consenso";
                    break;
                case null:
                    echo "<i class='contenedor-config $class_jctlm' $datafields>";
                    break;
            }

            echo "<strong class='analito' data-idreferencia='" . $qryDataConfiguraciones["id_analito"] . "'>" . $qryDataConfiguraciones["nombre_analito"] . "</strong>";
            echo " | Metodología: ";
            echo "<i class='metodologia' data-idreferencia='" . $qryDataConfiguraciones["id_metodologia"] . "'>" . $qryDataConfiguraciones["nombre_metodologia"] . "</i>";
            echo " | ";
            echo "<i class='analizador' data-idreferencia='" . $qryDataConfiguraciones["id_analizador"] . "'>" . $qryDataConfiguraciones["nombre_analizador"] . "</i> (G: <i class='gen_vitros' data-idreferencia='" . $qryDataConfiguraciones["id_gen_vitros"] . "'>" . $qryDataConfiguraciones["valor_gen_vitros"] . "</i>)";
            echo " | Reactivo: ";
            echo "<i class='reactivo' data-idreferencia='" . $qryDataConfiguraciones["id_reactivo"] . "'>" . $qryDataConfiguraciones["nombre_reactivo"] . "</i>";
            echo " | Unidad: ";
            echo "<i class='unidad' data-idreferencia='" . $qryDataConfiguraciones["id_unidad"] . "'>" . $qryDataConfiguraciones["nombre_unidad"] . "</i>";


            $options_dig_html = "<option value='val_analit_consenso'><strong>*** Generar mediante consenso de participantes QAP ***</strong></option>";

            for ($conGestDig = 0; $conGestDig < sizeof($digitaciones_cuantiativas); $conGestDig++) {
                // || "val_analit_consenso" 
                if (
                    $digitaciones_cuantiativas[$conGestDig]["nombre_analito"] == $qryDataConfiguraciones["nombre_analito"]
                ) { // Imprimir solo el mismo analito
                    $options_dig_html = $options_dig_html . "<option value='" . $digitaciones_cuantiativas[$conGestDig]["id_digitacion_cuantitativa"] . "'>" . $digitaciones_cuantiativas[$conGestDig]["nombre_analito"]
                        . " | Metodología: " . $digitaciones_cuantiativas[$conGestDig]["nombre_metodologia"]
                        . " | " . $digitaciones_cuantiativas[$conGestDig]["nombre_analizador"] . " (GEN: " . $digitaciones_cuantiativas[$conGestDig]["valor_gen_vitros"] . " )"
                        . " | Reactivo: " . $digitaciones_cuantiativas[$conGestDig]["nombre_reactivo"]
                        . " | Unidad: " . $digitaciones_cuantiativas[$conGestDig]["nombre_unidad"] . "</option>";
                }
            }


            echo "<select class='analito-digitacion'>";
            if ($tipo_digitacion_wwr != null) { // Si está definida la asignación para el analito
                echo "<option selected='selected' value='0'>" . $txt_asignacion_wwr . "</option>";
                echo $options_dig_html;
            } else {
                echo "<option selected='selected' value='0'></option>";
                echo $options_dig_html;
            }
            echo "</select>";


            $options_dig_html = "";
            echo " ";

            echo "<select class='m-wwr'>";
            if ($tipo_digitacion_wwr != null) { // Si está definida la asignación para el analito
                echo "<option selected='selected' value='0'>(Registrada en BD) Media: " . $media_estandar . " | D.E.: " . $desviacion_estandar . " | C.V.: " . $coeficiente_variacion . " | N: " . $n_evaluacion . "</option>";
            } else {
                echo "<option selected='selected' value='0'></option>";
            }
            echo "</select>";

            echo " ";

            echo "<select class='m-jctlm'>";
            if ($id_digitacion_jctlm != null) { // Si está definida la asignación para el analito
                echo "<option selected='selected' value='0'>(Registrada en BD) Valor: $valor_metodo_referencia%</option>";
            } else {
                echo "<option selected='selected' value='0'></option>";
            }
            echo "</select>";

            $options_tipoconsenso_dig_html = "<option value='1'>Par</option><option value='2'>Método</option><option value='3'>Todos los laboratorios</option>";

            echo "</i>";
            echo "</li>";
        }

        echo "</ul></li>";
    }
}

/*
if (sizeof($logQuery['INSERT']) > 0) {
    for ($y = 0; $y < sizeof($logQuery['INSERT']); $y++) {
        $tempLogQuery = mysql_real_escape_string($logQuery['INSERT'][$y]);
        $qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Registro de información','$tempLogQuery')";
        mysql_query($qry);
        mysqlException(mysql_error(),"_LGQ_0x01_");
    }
}

if (sizeof($logQuery['UPDATE']) > 0) {
    for ($y = 0; $y < sizeof($logQuery['UPDATE']); $y++) {
        $tempLogQuery = mysql_real_escape_string($logQuery['UPDATE'][$y]);
        $qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Actualización de información','$tempLogQuery')";
        mysql_query($qry);
        mysqlException(mysql_error(),"_LGQ_0x02_");			
    }		
}

if (sizeof($logQuery['DELETE']) > 0) {
    for ($y = 0; $y < sizeof($logQuery['DELETE']); $y++) {
        $tempLogQuery = mysql_real_escape_string($logQuery['DELETE'][$y]);
        $qry = "INSERT INTO $tbl_log (id_usuario,fecha,hora,log,query) VALUES ($userId,'$logDate','$logHour','Remoción de información','$tempLogQuery')";
        mysql_query($qry);
        mysqlException(mysql_error(),"_LGQ_0x03_");			
    }		
}
*/


mysql_close($con);
exit;

?>