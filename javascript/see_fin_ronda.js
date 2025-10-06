$(function(){

    $("#embed").ready(function(){

        $.ajax({
            url: "php/delete_document_temp.php",
            type: 'POST',
            data: {
                id: $("#id_reference").val(),
            }
        }).always(function (ewfwefsf) {
            console.log("Se eliminará:" + $("#id_reference").val());
            console.log(ewfwefsf);
        });
    });

});