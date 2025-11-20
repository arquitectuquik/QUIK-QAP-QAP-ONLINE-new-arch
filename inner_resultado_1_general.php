<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
	require_once 'mysql_compatibility.php';
}




/*

ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

*/
error_reporting(E_ERROR); // Report only errors



session_start();


header('Access-Control-Allow-Origin: *');

header('Access-Control-Allow-Methods: GET, POST');

header('Access-Control-Allow-Headers: X-Requested-With');

include_once "php/verifica_sesion.php";

include_once "php/complementos/grubbs.php";

include_once "php/complementos/intercuartil.php";
require_once __DIR__ . "/php/controllers/MediaDeComparacionController.php";
require_once __DIR__ . "/php/repositorys/ResultadosRepository.php";
require_once __DIR__ . "/php/repositorys/MediaEvaluacionEspecialRepository.php";
require_once __DIR__ . "/php/LogicaNegocio/MediaDeComparacion/App/TodosParticipantesFabrica.php";
require_once __DIR__ . "/php/LogicaNegocio/MediaDeComparacion/App/ParticipantesMismaMetodologiaFabrica.php";
require_once __DIR__ . "/php/LogicaNegocio/MediaDeComparacion/App/CaluladoresMedia/CalculadorMediaCasoEspecialEstrategiaDecorador.php";
require_once __DIR__ . "/php/LogicaNegocio/MediaDeComparacion/App/CaluladoresMedia/CalculadorMediaConFiltrosAtipicosEstrategia.php";
require_once __DIR__ . "/php/LogicaNegocio/MediaDeComparacion/App/FiltrosAtipicos/FiltroGrubbsFabrica.php";
require_once __DIR__ . "/php/LogicaNegocio/MediaDeComparacion/App/FiltrosAtipicos/FiltroIntercuartilicoFabrica.php";
actionRestriction_102();



$header = $_GET['header'];



if (!isset($_GET['filter'])) {

	$_GET['filter'] = 'NULL';
}

if (!isset($_GET['filterid'])) {

	$_GET['filterid'] = 'NULL';
}



$filter = $_GET['filter'];

$filterid = $_GET['filterid'];



if ($filter == "") {

	$filter = 'NULL';
}

if ($filterid == "") {

	$filterid = 'NULL';
}



// Uso de variables globales

include_once "tablePrinter.php";



