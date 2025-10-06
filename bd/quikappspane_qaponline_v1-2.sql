

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

DELIMITER $$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarAnalitos` ()   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE nombre_analito_agrupado VARCHAR(255);
    DECLARE analitos_agrupados CURSOR FOR 
		select nombre_analito
        from analito
        group by nombre_analito
        order by nombre_analito;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN analitos_agrupados;
    REPEAT
		IF NOT done THEN
			FETCH analitos_agrupados INTO
				nombre_analito_agrupado;
            call homogeneizarAnalitoscomplemento(nombre_analito_agrupado);
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE analitos_agrupados;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarAnalitoscomplemento` (IN `nombre_analito_agrupado` VARCHAR(255))   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE id_analito_agp int;
    DECLARE primer_id_analito int;
    DECLARE count_analitos int;
    DECLARE id_analitos_agp CURSOR FOR 
		select id_analito
        from analito 
        where nombre_analito = nombre_analito_agrupado and id_analito != (
			SELECT id_analito
			FROM analito
			where nombre_analito = nombre_analito_agrupado
			order by id_analito
			LIMIT 1
		)
        order by id_analito;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN id_analitos_agp;
    SET primer_id_analito = (
		SELECT id_analito
        FROM analito
        where nombre_analito = nombre_analito_agrupado
        order by id_analito
        LIMIT 1
    );
    REPEAT
		IF NOT done THEN
			FETCH id_analitos_agp INTO id_analito_agp;
			update material_jctlm set id_analito = primer_id_analito where id_analito = id_analito_agp and id_material_jctlm > 0;
			update unidad_global_analito set id_analito = primer_id_analito where id_analito = id_analito_agp and id_conexion > 0;
			update valor_metodo_referencia set id_analito = primer_id_analito where id_analito = id_analito_agp  and id_valor_metodo_referencia > 0;
			update metodo_jctlm set id_analito = primer_id_analito where id_analito = id_analito_agp and id_metodo_jctlm > 0;
			update configuracion_laboratorio_analito set id_analito = primer_id_analito where id_analito = id_analito_agp and id_configuracion > 0;
			update analito_resultado_reporte_cualitativo set id_analito = primer_id_analito where id_analito = id_analito_agp and id_analito_resultado_reporte_cualitativo > 0;
			update programa_analito set id_analito = primer_id_analito where id_analito = id_analito_agp and id_conexion > 0;
			update digitacion_cuantitativa set id_analito = primer_id_analito where id_analito = id_analito_agp and id_digitacion_cuantitativa > 0;
			update limite_evaluacion set id_analito = primer_id_analito where id_analito = id_analito_agp and id_limite > 0;

			delete from analito where id_analito = id_analito_agp;
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE id_analitos_agp;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarAnalizadores` ()   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE nombre_analizador_agrupado VARCHAR(255);
    DECLARE analizadores_agrupados CURSOR FOR 
		select nombre_analizador
        from analizador
        group by nombre_analizador
        order by nombre_analizador;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN analizadores_agrupados;
    REPEAT
		IF NOT done THEN
			FETCH analizadores_agrupados INTO
				nombre_analizador_agrupado;
            call homogeneizarAnalizadorescomplemento(nombre_analizador_agrupado);
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE analizadores_agrupados;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarAnalizadorescomplemento` (IN `nombre_analizador_agrupado` VARCHAR(255))   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE id_analizador_agp int;
    DECLARE primer_id_analizador int;
    DECLARE count_analizadores int;
    DECLARE id_analizadores_agp CURSOR FOR 
		select id_analizador
        from analizador
        where nombre_analizador = nombre_analizador_agrupado and id_analizador != (
			SELECT id_analizador
			FROM analizador
			where nombre_analizador = nombre_analizador_agrupado
			order by id_analizador
			LIMIT 1
		)
        order by id_analizador;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN id_analizadores_agp;
    SET primer_id_analizador = (
		SELECT id_analizador
        FROM analizador
        where nombre_analizador = nombre_analizador_agrupado
        order by id_analizador
        LIMIT 1
    );
    REPEAT
		IF NOT done THEN
			FETCH id_analizadores_agp INTO id_analizador_agp;
			update metodologia_analizador set id_analizador = primer_id_analizador where id_analizador = id_analizador_agp and id_conexion > 0;
			update digitacion_cuantitativa set id_analizador = primer_id_analizador where id_analizador = id_analizador_agp and id_digitacion_cuantitativa > 0;
			update configuracion_laboratorio_analito set id_analizador = primer_id_analizador where id_analizador = id_analizador_agp and id_configuracion > 0;
			update unidad_analizador set id_analizador = primer_id_analizador where id_analizador = id_analizador_agp  and id_conexion > 0;

			delete from analizador where id_analizador = id_analizador_agp;
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE id_analizadores_agp;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarMetodologias` ()   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE nombre_metodologia_agrupada VARCHAR(255);
    DECLARE metodologias_agrupadas CURSOR FOR 
		select nombre_metodologia
        from metodologia
        group by nombre_metodologia 
        order by nombre_metodologia;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN metodologias_agrupadas;
    REPEAT
		IF NOT done THEN
			FETCH metodologias_agrupadas INTO
				nombre_metodologia_agrupada;
            call homogeneizarMetodologiascomplemento(nombre_metodologia_agrupada);
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE metodologias_agrupadas;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarMetodologiascomplemento` (IN `nombre_metodologia_agrupada` VARCHAR(255))   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE id_metodologia_agp VARCHAR(255);
    DECLARE primer_id_metodologia int;
    DECLARE count_metodologias int;
    DECLARE id_metodologias_agp CURSOR FOR 
		select id_metodologia 
        from metodologia 
        where nombre_metodologia = nombre_metodologia_agrupada and id_metodologia != (
			SELECT id_metodologia
			FROM metodologia
			where nombre_metodologia = nombre_metodologia_agrupada
			order by id_metodologia
			LIMIT 1
		)
        order by id_metodologia;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN id_metodologias_agp;
    SET primer_id_metodologia = (
		SELECT id_metodologia
        FROM metodologia
        where nombre_metodologia = nombre_metodologia_agrupada
        order by id_metodologia
        LIMIT 1
    );
    REPEAT
		IF NOT done THEN
			FETCH id_metodologias_agp INTO id_metodologia_agp;
			update metodo_jctlm_emparejado set id_metodologia = primer_id_metodologia where id_metodologia = id_metodologia_agp and id_conexion > 0;
            update metodologia_analizador set id_metodologia = primer_id_metodologia where id_metodologia = id_metodologia_agp and id_conexion > 0;
			update valor_metodo_referencia set id_metodologia = primer_id_metodologia where id_metodologia = id_metodologia_agp and id_valor_metodo_referencia > 0;
			update configuracion_laboratorio_analito set id_metodologia = primer_id_metodologia where id_metodologia = id_metodologia_agp and id_configuracion > 0;
            update digitacion_cuantitativa set id_metodologia = primer_id_metodologia where id_metodologia = id_metodologia_agp and id_digitacion_cuantitativa > 0;

			delete from metodologia where id_metodologia = id_metodologia_agp;
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE id_metodologias_agp;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarUnidades` ()   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE nombre_unidad_agrupada VARCHAR(255);
    DECLARE unidades_agrupadas CURSOR FOR 
		select nombre_unidad
        from unidad
        group by nombre_unidad 
        order by nombre_unidad;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN unidades_agrupadas;
    REPEAT
		IF NOT done THEN
			FETCH unidades_agrupadas INTO
				nombre_unidad_agrupada;
            call homogeneizarUnidadescomplemento(nombre_unidad_agrupada);
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE unidades_agrupadas;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `homogeneizarUnidadescomplemento` (IN `nombre_unidad_agrupada` VARCHAR(255))   BEGIN

    DECLARE done INT DEFAULT 0;
    DECLARE id_unidad_agp VARCHAR(255);
    DECLARE primer_id_unidad int;
    DECLARE count_unidades int;
    DECLARE id_unidades_agp CURSOR FOR 
		select id_unidad 
        from unidad 
        where nombre_unidad = nombre_unidad_agrupada and id_unidad != (
			SELECT id_unidad
			FROM unidad
			where nombre_unidad = nombre_unidad_agrupada
			order by id_unidad
			LIMIT 1
		)
        order by id_unidad;
    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;
    OPEN id_unidades_agp;
    SET primer_id_unidad = (
		SELECT id_unidad
        FROM unidad
        where nombre_unidad = nombre_unidad_agrupada
        order by id_unidad
        LIMIT 1
    );
    REPEAT
		IF NOT done THEN
			FETCH id_unidades_agp INTO id_unidad_agp;

			update configuracion_laboratorio_analito set id_unidad = primer_id_unidad where id_unidad = id_unidad_agp and id_configuracion > 0;

			update valor_metodo_referencia set id_unidad = primer_id_unidad where id_unidad = id_unidad_agp and id_valor_metodo_referencia > 0;

			update unidad_analizador set id_unidad = primer_id_unidad where id_unidad = id_unidad_agp and id_conexion > 0;

			update unidad_global_analito set id_unidad = primer_id_unidad where id_unidad = id_unidad_agp and id_conexion > 0;

			update digitacion_cuantitativa set id_unidad = primer_id_unidad where id_unidad = id_unidad_agp and id_digitacion_cuantitativa > 0;

			delete from unidad where id_unidad = id_unidad_agp;
		END IF;
	UNTIL done
    END REPEAT;
    CLOSE id_unidades_agp;
END$$

CREATE DEFINER=`quikappspane`@`localhost` PROCEDURE `listar_configuraciones_lab` ()   BEGIN

    DECLARE id_programa_temp INT;
	DECLARE id_ronda_temp INT;
	DECLARE id_laboratorio_temp INT;
	DECLARE id_muestra_temp INT;
	DECLARE id_configuracion_temp INT;
	DECLARE id_analito_temp INT;
	DECLARE id_analizador_temp INT;
	DECLARE id_metodologia_temp INT;
	DECLARE id_reactivo_temp INT;
	DECLARE id_unidad_temp INT;
	DECLARE id_gen_vitros_temp INT;
	DECLARE id_material_temp INT;
	DECLARE count_media_evaluacion INT;
    DECLARE count_media_evaluacion_caso_especial INT;
    DECLARE done INT DEFAULT 0;
	DECLARE temp_media_definitiva_cursor CURSOR FOR
		select
			programa.id_programa,
			ronda.id_ronda,
			laboratorio.id_laboratorio,
			muestra.id_muestra,
			configuracion_laboratorio_analito.id_configuracion,
			analito.id_analito,
			analizador.id_analizador,
			metodologia.id_metodologia,
			reactivo.id_reactivo,
			unidad.id_unidad,
			gen_vitros.id_gen_vitros,
			material.id_material
		from
			programa
			join ronda on programa.id_programa = ronda.id_programa
			join ronda_laboratorio on ronda.id_ronda = ronda_laboratorio.id_ronda
			join laboratorio on laboratorio.id_laboratorio = ronda_laboratorio.id_laboratorio
			join contador_muestra on ronda.id_ronda = contador_muestra.id_ronda
			join muestra on muestra.id_muestra = contador_muestra.id_muestra
			join configuracion_laboratorio_analito on laboratorio.id_laboratorio = configuracion_laboratorio_analito.id_laboratorio and configuracion_laboratorio_analito.id_programa = programa.id_programa
			join analito on configuracion_laboratorio_analito.id_analito = analito.id_analito 
			join analizador on configuracion_laboratorio_analito.id_analizador = analizador.id_analizador 
			join metodologia on configuracion_laboratorio_analito.id_metodologia = metodologia.id_metodologia 
			join reactivo on configuracion_laboratorio_analito.id_reactivo = reactivo.id_reactivo 
			join unidad on configuracion_laboratorio_analito.id_unidad = unidad.id_unidad 
			join gen_vitros on configuracion_laboratorio_analito.id_gen_vitros = gen_vitros.id_gen_vitros
			left join material on configuracion_laboratorio_analito.id_material = material.id_material;

    DECLARE CONTINUE HANDLER FOR SQLSTATE '02000' SET done = 1;

	drop table if exists temp_media_definitiva;

    create table temp_media_definitiva(
		id_md INT PRIMARY KEY AUTO_INCREMENT,
		id_configuracion_md INT,
		media_estandar_md CHAR(255),
		desviacion_estandar_md CHAR(255),
		coeficiente_variacion_md CHAR(255),
        n_evaluacion_md CHAR(255),
        id_muestra_md INT,
		nivel_md INT,
		id_laboratorio_md INT,
        id_analito_resultado_reporte_cualitativo_md INT,
        id_digitacion_wwr_md INT,
        tipo_digitacion_wwr_md INT
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	OPEN temp_media_definitiva_cursor;

    REPEAT

		FETCH temp_media_definitiva_cursor INTO
			id_programa_temp,
			id_ronda_temp,
			id_laboratorio_temp,
			id_muestra_temp,
			id_configuracion_temp,
			id_analito_temp,
			id_analizador_temp,
			id_metodologia_temp,
			id_reactivo_temp,
			id_unidad_temp,
			id_gen_vitros_temp,
			id_material_temp;
		  IF NOT done THEN

			set @count_media_evaluacion_caso_especial := (
				SELECT distinct 
					count(*)
				FROM temp_media_evaluacion_caso_especial 
				INNER JOIN temp_configuracion_programa_analito ON temp_media_evaluacion_caso_especial.id_configuracion = temp_configuracion_programa_analito.id_configuracion 
				WHERE 
					temp_configuracion_programa_analito.id_analito = id_analito_temp 
					AND temp_configuracion_programa_analito.id_analizador = id_analizador_temp 
					AND temp_configuracion_programa_analito.id_metodologia = id_metodologia_temp
					AND temp_configuracion_programa_analito.id_reactivo = id_reactivo_temp
					AND temp_configuracion_programa_analito.id_unidad = id_unidad_temp
					AND temp_configuracion_programa_analito.id_gen_vitros = id_gen_vitros_temp
					AND temp_media_evaluacion_caso_especial.id_muestra = id_muestra_temp
					AND temp_media_evaluacion_caso_especial.id_laboratorio = id_laboratorio_temp
			);

			IF @count_media_evaluacion_caso_especial > 0 THEN        

CREATE TABLE `analito_resultado_reporte_cualitativo` (
  `id_analito_resultado_reporte_cualitativo` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `desc_resultado_reporte_cualitativo` char(255) DEFAULT NULL,
  `id_puntuacion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_26';

