<?php

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
*/

include "informe/fpdf/EstructuraPDFFinRonda.php";
require_once __DIR__ . "/controllers/MediaDeComparacionController.php";
require_once __DIR__ . "/repositorys/ResultadosRepository.php";
require_once __DIR__ . "/repositorys/MediaEvaluacionEspecialRepository.php";
require_once __DIR__ . "/LogicaNegocio/MediaDeComparacion/App/TodosParticipantesFabrica.php";
require_once __DIR__ . "/LogicaNegocio/MediaDeComparacion/App/ParticipantesMismaMetodologiaFabrica.php";
require_once __DIR__ . "/LogicaNegocio/MediaDeComparacion/App/CaluladoresMedia/CalculadorMediaCasoEspecialEstrategiaDecorador.php";
require_once __DIR__ . "/LogicaNegocio/MediaDeComparacion/App/CaluladoresMedia/CalculadorMediaConFiltrosAtipicosEstrategia.php";
require_once __DIR__ . "/LogicaNegocio/MediaDeComparacion/App/FiltrosAtipicos/FiltroGrubbsFabrica.php";
require_once __DIR__ . "/LogicaNegocio/MediaDeComparacion/App/FiltrosAtipicos/FiltroIntercuartilicoFabrica.php";

class BackFinRonda
{

    private $carpetaTemp;
    public $urlBases64;
    public $bases64;
    private $id_laboratorio;
    private $id_programa;
    private $id_ronda;
    private $idReporte;

    private $fechas_corte;

    public function __construct()
    {
        $this->carpetaTemp = 'temp_chart/'; // Local
        $this->idReporte = uniqid();
        $this->urlBases64 = array();
    }


    public function setAttribute($atributo, $valor)
    {
        $this->$atributo = $valor;
    }

    public function setNomsImages()
    {
        foreach ($this->bases64 as $base64) {
            $this->urlBases64[$base64["id"]] = $this->getUrlImg();
        }
    }

    public function getUrlImg()
    {
        return $this->carpetaTemp . uniqid() . ".png";
    }

    public function saveImages()
    {
        foreach ($this->bases64 as $base64) {
            file_put_contents(
                $this->urlBases64[$base64["id"]],
                $this->procesarImg($base64["val"])
            );
        }
    }

    public function procesarImg($base64)
    {
        $base_to_php = explode(',', $base64);
        $data = base64_decode($base_to_php[1]);
        return $data;
    }