switch ($header) {

	case 'showResultsGeneral':



		$filterArray = explode("|", $filter);



		for ($x = 0; $x < sizeof($filterArray); $x++) {

			if ($filterArray[$x] == "") {

				$filterArray[$x] = "NULL";
			}
		}



		$programid = clean($filterArray[0]);

		$labid = clean($filterArray[1]);

		$sampleid = clean($filterArray[2]);

		$roundid = clean($filterArray[4]);

		$reportstatusid = clean($filterArray[10]);

		$fechaCorte = $filterArray[count($filterArray) - 1];

		$arrayCalculosModificadosConsenso = [];
		$arrayCalculosModificadosInternacional = [];



		$pageContent = array(

			"labnumber" => "",
			"labname" => "",
			"labaddress" => "",
			"labcity" => "",
			"labcountry" => "",
			"labcontact" => "",
			"labphone" => "",
			"labemail" => "",
			"labresultsdate" => "",
			"programname" => "",
			"programinitials" => "",
			"programmodality" => "",
			"programroundnumber" => "",
			"programsamplenumber" => "",
			"programsample" => "",
			"programsampleexpirationdate" => "",
			"programsampletype" => "",
			"programtype" => "",
			"reportidoriginal" => "",
			"reportidupdated" => "",
			"evaluationcriteria" => "",
			"reportdayofgeneration" => "",
			"reportmonthofgeneration" => "",
			"reportyearofgeneration" => "",
			"reportdisclaimer" => "",
			"reportapprovedby" => "",
			"reportapprovedbyliability" => "",
			"reportapprovedbysignature" => "",
			"reportcompanyinfoarray" => array(),
			"reportstatus" => "",
			"reportlogo1" => "",
			"reportlogo2" => "",
			"programsamples" => array(),
			"ammountofresultsforcurrentsample" => 0,
			"ammountofresultsforcurrentsamplemisc" => 0,
			"ammountofsatisfactoryresults" => 0,
			"ammountofsatisfactoryresultsmisc" => 0,
			"ammountofsatisfactoryresultsforthewholeround" => 0,
			"ammountofsatisfactoryparticipantesqap" => 0,
			"ammountofsatisfactoryresultsforthewholeroundmisc" => 0,
			"ammountofhalfsatisfactoryresults" => 0,
			"ammountofhalfsatisfactoryresultsforthewholeround" => 0,
			"ammountofhalfsatisfactoryparticipantesqap" => 0,
			"ammountofunsatisfactoryresults" => 0,
			"ammountofunsatisfactoryresultsmisc" => 0,
			"ammountofunsatisfactoryresultsforthewholeround" => 0,
			"ammountofunsatisfactoryparticipantesqap" => 0,
			"ammountofunsatisfactoryresultsforthewholeroundmisc" => 0,
			"ammountofemptyresults" => 0,
			"ammountofeditedresults" => 0,
			"ammountoflateresults" => 0,
			"ammountofsatisfactoryreferenceresults" => 0,
			"ammountofunsatisfactoryreferenceresults" => 0,
			"ammounttotalofreportedanalytes" => 0,
			"ammounttotalofparticipantesqap" => 0,
			"ammounttotalofreportedanalytesmisc" => 0,
			"ammounttotalofreportedreferenceanalytes" => 0,
			"ammounttotalofreportedreferenceanalytesforthewholeround" => 0,
			"separatedanalyzername" => array(),
			"separatedanalyzerid" => array(),
			"separador_analito_resultado_reporte_cualitativo" => "",
			"labconfigurationitems" => array(

				"nombre_analito" => array(),
				"nombre_analizador" => array(),
				"id_analizador" => array(),
				"nombre_metodologia" => array(),
				"nombre_reactivo" => array(),
				"nombre_unidad" => array(),
				"nombre_unidad_global" => array(),
				"factor_conversion" => array(),
				"valor_gen_vitros" => array(),
				"nombre_material" => array(),
				"media_estandar" => array(),
				"nombre_unidad_comp" => array(),
				"tipo_media_estandar" => array(),
				"id_digitacion_wwr" => array(),
				"media_estandar_cualitativa" => array(),
				"desviacion_estandar" => array(),
				"valor_resultado" => array(),
				"valor_resultado_reporte_cualitativo" => array(),
				"observacion_resultado" => array(),
				"nombre_usuario" => array(),
				"fecha_resultado" => array(),
				"editado" => array(),
				"zscore" => array(),
				"diff" => array(),
				"limitname" => array(),
				"limitvalue" => array(),
				"limitoptionvalue" => array(),
				"limitoptionname" => array(),
				"deviationpercentage" => array(),
				"deviationpercentagereference" => array(),
				"upperLimit" => array(),
				"lowerlimit" => array(),
				"sampleperformance" => array(),
				"sampleperformancereference" => array(),
				"zscoreperformance" => array(),
				"referencemedia" => array(),
				"referencemetodology" => array(),
				"referenceunit" => array(),
				"jctlmmethod" => array(),
				"id_metodo_jctlm" => array(),
				"jctlmmaterial" => array(),
				"id_material_jctlm" => array(),
				"jctlmcalification" => array(),
				"comp" => array()

			),
			"labconfigurationitemsforthewholeround" => array(

				"muestra" => array(),
				"media_participantes_qap" => array(),
				"de_participantes_qap" => array(),
				"zscore_participantes_qap" => array(),
				"criterio_zscore_participantes_qap" => array(),
				"resultado" => array(),
				"resultado_reporte_cualitativo" => array(),
				"editado" => array(),
				"fecha_resultado" => array(),
				"media" => array(),
				"de" => array(),
				"n" => array(),
				"tipo_media_comparacion" => array(),
				"media_cualitativa" => array(),
				"zscore" => array(),
				"diff" => array(),
				"deviationpercentage" => array(),
				"deviationpercentagereference" => array(),
				"sampleperformance" => array(),
				"sampleperformancereference" => array(),
				"zscoreperformance" => array(),
				"referencemedia" => array(),
				"upperLimit" => array(),
				"lowerlimit" => array()

			),
			"tablestyle_text_color" => "color: #1c50a4;",
			"tablestyle_background_color" => "background-color: #f2f2f2;",
			"tablestyle_text_center" => "text-align: center; vertical-align: middle;",
			"tablestyle_text_left" => "text-align: left; vertical-align: middle;",
			"tablestyle_text_right" => "text-align: right; vertical-align: middle;",
			"tablestyle_text_justify" => "text-align: justify; vertical-align: middle;",
			"tablestyle_text_bold" => "font-weight: bold;",
			"tablestyle_text_size_10" => "font-size: 5pt;",
			"tablestyle_overflow" => "overflow: auto;",
			"tablestyle_border_all" => "border: 1pt solid #333;",
			"tablestyle_border_left" => "border-left: 1pt solid #333;",
			"tablestyle_border_top" => "border-top: 1pt solid #333;",
			"tablestyle_border_right" => "border-right: 1pt solid #333;",
			"tablestyle_border_bottom" => "border-bottom: 1pt solid #333;",
			"tablestyle_border_color" => "border-color: #1c50a4 !important; color: 1c50a4 !important;",
			"tablestyle_height1" => "height: 26px;",
			"tablestyle_height2" => "height: 120px;",
			"tablestyle_height3" => "height: 452px;"

		);



		$qry = "SELECT valor_misc FROM $tbl_misc WHERE titulo_misc = 'separador_analito_resultado_reporte_cualitativo'";

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), "_000");



		$pageContent["separador_analito_resultado_reporte_cualitativo"] = $qryData['valor_misc'];



		$qry = "SELECT id_tipo_programa FROM $tbl_programa WHERE $tbl_programa.id_programa = $programid LIMIT 0,1";

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), "_00");



		$pageContent["programtype"] = $qryData['id_tipo_programa'];



		$qry = "SELECT $tbl_laboratorio.*,$tbl_ciudad.nombre_ciudad,$tbl_pais.nombre_pais FROM $tbl_laboratorio INNER JOIN $tbl_ciudad ON $tbl_laboratorio.id_ciudad = $tbl_ciudad.id_ciudad 

			INNER JOIN $tbl_pais ON $tbl_ciudad.id_pais = $tbl_pais.id_pais WHERE $tbl_laboratorio.id_laboratorio = $labid";

		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), "_01");



		while ($qryData = mysql_fetch_array($qryArray)) {

			$pageContent["labnumber"] = $qryData['no_laboratorio'];

			$pageContent["labname"] = $qryData['nombre_laboratorio'];

			$pageContent["labaddress"] = $qryData['direccion_laboratorio'];

			$pageContent["labcity"] = $qryData['nombre_ciudad'];

			$pageContent["labcountry"] = $qryData['nombre_pais'];

			$pageContent["labcontact"] = $qryData['contacto_laboratorio'];

			$pageContent["labphone"] = $qryData['telefono_laboratorio'];

			$pageContent["labemail"] = $qryData['correo_laboratorio'];
		}



		$qry = "SELECT $tbl_programa.nombre_programa,$tbl_programa.sigla_programa,$tbl_programa.tipo_muestra,$tbl_programa.modalidad_muestra,$tbl_muestra.codigo_muestra,$tbl_muestra_programa.fecha_vencimiento FROM $tbl_programa INNER JOIN $tbl_muestra_programa ON $tbl_programa.id_programa = $tbl_muestra_programa.id_programa INNER JOIN $tbl_muestra ON $tbl_muestra_programa.id_muestra = $tbl_muestra.id_muestra WHERE $tbl_muestra.id_muestra = $sampleid";

		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), "_02");



		while ($qryData = mysql_fetch_array($qryArray)) {

			$pageContent["programname"] = $qryData['nombre_programa'];

			$pageContent["programinitials"] = $qryData['sigla_programa'];

			$pageContent["programsampletype"] = $qryData['tipo_muestra'];

			$pageContent["programmodality"] = $qryData['modalidad_muestra'];

			$pageContent["programsample"] = $qryData['codigo_muestra'];

			$pageContent["programsampleexpirationdate"] = $qryData['fecha_vencimiento'];
		}



		$qry = "SELECT no_ronda FROM $tbl_ronda WHERE id_ronda = $roundid";

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), "_03");

		$pageContent["programroundnumber"] = $qryData['no_ronda'];



		switch ($pageContent["programtype"]) {

			case 1:



				$pageContent["evaluationcriteria"] = "Satisfactorio:<br/>Diferencia porcentual no supera el error total máximo permitido<br/>Z-score es inferior a 2DS";



				break;

			case 2:



				$pageContent["evaluationcriteria"] = "Satisfactorio:<br/>El resultado de su laboratorio es igual a la referencia";



				break;
		}



		$pageContent["reportdayofgeneration"] = date('d');

		$pageContent["reportmonthofgeneration"] = date('m');

		$pageContent["reportyearofgeneration"] = date('Y');

		$pageContent["reportdisclaimer"] = "Confidencialidad, homogeneidad y estabilidad";

		$pageContent["reportapprovedby"] = "Alejandra Romero";

		$pageContent["reportapprovedbyliability"] = "Coordinadora de programa QAP";

		$pageContent["reportapprovedbysignature"] = "<img src='css/firma_alejandra_romero.png' width='322' height='70'></img>";

		$pageContent["reportcompanyinfoarray"] = array(

			"Información de contacto:",

			"Calle 63 C No. 35 - 13",

			"/ (601) 222-91-51",

			"- +57 318 271 1649",

			"/ Bogotá - Colombia",

			"<br>Coordinación de programas",

			"<a href='mailto:julian.ramirez@quik.com.co' target='_top'>julian.ramirez@quik.com.co</a>",

			'Contact Center:',

			"<a href='mailto:contact.center@quik.com.co' target='_top'>contact.center@quik.com.co</a>",

			"Página web:",

			"<a href='#'>www.quik.com.co</a>"

		);

		$pageContent["reportlogo1"] = "<img src='css/qap_logo.png' style='width: 150px; height: 80px;'></img>";

		//$pageContent["reportlogo2"] = "<img src='css/qlogo.png' style='width: 150px; height: 100px;'></img>";

		//$pageContent["reportfooterlogo"] = "<img src='css/qlogo.png' style='width: 70px; height: 40px;'></img>";

		$pageContent["reportlogoPortada1"] = "<img src='css/qap_logo.png' style='width: 200px;'></img>";

		$pageContent["reportlogoPortada2"] = "<img src='css/qlogopadding.png' style='width: 200px;'></img>";



		$qry = "SELECT $tbl_configuracion_laboratorio_analito.*,

				$tbl_analito.nombre_analito,
				$tbl_analito.id_analito,

				$tbl_analizador.nombre_analizador,

				$tbl_metodologia.nombre_metodologia,

				$tbl_reactivo.nombre_reactivo,

				$tbl_unidad.nombre_unidad,
				$tbl_unidad.id_unidad,

				$tbl_gen_vitros.id_gen_vitros,

				$tbl_gen_vitros.valor_gen_vitros,

				$tbl_material.nombre_material 

			FROM $tbl_configuracion_laboratorio_analito 

				INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito 

				INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador 

				INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia 

				INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo 

				INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad 

				INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros 

				LEFT JOIN $tbl_material ON $tbl_configuracion_laboratorio_analito.id_material = $tbl_material.id_material 

			WHERE $tbl_configuracion_laboratorio_analito.id_laboratorio = $labid 

				AND $tbl_configuracion_laboratorio_analito.id_programa = $programid 

				AND $tbl_configuracion_laboratorio_analito.activo = 1 

			ORDER BY $tbl_analito.nombre_analito ASC,$tbl_analito.nombre_analito ASC";

		$qryArray = mysql_query($qry);

		mysqlException(mysql_error(), "_04");



		$configurationids = array(

			"id_analito" => array(),
			"id_analizador" => array(),
			"id_metodologia" => array(),
			"id_reactivo" => array(),
			"id_unidad" => array(),
			"id_configuracion" => array(),
			"id_gen_vitros" => array(),
			"id_material" => array()

		);

		$configurationmixedvalues = array(

			"valor_resultado" => array(),
			"desviacion_estandar" => array(),
			"n_evaluacion" => array()

		);

		$x = 0;




		while ($qryData = mysql_fetch_array($qryArray)) {



			$qry = "SELECT id_conexion, nombre_unidad_global, factor_conversion FROM $tbl_unidad_global_analito WHERE id_analito = " . $qryData['id_analito'] . " AND id_unidad = " . $qryData['id_unidad'] . " LIMIT 0,1";

			$innerQryArray1 = mysql_query($qry);

			$innerQryData1 = mysql_fetch_array($innerQryArray1);



			$pageContent["labconfigurationitems"]["nombre_analito"][$x] = $qryData['nombre_analito'];
			$pageContent["labconfigurationitems"]["id_analito"][$x] = $qryData['id_analito'];

			$pageContent["labconfigurationitems"]["nombre_analizador"][$x] = $qryData['nombre_analizador'];

			$pageContent["labconfigurationitems"]["id_analizador"][$x] = $qryData['id_analizador'];

			$pageContent["labconfigurationitems"]["nombre_metodologia"][$x] = $qryData['nombre_metodologia'];

			$pageContent["labconfigurationitems"]["nombre_reactivo"][$x] = $qryData['nombre_reactivo'];

			$pageContent["labconfigurationitems"]["nombre_unidad"][$x] = $qryData['nombre_unidad'];

			$pageContent["labconfigurationitems"]["nombre_unidad_global"][$x] = $innerQryData1['nombre_unidad_global'];

			$pageContent["labconfigurationitems"]["factor_conversion"][$x] = $innerQryData1['factor_conversion'];

			$pageContent["labconfigurationitems"]["valor_gen_vitros"][$x] = $qryData['valor_gen_vitros'];

			$pageContent["labconfigurationitems"]["nombre_material"][$x] = $qryData['nombre_material'];



			$configurationids["id_analito"][$x] = $qryData['id_analito'];

			$configurationids["id_analizador"][$x] = $qryData['id_analizador'];

			$configurationids["id_metodologia"][$x] = $qryData['id_metodologia'];

			$configurationids["id_reactivo"][$x] = $qryData['id_reactivo'];

			$configurationids["id_unidad"][$x] = $qryData['id_unidad'];

			$configurationids["id_configuracion"][$x] = $qryData['id_configuracion'];

			$configurationids["id_gen_vitros"][$x] = $qryData['id_gen_vitros'];

			$configurationids["id_material"][$x] = $qryData['id_material'];



			$x++;
		}



		//var_dump($pageContent["labconfigurationitems"]["id_analito"]);
		for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {





			if ($pageContent["programtype"] == 1) {

				$qry = "SELECT nivel_lote, nombre_lote FROM $tbl_lote INNER JOIN $tbl_muestra_programa ON $tbl_lote.id_lote = $tbl_muestra_programa.id_lote WHERE $tbl_muestra_programa.id_muestra = $sampleid AND $tbl_muestra_programa.id_programa = $programid";



				$qryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_05_" . $x);



				$lotLevel = $qryData['nivel_lote'];

				$lotNombre = $qryData['nombre_lote'];
			} else if ($pageContent["programtype"] == 2) {

				$lotLevel = "0";

				$lotNombre = "0";
			}



			$qry = "SELECT 

					percentil_25,

					media_estandar,

					percentil_75,

					desviacion_estandar,

					coeficiente_variacion,

					n_evaluacion,

					tipo_digitacion_wwr,

					tipo_consenso_wwr,

					id_digitacion_wwr,

					unidad_mc.id_unidad, 

					unidad_mc.nombre_unidad as nombre_unidad_mc  

				FROM $tbl_media_evaluacion_caso_especial

					left join digitacion_cuantitativa on digitacion_cuantitativa.id_digitacion_cuantitativa = media_evaluacion_caso_especial.id_digitacion_wwr

					left join unidad unidad_mc on unidad_mc.id_unidad = digitacion_cuantitativa.id_unidad_mc

				INNER JOIN $tbl_configuracion_laboratorio_analito ON $tbl_media_evaluacion_caso_especial.id_configuracion = $tbl_configuracion_laboratorio_analito.id_configuracion 

				WHERE $tbl_configuracion_laboratorio_analito.id_configuracion = " . $configurationids['id_configuracion'][$x] . " AND $tbl_media_evaluacion_caso_especial.nivel = $lotLevel AND $tbl_media_evaluacion_caso_especial.id_muestra = $sampleid AND $tbl_media_evaluacion_caso_especial.id_laboratorio = $labid LIMIT 0,1";



			$qryData_2 = mysql_fetch_array(mysql_query($qry));

			mysqlException(mysql_error(), "_07_" . $x);





			if (!empty($qryData_2)) { // Si esta definida la media de caso especial





				// Id digitacion WWR

				$pageContent["labconfigurationitems"]["id_digitacion_wwr"][$x] = $qryData_2['id_digitacion_wwr'];



				switch ($qryData_2['tipo_digitacion_wwr']) {





					case 1: // Mensual

						$pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] = "Mensual";

						$pageContent["labconfigurationitems"]["media_estandar"][$x] = $qryData_2['media_estandar'];

						$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] = $qryData_2['desviacion_estandar'];

						$pageContent["labconfigurationitems"]["coeficiente_variacion"][$x] = $qryData_2['coeficiente_variacion'];


						$pageContent["labconfigurationitems"]["n_evaluacion"][$x] = $qryData_2['n_evaluacion'];

						$pageContent["labconfigurationitems"]["comp"][$x] = $qryData_2['tipo_consenso_wwr'];

						$pageContent["labconfigurationitems"]["nombre_unidad_comp"][$x] = $qryData_2['nombre_unidad_mc'];

						break;

					case 2: // Acumulada

						$pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] = "Acumulada";

						$pageContent["labconfigurationitems"]["media_estandar"][$x] = $qryData_2['media_estandar'];

						$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] = $qryData_2['desviacion_estandar'];

						$pageContent["labconfigurationitems"]["coeficiente_variacion"][$x] = $qryData_2['coeficiente_variacion'];

						$pageContent["labconfigurationitems"]["n_evaluacion"][$x] = $qryData_2['n_evaluacion'];

						$pageContent["labconfigurationitems"]["comp"][$x] = $qryData_2['tipo_consenso_wwr'];

						$pageContent["labconfigurationitems"]["nombre_unidad_comp"][$x] = $qryData_2['nombre_unidad_mc'];

						break;

					case 3: // Inserto	

						$pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] = "Inserto";

						$pageContent["labconfigurationitems"]["media_estandar"][$x] = $qryData_2['media_estandar'];

						$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] = $qryData_2['desviacion_estandar'];

						$pageContent["labconfigurationitems"]["coeficiente_variacion"][$x] = $qryData_2['coeficiente_variacion'];

						$pageContent["labconfigurationitems"]["n_evaluacion"][$x] = $qryData_2['n_evaluacion'];

						$pageContent["labconfigurationitems"]["comp"][$x] = $qryData_2['tipo_consenso_wwr'];

						$pageContent["labconfigurationitems"]["nombre_unidad_comp"][$x] = $qryData_2['nombre_unidad_mc'];

						break;

					case 4: // Media de consenso 2.

						if (

							($qryData_2["media_estandar"] == 0 || $qryData_2["media_estandar"] == null) &&

							($qryData_2["desviacion_estandar"] == 0 || $qryData_2["media_estandar"] == null)

						) { // Si la media y la D.E. No estan definidas


							if ($fechaCorte === NULL || $fechaCorte === '' || $fechaCorte === 'NULL') {
								// Si no se proporciona fechaCorte, se obtiene la última fecha de reporte
								// para el laboratorio y muestra actuales de la base de datos.
								$qry_aleatory = "SELECT fecha_reporte FROM `fecha_reporte_muestra` 
											WHERE id_laboratorio = '" . mysql_real_escape_string($labid) . "' 
											AND id_muestra = '" . mysql_real_escape_string($sampleid) . "'";
								$result = mysql_query($qry_aleatory);
								mysqlException(mysql_error(), "_23_");

								$innerQryData_aleatory = mysql_fetch_array($result);
								$fecha_reporte = $innerQryData_aleatory['fecha_reporte'];

							} else {
								// Si se proporciona fechaCorte, se decodifica
								$fechaDecodificada = base64_decode($fechaCorte);
								$fechaArray = json_decode($fechaDecodificada, true);

								// Se busca la fecha específica para el $sampleid actual en el array decodificado.
								if (isset($fechaArray[$sampleid]) && !empty($fechaArray[$sampleid]) && preg_match('/^Dd{4}-\d{2}-\d{2}$/', $fechaArray[$sampleid])) {
									$fecha_reporte = $fechaArray[$sampleid];
								} else {

									$qry_aleatory = "SELECT fecha_reporte FROM `fecha_reporte_muestra`
										WHERE id_laboratorio = '" . mysql_real_escape_string($labid) . "'
										AND id_muestra = '" . mysql_real_escape_string($sampleid) . "'";
									$result = mysql_query($qry_aleatory);
									mysqlException(mysql_error(), "_23_fallback");
									$innerQryData_aleatory = mysql_fetch_array($result);
									$fecha_reporte = $innerQryData_aleatory['fecha_reporte'];
								}
							}


							// Calculo para participante de QAP Online

							$nom_analito_cs = $pageContent["labconfigurationitems"]["nombre_analito"][$x];

							$nom_unidad_cs = $pageContent["labconfigurationitems"]["nombre_unidad"][$x];

							$id_analito_cs = $pageContent["labconfigurationitems"]["id_analito"][$x];

							$current_id_config_para_sesion = $configurationids["id_configuracion"][$x];


							// 1. AHORA, OBTENER LOS IDS SELECCIONADOS PREVIAMENTE DESDE LA BASE DE DATOS
							$previamente_seleccionados_db = array();
							$sql_get_selected_db = "SELECT id_resultado
                            FROM selecciones_consenso
                            WHERE id_configuracion = '" . mysql_real_escape_string($current_id_config_para_sesion) . "'
                            AND id_muestra = '" . mysql_real_escape_string($sampleid) . "'
                            AND DATE(fecha_seleccion) = DATE('" . mysql_real_escape_string($fecha_reporte) . "')";

							$result_selected_db = mysql_query($sql_get_selected_db);
							if ($result_selected_db) {
								while ($row_selected_db = mysql_fetch_assoc($result_selected_db)) {
									$previamente_seleccionados_db[] = $row_selected_db['id_resultado'];
								}
							}

							// Convertir a un array asociativo para búsqueda rápida si fuera necesario,
							// o simplemente usar $previamente_seleccionados_db directamente para el IN clause.
							$ids_seleccionados_personalizados_db = $previamente_seleccionados_db;
							$hay_selecciones_db = !empty($ids_seleccionados_personalizados_db);


							// 2. Construir la consulta base para obtener los participantes
							$qry_participantes_base = "SELECT 
                                    resultado.id_resultado, 
                                    resultado.valor_resultado AS 'resultado' 
                                FROM programa 
                                    JOIN muestra_programa ON programa.id_programa = muestra_programa.id_programa 
                                    JOIN muestra ON muestra.id_muestra = muestra_programa.id_muestra 
                                    JOIN lote ON lote.id_lote = muestra_programa.id_lote 
                                    JOIN resultado ON muestra.id_muestra = resultado.id_muestra 
                                    JOIN configuracion_laboratorio_analito ON configuracion_laboratorio_analito.id_configuracion = resultado.id_configuracion 
                                    JOIN unidad ON unidad.id_unidad = configuracion_laboratorio_analito.id_unidad 
                                    JOIN analito ON analito.id_analito = configuracion_laboratorio_analito.id_analito 
                                WHERE 
                                    resultado.valor_resultado IS NOT NULL 
                                    AND resultado.valor_resultado != ''
                                    AND lote.nombre_lote = '" . mysql_real_escape_string($lotNombre) . "' 
                                    AND analito.nombre_analito = '" . mysql_real_escape_string($nom_analito_cs) . "' 
                                    AND unidad.nombre_unidad = '" . mysql_real_escape_string($nom_unidad_cs) . "' 
                                    AND resultado.fecha_resultado <= '" . mysql_real_escape_string($fecha_reporte) . "'";

							$qry_participantes_final = $qry_participantes_base;

							// 3. Si hay selecciones personalizadas EN LA DB, modificar la consulta para usarlas
							if ($hay_selecciones_db) {
								$ids_escapados_para_sql = [];
								foreach ($ids_seleccionados_personalizados_db as $id_sel) { // Iterar sobre los IDs de la DB
									if (is_numeric($id_sel)) {
										$ids_escapados_para_sql[] = intval($id_sel);
									}
								}

								if (!empty($ids_escapados_para_sql)) {
									$qry_participantes_final .= " AND resultado.id_resultado IN (" . implode(",", $ids_escapados_para_sql) . ")";
								} else {
									// Si la DB tiene selecciones pero el array está vacío (ej: se deseleccionaron todos),
									// se quiere que no se muestre nada.
									$qry_participantes_final .= " AND 1=0 ";
								}
							}

							// 4. Ejecutar la consulta (base o modificada) y preparar datos para Grubbs/Intercuartil
							$objIntercuartil = new Intercuartil();
							$objGrubbs = new Grubbs();
							$qryArrayFinalConsenso = array(); // Array para los valores numéricos de resultado

							$query_result_participantes = mysql_query($qry_participantes_final);
							mysqlException(mysql_error(), "_01_caso4_modificado");

							if ($query_result_participantes) {
								while ($qryDataConsenso = mysql_fetch_assoc($query_result_participantes)) {

									$valor_original = $qryDataConsenso["resultado"];

									// 1. Verificamos que el campo exista antes de intentar procesarlo
									if (isset($valor_original)) {


										// Forzamos la conversión a flotante. floatval() o (float)
										$valor_procesado = (float) $valor_original;

										if (!empty($valor_original) && is_numeric($valor_procesado)) {

											array_push(
												$qryArrayFinalConsenso,
												array("resultado" => $valor_procesado)
											);
										}
									}
								}
							}



							$objGrubbs->exclusionAtipicos($qryArrayFinalConsenso, "resultado");
							$qryData_participantes = $objGrubbs->getPromediosNormales("resultado");
							// Variables de media de comparacion

							$pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] = "Consenso";

							$pageContent["labconfigurationitems"]["media_estandar"][$x] = $qryData_participantes['mediana'];

							$pageContent["labconfigurationitems"]["mediana"][$x] = $qryData_participantes['mediana'];

							$pageContent["labconfigurationitems"]["iqr"][$x] = $qryData_participantes['iqr'];

							$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] = $qryData_participantes['s'];

							$pageContent["labconfigurationitems"]["coeficiente_variacion"][$x] = $qryData_participantes['cv'];

							$pageContent["labconfigurationitems"]["n_evaluacion"][$x] = $qryData_participantes['n'];

							$pageContent["labconfigurationitems"]["comp"][$x] = $qryData_2['tipo_consenso_wwr'];

							$pageContent["labconfigurationitems"]["nombre_unidad_comp"][$x] = $pageContent["labconfigurationitems"]["nombre_unidad"][$x]; // Si es por participantes QAP de deja la misma unidades

						} else {

							$pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] = "Consenso";

							$pageContent["labconfigurationitems"]["q1"][$x] = $qryData_2['percentil_25'];
							$pageContent["labconfigurationitems"]["q3"][$x] = $qryData_2['percentil_75'];
							$pageContent["labconfigurationitems"]["iqr"][$x] = $qryData_2['percentil_75'] - $qryData_2['percentil_25'];

							$pageContent["labconfigurationitems"]["media_estandar"][$x] = $qryData_2['media_estandar'];

							$pageContent["labconfigurationitems"]["mediana"][$x] = $qryData_2['media_estandar'];

							$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] = ($qryData_2['percentil_75'] - $qryData_2['percentil_25']) * 0.7413;
							$pageContent["labconfigurationitems"]["s"][$x] = ($qryData_2['percentil_75'] - $qryData_2['percentil_25']) * 0.7413;

							$pageContent["labconfigurationitems"]["coeficiente_variacion"][$x] = $qryData_2['coeficiente_variacion'];

							$pageContent["labconfigurationitems"]["n_evaluacion"][$x] = $qryData_2['n_evaluacion'];

							$pageContent["labconfigurationitems"]["comp"][$x] = $qryData_2['tipo_consenso_wwr'];

							$pageContent["labconfigurationitems"]["nombre_unidad_comp"][$x] = $pageContent["labconfigurationitems"]["nombre_unidad"][$x]; // Si es por participantes QAP de deja la misma unidades

						}

						break;

					default:

						// Por defecto se agrega un valor de media acumulada

						$pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] = "Acumulada";

						$pageContent["labconfigurationitems"]["media_estandar"][$x] = $qryData_2['media_estandar'];

						$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] = $qryData_2['desviacion_estandar'];

						$pageContent["labconfigurationitems"]["coeficiente_variacion"][$x] = $qryData_2['coeficiente_variacion'];

						$pageContent["labconfigurationitems"]["n_evaluacion"][$x] = $qryData_2['n_evaluacion'];

						$pageContent["labconfigurationitems"]["comp"][$x] = $qryData_2['tipo_consenso_wwr'];

						$pageContent["labconfigurationitems"]["nombre_unidad_comp"][$x] = $qryData_2['nombre_unidad_mc'];

						break;
				}
			}



			$whichTable = 1;

			$toUseMediaTable = $tbl_media_evaluacion_caso_especial;



			if ($whichTable == 1) {

				$qry = "SELECT $tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $toUseMediaTable INNER JOIN $tbl_analito_resultado_reporte_cualitativo ON $toUseMediaTable.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = (SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_configuracion = " . $configurationids['id_configuracion'][$x] . ") AND id_muestra = $sampleid AND id_laboratorio = $labid LIMIT 0,1";
			} else {

				$qry = "SELECT $tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $toUseMediaTable INNER JOIN $tbl_analito_resultado_reporte_cualitativo ON $toUseMediaTable.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = (SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_configuracion = " . $configurationids['id_configuracion'][$x] . ") AND id_muestra = $sampleid LIMIT 0,1";
			}



			$qryData = mysql_fetch_array(mysql_query($qry));

			mysqlException(mysql_error(), "_08");



			$pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$x] = $qryData['desc_resultado_reporte_cualitativo'];







			if ($filterArray[3] == 1) {

				$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_programa = $programid AND id_analito = " . $configurationids['id_analito'][$x] . " AND id_analizador = " . $configurationids['id_analizador'][$x] . " AND id_metodologia = " . $configurationids['id_metodologia'][$x] . " AND id_reactivo = " . $configurationids['id_reactivo'][$x] . " AND id_unidad = " . $configurationids['id_unidad'][$x] . " AND id_gen_vitros = " . $configurationids['id_gen_vitros'][$x];
			} else if ($filterArray[3] == 2) {

				$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_programa = $programid AND  id_analito = " . $configurationids['id_analito'][$x] . " AND id_reactivo = " . $configurationids['id_reactivo'][$x] . " AND id_unidad = " . $configurationids['id_unidad'][$x] . " AND id_gen_vitros = " . $configurationids['id_gen_vitros'][$x];
			}



			$qryArray = mysql_query($qry);

			mysqlException(mysql_error(), "_08");

			$y = 0;



			while ($qryData = mysql_fetch_array($qryArray)) {



				$qry = "SELECT valor_resultado FROM $tbl_resultado INNER JOIN $tbl_usuario ON $tbl_resultado.id_usuario = $tbl_usuario.id_usuario WHERE id_configuracion = " . $qryData['id_configuracion'] . " AND id_muestra = $sampleid";

				$innerQryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_09");

				$configurationmixedvalues["valor_resultado"][$y] = $innerQryData['valor_resultado'];

				$y++;
			}







			if ($pageContent["labconfigurationitems"]["media_estandar"][$x] == 0 || $pageContent["labconfigurationitems"]["media_estandar"][$x] == "") { // Si la media es 0 ó la media es ""

				// Se iguala al promedio



				// Se iguala a cero

				$pageContent["labconfigurationitems"]["media_estandar"][$x] = "";
			}





			if ($pageContent["labconfigurationitems"]["desviacion_estandar"][$x] == 0 || $pageContent["labconfigurationitems"]["desviacion_estandar"][$x] == "") { // Si la desviación es nula o CERO

				// Se iguala a cero

				$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] = "";
			}



			$configurationmixedvalues["n_evaluacion"][$x] = $pageContent["labconfigurationitems"]["n_evaluacion"][$x];



			if ($filterArray[8] == 1) {

				$configurationmixedvalues["n_evaluacion"][$x] = (sizeof($configurationmixedvalues["valor_resultado"]) + ($pageContent["labconfigurationitems"]["n_evaluacion"][$x]));
			}



			$qry = "SELECT valor_metodo_referencia,nombre_metodologia,nombre_unidad 

				FROM 

					$tbl_valor_metodo_referencia 

					INNER JOIN $tbl_metodologia ON $tbl_valor_metodo_referencia.id_metodologia = $tbl_metodologia.id_metodologia 

					INNER JOIN $tbl_unidad ON $tbl_valor_metodo_referencia.id_unidad = $tbl_unidad.id_unidad 

				WHERE id_analito = " . $configurationids['id_analito'][$x] . " AND id_laboratorio = $labid AND id_muestra = $sampleid AND $tbl_valor_metodo_referencia.id_unidad = " . $configurationids['id_unidad'][$x] . " LIMIT 0,1";



			$qryData = mysql_fetch_array(mysql_query($qry));

			mysqlException(mysql_error(), "_10");



			$pageContent["labconfigurationitems"]["referencemedia"][$x] = $qryData['valor_metodo_referencia'];

			$pageContent["labconfigurationitems"]["referencemetodology"][$x] = $qryData['nombre_metodologia'];

			$pageContent["labconfigurationitems"]["referenceunit"][$x] = $qryData['nombre_unidad'];



			$pageContent["labconfigurationitems"]["jctlmcalification"][$x] = "";



			$qry = "SELECT id_metodo_jctlm, desc_metodo_jctlm FROM $tbl_metodo_jctlm WHERE id_analito = " . $configurationids['id_analito'][$x] . " AND activo = 1 ORDER BY desc_metodo_jctlm ASC";

			$qryArray = mysql_query($qry);

			$qryNumRows = mysql_num_rows($qryArray);

			mysqlException(mysql_error(), "_11");



			$pageContent["labconfigurationitems"]["jctlmmethod"][$x] = array();

			$pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x] = array();



			$tempCheck1 = false;



			$y = 0;



			if ($qryNumRows == 0) {

				//$pageContent["labconfigurationitems"]["jctlmmethod"][$x][$y] = "";				

			} else {



				while ($qryData = mysql_fetch_array($qryArray)) {



					$pageContent["labconfigurationitems"]["jctlmmethod"][$x][$y] = $qryData['desc_metodo_jctlm'];

					$pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x][$y] = $qryData['id_metodo_jctlm'];



					$qry = "SELECT id_conexion FROM $tbl_metodo_jctlm_emparejado WHERE id_metodo_jctlm = " . $qryData['id_metodo_jctlm'] . " AND id_metodologia = " . $configurationids['id_metodologia'][$x] . " LIMIT 0,1";



					$qryNumRows = mysql_num_rows(mysql_query($qry));

					mysqlException(mysql_error(), "_12");



					if ($qryNumRows > 0) {

						$tempCheck1 = true;

						$pageContent["labconfigurationitems"]["jctlmmethod"][$x][$y] .= "|1";
					} else {

						$pageContent["labconfigurationitems"]["jctlmmethod"][$x][$y] .= "|0";
					}



					$y++;
				}
			}



			if ($tempCheck1) {

				$pageContent["labconfigurationitems"]["jctlmcalification"][$x] = "Trazable por metodología";
			}



			$qry = "SELECT id_material_jctlm,desc_material_jctlm FROM $tbl_material_jctlm WHERE id_analito = " . $configurationids['id_analito'][$x] . " AND activo = 1 ORDER BY desc_material_jctlm ASC";

			$qryArray = mysql_query($qry);

			$qryNumRows = mysql_num_rows($qryArray);

			mysqlException(mysql_error(), "_13");



			$pageContent["labconfigurationitems"]["jctlmmaterial"][$x] = array();

			$pageContent["labconfigurationitems"]["id_material_jctlm"][$x] = array();



			$tempCheck2 = false;



			$y = 0;



			if ($qryNumRows == 0) {

				$pageContent["labconfigurationitems"]["jctlmmaterial"][$x][$y] = "";
			} else {

				while ($qryData = mysql_fetch_array($qryArray)) {



					$pageContent["labconfigurationitems"]["jctlmmaterial"][$x][$y] = $qryData['desc_material_jctlm'];

					$pageContent["labconfigurationitems"]["id_material_jctlm"][$x][$y] = $qryData['id_material_jctlm'];



					$qry = "SELECT id_conexion FROM $tbl_material_jctlm_emparejado WHERE id_material_jctlm = " . $qryData['id_material_jctlm'] . " AND id_material = " . $configurationids['id_material'][$x] . " LIMIT 0,1";



					$qryNumRows = mysql_num_rows(mysql_query($qry));

					mysqlException(mysql_error(), "_14");



					if ($qryNumRows > 0) {

						$tempCheck2 = true;

						$pageContent["labconfigurationitems"]["jctlmmaterial"][$x][$y] .= "|1";
					} else {

						$pageContent["labconfigurationitems"]["jctlmmaterial"][$x][$y] .= "|0";
					}



					$y++;
				}
			}



			if ($tempCheck2) {

				if ($pageContent["labconfigurationitems"]["jctlmcalification"][$x] != "") {

					$pageContent["labconfigurationitems"]["jctlmcalification"][$x] .= ", trazable por material";
				} else {

					$pageContent["labconfigurationitems"]["jctlmcalification"][$x] .= "Trazable por material";
				}
			}



			if ($tempCheck1 == false && $tempCheck2 == false) {

				$pageContent["labconfigurationitems"]["jctlmcalification"][$x] = "No trazable";
			}
		}



		if ($pageContent["programtype"] == 1) {

			$qry = "SELECT id_opcion_limite FROM $tbl_opcion_limite ORDER BY id_opcion_limite ASC";

			$qryArray = mysql_query($qry);

			mysqlException(mysql_error(), "_15");



			$x = 0;



			while ($qryData = mysql_fetch_array($qryArray)) {

				$tempValue_8[$x] = $qryData['id_opcion_limite'];

				$x++;
			}



			for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {



				for ($y = 0; $y < sizeof($tempValue_8); $y++) {

					$qry = "SELECT limite,nombre_opcion_limite,$tbl_limite_evaluacion.id_calculo_limite_evaluacion,$tbl_calculo_limite_evaluacion.desc_calculo_limite_evaluacion 

					FROM $tbl_limite_evaluacion 

					INNER JOIN $tbl_opcion_limite 

					ON $tbl_limite_evaluacion.id_opcion_limite = $tbl_opcion_limite.id_opcion_limite 

					LEFT JOIN $tbl_calculo_limite_evaluacion ON $tbl_limite_evaluacion.id_calculo_limite_evaluacion = $tbl_calculo_limite_evaluacion.id_calculo_limite_evaluacion 

					WHERE id_analito = " . $configurationids['id_analito'][$x] . " AND $tbl_limite_evaluacion.id_opcion_limite = $tempValue_8[$y]";

					$checkRows = mysql_num_rows(mysql_query($qry));

					mysqlException(mysql_error(), "_16");



					if ($checkRows > 0) {

						$qryData = mysql_fetch_array(mysql_query($qry));

						if ($qryData['limite'] > 0) {

							$pageContent["labconfigurationitems"]["limitvalue"][$x] = $qryData['limite'];

							$pageContent["labconfigurationitems"]["limitname"][$x] = $qryData['nombre_opcion_limite'];

							$pageContent["labconfigurationitems"]["limitoptionvalue"][$x] = $qryData['id_calculo_limite_evaluacion'];

							$pageContent["labconfigurationitems"]["limitoptionname"][$x] = $qryData['desc_calculo_limite_evaluacion'];

							break 1;
						}
					}
				}



				if (!isset($pageContent["labconfigurationitems"]["limitoptionvalue"][$x])) {

					$pageContent["labconfigurationitems"]["upperLimit"][$x] = 0;

					$pageContent["labconfigurationitems"]["lowerlimit"][$x] = 0;
				}



				switch ($pageContent["labconfigurationitems"]["limitoptionvalue"][$x]) {

					case 2:

					default:

						$pageContent["labconfigurationitems"]["upperLimit"][$x] = round(($pageContent["labconfigurationitems"]["referencemedia"][$x] + $pageContent["labconfigurationitems"]["limitvalue"][$x]), 2);

						$pageContent["labconfigurationitems"]["lowerlimit"][$x] = round(($pageContent["labconfigurationitems"]["referencemedia"][$x] - $pageContent["labconfigurationitems"]["limitvalue"][$x]), 2);

						break;

					case 3:

						$pageContent["labconfigurationitems"]["upperLimit"][$x] = round($pageContent["labconfigurationitems"]["referencemedia"][$x] + ($pageContent["labconfigurationitems"]["limitvalue"][$x] * $pageContent["labconfigurationitems"]["desviacion_estandar"][$x]), 2);

						$pageContent["labconfigurationitems"]["lowerlimit"][$x] = round($pageContent["labconfigurationitems"]["referencemedia"][$x] - ($pageContent["labconfigurationitems"]["limitvalue"][$x] * $pageContent["labconfigurationitems"]["desviacion_estandar"][$x]), 2);

						break;

					case 1:

						$pageContent["labconfigurationitems"]["upperLimit"][$x] = round($pageContent["labconfigurationitems"]["referencemedia"][$x] + (($pageContent["labconfigurationitems"]["limitvalue"][$x] * $pageContent["labconfigurationitems"]["referencemedia"][$x]) / 100), 2);

						$pageContent["labconfigurationitems"]["lowerlimit"][$x] = round($pageContent["labconfigurationitems"]["referencemedia"][$x] - (($pageContent["labconfigurationitems"]["limitvalue"][$x] * $pageContent["labconfigurationitems"]["referencemedia"][$x]) / 100), 2);

						break;
				}
			}
		}



		$qry = "SELECT no_contador FROM $tbl_contador_muestra WHERE id_muestra = $sampleid AND id_ronda = $roundid LIMIT 0,1";

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), "_17");

		$pageContent["programsamplenumber"] = $qryData['no_contador'];



		for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {



			$qry = "SELECT valor_resultado,observacion_resultado,fecha_resultado,nombre_usuario,editado,$tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $tbl_resultado INNER JOIN $tbl_usuario ON $tbl_resultado.id_usuario = $tbl_usuario.id_usuario LEFT JOIN $tbl_analito_resultado_reporte_cualitativo ON $tbl_resultado.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = " . $configurationids["id_configuracion"][$x] . " AND id_muestra = $sampleid";



			$qryData = mysql_fetch_array(mysql_query($qry));

			mysqlException(mysql_error(), "_18_" . $x);



			$qry = "SELECT fecha_reporte FROM $tbl_fecha_reporte_muestra WHERE id_laboratorio = $labid AND id_muestra = $sampleid ORDER BY id_fecha DESC LIMIT 0,1";

			$innerQryData = mysql_fetch_array(mysql_query($qry));

			mysqlException(mysql_error(), "_19_" . $x);



			if (mysql_num_rows(mysql_query($qry)) == 0) {

				$pageContent["labconfigurationitems"]["fecha_resultado"][$x] = $qryData['fecha_resultado'];
			} else {

				$pageContent["labconfigurationitems"]["fecha_resultado"][$x] = $innerQryData['fecha_reporte'];
			}



			$pageContent["labconfigurationitems"]["valor_resultado"][$x] = $qryData['valor_resultado'];

			$pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$x] = $qryData['desc_resultado_reporte_cualitativo'];

			$pageContent["labconfigurationitems"]["observacion_resultado"][$x] = $qryData['observacion_resultado'];

			$pageContent["labconfigurationitems"]["nombre_usuario"][$x] = $qryData['nombre_usuario'];

			$pageContent["labconfigurationitems"]["editado"][$x] = $qryData['editado'];



			$qry = "SELECT $tbl_muestra.id_muestra,$tbl_contador_muestra.no_contador,$tbl_programa.id_programa  FROM $tbl_ronda INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa WHERE $tbl_ronda.id_ronda = $roundid ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";



			$innerQryArray = mysql_query($qry);

			mysqlException(mysql_error(), "_20_" . $x);



			$pageContent["labconfigurationitemsforthewholeround"]["muestra"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["editado"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["fecha_resultado"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["media"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["mediana"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["q1"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["q3"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["tipo_media_consenso"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["tipo_media_comparacion"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["diff"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["media_participantes_qap"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["mediana_participantes_qap"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["s_participantes_qap"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["iqr_participantes_qap"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["de_participantes_qap"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["zscore_robusto_participantes_qap"][$x] = array();

			$pageContent["labconfigurationitemsforthewholeround"]["criterio_zscore_participantes_qap"][$x] = array();



			$y = 0;



			while ($innerQryData = mysql_fetch_array($innerQryArray)) {



				$qry = "SELECT valor_resultado,editado,fecha_resultado,$tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $tbl_resultado INNER JOIN $tbl_usuario ON $tbl_resultado.id_usuario = $tbl_usuario.id_usuario LEFT JOIN $tbl_analito_resultado_reporte_cualitativo ON $tbl_resultado.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = " . $configurationids['id_configuracion'][$x] . " AND id_muestra = " . $innerQryData['id_muestra'];



				$innerQryData_2 = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_21_" . $x);



				$qry = "SELECT fecha_reporte FROM $tbl_fecha_reporte_muestra WHERE id_laboratorio = $labid AND id_muestra = " . $innerQryData['id_muestra'] . " ORDER BY id_fecha DESC LIMIT 0,1";



				$innerQryData_4 = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_22_" . $x);



				if (mysql_num_rows(mysql_query($qry)) == 0) {

					$pageContent["labconfigurationitemsforthewholeround"]["fecha_resultado"][$x][$y] = $innerQryData_2['fecha_resultado'];
				} else {

					$pageContent["labconfigurationitemsforthewholeround"]["fecha_resultado"][$x][$y] = $innerQryData_4['fecha_reporte'];
				}



				$qry = "SELECT valor_metodo_referencia 

						FROM 

							$tbl_valor_metodo_referencia 

							INNER JOIN $tbl_metodologia ON $tbl_valor_metodo_referencia.id_metodologia = $tbl_metodologia.id_metodologia 

							INNER JOIN $tbl_unidad ON $tbl_valor_metodo_referencia.id_unidad = $tbl_unidad.id_unidad 

					WHERE id_analito = " . $configurationids['id_analito'][$x] . " AND id_laboratorio = $labid AND id_muestra = " . $innerQryData['id_muestra'] . " AND $tbl_valor_metodo_referencia.id_unidad = " . $configurationids['id_unidad'][$x] . " LIMIT 0,1";



				$qryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_10");



				$pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] = $qryData['valor_metodo_referencia'];



				$qry = "SELECT fecha_vencimiento FROM $tbl_muestra_programa WHERE id_muestra = " . $innerQryData['id_muestra'];



				$innerQryData_3 = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_23_" . $x);



				$pageContent["labconfigurationitemsforthewholeround"]["fecha_muestra"][$x][$y] = $innerQryData_3['fecha_vencimiento'];





				// Obtencion de nombre del lote de control

				$qry_lote_cs = "SELECT nombre_lote FROM $tbl_lote INNER JOIN $tbl_muestra_programa ON $tbl_lote.id_lote = $tbl_muestra_programa.id_lote WHERE $tbl_muestra_programa.id_muestra = " . $innerQryData['id_muestra'] . " AND $tbl_muestra_programa.id_programa = " . $innerQryData['id_programa'];



				$qryData_lote_cs = mysql_fetch_array(mysql_query($qry_lote_cs));

				mysqlException(mysql_error(), "_05_" . $x);



				$lotNombre_muestra_cs = $qryData_lote_cs['nombre_lote'];

				$nom_analito_cs = $pageContent["labconfigurationitems"]["nombre_analito"][$x];

				$nom_unidad_cs = $pageContent["labconfigurationitems"]["nombre_unidad"][$x];



				/**

																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																														 * Consulta de participantes de QAP

																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																														 */

				$qry_participantes_cs = "SELECT 

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

					and lote.nombre_lote = '" . $lotNombre_muestra_cs . "' 

					and analito.nombre_analito = '" . $nom_analito_cs . "' 

					and unidad.nombre_unidad = '" . $nom_unidad_cs . "'

				";
				$objIntercuartil = new Intercuartil();

				$objGrubbs = new Grubbs();

				$qryArrayFinalConsenso = array();

				$qryArrayParticipantes = mysql_query($qry_participantes_cs);

				mysqlException(mysql_error(), "_01");



				while ($qryDataConsenso = mysql_fetch_array($qryArrayParticipantes)) {

					array_push(

						$qryArrayFinalConsenso,

						array("resultado" => $qryDataConsenso["resultado"])

					);
				}

				//$objIntercuartil->test_intercuartil($qryArrayFinalConsenso, "resultado");

				//$qryData_participantes_cs = $objIntercuartil->getPromediosNormales("resultado");

				$objGrubbs->exclusionAtipicos($qryArrayFinalConsenso, "resultado");

				$qryData_participantes_cs = $objGrubbs->getPromediosNormales("resultado");

				$pageContent["labconfigurationitemsforthewholeround"]["media_participantes_qap"][$x][$y] = $qryData_participantes_cs['media'];

				$pageContent["labconfigurationitemsforthewholeround"]["mediana_participantes_qap"][$x][$y] = $qryData_participantes_cs['mediana'];

				$pageContent["labconfigurationitemsforthewholeround"]["de_participantes_qap"][$x][$y] = $qryData_participantes_cs['de'];

				$pageContent["labconfigurationitemsforthewholeround"]["s_participantes_qap"][$x][$y] = $qryData_participantes_cs['s'];

				$pageContent["labconfigurationitemsforthewholeround"]["iqr_participantes_qap"][$x][$y] = $qryData_participantes_cs['iqr'];

				$pageContent["labconfigurationitemsforthewholeround"]["n_participantes_qap"][$x][$y] = $qryData_participantes_cs['n'];

				$pageContent["labconfigurationitemsforthewholeround"]["muestra"][$x][$y] = $innerQryData['no_contador'];
				$pageContent["labconfigurationitemsforthewholeround"]["id_muestra"][$x][$y] = $innerQryData['id_muestra'];

				$pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] = $innerQryData_2['valor_resultado'];

				$pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y] = $innerQryData_2['desc_resultado_reporte_cualitativo'];

				$pageContent["labconfigurationitemsforthewholeround"]["editado"][$x][$y] = $innerQryData_2['editado'];



				if ($pageContent["programtype"] == 1) {

					// Consulta para obtener el nivel lote

					$qry = "SELECT nivel_lote FROM $tbl_lote INNER JOIN $tbl_muestra_programa ON $tbl_lote.id_lote = $tbl_muestra_programa.id_lote WHERE $tbl_muestra_programa.id_muestra = " . $innerQryData['id_muestra'] . " AND $tbl_muestra_programa.id_programa = $programid";

					$qryData = mysql_fetch_array(mysql_query($qry));

					mysqlException(mysql_error(), "_24_" . $x);

					$innerLotLevel = $qryData['nivel_lote'];
				} else {

					$innerLotLevel = 0;
				}





				// Consulta para obtener la media de mundial

				$qry = "SELECT percentil_25,media_estandar,percentil_75,desviacion_estandar,coeficiente_variacion,tipo_digitacion_wwr, n_evaluacion 

						FROM $tbl_media_evaluacion_caso_especial 

						INNER JOIN $tbl_configuracion_laboratorio_analito ON $tbl_media_evaluacion_caso_especial.id_configuracion = $tbl_configuracion_laboratorio_analito.id_configuracion 

						WHERE $tbl_configuracion_laboratorio_analito.id_configuracion = " . $configurationids['id_configuracion'][$x] . " AND $tbl_media_evaluacion_caso_especial.nivel = $innerLotLevel 

						AND $tbl_media_evaluacion_caso_especial.id_muestra = " . $innerQryData['id_muestra'] . " AND $tbl_media_evaluacion_caso_especial.id_laboratorio = $labid 

						LIMIT 1";

				$qryData_2 = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_26_" . $x);

				if (!empty($qryData_2)) {

					$innerTempValue_1 = $qryData_2['media_estandar'];

					$innerTempValue_2 = $qryData_2['desviacion_estandar'];

					$innerTempValue_4 = $qryData_2['tipo_digitacion_wwr'];

					$innerTempValue_5 = $qryData_2['percentil_25'];

					$innerTempValue_6 = $qryData_2['percentil_75'];
				}



				$toUseMediaTable = $tbl_media_evaluacion_caso_especial;

				$whichTable = 1;

				$pageContent["labconfigurationitemsforthewholeround"]["tipo_media_comparacion"][$x][$y] = $innerTempValue_4;

				$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] = $innerTempValue_1;

				$pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y] = $innerTempValue_2;

				$pageContent["labconfigurationitemsforthewholeround"]["q1"][$x][$y] = $innerTempValue_5;

				$pageContent["labconfigurationitemsforthewholeround"]["q3"][$x][$y] = $innerTempValue_6;

				$pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y] = 10; // Establecer el minimo valor para N;





				// Establecer la semaforización de los Zscore

				if (

					$pageContent["labconfigurationitemsforthewholeround"]["tipo_media_comparacion"][$x][$y] == 4 &&

					(

						$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] == "" &&

						$pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y] == "" &&

						$pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y] == ""

					)

				) { // Si el tipo de media es por CONSENSO (Compatibilidad con la versión 7)

					// N = minimo aceptado

					$pageContent["labconfigurationitemsforthewholeround"]["n_participantes_qap"][$x][$y] = $pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y];



					// Vaciar valores del WWR

					$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] = "";

					$pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y] = "";

					$pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y] = "";
				} else if (

					$pageContent["labconfigurationitemsforthewholeround"]["tipo_media_comparacion"][$x][$y] == 4 &&

					(

						$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] != "" &&

						$pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y] != "" &&

						$pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y] != ""

					)

				) { // Si el tipo de media es por CONSENSO y los valores fueron asignados directamente

					// Consenso QAP igual a WWR

					$pageContent["labconfigurationitemsforthewholeround"]["mediana_participantes_qap"][$x][$y] = $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y];

					$pageContent["labconfigurationitemsforthewholeround"]["iqr_participantes_qap"][$x][$y] = $pageContent["labconfigurationitemsforthewholeround"]["q3"][$x][$y] - $pageContent["labconfigurationitemsforthewholeround"]["q1"][$x][$y];

					$pageContent["labconfigurationitemsforthewholeround"]["s_participantes_qap"][$x][$y] = $pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y];

					$pageContent["labconfigurationitemsforthewholeround"]["n_participantes_qap"][$x][$y] = $pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y];

					// Vaciar valores del WWR

					$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] = "";

					$pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y] = "";

					$pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y] = "";
				}



				// Establecer los valores de Zscore - WWR

				if (

					$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] == "" ||

					$pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y] == "" ||

					$innerQryData_2['valor_resultado'] == ""

					// $innerQryData_2['valor_resultado'] === 0 

					// $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] == 0 || 

					// $pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y] == 0 || 

					// || $pageContent["labconfigurationitemsforthewholeround"]["n"][$x][$y] < 10

				) {

					$pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y] = "";

					$pageContent["labconfigurationitemsforthewholeround"]["diff"][$x][$y] = "";
				} else {

					$pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y] = round((($innerQryData_2['valor_resultado'] - $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y]) / $pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y]), 2);

					$pageContent["labconfigurationitemsforthewholeround"]["diff"][$x][$y] = round(((($innerQryData_2['valor_resultado'] - $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y]) / $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y]) * 100), 2);
				}

				// xxx
				// Establecer los valores de Zscore - Consenso QAP
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
										order by CAST(resultado.valor_resultado AS DECIMAL(10, 2))
									";


				$obgrubbs = new Intercuartil();



				$qryArrayFinalConsenso = array();

				$qryArrayParticipantes = mysql_query($qry_participantes);

				mysqlException(mysql_error(), "_01");



				while ($qryDataConsenso = mysql_fetch_array($qryArrayParticipantes)) {

					array_push(

						$qryArrayFinalConsenso,

						array("resultado" => $qryDataConsenso["resultado"])

					);
				}
				$objIntercuartil->test_intercuartil($qryArrayFinalConsenso, "resultado", false, true);
				$qryData_participantes = $objIntercuartil->getPromediosNormales("resultado");
				$aux = 0;
				if (floatval($pageContent["labconfigurationitemsforthewholeround"]["s_participantes_qap"][$x][$y]) === 0) {

					$pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y] = 0;
				} else if (

					// $pageContent["labconfigurationitemsforthewholeround"]["de_participantes_qap"][$x][$y] == 0 ||

					// $pageContent["labconfigurationitemsforthewholeround"]["media_participantes_qap"][$x][$y] == null ||

					// $pageContent["labconfigurationitemsforthewholeround"]["de_participantes_qap"][$x][$y] == null ||

					$pageContent["labconfigurationitemsforthewholeround"]["mediana_participantes_qap"][$x][$y] == "" ||

					// $pageContent["labconfigurationitemsforthewholeround"]["de_participantes_qap"][$x][$y] == "" ||

					$innerQryData_2['valor_resultado'] == ""

					// $innerQryData_2['valor_resultado'] === 0

					// || $pageContent["labconfigurationitemsforthewholeround"]["n_participantes_qap"][$x][$y] < 10

				) {

					$pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y] = "";
				} else {
					//zscore de la gráfica sección 4

					$pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y] = ($innerQryData_2['valor_resultado'] - $pageContent["labconfigurationitemsforthewholeround"]["mediana_participantes_qap"][$x][$y]) / ($pageContent["labconfigurationitemsforthewholeround"]["iqr_participantes_qap"][$x][$y] * 0.7413);

				}





				if (!isset($pageContent["labconfigurationitems"]["limitoptionvalue"][$x])) {

					$pageContent["labconfigurationitemsforthewholeround"]["upperLimit"][$x][$y] = 0;

					$pageContent["labconfigurationitemsforthewholeround"]["lowerlimit"][$x][$y] = 0;
				}





				/*

																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																														* Consultas para los resultados cualitativos

																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																														*/

				$qry = "SELECT $tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo FROM $toUseMediaTable INNER JOIN $tbl_analito_resultado_reporte_cualitativo ON $toUseMediaTable.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo WHERE id_configuracion = (SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_configuracion = " . $configurationids['id_configuracion'][$x] . ") AND id_muestra = " . $innerQryData['id_muestra'] . " AND id_laboratorio = $labid LIMIT 0,1";

				$qryData = mysql_fetch_array(mysql_query($qry));

				mysqlException(mysql_error(), "_08");

				$pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x][$y] = $qryData['desc_resultado_reporte_cualitativo'];

				if ($filterArray[3] == 1) {

					$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_analito = " . $configurationids['id_analito'][$x] . " AND id_analizador = " . $configurationids['id_analizador'][$x] . " AND id_metodologia = " . $configurationids['id_metodologia'][$x] . " AND id_reactivo = " . $configurationids['id_reactivo'][$x] . " AND id_unidad = " . $configurationids['id_unidad'][$x] . " AND id_gen_vitros = " . $configurationids['id_gen_vitros'][$x];
				} else if ($filterArray[3] == 2) {

					$qry = "SELECT id_configuracion FROM $tbl_configuracion_laboratorio_analito WHERE id_analito = " . $configurationids['id_analito'][$x] . " AND id_reactivo = " . $configurationids['id_reactivo'][$x] . " AND id_unidad = " . $configurationids['id_unidad'][$x] . " AND id_gen_vitros = " . $configurationids['id_gen_vitros'][$x];
				}

				$qryArray = mysql_query($qry);

				mysqlException(mysql_error(), "_27_" . $x);

				$z = 0;

				while ($qryData = mysql_fetch_array($qryArray)) {

					$qry = "SELECT valor_resultado FROM $tbl_resultado INNER JOIN $tbl_usuario ON $tbl_resultado.id_usuario = $tbl_usuario.id_usuario WHERE id_configuracion = " . $qryData['id_configuracion'] . " AND id_muestra = " . $innerQryData['id_muestra'];

					$innerQryData2 = mysql_fetch_array(mysql_query($qry));

					$innertempValue_28[$z] = $innerQryData2['valor_resultado'];

					$z++;
				}





				// Asignación de criterios de Zscore

				switch ($pageContent["programtype"]) {

					case 1: // Para los programas cuantitativos

						if ($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y] === "" || $pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y] === "N/A") {

							$pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$x][$y] = null;
						} else {

							if (abs($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y]) < 2) {

								$pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$x][$y] = 1;

								if ((($y + 1) <= $pageContent["programsamplenumber"])) {

									$pageContent["ammountofsatisfactoryresultsforthewholeround"] += 1;
								}
							} else if (abs($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y]) >= 2 && abs($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y]) < 3) {

								$pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$x][$y] = 2;

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammountofhalfsatisfactoryresultsforthewholeround"] += 1;
								}
							} else if (abs($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y]) >= 3) {

								$pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$x][$y] = 3;

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammountofunsatisfactoryresultsforthewholeround"] += 1;
								}
							}
						}



						// Definir el criterio del z-score para los participantes de QAP Online

						if (

							$pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y] === "" ||

							(

								$pageContent["labconfigurationitemsforthewholeround"]["tipo_media_comparacion"][$x][$y] != 4 &&

								$pageContent["labconfigurationitemsforthewholeround"]["n_participantes_qap"][$x][$y] < 4

							)

						) {

							$pageContent["labconfigurationitemsforthewholeround"]["criterio_zscore_participantes_qap"][$x][$y] = null;

							$pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y] = "";
						} else {

							if (abs($pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y]) < 2) {

								$pageContent["labconfigurationitemsforthewholeround"]["criterio_zscore_participantes_qap"][$x][$y] = 1;

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammountofsatisfactoryparticipantesqap"] += 1;

									$pageContent["ammounttotalofparticipantesqap"] += 1;
								}
							} else if (abs($pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y]) >= 2 && abs($pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y]) < 3) {

								$pageContent["labconfigurationitemsforthewholeround"]["criterio_zscore_participantes_qap"][$x][$y] = 2;

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammountofhalfsatisfactoryparticipantesqap"] += 1;

									$pageContent["ammounttotalofparticipantesqap"] += 1;
								}
							} else if (abs($pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$y]) >= 3) {

								$pageContent["labconfigurationitemsforthewholeround"]["criterio_zscore_participantes_qap"][$x][$y] = 3;

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammountofunsatisfactoryparticipantesqap"] += 1;

									$pageContent["ammounttotalofparticipantesqap"] += 1;
								}
							}
						}

						break;



					case 2: // En dado caso de ser uroanalisis, resumen de la ronda



						if ($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y] == "" || $pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x][$y] == "") {

							$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = null;
						} else {



							// Siempre se va a realizar este conteo para el sonde total de las graficas finales

							if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammounttotalofreportedanalytesmisc"] += 1;
								}
							} else {

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammounttotalofreportedanalytes"] += 1;
								}
							}





							// *********************************

							// Seccion de conteo de aprobaciones

							// *********************************



							if ($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y] == "" || $pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x][$y] == "") {

								$pageContent["labconfigurationitems"]["sampleperformance"][$x] = null;
							} else {



								// La media cualitativo = media de comparación



								// Si la media de comparacion tiene un universal

								if (strpos($pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x][$y], "*")) {



									// Siempre va a ser satisfactorio

									$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 1;



									if (($y + 1) <= $pageContent["programsamplenumber"]) {

										if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

											$pageContent["ammountofsatisfactoryresultsforthewholeroundmisc"] += 1;
										} else {

											$pageContent["ammountofsatisfactoryresultsforthewholeround"] += 1;
										}
									}
								} else {



									if (strpos($pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x][$y], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si contiene un ; en la palabra clave



										$tempCualitativeMedia = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x][$y]); // Media de comparacion temporal



										if ($tempCualitativeMedia[1] != "") { // Si hay un valor minimo y maximo de la media de comparacion

											$lowerLimiter = preg_replace("/[^0-9\.]/", "", $tempCualitativeMedia[0]); // Inferior

											$upperLimiter = preg_replace("/[^0-9\.]/", "", $tempCualitativeMedia[1]); // Superior



											if (strpos($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si el resultado reportado por el laboratorio es un rango



												$tempCualitativeResultado = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y]); // Resultado temporal



												if ($tempCualitativeResultado[1] != "") { // Si hay mínimo y máximo tanto para la media de comparacion y el valor reportado por el laboratorio

													$resultadoMinimo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[0]); // Inferior reportado

													$resultadoMaximo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[1]); // Superior reportado



													if ($resultadoMinimo >= $lowerLimiter && $resultadoMaximo <= $upperLimiter) { // Si el intervalo esta dentro del rango de comparacion



														$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 1;



														if (($y + 1) <= $pageContent["programsamplenumber"]) {

															if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

																$pageContent["ammountofsatisfactoryresultsforthewholeroundmisc"] += 1;
															} else {

																$pageContent["ammountofsatisfactoryresultsforthewholeround"] += 1;
															}
														}
													} else { // Si no es satisfcatorio

														$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 0;



														if (($y + 1) <= $pageContent["programsamplenumber"]) {

															if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

																$pageContent["ammountofunsatisfactoryresultsforthewholeroundmisc"] += 1;
															} else {

																$pageContent["ammountofunsatisfactoryresultsforthewholeround"] += 1;
															}
														}
													}
												} else { // Si el resultado maximo es hasta el infinido y hay un intervalo como comparacion



													$resultadoMinimo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[0]); // Inferior reportado





													// No va a ser satisfactorio por que se salio del rango

													$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 0;



													if (($y + 1) <= $pageContent["programsamplenumber"]) {

														if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

															$pageContent["ammountofunsatisfactoryresultsforthewholeroundmisc"] += 1;
														} else {

															$pageContent["ammountofunsatisfactoryresultsforthewholeround"] += 1;
														}
													}
												}
											} else { // Si el valor reportado por el laboratorio es un unico dato, y hay un intervalo como comparacion



												$tempResult = preg_replace("/[^0-9\.]/", "", $pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y]);



												if ($tempResult >= $lowerLimiter && $tempResult <= $upperLimiter) { // Si es satisfactorio 

													$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 1;



													if (($y + 1) <= $pageContent["programsamplenumber"]) {

														if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

															$pageContent["ammountofsatisfactoryresultsforthewholeroundmisc"] += 1;
														} else {

															$pageContent["ammountofsatisfactoryresultsforthewholeround"] += 1;
														}
													}
												} else { // Si no es satisfcatorio

													$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 0;



													if (($y + 1) <= $pageContent["programsamplenumber"]) {

														if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

															$pageContent["ammountofunsatisfactoryresultsforthewholeroundmisc"] += 1;
														} else {

															$pageContent["ammountofunsatisfactoryresultsforthewholeround"] += 1;
														}
													}
												}
											}
										} else { // Si la media de comparacion va hasta el infinito

											$lowerLimiter = preg_replace("/[^0-9\.]/", "", $tempCualitativeMedia[0]); // Inferior



											// Aqui no importa el resultado maximo reportado por al labotatorio

											$tempCualitativeResultado = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y]); // Resultado temporal

											$resultadoMinimo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[0]); // Inferior reportado



											if ($resultadoMinimo >= $lowerLimiter) { // Es satisfactorio

												$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 1;



												if (($y + 1) <= $pageContent["programsamplenumber"]) {

													if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

														$pageContent["ammountofsatisfactoryresultsforthewholeroundmisc"] += 1;
													} else {

														$pageContent["ammountofsatisfactoryresultsforthewholeround"] += 1;
													}
												}
											} else { // No es satisfactorio



												$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 0;



												if (($y + 1) <= $pageContent["programsamplenumber"]) {

													if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

														$pageContent["ammountofunsatisfactoryresultsforthewholeroundmisc"] += 1;
													} else {

														$pageContent["ammountofunsatisfactoryresultsforthewholeround"] += 1;
													}
												}
											}
										}
									} else { // Si es un valor fijo de comparacion



										if ($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$x][$y] == $pageContent["labconfigurationitemsforthewholeround"]["media_cualitativa"][$x][$y]) {

											$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 1;



											if (($y + 1) <= $pageContent["programsamplenumber"]) {

												if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

													$pageContent["ammountofsatisfactoryresultsforthewholeroundmisc"] += 1;
												} else {

													$pageContent["ammountofsatisfactoryresultsforthewholeround"] += 1;
												}
											}
										} else {

											$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 0;

											if (($y + 1) <= $pageContent["programsamplenumber"]) {

												if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

													$pageContent["ammountofunsatisfactoryresultsforthewholeroundmisc"] += 1;
												} else {

													$pageContent["ammountofunsatisfactoryresultsforthewholeround"] += 1;
												}
											}
										}
									}
								}
							}
						}



						break;
				}



				// Asignación de valores de JTCLM 

				if ($pageContent["programtype"] == 1) { // Si el programa es cuantitativo



					if ($pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] == "" || $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] == 0) {

						$toUseMedia = $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y];
					} else {

						$toUseMedia = $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y];
					}



					switch ($pageContent["labconfigurationitems"]["limitoptionvalue"][$x]) {

						case 2:

						default:

							$pageContent["labconfigurationitemsforthewholeround"]["upperLimit"][$x][$y] = round(($toUseMedia + $pageContent["labconfigurationitems"]["limitvalue"][$x]), 2);

							$pageContent["labconfigurationitemsforthewholeround"]["lowerlimit"][$x][$y] = round(($toUseMedia - $pageContent["labconfigurationitems"]["limitvalue"][$x]), 2);

							break;

						case 3:

							$pageContent["labconfigurationitemsforthewholeround"]["upperLimit"][$x][$y] = round($toUseMedia + ($pageContent["labconfigurationitems"]["limitvalue"][$x] * $pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y]), 2);

							$pageContent["labconfigurationitemsforthewholeround"]["lowerlimit"][$x][$y] = round($toUseMedia - ($pageContent["labconfigurationitems"]["limitvalue"][$x] * $pageContent["labconfigurationitemsforthewholeround"]["de"][$x][$y]), 2);

							break;

						case 1:

							$pageContent["labconfigurationitemsforthewholeround"]["upperLimit"][$x][$y] = round($toUseMedia + (($pageContent["labconfigurationitems"]["limitvalue"][$x] * $toUseMedia) / 100), 2);

							$pageContent["labconfigurationitemsforthewholeround"]["lowerlimit"][$x][$y] = round($toUseMedia - (($pageContent["labconfigurationitems"]["limitvalue"][$x] * $toUseMedia) / 100), 2);

							break;
					}
				}





				// Asignación de valores de media JCTLM

				if (

					($y + 1) > $pageContent["programsamplenumber"] ||

					$innerQryData_2['valor_resultado'] == "" ||

					$innerQryData_2['valor_resultado'] == null ||

					$pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] == "" ||

					$pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] == 0

				) {

					$pageContent["labconfigurationitemsforthewholeround"]["deviationpercentagereference"][$x][$y] = "";
				} else {

					$pageContent["labconfigurationitemsforthewholeround"]["deviationpercentagereference"][$x][$y] = round(((($innerQryData_2['valor_resultado'] - $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y]) * 100) / $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y]), 2);
				}



				if (

					($y + 1) > $pageContent["programsamplenumber"] ||

					$innerQryData_2['valor_resultado'] == "" ||

					$innerQryData_2['valor_resultado'] == null ||

					$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] == null ||

					$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] == 0 ||

					$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] == ""

				) {

					$pageContent["labconfigurationitemsforthewholeround"]["deviationpercentage"][$x][$y] = "";
				} else {

					$pageContent["labconfigurationitemsforthewholeround"]["deviationpercentage"][$x][$y] = round(((($innerQryData_2['valor_resultado'] - $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y]) * 100) / $pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y]), 2);
				}





				// Conteo y asignación de limites de JCTLM

				switch ($pageContent["programtype"]) {

					case 1: // Si el programa es cuantitativo

						if ($pageContent["labconfigurationitemsforthewholeround"]["deviationpercentage"][$x][$y] == "") {

							$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = null;
						} else {

							$pageContent["ammounttotalofreportedanalytes"] += 1;

							if (abs($pageContent["labconfigurationitemsforthewholeround"]["deviationpercentage"][$x][$y]) <= $pageContent["labconfigurationitems"]["limitvalue"][$x]) {

								$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 1;
							} else {

								$pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] = 0;
							}
						}



						if ($pageContent["labconfigurationitemsforthewholeround"]["deviationpercentagereference"][$x][$y] === "") {

							$pageContent["labconfigurationitemsforthewholeround"]["sampleperformancereference"][$x][$y] = null;
						} else {

							if (abs($pageContent["labconfigurationitemsforthewholeround"]["deviationpercentagereference"][$x][$y]) <= $pageContent["labconfigurationitems"]["limitvalue"][$x]) {

								$pageContent["labconfigurationitemsforthewholeround"]["sampleperformancereference"][$x][$y] = 1;

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammountofsatisfactoryreferenceresults"] += 1;
								}
							} else {

								$pageContent["labconfigurationitemsforthewholeround"]["sampleperformancereference"][$x][$y] = 0;

								if (($y + 1) <= $pageContent["programsamplenumber"]) {

									$pageContent["ammountofunsatisfactoryreferenceresults"] += 1;
								}
							}



							$pageContent["ammounttotalofreportedreferenceanalytesforthewholeround"] += 1;
						}



						break;
				}



				$y++;
			}
		}



		for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {



			if (($pageContent["labconfigurationitems"]["valor_resultado"][$x] == "" || $pageContent["labconfigurationitems"]["media_estandar"][$x] == "" || $pageContent["labconfigurationitems"]["desviacion_estandar"][$x] == "") || ($pageContent["labconfigurationitems"]["valor_resultado"][$x] == 0 || $pageContent["labconfigurationitems"]["media_estandar"][$x] == 0 || $pageContent["labconfigurationitems"]["desviacion_estandar"][$x] == 0)) {

				$pageContent["labconfigurationitems"]["zscore"][$x] = "";

				$pageContent["labconfigurationitems"]["diff"][$x] = "";
			} else {

				// Zscore 2. Evaluación con media de comparación
				if ($pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] == "Acumulada" || $pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] == "Inserto" || $pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] == "Mensual") {

					$pageContent["labconfigurationitems"]["zscore"][$x] = (($pageContent["labconfigurationitems"]["valor_resultado"][$x] - $pageContent["labconfigurationitems"]["media_estandar"][$x]) / $pageContent["labconfigurationitems"]["desviacion_estandar"][$x]);
				} else if ($pageContent["labconfigurationitems"]["n_evaluacion"][$x] < 4) {
					$pageContent["labconfigurationitems"]["zscore"][$x] = null;
				} else {
					$pageContent["labconfigurationitems"]["zscore"][$x] = ($pageContent["labconfigurationitems"]["valor_resultado"][$x] - $pageContent["labconfigurationitems"]["mediana"][$x]) / ($pageContent["labconfigurationitems"]["iqr"][$x] * 0.7413);
				}

				$pageContent["labconfigurationitems"]["diff"][$x] = ((($pageContent["labconfigurationitems"]["valor_resultado"][$x] - $pageContent["labconfigurationitems"]["media_estandar"][$x]) / $pageContent["labconfigurationitems"]["media_estandar"][$x]) * 100);
			}

			if (($pageContent["labconfigurationitems"]["valor_resultado"][$x] - $pageContent["labconfigurationitems"]["media_estandar"][$x]) == 0 && $pageContent["labconfigurationitems"]["media_estandar"][$x] != 0) { // Si la media es igual al VRL, colorizar verde

				$pageContent["labconfigurationitems"]["zscoreperformance"][$x] = 1;
			} else if ($pageContent["labconfigurationitems"]["zscore"][$x] == "") {

				$pageContent["labconfigurationitems"]["zscoreperformance"][$x] = null;
			} else {


				if ($pageContent["labconfigurationitems"]["zscore"][$x] == "") {

					$pageContent["labconfigurationitems"]["zscoreperformance"][$x] = null;
				} else if (abs($pageContent["labconfigurationitems"]["zscore"][$x]) < 2) {
					$pageContent["labconfigurationitems"]["zscoreperformance"][$x] = 1;
				} else if (abs($pageContent["labconfigurationitems"]["zscore"][$x]) >= 2 && abs($pageContent["labconfigurationitems"]["zscore"][$x]) < 3) {

					$pageContent["labconfigurationitems"]["zscoreperformance"][$x] = 2;
				} else if (abs($pageContent["labconfigurationitems"]["zscore"][$x]) >= 3) {

					$pageContent["labconfigurationitems"]["zscoreperformance"][$x] = 3;
				} else {

					$pageContent["labconfigurationitems"]["zscoreperformance"][$x] = null;
				}
			}


		}



		for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {



			if (($pageContent["labconfigurationitems"]["media_estandar"][$x] == "" || $pageContent["labconfigurationitems"]["media_estandar"][$x] == 0) || $pageContent["labconfigurationitems"]["valor_resultado"][$x] == "") {

				$pageContent["labconfigurationitems"]["deviationpercentage"][$x] = "";
			} else {



				$pageContent["labconfigurationitems"]["deviationpercentage"][$x] = round(((($pageContent["labconfigurationitems"]["valor_resultado"][$x] - $pageContent["labconfigurationitems"]["media_estandar"][$x]) * 100) / $pageContent["labconfigurationitems"]["media_estandar"][$x]), 2);
			}



			switch ($pageContent["programtype"]) {

				case 1:



					if ($pageContent["labconfigurationitems"]["deviationpercentage"][$x] == "") {

						$pageContent["labconfigurationitems"]["sampleperformance"][$x] = null;
					} else {

						if (abs($pageContent["labconfigurationitems"]["deviationpercentage"][$x]) <= $pageContent["labconfigurationitems"]["limitvalue"][$x]) {

							$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 1;

							$pageContent["ammountofsatisfactoryresults"] += 1;
						} else {

							$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 0;

							$pageContent["ammountofunsatisfactoryresults"] += 1;
						}



						$pageContent["ammountofresultsforcurrentsample"] += 1;
					}



					if (($pageContent["labconfigurationitems"]["referencemedia"][$x] == "" || $pageContent["labconfigurationitems"]["referencemedia"][$x] == 0) || $pageContent["labconfigurationitems"]["valor_resultado"][$x] == "") {

						$pageContent["labconfigurationitems"]["deviationpercentagereference"][$x] = null;
					} else {

						$pageContent["labconfigurationitems"]["deviationpercentagereference"][$x] = round(((($pageContent["labconfigurationitems"]["valor_resultado"][$x] - $pageContent["labconfigurationitems"]["referencemedia"][$x]) * 100) / $pageContent["labconfigurationitems"]["referencemedia"][$x]), 2);
					}



					if ($pageContent["labconfigurationitems"]["deviationpercentagereference"][$x] === null) {

						$pageContent["labconfigurationitems"]["sampleperformancereference"][$x] = null;
					} else {

						if (abs($pageContent["labconfigurationitems"]["deviationpercentagereference"][$x]) <= $pageContent["labconfigurationitems"]["limitvalue"][$x]) {

							$pageContent["labconfigurationitems"]["sampleperformancereference"][$x] = 1;
						} else {

							$pageContent["labconfigurationitems"]["sampleperformancereference"][$x] = 0;
						}
					}



					break;

				case 2: // En dado caso de ser uroanalisis



					if ($pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$x] == "" || $pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$x] == "") {

						$pageContent["labconfigurationitems"]["sampleperformance"][$x] = null;
					} else {



						// La media estantar = media de comparación



						// Si la media de comparacion contiene un simbolo de universal

						if (strpos($pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$x], "*")) {



							// Siempre va a dar satisfactorio

							$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 1;



							if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

								$pageContent["ammountofsatisfactoryresultsmisc"] += 1;

								$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
							} else { // Si es fisicoquimico

								$pageContent["ammountofsatisfactoryresults"] += 1;

								$pageContent["ammountofresultsforcurrentsample"] += 1;
							}
						} else {



							if (strpos($pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$x], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si contiene un ; en la palabra clave



								$tempCualitativeMedia = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$x]); // Media de comparacion temporal



								if ($tempCualitativeMedia[1] != "") { // Si hay un valor minimo y maximo de la media de comparacion

									$lowerLimiter = preg_replace("/[^0-9\.]/", "", $tempCualitativeMedia[0]); // Inferior

									$upperLimiter = preg_replace("/[^0-9\.]/", "", $tempCualitativeMedia[1]); // Superior



									if (strpos($pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$x], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si el resultado reportado por el laboratorio es un rango



										$tempCualitativeResultado = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$x]); // Resultado temporal



										if ($tempCualitativeResultado[1] != "") { // Si hay mínimo y máximo tanto para la media de comparacion y el valor reportado por el laboratorio

											$resultadoMinimo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[0]); // Inferior reportado

											$resultadoMaximo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[1]); // Superior reportado



											if ($resultadoMinimo >= $lowerLimiter && $resultadoMaximo <= $upperLimiter) { // Si el intervalo esta dentro del rango de comparacion



												$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 1;



												if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

													$pageContent["ammountofsatisfactoryresultsmisc"] += 1;

													$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
												} else { // Si es fisicoquimico

													$pageContent["ammountofsatisfactoryresults"] += 1;

													$pageContent["ammountofresultsforcurrentsample"] += 1;
												}
											} else { // Si no es satisfcatorio

												$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 0;



												if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

													$pageContent["ammountofunsatisfactoryresultsmisc"] += 1;

													$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
												} else { // Si es fisicoquimico

													$pageContent["ammountofunsatisfactoryresults"] += 1;

													$pageContent["ammountofresultsforcurrentsample"] += 1;
												}
											}
										} else { // Si el resultado maximo es hasta el infinido y hay un intervalo como comparacion



											$resultadoMinimo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[0]); // Inferior reportado





											// No va a ser satisfactorio por que se salio del rango

											$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 0;



											if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

												$pageContent["ammountofunsatisfactoryresultsmisc"] += 1;

												$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
											} else { // Si es fisicoquimico

												$pageContent["ammountofunsatisfactoryresults"] += 1;

												$pageContent["ammountofresultsforcurrentsample"] += 1;
											}
										}
									} else { // Si el valor reportado por el laboratorio es un unico dato, y hay un intervalo como comparacion



										$tempResult = preg_replace("/[^0-9\.]/", "", $pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$x]);



										if ($tempResult >= $lowerLimiter && $tempResult <= $upperLimiter) { // Si es satisfactorio 

											$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 1;



											if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

												$pageContent["ammountofsatisfactoryresultsmisc"] += 1;

												$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
											} else { // Si es fisicoquimico

												$pageContent["ammountofsatisfactoryresults"] += 1;

												$pageContent["ammountofresultsforcurrentsample"] += 1;
											}
										} else { // Si no es satisfcatorio

											$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 0;



											if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

												$pageContent["ammountofunsatisfactoryresultsmisc"] += 1;

												$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
											} else { // Si es fisicoquimico

												$pageContent["ammountofunsatisfactoryresults"] += 1;

												$pageContent["ammountofresultsforcurrentsample"] += 1;
											}
										}
									}
								} else { // Si la media de comparacion va hasta el infinito

									$lowerLimiter = preg_replace("/[^0-9\.]/", "", $tempCualitativeMedia[0]); // Inferior



									// Aqui no importa el resultado maximo reportado por al labotatorio

									$tempCualitativeResultado = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$x]); // Resultado temporal

									$resultadoMinimo = preg_replace("/[^0-9\.]/", "", $tempCualitativeResultado[0]); // Inferior reportado



									if ($resultadoMinimo >= $lowerLimiter) { // Es satisfactorio

										$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 1;



										if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

											$pageContent["ammountofsatisfactoryresultsmisc"] += 1;

											$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
										} else { // Si es fisicoquimico

											$pageContent["ammountofsatisfactoryresults"] += 1;

											$pageContent["ammountofresultsforcurrentsample"] += 1;
										}
									} else { // No es satisfactorio



										$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 0;



										if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) { // Si es microscopico

											$pageContent["ammountofunsatisfactoryresultsmisc"] += 1;

											$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
										} else { // Si es fisicoquimico

											$pageContent["ammountofunsatisfactoryresults"] += 1;

											$pageContent["ammountofresultsforcurrentsample"] += 1;
										}
									}
								}
							} else { // Si es un valor fijo de comparacion



								if ($pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$x] == $pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$x]) {

									$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 1;



									if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

										$pageContent["ammountofsatisfactoryresultsmisc"] += 1;

										$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
									} else {

										$pageContent["ammountofsatisfactoryresults"] += 1;

										$pageContent["ammountofresultsforcurrentsample"] += 1;
									}
								} else {

									$pageContent["labconfigurationitems"]["sampleperformance"][$x] = 0;

									$pageContent["ammountofunsatisfactoryresults"] += 1;



									if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$x]))) {

										$pageContent["ammountofunsatisfactoryresultsmisc"] += 1;

										$pageContent["ammountofresultsforcurrentsamplemisc"] += 1;
									} else {

										$pageContent["ammountofunsatisfactoryresults"] += 1;

										$pageContent["ammountofresultsforcurrentsample"] += 1;
									}
								}
							}
						}
					}



					break;
			}
		}



		$qry = "SELECT fecha_reporte FROM $tbl_fecha_reporte_muestra WHERE id_laboratorio = $labid AND id_muestra = $sampleid ORDER BY id_fecha DESC LIMIT 0,1";

		$qryData = mysql_fetch_array(mysql_query($qry));

		mysqlException(mysql_error(), "_28");



		if (mysql_num_rows(mysql_query($qry)) == 0) {

			$pageContent["labresultsdate"] = $pageContent["reportdayofgeneration"] . "/" . $pageContent["reportmonthofgeneration"] . "/" . $pageContent["reportyearofgeneration"];
		} else {

			$pageContent["labresultsdate"] = $qryData['fecha_reporte'];
		}



		$qry = "SELECT desc_tipo_estado_reporte FROM $tbl_tipo_estado_reporte WHERE id_tipo_estado_reporte = $reportstatusid";

		$qryData = mysql_fetch_array(mysql_query($qry));



		$pageContent["reportstatus"] = $qryData['desc_tipo_estado_reporte'];



		$pageContent["reportidoriginal"] = $pageContent["programinitials"] . "-" . $pageContent["labnumber"] . "-" . $pageContent["programroundnumber"] . "-" . $pageContent["programsamplenumber"];



		$qry = "SELECT DISTINCT id_analizador,nombre_analizador FROM $tbl_analizador WHERE id_analizador IN (" . implode(",", $pageContent["labconfigurationitems"]["id_analizador"]) . ") ORDER BY nombre_analizador ASC";

		$qryArray = mysql_query($qry);



		$x = 0;



		while ($qryData = mysql_fetch_array($qryArray)) {



			$pageContent["separatedanalyzerid"][$x] = $qryData['id_analizador'];

			$pageContent["separatedanalyzername"][$x] = $qryData['nombre_analizador'];

			$x++;
		}



		$comentaries = 0;



		for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {

			if ($pageContent["labconfigurationitems"]["observacion_resultado"][$x] != '') {

				$comentaries += 1;
			}
		}


		$resultadosRepository = new ResultadosRepository();
		$mediaEspecialRepo = new MediaEvaluacionEspecialRepository();


		$filtroIntercuartilicoFabrica = new FiltroIntercuartilicoFabrica();
		$filtroGrubbsFabrica = new FiltroGrubbsFabrica();


		$controllerMediaDeComparacionTodosLosParticipantes = new MediaDeComparacionController();
		$controllerMediaDeComparacionTodosLosParticipantes->setPrograma($programid);
		$controllerMediaDeComparacionTodosLosParticipantes->setLabolatorio($labid);
		$controllerMediaDeComparacionTodosLosParticipantes->setResultadosRepo($resultadosRepository);
		$controllerMediaDeComparacionTodosLosParticipantes->setMediaEvaluacionRepo($mediaEspecialRepo);

		$fabricaTodoslosParticipantes = new TodosParticipantesFabrica($resultadosRepository);
		$controllerMediaDeComparacionTodosLosParticipantes->setObtenedorResultadosFabrica($fabricaTodoslosParticipantes);

		$calculadorMediaConFilrosAtipicosTodosParticipantes = new CalculadorMediaConFiltrosAtipicosEstrategia();
		$calculadorMediaConFilrosAtipicosTodosParticipantes->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaConFilrosAtipicosTodosParticipantes->setIdPrograma($programid);
		$calculadorMediaConFilrosAtipicosTodosParticipantes->setObtenedorResultadosFabrica($fabricaTodoslosParticipantes);


		$calculadorMediaCasoEspecialTodos = new CalculadorMediaCasoEspecialEstrategiaDecorador($calculadorMediaConFilrosAtipicosTodosParticipantes);
		$calculadorMediaCasoEspecialTodos->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaCasoEspecialTodos->setIdLaboratorio($labid);
		$calculadorMediaCasoEspecialTodos->setIdPrograma($programid);
		$calculadorMediaCasoEspecialTodos->setObtenedorResultadosFabrica($fabricaTodoslosParticipantes);
		$calculadorMediaCasoEspecialTodos->setMediaEvaluacionRepo($mediaEspecialRepo);

		$controllerMediaDeComparacionTodosLosParticipantes->setCalculadorEstrategia($calculadorMediaCasoEspecialTodos);

		//para misma metodologia
		$controllerMediaDeComparacioParticipantesMismaMetodologia = new MediaDeComparacionController();
		$controllerMediaDeComparacioParticipantesMismaMetodologia->setPrograma($programid);
		$controllerMediaDeComparacioParticipantesMismaMetodologia->setLabolatorio($labid);
		$controllerMediaDeComparacioParticipantesMismaMetodologia->setResultadosRepo($resultadosRepository);
		$controllerMediaDeComparacioParticipantesMismaMetodologia->setMediaEvaluacionRepo($mediaEspecialRepo);

		$fabricaParticipantesMismaMetodologia = new ParticipantesMismaMetodologiaFabrica($resultadosRepository);
		$controllerMediaDeComparacioParticipantesMismaMetodologia->setObtenedorResultadosFabrica($fabricaParticipantesMismaMetodologia);

		$calculadorMediaConFilrosAtipicosMisma = new CalculadorMediaConFiltrosAtipicosEstrategia();
		$calculadorMediaConFilrosAtipicosMisma->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaConFilrosAtipicosMisma->setIdPrograma($programid);
		$calculadorMediaConFilrosAtipicosMisma->setObtenedorResultadosFabrica($fabricaParticipantesMismaMetodologia);


		$calculadorMediaCasoEspecialMisma = new CalculadorMediaCasoEspecialEstrategiaDecorador($calculadorMediaConFilrosAtipicosMisma);
		$calculadorMediaCasoEspecialMisma->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaCasoEspecialMisma->setIdLaboratorio($labid);
		$calculadorMediaCasoEspecialMisma->setIdPrograma($programid);
		$calculadorMediaCasoEspecialMisma->setObtenedorResultadosFabrica($fabricaParticipantesMismaMetodologia);
		$calculadorMediaCasoEspecialMisma->setMediaEvaluacionRepo($mediaEspecialRepo);

		$controllerMediaDeComparacioParticipantesMismaMetodologia->setCalculadorEstrategia($calculadorMediaConFilrosAtipicosMisma);
		if ($fechaCorte === NULL || $fechaCorte === '' || $fechaCorte === 'NULL') {
			// Consulta para obtener todos los muestra_id y su última fecha_reporte para el laboratorio actual
			$qry_todas_las_fechas_laboratorio = "SELECT id_muestra, MAX(fecha_reporte) AS fecha_reporte
												FROM `fecha_reporte_muestra`
												WHERE id_laboratorio = '" . mysql_real_escape_string($labid) . "'
												GROUP BY id_muestra";
			$result_todas_las_fechas = mysql_query($qry_todas_las_fechas_laboratorio);
			mysqlException(mysql_error(), "_ALL_FECHAS_MUESTRAS_LAB_");

			// Popula $fechasMuestras con todas las fechas de reporte para el laboratorio
			while ($row_fecha_lab = mysql_fetch_assoc($result_todas_las_fechas)) {
				if (!empty($row_fecha_lab['id_muestra']) && !empty($row_fecha_lab['fecha_reporte'])) {
					$fechasMuestras[$row_fecha_lab['id_muestra']] = $row_fecha_lab['fecha_reporte'];
				}
			}
			$fabricaTodoslosParticipantes->setFechaCorte($fechasMuestras);
			$fabricaParticipantesMismaMetodologia->setFechaCorte($fechasMuestras);


		} else if ($fechaCorte !== null && strlen($fechaCorte) >= 4) {
			$fechasMuestras = base64_decode($fechaCorte);
			$fechasMuestras = json_decode($fechasMuestras, true);
			$fabricaTodoslosParticipantes->setFechaCorte($fechasMuestras);
			$fabricaParticipantesMismaMetodologia->setFechaCorte($fechasMuestras);
		}

		$controllerMediaDeComparacionTodosLosParticipantes->establecerResultadosAnalitosMuestras($roundid);
		$controllerMediaDeComparacioParticipantesMismaMetodologia->establecerResultadosAnalitosMuestras($roundid);

		$indicadoresGenerales = $controllerMediaDeComparacionTodosLosParticipantes->calcularIndicadoresSatisfacionHastaMuestra($sampleid);
		$indicadoresGeneralesMisma = $controllerMediaDeComparacioParticipantesMismaMetodologia->calcularIndicadoresSatisfacionHastaMuestra($sampleid);
		//echo "<pre>";
		//print_r($controllerMediaDeComparacionTodosLosParticipantes->getCalculosAnalitos());
		//exit;
		//var_dump($indicadoresGenerales);
		//exit;
		break;
}



