$(document).ready(function () {
    $('form').attr('autocomplete', 'off');
});
function exibeCombinada() {
    $("#combinada").show();
    $("#detalhe").hide();
}

function escondeCombinada() {
    $("#combinada").hide();
}

$("form").live("submit", function (event) {
    //Valida o cookie UserCrypt no submit, caso não exista redireciona para o login
    //var user = getCookie("UserCrypt");
    //if (user == null || user == "") {
    //    $(location).attr('href', '/Account/LogOn');
    //}

    event.preventDefault();
    var form = $(this);
    $("#load").show();
    $.ajax({
        url: form.attr('action'),
        type: "POST",
        data: form.serialize(),
        success: function (data) {
            $("#detalhe").show();
            $("#detalhe").html(data);
            $("#combinada").hide();
            $.validator.unobtrusive.parse("form");
        },
        complete: function () {
            $("#load").hide();
        }
    });
});


//function getCookie(c_name) {
//    var i, x, y, ARRcookies = document.cookie.split(";");
//    for (i = 0; i < ARRcookies.length; i++) {
//        x = ARRcookies[i].substr(0, ARRcookies[i].indexOf("="));
//        y = ARRcookies[i].substr(ARRcookies[i].indexOf("=") + 1);
//        x = x.replace(/^\s+|\s+$/g, "");
//        if (x == c_name) {
//            return unescape(y);
//        }
//    }    
//    return null;    
//}