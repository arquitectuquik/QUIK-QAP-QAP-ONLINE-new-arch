<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	session_start();
	include_once"verifica_sesion.php";
	
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
	
	switch($header) {
		case 'showSampleSimple':

			switch ($filterid) {
				case 'id_programa':
					$filterQry = "WHERE $tbl_muestra_programa.id_programa = ".$filter;
				break;
				case 'fecha':
					$filterQry = "WHERE $tbl_muestra_programa.id_programa = $filter AND DATE('$logDate') <= $tbl_muestra_programa.fecha_vencimiento";
				break;					
				default:
					$filterQry = '';
				break;
			}
				
			$qry = "SELECT $tbl_muestra.id_muestra,$tbl_muestra.codigo_muestra,$tbl_muestra_programa.fecha_vencimiento,$tbl_ronda.no_ronda FROM $tbl_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_contador_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_ronda ON $tbl_contador_muestra.id_ronda = $tbl_ronda.id_ronda ".$filterQry." ORDER BY $tbl_ronda.no_ronda DESC, $tbl_muestra_programa.fecha_vencimiento DESC";
			
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			$returnValue_3 = array();
			$returnValue_4 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_muestra'];
				$returnValue_2[$x] = $qryData['no_ronda'];
				$returnValue_3[$x] = $qryData['codigo_muestra'];
				$returnValue_4[$x] = $qryData['fecha_vencimiento'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3>'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo '</response>';		
		break;
		case 'showIfLabReportedResult':

			switch ($filterid) {
				case 'id_array':
					$filterArray = explode("|",$filter);
					
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
				
			$qry = "SELECT $tbl_laboratorio.id_laboratorio,no_laboratorio,nombre_laboratorio FROM $tbl_laboratorio INNER JOIN $tbl_programa_laboratorio ON $tbl_laboratorio.id_laboratorio = $tbl_programa_laboratorio.id_laboratorio WHERE $tbl_programa_laboratorio.id_programa = $filterArray[0] AND $tbl_programa_laboratorio.activo = 1 ORDER BY no_laboratorio ASC";			
			
			$qryArray = mysql_query($qry);
	
			$returnValue_1 = array();
			$returnValue_2 = array();
			$returnValue_3 = array();
			$returnValue_4 = array();
			$returnValue_5 = array();

			$x = 0;
			$y = 0;
	
			while ($qryData = mysql_fetch_array($qryArray)) {
				
				$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_laboratorio = ".$qryData["id_laboratorio"]." AND id_programa = $filterArray[0] AND id_configuracion IN (SELECT id_configuracion FROM $tbl_resultado WHERE id_muestra = $filterArray[1])";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				$qry = "SELECT fecha_reporte FROM $tbl_fecha_reporte_muestra WHERE id_laboratorio = ".$qryData["id_laboratorio"]." AND id_muestra = $filterArray[1]";
				
				if ($checkrows > 0) {
					
					$innerQryData = mysql_fetch_array(mysql_query($qry));
					
					$returnValue_1[$x] = $qryData["no_laboratorio"];
					$returnValue_2[$x] = $qryData["nombre_laboratorio"];
					$returnValue_3[$x] = $innerQryData["fecha_reporte"];
					$x++;
				}
				if ($checkrows == 0) {
					$returnValue_4[$y] = $qryData["no_laboratorio"];
					$returnValue_5[$y] = $qryData["nombre_laboratorio"];
					$y++;
				}
			}
			
			echo '<response code="1">';
			echo'<returnvalues1>'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3>'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo'<returnvalues5>'.implode("|",$returnValue_5).'</returnvalues5>';
			echo '</response>';				
		
		break;
		case 'showReportedAnalitValues':

			switch ($filterid) {
				case 'id_array':
					$filterArray = explode("|",$filter);
					
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
	
			$sampleArray = array(
				"no_lab" => array()
				,"analito" => array()
			);
			
			$sampleArray2 = array(
				"valor_resultado" => array()			
			);

			$x = 0;
			$y = 0;
	
			$returnValue_1 = array();	
			$returnValue_2 = array();	
	
			$qry = "SELECT $tbl_analito.id_analito,nombre_analito FROM $tbl_analito INNER JOIN $tbl_programa_analito ON $tbl_analito.id_analito = $tbl_programa_analito.id_analito WHERE $tbl_programa_analito.id_programa = ".$filterArray[0]." ORDER BY $tbl_analito.nombre_analito ASC";

			$qryArray = mysql_query($qry);	
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_analito'];
				$returnValue_2[$x] = $qryData['nombre_analito'];
				$x++;
			}
	
			$x = 0;
	
			$qry = "SELECT $tbl_programa_laboratorio.id_laboratorio,no_laboratorio,nombre_laboratorio FROM $tbl_laboratorio INNER JOIN $tbl_programa_laboratorio ON $tbl_laboratorio.id_laboratorio = $tbl_programa_laboratorio.id_laboratorio WHERE $tbl_programa_laboratorio.id_programa = ".$filterArray[0]." AND $tbl_programa_laboratorio.activo = 1 ORDER BY no_laboratorio ASC";		
			
			$qryArray = mysql_query($qry);
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				
				$sampleArray['no_lab'][$x] = $qryData['no_laboratorio'];
				$sampleArray['analito'][$x] = $sampleArray2;
				
				for ($y = 0; $y < sizeof($returnValue_1); $y++) {
					
					$tempArray = array();
					$z = 0;					
					
					$qry = "SELECT valor_resultado FROM $tbl_resultado INNER JOIN $tbl_configuracion_laboratorio_analito ON $tbl_resultado.id_configuracion = $tbl_configuracion_laboratorio_analito.id_configuracion WHERE $tbl_configuracion_laboratorio_analito.id_laboratorio = ".$qryData['id_laboratorio']." AND $tbl_configuracion_laboratorio_analito.id_analito = ".$returnValue_1[$y]." AND $tbl_resultado.id_muestra = ".$filterArray[1];
					
					$innerQryArray = mysql_query($qry);
					
					if (mysql_num_rows($innerQryArray) == 0) {
						$tempArray[0] = "";
					} else {
						while ($innerQryData = mysql_fetch_array($innerQryArray)) {
							
							$tempArray[$z] = $innerQryData['valor_resultado'];
							$z++;
							
						}						
					}
					
					$sampleArray['analito'][$x]['valor_resultado'][$y] = implode(", ",$tempArray);
					
				}
				
				$x++;
				
			}
			
			echo '<response code="1">';
			echo'<returnvalues1>'.implode("|",$sampleArray['no_lab']).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3>';
				for ($x = 0; $x < sizeof($sampleArray['analito']); $x++) {
					echo'<item'.$x.'>';
						echo implode("|",$sampleArray['analito'][$x]['valor_resultado']);
					echo'</item'.$x.'>';
				}
			echo'</returnvalues3>';
			echo '</response>';				
		
		break;			
		default:
			echo'<response code="0">PHP dataChangeHandler error: id "'.$header.'" not found</response>';
		break;		
	}
	
	mysql_close($con);
	exit;
?>	