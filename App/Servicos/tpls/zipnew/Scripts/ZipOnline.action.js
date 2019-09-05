$(document).ready(function () {
    $('form').attr('autocomplete', 'off');
});
function estadoBotao(btTemp, btEstado) {
    if (btEstado==true) {
        $("#" + btTemp).removeAttr('disabled');
        $("#" + btTemp).removeClass('disabled_elements');
    } else if (btEstado==false) {
        $("#" + btTemp).attr('disabled', 'disabled');
        $("#" + btTemp).addClass('disabled_elements');
    }
}

function debugar(dado) {
    if ($.browser.mozilla == true) {
        console.log(dado);

        // internet explorer
    } else if ($.browser.msie == true) {
        //alert(dado);

        // webkit
    } else if ($.browser.webkit == true) {
        console.debug(dado);

        // outros navegadores
    } else {
        //alert(dado);
    }
}

function MostraMenuAcoes(obj) {
    if ($("#" + obj).is(":visible")) {
        $("#" + obj).hide();
    }
    else {
        $("#" + obj).show();
    }
};

function FechaMenuAcoes(obj) {
    $("#" + obj).hide();
};


function clicouEstado() {
    $.post("?ListaCidadesPorEstado", { estado: $("#Estado").val() }, function (data) {
        $("#dvCidades").empty().append(data);
    });
};

function clicou() {
    
}

function gravaContato() {

}

function CarregaFuncoesIniciais() {
    SuspendeHintInput();
    SuspendeHintSelect();
};

function SuspendeHintInput() {
    var Inputs = document.getElementsByTagName('input');

    for (var i = 0; i < Inputs.length; i++) {
        if (Inputs[i].className == 'textstyle titleHintBox') {
            Inputs[i]._title = Inputs[i].title;
            Inputs[i].onmouseover = function () {
                this.title = '';
            }
            Inputs[i].onmouseout = function () {
                this.title = this._title;
            }
        }
    }

};

function SuspendeHintSelect() {
//    var Inputs = document.getElementsByTagName('select');

//    for (var i = 0; i < Inputs.length; i++) {
//        if (Inputs[i].className == 'textstyle titleHintBox') {
//            Inputs[i]._title = Inputs[i].title;
//            Inputs[i].onmouseover = function () {
//                this.title = '';
//            }
//            Inputs[i].onmouseout = function () {
//                this.title = this._title;
//            }
//        }
//    }
};


function checaCaps(e) {
    kc = e.keyCode ? e.keyCode : e.which;
    sk = e.shiftKey ? e.shiftKey : ((kc == 16) ? true : false);
    if (((kc >= 65 && kc <= 90) && !sk) || ((kc >= 97 && kc <= 122) && sk))
        document.getElementById('caps').style.visibility = 'visible';
    else
        document.getElementById('caps').style.visibility = 'hidden';     
}


function gravaSugestaoTelefone() {

}

function gravaSugestaoTelefoneNovosDocumentos() {

}




function gravaSugestaoEmail() {

}

function gravaSugestaoEmailNovosDocumentos() {

}


function AvaliarTel() {
    
}

function AvaliarTelSugerido() {
    
}

function AvaliarEnd() {
    
}

function habilitaPF() {
    if ($("#ppf").attr("checked")) {
        $("#pf").show();
        $("#lb_nome").show();
    }
    else {
        $("#pf").hide();
        $("#lb_nome").hide();
    }

    if ($("#ppf").attr("checked") && $("#ppj").attr("checked")) {
        $("#lb_separa").show();
    } else {
        $("#lb_separa").hide();
    }
}

function habilitaPJ() {
    if ($("#ppj").attr("checked")) {
        $("#pj").show();
        $("#dv_ramo_atividade").show();
        $("#lb_razao_social").show();
    }
    else {
        $("#pj").hide();
        $("#dv_ramo_atividade").hide();
        $("#lb_razao_social").hide();
    }

    if ($("#ppf").attr("checked") && $("#ppj").attr("checked")) {
        $("#lb_separa").show();
    } else {
        $("#lb_separa").hide();
    }
}

