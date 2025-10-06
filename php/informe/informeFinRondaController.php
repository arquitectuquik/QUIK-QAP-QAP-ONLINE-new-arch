<?php
// Cargar compatibilidad MySQL para PHP 7+
if (!function_exists('mysql_connect')) {
    require_once '../../mysql_compatibility.php';
}

require_once __DIR__ . "/../controllers/MediaDeComparacionController.php";
require_once __DIR__ . "/../repositorys/ResultadosRepository.php";
require_once __DIR__ . "/../LogicaNegocio/MediaDeComparacion/App/TodosParticipantesFabrica.php";
require_once __DIR__ . "/../LogicaNegocio/MediaDeComparacion/App/ParticipantesMismaMetodologiaFabrica.php";
require_once __DIR__ . "/../repositorys/MediaEvaluacionEspecialRepository.php";
require_once __DIR__ . "/../LogicaNegocio/MediaDeComparacion/App/CaluladoresMedia/CalculadorMediaCasoEspecialEstrategiaDecorador.php";
require_once __DIR__ . "/../LogicaNegocio/MediaDeComparacion/App/CaluladoresMedia/CalculadorMediaConFiltrosAtipicosEstrategia.php";
require_once __DIR__ . "/../LogicaNegocio/MediaDeComparacion/App/FiltrosAtipicos/FiltroGrubbsFabrica.php";
require_once __DIR__ . "/../LogicaNegocio/MediaDeComparacion/App/FiltrosAtipicos/FiltroIntercuartilicoFabrica.php";
/*



ini_set('display_errors', 1);



ini_set('display_startup_errors', 1);



*/







class informeFinRondaController
{







    public static $verde = [46, 204, 113];



    public static $azul = [93, 173, 226];



    public static $rosa = [218, 104, 180];



    public static $gris_oscuro = [142, 142, 142];



    public static $gris_claro = [207, 207, 207];



    public static $return_vav_empty;

    public static $controllerMediaTodosParticipantes;
    public static $controllerMediaMismaMetodologia;







    public function __construct()



    {
    }







    public static function getPrograma($id_programa)



    {



        $qry = "SELECT * FROM programa WHERE id_programa = '$id_programa'";



        $qryData = mysql_fetch_array(mysql_query($qry));



        return (object) array(



            "id_programa" => $qryData["id_programa"],



            "nombre_programa" => $qryData["nombre_programa"],



            "sigla_programa" => $qryData["sigla_programa"],



            "tipo_muestra" => $qryData["tipo_muestra"],



            "modalidad_muestra" => $qryData["modalidad_muestra"],



            "no_muestras" => $qryData["no_muestras"],



            "id_tipo_programa" => $qryData["id_tipo_programa"],



        );
    }







    public static function getLaboratorio($id_laboratorio)



    {



        $qry = "SELECT *



                    FROM laboratorio



                        join ciudad on ciudad.id_ciudad = laboratorio.id_ciudad



                        join pais on pais.id_pais = ciudad.id_pais



                    WHERE id_laboratorio = '$id_laboratorio'";



        $qryData = mysql_fetch_array(mysql_query($qry));



        return (object) array(



            "id_laboratorio" => $qryData["id_laboratorio"],



            "no_laboratorio" => $qryData["no_laboratorio"],



            "nombre_laboratorio" => $qryData["nombre_laboratorio"],



            "direccion_laboratorio" => $qryData["direccion_laboratorio"],



            "telefono_laboratorio" => $qryData["telefono_laboratorio"],



            "correo_laboratorio" => $qryData["correo_laboratorio"],



            "contacto_laboratorio" => $qryData["contacto_laboratorio"],



            "nombre_ciudad" => $qryData["nombre_ciudad"],



            "nombre_pais" => $qryData["nombre_pais"],



            "id_ciudad" => $qryData["id_ciudad"],



        );
    }







    public static function getRonda($id_ronda, $id_programa)



