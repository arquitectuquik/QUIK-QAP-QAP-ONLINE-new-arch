<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

session_start();
include_once "verifica_sesion.php";

actionRestriction_102();

header('Content-Type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";

$header = $_POST['header'];

if (!isset($_POST['filter'])) {
	$_POST['filter'] = 'NULL';
}
if (!isset($_POST['filterid'])) {
	$_POST['filterid'] = 'NULL';
}

$filter = $_POST['filter'];
$filterid = $_POST['filterid'];

if ($filter == "") {
	$filter = 'NULL';
}
if ($filterid == "") {
	$filterid = 'NULL';
}

switch ($header) {
	case 'showAssignedLabProgram':

		switch ($filterid) {
			case 'id_laboratorio':
				$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = $filter";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT $tbl_programa.id_programa,$tbl_programa.nombre_programa FROM $tbl_programa INNER JOIN $tbl_programa_laboratorio ON $tbl_programa.id_programa = $tbl_programa_laboratorio.id_programa INNER JOIN $tbl_laboratorio ON $tbl_programa_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio $filterQry ORDER BY $tbl_programa.nombre_programa ASC, $tbl_laboratorio.nombre_laboratorio ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_programa'];
			$returnValue_2[$x] = $qryData['nombre_programa'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;


	case 'showAssignedLabRound':

		$filterArray = explode("|", $filter);

		for ($x = 0; $x < sizeof($filterArray); $x++) {
			if ($filterArray[$x] == "") {
				$filterArray[$x] = "NULL";
			}
		}

		switch ($filterid) {
			case 'id_laboratorio':
				// $filterQry = "WHERE $tbl_ronda_laboratorio.id_laboratorio = $filterArray[1] AND $tbl_ronda.id_programa = $filterArray[0] GROUP BY $tbl_ronda.no_ronda";
				// Se actualiza la sentencia group by
				$filterQry = "WHERE $tbl_ronda_laboratorio.id_laboratorio = $filterArray[1] AND $tbl_ronda.id_programa = $filterArray[0] GROUP BY $tbl_ronda.id_ronda";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT $tbl_ronda.no_ronda,$tbl_ronda.id_ronda FROM $tbl_ronda INNER JOIN $tbl_ronda_laboratorio ON $tbl_ronda.id_ronda = $tbl_ronda_laboratorio.id_ronda INNER JOIN $tbl_programa ON $tbl_ronda.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_muestra_programa ON $tbl_programa.id_programa = $tbl_muestra_programa.id_programa $filterQry ORDER BY $tbl_ronda.no_ronda DESC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();
		;

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_ronda'];
			$returnValue_2[$x] = $qryData['no_ronda'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showAssignedRoundSample':

		switch ($filterid) {
			case 'id_ronda':
				$filterQry = "WHERE $tbl_ronda.id_ronda = $filter";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT $tbl_muestra.id_muestra,$tbl_muestra.codigo_muestra,$tbl_contador_muestra.no_contador,$tbl_muestra_programa.fecha_vencimiento FROM $tbl_ronda INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa $filterQry ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();
		$returnValue_3 = array();
		$returnValue_4 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_muestra'];
			$returnValue_2[$x] = $qryData['no_contador'];
			$returnValue_3[$x] = $qryData['codigo_muestra'];
			$returnValue_4[$x] = $qryData['fecha_vencimiento'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';
		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';
		echo '</response>';
		break;
	case 'checkPdfStatus':

		switch ($filterid) {
			case 'id_temp_pdf':
				$filterQry = "WHERE $tbl_temp_pdf.id_temp_pdf = $filter";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT pdf_status FROM $tbl_temp_pdf $filterQry";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['pdf_status'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1>' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '</response>';
		break;
	case 'showAssignedAnalitMedia':

		if (isset($_POST['minitemstoshow'])) {
			$min = mysql_real_escape_string(clean($_POST['minitemstoshow']));
		} else {
			$min = 0;
		}
		if (isset($_POST['maxitemstoshow'])) {
			$max = mysql_real_escape_string(clean($_POST['maxitemstoshow']));
		} else {
			$max = 100;
		}
		if (isset($_POST['programtypeid'])) {
			$programtypeid = mysql_real_escape_string(clean($_POST['programtypeid']));
		} else {
			$programtypeid = "null";
		}

		switch ($filterid) {
			case 'id_programa':
				$filterQry = "WHERE $tbl_programa.id_programa = " . $filter;
				break;
			case 'id_array':

				$filterArray = explode("|", $filter);

				for ($x = 0; $x < sizeof($filterArray); $x++) {
					if ($filterArray[$x] == "") {
						$filterArray[$x] = "NULL";
					}
				}

				break;
			default:
				$filterQry = '';
				break;
		}

		if ($filterArray[2] != "NULL") {

			$qry = "SELECT 
							* 
						FROM $tbl_configuracion_laboratorio_analito
						JOIN $tbl_analito on $tbl_analito.id_analito = $tbl_configuracion_laboratorio_analito.id_analito
					WHERE id_laboratorio = " . $filterArray[2] . " AND id_programa = " . $filterArray[1] . " AND activo = 1
					ORDER BY $tbl_analito.nombre_analito ASC";

			$filterQryArray = mysql_query($qry);

			$filterQry = array();

			$x = 0;

			while ($filterQryData = mysql_fetch_array($filterQryArray)) {
				$filterQry[$x] = "WHERE $tbl_configuracion_laboratorio_analito.id_configuracion = " . $filterQryData["id_configuracion"];
				$x++;
			}

			$returnValue_1 = array();
			$returnValue_2 = array();
			$returnValue_3 = array();
			$returnValue_4 = array();
			$returnValue_5 = array();
			$returnValue_6 = array();
			$returnValue_7 = array();
			$returnValue_9 = array(
				'level0' => array(),
				'level1' => array(),
				'level2' => array(),
				'level3' => array()
			);
			$returnValue_10 = array();

			for ($x = 0; $x < sizeof($filterQry); $x++) {
				$qry = "SELECT $tbl_configuracion_laboratorio_analito.id_configuracion,nombre_programa,nombre_analito,nombre_analizador,nombre_metodologia,nombre_reactivo,nombre_unidad,$tbl_analito.id_analito,valor_gen_vitros 
							FROM 
								$tbl_configuracion_laboratorio_analito 
								INNER JOIN $tbl_programa ON $tbl_configuracion_laboratorio_analito.id_programa = $tbl_programa.id_programa 
								INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito 
								INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador 
								INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia 
								INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo 
								INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad 
								INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros 
							" . $filterQry[$x] . " 
							ORDER BY nombre_programa ASC, nombre_analizador ASC, nombre_analito ASC LIMIT $min,$max";

				$qryData = mysql_fetch_array(mysql_query($qry));

				if (!empty($qryData['id_configuracion'])) {
					$returnValue_1[$x] = $qryData['id_configuracion'];
				} else {
					$returnValue_1[$x] = "0";
				}

				$returnValue_2[$x] = $qryData['nombre_programa'];
				$returnValue_3[$x] = $qryData['nombre_analito'];
				$returnValue_4[$x] = $qryData['nombre_analizador'];
				$returnValue_5[$x] = $qryData['nombre_metodologia'];
				$returnValue_6[$x] = $qryData['nombre_reactivo'];
				$returnValue_7[$x] = $qryData['nombre_unidad'];
				$returnValue_10[$x] = $qryData['valor_gen_vitros'];

			}

			$lvl = array(1, 2, 3, 0);

			$level0Counter = 0;
			$level1Counter = 0;
			$level2Counter = 0;
			$level3Counter = 0;

			if (sizeof($returnValue_1) > 0) {
				for ($x = 0; $x < sizeof($returnValue_1); $x++) {

					$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,n_evaluacion,nivel 
								FROM $tbl_media_evaluacion_caso_especial 
								WHERE id_configuracion = " . $returnValue_1[$x] . " AND
								 nivel = " . $lvl[0] . " AND id_muestra = " . $filterArray[0] . " 
								 AND id_laboratorio = " . $filterArray[2];

					$qryArray_2 = mysql_query($qry);
					mysqlException(mysql_error(), $header . "_02_" . $x);

					$qryData_2 = mysql_fetch_array($qryArray_2);

					if (!empty($qryData_2)) {
						$returnValue_9['level1'][$level1Counter] = $qryData_2['percentil_25'];
						$returnValue_9['level1'][$level1Counter + 1] = $qryData_2['media_estandar'];
						$returnValue_9['level1'][$level1Counter + 2] = $qryData_2['percentil_75'];
						$returnValue_9['level1'][$level1Counter + 3] = $qryData_2['desviacion_estandar'];
						$returnValue_9['level1'][$level1Counter + 4] = $qryData_2['coeficiente_variacion'];
						$returnValue_9['level1'][$level1Counter + 5] = $qryData_2['n_evaluacion'];
					} else {
						$returnValue_9['level1'][$level1Counter] = 0;
						$returnValue_9['level1'][$level1Counter + 1] = 0;
						$returnValue_9['level1'][$level1Counter + 2] = 0;
						$returnValue_9['level1'][$level1Counter + 3] = 0;
						$returnValue_9['level1'][$level1Counter + 4] = 0;
						$returnValue_9['level1'][$level1Counter + 5] = 0;
					}

					$level1Counter = ($level1Counter + 6);

					$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,n_evaluacion,nivel FROM $tbl_media_evaluacion_caso_especial WHERE id_configuracion = " . $returnValue_1[$x] . " AND nivel = " . $lvl[1] . " AND id_muestra = " . $filterArray[0] . " AND id_laboratorio = " . $filterArray[2];

					$qryArray_2 = mysql_query($qry);
					mysqlException(mysql_error(), $header . "_02_" . $x);

					$qryData_2 = mysql_fetch_array($qryArray_2);

					if (!empty($qryData_2)) {
						$returnValue_9['level2'][$level2Counter] = $qryData_2['percentil_25'];
						$returnValue_9['level2'][$level2Counter + 1] = $qryData_2['media_estandar'];
						$returnValue_9['level2'][$level2Counter + 2] = $qryData_2['percentil_75'];
						$returnValue_9['level2'][$level2Counter + 3] = $qryData_2['desviacion_estandar'];
						$returnValue_9['level2'][$level2Counter + 4] = $qryData_2['coeficiente_variacion'];
						$returnValue_9['level2'][$level2Counter + 5] = $qryData_2['n_evaluacion'];
					} else {
						$returnValue_9['level2'][$level2Counter] = 0;
						$returnValue_9['level2'][$level2Counter + 1] = 0;
						$returnValue_9['level2'][$level2Counter + 2] = 0;
						$returnValue_9['level2'][$level2Counter + 3] = 0;
						$returnValue_9['level2'][$level2Counter + 4] = 0;
						$returnValue_9['level2'][$level2Counter + 5] = 0;
					}

					$level2Counter = ($level2Counter + 6);

					$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,n_evaluacion,nivel FROM $tbl_media_evaluacion_caso_especial WHERE id_configuracion = " . $returnValue_1[$x] . " AND nivel = " . $lvl[2] . " AND id_muestra = " . $filterArray[0] . " AND id_laboratorio = " . $filterArray[2];

					$qryArray_2 = mysql_query($qry);
					mysqlException(mysql_error(), $header . "_02_" . $x);

					$qryData_2 = mysql_fetch_array($qryArray_2);

					if (!empty($qryData_2)) {
						$returnValue_9['level3'][$level3Counter] = $qryData_2['percentil_25'];
						$returnValue_9['level3'][$level3Counter + 1] = $qryData_2['media_estandar'];
						$returnValue_9['level3'][$level3Counter + 2] = $qryData_2['percentil_75'];
						$returnValue_9['level3'][$level3Counter + 3] = $qryData_2['desviacion_estandar'];
						$returnValue_9['level3'][$level3Counter + 4] = $qryData_2['coeficiente_variacion'];
						$returnValue_9['level3'][$level3Counter + 5] = $qryData_2['n_evaluacion'];
					} else {
						$returnValue_9['level3'][$level3Counter] = 0;
						$returnValue_9['level3'][$level3Counter + 1] = 0;
						$returnValue_9['level3'][$level3Counter + 2] = 0;
						$returnValue_9['level3'][$level3Counter + 3] = 0;
						$returnValue_9['level3'][$level3Counter + 4] = 0;
						$returnValue_9['level3'][$level3Counter + 5] = 0;
					}

					$level3Counter = ($level3Counter + 6);

					$qry = "SELECT $tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $tbl_media_evaluacion_caso_especial INNER JOIN $tbl_analito_resultado_reporte_cualitativo ON $tbl_media_evaluacion_caso_especial.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = " . $returnValue_1[$x] . " AND id_muestra = " . $filterArray[0] . " AND id_laboratorio = " . $filterArray[2];

					$qryArray_2 = mysql_query($qry);
					mysqlException(mysql_error(), $header . "_02_" . $x);

					$qryData_2 = mysql_fetch_array($qryArray_2);

					if (!empty($qryData_2)) {
						$returnValue_9['level0'][$level0Counter] = $qryData_2['desc_resultado_reporte_cualitativo'];
					} else {
						$returnValue_9['level0'][$level0Counter] = "N/A";
					}

					$level0Counter++;

				}
			}

		}

		if ($programtypeid == 1) {
			$qry = "SELECT nivel_lote FROM $tbl_lote INNER JOIN $tbl_muestra_programa ON $tbl_lote.id_lote = $tbl_muestra_programa.id_lote WHERE $tbl_muestra_programa.id_muestra = $filterArray[0] AND $tbl_muestra_programa.id_programa = $filterArray[1]";

			$qryData = mysql_fetch_array(mysql_query($qry));
			mysqlException(mysql_error(), $header . "_05");

			$lotLevel = $qryData['nivel_lote'];
		} else if ($programtypeid == 2) {
			$lotLevel = 0;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';
		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';
		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';
		echo '<returnvalues6>' . implode("|", $returnValue_6) . '</returnvalues6>';
		echo '<returnvalues7>' . implode("|", $returnValue_7) . '</returnvalues7>';
		echo '<returnvalues9lvl0>' . implode("|", $returnValue_9['level0']) . '</returnvalues9lvl0>';
		echo '<returnvalues9lvl1>' . implode("|", $returnValue_9['level1']) . '</returnvalues9lvl1>';
		echo '<returnvalues9lvl2>' . implode("|", $returnValue_9['level2']) . '</returnvalues9lvl2>';
		echo '<returnvalues9lvl3>' . implode("|", $returnValue_9['level3']) . '</returnvalues9lvl3>';
		echo '<returnvalues10>' . implode("|", $returnValue_10) . '</returnvalues10>';
		echo '<returnvalues11>' . $lotLevel . '</returnvalues11>';
		echo '</response>';
		break;
	case 'showAssignedProgramType':

		switch ($filterid) {
			case 'id_programa':
				$filterQry = "WHERE $tbl_programa.id_programa = $filter";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT id_tipo_programa FROM $tbl_programa $filterQry LIMIT 0,1";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_tipo_programa'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showAnalitCualitativeTypeOfResultForConfiguration':

		switch ($filterid) {
			case 'id_configuracion':
				$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_configuracion = " . $filter;
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT id_analito FROM $tbl_configuracion_laboratorio_analito $filterQry LIMIT 0,1";
		$qryData = mysql_fetch_array(mysql_query($qry));
		mysqlException(mysql_error(), $header . "_01");

		$qry = "SELECT id_analito_resultado_reporte_cualitativo,desc_resultado_reporte_cualitativo FROM $tbl_analito_resultado_reporte_cualitativo WHERE id_analito = " . $qryData['id_analito'] . " ORDER BY desc_resultado_reporte_cualitativo ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_02");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_analito_resultado_reporte_cualitativo'];
			$returnValue_2[$x] = $qryData['desc_resultado_reporte_cualitativo'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showReferenceValue':

		switch ($filterid) {
			case 'id_array':

				$filterArray = explode("|", $filter);

				for ($x = 0; $x < sizeof($filterArray); $x++) {
					if ($filterArray[$x] == "") {
						$filterArray[$x] = "NULL";
					}
				}

				$filterQry = "WHERE $tbl_valor_metodo_referencia.id_muestra = $filterArray[1] AND $tbl_valor_metodo_referencia.id_laboratorio = $filterArray[2]";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT 
						id_valor_metodo_referencia,
						$tbl_programa.nombre_programa,
						$tbl_analito.nombre_analito,
						$tbl_metodologia.nombre_metodologia,
						$tbl_unidad.nombre_unidad,
						$tbl_muestra.codigo_muestra,valor_metodo_referencia 
					FROM 
						$tbl_valor_metodo_referencia 
						INNER JOIN $tbl_analito ON $tbl_valor_metodo_referencia.id_analito = $tbl_analito.id_analito 
						INNER JOIN $tbl_metodologia ON $tbl_valor_metodo_referencia.id_metodologia = $tbl_metodologia.id_metodologia 
						INNER JOIN $tbl_unidad ON $tbl_valor_metodo_referencia.id_unidad = $tbl_unidad.id_unidad 
						INNER JOIN $tbl_muestra ON $tbl_valor_metodo_referencia.id_muestra = $tbl_muestra.id_muestra 
						INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra 
						INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa 
					$filterQry 
					ORDER BY $tbl_programa.nombre_programa ASC, $tbl_muestra.codigo_muestra ASC, $tbl_analito.nombre_analito ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();
		$returnValue_3 = array();
		$returnValue_4 = array();
		$returnValue_5 = array();
		$returnValue_6 = array();
		$returnValue_7 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_valor_metodo_referencia'];
			$returnValue_2[$x] = $qryData['nombre_programa'];
			$returnValue_3[$x] = $qryData['codigo_muestra'];
			$returnValue_4[$x] = $qryData['nombre_analito'];
			$returnValue_5[$x] = $qryData['nombre_metodologia'];
			$returnValue_6[$x] = $qryData['valor_metodo_referencia'];
			$returnValue_7[$x] = $qryData['nombre_unidad'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';
		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';
		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';
		echo '<returnvalues6>' . implode("|", $returnValue_6) . '</returnvalues6>';
		echo '<returnvalues7>' . implode("|", $returnValue_7) . '</returnvalues7>';
		echo '</response>';
		break;
	case 'showAnalit':

		switch ($filterid) {
			case 'id_programa':
				$filterQry = "WHERE $tbl_programa.id_programa = " . $filter;
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT $tbl_programa_analito.id_conexion,$tbl_analito.id_analito,$tbl_programa.nombre_programa,$tbl_analito.nombre_analito FROM $tbl_analito INNER JOIN $tbl_programa_analito ON $tbl_analito.id_analito = $tbl_programa_analito.id_analito INNER JOIN $tbl_programa ON $tbl_programa.id_programa = $tbl_programa_analito.id_programa " . $filterQry . " ORDER BY $tbl_programa.nombre_programa ASC, $tbl_analito.nombre_analito ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();
		$returnValue_3 = array();
		$returnValue_4 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_conexion'];
			$returnValue_2[$x] = $qryData['nombre_programa'];
			$returnValue_3[$x] = $qryData['id_analito'];
			$returnValue_4[$x] = $qryData['nombre_analito'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 selectomit="1" content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '<returnvalues3 content="id">' . implode("|", $returnValue_3) . '</returnvalues3>';
		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';
		echo '</response>';
		break;
	case 'showAnalyzer':

		switch ($filterid) {
			case 'id_analito':
				$filterQry = "WHERE $tbl_analizador.id_analizador IN (SELECT id_analizador FROM $tbl_configuracion_laboratorio_analito WHERE id_analito = $filter)";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT id_analizador,nombre_analizador FROM $tbl_analizador " . $filterQry . " ORDER BY nombre_analizador ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_analizador'];
			$returnValue_2[$x] = $qryData['nombre_analizador'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showMethod':

		switch ($filterid) {
			case 'id_analizador':
				$filterQry = "WHERE $tbl_analizador.id_analizador = " . $filter;
				break;
			case 'id_analito':

				$filterArray = explode("|", $filter);

				for ($x = 0; $x < sizeof($filterArray); $x++) {
					if ($filterArray[$x] == "") {
						$filterArray[$x] = "NULL";
					}
				}

				// $filterQry = "WHERE $tbl_metodologia.id_metodologia IN (SELECT id_metodologia FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY nombre_metodologia";
				// Se actualiza la sentencia group by
				$filterQry = "WHERE $tbl_metodologia.id_metodologia IN (SELECT id_metodologia FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY $tbl_metodologia.id_metodologia";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT $tbl_metodologia_analizador.id_conexion,$tbl_metodologia.id_metodologia,$tbl_metodologia.nombre_metodologia,$tbl_analizador.nombre_analizador FROM $tbl_metodologia INNER JOIN $tbl_metodologia_analizador ON $tbl_metodologia.id_metodologia = $tbl_metodologia_analizador.id_metodologia INNER JOIN $tbl_analizador ON $tbl_analizador.id_analizador = $tbl_metodologia_analizador.id_analizador " . $filterQry . " ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_metodologia.nombre_metodologia ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();
		$returnValue_3 = array();
		$returnValue_4 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_conexion'];
			$returnValue_2[$x] = $qryData['nombre_analizador'];
			$returnValue_3[$x] = $qryData['id_metodologia'];
			$returnValue_4[$x] = $qryData['nombre_metodologia'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 selectomit="1" content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '<returnvalues3 content="id">' . implode("|", $returnValue_3) . '</returnvalues3>';
		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';
		echo '</response>';
		break;
	case 'showUnit':

		switch ($filterid) {
			case 'id_analizador':
				$filterQry = "WHERE $tbl_analizador.id_analizador = " . $filter;
				break;
			case 'id_analito':

				$filterArray = explode("|", $filter);

				for ($x = 0; $x < sizeof($filterArray); $x++) {
					if ($filterArray[$x] == "") {
						$filterArray[$x] = "NULL";
					}
				}

				// $filterQry = "WHERE $tbl_unidad.id_unidad IN (SELECT id_unidad FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY nombre_unidad";
				// Se actualiza sentencia de group by
				$filterQry = "WHERE $tbl_unidad.id_unidad IN (SELECT id_unidad FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY $tbl_unidad.id_unidad";

				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT $tbl_unidad_analizador.id_conexion,$tbl_unidad.id_unidad,$tbl_unidad.nombre_unidad,$tbl_analizador.nombre_analizador FROM $tbl_unidad INNER JOIN $tbl_unidad_analizador ON $tbl_unidad.id_unidad = $tbl_unidad_analizador.id_unidad INNER JOIN $tbl_analizador ON $tbl_analizador.id_analizador = $tbl_unidad_analizador.id_analizador " . $filterQry . " ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_unidad.nombre_unidad ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_01");

		$returnValue_1 = array();
		$returnValue_2 = array();
		$returnValue_3 = array();
		$returnValue_4 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['id_conexion'];
			$returnValue_2[$x] = $qryData['nombre_analizador'];
			$returnValue_3[$x] = $qryData['id_unidad'];
			$returnValue_4[$x] = $qryData['nombre_unidad'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id" selectomit="1">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '<returnvalues3 content="id">' . implode("|", $returnValue_3) . '</returnvalues3>';
		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';
		echo '</response>';
		break;
	default:
		echo '<response code="0">PHP callsHandler error: id "' . $header . '" not found</response>';
		break;
}

mysql_close($con);
exit;
?>