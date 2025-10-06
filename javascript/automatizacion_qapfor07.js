function automatizacion_qapfor07(tipobusqueda, info_lab, info_digitacion){
    
    let digActualWindow;
    
    switch(tipobusqueda){
        case "par": // Se busca un mensurando que tenga la misma metodologia, mismo equipo y unidad
            for(xewsd=0; xewsd<window.info_digitacion.digitacion_cuantitativa.length; xewsd++){
                digActualWindow = window.info_digitacion.digitacion_cuantitativa[xewsd];

                if(
                    digActualWindow.id_analito == info_lab.id_analito_av &&
                    digActualWindow.id_analizador == info_lab.id_analizador_av &&
                    digActualWindow.id_metodologia == info_lab.id_metodologia_av &&
                    digActualWindow.id_unidad == info_lab.id_unidad_av
                ) {
                    return digActualWindow.id_digitacion_cuantitativa; // Retorna el ID de la digitacion
                }               
            }

            return false;
        break;
        case "método":
            for(xewsd=0; xewsd<window.info_digitacion.digitacion_cuantitativa.length; xewsd++){
                digActualWindow = window.info_digitacion.digitacion_cuantitativa[xewsd];

                if(
                    digActualWindow.id_analito == info_lab.id_analito_av &&
                    (
                        digActualWindow.nombre_analizador == "N/A" ||
                        digActualWindow.nombre_analizador == "n/a" ||
                        digActualWindow.nombre_analizador == "N/A " ||
                        digActualWindow.nombre_analizador == "n/a " ||
                        digActualWindow.nombre_analizador == "Método" ||
                        digActualWindow.nombre_analizador == "MÉTODO" ||
                        digActualWindow.nombre_analizador == "método" ||
                        digActualWindow.nombre_analizador == "metodo"
                    ) &&
                    digActualWindow.id_metodologia == info_lab.id_metodologia_av &&
                    digActualWindow.id_unidad == info_lab.id_unidad_av
                ) {
                    return digActualWindow.id_digitacion_cuantitativa; // Retorna el ID de la digitacion
                }               
            }

            return false;
            break;

        case "unidad":
            for(xewsd=0; xewsd<window.info_digitacion.digitacion_cuantitativa.length; xewsd++){
                digActualWindow = window.info_digitacion.digitacion_cuantitativa[xewsd];

                if(
                    digActualWindow.id_analito == info_lab.id_analito_av &&
                    digActualWindow.id_unidad == info_lab.id_unidad_av
                ) {
                    // Devuelve el primer mensurando que encuentre con las mismas unidades
                    return digActualWindow.id_digitacion_cuantitativa; // Retorna el ID de la digitacion
                }               
            }

            return false;
            break;
    }

    digActualWindow = null;
}