<?php //die('O site encontra-se fora do ar no momento....');

require_once('config/index.php');


if(isset($_SESSION['Captcha']))
{
    if(isset($_POST['codigo']))
    {
        $captcha = $util->xss($_POST['codigo']);
    	$errors = array();
		
        if (sizeof($errors) == 0)
        {
            $securimage = new Sistema_Captcha();
            
			if ($securimage->check($captcha) == false)
            {
                $smarty->assign('error',$util->Msg('','error','<strong>Se nao conseguir entrar,tente com outro navegador.</strong>'));
            }
            else
            {
                unset($_SESSION['Captcha']);
                $usuario = $_SESSION['Sistema_Auth']['user'];
                $as = new Sistema_Online();
                $as->setIp($_SERVER['REMOTE_ADDR']);
                $as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
                  
                $log = new Sistema_Logs();
                $log->setUsuario($usuario);
                $log->save();
                    
                $as->setTempo(time());
                $as->setUsuario($usuario);
                $as->save();
			
                $user = new Sistema_Usuarios();
                $user->setUsuario($usuario);
                $user->Logon();
	
                header("Location: ./Painel");
                die;
            }
        }
    }

    $smarty->assign("idCaptcha",md5(uniqid()));
    $smarty->assign("Pagina","Confirma&ccedil;&atilde;o.");
    $smarty->assign('Container','include_captcha.html');
    $smarty->assign('Topo','include_topo.html');
    $smarty->assign('Destaque','include_destaque.html');
    $smarty->assign('Rodape','include_rodape.html');
    $smarty->display('mainFront.html');	
    die;
}

