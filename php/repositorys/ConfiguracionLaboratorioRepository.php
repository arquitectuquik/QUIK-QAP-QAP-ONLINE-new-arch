<?php
require_once __DIR__ . "/Repository.php";;
class ConfiguracionLaboratorioRepository extends Repository {

    /**
     * Devuelve solo la relacion que existe entre el laboratorio y el programa con los analitos
     *
     * @param [type] $idLaboratorio
     * @param [type] $idPrograma
     * @return void
     */
    public function idsAnalitosDelLaboratorioPorPrograma($idLaboratorio,$idPrograma)
    {
        $query = "
            SELECT cla.*,a.nombre_analito  FROM configuracion_laboratorio_analito cla
            INNER JOIN analito a ON a.id_analito = cla.id_analito
            WHERE id_laboratorio = ".$idLaboratorio."
            AND id_programa = ".$idPrograma." 
            AND cla.activo = 1
            ORDER BY a.nombre_analito ASC
        ";

  
      
        return $this->ejecutarQuery($query);
    }
}