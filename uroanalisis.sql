CREATE TABLE puntuaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO `puntuaciones` (`id`, `valor`, `created_at`, `updated_at`) VALUES 
(NULL, '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, '2', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, '3', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, '4', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, '5', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '6', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '7', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '8', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '9', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '10', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '11', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, '12', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),
(NULL, '13', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '14', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP), 
(NULL, '15', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);

ALTER TABLE `analito_resultado_reporte_cualitativo` ADD `id_puntuacion` INT NOT NULL AFTER `desc_resultado_reporte_cualitativo`, ADD INDEX `idx_id_puntuacion` (`id_puntuacion`);

ALTER TABLE `analito_resultado_reporte_cualitativo` ADD CONSTRAINT `fk_analito_resultado_reporte_cualitativo_puntuacion` FOREIGN KEY (`id_puntuacion`) REFERENCES `panequik_qaponline_v4`.`puntuaciones`(`id`) ON DELETE CASCADE ON UPDATE CASCADE


CREATE TABLE digitacion_resultados_verdaderos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mesurando_id INT NOT NULL,
    mesurando_resultado_reporte_cualitativo_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Definición de claves foráneas
    CONSTRAINT fk_digitacion_resultados_verdaderos_mesurando FOREIGN KEY (mesurando_id) REFERENCES analito(id_analito) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_digitacion_resultados_verdaderos_cualitativo FOREIGN KEY (mesurando_resultado_reporte_cualitativo_id) REFERENCES analito_resultado_reporte_cualitativo(id_analito_resultado_reporte_cualitativo ) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE digitaciones_uroanalisis (
    id_digitaciones_uroanalisis INT AUTO_INCREMENT PRIMARY KEY,
    id_laboratorio  INT NOT NULL,
    id_programa  INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    -- Definición de claves foráneas
    CONSTRAINT fk_digitaciones_uroanalisis_2_lab FOREIGN KEY (id_laboratorio) REFERENCES laboratorio(id_laboratorio) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_digitaciones_uroanalisis_2_programa FOREIGN KEY (id_programa) REFERENCES  programa(id_programa) ON DELETE CASCADE ON UPDATE CASCADE
);

ALTER TABLE `digitacion_resultados_verdaderos` ADD `id_digitacion_uroanalisis` INT NOT NULL AFTER `id`, ADD INDEX `idx_digitacion_uroanalisis` (`id_digitacion_uroanalisis`);

ALTER TABLE `digitacion_resultados_verdaderos` ADD CONSTRAINT `fk_digitacion_resultados_verdaderos_digitacion` FOREIGN KEY (`id_digitacion_uroanalisis`) REFERENCES `panequik_qaponline_v4`.`digitaciones_uroanalisis`(`id_digitaciones_uroanalisis`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `digitaciones_uroanalisis` ADD `id_lote` INT NULL AFTER `id_programa`, ADD INDEX `idx_lote` (`id_lote`);

ALTER TABLE `digitaciones_uroanalisis` ADD CONSTRAINT `fk_digitaciones_uroanalisis_2_lote` FOREIGN KEY (`id_lote`) REFERENCES `panequik_qaponline_v4`.`lote`(`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE;


CREATE TABLE `comparaciones_internacionales` 
( `id_comparaciones_internacionales` INT NOT NULL AUTO_INCREMENT , 
 `id_digitacion_uroanalisis` INT NOT NULL ,
 `id_mesurando` INT NOT NULL , 
 `id_mesurando_resultado_reporte_cualitativo` 
 INT NOT NULL , 
 PRIMARY KEY (`id_comparaciones_internacionales`), 
 INDEX `idx_id_digitacion_uroanalisis` (`id_digitacion_uroanalisis`),
 INDEX `idx_id_analito` (`id_mesurando`),
 INDEX `idx_id_resultado_cualitativo` (`id_mesurando_resultado_reporte_cualitativo`)) ENGINE = InnoDB;

ALTER TABLE `comparaciones_internacionales` 
ADD CONSTRAINT `fk_comparaciones_internacionales_digitacion` FOREIGN KEY (`id_digitacion_uroanalisis`) REFERENCES `panequik_qaponline_v4`.`digitaciones_uroanalisis`(`id_digitaciones_uroanalisis`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `comparaciones_internacionales` 
ADD CONSTRAINT `fk_comparaciones_internacionales_mesurando` FOREIGN KEY (`id_mesurando`) REFERENCES `panequik_qaponline_v4`.`analito`(`id_analito`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `comparaciones_internacionales` 
ADD CONSTRAINT `fk_comparaciones_internacionales_resultado` FOREIGN KEY (`id_mesurando_resultado_reporte_cualitativo`) REFERENCES `panequik_qaponline_v4`.`analito_resultado_reporte_cualitativo`(`id_analito_resultado_reporte_cualitativo`) ON DELETE RESTRICT ON UPDATE RESTRICT;




CREATE TABLE `panequik_qaponline_v4`.`mesurando_valores` 
( `id_mesurando_valores` INT NOT NULL AUTO_INCREMENT , `id_mesurando` INT NOT NULL , `numero_lab` INT NOT NULL , `numero_points` INT NOT NULL , 
PRIMARY KEY (`id_mesurando_valores`), INDEX `idx_id_analito` (`id_mesurando`)) ENGINE = InnoDB;

ALTER TABLE `mesurando_valores` ADD CONSTRAINT `fk_mesurando_valores_analito` FOREIGN KEY (`id_mesurando`) REFERENCES `panequik_qaponline_v4`.`analito`(`id_analito`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `mesurando_valores` ADD `id_digitaciones_uroanalisis` INT NOT NULL AFTER `id_mesurando_valores`, ADD INDEX `idx_digitacion` (`id_digitaciones_uroanalisis`);

ALTER TABLE `mesurando_valores` ADD CONSTRAINT `fk_mesurando_valores_digitacion` FOREIGN KEY (`id_digitaciones_uroanalisis`) REFERENCES `panequik_qaponline_v4`.`digitaciones_uroanalisis`(`id_digitaciones_uroanalisis`) ON DELETE RESTRICT ON UPDATE RESTRICT;

CREATE TABLE `panequik_qaponline_v4`.`resultados_vav` 
( `id_resultados_vav` INT NOT NULL AUTO_INCREMENT , `id_digitaciones_uroanalisis` INT NOT NULL , `id_mesurando` INT NOT NULL , `id_mesurando_resultado_reporte_cualitativo` INT NOT NULL , 
PRIMARY KEY (`id_resultados_vav`), 
INDEX `idx_digitacion_uroanalisis` (`id_digitaciones_uroanalisis`), 
INDEX `idx_id_analito` (`id_mesurando`), 
INDEX `idx_id_resultado_cualitativo` (`id_mesurando_resultado_reporte_cualitativo`)) ENGINE = InnoDB;

ALTER TABLE `resultados_vav` ADD CONSTRAINT `fk_resultados_vav_digitacion` FOREIGN KEY (`id_digitaciones_uroanalisis`) REFERENCES `panequik_qaponline_v4`.`digitaciones_uroanalisis`(`id_digitaciones_uroanalisis`) ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE `resultados_vav` ADD CONSTRAINT `fk_resultados_vav_analito` FOREIGN KEY (`id_mesurando`) REFERENCES `panequik_qaponline_v4`.`analito`(`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE; 

ALTER TABLE `resultados_vav` ADD CONSTRAINT `fk_resultados_vav_resultado_cualitativo` FOREIGN KEY (`id_mesurando_resultado_reporte_cualitativo`) REFERENCES `panequik_qaponline_v4`.`analito_resultado_reporte_cualitativo`(`id_analito_resultado_reporte_cualitativo`) ON DELETE CASCADE ON UPDATE CASCADE;



-----------------------------------------------------------------------------------------------------------
ALTER TABLE `digitacion_resultados_verdaderos` ADD `id_configuracion` INT NULL AFTER `id_digitacion_uroanalisis`, ADD INDEX `idx_id_configuracion` (`id_configuracion`);

ALTER TABLE `digitacion_resultados_verdaderos` ADD CONSTRAINT `fk_digitacion_resultados_verdaderos_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `panequik_qaponline_v4`.`configuracion_laboratorio_analito`(`id_configuracion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comparaciones_internacionales` ADD `id_configuracion` INT NULL AFTER `id_digitacion_uroanalisis`, ADD INDEX `idx_id_configuracion` (`id_configuracion`);

ALTER TABLE `comparaciones_internacionales` ADD CONSTRAINT `fk_comparaciones_internacionales_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `panequik_qaponline_v4`.`configuracion_laboratorio_analito`(`id_configuracion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `mesurando_valores` ADD `id_configuracion` INT NULL AFTER `id_digitaciones_uroanalisis`, ADD INDEX `idx_id_configuracion` (`id_configuracion`);

ALTER TABLE `mesurando_valores` ADD CONSTRAINT `fk_mesurando_valores_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `panequik_qaponline_v4`.`configuracion_laboratorio_analito`(`id_configuracion`) ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `resultados_vav` ADD `id_configuracion` INT NULL AFTER `id_digitaciones_uroanalisis`, ADD INDEX `idx_id_configuracion` (`id_configuracion`);

ALTER TABLE `resultados_vav` ADD CONSTRAINT `fk_resultados_vav_resultado_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `panequik_qaponline_v4`.`configuracion_laboratorio_analito`(`id_configuracion`) ON DELETE RESTRICT ON UPDATE RESTRICT;