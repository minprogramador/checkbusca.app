$(document).ready(function () {
    $('#Estado').change(function () {
        $('#dvCidades').append('<option value="0">Carregando...</option>');
        $.post("?ListaCidadesPorEstado", { estado: $("#Estado").val() }, function (data) {
            $("#dvCidades").empty().append(data);
        });
    });
});