if(isset($_SESSION['Sistema_Auth']['auth']) == 1)
{
    header("Location: ./Painel");
    die;
}
else
{
    if(isset($_POST['usuario']) && isset($_POST['senha']))
    {
        $usuario = $util->xss($_POST['usuario']);
        $senha   = $util->xss(md5($_POST['senha']));
        $authSis = new Sistema_Auth_Adapter_Db(Sistema_Db_Connection::factory($config));
        $authSis->setUser($usuario);
        $authSis->setPassword($senha);
        $authSis->setDb_user("usuario");
        $authSis->setDb_password("senha");
        $authSis->setTable("usuarios");

        if($authSis->autenticate())
        {
            $user = new Sistema_Usuarios();
            $user->setUsuario($usuario);
            $res = $user->getRes();
            
            $on = new Sistema_Online();
            $on->setUsuario($res['usuario']);			
			
            if($on->Ver() >= $res['acessos'])
            {
                $msg = "O usuario ja esta logado, nao empreste sua senha.";
                $util->ir('./Entrar',$msg,'info');
            }
			else
			{
				$auth = Sistema_Auth::getInstance();
				$auth->write($authSis);
	            
				if(CAPTCHA == 1)
	            {
					if($res['status'] == "2")
					{
						$log = new Sistema_Logs();
						$log->setUsuario($usuario);
						$log->save();
						
						$as = new Sistema_Online();
						$as->setIp($_SERVER['REMOTE_ADDR']);
						$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
				
						$as->setTempo(time());
						$as->setUsuario($usuario);
						$as->save();
						
						$user->Logon();
						
						
						$util->limpaTudo();
						$smarty->assign('error',$util->Msg('445px','error','<meta http-equiv="refresh" content="5; url=https://checkbusca.com/cadastro"><img src="https://checkbusca.com/images/icons/aguarde.gif">',''));
						
						$smarty->assign("Pagina","Autentique-se.");
						$smarty->assign('Container','include_login.html');
						$smarty->assign('Topo','include_topo.html');
						$smarty->assign('Destaque','include_destaque.html');
						$smarty->assign('Rodape','include_rodape.html');
						$smarty->display('main.html');
						die;
					}
					elseif($res['status'] == "3")
					{
						$util->limpaTudo();
						$smarty->assign('error',$util->Msg('445px','error','<meta http-equiv="refresh" content="5; url=https://checkbusca.com/Pag"><img src="https://checkbusca.com/images/icons/aguarde.gif">',''));
						
						$smarty->assign("Pagina","Autentique-se.");
						$smarty->assign('Container','include_login.html');
						$smarty->assign('Topo','include_topo.html');
						$smarty->assign('Destaque','include_destaque.html');
						$smarty->assign('Rodape','include_rodape.html');
						$smarty->display('main.html');
						die;
					}
					elseif($res['status'] == "4")
					{	
						unset($_SESSION['Captcha']);
						$log = new Sistema_Logs();
						$log->setUsuario($usuario);
						$log->save();
						
						$user->Logon();
						
						$as = new Sistema_Online();
						$as->setIp($_SERVER['REMOTE_ADDR']);
						$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
				
						$as->setTempo(time());
						$as->setUsuario($usuario);
						$as->save();
						
						header("Location: ./FormaPagamento");
						die;
					}
					elseif($res['status'] == "8")
					{
						unset($_SESSION['Captcha']);
						$log = new Sistema_Logs();
						$log->setUsuario($usuario);
						$log->save();
						
						$user->Logon();
						
						$as = new Sistema_Online();
						$as->setIp($_SERVER['REMOTE_ADDR']);
						$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
				
						$as->setTempo(time());
						$as->setUsuario($usuario);
						$as->save();
						
						header("Location: ./FormaPagamento");
						die;
					}

					if($res['captcha'] == "2")
					{
						unset($_SESSION['Captcha']);
						$log = new Sistema_Logs();
						$log->setUsuario($usuario);
						$log->save();
						
						$user->Logon();
						
						$as = new Sistema_Online();
						$as->setIp($_SERVER['REMOTE_ADDR']);
						$as->setUsuario($usuario);
						$as->setTempo(time());
						$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
						$as->save();
						
						header("Location: ./Painel");
						die;
						
					}
					else
					{ 
						$_SESSION['Captcha'] = "ok";
						header("Location: ./");
						die;
					}
				}
				else
				{
					if($res['status'] == "2")
					{
						$log = new Sistema_Logs();
						$log->setUsuario($usuario);
						$log->save();
						
						$as = new Sistema_Online();
						$as->setIp($_SERVER['REMOTE_ADDR']);
						$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
				
						$as->setTempo(time());
						$as->setUsuario($usuario);
						$as->save();
						
						$user->Logon();
						
						$util->limpaTudo();
						$smarty->assign('error',$util->Msg('445px','error','<strong>Usuario pendente.</strong>&nbsp;  ',''));
	
						$smarty->assign("Pagina","Autentique-se.");
						$smarty->assign('Container','include_login.html');
						$smarty->assign('Topo','include_topo.html');
						$smarty->assign('Destaque','include_destaque.html');
						$smarty->assign('Rodape','include_rodape.html');
						$smarty->display('main.html');
						die;
					}
					elseif($res['status'] == "3")
					{
						$util->limpaTudo();
						$smarty->assign('error',$util->Msg('445px','error','<strong>Usuario desativado.</strong>&nbsp;Entre em contato no faleconosco.',''));
	
						 $smarty->assign("Pagina","Autentique-se.");
						 $smarty->assign('Container','include_login.html');
						 $smarty->assign('Topo','include_topo.html');
						 $smarty->assign('Destaque','include_destaque.html');
						 $smarty->assign('Rodape','include_rodape.html');
						 $smarty->display('main.html');
						 die;
					}
					elseif($res['status'] == "4")
					{
                                                unset($_SESSION['Captcha']);
						$log = new Sistema_Logs();
						$log->setUsuario($usuario);
						$log->save();
						
						$user->Logon();
						
						$as = new Sistema_Online();
						$as->setIp($_SERVER['REMOTE_ADDR']);
						$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
				
						$as->setTempo(time());
						$as->setUsuario($usuario);
						$as->save();
						
						header("Location: ./FormaPagamento");
						die;
					}  
					elseif($res['status'] == "8")
					{
						unset($_SESSION['Captcha']);
						$log = new Sistema_Logs();
						$log->setUsuario($usuario);
						$log->save();
						
						$user->Logon();
						
						$as = new Sistema_Online();
						$as->setIp($_SERVER['REMOTE_ADDR']);
						$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
				
						$as->setTempo(time());
						$as->setUsuario($usuario);
						$as->save();
						
						header("Location: ./FormaPagamento");
						die;
					}
					
					unset($_SESSION['Captcha']);
					$log = new Sistema_Logs();
					$log->setUsuario($usuario);
					$log->save();
					
					$as = new Sistema_Online();
					$as->setIp($_SERVER['REMOTE_ADDR']);
					$as->setHost(gethostbyaddr($_SERVER['REMOTE_ADDR']));
			
					$as->setTempo(time());
					$as->setUsuario($usuario);
					$as->save();
					
					$user->Logon();
					
					header("Location: ./Painel");
					die;
				}
			}
        }
        else
        {
            $smarty->assign('error',$util->Msg('','error','<strong>senha inválida aguarde 60 segundos e digite diretamente pelo teclado.</strong>',''));
        }
    }

    $smarty->assign("Pagina","Autentique-se.");
    $smarty->assign('Container','include_login.html');
    $smarty->assign('Topo','include_topo.html');
    $smarty->assign('Destaque','include_destaque.html');
    $smarty->assign('Rodape','include_rodape.html');
    $smarty->display('mainFront.html');
    die;
}