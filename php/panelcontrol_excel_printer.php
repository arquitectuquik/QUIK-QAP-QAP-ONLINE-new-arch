<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	session_start();
	include_once"verifica_sesion.php";
	
	actionRestriction_102();
	
	require_once 'PHPExcel/IOFactory.php';
	require_once 'PHPExcel.php';
	
	$header = $_GET['header'];
	
	if (!isset($_GET['filter'])) {
		$_GET['filter'] = '';
	}
	
	if (!isset($_GET['filterid'])) {
		$_GET['filterid'] = '';
	}
	
	$filter = $_GET['filter'];
	$filterid = $_GET['filterid'];

	$orden_dato = $_GET['orden_dato'];
	//var_dump($orden_dato);
	//exit();

	if ($filter == "") {
		$filter = "NULL";
	}
	if ($filterid == "") {
		$filterid = "NULL";
	}
	
	$filename = "QAP-FOR-02";
	
	switch($header) {
		case 'exportSelectedLab':
		case 'exportAllLabs':

			switch ($filterid) {
				case 'id_array':
					$filterArray = explode("|",$filter);
					
					for ($x = 0; $x < sizeof($filterArray); $x++) {
						if ($filterArray[$x] == "") {
							$filterArray[$x] = "NULL";
						}
					}

					$filterQry = "WHERE $tbl_programa.id_programa = $filterArray[1] AND $tbl_laboratorio.id_laboratorio = $filterArray[0]";
					
				break;
				case 'id_programa':
					$filterQry = "WHERE $tbl_programa.id_programa = ".$filter;
				break;			
				default:
					$filterQry = '';
				break;
			}
			switch ($orden_dato) {
				case '2':
					$qry = "SELECT $tbl_configuracion_laboratorio_analito.id_configuracion,nombre_programa,nombre_analito,nombre_analizador,nombre_metodologia,nombre_reactivo,nombre_unidad,valor_gen_vitros,nombre_material,activo,$tbl_laboratorio.nombre_laboratorio,$tbl_laboratorio.no_laboratorio,$tbl_configuracion_laboratorio_analito.id_analito,$tbl_configuracion_laboratorio_analito.id_unidad FROM $tbl_configuracion_laboratorio_analito INNER JOIN $tbl_programa ON $tbl_configuracion_laboratorio_analito.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_laboratorio ON $tbl_configuracion_laboratorio_analito.id_laboratorio = $tbl_laboratorio.id_laboratorio INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros LEFT JOIN $tbl_material ON $tbl_configuracion_laboratorio_analito.id_material = $tbl_material.id_material $filterQry ORDER BY nombre_laboratorio ASC";
					break;

				case '1':
				$qry = "SELECT $tbl_configuracion_laboratorio_analito.id_configuracion, $tbl_configuracion_laboratorio_analito.id_programa,nombre_programa,nombre_analito,nombre_analizador,nombre_metodologia,nombre_reactivo,nombre_unidad,valor_gen_vitros,nombre_material,activo,$tbl_laboratorio.nombre_laboratorio,$tbl_laboratorio.no_laboratorio,$tbl_configuracion_laboratorio_analito.id_analito,$tbl_configuracion_laboratorio_analito.id_unidad FROM $tbl_configuracion_laboratorio_analito INNER JOIN $tbl_programa ON $tbl_configuracion_laboratorio_analito.id_programa = $tbl_programa.id_programa INNER JOIN $tbl_laboratorio ON $tbl_configuracion_laboratorio_analito.id_laboratorio = $tbl_laboratorio.id_laboratorio INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros LEFT JOIN $tbl_material ON $tbl_configuracion_laboratorio_analito.id_material = $tbl_material.id_material $filterQry ORDER BY nombre_analito ASC";
					break;

				
				default:
					# code...
					break;
			}

			$qryArray = mysql_query($qry);
			mysqlException(mysql_error(),$header."_01");			
			
			$returnArray_0 = array();
			$returnArray_1 = array();
			$returnArray_2 = array();
			$returnArray_3 = array();
			$returnArray_4 = array();
			$returnArray_5 = array();
			$returnArray_6 = array();
			$returnArray_7 = array();
			$returnArray_8 = array();
			$returnArray_9 = array();
			$returnArray_10 = array();
			$returnArray_11 = array();
			$programName = "";
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) 
			{

				
				$qry = "SELECT nombre_unidad_global, factor_conversion FROM $tbl_unidad_global_analito WHERE id_analito = ".$qryData['id_analito']." AND id_unidad = ".$qryData['id_unidad']." LIMIT 0,1";
				$innerQryArray1 = mysql_query($qry);
				$innerQryData1 = mysql_fetch_array($innerQryArray1);	
				mysqlException(mysql_error(),$header."_02");

				// METODO TRAZABLE CONSULTA POR ANALITO
				$qry_met = "SELECT GROUP_CONCAT($tbl_metodo_jctlm.desc_metodo_jctlm) AS metodo_trazable
				FROM $tbl_metodo_jctlm 
				left join $tbl_programa_analito 
				on $tbl_metodo_jctlm.id_analito = $tbl_programa_analito.id_analito and $tbl_programa_analito.id_programa = ".$filter ." where $tbl_metodo_jctlm.id_analito = ".$qryData['id_analito'] ." order by $tbl_metodo_jctlm.id_analito asc";


				$innerQryArraymetodo = mysql_query($qry_met);
				mysqlException(mysql_error(),$header."_02");

				while($innerQryDatametodo  = mysql_fetch_array($innerQryArraymetodo)) 
				{
					$returnArray_10[$x] = $innerQryDatametodo['metodo_trazable'];
				}


				// MATERIAL TRAZABLE CONSULTA POR ANALITO
				$qry_met = "SELECT GROUP_CONCAT($tbl_material_jctlm.desc_material_jctlm) AS material_trazable
				FROM $tbl_material_jctlm 
				left join $tbl_programa_analito 
				on $tbl_material_jctlm.id_analito = $tbl_programa_analito.id_analito and $tbl_programa_analito.id_programa = ".$filter ." where $tbl_material_jctlm.id_analito = ".$qryData['id_analito'] ." order by $tbl_material_jctlm.id_analito asc";


				$innerQryArraymetodo = mysql_query($qry_met);
				mysqlException(mysql_error(),$header."_02");
				
				while($innerQryDatametodo  = mysql_fetch_array($innerQryArraymetodo)) 
				{
					$returnArray_11[$x] = $innerQryDatametodo['material_trazable'];
				}

				
				$programName = $qryData['nombre_programa'];
				$returnArray_0[$x] = $qryData['id_configuracion'];
				$returnArray_1[$x] = $qryData['nombre_laboratorio'];
				$returnArray_2[$x] = $qryData['no_laboratorio'];
				$returnArray_3[$x] = $qryData['nombre_analito'];
				$returnArray_4[$x] = $qryData['nombre_analizador'];
				$returnArray_5[$x] = $qryData['nombre_metodologia'];

				$returnArray_6[$x] = $qryData['nombre_reactivo'];
				$returnArray_7[$x] = $qryData['nombre_unidad'];
				$returnArray_8[$x] = $innerQryData1['factor_conversion'];
				$returnArray_9[$x] = $innerQryData1['nombre_unidad_global'];
				
			
				$x++;
			}
			
			$filename.= " ".$programName;
			
			$returnArray_0 = array_reverse($returnArray_0);
			$returnArray_1 = array_reverse($returnArray_1);
			$returnArray_2 = array_reverse($returnArray_2);
			$returnArray_3 = array_reverse($returnArray_3);
			$returnArray_4 = array_reverse($returnArray_4);
			$returnArray_5 = array_reverse($returnArray_5);
			$returnArray_6 = array_reverse($returnArray_6);
			$returnArray_7 = array_reverse($returnArray_7);
			$returnArray_8 = array_reverse($returnArray_8);
			$returnArray_9 = array_reverse($returnArray_9);
			$returnArray_10 = array_reverse($returnArray_10);
			$returnArray_11 = array_reverse($returnArray_11);
			
			$objPHPExcel = PHPExcel_IOFactory::createReader('Excel2007');
			$objPHPExcel = $objPHPExcel->load('excelDoc/workbook.xlsx');
			
			$sheet = $objPHPExcel->getActiveSheet();
			
			$sheet->setCellValue('E8',date("d")."/".date("m")."/".date("Y"));
			$sheet->setCellValue('H8',"QAP-".$programName);
			
			$row = 12;
			
			for ($x = 0; $x < sizeof($returnArray_0); $x++) {
				
				$sheet->insertNewRowBefore($row, 1);
				
				$sheet->setCellValue('C'.$row,(sizeof($returnArray_0) - $x));
				$sheet->setCellValue('D'.$row,$returnArray_1[$x]);
				$sheet->setCellValue('E'.$row,$returnArray_2[$x]);
				$sheet->setCellValue('F'.$row,$returnArray_3[$x]);
				$sheet->setCellValue('G'.$row,$returnArray_4[$x]);
				$sheet->setCellValue('H'.$row,$returnArray_5[$x]);
				$sheet->setCellValue('I'.$row,$returnArray_6[$x]);
				$sheet->setCellValue('J'.$row,$returnArray_7[$x]);
				$sheet->setCellValue('K'.$row,$returnArray_8[$x]);
				$sheet->setCellValue('L'.$row,$returnArray_9[$x]);
				$sheet->setCellValue('M'.$row,$returnArray_10[$x]);
				$sheet->setCellValue('N'.$row,$returnArray_11[$x]);
				
				$styleArray = array(
					'alignment' => array(
						'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					),
					'borders' => array(
							'allborders' => array(
								'style' => PHPExcel_Style_Border::BORDER_THIN
							)
					)				
				);	
				
				$sheet->getStyle('C'.$row.':L'.$row)->getAlignment()->setWrapText(true);
				$sheet->getStyle('C'.$row.':L'.$row)->applyFromArray($styleArray);
				
			}
		
		break;
	}
	
	$sheet->removeRow(($row - 1), 1);
	
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
	header('Cache-Control: max-age=0');
	
	$objWriter=PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');	
	
	$objWriter->save('php://output');
	
	$objPHPExcel->disconnectWorksheets();
	unset($objPHPExcel);
	
	mysql_close($con);
	exit;
?>