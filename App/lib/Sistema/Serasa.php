<?php

class Sistema_Serasa extends Sistema_Db_Abstract
{
    protected $_table  = "senhas";
    private   $servico = null;
    private   $usuario = null;
    private   $senha   = null;
    private   $token   = null;
    private   $cookie  = null;
    private   $Ncookie = null;
    private   $form    = null;
    private   $status  = null;
    
    public function getForm()
    {
        return $this->form;
    }

    public function setForm($form)
    {
        $this->form = $form;
    }
    
    public function getNcookie()
    {
        return $this->Ncookie;
    }

    public function setNcookie($Ncookie)
    {
        $this->Ncookie = $Ncookie;
    }

        
    public function getServico()
    {
        return $this->servico;
    }

    public function setServico($servico)
    {
        $this->servico = $servico;
    }

        
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getCookie()
    {
        return $this->cookie;
    }

    public function setCookie($cookie)
    {
        $this->cookie = $cookie;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
    
    protected function _insert()
    {
        $db  = $this->getDb();
        $stm = $db->prepare(' insert into '.$this->_table.' (servico,usuario,senha,token,cookie,form,status) Values (:servico,:usuario,:senha,:token,:cookie,:form,:status)');

        $stm->bindValue(':servico',$this->getServico());
        $stm->bindValue(':usuario',$this->getUsuario());
        $stm->bindValue(':senha',$this->getSenha());
        $stm->bindValue(':token',$this->getToken());
        $stm->bindValue(':cookie',$this->getCookie());
        $stm->bindValue(':form',$this->getForm());
        $stm->bindValue(':status',$this->getStatus());
        
        return $stm->execute();

    }
    
    protected function _update()
    {
        $db = $this->getDb();
        $stm = $db->prepare(" update $this->_table set servico=:servico, usuario=:usuario, senha=:senha, token=:token, cookie=:cookie, form=:form, status=:status where id=:id");
       
        $stm->bindValue(':id', $this->getId());
        $stm->bindValue(':servico',$this->getServico());
        $stm->bindValue(':usuario',$this->getUsuario());
        $stm->bindValue(':senha',$this->getSenha());
        $stm->bindValue(':token',$this->getToken());
        $stm->bindValue(':cookie',$this->getCookie());
        $stm->bindValue(':form',  $this->getForm());
        $stm->bindValue(':status',$this->getStatus());
        
        return $stm->execute();

    }
    
    public function filNome($res)
    {
        $util = new Sistema_Util();
        $inf = $util->corta($res,'<a class="confidencial">','</a>');
		return $inf;
    }

    
    public function get_cc($servico)
    {
		$idUser = $this->getConjunto($servico);	
		$db  = $this->getDb();
		$stm = $db->prepare("select * from `fat_cc` where id=:id ORDER BY id DESC");
	
		$stm->bindValue(':id', $idUser);
		$stm->execute();
		$result   = $stm->fetch(PDO::FETCH_ASSOC);
	
        return $result;
    }


    public function listaConts($id)
    {
        $db  = $this->getDb();
        $stm = $db->prepare("select * from `senhas` where id=:id");
        $stm->bindValue(':id', $id);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

	public function limphall()
	{
		
	}
    
    public function Permissao()
    {
        
        $usuario = new Sistema_Usuarios();
        $usuario->setUsuario($_SESSION['getUsuario']);
        $res = $usuario->getRes();

        $plano  = new Sistema_Planos();
        $result = $plano->getRes($res['id']);
 
        if($result['limite'] <= $result['usado'])
        {
            header("Location:".PATCH.'?limite');
            die;
        }
        elseif(strtotime(date("Y-m-d")) >= strtotime($result['vencimento']))
        {
            header("Location:".PATCH.'/?venceu');
            #mostrar mensagem e executar o vencimento do usuario
            die;
        }
        else
        {
            $re  = $res['servicos'];
            $re  = explode(',',$re);

            foreach($re as $res)
            {
                if($res == $this->getServico())
                {
                    return true;
                    die;
                }
            }
        }
    }
    
    public function DelInfos($res)
    {
        $util = new Sistema_Util();
        
        $res     = str_replace($this->getToken(), '', $res);
        $NomeSec = $util->corta ($res, "CONFIDENCIAL PARA:", "<");
        if(strlen($NomeSec) > 5)
        {
            $res     = str_replace($NomeSec, ' '.NOMESITE, $res);
        }
        else
        {
            $NomeSec = $util->corta ($res, '<a class="confidencial">', "</a>");
            $res     = str_replace($NomeSec, ' '.NOMESITE, $res);
        }
        
        $cort    = $util->corta ($res, '<a href="/novomonitoreconcentre/', "&param=");
        $res     = str_replace('<a href="/novomonitoreconcentre/'.$cort.'&param="><img src="http://server.lan/serasa/images/bmonitore.gif"   border="0"></a>', '', $res);
        $res     = str_replace('<a href="javascript:self.print()" target="_top"><img src="http://server.lan/serasa/images/bimpri.gif" border="0"></a>', '', $res);
        $res     = str_replace('/novoconcentre/ConcentrePrincipal?urlLogout=https://sitenet.serasa.com.br/novoconcentre/ConcentrePrincipal', './', $res);
        $res     = str_replace('javascript:aux_chamatela();', './Concentre', $res);
        $res     = str_replace('ConcentrePrincipal?etapa', './Concentre?etapa', $res);
        $res     = str_replace('/novoconcentre/ConcentrePrincipal?param=', './Concentre', $res);
        $res     = str_replace('/identifica/?urlLogout=https://sitenet.serasa.com.br/identifica/', './', $res); 
        $res     = str_replace('request.getAttribute("urlmenuprod")', './', $res);
        $res     = str_replace('/novoconcentre/ConcentrePrincipal', './Concentre', $res);
        $res     = str_replace('/identifica/?urlLogout=https://sitenet.serasa.com.br./Concentre', './', $res);
        $res     = str_replace('/identifica/?urlLogout=https://sitenet.serasa.com.br/experian-product-web/Principal', './', $res);
        $res     = str_replace('<a href="?param=&etapa=filiais">Consulte as filiais da empresa.</a>', '', $res);
        
        $a       = $util->corta($res,'<b>Nova funcionalidade,','</b>');
        $a       = "Nova funcionalidade,".$a;
        $res     = str_replace($a, '', $res);
 
        $res     = str_replace('<a href="./Concentre?param=&etapa=filiais&cnpj="><img src="'.PATCH.'/images/btnFiliais.gif"   border="0"></a>', '', $res);
        $res     = str_replace('<a href="javascript:chamatela(3)"><img src="'.PATCH.'/images/bconslotecnpj.gif"   border="0"></a>', '', $res);
        $res     = str_replace('<a href="javascript:chamatela(2)"><img src="'.PATCH.'/images/bconslotecpf.gif"  border="0"></a>', '', $res);
        $res     = str_replace('<a href="/novomonitoreconcentre/MonitorePrincipal?param="><img src="'.PATCH.'/images/bmonitore.gif"   border="0"></a>', '', $res);
        $res     = str_replace('<a href="/novoconfirmei/ConfirmeiPrincipal?param="><img src="'.PATCH.'/images/bconfirmei.gif"  border="0"></a>', '', $res);
        $res     = str_replace('/identifica/ConcIdentificaConsulta?param=', './Identifica', $res);
        $res     = str_replace('/novoconcentre/./Concentre?urlLogout=https://sitenet.serasa.com.br/novoconcentre/./Concentre', './', $res);
        
        return $res;
    }
    
    public function Verific($cookie)
    {
        $util = new Sistema_Util();
        $res = $util->curl('https://sitenet.serasa.com.br/Logon/Logon',$cookie,null,true,'https://sitenet.serasa.com.br/elementos_estrutura/login.htm');
        preg_match_all('/Set-Cookie: JSESSIONID=(.*);/U',$res,$c);
		if(isset($c[0][0])){return false;}else{return true;}
    }
    
    public function curl($url,$method,$vars,$ref='',$cookie='',$header)
    {
        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_REFERER, $ref);
		curl_setopt($ch,CURLOPT_COOKIE, $cookie);
		curl_setopt ($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 5.1; rv:8.0) Gecko/20100101 Firefox/8.0");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_MAXREDIRS,3);
		curl_setopt($ch,CURLOPT_VERBOSE,0);
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,3);
        if ($method == 'POST')
		{
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		}
		$buffer = curl_exec ($ch);
		curl_close ($ch);
		return $buffer;   
    }
	
	
	public function getConta($servico)
	{
		#if($servico == "Crednet")
		#{
			$db  = $this->getDb();
			$stm = $db->prepare("select * from `senhas` where servico=:id");
			$stm->bindValue(':id', $servico);
			$stm->execute();
			$result = $stm->fetch(PDO::FETCH_ASSOC);
			$Lusuario = $result['usuario'];        
			$Lsenha   = $result['senha'];
			return "LOGON=$Lusuario&SENHA=$Lsenha&Encerrar=false";
		/*
        }
		else
		{
			$idUser = $this->getConjunto($servico);	
			$db  = $this->getDb();
			$stm = $db->prepare("select * from `fat_cc` where id=:id  ORDER BY id DESC");
	
			$stm->bindValue(':id', $idUser);
			$stm->execute();
			$result   = $stm->fetch(PDO::FETCH_ASSOC);
			$Lusuario = $result['usuario'];        
			$Lsenha   = $result['senha'];
			#return "LOGON=$Lusuario&SENHA=$Lsenha&NOVASENHA=&CONFNOVASENHA=";
			return "LOGON=$Lusuario&SENHA=$Lsenha&Encerrar=false";
		}
        */
	}