function podeMudarPF() {
    if (!$("#ppf").attr("checked") && !$("#ppj").attr("checked"))  {
        $("#ppf").attr("checked", "checked");
    }
}

function podeMudarPJ() {
    if (!$("#ppf").attr("checked") && !$("#ppj").attr("checked")) {
        $("#ppj").attr("checked", "checked");
    }

}

function hideConsulta() {
    $("#pesquisaCPF").hide();
    $("#menuLateral").hide();
}

function showConsulta() {
    $("#pesquisaCPF").show();
    $("#detalhe").hide();    
    $("#combinada").show();
    $("#menuLateral").hide();
}


function gravaPergunta() {

}

function aprovarSuporte(idBase, idSuporte) {
   
}

function gravaAvaliacaoSuporte() {

   
}

//RHB
function gravaSolicitacaoResetSenha() {
    
}


function fazBusca() {
   
}

//RHB
//Lista de usuários
function usuarioAdminLista() {
    $.post("/Administracao/ListaUsuarios", "", function (data) {
        $("#conteudo").empty().append(data);        
    });
}

//RHB
function verificaDisponibilidadeLogin() {
$.post("/Administracao/VerificaDisponibilidadeLogin", { Login: $("#Login").val() }, function (data) {
        $("#Erro").empty().append(data);
    });
}

function carregaProdutosPerfil() {
    if ($("input:checkbox:[name='chkPerfilAcessoConsulta']").is(":checked")) {
        $.post("/Administracao/ListaProdutosEmpresa", { idProduto: $("input:checkbox:[name='chkPerfilAcessoConsulta']").val(), status: "1", idUsuario: $("#IdUsuario").val() }, function (data) {
        $("#ProdutosEmpresa").empty().append(data);
        });
    }else
        if ($("input:checkbox:[name='chkPerfilAcessoConsulta']").not(":checked")) {
            $.post("/Administracao/ListaProdutosEmpresa", { idProduto: $("input:checkbox:[name='chkPerfilAcessoConsulta']").val(), status: "0", idUsuario: "0" }, function (data) {
            $("#ProdutosEmpresa").empty().append(data);
        });
    }
}

//RHB - ADM
function filtraGridUsuarios() {
    $("#load").show();
    $.post("/Administracao/ListaUsuarios", { ddlFiltro: $("#ddlFiltro").val(), ddlLogin: $("#ddlLogin").val(), LimpaFiltro: "true"  }, function (data) {
        $("#lista-usuarios").empty().append(data);
        $("#load").hide();
    });
}

//RHB - EMANAGER
function filtraGridUsuariosEmanager() {
    $("#load").show();
    $.post("/Administracao/ListaUsuariosAdm", { ddlFiltro: $("#ddlFiltro").val(), ddlEmpresa: $("#ddlEmpresa").val(), ddlContrato: $("#ddlContrato").val(),IdGrupo: $("#IdGrupo").val()}, function (data) {
        $("#listaNova").empty().append(data);
        $("#load").hide();
    });
}

//RHB - ADM
function filtraUsuarioLogin() {
    $("#load").show();
    $.post("/Administracao/ListaUsuarios", { ddlFiltro: $("#ddlFiltro").val(), ddlLogin: $("#ddlLogin").val(), LimpaFiltro: "false" }, function (data) {
        $("#lista-usuarios").empty().append(data);
        $("#load").hide();
    });
}

function carregaDropDownListEmpresas() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresas", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

function carregaDropDownListEmpresasDashboard() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasDashboard", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

function carregaDropDownListEmpresasRelatorioUsuarios() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasUsuarios", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}


function carregaDropDownListEmpresasUsuarios() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Administracao/LoadDropDownListEmpresasUsuarios", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

function carregaDropDownListEmpresasExtracao() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasExtracao", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

