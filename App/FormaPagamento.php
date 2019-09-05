<?php
#echo '<center style="padding-top:10px">.</center>';
   # die('Boleto indisponivel,renove ja Whats:51 984629791 Paulo');

require_once('config/index.php');
require_once("checkAuth.php");
//ultima alteracao em: 26/05/2019 15:30 ~ erro era no cpf, class Moip.
error_reporting(0);

if(isset($_GET['Boleto']))
{
	if(isset($_SESSION['linkMop']))
	{
		$util = new Sistema_Util();
		$re  = $util->curl($_SESSION['linkMop'],null,null,false);
		$re  = str_replace('src="img/','src="https://www.moip.com.br/img/',$re);
		$re  = str_replace('src="imgs/','src="https://www.moip.com.br/imgs/',$re);
		$ren = trim(rtrim(strip_tags($util->corta($re,'Cod. Cedente<br></font>','</font>'))));
		$re  = str_replace($ren,'----------',$re);
		echo $re;
		unset($_SESSION['linkMop']);
		die;
	}
	else
	{
		unset($_SESSION['linkMop']);
		die('Ocorreu um erro ao processar o boleto, retorne e tente novamente');
	}
}


if(isset($_GET['renovar']))
{
	$plano = new Sistema_Planos();
	$plano->setId_user($_SESSION['getId']);
		
	$info = $plano->getRes($_SESSION['getId']);
	$fatura = new Sistema_Faturas();	
	$fatura->setUsuario($info['id_usuario']);
		
	$re = $fatura->listUlFatura();
	
	if($re['status'] == 1)
	{
		if($re['status_fatura'] == 1)
		{
		
		$fatura->setData(date("Y-m-d"));
		$fatura->setVencimento(date('Y-m-d', strtotime("+10 days",strtotime(date("Y-m-d")))));
		$fatura->setPeriodo(30);
		$fatura->setValor($re['valor']);
		$fatura->setMetodo_pagamento(1);
		$fatura->setTipo(2);
		$fatura->setStatus(0);
		$fatura->setStatusFatura(0);
		$fatura->Criar();
		}
	}
}

if(isset($_GET['boleto']))
{
	$id   = $util->xss($_GET['id']);		
			
	$fatura = new Sistema_Fatura();
	$fatura->setId($id);
	$res = $fatura->find();
	
	$moip = new Sistema_Moip();
	$moip->setPeriodo($res['periodo']);
	$moip->setCodigo($id);
	$moip->setValor($res['valor']);
	$moip->setNome($_SESSION['getNome']);
	$moip->setEmail($_SESSION['getEmail']);
	
	$moip->setLogradouro('av jaguare');
	$moip->setNumero('325');
	$moip->setBairro('jaguare');
	$moip->setCidade('Sao Paulo');
	$moip->setEstado('SP');
	$moip->setCep('05346000');

	$moip->gerar();
	die;
}

