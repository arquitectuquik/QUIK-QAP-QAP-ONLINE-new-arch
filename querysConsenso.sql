-- obtiene las rondas con id de cada una, según el id laboratorio y el id del programa
SELECT ronda.no_ronda,ronda.id_ronda 
FROM ronda
INNER JOIN ronda_laboratorio ON ronda.id_ronda = ronda_laboratorio.id_ronda 
INNER JOIN programa ON ronda.id_programa = programa.id_programa 
INNER JOIN muestra_programa ON programa.id_programa = muestra_programa.id_programa 
WHERE ronda_laboratorio.id_laboratorio = 175 AND ronda.id_programa = 6 
GROUP BY ronda.id_ronda ORDER BY ronda.no_ronda DESC

-- se busca por id de ronda 269 que corresponde al numero de ronda 48
-- se obtiene el id_lote, nombre_lote, nivel_lote, fecha_vencimiento, id_muestra, codigo_muestra, no_contador y fecha_vencimiento de muestra_programa
-- aqui es donde miramos que lotes tienen que muestras
SELECT 
lote.id_lote, lote.nombre_lote, lote.nivel_lote, lote.fecha_vencimiento,
muestra.id_muestra,muestra.codigo_muestra,contador_muestra.no_contador,muestra_programa.fecha_vencimiento 
FROM ronda 
INNER JOIN contador_muestra ON ronda.id_ronda = contador_muestra.id_ronda 
INNER JOIN muestra ON contador_muestra.id_muestra = muestra.id_muestra 
INNER JOIN muestra_programa ON muestra.id_muestra = muestra_programa.id_muestra 
INNER JOIN programa ON muestra_programa.id_programa = programa.id_programa 
INNER JOIN lote ON lote.id_lote = muestra_programa.id_lote
WHERE ronda.id_ronda = 269 
ORDER BY ronda.no_ronda DESC, contador_muestra.no_contador ASC


-- Consulta para obtener todos los mesurandos condicionando que se haya subido un resultado de laboratorio, por el nombre del lote en este caso 98002 (por este lote ya que este lote contiene la muestra seleccionada por la que se esta generando el pdf) y por la fecha de resultado
SELECT DISTINCT
	analito.id_analito AS 'id_analito',
    analito.nombre_analito AS 'nombre_analito'
FROM 
    programa
    JOIN muestra_programa ON programa.id_programa = muestra_programa.id_programa
    JOIN muestra ON muestra.id_muestra = muestra_programa.id_muestra
    JOIN contador_muestra ON muestra.id_muestra = contador_muestra.id_muestra
    JOIN ronda ON ronda.id_ronda = contador_muestra.id_ronda
    JOIN lote ON lote.id_lote = muestra_programa.id_lote
    JOIN resultado ON muestra.id_muestra = resultado.id_muestra
    JOIN configuracion_laboratorio_analito ON configuracion_laboratorio_analito.id_configuracion = resultado.id_configuracion
    JOIN laboratorio ON laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio
    JOIN unidad ON unidad.id_unidad = configuracion_laboratorio_analito.id_unidad
    JOIN analito ON analito.id_analito = configuracion_laboratorio_analito.id_analito
    JOIN metodologia ON metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia
WHERE 
    resultado.valor_resultado IS NOT NULL
    AND resultado.valor_resultado != ''
    AND lote.nombre_lote = 98002
    AND resultado.fecha_resultado <= '2025-06-16'
ORDER BY analito.nombre_analito


-- Esta consulta se obtiene todos los laboratorios que han subidos su resultado en este caso para el analito 'Gravedad específica' con el mismo nombre de lote y fecha de resultado
-- además de consultar todos los laboratorios que han subido su resultado, se obtiene por cada registro la descripcion cualitativa seleccionada por el laboratorio y la puntuacion que se le asigno a esa descripcion cualitativa

