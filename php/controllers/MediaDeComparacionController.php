<?php
require_once __DIR__ . "/../repositorys/ConfiguracionLaboratorioRepository.php";
require_once __DIR__ . "/../repositorys/ResultadosRepository.php";
require_once __DIR__ . "/../repositorys/MuestrasRepository.php";
require_once __DIR__ . "/../complementos/IntercuartilV2.php";
require_once __DIR__ . "/../complementos/GrubbsV2.php";
require_once __DIR__ . "/../LogicaNegocio/MediaDeComparacion/Domain/ResultadosParticipantesFabrica.php";
class MediaDeComparacionController
{



    private $idPrograma;
    private $idLaboratorio;

    /**
     * Contiene el listado de configuracion de analitos del programa de un laboratorio
     *
     * @var array
     */
    private $configuracionAnalitos;
    private $resultadosLaboratorioPorAnalito;

    /**
     * Fabrica de estrategias para obtener resultados
     *
     * @var ResultadosParticipantesFabrica
     */
    private $obtenedorResultadosFabrica;

    private $resultadosTodosLosParticipantesPorAnalito;

    private $indicadores = [];

    private $calculoAnalitos = [];



    /**
     * Repositorio de resultados
     *
     * @var [type]
     */
    private $resultadosRepository;

    private $mediaEvaluacionRepo;

    private $cacluladorMediaEstrategia;

    public function setPrograma($idPrograma)
    {
        $this->idPrograma = $idPrograma;
        ;
    }

    public function setLabolatorio($idLaboratorio)
    {
        $this->idLaboratorio = $idLaboratorio;
    }


    public function setResultadosRepo($repo)
    {
        $this->resultadosRepository = $repo;
    }

    public function setMediaEvaluacionRepo($repo)
    {
        $this->mediaEvaluacionRepo = $repo;
    }

    public function setCalculadorEstrategia($estrategia)
    {
        return $this->cacluladorMediaEstrategia = $estrategia;
    }

    /**
     * Se encarga de establecer la clase obtenedora de los resultados de los laboratorios
     *
     * @param  $obtenedor
     * @return void
     */
    public function setObtenedorResultadosFabrica($obtenedorFabrica)
    {
        $this->obtenedorResultadosFabrica = $obtenedorFabrica;
    }

    public function establecerResultadosAnalitosMuestras($idRonda)
    {
        $analitosRepository = new ConfiguracionLaboratorioRepository();
        $this->configuracionAnalitos = $analitosRepository->idsAnalitosDelLaboratorioPorPrograma($this->idLaboratorio, $this->idPrograma);


        $matrizResultadosIds = [];

        $matrizCalculosResultadosIdsParticipantes = [];

        $muestrasRepository = new MuestrasRepository();
        $muestras = $muestrasRepository->muestrasDeRonda($this->idPrograma, $idRonda);


        /*
        Se va a recorrer cada uno de los analitos que tiene le programa del laboratorio y luego
        se recorrera todas las muestras que debe tener en la ronda que se esta analizando
        */
        $x = 0;
        foreach ($this->configuracionAnalitos as $indexConfig => $configAnalito) {

            $y = 0;
            //  echo "<h2>Analito ID ".$configAnalito["id_analito"]."</h2><br>";
            foreach ($muestras as $index => $muestra) {

                $resultado = $this->calculoPorMuestra($configAnalito, $muestra);


                $idAnalito = $configAnalito['id_analito'];
                $idMetodologia = $configAnalito["id_metodologia"];
                $idUnidad = $configAnalito["id_unidad"];
                $idMuestra = $muestra['id_muestra'];
                $idAnalizador = $configAnalito['id_analizador'];

                $matrizResultadosIds[$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra] = $resultado["resultado_lab"];

                $matrizCalculosResultadosIdsParticipantes[$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra] = $resultado["calculo"];

                $y++;
                //}

                //   echo "<br>Muestra # ".$index . " ID ".$muestra["id_muestra"] . " VALOR LAB: " .$valorResultado . "<br>";
            }

            $x++;
        }
        //  exit;
        $this->resultadosLaboratorioPorAnalito = [
            "ids" => $matrizResultadosIds
        ];
        $this->resultadosTodosLosParticipantesPorAnalito = [
            "ids" => $matrizCalculosResultadosIdsParticipantes
        ];

        // exit;
    }

