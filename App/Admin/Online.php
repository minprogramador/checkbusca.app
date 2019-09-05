<?php

require_once('config.php');
if(isset($_GET['ver']))
{
    $busca = base64_encode($util->xss($_GET['ver']));
    $url = PATCH."/Admin/Usuarios?pg=busca&usuario=$busca";
    header("Location: $url");
    die;
}
elseif(isset($_GET['d']))
{
	$Online->setUsuario(base64_decode($util->xss($_GET['d'])));
	$Online->setIp(base64_decode($util->xss($_GET['ip'])));
	$Online->Deslogar();
	$msg = "Usuario: ".base64_decode($util->xss($_GET['d'])).", deslogado com sucesso!";
	$util->ir('./Online',$msg,'info');
	die;
}

$Online = new Sistema_Online();

$smarty->assign('res',$Online->fetchAll()); 
$smarty->assign('Miolo','include_online.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 

