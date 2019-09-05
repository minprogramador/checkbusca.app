<?php

require_once('config.php');
error_reporting(0);
if(isset($_GET['pg']))
{
    $pagina = $util->xss($_GET['pg']);
    if($pagina == "busca")
    {
        $user = base64_decode($util->xss($_GET['usuario']));
        $usuario = new Sistema_Usuarios();
        $smarty->assign('res',$usuario->busca($user));
    }
    elseif($pagina == "editar")
    {
		$id = ($util->xss($_GET['id']));

        $Fatura = new Sistema_Faturas();
        $smarty->assign('pg','editar');
        $smarty->assign('get',$Fatura->getRes($id));
		
        if(isset($_POST['editar']))
    	{
			$idUser 		 = $util->xss($_POST['get']['usuario']);
			$data 			 = $util->xss($util->conData($_POST['get']['data']));
			$vencimento 	 = $util->xss($util->conData($_POST['get']['vencimento']));
			$periodo 		 = $util->xss($_POST['get']['periodo']);
			$valor 			 = $util->xss($_POST['get']['valor']);
			$forma_pagamento = $util->xss($_POST['get']['forma_pagamento']);
			$tipo 	         = $util->xss($_POST['get']['tipo']);
			$status 	     = $util->xss($_POST['get']['status']);
			$status_fatura   = $util->xss($_POST['get']['status_fatura']);
			
            $fatura = new Sistema_Faturas();
			$Fatura->setId($id);
			$Fatura->setData($data);
			$Fatura->setVencimento($vencimento);
			$Fatura->setPeriodo($periodo);
			$Fatura->setValor($valor);
			$Fatura->setForma($forma_pagamento);
			$Fatura->setTipo($tipo);
			$Fatura->setStatus($status);
			$Fatura->setStatusFatura($status_fatura);
			
			$Fatura->Alterar();
            $msg = "Fatura alterada com sucesso!";
            $util->ir('./Faturas?pg=editar&id='.$id,$msg,'info');
			die;
        }
    }
    elseif($pagina == "del")
    {
        if(isset($_GET['id']))
        {
            $fatura = new Sistema_Faturas();
            $fatura->setId($util->xss($_GET['id']));
            $fatura->delete();
            
            $msg = "Fatura deletada com sucesso!";
            $util->ir('./Faturas',$msg);
        }
        else
        {
            $msg = "Ocorre um erro ao deletar a fatura.";
            $util->ir('./Faturas',$msg);
        }
    }
}
else
{

	if(isset($_POST['FiltarFat']))
	{
		$paginacao = new Sistema_Paginacao();
		$idFatura = $util->xss($_POST['idFatura']);
		$idTrans  = $util->xss($_POST['idTrans']);
		$tipo     = $util->xss($_POST['tipo']);
		$formaPg  = $util->xss($_POST['formaPg']);
		$status   = $util->xss($_POST['status']);
		$datai    = $util->xss($_POST['datai']);
		$dataf    = $util->xss($_POST['dataf']);
		
		$idFatura = $util->xss($_POST['idFatura']);
		if(strlen($idFatura) > 0){ $idFatura = $idFatura; }else{ $idFatura = ''; }
		$idTrans  = $util->xss($_POST['idTrans']);
		if(strlen($idTrans) > 0){ $idTrans = $idTrans; }else{ $idTrans = ''; }
		$tipo     = $util->xss($_POST['tipo']);
		if(strlen($tipo) > 0){ $tipo = $tipo; }else{ $tipo = ''; }
		$formaPg  = $util->xss($_POST['formaPg']);
		if(strlen($formaPg) > 0){ $formaPg = $formaPg; if($formaPg == '9'){ $formaPg = '2,9'; } if($formaPg == '2'){ $formaPg = '2,9'; } }else{ $formaPg = ''; }
		$status   = $util->xss($_POST['status']);
		if(strlen($status) > 0){ if($status == 'true'){$status = '';}else{ $status = $status; } }else{ $status = ''; }
		$datai    = $util->conData($util->xss($_POST['datai']));
		if(strlen($datai) > 0){ $datai = $datai; }else{ $datai = ''; }
		$dataf    = $util->conData($util->xss($_POST['dataf']));
		if(strlen($dataf) > 0){ $dataf = $dataf; }else{ $dataf = ''; }
	
		$resultArray   = $paginacao->getDadosFaturas1($idFatura,$idTrans,$tipo,$formaPg,$status,$datai,$dataf);
		$total_records = count($resultArray);
		$val           = $paginacao->getValorFaturas1($idFatura,$idTrans,$tipo,$formaPg,$status,$datai,$dataf);
		$val = number_format($val[0]['ValorTotal'], 2, ',', '.'); 
		$smarty->assign('ValTotal',$val);;
		
	 	$total_records = $paginacao->getCount();
	    $smarty->assign('res',$resultArray);
	    $paginacao->setTotal($total_records);
	    $paginacao->doPagina();
		
	    if(!isset($_REQUEST['ordena'])) {$smarty->assign('Controllers',$paginacao->getControl()); }
	}
	else
	{
	    /* Listar e ordenar usuarios */
	    $paginacao = new Sistema_Paginacao();
	    $paginacao->setTable('fatura');
	    $paginacao->setBase(40);
	    $paginacao->setPatch('page');

	    if(isset($_GET['page'])) { $page = $util->xss($_GET['page']); }
	    else { $page = null; }
		
	    if ($page){ $from = ($page * $paginacao->getBase()) - $paginacao->getBase(); }
	    else { $from = 0; }
	    $paginacao->setPagina(PATCH.'/Admin/Faturas');
	    $paginacao->setLimite($from);
	    $paginacao->setMaximo($paginacao->getBase());

		if(isset($_REQUEST['ordena']))
		{
			$ordena = $util->xss($_REQUEST['ordena']);
			
			$resultArray = $paginacao->getDadosWhere(" where status='".$ordena."'");
		}
		else
		{
			$resultArray = $paginacao->getDados();
		}

	    $total_records = $paginacao->getCount();
	    $smarty->assign('res',$resultArray);
	    $paginacao->setTotal($total_records);
	    $paginacao->doPagina();
		
	    if(!isset($_REQUEST['ordena'])) {$smarty->assign('Controllers',$paginacao->getControl()); }
	}
}

$smarty->assign('Miolo','include_faturas.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 
