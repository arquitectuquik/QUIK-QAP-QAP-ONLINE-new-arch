function eliminarOptions(elemento) {
        
    var eleOptions = elemento.children();
    

    for (i = 0; i < eleOptions.length; i++) {
        eleOptions.eq(i).remove();
    }
    
    elemento.append($('<option value="" disabled="" selected="">Seleccione una de las opciones</option>'));
}