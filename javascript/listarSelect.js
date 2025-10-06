function listarSelect(tabla, campoP, idfiltro = null) {
            
    datosEMP = {
        tabla: tabla,
        id_filtro: idfiltro
    }
    
    $.post(
        "php/listar_select_basico.php", 
        datosEMP,
        function (data) {
            if(validarSiJSON(data)){

                campoP.html(campoP.find("option").eq(0));
                var resultado = JSON.parse(data);
                for (i = 0; i < resultado.length; i++) {
                    var option = $("<option value=" + resultado[i][0] + ">" + resultado[i][1] + "</option>");
                    campoP.append(option);
                }   
            }

        }
    );
}