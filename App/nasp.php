<?php

require_once('config/index.php');

if(isset($_POST['status_pagamento']) && isset($_POST['id_transacao']))
{
	#if($_GET['codigo'] != "91395002"){echo "ocorreu um error.";die;}
	
	$status_pg = $_POST['status_pagamento'];
	$transid   = $_POST['cod_moip'];
	$fee       = $_POST['tipo_pagamento'];
	$data      = date( "Y-m-d H:i:s");
	$invoiceid = $_POST['id_transacao'];
	$idFatura  = explode('|',$invoiceid);
	$idFatura  = $idFatura[0];
	
	$Fatura = new Sistema_Fatura();
	$Fatura->setId($idFatura);

	if($status_pg == "1")
	{
		$status = "1"; // Pagamento já foi realizado porém ainda não foi creditado na Carteira MoIP recebedora (devido ao floating da forma de pagamento)
		$Fatura->setData_pagamento($data);
		
		$res = $Fatura->getDadosUser();
		#envia email pro cliente
		#computa
		$plano  = new Sistema_Planos();
		$info = $plano->getRes($re['id']);
		$plano->setId($re['id']);
		$plano->CadLog($re['id'],$info['limite']);
		
		$mail = new Sistema_Email();

		$mail->setRNome($res['nome']);
		$mail->setREmail(trim($res['email']));
		$mail->setTitulo('Pagamento realizado com sucesso, - '.NOMESITE);       
		$Mensagem = "Ola, <strong>".$res['nome']."</strong>, recebemos seu Pagamento! <br />acesse: ".PATCH."<br/>";            
		$mail->setMensagem($Mensagem);
		$mail->Enviar();
		
		// envia email para o recebedor
		$mail->setRNome('consultas ja');
		$mail->setREmail('consultasja@hotmail.com');
		$mail->setTitulo('Pagamento recebido moip, - '.$res['nome']);       
		$Mensagemx = "Ola, Pagamento recebido de <strong>".$res['nome']."</strong>, Email: ".$res['email']." - ID da fatura: ".$idFatura."<br/>";            
		$mail->setMensagem($Mensagemx);
		$mail->Enviar();

		$Fatura->setStatus($status);
		$Fatura->setidFatura($transid);
		$Fatura->upStatus();
		die;
	}
	else if ( $status_pg == "2" )
	{
		$status = "0";
	}
	else if ( $status_pg == "3" ){$status = "3";}
	else if ( $status_pg == "4" )
	{
		$status = "4";
	}
	else if ( $status_pg == "5" )
	{
		$status = "5"; //Pagamento foi cancelado pelo pagador, instituição de pagamento, MoIP ou recebedor antes de ser concluído
	}
	else if ( $status_pg == "6" ){$status = "6";}
	else if ( $status_pg == "7" ){$status = "8";}

	$Fatura->setStatus($status);
	$Fatura->setidFatura($transid);
	$Fatura->upStatus();
}
# <!-- 0 == aguardando pagamento | 1 == paga | 2 == (Iniciado) pendente | 3 == (Boleto foi impresso e ainda não foi pago) cancelada | 4 == disponivel | 5  = em analise | 6 == devolvido | 8 devolvido-->