	public function NewLogar()
	{
        $util = new Sistema_Util();
		
		$url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
		$referer = "https://sitenet.serasa.com.br/Logon/index.jsp";
		$post    =  $this->getConta();
		
        $logar   = $util->curl($url,null,$post,true,$referer);
		$cookie  = $util->getCookies($logar);
			
		if(!preg_match("/var p = \"(.*?)\"/si",$logar, $matches))
		{
			$url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
			$cookie = null;	
			$post    = $this->getConta();
			$referer = "https://sitenet.serasa.com.br/elementos_estrutura/login-corporativo.html";
	
			$logar   = $util->curl($url,null,$post,true,$referer);
			$cookie  = $util->getCookies($logar);
	
			$logar1   = $util->curl($url,$cookie,null,true,$referer);
			$cookie1  = $util->getCookies($logar1);
				
			$logar2   = $util->curl($url,$cookie.'; '.$cookie1,null,true,$referer);
			$cookie2  = $util->getCookies($logar2);
	
			$logar3   = $util->curl($url,$cookie.'; '.$cookie1.'; '.$cookie2,null,true,$referer);
			$cookie3  = $util->getCookies($logar3);
	
			$ver = $cookie.'; '.$cookie1.'; '.$cookie2.'; '.$cookie3;
			$ex = explode(";",$ver);
				
			$ww = $ex[21].'; '.$ex[16].'; '.$ex[17].'; '.$ex[18].'; '.$ex[19].'; '.$ex[20];
	
			$logar   = $util->curl("https://sitenet.serasa.com.br/experian-product-web/Principal",$ww,null,true,$referer);
			$cookie  = $util->getCookies($logar);
		}

		if(preg_match("/var p = \"(.*?)\"/si",$logar, $matches))
        {
    	    $Token = $matches[1];
            $this->setToken($Token);
               
			$this->setCookie($cookie);
            $this->setNcookie($cookie);
				
			if($this->Verific($this->getNcookie()) == true)
			{
				$resNew = $util->curl("https://sitenet.serasa.com.br/cb/PFCBPrincipal?param=$Token",$cookie,null,true);
				preg_match_all('/Set-Cookie: (.*);/U',$resNew,$NCookie);
				$cookie = $NCookie[1][0];
	
				$res = array(
					'cookie' => $cookie,
					'token' => $Token,
					'token' => $Token
				);
				return $res;
			}
			else
			{
				echo "Error 303, entre em contato com o Administrador.";
				die;
			}
		}
	}
	