function carregaDropDownListEmpresasExtracaoNovoPedido() {
    $("#ddl_empresas_novo_pedido").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasExtracao", { fgBloqueado: $("#fgBloqueadoNovoPedido").prop('checked') }, function (data) {
        $("#ddl_empresas_novo_pedido").empty().append(data);
    });
}


function carregaDropDownListEmpresasConsultas() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasConsultas", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

function carregaDropDownListEmpresasServicos() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasServicos", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

function carregaDropDownListEmpresasAtualizacao() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasAtualizacao", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

//RHB - Relatório Usuários
function filtrarRelatorioUsuariosLista() {
    $("#load").show();
    $.post("/Relatorios/FiltrarUsuarios", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), EmpresaID: $("#ddlEmpresa").val()}, function (data) {
        $("#relatorio_conteudo").empty().append(data);
        $("#load").hide();
    });
}

//RHB - Relatório Atualização
function filtrarRelatorioAtualizacao() {
    $("#load").show();
    $.post("/Relatorios/FiltrarAtualizacao", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), ddlLogin: $("#ddlLogin").val(), EmpresaID: $("#ddlEmpresa").val(), TipoPessoa: $("#TipoPessoa").val(), IdJob: $("#IdJob").val() }, function (data) {
        $("#relatorio_conteudo").empty().append(data);
        $("#load").hide();
    });
}


//RHB - Relatório Consulta Web
function filtrarRelatorioConsultaWeb() {
    $("#load").show();
    $.post("/Relatorios/FiltrarConsultaWeb", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), ddlLogin: $("#ddlLogin").val(), EmpresaID: $("#ddlEmpresa").val(), idFonte: $("#idFonte").val(), IdJob: $("#IdJob").val() }, function (data) {
        $("#relatorio_conteudo").empty().append(data);
        $("#load").hide();
    });
}

function carregaDropDownListEmpresasConsultaWeb() {
    $("#ddl_empresas").empty().append("Carregando ...");
    $.post("/Relatorios/LoadDropDownListEmpresasConsultaWeb", { fgBloqueado: $("#fgBloqueado").prop('checked') }, function (data) {
        $("#ddl_empresas").empty().append(data);
    });
}

//LEO
function filtrarRelatorioUsuariosListaEmPDF() {
    $("#load").show();
    $.post("/Relatorios/FiltrarUsuariosEmPDF", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), Modulo: $("#Modulos").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), Servicos: $("#ddlServicos").val(), EmpresaID: $("#ddlEmpresa").val() }, function (data) {

        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();

        $("#load").hide();
    });
}


//RHB
function filtrarRelatorioUsuariosGrafico() {
    $("#load").show();
    $.post("/Relatorios/FiltrarUsuariosGrafico", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), EmpresaID: $("#ddlEmpresa").val() }, function (data) {       
        $("#relatorio_conteudo").empty().append(data);
        $("#load").hide();
    });
}

//RHB
function LimpaDivMaisFiltros() {
    $("#maisFiltros").empty();
    $("#div_relatorio_servicos").html(null);
    //desabilitar botão do gráfico
    estadoBotao("btGraficoServicos", false);
    $('#btGraficoServicos').attr('disabled', true);
}

//RHB - Relatório Consultas
function filtrarRelatorioConsultasLista() {
    $("#load").show();
    $.post("/Relatorios/FiltrarConsultas", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), ddlIP: $("#ddlIP").val(), Servicos: $("#ddlServicos").val(), EmpresaID: $("#ddlEmpresa").val() }, function (data) {        
        $("#div_relatorio_consultas").empty().append(data);
        $("#load").hide();
    });
}

function ListaUsuariosPorEmpresa() {
    $("#load").show();
    $.post("/Atualizacao/Usuarios", { idEmpresa: $("#ddlEmpresa").val() }, function (data) {
        $("#load").hide();
        $("#listaNova").empty().append(data);        
    });
}

