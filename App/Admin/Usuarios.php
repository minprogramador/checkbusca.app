<?php

require_once('config.php');

if(isset($_GET['pg']))
{
    $pagina = $util->xss($_GET['pg']);
    if($pagina == "busca")
    {
        $user = base64_decode($util->xss($_GET['usuario']));
        $usuario = new Sistema_Usuarios();
        $smarty->assign('res',$usuario->busca($user));
    }
	elseif($pagina == "contador")
    {
		$db = mysql_connect($config['hostname'],$config['user'],$config['password']) or die("Erro.");
		mysql_select_db($config['dbname']) or die("Erro.");

		if(isset($_POST['dia_i']) && isset($_POST['dia_f']))
		{
				$dia_i = $util->xss($_POST['dia_i']);
				$mes_i = $util->xss($_POST['mes_i']);
				$ano_i = $util->xss($_POST['ano_i']);
				$datai = $ano_i.'-'.$mes_i.'-'.$dia_i;
				
				$dia_f = $util->xss($_POST['dia_f']);
				$mes_f = $util->xss($_POST['mes_f']);
				$ano_f = $util->xss($_POST['ano_f']);
				$dataf = $ano_f.'-'.$mes_f.'-'.$dia_f;
				
			$query = mysql_query("SELECT * FROM fat_serasa  where (contratacao BETWEEN '$datai' AND '$dataf')") or die(mysql_error());
			while($array = mysql_fetch_array($query))
			{
				$id          = $array['id'];
				$usuario     = $array['usuario'];
				$limite      = $array['limite'];
				$contratacao = $array['contratacao'];
				$json[]      = array('id'=>$id,'usuario'=> $usuario,'limite'=> $limite,'contratacao'=>$contratacao);
			}
		}
		else
		{
			$query = mysql_query("SELECT * FROM fat_serasa") or die(mysql_error());
			while($array = mysql_fetch_array($query))
			{
				$id          = $array['id'];
				$usuario     = $array['usuario'];
				$limite      = $array['limite'];
				$contratacao = $array['contratacao'];
				$json[]      = array('id'=>$id,'usuario'=> $usuario,'limite'=> $limite,'contratacao'=>$contratacao);
			}
		}
		mysql_close($db);

		$smarty->assign('res',$json);
		
		$total = null;
		foreach($json as $res)
		{
			$total += $res['limite'];
		}
		
		$smarty->assign('Total',$total);
	
		$smarty->assign('pg','contador');
	}
	elseif($pagina == "addPontos")
    {
		if(isset($_POST['cadastrar_fatura']))
		{
			$id     = $util->xss($_REQUEST['idd']);
			$idd    = $util->xss($_REQUEST['id']);
			$pontos = $util->xss($_REQUEST['limite']);
			$plano  = new Sistema_Planos();
			$plano->AddPontos($pontos,$id,$idd);
			
			echo '<meta http-equiv="refresh" content="0; url=./Usuarios?pg=editar&id='.$id.'">';
			echo"<script type='text/javascript'>";
			echo "alert('Pontos adicionados com sucesso!');";
			echo "</script>";
		}
		
		$smarty->assign('pg','addPontos');
	}
	elseif($pagina == "Limpar")
    {
		$id     = $util->xss($_REQUEST['id']);
		
		$plano  = new Sistema_Planos();
		$plano->LimparPontos($id);
			
		echo '<meta http-equiv="refresh" content="0; url=./Usuarios?pg=editar&id='.$id.'">';
		echo"<script type='text/javascript'>";
		echo "alert('Pontos apagados com sucesso.');";
		echo "</script>";
		die;	
	}
    elseif($pagina == "editar")
    {
		$Serasa  = new Sistema_Serasa();
		$Servico = new Sistema_Servicos();
		$spc     = new Sistema_Spc();
		
		$rg      = new Sistema_Rg();
		$fullbusk = new Sistema_FullBusk();
		$sec      = new Sistema_Sec();

		$Usuario = new Sistema_Usuarios(@$_POST['get']);
        
		$Servico->setId($id);
		$Usuario->setId($id);

		$Control = new Sistema_ControlGeral();
        $Control->setIdUser($id);

		$smarty->assign('servicos',$Servico->getlist());
		$smarty->assign('pg','editar');
		$smarty->assign('get',$Usuario->getTudo());
		$smarty->assign('serasa',$Serasa->listConjunto());
		
		$spc->setId($id);
		$smarty->assign('spc',$spc->listPontos());
		
		$rg->setId($id);
		//$smarty->assign('rg',$rg->listPontos());

		$sec->setId($id);
		$smarty->assign('full',$sec->listPontos('CheckFull'));
		$smarty->assign('veiculo',$sec->listPontos('CheckVeiculo'));
		$smarty->assign('receita',$sec->listPontos('CheckReceita'));

		$fullbusk->setId($id);
		$smarty->assign('fullbusk',$fullbusk->listPontos());
		$smarty->assign('inss',$fullbusk->listPontosInss());
		$smarty->assign('confirme',$fullbusk->listPontosConfirme());
		$smarty->assign('pai',$fullbusk->listPontosPai());
		$smarty->assign('rg',$Servico->listPontosCpf1()); //pontos seekloc
		$smarty->assign('seekloc',$Servico->lpontSeekloc());
		$smarty->assign('one',$Servico->listPontosOneBusca($id));
$smarty->assign('Intouch',$Servico->listPontosOneBusca($id));

		$Control->setServico('CheckFone');
        $smarty->assign('ckeckFone',$Control->getLimites());

		$Control->setServico('Bacen');
        $smarty->assign('bacen',$Control->getLimites());

		$Control->setServico('CpfPeloFone');
        $smarty->assign('CpfPeloFone',$Control->getLimites());

		$Control->setServico('ConsultaDoc');
        $smarty->assign('ConsultaDoc',$Control->getLimites());

		$Control->setServico('CheckInss');
        $smarty->assign('CheckInss',$Control->getLimites());

		$Control->setServico('Consultadecredito');
        $smarty->assign('Creed',$Control->getLimites());

		$Control->setServico('CheckRg');
        $smarty->assign('CheckRg',$Control->getLimites());

		$Control->setServico('Masterbusca');
        $smarty->assign('CheckSus',$Control->getLimites());

		$Control->setServico('ConsultaCondutor');
        $smarty->assign('ConsultaCondutor',$Control->getLimites());

		$Control->setServico('MaxVeiculos');
        $smarty->assign('MaxVeiculos',$Control->getLimites());

		$Control->setServico('buscaGold');
        $smarty->assign('buscaGold',$Control->getLimites());

		$Control->setServico('Kibusca');
        $smarty->assign('Kibusca',$Control->getLimites());

		$Control->setServico('Intouch');
        $smarty->assign('intouch',$Control->getLimites());

		$Control->setServico('Check-ok');
        $smarty->assign('checkok',$Control->getLimites());


		$Control->setServico('UpBusca');
        $smarty->assign('upbusca',$Control->getLimites());

		$Control->setServico('Original');
        $smarty->assign('original',$Control->getLimites());

		$Control->setServico('Zipcode');
        $smarty->assign('zipcode',$Control->getLimites());

		$Control->setServico('ZipOn');
        $smarty->assign('zipon',$Control->getLimites());

		$Control->setServico('ConsultaCadastral');
        $smarty->assign('consultaCadastral',$Control->getLimites());

		$Control->setServico('Extrato');
        $smarty->assign('extrato',$Control->getLimites());

		$Control->setServico('Checkcondutor');
        $smarty->assign('checkcondutor',$Control->getLimites());

		$Control->setServico('Checkveiculos');
        $smarty->assign('checkveiculos',$Control->getLimites());

		$Control->setServico('max-spc-serasa');
        $smarty->assign('maxspcserasa',$Control->getLimites());

        if(isset($_POST['editar']))
    	{
            $a = array();
            foreach($_POST['servico'] as $serv){$a[] = $serv;}
            $servicos = implode(",", $a);
            
			$usuario = new Sistema_Usuarios();
			$usuario->setId($id);
			$usuario->setNome($util->xss($_POST['get']['nome']));
			$usuario->setEmail($util->xss($_POST['get']['email']));
			$usuario->setUsuario($util->xss($_POST['get']['login']));
			$usuario->setSenha($util->xss($_POST['get']['nova_senha']));
			$usuario->setServicos($servicos);
			$usuario->setSerasa($util->xss($_POST['get']['serasa']));
			$usuario->setCaptcha($util->xss($_POST['get']['captcha']));
			$usuario->setAcessos($util->xss($_POST['get']['acessos']));
			$usuario->setStatus($util->xss($_POST['get']['status']));

			
			$Servico->editOneBusca($util->xss($_POST['get']['limite_one']),$util->xss($_POST['get']['usado_one']),$id); //edit one

			$spc->setLimite($util->xss($_POST['get']['limite_spc']));
			$spc->setUsado($util->xss($_POST['get']['usado_spc']));
			
			//$rg->setLimite($util->xss($_POST['get']['limite_rg']));
			//$rg->setUsado($util->xss($_POST['get']['usado_rg']));

			//atualizar = sec
			$sec->atualizar($id,$util->xss($_POST['get']['limite_checkfull']),$util->xss($_POST['get']['usado_checkfull']),'CheckFull',$util->xss($_POST['get']['status_sec']));
			$sec->atualizar($id,$util->xss($_POST['get']['limite_veiculo']),$util->xss($_POST['get']['usado_veiculo']),'CheckVeiculo',$util->xss($_POST['get']['status_sec']));
			$sec->atualizar($id,$util->xss($_POST['get']['limite_receita']),$util->xss($_POST['get']['usado_receita']),'CheckReceita',$util->xss($_POST['get']['status_sec']));
			//atualizar = sec
			$fullbusk->setLimite($util->xss($_POST['get']['limite_fullbusk']));
			$fullbusk->setUsado($util->xss($_POST['get']['usado_fullbusk']));

			$fullbusk->upInss($util->xss($_POST['get']['limite_inss']),$util->xss($_POST['get']['usado_inss']));
			$fullbusk->upConfirme($util->xss($_POST['get']['limite_confirme']),$util->xss($_POST['get']['usado_confirme']));
			$fullbusk->upPai($util->xss($_POST['get']['limite_pai']),$util->xss($_POST['get']['usado_pai']));
			$Servico->upSeekloc($util->xss($_POST['get']['limite_seekloc']),$util->xss($_POST['get']['usado_seekloc']));

			$Servico->upCpf1($util->xss($_POST['get']['limite_rg']),$util->xss($_POST['get']['usado_rg'])); // limite equifax.


			$Control->editService($util->xss($_POST['get']['limite_ckeckFone']),$util->xss($_POST['get']['usado_ckeckFone']),$id,'CheckFone');
			$Control->editService($util->xss($_POST['get']['limite_bacen']),$util->xss($_POST['get']['usado_bacen']),$id,'Bacen');
			$Control->editService($util->xss($_POST['get']['limite_CpfPeloFone']),$util->xss($_POST['get']['usado_CpfPeloFone']),$id,'CpfPeloFone');
			$Control->editService($util->xss($_POST['get']['limite_ConsultaDoc']),$util->xss($_POST['get']['usado_ConsultaDoc']),$id,'ConsultaDoc');
			$Control->editService($util->xss($_POST['get']['limite_CheckInss']),$util->xss($_POST['get']['usado_CheckInss']),$id,'CheckInss');
			$Control->editService($util->xss($_POST['get']['limite_Creed']),$util->xss($_POST['get']['usado_Creed']),$id,'Consultadecredito');
			$Control->editService($util->xss($_POST['get']['limite_CheckRg']),$util->xss($_POST['get']['usado_CheckRg']),$id,'CheckRg');
			$Control->editService($util->xss($_POST['get']['limite_CheckSus']),$util->xss($_POST['get']['usado_CheckSus']),$id,'Masterbusca');

			$Control->editService($util->xss($_POST['get']['limite_condutor']),$util->xss($_POST['get']['usado_condutor']),$id,'ConsultaCondutor');
			$Control->editService($util->xss($_POST['get']['limite_mveiculo']),$util->xss($_POST['get']['usado_mveiculo']),$id,'MaxVeiculos');
			$Control->editService($util->xss($_POST['get']['limite_buscagold']),$util->xss($_POST['get']['usado_buscagold']),$id,'buscaGold');
			$Control->editService($util->xss($_POST['get']['limite_Kibusca']),$util->xss($_POST['get']['usado_Kibusca']),$id,'Kibusca');
			$Control->editService($util->xss($_POST['get']['limite_intouch']),$util->xss($_POST['get']['usado_intouch']),$id,'Intouch');
			$Control->editService($util->xss($_POST['get']['limite_check-ok']),$util->xss($_POST['get']['usado_check-ok']),$id,'Check-ok');
			$Control->editService($util->xss($_POST['get']['limite_upbusca']),$util->xss($_POST['get']['usado_upbusca']),$id,'UpBusca');
			$Control->editService($util->xss($_POST['get']['limite_original']),$util->xss($_POST['get']['usado_original']),$id,'Original');
			$Control->editService($util->xss($_POST['get']['limite_zipcode']),$util->xss($_POST['get']['usado_zipcode']),$id,'Zipcode');
			$Control->editService($util->xss($_POST['get']['limite_zipon']),$util->xss($_POST['get']['usado_zipon']),$id,'ZipOn');
			$Control->editService($util->xss($_POST['get']['limite_consultacadastral']),$util->xss($_POST['get']['usado_consultacadastral']),$id,'ConsultaCadastral');
			
			$Control->editService($util->xss($_POST['get']['limite_extrato']),$util->xss($_POST['get']['usado_extrato']),$id,'Extrato');
			$Control->editService($util->xss($_POST['get']['limite_checkcondutor']),$util->xss($_POST['get']['usado_checkcondutor']),$id,'Checkcondutor');
			$Control->editService($util->xss($_POST['get']['limite_checkveiculos']),$util->xss($_POST['get']['usado_checkveiculos']),$id,'Checkveiculos');


			$Control->editService($util->xss($_POST['get']['limite_max-spc-serasa']),$util->xss($_POST['get']['usado_max-spc-serasa']),$id,'max-spc-serasa');

			if(isset($_POST['get']['valor']))
			{
				$fatura = new Sistema_Faturas();
				$fatura->setUsuario($util->xss($_GET['id']));
				$fatura->setValor($util->xss($_POST['get']['valor']));
				$fatura->altValor();
				unset($fatura);
			}

            if($usuario->Alterar()) 
            {
				$plano = new Sistema_Planos();
				
				$plano->editponts($util->xss($_POST['get']['limite_serasa']),$util->xss($_POST['get']['usado_serasa']),$id); // pontos serasa.

				$plano->setId($id);
				$plano->setContratacao($util->conData($util->xss($_POST['get']['contratacao'])));
				$plano->setVencimento($util->conData($util->xss($_POST['get']['vencimento'])));
				$plano->edit();
				
				#OK - fatura
				if($util->xss($_POST['get']['status']) == "8")
				{
					$fatura = new Sistema_Faturas();
					$fatura->setUsuario($id);
					$res = $fatura->listUlFatura();
				
					$fatura->setId($res['id']);
					$fatura->setVencimento(date('Y-m-d', strtotime("+10 days",strtotime(date("Y-m-d")))));
					$fatura->setData(date("Y-m-d"));
					$fatura->setPeriodo($util->countData($util->conData($util->xss($_POST['get']['vencimento']))));
					$fatura->setValor($util->xss($_POST['get']['valor']));
					$fatura->setMetodo_pagamento(1);
					$fatura->setTipo(2);
					$fatura->setStatus(3);
					$fatura->setStatusFatura(0);
					$fatura->Alterar();
				}
				
				$spc->save();
				//$rg->save();
				$fullbusk->save();
				$msg = "Usuario alterado com sucesso!";
				$util->ir('./Usuarios?pg=editar&id='.$id,$msg,'info');
			}
			else
			{
				$msg = "Ocorreu um erro ao editar o usuario.";
				$util->ir('./Usuarios?pg=editar&id='.$id,$msg);
			}
		}
	}
    elseif($pagina == "cad")
    {
        if(isset($_POST['cadastrar']))
        {
            $a = array();
            foreach($_POST['servico'] as $serv){$a[] = $serv;}
            $servicos = implode(",", $a);
            
            $usuario = new Sistema_Usuarios();
            $usuario->setNome($util->xss($_POST['nome']));
            $usuario->setEmail($util->xss($_POST['email']));
            $usuario->setUsuario($util->xss($_POST['usuario']));
            $usuario->setSenha($util->xss($_POST['senha']));
            $usuario->setServicos($servicos);
            $usuario->setSerasa($util->xss($_POST['serasa']));
            $usuario->setCaptcha($util->xss($_POST['captcha']));
            $usuario->setAcessos($util->xss($_POST['acessos']));
            $usuario->setStatus($util->xss($_POST['status']));
            
            $plano = new Sistema_Planos();
            $plano->setLimite($util->xss($_POST['limite_serasa']));
            $plano->setUsado($util->xss($_POST['usado_serasa']));
            $plano->setContratacao($util->conData($util->xss($_POST['cadastro'])));
            $plano->setVencimento($util->conData($util->xss($_POST['vencimento'])));
            $plano->setValor($util->xss($_POST['valor']));
            $usuario->Cadastrar();
			
            $res      = $usuario->getRes();
            $spc      = new Sistema_Spc();
			$rg      = new Sistema_Rg();
			$fullbusk = new Sistema_FullBusk();


			if(isset($res['id'])) 
            {
				$spc->setUsuario($res['id']);
				$spc->setLimite($util->xss($_POST['limite_spc']));
				$spc->setUsado($util->xss($_POST['usado_spc']));
				$spc->Cadastrar();


				$rg->setUsuario($res['id']);
				$rg->setLimite($util->xss($_POST['limite_rg']));
				$rg->setUsado($util->xss($_POST['usado_rg']));
				$rg->Cadastrar();

				$fullbusk->setUsuario($res['id']);
				$fullbusk->setLimite($util->xss($_POST['limite_fullbusk']));
				$fullbusk->setUsado($util->xss($_POST['usado_fullbusk']));
				$fullbusk->Cadastrar();


				
                $plano->setId($res['id']);
                $plano->Cadastrar();
				if(strlen($_POST['limite_serasa']) >= 1)
				{
					$plano->AddPontos($util->xss($_POST['limite_serasa']),$res['id'],$res['usuario']);				
				}
				
				if($util->xss($_POST['status']) == "8")
				{
					$fatura = new Sistema_Faturas();
					$fatura->setUsuario($res['id']);
					$fatura->setData(date("Y-m-d"));
					$fatura->setVencimento(date('Y-m-d', strtotime("+10 days",strtotime(date("Y-m-d")))));
					$fatura->setPeriodo($util->countData($util->conData($util->xss($_POST['vencimento']))));
					$fatura->setValor($util->xss($_POST['valor']));
					$fatura->setMetodo_pagamento(1);
					$fatura->setTipo(1);
					$fatura->setStatus(3);
					$fatura->setStatusFatura(0);
					$fatura->Criar();
				}

                $msg = "www.checkbusca.com&nbsp;&raquo;&nbsp;Usuario:&nbsp;<strong>".$util->xss($_POST['usuario']).'</strong>&nbsp;&raquo;&nbsp;Senha:&nbsp;<strong>'.$util->xss($_POST['senha']).'</strong>';
                $util->ir('./Usuarios?pg=cad',$msg,'info');
            }
            else
            {
                $msg = "Ocorreu um erro ao cadastrar o usuario.";
                $util->ir('./Usuarios?pg=cad',$msg);
            }
        }
        else
        {
            $servico = new Sistema_Servicos();
            $serasa = new Sistema_Serasa();
            $smarty->assign('servicos',$servico->getlist());
            $smarty->assign('serasa',$serasa->listConjunto());
            $smarty->assign('pg','cad');
        }

    }
    elseif($pagina == "del")
    {
        if(isset($_GET['id']))
        {
            $Usuario = new Sistema_Usuarios();
            $Usuario->setId($util->xss($_GET['id']));
            $Usuario->delete();
            
            $plano = new Sistema_Planos();
            $plano->setId($util->xss($_GET['id']));
            $plano->delete();
            
            $msg = "Usuario deletado com sucesso!";
            $util->ir('./Usuarios',$msg);
        }
        else
        {
            $msg = "Ocorre um erro ao deletar o usuario.";
            $util->ir('./Usuarios',$msg);
        }
    }
}
else
{
    /* Listar e ordenar usuarios */
    $paginacao = new Sistema_Paginacao();
    $paginacao->setTable('usuarios');
    $paginacao->setBase(100);
    $paginacao->setPatch('page');

    if(isset($_GET['page'])) { $page = $util->xss($_GET['page']); }
    else { $page = null; }
	
    if ($page){ $from = ($page * $paginacao->getBase()) - $paginacao->getBase(); }
    else { $from = 0; }
    $paginacao->setPagina(PATCH.'/Admin/Usuarios');
    $paginacao->setLimite($from);
    $paginacao->setMaximo($paginacao->getBase());

    if(isset($_POST['Ordenar'])){ $resultArray = $paginacao->getDadosUsuarios($util->xss($_POST['ordena']));     }
    elseif($_POST['Pesquisar']) { $resultArray = $paginacao->getDadosUsuarios(null,$util->xss($_POST['busca'])); }
    else{ $resultArray = $paginacao->getDadosUsuarios(); }

    $total_records = $paginacao->getCount();
    $smarty->assign('res',$resultArray);
    $paginacao->setTotal($total_records);
    $paginacao->doPagina();
	
    if(!isset($_POST['Ordenar']) and !isset($_POST['Pesquisar'])) {$smarty->assign('Controllers',$paginacao->getControl()); }
}

$smarty->assign('Miolo','include_usuario.html');
$smarty->assign('Titulo_interna',"Painel Administrativo");
$smarty->assign("Pagina","Painel Administrativo");    
$smarty->assign('Container','include_interna.html');
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Lateral','include_lateral.html');
$smarty->display('main.html'); 
