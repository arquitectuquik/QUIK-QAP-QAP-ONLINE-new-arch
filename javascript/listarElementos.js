function listarElementos(table_trGestion) {
    
    var seleccion = table_trGestion.find("select").not(".unidad").not(".tipo").not(".metodologia");
        
    seleccion.each(function () {

        var tabla = $(this).attr("class").split(" ")[0]; // Se obtiene el nombre del elemento mediante la clase, en su primer posicion
        var campo = $(this);

        switch (tabla) {

            case "analito":
                listarSelect(tabla, campo, table_trGestion.parents(".cont-referencia-selectores").find(".cont-selectores #programa").val());
                break;

            case "analizador":
                // Se agrega un evento en dado caso de que cambie el valor del mismo
                eventoChangeAnalizador(campo, table_trGestion);
                listarSelect(tabla, campo, null);
                
                break;
            default:
                listarSelect(tabla, campo, null);
                break;
        }
    });
}