    {



        $qry = "SELECT



                        ronda.id_ronda as id_ronda_supc,



                        ronda.id_programa as id_programa_supc,



                        ronda.no_ronda no_ronda_supc,



                        (



                            select



                                min(fecha_vencimiento)



                            from



                                contador_muestra



                                join muestra_programa on muestra_programa.id_muestra = contador_muestra.id_muestra and muestra_programa.id_programa = '" . $id_programa . "'



                            where contador_muestra.id_ronda = '" . $id_ronda . "'



                        ) as fecha_min_sample,



                        (



                            select



                                max(fecha_vencimiento)



                            from



                                contador_muestra



                                join muestra_programa on muestra_programa.id_muestra = contador_muestra.id_muestra and muestra_programa.id_programa = '" . $id_programa . "'



                            where contador_muestra.id_ronda = '" . $id_ronda . "'



                        ) as fecha_max_sample



                    FROM ronda



                    WHERE ronda.id_ronda = '" . $id_ronda . "'";







        $qryData = mysql_fetch_array(mysql_query($qry));



        return (object) array(



            "id_ronda" => $qryData["id_ronda_supc"],



            "id_programa" => $qryData["id_programa_supc"],



            "no_ronda" => $qryData["no_ronda_supc"],



            "fecha_min_sample" => $qryData["fecha_min_sample"],



            "fecha_max_sample" => $qryData["fecha_max_sample"],



        );
    }







    public static function getAnalitos($id_laboratorio, $id_programa)



    {



        $qry = "SELECT



                    configuracion_laboratorio_analito.id_configuracion as id_configuracion,



                    configuracion_laboratorio_analito.id_laboratorio as id_laboratorio,



                    analito.id_analito as id_analito,

                    analizador.id_analizador as id_analizador,



                    nombre_analito,



                    nombre_analizador,



                    nombre_metodologia,

                    metodologia.id_metodologia,


                    nombre_reactivo,



                    unidad.id_unidad as id_unidad,



                    nombre_unidad,



                    valor_gen_vitros,



                    nombre_material



                from



                    configuracion_laboratorio_analito



                    join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito



                    join analizador on analizador.id_analizador = configuracion_laboratorio_analito.id_analizador



                    join metodologia on metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia



                    join reactivo on reactivo.id_reactivo = configuracion_laboratorio_analito.id_reactivo



                    join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad



                    join gen_vitros on gen_vitros.id_gen_vitros = configuracion_laboratorio_analito.id_gen_vitros



                    join material on material.id_material = configuracion_laboratorio_analito.id_material



                where



                    configuracion_laboratorio_analito.id_laboratorio = '" . $id_laboratorio . "'



                    and configuracion_laboratorio_analito.id_programa = '" . $id_programa . "'



                    and configuracion_laboratorio_analito.activo = 1



                order by nombre_analito asc, nombre_unidad asc, nombre_metodologia asc";



        $qryArray = mysql_query($qry);



        mysqlException(mysql_error(), "_2501");







        $analitos = array();







        while ($qryData = mysql_fetch_array($qryArray)) {



            array_push(



                $analitos,



                (object) array(



                    "id_configuracion" => $qryData["id_configuracion"],



                    "id_analito" => $qryData["id_analito"],
                    "id_analizador" => $qryData["id_analizador"],


                    "nombre_analito" => $qryData["nombre_analito"],



                    "nombre_analizador" => $qryData["nombre_analizador"],



                    "id_laboratorio" => $qryData["id_laboratorio"],



                    "nombre_reactivo" => $qryData["nombre_reactivo"],



                    "nombre_metodologia" => $qryData["nombre_metodologia"],



                    "id_unidad" => $qryData["id_unidad"],
                    "id_metodologia" => $qryData["id_metodologia"],


                    "nombre_unidad" => $qryData["nombre_unidad"],



                    "valor_gen_vitros" => $qryData["valor_gen_vitros"],



                    "nombre_material" => $qryData["nombre_material"],



                )



            );
        }







        return (object) $analitos;
    }











    public static function getAnalito($id_analito)



