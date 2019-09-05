<?php

require_once('config.php');


if(isset($_POST['editar'])) {

	$status = $_POST['get']['status'];
	if($status == 2){
		$status = "false";
	}else{
		$status = "true";
	}

	if(file_put_contents('../sixapi/config/.status', $status)) {
		$msg = "Configura&ccedil;&atilde;os alteradas com sucesso.";
		$util->ir('./Proxy',$msg,'info');
	}else{
		$msg = "Ocorreu um erro ao editar as configura&ccedil;&atilde;os.";
		$util->ir('./Proxy',$msg,'info');
	}
}else{
	$status = file_get_contents('../sixapi/config/.status');
	$dados = file_get_contents('../sixapi/config/config.json');

	if(stristr($status, 'true')) {
		$status = true;
	}else{
		$status = false;
	}
	include('../sixapi/config/contas.php');


// 	print_r($contas);
// //	echo json_decode($contas, true);
	// die;

	// $contas = file_get_contents('../sixapi/config/.cache');
	// $contas = json_decode($contas, true);

	

	$smarty->assign('res', $contas);
	$smarty->assign('status', $status);
	$smarty->assign('Miolo','include_proxy.html');
}


$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 