SELECT 
										resultado.valor_resultado AS 'resultado',
										resultado.fecha_resultado AS 'fecha_resultado',
										programa.nombre_programa AS 'nombre_programa',
										ronda.no_ronda AS 'no_ronda',
										contador_muestra.no_contador AS 'no_contador',
										muestra.id_muestra AS 'id_muestra',
										muestra.codigo_muestra AS 'codigo_muestra',
										carqc.id_configuracion AS 'id_configuracion',
										laboratorio.no_laboratorio AS 'no_laboratorio',
										laboratorio.nombre_laboratorio AS 'nombre_laboratorio',
										metodologia.nombre_metodologia AS 'nombre_metodologia',
										resultado.id_analito_resultado_reporte_cualitativo AS 'id_result_cualitativo',
										analito_resultado_reporte_cualitativo.desc_resultado_reporte_cualitativo,
										puntuaciones.valor AS 'puntuacion'
									FROM 
										programa
										JOIN muestra_programa ON programa.id_programa = muestra_programa.id_programa
										JOIN muestra ON muestra.id_muestra = muestra_programa.id_muestra
										JOIN contador_muestra ON muestra.id_muestra = contador_muestra.id_muestra
										JOIN ronda ON ronda.id_ronda = contador_muestra.id_ronda
										JOIN lote ON lote.id_lote = muestra_programa.id_lote
										JOIN resultado ON muestra.id_muestra = resultado.id_muestra
										JOIN configuracion_laboratorio_analito ON configuracion_laboratorio_analito.id_configuracion = resultado.id_configuracion
										JOIN laboratorio ON laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio
										JOIN unidad ON unidad.id_unidad = configuracion_laboratorio_analito.id_unidad
										JOIN analito ON analito.id_analito = configuracion_laboratorio_analito.id_analito
										JOIN metodologia ON metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia
										
										LEFT JOIN configuracion_analito_resultado_reporte_cualitativo AS carqc 
											ON carqc.id_configuracion = configuracion_laboratorio_analito.id_configuracion
											
										LEFT JOIN analito_resultado_reporte_cualitativo ON analito_resultado_reporte_cualitativo.id_analito_resultado_reporte_cualitativo = resultado.id_analito_resultado_reporte_cualitativo
										LEFT JOIN puntuaciones ON puntuaciones.id = analito_resultado_reporte_cualitativo.id_puntuacion
											
									WHERE 
										resultado.valor_resultado IS NOT NULL
										AND resultado.valor_resultado != ''
			 							AND analito.nombre_analito = 'Gravedad específica'
				 						AND lote.nombre_lote = 98002
				 						AND resultado.fecha_resultado <= '2025-06-16'
				 						GROUP BY carqc.id_configuracion


-- despues de esta consulta por medio de código se toma en cuenta el número de puntuacion y la descripcion cualitativa de cada registro y se van iterando para conocer cual es que el más se repite, y en caso de empate (por ejemplo: De 10 laboratorios que reportaron, 4 descripciones cualitativas tienen una puntuacion de 9 y 4  descripciones cualitativas tienen una puntuacion de 5) se toman esos valores


/*
SELECT 
	resultado.valor_resultado AS 'resultado',
	resultado.fecha_resultado AS 'fecha_resultado',
	programa.nombre_programa AS 'nombre_programa',
	ronda.no_ronda AS 'no_ronda',
	contador_muestra.no_contador AS 'no_contador',
	muestra.codigo_muestra AS 'codigo_muestra',
	carqc.id_configuracion AS 'id_configuracion',
	laboratorio.no_laboratorio AS 'no_laboratorio',
	laboratorio.nombre_laboratorio AS 'nombre_laboratorio',
	metodologia.nombre_metodologia AS 'nombre_metodologia'
FROM 
	programa
	JOIN muestra_programa ON programa.id_programa = muestra_programa.id_programa
	JOIN muestra ON muestra.id_muestra = muestra_programa.id_muestra
	JOIN contador_muestra ON muestra.id_muestra = contador_muestra.id_muestra
	JOIN ronda ON ronda.id_ronda = contador_muestra.id_ronda
	JOIN lote ON lote.id_lote = muestra_programa.id_lote
	JOIN resultado ON muestra.id_muestra = resultado.id_muestra
	JOIN configuracion_laboratorio_analito ON configuracion_laboratorio_analito.id_configuracion = resultado.id_configuracion
	JOIN laboratorio ON laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio
	JOIN unidad ON unidad.id_unidad = configuracion_laboratorio_analito.id_unidad
	JOIN analito ON analito.id_analito = configuracion_laboratorio_analito.id_analito
	JOIN metodologia ON metodologia.id_metodologia = configuracion_laboratorio_analito.id_metodologia
	-- AQUÍ LOS JOINs CORRECTOS CON ALIAS:
	LEFT JOIN configuracion_analito_resultado_reporte_cualitativo AS carqc 
		ON carqc.id_configuracion = configuracion_laboratorio_analito.id_configuracion
		
WHERE 
	resultado.valor_resultado IS NOT NULL
	AND resultado.valor_resultado != ''
	AND analito.nombre_analito = 'Microscopia: Recuento de Leucocitos'
	AND lote.nombre_lote = 98002
	AND resultado.fecha_resultado <= '2025-06-16'
GROUP BY carqc.id_configuracion;
*/