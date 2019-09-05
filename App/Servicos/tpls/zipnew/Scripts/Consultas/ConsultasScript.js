function consultarReceitaSrfPf() {
    
    if (validarDataNascimento($("#IdTxtBoxDataNascimento").val()))
        {
            $.ajax({
                url: "ReceitaFederalOnline",
                dataType: "html",
                data: {
                    "dtNascimento": $("#IdTxtBoxDataNascimento").val(),
                    "documento": $("#nrDoc").val(),
                    "idbase": $("#idBase").val(),
                    
                },
                beforeSend: function () {
                   $("#load").show();
                },
                success: function (event) {
                    $("#receita").html(event);
                },
                complete: function () {
                    $("#load").hide();
                }
        });
    } else {

        $('#lblValidacaoDtNascimento').css('visibility', 'visible');
        document.getElementById('IdTxtBoxDataNascimento').style.border = "solid 1px red";
    }
}

function validarDataNascimento(dataEntrada) {

    var resultado = true;
    var patternData = /^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/;
    if (!patternData.test(dataEntrada)) {
        
        resultado = false;
    }
    return resultado;
}

function IsNumeric() {
    var key = window.event.keyCode;
    $('#lblValidacaoDtNascimento').css('visibility', 'hidden');
    var txtBoxValue = $("#IdTxtBoxDataNascimento").val();
    
    if ((key < 48) || (key > 57)) {
        
        if ((key < 96) || (key > 105)) {
            if (key != 8 && key != 13) {
                $('#lblValidacaoDtNascimento').css('visibility', 'visible');
                $("#IdTxtBoxDataNascimento").val(txtBoxValue.slice(0, -1));
            }
        }
    }
    
    txtBoxValue = $("#IdTxtBoxDataNascimento").val();
    var charBarra = txtBoxValue.length;
    
    if ((charBarra == 2 || charBarra == 5) & key != 8) {
        $("#IdTxtBoxDataNascimento").val(txtBoxValue + '/');
    }
    
    if (charBarra == 10) {
        $("#btnSubmitDataNascimento").focus();
    }
    return true;
}