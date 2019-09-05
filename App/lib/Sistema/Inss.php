<?php

#SISTEMA INSS
#BY PUTTYOE
#puttyoe@hotmail.com
#14/01/2012
class Sistema_Inss extends Sistema_Db_Abstract
{
    protected $_table  = "proxy_inss";

	public $doc = null;
	public $c1  = null;
	public $c2  = null;
	public $c3  = null;
	public $c4  = null;
	public $c5  = null;
	public $tipo   = null;
	public $layout = null;
	public $senha  = null;
	public $proxy  = null;
	public $externo = true;
	public $urexter = "http://env-9982477.j.layershift.co.uk/ConsultBen";
	public $post    = null;
	
	public $ip      = null;
	public $porta   = null;
	public $status  = null;
	
	public function setIp($ip)
	{
		$this->ip = $ip;
	}
	
	public function getIp()
	{
		return $this->ip;
	}
	
	public function setPorta($porta)
	{
		$this->porta = $porta;
	}
	
	public function getPorta()
	{
		return $this->porta;
	}
	
	public function setStatus($status)
	{
		$this->status = $status;
	}
	
	public function getStatus()
	{
		return $this->status;
	}
	
	public function setPost($post)
	{
		$this->post = $post;
	}
	
	public function getPost()
	{
		return $this->post;
	}
	
	public function setDoc($doc)
	{
		$this->doc = $doc;
	}
	
	public function getDoc()
	{
		return $this->doc;
	}
	
	public function setC1($c1)
	{
		$this->c1 = $c1;
	}
	
	public function getC1()
	{
		return $this->c1;
	}

	public function setC2($c2)
	{
		$this->c2 = $c2;
	}
	
	public function getC2()
	{
		return $this->c2;
	}
	
	public function setC3($c3)
	{
		$this->c3 = $c3;
	}
	
	public function getC3()
	{
		return $this->c3;
	}
	
	public function setC4($c4)
	{
		$this->c4 = $c4;
	}
	
	public function getC4()
	{
		return $this->c4;
	}
	
	public function setC5($c5)
	{
		$this->c5 = $c5;
	}
	
	public function getC5()
	{
		return $this->c5;
	}

	public function setTipo($tipo)
	{
		$this->tipo = $tipo;
	}
	
	public function getTipo()
	{
		return $this->tipo;
	}
	
	public function setLayout($layout)
	{
		$this->layout = $layout;
	}
	
	public function getLayout()
	{
		return $this->layout;
	}
	
	public function setProxy($proxy)
	{
		$this->proxy = $proxy;
	}
	
	public function getProxy()
	{
		return $this->proxy;
	}
	
	public function __construct()
	{
		$this->setProxy((($this->get_proxy())));
	}
	
