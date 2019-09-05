$(document).ready(function () {

    $('a[name=modal]').click(function (e) {
        modalMask(e);
    });

    function modalMask(e) {
        e.preventDefault();

        var id = $(this).attr('href');

        var maskHeight = $(document).height();
        var maskWidth = $(window).width();

        $('#mask').css({ 'width': maskWidth, 'height': maskHeight });

        $('#mask').fadeIn(1000);
        $('#mask').fadeTo("slow", 0.8);

        //Get the window height and width
        var winH = $(document).height();
        var winW = $(window).width();

        var the_id = $(id);
        //the_id.css('top',  winH/2 - the_id.height() / 2);
        //the_id.css('top', $(this).position().top + ($(window).height() / 2) - the_id.height());
        //the_id.css('left', winW/2 - the_id.width() / 2);

        $(id).fadeIn(2000);
    }

    $('.window .close').click(function (e) {
        e.preventDefault();

        $('#mask').hide();
        $('.window').hide();
    });

    //clicando no modal ele fecha
    //$('#mask').click(function () {
    //    $(this).hide();
    //    $('.window').hide();
    //});
    
    //precionando no esc o modal ele fecha
    $(document).keyup(function (event) {
        if (event.keyCode == 27) {
            closePopup();
            event.stopPropagation();
        }
    });

});

//criando um janela modal, (título do modal, descrição do modal , conteúdo do modal)
function janelaZipModal(modalTitulo, modalDescricao, modalConteudo) {
    var modalContDescricao = "";
    if (modalDescricao != null) {
        modalContDescricao = "<h1 id=modalDescricao >" + modalDescricao + "</h1><br /><br />";
    }
    $("#lightBox").html("<div id=padrao >" +
    "<div class=zip_close_modal ><a id=btnFechar href=javascript:closePopup class=close >" +
    "<img alt=Fechar src=../Content/images/close_modal.png /></a></div>" +
    "<div class=zip_modal_header ><h2>" + modalTitulo + "</h2></div><div class=zip_modal_body >" + modalContDescricao + "<p>" + modalConteudo + "</p></div></div>");
    openPopup();
    $("#btnFechar").click(function () {
        closePopup();
    });     
}