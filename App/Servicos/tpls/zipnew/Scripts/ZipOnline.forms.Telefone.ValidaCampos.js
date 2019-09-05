//Autor: RHB
//JS para destacar os campos em seu preenchimento dos forms de consulta

function AddCssCampoTel() {
    //DDD não é obrigatório
    if ($("#NumeroTel").val() == "") {
        $("#NumeroTel").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
    }
//    if ($("#DDD").val() == "") {
//        $("#DDD").css({ backgroundColor: '#ffeeee', border: '1px solid #ff0000' });
//    }
}

//Remove Style-----------------------------------------------
function removeCssCampo(id) {
    var campo = "#" + id;
    if($(campo).val() != ""){ $(campo).removeAttr('style');}
}

//SUBMIT
$("form").submit(function () {    
    var msg = "";    
        //DDD e Telefone
        if ($("#NumeroTel").val() == "") {            
            msg += "Informe o Telefone!";
            alert(msg);
            return false;
        }            
});