    {



        $qry = "SELECT



                    configuracion_laboratorio_analito.id_configuracion as id_configuracion,



                    configuracion_laboratorio_analito.id_laboratorio as id_laboratorio,
                    configuracion_laboratorio_analito.id_metodologia as id_metodologia,



                    analito.id_analito as id_analito,
                    analizador.id_analizador as id_analizador,



                    nombre_analito,



                    nombre_analizador,



                    nombre_metodologia,



                    nombre_reactivo,



                    unidad.id_unidad as id_unidad,



                    nombre_unidad,



                    valor_gen_vitros,



                    nombre_material



                from



                    configuracion_laboratorio_analito



                    join analito on analito.id_analito = configuracion_laboratorio_analito.id_analito



                    join analizador on analizador.id_analizador = configuracion_laboratorio_analito.id_analizador



                    join metodologia on metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia



                    join reactivo on reactivo.id_reactivo = configuracion_laboratorio_analito.id_reactivo



                    join unidad on unidad.id_unidad = configuracion_laboratorio_analito.id_unidad



                    join gen_vitros on gen_vitros.id_gen_vitros = configuracion_laboratorio_analito.id_gen_vitros



                    join material on material.id_material = configuracion_laboratorio_analito.id_material



                where



                    configuracion_laboratorio_analito.id_configuracion = '" . $id_analito . "'";



        $qryArray = mysql_query($qry);



        $qryData = mysql_fetch_array($qryArray);







        return (object) array(



            "id_configuracion" => $qryData["id_configuracion"],



            "id_analito" => $qryData["id_analito"],
            "id_metodologia" => $qryData["id_metodologia"],
            "id_analizador" => $qryData["id_analizador"],



            "nombre_analito" => $qryData["nombre_analito"],



            "nombre_analizador" => $qryData["nombre_analizador"],



            "id_laboratorio" => $qryData["id_laboratorio"],



            "nombre_reactivo" => $qryData["nombre_reactivo"],



            "nombre_metodologia" => $qryData["nombre_metodologia"],



            "id_unidad" => $qryData["id_unidad"],



            "nombre_unidad" => $qryData["nombre_unidad"],



            "valor_gen_vitros" => $qryData["valor_gen_vitros"],



            "nombre_material" => $qryData["nombre_material"],



        );
    }







    public static function getMuestras($id_ronda, $id_programa)



    {







        $qry = "SELECT



                *



            from



                contador_muestra



                join muestra_programa on muestra_programa.id_muestra = contador_muestra.id_muestra and muestra_programa.id_programa = '" . $id_programa . "'



                join muestra on muestra.id_muestra = muestra_programa.id_muestra



                join lote on lote.id_lote = muestra_programa.id_lote



            where contador_muestra.id_ronda = '" . $id_ronda . "'



            order by contador_muestra.no_contador asc



            ";







        $qryArray = mysql_query($qry);



        mysqlException(mysql_error(), "_2502");







        $muestras = array();







        while ($qryData = mysql_fetch_array($qryArray)) {



            array_push(



                $muestras,



                (object) array(



                    "id_muestra" => $qryData["id_muestra"],
                    "id_lote" => $qryData["id_lote"],


                    "no_contador" => $qryData["no_contador"],



                    "codigo_muestra" => $qryData["codigo_muestra"],



                    "nombre_lote" => $qryData["nombre_lote"],



                    "nivel_lote" => $qryData["nivel_lote"],
                    "fecha_vencimiento_mp" => $qryData["fecha_vencimiento"],



                )



            );
        }







        return $muestras;
    }







    public static function getNiveles($id_ronda, $id_programa)



    {







        $qry = "SELECT



                nombre_lote,



                count(*) as num_muestras



            from



                contador_muestra



                join muestra_programa on muestra_programa.id_muestra = contador_muestra.id_muestra and muestra_programa.id_programa = '" . $id_programa . "'



                join muestra on muestra.id_muestra = muestra_programa.id_muestra



                join lote on lote.id_lote = muestra_programa.id_lote



            where contador_muestra.id_ronda = '" . $id_ronda . "'



            group by nombre_lote



            order by nombre_lote



            ";







        $qryArray = mysql_query($qry);



        mysqlException(mysql_error(), "_2502");







        $niveles = array();







        while ($qryData = mysql_fetch_array($qryArray)) {



            array_push(



                $niveles,



                (object) array(



                    "nombre_lote" => $qryData["nombre_lote"],



                    "num_muestras" => $qryData["num_muestras"],



                )



            );
        }







        return $niveles;
    }







