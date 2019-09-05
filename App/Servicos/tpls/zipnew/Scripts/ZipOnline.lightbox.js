
$(document).ready(function () {
//    $("#lightBox").dialog({
//        autoOpen: false,
//        title: '',
//        width: 'auto',
//        height: 'auto',
//        modal: true
//    });
});

function openPopup() {

    var maskHeight = $(document).height();

    var total = $(window).width();
    if (total > 960) {
        var maskWidth = $(window).width();
    }
    else
        var maskWidth = '960px';  //

    $('#mask').css({ 'min-width': maskWidth, 'height': maskHeight });
    $('#mask').fadeIn(1000);
    $('#mask').fadeTo("slow", 0.8);

    //Get the window height and width
    var winH = $(document).height();
    var winW = $(window).width();
    var the_id = $("#lightBox");
    $("#lightBox").fadeIn(1000, function () {
        //Disparando evento quando finaliza animação 
        $(document).trigger("lightBoxComplet", ["completo"]);
        $(document).unbind("lightBoxComplet");
    });
    
    $(document).keyup(function (e) {
        if (e.keyCode == 27) {
            closePopup();
            e.stopPropagation();
        }
    });
}

function closePopup() {

    $('#mask').hide();
    $('.window').hide();
    $("#lightBox").dialog("close");
    $("#lightBox").empty(); 
}