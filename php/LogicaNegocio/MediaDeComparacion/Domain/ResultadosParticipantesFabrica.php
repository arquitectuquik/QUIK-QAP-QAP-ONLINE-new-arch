<?php
require_once __DIR__."/ObtenedorResultadosInterface.php";
abstract class ResultadosParticipantesFabrica {
    protected $resultadosRepository;

    public function __construct($repository)
    {
        $this->resultadosRepository = $repository;
    }
    /**
     * Devuelve la estrategia usada para obtener los resultados de los participantes
     *
     * @param [type] $idPrograma
     * @param [type] $configAnalito
     * @param [type] $muestra
     * @return ObtenedorResultadosInterface
     */
    abstract public function crearEstrategia($idPrograma,$configAnalito,$muestra);
}