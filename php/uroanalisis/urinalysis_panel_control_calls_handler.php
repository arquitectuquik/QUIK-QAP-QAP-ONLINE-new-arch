<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}


session_start();
include_once "../verifica_sesion.php";
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

    case 'showAssignedProgramaLab':
        switch ($filterid) {

            case 'id_laboratorio':

                $filterQry = "WHERE $tbl_laboratorio.id_laboratorio = " . $filter;

                break;

            default:

                $filterQry = '';

                break;
        }



        $qry = "SELECT id_conexion,$tbl_programa.nombre_programa,$tbl_laboratorio.no_laboratorio,$tbl_laboratorio.nombre_laboratorio,$tbl_programa.id_programa,$tbl_programa_laboratorio.activo 
            FROM $tbl_programa 
            INNER JOIN $tbl_programa_laboratorio ON $tbl_programa.id_programa = $tbl_programa_laboratorio.id_programa 
            INNER JOIN $tbl_laboratorio ON $tbl_programa_laboratorio.id_laboratorio = $tbl_laboratorio.id_laboratorio $filterQry ORDER BY $tbl_programa.nombre_programa ASC, $tbl_laboratorio.nombre_laboratorio ASC";



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

    case 'showAssignedLoteRound':

        //---------------Para obtener la ronda---------------------------------

        $filterArray = explode("|",$filter);
			
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
			mysqlException(mysql_error(),$header."_01");			
			
			// $returnValue_1_ronda = array();
			// $returnValue_2_ronda = array();;
			
			$x = 0;
			
			while ($qryData = mysql_fetch_array($qryArray)) {
                $idRonda = $qryData['id_ronda'];
				// $returnValue_1_ronda[$x] = $qryData['id_ronda'];
				// $returnValue_2_ronda[$x] = $qryData['no_ronda'];

                //---------------Para obtener los lotes---------------------------------
                // switch ($filterid) {				
                // 	case 'id_ronda':
                // 		$filterQry = "WHERE $tbl_ronda.id_ronda = $filter";
                // 	break;					
                // 	default:
                // 		$filterQry = '';
                // 	break;
                // }
    
                // $qry = "SELECT $tbl_muestra.id_muestra,$tbl_muestra.codigo_muestra,$tbl_contador_muestra.no_contador,$tbl_muestra_programa.fecha_vencimiento FROM $tbl_ronda INNER JOIN $tbl_contador_muestra ON $tbl_ronda.id_ronda = $tbl_contador_muestra.id_ronda INNER JOIN $tbl_muestra ON $tbl_contador_muestra.id_muestra = $tbl_muestra.id_muestra INNER JOIN $tbl_muestra_programa ON $tbl_muestra.id_muestra = $tbl_muestra_programa.id_muestra INNER JOIN $tbl_programa ON $tbl_muestra_programa.id_programa = $tbl_programa.id_programa WHERE $tbl_ronda.id_ronda = $idRonda ORDER BY $tbl_ronda.no_ronda DESC, $tbl_contador_muestra.no_contador ASC";
    
                // $qryLote = "SELECT  DISTINCT lote.id_lote, lote.nombre_lote, lote.nivel_lote, lote.fecha_vencimiento
                //         FROM ronda 
                //         INNER JOIN contador_muestra ON ronda.id_ronda = contador_muestra.id_ronda 
                //         INNER JOIN muestra ON contador_muestra.id_muestra = muestra.id_muestra
                //         INNER JOIN muestra_programa ON muestra.id_muestra = muestra_programa.id_muestra 
                //         INNER JOIN programa ON muestra_programa.id_programa = programa.id_programa 
                //         INNER JOIN lote ON lote.id_lote = muestra_programa.id_lote
                //         WHERE ronda.id_ronda = $idRonda ORDER BY ronda.no_ronda DESC, contador_muestra.no_contador ASC";
    
                $qryLote = "SELECT  
        lote.id_lote, 
        lote.nombre_lote, 
        lote.nivel_lote, 
        lote.fecha_vencimiento
    FROM ronda 
    INNER JOIN contador_muestra ON ronda.id_ronda = contador_muestra.id_ronda 
    INNER JOIN muestra ON contador_muestra.id_muestra = muestra.id_muestra
    INNER JOIN muestra_programa ON muestra.id_muestra = muestra_programa.id_muestra 
    INNER JOIN programa ON muestra_programa.id_programa = programa.id_programa 
    INNER JOIN lote ON lote.id_lote = muestra_programa.id_lote
    WHERE ronda.id_ronda = $idRonda 
    GROUP BY 
        lote.id_lote, 
        lote.nombre_lote, 
        lote.nivel_lote, 
        lote.fecha_vencimiento";


                $qryArray = mysql_query($qryLote);
                mysqlException(mysql_error(),$header."_01");			
                
                $returnValue_1_lote = array();
                $returnValue_2_lote = array();
                $returnValue_3_lote = array();
                $returnValue_4_lote = array();
                
                $y = 0;
                
                while ($qryData = mysql_fetch_array($qryArray)) {
                    $returnValue_1_lote[$y] = $qryData['id_lote'];
                    $returnValue_2_lote[$y] = $qryData['nombre_lote'];
                    $returnValue_3_lote[$y] = $qryData['nivel_lote'];
                    $returnValue_4_lote[$y] = $qryData['fecha_vencimiento'];
    
                    $y++;
                }
                
				$x++;
			}

            echo '<response code="1">';
            echo'<returnvalues1 content="id">'.implode("|",$returnValue_1_lote).'</returnvalues1>';
            echo'<returnvalues2>'.implode("|",$returnValue_2_lote).'</returnvalues2>';
            echo'<returnvalues3>'.implode("|",$returnValue_3_lote).'</returnvalues3>';
            echo'<returnvalues4 >'.implode("|",$returnValue_4_lote).'</returnvalues4>';
            echo '</response>';	


        break;

    default:

        echo '<response code="0">PHP callsHandler error: id "' . $header . '" not found</response>';

        break;
}

exit;
