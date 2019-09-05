<?php
require_once('config.php');

if($_GET['pg'] == 'editar')
{
    $id = $util->xss($_GET['id']);
    
    $serasa = new Sistema_Serasa($_POST['get']);
    $serasa->setId($id);
    
    $servico = new Sistema_Servicos();
    $smarty->assign('servs',$servico->fetchAll());
    
    $smarty->assign('pg','editar');
    $smarty->assign('get',$serasa->find());

    if(isset($_POST['editar']))
    {
        if($serasa->save())
        {
            $msg = "Conta alterada com sucesso.";
            $util->ir('./Contas?pg=editar&id='.$id,$msg,'info');
        }
        else
        {
            $msg = "Ocorreu um erro ao editar a conta.";
            $util->ir('./Contas?pg=editar&id='.$id,$msg);
        }
    }
}
elseif($_GET['conjunto'] == "listar")
{
	$paginacao = new Sistema_Paginacao();
    $paginacao->setTable('con_serasa');
    $paginacao->setBase(100);
    $paginacao->setPatch('page');
    $total_records = $paginacao->getCount();
       
    if(isset($_GET['page'])){ $page = $util->xss($_GET['page']); }
    else{ $page = null; }
       
    if ($page){ $from 	= ($page * $paginacao->getBase()) - $paginacao->getBase(); }
    else{ $from = 0; }
    
    $paginacao->setLimite($from);
    $paginacao->setMaximo($paginacao->getBase());
    $resultArray = $paginacao->getDados();
    $smarty->assign('res',$resultArray);
    $paginacao->setPagina(PATCH.'/Admin/Contas?conjunto=listar');
    $paginacao->setTotal($total_records);
    $paginacao->doPagina();
    $smarty->assign('Controllers',$paginacao->getControl());
	$smarty->assign('pg','list_serasa');
}
elseif($_GET['conjunto'] == "editar")
{
	$senhas = new Sistema_Senhas();
	$senhas->setId($id);
    $smarty->assign('conjun',$senhas->getCon());
    $smarty->assign('servs',$senhas->listarCc());
	$smarty->assign('pg','editar_conjunto');
	
	if(isset($_POST['editar_conjunto']))
	{
		$senhas = new Sistema_Senhas(@$_POST['get']);
		$senhas->setId($id);
		
		if($senhas->save()) 
		{
			$msg = "Conjunto alterado com sucesso!";
			$util->ir('./Contas?conjunto=editar&id='.$id,$msg,'info');
		}
		else
		{
			$msg = "Ocorreu um erro ao editar o conjunto.";
			$util->ir('./Contas?conjunto=editar&id='.$id,$msg);
		}
	}
}
elseif($_GET['conjunto'] == "add")
{
	$senhas = new Sistema_Senhas();
    $smarty->assign('servs',$senhas->listarCc());

	$smarty->assign('pg','add_conjunto');
	
	if(isset($_POST['cad_conjunto']))
	{
		$senhas = new Sistema_Senhas(@$_POST['get']);
		if($senhas->save()) 
		{
			$msg = "Conjunto salvo com sucesso!";
			$util->ir('./Contas?conjunto=listar',$msg,'info');
		}
		else
		{
			$msg = "Ocorreu um erro ao salvar o conjunto.";
			$util->ir('./Contas?conjunto=listar',$msg);
		}
	}
}


elseif($_GET['pg'] == 'cad')
{
    $serasa = new Sistema_Serasa($_POST['get']);
    
    if($_POST['cadastrar'])
    {
        if($_POST['get'])
        {
            $serasa->save();
            $msg = "Conta cadastrada com sucesso.";
            $util->ir('./Contas?pg=cad',$msg,'info');
        }
        else
        {
            $msg = "Ocorreu um erro ao cadastrar a conta.";
            $util->ir('./Contas?pg=cad',$msg);
        }
    }
    $servico = new Sistema_Servicos();
    $smarty->assign('servs',$servico->fetchAll());
    $smarty->assign('pg','cad');
}
elseif($_GET['pg'] == 'del')
{
    if($_GET['id'])
    {
        $serasa = new Sistema_Serasa();
        $serasa->setId($util->xss($_GET['id']));
        $serasa->delete();
        $msg = "Conta excluida com sucesso.";
        $util->ir('./Contas',$msg,'info');
    }
    else
    {
        $msg = "Conta excluida com sucesso.";
        $util->ir('./Contas',$msg,'info');
    }
}
else
{
    $paginacao = new Sistema_Paginacao();
    $paginacao->setTable('senhas');
    $paginacao->setBase(100);
    $paginacao->setPatch('page');
    $total_records = $paginacao->getCount();
       
    if(isset($_GET['page'])){ $page = $util->xss($_GET['page']); }
    else{ $page = null; }
       
    if ($page){ $from 	= ($page * $paginacao->getBase()) - $paginacao->getBase(); }
    else{ $from = 0; }
    
    $paginacao->setLimite($from);
    $paginacao->setMaximo($paginacao->getBase());
    $resultArray = $paginacao->getDados();
    $smarty->assign('res',$resultArray);
    $paginacao->setPagina(PATCH.'/Admin/Contas');
    $paginacao->setTotal($total_records);
    $paginacao->doPagina();
    $smarty->assign('Controllers',$paginacao->getControl());
}

$smarty->assign('Miolo','include_conta.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 