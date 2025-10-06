<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}


    session_start();
	include_once"../verifica_sesion.php";
	actionRestriction_102();

    if(
        isset($_GET["tipoprograma"]) && isset($_GET["idreferencia"])
    ){

        $idreferencia = $_GET["idreferencia"];
        $tipoprograma = $_GET["tipoprograma"];

        if($tipoprograma == "cuantitativo"){ // Si el programa es cuantitativo
            $qryPrincipal = "SELECT 
                        programa.nombre_programa,
                        lote.nombre_lote,
                        digitacion.mes,
                        digitacion.estado
                    FROM 
                        digitacion
                        join programa on programa.id_programa = digitacion.id_programa
                        join lote on lote.id_lote = digitacion.id_lote
                    WHERE digitacion.id_digitacion = $idreferencia
            ";

            $qryArrayPrincipal = mysql_query($qryPrincipal);
            mysqlException(mysql_error(),"_01");
            $array_qry_principal = mysql_fetch_array($qryArrayPrincipal);
            
            
            // Query secundario
            $qrySecundario = "SELECT 
                digitacion_cuantitativa.id_digitacion_cuantitativa,
                digitacion_cuantitativa.id_digitacion,
                analito.nombre_analito,
                analizador.nombre_analizador,
                reactivo.nombre_reactivo,
                metodologia.nombre_metodologia,
                unidad.nombre_unidad,
                unidad_mc.nombre_unidad as nombre_unidad_mc,
                gen_vitros.valor_gen_vitros,
                digitacion_cuantitativa.media_mensual,
                digitacion_cuantitativa.de_mensual,
                digitacion_cuantitativa.cv_mensual,
                digitacion_cuantitativa.n_lab_mensual,
                digitacion_cuantitativa.n_puntos_mensual,
                digitacion_cuantitativa.media_acumulada,
                digitacion_cuantitativa.de_acumulada,
                digitacion_cuantitativa.cv_acumulada,
                digitacion_cuantitativa.n_lab_acumulada,
                digitacion_cuantitativa.n_puntos_acumulada,
                digitacion_cuantitativa.media_jctlm,
                digitacion_cuantitativa.etmp_jctlm,
                digitacion_cuantitativa.media_inserto,
                digitacion_cuantitativa.de_inserto,
                digitacion_cuantitativa.cv_inserto,
                digitacion_cuantitativa.n_inserto
            FROM 
                digitacion_cuantitativa
                join analito on analito.id_analito = digitacion_cuantitativa.id_analito
                join analizador on analizador.id_analizador = digitacion_cuantitativa.id_analizador
                join reactivo on reactivo.id_reactivo = digitacion_cuantitativa.id_reactivo
                join metodologia on metodologia.id_metodologia = digitacion_cuantitativa.id_metodologia
                join unidad on unidad.id_unidad = digitacion_cuantitativa.id_unidad
                left join unidad unidad_mc on unidad_mc.id_unidad = digitacion_cuantitativa.id_unidad_mc
                join gen_vitros on gen_vitros.id_gen_vitros = digitacion_cuantitativa.id_gen_vitros 

            WHERE
                digitacion_cuantitativa.id_digitacion = $idreferencia
            ORDER BY analito.nombre_analito
            ";

            $qryArraySecundario = mysql_query($qrySecundario);
            mysqlException(mysql_error(),"_01");
            $array_qry_secundario = array();

            $count_inserto_val = 0;
            
            while($qryDataSecundario = mysql_fetch_array($qryArraySecundario)) {
                $digitacionActual = array();
                $digitacionActual["id_digitacion_cuantitativa"] = $qryDataSecundario["id_digitacion_cuantitativa"];
                $digitacionActual["id_digitacion"] = $qryDataSecundario["id_digitacion"];
                $digitacionActual["nombre_analito"] = $qryDataSecundario["nombre_analito"];
                $digitacionActual["nombre_analizador"] = $qryDataSecundario["nombre_analizador"];
                $digitacionActual["nombre_reactivo"] = $qryDataSecundario["nombre_reactivo"];
                $digitacionActual["nombre_metodologia"] = $qryDataSecundario["nombre_metodologia"];
                $digitacionActual["nombre_unidad"] = $qryDataSecundario["nombre_unidad"];
                $digitacionActual["nombre_unidad_mc"] = $qryDataSecundario["nombre_unidad_mc"];
                $digitacionActual["valor_gen_vitros"] = $qryDataSecundario["valor_gen_vitros"];
                $digitacionActual["media_mensual"] = $qryDataSecundario["media_mensual"];
                $digitacionActual["de_mensual"] = $qryDataSecundario["de_mensual"];
                $digitacionActual["cv_mensual"] = $qryDataSecundario["cv_mensual"];
                $digitacionActual["n_lab_mensual"] = $qryDataSecundario["n_lab_mensual"];
                $digitacionActual["n_puntos_mensual"] = $qryDataSecundario["n_puntos_mensual"];
                $digitacionActual["media_acumulada"] = $qryDataSecundario["media_acumulada"];
                $digitacionActual["de_acumulada"] = $qryDataSecundario["de_acumulada"];
                $digitacionActual["cv_acumulada"] = $qryDataSecundario["cv_acumulada"];
                $digitacionActual["n_lab_acumulada"] = $qryDataSecundario["n_lab_acumulada"];
                $digitacionActual["n_puntos_acumulada"] = $qryDataSecundario["n_puntos_acumulada"];
                $digitacionActual["media_jctlm"] = $qryDataSecundario["media_jctlm"];
                $digitacionActual["etmp_jctlm"] = $qryDataSecundario["etmp_jctlm"];
                $digitacionActual["media_inserto"] = $qryDataSecundario["media_inserto"];
                $digitacionActual["de_inserto"] = $qryDataSecundario["de_inserto"];
                $digitacionActual["cv_inserto"] = $qryDataSecundario["cv_inserto"];
                $digitacionActual["n_inserto"] = $qryDataSecundario["n_inserto"];

                if(
                    $digitacionActual["media_inserto"] != "" ||
                    $digitacionActual["de_inserto"] != "" ||
                    $digitacionActual["cv_inserto"] != "" ||
                    $digitacionActual["n_inserto"] != ""
                ){ // Contador de valores de inserto
                    $count_inserto_val = $count_inserto_val + 1; 
                }

                $array_qry_secundario[] = $digitacionActual;
            }

            mysql_close($con);

        
        require_once("generalInformeResumen.php");

        $pdf = new generalInformeResumen('L','mm','letter'); // Página vertical, tamaño carta, medición en Milímetros
        $pdf->AliasNbPages();
        $pdf->AddPage();
        
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetFont('Arial','B',8);
        
        // Etiquetas
        $pdf->SetXY(10,30);

        $programa = $array_qry_principal["nombre_programa"];
        $lote = $array_qry_principal["nombre_lote"];
        $fecha = explode("-",$array_qry_principal["mes"]);
        $anno = $fecha[0];
        $mes = $fecha[1];
        
        $pdf->SetFont('Arial','B',8);
        $pdf->SetTextColor(40, 40, 40);
        $pdf->SetDrawColor(127, 179, 213);
        $pdf->SetFillColor(200, 212, 221);
        $pdf->Cell(21,5,"PROGRAMA",1,0,'L',1);
        $pdf->SetFillColor(230, 237, 242);
        
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(50,5,$programa,1,0,'L',1);
        
        $pdf->SetFont('Arial','B',8);
        $pdf->SetFillColor(200, 212, 221);
        $pdf->Cell(21,5,"LOTE",1,0,'L',1);
        $pdf->SetFillColor(230, 237, 242);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(24,5,$lote,1,0,'L',1);
        
        $pdf->SetFillColor(200, 212, 221);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(21,5,"MES",1,0,'L',1);
        $pdf->SetFillColor(230, 237, 242);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(24,5,"$anno-$mes",1,0,'L',1);
        
        $pdf->SetFillColor(200, 212, 221);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(21,5,"ESTADO",1,0,'L',1);
        $pdf->SetFillColor(230, 237, 242);
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(24,5,(($array_qry_principal["estado"] == 1) ? "Activo" : "Inactivo") ,1,0,'L',1);

        $pdf->Ln(6);

        $pdf->SetFillColor(200, 212, 221);
        $pdf->SetFont('Arial','B',7);
        $pdf->Cell(21,4,"Resumen de convenciones:",0,0,'L',0);
        $pdf->Ln(3);
        $pdf->SetFont('Arial','',7);
        $pdf->Cell(21,4,"IT: Item | TG: Tipo de gestión | G: Generación VITROS | Xpt: Valor aceptado como verdadero | N: Número de puntos de comparación | Tipos de gestión: 1-Original ó 2-Adaptación",0,0,'L',0);
        $pdf->SetFillColor(230, 237, 242);
        
        $pdf->Ln(8);
        $pdf->SetX(10);


        if($count_inserto_val > 0){ // Si hay como minimo un valor de inserto en la BD

            $anchoTercerNivel = 7.5;
            $anchoItem = 5;
            $anchoAnalito = 20;
            $anchoAnalizador = 22;
            $anchoReactivo = 13;
            $anchoMetodologia = 23;
            $anchoUnidad = 8.5;

            $pdf->con_inserto_incluido = true;

            // Enumeración
            $pdf->SetDrawColor(146, 169, 185);
            $pdf->SetFillColor(191, 208, 222);
            $pdf->SetFont('Arial','B',5);
            $pdf->Cell($anchoItem,2,"1",0,0,'C',0); // It
            $pdf->Cell($anchoAnalito,2,"2",0,0,'C',0); // Analito
            $pdf->Cell($anchoAnalizador,2,"3",0,0,'C',0); // Analizador y generacion de vitros
            $pdf->Cell($anchoReactivo,2,"4",0,0,'C',0); // Reactivo
            $pdf->Cell($anchoMetodologia,2,"5",0,0,'C',0); // Metodologia
            $pdf->Cell($anchoUnidad,2,"6",0,0,'C',0); // Unidad
            $pdf->Cell($anchoUnidad,2,"7",0,0,'C',0); // Unidad
            $pdf->Cell($anchoTercerNivel,2,"8",0,0,'C',0); // JCTLM
            $pdf->Cell($anchoTercerNivel,2,"9",0,0,'C',0);

            $pdf->Cell($anchoTercerNivel,2,"10",0,0,'C',0); // Mensual
            $pdf->Cell($anchoTercerNivel,2,"11",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"12",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"13",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"14",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"15",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"16",0,0,'C',0);

            $pdf->Cell($anchoTercerNivel,2,"17",0,0,'C',0); // Acumulada
            $pdf->Cell($anchoTercerNivel,2,"18",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"19",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"20",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"21",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"22",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"23",0,0,'C',0);

            $pdf->Cell($anchoTercerNivel,2,"24",0,0,'C',0); // Inserto
            $pdf->Cell($anchoTercerNivel,2,"25",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"26",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"27",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"28",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"29",0,1,'C',0);
            
            // Encabezado primer nivel
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',5);
            $pdf->Cell($anchoItem,9,"IT",1,0,'C',1);
            $pdf->Cell($anchoAnalito,9,"ANALITO",1,0,'C',1);
            $pdf->Cell($anchoAnalizador,9,"ANALIZADOR (GEN.)",1,0,'C',1);
            $pdf->Cell($anchoReactivo,9,"REACTIVO",1,0,'C',1);
            $pdf->Cell($anchoMetodologia,9,"METODOLOGIA",1,0,'C',1);
            $pdf->Cell($anchoUnidad,9,"UNIDAD",1,0,'C',1);
            $pdf->Cell($anchoUnidad,9,"U-MC",1,0,'C',1);
            
            $pdf->Cell($anchoTercerNivel * 2,4.5,"M.T. JCTLM",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 7,3,"MENSUAL",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 7,3,"ACUMULADA",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 6,3,"INSERTO",1,0,'C',1);

            // Borde izquierdo mensual
            $pdf->SetDrawColor(27, 100, 155);
            
            $pdf->SetLineWidth(0.3);
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 2,49);
            $pdf->Cell(0,3,"","L",0,'C',0);
            
            // Borde izquierdo acumulada
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 9,49);
            $pdf->Cell(0,3,"","L",0,'C',0);

            // Borde izquierdo inserto
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 16,49);
            $pdf->Cell(0,3,"","L",0,'C',0);

            // Borde derecho inserto
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 22,49);
            $pdf->Cell(0,3,"","L",0,'C',0);

            
            $pdf->SetDrawColor(146, 169, 185); // Reestablecimiento de color
            $pdf->SetLineWidth(0.2);
            
            // Segundo Nivel
            $pdf->SetFont('Arial','B',3.7);
            
            // JCTLM
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad,53.5);

            $pdf->Cell($anchoTercerNivel,4.5,"Xpt",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,4.5,"ETmp/APS",1,0,'C',1);
            
            // MENSUAL
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 2,52);
            $pdf->Cell($anchoTercerNivel,6,"ME",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"DE",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"CV",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"N",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"#DATOS",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 2,3,"INCERTIDUMBRE",1,0,'C',1);
            // ACUMULADA
            $pdf->Cell($anchoTercerNivel,6,"ME",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"DE",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"CV",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"N",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"#DATOS",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 2,3,"INCERTIDUMBRE",1,0,'C',1);
            // INSERTO
            $pdf->Cell($anchoTercerNivel,6,"ME",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"DE",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"CV",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"N",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 2,3,"INCERTIDUMBRE",1,0,'C',1);
            
            // TERCER NIVEL
            // MENSUAL
            $pdf->SetFont('Arial','B',3.5);
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 7,55);
            $pdf->Cell($anchoTercerNivel,3,"INFERIOR",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,3,"SUPERIOR",1,0,'C',1);

            // ACUMULADA
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 14,55);
            $pdf->Cell($anchoTercerNivel,3,"INFERIOR",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,3,"SUPERIOR",1,0,'C',1);

            // INSERTO
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 20,55);
            $pdf->Cell($anchoTercerNivel,3,"INFERIOR",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,3,"SUPERIOR",1,0,'C',1);
            
            $pdf->SetLineWidth(0.3);
            $pdf->SetDrawColor(27, 100, 155);
            // Lado izquierdo de mensual
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 2,52);
            $pdf->Cell(0,6,"","L",0,'C',0);
            // Lado izquierdo acumulado
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 9,52);
            $pdf->Cell(0,6,"","L",0,'C',0);
            // Lado izquierdo inserto
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 16,52);
            $pdf->Cell(0,6,"","L",0,'C',0);
            // Lado derecho inserto
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 22,52);
            $pdf->Cell(0,6,"","L",0,'C',0);

            
            $pdf->SetLineWidth(0.2);
            $pdf->SetDrawColor(146, 169, 185); // Reestablecimiento de color

            $pdf->SetXY(10,58);
            $pdf->SetFont('Arial','',4.5);

            // Tabla de contenido
            $pdf->SetWidths(
                array(
                    $anchoItem,
                    $anchoAnalito,
                    $anchoAnalizador,
                    $anchoReactivo,
                    $anchoMetodologia,
                    $anchoUnidad,
                    $anchoUnidad,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel
                ));
            $pdf->SetAligns(
                array(
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C"
                    )
                );

                $contador = 0;
                foreach($array_qry_secundario as $row_res){
                    $contador++;
        
                    if($contador % 2 == 0){
                        $pdf->SetFillColor(255, 255, 255);
                    } else {
                        $pdf->SetFillColor(240, 240, 240);
                    }


                    if($row_res["media_mensual"] != null && $row_res["de_mensual"] != null && $row_res["media_mensual"] != "" && $row_res["de_mensual"] != ""){
                        $inc_inf_mensual = $row_res["media_mensual"] - ($row_res["de_mensual"] * 2);
                        $inc_sup_mensual = $row_res["media_mensual"] + ($row_res["de_mensual"] * 2);
                    } else {
                        $inc_inf_mensual = "";
                        $inc_sup_mensual = "";
                    }


                    if($row_res["media_acumulada"] != null && $row_res["de_acumulada"] != null && $row_res["media_acumulada"] != "" && $row_res["de_acumulada"] != ""){
                        $inc_inf_acum = $row_res["media_acumulada"] - ($row_res["de_acumulada"] * 2);
                        $inc_sup_acum = $row_res["media_acumulada"] + ($row_res["de_acumulada"] * 2);
                    } else {
                        $inc_inf_acum = "";
                        $inc_sup_acum = "";
                    }


                    if($row_res["media_inserto"] != null && $row_res["de_inserto"] != null && $row_res["media_inserto"] != "" && $row_res["de_inserto"] != ""){
                        $inc_inf_inserto = $row_res["media_inserto"] - ($row_res["de_inserto"] * 2);
                        $inc_sup_inserto = $row_res["media_inserto"] + ($row_res["de_inserto"] * 2);
                    } else {
                        $inc_inf_inserto = "";
                        $inc_sup_inserto = "";
                    }

                    $pdf->Row(array(
                        $contador . "\n", // IT
                        $row_res["nombre_analito"] . "\n", // Analito
                        $row_res["nombre_analizador"] . " (". $row_res["valor_gen_vitros"] .")"."\n", // Analizador y generacion
                        $row_res["nombre_reactivo"] ."\n", // Reactivo
                        $row_res["nombre_metodologia"] ."\n", // Metodologia
                        $row_res["nombre_unidad"] ."\n", // Unidad
                        $row_res["nombre_unidad_mc"] ."\n", // Unidad
                        
                        $row_res["media_jctlm"] . "\n", /* VAV */
                        $row_res["etmp_jctlm"] . "\n", /* ETMP% */
                        
                        $row_res["media_mensual"] . "\n", /* Media mensual*/
                        $row_res["de_mensual"] . "\n", /* DE mensual*/
                        $row_res["cv_mensual"] . "\n", /* CV */
                        $row_res["n_lab_mensual"] . "\n", /* N */
                        $row_res["n_puntos_mensual"] . "\n", /* #DATOS */
                        round($inc_inf_mensual,2) . "\n", /* INF INCERTIDUMBRE */
                        round($inc_sup_mensual,2) . "\n", /* SUP INCERTIDUMBRE */
                        
                        $row_res["media_acumulada"] . "\n", /* Media acumulada*/
                        $row_res["de_acumulada"] . "\n", /* DE acumulada*/
                        $row_res["cv_acumulada"] . "\n", /* CV */
                        $row_res["n_lab_acumulada"] . "\n", /* N */
                        $row_res["n_puntos_acumulada"] . "\n", /* #DATOS */
                        round($inc_inf_acum,2) . "\n", /* INF INCERTIDUMBRE */
                        round($inc_sup_acum,2) . "\n", /* SUP INCERTIDUMBRE */


                        $row_res["media_inserto"] . "\n", /* Media inserto */
                        $row_res["de_inserto"] . "\n", /* DE inserto */
                        $row_res["cv_inserto"] . "\n", /* CV */
                        $row_res["n_inserto"] . "\n", /* N */
                        $inc_inf_inserto . "\n", /* INF INCERTIDUMBRE */
                        $inc_sup_inserto . "\n" /* SUP INCERTIDUMBRE */
                    ));
                }
        } else {
            
            $anchoTercerNivel = 9;
            $anchoItem = 5;
            $anchoAnalito = 24;
            $anchoAnalizador = 26;
            $anchoReactivo = 17;
            $anchoMetodologia = 27;
            $anchoUnidad = 8;

            $pdf->con_inserto_incluido = false;

            // Enumeración
            $pdf->SetDrawColor(146, 169, 185);
            $pdf->SetFillColor(191, 208, 222);
            $pdf->SetFont('Arial','B',5);
            $pdf->Cell($anchoItem,2,"1",0,0,'C',0); // It
            $pdf->Cell($anchoAnalito,2,"2",0,0,'C',0); // Analito
            $pdf->Cell($anchoAnalizador,2,"3",0,0,'C',0); // Analizador y generacion de vitros
            $pdf->Cell($anchoReactivo,2,"4",0,0,'C',0); // Reactivo
            $pdf->Cell($anchoMetodologia,2,"5",0,0,'C',0); // Metodologia
            $pdf->Cell($anchoUnidad,2,"6",0,0,'C',0); // Unidad
            $pdf->Cell($anchoUnidad,2,"7",0,0,'C',0); // Unidad
            $pdf->Cell($anchoTercerNivel,2,"8",0,0,'C',0); // JCTLM
            $pdf->Cell($anchoTercerNivel,2,"9",0,0,'C',0);

            $pdf->Cell($anchoTercerNivel,2,"10",0,0,'C',0); // Mensual
            $pdf->Cell($anchoTercerNivel,2,"11",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"12",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"13",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"14",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"15",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"16",0,0,'C',0);

            $pdf->Cell($anchoTercerNivel,2,"17",0,0,'C',0); // Acumulada
            $pdf->Cell($anchoTercerNivel,2,"18",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"19",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"20",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"21",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"22",0,0,'C',0);
            $pdf->Cell($anchoTercerNivel,2,"23",0,1,'C',0);
            
            // Encabezado primer nivel
            $pdf->SetX(10);
            $pdf->SetFont('Arial','B',5.5);
            $pdf->Cell($anchoItem,9,"IT",1,0,'C',1);
            $pdf->Cell($anchoAnalito,9,"ANALITO",1,0,'C',1);
            $pdf->Cell($anchoAnalizador,9,"ANALIZADOR (GEN.)",1,0,'C',1);
            $pdf->Cell($anchoReactivo,9,"REACTIVO",1,0,'C',1);
            $pdf->Cell($anchoMetodologia,9,"METODOLOGIA",1,0,'C',1);
            $pdf->Cell($anchoUnidad,9,"UNIDAD",1,0,'C',1);
            $pdf->Cell($anchoUnidad,9,"U-MC",1,0,'C',1);
            
            $pdf->Cell($anchoTercerNivel * 2,4.5,"M.T. JCTLM",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 7,3,"MENSUAL",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 7,3,"ACUMULADA",1,0,'C',1);

            // Borde izquierdo mensual
            $pdf->SetDrawColor(27, 100, 155);
            
            $pdf->SetLineWidth(0.3);
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 2,49);
            $pdf->Cell(0,3,"","L",0,'C',0);
            
            // Borde izquierdo acumulada
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 9,49);
            $pdf->Cell(0,3,"","L",0,'C',0);

            // Borde izquierdo acumulada
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 16,49);
            $pdf->Cell(0,3,"","L",0,'C',0);

            
            $pdf->SetDrawColor(146, 169, 185); // Reestablecimiento de color
            $pdf->SetLineWidth(0.2);
            
            // Segundo Nivel
            $pdf->SetFont('Arial','B',4.5);
            
            // JCTLM
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad,53.5);

            $pdf->Cell($anchoTercerNivel,4.5,"Xpt",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,4.5,"ETmp/APS",1,0,'C',1);
            
            // MES
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 2,52);
            $pdf->Cell($anchoTercerNivel,6,"ME",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"DE",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"CV",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"N",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"#DATOS",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 2,3,"INCERTIDUMBRE",1,0,'C',1);
            // ACUMULADA
            $pdf->Cell($anchoTercerNivel,6,"ME",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"DE",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"CV",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"N",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,6,"#DATOS",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel * 2,3,"INCERTIDUMBRE",1,0,'C',1);
            
            // TERCER NIVEL
            // MENSUAL
            $pdf->SetFont('Arial','B',4);
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 7,55);
            $pdf->Cell($anchoTercerNivel,3,"INFERIOR",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,3,"SUPERIOR",1,0,'C',1);

            // ACUMULADA
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 14,55);
            $pdf->Cell($anchoTercerNivel,3,"INFERIOR",1,0,'C',1);
            $pdf->Cell($anchoTercerNivel,3,"SUPERIOR",1,0,'C',1);
            
            $pdf->SetLineWidth(0.3);
            $pdf->SetDrawColor(27, 100, 155);
            // Lado izquierdo de mensual
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 2,52);
            $pdf->Cell(0,6,"","L",0,'C',0);
            // Lado izquierdo acumulado
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 9,52);
            $pdf->Cell(0,6,"","L",0,'C',0);
            // Lado izquierdo inserto
            $pdf->SetXY(10 + $anchoItem + $anchoAnalito + $anchoAnalizador + $anchoReactivo + $anchoMetodologia + $anchoUnidad + $anchoUnidad + $anchoTercerNivel * 16,52);
            $pdf->Cell(0,6,"","L",0,'C',0);
            
            $pdf->SetLineWidth(0.2);
            $pdf->SetDrawColor(146, 169, 185); // Reestablecimiento de color

            $pdf->SetXY(10,58);
            $pdf->SetFont('Arial','',4.8);

            // Tabla de contenido
            $pdf->SetWidths(
                array(
                    $anchoItem,
                    $anchoAnalito,
                    $anchoAnalizador,
                    $anchoReactivo,
                    $anchoMetodologia,
                    $anchoUnidad,
                    $anchoUnidad,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel,
                    $anchoTercerNivel
                ));
            $pdf->SetAligns(
                array(
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C",
                    "C"
                    )
                );

                $contador = 0;
                foreach($array_qry_secundario as $row_res){
                    $contador++;
        
                    if($contador % 2 == 0){
                        $pdf->SetFillColor(255, 255, 255);
                    } else {
                        $pdf->SetFillColor(240, 240, 240);
                    }


                    if($row_res["media_mensual"] != null && $row_res["de_mensual"] != null && $row_res["media_mensual"] != "" && $row_res["de_mensual"] != ""){
                        $inc_inf_mensual = $row_res["media_mensual"] - ($row_res["de_mensual"] * 2);
                        $inc_sup_mensual = $row_res["media_mensual"] + ($row_res["de_mensual"] * 2);
                    } else {
                        $inc_inf_mensual = "";
                        $inc_sup_mensual = "";
                    }


                    if($row_res["media_acumulada"] != null && $row_res["de_acumulada"] != null && $row_res["media_acumulada"] != "" && $row_res["de_acumulada"] != ""){
                        $inc_inf_acum = $row_res["media_acumulada"] - ($row_res["de_acumulada"] * 2);
                        $inc_sup_acum = $row_res["media_acumulada"] + ($row_res["de_acumulada"] * 2);
                    } else {
                        $inc_inf_acum = "";
                        $inc_sup_acum = "";
                    }

                    $pdf->Row(array(
                        $contador . "\n", // IT
                        $row_res["nombre_analito"] . "\n", // Analito
                        $row_res["nombre_analizador"] . " (". $row_res["valor_gen_vitros"] .")"."\n", // Analizador y generacion
                        $row_res["nombre_reactivo"] ."\n", // Reactivo
                        $row_res["nombre_metodologia"] ."\n", // Metodologia
                        $row_res["nombre_unidad"] ."\n", // Unidad
                        $row_res["nombre_unidad_mc"] ."\n", // Unidad
                        
                        $row_res["media_jctlm"] . "\n", /* VAV */
                        $row_res["etmp_jctlm"] . "\n", /* ETMP% */
                        
                        $row_res["media_mensual"] . "\n", /* Media mensual*/
                        $row_res["de_mensual"] . "\n", /* DE mensual*/
                        $row_res["cv_mensual"] . "\n", /* CV */
                        $row_res["n_lab_mensual"] . "\n", /* N */
                        $row_res["n_puntos_mensual"] . "\n", /* #DATOS */
                        round($inc_inf_mensual,2) . "\n", /* INF INCERTIDUMBRE */
                        round($inc_sup_mensual,2) . "\n", /* SUP INCERTIDUMBRE */
                        
                        $row_res["media_acumulada"] . "\n", /* Media acumulada*/
                        $row_res["de_acumulada"] . "\n", /* DE acumulada*/
                        $row_res["cv_acumulada"] . "\n", /* CV */
                        $row_res["n_lab_acumulada"] . "\n", /* N */
                        $row_res["n_puntos_acumulada"] . "\n", /* #DATOS */
                        round($inc_inf_acum,2) . "\n", /* INF INCERTIDUMBRE */
                        round($inc_sup_acum,2) . "\n" /* SUP INCERTIDUMBRE */
                    ));
                }
        }

        // Cerrar PDF
        $pdf->Close();

        $nomArchivo = utf8_decode("QAP-FOR-07 - $programa - $lote ($anno-$mes) .pdf");
        $pdf->Output("I",$nomArchivo);



        } else { // Si es cualitativo
            echo "Aun no hay soporte para reporte cualitativos...";
        }
    
    } else {
        echo "Información insuficiente para la generación del reporte...";
    }
?>