    public function generarEstructuraPDF()
    {
        $pdf = new EstructuraPDFFinRonda('P', 'mm', 'letter');


        $resultadosRepo = new ResultadosRepository();
        $mediaEspecialRepo = new MediaEvaluacionEspecialRepository();
        $fabricaTodosLosParticipantes = new TodosParticipantesFabrica($resultadosRepo);
        $fabricaMismaMetodologia = new ParticipantesMismaMetodologiaFabrica($resultadosRepo);
        $filtroIntercuartilicoFabrica = new FiltroIntercuartilicoFabrica();
        $filtroGrubbsFabrica = new FiltroGrubbsFabrica();


        if ($this->fechas_corte !== null && strlen($this->fechas_corte) >= 4) {
            $fechasMuestras = base64_decode($this->fechas_corte);
            $fechasMuestras = json_decode($fechasMuestras, true);
            $fabricaTodosLosParticipantes->setFechaCorte($fechasMuestras);
            $fabricaMismaMetodologia->setFechaCorte($fechasMuestras);
        }

        $controllerMediaComparacion = new MediaDeComparacionController();
        $controllerMediaComparacion->setLabolatorio($this->id_laboratorio);
        $controllerMediaComparacion->setPrograma($this->id_programa);
        $controllerMediaComparacion->setResultadosRepo($resultadosRepo);
        $controllerMediaComparacion->setMediaEvaluacionRepo($mediaEspecialRepo);
        $controllerMediaComparacion->setObtenedorResultadosFabrica($fabricaTodosLosParticipantes);

        $calculadorMediaConFilrosAtipicosTodosParticipantes = new CalculadorMediaConFiltrosAtipicosEstrategia();
        $calculadorMediaConFilrosAtipicosTodosParticipantes->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
        $calculadorMediaConFilrosAtipicosTodosParticipantes->setIdPrograma($this->id_programa);
        $calculadorMediaConFilrosAtipicosTodosParticipantes->setObtenedorResultadosFabrica($fabricaTodosLosParticipantes);


        $calculadorMediaCasoEspecialTodos = new CalculadorMediaCasoEspecialEstrategiaDecorador($calculadorMediaConFilrosAtipicosTodosParticipantes);
        $calculadorMediaCasoEspecialTodos->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
        $calculadorMediaCasoEspecialTodos->setIdLaboratorio($this->id_laboratorio);
        $calculadorMediaCasoEspecialTodos->setIdPrograma($this->id_programa);
        $calculadorMediaCasoEspecialTodos->setObtenedorResultadosFabrica($fabricaTodosLosParticipantes);
        $calculadorMediaCasoEspecialTodos->setMediaEvaluacionRepo($mediaEspecialRepo);
        $controllerMediaComparacion->setCalculadorEstrategia($calculadorMediaCasoEspecialTodos);




        $controllerMismaMetodologiaMediaComparacion = new MediaDeComparacionController();
        $controllerMismaMetodologiaMediaComparacion->setLabolatorio($this->id_laboratorio);
        $controllerMismaMetodologiaMediaComparacion->setPrograma($this->id_programa);
        $controllerMismaMetodologiaMediaComparacion->setResultadosRepo($resultadosRepo);
        $controllerMismaMetodologiaMediaComparacion->setObtenedorResultadosFabrica($fabricaMismaMetodologia);
        $controllerMismaMetodologiaMediaComparacion->setMediaEvaluacionRepo($mediaEspecialRepo);

        $calculadorMediaConFilrosAtipicosMisma = new CalculadorMediaConFiltrosAtipicosEstrategia();
        $calculadorMediaConFilrosAtipicosMisma->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
        $calculadorMediaConFilrosAtipicosMisma->setIdPrograma($this->id_programa);
        $calculadorMediaConFilrosAtipicosMisma->setObtenedorResultadosFabrica($fabricaMismaMetodologia);

        $calculadorMediaCasoEspecialMisma = new CalculadorMediaCasoEspecialEstrategiaDecorador($calculadorMediaConFilrosAtipicosMisma);
        $calculadorMediaCasoEspecialMisma->setFiltroAtipipicosFabrica($filtroIntercuartilicoFabrica);
        $calculadorMediaCasoEspecialMisma->setIdLaboratorio($this->id_laboratorio);
        $calculadorMediaCasoEspecialMisma->setIdPrograma($this->id_programa);
        $calculadorMediaCasoEspecialMisma->setObtenedorResultadosFabrica($fabricaMismaMetodologia);
        $calculadorMediaCasoEspecialMisma->setMediaEvaluacionRepo($mediaEspecialRepo);
        $controllerMismaMetodologiaMediaComparacion->setCalculadorEstrategia($calculadorMediaCasoEspecialMisma);


        $controllerMediaComparacion->establecerResultadosAnalitosMuestras($this->id_ronda);
        $controllerMismaMetodologiaMediaComparacion->establecerResultadosAnalitosMuestras($this->id_ronda);


        $pdf->CreateDocument(
            $this->id_laboratorio,
            $this->id_programa,
            $this->id_ronda,
            $this->urlBases64,
            $controllerMediaComparacion,
            $controllerMismaMetodologiaMediaComparacion
        );
        $pdf->Close();
        $pdf->Output("F", $this->carpetaTemp . $this->idReporte . ".pdf");
    }


    public function deleteTempImages()
    {
        foreach ($this->bases64 as $base64) {
            unlink($this->urlBases64[$base64["id"]]);
        }
    }


    public function generarInformeFinal($id_laboratorio, $id_programa, $id_ronda, $bases64, $fechas_corte)
    {
        $this->setAttribute("id_laboratorio", $id_laboratorio);
        $this->setAttribute("id_programa", $id_programa);
        $this->setAttribute("id_ronda", $id_ronda);
        $this->setAttribute("bases64", $bases64);
        $this->setAttribute("fechas_corte", $fechas_corte);
        $this->setNomsImages();
        $this->saveImages();
        $this->generarEstructuraPDF();
        $this->deleteTempImages();
        echo $this->idReporte;
    }
}


$backFinRonda = new BackFinRonda();
$backFinRonda->generarInformeFinal($_POST["laboratorio"], $_POST["programa"], $_POST["ronda"], $_POST["bases64"], $_POST["fechas_corte"]);