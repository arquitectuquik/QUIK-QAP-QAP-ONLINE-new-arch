<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

    session_start();
	include_once "verifica_sesion.php";	
	include_once "correo/envioCorreoPAT.php";	
	
	header('Content-Type: text/xml');
	echo "<?xml version='1.0' encoding='UTF-8' standalone='yes' ?>";		
	
	switch($_POST["accion"]) {
    
        case "listar_casos_clinicos":

            actionRestriction_125();
            
            $id_reto = 0;
            $id_reto = $_POST["id_reto"];
            $id_laboratorio = $_POST["id_laboratorio"];
            $id_laboratorio_desencriptado = encryptControl('decrypt',$id_laboratorio,$_SESSION['qap_token']);

            // Obtener la revaloración del ultimo intento para el reto seleccionado 
            $qry = "SELECT 
                    revaloracion 
                FROM intento 
                where 
                    reto_id_reto = $id_reto
                    and laboratorio_id_laboratorio = $id_laboratorio_desencriptado
                    and usuario_id_usuario = ".$_SESSION['qap_userId']."   
                order by intento.id_intento desc
                limit 1
            ";
            $qryArray = mysql_query($qry);
            mysqlException(mysql_error(),"_01");

            $revaloracion = 1;  // Si no hay intentos previos, por defecto permitir el nuevo intento
            
            while($qryData = mysql_fetch_array($qryArray)) {
                $revaloracion = $qryData["revaloracion"];
            }

            if($revaloracion == 1){
                echo '<response code="1">';
                    $programa_pat_id_programa = 0;
                    $nom_reto = "";

                    // Consultar el programa al que pertenece el reto
                    $qry = "SELECT programa_pat_id_programa, reto.nombre FROM reto where id_reto = $id_reto";
                    $qryArray = mysql_query($qry);
                    mysqlException(mysql_error(),"_01");
                    while($qryData = mysql_fetch_array($qryArray)) {
                        $programa_pat_id_programa = $qryData["programa_pat_id_programa"];
                        $nom_reto = $qryData["nombre"];
                    }
                    
                    $qryXD = "SELECT * FROM programa_pat WHERE id_programa = '$programa_pat_id_programa'";
                    $qryDataXD = mysql_fetch_array(mysql_query($qryXD));
                    $sigla_capXD = $qryDataXD['sigla'];
                    $sigla_capXD = substr($sigla_capXD, 0, -5);

                    if(
                        $programa_pat_id_programa == 1  || $programa_pat_id_programa == 2 || $programa_pat_id_programa == 3 || $programa_pat_id_programa == 4 || $programa_pat_id_programa == 5 || $programa_pat_id_programa == 6
                    ){
                        switch($programa_pat_id_programa){
                            case 1: // Si el programa es inmunohistoquimica
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto">';
                                        echo '<h2 class="text-center h5">Inmunohistoquímica</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                listarCasosClinicosInmuno($id_reto, $id_laboratorio);
                                break;
                                
                            case 2: // Si el programa es patologia quirurgica
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto">';
                                        echo '<h2 class="text-center h5">Patología quirúrgica</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                listarCasosClinicosPatQ($id_reto, $id_laboratorio);
                                break;
    
                            case 3: // Si el programa es Citología no ginecológica
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto">';
                                        echo '<h2 class="text-center h5">Citología no ginecológica</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                listarCasosClinicosCitNG($id_reto, $id_laboratorio);
                                break;
    
                            case 4: // Predictivo cancer de mama
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto">';
                                        echo '<h2 class="text-center h5">Predictivo de cáncer de mama</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                listarCasosClinicosPCM($id_reto, $id_laboratorio);
                                break;
    
                            case 5: // Citologia en base liquida
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto">';
                                        echo '<h2 class="text-center h5">Citología en Base Líquida</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                listarCasosClinicosCITLBC($id_reto, $id_laboratorio);
                                break;
    
                            case 6: // Citologia ginecologica
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto">';
                                        echo '<h2 class="text-center h5">Citología ginecológica</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosCITG($id_reto, $id_laboratorio);
                                break;
                        }
                    } else {
                        switch($sigla_capXD){
                            case "CAP-MK":
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto" style="min-width:1000px;">';
                                        echo '<h2 class="text-center h5">CAP-MK</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosMK($id_reto, $id_laboratorio);
                                break;
                            case "CAP-CYH":
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto" style="min-width:1000px;">';
                                        echo '<h2 class="text-center h5">CAP-CYH</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosCYH($id_reto, $id_laboratorio);
                                break;
                            case "CAP-PIP":
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto" style="min-width:1000px;">';
                                        echo '<h2 class="text-center h5">CAP-PIP</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosPIP($id_reto, $id_laboratorio);
                                break;
                            case "CAP-PAP":
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto" style="min-width:1000px;">';
                                        echo '<h2 class="text-center h5">CAP-PAP</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosPAP($id_reto, $id_laboratorio);
                                break;
                            case "CAP-PM2":
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto" style="min-width:1000px;">';
                                        echo '<h2 class="text-center h5">CAP-PM2</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosPM2($id_reto, $id_laboratorio);
                                break;
                            case "CAP-HER2":
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto" style="min-width:1000px;">';
                                        echo '<h2 class="text-center h5">CAP-HER2</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosHER2($id_reto, $id_laboratorio);
                                break;
    
                            case "CAP-NGC":
                                echo '<br />';
                                echo '<br />';
                                echo '<form id="form-reto" class="d-inline-block reto mx-auto">';
                                    echo '<div class="my-3 p-3 px-4 border rounded shadow bg-white overflow-auto" style="min-width:1000px;">';
                                        echo '<h2 class="text-center h5">CAP-NGC</h2>';
                                        echo '<h3 class="text-center h5">'.$nom_reto.'</h3>';
                                        listarCasosClinicosNGC($id_reto, $id_laboratorio);
                                break;
                        }
                    }

                echo '</response>';
            } else {
                echo '<response code="422">No puede realizar un nuevo intento...</response>';
            }

        break;
        
        case "guardarIntentoTemp":
            echo '<response code="1">';
                $variables = explode("&",$_POST["respuestas"]);
                $respuestasGen = array();
                $respuestasPuntuales = array(); // Almacenara solo las preguntas

                for($counterST=0; $counterST<sizeof($variables); $counterST++){
                    $cadenaExplode = explode("=",$variables[$counterST]);
                    if($cadenaExplode[0] == "laboratorio" || $cadenaExplode[0] == "reto" || $cadenaExplode[0] == "comentarios"){
                        $respuestasGen[$cadenaExplode[0]] = urldecode($cadenaExplode[1]);
                    } else {
                        $respuestasPuntuales[] = array(
                            "id" => $cadenaExplode[0],
                            "descripcion" => urldecode($cadenaExplode[1])
                        );
                    }
                }
                
                $id_laboratorio = encryptControl('decrypt',$respuestasGen["laboratorio"],$_SESSION['qap_token']);
                $id_reto = $respuestasGen["reto"];
                $comentarios = $respuestasGen["comentarios"];
                $id_usuario = $_SESSION['qap_userId'];
                $fecha_actual = date("Y-m-d h:i:s");


                $qryIntentoTemp = "SELECT id_intento FROM intento_temporal WHERE laboratorio_id_laboratorio = '$id_laboratorio' and usuario_id_usuario = '$id_usuario' and reto_id_reto = '$id_reto' limit 1";
                $checkrows2 = mysql_num_rows(mysql_query($qryIntentoTemp));
                $qryData_IT = mysql_fetch_array(mysql_query($qryIntentoTemp));
                mysqlException(mysql_error(),"_0x02_");
					
				if($checkrows2>0) {
                    $qryDelIntentoTemp = "DELETE FROM intento_temporal WHERE id_intento = '".$qryData_IT['id_intento']."'";
					mysql_query($qryDelIntentoTemp);
					mysqlException(mysql_error(),"_0x15");
					$logQuery['DELETE'][$dSum] = $qryDelIntentoTemp;
                }



                $qry = "INSERT INTO intento_temporal(laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto, comentario, fecha) 
                    VALUES($id_laboratorio, $id_usuario, $id_reto, '$comentarios', '$fecha_actual')";
                mysql_query($qry);
                $logQuery['INSERT'][$dSum] = $qry;
                $dSum++;
                mysqlException(mysql_error(),"_0x16");


                $qry = "SELECT last_insert_id() as id_intento";
                $qryArray = mysql_query($qry);
                mysqlException(mysql_error(),"_01");
                while($qryData = mysql_fetch_array($qryArray)) {
                    $id_intento = $qryData["id_intento"];
                }


                // Insertar las respuestas del usuario
                for($cntRP=0; $cntRP<sizeof($respuestasPuntuales); $cntRP++){

                    $preguntaDistractor = explode("-",$respuestasPuntuales[$cntRP]["descripcion"]); 
                    
                    if(isset($preguntaDistractor[2])){ // Si es un input tipo radio, manejar de manera convencional
                        $pregunta = $preguntaDistractor[1]; // Pregunta indicada por el usuario
                        $distractor = $preguntaDistractor[2]; // Respuesta indicada por el usuario
                        $qry = "INSERT INTO respuesta_lab_temporal(intento_id_intento, pregunta_id_pregunta, distractor_id_distractor) 
                            VALUES($id_intento, $pregunta, $distractor)";
                        mysql_query($qry);
                        $logQuery['INSERT'][$dSum] = $qry;
                        $dSum++;
                        mysqlException(mysql_error(),"_0x04");
                    } else { // Si es un input tipo Text, obtener su descripcion
                        $preguntaDistractor = explode("-",$respuestasPuntuales[$cntRP]["id"]);
                        $pregunta = $preguntaDistractor[1]; // Pregunta indicada por el usuario
                        $valor = $respuestasPuntuales[$cntRP]["descripcion"];
                        
                        if($valor === "" || $valor == NULL){
                            $qry = "INSERT INTO respuesta_lab_temporal(intento_id_intento, pregunta_id_pregunta, respuesta_cuantitativa) VALUES ($id_intento, $pregunta, NULL)";
                        } else {
                            $qry = "INSERT INTO respuesta_lab_temporal(intento_id_intento, pregunta_id_pregunta, respuesta_cuantitativa) VALUES ($id_intento, $pregunta, '$valor')";
                        }

                        mysql_query($qry);
                        $logQuery['INSERT'][$dSum] = $qry;
                        $dSum++;
                        mysqlException(mysql_error(),"_0x04");
                    }

                }
            echo '</response>';
            break;


        case "guardarIntento":
            
            echo '<response code="1">';
                $variables = explode("&",$_POST["respuestas"]);
                $respuestasGen = array();
                $respuestasPuntuales = array(); // Almacenara solo las preguntas

                for($counterST=0; $counterST<sizeof($variables); $counterST++){
                    $cadenaExplode = explode("=",$variables[$counterST]);
                   if($cadenaExplode[0] == "laboratorio" || $cadenaExplode[0] == "reto" || $cadenaExplode[0] == "comentarios"){
                       $respuestasGen[$cadenaExplode[0]] = urldecode($cadenaExplode[1]);
                   } else {
                       $respuestasPuntuales[] = array(
                            "id" => $cadenaExplode[0],
                            "descripcion" => urldecode($cadenaExplode[1])
                       );
                   }

                }
                
                $id_laboratorio = encryptControl('decrypt',$respuestasGen["laboratorio"],$_SESSION['qap_token']);
                $id_reto = $respuestasGen["reto"];
                $comentarios = $respuestasGen["comentarios"];
                $id_usuario = $_SESSION['qap_userId'];
                $fecha_actual = date("Y-m-d h:i:s");

                enviarCorreoPAT($id_laboratorio,$id_usuario,$id_reto,$fecha_actual);
                
                $qry = "INSERT INTO intento(laboratorio_id_laboratorio, usuario_id_usuario, reto_id_reto, comentario, fecha) 
                    VALUES($id_laboratorio, $id_usuario, $id_reto, '$comentarios', '$fecha_actual')";
                mysql_query($qry);
                $logQuery['INSERT'][$dSum] = $qry;
                $dSum++;
                mysqlException(mysql_error(),"_0x04");

                $qry = "SELECT last_insert_id() as id_intento";
                $qryArray = mysql_query($qry);
                mysqlException(mysql_error(),"_01");
                while($qryData = mysql_fetch_array($qryArray)) {
                    $id_intento = $qryData["id_intento"];
                }
                
                // Insertar las respuestas del usuario
                for($cntRP=0; $cntRP<sizeof($respuestasPuntuales); $cntRP++){

                    $preguntaDistractor = explode("-",$respuestasPuntuales[$cntRP]["descripcion"]); 
                    
                    if(isset($preguntaDistractor[2])){ // Si es un input tipo radio, manejar de manera convencional
                        $pregunta = $preguntaDistractor[1]; // Pregunta indicada por el usuario
                        $distractor = $preguntaDistractor[2]; // Respuesta indicada por el usuario
                        $qry = "INSERT INTO respuesta_lab(intento_id_intento, pregunta_id_pregunta, distractor_id_distractor) 
                            VALUES($id_intento, $pregunta, $distractor)";
                        mysql_query($qry);
                        $logQuery['INSERT'][$dSum] = $qry;
                        $dSum++;
                        mysqlException(mysql_error(),"_0x04");
                    } else { // Si es un input tipo Text, obtener su descripcion

                        $preguntaDistractor = explode("-",$respuestasPuntuales[$cntRP]["id"]);
                        $pregunta = $preguntaDistractor[1]; // Pregunta indicada por el usuario
                        $valor = $respuestasPuntuales[$cntRP]["descripcion"];
                        
                        $qry = "INSERT INTO respuesta_lab(intento_id_intento, pregunta_id_pregunta, respuesta_cuantitativa) 
                            VALUES($id_intento, $pregunta, '$valor')";
                        mysql_query($qry);
                        $logQuery['INSERT'][$dSum] = $qry;
                        $dSum++;
                        mysqlException(mysql_error(),"_0x04");
                    }
                }

                // Eliminar los intentos temporales si existen
                $qryIntentoTemp = "SELECT id_intento FROM intento_temporal WHERE laboratorio_id_laboratorio = '$id_laboratorio' and usuario_id_usuario = '$id_usuario' and reto_id_reto = '$id_reto' limit 1";
                $checkrows2 = mysql_num_rows(mysql_query($qryIntentoTemp));
                $qryData_IT = mysql_fetch_array(mysql_query($qryIntentoTemp));
                mysqlException(mysql_error(),"_0x02_");
					
				if($checkrows2>0) {
                    $qryDelIntentoTemp = "DELETE FROM intento_temporal WHERE id_intento = '".$qryData_IT['id_intento']."'";
					mysql_query($qryDelIntentoTemp);
					mysqlException(mysql_error(),"_0x15");
					$logQuery['DELETE'][$dSum] = $qryDelIntentoTemp;
                }
            echo '</response>';
            break;

		default:
			echo'<response code="0">PHP dataChangeHandler error: not found</response>';
		break;		
	}
	
	mysql_close($con);
    exit;


    function listarCasosClinicosInmuno($id_reto, $id_laboratorio){

            // Obtener casos clinicos de dicho reto
            $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
            $qryArray = mysql_query($qry);
            mysqlException(mysql_error(),"_01");
            while($qryData = mysql_fetch_array($qryArray)) {
                $id_caso_clinico = $qryData["id_caso_clinico"];
                $codigo = $qryData["codigo"];
                $nombre = $qryData["nombre"];
                $enunciado = $qryData["enunciado"];

                echo "<br />";
                echo "<br />";

                echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
                echo '<h5 class="h6 my-3">Historia clínica</h5>';
                echo '<p>'.$enunciado.'</p>';
                echo '<h5 class="h6 my-3">Interpretación de la inmunohistoquímica</h5>';
    

                
                echo '<div class="rounded border overflow-hidden">';
                    echo '<table class="table table-sm text-center table-striped">';
                        echo '<tr class="table-light text-dark">';
                            echo '<th>-</th>';
                            echo '<th colspan="4">Marcadores</th>';
                        echo '</tr>';

                        // Traer los posbibles marcadores de la seccion de patron de tinción
                        $qryPregunta = "SELECT
                            pregunta.id_pregunta,   
                            pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Patrón de tinción'";

                        $marcadores = array();
                        $qryArrayPregunta = mysql_query($qryPregunta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                            $marcadores[] = [
                                "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                "nombre" => $qryDataPregunta["nombre"]
                            ];
                        }

                        echo '<tr class="table-light text-dark">';
                            echo '<th>Patrón de tinción</th>';
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                            }
                        echo '</tr>';


                        // Traer las posibles respuestas para los marcadores de patron de tinción
                        $qryRespuesta = "SELECT distinct 
                            distractor.nombre
                        from
                            distractor
                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                        where 
                            grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Patrón de tinción'";

                        $posibles_respuestas = array();
                        $qryArrayRespuesta = mysql_query($qryRespuesta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                            $nom_distractor = $qryDataRespuesta["nombre"];

                            echo '<tr>';
                                echo '<td>'.$nom_distractor.'</td>';
                                
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                    $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                    $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                    
                                    // Se busca el distractor especifico
                                    $qryDistractorEsp = "SELECT 
                                        distractor.id_distractor,
                                        distractor.nombre
                                    from
                                        distractor
                                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where 
                                        distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                    $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                    mysqlException(mysql_error(),"_01");
                                    while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                        $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                        echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                    }
                                }
                            echo '</tr>';
                        }


                        // Traer los posbibles marcadores de la seccion de intensidad de tinción
                        $qryPregunta = "SELECT
                            pregunta.id_pregunta,   
                            pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de tinción'";

                        $marcadores = array();
                        $qryArrayPregunta = mysql_query($qryPregunta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                            $marcadores[] = [
                                "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                "nombre" => $qryDataPregunta["nombre"]
                            ];
                        }

                        echo '<tr class="table-light text-dark">';
                            echo '<th>Intensidad de tinción</th>';
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                            }
                        echo '</tr>';

                        // Traer las posibles respuestas para los marcadores de intensidad de tinción
                        $qryRespuesta = "SELECT distinct 
                            distractor.nombre
                        from
                            distractor
                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                        where 
                            grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de tinción'";

                        $posibles_respuestas = array();
                        $qryArrayRespuesta = mysql_query($qryRespuesta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                            $nom_distractor = $qryDataRespuesta["nombre"];

                            echo '<tr>';
                                echo '<td>'.$nom_distractor.'</td>';
                                
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                    $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                    $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                    
                                    // Se busca el distractor especifico
                                    $qryDistractorEsp = "SELECT 
                                        distractor.id_distractor,
                                        distractor.nombre
                                    from
                                        distractor
                                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where 
                                        distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                    $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                    mysqlException(mysql_error(),"_01");
                                    while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                        $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                        echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                    }
                                }
                            echo '</tr>';
                        }

                        // Traer los posbibles marcadores de la seccion de Porcentaje de células positivas
                        $qryPregunta = "SELECT
                            pregunta.id_pregunta,   
                            pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Porcentaje de células positivas'";

                        $marcadores = array();
                        $qryArrayPregunta = mysql_query($qryPregunta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                            $marcadores[] = [
                                "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                "nombre" => $qryDataPregunta["nombre"]
                            ];
                        }

                        echo '<tr class="table-light text-dark">';
                            echo '<th>Porcentaje de células positivas</th>';
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                            }
                        echo '</tr>';


                        // Traer las posibles respuestas para los marcadores de Porcentaje de células positivas
                        $qryRespuesta = "SELECT distinct 
                            distractor.nombre
                        from
                            distractor
                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                        where 
                            grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Porcentaje de células positivas'";

                        $posibles_respuestas = array();
                        $qryArrayRespuesta = mysql_query($qryRespuesta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                            $nom_distractor = $qryDataRespuesta["nombre"];

                            echo '<tr>';
                                echo '<td>'.$nom_distractor.'</td>';
                                
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                    $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                    $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                    
                                    // Se busca el distractor especifico
                                    $qryDistractorEsp = "SELECT 
                                        distractor.id_distractor,
                                        distractor.nombre
                                    from
                                        distractor
                                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where 
                                        distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                    $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                    mysqlException(mysql_error(),"_01");
                                    while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                        $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                        echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                    }
                                }
                            echo '</tr>';
                        }
                    echo '</table>';
                echo '</div>';

                // Traer la pregunta del diagnostico
                $qryPregunta = "SELECT
                    pregunta.id_pregunta,
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $id_pregunta = $qryDataPregunta["id_pregunta"];
                    $nombre = $qryDataPregunta["nombre"];

                    echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                    // Traer las posibles respuestas a la pregunta
                    $qryDistractor = "SELECT 
                            id_distractor,
                            nombre
                        from distractor
                        where pregunta_id_pregunta = $id_pregunta";

                    $qryArrayDistractor = mysql_query($qryDistractor);
                    mysqlException(mysql_error(),"_01");

                    echo "<ol type='A'>";
                    
                    while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                        $id_distractor = $qryDataDistractor["id_distractor"];
                        $nombre = $qryDataDistractor["nombre"];
                            echo "<li>";
                                echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                    echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                    echo $nombre;
                                    echo '</label>';
                                echo '</div>';
                            echo "</li>";
                    }

                    echo "</ol>";
                }
            }

            echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
            echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";


            echo '<br />';
            echo '<br />';
            echo '<br />';
            echo '<div class="text-center">';
                echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
                echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
            echo '</div>';
            echo '<div class="text-center">';
                echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
            echo '</div>';
            
            echo '</div>';

            echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
            echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }

    function listarCasosClinicosMK($id_reto, $id_laboratorio){

        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        while($qryData = mysql_fetch_array($qryArray)) {
            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";

            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Historia clínica</h5>';
            echo '<p>'.$enunciado.'</p>';
            echo '<h5 class="h6 my-3">Interpretación de la inmunohistoquímica</h5>';


            
            echo '<div class="rounded border overflow-hidden">';
                echo '<table class="table table-sm text-center table-striped">';
                    echo '<tr class="table-light text-dark">';
                        echo '<th>-</th>';
                        echo '<th colspan="4">Marcadores</th>';
                    echo '</tr>';

                    // Traer los posbibles marcadores de la seccion de patron de tinción
                    $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Patrón de marcación'";

                    $marcadores = array();
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                    }

                    echo '<tr class="table-light text-dark">';
                        echo '<th>Patrón de marcación</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                    echo '</tr>';


                    // Traer las posibles respuestas para los marcadores de patron de tinción
                    $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                    from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                    where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Patrón de marcación'";

                    $posibles_respuestas = array();
                    $qryArrayRespuesta = mysql_query($qryRespuesta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                    }


                    // Traer los posbibles marcadores de la seccion de intensidad de la coloración
                    $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la coloración'";

                    $marcadores = array();
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                    }

                    echo '<tr class="table-light text-dark">';
                        echo '<th>Intensidad de la coloración</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                    echo '</tr>';

                    // Traer las posibles respuestas para los marcadores de intensidad de la coloración
                    $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                    from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                    where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la coloración'";

                    $posibles_respuestas = array();
                    $qryArrayRespuesta = mysql_query($qryRespuesta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                    }

                    // Traer los posbibles marcadores de la seccion de Porcentaje de células positivas
                    $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Porcentaje de células positivas'";

                    $marcadores = array();
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                    }

                    echo '<tr class="table-light text-dark">';
                        echo '<th>Porcentaje de células positivas</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                    echo '</tr>';


                    // Traer las posibles respuestas para los marcadores de Porcentaje de células positivas
                    $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                    from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                    where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Porcentaje de células positivas'";

                    $posibles_respuestas = array();
                    $qryArrayRespuesta = mysql_query($qryRespuesta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                    }
                echo '</table>';
            echo '</div>';

            // Traer la pregunta del diagnostico
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT 
                        id_distractor,
                        nombre
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }
        }

            echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
            echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";


            echo '<br />';
            echo '<br />';
            echo '<br />';
            echo '<div class="text-center">';
                echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
                echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
            echo '</div>';
            echo '<div class="text-center">';
                echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
            echo '</div>';
            
            echo '</div>';

            echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
            echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }

    function listarCasosClinicosPatQ($id_reto, $id_laboratorio){
            // Obtener casos clinicos de dicho reto
            $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
            $qryArray = mysql_query($qry);
            mysqlException(mysql_error(),"_01");
            while($qryData = mysql_fetch_array($qryArray)) {
                $id_caso_clinico = $qryData["id_caso_clinico"];
                $codigo = $qryData["codigo"];
                $nombre = $qryData["nombre"];
                $enunciado = $qryData["enunciado"];

                echo "<br />";
                echo "<br />";

                echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
                echo '<h5 class="h6 my-3">Historia clínica</h5>';
                echo '<p>'.$enunciado.'</p>';

                // Traer la pregunta del diagnostico
                $qryPregunta = "SELECT
                    pregunta.id_pregunta,
                    pregunta.nombre
                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

                $qryArrayPregunta = mysql_query($qryPregunta);
                mysqlException(mysql_error(),"_01");
                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                    $id_pregunta = $qryDataPregunta["id_pregunta"];
                    $nombre = $qryDataPregunta["nombre"];

                    // Traer las imagenes relacionadas con la pregunta
                    $qryImagenes = "SELECT
                        imagen_adjunta.ruta,
                        imagen_adjunta.nombre
                    from imagen_adjunta
                    where imagen_adjunta.caso_clinico_id_caso_clinico = $id_caso_clinico and estado = 1 and tipo = 1";
                    
                    $checkrowsImg = mysql_num_rows(mysql_query($qryImagenes));
				
				    if ($checkrowsImg > 0) {
                        $qryArrayImagenes = mysql_query($qryImagenes);
                        mysqlException(mysql_error(),"_01");
                    
                        echo '<div class="card-deck">';
                            
                        while($qryDataImagenes = mysql_fetch_array($qryArrayImagenes)) {
                            $ruta_img = "php/informe/".$qryDataImagenes["ruta"];
                            $nombre_img = $qryDataImagenes["nombre"];
                            echo '<div class="card" style="width: 18rem;">';
                                echo '<img src="'.$ruta_img.'" class="card-img-top" alt="'.$nombre_img.'" title="'.$nombre_img.'" />';
                                echo '<div class="card-body">';
                                    echo '<h5 class="card-title h6">'.$nombre_img.'</h5>';
                                    echo '<a href="'.$ruta_img.'" target="_blank" class="btn btn-primary">Ampliar imagen</a>';
                                echo '</div>';
                            echo '</div>';
                        }
                        
                        echo '</div>';
                    }

                    echo '<h5 class="h6 my-3">'.$nombre.'</h5>';




                    // Traer las posibles respuestas a la pregunta
                    $qryDistractor = "SELECT 
                            id_distractor,
                            nombre
                        from distractor
                        where pregunta_id_pregunta = $id_pregunta";

                    $qryArrayDistractor = mysql_query($qryDistractor);
                    mysqlException(mysql_error(),"_01");

                    echo "<ol type='A'>";
                    
                    while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                        $id_distractor = $qryDataDistractor["id_distractor"];
                        $nombre = $qryDataDistractor["nombre"];
                            echo "<li>";
                                echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                    echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                    echo $nombre;
                                    echo '</label>';
                                echo '</div>';
                            echo "</li>";
                    }

                    echo "</ol>";
                }
            }

            echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
            echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";


            echo '<br />';
            echo '<br />';
            echo '<br />';
            echo '<div class="text-center">';
                echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
                echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
            echo '</div>';
            echo '<div class="text-center">';
                echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
            echo '</div>';
            
            echo '</div>';

            echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
            echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }

    function listarCasosClinicosCitNG($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        while($qryData = mysql_fetch_array($qryArray)) {
            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";

            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Historia clínica</h5>';
            echo '<p>'.$enunciado.'</p>';

            // Traer la pregunta del diagnostico
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];


                // Traer las imagenes relacionadas con la pregunta
                $qryImagenes = "SELECT
                    imagen_adjunta.ruta,
                    imagen_adjunta.nombre
                from imagen_adjunta
                where imagen_adjunta.caso_clinico_id_caso_clinico = $id_caso_clinico and estado = 1 and tipo = 1";
                
                $checkrowsImg = mysql_num_rows(mysql_query($qryImagenes));
            
                if ($checkrowsImg > 0) {
                    $qryArrayImagenes = mysql_query($qryImagenes);
                    mysqlException(mysql_error(),"_01");
                
                    echo '<div class="card-deck">';
                        
                    while($qryDataImagenes = mysql_fetch_array($qryArrayImagenes)) {
                        $ruta_img = "php/informe/".$qryDataImagenes["ruta"];
                        $nombre_img = $qryDataImagenes["nombre"];
                        echo '<div class="card" style="width: 18rem;">';
                            echo '<img src="'.$ruta_img.'" class="card-img-top" alt="'.$nombre_img.'" title="'.$nombre_img.'" />';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title h6">'.$nombre_img.'</h5>';
                                echo '<a href="'.$ruta_img.'" target="_blank" class="btn btn-primary">Ampliar imagen</a>';
                            echo '</div>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                }

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT 
                        id_distractor,
                        nombre
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";


        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }

    function listarCasosClinicosPCM($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        $count_casos_clinicos = 0;

        
        while($qryData = mysql_fetch_array($qryArray)) {

            $count_casos_clinicos++;

            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";
            
            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Descripción</h5>';
            echo '<p>'.$enunciado.'</p>';

            echo '<div class="rounded border overflow-hidden">';
                echo '<table class="table table-sm text-center table-striped tablePCM">';
                    echo '<tr class="table-light text-dark">';
                        echo '<th>-</th>';
                        echo '<th colspan="10">Muestras</th>';
                    echo '</tr>';


                    switch($count_casos_clinicos){
                        case 1: // Si es receptores de estrogenos
        
                                // Traer los posbibles marcadores de la primera seccion
                                $qryPregunta = "SELECT
                                    pregunta.id_pregunta,   
                                    pregunta.nombre
                                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";
        
                                $marcadores = array();
                                $qryArrayPregunta = mysql_query($qryPregunta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                                    $marcadores[] = [
                                        "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                        "nombre" => $qryDataPregunta["nombre"]
                                    ];
                                }
        
                                echo '<tr class="table-light text-dark">';
                                    echo '<th>% de carcinoma con tinción nuclear</th>';
                                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                        echo '<th class="minwidth">'.$marcadores[$countmm]["nombre"].'</th>';
                                    }
                                echo '</tr>';
        
        
                                // Traer las posibles respuestas para los marcadores de patron de tinción
                                $qryRespuesta = "SELECT distinct 
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";
        
                                $posibles_respuestas = array();
                                $qryArrayRespuesta = mysql_query($qryRespuesta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {
        
                                    $nom_distractor = $qryDataRespuesta["nombre"];
        
                                    echo '<tr>';
                                        echo '<td>'.$nom_distractor.'</td>';
                                        
                                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                            
                                            $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                            $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                            
                                            // Se busca el distractor especifico
                                            $qryDistractorEsp = "SELECT 
                                                distractor.id_distractor,
                                                distractor.nombre
                                            from
                                                distractor
                                                join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                                join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                            where 
                                                distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";
        
                                            $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                            mysqlException(mysql_error(),"_01");
                                            while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {
        
                                                $id_distractor_act = $qryDataDistractorEsp["id_distractor"];
        
                                                echo '<td class="minwidth"><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                            }
                                        }
                                    echo '</tr>';
                                }
                                
                                // Traer los posbibles marcadores de la seccion numero dos
                                $qryPregunta = "SELECT
                                    pregunta.id_pregunta,   
                                    pregunta.nombre
                                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción'";
        
                                $marcadores = array();
                                $qryArrayPregunta = mysql_query($qryPregunta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                                    $marcadores[] = [
                                        "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                        "nombre" => $qryDataPregunta["nombre"]
                                    ];
                                }
        
                                echo '<tr class="table-light text-dark">';
                                    echo '<th>Intensidad de tinción</th>';
                                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                        echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                                    }
                                echo '</tr>';
        
                                $qryRespuesta = "SELECT distinct 
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción'";
        
                                $posibles_respuestas = array();
                                $qryArrayRespuesta = mysql_query($qryRespuesta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {
        
                                    $nom_distractor = $qryDataRespuesta["nombre"];
        
                                    echo '<tr>';
                                        echo '<td>'.$nom_distractor.'</td>';
                                        
                                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
        
                                            $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                            $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                            
                                            // Se busca el distractor especifico
                                            $qryDistractorEsp = "SELECT 
                                                distractor.id_distractor,
                                                distractor.nombre
                                            from
                                                distractor
                                                join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                                join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                            where 
                                                distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";
        
                                            $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                            mysqlException(mysql_error(),"_01");
                                            while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {
        
                                                $id_distractor_act = $qryDataDistractorEsp["id_distractor"];
        
                                                echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                            }
                                        }
                                    echo '</tr>';
                                }
        
                                // Traer los posbibles marcadores de la seccion numero 3
                                $qryPregunta = "SELECT
                                    pregunta.id_pregunta,   
                                    pregunta.nombre
                                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";
        
                                $marcadores = array();
                                $qryArrayPregunta = mysql_query($qryPregunta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                                    $marcadores[] = [
                                        "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                        "nombre" => $qryDataPregunta["nombre"]
                                    ];
                                }
        
                                echo '<tr class="table-light text-dark">';
                                    echo '<th>Otros</th>';
                                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                        echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                                    }
                                echo '</tr>';
        
        
                                $qryRespuesta = "SELECT distinct 
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";
        
                                $posibles_respuestas = array();
                                $qryArrayRespuesta = mysql_query($qryRespuesta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {
        
                                    $nom_distractor = $qryDataRespuesta["nombre"];
        
                                    echo '<tr>';
                                        echo '<td>'.$nom_distractor.'</td>';
                                        
                                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
        
                                            $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                            $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                            
                                            // Se busca el distractor especifico
                                            $qryDistractorEsp = "SELECT 
                                                distractor.id_distractor,
                                                distractor.nombre
                                            from
                                                distractor
                                                join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                                join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                            where 
                                                distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";
        
                                            $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                            mysqlException(mysql_error(),"_01");
                                            while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {
        
                                                $id_distractor_act = $qryDataDistractorEsp["id_distractor"];
        
                                                echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                            }
                                        }
                                    echo '</tr>';
                                }

                            break;

                        case 2: // Si es receptores de progestagenos 
                                // Traer los posbibles marcadores de la primera seccion
                                $qryPregunta = "SELECT
                                pregunta.id_pregunta,   
                                pregunta.nombre
                                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";

                                $marcadores = array();
                                $qryArrayPregunta = mysql_query($qryPregunta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                                $marcadores[] = [
                                    "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                    "nombre" => $qryDataPregunta["nombre"]
                                ];
                                }

                                echo '<tr class="table-light text-dark">';
                                echo '<th>% de carcinoma con tinción nuclear</th>';
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                    echo '<th class="minwidth">'.$marcadores[$countmm]["nombre"].'</th>';
                                }
                                echo '</tr>';


                                // Traer las posibles respuestas para los marcadores de patron de tinción
                                $qryRespuesta = "SELECT distinct 
                                distractor.nombre
                                from
                                distractor
                                join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% de carcinoma con tinción nuclear'";

                                $posibles_respuestas = array();
                                $qryArrayRespuesta = mysql_query($qryRespuesta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                                $nom_distractor = $qryDataRespuesta["nombre"];

                                echo '<tr>';
                                    echo '<td>'.$nom_distractor.'</td>';
                                    
                                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                        
                                        $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                        $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                        
                                        // Se busca el distractor especifico
                                        $qryDistractorEsp = "SELECT 
                                            distractor.id_distractor,
                                            distractor.nombre
                                        from
                                            distractor
                                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                        where 
                                            distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                        $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                        mysqlException(mysql_error(),"_01");
                                        while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                            $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                            echo '<td class="minwidth"><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                        }
                                    }
                                echo '</tr>';
                                }

                                // Traer los posbibles marcadores de la seccion numero dos
                                $qryPregunta = "SELECT
                                pregunta.id_pregunta,   
                                pregunta.nombre
                                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción'";

                                $marcadores = array();
                                $qryArrayPregunta = mysql_query($qryPregunta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                                $marcadores[] = [
                                    "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                    "nombre" => $qryDataPregunta["nombre"]
                                ];
                                }

                                echo '<tr class="table-light text-dark">';
                                echo '<th>Intensidad de tinción</th>';
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                    echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                                }
                                echo '</tr>';

                                $qryRespuesta = "SELECT distinct 
                                distractor.nombre
                                from
                                distractor
                                join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad de la tinción'";

                                $posibles_respuestas = array();
                                $qryArrayRespuesta = mysql_query($qryRespuesta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                                $nom_distractor = $qryDataRespuesta["nombre"];

                                echo '<tr>';
                                    echo '<td>'.$nom_distractor.'</td>';
                                    
                                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                        $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                        $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                        
                                        // Se busca el distractor especifico
                                        $qryDistractorEsp = "SELECT 
                                            distractor.id_distractor,
                                            distractor.nombre
                                        from
                                            distractor
                                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                        where 
                                            distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                        $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                        mysqlException(mysql_error(),"_01");
                                        while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                            $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                            echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                        }
                                    }
                                echo '</tr>';
                                }

                                // Traer los posbibles marcadores de la seccion numero 3
                                $qryPregunta = "SELECT
                                pregunta.id_pregunta,   
                                pregunta.nombre
                                from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";

                                $marcadores = array();
                                $qryArrayPregunta = mysql_query($qryPregunta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                                $marcadores[] = [
                                    "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                    "nombre" => $qryDataPregunta["nombre"]
                                ];
                                }

                                echo '<tr class="table-light text-dark">';
                                echo '<th>Otros</th>';
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                    echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                                }
                                echo '</tr>';


                                $qryRespuesta = "SELECT distinct 
                                distractor.nombre
                                from
                                distractor
                                join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";

                                $posibles_respuestas = array();
                                $qryArrayRespuesta = mysql_query($qryRespuesta);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                                $nom_distractor = $qryDataRespuesta["nombre"];

                                echo '<tr>';
                                    echo '<td>'.$nom_distractor.'</td>';
                                    
                                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                        $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                        $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                        
                                        // Se busca el distractor especifico
                                        $qryDistractorEsp = "SELECT 
                                            distractor.id_distractor,
                                            distractor.nombre
                                        from
                                            distractor
                                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                        where 
                                            distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                        $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                        mysqlException(mysql_error(),"_01");
                                        while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                            $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                            echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                        }
                                    }
                                echo '</tr>';
                                }

                        break;
                        case 3: // Si es HER2

                            // Traer los posbibles marcadores de la primera seccion
                            $qryPregunta = "SELECT
                            pregunta.id_pregunta,   
                            pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Grado'";

                            $marcadores = array();
                            $qryArrayPregunta = mysql_query($qryPregunta);
                            mysqlException(mysql_error(),"_01");
                            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                            $marcadores[] = [
                                "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                "nombre" => $qryDataPregunta["nombre"]
                            ];
                            }

                            echo '<tr class="table-light text-dark">';
                            echo '<th>Grado</th>';
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                echo '<th class="minwidth">'.$marcadores[$countmm]["nombre"].'</th>';
                            }
                            echo '</tr>';


                            // Traer las posibles respuestas para los marcadores de patron de tinción
                            $qryRespuesta = "SELECT distinct 
                            distractor.nombre
                            from
                            distractor
                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                            where 
                            grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Grado'";

                            $posibles_respuestas = array();
                            $qryArrayRespuesta = mysql_query($qryRespuesta);
                            mysqlException(mysql_error(),"_01");
                            while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                            $nom_distractor = $qryDataRespuesta["nombre"];

                            echo '<tr>';
                                echo '<td>'.$nom_distractor.'</td>';
                                
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                    
                                    $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                    $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                    
                                    // Se busca el distractor especifico
                                    $qryDistractorEsp = "SELECT 
                                        distractor.id_distractor,
                                        distractor.nombre
                                    from
                                        distractor
                                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where 
                                        distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                    $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                    mysqlException(mysql_error(),"_01");
                                    while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                        $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                        echo '<td class="minwidth"><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                    }
                                }
                            echo '</tr>';
                            }

                            // Traer los posbibles marcadores de la seccion numero dos
                            $qryPregunta = "SELECT
                            pregunta.id_pregunta,   
                            pregunta.nombre
                            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                            where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";

                            $marcadores = array();
                            $qryArrayPregunta = mysql_query($qryPregunta);
                            mysqlException(mysql_error(),"_01");
                            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                            $marcadores[] = [
                                "id_pregunta" => $qryDataPregunta["id_pregunta"],
                                "nombre" => $qryDataPregunta["nombre"]
                            ];
                            }

                            echo '<tr class="table-light text-dark">';
                            echo '<th>Otros</th>';
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                            }
                            echo '</tr>';

                            $qryRespuesta = "SELECT distinct 
                            distractor.nombre
                            from
                            distractor
                            join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                            join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                            where 
                            grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";

                            $posibles_respuestas = array();
                            $qryArrayRespuesta = mysql_query($qryRespuesta);
                            mysqlException(mysql_error(),"_01");
                            while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                            $nom_distractor = $qryDataRespuesta["nombre"];

                            echo '<tr>';
                                echo '<td>'.$nom_distractor.'</td>';
                                
                                for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                    $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                    $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                    
                                    // Se busca el distractor especifico
                                    $qryDistractorEsp = "SELECT 
                                        distractor.id_distractor,
                                        distractor.nombre
                                    from
                                        distractor
                                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                    where 
                                        distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                    $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                    mysqlException(mysql_error(),"_01");
                                    while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                        $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                        echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                    }
                                }
                            echo '</tr>';
                            }

                        break;
                    }

                echo '</table>';
            echo '</div>';
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";

        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';

    }

    function listarCasosClinicosPM2($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        
        while($qryData = mysql_fetch_array($qryArray)) {

            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";
            
            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Descripción</h5>';
            echo '<p>'.$enunciado.'</p>';

            echo '<div class="rounded border overflow-hidden">';
                echo '<table class="table table-sm text-center table-striped tablePCM">';
                    echo '<tr class="table-light text-dark">';
                        echo '<th>-</th>';
                        echo '<th colspan="10">Cores</th>';
                    echo '</tr>';

                        // Traer los posbibles marcadores de la primera seccion
                        $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% Tinción'";

                        $marcadores = array();
                        $qryArrayPregunta = mysql_query($qryPregunta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                        }

                        echo '<tr class="table-light text-dark">';
                        echo '<th>% Tinción</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th class="minwidth">'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                        echo '</tr>';


                        // Traer las posibles respuestas para los marcadores de patron de tinción
                        $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                        from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                        where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = '% Tinción'";

                        $posibles_respuestas = array();
                        $qryArrayRespuesta = mysql_query($qryRespuesta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                
                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td class="minwidth"><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                        }

                        // Traer los posbibles marcadores de la seccion numero dos
                        $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad'";

                        $marcadores = array();
                        $qryArrayPregunta = mysql_query($qryPregunta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                        }

                        echo '<tr class="table-light text-dark">';
                        echo '<th>Intensidad</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                        echo '</tr>';

                        $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                        from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                        where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Intensidad'";

                        $posibles_respuestas = array();
                        $qryArrayRespuesta = mysql_query($qryRespuesta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                        }

                        // Traer los posbibles marcadores de la seccion numero 3
                        $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";

                        $marcadores = array();
                        $qryArrayPregunta = mysql_query($qryPregunta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                        }

                        echo '<tr class="table-light text-dark">';
                        echo '<th>Otros</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th>'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                        echo '</tr>';


                        $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                        from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                        where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Otros'";

                        $posibles_respuestas = array();
                        $qryArrayRespuesta = mysql_query($qryRespuesta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){

                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                        }

                echo '</table>';
            echo '</div>';
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";

        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';

    }


    function listarCasosClinicosHER2($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        
        while($qryData = mysql_fetch_array($qryArray)) {

            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";
            
            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Descripción</h5>';
            echo '<p>'.$enunciado.'</p>';

            echo '<div class="rounded border overflow-hidden">';
                echo '<table class="table table-sm text-center table-striped tablePCM">';
                    echo '<tr class="table-light text-dark">';
                        echo '<th>-</th>';
                        echo '<th colspan="10">Cores</th>';
                    echo '</tr>';

                        // Traer los posbibles marcadores de la primera seccion
                        $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                        from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Score'";

                        $marcadores = array();
                        $qryArrayPregunta = mysql_query($qryPregunta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                        }

                        echo '<tr class="table-light text-dark">';
                        echo '<th>Score</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th class="minwidth">'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                        echo '</tr>';


                        // Traer las posibles respuestas para los marcadores de patron de tinción
                        $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                        from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                        where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Score'";

                        $posibles_respuestas = array();
                        $qryArrayRespuesta = mysql_query($qryRespuesta);
                        mysqlException(mysql_error(),"_01");
                        while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                
                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td class="minwidth"><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                        }

                echo '</table>';
            echo '</div>';
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";

        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }

    function listarCasosClinicosPAP($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        while($qryData = mysql_fetch_array($qryArray)) {
            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";

            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Historia clínica</h5>';
            echo '<p>'.$enunciado.'</p>';

            // Traer la pregunta del diagnostico
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT 
                        id_distractor,
                        nombre
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A' style='list-style-position: inside;'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";

        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }


    function listarCasosClinicosNGC($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        while($qryData = mysql_fetch_array($qryArray)) {
            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";

            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Historia clínica</h5>';
            echo '<p>'.$enunciado.'</p>';

            // Traer la pregunta del diagnostico
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT 
                        id_distractor,
                        nombre,
                        abreviatura
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }

            // Traer la pregunta de la aceptabilidad
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Aceptabilidad'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT
                        id_distractor,
                        nombre,
                        abreviatura
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }

            // Traer la pregunta de la Calidad de la lamina
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Calidad de la lámina'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT
                        id_distractor,
                        nombre,
                        abreviatura
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";


        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';
        
        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }


    function listarCasosClinicosPIP($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        while($qryData = mysql_fetch_array($qryArray)) {
            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";

            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Historia clínica</h5>';
            echo '<p>'.$enunciado.'</p>';

            // Traer la pregunta del diagnostico
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT 
                        id_distractor,
                        nombre
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }


            // Traer la pregunta del slide quality
            $qryPreguntaSlide = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Quality'";

            $qryArrayPreguntaSlide = mysql_query($qryPreguntaSlide);
            mysqlException(mysql_error(),"_01");
            while($qryDataPreguntaSlide = mysql_fetch_array($qryArrayPreguntaSlide)) {
                $id_pregunta = $qryDataPreguntaSlide["id_pregunta"];
                $nombre = $qryDataPreguntaSlide["nombre"];

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';

                // Traer las posibles respuestas a la pregunta
                $qryDistractorSlide = "SELECT
                        id_distractor,
                        nombre
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractorSlide = mysql_query($qryDistractorSlide);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A'>";
                
                while($qryDataDistractorSlide = mysql_fetch_array($qryArrayDistractorSlide)) {
                    $id_distractor = $qryDataDistractorSlide["id_distractor"];
                    $nombre = $qryDataDistractorSlide["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";


        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';
        
        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }

    function listarCasosClinicosCYH($id_reto, $id_laboratorio){

        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        $count_casos_clinicos = 0;


        while($qryData = mysql_fetch_array($qryArray)) {

            $count_casos_clinicos++;

            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";
            
            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';

            echo '<div class="rounded border overflow-hidden">';
                echo '<table class="table table-sm text-center table-striped tablePCM">';
                    echo '<tr class="table-light text-dark">';
                        echo '<th>-</th>';
                        echo '<th colspan="10">Muestras</th>';
                    echo '</tr>';


                    // Primer grupo INTERPRETATION
                    $qryPregunta = "SELECT
                        pregunta.id_pregunta,   
                        pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                        where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Interpretation'";

                    $marcadores = array();
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                    }

                    echo '<tr class="table-light text-dark">';
                        echo '<th>Interpretation</th>';
                        for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                            echo '<th class="minwidth">'.$marcadores[$countmm]["nombre"].'</th>';
                        }
                    echo '</tr>';


                    // Traer las posibles respuestas para los marcadores y la interpretacion
                    $qryRespuesta = "SELECT distinct 
                        distractor.nombre
                    from
                        distractor
                        join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                        join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                    where 
                        grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Interpretation'";

                    $posibles_respuestas = array();
                    $qryArrayRespuesta = mysql_query($qryRespuesta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataRespuesta = mysql_fetch_array($qryArrayRespuesta)) {

                        $nom_distractor = $qryDataRespuesta["nombre"];

                        echo '<tr>';
                            echo '<td>'.$nom_distractor.'</td>';
                            
                            for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                                
                                $id_pregunta_act = $marcadores[$countmm]["id_pregunta"];
                                $nom_pregunta_act = $marcadores[$countmm]["nombre"];
                                
                                // Se busca el distractor especifico
                                $qryDistractorEsp = "SELECT 
                                    distractor.id_distractor,
                                    distractor.nombre
                                from
                                    distractor
                                    join pregunta on pregunta.id_pregunta = distractor.pregunta_id_pregunta
                                    join grupo on grupo.id_grupo = pregunta.grupo_id_grupo
                                where 
                                    distractor.nombre = '".$nom_distractor."' and pregunta_id_pregunta = $id_pregunta_act";

                                $qryArrayDistractorEsp = mysql_query($qryDistractorEsp);
                                mysqlException(mysql_error(),"_01");
                                while($qryDataDistractorEsp = mysql_fetch_array($qryArrayDistractorEsp)) {

                                    $id_distractor_act = $qryDataDistractorEsp["id_distractor"];

                                    echo '<td class="minwidth"><input type="radio" name="in-'.$id_pregunta_act.'" value="in-'.$id_pregunta_act.'-'.$id_distractor_act.'" /></td>';
                                }
                            }
                        echo '</tr>';
                    }

                    // Segundo grupo (AVERAGE NUMBER of HER2)
                    $qryPregunta = "SELECT
                    pregunta.id_pregunta,   
                    pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'HER2/Control Ratio'";

                    $marcadores = array();
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                    }

                    echo '<tr class="table-light text-dark">';
                    echo '<th>Average number of HER2 signals per scored nucleus</th>';
                    
                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                        echo '<td>';
                        echo    '<input type="text" class="form-control form-control-sm" name="in-'.$marcadores[$countmm]['id_pregunta'].'" />';
                        echo '</td>';
                    }


                    // Tercer grupo (HER2 Avg/cell)
                    $qryPregunta = "SELECT
                    pregunta.id_pregunta,   
                    pregunta.nombre
                    from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                    where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'HER2 Avg/cell'";

                    $marcadores = array();
                    $qryArrayPregunta = mysql_query($qryPregunta);
                    mysqlException(mysql_error(),"_01");
                    while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                        $marcadores[] = [
                            "id_pregunta" => $qryDataPregunta["id_pregunta"],
                            "nombre" => $qryDataPregunta["nombre"]
                        ];
                    }
                    echo '</tr>';


                    echo '<tr class="table-light text-dark">';
                    echo '<th>Ratio of HER2 to chromosome 17 centromere signals</th>';
                    
                    for($countmm=0; $countmm<sizeof($marcadores);$countmm++){
                        echo '<td>';
                        echo    '<input type="text" class="form-control form-control-sm" name="in-'.$marcadores[$countmm]['id_pregunta'].'" />';
                        echo '</td>';
                    }

                    echo '</tr>';

                    echo '</table>';
                echo '</div>';       
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";

        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }

    function listarCasosClinicosCITLBC($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        while($qryData = mysql_fetch_array($qryArray)) {
            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";

            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Historia clínica</h5>';
            echo '<p>'.$enunciado.'</p>';

            // Traer la pregunta del diagnostico
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                // Traer las imagenes relacionadas con la pregunta
                $qryImagenes = "SELECT
                    imagen_adjunta.ruta,
                    imagen_adjunta.nombre
                from imagen_adjunta
                where imagen_adjunta.caso_clinico_id_caso_clinico = $id_caso_clinico and estado = 1 and tipo = 1";
                
                $checkrowsImg = mysql_num_rows(mysql_query($qryImagenes));
            
                if ($checkrowsImg > 0) {
                    $qryArrayImagenes = mysql_query($qryImagenes);
                    mysqlException(mysql_error(),"_01");
                
                    echo '<div class="card-deck">';
                        
                    while($qryDataImagenes = mysql_fetch_array($qryArrayImagenes)) {
                        $ruta_img = "php/informe/".$qryDataImagenes["ruta"];
                        $nombre_img = $qryDataImagenes["nombre"];
                        echo '<div class="card" style="width: 18rem;">';
                            echo '<img src="'.$ruta_img.'" class="card-img-top" alt="'.$nombre_img.'" title="'.$nombre_img.'" />';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title h6">'.$nombre_img.'</h5>';
                                echo '<a href="'.$ruta_img.'" target="_blank" class="btn btn-primary">Ampliar imagen</a>';
                            echo '</div>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                }

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';




                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT 
                        id_distractor,
                        nombre
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A' style='list-style-position: inside;'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";


        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }
    
    function listarCasosClinicosCITG($id_reto, $id_laboratorio){
        // Obtener casos clinicos de dicho reto
        $qry = "SELECT id_caso_clinico, codigo, nombre, enunciado FROM caso_clinico where reto_id_reto = $id_reto and estado = 1";
        $qryArray = mysql_query($qry);
        mysqlException(mysql_error(),"_01");
        while($qryData = mysql_fetch_array($qryArray)) {
            $id_caso_clinico = $qryData["id_caso_clinico"];
            $codigo = $qryData["codigo"];
            $nombre = $qryData["nombre"];
            $enunciado = $qryData["enunciado"];

            echo "<br />";
            echo "<br />";

            echo '<h4 class="h5 border-bottom border-info pb-2">'.$nombre.' - '.$codigo.'</h4>';
            echo '<h5 class="h6 my-3">Historia clínica</h5>';
            echo '<p>'.$enunciado.'</p>';

            // Traer la pregunta del diagnostico
            $qryPregunta = "SELECT
                pregunta.id_pregunta,
                pregunta.nombre
            from grupo join pregunta on grupo.id_grupo = pregunta.grupo_id_grupo
                where grupo.caso_clinico_id_caso_clinico = $id_caso_clinico and grupo.nombre = 'Diagnóstico'";

            $qryArrayPregunta = mysql_query($qryPregunta);
            mysqlException(mysql_error(),"_01");
            while($qryDataPregunta = mysql_fetch_array($qryArrayPregunta)) {
                $id_pregunta = $qryDataPregunta["id_pregunta"];
                $nombre = $qryDataPregunta["nombre"];

                // Traer las imagenes relacionadas con la pregunta
                $qryImagenes = "SELECT
                    imagen_adjunta.ruta,
                    imagen_adjunta.nombre
                from imagen_adjunta
                where imagen_adjunta.caso_clinico_id_caso_clinico = $id_caso_clinico and estado = 1 and tipo = 1";
                
                $checkrowsImg = mysql_num_rows(mysql_query($qryImagenes));
            
                if ($checkrowsImg > 0) {
                    $qryArrayImagenes = mysql_query($qryImagenes);
                    mysqlException(mysql_error(),"_01");
                
                    echo '<div class="card-deck">';
                        
                    while($qryDataImagenes = mysql_fetch_array($qryArrayImagenes)) {
                        $ruta_img = "php/informe/".$qryDataImagenes["ruta"];
                        $nombre_img = $qryDataImagenes["nombre"];
                        echo '<div class="card" style="width: 18rem;">';
                            echo '<img src="'.$ruta_img.'" class="card-img-top" alt="'.$nombre_img.'" title="'.$nombre_img.'" />';
                            echo '<div class="card-body">';
                                echo '<h5 class="card-title h6">'.$nombre_img.'</h5>';
                                echo '<a href="'.$ruta_img.'" target="_blank" class="btn btn-primary">Ampliar imagen</a>';
                            echo '</div>';
                        echo '</div>';
                    }
                    
                    echo '</div>';
                }

                echo '<h5 class="h6 my-3">'.$nombre.'</h5>';




                // Traer las posibles respuestas a la pregunta
                $qryDistractor = "SELECT 
                        id_distractor,
                        nombre
                    from distractor
                    where pregunta_id_pregunta = $id_pregunta";

                $qryArrayDistractor = mysql_query($qryDistractor);
                mysqlException(mysql_error(),"_01");

                echo "<ol type='A' style='list-style-position: inside;'>";
                
                while($qryDataDistractor = mysql_fetch_array($qryArrayDistractor)) {
                    $id_distractor = $qryDataDistractor["id_distractor"];
                    $nombre = $qryDataDistractor["nombre"];
                        echo "<li>";
                            echo '<div class="form-check">';
                                echo '<input class="form-check-input" type="radio" id="in-'.$id_pregunta.'-'.$id_distractor.'" name="in-'.$id_pregunta.'" value="in-'.$id_pregunta.'-'.$id_distractor.'" />';
                                echo '<label class="form-check-label" for="in-'.$id_pregunta.'-'.$id_distractor.'">';
                                echo $nombre;
                                echo '</label>';
                            echo '</div>';
                        echo "</li>";
                }

                echo "</ol>";
            }
        }

        echo '<h5 class="h6 my-3">Observaciones adicionales</h5>';
        echo "<textarea class='form-control' id='comentarios_reto' name='comentarios'></textarea>";

        echo '<br />';
        echo '<br />';
        echo '<br />';
        echo '<div class="text-center">';
            echo '<button type="button" id="btn-save-temp" class="btn btn-sm btn-success ml-2"><i class="fas fa-save"></i> Guardar mis respuestas para continuar después</button>';
            echo '<button type="submit" class="btn btn-sm btn-primary ml-2"><i class="fas fa-check"></i> Terminar intento</button>';
        echo '</div>';
        echo '<div class="text-center">';
            echo '<small class="">Si desea cancelar este intento, de clic en el logo de Quik en la parte superior izquierda</small>';
        echo '</div>';

        echo '</div>';

        echo '<input type="hidden" name="laboratorio" value="'.$id_laboratorio.'" />';
        echo '<input type="hidden" name="reto" value="'.$id_reto.'" />';
        echo '</form>';
        echo '<br />';
    }
?>	