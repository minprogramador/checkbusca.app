<?php
require_once('config.php');

/* Listar e ordenar usuarios */
$paginacao = new Sistema_Paginacao();
$paginacao->setTable('servicos');
$paginacao->setBase(25);
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
$resultArray = $paginacao->getDados();
$paginacao->setPagina(PATCH.'/Admin/Servicos');
$smarty->assign('res',$resultArray);
$paginacao->setTotal($total_records);
$paginacao->doPagina();
$smarty->assign('Controllers',$paginacao->getControl());
    
$smarty->assign('Miolo','include_servicos.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 