<?php
require_once __DIR__ . "/../Domain/ResultadosParticipantesFabrica.php";
require_once __DIR__ . "/ObResultadosParticipantesEstrategia.php";
class TodosParticipantesFabrica extends ResultadosParticipantesFabrica
{

    private $fechaCortePersonalizada;

    public function setFechaCorte($fecha)
    {
        $this->fechaCortePersonalizada = $fecha;
    }

    /**
     * Se encarga de crear la 
     *
     * @param [type] $idPrograma
     * @param [type] $configAnalito
     * @param [type] $muestra
     * @return void
     */
    public function crearEstrategia($idPrograma, $configAnalito, $muestra)
    {

        $fecha = $muestra['fecha_vencimiento_mp'];

        // Número de días que deseas añadir
        $dias_a_anadir = 8;
        // Añadir días a la fecha original
        $nueva_fecha = date('Y-m-d', strtotime($fecha . ' + ' . $dias_a_anadir . ' days'));

        if (is_array($this->fechaCortePersonalizada) && !empty($this->fechaCortePersonalizada[$muestra['id_muestra']])) {
            $nueva_fecha = $this->fechaCortePersonalizada[$muestra['id_muestra']];
        }
        // Obtener el id_configuracion del analito actual 
        $idConfigConsensoActual = null;
        if (is_array($configAnalito) && isset($configAnalito['id_configuracion'])) {
            $idConfigConsensoActual = $configAnalito['id_configuracion'];
        }

        $idMuestraActual = isset($muestra['id_muestra']) ? $muestra['id_muestra'] : null; // Obtener id_muestra
        $fechaSeleccionActual = $nueva_fecha; // La fecha de corte es la fecha de seleccion


        $estrategia = new ObResultadosParticipantesEstrategia(
            $idPrograma,
            $configAnalito['id_unidad'],
            $muestra['id_lote'],
            $configAnalito['id_analito'],
            $nueva_fecha,
            $idConfigConsensoActual,
            $idMuestraActual,
            $fechaSeleccionActual
        );
        $estrategia->setRepository($this->resultadosRepository);
        return $estrategia;
    }
}
