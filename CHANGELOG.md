# Changelog

Todas las notas de cambios de este proyecto estaran escritas en este archivo

## [12.1.0] - 2024-05-21

### Added
- Se añade controlador encargador de orquestar los calculos de la media de todos y participantes de misma metodologia
- Se añade clases de repositorio encargadas de hacer exclusivamente las querys a la base de datos
- Se crea carpeta de Logica de Negocio para almacenar las clases e interfaces encargadas de realizar calculos relacionados al negocio
- Se añaden inputs en a vista de resultados y fin de ronda para especificar las fechas de corte para tomar los participantes 

### Fixed
- Se realiza refactorizacion del lugar de donde se extraen los datos que se muestran en el pdf de resultado como en el fin de ronda para que los dos dependar el controlador

### Changed
- Se cambia el algoritmo de toma de participantes y ahora se tiene en cuenta los participantes que reportaron en una fecha menor o igual a la indicada en los inputs de resultados o fin de ronda o si estos no tienen especificados fechas se tomaran de la fecha de reporte de la muestra configurada en la administra mas 8 dias