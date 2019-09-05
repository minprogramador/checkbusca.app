<?php
require_once('config.php');

if(isset($_POST['DellLogs']))
{
    $cats = ($_POST['check']);
    foreach($cats as $key => $value)
    {
        $log = new Sistema_Logs();
        $log->setId($util->xss($value));
        $log->delete();
    } 
    $msg = "Logs deletados com sucesso!";
    
    if(isset($_GET['id']))
    {
        $util->ir('./Logs?id='.$util->xss($_GET['id']),$msg,'info');
    }
    else
    {
        $util->ir('./Logs',$msg,'info');
    }
}
elseif(isset($_POST['dellFull']))
{
	$log = new Sistema_Logs();
    $log->dellFull();

    $msg = "Todos os logs foram, deletados com sucesso!";
    
	$util->ir('./Logs',$msg,'info');
}


$paginacao = new Sistema_Paginacao();
$paginacao->setTable('log_acesso');
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
$paginacao->setPagina(PATCH.'/Admin/Logs');

if(isset($_GET['id']))
{
    $resultArray = $paginacao->getDados($util->xss($_GET['id']));
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

$smarty->assign('Miolo','include_logs.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 