<?php

require_once('config.php');

if(isset($_GET['pg']) == "editar")
{
    if(isset($_POST['editar']))
    {
        $Mensagem = new Sistema_Mensagem($_POST['get']);
        $Mensagem->setId(1);

        if($Mensagem->save())
        {
            $msg = "Configura&ccedil;&atilde;os alteradas com sucesso.";
            $util->ir('./Mensagem?pg=editar&id=1',$msg,'info');
        }
        else
        {
            $msg = "Ocorreu um erro ao editar as configura&ccedil;&atilde;os.";
            $util->ir('./Mensagem?pg=editar&id=1',$msg,'info');
        }
    }
    $Mensagem = new Sistema_Mensagem();
    $Mensagem->setId(1);
    $smarty->assign('res',$Mensagem->find()); 
    
    $smarty->assign('pg','editar');
}
else
{
    $Mensagem = new Sistema_Mensagem();
    $Mensagem->setId(1);
    $smarty->assign('res',$Mensagem->fetchAll()); 
}

$smarty->assign('Miolo','include_mensagem.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 