    public function calculoPorMuestra($configAnalito, $muestra)
    {
        $matriz = [
            "resultado_lab" => null,
            "calculo" => null
        ];
        // if ($muestra["no_contador"] == 2 && $indexConfig == 2) {
        $resultado = $this->resultadosRepository
            ->resultadosPorConfigMuestra(
                $configAnalito['id_configuracion'],
                $muestra['id_muestra']
            );
        $valorResultado = 0;
        if (count($resultado) > 0) {
            $valorResultado = $resultado[0]['valor_resultado'];
        }
        $idAnalito = $configAnalito['id_analito'];
        $idMetodologia = $configAnalito["id_metodologia"];
        $idAnalizador = $configAnalito['id_analizador'];
        $idUnidad = $configAnalito["id_unidad"];
        $idMuestra = $muestra['id_muestra'];
        if ($valorResultado != 0) { //el laboratorio no reporto
            //$matrizResultadosIds[$configAnalito['id_analito']][$muestra['id_muestra']] = $valorResultado;
            //$matrizResultadosCoordenadas[$x][$y] = $valorResultado;
            $matriz["resultado_lab"] = $valorResultado;

            $matriz["calculo"] = $this->cacluladorMediaEstrategia->calcular(
                $configAnalito,
                $muestra
            );


            /*$mediaEvaluacionEspecial = $this->mediaEvaluacionRepo->getMedia(
                $configAnalito["id_configuracion"],
                $muestra["nivel_lote"],
                $idMuestra,
                $this->idLaboratorio
            );

            if (count($mediaEvaluacionEspecial) > 0 && $mediaEvaluacionEspecial[0]["tipo_digitacion_wwr"] == 4) {
                //var_dump($mediaEvaluacionEspecial);
                //exit;
                //concenso
                if (
                    isset($mediaEvaluacionEspecial[0]["media_estandar"])
                    && is_numeric($mediaEvaluacionEspecial[0]["media_estandar"])
                ) {
                    //es por concenso y ademas la muestra y el analito tienen definido la media se da prioridad
                    $matriz["calculo"] = [
                        "media" => $mediaEvaluacionEspecial[0]["media_estandar"],
                        "de" => $mediaEvaluacionEspecial[0]["desviacion_estandar"],
                        "cv" => $mediaEvaluacionEspecial[0]["coeficiente_variacion"],
                        "n" => $mediaEvaluacionEspecial[0]["n_evaluacion"]
                    ];
                } else {
                    //como no tienen definido la media se realiza la busqueda de los resultados de laboratorios
                    //pero en filtro intercuartilico se aplica grubbs

                    $estrategiaObtenedoraResultados = $this->obtenedorResultadosFabrica->crearEstrategia(
                        $this->idPrograma,
                        $configAnalito,
                        $muestra
                    );
                    $resultadosParticipantes = $estrategiaObtenedoraResultados->getResultados();


                    if (count($resultadosParticipantes) > 0) {
                        $valoresParticipantes = array_column($resultadosParticipantes, "valor_resultado");

                        $grubbs = new GrubbsV2();
                        $grubbs->exclusionAtipicos($valoresParticipantes);
                        $resultadoParticipantes = $grubbs->getPromediosNormales();


                        //$matrizValoresLaboratorios[$configAnalito["id_analito"]][$muestra["id_muestra"]] = $filtroIntercuartilico->getResultadosEscogidos();

                        // $matrizCalculosCoordenadasParticipantes[$x][$y] = $resultadoParticipantes;
                        $matriz["calculo"] = $resultadoParticipantes;
                        //$matrizCalculosResultadosIdsParticipantes[$configAnalito['id_analito']][$muestra["id_muestra"]] = $resultadoParticipantes;
                    }
                }
            } else {
                $estrategiaObtenedoraResultados = $this->obtenedorResultadosFabrica->crearEstrategia(
                    $this->idPrograma,
                    $configAnalito,
                    $muestra
                );
                $resultadosParticipantes = $estrategiaObtenedoraResultados->getResultados();


                if (count($resultadosParticipantes) > 0) {
                    $valoresParticipantes = array_column($resultadosParticipantes, "valor_resultado");

                    $filtroIntercuartilico = new IntercuartilV2();
                    $filtroIntercuartilico->test_intercuartil($valoresParticipantes, false);
                    $resultadoParticipantes = $filtroIntercuartilico->getPromediosNormales();


                    //$matrizValoresLaboratorios[$configAnalito["id_analito"]][$muestra["id_muestra"]] = $filtroIntercuartilico->getResultadosEscogidos();

                    // $matrizCalculosCoordenadasParticipantes[$x][$y] = $resultadoParticipantes;
                    $matriz["calculo"] = $resultadoParticipantes;
                    //$matrizCalculosResultadosIdsParticipantes[$configAnalito['id_analito']][$muestra["id_muestra"]] = $resultadoParticipantes;
                }
            }
            */
        }

        $this->setCalculoAnalitoMuestra(
            $matriz["calculo"],
            $matriz["resultado_lab"],
            $idAnalito,
            $idMuestra,
            $idMetodologia,
            $idUnidad,
            $idAnalizador
        );

        return $matriz;
    }