function ListaUsuariosPorEmpresaAdm() {
    if ($("#ddlEmpresa").val() != "0") {
        $.post("/Administracao/ListaUsuariosAdm", { ddlFiltro: $("#ddlFiltro").val(), ddlEmpresa: $("#ddlEmpresa").val(), ddlContrato: $("#ddlContrato").val(), IdGrupo: 0 }, function (data) {
            $("#listaNova").empty().append(data);
            DDLCentroCusto();
            $("#load").hide();
        });
    } else {
        $("#listaNova").empty();
        $("#filter").val("");
        $("#btnBusca").show();
    }
}

function ListaUsuariosPorContratoAdm() {
    $("#load").show();
    if ($("#ddlEmpresa").val() != "0") {
        $.post("/Administracao/ListaUsuariosAdm", { ddlFiltro: $("#ddlFiltro").val(), ddlEmpresa: $("#ddlEmpresa").val(), ddlContrato: $("#ddlContrato").val(), IdGrupo: $("#IdGrupo").val() }, function (data) {
            $("#listaNova").empty().append(data);
            $("#load").hide();
        });
    } else {
        $("#listaNova").empty();
        $("#filter").val("");
        $("#btnBusca").show();
    }
}

function DDLCentroCusto() {
    $("#load").show();
    if ($("#ddlEmpresa").val() != "0") {
        $.post("/Administracao/DDLCentroCusto", { idEmpresa: $("#ddlEmpresa").val() }, function (data) {
            $("#ddlCC").empty().append(data);
        });
    } else {
        $("#listaNova").empty();
        $("#filter").val("");
        $("#btnBusca").show();
    }
    $("#load").hide();
}

function ListaUsuariosPorCentroCusto() {
    $("#load").show();
    if ($("#ddlEmpresa").val() != "0") {
        $.post("/Administracao/ListaUsuariosAdm", { ddlFiltro: $("#ddlFiltro").val(), ddlEmpresa: $("#ddlEmpresa").val(), ddlContrato: $("#ddlContrato").val(), IdGrupo: $("#IdGrupo").val() }, function (data) {
            $("#listaNova").empty().append(data);
        });
    } else {
        $("#listaNova").empty();
        $("#filter").val("");
        $("#btnBusca").show();
    }
    $("#load").hide();
}

function NovoUsuarioAdm() {
    $("#load").show();
    $.get("/Administracao/UsuarioIdentificacao", { idEmpresa: $("#ddlEmpresa").val() }, function (data) {
        $("#load").hide();
        $("#ListaUsuariosAdm").empty().append(data);
    });
}

function ListaLoginUsuarioAdm() {
    $("#load").show();
    $.post("/Administracao/ListaLoginUsuariosAdm", { login: $("#filter").val(), ddlFiltro: $("#ddlFiltro").val(), ddlContrato: $("#ddlContrato").val() }, function (data) {
        $("#load").hide();
        $("#listaNova").empty().append(data);
    });
}

function EditarUsuarioAdm(id) {
    $("#load").show();
    $.get("/Administracao/AlterarUsuarioIdentificacao", { idUsuario: id }, function (data) {
        $("#load").hide();
        $("#ListaUsuariosAdm").empty().append(data);
    });
}

function ListaUsuariosFacebook() {
    $("#load").show();
    $.post("/Administracao/UsuariosFacebook", { idEmpresa: $("#ddlEmpresa").val() }, function (data) {
        $("#load").hide();
        $("#listaNova").empty().append(data);
    });
}

function AlteraFacebook(value) {
    $.post("/Administracao/AlteraFacebook", { Id: value, NovoLimite: $("#" + value).val() }, function (data) {
        $("#retorno").empty().append(data);
    });
}

//LF - Relatório Consultas PDF
function filtrarRelatorioConsultasListaEmPDF() {
    $("#load").show();
    $.post("/Relatorios/FiltrarConsultasEmPDF", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), ddlIP: $("#ddlIP").val(), Servicos: $("#ddlServicos").val(), EmpresaID: $("#ddlEmpresa").val() }, function (data) {

        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();

        $("#load").hide();

    });
}