	public function get_proxy()
    {
        $db  = $this->getDb();
        $stm = $db->prepare("select * from `proxy_inss` where id=:id");

        $stm->bindValue(':id', 1);
        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);
		if($result['status'] == 1)
		{
			return trim($result['ip']).':'.trim($result['porta']);
		}
		else
		{
			return '';
		}
    }

    protected function _insert(){}
	
    protected function _update()
	{
        $db = $this->getDb();
        $stm = $db->prepare(" update `proxy_inss` set ip=:ip, porta=:porta, status=:status where id=:id");

        $stm->bindValue(':id', 1);
        $stm->bindValue(':ip',$this->getIp());
        $stm->bindValue(':porta',$this->getPorta());
        $stm->bindValue(':status',$this->getStatus());
        return $stm->execute();
	}
	
	public function Atualizar()
	{
        $db = $this->getDb();
        $stm = $db->prepare(" update `proxy_inss` set ip=:ip, porta=:porta, status=:status where id=:id");

        $stm->bindValue(':id', 1);
        $stm->bindValue(':ip',$this->getIp());
        $stm->bindValue(':porta',$this->getPorta());
        $stm->bindValue(':status',$this->getStatus());
        return $stm->execute();		
	}
	
	public function curl($url,$cookies,$post,$header=true,$referer=null,$follow=false)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt ($ch, CURLOPT_FRESH_CONNECT, 1);
		if($cookies != "0")
		{
			curl_setopt($ch, CURLOPT_COOKIE, 'SIW01=100513353F92;');
		}
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_4) AppleWebKit/536.30.1 (KHTML, like Gecko) Version/6.0.5 Safari/536.30.1');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
		if(isset($referer)){ curl_setopt($ch, CURLOPT_REFERER,$referer); }
		else{ curl_setopt($ch, CURLOPT_REFERER,'http://www010.dataprev.gov.br/CWS/CONTEXTO/CTC/BCAT0013.html'); }
		if ($post)
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
		}
		
		if(strlen($this->getProxy()) > 2)
		{
			curl_setopt($ch, CURLOPT_PROXY, $this->getProxy());
			#curl_setopt($ch, CURLOPT_PROXY, "218.80.252.174:8080");
		}
		
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 20);
		
		$res = curl_exec( $ch);
		curl_close($ch); 
		return ($res);
	}
	
	public function getCookies($get)
	{
		preg_match_all('/Set-Cookie: (.*);/U',$get,$temp);
		$cookie = $temp[1];
		$cookies = implode('; ',$cookie);
		return $cookies;
	}
	
	public function corta($str, $left, $right) 
	{
		$str = substr ( stristr ( $str, $left ), strlen ( $left ) );
		$leftLen = strlen ( stristr ( $str, $right ) );
		$leftLen = $leftLen ? - ($leftLen) : strlen ( $str );
		$str = substr ( $str, 0, $leftLen );
		return $str;
	}
	
	public function xss($data, $problem='')
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		$data = strip_tags($data);
		if ($problem && strlen($data) == 0) { return ($problem); }
		return $data;
	}

	public function Verificar($re)
	{
		$ver = trim($this->corta($re,'http://www.dataprev.gov.br/imagens/','.gif'));
		
		if($ver == "dataprev"){ echo false; } else { return true; }
	}
	
	public function VerTipo()
	{
		if($this->tipo == 'nome')
		{
			$this->setC1("BLB00.12");
			$this->setC2('');
			$this->setLayout("8%2C69%2C70%2C70%2C8%2C1");
		}
		if($this->tipo == 'pesnome')
		{
			$this->setC1("BLB00.12");
			$this->setC2('');
			$this->setLayout("8%2C69%2C70%2C70%2C8%2C1");
		}
		elseif($this->tipo == 'Gfamiliar')
		{
			$this->setC1("BLB00.22");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}
		elseif($this->tipo == 'nit')
		{
			$this->setC1("BLB00.48");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}
		elseif($this->tipo == 'beneficio')
		{
			$this->setC1("BLB00.30");
			$this->setC2('');
			$this->setLayout("8%2C69%2C11%2C1");
		}
		elseif($this->tipo == 'cpf')
		{
			$this->setC1("BLB00.17");
			$this->setC2('');
			$this->setLayout("8%2C69%2C11%2C1");
		}
		elseif($this->tipo == 'inCredito')
		{
			$this->setC1("BLR00.11");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}
		elseif($this->tipo == 'vcm')
		{
			#VALIDA - Validacao do Calculo de Credito Mensal   
			$this->setC1("BLV00.13");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10%2C1");
		}
		elseif($this->tipo == 'Titulardobene')
		{
			$this->setC1("BLB01.22");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}
		elseif($this->tipo == 'rv')
		{
			$this->setC1("BLR00.11");
			$this->setC2('');
			$this->setLayout("8%2C69%2C11%2C1");
		}
		elseif($this->tipo == 'titula')
		{
			$this->setC1("BLB00.22");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}
	
	
	
	
		elseif($this->tipo == 'hiscns')
		{
			$this->setC1("BLH00.12");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}
		elseif($this->tipo == 'ultcrenet')
		{
			$this->setC1("BPV00.23");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10%2C8%2C1");
		}
		elseif($this->tipo == 'hiscre')
		{
			$this->setC1("BPV00.11");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}
		elseif($this->tipo == 'aps')
		{
			$this->setC1("BCP00.41");
			$this->setC2('');
			$this->setLayout("8%2C69%2C8%2C8%2C8%2C1");
		}
		elseif($this->tipo == 'conind')
		{
			#conind_informacoesdeindeferimento
			$this->setC1("BCC00.18");
			$this->setC2('');
			$this->setLayout("8%2C69%2C10");
		}


	}
	
	public function limpar($res)
	{
		$res  = str_replace("<script language=JavaScript>parent.erroconfere = \"\";parent.exibeErro = \"\";</script>", "", $res);
		$cot  = $this->corta($res,'<title>','</title>');
		$res  = str_replace('<html><head><title>'.$cot.'</title><body><form name="'.$cot.'" method=post><pre>', '', $res);
		
		if($this->tipo == "cpf")
		{
			$cot = $this->corta($res,'<input type="hidden" name="C_1" size=8 maxlength=8 value="STP05.01">','Nome:');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('<input type="text"', '<input type="text" style="display:none"', $res);
			$res = str_replace('<input type="text" style="display:none" name="C_5"', '<input type="text" name="C_5"', $res);
			$cot = $this->corta($res,'<input type="text" style="display:none" name="C_11" size=1 maxlength=1          >','</html>');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('</html>', '', $res);
			$res = str_replace(' <input type="hidden" name="C_1" size=8 maxlength=8 value="STP05.01">', ' ', $res);
			$res = str_replace('<input type="text" style="display:none" name="C_11" size=1 maxlength=1          >', ' ', $res);
		}
		if($this->tipo == "inCredito")
		{
			$cot = $this->corta($res,'<input type="hidden" name="C_1" size=8 maxlength=8 value="BLR01.11">','NB');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('<input type="text" style="display:none" name="C_3"', '<input type="text" name="C_3"', $res);
			$cot = $this->corta($res,'<input type="hidden" name="layout" value="8,69,10">','</body>');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace(' <input type="hidden" name="C_1" size=8 maxlength=8 value="BLR01.11"> ', '', $res);
			$res = str_replace('<input type="hidden" name="layout" value="8,69,10"> </body></html>', ' ', $res);

		}
		if($this->tipo == "Gfamiliar")
		{
			$res = str_replace('</pre><center><input type="submit" name="submit" value="Transmite"><input type="reset" name="reset" value="Limpa"></center></form></body></html>', '', $res);
			$cot = $this->corta($res,'<input type="hidden" name="C_1" size=8 maxlength=8 value="BLB01.52">','NB');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace(' <input type="hidden" name="C_1" size=8 maxlength=8 value="BLB01.52"> ', ' ', $res);

			$cot = $this->corta($res,'CONTINUA (+/-)','<input type="hidden" name="layout" value="8,69,1,1">');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('CONTINUA (+/-) <input type="hidden" name="layout" value="8,69,1,1">', '', $res);
		}
		if($this->tipo == "nit")
		{
			$cot = $this->corta($res,' <input type="hidden" name="C_1" size=8 maxlength=8 value="BLB01.00">','Nome:');
			$res = str_replace($cot, ' ', $res);
			$cot = $this->corta($res,'<input type="hidden" name="layout" value="8,8,2,69,10,1,10,1,10,1,1,2,1">','</html>');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('<input type="hidden" name="layout" value="8,8,2,69,10,1,10,1,10,1,1,2,1"> </html>', '', $res);
			$res = str_replace(' <input type="hidden" name="C_1" size=8 maxlength=8 value="BLB01.00">', ' ', $res);
			$res = str_replace('<input type="text"', '<input type="text" style="display:none"', $res);
			$res = str_replace('Proxima Pagina (Nova Pesquisa ou Finalizar com 99)', '', $res);
		}
		if($this->tipo == "beneficio")
		{
			$cot = $this->corta($res,'<input type="hidden" name="C_1" size=8 maxlength=8 value="BLB01.30">','NB');
			$res = str_replace($cot, '', $res);
			
			$cot = $this->corta($res,'<input type="hidden" name="layout" value="8,69,10">','</html>');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('<input type="hidden" name="layout" value="8,69,10"> </html>', '', $res);
		}
		if($this->tipo == "nome")
		{
			#aki
			$cot = $this->corta($res,'<input type="hidden" name="C_1" size=8 maxlength=8 value="BLB01.12">','Nome:');
			$res = str_replace($cot, ' ', $res);
			
			$cot = $this->corta($res,'Proxima Pagina','</html>');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('Proxima Pagina </html>', '', $res);
			$res = str_replace('<input type="text"', '<input type="text" style="display:none"', $res);
			
			$cot = $this->corta($res,'Sequencia:','maxlength=1          >');
			$res = str_replace($cot, '', $res);
			$res = str_replace('Sequencia:maxlength=1          >', '', $res);
			
			$res = str_replace('<input type="submit" name="submit" value="Transmite">', '', $res);
			$res = str_replace('<input type="reset" name="reset" value="Limpa">', '', $res);
		}
		if($this->tipo == "pesnome")
		{
			$cot = $this->corta($res,'parent.erroconfere =','Nome:');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('parent.erroconfere = ', "  ", $res);
			
			$cot = $this->corta($res,'Sequencia:','F)');
			$res = str_replace($cot, ' ', $res);
			$res = str_replace('Sequencia: F)', '', $res);
			
			$res = str_replace("Proxima Pagina (Nova Pesquisa ou Finalizar com 99)", '', $res);
			$res = str_replace('FIM', " FIM", $res);
	
			$res = strip_tags($res);
		}
		if($this->tipo == "vcm")
		{	
			$cot = $this->corta($res,'MPAS/INSS','NB');
			$res = str_replace($cot, '', $res);
			$res = str_replace('MPAS/INSSNB', "\nNB", $res);
			$res = strip_tags($res);
		}
		if($this->tipo == "Titulardobene")
		{	
			$res = strip_tags($res);
			$cot = $this->corta($res,'MPAS/INSS','NB    ');
			$res = str_replace($cot, "", $res);
			$res = str_replace('   MPAS/INSSNB', " MPAS/INSSNB", $res);
		}
		if($this->tipo == "rv")
		{	
			$res = strip_tags($res);
			$cot = $this->corta($res,'MPAS/INSS','NB    ');
			$res = str_replace($cot, "", $res);
			$res = str_replace('   MPAS/INSS', " MPAS/INSS", $res);
		}
		if($this->tipo == "hiscns")
		{	
			$res = strip_tags($res);
			$cot = $this->corta($res,'MPAS/INSS','NB:');
			$res = str_replace($cot, "", $res);
			$res = str_replace('  MPAS/INSS', "", $res);
			$res = str_replace('CONTINUA', "", $res);
			$res = str_replace('Proxima Pagina:', "", $res);
			$res = str_replace('Digite 99 para encerrar ou para detalhar', "", $res);
		}
		if($this->tipo == "conind")
		{	
			$res = strip_tags($res);
			$cot = $this->corta($res,'MPAS/INSS','NB    ');
			$res = str_replace($cot, "", $res);
			$res = str_replace('   MPAS/INSS', " MPAS/INSS", $res);
		}
		if($this->tipo == "ultcrenet")
		{	
			$res = strip_tags($res);
			$cot = $this->corta($res,'MPAS/INSS','NB:');
			$res = str_replace($cot, "", $res);
			$res = str_replace('   MPAS/INSS', "", $res);
		}
		if($this->tipo == "hiscre")
		{	
			$res = strip_tags($res);
			$cot = $this->corta($res,'MPAS/INSS','NB:');
			$res = str_replace($cot, "", $res);
			$res = str_replace('  MPAS/INSS', "", $res);
			$res = str_replace('CONTINUA', "", $res);
			$res = str_replace('Proxima Pagina:', "", $res);
			$res = str_replace('Digite 99 para encerrar ou para detalhar', "", $res);
		}
		if($this->tipo == "aps")
		{	
			#$res = strip_tags($res);
			#$cot = $this->corta($res,'MPAS/INSS','NB    ');
			#$res = str_replace($cot, "", $res);
			#$res = str_replace('   MPAS/INSS', " MPAS/INSS", $res);
		}

		return $res;
	}
	
	public function logaExterno()
	{
		$email  = urlencode("");
		$senha  = "";
		$re     = $this->curl($this->urexter.'/AutLogin',null,'email='.$email.'&senha='.$senha.'&login_r8_c4.x=30&login_r8_c4.y=13',true,$this->urexter.'/index.jsp');
		$cookie = $this->getCookies($re);
		return $cookie;
	}
	
	public function Consultar()
	{
		if($this->tipo == "nome")
		{
			$this->VerTipo();
			$post = ($this->getPost());

			$nome = $post['nome'];
			$nome = urlencode($nome);
			
			$mae  = $post['mae'];
			$mae  = urlencode($mae);
			$data = $post['data'];
			$data = str_replace('/', "", $data);

			$data = ($data);
			
			$this->setC3($nome);
			$this->setC4($mae);
			$this->setC5($data);
			$this->VerTipo();
			$re = $this->curl('http://www010.dataprev.gov.br/cws/bin/cws2.asp',null,"C_1={$this->getC1()}&C_2={$this->getC2()}&C_3={$nome}&C_4={$mae}&C_5={$data}&layout={$this->getLayout()}",false);
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
		elseif($this->tipo == "pesnome")
		{
			$this->VerTipo();
			$post = base64_decode($this->getPost());
			$post = explode('&',$post);
			
			$nome = $post[0];
			$nome = urlencode(str_replace('nome=', '', $nome));
			$mae  = $post[1];
			$mae  = urlencode(str_replace('nomemae=', '', $mae));
			$data = $post[2];
			$data = (str_replace('dtnasc=', '', $data));
			
			$this->setC3($nome);
			$this->setC4($mae);
			$this->setC5($data);
			$this->VerTipo();
			$re = $this->curl('http://www010.dataprev.gov.br/cws/bin/cws2.asp',null,null);
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
		elseif($this->tipo == "titula")
		{
			
			$url = array(
						'http://6.hidemyass.com/ip-2/encoded/Oi8vd3d3MDEwLmRhdGFwcmV2Lmdvdi5ici9DV1MvQklOL0NXUzkxLkFTUA%3D%3D&f=norefer',
						'http://6.hidemyass.com/ip-6/encoded/Oi8vd3d3MDEwLmRhdGFwcmV2Lmdvdi5ici9DV1MvQklOL0NXUzkxLkFTUA%3D%3D&f=norefer',
						'http://www010.dataprev.gov.br/CWS/BIN/CWS91.ASP'
						 );
						
			#$ur = $url[rand(1,3)];
			$ur = "http://".rand(1,7).".hidemyass.com/ip-".rand(1,50)."/encoded/Oi8vd3d3MDEwLmRhdGFwcmV2Lmdvdi5ici9DV1MvQklOL0NXUzkxLkFTUA%3D%3D&f=norefer";
			$this->setC1("BLB00.17");
			$this->setC2('');
			$this->setLayout("8%2C69%2C11%2C1");
			
			$re = $this->curl($ur,null,"C_1={$this->getC1()}&C_2={$this->getC2()}&C_3={$this->getC3()}&layout={$this->getLayout()}&submit=Buscar",false,null,false,false);
			$Nb = $this->corta($re,'<input type="hidden" name="C_5" size=10 maxlength=10 value="','">*');
			
			if(strlen($Nb) > 4)
			{
				$this->setC1("BLB00.22");
				$this->setC2('');
				$this->setLayout("8%2C69%2C10");
				$this->setC3($Nb);
				
				$re = $this->curl($ur,null,"C_1={$this->getC1()}&C_2={$this->getC2()}&C_3={$this->getC3()}&layout={$this->getLayout()}&submit=Buscar",false,null,false,false);
				$cot = $this->corta($re,'<input type="hidden" name="C_1" size=8 maxlength=8 value="BLB01.22">','Nome');
				$re = str_replace($cot, "", $re);
				$re = strip_tags($re);
				
				$ccc = $this->corta($re,'parent.erroconfere',' Nome do ');
				$re = str_replace($ccc, "", $re);
				$re = str_replace('parent.erroconfere', "", $re);
				$re = str_replace('Endereco para Correspondencia', "\n           Endereco para Correspondencia", $re);

				$this->setC1("BLR00.11");
				$this->setC2('');
				$this->setLayout("8%2C69%2C10");
				$this->setC3($Nb);
				$re1 = $this->curl($ur,null,"C_1={$this->getC1()}&C_2={$this->getC2()}&C_3={$this->getC3()}&layout={$this->getLayout()}&submit=Buscar",false,null,false,false);

				$cot = $this->corta($re1,'<input type="hidden" name="C_1" size=8 maxlength=8 value="BLR01.11">','Situacao:');
				$re1 = str_replace($cot, "", $re1);
				$re1 = strip_tags($re1);
				
				$ccc = $this->corta($re1,'parent.erroconfere','Ult.');
				$re1 = str_replace($ccc, "", $re1);
				$re1 = str_replace('parent.erroconfereUlt.Extrato:', "Ult.Extrato:", $re1);
				#$re = str_replace('Endereco para Correspondencia', "\n           Endereco para Correspondencia", $re);
				

				echo "<pre>$re \n====================================================\n <strong>Informacoes de Creditos</strong> \n".$re1.'</pre>';
			}
			else
			{
				echo "tente novamente em breve.";
			}
			echo $ur;
			die;
		}
		elseif($this->tipo == "hiscns")
		{
			$this->VerTipo();
			$re = $this->curl('http://www010.dataprev.gov.br/cws/bin/cws2.asp',null,"C_1=BPV00.11&C_2=&C_3={$this->getC3()}&layout=8%2C69%2C10",false,'http://www010.dataprev.gov.br/cws/bin/cws2.asp',false,false);
			
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
		elseif($this->tipo == "ultcrenet")
		{
			$this->VerTipo();
			
			$re = $this->curl('http://www010.dataprev.gov.br/cws/bin/cws2.asp',null,"C_1=BPV00.23&C_2=&C_3={$this->getC3()}&C_4={$this->getC4()}&C_5=&layout=8%2C69%2C10%2C8%2C1",false,'http://www010.dataprev.gov.br/cws/bin/cws2.asp',false,false);
			
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
		elseif($this->tipo == "hiscre")
		{
			$this->VerTipo();
			
			$re = $this->curl('http://www010.dataprev.gov.br/cws/bin/cws2.asp',null,"C_1=BPV00.11&C_2=&C_3={$this->getC3()}&layout=8%2C69%2C10",false,'http://www010.dataprev.gov.br/cws/bin/cws2.asp',false,false);
			
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
		elseif($this->tipo == "conind")
		{
			$re = $this->curl('http://www010.dataprev.gov.br/CWS/BIN/CWS91.asp',null,"C_1=BCC00.18&C_2=&C_3={$this->getC3()}&C_4=&C_5=&C_6=&layout=8%2C69%2C10",false,null,false,false);
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
		elseif($this->tipo == "aps")
		{
			$this->VerTipo();
			
			
			$this->VerTipo();
			$post = ($this->getPost());

			$aps = $post['aps'];
			$aps = urlencode($aps);
			
			$datai  = $post['datai'];
			$datai = str_replace('/', "", $datai);
			$dataf = $post['dataf'];
			$dataf = str_replace('/', "", $dataf);

			
			$this->setC3($aps);
			$this->setC4($datai);
			$this->setC5($dataf);
			$this->VerTipo();
			$post = "C_1=BCP00.41&C_2=&C_3={$aps}&C_4={$datai}&C_5={$dataf}&C_6=&layout=8%2C69%2C8%2C8%2C8%2C1";
			
			
			$re = $this->curl('http://www010.dataprev.gov.br/cws/bin/cws2.asp',null,$post,false,'http://www010.dataprev.gov.br/cws/bin/cws2.asp',false,false);
			
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
		else
		{	
			$this->VerTipo();
			
			$re = $this->curl('http://www010.dataprev.gov.br/CWS/BIN/CWS91.ASP',null,"C_1={$this->getC1()}&C_2={$this->getC2()}&C_3={$this->getC3()}&C_4=&layout={$this->getLayout()}&submit=Buscar",false,null,false,false);
			
			if($this->Verificar($re) == true) { return $this->limpar($re); } else { return "null"; }
		}
	}
}
#SISTEMA INSS
#BY PUTTYOE
#puttyoe@hotmail.com
#14/01/2012