    public function calcularIndicadoresSatisfacionHastaMuestra($idMuestra)
    {
        $indicadores = [
            "resultados" => [
                "satisfactorio" => 0,
                "alarma" => 0,
                "no_satisfactorio" => 0,
            ],
            "porcentaje" => [],
            "total" => 0,
            "ids" => [],
            "evaluacion" => []
        ];


        foreach ($this->calculoAnalitos as $iAnalito => $metodologias) {
            foreach ($metodologias as $idMetodologia => $analizadores) {
                foreach ($analizadores as $idAnalizador => $unidades) {
                    foreach ($unidades as $idUnidad => $muestras) {
                        foreach ($muestras as $iMuestra => $calculoFin) {
                            $resultado = -1;
                            if ($calculoFin["n"] >= 1) {
                                if ($calculoFin["zscore"] >= -2 && $calculoFin["zscore"] < 2) {
                                    $resultado = 1;
                                    $indicadores["resultados"]["satisfactorio"]++;
                                } else if (($calculoFin["zscore"] >= 2 && $calculoFin["zscore"] < 3) || ($calculoFin["zscore"] >= -3 && $calculoFin["zscore"] < -2)) {
                                    $resultado = 0;
                                    $indicadores["resultados"]["alarma"]++;
                                } else {
                                    $resultado = -1;
                                    $indicadores["resultados"]["no_satisfactorio"]++;
                                }
                                $indicadores["ids"][$iAnalito][$idMetodologia][$idAnalizador][$idUnidad][$iMuestra] = $resultado;

                                $indicadores["evaluacion"][$iAnalito][$idMetodologia][$idAnalizador][$idUnidad][$iMuestra] = $calculoFin["zscore"];

                                $indicadores["total"]++;

                            } else {
                                // break; //como la muestra no es valida no se tendra en cuenta para los indicadores
                            }

                            if ($idMuestra == $iMuestra) {
                                break;
                            }

                        }
                    }
                }

            }
        }

        foreach ($indicadores["resultados"] as $key => $valorInicador) {
            $indicadores["porcentaje"][$key] = round(($valorInicador * 100) / $indicadores["total"], 2);
        }

        $this->indicadores = $indicadores;
        return $indicadores;
    }
    /**
     * Calcula los indicadores de satisfacción, alarma y no satisfactorio
     * a partir de un array de resultados de cálculo sin niveles anidados,
     * devolviendo una estructura de datos completa.
     *
     * @param array $resultadosDeCalculo Un array de resultados, donde cada elemento
     * contiene las claves 'zscore' y 'n'.
     * @return array Una estructura de datos completa con resultados, porcentajes y evaluación.
     */
    public function calcularPorcentajesDesdeArraySimple($resultadosDeCalculo)
    {
        $indicadores = [
            "resultados" => [
                "satisfactorio" => 0,
                "alarma" => 0,
                "no_satisfactorio" => 0,
            ],
            "porcentaje" => [],
            "total" => 0,
            "ids" => [], // No se puede popular con este array de entrada, se devuelve vacío
            "evaluacion" => [] // Se llenará con los zscores del array de entrada
        ];

        $i = 0; // Se usará un contador como ID para la evaluación, ya que no hay IDs en el array
        foreach ($resultadosDeCalculo as $calculo) {
            if (isset($calculo["n"]) && $calculo["n"] >= 1 && isset($calculo["zscore"])) {
                $resultado = -1;

                if ($calculo["zscore"] >= -2 && $calculo["zscore"] < 2) {
                    $resultado = 1;
                    $indicadores["resultados"]["satisfactorio"]++;
                } else if (($calculo["zscore"] >= 2 && $calculo["zscore"] < 3) || ($calculo["zscore"] >= -3 && $calculo["zscore"] < -2)) {
                    $resultado = 0;
                    $indicadores["resultados"]["alarma"]++;
                } else {
                    $resultado = -1;
                    $indicadores["resultados"]["no_satisfactorio"]++;
                }

                $indicadores["total"]++;
                $indicadores["evaluacion"][$i] = $calculo["zscore"];
                $i++;
            }
        }

        // Calcular los porcentajes finales
        foreach ($indicadores["resultados"] as $key => $valorInicador) {
            if ($indicadores["total"] > 0) {
                $indicadores["porcentaje"][$key] = round(($valorInicador * 100) / $indicadores["total"], 2);
            } else {
                $indicadores["porcentaje"][$key] = 0;
            }
        }

        return $indicadores;
    }

