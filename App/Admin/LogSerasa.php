<?php
require_once('config.php');


if(isset($_POST['mes']))
{
    $log = new Sistema_Logs();
    if(isset($_REQUEST['id']))
    {
        $id = $_REQUEST['id'];
    }
    else
    {
        $id = null;
    }
    
    $a = $log->selecMesSerasa($_POST['mes'],$id);
    $smarty->assign('res',$a);
    $smarty->assign('Miolo','include_logsSerasa.html');
    $smarty->assign('Titulo_interna',"Painel Administrativo");
    $smarty->assign("Pagina","Painel Administrativo");    
    $smarty->assign('Container','include_interna.html');
    $smarty->assign('Topo','include_topo.html');
    $smarty->assign('Lateral','include_lateral.html');
    $smarty->display('main.html'); 
    die;
}

if(isset($_POST['DellLogs']))
{
    $cats = ($_POST['check']);
    foreach($cats as $key => $value)
    {
        $log = new Sistema_Logs();
        $log->setId($util->xss($value));
        $log->deleteSerasa();
    } 

    $msg = "Logs deletados com sucesso!";
    
    if(isset($_GET['id']))
    {
        $util->ir('./LogSerasa?id='.$util->xss($_GET['id']),$msg,'info');
    }
    else
    {
        $util->ir('./LogSerasa',$msg,'info');
    }
}
elseif(isset($_POST['dellFull']))
{
	$log = new Sistema_Logs();
    $log->dellFullSerasa();

    $msg = "Todos os logs foram, deletados com sucesso!";
    
	$util->ir('./LogSerasa',$msg,'info');
}


$paginacao = new Sistema_Paginacao();
$paginacao->setTable('log_serasa');
$paginacao->setBase(30);
$paginacao->setPatch('page');


$total_records = $paginacao->getCount();

if(isset($_GET['page']))
{
    $page = $util->xss($_GET['page']);
}
else
{
    $page = null;
}

if ($page)
{
    $from = ($page * $paginacao->getBase()) - $paginacao->getBase();
}
else
{
    $from = 0;	
}

$paginacao->setLimite($from);
$paginacao->setMaximo($paginacao->getBase());
$paginacao->setPagina(PATCH.'/Admin/LogSerasa');

if(isset($_GET['id']))
{
    $resultArray = $paginacao->getDadosIdUser($util->xss($_GET['id']));
}
else
{

    $resultArray = $paginacao->getDados();
}

$smarty->assign('res',$resultArray);
$paginacao->setTotal($total_records);
$paginacao->doPagina();

if(!isset($_GET['id']))
{
    $smarty->assign('Controllers',$paginacao->getControl());
}

$smarty->assign('Miolo','include_logsSerasa.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 