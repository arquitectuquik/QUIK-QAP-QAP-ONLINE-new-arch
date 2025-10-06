<?php
require_once __DIR__."/Repository.php";
class MuestrasRepository extends Repository {

    public function muestrasDeRonda($idPrograma,$idRonda)
    {
        $query = "
        SELECT
            muestra.id_muestra,
            muestra.codigo_muestra,
            contador_muestra.no_contador,
            muestra_programa.fecha_vencimiento as fecha_vencimiento_mp,
            muestra_programa.id_lote,
            lote.fecha_vencimiento as fecha_vencimiento_lote,
            lote.nivel_lote
        FROM contador_muestra
        INNER JOIN muestra ON
            contador_muestra.id_muestra = muestra.id_muestra
        INNER JOIN muestra_programa ON
            muestra.id_muestra = muestra_programa.id_muestra   
        INNER JOIN lote ON
            lote.id_lote = muestra_programa.id_lote      
        WHERE
            contador_muestra.id_ronda = ".$idRonda."
            AND muestra_programa.id_programa = ".$idPrograma."
        ORDER BY            
            contador_muestra.no_contador ASC
        ";
        return $this->ejecutarQuery($query);
    }
}