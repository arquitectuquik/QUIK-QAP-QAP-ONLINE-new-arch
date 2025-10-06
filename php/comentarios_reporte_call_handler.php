<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

	session_start();
	include_once"verifica_sesion.php";
	
	actionRestriction_102();	

	$tipo = $_POST['tipo'];
	
	switch($tipo) {
        case 'showHTMLComentarios':
            
			$labid = $_POST["laboratorio"];
            $programid = $_POST["programa"];
			$roundid = $_POST["ronda"];
            $sampleid = $_POST["muestra"];

            $pageContent = array(
				"labnumber" => ""
				,"labname" => ""
				,"labaddress" => ""
				,"labcity" => ""
				,"labcountry" => ""
				,"labcontact" => ""
				,"labphone" => ""
				,"labemail" => ""
				,"labresultsdate" => ""
				,"programname" => ""
				,"programinitials" => ""
				,"programmodality" => ""
				,"programroundnumber" => ""
				,"programsamplenumber" => ""
				,"programsample" => ""
				,"programsampleexpirationdate" => ""
				,"programsampletype" => ""
				,"programtype" => ""
				,"reportidoriginal" => ""
				,"reportidupdated" => ""
				,"evaluationcriteria" => ""
				,"reportdayofgeneration" => ""
				,"reportmonthofgeneration" => ""
				,"reportyearofgeneration" => ""
				,"reportdisclaimer" => ""
				,"reportapprovedby" => ""
				,"reportapprovedbyliability" => ""
				,"reportapprovedbysignature" => ""
				,"reportcompanyinfoarray" => array()
				,"reportstatus" => ""
				,"reportlogo1" => ""
				,"reportlogo2" => ""
				,"programsamples" => array()
				,"ammountofresultsforcurrentsample" => 0
				,"ammountofresultsforcurrentsamplemisc" => 0
				,"ammountofsatisfactoryresults" => 0
				,"ammountofsatisfactoryresultsmisc" => 0
				,"ammountofsatisfactoryresultsforthewholeround" => 0
				,"ammountofsatisfactoryresultsforthewholeroundmisc" => 0
				,"ammountofhalfsatisfactoryresults" => 0
				,"ammountofhalfsatisfactoryresultsforthewholeround" => 0				
				,"ammountofunsatisfactoryresults" => 0
				,"ammountofunsatisfactoryresultsmisc" => 0
				,"ammountofunsatisfactoryresultsforthewholeround" => 0
				,"ammountofunsatisfactoryresultsforthewholeroundmisc" => 0
				,"ammountofemptyresults" => 0
				,"ammountofeditedresults" => 0
				,"ammountoflateresults" => 0
				,"ammountofsatisfactoryreferenceresults" => 0
				,"ammountofunsatisfactoryreferenceresults" => 0				
				,"ammounttotalofreportedanalytes" => 0
				,"ammounttotalofreportedanalytesmisc" => 0
				,"ammounttotalofreportedreferenceanalytes" => 0
				,"ammounttotalofreportedreferenceanalytesforthewholeround" => 0
				,"separatedanalyzername" => array()
				,"separatedanalyzerid" => array()
				,"separador_analito_resultado_reporte_cualitativo" => ""
				,"labconfigurationitems" => array(
					"nombre_analito" => array()
					,"nombre_analizador" => array()
					,"id_analizador" => array()
					,"nombre_metodologia" => array()
					,"nombre_reactivo" => array()
					,"nombre_unidad" => array()
					,"nombre_unidad_global" => array()
					,"factor_conversion" => array()
					,"valor_gen_vitros" => array()
					,"nombre_material" => array()
					,"media_estandar" => array()
					,"media_estandar_cualitativa" => array()
					,"desviacion_estandar" => array()
					,"valor_resultado" => array()
					,"valor_resultado_reporte_cualitativo" => array()
					,"observacion_resultado" => array()
					,"nombre_usuario" => array()
					,"fecha_resultado" => array()
					,"editado" => array()
					,"zscore" => array()
					,"diff" => array()
					,"limitname" => array()
					,"limitvalue" => array()
					,"limitoptionvalue" => array()
					,"limitoptionname" => array()
					,"deviationpercentage" => array()
					,"deviationpercentagereference" => array()
					,"upperLimit" => array()
					,"lowerlimit" => array()
					,"sampleperformance" => array()
					,"sampleperformancereference" => array()
					,"zscoreperformance" => array()
					,"referencemedia" => array()
					,"referencemetodology" => array()
					,"referenceunit" => array()
					,"jctlmmethod" => array()
					,"id_metodo_jctlm" => array()
					,"jctlmmaterial" => array()
					,"id_material_jctlm" => array()
					,"jctlmcalification" => array()
				)
            );	
            

            $qry = "SELECT id_tipo_programa FROM $tbl_programa WHERE $tbl_programa.id_programa = $programid LIMIT 0,1";
			$qryData = mysql_fetch_array(mysql_query($qry));
			mysqlException(mysql_error(),"_00");
			
            $pageContent["programtype"] = $qryData['id_tipo_programa'];
            


            $qry = "SELECT $tbl_configuracion_laboratorio_analito.*, $tbl_analito.nombre_analito, $tbl_analizador.nombre_analizador, $tbl_metodologia.nombre_metodologia, $tbl_reactivo.nombre_reactivo, $tbl_unidad.nombre_unidad, $tbl_gen_vitros.id_gen_vitros, $tbl_gen_vitros.valor_gen_vitros, $tbl_material.nombre_material  FROM $tbl_configuracion_laboratorio_analito  INNER JOIN $tbl_analito ON $tbl_configuracion_laboratorio_analito.id_analito = $tbl_analito.id_analito  INNER JOIN $tbl_analizador ON $tbl_configuracion_laboratorio_analito.id_analizador = $tbl_analizador.id_analizador  INNER JOIN $tbl_metodologia ON $tbl_configuracion_laboratorio_analito.id_metodologia = $tbl_metodologia.id_metodologia  INNER JOIN $tbl_reactivo ON $tbl_configuracion_laboratorio_analito.id_reactivo = $tbl_reactivo.id_reactivo  INNER JOIN $tbl_unidad ON $tbl_configuracion_laboratorio_analito.id_unidad = $tbl_unidad.id_unidad  INNER JOIN $tbl_gen_vitros ON $tbl_configuracion_laboratorio_analito.id_gen_vitros = $tbl_gen_vitros.id_gen_vitros  LEFT JOIN $tbl_material ON $tbl_configuracion_laboratorio_analito.id_material = $tbl_material.id_material  WHERE $tbl_configuracion_laboratorio_analito.id_laboratorio = $labid AND $tbl_configuracion_laboratorio_analito.id_programa = $programid AND $tbl_configuracion_laboratorio_analito.activo = 1  ORDER BY $tbl_analito.nombre_analito ASC,$tbl_analito.nombre_analito ASC";
			$qryArray = mysql_query($qry);
            mysqlException(mysql_error(),"_04");	
            
            $configurationids = array(
				"id_analito" => array()
				,"id_analizador" => array()
				,"id_metodologia" => array()
				,"id_reactivo" => array()
				,"id_unidad" => array()
				,"id_configuracion" => array()
				,"id_gen_vitros" => array()
				,"id_material" => array()
			);
			$configurationmixedvalues = array(
				"valor_resultado" => array()
				,"desviacion_estandar" => array() 
				,"n_evaluacion" => array() 
			);

            $x = 0;

            while ($qryData = mysql_fetch_array($qryArray)) {
				
				$qry = "SELECT id_conexion, nombre_unidad_global, factor_conversion FROM $tbl_unidad_global_analito WHERE id_analito = ".$qryData['id_analito']." AND id_unidad = ".$qryData['id_unidad']." LIMIT 0,1";
				$innerQryArray1 = mysql_query($qry);
				$innerQryData1 = mysql_fetch_array($innerQryArray1);				
				
				$pageContent["labconfigurationitems"]["nombre_analito"][$x] = $qryData['nombre_analito'];
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

            for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {
				
				$qry = "SELECT 
                        valor_resultado,
                        observacion_resultado,
                        fecha_resultado,
                        nombre_usuario,
                        editado,
                        $tbl_analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo 
                    FROM $tbl_resultado 
                    INNER JOIN $tbl_usuario 
                        ON $tbl_resultado.id_usuario = $tbl_usuario.id_usuario 
                    LEFT JOIN $tbl_analito_resultado_reporte_cualitativo 
                        ON $tbl_resultado.id_analito_resultado_reporte_cualitativo = $tbl_analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo 
                    WHERE id_configuracion = ".$configurationids["id_configuracion"][$x]." AND id_muestra = $sampleid";
				
				$qryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),"_18_".$x);	
	
				$qry = "SELECT fecha_reporte FROM $tbl_fecha_reporte_muestra WHERE id_laboratorio = $labid AND id_muestra = $sampleid ORDER BY id_fecha DESC LIMIT 0,1";
				$innerQryData = mysql_fetch_array(mysql_query($qry));
				mysqlException(mysql_error(),"_19_".$x);
				
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
				
            }




            if (sizeof($pageContent["labconfigurationitems"]["observacion_resultado"]) > 0) {
		
                $y = 0;
                $counterArray = array();
                
                for ($x = 0; $x < sizeof($configurationids["id_configuracion"]); $x++) {
                    if ($pageContent["labconfigurationitems"]["observacion_resultado"][$x] != '') {
                        $counterArray[$y] = $x;
                        $y++;
                    }
                }
                
                echo '<div class="col-xs-12" style="max-height: inherit; overflow: auto;">';
                if (sizeof($counterArray) == 0) {
                    echo "<div style='margin-top: 10%;'>";
                        echo "<input class='counter-comentarios' value='".sizeof($counterArray)."' type='hidden'>";
                        echo "<center>";
                        echo "<h1>No se han encontrado comentarios para mostrar</h1>";
                        echo "</center>";
                    echo "</div>";
                } else {
                    for ($x = 0; $x < sizeof($counterArray); $x++) {
                        echo "<div class='margin-top-1 margin-bottom-1'>";
                            echo "<input class='counter-comentarios' value='".sizeof($counterArray)."' type='hidden'>";
                            echo "<table class='table table-responsive table-bordered' style='background-color: white;'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>Info del analito: ".$pageContent["labconfigurationitems"]["nombre_analito"][$counterArray[$x]].", ".$pageContent["labconfigurationitems"]["nombre_analizador"][$counterArray[$x]].", ".$pageContent["labconfigurationitems"]["nombre_metodologia"][$counterArray[$x]].", ".$pageContent["labconfigurationitems"]["nombre_unidad"][$counterArray[$x]].", ".$pageContent["labconfigurationitems"]["nombre_reactivo"][$counterArray[$x]].", N° de generación VITROS ".$pageContent["labconfigurationitems"]["valor_gen_vitros"][$counterArray[$x]]."</th>";
                                    echo "</tr>";
                                    echo "<tr>";
                                        if($pageContent["programtype"] == 1){ // Si el programa es cuantitativo
                                            echo "<th>Resultado del analito: ".$pageContent["labconfigurationitems"]["valor_resultado"][$counterArray[$x]]."</th>";
                                        } else { // Si el programa es cualitativo
                                            echo "<th>Resultado del analito: ".$pageContent["labconfigurationitems"]["valor_resultado_reporte_cualitativo"][$counterArray[$x]]."</th>";
                                        }
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";	
                                        echo "<tr>";
                                            echo "<td>";
                                            echo "<span style='font-weight: bold;'>Comentario: </span>";
                                            echo "'".$pageContent["labconfigurationitems"]["observacion_resultado"][$counterArray[$x]]."'<span style='font-weight: bold;'> por: </span>".$pageContent["labconfigurationitems"]["nombre_usuario"][$counterArray[$x]];
                                            echo "</td>";					
                                        echo "</tr>";
                                echo "</tbody>";
                            echo "</table>";		
                        echo "</div>";
                    }
                }
                echo '</div>';	
            }
		break;
				
		default:
			echo'Ha ocurrido algo inesperado, por favor intente nuevamente...';
		break;		
	}
	
	mysql_close($con);
	exit;
?>	