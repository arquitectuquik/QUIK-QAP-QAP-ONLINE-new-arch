function validarSiJSON(cadena){
    var cadenaLimpia = cadena.trim(" ","");
    
    cadenaLimpia = cadenaLimpia.substr(0,1);
    
    if(cadenaLimpia === "[" || cadenaLimpia === "{"){
        return true;
    } else {
        return false;
    }
}