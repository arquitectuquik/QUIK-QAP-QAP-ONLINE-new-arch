<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once 'mysql_compatibility.php';
}




function tablePrinter($val,$customText, $laboratorio = 0, $muestra = 0) {

		

		

		$qry_aleatory = "SELECT fecha_reporte FROM `fecha_reporte_muestra` where id_laboratorio = '$laboratorio' AND id_muestra = '$muestra'";

		$innerQryData_aleatory = mysql_fetch_array(mysql_query($qry_aleatory));

		mysqlException(mysql_error(),"_23_");

		$fecha_reporte = $innerQryData_aleatory['fecha_reporte'];

		

	

		global $pageContent;

		global $reportstatusid;

		

		if (!isset($customText)) {

			$customText = "vacio";

		} 

		

		setlocale(LC_ALL,"es_CO.UTF-8","es_CO","esp");

		$d = $pageContent["reportyearofgeneration"].'-'.$pageContent["reportmonthofgeneration"].'-'.$pageContent["reportdayofgeneration"];

		

		switch ($val) {

			case 'br':

				echo "<table style='width: 100%;'>";

					echo "<thead>";

						echo "<tr>";

							if ($customText == "no_border") {

								echo "<th style='display:inline-block; padding: 3px 0'>&nbsp;</th>";

							} else {

								echo "<th style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_right"]."; display:inline-block; padding: 3px 0'>&nbsp;</th>";

							}

						echo "</tr>";				

					echo "</thead>";

				echo "</table>";			

			break;

			case 'tablestart':

				echo "<table style='width: 100%;' cellspacing='0'>";

					echo "<tfoot>";

						echo "<tr>";

							echo "<td style='".$pageContent["tablestyle_border_bottom"]."'>&nbsp;</td>";

						echo "</tr>";

					echo "</tfoot>";

				echo "</table>";			

			break;			

			case 'tableend':

				echo "<table style='width: 100%;' cellspacing='0'>";

					echo "<tfoot>";

						echo "<tr>";

							echo "<td style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_border_right"]."'>&nbsp;</td>";

						echo "</tr>";

					echo "</tfoot>";

				echo "</table>";		

			break;

			case 'headerPortada':

				echo "<!-- headerPortada separator -->";

				echo "<table style='width: 100%;' cellpadding='1' cellspacing='0'>";

					echo "<thead>";

						echo "<tr style='width: 100%'>";

							echo "<td style='border:none; width: 200px;'>".$pageContent["reportlogoPortada1"]."</td>";

							echo "<td style='border:none; width: 300px;'></td>";

							echo "<td style='border:none; width: 200px;'>".$pageContent["reportlogoPortada2"]."</td>";	

							echo "<td style='border:none; width: 300px;'></td>";

								echo "<td style='border:none; width: 200px;'>".$pageContent["reportlogoPortada2"]."</td>";	

						echo "</tr>";

					echo "<tr style='width: 100%'>";

                            echo "<td style='border:none; width: 150px;'>".$pageContent["logo_prog"]."</td>";

                            echo "<td style='border:none; width: 300px;'></td>";

                            echo "<td style='border:none; width: 150px;'></td>"; // Dejamos esta celda vacía para mantener el diseño

                            echo "<td style='border:none; width: 300px;'></td>";

                        echo "</tr>";

					echo "</thead>";

				echo "</table>";

				echo "<table style='width: 100%;' cellpadding='3' cellspacing='0'>";

					echo "<thead>";

						echo "<tr>";

							echo "<th>&nbsp;</th>";

						echo "</tr>";		 		

					echo "</thead>";

				echo "</table>";				

				echo "<!-- /headerPortada separator -->";

			break;

			case 'header2':

				echo "<!-- 2 separator -->";

				echo "<table style='width: 100%;' cellpadding='1' cellspacing='0'>";

					echo "<thead>";

						echo "<tr>";

						    echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_text_bold"]."' colspan='2' rowspan='6'>".$pageContent["reportlogo1"]."</th>";

							echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_text_bold"]." font-size: 10pt;/**/' colspan='6' rowspan='6'><br><br>Quality Assurance Program<br/>PROGRAMA DE ASEGURAMIENTO EXTERNO <br/><span style='".$pageContent["tablestyle_text_color"]."'><span style='".$pageContent["tablestyle_text_color"]."'>".$pageContent["programinitials"]."</span> - ".$pageContent["programname"]."</span></th>"; 

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_left"]."font-size:6pt;/**/'>Identificación Laboratorio: </td>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."font-size:6pt;/**/'>".$pageContent["labnumber"]."</td>";							

						echo "</tr>";

						echo "<tr>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_left"]."font-size:6pt;'>Ronda: </td>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."font-size:6pt;'>".$pageContent["programroundnumber"]."</td>";

						echo "</tr>";

						echo "<tr>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_left"]."font-size:6pt;/**/'>Muestra: </td>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."font-size:6pt;/**/'>".$pageContent["programsamplenumber"]."</td>";

						echo "</tr>";

						echo "<tr>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_left"]."font-size:6pt;/**/'>Código Muestra: </td>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."font-size:6pt;/**/'>".$pageContent["programsample"]."</td>";

						echo "</tr>";

						echo "<tr>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_left"]."font-size:6pt;/**/'>Fecha reporte: </td>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."font-size:6pt;/**/'>".$fecha_reporte."</td>";

						echo "</tr>";

						echo "<tr>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_left"]."font-size:6pt;/**/'>Estado: </td>";

							echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."font-size:6pt;/**/'>".$pageContent["reportstatus"]."</td>";

						echo "</tr>";

					echo "</thead>";

				echo "</table>";

				echo "<table style='width: 100%;' cellpadding='3' cellspacing='0'>";

					echo "<thead>";

						echo "<tr>";

							echo "<th>&nbsp;</th>";

						echo "</tr>";		 		

					echo "</thead>";

				echo "</table>";				

				echo "<table style='width: 100%;' cellpadding='3' cellspacing='0'>";

					echo "<thead>";

						echo "<tr>";

							echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_bold"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_text_color"]."font-size:8pt;/**/'>".mb_strtoupper($customText,"utf-8")."</th>";

						echo "</tr>";				

					echo "</thead>";

				echo "</table>";

				echo "<!-- /header2 separator -->";

			break;

			case 'header3':

				echo "<table style='width: 100%;' cellpadding='3' cellspacing='0'>";

					echo "<thead>";

						echo "<tr>";

							echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_bold"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_text_color"]."font-size:8pt;/**/'>".mb_strtoupper($customText,"utf-8")."</th>";

						echo "</tr>";				

					echo "</thead>";

				echo "</table>";

			break;			

			case 'tablenotifications':

				echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

					echo "<tfoot>";



							switch ($pageContent["programtype"]) {

								case 1:

								

									switch ($customText) {

										case "notification1":

											echo "<tr style='font-size: 7px;'>";

												echo "<th style='width:25%;".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#afffaf;' rowspan='2'>Satisfactorio: El resultado reportado por el laboratorio NO supera la diferencia porcentual del ETmp%/APS comparado con X<sub>pt</sub></th>";

												echo "<th style='width:25%;".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ff7d7d;' rowspan='2'>No satisfactorio: El resultado reportado por el laboratorio SI supera la diferencia porcentual del ETmp%/APS comparado con X<sub>pt</sub></th>";

												echo "<th style='width:25%;".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_border_right"]."'>ETmp%/APS</th>";

												echo "<th style='width:25%;".$pageContent["tablestyle_border_top"].$pageContent["tablestyle_border_right"].$pageContent["tablestyle_text_center"]."'>X<sub>pt</sub></th>";

											echo "</tr>";

											echo "<tr style='font-size: 7px;'>";

												echo "<th style='width:25%;".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_border_right"]."'>Error Total máximo permisible <br/>* Fuente ".$pageContent['labconfigurationitems']['limitname'][0]."</th>";

												echo "<th style='width:25%;".$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_border_right"]."'>Valor aceptado como verdadero</th>";									

											echo "</tr>";												

										break;

										case "notification2":

											echo "<tr style='font-size: 7px;'>";

													echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#afffaf;' rowspan='2' colspan='2'>X<sub>pt</sub> - La diferencia porcentual es inferior o igual al error total máximo permisible.</th>";

													echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ff7d7d;' rowspan='2' colspan='2'>X<sub>pt</sub> - La diferencia porcentual es superior al error total máximo permisible.</th>";

													echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#afffaf;' rowspan='2' colspan='2'><b>Satisfactorio</b><br/> si su resultado está entre +/- 2 Z-score.</th>";

													echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ffff7d;' rowspan='2' colspan='2'><b>Alarma</b><br/> si su resultado está entre +/- 2 y  +/- 3 Z-score.</th>";

													echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ff7d7d;' rowspan='2' colspan='2'><b>No satisfactorio</b><br/>  si su resultado es mayor a  +/- 3 Z-score.</th>";



													echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."' rowspan='2' colspan='2'>

															<b>N/A </b> No aplica<br>

													</th>";

													



													echo "<th style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 10px;'><span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span></th>";

													echo "<th style='".$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 10px;'><span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span></th>";

													echo "<th style='".$pageContent["tablestyle_border_right"].$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 10px;'><span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span></th>";													

												echo "</tr>";

												echo "<tr style='font-size: 6px;'>";

													echo "<th style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Tardío</th>";

													echo "<th style='".$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Ausente</th>";

													echo "<th style='".$pageContent["tablestyle_border_right"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Revalorado</th>";											

											echo "</tr>";														

										break;	

										case "notification3":

											echo "<tr style='font-size: 7px;'>";

												echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#afffaf;width:22.2222%;' rowspan='2'><b>Satisfactorio</b><br/> si su resultado está entre +/- 2 Z-score.</th>";

												echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ffff7d;width:22.2222%;' rowspan='2'><b>Alarma</b><br/> si su resultado está entre +/- 2 y +/- 3 Z-score.</th>";

												echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ff7d7d;width:22.2222%;' rowspan='2'><b>No satisfactorio</b><br/> si su resultado es mayor a +/- 3 Z-score.</th>";



												echo "<th style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 8pt;width:11.1111%;'><span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span></th>";

												echo "<th style='".$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 8pt;width:11.1111%;'><span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span></th>";

												echo "<th style='".$pageContent["tablestyle_border_right"].$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 8pt;width:11.1111%;'><span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span></th>";												

											echo "</tr>";

											echo "<tr style='font-size: 7px;'>";

													echo "<th style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Tardío</th>";

													echo "<th style='".$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Ausente</th>";

													echo "<th style='".$pageContent["tablestyle_border_right"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Revalorado</th>";											

											echo "</tr>";										

										break;

										case "notification4":

											echo "<tr>";

												echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_text_color"]."; font-size: 7px;' colspan='3'>Valoración con comparación con X<sub>pt</sub></th>";

												echo "<th colspan='2'>&nbsp;</th>";

												echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"].$pageContent["tablestyle_text_color"]."; font-size: 7px;' colspan='3'>Valoración con media de consenso</th>";

											echo "</tr>";

											echo "<tr>";

												echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]." background-color: #afffaf;; font-size: 7px; color: #000;'><u>Satisfactorio:</u> Cuando la diferencia porcentual con el X<sub>pt</sub>, no supera el error total máximo permisible.</td>";

												echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]." background-color: #ff7d7d;; font-size: 7px; color: #000;'><u>No satisfactorio:</u> Cuando la diferencia porcentual con X<sub>pt</sub>, supera el error total máximo permisible.</td>";

												echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."; font-size: 7px; color: #000;'>No aplica.</td>";

												echo "<td>&nbsp;</td>";

												echo "<td>&nbsp;</td>";

												echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#afffaf; font-size: 4pt; color: #000;' rowspan='2'>Satisfactorio si su resultado está entre +/- 2 Z-score.</td>";

												echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ffff7d; font-size: 4pt; color: #000;' rowspan='2'>Alarma si su resultado está entre +/- 2 y  +/- 3 Z-score.</td>";

												echo "<td style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ff7d7d; font-size: 4pt; color: #000;' rowspan='2'>No satisfactorio si su resultado es mayor a +/- 3 Z-score.</td>";												

											echo "</tr>";											

										break;

									}								

								

								break;

								case 2:

									echo "<tr style='font-size:8px;'>";

										echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#afffaf;' rowspan='2'><b><u>Satisfactorio:</u></b> El resultado de su laboratorio es igual a la referencia.</th>";

										echo "<th style='".$pageContent["tablestyle_border_all"].$pageContent["tablestyle_text_center"]."background-color:#ff7d7d;' rowspan='2'><b><u>No satisfactorio:</u></b> El resultado de su laboratorio es diferente a la referencia.</th>";

										echo "<th style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 13px;'><span hidden='hidden'>6</span><span class='glyphicon glyphicon-hourglass'></span></th>";

										echo "<th style='".$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 13px;'><span hidden='hidden'>x</span><span class='glyphicon glyphicon-remove'></span></th>";

										echo "<th style='".$pageContent["tablestyle_border_right"].$pageContent["tablestyle_border_top"].$pageContent["tablestyle_text_center"]." font-family:Wingdings; font-size: 13px;'><span hidden='hidden'>!</span><span class='glyphicon glyphicon-pencil'></span></th>";									

									echo "</tr>";

									echo "<tr style='font-size:8px;'>";

											echo "<th style='".$pageContent["tablestyle_border_left"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Resultado tardío</th>";

											echo "<th style='".$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Resultado ausente</th>";

											echo "<th style='".$pageContent["tablestyle_border_right"].$pageContent["tablestyle_border_bottom"].$pageContent["tablestyle_text_center"]."'>Resultado revalorado</th>";											

									echo "</tr>";

								break;

							}

								

					echo "</tfoot>";

				echo "</table>";			

			break;

			case 'footer':			

			break;

			case 'footerPortada':

				echo "<hr style='color:#333'>";

				echo "<table style='width: 100%;' border:none;>";

					echo "<tfoot>";

						echo "<tr>";

							echo "<th>&nbsp;</th>";

						echo "</tr>";				

					echo "</tfoot>";

				echo "</table>";			

				echo "<table style='width: 100%;' cellpadding='5' cellspacing='0'>";

					echo "<tfoot>";

						echo "<tr>";

							echo "<th style='width: 100%; text-align:center; font-size: 8pt;'>";

							for ($x = 0; $x < sizeof($pageContent["reportcompanyinfoarray"]); $x++) {

								echo " ".$pageContent["reportcompanyinfoarray"][$x]." ";

							}

							echo "</th>";							

						echo "</tr>";				

					echo "</tfoot>";

				echo "</table>";

				echo "<table style='width: 100%;' border:none;>";

					echo "<tfoot>";

						echo "<tr>";

							echo "<th>&nbsp;</th>";

						echo "</tr>";

						echo "<tr>";

							echo "<th>&nbsp;</th>";

						echo "</tr>";				

					echo "</tfoot>";

				echo "</table>";			

				echo "<!-- /footer separator -->";				

			break;

			case 'sizeinput':

				echo "<div class='col-xs-12' data-id='sheet-size-values-container'>";

					echo "<div class='col-xs-6'>";

						echo "<div class='form-group'>";

							echo "<label style='color: white;'>Alto de página</label>";

							echo "<input type='text' class='form-control input-sm input-block' data-id='sheet-size-height'/>";

						echo "</div>";

					echo "</div>";

					echo "<div class='col-xs-6'>";

						echo "<div class='form-group'>";

							echo "<label style='color: white;'>Ancho de página</label>";

							echo "<input type='text' class='form-control input-sm input-block' data-id='sheet-size-width'/>";

						echo "</div>";

					echo "</div>";					

				echo "</div>";			

			break;

		}

    }

    

?>