    public static function getVRL($muestra, $analito)



    { // Obtener los valores reportados por el laboratorio







        $qry = "SELECT valor_resultado



                    from resultado



                    where id_muestra = '" . $muestra->id_muestra . "' and id_configuracion = '" . $analito->id_configuracion . "'



                    limit 1";







        $qryData = mysql_fetch_array(mysql_query($qry));







        if (isset($qryData["valor_resultado"])) {



            return $qryData["valor_resultado"];
        }







        return "N/A";
    }







    public static function getVAV_JCTLM($muestra, $analito)



    {



        self::$return_vav_empty = (object) array(



            "valor_metodo_referencia" => "N/A",



            "nombre_metodologia" => "N/A",



            "nombre_unidad" => "N/A",



        );







        if (self::getVRL($muestra, $analito) == "N/A") {



            return self::$return_vav_empty;
        }







        $qry = "SELECT



                        valor_metodo_referencia,



                        nombre_metodologia,



                        nombre_unidad



                    FROM



                        valor_metodo_referencia



                        INNER JOIN metodologia ON valor_metodo_referencia.id_metodologia = metodologia.id_metodologia



                        INNER JOIN unidad ON valor_metodo_referencia.id_unidad = unidad.id_unidad



                    WHERE id_analito = '" . $analito->id_analito . "' AND id_laboratorio = '" . $analito->id_laboratorio . "' AND id_muestra = '" . $muestra->id_muestra . "' AND valor_metodo_referencia.id_unidad = '" . $analito->id_unidad . "'



                    LIMIT 1";







        $qryData = mysql_fetch_array(mysql_query($qry));







        if (isset($qryData["valor_metodo_referencia"]) && $qryData["valor_metodo_referencia"] != 0) {



            return (object) array(



                "valor_metodo_referencia" => $qryData["valor_metodo_referencia"],



                "nombre_metodologia" => $qryData["nombre_metodologia"],



                "nombre_unidad" => $qryData["nombre_unidad"],



            );
        }







        return self::$return_vav_empty;
    }







    public static function getVAV_Principal($muestra, $analito)



