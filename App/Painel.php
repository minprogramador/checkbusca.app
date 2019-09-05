<?php

require_once('config/index.php');
require_once("checkAuth.php");

if($_SESSION['getStatus'] == 8)
{
	header("Location: ./FormaPagamento");
	die;
}

$plano = new Sistema_Planos();
$plano->setId($_SESSION['getId']);
$info = $plano->ListaInfo();
$smarty->assign('inPlano',$info);

if($util->countData($info['vencimento']) <= 0)
{
	$usuarios = new Sistema_Usuarios();
	$usuarios->setId($_SESSION['getId']);
	$usuarios->mudaStatus();
	unset($usuarios);
	header("Location: ./FormaPagamento?renovar");
	die;
}

$util = new Sistema_Util();
$smarty->assign('CountVencimento',$util->countData($info['vencimento']));
	
$usuario = new Sistema_Usuarios();
$usuario->setUsuario($_SESSION['getUsuario']);
$inf = $usuario->getRes();

$re  = $inf['servicos'];
$re  = explode(',',$re);
$re  = str_replace(' ', '', $re);
$smarty->assign('Servicos',$re);

$titulo_interna    = "Menu de Serviços";

if($util->countData($info['vencimento']) <= 2)
{
	$smarty->assign('pagrec','renovar');
}
$smarty->assign('Titulo_interna',$titulo_interna);
$smarty->assign("Pagina","Painel de servi&ccedil;os");
$smarty->assign('Miolo','include_painel.html');
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html');
