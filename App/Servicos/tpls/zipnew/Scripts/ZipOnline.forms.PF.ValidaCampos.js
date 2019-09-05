//Autor: RHB
//JS para destacar os campos em seu preenchimento dos forms de consulta 
/*CONSULTA PF ----------------------------------------------------------------------------------------------------------------*/
function AddCssCampo() {
    //Destaca cidades apenas se não contém valor nos campos Telefone,Nome,CEP
    if ($("#Cidades").val() == "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "" && $("#DataNascimento").val() == "") {
        $("#Cidades").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }

    if ($("#Logradouro").val() == "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "" && $("#DataNascimento").val() == "") {
        $("#Logradouro").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
        $("#Numero").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }

    if ($("#Estado").val() == "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "" && $("#DataNascimento").val() == "") {
        $("#Estado").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }
}

function AddCssDtNasc() {
    //Destaca cidades apenas se não contém valor nos campos Telefone,Nome,CEP
    if ($("#Nome").val() == "" && $("#CEP").val() == "" && $("#Cidades").val() == "" && $("#Logradouro").val() == "" && $("#Telefone").val() == "") {
        $("#Nome").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }

    if ($("#CEP").val() == "" && $("#Estado").val() == "" && $("#Telefone").val() == "" && $("#Nome").val() == "") {
        $("#CEP").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }

    if ($("#Cidades").val() == "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "") {
        $("#Cidades").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }

    if ($("#Logradouro").val() == "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "") {
        $("#Logradouro").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
        $("#Numero").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }

    if ($("#Estado").val() == "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "") {
        $("#Estado").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }
}

function AddCssCampoTel() {
    //DDD não é obrigatório
    if ($("#Telefone").val() == "") {
        $("#Telefone").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }
    if ($("#Telefone").val() == "" && $("#DDD").val() == "") {
        $("#DDD").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }
}

//Remove Style-----------------------------------------------
function removeCssCampo(id) {
    var campo = "#" + id;
    $(campo).removeAttr('style');

    //Retira o style do número não obrigatório
    if (id == "Logradouro") {
        $("#Numero").removeAttr('style');
    }

    if ($("#DataNascimento").val() != "" && (id == "Cidades" || id == "Logradouro")) {
        $("#DDD").removeAttr('style');
        if ($("#DDD").val() == "") { $("#Telefone").removeAttr('style'); }
        $("#Estado").removeAttr('style');
        $("#Cidades").removeAttr('style');        
        $("#Logradouro").removeAttr('style');
        $("#Numero").removeAttr('style');
        $("#Nome").removeAttr('style');
        $("#CEP").removeAttr('style');
    }

    if (id == "Telefone" || id == "CEP" || id == "Nome" || id == "DDD" || id == "CPF") {
        $("#DDD").removeAttr('style');
        if ($("#DDD").val() == "") { $("#Telefone").removeAttr('style'); }
        $("#Estado").removeAttr('style');
        $("#Cidades").removeAttr('style');
        $("#Logradouro").removeAttr('style');
        $("#Numero").removeAttr('style');
        $("#Nome").removeAttr('style');
        $("#CEP").removeAttr('style');
    }
}

//Drop Estado sem valor remove style do endereço
function removeCssCamposEndereco() {
    if ($("#Estado").val() == "") {
        $("#Estado").removeAttr('style');
        $("#Cidades").removeAttr('style');
        $("#Logradouro").removeAttr('style');
        $("#Numero").removeAttr('style');
    }
}
//---------------------------------------------------------
//SUBMIT
$("form").submit(function () {
    var ExibeMsg = true;
    var msg = "Nenhum campo foi preenchido para consultar!";
    $("form :input[type=text]").each(function (i) {
        if (this.value != "") {
            ExibeMsg = false;
        }
        
        //Apenas DataNasc não consulta
        if ($("#DataNascimento").val() != "" && $("#CEP").val() == "" && $("#Nome").val() == "" && $("#Cidades").val() == 0 && $("#Logradouro").val() == "" && $("#Telefone").val() == "") {
            msg = "";
            msg = "Necessário informar mais algum campo para consulta!";
            ExibeMsg = true;
        }

        //Estado sem cidade e logradouro, sem telefone.
        if ($("#Estado").val() != "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "" && $("#DataNascimento").val() == "") {
            msg = "";
            if ($("#Cidades").val() == "") {
                msg = "Necessário informar a cidade!";
                ExibeMsg = true;
            }
            if ($("#Logradouro").val() == "") {
                msg += "\nNecessário informar o logradouro!";
                ExibeMsg = true;
            }
        }
        //Cidade sem estado e logradouro, sem telefone
        if ($("#Cidades").val() != "" && $("#Cidades").val() != 0 && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "" && $("#DataNascimento").val() == "") {
            msg = "";
            if ($("#Estado").val() == "") {
                msg = "Necessário informar o estado!";
                ExibeMsg = true;
            }
            if ($("#Logradouro").val() == "") {
                msg += "\nNecessário informar o logradouro!";
                ExibeMsg = true;
            }
        }
        //Logradouro sem estado e cidade, sem telefone 
        if ($("#Logradouro").val() != "" && $("#Telefone").val() == "" && $("#Nome").val() == "" && $("#CEP").val() == "" && $("#DataNascimento").val() == "") {
            msg = "";
            if ($("#Estado").val() == "") {
                msg = "Necessário informar o estado!";
                ExibeMsg = true;
            }
            if ($("#Cidades").val() == "") {
                msg += "\nNecessário informar a cidade!";
                ExibeMsg = true;
            }
        }

        //DDD sem telefone
        if ($("#DDD").val() != "" && $("#Telefone").val() == "" && $("#CEP").val() == "") {
            msg = "";
            msg = "Necessário informar o telefone!";
            ExibeMsg = true;
        }
    });

    if (ExibeMsg) {
        alert(msg);
        return false;
    }
});
/*FIM CONSULTA PF ----------------------------------------------------------------------------------------------------------------*/