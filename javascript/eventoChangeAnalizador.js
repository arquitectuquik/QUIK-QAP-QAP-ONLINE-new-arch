function eventoChangeAnalizador(campo, table_trGestion){
    campo.change(function (e) {
        e.preventDefault();
        
        // Analizador
        eliminarOptions(campo.parents("tr").find(".unidad"));
        eliminarOptions(campo.parents("tr").find(".unidad_mc"));

        listarSelect("unidad", table_trGestion.find(".unidad"), table_trGestion.find(".analizador").val());
        listarSelect("unidad", table_trGestion.find(".unidad_mc"), table_trGestion.find(".analizador").val());
        
        // Metodologia
        eliminarOptions(campo.parents("tr").find(".metodologia"));
        listarSelect("metodologia", table_trGestion.find(".metodologia"), table_trGestion.find(".analizador").val());

        // Si el equipo seleccionado es vitros
        let valEquipo = table_trGestion.find(".analizador").val();
        let descEquipo = table_trGestion.find(".analizador option[value="+valEquipo+"]").text();
        if(descEquipo.indexOf("vitros") !== -1 || descEquipo.indexOf("Vitros") !== -1 || descEquipo.indexOf("VITROS") !== -1){ // Si encuentra la palabra vitros
            // Habilitar la seleccion de la generacion
            table_trGestion.find(".gen_vitros").prop("disabled",false); 
        } else {
            // Bloquear la seleccion de la generacion 
            table_trGestion.find(".gen_vitros").prop("disabled",true); 
        }
    });
}