    {



        self::$return_vav_empty = (object) array(



            "tipo_media_estandar" => "N/A",



            "color" => [50, 50, 50],



            "media_estandar" => "N/A",



            "desviacion_estandar" => "N/A",



            "coeficiente_variacion" => "N/A",



            "n_evaluacion" => "N/A"



        );







        if (self::getVRL($muestra, $analito) == "N/A") {



            return self::$return_vav_empty;
        }











        $qry = "SELECT



                    media_estandar,



                    desviacion_estandar,



                    coeficiente_variacion,



                    n_evaluacion,



                    tipo_digitacion_wwr,



                    tipo_consenso_wwr,



                    id_digitacion_wwr,



                    unidad_mc.id_unidad,



                    unidad_mc.nombre_unidad as nombre_unidad_mc



                FROM media_evaluacion_caso_especial



                    left join digitacion_cuantitativa on digitacion_cuantitativa.id_digitacion_cuantitativa = media_evaluacion_caso_especial.id_digitacion_wwr



                    left join unidad unidad_mc on unidad_mc.id_unidad = digitacion_cuantitativa.id_unidad_mc



                INNER JOIN configuracion_laboratorio_analito ON media_evaluacion_caso_especial.id_configuracion = configuracion_laboratorio_analito.id_configuracion



                WHERE configuracion_laboratorio_analito.id_configuracion = '" . $analito->id_configuracion . "' AND media_evaluacion_caso_especial.nivel = '" . $muestra->nivel_lote . "' AND media_evaluacion_caso_especial.id_muestra = '" . $muestra->id_muestra . "' AND media_evaluacion_caso_especial.id_laboratorio = '" . $analito->id_laboratorio . "' LIMIT 0,1";







        $qryData_2 = mysql_fetch_array(mysql_query($qry));



        mysqlException(mysql_error(), "2107");







        if (isset($qryData_2)) {



            switch ($qryData_2['tipo_digitacion_wwr']) {



                case 1: // Mensual



                    return (object) array(



                        "tipo_media_estandar" => "Mensual",



                        "color" => self::getColorVAV("Mensual", $qryData_2['media_estandar']),



                        "media_estandar" => $qryData_2['media_estandar'],



                        "desviacion_estandar" => $qryData_2['desviacion_estandar'],



                        "coeficiente_variacion" => $qryData_2['coeficiente_variacion'],



                        "n_evaluacion" => $qryData_2['n_evaluacion']



                    );



                    break;



                case 2: // Acumulada



                    return (object) array(



                        "tipo_media_estandar" => "Acumulada",



                        "color" => self::getColorVAV("Acumulada", $qryData_2['media_estandar']),



                        "media_estandar" => $qryData_2['media_estandar'],



                        "desviacion_estandar" => $qryData_2['desviacion_estandar'],



                        "coeficiente_variacion" => $qryData_2['coeficiente_variacion'],



                        "n_evaluacion" => $qryData_2['n_evaluacion']



                    );



                    break;



                case 3: // Inserto



                    return (object) array(



                        "tipo_media_estandar" => "Inserto",



                        "color" => self::getColorVAV("Inserto", $qryData_2['media_estandar']),



                        "media_estandar" => $qryData_2['media_estandar'],



                        "desviacion_estandar" => $qryData_2['desviacion_estandar'],



                        "coeficiente_variacion" => $qryData_2['coeficiente_variacion'],



                        "n_evaluacion" => 1



                    );



                    break;



                case 4: // Media de consenso



                    if (



                        ($qryData_2["media_estandar"] == 0 || $qryData_2["media_estandar"] == null) &&



                        ($qryData_2["desviacion_estandar"] == 0 || $qryData_2["media_estandar"] == null)



                    ) { // Si la media y la D.E. No estan definidas







                        $result_consenso = self::getVAV_Consenso($muestra, $analito);



                        return (object) array(



                            "tipo_media_estandar" => "Consenso",



                            "color" => self::getColorVAV("Consenso", $result_consenso->media),



                            "media_estandar" => $result_consenso->media,



                            "desviacion_estandar" => $result_consenso->de,



                            "coeficiente_variacion" => $result_consenso->cv,



                            "n_evaluacion" => $result_consenso->n



                        );
                    } else {







                        return (object) array(



                            "tipo_media_estandar" => "Consenso",



                            "color" => self::getColorVAV("Consenso", $qryData_2['media_estandar']),



                            "media_estandar" => $qryData_2['media_estandar'],



                            "desviacion_estandar" => $qryData_2['desviacion_estandar'],



                            "coeficiente_variacion" => $qryData_2['coeficiente_variacion'],



                            "n_evaluacion" => $qryData_2['n_evaluacion']



                        );
                    }







                    break;



                default:



                    return (object) array(



                        "tipo_media_estandar" => "Acumulada",



                        "color" => self::getColorVAV("Acumulada", $qryData_2['media_estandar']),



                        "media_estandar" => $qryData_2['media_estandar'],



                        "desviacion_estandar" => $qryData_2['desviacion_estandar'],



                        "coeficiente_variacion" => $qryData_2['coeficiente_variacion'],



                        "n_evaluacion" => $qryData_2['n_evaluacion']



                    );



                    break;
            }
        } else {



            return self::$return_vav_empty;
        }
    }