//LF - Lista Usuario PDF
function ListaUsuariosLightBoxEmPDF() {
    $("#load").show();
    $.post("/Relatorios/ListaUsuariosLightBoxEmPDF", { NomeEmpresa: $("input:hidden[name='NomeEmpresa']").val(), IdEmpresa: $("input:hidden[name='IdEmpresa']").val(), fl_dtInicio: $("input:hidden[name='fl_dtInicio']").val(), fl_dtFim: $("input:hidden[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val() }, function (data) {

        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();

        $("#load").hide();

    });
}

function ListaConsultasLightBoxEmPDF() {
    $("#load").show();
    $.post("/Relatorios/ListaConsultasLightBoxEmPDF", { NomeEmpresa: $("input:hidden[name='NomeEmpresa']").val(), IdEmpresa: $("input:hidden[name='IdEmpresa']").val(), fl_dtInicio: $("input:hidden[name='fl_dtInicio']").val(), fl_dtFim: $("input:hidden[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val() }, function (data) {

        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();

        $("#load").hide();

    });
}


function ListaServicosLightBoxEmPDF() {
    $("#load").show();
    $.post("/Relatorios/ListaServicosLightBoxEmPDF", { NomeEmpresa: $("input:hidden[name='NomeEmpresa']").val(), IdEmpresa: $("input:hidden[name='IdEmpresa']").val(), fl_dtInicio: $("input:hidden[name='fl_dtInicio']").val(), fl_dtFim: $("input:hidden[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val() }, function (data) {

        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();

        $("#load").hide();

    });
}


//LF - Relatório Consultas Impressao
function filtrarRelatorioConsultasListaImpressao() {
    $("#load").show();
    $.post("/Relatorios/FiltrarConsultasImpressao", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), ddlIP: $("#ddlIP").val(), Servicos: $("#ddlServicos").val(), EmpresaID: $("#ddlEmpresa").val() }, function (data) {


        var mywindow = window.open('', 'impressao', 'width=700,height=600,scrollbars=yes');
        mywindow.document.write('<html><head><title>ZipCode</title>');
        mywindow.document.write('<link href="../Content/css/estilo_zip_impressao.css" rel="stylesheet" type="text/css" />');
        mywindow.document.write('</head><body><div class="zip_main"><div class="zip_main_corpo"><div class="zip_main_content">');
        mywindow.document.write(data);
        mywindow.document.write('</div></div></div></body></html>');
        mywindow.document.close();
        mywindow.print();
        $("#load").hide();
    });
};


//RHB
function filtrarRelatorioConsultasGrafico() {
    $("#load").show();
    $.post("/Relatorios/FiltrarConsultasGrafico", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), ddlIP: $("#ddlIP").val(), Servicos: $("#ddlServicos").val(), EmpresaID: $("#ddlEmpresa").val() }, function (data) {        
        $("#div_relatorio_consultas").empty().append(data);
        $("#load").hide();
    });
}

//Relatório Consultas Gráfico (PDF)
function filtrarRelatorioConsultasGraficoEmPDF() {
    $("#load").show();
    $.post("/Relatorios/FiltrarConsultasGraficoEmPDF", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), TipoContrato: $("#TipoContrato").val(), ddlLogin: $("#ddlLogin").val(), ddlIP: $("#ddlIP").val(), Servicos: $("#ddlServicos").val(), EmpresaID: $("#ddlEmpresa").val() }, function (data) {
        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();

        $("#load").hide();
    });
}


function filtrarRelatorioExtracaoLista() {
    $("#load").show();
    $.post("/Relatorios/ListaPedidosFiltro", { idEmpresa: $("#ddlEmpresa").val(), Mes: $("#ddlMes").val() }, function (data) {
        $("#relatorio_conteudo_extracao").empty().append(data);
        $("#load").hide();
    });
}

//Relatório de atualização (PDF)
function PDFRelatorioAtualizacao(idJob) {
    $("#load").show();

    $.post("/Atualizacao/PDFRelatorioAtualizacao", { JOB: idJob }, function (data) {
        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();
        $("#load").hide();
    });

}