CREATE TABLE `analizador` (
  `id_analizador` int(11) NOT NULL,
  `nombre_analizador` longtext CHARACTER SET utf8 COLLATE utf8_spanish2_ci NOT NULL,
  `cod_analizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_03';

CREATE TABLE `archivo` (
  `id_archivo` int(11) NOT NULL,
  `id_laboratorio` int(11) DEFAULT NULL,
  `id_reto` int(11) DEFAULT NULL,
  `id_ronda` int(11) DEFAULT NULL,
  `nombre_archivo` varchar(255) NOT NULL,
  `extencion_archivo` varchar(255) NOT NULL,
  `index_archivo` char(255) NOT NULL,
  `activo` int(11) NOT NULL,
  `fecha_carga` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Almacenamiento de documentos de asesorias.';

CREATE TABLE `calculo_limite_evaluacion` (
  `id_calculo_limite_evaluacion` int(11) NOT NULL,
  `desc_calculo_limite_evaluacion` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_31';

CREATE TABLE `caso_clinico` (
  `id_caso_clinico` int(11) NOT NULL,
  `reto_id_reto` int(11) NOT NULL,
  `codigo` varchar(45) NOT NULL,
  `nombre` varchar(200) NOT NULL COMMENT 'Analito objeto',
  `enunciado` mediumtext,
  `revision` mediumtext,
  `tejido` varchar(45) DEFAULT NULL,
  `celulas_objetivo` varchar(45) DEFAULT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

 en estos casos la evaluación de la expresión de la proteína SOX11 mediante inmunohistoquímica surge como una herramienta muy útil e indispensable para su diagnóstico.\r\nLa neoplasia de células del manto in situ, previamente denominada como linfoma de células del manto in situ, se define como la presencia de células Ciclina D1 positivas, que portan la translocación 11;14, restringidas a la zona del manto, sin expandirlo ni reemplazarlo por completo. Este es usualmente un hallazgo incidental en un ganglio linfático de características reactivas y su potencial maligno es limitado.\r\nEl Linfoma Linfocitico de célula pequeña (CLL/SLL), es otro tipo de linfoma con co-expresión de CD5, el cual puede ser diferenciado del MCL por sus características morfológicas, con un predominio de célula pequeña con núcleo redondo y la presencia de prolinfocitos y parainmunoblastos. En su fenotipo se caracterizan típicamente por la expresión CD20 (usualmente débil en CF), CD23, CD200, cadenas livianas (monoclonales y débiles), LEF1 y negatividad para CD10, Ciclina D1, SOX11. Aunque, en este tipo de Linfoma la expresión de Ciclina D1 puede ser observada restringida a los centros de proliferación.', NULL, NULL, b'1'),
(249, 54, 'IHQ-SET-C3', 'Caso clínico 3', 'Mujer de 75 años con antecedente de hipertensión y dislipidemia consultó a urgencias por fiebre y disuria, a pesar del tratamiento antibiótico no mejoró y estudios adicionales mostraron una estrechez ureteral extrínseca y una colección perirrenal izquierda. Una laparoscopia diagnóstica mostró múltiples lesiones puntiformes, coalescentes, en el peritoneo pélvico y abdominal. Se observaron lesiones nodulares blanquecinas pequeñas en el hígado. Se tomaron biopsias de peritoneo.', 'Se observa peritoneo con compromiso por una neoplasia maligna compuesta por células de tamaño intermedio, sin pleomorfismo significativo, dispuestas en cordones, nidos pequeños y en célula suelta, en un patrón infiltrativo. Las células son positivas para CK7, GATA-3 y RE (100%), y son negativas con CK20. Estudios adicionales de inmunohistoquímica mostraron ausencia de reactividad con p63, E-cadherina, CDX-2, PAX-8 y calretinina. El diagnóstico más probable es un carcinoma de mama metastásico que favorece un subtipo lobulillar. Estudios de imágenes complementarios evidenciaron un nódulo de 3 cm en mama derecha.  \r\nLa inmunohistoquímica es muy útil en este caso debido a que los hallazgos histológicos podrían ser vistos en cualquiera de las opciones, menos probable un mesotelioma. GATA-3 y CK7 son marcadores cuya reactividad es compartida con uno de los principales imitadores, el carcinoma urotelial. Sin embargo, la presencia de unos receptores estrogénicos muy positivos y ausencia de CK20 (aunque este último hallazgo por si solo no es confiable) favorecen origen en glándula mamaria. Los carcinomas renales de célula clara son típicamente negativos para CK7, GATA-3 y receptores de estrógeno. Los mesoteliomas tienen una citología distinta y citoplasma usualmente más abundante, estos en ocasiones pueden expresar GATA-3 y son positivos para CK7, pero no muestran expresión fuerte de receptores de estrógenos.', NULL, NULL, b'1'),
(250, 54, 'IHQ-SET-C4', 'Caso clínico 4', 'Hombre de 42 años de edad con cuadro clínico de 8 meses de evolución consistente en tos seca ocasional, la cual se incrementaba en intensidad y frecuencia, asociado presentaba dolor pleurítico. Inicialmente recibió manejo sintomático sin mejoría de cuadro clínico, debido a lo cual se realizó tomografía observándose una lesión localizada aparentemente en pulmón derecho de 13 cm de diámetro. Durante el procedimiento quirúrgico se observó que la lesión descrita era nodular y bien circunscrita, localizada en el mediastino posterior.', 'El Schwannoma celular es una variante bien reconocida de schwanoma, que, debido a su celularidad, actividad mitótica y presencia ocasional de destrucción ósea, es diagnosticado como maligno en la de un cuarto de los casos. Se define como un schwanoma constituido predominante o exclusivamente por áreas Antoni A que pierden los cuerpos de Verocay, ocurre en un grupo etareo similar a los schwanomas clásicos, pero tiende a desarrollarse más frecuentemente en estructuras profundas como región paravertebral, mediastino posterior y retroperitoneo.  Los parescraneales pueden verse comprometidos, especialmente el quinto y el octavo. Solo cerca del 25% se desarrollan en tejidos blandos profundos de extremidades. Puede presentarse como una masa palpable asintomática evidente en estudios de imágenes o como una masa que produce síntomas neurológicos. Al igual que los schwanomas clásicos, las lesiones son circunscritas, si no encapsuladas, y ocasionalmente son multinoculares y plexiformes. Macroscópicamente son de color pardo homogéneas, con hemorragia, pero rara vez presentan degeneración quística. Las áreas Antoni A dominan el cuadro histológico, pero pueden estar presentes pequeños focos de áreas Antoni B, que generalmente no exceden el 10% de la lesión. Además de los fascículos cortos y en espiral de células de Schwann, las áreas de Antoni A pueden mostrar fascículos largos y amplios, en ocasiones este patrón sugiere el diagnóstico de fibrosarcoma o leiomiosarcoma.\r\nSe puede observar actividad mitótica, pero generalmente es baja (menos de 4 mitosis por 10 campos de alto aumento). Pueden observarse áreas focales de necrosis en hasta el 10% de los casos, asociadas con mayor frecuencia a trauma. Sin embargo, las células que rodean las áreas de necrosis son células de Schwann diferenciadas y carecen de hipercromatismo  y anaplásica que acompañan a las áreas de necrosis zonal en los tumores malignos de la vaina neural periférica. Al igual que los schwannomas clásicos, muestran una inmunorreactividad difusa y fuerte para S100. Los factores importantes que sugieren una diagnóstico benigno incluyen una celularidad desproporcionadamente alta en comparación con los niveles de actividad mitótica y atipia, circunscripción o encapsulación, hialinización perivascular, áreas focales Antoni B e inmunorreactividad S100.', NULL, NULL, b'1'),
(251, 56, 'PQ-219-1', 'Caso clínico 1', 'Mujer de 64 años quien consulta por presentar de 1 año de evolución de masa en cuadrante superior externo de glándula mamaria izquierda para lo cual realizan ecografía que muestra en la periferia de cuadrante superior externo, plano profundo, entre el eje de las 2 y 3, un nódulo ovalado, de márgenes circunscritos, ecogenicidad heterogénea con septos ecogénicos. mide 3,9 x 1 cm. Se realizó resección.', 'Los lipomas intramusculares son lesiones mesenquimales benignas relativamente infrecuentes, constituyen cerca del 1.8% de los tumores primarios de tejido adiposo y menos del 1% de los lipomas. Debido a su gran tamaño, localización profunda, y crecimiento infiltrante son de dificultad diagnóstica tanto para los clínicos como para los patólogos. Ocurren principalmente en adultos entre los 30-60 años con predilección masculina, y compromiso de músculos grandes de las extremidades, especialmente muslo, hombro y parte superior del brazo. La mayoría tienen un crecimiento lento, no dolorosa apareciendo sólo durante la contracción muscular. Los tumores son radiolucidos y pueden encontrarse de forma incidental en exámenes radiológicos de rutina.\r\n\r\nHistológicamente se observan adipocitos infiltrando difusamente el musculo. Las fibras musculares atrapadas usualmente muestran pocos cambios hasta diferentes grados de atrofia muscular. Característicamente, los adipocitos son maduros, sin presencia de lipoblastos o células con núcleos atípicos como se observan en los tumores lipomatosos atípicos (liposarcomas bien diferenciados). Adicionalmente en los tumores lipomatoso atípicos se pueden observan septos fibrosos gruesos asociado presencia de células inflamatorias y áreas mixoides. Sin embargo, se debe realizar un exhaustivo muestreo del tumor debido a la dificultad para distinguirlo de esta lesión. Adicionalmente es posible realizar estudios de FISH o inmunohistoquimica que demuestran la ausencia de amplificación del MDM2 en los lipomas intramusculares y presencia de amplificación en los tumores lipomatosos atípicos (liposarcomas bien diferenciados). La lipoblastomatosis difusa y lipoblastomatosis, ocurren principalmente en infantes y niños, en la subcutis y músculo, estas lesiones tienen a ser más lobuladas que los lipomas intramusculares, en ocasiones sin embargo estas lesiones tienden a ser indistinguibles. En algunas ocasiones las malformaciones vasculares intramusculares pueden estar acompañadas por grasa simulando la imagen de un lipoma intramuscular, en tales casos se puede malinterpretar como un angiolipoma.\r\n\r\nEl pronóstico de estos tumores es excelente cuando es completamente removido. En general, la tasa de recurrencia varía entre 3% hasta un 62.5% dependiendo de la completa escisión de la lesión.', NULL, NULL, b'1'),
(252, 56, 'PQ-2131-1', 'Caso clínico 2', 'Mujer de 50 años con enfisema pulmonar y disnea de medianos esfuerzos. Presenta hepatopatía crónica y se realiza una biopsia.', 'Se observa una alteración de la arquitectura en estadio de cirrosis. Se observa en algunos hepatocitos periseptales glóbulos hialinos intracitoplasmáticos de distinto tamaño que muestran positividad con PAS-diastasa. La paciente es portadora de PIZZ con expresión pulmonar y hepática. En adultos la enfermedad hepática puede desarrollarse a partir de la sexta década. En algunos pacientes coexisten otras patologías hepáticas como consumo de bebidas alcohólicas, VHC.', NULL, NULL, b'1'),
(253, 56, 'PQ-2132-1', 'Caso clínico 3', 'Hombre de 46 años con antecedente de diverticulitis aguda, refiere haber persistido con disconfort abdominal por lo cual se realiza colonoscopia que evidenció cambios inflamatorios en colon izquierdo, presentó severos signos inflamatorios con erosiones, micro ulceraciones, cubiertas por fibrina, severo edema. El TAC mostró formaciones diverticulares en el colon transverso, colon descendente y colon sigmoides, observando un engrosamiento de las paredes de un segmento corto del colon descendente con estriación de la grasa adyacente a divertículo, sin identificar signos de perforación ni abscesos. Se enviaron biopsias para análisis.', 'Los pacientes con enfermedad diverticular pueden desarrollar una forma de colitis crónica que se limita a áreas de diverticulosis, pero comparte muchas características clínicas e histológicas con la Enfermedad inflamatoria intestinal.  El compromiso es en el colon izquierdo, pueden quejarse de dolor en cuadrante abdominal izquierdo agudo, a diferencia Los pacientes pueden quejarse de cuadrante abdominal izquierdo agudo, a diferencia de la EII, los pacientes no suelen presentar diarrea ni sangrado. Las biopsias muestran distorsión arquitectónica criptas irregulares en forma, orientación y acortamiento de las criptas, es frecuente la criptitis aguda, abscesos crípticos e inflamación difusa de la mucosa con linfocitos, plasmocitos y eosinófilos muy semejante a lo observado  en enfermedad inflamatoria intestinal, agregados linfoides basales, fibrosis y granulomas que simulan la enfermedad de Crohn o cambios contiguos difusos que recuerdan colitis ulcerativa Biopsias del recto, por definición, son normales.  Los principales diagnósticos diferenciales incluyen Enfermedad inflamatoria intestinal y colitis infecciosas.  Claves diagnósticas: - Historia clínica de diverticulosis y endoscopia - Agregados linfoides basales e infiltrado linfoplasmocitario con eosinófilos - Colitis segmentaría', NULL, NULL, b'1'),
(254, 56, 'PQ-2133-1', 'Caso clínico 4', 'Mujer de 43 años con antecedente de hipertensión y diabetes no controlada, presenta cuadro clínico de 4 meses de evolución de masa en mama izquierdo de aproximadamente 8 cm, en cuadrantes superiores y región retroareolar, asociado en el último mes a dolor, eritema y rubor, en biopsia previa se reportó mastitis aguda y crónica, sin antecedentes de trauma ni implantes mamarios. Se inició manejo antibiótico y se realizó mamotomía con desbridamiento de la lesión. Las coloraciones histoquímicas de Gram, PAS, Gomori y Ziehl-Neelsen fueron negativas para microorganismos. En estudios microbiológicos se observó crecimiento de Corynebacterium kroppenstedtii.', 'La mastitis granulomatosa quística neutrofílica es un subtipo infrecuente de mastitis granulomatosa, da cuenta de menos 1% de los especímenes, la edad media de presentación es de 35 años, usualmente es unilateral, cerca del 8.5% de las pacientes tienen enfermedad bilateral, se presentan como una masa mamaria con o sin inversión del pezón, pueden presentar dolor, secreción por el pezón, eritema y absceso.\n\nEl patrón histológico es característico con presencia de lipogranulomas constituidos por vacuolas lipídicas centrales bordeadas por neutrófilos y un manguito externo de histiocitos epitelioides. Algunas de las vacuolas lipídicas pueden contener bacilos gram positivos dispersos. El infiltrado inflamatorio circundante es mixto con presencia de células gigantes de tipo Langhans, linfocitos y neutrófilos. La definición de esta entidad todavía está evolucionando y no hay criterios diagnósticos universalmente aceptados. Aunque la literatura sugiere una fuerte asociación con especies de Corynebacterium, la evidencia de esta infección puede ser difícil de probar. En ausencia evidencia histoquímica y/o microbiológica de corynebacterias, esta entidad puede sobreponerse clínica, radiológica y patológicamente con otras condiciones inflamatorias o neoplásicas, incluyendo carcinomas infiltrantes.\n\nUna vez descartado un proceso maligno por histología, es necesario descartar otras causas infecciosas, incluyendo bacterias, hongos, o parásitos. Las infecciones bacterianas son más prevalentes y pueden ser polimicrobianas, aunque se ha identificado a bacterias del género Pseudomonas como el germen más frecuente. En áreas endémicas es necesario descartar una mastitis por tuberculosis, esta usualmente se presenta entre los 20-40 años de edad, como una masa, con ulceración, dolor o absceso, sin síntomas sistémicos o pulmonares, y en la histológica es posible encontrar granulomas necrotizantes o no necrotizantes constituidos por histiocitos epitelioides, células gigantes de tipo Langhans, eosinófilos, linfocitos y células plasmáticas afectando predominantemente los ductos más que los lóbulos; para su diagnóstico se requiere la realización de coloraciones con Ziehl-Neelsen, cultivos o detección molecular.\n\nLos abscesos subareolares por su parte son consecuencia de la obstrucción por queratina de los ductos lactíferos (metaplasia escamosa de ductos lactíferos), los ductos pueden romperse resultando en una reacción inflamatoria contra la queratina, en fases agudas se observa un absceso con un infiltrado mixto con predominio neutrofílico, en fases de resolución células inflamatorias crónicas, y reacción de células gigantes tipo cuerpo extraño en respuesta a la queratina. En estos casos es frecuente encontrar presencia de gérmenes anaerobios.\n\nPor otro lado, los granulomas a cuerpo extraño debidos a presencia de silicona o sutura y la necrosis grasa debido a trauma, pueden tener similitud histológica con la mastitis granulomatosa quística neutrofílica, ya que estas dos entidades pueden mostrar estructuras que simulan vacuolas lipídicas. Sin embargo, la historia clínica y un cuidadoso examen de las vacuolas pueden ayudar a establecer el diagnóstico correcto.\n\nAunque poco frecuentes se han reportado reacciones granulomatosas a enfermedades autoinmunes tales como granulomatosis con poliangeitis y artritis reumatoide, las cuales usualmente presentan manifestaciones sistémicas asociadas a presencia de anticuerpos, e histológicamente se observan como granulomas necrotizantes.\n\nPor último, el diagnóstico diferencial de cualquier proceso granulomatoso es la sarcoidosis, menos del 1% de los casos tienen compromiso mamario y tienen evidencia de enfermedad sistémica. En la histología se manifiestan como granulomas no necrotizantes desnudos.', NULL, NULL, b'1'),
(255, 57, 'PQ-22183-2', 'Caso clínico 1', 'Mujer 37 años con embarazo de 16 semanas sin antecedentes clínicos de importancia, consultó al servicio de urgencias por sensación de “salida de líquido por genitales externos”, sin otros síntomas asociados. Una ecografía transvaginal mostró anhidramnios y cérvix abierto, manejándose como aborto inevitable. El feto, placenta, membranas ovulares y cordón fueron enviados a patología. Se envía un corte representativo de las membranas y cordón umbilical.', 'Se observan membranas ovulares con infiltrado inflamatorio agudo (neutrofílico) que se extiende al corión fibroso y amnios con focos de necrosis del epitelio amniótico y cariorrexis. En algunas áreas se identifican microabscesos subcoriónicos, definido como grupos de más de 10-20 neutrófilos. Lo anterior corresponde a una corioamnionitis necrotizante severa (Estadio 3, Grado 2). Aunque no fue evaluado en este caso, los cortes del cordón umbilical no muestran inflamación (sin respuesta inflamatoria fetal).\r\n\r\nPara la estadificación y gradación de las respuestas inflamatorias materna y fetal en infección uterina ascendente es recomendado utilizar las recomendaciones del Consenso del Grupo de Trabajo de Placenta de Amsterdam 2016 (Khong TY, Mooney EE, Ariel I, et al. Sampling and Definitions of Placental Lesions: Amsterdam Placental Workshop Group Consensus Statement. Arch Pathol Lab Med. 2016;140(7):698-713).  Los estadios de la respuesta inflamatoria materna han sido asociados a la duración de la infección, siendo el estadio 3 frecuentemente asociado con infecciones de más de 36 horas de duración.  En embarazos tempranos casi siempre se asocia a ruptura de membranas', NULL, NULL, b'1'),
(256, 57, 'PQ-22182-2', 'Caso clínico 2', 'Hombre de 59 años con antecedente de exposición a partículas por trabajo como mecánico, con historia clínica de pérdida de peso (10 kg aproximadamente) motivo por el cual consultó. En tomografía axial computarizada de tórax se observó un nódulo pulmonar dominante inferior derecho y adenopatías mediastinales bilaterales, además de imágenes sugestivas de granulomas en ápices pulmonares, se decide realización de lobectomía segmentaria por toracoscopia.  Días antes del ingreso presentó picos febriles no cuantificados.\r\n\r\n\r\nEn los cortes histológicos se realizaron tinciones histoquímicas con Ziehl – Neelsen, PAS y Gomori las cuales fueron negativas para microorganismos micóticos y bacilos ácido – alcoholes resistentes. Los estudios moleculares para detección de mycobacterias fueron negativos.', 'La silicosis comprende un grupo de enfermedades pulmonares relacionadas que resultan de la inhalación de cristales de sílice.  Los pacientes presentan un amplio rango de presentaciones clínicas, desde asintomáticos con silicosis simple hasta cuadros de disnea marcada en casos de silicosis en conglomerados.  La silicosis nodular se caracteriza por nódulos hialinizados, que varían desde pocos milímetros a más de un centímetro de diámetro.  El hallazgo histológico característico es la presencia de nódulos silicóticos con presencia de haces densos hialinizados de fibras colágenas, concéntricos, acelulares y formando remolinos.  Pueden encontrarse como en el presente caso, cantidades variables de pigmento negro (carbón), así como calcificaciones, estos hallazgos pueden encontrarse centralmente o en la periferia.  Los nódulos frecuentemente se encuentran en localización perivascular o peribronquiolar pero pueden observarse en cualquier lugar del parénquima pulmonar.  Estos nódulos pueden coalescer formando masas firmes, irregulares, grisáceas de 2 cm o más en su mayor dimensión, usualmente en lóbulos superiores y frecuentemente bilaterales.  Cuando las lesiones coalescen suelen referirse como conglomerado de silicosis.  Estas masas muestran extensa fibrosis y cavitaciones centrales como resultado de la isquemia.  Cuando esto ocurre es necesario diferenciar de una infección por Mycobacterium tuberculosis. Adicionalmente es posible observar enfisema perifocal adyacente a las lesiones fibróticas.  Los nódulos frecuentemente se extienden a la pleura, y pueden evidenciarse adherencias pleurales extensas.  Los ganglios linfáticos hiliares casi siempre se encuentran comprometidos, encontrándose aumentados de tamaño y firmes con hallazgos histológicos similares a los observados en el parénquima pulmonar.\r\n\r\nLos nódulos silicóticos típicamente son bilaterales y múltiples, y puede ser necesario distinguir microscópicamente de granulomas tuberculosos o micóticos.  La presencia de necrosis en asociación con células gigantes favorece una etiología infecciosa.  En estos casos el examen con luz polarizada es de uso limitado, debido a que las partículas de sílice son débilmente refringentes, y pequeñas partículas en los cortes histológicos pueden ser difíciles de visualizar.\r\n\r\nAdicionalmente, debemos tener en cuenta el diagnóstico de sarcoidosis, en estos casos la presencia de células gigantes multinucleadas y la ausencia de depósitos significativos de polvo silicótico favorecen el diagnóstico de sarcoidosis.  Los granulomas sarcoidales pueden contener partículas en forma de aguja o laminares birrefringentes, que representan carbonato y oxalato de calcio endógeno, diferentes a las partículas birrefringentes pequeñas y tenues que suelen verse en los casos de silicosis', NULL, NULL, b'1'),
(257, 57, 'PQ-2235-2', 'Caso clínico 3', 'Mujer de 50 años con colestasis, con fosfatasa alcalina elevada y gamma glutamil transferasa elevada, por elastografia se observó fibrosis leve a moderada. La resonancia magnética nuclear mostró hipotrofia del lóbulo hepático derecho con aumento compensatorio del lóbulo hepático derecho. Saturación de transferrina en 46 porciento. La sospecha clínica era colangitis biliar primaria. Una biopsia previa extrainstitucional reportó hepatitis crónica, otra biopsia intrainstitucional mostró cambios leves inespecíficos, sin evidencia de enfermedad necro inflamatoria activa.', 'En ocasiones son realizadas biopsias hepáticas en pacientes con alteración de las pruebas de función hepática sea con evidencia clínica reciente de hepatitis aguda o en quienes no se pueden encontrar características una clara explicación de una “enfermedad hepática crónica” (pruebas serológicas negativas para hepatitis viral o marcadores autoinmunes).  En la mayoría de los pacientes afectados, la hepatitis aguda es una enfermedad autolimitada sin enfermedad a largo plazo sin secuelas o evidencia de lesión hepática en curso. Esto se da especialmente en hepatitis por virus hepatotrópicos hepatitis A o E u otros virus no hepatotrópicos (por ejemplo, Virus de Epstein Barr, citomegalovirus) también en lesión hepática inducida por fármacos. Si la biopsia hepática es realizada después de la aguda, puede mostrar poca o ninguna anomalía histológica. Células de Kupffer hiperplásicas pueden ser evidentes con H y E pero se aprecia más fácilmente en una tinción PAS Diastasa. Este hallazgo es un reflejo de la lesión hepática reciente y necrosis pasada, en ausencia de otros signos de patología hepática.  Puntos clave:  1. La hiperplasia de células de Kupffer se puede resaltar con un PAS después de la tinción con PAS diastasa y puede ser la única característica histológica evidente después de una hepatitis aguda reciente en fase de resolución.  2. Buscarlos en una biopsia de hígado por lo demás \"casi normal\" en un paciente con una historia reportada de elevación de transaminasas.', NULL, NULL, b'1');
 en esta entidad las células tumorales son usualmente monotonas de tamaño intermedio, exhiben moldeamiento y un núcleo redondo con nucleolos aparantes paracentrales. Fenotipicamente expresan CD10, BCL6 y son negativas para BCL2.\nLa categoría de Linfomas B de alto grado, No especificados (NOS), son incluidos casos con morfología intermedia entre LB y LBDCG o linfomas con apariencia blastoide, sin evidencia de reordenamientos en los genes MYC y BCL2 y/o BCL6. En esta categoría, no deben ser clasificados casos con morfología de LBDCG, como en el presente ejemplo, aun si portan un alto índice de proliferación.\nLas características fenotípicas encontradas no apoyan un diagnostico de Linfoma Plasmablástico (LPB). Este corresponde a un linfoma B de diferenciación terminal, con una localización frecuentemente extranodal, afectando adultos con inmunodeficiencia. Morfológicamente, con células tumorales grandes que recuerdan inmunoblastos (como en este caso) o plasmablastos y un fenotípico de forma característica con perdida o mínima expresión de CD20 y reactividad para marcadores  de células plasmáticas como CD38, CD138 y MUM1. Por lo tanto, LBDCG con una morfología predominante plasmablastica o inmunoblastica, pero con expresión fuerte para CD20, CD79 Y PAX5, no deben ser incluidos en la categoría de LPB.\nFinalmente, es de recalcar que la clasificación de la OMS, resalta la importancia de la determinación de la célula de origen en el LBDCG, la cual deberá ser definida en todos los casos al diagnóstico. De no estar disponibles estudios moleculares, los estudios de IHQ a través de los diferentes algoritmos, como el algoritmo de Hans, son considerados una alternativa aceptable y de uso rutinario.', NULL, NULL, b'1'),
(305, 73, 'IHQ-SET-D4', 'Caso clínico 4', 'Hombre de 57 años, a quien en una radiografía de tórax por estudio de disnea\r\nencuentran múltiples nódulos, algunos cavitados, predominantemente en el pulmón\r\nderecho. Además de estudios de imágenes se realizó una biopsia por toracoscopia. El\r\ndiagnóstico más probable es:', 'Se observa parénquima pulmonar con compromiso por una neoplasia maligna epitelial constituida por estructuras pseudoglandulares tapizadas por células grandes, cilíndricas, de núcleos hipercromáticos, pleomórficos, de cromatina vesicular. Se identifican frecuentes figuras mitóticas y apoptóticas. Las luces glandulares muestran detritos celulares y hay focos de necrosis. Las células neoplásicas son positivas para CK20 y CDX-2, y negativas para TTF-1 y CK7. Los hallazgos descritos son los de un adenocarcinoma metastásico de origen colónico. Dentro de los estudios de extensión realizados se encontraba una colonoscopia que evidenció una lesión de aspecto neoplásico en el colon sigmoides.\nLa morfologia de este tumor es muy típica de los adenocarcinomas de colon (células altas, detritos intraluminales). Por otro lado la ausencia de CK7 en presencia de reactividad con CK20 y CDX-2 apoya este diagnóstico.\nLos principales diagnósticos diferenciales en este caso son los carcinomas metastásicos. Los carcinomas de origen pancreatobiliar pueden ser similares morfológicamente, pero usualmente se asocian a reactividad con CK7 y patrón de expresión de CDX2 variable (no todas las células positivas). La histología no favorece origen prostático, además estos tumores suelen ser CK7 y CK20 negativos.\nDentro de los tumores primarios pulmonares, el principal diagnóstico diferencial es el adenocarcinoma pulmonar, especialmente con patrón acinar. Estos tumores por lo general son lesiones únicas, aunque hay excepciones y metastásis intrapulmonares. El inmunoperfil de estos tumores es CK7 y TTF-1 positivo.', NULL, NULL, b'1'),
(309, 75, 'P2CITNGC2 (CITNG-222)', 'Caso Clínico 1', 'Paciente de 4 años con masa en fosa posterior', 'La preparación muestra abundantes células tumorales de pequeño a mediano tamaño con núcleos hipercromáticos y escaso citoplasma, y presencia de pleomórfismo nuclear leve. Los hallazgos morfológicos corresponden a compromiso por tumor de células redondas y azules.  El estudio histológico mostro un meduloblastoma. \r\n\r\nEl meduloblastoma es un tumor de célula pequeña pobremente diferenciado que se origina en el cerebelo, el cual compromete principalmente a la población pediátrica. Aproximadamente un 25% de pacientes con meduloblastoma tienen líquido cefalorraquídeo positivo, debido al compromiso de leptomeninges. Los meduloblastomas se caracterizan citomorfológicamente por la presencia de células pequeñas a medianas con núcleos hipercromáticos, escaso citoplasma y moldeamiento nuclear. En la variante de célula grande/anaplásica, puede observarse atipia citología severa con presencia de nucléolo prominente, cuerpos apoptóticos y mitosis. \r\n\r\nMorfológicamente, las células de meduloblastoma son indistinguibles de otras células tumorales pequeñas como por ejemplo el carcinoma de célula pequeña pulmonar. También el ependimoma anaplásico del cuarto ventrículo puede ser clínica y citológicamente indistinguible del meduloblastoma.', NULL, NULL, b'1'),
(310, 75, 'P2CITNGC2 (CITNG-225)', 'Caso Clínico 2', 'Paciente masculino de 68 años con nódulo tiroideo solido circunscrito de 2.3 cm', 'Extendido hipercelular con gran cantidad de células tumorales dispuestas en sabanas y sueltas con formas plasmocitoides y elongadas, con citoplasma eosinófilos y cromatina en patrón de sal y pimienta. En el fondo se ven gran cantidad de núcleos desnudos con las mismas características.  El estudio histológico mostro un carcinoma medular.\r\n\r\nEl carcinoma medular es una neoplasia neuroendocrina maligna derivada de las células parafoliculares (células C) de la glándula tiroides. Los aspirados muestran celularidad moderada a marcada, en su mayoría compuesta por células sueltas que alteran con algunos grupos sincitiales. Las células son plasmocitoides, poligonales, redondas o con forma elongada. Los núcleos son redondos, ovalados o elongados, frecuentemente excéntricos, con patrón de cromatina en “sal y pimienta”. Ocasionalmente se observan pseudoinclusiones nucleares, pero las hendiduras son inusuales. El citoplasma es granular y variable en cantidad. Frecuentemente se observa amiloide. Las células son positivas para calcitonina, CEA, marcadores neuroendocrinos (cromogranina, sinaptofisina), y negativas para tiroglobulina.', NULL, NULL, b'1');

CREATE TABLE `catalogo` (
  `id_catalogo` int(11) NOT NULL,
  `nombre_catalogo` varchar(255) NOT NULL,
  `id_distribuidor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_18';

CREATE TABLE `ciudad` (
  `id_ciudad` int(11) NOT NULL,
  `nombre_ciudad` varchar(255) NOT NULL,
  `id_pais` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_15';

CREATE TABLE `comparaciones_internacionales` (
  `id_comparaciones_internacionales` int(11) NOT NULL,
  `id_digitacion_uroanalisis` int(11) NOT NULL,
  `id_mesurando` int(11) NOT NULL,
  `id_mesurando_resultado_reporte_cualitativo` int(11) NOT NULL,
  `id_configuracion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `configuracion_analito_resultado_reporte_cualitativo` (
  `id_conexion` int(11) NOT NULL,
  `id_configuracion` int(11) NOT NULL,
  `id_analito_resultado_reporte_cualitativo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_28';

CREATE TABLE `configuracion_laboratorio_analito` (
  `id_configuracion` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `id_analizador` int(11) NOT NULL,
  `id_metodologia` int(11) NOT NULL,
  `id_reactivo` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_gen_vitros` int(11) NOT NULL,
  `id_material` int(11) DEFAULT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_47';

CREATE TABLE `contador_informe` (
  `id_contador` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `valor_contador_original` int(11) NOT NULL,
  `valor_contador_actualizado` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_37';

CREATE TABLE `contador_muestra` (
  `id_conexion` int(11) NOT NULL,
  `id_ronda` int(11) NOT NULL,
  `id_muestra` int(11) NOT NULL,
  `no_contador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_14';

CREATE TABLE `digitacion` (
  `id_digitacion` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `mes` date NOT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `digitaciones_uroanalisis` (
  `id_digitaciones_uroanalisis` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_lote` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE `digitacion_cuantitativa` (
  `id_digitacion_cuantitativa` int(11) NOT NULL,
  `id_digitacion` int(11) NOT NULL,
  `tipo_digitacion` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `id_analizador` int(11) NOT NULL,
  `id_reactivo` int(11) NOT NULL,
  `id_metodologia` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_unidad_mc` int(11) DEFAULT NULL,
  `id_gen_vitros` int(11) NOT NULL,
  `media_mensual` char(255) DEFAULT NULL,
  `de_mensual` char(255) DEFAULT NULL,
  `cv_mensual` char(255) DEFAULT NULL,
  `n_lab_mensual` char(255) DEFAULT NULL,
  `n_puntos_mensual` char(255) DEFAULT NULL,
  `media_acumulada` char(255) DEFAULT NULL,
  `de_acumulada` char(255) DEFAULT NULL,
  `cv_acumulada` char(255) DEFAULT NULL,
  `n_lab_acumulada` char(255) DEFAULT NULL,
  `n_puntos_acumulada` char(255) DEFAULT NULL,
  `media_jctlm` char(255) DEFAULT NULL,
  `etmp_jctlm` char(255) DEFAULT NULL,
  `media_inserto` char(255) DEFAULT NULL,
  `de_inserto` char(255) DEFAULT NULL,
  `cv_inserto` char(255) DEFAULT NULL,
  `n_inserto` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `digitacion_resultados_verdaderos` (
  `id` int(11) NOT NULL,
  `id_digitacion_uroanalisis` int(11) NOT NULL,
  `id_configuracion` int(11) DEFAULT NULL,
  `mesurando_id` int(11) NOT NULL,
  `mesurando_resultado_reporte_cualitativo_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci;

CREATE TABLE `distractor` (
  `id_distractor` int(11) NOT NULL,
  `pregunta_id_pregunta` int(11) NOT NULL,
  `abreviatura` varchar(45) DEFAULT NULL,
  `nombre` varchar(400) NOT NULL COMMENT 'Nombre de la posible respuesta.',
  `valor` decimal(6,3) NOT NULL COMMENT 'Si el valor es booleano se asigna un 1.0, de lo contrario se asigna el valor correspondiente en decimales.',
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `distribuidor` (
  `id_distribuidor` int(11) NOT NULL,
  `nombre_distribuidor` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_06';

CREATE TABLE `fecha_reporte_muestra` (
  `id_fecha` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `id_muestra` int(11) NOT NULL,
  `fecha_reporte` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_38';

CREATE TABLE `gen_vitros` (
  `id_gen_vitros` int(11) NOT NULL,
  `valor_gen_vitros` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_12';

CREATE TABLE `grupo` (
  `id_grupo` int(11) NOT NULL,
  `caso_clinico_id_caso_clinico` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `imagen_adjunta` (
  `id_imagen_adjunta` int(11) NOT NULL,
  `caso_clinico_id_caso_clinico` int(11) NOT NULL,
  `tipo` tinyint(4) NOT NULL COMMENT 'Si la imagen es del enunciado o de la revision',
  `ruta` varchar(450) NOT NULL,
  `nombre` varchar(450) NOT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `intento` (
  `id_intento` int(11) NOT NULL,
  `laboratorio_id_laboratorio` int(11) NOT NULL,
  `usuario_id_usuario` int(11) NOT NULL,
  `reto_id_reto` int(11) NOT NULL,
  `comentario` mediumtext,
  `fecha` datetime NOT NULL COMMENT 'Fecha cuando se realizo el intento',
  `revaloracion` bit(1) NOT NULL DEFAULT b'0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `intento_temporal` (
  `id_intento` int(11) NOT NULL,
  `laboratorio_id_laboratorio` int(11) NOT NULL,
  `usuario_id_usuario` int(11) NOT NULL,
  `reto_id_reto` int(11) NOT NULL,
  `comentario` mediumtext,
  `fecha` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Aquí se guardarán los intentos incompletos, por si se desea guardar temporalmente la información de un reto.';

CREATE TABLE `laboratorio` (
  `id_laboratorio` int(11) NOT NULL,
  `no_laboratorio` varchar(255) NOT NULL,
  `nombre_laboratorio` varchar(255) DEFAULT NULL,
  `direccion_laboratorio` varchar(255) DEFAULT NULL,
  `telefono_laboratorio` varchar(255) DEFAULT NULL,
  `correo_laboratorio` varchar(255) DEFAULT NULL,
  `contacto_laboratorio` varchar(255) DEFAULT NULL,
  `id_ciudad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_17';

CREATE TABLE `limite_evaluacion` (
  `id_limite` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `id_opcion_limite` int(11) NOT NULL,
  `limite` varchar(255) NOT NULL,
  `id_calculo_limite_evaluacion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_32';

CREATE TABLE `log` (
  `id_log` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `fecha` date NOT NULL,
  `hora` time NOT NULL,
  `log` text NOT NULL,
  `query` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_34';

CREATE TABLE `log_configuracion_analito` (
  `id_log_configuracion_analito` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `fecha` datetime NOT NULL,
  `nombre_usuario` varchar(45) NOT NULL,
  `titulo` varchar(30) NOT NULL,
  `resumen` varchar(455) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `lote` (
  `id_lote` int(11) NOT NULL,
  `nombre_lote` varchar(255) DEFAULT NULL,
  `nivel_lote` varchar(255) DEFAULT NULL,
  `estado_lote` int(11) NOT NULL,
  `id_catalogo` int(11) NOT NULL,
  `nombre_lote_qap` varchar(255) DEFAULT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_19';

CREATE TABLE `lote_pat` (
  `id_lote_pat` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `material` (
  `id_material` int(11) NOT NULL,
  `nombre_material` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_44';

CREATE TABLE `material_jctlm` (
  `id_material_jctlm` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `desc_material_jctlm` varchar(255) DEFAULT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_43';

CREATE TABLE `material_jctlm_emparejado` (
  `id_conexion` int(11) NOT NULL,
  `id_material_jctlm` int(11) NOT NULL,
  `id_material` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_46';

CREATE TABLE `media_evaluacion` (
  `id_media_analito` int(11) NOT NULL,
  `id_configuracion` int(11) NOT NULL,
  `media_estandar` char(255) NOT NULL,
  `desviacion_estandar` char(255) NOT NULL,
  `coeficiente_variacion` char(255) NOT NULL,
  `n_evaluacion` char(255) NOT NULL,
  `id_muestra` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `id_analito_resultado_reporte_cualitativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `media_evaluacion_caso_especial` (
  `id_media_analito` int(11) NOT NULL,
  `id_configuracion` int(11) NOT NULL,
  `media_estandar` char(255) NOT NULL,
  `desviacion_estandar` char(255) NOT NULL,
  `coeficiente_variacion` char(255) NOT NULL,
  `n_evaluacion` char(255) NOT NULL,
  `id_muestra` int(11) NOT NULL,
  `nivel` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `id_analito_resultado_reporte_cualitativo` int(11) DEFAULT NULL,
  `id_digitacion_wwr` int(11) DEFAULT NULL,
  `tipo_digitacion_wwr` tinyint(4) DEFAULT NULL,
  `tipo_consenso_wwr` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_30';

CREATE TABLE `mesurando_valores` (
  `id_mesurando_valores` int(11) NOT NULL,
  `id_digitaciones_uroanalisis` int(11) NOT NULL,
  `id_mesurando` int(11) NOT NULL,
  `numero_lab` int(11) NOT NULL,
  `numero_points` int(11) NOT NULL,
  `id_configuracion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `metodologia` (
  `id_metodologia` int(11) NOT NULL,
  `nombre_metodologia` varchar(255) NOT NULL,
  `cod_metodologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_05';

CREATE TABLE `metodologia_analizador` (
  `id_conexion` int(11) NOT NULL,
  `id_metodologia` int(11) NOT NULL,
  `id_analizador` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_22';

CREATE TABLE `metodo_jctlm` (
  `id_metodo_jctlm` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `desc_metodo_jctlm` varchar(255) DEFAULT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_42';

CREATE TABLE `metodo_jctlm_emparejado` (
  `id_conexion` int(11) NOT NULL,
  `id_metodo_jctlm` int(11) NOT NULL,
  `id_metodologia` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_45';

CREATE TABLE `misc` (
  `id_misc` int(11) NOT NULL,
  `titulo_misc` varchar(255) NOT NULL,
  `valor_misc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_40';

CREATE TABLE `muestra` (
  `id_muestra` int(11) NOT NULL,
  `codigo_muestra` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_10';

CREATE TABLE `muestra_programa` (
  `id_muestra_programa` int(11) NOT NULL,
  `id_muestra` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_lote` int(11) NOT NULL,
  `fecha_vencimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_23';

CREATE TABLE `opcion_limite` (
  `id_opcion_limite` int(11) NOT NULL,
  `nombre_opcion_limite` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_16';

CREATE TABLE `pais` (
  `id_pais` int(11) NOT NULL,
  `nombre_pais` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_02';

CREATE TABLE `pregunta` (
  `id_pregunta` int(15) NOT NULL,
  `grupo_id_grupo` int(11) NOT NULL,
  `nombre` varchar(400) NOT NULL,
  `intervalo_min` decimal(8,3) DEFAULT NULL,
  `intervalo_max` decimal(8,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `programa` (
  `id_programa` int(11) NOT NULL,
  `nombre_programa` varchar(255) NOT NULL,
  `sigla_programa` varchar(255) NOT NULL,
  `tipo_muestra` varchar(255) NOT NULL,
  `modalidad_muestra` varchar(255) NOT NULL,
  `no_muestras` varchar(255) NOT NULL,
  `id_tipo_programa` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_09';

CREATE TABLE `programa_analito` (
  `id_conexion` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_25';

CREATE TABLE `programa_laboratorio` (
  `id_conexion` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `activo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_24';

CREATE TABLE `programa_pat` (
  `id_programa` int(11) NOT NULL,
  `sigla` varchar(45) NOT NULL,
  `nombre` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `puntuaciones` (
  `id` int(11) NOT NULL,
  `valor` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `reactivo` (
  `id_reactivo` int(11) NOT NULL,
  `nombre_reactivo` varchar(255) NOT NULL,
  `cod_reactivo` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_11';

CREATE TABLE `referencia` (
  `id_referencia` int(11) NOT NULL,
  `caso_clinico_id_caso_clinico` int(11) NOT NULL,
  `descripcion` varchar(450) NOT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `respuesta_lab` (
  `id_respuesta_lab` int(11) NOT NULL,
  `intento_id_intento` int(11) NOT NULL,
  `pregunta_id_pregunta` int(11) NOT NULL,
  `distractor_id_distractor` int(11) DEFAULT NULL,
  `respuesta_cuantitativa` decimal(7,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `respuesta_lab_temporal` (
  `id_respuesta_lab` int(11) NOT NULL,
  `intento_id_intento` int(11) NOT NULL,
  `pregunta_id_pregunta` int(11) NOT NULL,
  `distractor_id_distractor` int(11) DEFAULT NULL,
  `respuesta_cuantitativa` decimal(7,3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Aqui se guardaran las respuestas temporales de un intento';

CREATE TABLE `resultado` (
  `id_resultado` int(11) NOT NULL,
  `id_muestra` int(11) NOT NULL,
  `id_configuracion` int(11) NOT NULL,
  `fecha_resultado` date NOT NULL,
  `valor_resultado` varchar(255) DEFAULT NULL,
  `observacion_resultado` text,
  `editado` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `revalorado` int(11) NOT NULL,
  `id_analito_resultado_reporte_cualitativo` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_48';

CREATE TABLE `resultados_vav` (
  `id_resultados_vav` int(11) NOT NULL,
  `id_digitaciones_uroanalisis` int(11) NOT NULL,
  `id_mesurando` int(11) NOT NULL,
  `id_mesurando_resultado_reporte_cualitativo` int(11) NOT NULL,
  `id_configuracion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `reto` (
  `id_reto` int(11) NOT NULL,
  `programa_pat_id_programa` int(11) NOT NULL,
  `lote_pat_id_lote_pat` int(11) DEFAULT NULL,
  `nombre` varchar(45) NOT NULL,
  `estado` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Asignacion de retos: ejemplo A, B, C, D para inmunohistoquimica.';

CREATE TABLE `reto_laboratorio` (
  `id_reto_laboratorio` int(11) NOT NULL,
  `laboratorio_id_laboratorio` int(11) NOT NULL,
  `reto_id_reto` int(11) NOT NULL,
  `envio` int(11) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ronda` (
  `id_ronda` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL,
  `no_ronda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_13';

CREATE TABLE `ronda_laboratorio` (
  `id_ronda_laboratorio` int(11) NOT NULL,
  `id_ronda` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_33';

CREATE TABLE `sesion` (
  `id_sesion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `token_sesion` char(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_35';

CREATE TABLE `temp_configuraciones_cuali_definitivas` (
  `id_ccd` int(11) NOT NULL,
  `id_configuracion_ccd` int(11) DEFAULT NULL,
  `id_analito_resultado_reporte_cualitativo_ccd` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `temp_media_definitiva` (
  `id_md` int(11) NOT NULL,
  `id_configuracion_md` int(11) DEFAULT NULL,
  `media_estandar_md` char(255) DEFAULT NULL,
  `desviacion_estandar_md` char(255) DEFAULT NULL,
  `coeficiente_variacion_md` char(255) DEFAULT NULL,
  `n_evaluacion_md` char(255) DEFAULT NULL,
  `id_muestra_md` int(11) DEFAULT NULL,
  `nivel_md` int(11) DEFAULT NULL,
  `id_laboratorio_md` int(11) DEFAULT NULL,
  `id_analito_resultado_reporte_cualitativo_md` int(11) DEFAULT NULL,
  `id_digitacion_wwr_md` int(11) DEFAULT NULL,
  `tipo_digitacion_wwr_md` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `temp_pdf` (
  `id_temp_pdf` int(15) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `html_content` longtext NOT NULL,
  `pdf_token` char(255) NOT NULL,
  `pdf_status` int(11) NOT NULL,
  `fecha` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_36';

CREATE TABLE `temp_valor_referencia` (
  `id_tvr` int(11) NOT NULL,
  `id_laboratorio_tvr` int(11) DEFAULT NULL,
  `id_muestra_tvr` int(11) DEFAULT NULL,
  `id_analito_tvr` int(11) DEFAULT NULL,
  `id_unidad_tvr` int(11) DEFAULT NULL,
  `id_metodologia_tvr` int(11) DEFAULT NULL,
  `valor_metodo_referencia` varchar(255) DEFAULT NULL,
  `id_digitacion_wwr_md` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `tipo_estado_reporte` (
  `id_tipo_estado_reporte` int(11) NOT NULL,
  `desc_tipo_estado_reporte` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_41';

CREATE TABLE `tipo_programa` (
  `id_tipo_programa` int(11) NOT NULL,
  `desc_tipo_programa` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_08';

CREATE TABLE `unidad` (
  `id_unidad` int(11) NOT NULL,
  `nombre_unidad` varchar(255) NOT NULL,
  `cod_unidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_04';

CREATE TABLE `unidad_analizador` (
  `id_conexion` int(11) NOT NULL,
  `id_analizador` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_21';

CREATE TABLE `unidad_global_analito` (
  `id_conexion` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `nombre_unidad_global` varchar(255) DEFAULT NULL,
  `factor_conversion` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_49';

CREATE TABLE `usuario` (
  `id_usuario` int(11) NOT NULL,
  `nombre_usuario` varchar(255) NOT NULL,
  `contrasena` char(255) NOT NULL,
  `nombre_completo` varchar(100) DEFAULT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `cod_usuario` varchar(45) DEFAULT NULL,
  `email_usuario` varchar(255) DEFAULT NULL,
  `passwordchange_lastupdateddate` date DEFAULT NULL,
  `passwordchange_lastupdatedhour` time DEFAULT NULL,
  `passwordchange_lastupdatedip` char(255) DEFAULT NULL,
  `passwordchange_lastupdatedbrowser` varchar(255) DEFAULT NULL,
  `estado` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_01';

CREATE TABLE `usuario_laboratorio` (
  `id_conexion` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_20';

CREATE TABLE `valor_metodo_referencia` (
  `id_valor_metodo_referencia` int(11) NOT NULL,
  `id_laboratorio` int(11) NOT NULL,
  `id_muestra` int(11) NOT NULL,
  `id_analito` int(11) NOT NULL,
  `id_unidad` int(11) NOT NULL,
  `id_metodologia` int(11) NOT NULL,
  `valor_metodo_referencia` varchar(255) DEFAULT NULL,
  `id_digitacion_jctlm` int(11) DEFAULT NULL,
  `id_configuracion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='tbl_39';

ALTER TABLE `analito`
  ADD PRIMARY KEY (`id_analito`);

ALTER TABLE `analito_resultado_reporte_cualitativo`
  ADD PRIMARY KEY (`id_analito_resultado_reporte_cualitativo`),
  ADD KEY `fk_analito_resultado_reporte_cualitativo_analito2_idx` (`id_analito`),
  ADD KEY `idx_id_puntuacion` (`id_puntuacion`);

ALTER TABLE `analizador`
  ADD PRIMARY KEY (`id_analizador`),
  ADD UNIQUE KEY `cod_analizador_UNIQUE` (`cod_analizador`);

ALTER TABLE `archivo`
  ADD PRIMARY KEY (`id_archivo`),
  ADD KEY `fk_archivo_laboratorio_idx` (`id_laboratorio`),
  ADD KEY `fk_archivo_ronda_idx` (`id_ronda`),
  ADD KEY `fk_archivo_reto_idx` (`id_reto`);

ALTER TABLE `calculo_limite_evaluacion`
  ADD PRIMARY KEY (`id_calculo_limite_evaluacion`);

ALTER TABLE `caso_clinico`
  ADD PRIMARY KEY (`id_caso_clinico`),
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`),
  ADD KEY `fk_caso_clinico_reto1_idx` (`reto_id_reto`);

ALTER TABLE `catalogo`
  ADD PRIMARY KEY (`id_catalogo`),
  ADD KEY `fk_catalogo_distribuidor1_idx` (`id_distribuidor`);

ALTER TABLE `ciudad`
  ADD PRIMARY KEY (`id_ciudad`),
  ADD KEY `fk_ciudad_pais1_idx` (`id_pais`);

ALTER TABLE `comparaciones_internacionales`
  ADD PRIMARY KEY (`id_comparaciones_internacionales`),
  ADD KEY `fk_comparaciones_internacionales_id_configuracion` (`id_configuracion`),
  ADD KEY `fk_comparaciones_internacionales_digitacion` (`id_digitacion_uroanalisis`) USING BTREE,
  ADD KEY `fk_comparaciones_internacionales_mesurando` (`id_mesurando`) USING BTREE,
  ADD KEY `fk_comparaciones_internacionales_resultado` (`id_mesurando_resultado_reporte_cualitativo`) USING BTREE;

ALTER TABLE `configuracion_analito_resultado_reporte_cualitativo`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_configuracion_analito_resultado_reporte_cualitativo_anal_idx1` (`id_analito_resultado_reporte_cualitativo`),
  ADD KEY `fk_configuracion_analito_resultado_reporte_cualitativo_conf_idx` (`id_configuracion`);

ALTER TABLE `configuracion_laboratorio_analito`
  ADD PRIMARY KEY (`id_configuracion`),
  ADD KEY `fk_configuracion_laboratorio_analito_laboratorio1_idx` (`id_laboratorio`),
  ADD KEY `fk_configuracion_laboratorio_analito_programa1_idx` (`id_programa`),
  ADD KEY `fk_configuracion_laboratorio_analito_analito1_idx` (`id_analito`),
  ADD KEY `fk_configuracion_laboratorio_analito_analizador1_idx` (`id_analizador`),
  ADD KEY `fk_configuracion_laboratorio_analito_metodologia1_idx` (`id_metodologia`),
  ADD KEY `fk_configuracion_laboratorio_analito_reactivo1_idx` (`id_reactivo`),
  ADD KEY `fk_configuracion_laboratorio_analito_unidad1_idx` (`id_unidad`),
  ADD KEY `fk_configuracion_laboratorio_analito_gen_vitros1_idx` (`id_gen_vitros`),
  ADD KEY `fk_configuracion_laboratorio_analito_material1_idx` (`id_material`);

ALTER TABLE `contador_informe`
  ADD PRIMARY KEY (`id_contador`),
  ADD KEY `fk_contador_informe_laboratorio1_idx` (`id_laboratorio`);

ALTER TABLE `contador_muestra`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_contador_muestra_ronda1_idx` (`id_ronda`),
  ADD KEY `fk_contador_muestra_muestra1_idx` (`id_muestra`);

ALTER TABLE `digitacion`
  ADD PRIMARY KEY (`id_digitacion`),
  ADD KEY `fk_digitacion_lote1_idx` (`id_lote`),
  ADD KEY `fk_digitacion_programa1_idx` (`id_programa`);

ALTER TABLE `digitaciones_uroanalisis`
  ADD PRIMARY KEY (`id_digitaciones_uroanalisis`),
  ADD KEY `fk_digitaciones_uroanalisis_2_lab` (`id_laboratorio`),
  ADD KEY `fk_digitaciones_uroanalisis_2_programa` (`id_programa`),
  ADD KEY `idx_lote` (`id_lote`);

ALTER TABLE `digitacion_cuantitativa`
  ADD PRIMARY KEY (`id_digitacion_cuantitativa`),
  ADD KEY `fk_digitacion_cuantitativa_digitacion1_idx` (`id_digitacion`),
  ADD KEY `fk_digitacion_cuantitativa_analito1_idx` (`id_analito`),
  ADD KEY `fk_digitacion_cuantitativa_analizador1_idx` (`id_analizador`),
  ADD KEY `fk_digitacion_cuantitativa_reactivo1_idx` (`id_reactivo`),
  ADD KEY `fk_digitacion_cuantitativa_metodologia1_idx` (`id_metodologia`),
  ADD KEY `fk_digitacion_cuantitativa_gen_vitros1_idx` (`id_gen_vitros`),
  ADD KEY `fk_digitacion_cuantitativa_unidad1_idx` (`id_unidad`);

ALTER TABLE `digitacion_resultados_verdaderos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_digitacion_resultados_verdaderos_mesurando` (`mesurando_id`),
  ADD KEY `fk_digitacion_resultados_verdaderos_cualitativo` (`mesurando_resultado_reporte_cualitativo_id`),
  ADD KEY `idx_digitacion_uroanalisis` (`id_digitacion_uroanalisis`),
  ADD KEY `fk_digitacion_resultados_verdaderos_id_configuracion` (`id_configuracion`);

ALTER TABLE `distractor`
  ADD PRIMARY KEY (`id_distractor`),
  ADD KEY `fk_distractor_pregunta1_idx` (`pregunta_id_pregunta`);

ALTER TABLE `distribuidor`
  ADD PRIMARY KEY (`id_distribuidor`);

ALTER TABLE `fecha_reporte_muestra`
  ADD PRIMARY KEY (`id_fecha`),
  ADD KEY `fk_fecha_reporte_muestra_laboratorio1_idx` (`id_laboratorio`),
  ADD KEY `fk_fecha_reporte_muestra_muestra1_idx` (`id_muestra`);

ALTER TABLE `gen_vitros`
  ADD PRIMARY KEY (`id_gen_vitros`);

ALTER TABLE `grupo`
  ADD PRIMARY KEY (`id_grupo`),
  ADD KEY `fk_grupo_caso_clinico1_idx` (`caso_clinico_id_caso_clinico`);

ALTER TABLE `imagen_adjunta`
  ADD PRIMARY KEY (`id_imagen_adjunta`),
  ADD KEY `fk_imagen_adjunta_caso_clinico1_idx` (`caso_clinico_id_caso_clinico`);

ALTER TABLE `intento`
  ADD PRIMARY KEY (`id_intento`),
  ADD KEY `fk_itento_laboratorio1_idx` (`laboratorio_id_laboratorio`),
  ADD KEY `fk_itento_usuario1_idx` (`usuario_id_usuario`),
  ADD KEY `fk_intento_reto1_idx` (`reto_id_reto`);

ALTER TABLE `intento_temporal`
  ADD PRIMARY KEY (`id_intento`),
  ADD KEY `reto_fk_idx` (`reto_id_reto`),
  ADD KEY `laboratorio_fk_idx` (`laboratorio_id_laboratorio`),
  ADD KEY `usuario_fk_idx` (`usuario_id_usuario`);

ALTER TABLE `laboratorio`
  ADD PRIMARY KEY (`id_laboratorio`),
  ADD KEY `fk_laboratorio_ciudad1_idx` (`id_ciudad`);

ALTER TABLE `limite_evaluacion`
  ADD PRIMARY KEY (`id_limite`),
  ADD KEY `fk_limite_evaluacion_analito1_idx` (`id_analito`),
  ADD KEY `fk_limite_evaluacion_opcion_limite1_idx` (`id_opcion_limite`),
  ADD KEY `fk_limite_evaluacion_calculo_limite_evaluacion1_idx` (`id_calculo_limite_evaluacion`);

ALTER TABLE `log`
  ADD PRIMARY KEY (`id_log`);

ALTER TABLE `log_configuracion_analito`
  ADD PRIMARY KEY (`id_log_configuracion_analito`);

ALTER TABLE `lote`
  ADD PRIMARY KEY (`id_lote`),
  ADD KEY `fk_lote_catalogo1_idx` (`id_catalogo`);

ALTER TABLE `lote_pat`
  ADD PRIMARY KEY (`id_lote_pat`);

ALTER TABLE `material`
  ADD PRIMARY KEY (`id_material`);

ALTER TABLE `material_jctlm`
  ADD PRIMARY KEY (`id_material_jctlm`),
  ADD KEY `fk_material_jctlm_analito1_idx` (`id_analito`);

ALTER TABLE `material_jctlm_emparejado`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_material_jctlm_emparejado_material_jctlm1_idx` (`id_material_jctlm`),
  ADD KEY `fk_material_jctlm_emparejado_material1_idx` (`id_material`);

ALTER TABLE `media_evaluacion`
  ADD PRIMARY KEY (`id_media_analito`),
  ADD KEY `id_configuracion` (`id_configuracion`),
  ADD KEY `id_muestra` (`id_muestra`),
  ADD KEY `id_analito_resultado_reporte_cualitativo` (`id_analito_resultado_reporte_cualitativo`);

ALTER TABLE `media_evaluacion_caso_especial`
  ADD PRIMARY KEY (`id_media_analito`),
  ADD KEY `fk_media_evaluacion_caso_especial_configuracion_laboratorio_idx1` (`id_configuracion`),
  ADD KEY `fk_media_evaluacion_caso_especial_muestra1_idx` (`id_muestra`),
  ADD KEY `fk_media_evaluacion_caso_especial_laboratorio1_idx` (`id_laboratorio`),
  ADD KEY `fk_media_evaluacion_caso_especial_analito_resultado_reporte_idx` (`id_analito_resultado_reporte_cualitativo`);

ALTER TABLE `mesurando_valores`
  ADD PRIMARY KEY (`id_mesurando_valores`),
  ADD KEY `fk_mesurando_valores_id_configuracion` (`id_configuracion`),
  ADD KEY `fk_mesurando_valores_analito` (`id_mesurando`) USING BTREE,
  ADD KEY `fk_mesurando_valores_digitacion` (`id_digitaciones_uroanalisis`) USING BTREE;

ALTER TABLE `metodologia`
  ADD PRIMARY KEY (`id_metodologia`);

ALTER TABLE `metodologia_analizador`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_metodologia_analizador_metodologia1_idx` (`id_metodologia`),
  ADD KEY `fk_metodologia_analizador_analizador1_idx` (`id_analizador`);

ALTER TABLE `metodo_jctlm`
  ADD PRIMARY KEY (`id_metodo_jctlm`),
  ADD KEY `fk_metodo_jctlm_analito1_idx` (`id_analito`);

ALTER TABLE `metodo_jctlm_emparejado`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_metodo_jctlm_emparejado_metodo_jctlm1_idx` (`id_metodo_jctlm`),
  ADD KEY `fk_metodo_jctlm_emparejado_metodologia1_idx` (`id_metodologia`);

ALTER TABLE `misc`
  ADD PRIMARY KEY (`id_misc`);

ALTER TABLE `muestra`
  ADD PRIMARY KEY (`id_muestra`);

ALTER TABLE `muestra_programa`
  ADD PRIMARY KEY (`id_muestra_programa`),
  ADD KEY `fk_muestra_programa_muestra1_idx` (`id_muestra`),
  ADD KEY `fk_muestra_programa_programa1_idx` (`id_programa`),
  ADD KEY `fk_muestra_programa_lote1_idx` (`id_lote`);

ALTER TABLE `opcion_limite`
  ADD PRIMARY KEY (`id_opcion_limite`);

ALTER TABLE `pais`
  ADD PRIMARY KEY (`id_pais`);

ALTER TABLE `pregunta`
  ADD PRIMARY KEY (`id_pregunta`),
  ADD KEY `fk_pregunta_grupo1_idx` (`grupo_id_grupo`);

ALTER TABLE `programa`
  ADD PRIMARY KEY (`id_programa`),
  ADD KEY `fk_programa_tipo_programa1_idx` (`id_tipo_programa`);

ALTER TABLE `programa_analito`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_programa_analito_programa1_idx` (`id_programa`),
  ADD KEY `fk_programa_analito_analito1_idx` (`id_analito`);

ALTER TABLE `programa_laboratorio`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_programa_laboratorio_programa1_idx` (`id_programa`),
  ADD KEY `fk_programa_laboratorio_laboratorio1_idx` (`id_laboratorio`);

ALTER TABLE `programa_pat`
  ADD PRIMARY KEY (`id_programa`);

ALTER TABLE `puntuaciones`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `reactivo`
  ADD PRIMARY KEY (`id_reactivo`),
  ADD UNIQUE KEY `cod_reactivo_UNIQUE` (`cod_reactivo`);

ALTER TABLE `referencia`
  ADD PRIMARY KEY (`id_referencia`),
  ADD KEY `fk_referencia_caso_clinico1_idx` (`caso_clinico_id_caso_clinico`);

ALTER TABLE `respuesta_lab`
  ADD PRIMARY KEY (`id_respuesta_lab`),
  ADD KEY `fk_respuesta_lab_distractor1_idx` (`distractor_id_distractor`),
  ADD KEY `fk_respuesta_lab_intento1_idx` (`intento_id_intento`),
  ADD KEY `fk_respuesta_lab_pregunta1_idx` (`pregunta_id_pregunta`);

ALTER TABLE `respuesta_lab_temporal`
  ADD PRIMARY KEY (`id_respuesta_lab`),
  ADD KEY `fk_distractor_idx` (`distractor_id_distractor`),
  ADD KEY `fk_intento_idx` (`intento_id_intento`),
  ADD KEY `fk_pregunta_idx` (`pregunta_id_pregunta`);

ALTER TABLE `resultado`
  ADD PRIMARY KEY (`id_resultado`),
  ADD KEY `fk_resultado_muestra1_idx` (`id_muestra`),
  ADD KEY `fk_resultado_configuracion_laboratorio_analito1_idx` (`id_configuracion`),
  ADD KEY `fk_resultado_usuario1_idx` (`id_usuario`),
  ADD KEY `fk_resultado_analito_resultado_reporte_cualitativo1_idx` (`id_analito_resultado_reporte_cualitativo`);

ALTER TABLE `resultados_vav`
  ADD PRIMARY KEY (`id_resultados_vav`),
  ADD KEY `fk_resultados_vav_resultado_id_configuracion` (`id_configuracion`),
  ADD KEY `fk_resultados_vav_digitacion` (`id_digitaciones_uroanalisis`) USING BTREE,
  ADD KEY `fk_resultados_vav_analito` (`id_mesurando`) USING BTREE,
  ADD KEY `fk_resultados_vav_resultado_cualitativo` (`id_mesurando_resultado_reporte_cualitativo`) USING BTREE;

ALTER TABLE `reto`
  ADD PRIMARY KEY (`id_reto`),
  ADD KEY `fk_programa_pat_has_reto_programa_pat1_idx` (`programa_pat_id_programa`),
  ADD KEY `fk_reto_lote_pat1_idx` (`lote_pat_id_lote_pat`);

ALTER TABLE `reto_laboratorio`
  ADD PRIMARY KEY (`id_reto_laboratorio`),
  ADD KEY `fk_reto_laboratorio_laboratorio1_idx` (`laboratorio_id_laboratorio`),
  ADD KEY `fk_reto_laboratorio_reto1_idx` (`reto_id_reto`);

ALTER TABLE `ronda`
  ADD PRIMARY KEY (`id_ronda`),
  ADD KEY `fk_ronda_programa1_idx` (`id_programa`);

ALTER TABLE `ronda_laboratorio`
  ADD PRIMARY KEY (`id_ronda_laboratorio`),
  ADD KEY `fk_ronda_laboratorio_ronda1_idx` (`id_ronda`),
  ADD KEY `fk_ronda_laboratorio_laboratorio1_idx` (`id_laboratorio`);

ALTER TABLE `sesion`
  ADD PRIMARY KEY (`id_sesion`),
  ADD KEY `fk_sesion_usuario1_idx` (`id_usuario`);

ALTER TABLE `temp_configuraciones_cuali_definitivas`
  ADD PRIMARY KEY (`id_ccd`);

ALTER TABLE `temp_media_definitiva`
  ADD PRIMARY KEY (`id_md`);

ALTER TABLE `temp_pdf`
  ADD PRIMARY KEY (`id_temp_pdf`);

ALTER TABLE `temp_valor_referencia`
  ADD PRIMARY KEY (`id_tvr`);

ALTER TABLE `tipo_estado_reporte`
  ADD PRIMARY KEY (`id_tipo_estado_reporte`);

ALTER TABLE `tipo_programa`
  ADD PRIMARY KEY (`id_tipo_programa`);

ALTER TABLE `unidad`
  ADD PRIMARY KEY (`id_unidad`),
  ADD UNIQUE KEY `cod_unidad_UNIQUE` (`cod_unidad`);

ALTER TABLE `unidad_analizador`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_unidad_analizador_analizador1_idx` (`id_analizador`),
  ADD KEY `fk_unidad_analizador_unidad1_idx` (`id_unidad`);

ALTER TABLE `unidad_global_analito`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_unidad_global_analito_unidad1_idx` (`id_unidad`),
  ADD KEY `fk_unidad_global_analito_analito1_idx` (`id_analito`);

ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `cod_usuario_UNIQUE` (`cod_usuario`) USING BTREE;

ALTER TABLE `usuario_laboratorio`
  ADD PRIMARY KEY (`id_conexion`),
  ADD KEY `fk_usuario_laboratorio_usuario1_idx` (`id_usuario`),
  ADD KEY `fk_usuario_laboratorio_laboratorio1_idx` (`id_laboratorio`);

ALTER TABLE `valor_metodo_referencia`
  ADD PRIMARY KEY (`id_valor_metodo_referencia`),
  ADD KEY `fk_valor_metodo_referencia_analito1_idx` (`id_analito`),
  ADD KEY `fk_valor_metodo_referencia_metodologia1_idx` (`id_metodologia`),
  ADD KEY `fk_valor_metodo_referencia_muestra1_idx` (`id_muestra`),
  ADD KEY `fk_valor_metodo_referencia_unidad1_idx` (`id_unidad`),
  ADD KEY `fk_valor_metodo_referencia_laboratorio1_idx` (`id_laboratorio`);

ALTER TABLE `analito`
  MODIFY `id_analito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=355;

ALTER TABLE `analito_resultado_reporte_cualitativo`
  MODIFY `id_analito_resultado_reporte_cualitativo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=559;

ALTER TABLE `analizador`
  MODIFY `id_analizador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=495;

ALTER TABLE `archivo`
  MODIFY `id_archivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6587;

ALTER TABLE `calculo_limite_evaluacion`
  MODIFY `id_calculo_limite_evaluacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `caso_clinico`
  MODIFY `id_caso_clinico` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=319;

ALTER TABLE `catalogo`
  MODIFY `id_catalogo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

ALTER TABLE `ciudad`
  MODIFY `id_ciudad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

ALTER TABLE `comparaciones_internacionales`
  MODIFY `id_comparaciones_internacionales` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=790;

ALTER TABLE `configuracion_analito_resultado_reporte_cualitativo`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9429;

ALTER TABLE `configuracion_laboratorio_analito`
  MODIFY `id_configuracion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8140;

ALTER TABLE `contador_informe`
  MODIFY `id_contador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

ALTER TABLE `contador_muestra`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1631;

ALTER TABLE `digitacion`
  MODIFY `id_digitacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=242;

ALTER TABLE `digitaciones_uroanalisis`
  MODIFY `id_digitaciones_uroanalisis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

ALTER TABLE `digitacion_cuantitativa`
  MODIFY `id_digitacion_cuantitativa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10424;

ALTER TABLE `digitacion_resultados_verdaderos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3050;

ALTER TABLE `distractor`
  MODIFY `id_distractor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9266;

ALTER TABLE `distribuidor`
  MODIFY `id_distribuidor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `fecha_reporte_muestra`
  MODIFY `id_fecha` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4639;

ALTER TABLE `gen_vitros`
  MODIFY `id_gen_vitros` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

ALTER TABLE `grupo`
  MODIFY `id_grupo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=512;

ALTER TABLE `imagen_adjunta`
  MODIFY `id_imagen_adjunta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

ALTER TABLE `intento`
  MODIFY `id_intento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=821;

ALTER TABLE `intento_temporal`
  MODIFY `id_intento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=224;

ALTER TABLE `laboratorio`
  MODIFY `id_laboratorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=313;

ALTER TABLE `limite_evaluacion`
  MODIFY `id_limite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=629;

ALTER TABLE `log`
  MODIFY `id_log` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=440578;

ALTER TABLE `log_configuracion_analito`
  MODIFY `id_log_configuracion_analito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11997;

ALTER TABLE `lote`
  MODIFY `id_lote` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

ALTER TABLE `lote_pat`
  MODIFY `id_lote_pat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

ALTER TABLE `material`
  MODIFY `id_material` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

ALTER TABLE `material_jctlm`
  MODIFY `id_material_jctlm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

ALTER TABLE `material_jctlm_emparejado`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `media_evaluacion`
  MODIFY `id_media_analito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=227;

ALTER TABLE `media_evaluacion_caso_especial`
  MODIFY `id_media_analito` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106194;

ALTER TABLE `mesurando_valores`
  MODIFY `id_mesurando_valores` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1225;

ALTER TABLE `metodologia`
  MODIFY `id_metodologia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36270;

ALTER TABLE `metodologia_analizador`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38631;

ALTER TABLE `metodo_jctlm`
  MODIFY `id_metodo_jctlm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=149;

ALTER TABLE `metodo_jctlm_emparejado`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

ALTER TABLE `misc`
  MODIFY `id_misc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `muestra`
  MODIFY `id_muestra` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1677;

ALTER TABLE `muestra_programa`
  MODIFY `id_muestra_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1694;

ALTER TABLE `opcion_limite`
  MODIFY `id_opcion_limite` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

ALTER TABLE `pais`
  MODIFY `id_pais` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `pregunta`
  MODIFY `id_pregunta` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1761;

ALTER TABLE `programa`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

ALTER TABLE `programa_analito`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=375;

ALTER TABLE `programa_laboratorio`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=661;

ALTER TABLE `programa_pat`
  MODIFY `id_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

ALTER TABLE `puntuaciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `reactivo`
  MODIFY `id_reactivo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

ALTER TABLE `referencia`
  MODIFY `id_referencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

ALTER TABLE `respuesta_lab`
  MODIFY `id_respuesta_lab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22390;

ALTER TABLE `respuesta_lab_temporal`
  MODIFY `id_respuesta_lab` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2416;

ALTER TABLE `resultado`
  MODIFY `id_resultado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47399;

ALTER TABLE `resultados_vav`
  MODIFY `id_resultados_vav` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3066;

ALTER TABLE `reto`
  MODIFY `id_reto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

ALTER TABLE `reto_laboratorio`
  MODIFY `id_reto_laboratorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=462;

ALTER TABLE `ronda`
  MODIFY `id_ronda` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=371;

ALTER TABLE `ronda_laboratorio`
  MODIFY `id_ronda_laboratorio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1309;

ALTER TABLE `sesion`
  MODIFY `id_sesion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23333;

ALTER TABLE `temp_configuraciones_cuali_definitivas`
  MODIFY `id_ccd` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `temp_media_definitiva`
  MODIFY `id_md` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `temp_pdf`
  MODIFY `id_temp_pdf` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12482;

ALTER TABLE `temp_valor_referencia`
  MODIFY `id_tvr` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `tipo_estado_reporte`
  MODIFY `id_tipo_estado_reporte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `tipo_programa`
  MODIFY `id_tipo_programa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `unidad`
  MODIFY `id_unidad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7196;

ALTER TABLE `unidad_analizador`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8215;

ALTER TABLE `unidad_global_analito`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

ALTER TABLE `usuario`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=624;

ALTER TABLE `usuario_laboratorio`
  MODIFY `id_conexion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=886;

ALTER TABLE `valor_metodo_referencia`
  MODIFY `id_valor_metodo_referencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13397;

ALTER TABLE `analito_resultado_reporte_cualitativo`
  ADD CONSTRAINT `fk_analito_resultado_reporte_cualitativo_analito2` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_analito_resultado_reporte_cualitativo_puntuacion` FOREIGN KEY (`id_puntuacion`) REFERENCES `puntuaciones` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `archivo`
  ADD CONSTRAINT `fk_archivo_laboratorio` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_archivo_reto` FOREIGN KEY (`id_reto`) REFERENCES `reto` (`id_reto`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `fk_archivo_ronda` FOREIGN KEY (`id_ronda`) REFERENCES `ronda` (`id_ronda`) ON DELETE SET NULL ON UPDATE SET NULL;

ALTER TABLE `caso_clinico`
  ADD CONSTRAINT `fk_caso_clinico_reto1` FOREIGN KEY (`reto_id_reto`) REFERENCES `reto` (`id_reto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `catalogo`
  ADD CONSTRAINT `fk_catalogo_distribuidor1` FOREIGN KEY (`id_distribuidor`) REFERENCES `distribuidor` (`id_distribuidor`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ciudad`
  ADD CONSTRAINT `fk_ciudad_pais1` FOREIGN KEY (`id_pais`) REFERENCES `pais` (`id_pais`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `comparaciones_internacionales`
  ADD CONSTRAINT `fk_comparaciones_internacionales_digitacion` FOREIGN KEY (`id_digitacion_uroanalisis`) REFERENCES `digitaciones_uroanalisis` (`id_digitaciones_uroanalisis`),
  ADD CONSTRAINT `fk_comparaciones_internacionales_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `configuracion_laboratorio_analito` (`id_configuracion`),
  ADD CONSTRAINT `fk_comparaciones_internacionales_mesurando` FOREIGN KEY (`id_mesurando`) REFERENCES `analito` (`id_analito`),
  ADD CONSTRAINT `fk_comparaciones_internacionales_resultado` FOREIGN KEY (`id_mesurando_resultado_reporte_cualitativo`) REFERENCES `analito_resultado_reporte_cualitativo` (`id_analito_resultado_reporte_cualitativo`);

ALTER TABLE `configuracion_analito_resultado_reporte_cualitativo`
  ADD CONSTRAINT `fk_configuracion_analito_resultado_reporte_cualitativo_analit2` FOREIGN KEY (`id_analito_resultado_reporte_cualitativo`) REFERENCES `analito_resultado_reporte_cualitativo` (`id_analito_resultado_reporte_cualitativo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_analito_resultado_reporte_cualitativo_config1` FOREIGN KEY (`id_configuracion`) REFERENCES `configuracion_laboratorio_analito` (`id_configuracion`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `configuracion_laboratorio_analito`
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_analizador1` FOREIGN KEY (`id_analizador`) REFERENCES `analizador` (`id_analizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_gen_vitros1` FOREIGN KEY (`id_gen_vitros`) REFERENCES `gen_vitros` (`id_gen_vitros`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_material1` FOREIGN KEY (`id_material`) REFERENCES `material` (`id_material`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_metodologia1` FOREIGN KEY (`id_metodologia`) REFERENCES `metodologia` (`id_metodologia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_programa1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_reactivo1` FOREIGN KEY (`id_reactivo`) REFERENCES `reactivo` (`id_reactivo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_configuracion_laboratorio_analito_unidad1` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `contador_informe`
  ADD CONSTRAINT `fk_contador_informe_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `contador_muestra`
  ADD CONSTRAINT `fk_contador_muestra_muestra1` FOREIGN KEY (`id_muestra`) REFERENCES `muestra` (`id_muestra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_contador_muestra_ronda1` FOREIGN KEY (`id_ronda`) REFERENCES `ronda` (`id_ronda`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `digitacion`
  ADD CONSTRAINT `fk_digitacion_lote1` FOREIGN KEY (`id_lote`) REFERENCES `lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_programa1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `digitaciones_uroanalisis`
  ADD CONSTRAINT `fk_digitaciones_uroanalisis_2_lab` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitaciones_uroanalisis_2_lote` FOREIGN KEY (`id_lote`) REFERENCES `lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitaciones_uroanalisis_2_programa` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `digitacion_cuantitativa`
  ADD CONSTRAINT `fk_digitacion_cuantitativa_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_cuantitativa_analizador1` FOREIGN KEY (`id_analizador`) REFERENCES `analizador` (`id_analizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_cuantitativa_digitacion1` FOREIGN KEY (`id_digitacion`) REFERENCES `digitacion` (`id_digitacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_cuantitativa_gen_vitros1` FOREIGN KEY (`id_gen_vitros`) REFERENCES `gen_vitros` (`id_gen_vitros`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_cuantitativa_metodologia1` FOREIGN KEY (`id_metodologia`) REFERENCES `metodologia` (`id_metodologia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_cuantitativa_reactivo1` FOREIGN KEY (`id_reactivo`) REFERENCES `reactivo` (`id_reactivo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_cuantitativa_unidad1` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `digitacion_resultados_verdaderos`
  ADD CONSTRAINT `fk_digitacion_resultados_verdaderos_cualitativo` FOREIGN KEY (`mesurando_resultado_reporte_cualitativo_id`) REFERENCES `analito_resultado_reporte_cualitativo` (`id_analito_resultado_reporte_cualitativo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_resultados_verdaderos_digitacion` FOREIGN KEY (`id_digitacion_uroanalisis`) REFERENCES `digitaciones_uroanalisis` (`id_digitaciones_uroanalisis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_resultados_verdaderos_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `configuracion_laboratorio_analito` (`id_configuracion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_digitacion_resultados_verdaderos_mesurando` FOREIGN KEY (`mesurando_id`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `distractor`
  ADD CONSTRAINT `fk_distractor_pregunta1` FOREIGN KEY (`pregunta_id_pregunta`) REFERENCES `pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `fecha_reporte_muestra`
  ADD CONSTRAINT `fk_fecha_reporte_muestra_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_fecha_reporte_muestra_muestra1` FOREIGN KEY (`id_muestra`) REFERENCES `muestra` (`id_muestra`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `grupo`
  ADD CONSTRAINT `fk_grupo_caso_clinico1` FOREIGN KEY (`caso_clinico_id_caso_clinico`) REFERENCES `caso_clinico` (`id_caso_clinico`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `imagen_adjunta`
  ADD CONSTRAINT `fk_imagen_adjunta_caso_clinico1` FOREIGN KEY (`caso_clinico_id_caso_clinico`) REFERENCES `caso_clinico` (`id_caso_clinico`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `intento`
  ADD CONSTRAINT `fk_intento_reto1` FOREIGN KEY (`reto_id_reto`) REFERENCES `reto` (`id_reto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itento_laboratorio1` FOREIGN KEY (`laboratorio_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_itento_usuario1` FOREIGN KEY (`usuario_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `intento_temporal`
  ADD CONSTRAINT `laboratorio_fk` FOREIGN KEY (`laboratorio_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reto_fk` FOREIGN KEY (`reto_id_reto`) REFERENCES `reto` (`id_reto`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `usuario_fk` FOREIGN KEY (`usuario_id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `laboratorio`
  ADD CONSTRAINT `fk_laboratorio_ciudad1` FOREIGN KEY (`id_ciudad`) REFERENCES `ciudad` (`id_ciudad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `limite_evaluacion`
  ADD CONSTRAINT `fk_limite_evaluacion_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_limite_evaluacion_calculo_limite_evaluacion1` FOREIGN KEY (`id_calculo_limite_evaluacion`) REFERENCES `calculo_limite_evaluacion` (`id_calculo_limite_evaluacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_limite_evaluacion_opcion_limite1` FOREIGN KEY (`id_opcion_limite`) REFERENCES `opcion_limite` (`id_opcion_limite`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `lote`
  ADD CONSTRAINT `fk_lote_catalogo1` FOREIGN KEY (`id_catalogo`) REFERENCES `catalogo` (`id_catalogo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `material_jctlm`
  ADD CONSTRAINT `fk_material_jctlm_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `material_jctlm_emparejado`
  ADD CONSTRAINT `fk_material_jctlm_emparejado_material1` FOREIGN KEY (`id_material`) REFERENCES `material` (`id_material`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_material_jctlm_emparejado_material_jctlm1` FOREIGN KEY (`id_material_jctlm`) REFERENCES `material_jctlm` (`id_material_jctlm`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `media_evaluacion_caso_especial`
  ADD CONSTRAINT `fk_media_evaluacion_caso_especial_analito_resultado_reporte_c1` FOREIGN KEY (`id_analito_resultado_reporte_cualitativo`) REFERENCES `analito_resultado_reporte_cualitativo` (`id_analito_resultado_reporte_cualitativo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_media_evaluacion_caso_especial_configuracion_laboratorio_a2` FOREIGN KEY (`id_configuracion`) REFERENCES `configuracion_laboratorio_analito` (`id_configuracion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_media_evaluacion_caso_especial_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_media_evaluacion_caso_especial_muestra1` FOREIGN KEY (`id_muestra`) REFERENCES `muestra` (`id_muestra`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `mesurando_valores`
  ADD CONSTRAINT `fk_mesurando_valores_analito` FOREIGN KEY (`id_mesurando`) REFERENCES `analito` (`id_analito`),
  ADD CONSTRAINT `fk_mesurando_valores_digitacion` FOREIGN KEY (`id_digitaciones_uroanalisis`) REFERENCES `digitaciones_uroanalisis` (`id_digitaciones_uroanalisis`),
  ADD CONSTRAINT `fk_mesurando_valores_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `configuracion_laboratorio_analito` (`id_configuracion`);

ALTER TABLE `metodologia_analizador`
  ADD CONSTRAINT `fk_metodologia_analizador_analizador1` FOREIGN KEY (`id_analizador`) REFERENCES `analizador` (`id_analizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_metodologia_analizador_metodologia1` FOREIGN KEY (`id_metodologia`) REFERENCES `metodologia` (`id_metodologia`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `metodo_jctlm`
  ADD CONSTRAINT `fk_metodo_jctlm_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `metodo_jctlm_emparejado`
  ADD CONSTRAINT `fk_metodo_jctlm_emparejado_metodo_jctlm1` FOREIGN KEY (`id_metodo_jctlm`) REFERENCES `metodo_jctlm` (`id_metodo_jctlm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_metodo_jctlm_emparejado_metodologia1` FOREIGN KEY (`id_metodologia`) REFERENCES `metodologia` (`id_metodologia`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `muestra_programa`
  ADD CONSTRAINT `fk_muestra_programa_lote1` FOREIGN KEY (`id_lote`) REFERENCES `lote` (`id_lote`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_muestra_programa_muestra1` FOREIGN KEY (`id_muestra`) REFERENCES `muestra` (`id_muestra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_muestra_programa_programa1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `pregunta`
  ADD CONSTRAINT `fk_pregunta_grupo1` FOREIGN KEY (`grupo_id_grupo`) REFERENCES `grupo` (`id_grupo`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `programa`
  ADD CONSTRAINT `fk_programa_tipo_programa1` FOREIGN KEY (`id_tipo_programa`) REFERENCES `tipo_programa` (`id_tipo_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `programa_analito`
  ADD CONSTRAINT `fk_programa_analito_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_programa_analito_programa1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `programa_laboratorio`
  ADD CONSTRAINT `fk_programa_laboratorio_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_programa_laboratorio_programa1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `referencia`
  ADD CONSTRAINT `fk_referencia_caso_clinico1` FOREIGN KEY (`caso_clinico_id_caso_clinico`) REFERENCES `caso_clinico` (`id_caso_clinico`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `respuesta_lab`
  ADD CONSTRAINT `fk_respuesta_lab_distractor1` FOREIGN KEY (`distractor_id_distractor`) REFERENCES `distractor` (`id_distractor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respuesta_lab_intento1` FOREIGN KEY (`intento_id_intento`) REFERENCES `intento` (`id_intento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_respuesta_lab_pregunta1` FOREIGN KEY (`pregunta_id_pregunta`) REFERENCES `pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `respuesta_lab_temporal`
  ADD CONSTRAINT `fk_distractor` FOREIGN KEY (`distractor_id_distractor`) REFERENCES `distractor` (`id_distractor`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_intento` FOREIGN KEY (`intento_id_intento`) REFERENCES `intento_temporal` (`id_intento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pregunta` FOREIGN KEY (`pregunta_id_pregunta`) REFERENCES `pregunta` (`id_pregunta`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `resultado`
  ADD CONSTRAINT `fk_resultado_analito_resultado_reporte_cualitativo1` FOREIGN KEY (`id_analito_resultado_reporte_cualitativo`) REFERENCES `analito_resultado_reporte_cualitativo` (`id_analito_resultado_reporte_cualitativo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultado_configuracion_laboratorio_analito1` FOREIGN KEY (`id_configuracion`) REFERENCES `configuracion_laboratorio_analito` (`id_configuracion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultado_muestra1` FOREIGN KEY (`id_muestra`) REFERENCES `muestra` (`id_muestra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultado_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `resultados_vav`
  ADD CONSTRAINT `fk_resultados_vav_analito` FOREIGN KEY (`id_mesurando`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultados_vav_digitacion` FOREIGN KEY (`id_digitaciones_uroanalisis`) REFERENCES `digitaciones_uroanalisis` (`id_digitaciones_uroanalisis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultados_vav_resultado_cualitativo` FOREIGN KEY (`id_mesurando_resultado_reporte_cualitativo`) REFERENCES `analito_resultado_reporte_cualitativo` (`id_analito_resultado_reporte_cualitativo`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_resultados_vav_resultado_id_configuracion` FOREIGN KEY (`id_configuracion`) REFERENCES `configuracion_laboratorio_analito` (`id_configuracion`);

ALTER TABLE `reto`
  ADD CONSTRAINT `fk_programa_pat_has_reto_programa_pat1` FOREIGN KEY (`programa_pat_id_programa`) REFERENCES `programa_pat` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reto_lote_pat1` FOREIGN KEY (`lote_pat_id_lote_pat`) REFERENCES `lote_pat` (`id_lote_pat`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `reto_laboratorio`
  ADD CONSTRAINT `fk_reto_laboratorio_laboratorio1` FOREIGN KEY (`laboratorio_id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reto_laboratorio_reto1` FOREIGN KEY (`reto_id_reto`) REFERENCES `reto` (`id_reto`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ronda`
  ADD CONSTRAINT `fk_ronda_programa1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id_programa`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `ronda_laboratorio`
  ADD CONSTRAINT `fk_ronda_laboratorio_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ronda_laboratorio_ronda1` FOREIGN KEY (`id_ronda`) REFERENCES `ronda` (`id_ronda`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `sesion`
  ADD CONSTRAINT `fk_sesion_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `unidad_analizador`
  ADD CONSTRAINT `fk_unidad_analizador_analizador1` FOREIGN KEY (`id_analizador`) REFERENCES `analizador` (`id_analizador`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_unidad_analizador_unidad1` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `unidad_global_analito`
  ADD CONSTRAINT `fk_unidad_global_analito_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_unidad_global_analito_unidad1` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `usuario_laboratorio`
  ADD CONSTRAINT `fk_usuario_laboratorio_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_usuario_laboratorio_usuario1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `valor_metodo_referencia`
  ADD CONSTRAINT `fk_valor_metodo_referencia_analito1` FOREIGN KEY (`id_analito`) REFERENCES `analito` (`id_analito`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_valor_metodo_referencia_laboratorio1` FOREIGN KEY (`id_laboratorio`) REFERENCES `laboratorio` (`id_laboratorio`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_valor_metodo_referencia_metodologia1` FOREIGN KEY (`id_metodologia`) REFERENCES `metodologia` (`id_metodologia`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_valor_metodo_referencia_muestra1` FOREIGN KEY (`id_muestra`) REFERENCES `muestra` (`id_muestra`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_valor_metodo_referencia_unidad1` FOREIGN KEY (`id_unidad`) REFERENCES `unidad` (`id_unidad`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

CREATE TABLE
    selecciones_consenso (
        id_seleccion INT AUTO_INCREMENT PRIMARY KEY,
        id_configuracion INT NOT NULL,
        id_muestra INT NOT NULL,
        id_resultado INT NOT NULL,
        fecha_seleccion DATETIME DEFAULT CURRENT_TIMESTAMP,
        UNIQUE (
            id_configuracion,
            id_muestra,
            id_resultado,
            fecha_seleccion
        ),
        CONSTRAINT fk_sc_configuracion FOREIGN KEY (id_configuracion) REFERENCES configuracion_laboratorio_analito (id_configuracion),
        CONSTRAINT fk_sc_muestra FOREIGN KEY (id_muestra) REFERENCES muestra (id_muestra),
        CONSTRAINT fk_sc_resultado FOREIGN KEY (id_resultado) REFERENCES resultado (id_resultado)
    );

CREATE INDEX idx_sc_config_muestra ON selecciones_consenso (id_configuracion, id_muestra);

CREATE INDEX idx_sc_resultado ON selecciones_consenso (id_resultado);

ALTER TABLE media_evaluacion_caso_especial
ADD COLUMN percentil_25 DECIMAL(10, 3) DEFAULT 0,
ADD COLUMN percentil_75 DECIMAL(10, 3) DEFAULT 0;