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

	$_POST['filter'] = '';

}



if (!isset($_POST['filterid'])) {

	$_POST['filterid'] = '';

}



$filter = $_POST['filter'];

$filterid = $_POST['filterid'];



if ($filter == "") {

	$filter = "NULL";

}

if ($filterid == "") {

	$filterid = "NULL";

}



switch ($header) {

	case 'showCat':



		switch ($filterid) {

			case 'id_distribuidor':

				$filterQry = "WHERE $tbl_distribuidor.id_distribuidor = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_catalogo,nombre_catalogo,nombre_distribuidor FROM $tbl_catalogo INNER JOIN $tbl_distribuidor ON $tbl_catalogo.id_distribuidor = $tbl_distribuidor.id_distribuidor " . $filterQry . " ORDER BY nombre_distribuidor ASC, nombre_catalogo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01" . $qry);



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_catalogo'];

			$returnValue_2[$x] = $qryData['nombre_distribuidor'];

			$returnValue_3[$x] = $qryData['nombre_catalogo'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';

		break;

	case 'showLot':



		switch ($filterid) {

			case 'id_catalogo':

				$filterQry = "WHERE $tbl_catalogo.id_catalogo = $filter AND estado_lote = 1";

				break;

			case 'estado_lote':

				$filterQry = "WHERE estado_lote = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT $tbl_lote.id_lote,$tbl_catalogo.nombre_catalogo,nombre_lote,fecha_vencimiento,nivel_lote FROM $tbl_lote INNER JOIN $tbl_catalogo ON $tbl_catalogo.id_catalogo = $tbl_lote.id_catalogo " . $filterQry . " ORDER BY $tbl_catalogo.nombre_catalogo ASC,nivel_lote ASC, nombre_lote ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_lote'];

			$returnValue_2[$x] = $qryData['nombre_catalogo'];

			$returnValue_3[$x] = $qryData['nombre_lote'];

			$returnValue_4[$x] = $qryData['fecha_vencimiento'];

			$returnValue_5[$x] = $qryData['nivel_lote'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;

	case 'showAllLots':



		switch ($filterid) {

			case 'id_catalogo':

				$filterQry = "WHERE $tbl_catalogo.id_catalogo = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT $tbl_lote.id_lote,$tbl_catalogo.nombre_catalogo,nombre_lote,estado_lote,nivel_lote FROM $tbl_lote INNER JOIN $tbl_catalogo ON $tbl_catalogo.id_catalogo = $tbl_lote.id_catalogo " . $filterQry . " ORDER BY estado_lote ASC, $tbl_catalogo.nombre_catalogo ASC, nivel_lote ASC, nombre_lote ASC";





		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_lote'];

			$returnValue_2[$x] = $qryData['nombre_catalogo'];

			$returnValue_3[$x] = $qryData['nombre_lote'];

			$returnValue_4[$x] = $qryData['nivel_lote'];

			$returnValue_5[$x] = $qryData['estado_lote'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;



	case "showProgramPAT":



		$qry = "SELECT 

						$tbl_programa_pat.id_programa as 'id_programa_pat',

						$tbl_programa_pat.nombre as 'nombre_programa_pat'

					from

						$tbl_programa_pat

					ORDER BY 

						$tbl_programa_pat.nombre";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_2501489");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_programa_pat'];

			$returnValue_2[$x] = $qryData['nombre_programa_pat'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';



		break;





	case "showLotePAT":



		$qry = "SELECT 

						id_lote_pat as 'id_lote_pat',

						nombre as 'nombre_lote_pat'

					from

						lote_pat

					ORDER BY 

						nombre";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_2501488");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_lote_pat'];

			$returnValue_2[$x] = $qryData['nombre_lote_pat'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';



		break;



	case "showRetoPAT":



		switch ($filterid) {

			case 'activos':

				$filterQry = "WHERE reto.estado = 1";

				break;

			case 'id_programa_pat':

				$filterQry = "WHERE programa_pat.id_programa = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						$tbl_reto.id_reto,

						$tbl_programa_pat.nombre as 'nombre_programa_pat',

						$tbl_reto.nombre as 'nombre_reto',

						$tbl_reto.estado as 'estado',

						lote_pat.nombre as 'nombre_lote_pat'

					from

						$tbl_programa_pat 

						join $tbl_reto on $tbl_programa_pat.id_programa = $tbl_reto.programa_pat_id_programa

						join lote_pat on lote_pat.id_lote_pat = reto.lote_pat_id_lote_pat

					$filterQry

					ORDER BY $tbl_programa_pat.nombre ASC, $tbl_reto.nombre ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_245687");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_reto'];

			$returnValue_2[$x] = $qryData['nombre_programa_pat'];

			$returnValue_3[$x] = $qryData['nombre_reto'];

			$returnValue_4[$x] = $qryData['nombre_lote_pat'];

			$returnValue_5[$x] = $qryData['estado'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';



		echo '</response>';



		break;



	case "showCasoClinicoPAT":



		switch ($filterid) {

			/*

			case 'activos':

				$filterQry = "WHERE reto.estado = 1";

				break;

				*/

			case 'id_reto_pat':

				$filterQry = "WHERE reto.id_reto = " . $filter;

				break;

			case 'id_reto_pat_and_activo':

				$filterQry = "WHERE caso_clinico.estado = 1 AND reto.id_reto = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						caso_clinico.id_caso_clinico as 'id_caso_clinico', 

						caso_clinico.reto_id_reto as 'reto_id_reto', 

						caso_clinico.codigo as 'codigo', 

						caso_clinico.nombre as 'nombre_caso_clinico', 

						COALESCE(caso_clinico.enunciado, ' - - ') as 'enunciado', 

						COALESCE(caso_clinico.revision, ' - - ') as 'revision', 

						COALESCE(caso_clinico.tejido, ' - - ') as 'tejido', 

						COALESCE(caso_clinico.celulas_objetivo, ' - - ') as 'celulas_objetivo',

						caso_clinico.estado as 'estado',

						programa_pat.nombre as 'nombre_programa_pat',

						reto.nombre as 'nombre_reto_pat'

					from

						caso_clinico

						join reto on reto.id_reto = caso_clinico.reto_id_reto

						join programa_pat on programa_pat.id_programa = reto.programa_pat_id_programa

					$filterQry

					ORDER BY programa_pat.nombre ASC, reto.nombre ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_2456814");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();

		$returnValue_7 = array();

		$returnValue_8 = array();

		$returnValue_9 = array();

		$returnValue_10 = array();

		$returnValue_11 = array();

		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_caso_clinico'];

			$returnValue_2[$x] = $qryData['reto_id_reto'];

			$returnValue_3[$x] = $qryData['codigo'];

			$returnValue_4[$x] = $qryData['nombre_caso_clinico'];

			$returnValue_5[$x] = $qryData['enunciado'];

			$returnValue_6[$x] = $qryData['revision'];

			$returnValue_7[$x] = $qryData['tejido'];

			$returnValue_8[$x] = $qryData['celulas_objetivo'];

			$returnValue_9[$x] = $qryData['estado'];

			$returnValue_10[$x] = $qryData['nombre_programa_pat'];

			$returnValue_11[$x] = $qryData['nombre_reto_pat'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6 selectomit="1">' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '<returnvalues7 selectomit="1">' . implode("|", $returnValue_7) . '</returnvalues7>';

		echo '<returnvalues8 selectomit="1">' . implode("|", $returnValue_8) . '</returnvalues8>';

		echo '<returnvalues9 selectomit="1">' . implode("|", $returnValue_9) . '</returnvalues9>';

		echo '<returnvalues10 selectomit="1">' . implode("|", $returnValue_10) . '</returnvalues10>';

		echo '<returnvalues11 selectomit="1">' . implode("|", $returnValue_11) . '</returnvalues11>';

		echo '</response>';

		break;







	case 'showProgram':



		switch ($filterid) {

			case 'id_laboratorio':

				$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = " . $filter;

				break;

			case 'id_tipo_programa':

				$filterQry = "WHERE $tbl_tipo_programa.id_tipo_programa = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		// $qry = "SELECT $tbl_programa.id_programa,nombre_programa,sigla_programa,no_muestras,tipo_muestra,modalidad_muestra,$tbl_tipo_programa.desc_tipo_programa FROM $tbl_programa LEFT OUTER JOIN $tbl_programa_laboratorio ON $tbl_programa.id_programa = $tbl_programa_laboratorio.id_programa INNER JOIN $tbl_tipo_programa ON $tbl_programa.id_tipo_programa = $tbl_tipo_programa.id_tipo_programa LEFT OUTER JOIN $tbl_laboratorio ON $tbl_programa_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio ".$filterQry." GROUP BY $tbl_programa.nombre_programa ORDER BY $tbl_tipo_programa.id_tipo_programa ASC, nombre_programa ASC";

		// Se actualiza la sentencia de group by

		$qry = "SELECT DISTINCT 

			            $tbl_programa.id_programa,

			            nombre_programa,

			            sigla_programa,

			            no_muestras,

			            tipo_muestra,

			            modalidad_muestra,

			            $tbl_tipo_programa.desc_tipo_programa,

			            $tbl_tipo_programa.id_tipo_programa

			 FROM $tbl_programa 

			 LEFT OUTER JOIN $tbl_programa_laboratorio ON $tbl_programa.id_programa = $tbl_programa_laboratorio.id_programa 

			 INNER JOIN $tbl_tipo_programa ON $tbl_programa.id_tipo_programa = $tbl_tipo_programa.id_tipo_programa 

			 LEFT OUTER JOIN $tbl_laboratorio ON $tbl_programa_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio " . $filterQry . " 

			 ORDER BY $tbl_tipo_programa.id_tipo_programa ASC, nombre_programa ASC";



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

			$returnValue_1[$x] = $qryData['id_programa'];

			$returnValue_2[$x] = $qryData['nombre_programa'];

			$returnValue_3[$x] = $qryData['sigla_programa'];

			$returnValue_4[$x] = $qryData['no_muestras'];

			$returnValue_5[$x] = $qryData['tipo_muestra'];

			$returnValue_6[$x] = $qryData['modalidad_muestra'];

			$returnValue_7[$x] = $qryData['desc_tipo_programa'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6 selectomit="1">' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '<returnvalues7 selectomit="1">' . implode("|", $returnValue_7) . '</returnvalues7>';

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



		$qry = "SELECT 

						$tbl_programa_analito.id_conexion,

						$tbl_analito.id_analito,

						$tbl_programa.nombre_programa,

						$tbl_analito.cod_analito,

						$tbl_analito.nombre_analito 

					FROM $tbl_analito 

						INNER JOIN $tbl_programa_analito ON $tbl_analito.id_analito = $tbl_programa_analito.id_analito 

						INNER JOIN $tbl_programa ON $tbl_programa.id_programa = $tbl_programa_analito.id_programa " . $filterQry . " 

					ORDER BY $tbl_programa.nombre_programa ASC, $tbl_analito.nombre_analito ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_conexion'];

			$returnValue_2[$x] = $qryData['nombre_programa'];

			$returnValue_3[$x] = $qryData['id_analito'];

			$returnValue_4[$x] = $qryData['nombre_analito'];

			$returnValue_5[$x] = $qryData['cod_analito'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 selectomit="1" content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 content="id">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;

	case 'showSample':



		switch ($filterid) {

			case 'id_programa':

				$filterQry = "WHERE $tbl_programa.id_programa = " . $filter;

				break;

			case 'fecha':

				$filterQry = "WHERE $tbl_programa.id_programa = $filter AND DATE('$logDate') <= $tbl_muestra_programa.fecha_vencimiento";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

					$tbl_muestra.id_muestra,

					$tbl_muestra_programa.id_muestra_programa,

					$tbl_muestra.codigo_muestra,

					$tbl_programa.nombre_programa,

					$tbl_lote.nombre_lote,

					$tbl_lote.fecha_vencimiento AS fecha_lote,

					$tbl_catalogo.nombre_catalogo,

					$tbl_lote.nombre_lote_qap,

					$tbl_muestra_programa.fecha_vencimiento AS fecha_muestra,

					$tbl_lote.nivel_lote,$tbl_ronda.no_ronda,

					$tbl_contador_muestra.no_contador 

				FROM $tbl_muestra_programa INNER JOIN $tbl_muestra ON $tbl_muestra_programa.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_lote ON $tbl_muestra_programa.id_lote = $tbl_lote.id_lote INNER JOIN $tbl_catalogo ON $tbl_lote.id_catalogo = $tbl_catalogo.id_catalogo INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_contador_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_ronda ON $tbl_contador_muestra.id_ronda = $tbl_ronda.id_ronda " . $filterQry . " ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();

		$returnValue_7 = array();

		$returnValue_8 = array();

		$returnValue_9 = array();

		$returnValue_10 = array();

		$returnValue_11 = array();

		$returnValue_12 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_muestra_programa'];

			$returnValue_2[$x] = $qryData['codigo_muestra'];

			$returnValue_3[$x] = $qryData['nombre_programa'];

			$returnValue_4[$x] = $qryData['nombre_lote_qap'];

			$returnValue_5[$x] = $qryData['fecha_muestra'];

			$returnValue_6[$x] = $qryData['nombre_catalogo'];

			$returnValue_7[$x] = $qryData['nombre_lote'];

			$returnValue_8[$x] = $qryData['nivel_lote'];

			$returnValue_9[$x] = $qryData['fecha_lote'];

			$returnValue_10[$x] = $qryData['no_contador'];

			$returnValue_11[$x] = $qryData['no_ronda'];

			$returnValue_12[$x] = $qryData['id_muestra'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 selectomit="1" content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6 selectomit="1">' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '<returnvalues7 selectomit="1">' . implode("|", $returnValue_7) . '</returnvalues7>';

		echo '<returnvalues8 selectomit="1">' . implode("|", $returnValue_8) . '</returnvalues8>';

		echo '<returnvalues9 selectomit="1">' . implode("|", $returnValue_9) . '</returnvalues9>';

		echo '<returnvalues10 selectomit="1">' . implode("|", $returnValue_10) . '</returnvalues10>';

		echo '<returnvalues11 selectomit="1">' . implode("|", $returnValue_11) . '</returnvalues11>';

		echo '<returnvalues12 content="id">' . implode("|", $returnValue_12) . '</returnvalues12>';

		echo '</response>';

		break;

	case 'showSampleSimple':



		switch ($filterid) {

			case 'id_programa':

				$filterQry = "WHERE $tbl_muestra_programa.id_programa = " . $filter;

				break;

			case 'fecha':

				$filterQry = "WHERE $tbl_muestra_programa.id_programa = $filter AND DATE('$logDate') <= $tbl_muestra_programa.fecha_vencimiento";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT $tbl_muestra.id_muestra,codigo_muestra,$tbl_ronda.no_ronda FROM $tbl_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_contador_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_ronda ON $tbl_contador_muestra.id_ronda = $tbl_ronda.id_ronda " . $filterQry . " ORDER BY $tbl_ronda.no_ronda DESC, $tbl_muestra.codigo_muestra ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_muestra'];

			$returnValue_2[$x] = $qryData['no_ronda'];

			$returnValue_3[$x] = $qryData['codigo_muestra'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';

		break;

	case 'showAnalyzer':



		switch ($filterid) {

			case 'id_analito':

				// Pertenecia al modulo de programa por lo cual se deshabilita

				$filterQry = '';

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_analizador,cod_analizador,nombre_analizador FROM $tbl_analizador " . $filterQry . " ORDER BY nombre_analizador ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_analizador'];

			$returnValue_2[$x] = $qryData['cod_analizador'];

			$returnValue_3[$x] = $qryData['nombre_analizador'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';



		break;



	case 'showMetodologia':



		switch ($filterid) {

			case 'id_analito':

				// Linea de codigo deshabilitada

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_metodologia,cod_metodologia,nombre_metodologia FROM $tbl_metodologia " . $filterQry . " ORDER BY nombre_metodologia ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_metodologia'];

			$returnValue_2[$x] = $qryData['cod_metodologia'];

			$returnValue_3[$x] = $qryData['nombre_metodologia'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';

		break;



	case 'showMagnitud':



		switch ($filterid) {

			case 'id_analito':

				// Linea de codigo deshabilitada

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_analito,cod_analito,nombre_analito FROM $tbl_analito " . $filterQry . " ORDER BY nombre_analito ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_analito'];

			$returnValue_2[$x] = $qryData['cod_analito'];

			$returnValue_3[$x] = $qryData['nombre_analito'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';

		break;





	case 'showUnidad':



		switch ($filterid) {

			case 'id_analito':

				// Linea de codigo deshabilitada

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_unidad,cod_unidad,nombre_unidad FROM $tbl_unidad " . $filterQry . " ORDER BY nombre_unidad ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_unidad'];

			$returnValue_2[$x] = $qryData['cod_unidad'];

			$returnValue_3[$x] = $qryData['nombre_unidad'];

			$x++;

		}





		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

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

				// Se actualiza la sentencia de group by

				$filterQry = "WHERE $tbl_metodologia.id_metodologia IN (SELECT id_metodologia FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1])";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT

			            $tbl_metodologia_analizador.id_conexion,

			            $tbl_metodologia.id_metodologia,

			            $tbl_metodologia.nombre_metodologia,

			            $tbl_analizador.nombre_analizador 

			    FROM $tbl_metodologia 

			    INNER JOIN $tbl_metodologia_analizador ON $tbl_metodologia.id_metodologia = $tbl_metodologia_analizador.id_metodologia 

			    INNER JOIN $tbl_analizador ON $tbl_analizador.id_analizador = $tbl_metodologia_analizador.id_analizador 

			    " . $filterQry . " 

			    ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_metodologia.nombre_metodologia ASC";



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

	case 'showReactive':



		switch ($filterid) {

			case 'id_analito':

				// Se deshabilita

				// Linea de codigo deshabilitada

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_reactivo,nombre_reactivo,cod_reactivo FROM $tbl_reactivo " . $filterQry . " ORDER BY nombre_reactivo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_reactivo'];

			$returnValue_2[$x] = $qryData['cod_reactivo'];

			$returnValue_3[$x] = $qryData['nombre_reactivo'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

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

				// Se actualiza la sentencia group by

				$filterQry = "WHERE $tbl_unidad.id_unidad IN (SELECT id_unidad FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1])";



				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT 

						$tbl_unidad_analizador.id_conexion,

			            $tbl_unidad.id_unidad,

			            $tbl_unidad.nombre_unidad,

			            $tbl_analizador.nombre_analizador 

			     FROM $tbl_unidad INNER JOIN $tbl_unidad_analizador ON $tbl_unidad.id_unidad = $tbl_unidad_analizador.id_unidad INNER JOIN $tbl_analizador ON $tbl_analizador.id_analizador = $tbl_unidad_analizador.id_analizador " . $filterQry . " ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_unidad.nombre_unidad ASC";



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

	case 'showVitrosGen':



		switch ($filterid) {

			case 'id_analito':



				$filterArray = explode("|", $filter);



				for ($x = 0; $x < sizeof($filterArray); $x++) {

					if ($filterArray[$x] == "") {

						$filterArray[$x] = "NULL";

					}

				}



				// $filterQry = "WHERE $tbl_gen_vitros.id_gen_vitros IN (SELECT id_gen_vitros FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY valor_gen_vitros";

				// Se actualiza group by

				$filterQry = "WHERE $tbl_gen_vitros.id_gen_vitros IN (SELECT id_gen_vitros FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1])";



				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT id_gen_vitros,valor_gen_vitros FROM $tbl_gen_vitros " . $filterQry . " ORDER BY valor_gen_vitros ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_gen_vitros'];

			$returnValue_2[$x] = $qryData['valor_gen_vitros'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showLab':



		switch ($filterid) {

			case "patologia":

				$filterQry = 'where no_laboratorio like "200%"';

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_laboratorio,no_laboratorio,nombre_laboratorio,direccion_laboratorio,telefono_laboratorio,correo_laboratorio,contacto_laboratorio,nombre_ciudad 

					FROM $tbl_laboratorio INNER JOIN $tbl_ciudad ON $tbl_laboratorio.id_ciudad = $tbl_ciudad.id_ciudad $filterQry 

					ORDER BY no_laboratorio ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();

		$returnValue_7 = array();

		$returnValue_8 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_laboratorio'];

			$returnValue_2[$x] = $qryData['no_laboratorio'];

			$returnValue_3[$x] = $qryData['nombre_laboratorio'];

			$returnValue_4[$x] = $qryData['contacto_laboratorio'];

			$returnValue_5[$x] = $qryData['direccion_laboratorio'];

			$returnValue_6[$x] = $qryData['nombre_ciudad'];

			$returnValue_7[$x] = $qryData['telefono_laboratorio'];

			$returnValue_8[$x] = $qryData['correo_laboratorio'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6 selectomit="1">' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '<returnvalues7 selectomit="1">' . implode("|", $returnValue_7) . '</returnvalues7>';

		echo '<returnvalues8 selectomit="1">' . implode("|", $returnValue_8) . '</returnvalues8>';

		echo '</response>';

		break;

	case 'showAssignedLabProgram':



		switch ($filterid) {

			case 'id_laboratorio':

				$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_conexion,$tbl_programa.nombre_programa,$tbl_laboratorio.no_laboratorio,$tbl_laboratorio.nombre_laboratorio,$tbl_programa.id_programa,$tbl_programa_laboratorio.activo FROM $tbl_programa INNER JOIN $tbl_programa_laboratorio ON $tbl_programa.id_programa = $tbl_programa_laboratorio.id_programa INNER JOIN $tbl_laboratorio ON $tbl_programa_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio $filterQry ORDER BY $tbl_programa.nombre_programa ASC, $tbl_laboratorio.nombre_laboratorio ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_conexion'];

			$returnValue_2[$x] = $qryData['no_laboratorio'];

			$returnValue_3[$x] = $qryData['nombre_laboratorio'];

			$returnValue_4[$x] = $qryData['nombre_programa'];

			$returnValue_5[$x] = $qryData['id_programa'];

			$returnValue_6[$x] = $qryData['activo'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 selectomit="1" content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 content="id">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6 selectomit="1">' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '</response>';

		break;





	case "showAssignedLabProgramGeneral":



		$qryLab = "SELECT no_laboratorio FROM laboratorio where id_laboratorio = " . $filter;

		$qryLabArray = mysql_query($qryLab);

		$qryDataLab = mysql_fetch_array($qryLabArray);

		$no_laboratorio = $qryDataLab['no_laboratorio'];



		if (strpos($no_laboratorio, "200") === 0) { // Si es un laboratorio de patologia anatomica



			$qry = "SELECT distinct

						programa_pat.id_programa,

						programa_pat.nombre

					FROM 

						programa_pat join reto on programa_pat.id_programa = reto.programa_pat_id_programa

						join reto_laboratorio on reto.id_reto = reto_laboratorio.reto_id_reto

					where reto_laboratorio.laboratorio_id_laboratorio = '" . $filter . "'

					order by programa_pat.nombre";



			$qryArray = mysql_query($qry);

			mysqlException(mysql_error(), $header . "_01");



			$returnValue_1 = array();

			$returnValue_2 = array();



			$x = 0;



			while ($qryData = mysql_fetch_array($qryArray)) {

				$returnValue_1[$x] = $qryData['id_programa'];

				$returnValue_2[$x] = $qryData['nombre'];

				$x++;

			}



			echo '<response code="1">';

			echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

			echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

			echo '</response>';



		} else if (strpos($no_laboratorio, "100") === 0) { // Si es un laboratorio clinico



			$qry = "SELECT id_conexion,$tbl_programa.nombre_programa,$tbl_laboratorio.no_laboratorio,$tbl_laboratorio.nombre_laboratorio,$tbl_programa.id_programa,$tbl_programa_laboratorio.activo FROM $tbl_programa INNER JOIN $tbl_programa_laboratorio ON $tbl_programa.id_programa = $tbl_programa_laboratorio.id_programa INNER JOIN $tbl_laboratorio ON $tbl_programa_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio WHERE $tbl_laboratorio.id_laboratorio = " . $filter . " ORDER BY $tbl_programa.nombre_programa ASC, $tbl_laboratorio.nombre_laboratorio ASC";



			$qryArray = mysql_query($qry);

			mysqlException(mysql_error(), $header . "_01");



			$returnValue_1 = array();

			$returnValue_2 = array();



			$x = 0;



			while ($qryData = mysql_fetch_array($qryArray)) {

				$returnValue_1[$x] = $qryData['nombre_programa'];

				$returnValue_2[$x] = $qryData['id_programa'];

				$x++;

			}



			echo '<response code="1">';

			echo '<returnvalues1>' . implode("|", $returnValue_1) . '</returnvalues1>';

			echo '<returnvalues2 content="id">' . implode("|", $returnValue_2) . '</returnvalues2>';

			echo '</response>';

		}



		break;



	case 'showAssignedCiclosProgram':



		$filterArray = explode("|", $filter);



		for ($x = 0; $x < sizeof($filterArray); $x++) {

			if ($filterArray[$x] == "") {

				$filterArray[$x] = "NULL";

			}

		}



		$id_programa = $filterArray[0];

		$id_laboratorio = $filterArray[1];



		$qryLab = "SELECT no_laboratorio FROM laboratorio where id_laboratorio = " . $id_laboratorio;

		$qryLabArray = mysql_query($qryLab);

		$qryDataLab = mysql_fetch_array($qryLabArray);

		$no_laboratorio = $qryDataLab['no_laboratorio'];



		if (strpos($no_laboratorio, "200") === 0) { // Si es un laboratorio de patologia anatomica



			$qry = "SELECT distinct

					reto.id_reto,

					reto.nombre

				FROM 

					programa_pat join reto on programa_pat.id_programa = reto.programa_pat_id_programa

					join reto_laboratorio on reto.id_reto = reto_laboratorio.reto_id_reto

				where reto_laboratorio.laboratorio_id_laboratorio = '" . $id_laboratorio . "' and programa_pat.id_programa = '" . $id_programa . "'";



			$qryArray = mysql_query($qry);

			mysqlException(mysql_error(), $header . "_01");



			$returnValue_1 = array();

			$returnValue_2 = array();



			$x = 0;



			while ($qryData = mysql_fetch_array($qryArray)) {

				$returnValue_1[$x] = $qryData['id_reto'];

				$returnValue_2[$x] = $qryData['nombre'];

				$x++;

			}



			echo '<response code="1">';

			echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

			echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

			echo '</response>';



		} else if (strpos($no_laboratorio, "100") === 0) { // Si es un laboratorio clinico



			$qry = "SELECT DISTINCT

					$tbl_programa.nombre_programa,

					$tbl_ronda.no_ronda,

					$tbl_ronda.id_ronda,

					'1' AS codigo_muestra,

					'1' AS no_contador 

				FROM $tbl_ronda 

				INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda 

				INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra 

				INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra 

				INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa 

				WHERE $tbl_programa.id_programa = $id_programa

				ORDER BY $tbl_ronda.no_ronda DESC";



			$qryArray = mysql_query($qry);

			mysqlException(mysql_error(), $header . "_01");



			$returnValue_1 = array();

			$returnValue_2 = array();



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



		}

		break;



	case "showDocuments":



		$filterArray = explode("|", $filter);



		for ($x = 0; $x < sizeof($filterArray); $x++) {

			if ($filterArray[$x] == "") {

				$filterArray[$x] = "NULL";

			}

		}



		$qryLab = "SELECT no_laboratorio FROM laboratorio where id_laboratorio = " . $filterArray[0];

		$qryLabArray = mysql_query($qryLab);

		$qryDataLab = mysql_fetch_array($qryLabArray);

		$no_laboratorio = $qryDataLab['no_laboratorio'];



		if (strpos($no_laboratorio, "200") === 0) {

			$filterQry = "WHERE archivo.id_laboratorio = '" . mysql_real_escape_string(stripcslashes(clean($filterArray[0]))) . "' AND id_reto = " . mysql_real_escape_string(stripcslashes(clean($filterArray[1])));

		} else if (strpos($no_laboratorio, "100") === 0) {

			$filterQry = "WHERE archivo.id_laboratorio = '" . mysql_real_escape_string(stripcslashes(clean($filterArray[0]))) . "' AND id_ronda = " . mysql_real_escape_string(stripcslashes(clean($filterArray[1])));

		}



		$qry = "SELECT id_archivo,nombre_archivo,extencion_archivo,index_archivo,activo,fecha_carga 

			FROM archivo $filterQry ORDER BY fecha_carga DESC, activo DESC, nombre_archivo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_0x01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = encryptControl('encrypt', $qryData['id_archivo'], $_SESSION['qap_token']);

			$returnValue_2[$x] = $qryData['nombre_archivo'];

			$returnValue_3[$x] = $qryData['extencion_archivo'];

			$returnValue_4[$x] = $qryData['index_archivo'];

			$returnValue_5[$x] = $qryData['activo'];

			$returnValue_6[$x] = $qryData['fecha_carga'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6>' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '</response>';



		break;



	case 'showActiveStatusOptions':

		echo '<response code="1">';

		echo '<returnvalues1 content="id">0|1</returnvalues1>';

		echo '<returnvalues2>No|Si</returnvalues2>';

		echo '</response>';

		break;



	case 'showAssignedLabReto':



		switch ($filterid) {

			case 'id_laboratorio':

				$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						$tbl_reto_laboratorio.id_reto_laboratorio,

						$tbl_reto.nombre as 'nombre_reto',

						$tbl_laboratorio.no_laboratorio,

						$tbl_laboratorio.nombre_laboratorio,

						$tbl_programa_pat.id_programa, 	

						$tbl_programa_pat.nombre as 'nombre_programa_pat',

						$tbl_reto_laboratorio.envio as 'envio'

					FROM 

						$tbl_programa_pat join $tbl_reto on $tbl_programa_pat.id_programa = $tbl_reto.programa_pat_id_programa 

						join $tbl_reto_laboratorio on $tbl_reto_laboratorio.reto_id_reto = $tbl_reto.id_reto

						join $tbl_laboratorio on $tbl_laboratorio.id_laboratorio = $tbl_reto_laboratorio.laboratorio_id_laboratorio

					$filterQry

					ORDER BY $tbl_programa_pat.nombre ASC, $tbl_reto.nombre ASC";



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

			$returnValue_1[$x] = $qryData['id_reto_laboratorio'];

			$returnValue_2[$x] = $qryData['nombre_reto'];

			$returnValue_3[$x] = $qryData['no_laboratorio'];

			$returnValue_4[$x] = $qryData['nombre_laboratorio'];

			$returnValue_5[$x] = $qryData['id_programa'];

			$returnValue_6[$x] = $qryData['nombre_programa_pat'];

			$returnValue_7[$x] = $qryData['envio'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 selectomit="1" content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6>' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '<returnvalues7>' . implode("|", $returnValue_7) . '</returnvalues7>';

		echo '</response>';

		break;



	case 'showAssignedLabAnalit':



		switch ($filterid) {

			case 'id_array':

				$filterArray = explode("|", $filter);



				for ($x = 0; $x < sizeof($filterArray); $x++) {

					if ($filterArray[$x] == "") {

						$filterArray[$x] = "NULL";

					}

				}



				$filterQry = "WHERE $tbl_programa.id_programa = $filterArray[1] AND $tbl_laboratorio.id_laboratorio = $filterArray[0]";



				break;

			case 'id_laboratorio':

				$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT $tbl_configuracion_laboratorio_analito.id_configuracion,nombre_programa,nombre_analito,nombre_analizador,nombre_metodologia,nombre_reactivo,nombre_unidad,valor_gen_vitros,nombre_material,activo FROM $tbl_configuracion_laboratorio_analito INNER JOIN $tbl_programa ON $tbl_configuracion_laboratorio_analito.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_laboratorio ON $tbl_configuracion_laboratorio_analito.id_laboratorio = $tbl_laboratorio.id_laboratorio INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros LEFT JOIN $tbl_material ON $tbl_configuracion_laboratorio_analito.id_material = $tbl_material.id_material $filterQry ORDER BY nombre_programa ASC, nombre_analito ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();

		$returnValue_7 = array();

		$returnValue_8 = array();

		$returnValue_9 = array();

		$returnValue_10 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_configuracion'];

			$returnValue_2[$x] = $qryData['nombre_programa'];

			$returnValue_3[$x] = $qryData['nombre_analito'];

			$returnValue_4[$x] = $qryData['nombre_analizador'];

			$returnValue_5[$x] = $qryData['nombre_metodologia'];

			$returnValue_6[$x] = $qryData['nombre_reactivo'];

			$returnValue_7[$x] = $qryData['nombre_unidad'];

			$returnValue_8[$x] = $qryData['valor_gen_vitros'];

			$returnValue_9[$x] = $qryData['nombre_material'];

			$returnValue_10[$x] = $qryData['activo'];

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

		echo '<returnvalues8>' . implode("|", $returnValue_8) . '</returnvalues8>';

		echo '<returnvalues9>' . implode("|", $returnValue_9) . '</returnvalues9>';

		echo '<returnvalues10>' . implode("|", $returnValue_10) . '</returnvalues10>';

		echo '</response>';



		break;

	case 'showCountry':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_pais,nombre_pais FROM $tbl_pais $filterQry ORDER BY nombre_pais ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_pais'];

			$returnValue_2[$x] = $qryData['nombre_pais'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showAllUnits':



		switch ($filterid) {

			case "analitolaboratorio":

				$id_configuracion_lab = $filter;

				$qry = "SELECT id_analizador from $tbl_configuracion_laboratorio_analito where id_configuracion = $id_configuracion_lab";

				$qryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), $header . "_01");

				$id_analizador = $qryData["id_analizador"];

				$filterQry = " where analizador.id_analizador = $id_analizador";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

					$tbl_unidad.id_unidad,$tbl_unidad.nombre_unidad,$tbl_analizador.nombre_analizador 

				FROM $tbl_unidad 

				INNER JOIN $tbl_unidad_analizador ON $tbl_unidad.id_unidad = $tbl_unidad_analizador.id_unidad 

				INNER JOIN $tbl_analizador ON $tbl_unidad_analizador.id_analizador = $tbl_analizador.id_analizador 

				$filterQry

				ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_unidad.nombre_unidad ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_unidad'];

			$returnValue_2[$x] = $qryData['nombre_analizador'] . " - " . $qryData['nombre_unidad'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showAllVitrosGen':



		switch ($filterid) {

			case "analitolaboratorio":

				$id_configuracion_lab = $filter;

				$qry = "SELECT $tbl_analizador.nombre_analizador from $tbl_configuracion_laboratorio_analito join $tbl_analizador on $tbl_analizador.id_analizador = $tbl_configuracion_laboratorio_analito.id_analizador where id_configuracion = $id_configuracion_lab";

				$qryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), $header . "_01");

				$nombre_analizador = $qryData["nombre_analizador"];



				// Saber si el nombre del analizador contiene la palabra VITROS

				if (strpos(strtolower($nombre_analizador), "vitros") === false) {

					$filterQry = " where gen_vitros.valor_gen_vitros = 0"; // Como no contiene la palabra vitros, entonces muestra solo el cero

				} else {

					$filterQry = "";

				}



				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

					$tbl_gen_vitros.id_gen_vitros,

					$tbl_gen_vitros.valor_gen_vitros 

				FROM $tbl_gen_vitros 	

				$filterQry

				ORDER BY $tbl_gen_vitros.valor_gen_vitros ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_gen_vitros'];

			$returnValue_2[$x] = $qryData['valor_gen_vitros'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;



	case 'showAllMagnitudes':



		switch ($filterid) {

			case "analitolaboratorio":

				$id_configuracion_lab = $filter;

				$qry = "SELECT id_programa from $tbl_configuracion_laboratorio_analito where id_configuracion = $id_configuracion_lab";

				$qryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), $header . "_01");

				$id_programa = $qryData["id_programa"];

				$filterQry = " where programa.id_programa = $id_programa";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

					$tbl_analito.id_analito,$tbl_analito.nombre_analito,$tbl_programa.nombre_programa 

				FROM $tbl_analito 

					INNER JOIN $tbl_programa_analito ON $tbl_analito.id_analito = $tbl_programa_analito.id_analito 

					INNER JOIN $tbl_programa ON $tbl_programa_analito.id_programa = $tbl_programa.id_programa 

				$filterQry

				ORDER BY $tbl_programa.nombre_programa ASC, $tbl_analito.nombre_analito ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_analito'];

			$returnValue_2[$x] = $qryData['nombre_programa'] . " - " . $qryData['nombre_analito'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showAllMaterials':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_material,nombre_material FROM $tbl_material ORDER BY nombre_material ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_material'];

			$returnValue_2[$x] = $qryData['nombre_material'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showAllAnalyzers':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_analizador,nombre_analizador FROM $tbl_analizador ORDER BY nombre_analizador ASC";



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

	case 'showAllMethods':



		switch ($filterid) {

			case "analitolaboratorio":

				$id_configuracion_lab = $filter;

				$qry = "SELECT id_analizador from $tbl_configuracion_laboratorio_analito where id_configuracion = $id_configuracion_lab";

				$qryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), $header . "_01");

				$id_analizador = $qryData["id_analizador"];

				$filterQry = " where analizador.id_analizador = $id_analizador";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT $tbl_metodologia.id_metodologia,$tbl_metodologia.nombre_metodologia,$tbl_analizador.nombre_analizador 

					FROM $tbl_metodologia 

						INNER JOIN $tbl_metodologia_analizador ON $tbl_metodologia.id_metodologia = $tbl_metodologia_analizador.id_metodologia 

						INNER JOIN $tbl_analizador ON $tbl_metodologia_analizador.id_analizador = $tbl_analizador.id_analizador

					$filterQry 

					ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_metodologia.nombre_metodologia ASC";

		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_metodologia'];

			$returnValue_2[$x] = $qryData['nombre_analizador'] . " - " . $qryData['nombre_metodologia'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showAllReactives':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_reactivo,nombre_reactivo FROM $tbl_reactivo ORDER BY nombre_reactivo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_reactivo'];

			$returnValue_2[$x] = $qryData['nombre_reactivo'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showCity':



		switch ($filterid) {

			case 'id_pais':

				$filterQry = "WHERE $tbl_pais.id_pais = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_ciudad,nombre_ciudad,nombre_pais FROM $tbl_pais INNER JOIN $tbl_ciudad ON $tbl_ciudad.id_pais = $tbl_pais.id_pais " . $filterQry . " ORDER BY nombre_pais ASC, nombre_ciudad ASC";





		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_ciudad'];

			$returnValue_2[$x] = $qryData['nombre_pais'];

			$returnValue_3[$x] = $qryData['nombre_ciudad'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';

		break;

	case 'showUser':



		switch ($filterid) {

			case 'tipo_usuario':

				$filterQry = "WHERE usuario.estado=1 AND $tbl_usuario.tipo_usuario = " . $filter;

				break;

			default:

				$filterQry = 'WHERE usuario.estado=1 ';

				break;

		}



		$qry = "SELECT id_usuario,nombre_usuario,tipo_usuario,cod_usuario,nombre_completo,email_usuario FROM $tbl_usuario " . $filterQry . " ORDER BY nombre_usuario ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();

		$returnValue_8 = array();

		$returnValue_7 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_usuario'];

			$returnValue_2[$x] = $qryData['nombre_usuario'];

			$returnValue_3[$x] = "*****";

			$returnValue_4[$x] = $qryData['tipo_usuario'];



			if ($qryData['cod_usuario'] == null) {

				$returnValue_5[$x] = "-";

			} else {

				$returnValue_5[$x] = $qryData['cod_usuario'];

			}



			if ($qryData['nombre_completo'] == null) {

				$returnValue_6[$x] = "-";

			} else {

				$returnValue_6[$x] = $qryData['nombre_completo'];

			}





			if ($qryData['email_usuario'] == null) {

				$returnValue_7[$x] = "-";

			} else {

				$returnValue_7[$x] = $qryData['email_usuario'];

			}





			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6 selectomit="1">' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '<returnvalues7 selectomit="1">' . implode("|", $returnValue_7) . '</returnvalues7>';

		echo '</response>';

		break;



	case 'showIntentos':



		switch ($filterid) {

			case 'id_reto':

				$filterQry = "WHERE $tbl_intento.reto_id_reto = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT distinct

						laboratorio.id_laboratorio as qry1_id_laboratorio,

						laboratorio.no_laboratorio, 

						laboratorio.nombre_laboratorio, 

						reto.id_reto as qry1_id_reto,

						reto.nombre as nombre_reto,

						programa_pat.nombre as nombre_programa, 

						usuario.id_usuario as qry1_id_usuario,

						usuario.nombre_usuario,

						(

							select

								count(*)

							from 

								intento

							where 

								laboratorio_id_laboratorio = qry1_id_laboratorio 

								and reto_id_reto = qry1_id_reto

								and usuario_id_usuario = qry1_id_usuario

						) as num_intentos,

						(

							select

								intento.fecha

							from 

								intento

							where 

								laboratorio_id_laboratorio = qry1_id_laboratorio 

								and reto_id_reto = qry1_id_reto

								and usuario_id_usuario = qry1_id_usuario

							order by intento.id_intento desc

							limit 1

						) as ultima_fecha,

						(

							select

								intento.id_intento

							from 

								intento

							where 

								laboratorio_id_laboratorio = qry1_id_laboratorio 

								and reto_id_reto = qry1_id_reto

								and usuario_id_usuario = qry1_id_usuario

							order by intento.id_intento desc

							limit 1

						) as id_ultimo_intento,

						(

							select

								intento.revaloracion

							from 

								intento

							where 

								laboratorio_id_laboratorio = qry1_id_laboratorio 

								and reto_id_reto = qry1_id_reto

								and usuario_id_usuario = qry1_id_usuario

							order by intento.id_intento desc

							limit 1

						) as revaloracion

					FROM 

						intento 

						join laboratorio on laboratorio.id_laboratorio = intento.laboratorio_id_laboratorio

						join reto on reto.id_reto = intento.reto_id_reto

						join usuario on usuario.id_usuario = intento.usuario_id_usuario

						join programa_pat on programa_pat.id_programa = reto.programa_pat_id_programa

					$filterQry

					order by nombre_reto, nombre_programa

					";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");





		$qry1_id_laboratorio = array();

		$no_laboratorio = array();

		$nombre_laboratorio = array();

		$qry1_id_reto = array();

		$nombre_reto = array();

		$nombre_programa = array();

		$qry1_id_usuario = array();

		$nombre_usuario = array();

		$num_intentos = array();

		$ultima_fecha = array();

		$id_ultimo_intento = array();

		$revaloracion = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$qry1_id_laboratorio[$x] = $qryData['qry1_id_laboratorio'];

			$no_laboratorio[$x] = $qryData['no_laboratorio'];

			$nombre_laboratorio[$x] = $qryData['nombre_laboratorio'];

			$qry1_id_reto[$x] = $qryData['qry1_id_reto'];

			$nombre_reto[$x] = $qryData['nombre_reto'];

			$nombre_programa[$x] = $qryData['nombre_programa'];

			$qry1_id_usuario[$x] = $qryData['qry1_id_usuario'];

			$nombre_usuario[$x] = $qryData['nombre_usuario'];

			$num_intentos[$x] = $qryData['num_intentos'];

			$ultima_fecha[$x] = $qryData['ultima_fecha'];

			$id_ultimo_intento[$x] = $qryData['id_ultimo_intento'];

			$revaloracion[$x] = $qryData['revaloracion'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnValues_1 selectomit="1">' . implode("|", $qry1_id_laboratorio) . '</returnValues_1>';

		echo '<returnValues_2 selectomit="1">' . implode("|", $no_laboratorio) . '</returnValues_2>';

		echo '<returnValues_3 selectomit="1">' . implode("|", $nombre_laboratorio) . '</returnValues_3>';

		echo '<returnValues_4 selectomit="1">' . implode("|", $qry1_id_reto) . '</returnValues_4>';

		echo '<returnValues_5 selectomit="1">' . implode("|", $nombre_reto) . '</returnValues_5>';

		echo '<returnValues_6 selectomit="1">' . implode("|", $nombre_programa) . '</returnValues_6>';

		echo '<returnValues_7 selectomit="1">' . implode("|", $qry1_id_usuario) . '</returnValues_7>';

		echo '<returnValues_8 selectomit="1">' . implode("|", $nombre_usuario) . '</returnValues_8>';

		echo '<returnValues_9 selectomit="1">' . implode("|", $num_intentos) . '</returnValues_9>';

		echo '<returnValues_10 selectomit="1">' . implode("|", $ultima_fecha) . '</returnValues_10>';

		echo '<returnValues_11 content="id">' . implode("|", $id_ultimo_intento) . '</returnValues_11>';

		echo '<returnValues_12 selectomit="1">' . implode("|", $revaloracion) . '</returnValues_12>';

		echo '</response>';

		break;



	case 'showAssignedLabUser':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_conexion,nombre_usuario,nombre_laboratorio,no_laboratorio FROM $tbl_usuario_laboratorio INNER JOIN $tbl_usuario ON $tbl_usuario_laboratorio.id_usuario = $tbl_usuario.id_usuario INNER JOIN $tbl_laboratorio ON $tbl_usuario_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio $filterQry ORDER BY nombre_usuario ASC, no_laboratorio ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_conexion'];

			$returnValue_2[$x] = $qryData['nombre_usuario'];

			$returnValue_3[$x] = $qryData['no_laboratorio'];

			$returnValue_4[$x] = $qryData['nombre_laboratorio'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '</response>';

		break;

	case 'showLog':

		actionRestriction_0();

		$limit = clean($_POST['querylimit']);



		$qry = "SELECT id_log,fecha,hora,log,query,$tbl_usuario.nombre_usuario FROM $tbl_log INNER JOIN $tbl_usuario ON $tbl_log.id_usuario = $tbl_usuario.id_usuario ORDER BY fecha DESC,hora DESC LIMIT 0,$limit";



		$logId = array();

		$logDate = array();

		$logHour = array();

		$logUser = array();

		$logAction = array();

		$logQuery = array();



		$data = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$x = 0;



		while ($reg = mysql_fetch_array($data)) {

			mysqlException(mysql_error(), $header . "_02");

			$logId[$x] = $reg['id_log'];

			$logDate[$x] = $reg['fecha'];

			$logHour[$x] = $reg['hora'];

			$logUser[$x] = $reg['nombre_usuario'];

			$logAction[$x] = $reg['log'];

			$logQuery[$x] = clean($reg['query']);



			$x++;

		}



		echo '<response code="1">';

		echo '<logid>' . implode("|", $logId) . '</logid>';

		echo '<logdate>' . implode("|", $logDate) . '</logdate>';

		echo '<loghour>' . implode("|", $logHour) . '</loghour>';

		echo '<loguser>' . implode("|", $logUser) . '</loguser>';

		echo '<logaction>' . implode("|", $logAction) . '</logaction>';

		echo '<logquery>' . implode("|", $logQuery) . '</logquery>';

		echo '</response>';

		break;

	case 'showLogEnrolamiento':

		actionRestriction_100();



		$laboratorioid = clean($_POST['laboratorioid']);

		$programaid = clean($_POST['programaid']);

		$fechainicial = clean($_POST['fechainicial']);

		$fechafinal = clean($_POST['fechafinal']);



		// Trae los primero 50 que encuentre

		$qry = "SELECT 

				laboratorio.no_laboratorio,

				programa.nombre_programa,

				fecha,

				nombre_usuario,

				titulo,

				resumen 

			FROM log_configuracion_analito 

				JOIN laboratorio ON laboratorio.id_laboratorio = log_configuracion_analito.id_laboratorio

				join programa on programa.id_programa = log_configuracion_analito.id_programa

			WHERE 

				laboratorio.id_laboratorio = '" . $laboratorioid . "'

				AND programa.id_programa = '" . $programaid . "'

				and fecha between '" . $fechainicial . "' and DATE_ADD(DATE_ADD(DATE_ADD('" . $fechafinal . "', INTERVAL 23 HOUR), INTERVAL 59 MINUTE), INTERVAL 59 SECOND)

			ORDER BY fecha DESC";



		$no_laboratorio = array();

		$nombre_programa = array();

		$fecha = array();

		$nombre_usuario = array();

		$titulo = array();

		$resumen = array();



		$data = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$x = 0;



		while ($reg = mysql_fetch_array($data)) {

			mysqlException(mysql_error(), $header . "_02");

			$no_laboratorio[$x] = $reg['no_laboratorio'];

			$nombre_programa[$x] = $reg['nombre_programa'];

			$fecha[$x] = $reg['fecha'];

			$nombre_usuario[$x] = $reg['nombre_usuario'];

			$titulo[$x] = $reg['titulo'];

			$resumen[$x] = clean($reg['resumen']);

			$x++;

		}



		echo '<response code="1">';

		echo '<no_laboratorio>' . implode("|", $no_laboratorio) . '</no_laboratorio>';

		echo '<nombre_programa>' . implode("|", $nombre_programa) . '</nombre_programa>';

		echo '<fecha>' . implode("|", $fecha) . '</fecha>';

		echo '<nombre_usuario>' . implode("|", $nombre_usuario) . '</nombre_usuario>';

		echo '<titulo>' . implode("|", $titulo) . '</titulo>';

		echo '<resumen>' . implode("|", $resumen) . '</resumen>';

		echo '</response>';

		break;

	case 'showDis':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_distribuidor,nombre_distribuidor FROM $tbl_distribuidor $filterQry ORDER BY nombre_distribuidor ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_distribuidor'];

			$returnValue_2[$x] = $qryData['nombre_distribuidor'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

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

			$qry = "SELECT * FROM $tbl_configuracion_laboratorio_analito WHERE id_laboratorio = " . $filterArray[2] . " AND id_programa = " . $filterArray[1] . " AND activo = 1";

			$filterQryArray = mysql_query($qry);

			$filterQry = array();

			$x = 0;

			while ($filterQryData = mysql_fetch_array($filterQryArray)) {
				$filterQry[$x] = "WHERE $tbl_programa.id_programa = " . $filterArray[1] . " AND $tbl_configuracion_laboratorio_analito.id_analito = " . $filterQryData['id_analito'] . " AND $tbl_configuracion_laboratorio_analito.id_analizador = " . $filterQryData['id_analizador'] . " AND $tbl_configuracion_laboratorio_analito.id_metodologia = " . $filterQryData['id_metodologia'] . " AND $tbl_configuracion_laboratorio_analito.id_reactivo = " . $filterQryData['id_reactivo'] . " AND $tbl_configuracion_laboratorio_analito.id_unidad = " . $filterQryData['id_unidad'] . " AND $tbl_configuracion_laboratorio_analito.id_gen_vitros = " . $filterQryData['id_gen_vitros'];
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
				$qry = "SELECT $tbl_configuracion_laboratorio_analito.id_configuracion,nombre_programa,nombre_analito,nombre_analizador,nombre_metodologia,nombre_reactivo,nombre_unidad,$tbl_analito.id_analito,valor_gen_vitros FROM $tbl_configuracion_laboratorio_analito INNER JOIN $tbl_programa ON $tbl_configuracion_laboratorio_analito.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros " . $filterQry[$x] . " ORDER BY nombre_programa ASC, nombre_analizador ASC, nombre_analito ASC LIMIT $min,$max";

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

					// NIVEL 1
					$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,n_evaluacion,nivel FROM $tbl_media_evaluacion_caso_especial WHERE id_configuracion = " . $returnValue_1[$x] . " AND nivel = " . $lvl[0] . " AND id_muestra = " . $filterArray[0] . " AND id_laboratorio = " . $filterArray[2];

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

					// NIVEL 2
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

					// NIVEL 3
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

					// NIVEL 0 (Cualitativo)
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

		} else {

			$filterQry = "WHERE $tbl_programa.id_programa = " . $filterArray[1];

			$qry = "SELECT $tbl_configuracion_laboratorio_analito.id_configuracion,nombre_programa,nombre_analito,nombre_analizador,nombre_metodologia,nombre_reactivo,nombre_unidad,$tbl_analito.id_analito,valor_gen_vitros FROM $tbl_configuracion_laboratorio_analito INNER JOIN $tbl_programa ON $tbl_configuracion_laboratorio_analito.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros " . $filterQry . " ORDER BY nombre_programa ASC, nombre_analizador ASC, nombre_analito ASC LIMIT $min,$max";

			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(), $header . "_01");

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

			$x = 0;

			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_configuracion'];
				$returnValue_2[$x] = $qryData['nombre_programa'];
				$returnValue_3[$x] = $qryData['nombre_analito'];
				$returnValue_4[$x] = $qryData['nombre_analizador'];
				$returnValue_5[$x] = $qryData['nombre_metodologia'];
				$returnValue_6[$x] = $qryData['nombre_reactivo'];
				$returnValue_7[$x] = $qryData['nombre_unidad'];
				$returnValue_10[$x] = $qryData['valor_gen_vitros'];

				$x++;
			}

			$lvl = array(1, 2, 3, 0);

			$level0Counter = 0;
			$level1Counter = 0;
			$level2Counter = 0;
			$level3Counter = 0;

			for ($x = 0; $x < sizeof($returnValue_1); $x++) {

				// NIVEL 1
				$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,n_evaluacion,nivel FROM $tbl_media_evaluacion_caso_especial WHERE id_configuracion = " . $returnValue_1[$x] . " AND nivel = " . $lvl[0] . " AND id_muestra = " . $filterArray[0];

				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(), $header . "_02_" . $x);

				$qryData = mysql_fetch_array($qryArray);

				if (!empty($qryData)) {
					$returnValue_9['level1'][$level1Counter] = $qryData['percentil_25'];
					$returnValue_9['level1'][$level1Counter + 1] = $qryData['media_estandar'];
					$returnValue_9['level1'][$level1Counter + 2] = $qryData['percentil_75'];
					$returnValue_9['level1'][$level1Counter + 3] = $qryData['desviacion_estandar'];
					$returnValue_9['level1'][$level1Counter + 4] = $qryData['coeficiente_variacion'];
					$returnValue_9['level1'][$level1Counter + 5] = $qryData['n_evaluacion'];

				} else {
					$returnValue_9['level1'][$level1Counter] = 0;
					$returnValue_9['level1'][$level1Counter + 1] = 0;
					$returnValue_9['level1'][$level1Counter + 2] = 0;
					$returnValue_9['level1'][$level1Counter + 3] = 0;
					$returnValue_9['level1'][$level1Counter + 4] = 0;
					$returnValue_9['level1'][$level1Counter + 5] = 0;
				}

				$level1Counter = ($level1Counter + 6);

				// NIVEL 2
				$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,n_evaluacion,nivel FROM $tbl_media_evaluacion_caso_especial WHERE id_configuracion = " . $returnValue_1[$x] . " AND nivel = " . $lvl[1] . " AND id_muestra = " . $filterArray[0];

				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(), $header . "_03_" . $x);

				$qryData = mysql_fetch_array($qryArray);

				if (!empty($qryData)) {
					$returnValue_9['level2'][$level2Counter] = $qryData['percentil_25'];
					$returnValue_9['level2'][$level2Counter + 1] = $qryData['media_estandar'];
					$returnValue_9['level2'][$level2Counter + 2] = $qryData['percentil_75'];
					$returnValue_9['level2'][$level2Counter + 3] = $qryData['desviacion_estandar'];
					$returnValue_9['level2'][$level2Counter + 4] = $qryData['coeficiente_variacion'];
					$returnValue_9['level2'][$level2Counter + 5] = $qryData['n_evaluacion'];

				} else {
					$returnValue_9['level2'][$level2Counter] = 0;
					$returnValue_9['level2'][$level2Counter + 1] = 0;
					$returnValue_9['level2'][$level2Counter + 2] = 0;
					$returnValue_9['level2'][$level2Counter + 3] = 0;
					$returnValue_9['level2'][$level2Counter + 4] = 0;
					$returnValue_9['level2'][$level2Counter + 5] = 0;
				}

				$level2Counter = ($level2Counter + 6);

				// NIVEL 3
				$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,n_evaluacion,nivel FROM $tbl_media_evaluacion_caso_especial WHERE id_configuracion = " . $returnValue_1[$x] . " AND nivel = " . $lvl[2] . " AND id_muestra = " . $filterArray[0];

				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(), $header . "_04_" . $x);

				$qryData = mysql_fetch_array($qryArray);

				if (!empty($qryData)) {
					$returnValue_9['level3'][$level3Counter] = $qryData['percentil_25'];
					$returnValue_9['level3'][$level3Counter + 1] = $qryData['media_estandar'];
					$returnValue_9['level3'][$level3Counter + 2] = $qryData['percentil_75'];
					$returnValue_9['level3'][$level3Counter + 3] = $qryData['desviacion_estandar'];
					$returnValue_9['level3'][$level3Counter + 4] = $qryData['coeficiente_variacion'];
					$returnValue_9['level3'][$level3Counter + 5] = $qryData['n_evaluacion'];

				} else {
					$returnValue_9['level3'][$level3Counter] = 0;
					$returnValue_9['level3'][$level3Counter + 1] = 0;
					$returnValue_9['level3'][$level3Counter + 2] = 0;
					$returnValue_9['level3'][$level3Counter + 3] = 0;
					$returnValue_9['level3'][$level3Counter + 4] = 0;
					$returnValue_9['level3'][$level3Counter + 5] = 0;
				}

				$level3Counter = ($level3Counter + 6);

				// NIVEL 0 (Cualitativo)
				$qry = "SELECT $tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $tbl_media_evaluacion_caso_especial INNER JOIN $tbl_analito_resultado_reporte_cualitativo ON $tbl_media_evaluacion_caso_especial.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = " . $returnValue_1[$x] . " AND id_muestra = " . $filterArray[0];

				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(), $header . "_04_" . $x);

				$qryData = mysql_fetch_array($qryArray);

				if (!empty($qryData)) {
					$returnValue_9['level0'][$level0Counter] = $qryData['desc_resultado_reporte_cualitativo'];

				} else {
					$returnValue_9['level0'][$level0Counter] = "N/A";
				}

				$level0Counter++;

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
	case 'showAssignedAnalitLimit':



		switch ($filterid) {

			case 'id_array':



				$filterArray = explode("|", $filter);



				for ($x = 0; $x < sizeof($filterArray); $x++) {

					if ($filterArray[$x] == "") {

						$filterArray[$x] = "NULL";

					}

				}



				$filterQry = "WHERE $tbl_programa_analito.id_programa = $filterArray[0]";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT $tbl_analito.id_analito,nombre_analito,nombre_programa FROM $tbl_analito INNER JOIN $tbl_programa_analito ON $tbl_analito.id_analito = $tbl_programa_analito.id_analito INNER JOIN $tbl_programa ON $tbl_programa_analito.id_programa = $tbl_programa.id_programa $filterQry ORDER BY nombre_analito ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_analito'];

			$returnValue_2[$x] = $qryData['nombre_analito'];

			$returnValue_3[$x] = $qryData['nombre_programa'];



			$qry = "SELECT limite,id_calculo_limite_evaluacion FROM $tbl_limite_evaluacion WHERE id_analito = " . $qryData['id_analito'] . " AND id_opcion_limite = $filterArray[1]";



			$innerQryData = mysql_fetch_array(mysql_query($qry));

			mysqlException(mysql_error(), $header . "_02");



			$returnValue_4[$x] = $innerQryData['limite'];

			$returnValue_5[$x] = $innerQryData['id_calculo_limite_evaluacion'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;

	case 'showAssignedProgramRound':



		switch ($filterid) {

			case 'id_programa':

				// $filterQry = "WHERE $tbl_programa.id_programa = $filter GROUP BY $tbl_ronda.no_ronda";

				// Se actualiza group by

				// $filterQry = "WHERE $tbl_programa.id_programa = $filter GROUP BY $tbl_ronda.id_ronda";

				$qry = "SELECT DISTINCT

    			        $tbl_programa.nombre_programa,

    			        $tbl_ronda.no_ronda,

    			        $tbl_ronda.id_ronda,

    			        '1' AS codigo_muestra,

    			        '1' AS no_contador 

			        FROM $tbl_ronda 

			        INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda 

			        INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra 

			        INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra 

			        INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa 

					WHERE $tbl_programa.id_programa = $filter

					ORDER BY $tbl_ronda.no_ronda DESC

					";

				// ".$filterQry." 

				break;

			case 'id_ronda':

				$filterQry = "WHERE $tbl_ronda.id_ronda = " . $filter;

				$qry = "SELECT 

    			        $tbl_programa.nombre_programa,

    			        $tbl_ronda.no_ronda,

    			        $tbl_ronda.id_ronda,

    			        $tbl_muestra.codigo_muestra,

    			        $tbl_contador_muestra.no_contador 

			        FROM $tbl_ronda 

			        INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda 

			        INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra 

			        INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra 

			        INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa 

			        " . $filterQry . " 

			        ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";

				break;

			case 'no_id':

				// $filterQry = "GROUP BY $tbl_ronda.no_ronda";

				// Se actualizo el group by

				// $filterQry = "GROUP BY $tbl_ronda.id_ronda, $tbl_muestra.id_muestra, $tbl_contador_muestra.id_conexion";

				$qry = "SELECT DISTINCT

    			        $tbl_programa.nombre_programa,

    			        $tbl_ronda.no_ronda,

    			        $tbl_ronda.id_ronda,

    			        $tbl_muestra.codigo_muestra,

    			        $tbl_contador_muestra.no_contador 

			        FROM $tbl_ronda 

			        INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda 

			        INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra 

			        INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra 

			        INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa 

			        ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";

				// ".$filterQry." 

				break;

			default:

				$filterQry = '';

				$qry = "SELECT 

    			        $tbl_programa.nombre_programa,

    			        $tbl_ronda.no_ronda,

    			        $tbl_ronda.id_ronda,

    			        $tbl_muestra.codigo_muestra,

    			        $tbl_contador_muestra.no_contador 

			        FROM $tbl_ronda 

			        INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda 

			        INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra 

			        INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra 

			        INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa 

			        " . $filterQry . " 

			        ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";

				break;

		}



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_ronda'];

			$returnValue_2[$x] = $qryData['no_ronda'];

			$returnValue_3[$x] = $qryData['no_contador'];

			$returnValue_4[$x] = $qryData['codigo_muestra'];

			$returnValue_5[$x] = $qryData['nombre_programa'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;

	case 'showAssignedLabRound':



		switch ($filterid) {

			case 'id_laboratorio':

				// $filterQry = "WHERE $tbl_laboratorio.id_laboratorio = ".$filter." GROUP BY $tbl_programa.nombre_programa, $tbl_ronda.no_ronda";

				// Se actualiza el group  by

				$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = " . $filter . " GROUP BY programa.nombre_programa, ronda.no_ronda, ronda_laboratorio.id_ronda_laboratorio, laboratorio.no_laboratorio,laboratorio.nombre_laboratorio";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

			            $tbl_laboratorio.no_laboratorio,

			            $tbl_laboratorio.nombre_laboratorio,

			            $tbl_programa.nombre_programa,

			            $tbl_ronda.no_ronda,

			            $tbl_ronda_laboratorio.id_ronda_laboratorio 

			        FROM $tbl_laboratorio INNER JOIN $tbl_ronda_laboratorio ON $tbl_laboratorio.id_laboratorio = $tbl_ronda_laboratorio.id_laboratorio 

			        INNER JOIN $tbl_ronda ON $tbl_ronda_laboratorio.id_ronda = $tbl_ronda.id_ronda 

			        INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda 

			        INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra 

			        INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra 

			        INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa " . $filterQry . " 

			        ORDER BY $tbl_programa.nombre_programa ASC, $tbl_laboratorio.nombre_laboratorio ASC, $tbl_ronda.no_ronda ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_ronda_laboratorio'];

			$returnValue_2[$x] = $qryData['no_laboratorio'];

			$returnValue_3[$x] = $qryData['nombre_laboratorio'];

			$returnValue_4[$x] = $qryData['nombre_programa'];

			$returnValue_5[$x] = $qryData['no_ronda'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6>' . implode("|", $returnValue_5) . '</returnvalues6>';

		echo '</response>';

		break;

	case 'showAssignedLabRoundSimple':



		$filterArray = explode("|", $filter);



		for ($x = 0; $x < sizeof($filterArray); $x++) {

			if ($filterArray[$x] == "") {

				$filterArray[$x] = "NULL";

			}

		}



		switch ($filterid) {

			case 'id_laboratorio':

				// $filterQry = "WHERE $tbl_ronda_laboratorio.id_laboratorio = $filterArray[1] AND $tbl_ronda.id_programa = $filterArray[0] GROUP BY $tbl_ronda.no_ronda";

				// Se actualiza el group  by

				$filterQry = "WHERE $tbl_ronda_laboratorio.id_laboratorio = $filterArray[1] AND $tbl_ronda.id_programa = $filterArray[0]";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT $tbl_ronda.no_ronda,$tbl_ronda.id_ronda 

					FROM $tbl_ronda 

						INNER JOIN $tbl_ronda_laboratorio ON $tbl_ronda.id_ronda = $tbl_ronda_laboratorio.id_ronda 

						INNER JOIN $tbl_programa ON $tbl_ronda.id_programa = $tbl_programa.id_programa 

						INNER JOIN $tbl_muestra_programa ON $tbl_programa.id_programa = $tbl_muestra_programa.id_programa 

					$filterQry 

					ORDER BY $tbl_ronda.no_ronda DESC";



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



		$qry = "SELECT $tbl_muestra.id_muestra,$tbl_muestra.codigo_muestra,$tbl_contador_muestra.no_contador FROM $tbl_ronda INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa $filterQry ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";

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

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';



		break;



	case 'showAssignedLabAnalitWithResult':



		$filterArray = explode("|", $filter);



		for ($x = 0; $x < sizeof($filterArray); $x++) {

			if ($filterArray[$x] == "") {

				$filterArray[$x] = "NULL";

			}

		}



		switch ($filterid) {

			case 'id_array':

				$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_laboratorio = $filterArray[0] AND $tbl_configuracion_laboratorio_analito.id_programa = $filterArray[1] AND activo = 1";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT

						$tbl_configuracion_laboratorio_analito.id_configuracion,

						nombre_analito,

						nombre_analizador,

						nombre_metodologia,

						nombre_reactivo,

						nombre_unidad,

						valor_gen_vitros 

					FROM $tbl_configuracion_laboratorio_analito 

					INNER JOIN $tbl_laboratorio ON $tbl_configuracion_laboratorio_analito.id_laboratorio = $tbl_laboratorio.id_laboratorio 

					INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito 

					INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador 

					INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia 

					INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo 

					INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad 

					LEFT JOIN $tbl_resultado ON $tbl_configuracion_laboratorio_analito.id_configuracion = $tbl_resultado.id_configuracion 

					INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros $filterQry 

					ORDER BY nombre_analito ASC";



		// Se elimina el group by

		// GROUP BY $tbl_configuracion_laboratorio_analito.id_configuracion 



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();

		$returnValue_7 = array();

		$returnValue_8 = array();

		$returnValue_9 = array();

		$returnValue_10 = array();

		$returnValue_11 = array();

		$returnValue_12 = array();

		$returnValue_13 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_13[$x] = $qryData['id_configuracion'];

			$returnValue_2[$x] = $qryData['nombre_analito'];

			$returnValue_3[$x] = $qryData['nombre_analizador'];

			$returnValue_4[$x] = $qryData['nombre_metodologia'];

			$returnValue_5[$x] = $qryData['nombre_reactivo'];

			$returnValue_6[$x] = $qryData['nombre_unidad'];

			$returnValue_11[$x] = $qryData['valor_gen_vitros'];



			$x++;

		}



		for ($x = 0; $x < sizeof($returnValue_13); $x++) {



			$qry = "SELECT id_resultado,valor_resultado,observacion_resultado,nombre_usuario,fecha_resultado,revalorado FROM $tbl_resultado INNER JOIN $tbl_usuario ON $tbl_resultado.id_usuario = $tbl_usuario.id_usuario WHERE id_configuracion = $returnValue_13[$x] AND id_muestra = $filterArray[2]";



			$qryData = mysql_fetch_array(mysql_query($qry));

			mysqlException(mysql_error(), $header . "_01_" . $x);

			$returnValue_1[$x] = $qryData['id_resultado'];

			$returnValue_7[$x] = $qryData['valor_resultado'];

			$returnValue_8[$x] = $qryData['observacion_resultado'];

			$returnValue_9[$x] = $qryData['nombre_usuario'];

			$returnValue_10[$x] = $qryData['fecha_resultado'];

			$returnValue_12[$x] = $qryData['revalorado'];



		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6>' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '<returnvalues7>' . implode("|", $returnValue_7) . '</returnvalues7>';

		echo '<returnvalues8>' . implode("|", $returnValue_8) . '</returnvalues8>';

		echo '<returnvalues9>' . implode("|", $returnValue_9) . '</returnvalues9>';

		echo '<returnvalues10>' . implode("|", $returnValue_10) . '</returnvalues10>';

		echo '<returnvalues11>' . implode("|", $returnValue_11) . '</returnvalues11>';

		echo '<returnvalues12>' . implode("|", $returnValue_12) . '</returnvalues12>';

		echo '<returnvalues13>' . implode("|", $returnValue_13) . '</returnvalues13>';

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



				$filterQry = "WHERE $tbl_valor_metodo_referencia.id_muestra = $filterArray[1]";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_valor_metodo_referencia,$tbl_programa.nombre_programa,$tbl_analito.nombre_analito,$tbl_metodologia.nombre_metodologia,$tbl_unidad.nombre_unidad,$tbl_muestra.codigo_muestra,valor_metodo_referencia FROM $tbl_valor_metodo_referencia INNER JOIN $tbl_analito ON $tbl_valor_metodo_referencia.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_metodologia ON $tbl_valor_metodo_referencia.id_metodologia = $tbl_metodologia.id_metodologia INNER JOIN $tbl_unidad ON $tbl_valor_metodo_referencia.id_unidad = $tbl_unidad.id_unidad INNER JOIN $tbl_muestra ON $tbl_valor_metodo_referencia.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa $filterQry ORDER BY $tbl_programa.nombre_programa ASC, $tbl_muestra.codigo_muestra ASC, $tbl_analito.nombre_analito ASC";



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



	case "showReferenciaPAT":

		switch ($filterid) {

			case 'id_caso_clinico':

				$filterQry = "WHERE caso_clinico.id_caso_clinico = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						referencia.id_referencia as 'id_referencia',

						referencia.descripcion as 'descripcion',

						referencia.estado as 'estado',

						caso_clinico.codigo as 'codigo_caso_clinico'

					FROM referencia

						join caso_clinico on caso_clinico.id_caso_clinico = referencia.caso_clinico_id_caso_clinico

					$filterQry

			";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_04579");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_referencia'];

			$returnValue_2[$x] = $qryData['descripcion'];

			$returnValue_3[$x] = $qryData['estado'];

			$returnValue_4[$x] = $qryData['codigo_caso_clinico'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '</response>';



		break;

	case "showImagen":



		switch ($filterid) {

			case 'id_caso_clinico_pat':

				$filterQry = "WHERE caso_clinico.id_caso_clinico = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						imagen_adjunta.id_imagen_adjunta as 'id_imagen_adjunta', 

						imagen_adjunta.caso_clinico_id_caso_clinico as 'caso_clinico_id_caso_clinico', 

						imagen_adjunta.tipo as 'tipo', 

						imagen_adjunta.ruta as 'ruta', 

						imagen_adjunta.nombre as 'nombre', 

						imagen_adjunta.estado as 'estado',

						caso_clinico.codigo as 'codigo_caso_clinico'

					FROM imagen_adjunta

						join caso_clinico on caso_clinico.id_caso_clinico = imagen_adjunta.caso_clinico_id_caso_clinico

					$filterQry

			";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_04579");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();

		$returnValue_7 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_imagen_adjunta'];

			$returnValue_2[$x] = $qryData['caso_clinico_id_caso_clinico'];

			$returnValue_3[$x] = $qryData['tipo'];

			$returnValue_4[$x] = $qryData['ruta'];

			$returnValue_5[$x] = $qryData['nombre'];

			$returnValue_6[$x] = $qryData['estado'];

			$returnValue_7[$x] = $qryData['codigo_caso_clinico'];

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



	case "showGrupo":



		switch ($filterid) {

			case 'id_caso_clinico_pat':

				$filterQry = "WHERE caso_clinico.id_caso_clinico = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						grupo.id_grupo as 'id_grupo',

						grupo.nombre as 'nombre_grupo',

						caso_clinico.codigo as 'codigo_caso_clinico'

					FROM grupo

						join caso_clinico on caso_clinico.id_caso_clinico = grupo.caso_clinico_id_caso_clinico

					$filterQry

			";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_0457902");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_grupo'];

			$returnValue_2[$x] = $qryData['nombre_grupo'];

			$returnValue_3[$x] = $qryData['codigo_caso_clinico'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '</response>';



		break;





	case "showPregunta":

		switch ($filterid) {

			case 'id_grupo':

				$filterQry = "WHERE grupo.id_grupo = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						pregunta.id_pregunta as 'id_pregunta',

						pregunta.nombre as 'nombre_pregunta',

						coalesce(pregunta.intervalo_min, ' - - ') as 'intervalo_min',

						coalesce(pregunta.intervalo_max, ' - - ') as 'intervalo_max',

						grupo.nombre as 'nombre_grupo',

						caso_clinico.codigo as 'codigo_caso_clinico'

					FROM pregunta

						join grupo on grupo.id_grupo = pregunta.grupo_id_grupo

						join caso_clinico on caso_clinico.id_caso_clinico = grupo.caso_clinico_id_caso_clinico

					$filterQry";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_045790345");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_pregunta'];

			$returnValue_2[$x] = $qryData['nombre_pregunta'];

			$returnValue_3[$x] = $qryData['intervalo_min'];

			$returnValue_4[$x] = $qryData['intervalo_max'];

			$returnValue_5[$x] = $qryData['nombre_grupo'];

			$returnValue_6[$x] = $qryData['codigo_caso_clinico'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4 selectomit="1">' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6 selectomit="1">' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '</response>';



		break;



	case "showDistractor":

		switch ($filterid) {

			case 'id_pregunta':

				$filterQry = "WHERE pregunta.id_pregunta = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT 

						distractor.id_distractor as 'id_distractor',

						coalesce(distractor.abreviatura, ' - - ') as 'abreviatura',

						distractor.nombre as 'nombre_distractor',

						distractor.valor as 'valor_distractor',

						distractor.estado as 'estado_distractor',

						pregunta.nombre as 'nombre_pregunta'

					FROM distractor

						join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta

					$filterQry";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_04579034543");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();

		$returnValue_6 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_distractor'];

			$returnValue_2[$x] = $qryData['abreviatura'];

			$returnValue_3[$x] = $qryData['nombre_distractor'];

			$returnValue_4[$x] = $qryData['valor_distractor'];

			$returnValue_5[$x] = $qryData['estado_distractor'];

			$returnValue_6[$x] = $qryData['nombre_pregunta'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '<returnvalues6>' . implode("|", $returnValue_6) . '</returnvalues6>';

		echo '</response>';

		break;



	case 'showAssignedAnalitLimitType':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_calculo_limite_evaluacion,desc_calculo_limite_evaluacion FROM $tbl_calculo_limite_evaluacion ORDER BY desc_calculo_limite_evaluacion ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_calculo_limite_evaluacion'];

			$returnValue_2[$x] = $qryData['desc_calculo_limite_evaluacion'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showJctlmMethod':



		switch ($filterid) {

			case 'id_programa':

				$filterQry = "WHERE $tbl_programa_analito.id_programa = $filter";

				break;

			case 'id_analito':

				$filterQry = "WHERE $tbl_programa_analito.id_analito = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_metodo_jctlm,$tbl_programa.nombre_programa,$tbl_analito.nombre_analito,desc_metodo_jctlm,activo 

					FROM $tbl_metodo_jctlm 

						INNER JOIN $tbl_programa_analito ON $tbl_metodo_jctlm.id_analito = $tbl_programa_analito.id_analito 

						INNER JOIN $tbl_analito ON $tbl_programa_analito.id_analito = $tbl_analito.id_analito 

						INNER JOIN $tbl_programa ON $tbl_programa_analito.id_programa = $tbl_programa.id_programa $filterQry 

					ORDER BY $tbl_programa.nombre_programa ASC, $tbl_analito.nombre_analito ASC, activo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_metodo_jctlm'];

			$returnValue_2[$x] = $qryData['nombre_programa'];

			$returnValue_3[$x] = $qryData['nombre_analito'];

			$returnValue_4[$x] = $qryData['desc_metodo_jctlm'];

			$returnValue_5[$x] = $qryData['activo'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;

	case 'showJctlmMaterial':



		switch ($filterid) {

			case 'id_programa':

				$filterQry = "WHERE $tbl_programa_analito.id_programa = $filter";

				break;

			case 'id_analito':

				$filterQry = "WHERE $tbl_programa_analito.id_analito = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_material_jctlm,$tbl_programa.nombre_programa,$tbl_analito.nombre_analito,desc_material_jctlm,activo FROM $tbl_material_jctlm INNER JOIN $tbl_programa_analito ON $tbl_material_jctlm.id_analito = $tbl_programa_analito.id_analito INNER JOIN $tbl_analito ON $tbl_programa_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_programa ON $tbl_programa_analito.id_programa = $tbl_programa.id_programa $filterQry ORDER BY $tbl_programa.nombre_programa ASC, $tbl_analito.nombre_analito ASC, activo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_material_jctlm'];

			$returnValue_2[$x] = $qryData['nombre_programa'];

			$returnValue_3[$x] = $qryData['nombre_analito'];

			$returnValue_4[$x] = $qryData['desc_material_jctlm'];

			$returnValue_5[$x] = $qryData['activo'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2 selectomit="1">' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 selectomit="1">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5 selectomit="1">' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;

	case 'showMaterial':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_material,nombre_material FROM $tbl_material ORDER BY nombre_material ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_material'];

			$returnValue_2[$x] = $qryData['nombre_material'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showInUseMethods':



		switch ($filterid) {

			case 'id_analito':

				$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_analito = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT id_metodologia, nombre_metodologia 

					FROM $tbl_metodologia WHERE id_metodologia IN 

					(SELECT id_metodologia FROM $tbl_configuracion_laboratorio_analito $filterQry)";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_metodologia'];

			$returnValue_2[$x] = $qryData['nombre_metodologia'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showInUseMaterials':



		switch ($filterid) {

			case 'id_analito':

				$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_analito = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT id_material, nombre_material FROM $tbl_material WHERE id_material IN (SELECT id_material FROM $tbl_configuracion_laboratorio_analito $filterQry)";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_material'];

			$returnValue_2[$x] = $qryData['nombre_material'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '</response>';

		break;

	case 'showPairedJctlmMethods':



		switch ($filterid) {

			case 'id_analito':

				$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_analito = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT id_conexion,$tbl_metodologia.nombre_metodologia,$tbl_metodo_jctlm.desc_metodo_jctlm,$tbl_analito.nombre_analito 

					FROM $tbl_metodo_jctlm_emparejado

						INNER JOIN $tbl_metodologia ON $tbl_metodo_jctlm_emparejado.id_metodologia = $tbl_metodologia.id_metodologia 

						INNER JOIN $tbl_metodo_jctlm ON $tbl_metodo_jctlm_emparejado.id_metodo_jctlm = $tbl_metodo_jctlm.id_metodo_jctlm 

						INNER JOIN $tbl_analito ON $tbl_metodo_jctlm.id_analito = $tbl_analito.id_analito 

						WHERE $tbl_metodologia.id_metodologia IN (SELECT id_metodologia FROM $tbl_configuracion_laboratorio_analito $filterQry)";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_conexion'];

			$returnValue_2[$x] = $qryData['nombre_metodologia'];

			$returnValue_3[$x] = $qryData['desc_metodo_jctlm'];

			$returnValue_4[$x] = $qryData['nombre_analito'];

			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '</response>';

		break;

	case 'showPairedJctlmMaterials':



		switch ($filterid) {

			case 'id_analito':

				$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_analito = $filter";

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT id_conexion,$tbl_material.nombre_material,$tbl_material_jctlm.desc_material_jctlm,$tbl_analito.nombre_analito FROM $tbl_material_jctlm_emparejado INNER JOIN $tbl_material ON $tbl_material_jctlm_emparejado.id_material = $tbl_material.id_material INNER JOIN $tbl_material_jctlm ON $tbl_material_jctlm_emparejado.id_material_jctlm = $tbl_material_jctlm.id_material_jctlm INNER JOIN $tbl_analito ON $tbl_material_jctlm.id_analito = $tbl_analito.id_analito WHERE $tbl_material.id_material IN (SELECT id_material FROM $tbl_configuracion_laboratorio_analito $filterQry)";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_conexion'];

			$returnValue_2[$x] = $qryData['nombre_material'];

			$returnValue_3[$x] = $qryData['desc_material_jctlm'];

			$returnValue_4[$x] = $qryData['nombre_analito'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '</response>';

		break;

	case 'showProgramTypes':



		switch ($filterid) {

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_tipo_programa,desc_tipo_programa FROM $tbl_tipo_programa ORDER BY id_tipo_programa ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_tipo_programa'];

			$returnValue_2[$x] = $qryData['desc_tipo_programa'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

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

	case 'showAnalitCualitativeTypeOfResult':

	case 'showAnalitCualitativeTypeOfResult2':



		switch ($filterid) {

			case 'id_analito':

				$filterQry = "WHERE $tbl_analito.id_analito = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_analito_resultado_reporte_cualitativo,desc_resultado_reporte_cualitativo,$tbl_analito.nombre_analito, $tbl_puntuaciones.valor FROM $tbl_analito_resultado_reporte_cualitativo 
			INNER JOIN $tbl_analito ON $tbl_analito_resultado_reporte_cualitativo.id_analito = $tbl_analito.id_analito 
			INNER JOIN $tbl_puntuaciones ON $tbl_puntuaciones.id = $tbl_analito_resultado_reporte_cualitativo.id_puntuacion
			$filterQry ORDER BY nombre_analito ASC, desc_resultado_reporte_cualitativo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();




		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_analito_resultado_reporte_cualitativo'];

			$returnValue_2[$x] = $qryData['nombre_analito'];

			$returnValue_3[$x] = $qryData['desc_resultado_reporte_cualitativo'];

			$returnValue_4[$x] = $qryData['valor'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '</response>';

		break;

	case 'showAnalitConfiguredCualitativeTypeOfResult':



		switch ($filterid) {

			case 'id_configuracion':

				$filterQry = "WHERE $tbl_configuracion_analito_resultado_reporte_cualitativo.id_configuracion = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT id_analito FROM $tbl_configuracion_laboratorio_analito WHERE id_configuracion = $filter LIMIT 0,1";

		$qryData = mysql_fetch_array(mysql_query($qry));



		$analitid = $qryData['id_analito'];



		$qry = "SELECT id_analito_resultado_reporte_cualitativo,desc_resultado_reporte_cualitativo 

					FROM $tbl_analito_resultado_reporte_cualitativo 

					WHERE id_analito_resultado_reporte_cualitativo IN (

						SELECT id_analito_resultado_reporte_cualitativo FROM $tbl_configuracion_analito_resultado_reporte_cualitativo $filterQry

					) 

					ORDER BY desc_resultado_reporte_cualitativo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_1[$x] = $qryData['id_analito_resultado_reporte_cualitativo'];

			$returnValue_2[$x] = $qryData['desc_resultado_reporte_cualitativo'];



			$x++;

		}



		$qry = "SELECT id_analito_resultado_reporte_cualitativo,desc_resultado_reporte_cualitativo FROM $tbl_analito_resultado_reporte_cualitativo WHERE id_analito = $analitid AND  id_analito_resultado_reporte_cualitativo NOT IN (SELECT id_analito_resultado_reporte_cualitativo FROM $tbl_configuracion_analito_resultado_reporte_cualitativo $filterQry) ORDER BY desc_resultado_reporte_cualitativo ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_02");



		$returnValue_3 = array();

		$returnValue_4 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {

			$returnValue_3[$x] = $qryData['id_analito_resultado_reporte_cualitativo'];

			$returnValue_4[$x] = $qryData['desc_resultado_reporte_cualitativo'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3 content="id">' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

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

	case 'checkAmmountOfSamplesForRound':



		switch ($filterid) {

			case 'id_array':



				$filterArray = explode("|", mysql_real_escape_string(stripslashes(clean($filter))));



				for ($x = 0; $x < sizeof($filterArray); $x++) {

					if ($filterArray[$x] == "") {

						$filterArray[$x] = "NULL";

					}

				}



				$filterQry = "WHERE id_programa = " . $filterArray[0] . " AND no_ronda = " . $filterArray[1];

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT no_muestras FROM $tbl_programa WHERE id_programa = " . $filterArray[0];

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), $header . "_0x01_");

		$sampleLimit = $qryData['no_muestras'];



		$qry = "SELECT id_ronda FROM $tbl_ronda $filterQry ORDER BY no_ronda DESC LIMIT 0,1";

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), $header . "_0x02_");



		if (mysql_num_rows(mysql_query($qry)) > 0) {

			$tempId = $qryData['id_ronda'];

		} else {

			$tempId = "null";

		}







		$qry = "SELECT no_contador FROM $tbl_contador_muestra WHERE id_ronda = $tempId ORDER BY no_contador DESC LIMIT 0,1";

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), $header . "_0x03_");



		if ($qryData['no_contador'] < $sampleLimit) {

			$response = 1;

		} else {

			$response = 0;

		}



		echo '<response code="1">';

		echo $response;

		echo '</response>';

		break;

	case 'showGlobalUnits':



		switch ($filterid) {

			case 'id_programa':

				$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_programa = " . $filter;

				break;

			default:

				$filterQry = '';

				break;

		}



		$qry = "SELECT DISTINCT $tbl_configuracion_laboratorio_analito.id_analito, $tbl_configuracion_laboratorio_analito.id_unidad, nombre_analito, nombre_unidad FROM $tbl_configuracion_laboratorio_analito INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad $filterQry ORDER BY nombre_analito ASC, nombre_unidad ASC";



		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), $header . "_01");



		$returnValue_1 = array();

		$returnValue_2 = array();

		$returnValue_3 = array();

		$returnValue_4 = array();

		$returnValue_5 = array();



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {



			$qry = "SELECT id_conexion, nombre_unidad_global, factor_conversion FROM $tbl_unidad_global_analito WHERE id_analito = " . $qryData['id_analito'] . " AND id_unidad = " . $qryData['id_unidad'] . " LIMIT 0,1";

			$innerQryArray1 = mysql_query($qry);

			$innerQryData1 = mysql_fetch_array($innerQryArray1);

			$innerQryRows1 = mysql_num_rows($innerQryArray1);

			mysqlException(mysql_error(), $header . "_02");



			if ($innerQryRows1 > 0) {

				$returnValue_1[$x] = $innerQryData1['id_conexion'] . "-" . $qryData['id_analito'] . "-" . $qryData['id_unidad'];

			} else {

				$returnValue_1[$x] = "null" . "-" . $qryData['id_analito'] . "-" . $qryData['id_unidad'];

			}





			$returnValue_2[$x] = $qryData['nombre_analito'];

			$returnValue_3[$x] = $qryData['nombre_unidad'];

			$returnValue_4[$x] = $innerQryData1['nombre_unidad_global'];

			$returnValue_5[$x] = $innerQryData1['factor_conversion'];



			$x++;

		}



		echo '<response code="1">';

		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';

		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';

		echo '<returnvalues3>' . implode("|", $returnValue_3) . '</returnvalues3>';

		echo '<returnvalues4>' . implode("|", $returnValue_4) . '</returnvalues4>';

		echo '<returnvalues5>' . implode("|", $returnValue_5) . '</returnvalues5>';

		echo '</response>';

		break;

	default:

		echo '<response code="0">PHP callsHandler error: id "' . $header . '" not found</response>';

		break;

}



mysql_close($con);

exit;

?>