function PDFRelatorioAtualizacaoAdm() {
    $("#load").show();
    $.post("/Relatorios/FiltrarAtualizacaoEmPDF", { fl_dtInicio: $("input:text[name='fl_dtInicio']").val(), fl_dtFim: $("input:text[name='fl_dtFim']").val(), ddlLogin: $("#ddlLogin").val(), EmpresaID: $("#ddlEmpresa").val(), TipoPessoa: $("#TipoPessoa").val() }, function (data) {
        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();
        $("#load").hide();
    });

}


//Relatório de atualização (PDF)
function PesquisaDashbordEmPDF(idJob) {
    $("#load").show();

    var dt_inicial = $("#DtInicial").val();
    var tp_contrato = $("#TipoContrato").val();
    var empresa = $("#ddlEmpresa").val();

    $.post("/Relatorios/PesquisaDashboardPDF", { DtInicial: dt_inicial, TipoContrato: tp_contrato, ddlEmpresa: empresa }, function (data) {
        var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
        mywindow.document.write('<html><head><title>ZipCode</title>');

        var str_embed = "<embed src=\"" + data + "\" width=\"100%\" height=\"100%\">";
        mywindow.document.write(str_embed);

        mywindow.document.write('</body></html>');

        mywindow.focus();
        $("#load").hide();
    });

}


//RHB
function ExportElem(url) {
    window.open(url, 'exportação', 'width=1000,height=800,scrollbars=yes');
}

//RHB
function PrintElem(elem) {
    var data = $(elem).html().toString();

    var mywindow = window.open('', 'impressao', 'width=1000,height=800,scrollbars=yes');
    mywindow.document.write('<html><head><title>ZipCode</title>');
    mywindow.document.write('<link href="../Content/css/estilo_zip.css" rel="stylesheet" type="text/css" />');
    mywindow.document.write('<style type="text/css"> #pageNavPosition2{display:none;}#btAcoes{display:none;}</style>');
    mywindow.document.write('</head><body><div class="zip_main"><div class="zip_main_corpo"><div class="zip_main_content">');       
    mywindow.document.write(data);
    mywindow.document.write('</div></div></div></body></html>');
    mywindow.document.close();
    mywindow.print();
    return true;
}

//LEO
function ImprimeModel(elem, url_action) {
    $.ajax({
        type: 'post',
        url: url_action,
        data: JSON.stringify(elem),
        contentType: "application/json; charset=utf-8",
        traditional: true,
        success: function (data) {
            var mywindow = window.open('', 'impressao', 'width=700,height=600,scrollbars=yes');
            mywindow.document.write('<html><head><title>ZipCode</title>');
            mywindow.document.write('<link href="../Content/css/estilo_zip_impressao.css" rel="stylesheet" type="text/css" />');
            mywindow.document.write('</head><body><div class="zip_main"><div class="zip_main_corpo"><div class="zip_main_content">');
            mywindow.document.write(data);
            mywindow.document.write('</div></div></div></body></html>');
            mywindow.document.close();
            mywindow.print();
        }
    });
}

function ExportaPDF(elem, url_action) {

    $.ajax({
        type: 'POST',
        url: url_action,
        data: JSON.stringify(elem),
        contentType: "application/json; charset=utf-8",
        traditional: true,
        success: function (msg) {

            var mywindow = window.open('', 'pdf', 'width=700,height=600,scrollbars=yes,resizable=1');
            mywindow.document.write('<html><head><title>ZipCode</title>');

            var str_embed = "<embed src=\"" + msg + "\" width=\"100%\" height=\"100%\">";
            mywindow.document.write(str_embed);

            mywindow.document.write('</body></html>');

            mywindow.focus();

        }
    });

};


function UrlGraficoQualificacao(action, validos, invalidos) {

    $("#load").show();
    $.post(action, { Validos: validos, Invalidos: invalidos }, function (data) {
        return data;
    });

}


function htmlEncode(value) {
    if (value) {
        return jQuery('<div />').text(value).html();
    } else {
        return '';
    }
}

