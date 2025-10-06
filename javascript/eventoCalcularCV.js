function eventoCalcularCV(table_trGestion){

    table_trGestion.find(".change_cv").keyup(function(e){
        e.preventDefault();

        let change_cv = $(this); 
        let padreTR = change_cv.parents("tr");

        // calculo de CV
        let media_val = padreTR.find("." + change_cv.data("fieldmedia")).val();
        let de_val = padreTR.find("." + change_cv.data("fieldde")).val();
        let cv_val = Math.round(((de_val / media_val) * 100) * 1000) / 1000;

        if(media_val == "" || de_val == "" || cv_val == "" || Number.isNaN(media_val) || Number.isNaN(de_val) || Number.isNaN(cv_val)){ // Si la desviación estandar y la media son numericas y están definidas
            padreTR.find("." + change_cv.data("fieldcv")).val(""); // Difinir un valor de nulo al CV indicado
        } else {
            padreTR.find("." + change_cv.data("fieldcv")).val(cv_val);
        }
    });
}