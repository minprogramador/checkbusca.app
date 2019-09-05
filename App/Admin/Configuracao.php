<?php

require_once('config.php');


if(isset($_GET['pg']))
{
    $pagina = $util->xss($_GET['pg']);
    
    if($pagina == "editar")
    {
        if(isset($_POST['editar']))
        {
            $Conf = new Sistema_Configuracao($_POST['get']);
            $Conf->setId(1);

            if($Conf->save())
            {
                $msg = "Configura&ccedil;&atilde;os alteradas com sucesso.";
                $util->ir('./Configuracao?pg=editar&id=1',$msg,'info');
            }
            else
            {
                $msg = "Ocorreu um erro ao editar as configura&ccedil;&atilde;os.";
                $util->ir('./Configuracao?pg=editar&id=1',$msg,'info');
            }
        }
        
        $Conf = new Sistema_Configuracao();
        $Conf->setId(1);
        $smarty->assign('res',$Conf->find()); 

        $smarty->assign('pg','editar');
        $smarty->assign('Miolo','include_config.html');
    }
    if($pagina == "editarMail")
    {
        if(isset($_POST['editar']))
        {
            $Email = new Sistema_Email($_POST['get']);
            $Email->setId(1);

            if($Email->save())
            {
                $msg = "Configura&ccedil;&atilde;os alteradas com sucesso.";
                $util->ir('./Configuracao?pg=editarMail&id=1',$msg,'info');
            }
            else
            {
                $msg = "Ocorreu um erro ao editar as configura&ccedil;&atilde;os.";
                $util->ir('./Configuracao?pg=editarMail&id=1',$msg,'info');
            }
        }
        
        $Email = new Sistema_Email();
        $Email->setId(1);
        
        $smarty->assign('res',$Email->find()); 
        $smarty->assign('pg','editar');
        $smarty->assign('Miolo','include_email.html');
    }
    elseif($pagina == "email")
    {
        $Email = new Sistema_Email();
        $Email->setId(1);
        
        $smarty->assign('res',$Email->fetchAll()); 
        $smarty->assign('Miolo','include_email.html');

    }
}
else
{
    $Conf = new Sistema_Configuracao();
    $Conf->setId(1);
    $smarty->assign('res',$Conf->fetchAll()); 
    $smarty->assign('Miolo','include_config.html');
}



$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 