    public static function getVAV_Consenso($muestra, $analito)
    {
       
        self::$return_vav_empty = (object) array(
            "media" => "N/A",
            "de" => "N/A",
            "cv" => "N/A",
            "n" => "N/A"
        );

        
     
     
        if(self::getVRL($muestra, $analito) == "N/A"){



            return self::$return_vav_empty; 



        }

       
        $configAnalito = [
            "id_unidad" => $analito->id_unidad,
            "id_analito" => $analito->id_analito,
            "id_metodologia" => $analito->id_metodologia,
            "id_configuracion" => $analito->id_configuracion,
            "id_analizador" => $analito->id_analizador,
        ];
        $muestraArray = [
            "id_lote" => $muestra->id_lote,
            "id_muestra" => $muestra->id_muestra,
            "fecha_vencimiento_mp" => $muestra->fecha_vencimiento_mp,
            "nivel_lote" => $muestra->id_lote,
        ];
       

        self::$controllerMediaTodosParticipantes->calculoPorMuestra($configAnalito,$muestraArray);


        $resultadosTodos = self::$controllerMediaTodosParticipantes->getCalculoPorAnalitoIdMuestraId(
            $analito->id_analito,
            $muestra->id_muestra,
            $analito->id_metodologia,
            $analito->id_unidad,
            $analito->id_analizador
        );  

        return (Object) array(



            "media" => $resultadosTodos["media"],



            "de" => $resultadosTodos["de"],



            "cv" => $resultadosTodos["cv"],



            "n" => $resultadosTodos["n"],

        );











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



                lote.nombre_lote = '" . $muestra->nombre_lote . "'



                and analito.nombre_analito = '" . $analito->nombre_analito . "'



                and unidad.nombre_unidad = '" . $analito->nombre_unidad . "'



            ";

          




        $objGrubbs = new Grubbs();
        
        $objIntercuartil = new Intercuartil();






        $qryArrayFinalConsenso = array();



        $qryArrayParticipantes = mysql_query($qry_participantes);



        mysqlException(mysql_error(), "_01");







        while ($qryDataConsenso = mysql_fetch_array($qryArrayParticipantes)) {



            array_push(



                $qryArrayFinalConsenso,



                array("resultado" => $qryDataConsenso["resultado"])



            );



        }




        $objIntercuartil->test_intercuartil($qryArrayFinalConsenso, "resultado");
        
        $objGrubbs->exclusionAtipicos($qryArrayFinalConsenso, "resultado");

        $qryData_participantes = $objIntercuartil->getPromediosNormales("resultado");







        if ($qryData_participantes["n"] >= 0 && isset($qryData_participantes["media"])) {



            return (Object) array(



                "media" => $qryData_participantes["media"],



                "de" => $qryData_participantes["de"],



                "cv" => $qryData_participantes["cv"],



                "n" => $qryData_participantes["n"],



            );



        }



        return self::$return_vav_empty;


    }







    public static function getVAV_ConsensoMetodologia($muestra, $analito)
    {
       
        self::$return_vav_empty = (object) array(
            "media" => "N/A",
            "de" => "N/A",
            "cv" => "N/A",
            "n" => "N/A",
        );
        
        
        if (self::getVRL($muestra, $analito) == "N/A") {



            return self::$return_vav_empty;
        }

        $configAnalito = [
            "id_unidad" => $analito->id_unidad,
            "id_analito" => $analito->id_analito,
            "id_metodologia" => $analito->id_metodologia,
            "id_configuracion" => $analito->id_configuracion,
            "id_analizador" => $analito->id_analizador
        ];
        $muestraArray = [
            "id_lote" => $muestra->id_lote,
            "id_muestra" => $muestra->id_muestra,
            "fecha_vencimiento_mp" => $muestra->fecha_vencimiento_mp,
            "nivel_lote" => $muestra->nivel_lote
        ];

        self::$controllerMediaMismaMetodologia->calculoPorMuestra($configAnalito,$muestraArray);
        $resultadosMisma = self::$controllerMediaMismaMetodologia->getCalculoPorAnalitoIdMuestraId(
            $analito->id_analito,
            $muestra->id_muestra,
            $analito->id_metodologia,
            $analito->id_unidad,
            $analito->id_analizador
        );

        return (Object) array(



            "media" => $resultadosMisma["media"],



            "de" => $resultadosMisma["de"],



            "cv" => $resultadosMisma["cv"],



            "n" => $resultadosMisma["n"],

        );






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



                join metodologia on metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia



            where



                resultado.valor_resultado is not null 



                and resultado.valor_resultado != ''



                and lote.nombre_lote = '" . $muestra->nombre_lote . "'



                and analito.nombre_analito = '" . $analito->nombre_analito . "'



                and unidad.nombre_unidad = '" . $analito->nombre_unidad . "'



                and metodologia.nombre_metodologia = '" . $analito->nombre_metodologia . "'";







        $objGrubbs = new Grubbs();







        $qryArrayFinalConsenso = array();



        $qryArrayParticipantes = mysql_query($qry_participantes);



        mysqlException(mysql_error(), "_01");







        while ($qryDataConsenso = mysql_fetch_array($qryArrayParticipantes)) {



            array_push(



                $qryArrayFinalConsenso,



                array("resultado" => $qryDataConsenso["resultado"])



            );
        }







        $objGrubbs->exclusionAtipicos($qryArrayFinalConsenso, "resultado");



        $qryData_participantes = $objGrubbs->getPromediosNormales("resultado");







        if ($qryData_participantes["n"] >= 00 && isset($qryData_participantes["media"])) {



            return (object) array(



                "media" => $qryData_participantes["media"],



                "de" => $qryData_participantes["de"],



                "cv" => $qryData_participantes["cv"],



                "n" => $qryData_participantes["n"],



            );
        }







        return self::$return_vav_empty;
        
    }