if(isset($_GET['id']))
{
	if(isset($_POST['gateway']))
	{
		$tipo = $util->xss($_POST['gateway']);
		$id   = $util->xss($_GET['id']);
		
		$fatura = new Sistema_Faturas();
		$fatura->setUsuario($id);
		
		if($tipo == "2")
		{
			$fatura->setMetodo_pagamento("2");
		}
		else
		{
			$fatura->setMetodo_pagamento("1");
		}
		
		$fatura->upMetodo();	
		header("Location: ".PATCH."/FormaPagamento?id=$id");
		die;
	}
	else
	{
		$emaill[0] = 'paulinosilva16@rocketmail.com';
		$emaill[1] = 'miltom.jose@yahoo.com';
		$emaill[2] = 'rosamurilo86@yahoo.com';
		$numero = rand(0,2);
		$id   = $util->xss($_GET['id']);		

		$fatura = new Sistema_Fatura();
		$fatura->setId($id);
		$res = $fatura->find();

		$moip = new Sistema_Moip();
		$moip->setPeriodo($res['periodo']);
		$moip->setCodigo($id);
		$moip->setValor($res['valor']);
		$moip->setNome($_SESSION['getNome']);
		$moip->setEmail($emaill[$numero]);
	
		$moip->setLogradouro('av jaguare');
		$moip->setNumero('325');
		$moip->setBairro('jaguare');
		$moip->setCidade('Sao Paulo');
		$moip->setEstado('SP');
		$moip->setCep('05346000');

		if(isset($_REQUEST['banco']))
		{
			
			if($_REQUEST['banco'] == 'undefined')
			{
				#$lkmoip = "./FormaPagamento.php?boleto=true&id=".$id;//$moip->gerar(); // boleto
				$lkmoip = $moip->gerar(); // boleto
			}
			else
			{
				$lkmoip = $moip->Debito($util->xss($_REQUEST['banco'])); // debito
			}
		}
		else
		{
			#$lkmoip = "./FormaPagamento.php?boleto=true&id=".$id;//$moip->gerar(); // boleto
			$lkmoip = $moip->gerar(); // boleto

			$_SESSION['linkMop'] = $lkmoip;
			$lkmoip = "http://checkbusca.com/FormaPagamento?id=".$_GET['id']."&Boleto=true";
		}
	
		$smarty->assign('Link',$lkmoip);
		
		$id   = $util->xss($_GET['id']);
		$fatura = new Sistema_Faturas();
		$fatura->setUsuario($_SESSION['getId']);
		$res = $fatura->getWhere(" where id='$id' and id_usuario='".$_SESSION['getId']."' order by id desc Limit 1");
		
		if(count($res) > 1)
		{
			if($res['id_usuario'] != $_SESSION['getId'])
			{
				echo "ocorreu um erro.";
				die;
			}
		}
		else
		{
			echo "ocorreu um erro.";
			die;
		}
		
		$id = $util->xss($_GET['id']);
		$plano = new Sistema_Planos();
		$plano->setId($_SESSION['getId']);
		$info = $plano->ListaInfo();
		$smarty->assign('inPlano',$info);
				
		$util = new Sistema_Util();
		$smarty->assign('CountVencimento',$util->countData($info['vencimento']));
				
		$usuario = new Sistema_Usuarios();
		$usuario->setUsuario($_SESSION['getUsuario']);
		$inf = $usuario->getRes();
			
		$fatura = new Sistema_Faturas();
		$fatura->setUsuario($_SESSION['getId']);
		$fatura->setId($util->xss($_GET['id']));

		$titulo_interna    = "Faturas [".$id."]";
			
		$smarty->assign('Pg','Fatura');
		$smarty->assign('id',$id);
		$smarty->assign('Forma',$res['forma_pagamento']);
		$smarty->assign('fats',$res);

		$smarty->assign('infUser',$inf);
		$smarty->assign('Titulo_interna',$titulo_interna);
		$smarty->assign("Pagina","Painel de servi&ccedil;os");
		$smarty->assign('Miolo','include_faturas.html');
		$smarty->assign('Container','include_interna.html');
		$smarty->assign('Topo','include_topo.html');
		$smarty->assign('Lateral','include_lateral.html');
		$smarty->display('include_faturas.html');
		die;
	}
}


$plano = new Sistema_Planos();
$plano->setId($_SESSION['getId']);
$info = $plano->ListaInfo();
$smarty->assign('inPlano',$info);
	
$util = new Sistema_Util();
$smarty->assign('CountVencimento',$util->countData($info['vencimento']));
	
$usuario = new Sistema_Usuarios();
$usuario->setUsuario($_SESSION['getUsuario']);
$inf = $usuario->getRes();

$fatura = new Sistema_Faturas();
$fatura->setId($util->xss($_GET['id']));
$fatura->setUsuario($_SESSION['getId']);

$titulo_interna    = "Faturas, Formas de pagamento.";

$smarty->assign('fats',$fatura->getRes());
$smarty->assign('Titulo_interna',$titulo_interna);
$smarty->assign("Pagina","Painel de servi&ccedil;os");
$smarty->assign('Miolo','include_faturas.html');
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral2.html');
$smarty->display('main.html');