?>



<!DOCTYPE html>

<html lang="es">

<head>

	<meta charset="utf-8">

	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link href="boostrap/css/bootstrap.min.css?v12" rel="stylesheet" media="screen">

	<link href="css/jquery-ui.min.css?v12" rel="stylesheet" media="screen">

	<link href="css/pagina.css?v12" rel="stylesheet" media="screen">

</head>

<body onload="initialize();" class="transparent-body">



	<?php



	echo '<input type="text" id="filenameInput" value="' . trim($pageContent["labnumber"]) . '-' . trim($pageContent["programinitials"]) . '-R' . trim($pageContent["programroundnumber"]) . '-MX' . trim($pageContent["programsamplenumber"]) . '-' . trim($pageContent["programsample"]) . '" hidden="hidden"/>';

	echo '<input type="text" id="autoPdfValue" value="' . $filterArray[9] . '" hidden="hidden"/>';

	echo '<input type="text" id="reportid1" value="' . $pageContent["reportidoriginal"] . '" hidden="hidden"/>';

	echo '<input type="text" id="reportid2" value="' . $pageContent["reportidupdated"] . '" hidden="hidden"/>';

	echo '<input type="text" id="labid" value="' . $labid . '" hidden="hidden"/>';

	echo '<input type="text" id="programtype" value="' . $pageContent["programtype"] . '" hidden="hidden"/>';



	?>



	<div id="workbook" style="height: 93.5vh; max-height: 93.5vh; overflow: hidden; display:none;">



		<?php

		$switch_logo = $pageContent["programinitials"] . " - " . $pageContent["programname"];
		switch ($switch_logo) {
			case 'QAP-C - Coagulación':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_C.PNG' alt='OK' height='30' width='200'></img></div>";
				break;
			case 'QAP-H - Hematología':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_H.PNG' alt='OK' height='30' width='200'></img></div>";
				break;
			case 'QAP-I - Inmunoensayo':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_I.PNG' alt='OK' height='30' width='180'></img></div>";
				break;

			default:
				# code...
				break;
			case 'QAP-Hb - Hemoglobina':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_HB.PNG' alt='OK' height='30' width='180'></img></div>";
				break;

			case 'QAP-MT - Marcadores Tumorales':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_MT.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-PP - Proteínas plasmáticas':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_PP.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-Q - Química sanguínea':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_Q.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-QU - Química urinaria':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_QU.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-U - Uroanálisis':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_U.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-POCT - Glucosa':
				$pageContent["logo_prog"] = "<div style='display: flex; justify-content: center;'><img src='css/etiquetas/QAP_POCT_ GLU.PNG' alt='OK' height='30' width='180'></img></div>";

				break;
			case 'QAP-POCT - Hcg':
				$pageContent["logo_prog"] = "<div style='text-align: justify;'><img src='css/etiquetas/QAP_QU.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-GAS - Gases':
				$pageContent["logo_prog"] = "<div style='text-align: justify;'><img src='css/etiquetas/QAP-GAS.png' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-MC - Marcadores Cardiacos':
				$pageContent["logo_prog"] = "<div style='text-align: justify;'><img src='css/etiquetas/QAP-MC.png' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP POCT-I - QAP POCT Infecciosas':
				$pageContent["logo_prog"] = "<div style='text-align: justify;'><img src='css/etiquetas/QAP_POCT_ INFECCIOSAS.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-INF - Infecciosas':
				$pageContent["logo_prog"] = "<div style='text-align: justify;'><img src='css/etiquetas/QAP-INF.png' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP POCT - Glu - Glucosa':
				$pageContent["logo_prog"] = "<div style='text-align: justify;'><img src='css/etiquetas/QAP_POCT_ GLU.PNG' alt='OK' height='30' width='180'></img></div>";
				break;
			case 'QAP-DD - D-Dímero':
				$pageContent["logo_prog"] = "<div style='text-align: justify;'><img src='css/etiquetas/QAP-Dimero.jpg' alt='OK' height='30' width='180'></img></div>";
		}


		echo "<div class='col margin-top-2 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";


		tablePrinter('headerPortada', '1. PORTADA');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');


		echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";



		echo "<tbody>";

		echo "<tr style='background-color: white;'>";

		echo "<td style='width: 48%;'></td>";

		echo "<td style='width: 2%; border-right:1px solid #21618C'></td>";

		echo "<td style='width: 2%; border-left:1px solid #21618C'></td>";

		echo "<td style='font-size:11px;width: 48%;' rowspan='3'>

							<strong style='color:#21618C;'>" . mb_strtoupper($pageContent["labname"], "utf-8") . "</strong> <br>

							Correo electrónico: " . $pageContent["labemail"] . " <br>

							Dirección: " . $pageContent["labaddress"] . "<br>

							Ciudad: " . $pageContent["labcity"] . " <br>

							País: " . $pageContent["labcountry"] . " <br>

							Contacto: " . $pageContent["labcontact"] . " <br>

							Teléfono: " . $pageContent["labphone"] . " <br>

						</td>";

		echo "</tr>";

		echo "<tr style='background-color: white;'>";

		echo "<td style='width: 48%;'></td>";

		echo "<td style='width: 2%; border-right:1px solid #21618C'></td>";

		echo "<td style='width: 2%; border-left:1px solid #21618C'></td>";

		echo "</tr>";

		echo "<tr style='background-color: white;'>";

		echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_text_bold"] . ";width: 48%;'>

							<span style='font-size: 11pt;'>PROGRAMA DE ASEGURAMIENTO DE CALIDAD</span><br>

							<span style='color:#21618C; text-decoration: underline; font-size: 11pt;'>" . $pageContent["programinitials"] . " - " . $pageContent["programname"] . "</span>

						</td>";

		echo "<td style='width: 2%; border-right:1px solid #21618C'></td>";

		echo "<td style='width: 2%; border-left:1px solid #21618C'></td>";

		echo "<td style='width: 48%;'></td>";

		echo "</tr>";



		setlocale(LC_ALL, "es_CO.UTF-8", "es_CO", "esp");

		$d = $pageContent["reportyearofgeneration"] . '-' . $pageContent["reportmonthofgeneration"] . '-' . $pageContent["reportdayofgeneration"];



		echo "<tr style='background-color: white;'>";

		echo "<td style='width: 48%;'></td>";

		echo "<td style='width: 2%; border-right:1px solid #21618C'></td>";

		echo "<td style='width: 2%; border-left:1px solid #21618C'></td>";

		echo "<td style='font-size:11px;width: 48%;' rowspan='3'>

							<strong style='color:#21618C;'>IDENTIFICACIÓN DEL LABORATORIO: " . $pageContent["labnumber"] . " </strong><br>

							Código de reporte: " . $pageContent["reportidoriginal"] . " <br>

							Ronda: " . $pageContent["programroundnumber"] . "<br>

							Muestra: " . $pageContent["programsamplenumber"] . "<br>

							Código de la muestra: " . $pageContent["programsample"] . " <br>

							Tipo de muestra: " . $pageContent["programsampletype"] . " <br>

							Fecha generación: " . strftime("%d / %B / %Y", strtotime($d)) . " <br><br>

					</td>";

		echo "</tr>";





		echo "<tr style='background-color: white;'>";

		echo "<td style='width: 48%;'></td>";

		echo "<td style='width: 2%; border-right:1px solid #21618C'></td>";

		echo "<td style='width: 2%; border-left:1px solid #21618C'></td>";

		echo "</tr>";





		echo "<tr style='background-color: white;'>";

		echo "<td style='width: 48%;'></td>";

		echo "<td style='width: 2%; border-right:1px solid #21618C'></td>";

		echo "<td style='width: 2%; border-left:1px solid #21618C'></td>";

		echo "</tr>";





		echo "</tbody>";

		echo '</table>';



		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');

		echo "</div>";



		echo "<!-- sheet separator -->";



		echo "<div class='col margin-top-2 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

		tablePrinter('header2', '1. TÉRMINOS GENERALES', $labid, $sampleid);

		echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

		echo "<tbody>";

		echo "<tr>";

		echo "<td style='" . $pageContent["tablestyle_border_left"] . "width: 2%;'>&nbsp;</td>";

		echo "<td style='width: 96%; font-family: Times New Roman, Georgia, Helvetica !important;" . $pageContent["tablestyle_text_justify"] . "font-size:10pt;' >



							<br>



							<strong>Confidencialidad:</strong><br><br>



							Quik SAS es una organización certificada bajo los estándares internacionales de la ISO 9001:2015 <sup>1</sup>, ISO 14001:2015 <sup>2</sup>, ISO 45001:2018 <sup>3</sup> y en cumplimiento al numeral 4.10 de ISO 17043:2010 <sup>4</sup>, garantiza la confidencialidad del presente reporte. La divulgación del presente informe se realizará únicamente al contacto autorizado por cada laboratorio. En caso de que la autoridad competente requiera información contenida en los reportes, será comunicado al participante involucrado con autorización expresa del mismo.<br><br>

							

							(1)	Sistema de gestión de calidad (SGC) <br>

							(2)	Sistema de gestión ambiental (SGA) <br>

							(3) Sistema de gestión de seguridad y salud en el trabajo (SGSST)<br>

							(4) Requisitos generales para los ensayos de aptitud<br><br>



							<strong>Homogeneidad y estabilidad:</strong><br><br>

							Quik SAS certifica la homogeneidad y estabilidad suficiente de los ítems incluidos en los ensayos a través de una rigurosa selección de los materiales de cada programa, garantizando las condiciones adecuadas en la cadena de transporte y a través de verificaciones con métodos estadísticos.Los detalles de preparación y manejo del control se encuentran en el inserto de cada programa.<br><br>

							

							<strong>Subcontrataciones:</strong><br><br>
							

							La planificación, el diseño estadístico, la operación y la generación de los informes son realizados por Quik SAS. Los materiales utilizados para los programas de laboratorio clínico son contratados con Bio-Rad Laboratories Inc.
                            
                            Los valores asignados de la sección 3 se obtienen de laboratorios clínicos con metodologías o materiales de referencia trazables al” Joint Committee for Traceability in Laboratory Medicine” (JCTLM).<br>						

							<br><strong>Diseño de los programas QAP: </strong><br><br>
							
							Los programas QAP LC están compuestos por rondas de acuerdo con la frecuencia establecida para cada programa. Las matrices utilizadas con conmutables con las muestras de las pacientes procesadas en la cotidianidad del laboratorio. El valor asignado se obtiene a partir de una comparación interlaboratorios a nivel internacional, el consenso QAP y/o un laboratorio con material o metodología de referencia trazable al JCTLM.<br><br>
	
                            <strong>Cálculos para el análisis estadístico cuando la media de comparación es internacional o es método trazable a material y/o avalado por el JCTLM </strong><br><br>
                            <strong>Formula Desviación Estándar:</strong><br>
                            <img src='css/images/Formula D.E.png' alt='Fórmula D.E' height='38'></img><br>
                            <strong>Formula Media:</strong><br>
                            <img src='css/images/Formula media.png' alt='Fórmula media' height='32'></img><br>
                            <strong>Formula Zscore:</strong><br><br>
                            <img src='css/images/Formula zcore.png' alt='Fórmula zcore' height='36'></img><br>
							<strong>Formula Incertidumbre:</strong><br>
                            <img src='css/images/Formula incertidumbre.png' alt='Formula incertidumbre' height='22'></img>


						</td>";


		echo "<td style='" . $pageContent["tablestyle_border_right"] . "width: 2%;'>&nbsp;</td>";

		echo "</tr>";



		echo "<td colspan='3' style='" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_bottom"] . "; width: 100%;'>&nbsp;</td>";



		echo "</tbody>";

		echo "</table>";

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');



		echo "<div class='col margin-top-2 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

		tablePrinter('header2', '1. TÉRMINOS GENERALES', $labid, $sampleid);

		echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

		echo "<tbody>";

		echo "<tr>";

		echo "<td style='" . $pageContent["tablestyle_border_left"] . "width: 2%;'>&nbsp;</td>";


		echo "<td style='width: 96%; font-family: Times New Roman, Georgia, Helvetica !important;" . $pageContent["tablestyle_text_justify"] . "font-size:10pt;' >


							<br><br><strong>Definiciones y cálculos para el análisis estadístico cuando la media de comparación es por consenso: </strong>
							<ul>
								<li>Resultado del laboratorio (u): Valor informado por un laboratorio participante en un ensayo de aptitud.</li>
								<li>Mediana: Valor central de los datos ordenados. Se emplea como estimador robusto del valor asignado.</li>
								<li>Rango intercuartílico (IQR): Diferencia entre el tercer y primer cuartil. Delimita el rango que contiene el 50% central de los datos, excluyendo valores atípicos. </li><br>
								<img src='css/images/Formula IQR.png' alt='Formula IQR' height='23'></img>
								<li>Desviación estándar robusta (s*): Estimación de la desviación estándar basada en el IQR.</li><br>
								<img src='css/images/Formula s.png' alt='Formula desviación estandar robusta' height='38'></img>
							</ul>
							<strong>Z-Score Robusto: </strong><br>
							<img src='css/images/Formula zscore robusto.png' alt='Fórmula zscore robusto' height='35'></img><br>
							<img src='css/images/Descripcion z robusta.png' alt='Fórmula zscore robusto' height='62'></img><br>
							<strong>Incertidumbre del valor asignado: </strong><br>
							<img src='css/images/Formula incertidumbre robusta.png' alt='Fórmula incertidumbre valor asignado' height='40'></img><br>
							<img src='css/images/Descripcion incertidumbre robusta.png' alt='Fórmula incertidumbre valor asignado' height='77'></img><br>

						</td>";

		echo "<td style='" . $pageContent["tablestyle_border_right"] . "width: 2%;'>&nbsp;</td>";

		echo "</tr>";

		echo "<tr>";

		echo "<td colspan='3' style='" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_bottom"] . "; width: 100%;'>&nbsp;</td>";

		echo "</tr>";

		echo "</tbody>";

		echo "</table>";

		tablePrinter('br', 'no_border');

		tablePrinter('br', 'no_border');



		echo "</div>";



		echo "<!-- sheet separator -->";



		switch ($pageContent["programtype"]) {

			case 1:



				$itemCounter = 0;



				echo "<div class='col margin-top-2 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

				tablePrinter('header2', '2. EVALUACIÓN CON MEDIA DE COMPARACIÓN', $labid, $sampleid);

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;'>";

				echo "<tbody>";



				echo "<tr style='font-size: 5pt'>

									<th style='font-weight:bold;text-align:center; width: 4%;'>1</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>2</th>

									<th style='font-weight:bold;text-align:center; width: 17.5%'>3</th>

									<th style='font-weight:bold;text-align:center; width: 12.5%'>4</th>

									<th style='font-weight:bold;text-align:center; width: 12.5%'>5</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>6</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>7</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>8</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>9</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>10</th>

									<th style='font-weight:bold;text-align:center; width: 5.5%'>11</th>

									<th style='font-weight:bold;text-align:center; width: 4%'>12</th>

									<th style='font-weight:bold;text-align:center; width: 7%'>13</th>

									<th style='font-weight:bold;text-align:center; width: 7%'>14</th>

								</tr>";



				echo "<tr style='font-size: 8px;font-weight: bold;'>";

				echo "<th style='4%;" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>IT<br></th>";

				echo "<th style='5%;" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>NOT<br></th>";

				echo "<th style='17.5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "' >Mensurando<br></th>";

				echo "<th style='12.5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Analizador<br></th>";

				echo "<th style='12.5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Método<br></th>";

				echo "<th style='5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>VRL<br></th>";

				echo "<th style='5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>U-LAB<br></th>";

				echo "<th style='5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>M-C<br></th>";

				echo "<th style='5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>U-MC<br></th>";

				echo "<th style='5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>DE-C<br></th>";

				echo "<th style='5.5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>T-C<br></th>";

				echo "<th style='4%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Z<br></th>";

				echo "<th style='7%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>VAL<br></th>";

				echo "<th style='7%;" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>COMP<br></th>";

				echo "</tr>";



				$count_alts = 0;

				for ($x = 0; $x < sizeof($configurationids["id_analito"]); $x++) {





					if ($pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter] != "") { // Si el laboratorio reporto
		




						$count_alts++;

						if ((($count_alts + 1) % 2) == 0) {

							$trBackgroundColor = "white";
						} else {

							$trBackgroundColor = "#f2f2f2";
						}



						if (!isset($configurationids["id_analito"][$itemCounter])) {



							echo "<tr style='background-color:" . $trBackgroundColor . ";'>";

							echo "<td style='width: 4%;" . $pageContent["tablestyle_height1"] . $pageContent["tablestyle_border_left"] . "'>&nbsp;</td>";

							echo "<td style='width: 5%;'>&nbsp;</td>";

							echo "<td style='width: 17.5%;'>&nbsp;</td>";

							echo "<td style='width: 12.5%;'>&nbsp;</td>";

							echo "<td style='width: 12.5%;'>&nbsp;</td>";

							echo "<td style='width: 5%;'>&nbsp;</td>";

							echo "<td style='width: 5%;'>&nbsp;</td>";

							echo "<td style='width: 5%;'>&nbsp;</td>";

							echo "<td style='width: 5%;'>&nbsp;</td>";

							echo "<td style='width: 5%;'>&nbsp;</td>";

							echo "<td style='width: 5.5%;'>&nbsp;</td>";

							echo "<td style='width: 4%;'>&nbsp;</td>";

							echo "<td style='width: 7%;'>&nbsp;</td>";

							echo "<td style='width: 7%;" . $pageContent["tablestyle_border_right"] . "'>&nbsp;</td>";

							echo "</tr>";
						} else {



							echo "<tr style='background-color:" . $trBackgroundColor . ";font-size: 6px;text-align:center;'>";



							$badge = "";



							if ($pageContent["labconfigurationitems"]["fecha_resultado"][$itemCounter] == "" || $pageContent["programsampleexpirationdate"] == "") { // Si hay no existe una fecha de referencia, o es una fecha igual a la actual
		


							} else {

								if (strtotime($pageContent["labconfigurationitems"]["fecha_resultado"][$itemCounter]) > strtotime($pageContent["programsampleexpirationdate"])) { // Si la fecha de la ejecución de la muestra es superior a la de la fecha de vencimiento de la misma
		
									if ($filterArray[5]) {

										$badge = $badge . "<span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span>";
									}
								}
							}





							if ($pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter] == "") { // Si no se reporto nada frente a una muestra
		
								if ($filterArray[6]) {

									$badge = $badge . "<span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span>";
								}
							}

							if ($pageContent["labconfigurationitems"]["editado"][$itemCounter] == 1) { // Si fue editado el resultado del analito
		
								if ($filterArray[7]) {

									$badge = $badge . "<span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span>";
								}
							}



							echo "<td style='width:4%;" . $pageContent["tablestyle_height1"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>" . ($count_alts) . "</td>";

							echo "<td style='width:5%;" . $pageContent["tablestyle_text_center"] . " font-family:Wingdings'>" . $badge . "</td>";





							// Colorización del mensurando según su rendimiento de Zscore
		
							if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] == 1) { // Verde
		
								echo "<td style='width:17.5%;" . $pageContent["tablestyle_text_center"] . "background-color:#afffaf;'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter] . "</td>";
							} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] == 2) { // Amarillo 
		
								echo "<td style='width:17.5%;" . $pageContent["tablestyle_text_center"] . "background-color:#ffff7d;'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter] . "</td>";
							} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] == 3) { // Rojo
		
								echo "<td style='width:17.5%;" . $pageContent["tablestyle_text_center"] . "background-color:#ff7d7d;'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter] . "</td>";
							} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] === null) {

								echo "<td style='width:17.5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter] . "</td>";
							}

							if ($pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter] == "Consenso" && $pageContent["labconfigurationitems"]["n_evaluacion"][$itemCounter] < 4) {
								// Nombre del analizador
								echo "<td>" . $pageContent["labconfigurationitems"]["nombre_analizador"][$itemCounter] . "</td>";
								// Nombre de la métodología (método)
								echo "<td>" . $pageContent["labconfigurationitems"]["nombre_metodologia"][$itemCounter] . "</td>";
								// Valor de resultado reportado por el laboratorio
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . (($pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter] == "") ? "N/A" : $pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter]) . "</td>";
								// Unidad laboratorio
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_unidad"][$itemCounter] . "</td>";
								// Media del grupo de comparación (media estándar)
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . "N/A" . "</td>";
								// Unidad de la media de comparación
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . "N/A" . "</td>";
								// D.E. grupo de comparación
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . "N/A" . "</td>";
								// tipo de consenso
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . (($pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter] == "") ? "N/A" : $pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter]) . "</td>";
								// 2. Evaluación con media de comparación (repetida)
								// Z-score
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . "N/A" . "</td>";

							} else {
								// Nombre del analizador
								echo "<td>" . $pageContent["labconfigurationitems"]["nombre_analizador"][$itemCounter] . "</td>";
								// Nombre de la métodología (método)
								echo "<td>" . $pageContent["labconfigurationitems"]["nombre_metodologia"][$itemCounter] . "</td>";
								// Valor de resultado reportado por el laboratorio
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . (($pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter] == "") ? "N/A" : $pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter]) . "</td>";
								// Unidad laboratorio
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_unidad"][$itemCounter] . "</td>";
								// Media del grupo de comparación (media estándar)
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . (($pageContent["labconfigurationitems"]["media_estandar"][$itemCounter] == "") ? "N/A" : round($pageContent["labconfigurationitems"]["media_estandar"][$itemCounter], 2)) . "</td>";
								// Unidad de la media de comparación
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . ((isset($pageContent["labconfigurationitems"]["nombre_unidad_comp"][$itemCounter])) ? $pageContent["labconfigurationitems"]["nombre_unidad_comp"][$itemCounter] : "N/A") . "</td>";
								// D.E. grupo de comparación
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . (($pageContent["labconfigurationitems"]["desviacion_estandar"][$itemCounter] == "") ? "0" : round($pageContent["labconfigurationitems"]["desviacion_estandar"][$itemCounter], 2)) . "</td>";
								// tipo de consenso
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . (($pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter] == "") ? "N/A" : $pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter]) . "</td>";
								// 2. Evaluación con media de comparación (repetida)
								// Z-score
								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . (($pageContent["labconfigurationitems"]["zscore"][$itemCounter] === "") ? "0" : round($pageContent["labconfigurationitems"]["zscore"][$itemCounter], 2)) . "</td>";
							}


							// Rendimiento de la variable Z-score 
		
							if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] == 1) {

								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>Satisfactorio</td>";
							} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] == 2) {

								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>Alarma</td>";
							} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] == 3) {

								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>No satisfactorio</td>";
							} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$itemCounter] === null) {

								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";
							}



							$id_analito_digitado = ((isset($pageContent["labconfigurationitems"]["id_digitacion_wwr"][$itemCounter])) ? $pageContent["labconfigurationitems"]["id_digitacion_wwr"][$itemCounter] : 0);



							// Obtener el nombre del analizador con el que se realizó la digitación
		
							$qry_nom_analizador = "SELECT

													analizador.nombre_analizador,

													metodologia.nombre_metodologia

												from 

													digitacion_cuantitativa

													join analizador on analizador.id_analizador = digitacion_cuantitativa.id_analizador

													join metodologia on metodologia.id_metodologia = digitacion_cuantitativa.id_metodologia

												where id_digitacion_cuantitativa = '" . $id_analito_digitado . "'";



							$qryDataArrayAnalizador = mysql_fetch_array(mysql_query($qry_nom_analizador));

							mysqlException(mysql_error(), "_01");



							// Si la media de comparación es por unity (mensual o acumulada)
		
							if ($pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter] == "Acumulada" || $pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter] == "Mensual" || $pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter] == "Inserto") {

								// Verificar ahora si es grupo par o método
		
								if (

									strtoupper(trim($qryDataArrayAnalizador["nombre_analizador"])) == strtoupper(trim($pageContent["labconfigurationitems"]["nombre_analizador"][$itemCounter])) &&

									strtoupper(trim($qryDataArrayAnalizador["nombre_metodologia"])) == strtoupper(trim($pageContent["labconfigurationitems"]["nombre_metodologia"][$itemCounter]))

								) { // Si el nombre del equipo es N/A o método
		
									echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'>Par</td>";
								} else if (

									(

										$qryDataArrayAnalizador["nombre_analizador"] == "N/A" ||

										$qryDataArrayAnalizador["nombre_analizador"] == "n/a" ||

										$qryDataArrayAnalizador["nombre_analizador"] == "N/A " ||

										$qryDataArrayAnalizador["nombre_analizador"] == "n/a " ||

										$qryDataArrayAnalizador["nombre_analizador"] == "Método" ||

										$qryDataArrayAnalizador["nombre_analizador"] == "MÉTODO" ||

										$qryDataArrayAnalizador["nombre_analizador"] == "método" ||

										$qryDataArrayAnalizador["nombre_analizador"] == "metodo"

									)

									&&

									(strtoupper(trim($qryDataArrayAnalizador["nombre_metodologia"])) == strtoupper(trim($pageContent["labconfigurationitems"]["nombre_metodologia"][$itemCounter])))

								) { // Si la metodologia es la misma del mensurando y su equipo no aplica: grupo metodo
		
									echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'>Método</td>";
								} else {

									echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'>Todos los laboratorios</td>";
								}
							} else if ($pageContent["labconfigurationitems"]["tipo_media_estandar"][$itemCounter] == "Consenso") {

								echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'>Todos los laboratorios</td>";
							} else {

								echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'>Par</td>";
							}

							echo "</tr>";
						}
					}

					$itemCounter++;
				}



				echo "</tbody>";

				echo "</table>";

				tablePrinter('tableend', 'null');

				tablePrinter('br', 'no_border');



				echo "<table>";

				echo "<tr style='font-size: 6pt;'>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:20%;'><strong>IT:</strong> Ítem</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:20%;'><strong>NOT:</strong> Notificaciones</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:20%;'><strong>VRL:</strong> Valor reportado por el laboratorio</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:20%;'><strong>U-LAB:</strong> Unidades de laboratorio</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:20%;'><strong>U-MC:</strong> Unidades Originales de la media de comparación</td>";

				echo "</tr>";



				echo "<tr style='font-size: 6pt;'>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:16.666%;'><strong>M-C:</strong> Media del grupo de comparación</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:16.666%;'><strong>DE-C:</strong> Desviación estándar del grupo de comparación</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:16.666%;'><strong>T-C:</strong> Tipo de consenso</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:16.666%;'><strong>Zs:</strong> Z-score</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:16.666%;'><strong>VAL:</strong> Valoración</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:16.666%;'><strong>COMP:</strong> Comparador</td>";

				echo "</tr>";

				echo "</table>";



				tablePrinter('br', 'no_border');



				tablePrinter('tablenotifications', 'notification3');

				tablePrinter('br', 'no_border');

				echo "</div>";



				echo "<!-- sheet separator -->";



				break;

			case 2:



				$repeat = true;

				$maxRows = 10;

				$maxRowsHolder = $maxRows;

				$maxRows2 = 3;

				$maxRowsHolder2 = $maxRows2;

				$itemCounter = 0;

				$itemCounter2 = 0;

				$finishTable = true;



				while ($repeat) {



					$maxRows = $maxRowsHolder;

					$maxRows2 = $maxRowsHolder2;

					$tempCounter1 = 0;

					$tempCounter2 = 0;

					$finishTable = true;



					echo "<div class='col margin-top-2 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

					tablePrinter('header2', '2. INFORME DE EVALUACIÓN DE LA MUESTRA', $labid, $sampleid);

					tablePrinter('header3', '2.1. INFORME FÍSICO QUÍMICO');

					echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

					echo "<tbody>";



					echo "<tr style='font-size: 5pt'>

									<th style='font-weight:bold;text-align:center;'>1</th>

									<th style='font-weight:bold;text-align:center;'>2</th>

									<th style='font-weight:bold;text-align:center;'>3</th>

									<th style='font-weight:bold;text-align:center;'>4</th>

									<th style='font-weight:bold;text-align:center;'>5</th>

									<th style='font-weight:bold;text-align:center;'>6</th>

									<th style='font-weight:bold;text-align:center;'>7</th>

									<th style='font-weight:bold;text-align:center;'>8</th>

									<th style='font-weight:bold;text-align:center;'>9</th>

								</tr>";



					echo "<tr style='font-size: 8px'>";

					echo "<th style='" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>Ítem</th>";

					echo "<th style='" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>Notificaciones</th>";

					echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Mensurando</th>";

					echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Analizador</th>";

					echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Método</th>";

					echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Su resultado</th>";

					echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Referencia</th>";

					echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Desempeño</th>";

					echo "<th style='" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>Evaluación</th>";

					echo "</tr>";



					for ($x = $itemCounter; $x < sizeof($configurationids["id_analito"]); $x++) {



						if ((($x + 1) % 2) == 0) {

							$trBackgroundColor = "white";
						} else {

							$trBackgroundColor = "#f2f2f2";
						}



						if (isset($configurationids["id_analito"][$itemCounter])) {



							if (!preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$itemCounter]))) {

								echo "<tr style='background-color:" . $trBackgroundColor . ";font-size: 7px;'>";



								$badge = "";



								if ($pageContent["labconfigurationitems"]["fecha_resultado"][$itemCounter] == "" || $pageContent["programsampleexpirationdate"] == "") {

									//
		
								} else {

									if (strtotime($pageContent["labconfigurationitems"]["fecha_resultado"][$itemCounter]) > strtotime($pageContent["programsampleexpirationdate"])) {

										if ($filterArray[5]) {

											$badge = $badge . "<span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span>";
										}
									}
								}

								if ($pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter] == "") {

									if ($filterArray[6]) {

										$badge = $badge . "<span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span>";
									}
								}

								if ($pageContent["labconfigurationitems"]["editado"][$itemCounter] == 1) {

									if ($filterArray[7]) {

										$badge = $badge . "<span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span>";
									}
								}







								echo "<td style='" . $pageContent["tablestyle_height1"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>" . ($itemCounter + 1) . "</td>";

								echo "<td style='" . $pageContent["tablestyle_text_center"] . " font-family:Wingdings'>" . $badge . "</td>";

								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter] . "</td>";

								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_analizador"][$itemCounter] . "</td>";

								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_metodologia"][$itemCounter] . "</td>";





								$textoSeparador = "";



								if (strpos($pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si tiene el separador
		
									$arrayIntervalo = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter]);



									if ($arrayIntervalo[1] != "") {

										$textoSeparador = $arrayIntervalo[0] . " hasta " . $arrayIntervalo[1];
									} else {

										$textoSeparador = $arrayIntervalo[0] . " o más";
									}
								} else {

									$textoSeparador = $pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter];
								}



								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $textoSeparador . "</td>";





								$textoSeparador = "";





								if (strpos($pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$itemCounter], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si tiene el separador
		
									$arrayIntervalo = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$itemCounter]);



									if ($arrayIntervalo[1] != "") {

										$textoSeparador = $arrayIntervalo[0] . " hasta " . $arrayIntervalo[1];
									} else {

										$textoSeparador = $arrayIntervalo[0] . " o más";
									}
								} else {

									$textoSeparador = $pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$itemCounter];
								}



								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $textoSeparador . "</td>";



								if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter] === 0) {

									echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_text_size_10"] . "'>No satisfactorio</td>";
								} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter] == 1) {

									echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_text_size_10"] . "'>Satisfactorio</td>";
								} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter] === null) {

									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
								}



								if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter] === 0) {

									echo "<td style='background-color:#ff7d7d;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'><img src='css/wrong_icon.png' alt='X' height='20' width='20'></img></td>";
								} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter] == 1) {

									echo "<td style='background-color:#afffaf;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'><img src='css/check_icon.png' alt='OK' height='20' width='20'></img></td>";
								} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter] === null) {

									echo "<td style='" . $pageContent["tablestyle_border_right"] . "'>&nbsp;</td>";
								}



								echo "</tr>";



								$tempCounter1++;
							}
						}



						if ($tempCounter1 == $maxRows && sizeof($configurationids["id_analito"]) != ($tempCounter1 + $maxRows2)) {



							$maxRows = 17;

							$finishTable = false;



							if ($tempCounter1 == 17) {

								break;
							}
						}



						$itemCounter++;
					}



					for ($x = $tempCounter1; $x < $maxRows; $x++) {



						if ((($x + 1) % 2) == 0) {

							$trBackgroundColor = "white";
						} else {

							$trBackgroundColor = "#f2f2f2";
						}



						echo "<tr style='background-color:" . $trBackgroundColor . ";'>";

						echo "<td style='" . $pageContent["tablestyle_height1"] . $pageContent["tablestyle_border_left"] . "'>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td style='" . $pageContent["tablestyle_border_right"] . "'>&nbsp;</td>";

						echo "</tr>";
					}



					echo "</tbody>";

					echo "</table>";

					tablePrinter('tableend', 'null');

					tablePrinter('br', 'no_border');



					if ($finishTable) {



						echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

						echo "<tfoot>";

						echo "<tr style='font-size: 8px;'>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_background_color"] . "'>Puntaje</th>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["ammountofsatisfactoryresults"] . " / " . $pageContent["ammountofresultsforcurrentsample"] . "</th>";

						echo "<th>&nbsp;</th>";

						echo "<th>&nbsp;</th>";

						echo "</tr>";

						echo "<tr style='font-size: 8px;'>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_background_color"] . "'>% Concordancia</th>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>" . ($pageContent["ammountofresultsforcurrentsample"] == 0 ? "" : round($pageContent["ammountofsatisfactoryresults"] * 100 / $pageContent["ammountofresultsforcurrentsample"])) . "%</th>";

						echo "<th>&nbsp;</th>";

						echo "<th>&nbsp;</th>";

						echo "</tr>";

						echo "</tfoot>";

						echo "</table>";

						tablePrinter('br', 'no_border');



						echo "</div>";



						echo "<!-- sheet separator -->";



						echo "<div class='col margin-top-2 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";



						tablePrinter('header2', '2. INFORME DE EVALUACIÓN DE LA MUESTRA', $labid, $sampleid);

						tablePrinter('header3', '2.2. INFORME ANÁLISIS MICROSCÓPICO/SEDIMENTO URINARIO');

						echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

						echo "<tbody>";



						echo "<tr style='font-size: 5pt'>

										<th style='font-weight:bold;text-align:center;'>1</th>

										<th style='font-weight:bold;text-align:center;'>2</th>

										<th style='font-weight:bold;text-align:center;'>3</th>

										<th style='font-weight:bold;text-align:center;'>4</th>

										<th style='font-weight:bold;text-align:center;'>5</th>

										<th style='font-weight:bold;text-align:center;'>6</th>

										<th style='font-weight:bold;text-align:center;'>7</th>

										<th style='font-weight:bold;text-align:center;'>8</th>

										<th style='font-weight:bold;text-align:center;'>9</th>

									</tr>";



						echo "<tr style='font-size:8px;font-weight:bold;'>";

						echo "<th style='" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>Ítem</th>";

						echo "<th style='" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>Notificaciones</th>";

						echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Mensurando</th>";

						echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Analizador</th>";

						echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Método</th>";

						echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Su resultado</th>";

						echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Referencia</th>";

						echo "<th style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_bottom"] . "'>Desempeño</th>";

						echo "<th style='" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "'>Evaluación</th>";

						echo "</tr>";



						for ($x = $itemCounter2; $x < sizeof($configurationids["id_analito"]); $x++) {



							if ((($x + 1) % 2) == 0) {

								$trBackgroundColor = "white";
							} else {

								$trBackgroundColor = "#f2f2f2";
							}



							if (isset($configurationids["id_analito"][$itemCounter2])) {



								if (preg_match("/micros/i", strtolower($pageContent["labconfigurationitems"]["nombre_analizador"][$itemCounter2]))) {

									echo "<tr style='background-color:" . $trBackgroundColor . ";font-size:7px'>";



									$badge = "";



									if ($pageContent["labconfigurationitems"]["fecha_resultado"][$itemCounter2] == "" || $pageContent["programsampleexpirationdate"] == "") {

										//
		
									} else {

										if (strtotime($pageContent["labconfigurationitems"]["fecha_resultado"][$itemCounter2]) > strtotime($pageContent["programsampleexpirationdate"])) {

											if ($filterArray[5]) {

												$badge = $badge . "<span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span>";
											}
										}
									}

									if ($pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter2] == "") {

										if ($filterArray[6]) {

											$badge = $badge . "<span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span>";
										}
									}

									if ($pageContent["labconfigurationitems"]["editado"][$itemCounter2] == 1) {

										if ($filterArray[7]) {

											$badge = $badge . "<span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span>";
										}
									}



									echo "<td style='" . $pageContent["tablestyle_height1"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>" . ($itemCounter2 + 1) . "</td>";

									echo "<td style='" . $pageContent["tablestyle_text_center"] . " font-family:Wingdings'>" . $badge . "</td>";

									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter2] . "</td>";

									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_analizador"][$itemCounter2] . "</td>";

									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_metodologia"][$itemCounter2] . "</td>";



									$textoSeparador = "";



									if (strpos($pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter2], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si tiene el separador
		
										$arrayIntervalo = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter2]);



										if ($arrayIntervalo[1] != "") {

											$textoSeparador = $arrayIntervalo[0] . " hasta " . $arrayIntervalo[1];
										} else {

											$textoSeparador = $arrayIntervalo[0] . " o más";
										}
									} else {

										$textoSeparador = $pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$itemCounter2];
									}



									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $textoSeparador . "</td>";





									$textoSeparador = "";



									if (strpos($pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$itemCounter2], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si tiene el separador
		
										$arrayIntervalo = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$itemCounter2]);



										if ($arrayIntervalo[1] != "") {

											$textoSeparador = $arrayIntervalo[0] . " hasta " . $arrayIntervalo[1];
										} else {

											$textoSeparador = $arrayIntervalo[0] . " o más";
										}
									} else {

										$textoSeparador = $pageContent["labconfigurationitems"]["media_estandar_cualitativa"][$itemCounter2];
									}



									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $textoSeparador . "</td>";



									if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter2] === 0) {

										echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_text_size_10"] . "'>No satisfactorio</td>";
									} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter2] == 1) {

										echo "<td style='" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_text_size_10"] . "'>Satisfactorio</td>";
									} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter2] === null) {

										echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
									}



									if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter2] === 0) {

										echo "<td style='background-color:#ff7d7d;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'><img src='css/wrong_icon.png' alt='X' height='20' width='20'></img></td>";
									} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter2] == 1) {

										echo "<td style='background-color:#afffaf;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_border_right"] . "'><img src='css/check_icon.png' alt='OK' height='20' width='20'></img></td>";
									} else if ($pageContent["labconfigurationitems"]["sampleperformance"][$itemCounter2] === null) {

										echo "<td style='" . $pageContent["tablestyle_border_right"] . "'>&nbsp;</td>";
									}



									echo "</tr>";



									$tempCounter2++;
								}
							}



							if (($tempCounter2 == $maxRows2 && isset($configurationids["id_analito"][$itemCounter + 1])) || ($tempCounter1 == $maxRows && sizeof($configurationids["id_analito"]) == ($tempCounter2))) {

								$repeat = true;

								break;
							} else {

								$repeat = false;
							}



							$itemCounter2++;
						}



						for ($x = $tempCounter2; $x < $maxRows2; $x++) {



							if ((($x + 1) % 2) == 0) {

								$trBackgroundColor = "white";
							} else {

								$trBackgroundColor = "#f2f2f2";
							}



							echo "<tr style='background-color:" . $trBackgroundColor . ";'>";

							echo "<td style='" . $pageContent["tablestyle_height1"] . $pageContent["tablestyle_border_left"] . "'>&nbsp;</td>";

							echo "<td>&nbsp;</td>";

							echo "<td>&nbsp;</td>";

							echo "<td>&nbsp;</td>";

							echo "<td>&nbsp;</td>";

							echo "<td>&nbsp;</td>";

							echo "<td>&nbsp;</td>";

							echo "<td>&nbsp;</td>";

							echo "<td style='" . $pageContent["tablestyle_border_right"] . "'>&nbsp;</td>";

							echo "</tr>";
						}



						echo "</tbody>";

						echo "</table>";

						tablePrinter('tableend', 'null');

						tablePrinter('br', 'no_border');

						echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

						echo "<tfoot>";

						echo "<tr style='font-size:8px;'>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_background_color"] . "'>Puntaje</th>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["ammountofsatisfactoryresultsmisc"] . " / " . $pageContent["ammountofresultsforcurrentsamplemisc"] . "</th>";

						echo "<th>&nbsp;</th>";

						echo "<th>&nbsp;</th>";

						echo "</tr>";

						echo "<tr style='font-size:8px;'>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_background_color"] . "'>% Concordancia</th>";

						echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>" . ($pageContent["ammountofresultsforcurrentsamplemisc"] == 0 ? "" : round($pageContent["ammountofsatisfactoryresultsmisc"] * 100 / $pageContent["ammountofresultsforcurrentsamplemisc"])) . "%</th>";

						echo "<th>&nbsp;</th>";

						echo "<th>&nbsp;</th>";

						echo "</tr>";

						echo "</tfoot>";

						echo "</table>";

						tablePrinter('br', 'no_border');
					}



					tablePrinter('tablenotifications', 'null');

					tablePrinter('br', 'no_border');

					// tablePrinter('footer',0);						
		
					echo "</div>";



					echo "<!-- sheet separator -->";



					$itemCounter++;

					$itemCounter2++;
				}



				break;
		}



		switch ($pageContent["programtype"]) {

			case 1:

				$itemCounter = 0;

				echo "<div class='col margin-top-1 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

				tablePrinter('header2', '3. EVALUACIÓN CON VALOR OBTENIDO CON EL MÉTODO TRAZABLE A MATERIAL Y/O MÉTODO AVALADO POR EL JCTLM', $labid, $sampleid);

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;'>";

				echo "<thead>";



				echo "<tr style='font-size: 5pt'>

									<th style='font-weight:bold;text-align:center; width: 5%;'>1</th>

									<th style='font-weight:bold;text-align:center; width: 17.5%'>2</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>3</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>4</th>

									<th style='font-weight:bold;text-align:center; width: 5%'>5</th>

									<th style='font-weight:bold;text-align:center; width: 10%'>6</th>

									<th style='font-weight:bold;text-align:center; width: 15%'>7</th>

									<th style='font-weight:bold;text-align:center; width: 7.5%'>8</th>

									<th style='font-weight:bold;text-align:center; width: 7.5%'>9</th>

									<th style='font-weight:bold;text-align:center; width: 15%'>10</th>

									<th style='font-weight:bold;text-align:center; width: 7.5%'>11</th>

								</tr>";



				echo "<tr style='font-size: 8px;'>";

				echo "<th style='font-weight:bold;width:5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>Ítem<br></th>";

				echo "<th style='font-weight:bold;width:17.5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>Mensurando<br></th>";

				echo "<th style='font-weight:bold;width:5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>VRL<br></th>";

				echo "<th style='font-weight:bold;width:5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>U-LAB<br></th>";

				echo "<th style='font-weight:bold;width:5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>X<sub>pt</sub></sub><br></th>";

				echo "<th style='font-weight:bold;width:10%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>U-X<sub>pt</sub><br></th>";

				echo "<th style='font-weight:bold;width:15%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>M-REF<br></th>";

				echo "<th style='font-weight:bold;width:7.5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>D%<br></th>";

				echo "<th style='font-weight:bold;width:7.5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>ETmp/APS<br></th>";

				echo "<th style='font-weight:bold;width:15%;" . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='1' colspan='2'>Límites aceptación</th>";

				echo "<th style='font-weight:bold;width:7.5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>Valoración<br></th>";

				echo "</tr>";

				echo "<tr style='font-size: 8px;'>";

				echo "<th style='font-weight:bold;width:7.5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "' rowspan='1'>Bajo<br></th>";

				echo "<th style='font-weight:bold;width:7.5%;" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_text_center"] . "' rowspan='1'>Alto<br></th>";

				echo "</tr>";

				echo "</thead>";

				echo "<tbody>";

				$tempCounter = 0;



				for ($x = $itemCounter; $x < sizeof($configurationids["id_analito"]); $x++) {



					if ($pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter] != "") { // Si esta definido el valor reportado por el laboratorio
		


						if ((($tempCounter + 1) % 2) == 0) {

							$trBackgroundColor = "white";
						} else {

							$trBackgroundColor = "#f2f2f2";
						}



						if (isset($pageContent["labconfigurationitems"]["referencemedia"][$itemCounter])) {



							echo "<tr style='background-color:" . $trBackgroundColor . ";font-size: 7px; text-align: center;'>";



							echo "<td style='width:5%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_height1"] . $pageContent["tablestyle_border_left"] . "'>" . ($tempCounter + 1) . "</td>";

							echo "<td style='width:17.5%;" . $pageContent["tablestyle_text_left"] . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter] . "</td>";

							echo "<td style='width:5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["valor_resultado"][$itemCounter] . "</td>";

							echo "<td style='width:5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_unidad"][$itemCounter] . "</td>";

							echo "<td style='width:5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["referencemedia"][$itemCounter] . "</td>";

							echo "<td style='width:10%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["referenceunit"][$itemCounter] . "</td>";

							echo "<td style='width:15%;font-size: 6px;'>Ver sección 5: Informe de trazabilidad metrológica</td>";

							echo "<td style='width:7.5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["deviationpercentagereference"][$itemCounter] . "</td>";

							echo "<td style='width:7.5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["limitvalue"][$itemCounter] . "</td>";

							echo "<td style='width:7.5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["lowerlimit"][$itemCounter] . "</td>";

							echo "<td style='width:7.5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["upperLimit"][$itemCounter] . "</td>";



							if ($pageContent["labconfigurationitems"]["sampleperformancereference"][$itemCounter] === 0) {

								echo "<td style='font-size:7px;width:7.5%;" . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_text_center"] . " background-color: #ff7d7d;'>No satisfactorio</td>";
							} else if ($pageContent["labconfigurationitems"]["sampleperformancereference"][$itemCounter] == 1) {

								echo "<td style='font-size:7px;width:7.5%;" . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_text_center"] . " background-color: #afffaf;'>Satisfactorio</td>";
							} else if ($pageContent["labconfigurationitems"]["sampleperformancereference"][$itemCounter] === null) {

								echo "<td style='font-size:7px;width:7.5%;" . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
							}



							echo "</tr>";



							$pageContent["ammounttotalofreportedreferenceanalytes"] += 1;

							$tempCounter++;
						}
					}

					$itemCounter++;
				}



				echo "</tbody>";

				echo "</table>";

				tablePrinter('tableend', 'null');

				tablePrinter('br', 'no_border');



				echo "<table>";

				echo "<tr style='font-size: 6pt;'>";



				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:50%;'><strong>VRL:</strong> Valor reportado por el laboratorio</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:50%;'><strong>U-Xpt:</strong> Unidades del valor aceptado como verdadero</td>";

				echo "</tr>";



				echo "<tr style='font-size: 6pt;'>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:33.33%;'><strong>U-LAB:</strong> Unidades de laboratorio</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:33.33%;'><strong>M-REF:</strong>Método de referencia</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . ";width:33.33%;'><strong>D%</strong> Diferencia porcentual %</td>";

				echo "</tr>";

				echo "</table>";



				tablePrinter('br', 'no_border');

				tablePrinter('tablenotifications', 'notification1');

				tablePrinter('br', 'no_border');

				echo "</div>";



				echo "<!-- sheet separator -->";



				break;
		}



		switch ($pageContent["programtype"]) {

			case 1:



				$analitRowCounter = 0;

				$maxanalitrowcounter = 2;


				$zscoreintercuartil = array();
				//var_dump($configurationids);
				//var_dump($pageContent["labconfigurationitems"]);
		
				for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {

					$calculoAnalitoMuestra = $controllerMediaDeComparacionTodosLosParticipantes->getCalculoPorAnalitoIdMuestraId(
						$configurationids["id_analito"][$x],
						$sampleid,
						$configurationids["id_metodologia"][$x],
						$configurationids["id_unidad"][$x],
						$configurationids["id_analizador"][$x]
					);



					$indicador = $controllerMediaDeComparacionTodosLosParticipantes->getIndicadorAnalitoMuestraUnidad(
						$configurationids["id_analito"][$x],
						$sampleid,
						$configurationids["id_metodologia"][$x],
						$configurationids["id_unidad"][$x],
						$configurationids["id_analizador"][$x]
					);

					$calculoAnalitoMuestraMisma = $controllerMediaDeComparacioParticipantesMismaMetodologia->getCalculoPorAnalitoIdMuestraId(
						$configurationids["id_analito"][$x],
						$sampleid,
						$configurationids["id_metodologia"][$x],
						$configurationids["id_unidad"][$x],
						$configurationids["id_analizador"][$x]
					);

					$indicadorMisma = $controllerMediaDeComparacioParticipantesMismaMetodologia->getIndicadorAnalitoMuestraUnidad(
						$configurationids["id_analito"][$x],
						$sampleid,
						$configurationids["id_metodologia"][$x],
						$configurationids["id_unidad"][$x],
						$configurationids["id_analizador"][$x]
					);

					//if ($pageContent["labconfigurationitems"]["valor_resultado"][$x] != "") { // Si el laboratorio reporto
					if ($calculoAnalitoMuestra["valor_lab"] != "0" && $calculoAnalitoMuestra["valor_lab"] != null) { // Si el laboratorio reporto
		


						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								$pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$y] = "";
							}
						}



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["diff"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								$pageContent["labconfigurationitemsforthewholeround"]["diff"][$x][$y] = "";
							}
						}



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["media"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								$pageContent["labconfigurationitemsforthewholeround"]["media"][$x][$y] = "";
							}
						}



						$chartValues_1 = md5(uniqid(rand(), true));

						$chartValues_2 = implode("|", $pageContent["labconfigurationitemsforthewholeround"]["muestra"][$x]);



						$array_zscore_chart = array();



						for ($xi = 0; $xi < sizeof($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x]); $xi++) {

							if (($xi + 1) > $pageContent["programsamplenumber"]) {

								break;
							} else {

								if (!empty($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$xi])) {
									// Si el z-score de la tabla de casos especiales no está vacío, se utiliza ese.
									array_push($array_zscore_chart, $pageContent["labconfigurationitemsforthewholeround"]["zscore"][$x][$xi]);
								} else {
									// Si no existe, se utiliza el z-score del consenso de participantes.
									array_push($array_zscore_chart, $pageContent["labconfigurationitemsforthewholeround"]["zscore_participantes_qap"][$x][$xi]);
								}
							}
						}



						$array_zscore_chart = implode("|", $array_zscore_chart);



						$chartValues_3 = $array_zscore_chart;

						$chartValues_4 = implode("|", $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x]);

						$chartValues_5 = md5(uniqid(rand(), true));

						$chartValues_12 = md5(uniqid(rand(), true));



						$tempMax = 0;



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								break;
							} else {



								if ($pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] > $tempMax) {

									$tempMax = $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y];
								}
							}
						}



						if (isset($pageContent["labconfigurationitems"]["limitvalue"][$x])) {
							$chartValues_13 = round(($tempMax * ($pageContent["labconfigurationitems"]["limitvalue"][$x] / 100)), 2);
						} else {
							// Si no existe el índice, puedes asignar un valor por defecto
							$chartValues_13 = 0;  // o null, según tu lógica
						}



						$tempMax = 0;

						$tempMin = 0;



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								break;
							} else {

								if ($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] > $tempMax) {

									$tempMax = $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y];
								}
							}
						}



						$tempMin = $tempMax;



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								break;
							} else {

								if (is_numeric($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y])) {

									if ($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] < $tempMin) {

										$tempMin = $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y];
									}
								}
							}
						}



						$chartValues_14 = $tempMax;

						$chartValues_15 = array();

						$chartValues_16 = array();



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								break;
							} else {

								if (($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] != "" || $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] != 0) && ($pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] != "" || $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] != 0)) {

									$chartValues_15[$y] = (1) * round(($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] - $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y]), 2);
								}
							}
						}



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								break;
							} else {

								if (($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] != "" || $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y] != 0) && ($pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] != "" || $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y] != 0)) {

									$chartValues_16[$y] = $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y];
								}
							}
						}



						$chartValues_15 = implode("|", $chartValues_15);

						$chartValues_16 = implode("|", $chartValues_16);



						$chartValues_17 = $tempMin;

						$chartValues_21 = array();



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x]); $y++) {

							if (($y + 1) > $pageContent["programsamplenumber"]) {

								break;
							} else {



								$puntos = "";

								$referenceMedia = $pageContent["labconfigurationitemsforthewholeround"]["referencemedia"][$x][$y];

								$resultado = $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$x][$y];



								if (($resultado != "" || $resultado != 0) && ($referenceMedia != "" || $referenceMedia != 0 || $referenceMedia != NULL)) {

									$puntos = round(($referenceMedia - $resultado), 2);
								}



								// Generacion de nombres de etiquetas
		
								if (($resultado != "" || $resultado != 0) && ($referenceMedia != "" || $referenceMedia != 0 || $referenceMedia != NULL)) {

									$chartValues_21[$y] = (-1) * $puntos . " " . $pageContent["labconfigurationitems"]["nombre_unidad"][$x] . " (" . ($pageContent["labconfigurationitemsforthewholeround"]["deviationpercentagereference"][$x][$y] * (1)) . "%)";
								}
							}
						}



						$chartValues_21 = implode("|", $chartValues_21);

						if (isset($pageContent["labconfigurationitems"]["limitvalue"][$x]) && isset($pageContent["labconfigurationitems"]["limitname"][$x])) {
							$chartValues_18 = $pageContent["labconfigurationitems"]["limitvalue"][$x] . " - " . $pageContent["labconfigurationitems"]["limitname"][$x];
						} else {
							$chartValues_18 = "N/A - N/A";
						}


						echo "<span style='color:white;' data-chart-container='2' data-chart-content='1' hidden='hidden'>" . $chartValues_5 . "</span>";

						echo "<span style='color:white;' data-chart-container='2' data-chart-content='2' hidden='hidden'>" . $chartValues_3 . "</span>";

						echo "<span style='color:white;' data-chart-container='2' data-chart-content='3' hidden='hidden'>" . $chartValues_4 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='1' hidden='hidden'>" . $chartValues_12 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='2' hidden='hidden'>" . $chartValues_13 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='3' hidden='hidden'>" . $chartValues_14 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='4' hidden='hidden'>" . $chartValues_15 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='5' hidden='hidden'>" . $chartValues_16 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='6' hidden='hidden'>" . $chartValues_17 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='7' hidden='hidden'>" . $chartValues_18 . "</span>";

						echo "<span style='color:white;' data-chart-container='4' data-chart-content='8' hidden='hidden'>" . $chartValues_21 . "</span>";



						if ($analitRowCounter == 0) {



							echo "<div class='col margin-top-1 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

							tablePrinter('header2', '4. Evaluación con media de comparación y con X<sub>pt</sub> (valor aceptado como verdadero)', $labid, $sampleid);

							tablePrinter('br', 'no_border');
						}



						$nombreAnalito = isset($pageContent["labconfigurationitems"]["nombre_analito"][$x])
							? $pageContent["labconfigurationitems"]["nombre_analito"][$x]
							: "N/A";

						$valorResultado = isset($pageContent["labconfigurationitems"]["valor_resultado"][$x])
							? $pageContent["labconfigurationitems"]["valor_resultado"][$x]
							: "";

						$unidad = isset($pageContent["labconfigurationitems"]["nombre_unidad"][$x])
							? $pageContent["labconfigurationitems"]["nombre_unidad"][$x]
							: "";

						$analizador = isset($pageContent["labconfigurationitems"]["nombre_analizador"][$x])
							? $pageContent["labconfigurationitems"]["nombre_analizador"][$x]
							: "N/A";

						$metodologia = isset($pageContent["labconfigurationitems"]["nombre_metodologia"][$x])
							? $pageContent["labconfigurationitems"]["nombre_metodologia"][$x]
							: "N/A";

						$limitName = isset($pageContent["labconfigurationitems"]["limitname"][$x])
							? $pageContent["labconfigurationitems"]["limitname"][$x]
							: "N/A";

						$limitValue = isset($pageContent["labconfigurationitems"]["limitvalue"][$x])
							? $pageContent["labconfigurationitems"]["limitvalue"][$x]
							: " - - ";

						echo "
