function eliminarModal(contM){
    if($("body").hasClass("modal-open")){
        contM.find(".modal").modal("hide");
        contM.html("");
        $('body').removeClass('modal-open'); 
        
        if(!($("body").hasClass("p-0"))){ // Si no tiene la clase de padding 0
            $("body").addClass("p-0");
        }
        $('.modal-backdrop').remove();
    }
}