    public function getConjunto($servico)
	{
		$idUser = $_SESSION['getSerasa'];

        $db  = $this->getDb();
        $stm = $db->prepare("select * from `con_serasa` where id=:id");
        $stm->bindValue(':id', $idUser);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
		return $result[$servico];
	}
	
    public function GetccSerasa($servico)
	{
        $db  = $this->getDb();
        $stm = $db->prepare("select * from `senhas` where servico=:id");
        $stm->bindValue(':id', $servico);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

    public function Logar($servico=null)
    {
        $util = new Sistema_Util();
        
        $db  = $this->getDb();
        $stm = $db->prepare("select * from `senhas` where servico='$servico'");
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
        
        $Lusuario = $result['usuario'];        
        $Lsenha   = $result['senha'];
        
        if(strlen($Lusuario) < 2)
        {
            die('indisponivel no momento.');
        }
        if($result['status'] != 1)
        {
            die('indisponivel no momento.');
        }
       
            $url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
            $referer = "https://sitenet.serasa.com.br/Logon/index.jsp";
            $post    =  $this->getConta($servico);
            
            
            $logar   = $util->curl($url,null,$post,true,$referer);
            $cookie  = $util->getCookies($logar);
            

            
            if(stristr($logar,'ion="https://sitenet05.serasa.com.br/Co'))
            {
                $tt     = $util->parseForm($logar);
                $tt     = $tt['param'];
                $logar  = $util->curl("https://sitenet05.serasa.com.br/ContratacaoEletronica/AceiteEletronico/AceiteContrato.aspx",$cookie,"apl=https%3A%2F%2Fsitenet.serasa.com.br%2Fexperian-product-web%2FPrincipal&c=true&param=".$tt,'https://sitenet.serasa.com.br/experian-product-web/Principal');
                $logar  = $util->curl("https://sitenet05.serasa.com.br/ContratacaoEletronica/AceiteEletronico/AceiteContrato.aspx?apl=https%3a%2f%2fsitenet.serasa.com.br%2fexperian-product-web%2fPrincipal&c=true",$cookie,null,'https://sitenet.serasa.com.br/experian-product-web/Principal');
                $tt     = $util->parseForm($logar);         
                $logar  = $util->curl("https://sitenet.serasa.com.br/experian-product-web/Principal",$cookie,'param='.$tt['param'].'&F=&G=&J=&N=&C=true&apl=https%3A%2F%2Fsitenet.serasa.com.br%2Fexperian-product-web%2FPrincipal&ACEITE=true&Encerrar=false','https://sitenet05.serasa.com.br/ContratacaoEletronica/AceiteEletronico/AceiteContrato.aspx?apl=https%3a%2f%2fsitenet.serasa.com.br%2fexperian-product-web%2fPrincipal&c=true');
            }

            if(stristr($logar,'ion="https://sitenet05.serasa.com.br/Bloq'))
            {
                $tt     = $util->parseForm($logar);
                $tt     = $tt['param'];
                $cookie  = $util->getCookies($logar);
                $url     = "https://sitenet05.serasa.com.br/BloqueioVariacaoConsumoInternet/Paginas/DesbloqueioCliente.aspx";
                $referer = "https://sitenet.serasa.com.br/experian-product-web/Principal";
                $post    =  'apl=https%3A%2F%2Fsitenet.serasa.com.br%2Fexperian-product-web%2FPrincipal&c=true&param='.$tt;        
                $logar   = $util->curl($url,$cookie,$post,true,$referer);
        
                $url     = "https://sitenet05.serasa.com.br/BloqueioVariacaoConsumoInternet/Paginas/Encerra.axd";
                $referer = "https://sitenet05.serasa.com.br/BloqueioVariacaoConsumoInternet/Paginas/DesbloqueioCliente.aspx";
            
            
                $logar   = $util->curl($url,$cookie,null,true,$referer);

                $url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
                $referer = "https://sitenet.serasa.com.br/Logon/index.jsp";
                $post    =  $this->getConta($servico);
            
            
                $logar   = $util->curl($url,$cookie,$post,true,$referer);
            }

            if(!preg_match("/var p = \"(.*?)\"/si",$logar, $matches))
            {
                $url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
                $referer = "https://sitenet.serasa.com.br/Logon/index.jsp";
                $cookie  = null;   

                $post    = "LOGON=$Lusuario&SENHA=$Lsenha&Encerrar=false";
    
                $logar    = $util->curl($url,null,$post,true,$referer);
                $cookie   = $util->getCookies($logar);
                $logar1   = $util->curl($url,$cookie,null,true,$referer);
                $cookie1  = $util->getCookies($logar1);
                $logar2   = $util->curl($url,$cookie.'; '.$cookie1,null,true,$referer);
                $cookie2  = $util->getCookies($logar2);
                $logar3   = $util->curl($url,$cookie.'; '.$cookie1.'; '.$cookie2,null,true,$referer);
                $cookie3  = $util->getCookies($logar3);
    
                $ver = $cookie.'; '.$cookie1.'; '.$cookie2.'; '.$cookie3;
                $ex = explode(";",$ver);
                $ww = $ex[21].'; '.$ex[16].'; '.$ex[17].'; '.$ex[18].'; '.$ex[19].'; '.$ex[20];
                $logar   = $util->curl("https://sitenet.serasa.com.br/experian-product-web/Principal",$ww,null,true,$referer);
                $cookie  = $util->getCookies($logar);
            }


            if(preg_match("/var p = \"(.*?)\"/si",$logar, $matches))
            {
                $this->setToken($matches[1]);
                $this->setCookie($cookie);
            }
    }


    public function Logar1x($servico=null)
    {
		$util = new Sistema_Util();
		$idUser = $this->getConjunto($servico);

		if($servico == "Crednet")
		{
			$result = $this->GetccSerasa("Crednet");
		}
		else
		{
			$db  = $this->getDb();
			$stm = $db->prepare("select * from `fat_cc` where id='$idUser' ORDER BY id DESC");

			$stm->execute();
	        $result = $stm->fetch(PDO::FETCH_ASSOC);
		}
			
        $Lusuario = $result['usuario'];        
        $Lsenha   = $result['senha'];
        $Lcookie  = $result['cookie'];
        $LToken   = $result['token'];

			$url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
			$referer = "https://sitenet.serasa.com.br/Logon/index.jsp";
			$post    =  $this->getConta($servico);
			
			$logar   = $util->curl($url,null,$post,true,$referer);
			$cookie  = $util->getCookies($logar);
			
			if(stristr($logar,'action="https://sitenet05.serasa.com.br/ContratacaoEletronica/AceiteEletronico/AceiteCo'))
			{
				$tok = $util->corta($logar,'<input name="param" type="hidden" value="','">');

				$url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
				$referer = "https://sitenet05.serasa.com.br/ContratacaoEletronica/AceiteEletronico/AceiteContrato.aspx?apl=https%3a%2f%2fsitenet.serasa.com.br%2fexperian-product-web%2fPrincipal&c=true";
				
				$logar   = $util->curl($url,null,"param=$tok&F=&G=&J=&N=&C=true&apl=https%3A%2F%2Fsitenet.serasa.com.br%2Fexperian-product-web%2FPrincipal&ACEITE=true&Encerrar=false",true,$referer);
				$cookie  = $util->getCookies($logar);
			}
			
			if(!preg_match("/var p = \"(.*?)\"/si",$logar, $matches))
			{
				$url     = "https://sitenet.serasa.com.br/experian-product-web/Principal";
				$cookie  = null;	
				$post    = $this->getConta($servico);
				$referer = "https://sitenet.serasa.com.br/elementos_estrutura/login-corporativo.html";
	
				$logar   = $util->curl($url,null,$post,true,$referer);
				$cookie  = $util->getCookies($logar);
	
				$logar1   = $util->curl($url,$cookie,null,true,$referer);
				$cookie1  = $util->getCookies($logar1);
				
				$logar2   = $util->curl($url,$cookie.'; '.$cookie1,null,true,$referer);
				$cookie2  = $util->getCookies($logar2);
	
				$logar3   = $util->curl($url,$cookie.'; '.$cookie1.'; '.$cookie2,null,true,$referer);
				$cookie3  = $util->getCookies($logar3);
	
				$ver = $cookie.'; '.$cookie1.'; '.$cookie2.'; '.$cookie3;
				$ex = explode(";",$ver);
				
				$ww = $ex[21].'; '.$ex[16].'; '.$ex[17].'; '.$ex[18].'; '.$ex[19].'; '.$ex[20];
	
				$logar   = $util->curl("https://sitenet.serasa.com.br/experian-product-web/Principal",$ww,null,true,$referer);
				$cookie  = $util->getCookies($logar);
			}

			if(preg_match("/var p = \"(.*?)\"/si",$logar, $matches))
            {
                $Token = $matches[1];
                $this->setToken($Token);
               
				$this->setCookie($cookie);
                $this->setNcookie($cookie);
				
				if($this->Verific($this->getNcookie()) == true)
            	{                
                	$db = $this->getDb();
					$stm = $db->prepare('update `fat_cc` set cookie=:cookie, token=:token where id=:id');
					$stm->bindValue(':id', $idUser);
					$stm->bindValue(':cookie', $this->getNcookie());
					$stm->bindValue(':token',  $this->getToken());
					return $stm->execute();
				}
				else
				{
					echo "Error 303, entre em contato com o Administrador.";
					die;
				}
			}
	}
				
    public function getDados()
    {
        $db  = $this->getDb();
        $stm = $db->prepare(' select * from '.$this->_table.' where servico=:servico');
        $stm->bindValue(':servico',$this->getServico());
        $stm->execute();
        return $stm->fetch(PDO::FETCH_ASSOC);

    }
	
	public function listIcon($servico)
	{
		$usuario = new Sistema_Usuarios();
        $usuario->setUsuario($_SESSION['getUsuario']);
        $res = $usuario->getRes();
		
		$re  = $res['servicos'];
        $re  = explode(',',$re);
        foreach($re as $res)
        {
        	if($res == $servico)
            {
            	return true;
                die;
            }
		}
	}
	
    public function listConta()
    {
        $db  = $this->getDb();
        $stm = $db->prepare(' select * from '.$this->_table.' where servico=:servico');
        $stm->bindValue(':servico','Serasa');
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listConjunto()
    {
        $db  = $this->getDb();
        $stm = $db->prepare(' select * from `con_serasa` where status=1');
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}