    public static function getColorVAV($tipo_consenso, $media_estandar)
    {







        if ($media_estandar != "N/A") {



            switch ($tipo_consenso) {



                case "Mensual":



                    return self::$verde; // Verde



                case "Acumulada":



                    return self::$azul; // Azul



                case "Inserto":



                    return self::$rosa; // Rosado



                case "Consenso":



                    return self::$gris_oscuro; // Gris



            }
        }







        return self::$gris_claro;
    }







    public static function getInfoCorrelacion($id_analito_lab, $id_laboratorio, $id_programa, $id_ronda)
    {




        $obj_final = array();



        $muestras = self::getMuestras($id_ronda, $id_programa);



        $analito = self::getAnalito($id_analito_lab);







        foreach ($muestras as $muestra) {

           
            array_push(



                $obj_final,



                (object) array(



                    "id_muestra" => $muestra->id_muestra,



                    "no_contador" => $muestra->no_contador,



                    "codigo_muestra" => $muestra->codigo_muestra,



                    "nombre_lote" => $muestra->nombre_lote,



                    "nivel_lote" => $muestra->nivel_lote,



                    "vrl" => self::getVRL($muestra, $analito),



                    "vav_jctlm" => self::getVAV_JCTLM($muestra, $analito),



                    "vav_principal" => self::getVAV_Principal($muestra, $analito),



                    "vav_consenso" => self::getVAV_Consenso($muestra, $analito),



                    "vav_consenso_metodologia" => self::getVAV_ConsensoMetodologia($muestra, $analito)



                )



            );
        }



        return (object) array(



            "analito" => $analito,



            "muestras" => $obj_final



        );
    }


