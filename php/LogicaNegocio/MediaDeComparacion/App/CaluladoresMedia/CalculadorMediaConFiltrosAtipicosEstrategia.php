<?php

class CalculadorMediaConFiltrosAtipicosEstrategia
{
    /**
     * Fabrica de estrategias para obtener resultados
     *
     * @var ResultadosParticipantesFabrica
     */
    protected $obtenedorResultadosFabrica;

    protected $filtroAtipicoFabrica;

    protected $idPrograma;

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


    public function setFiltroAtipipicosFabrica($filtroAtipicosFabrica)
    {
        $this->filtroAtipicoFabrica = $filtroAtipicosFabrica;
    }

    public function setIdPrograma($id)
    {
        $this->idPrograma = $id;
    }


    public function calcular($configAnalito, $muestra)
    {
        $estrategiaObtenedoraResultados = $this->obtenedorResultadosFabrica->crearEstrategia(
            $this->idPrograma,
            $configAnalito,
            $muestra
        );
        $resultadosParticipantes = $estrategiaObtenedoraResultados->getResultados();

        // Estructura base con valores por defecto
        $resultadoDefault = [
            "media" => 0,
            "n" => 0,
            "cv" => 0,
            "mediana" => 0,
            "q1" => 0,
            "q3" => 0,
            "s" => 0
        ];

        if (count($resultadosParticipantes) === 0) {
            return $resultadoDefault;
        }

        $valoresParticipantes = array_filter(
            array_column($resultadosParticipantes, "valor_resultado"),
            function ($v) {
                return is_numeric($v);
            }
        );

        // Si no hay valores numéricos válidos
        if (empty($valoresParticipantes)) {
            return $resultadoDefault;
        }

        $filtroAtipicos = $this->filtroAtipicoFabrica->crearFiltro();
        $filtroAtipicos->ejecutar($valoresParticipantes, false);
        $resultado = $filtroAtipicos->getPromediosNormales();

        // Asegurar que todos los campos existan (previene undefined index)

       
        return array_merge($resultadoDefault, $resultado);
    }
}