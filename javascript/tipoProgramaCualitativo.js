function tipoProgramaCualitativo(elementEvent){

    let programaElement = elementEvent.parents(".cont-referencia-selectores").find(".cont-selectores #programa");
    let valPrograma = programaElement.val();
    let descPrograma = programaElement.find("option[value="+valPrograma+"]").text();
    
    if((descPrograma.indexOf("Cualitativo")) !== -1){ // Si es cualitativo
        return true;
    } else {
        return false;
    }
}