    public static function setConfiInicial($idLaboratorio, $idPrograma, $idRonda, $fechasCorte = null)
    {
        $resultadosRepo = new ResultadosRepository();
        $mediaEspecialRepo = new MediaEvaluacionEspecialRepository();
        $fabricaTodosLosParticipantes = new TodosParticipantesFabrica($resultadosRepo);
        $fabricaMismaMetodologia = new ParticipantesMismaMetodologiaFabrica($resultadosRepo);

        $filtroIntercuartilicoFabrica = new FiltroIntercuartilicoFabrica();
		$filtroGrubbsFabrica = new FiltroGrubbsFabrica();


        if($fechasCorte !== null && strlen($fechasCorte) >= 4) {		
            $fechasMuestras = base64_decode($fechasCorte);
            $fechasMuestras = json_decode($fechasMuestras,true);	
            
            $fabricaTodosLosParticipantes->setFechaCorte($fechasMuestras);
            $fabricaMismaMetodologia->setFechaCorte($fechasMuestras);
        }

        $controllerMediaComparacion = new MediaDeComparacionController();
        $controllerMediaComparacion->setLabolatorio($idLaboratorio);
        $controllerMediaComparacion->setPrograma($idPrograma);
        $controllerMediaComparacion->setResultadosRepo($resultadosRepo);
        $controllerMediaComparacion->setObtenedorResultadosFabrica($fabricaTodosLosParticipantes);
        $controllerMediaComparacion->setMediaEvaluacionRepo($mediaEspecialRepo);

        $calculadorMediaConFilrosAtipicosTodosParticipantes = new CalculadorMediaConFiltrosAtipicosEstrategia();
		$calculadorMediaConFilrosAtipicosTodosParticipantes->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaConFilrosAtipicosTodosParticipantes->setIdPrograma($idPrograma);
		$calculadorMediaConFilrosAtipicosTodosParticipantes->setObtenedorResultadosFabrica($fabricaTodosLosParticipantes);
		
	
		$calculadorMediaCasoEspecialTodos = new CalculadorMediaCasoEspecialEstrategiaDecorador($calculadorMediaConFilrosAtipicosTodosParticipantes);
		$calculadorMediaCasoEspecialTodos->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaCasoEspecialTodos->setIdLaboratorio($idLaboratorio);
		$calculadorMediaCasoEspecialTodos->setIdPrograma($idPrograma);
		$calculadorMediaCasoEspecialTodos->setObtenedorResultadosFabrica($fabricaTodosLosParticipantes);
		$calculadorMediaCasoEspecialTodos->setMediaEvaluacionRepo($mediaEspecialRepo);
		$controllerMediaComparacion->setCalculadorEstrategia($calculadorMediaCasoEspecialTodos);
        

        $controllerMismaMetodologiaMediaComparacion = new MediaDeComparacionController();
        $controllerMismaMetodologiaMediaComparacion->setLabolatorio($idLaboratorio);
        $controllerMismaMetodologiaMediaComparacion->setPrograma($idPrograma);
        $controllerMismaMetodologiaMediaComparacion->setResultadosRepo($resultadosRepo);
        $controllerMismaMetodologiaMediaComparacion->setObtenedorResultadosFabrica($fabricaMismaMetodologia);
        $controllerMismaMetodologiaMediaComparacion->setMediaEvaluacionRepo($mediaEspecialRepo);
        
        $calculadorMediaConFilrosAtipicosMisma = new CalculadorMediaConFiltrosAtipicosEstrategia();
		$calculadorMediaConFilrosAtipicosMisma->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaConFilrosAtipicosMisma->setIdPrograma($idPrograma);
		$calculadorMediaConFilrosAtipicosMisma->setObtenedorResultadosFabrica($fabricaMismaMetodologia);

        $calculadorMediaCasoEspecialMisma = new CalculadorMediaCasoEspecialEstrategiaDecorador($calculadorMediaConFilrosAtipicosMisma);
		$calculadorMediaCasoEspecialMisma->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
		$calculadorMediaCasoEspecialMisma->setIdLaboratorio($idLaboratorio);
		$calculadorMediaCasoEspecialMisma->setIdPrograma($idPrograma);
		$calculadorMediaCasoEspecialMisma->setObtenedorResultadosFabrica($fabricaTodosLosParticipantes);
		$calculadorMediaCasoEspecialMisma->setMediaEvaluacionRepo($mediaEspecialRepo);
		$controllerMismaMetodologiaMediaComparacion->setCalculadorEstrategia($calculadorMediaCasoEspecialMisma);

        self::$controllerMediaMismaMetodologia = $controllerMismaMetodologiaMediaComparacion;
        self::$controllerMediaTodosParticipantes = $controllerMediaComparacion;
    }
}











if (isset($_POST["accion"])) { //cuando es invocado directamente



    include_once("../sql_connection.php");



    include_once("../complementos/grubbs.php");

    include_once("../complementos/intercuartil.php");



    informeFinRondaController::setConfiInicial(
        $_POST["id_laboratorio"],
        $_POST["id_programa"],
        $_POST["id_ronda"],
        $_POST["fechas_corte"]
    );
    

    echo json_encode(informeFinRondaController::getInfoCorrelacion($_POST["id_analito_lab"], $_POST["id_laboratorio"], $_POST["id_programa"], $_POST["id_ronda"]));
}