    public function getIndicadorAnalitoMuestraUnidad($idAnalito, $idMuestra, $idMetodologia, $idUnidad, $idAnalizador)
    {

        if (
            isset($this->indicadores["ids"][$idAnalito])
            && isset($this->indicadores["ids"][$idAnalito][$idMetodologia])
            && isset($this->indicadores["ids"][$idAnalito][$idMetodologia][$idAnalizador])
            && isset($this->indicadores["ids"][$idAnalito][$idMetodologia][$idAnalizador][$idUnidad])
            && isset($this->indicadores["ids"][$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra])
        ) {
            return $this->indicadores["ids"][$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra];
        }
        return -1; //para que se no satisfactorio

    }

    public function getIndicadoresGlobal()
    {
        return $this->indicadores;
    }


    public function getCalculoPorAnalitoIdMuestraId($idAnalito, $idMuestra, $idMetodologia, $idUnidad, $idAnalizador)
    {

        if (!(isset($this->calculoAnalitos[$idAnalito]) && isset($this->calculoAnalitos[$idAnalito][$idMetodologia]) && isset($this->calculoAnalitos[$idAnalito][$idMetodologia][$idAnalizador]) && isset($this->calculoAnalitos[$idAnalito][$idMetodologia][$idAnalizador][$idUnidad]) && isset($this->calculoAnalitos[$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra]))) {

            $resultadosParticipantes = $this->resultadosTodosLosParticipantesPorAnalito["ids"][$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra];

            $resultadoLaboratorio = $this->resultadosLaboratorioPorAnalito["ids"][$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra];
            $this->setCalculoAnalitoMuestra(
                $resultadosParticipantes,
                $resultadoLaboratorio,
                $idAnalito,
                $idMuestra,
                $idMetodologia,
                $idUnidad,
                $idAnalizador
            );
        }
        return $this->calculoAnalitos[$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra];
    }

