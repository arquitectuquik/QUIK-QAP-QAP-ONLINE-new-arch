<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../mysql_compatibility.php';
}

session_start();
include_once "verifica_sesion.php";

if (isset($_POST['tabla']) && $_POST['tabla'] != "" && $_POST['tabla'] != "NULL") {
	$tabla = $_POST['tabla'];
} else {
	$tabla = 0;
}

if (isset($_POST['id_filtro']) && $_POST['id_filtro'] != "" && $_POST['id_filtro'] != "NULL") {
	$id_filtro = clean($_POST['id_filtro']);
} else {
	$id_filtro = 0;
}

if (isset($_POST['id_subfiltro']) && $_POST['id_subfiltro'] != "" && $_POST['id_subfiltro'] != "NULL") {
	$id_subfiltro = clean($_POST['id_subfiltro']);
} else {
	$id_subfiltro = 0;
}
if (isset($_POST['id_subfiltro2']) && $_POST['id_subfiltro2'] != "" && $_POST['id_subfiltro2'] != "NULL") {
	$id_subfiltro2 = clean($_POST['id_subfiltro2']);
} else {
	$id_subfiltro2 = 0;
}

switch ($tabla) {

	case "programa_pat":
		actionRestriction_100();
		$qry = "SELECT 
                        programa_pat.id_programa,
                        programa_pat.nombre 
                    FROM programa_pat
                    order by programa_pat.nombre";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "programas_asignados_pat":
		actionRestriction_125();
		$qry = "SELECT distinct
				programa_pat.id_programa,
				programa_pat.nombre
			FROM 
				programa_pat join reto on programa_pat.id_programa = reto.programa_pat_id_programa
				join reto_laboratorio on reto.id_reto = reto_laboratorio.reto_id_reto
			where reto_laboratorio.laboratorio_id_laboratorio = '" . encryptControl('decrypt', $id_filtro, $_SESSION['qap_token']) . "'
			order by programa_pat.nombre";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "programas_asignados_pat_report":
		actionRestriction_102();
		$qry = "SELECT distinct
				programa_pat.id_programa,
				programa_pat.nombre
			FROM 
				programa_pat join reto on programa_pat.id_programa = reto.programa_pat_id_programa
				join reto_laboratorio on reto.id_reto = reto_laboratorio.reto_id_reto
			where reto_laboratorio.laboratorio_id_laboratorio = '" . $id_filtro . "'
			order by programa_pat.nombre";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "programas_asignados_fin_ronda_report":
		actionRestriction_102();
		$qry = "SELECT 
					programa.id_programa,
					programa.nombre_programa
				FROM programa 
				INNER JOIN programa_laboratorio ON programa.id_programa = programa_laboratorio.id_programa 
				INNER JOIN laboratorio ON programa_laboratorio.id_laboratorio = laboratorio.id_laboratorio 
				where laboratorio.id_laboratorio = '" . $id_filtro . "' 
				ORDER BY programa.nombre_programa ASC, laboratorio.nombre_laboratorio ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "retos_asignados_pat_report":
		actionRestriction_102();

		$id_filtro_programa = $_POST["id_filtro_programa"];

		$qry = "SELECT distinct
				reto.id_reto,
				reto.nombre
			FROM 
				programa_pat join reto on programa_pat.id_programa = reto.programa_pat_id_programa
				join reto_laboratorio on reto.id_reto = reto_laboratorio.reto_id_reto
			where reto_laboratorio.laboratorio_id_laboratorio = '" . $id_filtro . "' and programa_pat.id_programa = '" . $id_filtro_programa . "'";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "rondas_asignadas_fin_ronda_report":
		actionRestriction_102();

		$id_filtro_programa = $_POST["id_filtro_programa"];

		$qry = "SELECT distinct
				ronda.id_ronda,
				ronda.no_ronda
			FROM
				ronda_laboratorio join ronda on ronda.id_ronda = ronda_laboratorio.id_ronda
			where ronda_laboratorio.id_laboratorio = '" . $id_filtro . "' and ronda.id_programa = '" . $id_filtro_programa . "'";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;


	case "intentos_pat_report":
		actionRestriction_102();

		$id_filtro_reto = $_POST["id_filtro_reto"];

		$qry = "SELECT distinct
				intento.id_intento,
				usuario.nombre_usuario,
				intento.fecha
			FROM 
				intento join usuario on usuario.id_usuario = intento.usuario_id_usuario
			where intento.laboratorio_id_laboratorio = '" . $id_filtro . "' and intento.reto_id_reto = '" . $id_filtro_reto . "'";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "info_laboratorio":
		actionRestriction_125();
		$qry = "SELECT distinct
					*
				FROM 
					laboratorio
					join ciudad on ciudad.id_ciudad = laboratorio.id_ciudad
					join pais on pais.id_pais = ciudad.id_pais
				where laboratorio.id_laboratorio = '" . encryptControl('decrypt', $id_filtro, $_SESSION['qap_token']) . "'
				limit 0,1";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "info_laboratorio":
		actionRestriction_125();
		$qry = "SELECT distinct
				*
			FROM 
				laboratorio
				join ciudad on ciudad.id_ciudad = laboratorio.id_ciudad
				join pais on pais.id_pais = ciudad.id_pais
			where laboratorio.id_laboratorio = '" . encryptControl('decrypt', $id_filtro, $_SESSION['qap_token']) . "'
			limit 0,1";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "listar_respuestas_temp":
		actionRestriction_125();


		// Seccion para las respuestas convencionales de seleccion multiple
		$qry = "SELECT distinct
					concat('in-',respuesta_lab_temporal.pregunta_id_pregunta,'-',respuesta_lab_temporal.distractor_id_distractor) as resp_seleccionada
			from
				intento_temporal
				join respuesta_lab_temporal on intento_temporal.id_intento = respuesta_lab_temporal.intento_id_intento
			where respuesta_lab_temporal.distractor_id_distractor is not null and intento_temporal.reto_id_reto = " . $_POST["id_reto"] . " and usuario_id_usuario =" . $_SESSION['qap_userId'] . " and laboratorio_id_laboratorio = " . encryptControl('decrypt', $_POST["id_laboratorio"], $_SESSION['qap_token']) . "";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_18");

		$response_all = array();
		$response_all["respuestas"] = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all["respuestas"][] = $qryData["resp_seleccionada"];
		}


		// Seccion para los comentarios
		$qry2 = "SELECT
				comentario
			from
				intento_temporal
			where intento_temporal.reto_id_reto = " . $_POST["id_reto"] . " and usuario_id_usuario =" . $_SESSION['qap_userId'] . " and laboratorio_id_laboratorio = " . encryptControl('decrypt', $_POST["id_laboratorio"], $_SESSION['qap_token']) . "";

		$qryArray2 = mysql_query($qry2);
		mysqlException(mysql_error(), "_18");
		$qryData2 = mysql_fetch_array($qryArray2);
		$response_all["comentario"] = $qryData2["comentario"];


		// Respuestas de tipo campo numerico abierto
		$qry3 = "SELECT
				concat('in-', respuesta_lab_temporal.pregunta_id_pregunta) as id_pregunta,
				respuesta_cuantitativa
			from
				intento_temporal
				join respuesta_lab_temporal on intento_temporal.id_intento = respuesta_lab_temporal.intento_id_intento
			where respuesta_lab_temporal.respuesta_cuantitativa is not null 
				and intento_temporal.reto_id_reto = " . $_POST["id_reto"] . " 
				and usuario_id_usuario =" . $_SESSION['qap_userId'] . " 
				and laboratorio_id_laboratorio = " . encryptControl('decrypt', $_POST["id_laboratorio"], $_SESSION['qap_token']) . "";

		$qryArray3 = mysql_query($qry3);
		mysqlException(mysql_error(), "_18");

		$response_all["respuestas_abiertas"] = array();

		while ($qryData3 = mysql_fetch_array($qryArray3)) {
			$response_all["respuestas_abiertas"][] = array(
				"id_pregunta" => $qryData3["id_pregunta"],
				"respuesta_cuantitativa" => $qryData3["respuesta_cuantitativa"]
			);
		}

		echo json_encode($response_all);
		break;

	case "info_retos_laboratorio":

		$id_programa_pat = $_POST["id_programa_pat"];

		actionRestriction_125();
		$qry = "SELECT distinct
				programa_pat.nombre as 'nombre_programa_pat',
				reto.id_reto,
				reto.nombre as 'nombre_reto_pat',
				lote_pat.nombre as 'nombre_lote_pat',
				(select count(*)
				from
					caso_clinico
				where caso_clinico.reto_id_reto = reto.id_reto
				limit 1) as num_casos_clinicos,
				(select count(*)
				from
					intento
				where intento.reto_id_reto = reto.id_reto and usuario_id_usuario = " . $_SESSION['qap_userId'] . "
				limit 1) as num_intentos,
				(select 
					fecha
				from
					intento
				where intento.reto_id_reto = reto.id_reto and usuario_id_usuario =" . $_SESSION['qap_userId'] . "
				order by fecha desc
				limit 1
				) as ultimo_intento,

				(select 
					if(id_intento is null, 0, 1)
				from
					intento_temporal
				where intento_temporal.reto_id_reto = reto.id_reto and usuario_id_usuario =" . $_SESSION['qap_userId'] . " and laboratorio_id_laboratorio = " . encryptControl('decrypt', $id_filtro, $_SESSION['qap_token']) . "
				order by fecha desc
				limit 1
				) as intento_temp
			from
				programa_pat join reto on programa_pat.id_programa = reto.programa_pat_id_programa
				join reto_laboratorio on reto_laboratorio.reto_id_reto = reto.id_reto
				left join lote_pat on lote_pat.id_lote_pat = reto.lote_pat_id_lote_pat
			where reto_laboratorio.laboratorio_id_laboratorio = " . encryptControl('decrypt', $id_filtro, $_SESSION['qap_token']) . " and programa_pat.id_programa = $id_programa_pat";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;

	case "reto_pat":
		actionRestriction_100();
		$qry = "SELECT 
						reto.id_reto, 
						reto.nombre 
					FROM reto
					where reto.estado = 1 and reto.programa_pat_id_programa = $id_filtro
					order by reto.nombre";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;
	case "caso_clinico_pat":
		actionRestriction_100();
		$qry = "SELECT 
						caso_clinico_reto.id_caso_clinico_reto,
						caso_clinico_reto.nombre 
					FROM caso_clinico_reto
					where caso_clinico_reto.estado = 1 and programa_pat_reto_id_programa_pat_reto = $id_filtro
					order by caso_clinico_reto.nombre";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;
	case "analito":
		actionRestriction_102();
		$qry = "SELECT 
						$tbl_analito.id_analito,
						$tbl_analito.nombre_analito 
					FROM $tbl_analito 
					JOIN $tbl_programa_analito on $tbl_programa_analito.id_analito = $tbl_analito.id_analito
					WHERE $tbl_programa_analito.id_programa = $id_filtro
					order by $tbl_analito.nombre_analito";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;
	case "analizador":
		actionRestriction_102();
		$qry = "SELECT 
                        $tbl_analizador.id_analizador,
                        $tbl_analizador.nombre_analizador 
                    FROM $tbl_analizador 
                    order by $tbl_analizador.nombre_analizador";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "reactivo":
		actionRestriction_102();
		$qry = "SELECT 
                        $tbl_reactivo.id_reactivo,
                        $tbl_reactivo.nombre_reactivo 
                    FROM $tbl_reactivo 
                    order by $tbl_reactivo.nombre_reactivo";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "metodologia":
		actionRestriction_102();
		$qry = "SELECT 
                        $tbl_metodologia.id_metodologia,
                        $tbl_metodologia.nombre_metodologia 
                    FROM $tbl_metodologia
                    JOIN $tbl_metodologia_analizador on $tbl_metodologia_analizador.id_metodologia = $tbl_metodologia.id_metodologia
                    WHERE $tbl_metodologia_analizador.id_analizador = $id_filtro
                    order by $tbl_metodologia.nombre_metodologia";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);

		break;
	case "unidad":
		actionRestriction_102();
		$qry = "SELECT 
                        $tbl_unidad.id_unidad,
                        $tbl_unidad.nombre_unidad 
                    FROM $tbl_unidad
                    JOIN $tbl_unidad_analizador on $tbl_unidad_analizador.id_unidad = $tbl_unidad.id_unidad
                    WHERE $tbl_unidad_analizador.id_analizador = $id_filtro
                    order by $tbl_unidad.nombre_unidad";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "gen_vitros":
		actionRestriction_102();
		$qry = "SELECT 
                        $tbl_gen_vitros.id_gen_vitros,
                        $tbl_gen_vitros.valor_gen_vitros 
                    FROM $tbl_gen_vitros
                    order by $tbl_gen_vitros.valor_gen_vitros";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;

	case "lotes_digitacion":
		actionRestriction_102();
		$qry = "SELECT 
				$tbl_lote.id_lote,
				$tbl_lote.nombre_lote,
				$tbl_lote.nivel_lote,
				$tbl_lote.fecha_vencimiento 
			FROM 
				$tbl_lote 
				join $tbl_digitacion on $tbl_digitacion.id_lote = $tbl_lote.id_lote
			WHERE digitacion.id_programa = $id_filtro
			group by $tbl_lote.id_lote
			ORDER BY $tbl_lote.nombre_lote ASC
			";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
		// case "ronda_clic_for_52":
		// 	actionRestriction_102();
		// 	$qry = "SELECT distinct
		// 					ronda.id_ronda,
		// 					ronda.no_ronda 
		// 					FROM ronda 
		// 				WHERE  ronda.id_programa = $id_filtro";

		// 	$qryArray = mysql_query($qry);
		// 	mysqlException(mysql_error(), "_01");

		// 	$response_all = array();

		// 	while ($qryData = mysql_fetch_array($qryArray)) {
		// 		$response_all[] = $qryData;
		// 	}

		// 	echo json_encode($response_all);
		// 	break;
		// case "muestra_clic_for_52":
		// 	actionRestriction_102();
		// 	$qry = "SELECT distinct
		// 					muestra.id_muestra,
		// 					muestra.codigo_muestra,
		// 					contador_muestra.no_contador
		// 					FROM contador_muestra 
		// 					JOIN muestra on muestra.id_muestra = contador_muestra.id_muestra
		// 				WHERE  contador_muestra.id_ronda = $id_filtro";

		// 	$qryArray = mysql_query($qry);
		// 	mysqlException(mysql_error(), "_01");

		// 	$response_all = array();

		// 	while ($qryData = mysql_fetch_array($qryArray)) {
		// 		$response_all[] = $qryData;
		// 	}

		// 	echo json_encode($response_all);
		// 	break;
	case "programa_clic_for_52":
		actionRestriction_102();
		$qry = "SELECT distinct
								programa.id_programa,programa.sigla_programa,programa.nombre_programa
								FROM configuracion_laboratorio_analito cla
								INNER JOIN programa ON programa.id_programa = cla.id_programa
							WHERE cla.id_laboratorio IN(" . $id_filtro . ")";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "ano_clic_for_52":
		actionRestriction_102();
		$qry = "SELECT distinct
								EXTRACT( YEAR FROM resultado.fecha_resultado)
								FROM ronda_laboratorio 
								INNER JOIN ronda ON ronda.id_ronda = ronda_laboratorio.id_ronda
								INNER JOIN contador_muestra ON contador_muestra.id_ronda = ronda.id_ronda
								INNER JOIN muestra ON contador_muestra.id_muestra = muestra.id_muestra
								INNER JOIN resultado ON resultado.id_muestra = muestra.id_muestra
							WHERE  ronda.id_programa IN(" . $id_filtro . ")
							AND  ronda_laboratorio.id_laboratorio IN(" . $id_subfiltro . ")";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "mes_clic_for_52":
		actionRestriction_102();
		$qry = "SELECT distinct
										EXTRACT( MONTH FROM resultado.fecha_resultado)
										FROM ronda_laboratorio 
										INNER JOIN ronda ON ronda.id_ronda = ronda_laboratorio.id_ronda
										INNER JOIN contador_muestra ON contador_muestra.id_ronda = ronda.id_ronda
										INNER JOIN muestra ON contador_muestra.id_muestra = muestra.id_muestra
										INNER JOIN resultado ON resultado.id_muestra = muestra.id_muestra
									WHERE  ronda.id_programa IN(" . $id_filtro . ")
									AND  ronda_laboratorio.id_laboratorio IN(" . $id_subfiltro . ")
									AND EXTRACT( YEAR FROM resultado.fecha_resultado) IN(" . $id_subfiltro2 . ")";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "laboratorio_clic_for_52":
		actionRestriction_102();
		$qry = "SELECT id_laboratorio,no_laboratorio,nombre_laboratorio FROM laboratorio WHERE laboratorio.id_ciudad IN(" . $id_filtro . ") ORDER BY laboratorio.no_laboratorio ASC";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "ronda_clic_for_52":
		actionRestriction_102();
		$qry = "SELECT distinct
										ronda.id_ronda,ronda.no_ronda
										FROM ronda_laboratorio 
										INNER JOIN ronda ON ronda.id_ronda = ronda_laboratorio.id_ronda
									WHERE  ronda.id_programa IN(" . $id_filtro . ")
									AND  ronda_laboratorio.id_laboratorio IN(" . $id_subfiltro . ")";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "analito_clic_for_52":
		actionRestriction_102();
		$qry = "SELECT distinct
								analito.id_analito,analito.nombre_analito
								FROM configuracion_laboratorio_analito cla
								INNER JOIN analito ON analito.id_analito= cla.id_analito
							WHERE  cla.id_programa IN(" . $id_filtro . ")
							AND   cla.id_laboratorio IN(" . $id_subfiltro . ")";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
		actionRestriction_102();
		$qry = "SELECT distinct
			ronda.id_ronda,ronda.no_ronda
			FROM ronda_laboratorio 
			INNER JOIN ronda ON ronda.id_ronda = ronda_laboratorio.id_ronda
			WHERE  ronda.id_programa IN(" . $id_filtro . ")
			AND  ronda_laboratorio.id_laboratorio IN(" . $id_subfiltro . ")";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
	case "muestra_clic_for_52":
		actionRestriction_102();
		$qry = "SELECT distinct
			muestra.id_muestra, muestra.codigo_muestra, contador_muestra.no_contador, contador_muestra.id_conexion
			FROM configuracion_laboratorio_analito cla
			INNER JOIN resultado ON resultado.id_configuracion = cla.id_configuracion
			INNER JOIN muestra ON muestra.id_muestra = resultado.id_muestra
			INNER JOIN contador_muestra ON contador_muestra.id_muestra = muestra.id_muestra
			WHERE  cla.id_programa IN(" . $id_filtro . ")
			AND   cla.id_laboratorio IN(" . $id_subfiltro . ")";

		$qryArray = mysql_query($qry);
		mysqlException(mysql_error(), "_01");

		$response_all = array();

		while ($qryData = mysql_fetch_array($qryArray)) {
			$response_all[] = $qryData;
		}

		echo json_encode($response_all);
		break;
}

mysql_close($con);
exit;
