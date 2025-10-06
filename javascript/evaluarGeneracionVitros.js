function evaluarGeneracionVitros(trActual){

    let valEquipo = trActual.find(".analizador").val();
    let descEquipo = trActual.find(".analizador option[value="+valEquipo+"]").text();
    if(descEquipo.indexOf("vitros") !== -1 || descEquipo.indexOf("Vitros") !== -1 || descEquipo.indexOf("VITROS") !== -1){ // Si el equipo es vitros
        if(trActual.find(".gen_vitros").val() == "" || trActual.find(".gen_vitros").val() == undefined){ // Si esta indefinida la generacion 
            return true; // Generar alerta
        } else {
            return false; // Para permitir el flujo del condicional
        }
    } else {
        return false; // Para permitir el flujo del condicional
    }
}