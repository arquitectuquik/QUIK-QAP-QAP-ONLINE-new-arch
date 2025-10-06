<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	session_start();
	include_once"verifica_sesion.php";
	userRestriction();	
	
	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";		
	
	$header = mysql_real_escape_string(stripslashes(clean($_POST['header'])));
	
	if (!isset($_POST['filter'])) {
		$_POST['filter'] = 'NULL';
	}
	if (!isset($_POST['filterid'])) {
		$_POST['filterid'] = 'NULL';
	}
	
	$filter = mysql_real_escape_string(stripslashes(clean($_POST['filter'])));
	$filterid = mysql_real_escape_string(stripslashes(clean($_POST['filterid'])));
	
	if ($filter == "") {
		$filter = 'NULL';
	}
	if ($filterid == "") {
		$filterid = 'NULL';
	}
	
	switch($header) {
		case 'showAssignedLabProgram':
		
			switch ($filterid) {
				case 'id_laboratorio':
					$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = ".encryptControl('decrypt',$filter,$_SESSION['qap_token']);
				break;
				default:
					$filterQry = '';
				break;
			}					
			
			$qry = "SELECT id_conexion,$tbl_programa.nombre_programa,$tbl_laboratorio.no_laboratorio,$tbl_laboratorio.nombre_laboratorio,$tbl_programa.id_programa FROM $tbl_programa INNER JOIN $tbl_programa_laboratorio ON $tbl_programa.id_programa = $tbl_programa_laboratorio.id_programa INNER JOIN $tbl_laboratorio ON $tbl_programa_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio $filterQry ORDER BY $tbl_programa.nombre_programa ASC, $tbl_laboratorio.nombre_laboratorio ASC";				
	
		
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			$returnValue_3 = array();
			$returnValue_4 = array();
			$returnValue_5 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_conexion'];
				$returnValue_2[$x] = $qryData['no_laboratorio'];
				$returnValue_3[$x] = $qryData['nombre_laboratorio'];
				$returnValue_4[$x] = $qryData['nombre_programa'];
				$returnValue_5[$x] = $qryData['id_programa'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 selectomit="1" content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2 selectomit="1">'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3 selectomit="1">'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo'<returnvalues5 content="id">'.implode("|",$returnValue_5).'</returnvalues5>';
			echo '</response>';		
		break;
		case 'showAnalitConfiguredCualitativeTypeOfResult':

			$filter = encryptControl('decrypt',$filter,$_SESSION['qap_token']);
			switch ($filterid) {
				case 'id_configuracion':
					$filterQry = "WHERE $tbl_configuracion_analito_resultado_reporte_cualitativo.id_configuracion = ".$filter;
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
			mysqlException(mysql_error(),$header."_01");
			
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
			mysqlException(mysql_error(),$header."_02");
			
			$returnValue_3 = array();
			$returnValue_4 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_3[$x] = $qryData['id_analito_resultado_reporte_cualitativo'];
				$returnValue_4[$x] = $qryData['desc_resultado_reporte_cualitativo'];

				$x++;
			}			
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3 content="id">'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';			
			echo '</response>';		
		break;
		case 'showAssignedLabRound':

			$filterArray = explode("|",$filter);
			
			for ($x = 0; $x < sizeof($filterArray); $x++) {
				if ($filterArray[$x] == "") {
					$filterArray[$x] = "NULL";
				}
			}					
			
			switch ($filterid) {
				case 'id_laboratorio':
					// $filterQry = "WHERE $tbl_ronda_laboratorio.id_laboratorio = ".encryptControl('decrypt',$filterArray[1],$_SESSION['qap_token'])." AND $tbl_ronda.id_programa = $filterArray[0] GROUP BY $tbl_ronda.no_ronda";
					// Se actualiza la sentencia group by
					$filterQry = "WHERE $tbl_ronda_laboratorio.id_laboratorio = ".encryptControl('decrypt',$filterArray[1],$_SESSION['qap_token'])." AND $tbl_ronda.id_programa = $filterArray[0] GROUP BY $tbl_ronda.id_ronda";
				break;
				default:
					$filterQry = '';
				break;
			}

			$qry = "SELECT $tbl_ronda.no_ronda,$tbl_ronda.id_ronda FROM $tbl_ronda INNER JOIN $tbl_ronda_laboratorio ON $tbl_ronda.id_ronda = $tbl_ronda_laboratorio.id_ronda INNER JOIN $tbl_programa ON $tbl_ronda.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_muestra_programa ON $tbl_programa.id_programa = $tbl_muestra_programa.id_programa $filterQry ORDER BY $tbl_ronda.no_ronda DESC";

			
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();;
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_ronda'];
				$returnValue_2[$x] = $qryData['no_ronda'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo '</response>';		
		break;
		case 'showAssignedRoundSample':

			$filterArray = explode("|",$filter);
			
			for ($x = 0; $x < sizeof($filterArray); $x++) {
				if ($filterArray[$x] == "") {
					$filterArray[$x] = "NULL";
				}
			}		
		
			switch ($filterid) {				
				case 'id_array':
					$filterQry = "WHERE $tbl_ronda.id_ronda = $filterArray[0]";
				break;					
				default:
					$filterQry = '';
				break;
			}

			$qry = "SELECT $tbl_muestra.id_muestra,$tbl_muestra.codigo_muestra,$tbl_contador_muestra.no_contador,$tbl_muestra_programa.fecha_vencimiento FROM $tbl_ronda INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa $filterQry ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";
			
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			$returnValue_3 = array();
			$returnValue_4 = array();
			$returnValue_5 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = encryptControl("encrypt",$qryData['id_muestra'],$_SESSION['qap_token']);
				$returnValue_2[$x] = $qryData['no_contador'];
				$returnValue_3[$x] = $qryData['codigo_muestra'];
				$returnValue_4[$x] = $qryData['fecha_vencimiento'];
				
				$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_laboratorio = ".encryptControl("decrypt",$filterArray[2],$_SESSION['qap_token'])." AND id_programa = $filterArray[1] AND id_configuracion IN (SELECT id_configuracion FROM $tbl_resultado WHERE id_muestra = ".$qryData['id_muestra'].")";
				
				$checkrows = mysql_num_rows(mysql_query($qry));
				
				if ($checkrows > 0) {					
					$returnValue_5[$x] = 1;
				}
				if ($checkrows == 0) {
					$returnValue_5[$x] = 0;
				}				
				
				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3>'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo'<returnvalues5>'.implode("|",$returnValue_5).'</returnvalues5>';
			echo '</response>';			
		break;
		case 'showAssignedLabAnalit':

			$filterArray = explode("|",$filter);
			
			for ($x = 0; $x < sizeof($filterArray); $x++) {
				if ($filterArray[$x] == "") {
					$filterArray[$x] = "NULL";
				}
			}				
			
			switch ($filterid) {
				case 'id_array':
					$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_laboratorio = ".encryptControl('decrypt',$filterArray[0],$_SESSION['qap_token'])." AND $tbl_configuracion_laboratorio_analito.id_programa = $filterArray[1] AND activo = 1";
				break;				
				default:
					$filterQry = '';
				break;
			}			
				
			// $qry = "SELECT $tbl_configuracion_laboratorio_analito.id_configuracion,nombre_analito,nombre_analizador,nombre_metodologia,nombre_reactivo,nombre_unidad,valor_gen_vitros FROM $tbl_configuracion_laboratorio_analito INNER JOIN $tbl_laboratorio ON $tbl_configuracion_laboratorio_analito.id_laboratorio = $tbl_laboratorio.id_laboratorio INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad LEFT JOIN $tbl_resultado ON $tbl_configuracion_laboratorio_analito.id_configuracion = $tbl_resultado.id_configuracion INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros $filterQry GROUP BY $tbl_configuracion_laboratorio_analito.id_configuracion ORDER BY nombre_analito ASC";
			// Se actualiza el group by
			$qry = "SELECT 
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
			         GROUP BY $tbl_configuracion_laboratorio_analito.id_configuracion 
			         ORDER BY nombre_analito ASC";
			
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
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
			$returnValue_13 = $_SESSION['qap_key'];
			$returnValue_14 = array();
			$returnValue_15 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = encryptControl("encrypt",$qryData['id_configuracion'],$_SESSION['qap_token']);
				$returnValue_2[$x] = $qryData['nombre_analito'];
				$returnValue_3[$x] = $qryData['nombre_analizador'];
				$returnValue_4[$x] = $qryData['nombre_metodologia'];
				$returnValue_5[$x] = $qryData['nombre_reactivo'];
				$returnValue_6[$x] = $qryData['nombre_unidad'];
				$returnValue_11[$x] = $qryData['valor_gen_vitros'];

				$x++;
			}
			
			for ($x = 0; $x < sizeof($returnValue_1); $x++) {
				
				$qry = "SELECT valor_resultado,observacion_resultado,nombre_usuario,fecha_resultado,revalorado,$tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $tbl_resultado INNER JOIN $tbl_usuario ON $tbl_resultado.id_usuario = $tbl_usuario.id_usuario LEFT JOIN $tbl_analito_resultado_reporte_cualitativo ON $tbl_resultado.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = ".encryptControl("decrypt",$returnValue_1[$x],$_SESSION['qap_token'])." AND id_muestra = ".encryptControl("decrypt",$filterArray[2],$_SESSION['qap_token']);
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),$header."_01_".$x);

				$returnValue_7[$x] = $qryData['valor_resultado'];
				$returnValue_8[$x] = $qryData['observacion_resultado'];
				$returnValue_9[$x] = $qryData['nombre_usuario'];
				$returnValue_10[$x] = $qryData['fecha_resultado'];
				$returnValue_12[$x] = $qryData['revalorado'];
				$returnValue_14[$x] = $qryData['desc_resultado_reporte_cualitativo'];
				
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3>'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo'<returnvalues5>'.implode("|",$returnValue_5).'</returnvalues5>';
			echo'<returnvalues6>'.implode("|",$returnValue_6).'</returnvalues6>';
			echo'<returnvalues7>'.implode("|",$returnValue_7).'</returnvalues7>';
			echo'<returnvalues8>'.implode("|",$returnValue_8).'</returnvalues8>';
			echo'<returnvalues9>'.implode("|",$returnValue_9).'</returnvalues9>';
			echo'<returnvalues10>'.implode("|",$returnValue_10).'</returnvalues10>';
			echo'<returnvalues11>'.implode("|",$returnValue_11).'</returnvalues11>';
			echo'<returnvalues12>'.implode("|",$returnValue_12).'</returnvalues12>';
			echo'<returnvalues13>'.$returnValue_13.'</returnvalues13>';
			echo'<returnvalues14>'.implode("|",$returnValue_14).'</returnvalues14>';
			echo '</response>';		
		break;
		case 'showAssignedLabAnalitSimple':
			$filterArray = explode("|",$filter);
			
			for ($x = 0; $x < sizeof($filterArray); $x++) {
				if ($filterArray[$x] == "") {
					$filterArray[$x] = "NULL";
				}
			}		
		
			switch ($filterid) {				
				case 'id_array':
					$filterQry = " WHERE $tbl_laboratorio.id_laboratorio = '".encryptControl('decrypt',$filterArray[0],$_SESSION['qap_token']) ."' AND $tbl_programa.id_programa = '$filterArray[1]' ";
				break;					
				default:
					$filterQry = ' ';
				break;
			}
			$qry = "SELECT 
						$tbl_configuracion_laboratorio_analito.id_configuracion,
						nombre_programa,
						nombre_analito,
						nombre_analizador,
						nombre_metodologia,
						nombre_reactivo,
						nombre_unidad,
						valor_gen_vitros,
						nombre_material,
						activo 
					FROM $tbl_configuracion_laboratorio_analito 
					INNER JOIN $tbl_programa ON $tbl_configuracion_laboratorio_analito.id_programa = $tbl_programa.id_programa 
					INNER JOIN $tbl_laboratorio ON $tbl_configuracion_laboratorio_analito.id_laboratorio = $tbl_laboratorio.id_laboratorio 
					INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito 
					INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador 
					INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia 
					INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo 
					INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad 
					INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros 
					LEFT JOIN $tbl_material ON $tbl_configuracion_laboratorio_analito.id_material = $tbl_material.id_material
					$filterQry
					ORDER BY nombre_programa ASC, nombre_analito ASC, nombre_analizador ASC,  nombre_metodologia ASC";

			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
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
				$returnValue_1[$x] = encryptControl("encrypt",$qryData['id_configuracion'],$_SESSION['qap_token']);
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
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3>'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo'<returnvalues5>'.implode("|",$returnValue_5).'</returnvalues5>';
			echo'<returnvalues6>'.implode("|",$returnValue_6).'</returnvalues6>';
			echo'<returnvalues7>'.implode("|",$returnValue_7).'</returnvalues7>';
			echo'<returnvalues8>'.implode("|",$returnValue_8).'</returnvalues8>';
			echo'<returnvalues9>'.implode("|",$returnValue_9).'</returnvalues9>';
			echo'<returnvalues10>'.implode("|",$returnValue_10).'</returnvalues10>';
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
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_material'];
				$returnValue_2[$x] = $qryData['nombre_material'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo '</response>';		
		break;

		case 'showLabData':
		
			switch ($filterid) {
				case 'id_laboratorio':
					$filterQry = "WHERE $tbl_laboratorio.id_laboratorio = ".encryptControl('decrypt',$filter,$_SESSION['qap_token']);
				break;
				default:
					$filterQry = '';
				break;
			}		
		
			$qry = "SELECT $tbl_laboratorio.*,$tbl_ciudad.nombre_ciudad,$tbl_pais.nombre_pais FROM $tbl_laboratorio INNER JOIN $tbl_ciudad ON $tbl_laboratorio.id_ciudad = $tbl_ciudad.id_ciudad INNER JOIN $tbl_pais ON $tbl_ciudad.id_pais = $tbl_pais.id_pais ".$filterQry;			

			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			

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
				$returnValue_1[$x] = $qryData['no_laboratorio'];
				$returnValue_2[$x] = $qryData['nombre_laboratorio'];
				$returnValue_3[$x] = $qryData['direccion_laboratorio'];
				$returnValue_4[$x] = $qryData['telefono_laboratorio'];
				$returnValue_5[$x] = $qryData['correo_laboratorio'];
				$returnValue_6[$x] = $qryData['contacto_laboratorio'];
				$returnValue_7[$x] = $qryData['nombre_ciudad'];
				$returnValue_8[$x] = $qryData['nombre_pais'];

				$x++;
			}		
		
			echo '<response code="1">';
			echo'<returnvalues1>'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3>'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo'<returnvalues5>'.implode("|",$returnValue_5).'</returnvalues5>';
			echo'<returnvalues6>'.implode("|",$returnValue_6).'</returnvalues6>';
			echo'<returnvalues7>'.implode("|",$returnValue_7).'</returnvalues7>';
			echo'<returnvalues8>'.implode("|",$returnValue_8).'</returnvalues8>';
			echo '</response>';			
		
		break;
		case 'showAnalit':
				
			switch ($filterid) {
				case 'id_programa':
					$filterQry = "WHERE $tbl_programa.id_programa = ".$filter;
				break;
				default:
					$filterQry = '';
				break;
			}			
				
			$qry = "SELECT $tbl_programa_analito.id_conexion,$tbl_analito.id_analito,$tbl_programa.nombre_programa,$tbl_analito.nombre_analito FROM $tbl_analito INNER JOIN $tbl_programa_analito ON $tbl_analito.id_analito = $tbl_programa_analito.id_analito INNER JOIN $tbl_programa ON $tbl_programa.id_programa = $tbl_programa_analito.id_programa ".$filterQry." ORDER BY $tbl_programa.nombre_programa ASC, $tbl_analito.nombre_analito ASC";		
			
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
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
			echo'<returnvalues1 selectomit="1" content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2 selectomit="1">'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3 content="id">'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
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
				
			$qry = "SELECT id_analizador,nombre_analizador FROM $tbl_analizador ".$filterQry." ORDER BY nombre_analizador ASC";
				
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_analizador'];
				$returnValue_2[$x] = $qryData['nombre_analizador'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo '</response>';		
		break;		
		case 'showMethod':
				
			switch ($filterid) {
				case 'id_analizador':
					$filterQry = "WHERE $tbl_analizador.id_analizador = ".$filter;
				break;
				case 'id_analito':
				
					$filterArray = explode("|",$filter);
					
					for ($x = 0; $x < sizeof($filterArray); $x++) {
						if ($filterArray[$x] == "") {
							$filterArray[$x] = "NULL";
						}
					}			
				
					$filterQry = "WHERE $tbl_metodologia.id_metodologia IN (SELECT id_metodologia FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY $tbl_metodologia.id_metodologia, $tbl_metodologia_analizador.id_conexion";
				break;					
				default:
					$filterQry = '';
				break;
			}			
				
			$qry = "SELECT $tbl_metodologia_analizador.id_conexion,$tbl_metodologia.id_metodologia,$tbl_metodologia.nombre_metodologia,$tbl_analizador.nombre_analizador FROM $tbl_metodologia INNER JOIN $tbl_metodologia_analizador ON $tbl_metodologia.id_metodologia = $tbl_metodologia_analizador.id_metodologia INNER JOIN $tbl_analizador ON $tbl_analizador.id_analizador = $tbl_metodologia_analizador.id_analizador ".$filterQry." ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_metodologia.nombre_metodologia ASC";
		
			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
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
			echo'<returnvalues1 selectomit="1" content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2 selectomit="1">'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3 content="id">'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo '</response>';		
		break;
		case 'showReactive':

			switch ($filterid) {
				case 'id_analito':
					$filterQry = "WHERE $tbl_reactivo.id_reactivo IN (SELECT id_reactivo FROM $tbl_configuracion_laboratorio_analito WHERE id_analito = $filter)";
				break;
				default:
					$filterQry = '';
				break;
			}
		
			$qry = "SELECT id_reactivo,nombre_reactivo FROM $tbl_reactivo ".$filterQry." ORDER BY nombre_reactivo ASC";

			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_reactivo'];
				$returnValue_2[$x] = $qryData['nombre_reactivo'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo '</response>';		
		break;
		case 'showUnit':
				
			switch ($filterid) {
				case 'id_analizador':
					$filterQry = "WHERE $tbl_analizador.id_analizador = ".$filter;
				break;
				case 'id_analito':
			
					$filterArray = explode("|",$filter);
					
					for ($x = 0; $x < sizeof($filterArray); $x++) {
						if ($filterArray[$x] == "") {
							$filterArray[$x] = "NULL";
						}
					}			
				
					$filterQry = "WHERE $tbl_unidad.id_unidad IN (SELECT id_unidad FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY $tbl_unidad.id_unidad, $tbl_unidad_analizador.id_conexion";
			
				break;
				default:
					$filterQry = '';
				break;
			}
				
			$qry = "SELECT $tbl_unidad_analizador.id_conexion,$tbl_unidad.id_unidad,$tbl_unidad.nombre_unidad,$tbl_analizador.nombre_analizador FROM $tbl_unidad INNER JOIN $tbl_unidad_analizador ON $tbl_unidad.id_unidad = $tbl_unidad_analizador.id_unidad INNER JOIN $tbl_analizador ON $tbl_analizador.id_analizador = $tbl_unidad_analizador.id_analizador ".$filterQry." ORDER BY $tbl_analizador.nombre_analizador ASC, $tbl_unidad.nombre_unidad ASC";				

			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
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
			echo'<returnvalues1 content="id" selectomit="1">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2 selectomit="1">'.implode("|",$returnValue_2).'</returnvalues2>';
			echo'<returnvalues3 content="id">'.implode("|",$returnValue_3).'</returnvalues3>';
			echo'<returnvalues4>'.implode("|",$returnValue_4).'</returnvalues4>';
			echo '</response>';		
		break;
		case 'showVitrosGen':
				
			switch ($filterid) {
				case 'id_analito':
			
					$filterArray = explode("|",$filter);
					
					for ($x = 0; $x < sizeof($filterArray); $x++) {
						if ($filterArray[$x] == "") {
							$filterArray[$x] = "NULL";
						}
					}			
			
					$filterQry = "WHERE $tbl_gen_vitros.id_gen_vitros IN (SELECT id_gen_vitros FROM $tbl_configuracion_laboratorio_analito WHERE id_analizador = $filterArray[0] AND id_analito = $filterArray[1]) GROUP BY $tbl_gen_vitros.id_gen_vitros";
			
				break;
				default:
					$filterQry = '';
				break;
			}
				
			$qry = "SELECT id_gen_vitros,valor_gen_vitros FROM $tbl_gen_vitros ".$filterQry." ORDER BY valor_gen_vitros ASC";			

			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_gen_vitros'];
				$returnValue_2[$x] = $qryData['valor_gen_vitros'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
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
			mysqlException(mysql_error(),$header."_01");
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
				$returnValue_1[$x] = $qryData['id_tipo_programa'];

				$x++;
			}
			
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo '</response>';		
		break;
		case 'showAnalitCualitativeTypeOfResultForConfiguration':

			switch ($filterid) {
				case 'id_configuracion':
					$filterQry = "WHERE $tbl_configuracion_laboratorio_analito.id_configuracion = ".encryptControl("decrypt",$filter,$_SESSION['qap_token']);
				break;
				default:
					$filterQry = '';
				break;
			}
			
			$qry = "SELECT id_analito,id_analizador,id_metodologia,id_reactivo,id_unidad,id_gen_vitros,id_programa, id_laboratorio FROM $tbl_configuracion_laboratorio_analito $filterQry LIMIT 0,1";
			$qryData = mysql_fetch_array(mysql_query($qry));
			mysqlException(mysql_error(),$header."_01");
			
			$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito 
					WHERE id_analito = ".$qryData['id_analito']." 
						AND id_laboratorio = ".$qryData['id_laboratorio']." 
						AND id_programa = ".$qryData['id_programa']." 
						AND id_analizador = ".$qryData['id_analizador']." 
						AND id_metodologia = ".$qryData['id_metodologia']." 
						AND id_reactivo = ".$qryData['id_reactivo']." 
						AND id_unidad = ".$qryData['id_unidad']." 
						AND id_gen_vitros = ".$qryData['id_gen_vitros']."
					LIMIT 0,1";
			$qryData2 = mysql_fetch_array(mysql_query($qry));
			mysqlException(mysql_error(),$header."_01");			
			
			$returnValue_1 = array();
			$returnValue_2 = array();
			
			$returnValue_1[0] = "null";
			$returnValue_2[0] = "N/A";			
			
			if (mysql_num_rows(mysql_query($qry)) > 0) {
				$qry = "SELECT id_analito_resultado_reporte_cualitativo,desc_resultado_reporte_cualitativo FROM $tbl_analito_resultado_reporte_cualitativo WHERE id_analito_resultado_reporte_cualitativo IN (SELECT id_analito_resultado_reporte_cualitativo FROM $tbl_configuracion_analito_resultado_reporte_cualitativo WHERE $tbl_configuracion_analito_resultado_reporte_cualitativo.id_configuracion = ".$qryData2['id_configuracion'].") ORDER BY desc_resultado_reporte_cualitativo ASC";
				$qryArray = mysql_query($qry);
				mysqlException(mysql_error(),$header."_02");
				

				$qry_misc = "SELECT valor_misc FROM $tbl_misc WHERE titulo_misc = 'separador_analito_resultado_reporte_cualitativo'";
				$qryData_misc = mysql_fetch_array(mysql_query($qry_misc));
				mysqlException(mysql_error(),$header."_000");
				
				$separador_cualitativo = $qryData_misc['valor_misc'];

				$x = 1;
				
				while ($qryData = mysql_fetch_array($qryArray)) {

					$textoSeparador = "";

					if(strpos($qryData['desc_resultado_reporte_cualitativo'], $separador_cualitativo)){ // Si tiene el separador
						$arrayIntervalo = explode($separador_cualitativo,$qryData['desc_resultado_reporte_cualitativo']);
						
						if($arrayIntervalo[1] != ""){
							$textoSeparador = $arrayIntervalo[0] . " hasta " . $arrayIntervalo[1];
						} else {
							$textoSeparador = $arrayIntervalo[0] . " o más";
						}
	
					} else {
						$textoSeparador = $qryData['desc_resultado_reporte_cualitativo'];
					}



					$returnValue_1[$x] = $qryData['id_analito_resultado_reporte_cualitativo'];
					$returnValue_2[$x] = $textoSeparador;
	
					$x++;
				}
			}
	
			echo '<response code="1">';
			echo'<returnvalues1 content="id">'.implode("|",$returnValue_1).'</returnvalues1>';
			echo'<returnvalues2>'.implode("|",$returnValue_2).'</returnvalues2>';
			echo '</response>';		
		break;
		default:
			echo'<response code="0">PHP dataChangeHandler error: id "'.$header.'" not found</response>';
		break;		
	}
	
	mysql_close($con);
	exit;
?>	