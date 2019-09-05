<?php
/*
 * Pagina checkAuth
 * Responsavel por verificar se o usuario esta On
 * Versao: 1.0
 * criada em 14/10/2011
 * Desenvolvedor: Brunno duarte.
 * contato: brunos.duarte@hotmail.com
 */
if(isset($_SESSION['getUsuario']))
{
    $plano = new Sistema_Planos();
    $plano->setId_user($_SESSION['getId']);

    if($res = $plano->VerificaData() == true)
    {
		$info = $plano->getRes($_SESSION['getId']);
		
		$usuario = new Sistema_Usuarios();
		$usuario->setUsuario($_SESSION['getUsuario']);
		$res      = $usuario->getRes();
		
		$fatura = new Sistema_Faturas();
		
		#verific
		$fatura->setUsuario($info['id_usuario']);

		$re = $fatura->listUlFatura();
		if($re['tipo'] == 1)
		{
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
					#limpa tudo
					$plano = new Sistema_Planos();
					$plano->clearFull($info['id_usuario']);
				}
			}
		}
		elseif($re['tipo'] == 2)
		{
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
					#limpa tudo
					$plano = new Sistema_Planos();
					$plano->clearFull($info['id_usuario']);
				}
			}
		}
    }
	
	#verificar aki se ja tem fatura, se nao tiver criar, e se ja tiver, nao fazer nada, em questao de fatura pendente de renovacao!!!
}

$auth = Sistema_Auth::getInstance();
if(!$auth->isLogged())
{
	header("location: ".PATCH);
    exit;
}

if(isset($_SESSION['Captcha']))
{
    header("Location: ./");
    die;
}