function htmlDecode(value) {
    if (value) {
        return $('<div />').html(value).text();
    } else {
        return '';
    }
}


//RHB - DatePicker
$(function () {
    $.datepicker.setDefaults($.datepicker.regional['pt-BR']);
    $("#datepicker").datepicker();
    $("#datepicker2").datepicker();
});
//RHB
function salvaBloqueioEmpresa() {
    if ($("input:radio:[name='MotivoBloqueio']").is(":checked")) {
        $("#load").show();
        var Opcao = "";
        $('input:radio[name=MotivoBloqueio]').each(function() {
            if ($(this).is(':checked'))
                Opcao = parseInt($(this).val());
        });
        //POST
        $.post("/Administracao/GravaBloquearEmpresa", { Id: $("#Id").val(), idBloqueio: Opcao }, function (data) {
            $("#padrao").hide();
            $("#retorno").empty().append(data);
            location.reload(true);
            $("#load").hide();
        });
    } else {
        alert('Por favor, escolha um motivo.');
    }
}

//RHB
function salvaDesbloqueioEmpresa() {
    if ($("input:radio:[name='MotivoBloqueio']").is(":checked")) {
        $("#load").show();
        var Opcao = "";
        $('input:radio[name=MotivoBloqueio]').each(function() {
            if ($(this).is(':checked'))
                Opcao = parseInt($(this).val());
        });
        //POST
        $.post("/Administracao/GravaDesbloquearEmpresa", { Id: $("#Id").val(), idBloqueio: Opcao }, function (data) {
            $("#padrao").hide();
            $("#retorno").empty().append(data);
            location.reload(true);
            $("#load").hide();
        });
    } else {
        alert('Por favor, escolha um motivo.');
    }
}

function AlteraLimite(value) {

    $("#btnGravar").hide();

    $.post("/Atualizacao/AlteraLimite", { Id: value, NovoLimite: $("#LimiteDocumentos").val() }, function (data) {
        $("#retorno").empty().append(data);
    });
}

function AlteraLimiteConsultaWeb(value) {

    $("#btnGravar").hide();

    $.post("/ConsultaWeb/AlteraLimite", { Id: value, NovoLimite: $("#LimiteDocumentos").val() }, function (data) {
        $("#retorno").empty().append(data);
    });
}

//RHB - AntiFraudeAdm
function ListaPoliticasPorEmpresa() {
    $("#load").show();
    $.post("/AntiFraudeAdm/ListaPoliticas", { idEmpresa: $("#ddlEmpresa").val() }, function (data) {
        $("#load").hide();
        $("#ListaPoliticasEmpresa").empty().append(data);
    });
}

//RHB - Administracao - CadastroIP
function CarregaRangeIP() {
    $("#load").show();
    $.post("/Administracao/ListaEmpresaIP", { idEmpresa: $("#ddlEmpresa").val() }, function (data) {
        $("#lista-usuarios").empty().append(data);
        $("#load").hide();
    });
}

function CarregaUsuariosCC() {
    $("#load").show();
    $.post("/Administracao/ListaUsuariosCC", { idGrupo: $("#ddlCentroCusto").val(), idEmpresa: $("#ddlEmpresa").val()}, function (data) {
        $("#usuariosCC").empty().append(data);
        $("#load").hide();
    });
}


function CarregaDropDownCC() {
    $("#load").show();
    $.post("/Administracao/ListaCcEmpresa", { idEmpresa: $("#ddlEmpresa").val(), idGrupo: $("#ddlCentroCusto").val()}, function (data) {
        $("#ddlCC").empty().append(data);
        $("#load").hide();
    });
}


function CadastrarCentroCusto() {
    $("#load").show();
    var nome = $("#Descricao").val();
    $.post("/Administracao/NovoCentroCusto", { nomeCC: nome, idEmpresa: $("#ddlEmpresa").val() }, function (data) {
        $("#cc").empty().append(data);
        CarregaDropDownCC();
        $("#load").hide();
    });
}