    public function getCalculosAnalitos()
    {
        return $this->calculoAnalitos;
    }


    private function calcularAnalitoMuestra($resultadosParticipantes, $resultadoLaboratorio)
    {
        $n = $resultadosParticipantes["n"];
        // Nueva fórmula de Z-Score basada en mediana e IQR y la de la incertidumbre
        $mediana = $resultadosParticipantes["mediana"];
        $iqr = $resultadosParticipantes["q3"] - $resultadosParticipantes["q1"];

        // Evitar división por cero

        if ($iqr == 0) {
            $zscore_cal = 0;
            $incertidumbre_robusta = "N/A";
            $s = 0;
        } else {
            // Fórmula desviación estándar robusta usando IQR
            $s = $iqr * 0.7413; // El factor 0.7413 escala el IQR para que sea comparable a la DE en distribuciones normales
            // Fórmula robusta de Z-Score usando mediana e IQR
            $zscore_cal = ($resultadoLaboratorio - $mediana) / ($s);
            // Fórmula de incertidumbre basada en IQR
            $incertidumbre_robusta = 1.25 * ($s / sqrt($n)); // 1.25 es un factor de ajuste para la incertidumbre
        }

        $diferencia = 0;

        if ($resultadosParticipantes["de"] != 0) {
            $diferencia = (($resultadoLaboratorio - $resultadosParticipantes["media"]) / $resultadosParticipantes["media"]) * 100;
        }
        $diferencia_robusta = 0;

        if ($mediana != 0) {
            $diferencia_robusta = (($resultadoLaboratorio - $mediana) / $mediana) * 100;
        }
        $incerctidumbreSup = "N/A";
        $incerctidumbreInf = "N/A";

        if ($resultadosParticipantes["de"] != 0 && $resultadosParticipantes["media"] != "" && $resultadosParticipantes["media"] != 0) {

            $incerctidumbreSup = ($resultadosParticipantes["media"] + ($resultadosParticipantes["de"] * 2));

            $incerctidumbreInf = ($resultadosParticipantes["media"] - ($resultadosParticipantes["de"] * 2));
        }



        if ($resultadosParticipantes["media"] == 0) {
            $cv = 0;
        } else {
            $cv = $resultadosParticipantes["cv"];
        }


        $caclulo = [
            "mediana" => round($mediana, 4),
            "q1" => round($resultadosParticipantes["q1"], 4),
            "q3" => round($resultadosParticipantes["q3"], 4),
            "iqr" => round($iqr, 4),
            "media" => round($resultadosParticipantes["media"], 4),
            "de" => round($resultadosParticipantes["de"], 4),
            "n" => round($n, 4),
            "zscore" => round($zscore_cal, 4),
            "diff" => round($diferencia, 4),
            "valor_lab" => $resultadoLaboratorio,
            "incertidumbre_sup" => round($incerctidumbreSup, 2) . "",
            "incertidumbre_inf" => round($incerctidumbreInf, 2) . "",
            "incertidumbre" => round($incertidumbre_robusta, 4),
            "cv" => round($cv, 4),
            "s" => round($s, 4),
            "diferencia_robusta" => round($diferencia_robusta, 4)
        ];

        return $caclulo;
    }
    private function setCalculoAnalitoMuestra($resultadosParticipantes, $resultadoLaboratorio, $idAnalito, $idMuestra, $idMetodologia, $idUnidad, $idAnalizador)
    {

        $caclulo = $this->calcularAnalitoMuestra($resultadosParticipantes, $resultadoLaboratorio);

        $this->calculoAnalitos[$idAnalito][$idMetodologia][$idAnalizador][$idUnidad][$idMuestra] = $caclulo;
    }
}