<table style='width: 100%'>
    <tbody>
        <tr>
            <td style='width: 35%; background-color: #D4E6F1;font-weight:bold;text-align:center;font-size:9pt;color:#1A5276'>{$nombreAnalito}</td>
            <td style='width: 14%; font-size:9pt;text-align:right;font-weight:bold;'>" . (($valorResultado == "") ? "- -" : $valorResultado) . " {$unidad}</td>
            <td style='width: 15%; font-size:9pt;text-align:right;'>{$analizador}</td>
            <td style='width: 18%; font-size:9pt;text-align:right;'>{$metodologia}</td>
            <td style='width: 7%; font-size:9pt; text-align:right;'>{$limitName}</td>
            <td style='width: 10%; font-size:9pt; text-align:right;'>{$limitValue}% APS</td>
									</tr>
								</tbody>
							</table>
						";




						tablePrinter('br', 'no_border');



						echo "

							<table style='width: 100%'>

								<tbody>

									<tr style='font-size: 5pt'>

									 	<th style='font-weight:bold;text-align:center; width: 27.5%;'>1</th>

									 	<th style='font-weight:bold;text-align:center; width: 6.5%'>2</th>

									 	<th style='font-weight:bold;text-align:center; width: 7.5%'>3</th>

									 	<th style='font-weight:bold;text-align:center; width: 6.5%'>4</th>

									 	<th style='font-weight:bold;text-align:center; width: 6.5%'>5</th>

									 	<th style='font-weight:bold;text-align:center; width: 6.5%'>6</th>

									 	<th style='font-weight:bold;text-align:center; width: 11%'>7</th>

									 	<th style='font-weight:bold;text-align:center; width: 10%'>8</th>

									 	<th style='font-weight:bold;text-align:center; width: 7%'>9</th>

									 	<th style='font-weight:bold;text-align:center; width: 11%'>10</th>

									 </tr>



									<tr style='font-size: 7pt'>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 27.5%;'>Fuente de comparación<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 6.5%'>P25<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 7.5%'> X<sub>pt</sub><br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 6.5%'>P75<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 6.5%'>D.E.<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 6.5%'>n/N<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 11%'> Incertidumbre<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 10%'> Diferencia%<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 7%'> Z-score<br></th>

										<th style='font-weight:bold;background-color:#FFF;border:1px solid #B2BABB;border-bottom:2px solid #B2BABB;text-align:center; width: 11%'> Valoración<br></th>

									</tr>";





						// Fuente de comparación
		
						echo "<tr style='font-size: 7pt; background-color:#EAECEE;'>

										<th style='text-align:center; width: 27.5%;border-left:1px solid #B2BABB;'>RL-MMT-JCTLM<sup>1</sup></th>";

						// P25 No aplica para el JCTLM
		
						echo "<td style='width: 6.5%;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";

						// X<sub>pt</sub>
		
						if ($pageContent["labconfigurationitems"]["referencemedia"][$x] == "" || $pageContent["labconfigurationitems"]["referencemedia"][$x] == 0) {

							echo "<td style='width: 7.5%;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";
						} else {

							echo "<td style='width: 7.5%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["referencemedia"][$x] . "</td>";
						}


						// P75 No aplica para el JCTLM
		
						echo "<td style='width: 6.5%;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";



						echo "<td style='text-align:center; width: 6.5%'>N/A</td> "; // DE
		
						echo "<td style='text-align:center; width: 6.5%'>N/A</td>"; // N
		
						echo "<td style='text-align:center; width: 11%'>N/A</td>"; // Incertidumbre
		


						// Diferencia porcentual
		
						if ($pageContent["labconfigurationitems"]["referencemedia"][$x] == "" || $pageContent["labconfigurationitems"]["referencemedia"][$x] == 0) {

							echo "<td style='width: 10%;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";
						} else {

							$operacion = (($pageContent["labconfigurationitems"]["referencemedia"][$x] - $pageContent["labconfigurationitems"]["valor_resultado"][$x]) / $pageContent["labconfigurationitems"]["referencemedia"][$x]) * -100;

							echo "<td style='width: 10%;" . $pageContent["tablestyle_text_center"] . "'>" . round($operacion, 2) . "</td>";
						}



						echo "<td style='text-align:center; width: 7%'>N/A</td>"; // Z-Score
		


						// Valoración
		
						if ($pageContent["labconfigurationitems"]["sampleperformancereference"][$x] === 0) {

							echo "<td style='width:11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>No satisfactorio</td>";
						} else if ($pageContent["labconfigurationitems"]["sampleperformancereference"][$x] == 1) {

							echo "<td style='width:11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>Satisfactorio</td>";
						} else if ($pageContent["labconfigurationitems"]["sampleperformancereference"][$x] == null) {

							echo "<td style='width:11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";
						}

						echo "</tr>";



						switch ($pageContent["labconfigurationitems"]["tipo_media_estandar"][$x]) {


							case "Consenso": // Si la media es por consenso
		


								// Media de comparación internacional en N/A
		
								echo "<tr style='font-size: 7pt; background-color:#FFF;'>";

								echo "<th style='text-align:center;width:27.5%;border-left:1px solid #B2BABB;'>Media de comparación internacional</th>";

								echo "<td style='text-align:center;width:6.5%'>N/A</td>"; // P25 (No aplica para la media de comparación internacional)
		
								echo "<td style='text-align:center;width:7.5%'>N/A</td>"; // X<sub>pt</sub>
		
								echo "<td style='text-align:center;width:6.5%'>N/A</td>"; // P75 (No aplica para la media de comparación internacional)
		
								echo "<td style='text-align:center;width:6.5%'>N/A</td>"; // D.E.
		
								echo "<td style='text-align:center;width:6.5%'>N/A</td>"; // N
		
								echo "<td style='width: 11%;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>"; // Incertidumbre
		
								echo "<td style='width: 10%;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>"; // Diff
		
								echo "<td style='text-align:center;width: 7%'>N/A</td>"; // Zscore
		
								echo "<td style='width: 11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>"; // Valoración
		
								echo "</tr>";





								if (

									$pageContent["labconfigurationitems"]["media_estandar"][$x] == "" &&

									$pageContent["labconfigurationitems"]["desviacion_estandar"][$x] == "" &&

									$pageContent["labconfigurationitems"]["n_evaluacion"][$x] == ""

								) {
								} else { // Después de la versión 7 de QAP Online
		

									$mostrarTodosParticipantes = true;
									$mostrarMismaMetodologia = true;
									$leyendaCV = "";
									$leyendaDatosInsuficientes = "";

									// Lógica para la leyenda y la visualización
		
									if (isset($calculoAnalitoMuestra["n"]) && $calculoAnalitoMuestra["n"] < 4) {
										$mostrarTodosParticipantes = false;
										$leyendaDatosInsuficientes = "No hay suficientes datos para la comparación de todos los participantes QAP. ";
									}

									if (isset($calculoAnalitoMuestraMisma["n"]) && $calculoAnalitoMuestraMisma["n"] < 4) {
										$mostrarMismaMetodologia = false;
										$leyendaDatosInsuficientes = "No hay suficientes datos para la comparación de la misma metodología.";
									}

									if (isset($calculoAnalitoMuestra["n"]) && $calculoAnalitoMuestra["n"] < 4 && isset($calculoAnalitoMuestraMisma["n"]) && $calculoAnalitoMuestraMisma["n"] < 4) {
										$mostrarTodosParticipantes = false;
										$mostrarMismaMetodologia = false;
										$leyendaDatosInsuficientes = "No hay suficientes datos para la comparación de todos los participantes QAP y con la misma metodología.";
									}

									// ---------------------- IMPRESIÓN DE LA TABLA ----------------------
									// Fila para "Todos los participantes de QAP"
									echo "<tr style='font-size: 7pt; background-color:#EAECEE;'>";
									echo "<th style='text-align:center;width:27.5%;border-left:1px solid #B2BABB;'>Todos los participantes de QAP<sup>2</sup></th>";

									if ($mostrarTodosParticipantes) {
										$datosAUsar = $calculoAnalitoMuestra;
										$indicadorAUsar = $indicador;

										if (isset($datosAUsar["n"]) && $datosAUsar["n"] >= 4) {

											echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["q1"], 2) . "</td>";
											echo "<td style='text-align:center;width: 7.5%'>" . round($datosAUsar["mediana"], 2) . "</td>";
											echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["q3"], 2) . "</td>";
											echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["s"], 2) . "</td>";
											echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["n"], 2) . "</td>";
											echo "<td style='text-align:center;width: 11%'>" . round($datosAUsar["incertidumbre"], 2) . "</td>";
											echo "<td style='text-align:center;width: 10%'>" . round($datosAUsar["diferencia_robusta"], 2) . "</td>";
											echo "<td style='text-align:center;width: 7%'>" . round($datosAUsar["zscore"], 2) . "</td>";
											if ($indicadorAUsar == 1) {
												$rendimiento = "Satisfactorio";
											} else if ($indicadorAUsar == 0) {
												$rendimiento = 'Alarma';
											} else {
												$rendimiento = "No satisfactorio";
											}
										} else {
											echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='text-align:center;width: 7.5%'>N/A</td>";
											echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='text-align:center;width: 11%'>N/A</td>";
											echo "<td style='text-align:center;width: 10%'>N/A</td>";
											echo "<td style='text-align:center;width: 7%'>N/A</td>";
											$rendimiento = "N/A";
										}
									} else {
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 7.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 11%'>N/A</td>";
										echo "<td style='text-align:center;width: 10%'>N/A</td>";
										echo "<td style='text-align:center;width: 7%'>N/A</td>";
										$rendimiento = "N/A";
									}
									echo "<td style='width: 11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>" . $rendimiento . "</td>";
									echo "</tr>";

									// Fila para "Participantes QAP misma metodología"
									echo "<tr style='font-size: 7pt;background-color:#fff'>";
									echo "<th style='border-left:1px solid #B2BABB;border-bottom:1px solid #B2BABB;text-align:center;width: 27.5%;'>Participantes QAP misma metodología<sup>2</sup></th>";

									if ($mostrarMismaMetodologia) {
										$datosAUsar = $calculoAnalitoMuestraMisma;
										$indicadorAUsar = $indicadorMisma;

										if (isset($datosAUsar["n"]) && $datosAUsar["n"] >= 4) {
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["q1"], 2) . "</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7.5%'>" . round($datosAUsar["mediana"], 2) . "</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["q3"], 2) . "</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["s"], 2) . "</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["n"], 2) . "</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 11%'>" . round($datosAUsar["incertidumbre"], 2) . "</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 10%'>" . round($datosAUsar["diferencia_robusta"], 2) . "</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7%'>" . round($datosAUsar["zscore"], 2) . "</td>";

											if ($indicadorAUsar == 1) {
												$rendimiento = "Satisfactorio";
											} else if ($indicadorAUsar == 0) {
												$rendimiento = 'Alarma';
											} else {
												$rendimiento = "No satisfactorio";
											}
										} else {
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7.5%'>N/A</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 11%'>N/A</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 10%'>N/A</td>";
											echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7%'>N/A</td>";
											$rendimiento = "N/A";
										}
									} else {
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 11%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 10%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7%'>N/A</td>";
										$rendimiento = "N/A";
									}
									echo "<td style='text-align:center;width: 11%; border-right:1px solid #B2BABB;border-bottom:1px solid #B2BABB;'>" . $rendimiento . "</td>";
									echo "</tr>";

									// Leyendas
									if (!empty($leyendaDatosInsuficientes)) {
										echo "<tr><td colspan='10' style='font-size: 7pt;'>" . $leyendaDatosInsuficientes . "</td></tr>";
									}
								}
								break;


							default: // Si no es mediante consenso
		

								// Determinar qué datos mostrar según la lógica del CV
								$mostrarTodosParticipantes = true;
								$mostrarMismaMetodologia = true;
								$leyendaCV = "";
								$leyendaDatosInsuficientes = "";

								// Lógica para la leyenda y la visualización
		
								if (isset($calculoAnalitoMuestra["n"]) && $calculoAnalitoMuestra["n"] < 4) {
									$mostrarTodosParticipantes = false;
									$leyendaDatosInsuficientes = "No hay suficientes datos para la comparación de todos los participantes QAP. ";
								}

								if (isset($calculoAnalitoMuestraMisma["n"]) && $calculoAnalitoMuestraMisma["n"] < 4) {
									$mostrarMismaMetodologia = false;
									$leyendaDatosInsuficientes = "No hay suficientes datos para la comparación de la misma metodología.";
								}

								if (isset($calculoAnalitoMuestra["n"]) && $calculoAnalitoMuestra["n"] < 4 && isset($calculoAnalitoMuestraMisma["n"]) && $calculoAnalitoMuestraMisma["n"] < 4) {
									$mostrarTodosParticipantes = false;
									$mostrarMismaMetodologia = false;
									$leyendaDatosInsuficientes = "No hay suficientes datos para la comparación de todos los participantes QAP y con la misma metodología.";
								}

								// ---------------------- IMPRESIÓN DE LA TABLA ----------------------
								// Fila para "Media de inserto" o "Media de comparación internacional"
								echo "<tr style='font-size: 7pt; background-color:#FFF;'>";
								if ($pageContent["labconfigurationitems"]["tipo_media_estandar"][$x] == "Inserto") {
									echo "<th style='text-align:center;width:27.5%;border-left:1px solid #B2BABB;'>Media de inserto</th>";
								} else {
									echo "<th style='text-align:center;width:27.5%;border-left:1px solid #B2BABB;'>Media de comparación internacional</th>";
								}

								echo "<td style='text-align:center;width:6.5%'>N/A</td>";
								echo "<td style='text-align:center;width:7.5%'>" . (($pageContent["labconfigurationitems"]["media_estandar"][$x] == "" || $pageContent["labconfigurationitems"]["valor_resultado"][$x] == "") ? "N/A" : round($pageContent["labconfigurationitems"]["media_estandar"][$x], 2)) . "</td>";
								echo "<td style='text-align:center;width:6.5%'>N/A</td>";
								echo "<td style='text-align:center;width:6.5%'>" . (($pageContent["labconfigurationitems"]["desviacion_estandar"][$x] == "" || $pageContent["labconfigurationitems"]["valor_resultado"][$x] == "") ? "N/A" : round($pageContent["labconfigurationitems"]["desviacion_estandar"][$x], 2)) . "</td>";
								echo "<td style='text-align:center;width:6.5%'>" . (($pageContent["labconfigurationitems"]["n_evaluacion"][$x] == "" || $pageContent["labconfigurationitems"]["valor_resultado"][$x] == "") ? "N/A" : $pageContent["labconfigurationitems"]["n_evaluacion"][$x]) . "</td>";

								// Incertidumbre
								$incertidumbre_inf = "N/A";
								$incertidumbre_sup = "N/A";
								if (is_numeric($pageContent["labconfigurationitems"]["media_estandar"][$x]) && is_numeric($pageContent["labconfigurationitems"]["desviacion_estandar"][$x]) && $pageContent["labconfigurationitems"]["valor_resultado"][$x] != "") {
									$incertidumbre_inf = $pageContent["labconfigurationitems"]["media_estandar"][$x] - ($pageContent["labconfigurationitems"]["desviacion_estandar"][$x] * 2);
									$incertidumbre_sup = $pageContent["labconfigurationitems"]["media_estandar"][$x] + ($pageContent["labconfigurationitems"]["desviacion_estandar"][$x] * 2);
								}
								if ($incertidumbre_inf == "N/A" || $incertidumbre_sup == "N/A") {
									echo "<td style='width: 11%;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";
								} else {
									echo "<td style='width: 11%;" . $pageContent["tablestyle_text_center"] . "'>" . round($incertidumbre_inf, 2) . " a " . round($incertidumbre_sup, 2) . "</td>";
								}

								// Diferencia porcentual
								if ($pageContent["labconfigurationitems"]["media_estandar"][$x] == "" || $pageContent["labconfigurationitems"]["media_estandar"][$x] == 0 || $pageContent["labconfigurationitems"]["valor_resultado"][$x] == "") {

									$pageContent["labconfigurationitems"]["diff_porcentual"][$x] = "N/A";

									echo "<td style='width: 10%;" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["diff_porcentual"][$x] . "</td>";
								} else {
									$pageContent["labconfigurationitems"]["diff_porcentual"][$x] = (($pageContent["labconfigurationitems"]["valor_resultado"][$x] - $pageContent["labconfigurationitems"]["media_estandar"][$x]) / $pageContent["labconfigurationitems"]["media_estandar"][$x]) * 100;

									echo "<td style='width: 10%;" . $pageContent["tablestyle_text_center"] . "'>" . round($pageContent["labconfigurationitems"]["diff_porcentual"][$x], 2) . "</td>";
								}

								// Z-Score
								if (isset($pageContent["labconfigurationitems"]["zscore"][$x])) {
									echo "<td style='text-align:center;width: 7%'>" . round($pageContent["labconfigurationitems"]["zscore"][$x], 2) . "</td>";
								} else {
									echo "<td style='text-align:center;width: 7%'>N/A</td>";
								}

								// Valoración
								if (isset($pageContent["labconfigurationitems"]["zscoreperformance"][$x])) {
									$rendimiento = "N/A";
									if ($pageContent["labconfigurationitems"]["zscoreperformance"][$x] == 1) {
										$rendimiento = "Satisfactorio";
									} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$x] == 2) {
										$rendimiento = 'Alarma';
									} else if ($pageContent["labconfigurationitems"]["zscoreperformance"][$x] == 3) {
										$rendimiento = "No satisfactorio";
									}
									echo "<td style='width: 11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>" . $rendimiento . "</td>";
								} else {
									echo "<td style='width: 11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>N/A</td>";
								}
								echo "</tr>";

								// Fila para "Todos los participantes de QAP"
								echo "<tr style='font-size: 7pt; background-color:#EAECEE;'>";
								echo "<th style='text-align:center;width: 27.5%;border-left:1px solid #B2BABB;'>Todos los participantes de QAP<sup>2</sup></th>";

								if ($mostrarTodosParticipantes) {
									$datosAUsar = $calculoAnalitoMuestra;
									$indicadorAUsar = $indicador;

									if (isset($datosAUsar["n"]) && $datosAUsar["n"] >= 4) {
										echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["q1"], 2) . "</td>";
										echo "<td style='text-align:center;width: 7.5%'>" . round($datosAUsar["mediana"], 2) . "</td>";
										echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["q3"], 2) . "</td>";
										echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["s"], 2) . "</td>";
										echo "<td style='text-align:center;width: 6.5%'>" . round($datosAUsar["n"], 2) . "</td>";
										echo "<td style='text-align:center;width: 11%'>" . round($datosAUsar["incertidumbre"], 2) . "</td>";
										echo "<td style='text-align:center;width: 10%'>" . round($datosAUsar["diferencia_robusta"], 2) . "</td>";
										echo "<td style='text-align:center;width: 7%'>" . round($datosAUsar["zscore"], 2) . "</td>";

										if ($indicadorAUsar == 1) {
											$rendimiento = "Satisfactorio";
										} else if ($indicadorAUsar == 0) {
											$rendimiento = 'Alarma';
										} else {
											$rendimiento = "No satisfactorio";
										}
									} else {
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 7.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='text-align:center;width: 11%'>N/A</td>";
										echo "<td style='text-align:center;width: 10%'>N/A</td>";
										echo "<td style='text-align:center;width: 7%'>N/A</td>";
										$rendimiento = "N/A";
									}
								} else {
									echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='text-align:center;width: 7.5%'>N/A</td>";
									echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='text-align:center;width: 11%'>N/A</td>";
									echo "<td style='text-align:center;width: 10%'>N/A</td>";
									echo "<td style='text-align:center;width: 7%'>N/A</td>";
									$rendimiento = "N/A";
								}
								echo "<td style='width: 11%;border-right:1px solid #B2BABB;" . $pageContent["tablestyle_text_center"] . "'>" . $rendimiento . "</td>";
								// echo "</tr>";
		
								// Fila para "Participantes QAP misma metodología"
								echo "<tr style='font-size: 7pt;background-color:#fff'>";
								echo "<th style='border-left:1px solid #B2BABB;border-bottom:1px solid #B2BABB;text-align:center;width: 27.5%;'>Participantes QAP misma metodología<sup>2</sup></th>";

								if ($mostrarMismaMetodologia) {
									$datosAUsar = $calculoAnalitoMuestraMisma;
									$indicadorAUsar = $indicadorMisma;

									if (isset($datosAUsar["n"]) && $datosAUsar["n"] >= 4) {
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["q1"], 2) . "</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7.5%'>" . round($datosAUsar["mediana"], 2) . "</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["q3"], 2) . "</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["s"], 2) . "</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>" . round($datosAUsar["n"], 2) . "</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 11%'>" . round($datosAUsar["incertidumbre"], 2) . "</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 10%'>" . round($datosAUsar["diferencia_robusta"], 2) . "</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7%'>" . round($datosAUsar["zscore"], 2) . "</td>";

										if ($indicadorAUsar == 1) {
											$rendimiento = "Satisfactorio";
										} else if ($indicadorAUsar == 0) {
											$rendimiento = 'Alarma';
										} else {
											$rendimiento = "No satisfactorio";
										}
									} else {
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 11%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 10%'>N/A</td>";
										echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7%'>N/A</td>";
										$rendimiento = "N/A";
									}
								} else {
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7.5%'>N/A</td>";
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 6.5%'>N/A</td>";
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 11%'>N/A</td>";
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 10%'>N/A</td>";
									echo "<td style='border-bottom:1px solid #B2BABB;text-align:center;width: 7%'>N/A</td>";
									$rendimiento = "N/A";
								}
								echo "<td style='text-align:center;width: 11%; border-right:1px solid #B2BABB;border-bottom:1px solid #B2BABB;'>" . $rendimiento . "</td>";
								echo "</tr>";

								// Leyendas
								if (!empty($leyendaDatosInsuficientes)) {
									echo "<tr><td colspan='10' style='font-size: 7pt;'>" . $leyendaDatosInsuficientes . "</td></tr>";
								}
								if (!empty($leyendaCV)) {
									echo "<tr><td colspan='10' style='font-size: 7pt;'>" . $leyendaCV . "</td></tr>";
								}
								break;

						}




						echo "</tbody>

							</table>

						";





						tablePrinter('br', 'no_border');





						echo "<table>
								<tr>
									<td style='font-size:7px;width:100%'>(1) RL-MMT-JCTLM: Resultado de laboratorio que trabaja con material y método trazable a los avalados por el JCTLM</td>
								</tr>
								<tr>
									<td style='font-size:7px;width:100%'>(2) Valores obtenidos por estadísticos robustos</td>
								</tr>
							</table>";





						tablePrinter('br', 'no_border');





						echo "<table style='width: 100%;'>";

						echo "<tbody>";

						echo "<tr>";

						echo "<td style='width:50%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_overflow"] . "'>";

						echo "<img style='width: 390px;height: 186px;' data-src='php/temp_chart/" . $chartValues_12 . ".jpg' data-chart-frame='1'></img>";

						echo "</td>";

						echo "<td style='width:50%;" . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_overflow"] . "'>";

						echo "<img style='width: 390px;height: 186px;' data-src='php/temp_chart/" . $chartValues_5 . ".jpg' data-chart-frame='1'></img>";

						echo "</td>";

						echo "</tr>";

						echo "</tbody>";

						echo "</table>";



						tablePrinter('br', 'no_border');




						if ($analitRowCounter == ($maxanalitrowcounter - 1) || $x == (sizeof($configurationids["id_configuracion"]) - 1)) {



							if ($analitRowCounter < ($maxanalitrowcounter - 1)) {

								tablePrinter('br', 'no_border');
							}



							echo "</div>";

							echo "<!-- sheet separator -->";
						}



						if ($analitRowCounter == ($maxanalitrowcounter - 1)) {

							$analitRowCounter = 0;
						} else {

							$analitRowCounter++;
						}
					} else { // Si el laboratorio NO reportó
		
						if ($x == (sizeof($configurationids["id_configuracion"]) - 1)) {

							echo "<!-- sheet separator -->";
						}
					}
				}



				break;
		}



		switch ($pageContent["programtype"]) {

			case 1:



				$repeat = true;

				$maxRows = 20;

				$itemCounter = 0;

				// $itemCounter2 	=	0;
		


				// while ($repeat){
		


				echo "<div class='col margin-top-1 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

				tablePrinter('header2', '5. INFORME DE TRAZABILIDAD METROLÓGICA', $labid, $sampleid);

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

				echo "<tbody>";



				echo "<tr style='font-size: 5pt'>

									<th style='font-weight:bold;text-align:center;'>1</th>

									<th style='font-weight:bold;text-align:center;'>2</th>

									<th style='font-weight:bold;text-align:center;'>3</th>

									<th style='font-weight:bold;text-align:center;'>4</th>

									<th style='font-weight:bold;text-align:center;'>5</th>

									<th style='font-weight:bold;text-align:center;'>6</th>

									<th style='font-weight:bold;text-align:center;'>7</th>

									<th style='font-weight:bold;text-align:center;'>8</th>

								</tr>";



				echo "<tr style='font-size: 7px'>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Ítem</th>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Mensurando</th>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Analizador</th>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Metodología declarada por el manufacturador</th>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Metodología de referencia avalada por el JCTLM</th>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Material trazable declarado por el manufacturador</th>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Material de referencia avalado por el JCTLM</th>";

				echo "<th style='font-weight: bold; " . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_background_color"] . $pageContent["tablestyle_text_center"] . "'>Estado de trazabilidad</th>";

				echo "</tr>";



				for ($x = 0; $x < sizeof($configurationids["id_analito"]); $x++) {



					if ((($x + 1) % 2) == 0) {

						$trBackgroundColor = "#f2f2f2";
					} else {

						$trBackgroundColor = "white";
					}



					if (isset($configurationids['id_analito'][$itemCounter])) {

						echo "<tr style='background-color:" . $trBackgroundColor . ";font-size: 7px;'>";

						echo "<td style='" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>" . ($itemCounter + 1) . "</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent['labconfigurationitems']['nombre_analito'][$x] . "</td>";

						echo "<td style='" . $pageContent['tablestyle_text_center'] . "'>" . $pageContent["labconfigurationitems"]["nombre_analizador"][$x] . "</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_metodologia"][$x] . "</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>";



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x]); $y++) {



							$temp_array = explode('|', $pageContent['labconfigurationitems']['jctlmmethod'][$x][$y]);



							if ($temp_array[1] == 1) {

								echo "<span style='background-color:#afffaf;'>&nbsp;" . $pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x][$y] . "&nbsp;</span>";
							} else {

								echo "<span>&nbsp;" . $pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x][$y] . "&nbsp;</span>";
							}
						}

						echo "</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["nombre_material"][$x] . "</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>";



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitems"]["id_material_jctlm"][$x]); $y++) {

							$temp_array = explode('|', $pageContent['labconfigurationitems']['jctlmmaterial'][$x][$y]);



							if ($temp_array[1] == 1) {

								echo "<span style='background-color:#afffaf;'>&nbsp;" . $pageContent["labconfigurationitems"]["id_material_jctlm"][$x][$y] . "&nbsp;</span>";
							} else {

								echo "<span>&nbsp; " . $pageContent["labconfigurationitems"]["id_material_jctlm"][$x][$y] . "&nbsp;</span>";
							}
						}

						echo "</td>";

						echo "<td style='" . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_text_center"] . "'>" . $pageContent["labconfigurationitems"]["jctlmcalification"][$x] . "</td>";

						echo "</tr>";
					} else {

						echo "<tr style='background-color:" . $trBackgroundColor . "'>";

						echo "<td style='" . $pageContent["tablestyle_border_left"] . "'>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td>&nbsp;</td>";

						echo "<td style='" . $pageContent["tablestyle_border_right"] . "'>&nbsp;</td>";

						echo "</tr>";
					}



					$itemCounter++;
				}



				echo "</tbody>";

				echo "</table>";

				tablePrinter('tableend', 'null');

				tablePrinter('br', 'no_border');



				echo "<table>";

				echo "<thead>";

				echo "<tr style='font-size:8px;'>";

				echo "<th>Nomenclatura método</th>";

				echo "</tr>";

				echo "</thead>";



				echo "<tbody>";

				echo "<tr style='" . $pageContent['tablestyle_text_justify'] . ";font-size:8px;'>";

				echo "<td>";

				for ($x = 0; $x < sizeof($configurationids['id_analito']); $x++) {



					for ($y = 0; $y < sizeof($pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x]); $y++) {

						$temp_array = explode('|', $pageContent['labconfigurationitems']['jctlmmethod'][$x][$y]);

						if ($temp_array[1] == 1) {

							echo "<span style='background-color:#afffaf;'>&nbsp; <b>" . $pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x][$y] . '</b>: ' . $temp_array[0] . "&nbsp;</span>";
						} else {

							echo "<span>&nbsp;<b>" . $pageContent["labconfigurationitems"]["id_metodo_jctlm"][$x][$y] . '</b>: ' . $temp_array[0] . "&nbsp;</span>";
						}
					}
				}

				echo "</td>";

				echo "</tr>";

				echo "</table>";



				tablePrinter('br', 'no_border');

				echo "<table>";

				echo "<thead>";

				echo "<tr style='font-size:8px;'>";

				echo "<th>Nomenclatura materiales</th>";

				echo "</tr>";

				echo "</thead>";



				echo "<tbody>";

				echo "<tr style='" . $pageContent['tablestyle_text_justify'] . ";font-size:8px;'>";

				echo "<td>";

				for ($x = 0; $x < sizeof($configurationids['id_analito']); $x++) {



					for ($y = 0; $y < sizeof($pageContent["labconfigurationitems"]["id_material_jctlm"][$x]); $y++) {

						$temp_array = explode('|', $pageContent['labconfigurationitems']['jctlmmaterial'][$x][$y]);

						if ($temp_array[1] == 1) {

							echo "<span style='background-color:#afffaf;'>&nbsp; <b>" . $pageContent["labconfigurationitems"]["id_material_jctlm"][$x][$y] . '</b>: ' . $temp_array[0] . "&nbsp;</span>";
						} else {

							echo "<span>&nbsp;<b>" . $pageContent["labconfigurationitems"]["id_material_jctlm"][$x][$y] . '</b>: ' . $temp_array[0] . "&nbsp;</span>";
						}
					}
				}

				echo "</td>";

				echo "</tr>";

				echo "</table>";



				echo "</div>";



				echo "<!-- sheet separator -->";



				// }
		
				break;
		}



		switch ($pageContent["programtype"]) {

			case 1:
				$repeat = true;
				$maxRows = 35;
				$itemCounter = 0;

				// Determinar si necesitamos dividir las tablas
				$totalMuestras = sizeof($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0]);
				$muestrasPorTabla = array();

				if ($totalMuestras > 8) {
					// Primera tabla: 6 muestras (índices 0-5)
					$muestrasPorTabla[0] = array_slice($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0], 0, 6);
					// Segunda tabla: el resto de muestras (índices 6 en adelante)
					$muestrasPorTabla[1] = array_slice($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0], 6);
				} else {
					// Una sola tabla con todas las muestras
					$muestrasPorTabla[0] = $pageContent["labconfigurationitemsforthewholeround"]["muestra"][0];
				}

				// Generar cada tabla
				for ($tablaIndex = 0; $tablaIndex < count($muestrasPorTabla); $tablaIndex++) {
					$muestrasActuales = $muestrasPorTabla[$tablaIndex];
					$offsetMuestra = ($tablaIndex == 0) ? 0 : 6; // Para la segunda tabla, empezamos desde el índice 6
		
					echo "<div class='col margin-top-1 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

					// Solo mostrar el encabezado principal en la primera tabla
					if ($tablaIndex == 0) {
						tablePrinter('header2', '6. RESUMEN DE RONDA', $labid, $sampleid);
						tablePrinter('br', 'no_border');
					}

					echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";
					echo "<tbody>";
					echo "<tr style='font-size:7px;font-weight:bold;'>";
					echo "<th style='" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' rowspan='2'>Ítem</th>";
					echo "<th style='" . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' colspan='2' rowspan='2'>Mensurando</th>";

					// Encabezados de muestras para la tabla actual
					for ($x = 0; $x < sizeof($muestrasActuales); $x++) {
						echo "<th style='" . (($x + 1) == sizeof($muestrasActuales) ? $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_top"] : $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"]) . $pageContent["tablestyle_text_center"] . "' colspan='3'>Muestra " . $muestrasActuales[$x] . "</th>";
					}

					echo "</tr>";
					echo "<tr style='font-size:5px;font-weight:bold;'>";

					$notificaciones_muestra = [];

					// Subencabezados para las muestras actuales
					for ($x = 0; $x < sizeof($muestrasActuales); $x++) {
						$indiceOriginal = $offsetMuestra + $x;

						// Para la ronda Y se agregan los tres tipos de notificaciones
						$notificaciones_muestra[$indiceOriginal] = [];
						$notificaciones_muestra[$indiceOriginal]["tardio"] = 0;
						$notificaciones_muestra[$indiceOriginal]["ausente"] = 0;
						$notificaciones_muestra[$indiceOriginal]["revalorado"] = 0;

						echo "<th style='" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "'>Dif% con RL-MMT-JCTLM</th>";
						echo "<th style='" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "'>Z-S<br>WWR</th>";
						echo "<th style='" . (($x + 1) == sizeof($muestrasActuales) ? $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_top"] : $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"]) . $pageContent["tablestyle_text_center"] . "'>Z Score participantes QAP</th>";
					}

					echo "</tr>";

					// Reiniciar contador para cada tabla
					$itemCounterLocal = 0;

					// Filas de datos
					for ($x = 0; $x < sizeof($configurationids["id_analito"]); $x++) {
						if ((($x + 1) % 2) == 0) {
							$trBackgroundColor = "white";
						} else {
							$trBackgroundColor = "#f2f2f2";
						}

						if (!isset($configurationids["id_analito"][$itemCounterLocal])) {
							echo "<tr style='background-color:" . $trBackgroundColor . ";font-size:6px;'>";
							echo "<td style='font-weight:bold;" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
							echo "<td style='font-weight:bold;" . $pageContent["tablestyle_text_center"] . "' colspan='2'>&nbsp;</td>";

							for ($y = 0; $y < sizeof($muestrasActuales); $y++) {
								echo "<td style='font-weight:bold;" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
								echo "<td style='font-weight:bold;" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
								echo "<td style='font-weight:bold;" . (($y + 1) == sizeof($muestrasActuales) ? $pageContent["tablestyle_border_right"] : "") . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
							}
							echo "</tr>";
						} else {
							echo "<tr style='background-color:" . $trBackgroundColor . ";font-size:6px;'>";
							echo "<td style='" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>" . ($itemCounterLocal + 1) . "</td>";
							echo "<td style='" . $pageContent["tablestyle_text_left"] . "' colspan='2'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounterLocal] . "</td>";



							// Procesar solo las muestras correspondientes a esta tabla
							for ($y = 0; $y < sizeof($muestrasActuales); $y++) {
								$indiceOriginalMuestra = $offsetMuestra + $y;


								$sampleIdActual = $pageContent["labconfigurationitemsforthewholeround"]["id_muestra"][$itemCounterLocal][$indiceOriginalMuestra];
								$calculoAnalitoMuestra = $controllerMediaDeComparacionTodosLosParticipantes->getCalculoPorAnalitoIdMuestraId(
									$configurationids["id_analito"][$itemCounterLocal],
									$sampleIdActual,
									$configurationids["id_metodologia"][$itemCounterLocal],
									$configurationids["id_unidad"][$itemCounterLocal],
									$configurationids["id_analizador"][$itemCounterLocal]
								);


								$FECHA_INICIO_NUEVA_FORMULA_ZSCORE = strtotime("2025-06-01");
								// la siguiente comparacion puede fallar luego del 2038 por el overflow de la unix epoch
								if (isset($fechasMuestras[$sampleIdActual]) && strtotime($fechasMuestras[$sampleIdActual]) < $FECHA_INICIO_NUEVA_FORMULA_ZSCORE) {
									// zscore = ((resultado reportado por el lab) - (media de consenso)) / desviación estándar de consenso
									$calculoAnalitoMuestra["zscore"] = (floatval($calculoAnalitoMuestra["valor_lab"]) - $calculoAnalitoMuestra["media"]) / $calculoAnalitoMuestra["de"];
								}
								if ($calculoAnalitoMuestra["n"] >= 4 && $fechasMuestras[$sampleIdActual] <= $fechasMuestras[$sampleid]) {
									$arrayCalculosModificadosConsenso[] = $calculoAnalitoMuestra;
								}



								$calculoAnalitoMuestra["color"] = "";
								if ($calculoAnalitoMuestra["zscore"] !== "" && $calculoAnalitoMuestra["zscore"] !== null && is_numeric($calculoAnalitoMuestra["zscore"]) && $calculoAnalitoMuestra["n"] >= 4) {
									if (abs($calculoAnalitoMuestra["zscore"]) <= 2) {
										$calculoAnalitoMuestra["color"] = "#afffaf"; // Verde
									} else if (abs($calculoAnalitoMuestra["zscore"]) > 2 && abs($calculoAnalitoMuestra["zscore"]) <= 3) {
										$calculoAnalitoMuestra["color"] = "#ffff7d"; // Amarillo
									} else if (abs($calculoAnalitoMuestra["zscore"]) > 3) {
										$calculoAnalitoMuestra["color"] = "#ff7d7d"; // Rojo
									}
								}

								if (($indiceOriginalMuestra + 1) <= $pageContent["programsamplenumber"]) {
									$badge = "";

									if ($pageContent["labconfigurationitemsforthewholeround"]["fecha_resultado"][$itemCounterLocal][$indiceOriginalMuestra] == "" || $pageContent["labconfigurationitemsforthewholeround"]["fecha_muestra"][$itemCounterLocal][$indiceOriginalMuestra] == "") {
										//
									} else {
										if (strtotime($pageContent["labconfigurationitemsforthewholeround"]["fecha_resultado"][$itemCounterLocal][$indiceOriginalMuestra]) > strtotime($pageContent["labconfigurationitemsforthewholeround"]["fecha_muestra"][$itemCounterLocal][$indiceOriginalMuestra]) && ($indiceOriginalMuestra + 1) <= $pageContent["programsamplenumber"]) {
											if ($filterArray[5]) {
												$badge = $badge . "<span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span>";
												$pageContent["ammountoflateresults"] = $pageContent["ammountoflateresults"] + 1;
												$notificaciones_muestra[$indiceOriginalMuestra]["tardio"] = $notificaciones_muestra[$indiceOriginalMuestra]["tardio"] + 1;
											}
										}
									}

									if ($pageContent["labconfigurationitemsforthewholeround"]["resultado"][$itemCounterLocal][$indiceOriginalMuestra] == "" && ($indiceOriginalMuestra + 1) <= $pageContent["programsamplenumber"]) {
										if ($filterArray[6]) {
											$badge = $badge . "<span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span>";
											$pageContent["ammountofemptyresults"] = $pageContent["ammountofemptyresults"] + 1;
											$notificaciones_muestra[$indiceOriginalMuestra]["ausente"] = $notificaciones_muestra[$indiceOriginalMuestra]["ausente"] + 1;
										}
									}

									if ($pageContent["labconfigurationitemsforthewholeround"]["editado"][$itemCounterLocal][$indiceOriginalMuestra] == 1 && ($indiceOriginalMuestra + 1) <= $pageContent["programsamplenumber"]) {
										if ($filterArray[7]) {
											$badge = $badge . "<span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span>";
											$pageContent["ammountofeditedresults"] = $pageContent["ammountofeditedresults"] + 1;
											$notificaciones_muestra[$indiceOriginalMuestra]["revalorado"] = $notificaciones_muestra[$indiceOriginalMuestra]["revalorado"] + 1;
										}
									}

									// Indicadores de los Zscore (Zscore WWR)
									if ($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$itemCounterLocal][$indiceOriginalMuestra] === "" || $pageContent["labconfigurationitemsforthewholeround"]["resultado"][$itemCounterLocal][$indiceOriginalMuestra] == "") {
										$alertColor = "";
										$alertIcon = "";
									} else {
										if ($pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$itemCounterLocal][$indiceOriginalMuestra] == 1) {
											$alertColor = "#afffaf"; // Verde
											$alertIcon = "<span class='glyphicon glyphicon-thumbs-up'></span>";
										} else if ($pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$itemCounterLocal][$indiceOriginalMuestra] == 2) {
											$alertColor = "#ffff7d"; // Rojo
											$alertIcon = "<span class='glyphicon glyphicon-thumbs-up'></span>";
										} else if ($pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$itemCounterLocal][$indiceOriginalMuestra] == 3) {
											$alertColor = "#ff7d7d"; // Amarillo
											$alertIcon = "<span class='glyphicon glyphicon-thumbs-down'></span>";
										} else if ($pageContent["labconfigurationitemsforthewholeround"]["zscoreperformance"][$itemCounterLocal][$indiceOriginalMuestra] === null) {
											$alertColor = "";
											$alertIcon = "";
										}
									}

									// Zscore de participantes
									if (
										$pageContent["labconfigurationitemsforthewholeround"]["tipo_media_comparacion"][$itemCounterLocal][$indiceOriginalMuestra] != 4 &&
										$calculoAnalitoMuestra["n"] < 4
									) {
										$alertColor3 = "";
									} else {
										$indicador = $controllerMediaDeComparacionTodosLosParticipantes->getIndicadorAnalitoMuestraUnidad(
											$configurationids["id_analito"][$itemCounterLocal],
											$pageContent["labconfigurationitemsforthewholeround"]["id_muestra"][$itemCounterLocal][$indiceOriginalMuestra],
											$configurationids["id_metodologia"][$itemCounterLocal],
											$configurationids["id_unidad"][$itemCounterLocal],
											$configurationids["id_analizador"][$itemCounterLocal]
										);

										if ($indicador == 1) {
											$alertColor3 = "#afffaf"; // Verde
										} else if ($indicador == 0) {
											$alertColor3 = "#ffff7d"; // Amarillo
										} else {
											$alertColor3 = "#ff7d7d"; // Rojo
										}
									}

									// Zscore de JCTLM
									if ($pageContent["labconfigurationitemsforthewholeround"]["sampleperformancereference"][$itemCounterLocal][$indiceOriginalMuestra] === null) {
										$alertColor2 = "";
										$alertIcon2 = "";
									} else {
										if ($pageContent["labconfigurationitemsforthewholeround"]["sampleperformancereference"][$itemCounterLocal][$indiceOriginalMuestra] === 0) {
											$alertColor2 = "#ff7d7d"; // Rojo
											$alertIcon2 = "<span class='glyphicon glyphicon-thumbs-down'></span>";
										} else if ($pageContent["labconfigurationitemsforthewholeround"]["sampleperformancereference"][$itemCounterLocal][$indiceOriginalMuestra] == 1) {
											$alertColor2 = "#afffaf"; // Verde
											$alertIcon2 = "<span class='glyphicon glyphicon-thumbs-up'></span>";
										} else if ($pageContent["labconfigurationitemsforthewholeround"]["sampleperformancereference"][$itemCounterLocal][$indiceOriginalMuestra] === null) {
											$alertColor2 = "";
											$alertIcon2 = "";
										}
									}

									// Impresión de los valores
									// 6. Resumen de ronda participantes QAP
									// zscore 6.
									echo "<td style='" . $pageContent["tablestyle_text_center"] . ";background-color:" . $alertColor2 . ";'>" . (($pageContent["labconfigurationitemsforthewholeround"]["deviationpercentagereference"][$itemCounterLocal][$indiceOriginalMuestra] === "") ? "N/A" : $pageContent["labconfigurationitemsforthewholeround"]["deviationpercentagereference"][$itemCounterLocal][$indiceOriginalMuestra]) . "</td>";
									echo "<td style='" . $pageContent["tablestyle_text_center"] . ";background-color:" . $alertColor . ";'>" . (($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$itemCounterLocal][$indiceOriginalMuestra] === "") ? "N/A" : $pageContent["labconfigurationitemsforthewholeround"]["zscore"][$itemCounterLocal][$indiceOriginalMuestra]) . "</td>";
									if ($pageContent["labconfigurationitemsforthewholeround"]["zscore"][$itemCounterLocal][$indiceOriginalMuestra] !== "") {
										$arrayCalculosModificadosInternacional[] = [
											"zscore" => $pageContent["labconfigurationitemsforthewholeround"]["zscore"][$itemCounterLocal][$indiceOriginalMuestra],
											"n" => 10
										];
									}
									echo "<td style='" . (($y + 1) == sizeof($muestrasActuales) ? $pageContent["tablestyle_border_right"] : "") . $pageContent["tablestyle_text_center"] . ";background-color:" . $calculoAnalitoMuestra["color"] . ";'>" . (($calculoAnalitoMuestra["n"] < 4) ? "N/A" : round($calculoAnalitoMuestra["zscore"], 2)) . "</td>";

									$badge = "";
									$alertColor = "";
									$alertIcon = "";
									$alertColor2 = "";
									$alertIcon2 = "";
								} else {
									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
									echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
									echo "<td style='" . (($y + 1) == sizeof($muestrasActuales) ? $pageContent["tablestyle_border_right"] : "") . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
								}

							}
							echo "</tr>";
						}
						$itemCounterLocal++;
					}

					// Impresión de valores de notificaciones
					echo "<tr style='font-size:8px; text-align:center'>";
					echo "<td colspan='3' style='font-size:7px; border: 1px solid #ccc; border-left: 1px solid #333;'><strong>Notificaciones<strong></td>";

					for ($num_muestra = 0; $num_muestra < sizeof($muestrasActuales); $num_muestra++) {
						$indiceOriginalNotif = $offsetMuestra + $num_muestra;
						$border_ultimo = "";

						if (($num_muestra + 1) == sizeof($muestrasActuales)) {
							$border_ultimo = "border-right:1px solid #333;";
						}

						echo (
							"<td colspan='3' style='border: 1px solid #ccc;" . $border_ultimo . "'>" .
							"<span style='font-family:Wingdings;'><span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span></span>" .
							" " .
							(isset($notificaciones_muestra[$indiceOriginalNotif]["tardio"]) ? $notificaciones_muestra[$indiceOriginalNotif]["tardio"] : 0) .
							" " .
							"<span style='font-family:Wingdings;'><span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span></span>" .
							" " .
							(isset($notificaciones_muestra[$indiceOriginalNotif]["ausente"]) ? $notificaciones_muestra[$indiceOriginalNotif]["ausente"] : 0) .
							" " .
							"<span style='font-family:Wingdings;'><span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span></span>" .
							" " .
							(isset($notificaciones_muestra[$indiceOriginalNotif]["revalorado"]) ? $notificaciones_muestra[$indiceOriginalNotif]["revalorado"] : 0) .
							"</td>"
						);
					}
					echo "</tr>";

					echo "</tbody>";
					echo "</table>";
					tablePrinter('tableend', 'null');
					tablePrinter('br', 'no_border');
					tablePrinter('tablenotifications', 'notification2');
					tablePrinter('br', 'no_border');
					echo "</div>";

				}

				// Reiniciar el contador principal
				$itemCounter = sizeof($configurationids["id_analito"]);
				echo "<!-- sheet separator -->";

				break;
			case 2:



				$repeat = true;

				// $maxRows = 20;
		
				$itemCounter = 0;



				// while ($repeat) {
		


				echo "<div class='col margin-top-1 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

				tablePrinter('header2', '3. RESUMEN DE RONDA', $labid, $sampleid);

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;'>";

				echo "<tbody>";

				echo "<tr style='font-size:8px;font-weight:bold;'>";

				echo "<th style='" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' >Ítem<br></th>";

				echo "<th style='" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>Mensurando<br></th>";

				echo "<th style='" . $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>% de concordancia<br></th>";



				if (isset($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0])) {

					for ($x = 0; $x < sizeof($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0]); $x++) {



						echo "<th style='" . (($x + 1) == sizeof($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0]) ? $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_right"] . $pageContent["tablestyle_border_top"] : $pageContent["tablestyle_border_bottom"] . $pageContent["tablestyle_border_top"]) . $pageContent["tablestyle_text_center"] . "' colspan='2'>Muestra " . $pageContent["labconfigurationitemsforthewholeround"]["muestra"][0][$x] . "<br></th>";
					}
				}



				echo "</tr>";



				for ($x = 0; $x < sizeof($configurationids["id_analito"]); $x++) {



					$sampleperformance1 = 0;

					$sampleperformancePercentage = 0;



					if (isset($pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x])) {

						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x]); $y++) {

							if (($y + 1) <= $pageContent["programsamplenumber"]) {

								if ($pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$x][$y] == 1) {

									$sampleperformance1 += 1;
								}
							} else {

								break 1;
							}
						}
					}



					if ($pageContent["programsamplenumber"] > 0) {

						$sampleperformancePercentage = round(($sampleperformance1 * 100) / $pageContent["programsamplenumber"], 2) . "%";
					} else {

						$sampleperformancePercentage = "";
					}



					if ((($x + 1) % 2) == 0) {

						$trBackgroundColor = "white";
					} else {

						$trBackgroundColor = "#f2f2f2";
					}



					if (!isset($configurationids["id_analito"][$itemCounter])) {



						echo "<tr style='background-color:" . $trBackgroundColor . ";font-size:7px;'>";



						echo "<td style='" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "' colspan='3'>&nbsp;</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "' colspan='3'>&nbsp;</td>";



						if (isset($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0])) {

							for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0]); $y++) {



								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";

								echo "<td style='" . (($y + 1) == sizeof($pageContent["labconfigurationitemsforthewholeround"]["muestra"][0]) ? $pageContent["tablestyle_border_right"] : "") . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
							}
						}



						echo "</tr>";
					} else {



						echo "<tr style='background-color:" . $trBackgroundColor . ";font-size:7px;'>";



						echo "<td style='" . $pageContent["tablestyle_border_left"] . $pageContent["tablestyle_text_center"] . "'>" . ($itemCounter + 1) . "</td>";

						echo "<td style='" . $pageContent["tablestyle_text_left"] . $pageContent["tablestyle_text_center"] . "' colspan='4'>" . $pageContent["labconfigurationitems"]["nombre_analito"][$itemCounter] . "</td>";

						echo "<td style='" . $pageContent["tablestyle_text_center"] . "' colspan='2'>$sampleperformancePercentage</td>";



						for ($y = 0; $y < sizeof($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter]); $y++) {



							if (($y + 1) <= $pageContent["programsamplenumber"]) {



								$badge = "";



								if ($pageContent["labconfigurationitemsforthewholeround"]["fecha_resultado"][$itemCounter][$y] == "" || $pageContent["labconfigurationitemsforthewholeround"]["fecha_muestra"][$itemCounter][$y] == "") {

									//
		
								} else {

									if (strtotime($pageContent["labconfigurationitemsforthewholeround"]["fecha_resultado"][$itemCounter][$y]) > strtotime($pageContent["labconfigurationitemsforthewholeround"]["fecha_muestra"][$itemCounter][$y]) && ($y + 1) <= $pageContent["programsamplenumber"]) {

										if ($filterArray[5]) {

											$badge = $badge . "<span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span>";

											$pageContent["ammountoflateresults"] += 1;
										}
									}
								}

								if ($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter][$y] == "" && ($y + 1) <= $pageContent["programsamplenumber"]) {

									if ($filterArray[6]) {

										$badge = $badge . "<span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span>";

										$pageContent["ammountofemptyresults"] += 1;
									}
								}

								if ($pageContent["labconfigurationitemsforthewholeround"]["editado"][$itemCounter][$y] == 1 && ($y + 1) <= $pageContent["programsamplenumber"]) {

									if ($filterArray[7]) {

										$badge = $badge . "<span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span>";

										$pageContent["ammountofeditedresults"] += 1;
									}
								}



								if ($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter][$y] == "") {

									$alertColor = "";

									$alertIcon = "";

									$pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter][$y] = "";
								} else {

									if ($pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$itemCounter][$y] == 1) {

										$alertColor = "#afffaf";

										$alertIcon = "<span class='glyphicon glyphicon-thumbs-up'></span>";
									} else if ($pageContent["labconfigurationitemsforthewholeround"]["sampleperformance"][$itemCounter][$y] == 0) {

										$alertColor = "#ff7d7d";

										$alertIcon = "<span class='glyphicon glyphicon-thumbs-down'></span>";
									}
								}







								$textoSeparador = "";



								if (strpos($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter][$y], $pageContent["separador_analito_resultado_reporte_cualitativo"])) { // Si tiene el separador
		
									$arrayIntervalo = explode($pageContent["separador_analito_resultado_reporte_cualitativo"], $pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter][$y]);



									if ($arrayIntervalo[1] != "") {

										$textoSeparador = $arrayIntervalo[0] . " hasta " . $arrayIntervalo[1];
									} else {

										$textoSeparador = $arrayIntervalo[0] . " o más";
									}
								} else {

									$textoSeparador = $pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter][$y];
								}



								echo "<td style='" . $pageContent["tablestyle_text_center"] . "font-family:Wingdings;'>" . $badge . "</td>";

								echo "<td style='" . (($y + 1) == sizeof($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter]) ? $pageContent["tablestyle_border_right"] : "") . $pageContent["tablestyle_text_center"] . "background-color:" . $alertColor . ";'>" .

									/*$pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter][$y].*/

									$textoSeparador .

									"</td>";



								$badge = "";

								$alertColor = "";

								$alertIcon = "";
							} else {



								echo "<td style='" . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";

								echo "<td style='" . (($y + 1) == sizeof($pageContent["labconfigurationitemsforthewholeround"]["resultado_reporte_cualitativo"][$itemCounter]) ? $pageContent["tablestyle_border_right"] : "") . $pageContent["tablestyle_text_center"] . "'>&nbsp;</td>";
							}
						}



						echo "</tr>";
					}



					$itemCounter++;
				}




				echo "</tbody>";

				echo "</table>";

				tablePrinter('tableend', 'null');

				tablePrinter('br', 'no_border');

				tablePrinter('tablenotifications', 'null');

				tablePrinter('br', 'no_border');

				echo "</div>";



				echo "<!-- sheet separator -->";

				// }		
		


				break;
		}
		// Crea una instancia del controlador para acceder al método de cálculo
		$mediaController = new MediaDeComparacionController();

		// Recalcula los porcentajes con el método y el array de resultados modificado
		$nuevosIndicadoresInternacional = $mediaController->calcularPorcentajesDesdeArraySimple($arrayCalculosModificadosInternacional);
		$nuevosIndicadoresConsenso = $mediaController->calcularPorcentajesDesdeArraySimple($arrayCalculosModificadosConsenso);

		// Sobrescribe los porcentajes de la variable global para el consenso
		$indicadoresGenerales["porcentaje"]["satisfactorio"] = $nuevosIndicadoresConsenso["porcentaje"]["satisfactorio"];
		$indicadoresGenerales["porcentaje"]["alarma"] = $nuevosIndicadoresConsenso["porcentaje"]["alarma"];
		$indicadoresGenerales["porcentaje"]["no_satisfactorio"] = $nuevosIndicadoresConsenso["porcentaje"]["no_satisfactorio"];
		$indicadoresGenerales["resultados"]["satisfactorio"] = $nuevosIndicadoresConsenso["resultados"]["satisfactorio"];
		$indicadoresGenerales["resultados"]["alarma"] = $nuevosIndicadoresConsenso["resultados"]["alarma"];
		$indicadoresGenerales["resultados"]["no_satisfactorio"] = $nuevosIndicadoresConsenso["resultados"]["no_satisfactorio"];


		// Sobrescribe los porcentajes de la variable global para la media Internacional
		$indicadoresGeneralesInternacional["porcentaje"]["satisfactorio"] = $nuevosIndicadoresInternacional["porcentaje"]["satisfactorio"];
		$indicadoresGeneralesInternacional["porcentaje"]["alarma"] = $nuevosIndicadoresInternacional["porcentaje"]["alarma"];
		$indicadoresGeneralesInternacional["porcentaje"]["no_satisfactorio"] = $nuevosIndicadoresInternacional["porcentaje"]["no_satisfactorio"];
		$indicadoresGeneralesInternacional["resultados"]["satisfactorio"] = $nuevosIndicadoresInternacional["resultados"]["satisfactorio"];
		$indicadoresGeneralesInternacional["resultados"]["alarma"] = $nuevosIndicadoresInternacional["resultados"]["alarma"];
		$indicadoresGeneralesInternacional["resultados"]["no_satisfactorio"] = $nuevosIndicadoresInternacional["resultados"]["no_satisfactorio"];



		switch ($pageContent["programtype"]) {

			case 1:



				$chartValues_17 = md5(uniqid(rand(), true));

				$chartValues_18 = $indicadoresGeneralesInternacional["porcentaje"]["satisfactorio"] . "|" .
					$indicadoresGeneralesInternacional["porcentaje"]["alarma"] . "|" .
					$indicadoresGeneralesInternacional["porcentaje"]["no_satisfactorio"];



				$chartValues_19 = md5(uniqid(rand(), true));

				if ((($pageContent["ammountofsatisfactoryreferenceresults"] * 100) != 0 || $pageContent["ammounttotalofreportedreferenceanalytes"] != 0) || (($pageContent["ammountofunsatisfactoryreferenceresults"] * 100) != 0)) {

					$chartValues_20 = round(($pageContent["ammountofsatisfactoryreferenceresults"] * 100) / $pageContent["ammounttotalofreportedreferenceanalytesforthewholeround"], 2) . "|" . round(($pageContent["ammountofunsatisfactoryreferenceresults"] * 100) / $pageContent["ammounttotalofreportedreferenceanalytesforthewholeround"], 2);
				} else {

					$chartValues_20 = "0|0";
				}



				$chartValues_31 = md5(uniqid(rand(), true));

				$chartValues_32 = $indicadoresGenerales["porcentaje"]["satisfactorio"] . "|" . $indicadoresGenerales["porcentaje"]["alarma"] . "|" . $indicadoresGenerales["porcentaje"]["no_satisfactorio"];



				echo "<span style='color:white;' data-chart-container='5' data-chart-content='1' hidden='hidden'>" . $chartValues_17 . "</span>";

				echo "<span style='color:white;' data-chart-container='5' data-chart-content='2' hidden='hidden'>" . $chartValues_18 . "</span>";



				echo "<span style='color:white;' data-chart-container='6' data-chart-content='1' hidden='hidden'>" . $chartValues_19 . "</span>";

				echo "<span style='color:white;' data-chart-container='6' data-chart-content='2' hidden='hidden'>" . $chartValues_20 . "</span>";



				echo "<span style='color:white;' data-chart-container='9' data-chart-content='1' hidden='hidden'>" . $chartValues_31 . "</span>";

				echo "<span style='color:white;' data-chart-container='9' data-chart-content='2' hidden='hidden'>" . $chartValues_32 . "</span>";





				echo "<div class='col margin-top-1 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

				tablePrinter('header2', '7. INDICADORES DE COMPETENCIA TÉCNICA', $labid, $sampleid);

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;' cellpadding='3' cellspacing='0'>";

				echo "<thead>";

				echo "<tr>";



				if ($pageContent["programsamplenumber"] == 1) {

					$texto_subtitulo = "7.1. desempeño para la muestra " . $pageContent["programsamplenumber"];
				} else {

					$texto_subtitulo = "7.1. desempeño para las " . $pageContent["programsamplenumber"] . " muestras";
				}



				echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_bold"] . $pageContent["tablestyle_text_center"] . $pageContent["tablestyle_text_color"] . "font-size:8pt;'>" . mb_strtoupper($texto_subtitulo, "utf-8") . "</th>";

				echo "</tr>";

				echo "</thead>";

				echo "</table>";

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

				echo "<tbody>";

				echo "<tr>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='6'><img data-src='php/temp_chart/" . $chartValues_17 . ".jpg' data-chart-frame='1'></img></td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='6'><img data-src='php/temp_chart/" . $chartValues_19 . ".jpg' data-chart-frame='1'></img></td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='6'><img data-src='php/temp_chart/" . $chartValues_31 . ".jpg' data-chart-frame='1'></img></td>"; // Grafica de participantes QAP
		
				echo "</tr>";

				echo "<tr style='font-size:8px;'>";

				echo "<td style='background-color:#afffaf; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>Satisfactorio</td>";

				echo "<td style='background-color:#ffff7d; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>Alarma</td>";

				echo "<td style='background-color:#ff7d7d; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>No satisfactorio</td>";



				echo "<td style='background-color:#afffaf; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>Satisfactorio</td>";

				echo "<td style='background-color:#ff7d7d; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>No satisfactorio</td>";



				echo "<td style='background-color:#afffaf; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>Satisfactorio</td>";

				echo "<td style='background-color:#ffff7d; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>Alarma</td>";

				echo "<td style='background-color:#ff7d7d; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>No satisfactorio</td>";

				echo "</tr>";

				echo "<tr style='font-size:8px;'>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGeneralesInternacional["resultados"]["satisfactorio"] . "</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGeneralesInternacional["resultados"]["alarma"] . "</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGeneralesInternacional["resultados"]["no_satisfactorio"] . "</td>";



				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . $pageContent["ammountofsatisfactoryreferenceresults"] . "</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . $pageContent["ammountofunsatisfactoryreferenceresults"] . "</td>";



				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGenerales["resultados"]["satisfactorio"] . "</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGenerales["resultados"]["alarma"] . "</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGenerales["resultados"]["no_satisfactorio"] . "</td>";

				echo "</tr>";



				echo "<tr style='font-size:8px;'>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGeneralesInternacional["porcentaje"]["satisfactorio"] . "%</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGeneralesInternacional["porcentaje"]["alarma"] . "%</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGeneralesInternacional["porcentaje"]["no_satisfactorio"] . "%</td>";



				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . ((($pageContent["ammountofsatisfactoryreferenceresults"] * 100) != 0 || $pageContent["ammounttotalofreportedreferenceanalytesforthewholeround"] != 0) ? round(($pageContent["ammountofsatisfactoryreferenceresults"] * 100) / $pageContent["ammounttotalofreportedreferenceanalytesforthewholeround"], 2) : "0") . "%</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . ((($pageContent["ammountofunsatisfactoryreferenceresults"] * 100) != 0 || $pageContent["ammounttotalofreportedreferenceanalytesforthewholeround"] != 0) ? round(($pageContent["ammountofunsatisfactoryreferenceresults"] * 100) / $pageContent["ammounttotalofreportedreferenceanalytesforthewholeround"], 2) : "0") . "%</td>";



				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGenerales["porcentaje"]["satisfactorio"] . "%</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGenerales["porcentaje"]["alarma"] . "%</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='2'>" . $indicadoresGenerales["porcentaje"]["no_satisfactorio"] . "%</td>";

				echo "</tr>";

				echo "</tbody>";

				echo "</table>";



				tablePrinter('br', 'no_border');



				echo "<table style='width: 100%;font-size:9px;'>";

				echo "<tbody>";

				echo "<tr>";

				echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>Observaciones:</th>";

				echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>Revisado por:</th>";

				echo "</tr>";

				echo "<tr>";

				echo "<td rowspan='3' style='" . $pageContent["tablestyle_border_all"] . " height: 200px;' id='sheetInput1' data-id='1'></td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . " height: 100px;' id='sheetInput2' data-id='2'>&nbsp;</td>";

				echo "</tr>";

				echo "<tr>";

				echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>Fecha:</th>";

				echo "</tr>";

				echo "<tr>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . " font-size:32pt;'>&nbsp;</td>";

				echo "</tr>";

				echo "</tbody>";

				echo "</table>";

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;font-size: 9px;'>";

				echo "<tbody>";

				echo "<tr>";

				echo "<td style='" . $pageContent["tablestyle_text_bold"] . $pageContent["tablestyle_text_center"] . "'></br>-- Final de reporte --</br></br></br></br></br></br></br></br>Aprobado por:</br>Coordinador Programas QAP</br>
				
				<div style='text-align: right; margin-top: 20px;'>
                                            Coordinador QAP:</br>
                                            María Paula Mora Gamboa</br>
                                            Contacto: 3174399931</br>
                                            Correo: maria.mora@quik.com.co
                                        </div>
				</td>";

				echo "</tr>";

				echo "</tbody>";

				echo "</table>";

				echo "</div>";



				break;

			case 2:



				$chartValues_17 = md5(uniqid(rand(), true));

				$chartValues_18 = round(($pageContent["ammountofsatisfactoryresultsforthewholeround"] * 100) / $pageContent["ammounttotalofreportedanalytes"], 2) . "|" . round(($pageContent["ammountofunsatisfactoryresultsforthewholeround"] * 100) / $pageContent["ammounttotalofreportedanalytes"], 2);

				$chartValues_19 = md5(uniqid(rand(), true));

				$chartValues_20 = round(($pageContent["ammountofsatisfactoryresultsforthewholeroundmisc"] * 100) / $pageContent["ammounttotalofreportedanalytesmisc"], 2) . "|" . round(($pageContent["ammountofunsatisfactoryresultsforthewholeroundmisc"] * 100) / $pageContent["ammounttotalofreportedanalytesmisc"], 2);





				echo "<span style='color:white;' data-chart-container='7' data-chart-content='1' hidden='hidden'>" . $chartValues_17 . "</span>";

				echo "<span style='color:white;' data-chart-container='7' data-chart-content='2' hidden='hidden'>" . $chartValues_18 . "</span>";

				echo "<span style='color:white;' data-chart-container='8' data-chart-content='1' hidden='hidden'>" . $chartValues_19 . "</span>";

				echo "<span style='color:white;' data-chart-container='8' data-chart-content='2' hidden='hidden'>" . $chartValues_20 . "</span>";



				echo "<div class='col margin-top-1 margin-bottom-1 sheet' data-sheet='true' title='216|279' style='width:864px !important; height:1115px !important; margin: auto;' alt='P' id='" . md5(uniqid(rand(), true)) . "'>";

				tablePrinter('header2', '4. INDICADORES DE COMPETENCIA TÉCNICA', $labid, $sampleid);

				tablePrinter('br', 'no_border');

				echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

				echo "<tbody>";

				echo "<tr>";

				echo "<td>&nbsp;</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='6'><img data-src='php/temp_chart/" . $chartValues_17 . ".jpg' data-chart-frame='1'></img></td>";

				echo "<td>&nbsp;</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='6'><img data-src='php/temp_chart/" . $chartValues_19 . ".jpg' data-chart-frame='1'></img></td>";

				echo "<td>&nbsp;</td>";

				echo "</tr>";

				echo "<tr style='font-size:8px;'>";

				echo "<td>&nbsp;</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_bold"] . $pageContent["tablestyle_text_center"] . "' colspan='6'>ANÁLISIS FÍSICO QUÍMICO</td>";

				echo "<td>&nbsp;</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_bold"] . $pageContent["tablestyle_text_center"] . "' colspan='6'>ANÁLISIS MICROSCÓPICO</td>";

				echo "<td>&nbsp;</td>";

				echo "</tr>";

				echo "<tr style='font-size:8px;'>";

				echo "<td>&nbsp;</td>";

				echo "<td style='background-color:#afffaf; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>Satisfactorio</td>";

				echo "<td style='background-color:#ff7d7d; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>No satisfactorio</td>";

				echo "<td>&nbsp;</td>";

				echo "<td style='background-color:#afffaf; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>Satisfactorio</td>";

				echo "<td style='background-color:#ff7d7d; " . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>No satisfactorio</td>";

				echo "<td>&nbsp;</td>";

				echo "</tr>";

				echo "<tr style='font-size:8px;'>";

				echo "<td>&nbsp;</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . $pageContent["ammountofsatisfactoryresultsforthewholeround"] . "</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . $pageContent["ammountofunsatisfactoryresultsforthewholeround"] . "</td>";

				echo "<td>&nbsp;</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . $pageContent["ammountofsatisfactoryresultsforthewholeroundmisc"] . "</td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "' colspan='3'>" . $pageContent["ammountofunsatisfactoryresultsforthewholeroundmisc"] . "</td>";

				echo "<td>&nbsp;</td>";

				echo "</tr>";

				echo "</tbody>";

				echo "</table>";

				tablePrinter('br', 'no_border');



				echo "<table style='width: 100%;font-size:9px;'>";

				echo "<tbody>";

				echo "<tr>";

				echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>Observaciones:</th>";

				echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>Revisado por:</th>";

				echo "</tr>";

				echo "<tr>";

				echo "<td rowspan='3' style='" . $pageContent["tablestyle_border_all"] . " height: 200px;' id='sheetInput1' data-id='1'></td>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . " height: 100px;' id='sheetInput2' data-id='2'>&nbsp;</td>";

				echo "</tr>";

				echo "<tr>";

				echo "<th style='" . $pageContent["tablestyle_border_all"] . $pageContent["tablestyle_text_center"] . "'>Fecha:</th>";

				echo "</tr>";

				echo "<tr>";

				echo "<td style='" . $pageContent["tablestyle_border_all"] . " font-size:32pt;'>&nbsp;</td>";

				echo "</tr>";

				echo "</tbody>";

				echo "</table>";

				tablePrinter('br', 'no_border');



				echo "<table style='width: 100%;font-size:9px;'>";

				echo "<tbody>";

				echo "<tr>";

				echo "<td style='" . $pageContent["tablestyle_text_bold"] . $pageContent["tablestyle_text_center"] . "'>-- Final de reporte --</br></br></br></br></br></br></br>Aprobado por:</br>Aída Porras. Magister en Biología. Doctor in management.</br>Coordinadora programas QAP</td>";

				echo "</tr>";

				echo "</tbody>";

				echo "</table>";

				tablePrinter('footer', 9);

				echo "</div>";



				break;
		}



		?>



	</div>



	<script src="jquery/jquery-2.1.4.min.js?v12"></script>

	<script src="jquery/jquery-ui.min.js?v12"></script>

	<script src="jquery/jquery.md5.js?v12"></script>

	<script src="jquery/jquery.statusBox.js?v12"></script>

	<script src="javascript/bootstrap.min.js?v12"></script>

	<script src="javascript/inner_resultado_1_general.js?v12"></script>




</body>

</html>