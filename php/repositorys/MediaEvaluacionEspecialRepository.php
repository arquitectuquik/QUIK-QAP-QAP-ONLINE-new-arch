<?php
require_once __DIR__ . "/Repository.php";
class MediaEvaluacionEspecialRepository extends Repository
{

	public function getMedia($idConfiguracion, $nivelLote, $idMuestra, $idLab)
	{
		$query = "
		SELECT 
		mec.percentil_25,
		mec.percentil_75,
		mec.media_estandar,

		mec.desviacion_estandar,

		mec.coeficiente_variacion,

		mec.n_evaluacion,

		mec.tipo_digitacion_wwr,

		mec.tipo_consenso_wwr,

		mec.id_digitacion_wwr,

		unidad_mc.id_unidad, 

		unidad_mc.nombre_unidad as nombre_unidad_mc  

		FROM media_evaluacion_caso_especial mec

			left join digitacion_cuantitativa dc on dc.id_digitacion_cuantitativa = mec.id_digitacion_wwr

			left join unidad unidad_mc on unidad_mc.id_unidad = dc.id_unidad_mc

		INNER JOIN configuracion_laboratorio_analito cla ON mec.id_configuracion = cla.id_configuracion 
		WHERE cla.id_configuracion = " . $idConfiguracion . " AND mec.nivel =" . $nivelLote . " AND mec.id_muestra = " . $idMuestra . " AND mec.id_laboratorio = " . $idLab . " LIMIT 0,1";

		return $this->ejecutarQuery($query);
	}
}