//RHB - Administracao - Perfil
//function AlterarPerfil(idPerfil) {
//    $("#load").show();
//    $.post("/Administracao/AlterarPerfil", { idPerfil: idPerfil}, function (data) {
//        $("#retornoAlterarPerfil").empty().append(data);
//        $("#load").hide();
//    });
//}

//RHB - Facebook
function FacebookSendPJ(idfacebook, username) {
    $.get("/Consultas/FacebookSendPJ", { idFacebook: idfacebook, username: username }, function (data) {
        $("#content").empty().append(data);
    });
};

function RegistraInteresseConfigMsgFacebook() {
    $.post("/Consultas/RegistraInteresseConfigMsgFacebook", {}, function (data) {
        $("#padrao").empty().append(data);
    });
}

function EnviaMailFacebook() {
    $("#load").show();

    var username = $("#username").val();
    var documento = $("#doc_mascarado").val();
    var nome = $("#nome").val();
    var ddd = $("#ddd").val();
    var telefone = $("#telefone").val();
    var email = $("#email").val();
    var idMsg = 1; //$("#ddTitulos option:selected").val();
    var nrdocumento = $("#nrDocumento").val();
    var idbase = $("#idBaseConsultado").val();
    var idfacebook = $("#idFaceBook").val();

    if (ddd != "" && telefone != "" && email != "") {
        if (emailValido(email)) {
            $.post("/Consultas/EnviaMailFacebook", { username: username, documento: documento, nrDocumento: nrdocumento, nome: nome, ddd: ddd, telefone: telefone, email: email, idMensagem: idMsg, idBase: idbase, idFaceBook: idfacebook }, function (data) {
                $("#conteudo").hide();
                $("#retorno").empty().append(data);
            });
        } else {
            $("#msg_erro").text("Digite e-mail válido");
            $("#msg_erro").show();
        }
    } else {
        $("#msg_erro").text("Preencher todos os campos");
        $("#msg_erro").show();
    }

    $("#load").hide();
}

function filtrarAdmAtualizacaoCampos() {
    $("#load").show();
    $.post("/Atualizacao/ListarCampos", { idUsuario: $("#IdUsuario").val(), idEmpresa: $("#IdEmpresa").val(), publico: $("#ddlPublico").val() }, function (data) {
        $("#campos").empty().append(data);
        $("#load").hide();
    });
}

function ValidaLogin() {

    var reg = /^[a-zA-Z0-9-_\.@]*$/;

    $('#Erro').show();

    if (!reg.test($("#Login").val())) {

        $('#Erro').text('Login Inválido!');
        $('#Erro').css({ color: "red"});
        $('#Login').addClass('input-validation-error');

    }else{
        $('#Erro').text('');
        $('#Erro').css({ color: "#693906"});
        $('#Login').removeClass('input-validation-error');

    }
};

function zebrarTabela() {
    //tabela zebrada
    $('#table tbody tr:even').addClass("adm_tbl_bg");
    $('#table tbody tr:odd').addClass("adm_tbl_bg2");
}

//////////teste layout responsivo
//$(document).ready(function () {
//    layoutMobile();
//});

//function layoutMobile() {   
//    if(isMobile()) {
//        $(".zip_sidebar").addClass('zip_sidebar_responsivo');
//        $(".zip_container").addClass('zip_container_responsivo');
//        $(".zip_logo_topo").addClass('zip_logo_topo_responsivo');
//        $(".zip_ribbon_content").addClass('zip_ribbon_content_responsivo');
//        $(".zip_tu_footer").addClass('zip_tu_footer_responsivo');
//        $(".zip_sidebar").hide();
//        $("#menu_responsivo").show();
//        $('#menu_responsivo').click(function () {
//            $(".zip_sidebar").toggle("slow", function () {
                
//            });
//        });
//    }
//}

function isMobile()
{
    var userAgent = navigator.userAgent.toLowerCase();
    if( userAgent.search(/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i)!= -1 ) {
        return true;
    }else {
        return false;
    }     
}