<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

session_start();

header('Content-Type: text/xml');
echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";

include_once "verifica_sesion.php";

$header = $_POST['header'];

if (!isset($_POST['filter'])) {
	$_POST['filter'] = '';
}

if (!isset($_POST['filterid'])) {
	$_POST['filterid'] = '';
}

$filter = mysql_real_escape_string(stripslashes($_POST['filter']));
$filterid = mysql_real_escape_string(stripslashes($_POST['filterid']));

if ($filter == "") {
	$filter = "NULL";
}
if ($filterid == "") {
	$filterid = "NULL";
}

switch ($header) {
	case 'showClientHqs':

		switch ($filterid) {
			case 'id_cliente':
				$filterQry = "WHERE $tbl_cliente.id = " . encryptControl('decrypt', $filter, $_SESSION['qap_userId']) . " AND $tbl_sede_usuario.id_usuario = '" . $_SESSION['qap_userId'] . "'";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT DISTINCT $tbl_sede.nombre AS 'nombre_sede',$tbl_cliente.nombre AS 'nombre_cliente' FROM $tbl_sede INNER JOIN $tbl_cliente ON $tbl_sede.id_cliente = $tbl_cliente.id INNER JOIN $tbl_sede_usuario ON $tbl_sede.nombre = $tbl_sede_usuario.id_sede $filterQry ORDER BY 'nombre_cliente' ASC, 'nombre_sede' ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_0x01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = encryptControl('encrypt', $qryData['nombre_sede'], $_SESSION['qap_userId']);
			$returnValue_2[$x] = $qryData['nombre_sede'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showClientHqLabNumbers':

		switch ($filterid) {
			case 'id_sede':
				$filterQry = "WHERE $tbl_laboratorio.id_sede = '" . encryptControl('decrypt', $filter, $_SESSION['qap_userId']) . "'";
				break;
			case 'id_reporte':

				$filterArray = explode("|", $filter);

				for ($x = 0; $x < sizeof($filterArray); $x++) {
					if ($filterArray[$x] == "") {
						$filterArray[$x] = "NULL";
					}
				}

				$filterQry = "WHERE $tbl_laboratorio.id_sede = '" . encryptControl('decrypt', $filterArray[0], $_SESSION['qap_userId']) . "' AND $tbl_reporte_laboratorio.id_reporte = '" . $filterArray[1] . "'";

				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT DISTINCT $tbl_laboratorio.id AS 'no_lab' FROM $tbl_sede INNER JOIN $tbl_laboratorio ON $tbl_sede.nombre = $tbl_laboratorio.id_sede INNER JOIN $tbl_reporte_laboratorio ON $tbl_reporte_laboratorio.id_laboratorio = $tbl_laboratorio.id $filterQry ORDER BY 'no_lab' ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_0x01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = encryptControl('encrypt', $qryData['no_lab'], $_SESSION['qap_userId']);
			$returnValue_2[$x] = $qryData['no_lab'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showLabAssignedReports':

		switch ($filterid) {
			case 'id_laboratorio':
				$filterQry = "WHERE id_laboratorio = " . encryptControl('decrypt', $filter, $_SESSION['qap_userId']);
				break;
			case 'id_sede':
				$filterQry = "WHERE id_sede = '" . encryptControl('decrypt', $filter, $_SESSION['qap_userId']) . "'";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT 
			    $tbl_reporte.descripcion,$tbl_reporte.nombre_rep 
			FROM $tbl_reporte_laboratorio 
    			INNER JOIN $tbl_reporte ON $tbl_reporte_laboratorio.id_reporte = $tbl_reporte.nombre_rep 
    			INNER JOIN $tbl_laboratorio ON $tbl_reporte_laboratorio.id_laboratorio = $tbl_laboratorio.id 
    			INNER JOIN $tbl_sede ON $tbl_laboratorio.id_sede = $tbl_sede.nombre $filterQry 
    		GROUP BY $tbl_reporte.descripcion,$tbl_reporte.nombre_rep ORDER BY $tbl_reporte.descripcion ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_0x01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['nombre_rep'];
			$returnValue_2[$x] = $qryData['descripcion'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showExternalReportCicles':

		switch ($filterid) {
			case 'id_reporte_eqas':
				$filterQry = "WHERE $tbl_reporte_eqas.nombre = '$filter'";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT n_ciclo FROM $tbl_ciclo_eqas INNER JOIN $tbl_reporte_eqas ON $tbl_ciclo_eqas.id_eqas = $tbl_reporte_eqas.nombre $filterQry ORDER BY n_ciclo DESC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_0x01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['n_ciclo'];
			$returnValue_2[$x] = $qryData['n_ciclo'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showProgramTypes':

		switch ($filterid) {
			case 'id_tipo_reporte':
				$filterQry = "WHERE tipo_reporte = '$filter'";
				break;
			default:
				$filterQry = '';
				break;
		}

		$qry = "SELECT nombre,descripcion FROM $tbl_reporte_eqas $filterQry ORDER BY nombre ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), $header . "_0x01");

		$returnValue_1 = array();
		$returnValue_2 = array();

		$x = 0;

		while ($qryData = mysql_fetch_array($qryArray)) {
			$returnValue_1[$x] = $qryData['nombre'];
			$returnValue_2[$x] = $qryData['descripcion'];

			$x++;
		}

		echo '<response code="1">';
		echo '<returnvalues1 content="id">' . implode("|", $returnValue_1) . '</returnvalues1>';
		echo '<returnvalues2>' . implode("|", $returnValue_2) . '</returnvalues2>';
		echo '</response>';
		break;
	case 'showDocuments':

		$filterArray = explode("|", $filter);

		for ($x = 0; $x < sizeof($filterArray); $x++) {
			if ($filterArray[$x] == "") {
				$filterArray[$x] = "NULL";
			}
		}

		$filterArray[0] = encryptControl('decrypt', $filterArray[0], $_SESSION['qap_token']);

		$qryLab = "SELECT no_laboratorio FROM laboratorio where id_laboratorio = " . $filterArray[0];
		$qryLabArray = mysql_query($qryLab);
		$qryDataLab = mysql_fetch_array($qryLabArray);
		$no_laboratorio = $qryDataLab['no_laboratorio'];


		$qryUser = "SELECT cod_usuario FROM usuario where id_usuario = " . $_SESSION['qap_userId'];
		$qryUserArray = mysql_query($qryUser);
		$qryDataUser = mysql_fetch_array($qryUserArray);
		$cod_usuario = $qryDataUser['cod_usuario'];

		if (strpos($no_laboratorio, "200") === 0) {
			if ($_SESSION["qap_key"] == 125) { // Si es usuario es un patologo normal no puede ver los documentos que tengan la palabra "Instalaboratorio" o de un usuario distinto
				$filterQry = "WHERE archivo.activo = 1 and archivo.id_laboratorio = '" . mysql_real_escape_string(stripcslashes(clean($filterArray[0]))) . "' AND archivo.id_reto = " . mysql_real_escape_string(stripcslashes(clean($filterArray[1]))) . " AND archivo.nombre_archivo not like '%ntralaboratorio%' AND archivo.nombre_archivo like '%" . $cod_usuario . "%'";
			} else { // Si es un usuario coordinador PUEDE ver todos los reportes activos
				$filterQry = "WHERE archivo.activo = 1 and archivo.id_laboratorio = '" . mysql_real_escape_string(stripcslashes(clean($filterArray[0]))) . "' AND archivo.id_reto = " . mysql_real_escape_string(stripcslashes(clean($filterArray[1])));
			}
		} else if (strpos($no_laboratorio, "100") === 0) {
			$filterQry = "WHERE archivo.activo = 1 and archivo.id_laboratorio = '" . mysql_real_escape_string(stripcslashes(clean($filterArray[0]))) . "' AND id_ronda = " . mysql_real_escape_string(stripcslashes(clean($filterArray[1])));
		}

		$qry = "SELECT
					id_archivo,
					nombre_archivo,
					extencion_archivo,
					index_archivo,
					activo,fecha_carga 
			FROM archivo $filterQry 
			ORDER BY fecha_carga DESC, activo DESC, nombre_archivo ASC";

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

	case "showAssignedLabProgramGeneral":
		$filter = encryptControl('decrypt', $filter, $_SESSION['qap_token']);

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
		$id_laboratorio = encryptControl('decrypt', $filterArray[1], $_SESSION['qap_token']);

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
					programa.nombre_programa,
					ronda.no_ronda,
					ronda.id_ronda,
					'1' AS codigo_muestra,
					'1' AS no_contador 
				FROM laboratorio
				INNER JOIN ronda_laboratorio ON laboratorio.id_laboratorio = ronda_laboratorio.id_laboratorio
				INNER JOIN ronda ON ronda_laboratorio.id_ronda = ronda.id_ronda
				INNER JOIN contador_muestra ON ronda.id_ronda = contador_muestra.id_ronda
				INNER JOIN muestra ON contador_muestra.id_muestra = muestra.id_muestra
				INNER JOIN muestra_programa ON muestra.id_muestra = muestra_programa.id_muestra
				INNER JOIN programa ON muestra_programa.id_programa = programa.id_programa
				WHERE programa.id_programa = $id_programa
				AND laboratorio.id_laboratorio = $id_laboratorio
				ORDER BY
					ronda.no_ronda DESC";

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

	case 'showActiveStatusOptions':

		echo '<response code="1">';
		echo '<returnvalues1 content="id">0|1</returnvalues1>';
		echo '<returnvalues2>No|Si</returnvalues2>';
		echo '</response>';
		break;
	default:
		echo '<response code="0">PHP callshandler error: id "' . $header . '" not found</response>';
		break;
}

mysql_close($con);
exit;
?>