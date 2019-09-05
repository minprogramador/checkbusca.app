<?php

require_once('config.php');

if($_GET['pg'] == 'editar')
{
    if(isset($_POST['editar']))
    {
        $Conf = new Sistema_Verificacao();
        $Conf->setUsado($_POST['get']['usado']);
        $Conf->setLimite($_POST['get']['limite']);
        $Conf->setData($_POST['get']['tempo']);
        $Conf->setServico($_POST['get']['servico']);
        $Conf->setUlData($_POST['get']['ul_data']);
        $Conf->setStatus($_POST['get']['status']);
        $Conf->setId($_GET['id']);

        if($Conf->Alterar())
        {
            $msg = "Configura&ccedil;&atilde;os alteradas com sucesso.";
            $util->ir('./LimiteConsultas',$msg,'info');
        }
        else
        {
            $msg = "Ocorreu um erro ao editar as configura&ccedil;&atilde;os.";
            $util->ir('./LimiteConsultas',$msg,'info');
        }
    }
    
    $smarty->assign('pg','editar');
    $Conf = new Sistema_Verificacao();
    $Conf->setId($_GET['id']);
    $smarty->assign('res',$Conf->getResid());
}
else
{
    $Conf = new Sistema_Verificacao();
    $smarty->assign('res',$Conf->fetchAll());
}

$smarty->assign('Miolo','include_limite_serasa.html');

$smarty->assign('Titulo_interna',"Limite - Serasa - Painel Administrativo");
$smarty->assign("Pagina","Limite - Serasa");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 