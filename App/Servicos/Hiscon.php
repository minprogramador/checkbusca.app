<?php

// if($_SERVER['REMOTE_ADDR'] != '181.220.68.18'){
//  	die('<p align="center"><img src="https://checkbusca.com/images/icons/manutencao.jpg" align="top">');
#}

ob_start();
ob_implicit_flush (TRUE);
ignore_user_abort (0);
require_once('config.php');
require_once("checkAuth.php");

$fullbusk = new Sistema_FullBusk();
$fullbusk->Permissao();
$fullbusk->setId($_SESSION['getId']);
$pontos  = $fullbusk->listPontos();
$servico = new Sistema_Servicos();
$servico->setServico('Hiscon');

if($pontos['status'] != '1'){ $erroy = true; }
if($pontos['usado'] >= $pontos['limite']){ $erroy = true; }

if(isset($erroy)){ die('Seu limite no Servico <strong>'.$servico->getServico().'</strong>, acabou, para adquirir mais entre em contato!'); }

define('USER','pesquisa.fernando');
define('PASS','SH4xFyTBQ');
define('URL','https://sistema.startpesquisa.com.br');
define('PROXY', '181.215.8.112:3128');

function curl($link,$cookie,$post=null,$ref=null,$header=true, $headers=null)
{
	$timeout = 30;
	$ctime   = 30;
	$ch      = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL            => $link,
		CURLOPT_REFERER        => $ref,
		CURLOPT_HEADER         => $header,
		CURLOPT_COOKIE         => $cookie,
		CURLOPT_USERAGENT      => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:60.0) Gecko/20100101 Firefox/60.0',
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => 0,
		CURLOPT_BINARYTRANSFER => true,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_VERBOSE        => false,
		CURLOPT_TIMEOUT        => $timeout,
		CURLOPT_CONNECTTIMEOUT => $ctime,
		CURLOPT_ENCODING       => 'GZIP'
	));
        
	if(strlen($post) > 2){ curl_setopt($ch, CURLOPT_POST, true); curl_setopt($ch, CURLOPT_POSTFIELDS, $post); }

	if(($headers))
	{
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	}
	
	curl_setopt($ch, CURLOPT_PROXY, PROXY);
	
	$res = curl_exec($ch);

	curl_close($ch); 
	return ($res);
}

function getCookies($get)
{
	preg_match_all('/Set-Cookie: (.*);/U',$get,$temp);
	$cookie  = $temp[1];
	$cookies = implode('; ',$cookie);
	return $cookies;
}

function parseForm($data)
{
	$post = array();
	if(preg_match_all('/<input(.*)>/U', $data, $matches))
	{
		foreach($matches[0] as $input)
		{
			if(!stristr($input, "name=")) continue;
			if(preg_match('/name=(".*"|\'.*\')/U', $input, $name))
			{
				$key = substr($name[1], 1, -1);
				if(preg_match('/value=(".*"|\'.*\')/U', $input, $value)) $post[$key] = substr($value[1], 1, -1);
				else $post[$key] = "";
			}
		}
	}
	return $post;
}

function corta($str, $left, $right) 
{
	$str      = substr (stristr ($str, $left), strlen ($left));
	@$leftLen = strlen (stristr ($str, $right));
	$leftLen  = $leftLen ? - ($leftLen) : strlen ($str);
	$str      = substr ($str, 0, $leftLen);
	return $str;
}

function save($string,$file)
{
    $fp = fopen("Bin/".$file, "w+"); 
    $escreve = fwrite($fp, $string);
    fclose($fp);
}

function ler($file)
{
    $arquivo = fopen('Bin/'.$file,'r');
    if ($arquivo == false) die('Nao foi possivel abrir o arquivo.');
    $linha = fgets($arquivo);
    return $linha;
    fclose($arquivo);
}

function logar()
{
	$get 	= curl(URL.'/pages/principal.jsf', null, null, null);
	$cookie = getCookies($get);
	$frm    = parseForm($get);
	$frm['username'] 	= USER;
	$frm['j_username']  = USER;
	$frm['j_password']  = PASS;
	$post   = http_build_query($frm);
	$loga   = curl(URL.'/j_security_check', $cookie, $post, URL.'/pages/principal.jsf');
	$cookie = getCookies($loga);

	if(stristr($loga, '/pages/principal.jsf'))
	{
		$loga   = curl(str_replace('https', 'http', URL).'/pages/principal.jsf', $cookie,
		 '', URL . '/pages/principal.jsf');
		 
		$loga   = curl(URL.'/pages/principal.jsf', $cookie,
		 '', URL . '/pages/principal.jsf');
		 
		$loga   = curl(str_replace('https', 'http', URL).'/pages/principal.jsf', $cookie,
		 '', URL . '/pages/principal.jsf');
		 
		$loga   = curl(URL.'/pages/principal.jsf', $cookie,
		 '', URL . '/pages/principal.jsf');

		if(stristr($loga, '/logout.jsf">'))
		{
			save($cookie, 'cook3kokxx.cox');
			return $cookie;
		}
		else
		{
			save('', 'cook3kokxx.cox');
			return false;
		}
	}
	else
	{
		save('', 'cook3kokxx.cox');
		return false;
	}
}

function deslogar()
{
	$cookie = ler('cook3kokxx.cox');
	$res	= curl(URL.'/logout.jsf', $cookie, null , URL.'/pages/consultaHiscon.jsf');
	return true;
}
// deslogar();
// die;

function Mask($mask,$str){

    $str = str_replace(" ","",$str);

    for($i=0;$i<strlen($str);$i++){
        $mask[strpos($mask,"#")] = $str[$i];
    }

    return $mask;

}

function getCpf($doc, $cookie, $token, $link, $ref)
{

	if(!stristr($doc, '.')) {
		$doc = Mask("###.###.###-##",$doc);	
	}

	$tokenchave = ler('cook3token.cox');

	$headers = array(
		'Faces-Request: partial/ajax',
		'X-Requested-With: XMLHttpRequest',
		'Connection: keep-alive'
	);
		
	$post = array(
		'javax.faces.partial.ajax' 	 => 'true',
		'javax.faces.source' 		 => $tokenchave,
		'javax.faces.partial.execute'=> '@all',
		'javax.faces.partial.render' => 'resultado mensagens creditos',
		$tokenchave 				 => $tokenchave,
		'formConsultaHiscon' 		 => 'formConsultaHiscon',
		'slcCpfBeneficio_focus' 	 => '',
		'slcCpfBeneficio_input'		 => 'PC',
		'txtPesquisaCPF1' 			 => $doc,
		'javax.faces.ViewState' 	 => $token
	);

	$cookie = $cookie . '; barcelona_expandeditems=menu-form-pesquisa:j_idt174_0,menu-form-pesquisa:j_idt279_1';
	$postn  = http_build_query($post);
	$entra = curl($link, $cookie, $postn, $ref, true, null);

	
	if(!stristr($entra, '>Dados Pessoais'))
	{
		$tokenchave = corta($entra, '<button id="', '"');
		save($tokenchave, 'cook3token.cox');

		if(stristr($entra, '<update id="j_id1:javax.faces.ViewState:0">'))
		{
			$njavaxfaces = corta($entra, '<update id="j_id1:javax.faces.ViewState:0">', '</update>');
			$njavaxfaces = str_replace(array("\n", "\r", "\t", ' ', '<![CDATA[-', ']]>',
			'<![CDATA['), '', $njavaxfaces);
			$njavaxfaces = trim(rtrim($njavaxfaces));
			$post['javax.faces.ViewState'] = $njavaxfaces;
			$post  = http_build_query($post);

			$entra = curl($link, $cookie, $post, $ref, true, $headers);	

			if(stristr($entra, '<update id="j_id1:javax.faces.ViewState:0">'))
			{
				$njavaxfaces = corta($entra, '<update id="j_id1:javax.faces.ViewState:0">', '</update>');
				$njavaxfaces = str_replace(array("\n", "\r", "\t", ' ', '<![CDATA[-', ']]>',
				'<![CDATA['), '', $njavaxfaces);
				$njavaxfaces = trim(rtrim($njavaxfaces));
				$post['javax.faces.ViewState'] = $njavaxfaces;
				$post  = http_build_query($post);
				$entra = curl($link, $cookie, $post, $ref, true, $headers);	
			}
			else
			{
				$frm = parseForm($entra);
				$post['javax.faces.ViewState'] = $frm['javax.faces.ViewState'];
				$post  = http_build_query($post);
				$entra = curl($link, $cookie, $post, $ref, true, $headers);	
			}	
		}			
	}
	
	if(!stristr($entra, '>Dados Pessoais'))
	{
		$entra = false;
	}
	
	return $entra;
}

function getNb($doc, $cookie, $token, $link, $ref)
{
	$tokenchave = ler('cook3token.cox');
	$headers = array(
		'Faces-Request: partial/ajax',
		'X-Requested-With: XMLHttpRequest',
		'Connection: keep-alive'
	);

	$post1 = array(
		'formConsultaHiscon' 			=> 'formConsultaHiscon',
		$tokenchave 					=> $tokenchave,
		'javax.faces.partial.ajax' 		=> 'true',
		'javax.faces.partial.execute' 	=> '@all',
		'javax.faces.partial.render'	=> 'resultado mensagens creditos',
		'javax.faces.source' 			=> $tokenchave,
		'slcCpfBeneficio_focus' 		=> '',
		'slcCpfBeneficio_input' 		=> 'PB',
		'txtPesquisaBeneficio' 			=> $doc,
		'javax.faces.ViewState' 		=> $token				
	);

	$post2 = array(
		'formConsultaHiscon' 		  => 'formConsultaHiscon',
		'javax.faces.behavior.event'  => 'change',
		'javax.faces.partial.ajax' 	  => 'true',
		'javax.faces.partial.event'   => 'change',
		'javax.faces.partial.execute' => 'slcCpfBeneficio',
		'javax.faces.partial.render'  => 'panelGridBuscarCpfBeneficio',
		'javax.faces.source'		  => 'slcCpfBeneficio',
		'javax.faces.ViewState' 	  => $token,
		'slcCpfBeneficio_focus'		  => '',
		'slcCpfBeneficio_input' 	  => 'PB',
		'txtPesquisaBeneficio'        => ''
	);
	
	$post2  = http_build_query($post2);			
	$entra = curl($link, $cookie, $post2, $ref, true, null);

	if(!stristr($entra, '>Dados Pessoais'))
	{
		if(stristr($entra, '<update id="j_id1:javax.faces.ViewState:0">'))
		{
			$njavaxfaces = corta($entra, '<update id="j_id1:javax.faces.ViewState:0">', '</update>');
			$njavaxfaces = str_replace(array("\n", "\r", "\t", ' ', '<![CDATA[-', ']]>',
			'<![CDATA['), '', $njavaxfaces);
			$njavaxfaces = trim(rtrim($njavaxfaces));
			$post1['javax.faces.ViewState'] = $njavaxfaces;
			$post  = http_build_query($post1);

			$entra = curl($link, $cookie, $post, $ref, true, $headers);
			if(!stristr($entra, '>Dados Pessoais'))
			{
				$tokenchave = corta($entra, '<button id="', '"');
				if(strlen($tokenchave) > 3)
				{
					save($tokenchave, 'cook3token.cox');
				}				
				$entra = false;
			}			
		}	
	}
	
	return $entra;
}

function limpHist($data) {
	$data = '<td'. $data;

	$data = strip_tags($data);
	$data = stripslashes($data) . "#FIMDEL#";
	if(stristr($data, '$(functi')) {
		$rem = corta($data, '$(fun', '#FIMDEL#');
		$data = str_replace([$rem, '#FIMDEL#','$(fun'], '', $data);
	}

	if(stristr($data, '#FIMDEL#')) {
		$data = str_replace('#FIMDEL#', '', $data);
	}
	return trim(rtrim($data));
}

function consultar($doc)
{	
	$cookie  = ler('cook3kokxx.cox');
	$link    = 'https://sistema.startpesquisa.com.br/pages/consultaHiscon.jsf';
	$ref     = $link;

	$headers = array(
		'Faces-Request: partial/ajax',
		'X-Requested-With: XMLHttpRequest',
		'Connection: keep-alive'
	);

	$post   = null;
	$entra  = curl($link, $cookie, $post, $ref, true, null);

	if(stristr($entra, 'ACESSAR</a>'))
	{
		$cookie = logar();
		if($cookie == false)
		{
			$result = array('nada encontrado');
			return $result;
		}
		else
		{
			$entra  = curl($link, $cookie, $post, $ref, true, null);
		}
		//relogar
	}
	
	if(stristr($entra, 'name="javax.faces.ViewState"'))
	{
		$frm = parseForm($entra);

		if(strlen($doc) >= 11)
		{
			$entra = getCpf($doc, $cookie, $frm['javax.faces.ViewState'], $link, $ref);

			if($entra == false)
			{
				$entra = getCpf($doc, $cookie, $frm['javax.faces.ViewState'], $link, $ref);
			}
		}
		else
		{
			$entra = getNb($doc, $cookie, $frm['javax.faces.ViewState'], $link, $ref);
			if($entra == false)
			{
				$entra = getNb($doc, $cookie, $frm['javax.faces.ViewState'], $link, $ref);				
			}
			//getNb
		}
		
		
		if(stristr($entra, '>Dados Pessoais'))
		{
			if(stristr($entra, 'txtCPF'))
			{
				$frm  = parseForm($entra);
				$ver = explode('<tr data-ri', $entra);

				$hiscdata = corta($entra, 'Contratos em andamento', '<script id="dataTableEmprestimo_s"');
				
				$html = corta($hiscdata, '<tbody id="dataTableEmprestimo_data"', '</tbody>');
				$html = '<table> <tbody id="dataTableEmprestimo_data" ' . $html . '</tbody></table>';
				
				$dom = new domDocument; 
				$dom->loadHTML($html); 
				$dom->preserveWhiteSpace = false; 
				$tables = $dom->getElementsByTagName('table'); 
				$rows = $dom->getElementsByTagName('tr'); 

				$contratos = [];
				$totalParcelas = 0;
				$totalSaldoAproximado = 0;

				foreach ($rows as $row) {

					$cols = $row->getElementsByTagName('td');

					$banco = $cols->item(0)->nodeValue;
					$contrato = $cols->item(1)->nodeValue;
					$inicioDesconto = $cols->item(2)->nodeValue;
					$Termino = $cols->item(3)->nodeValue;
					$valorContrato = $cols->item(4)->nodeValue;
					$qntParcelas = $cols->item(5)->nodeValue;
					$qntDesc = $cols->item(6)->nodeValue;
					$qntEmAberto = $cols->item(7)->nodeValue;
					$parcPagas = $cols->item(8)->nodeValue;
					$valorParcela = $cols->item(9)->nodeValue;
					$saldoAproximado = $cols->item(10)->nodeValue;
					$valorParcelaLimpo = str_replace(['R$', ' '], '', $valorParcela);
					$valorParcelaLimpo = str_replace('.', '', $valorParcelaLimpo);
				    $valorParcelaLimpo = str_replace(',', '.', $valorParcelaLimpo);


					$totalSaldoAproximadoLimpo = str_replace(['R$', ' '], '', $saldoAproximado);
					$totalSaldoAproximadoLimpo = str_replace('.', '', $totalSaldoAproximadoLimpo);
				    $totalSaldoAproximadoLimpo = str_replace(',', '.', $totalSaldoAproximadoLimpo);

					$totalParcelas += $valorParcelaLimpo;
					$totalSaldoAproximado += $totalSaldoAproximadoLimpo;

					$contratos[] = [
						'banco' => $banco,
						'Contrato' => $contrato,
						'InicioDesconto' => $inicioDesconto,
						'Termino' => $Termino,
						'ValorContrato' => $valorContrato,
						'QntParcelas' => $qntParcelas,
						'qntDesc' => $qntDesc,
						'qntEmAberto' => $qntEmAberto,
						'parcPagas' => $parcPagas,
						'ValorParcela' => $valorParcela,
						'saldoAproximado' => $saldoAproximado 

					];
				}

				$totalSaldoAproximado = number_format($totalSaldoAproximado, 2, ',', '.');
				$totalParcelas = number_format($totalParcelas, 2, ',', '.');

				$contratoDadosOk = [];
				$contratoDadosOk['total'] = ['parcelas' => 'R$: '.$totalParcelas, 'saldo' => 'R$: '.$totalSaldoAproximado];
				$contratoDadosOk['contratos'] = $contratos;


				

				$Historico = [];

				$HistOk = '
				<div>
				<table class="table-style-one">
					<thead>
						<tr>
							<th>
								<span>Banco</span>
							</th>
							<th>
								<span>Contrato</span>
							</th>
							<th>
								<span>Inicio Desconto</span>
							</th>
							<th>
								<span>Termino</span>
							</th>
							<th>
								<span>Valor do Contrato</span>
							</th>
							<th>
								<span>Qtd. Parcelas</span>
							</th>
							<th>
								<span>Qtd. Desc.</span>
							</th>
							<th>
								<span>Qtd. em Aberto</span>
							</th>
							<th>
								<span>% Parc. Pagas</span>
							</th>
							<th>
								<span>Valor da Parcela</span>
							</th>
							<th>
								<span>Saldo Aproximado</span>
							</th>
						</tr>
					</thead>
					<tbody>
				';
				$Hischeck = false;
				foreach($contratoDadosOk['contratos'] as $v) {

					$Hischeck = true;

					$HistOk .= "
								<tr>
									<td>{$v['banco']}</td>
									<td>{$v['Contrato']}</td>
									<td>{$v['InicioDesconto']}</td>
									<td>{$v['Termino']}</td>
									<td>{$v['ValorContrato']}</td>
									<td>{$v['QntParcelas']}</td>
									<td>{$v['qntDesc']}</td>
									<td>{$v['qntEmAberto']}</td>
									<td>{$v['parcPagas']}</td>
									<td>{$v['ValorParcela']}</td>
									<td>{$v['saldoAproximado']}</td>
								</tr>
					";

				}				
				
				if($Hischeck === false) {
					$HistOk .= "
								<tr>								
									<td colspan='11'><center><strong>Nada encontrado.</strong></center></td>
								</tr>
					";
				}

				$HistOk .= '</tbody></table></div>'; 

				if(strlen($frm['txtCPF']) > 5)
				{
					$fullbusk = new Sistema_FullBusk();
					$fullbusk->Permissao();
					$fullbusk->setId($_SESSION['getId']);
					$fullbusk->CountPontos();
				}

				$result = array(
					'cpf'      => $frm['txtCPF'],
					'nb'	   => $frm['txtMatricula'],
					'nome'     => $frm['txtNome'],
					'idade'    => $frm['txtIdade'],
					'telefone' => $frm['txtTelefone'],
					'endereco' => $frm['txtEndereco'],
					'banco'    => array(
						'nome'     => $frm['txtBanco'],
						'agencia'  => $frm['txtAgencia'],
						'conta'    => $frm['txtConta'],
						'endereco' => $frm['txtEndBanco'],
					),
					'salario'   => $frm['txtSalario'],
					'concessao' => $frm['txtConcessao'],
					'especie'   => $frm['txtEspecie'],
					'margem'	=> $frm['txtMargem'],
					'margemcc'  => $frm['txtMargemCartao'],
					'historico' => $HistOk,
				);				
			}
			else
			{
				$result = array('nada encontrado');
			}
		}
		else
		{
			$result = array('nada encontrado');
		}	
	}
	else
	{
		$result = array('relogar...');
	}

	return $result;
}


if(isset($_GET['doc']))
{
	$Util = new Sistema_Util();
	$doc = $Util->xss($_GET['doc']);
	$result = consultar($doc);
	header("Content-type:application/json");
	echo json_encode($result);
	die;
}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Consulta Hiscon</title>
<link href="https://checkbusca.com/Servicos/tpls/Hiscon/css/css.css" rel="stylesheet" type="text/css" />
</head>
<style type="text/css">
	table.table-style-one {
		font-family: verdana,arial,sans-serif;
		font-size:11px;
		color:#333333;
		border-width: 1px;
		border-color: #3A3A3A;
		border-collapse: collapse;
	}
	table.table-style-one th {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #3A3A3A;
		background-color: #B3B3B3;
	}
	table.table-style-one td {
		border-width: 1px;
		padding: 8px;
		border-style: solid;
		border-color: #3A3A3A;
		background-color: #ffffff;
	}
</style>
<body>

<script>

function getDados(doc)
{
	document.getElementById('load').style.display = 'block';
	var doc     = doc;
	var xmlhttp = new XMLHttpRequest();
	var url     = "./Hiscon.php?doc=" + doc;
	xmlhttp.open("GET", url, false);
	xmlhttp.send();

	if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		if(xmlhttp.responseText.length < 5)
		{
			return 'true';
		}
		else
		{
			var res = JSON.parse(xmlhttp.responseText);
			if (res == 'nada encontrado')
			{
				return 'true';
			}
			else if (res.cpf.length > 5)
			{				
				document.getElementById('vcpf').innerHTML 		= res.cpf;
				document.getElementById('vnb').innerHTML 		= res.nb;
				document.getElementById('vnome').innerHTML 		= res.nome;
				document.getElementById('vidade').innerHTML 	= res.idade;
				document.getElementById('vtelefone').innerHTML 	= res.telefone;
				document.getElementById('vendereco').innerHTML 	= res.endereco;
				document.getElementById('vsalario').innerHTML 	= res.salario;
				document.getElementById('vconcessao').innerHTML = res.concessao;
				document.getElementById('vespecie').innerHTML 	= res.especie;
				document.getElementById('vmargem').innerHTML 	= res.margem;
				document.getElementById('vmargemcc').innerHTML  = res.margemcc;
				document.getElementById('voutros').innerHTML 	= res.historico;


				document.getElementById('bancNome').innerHTML 	= res.banco.nome;
				document.getElementById('bancAg').innerHTML 	= res.banco.agencia;
				document.getElementById('banccc').innerHTML 	= res.banco.conta;
				document.getElementById('bancend').innerHTML 	= res.banco.endereco;

				document.getElementById('resultado').style.display = 'block';
				document.getElementById('frm').style.display 	   = 'none';
				return 'false'
			}
			else
			{
				return 'true';
    		}
		}
	}
	else
	{
		return 'true';
	}
}

function Buscar()
{
	var doc = document.getElementById("inpbusca").value;
	var tentativas;
	for (tentativas = 0; tentativas < 4; tentativas++)
	{
		if (tentativas > 2)
		{
			document.getElementById('load').style.display = 'none';
			alert('Nada encontrado para o documento solicitado.');
			break;
		}	
		status = getDados(doc);
		if(status == 'true')
		{
			continue;
		}
		else
		{
			break;
		}
	}
}
</script>

<div id="Content" style="background:none; height:auto">
    <h1><img src="https://checkbusca.com/Servicos/tpls/Hiscon/images/logo.jpg" width="256" height="52" border="0" /></h1>
	<div id="frm">
		<form action="javascript:void(0)" onSubmit="return Buscar()" method="post">
    		<div class="busca">
    			<input type="text" id="inpbusca" class="busc" name="busca" value="" placeholder="Digite o CPF ou NB." />
   			 	<input type="submit" class="sbmit" id="inbuscar" name="buscar" value="" />
    	 	</div>
   	 	</form>
	<div id="load" style="display:none">
		<br>
		<center>
			<img src="data:image/gif;base64,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">
		</center>
	</div>
	</div>
	
</div>
			
	<div id="resultado" style="margin-left:20%; margin-right:20%; display:none">
	<table>
		<tr>
			<td><strong>CPF:</strong></td>
			<td id="vcpf"></td>
		</tr>
		<tr>
			<td><strong>NB:</strong></td>
			<td id="vnb"></td>
		</tr>
		<tr>
			<td><strong>Nome:</strong></td>
			<td id="vnome"></td>
		</tr>
		<tr>
			<td><strong>Idade:</strong></td>
			<td id="vidade"></td>
		</tr>
		<tr>
			<td><strong>telefone:</strong></td>
			<td id="vtelefone"></td>
		</tr>
		<tr>
			<td><strong>endereco:</strong></td>
			<td id="vendereco"></td>
		</tr>
	 	<tr>
		 	<td colapace="2"><br/></td>
		</tr>		
		<tr>
			<td><strong>salario:</strong></td>
			<td id="vsalario"></td>
		</tr>
		<tr>
			<td><strong>concessao:</strong></td>
			<td id="vconcessao"></td>
		</tr>
		<tr>
			<td><strong>especie:</strong></td>
			<td id="vespecie"></td>
		</tr>
		<tr>
			<td><strong>margem:</strong></td>
			<td id="vmargem"></td>
		</tr>
		<tr>
			<td><strong>margemcc:</strong></td>
			<td id="vmargemcc"></td>
		</tr>
		 <tr>
		 	<td colapace="2"><br/></td>
		 </tr>
		<tr>
			<td><strong>Banco:</strong></td>
			<td id="bancNome"></td>
		</tr>
		<tr>
			<td><strong>Agencia:</strong></td>
			<td id="bancAg"></td>
		</tr>
		<tr>
			<td><strong>Conta:</strong></td>
			<td id="banccc"></td>
		</tr>
		<tr>
			<td><strong>Endereço banco:</strong></td>
			<td id="bancend"></td>
		</tr>

	</table>
	<div id="voutros" style="margin-top:15px"></div>		
	<center>
		<br/>
		<a href="./Hiscon">Nova consulta</a>
		<br/>
		<br/>
	</center>
	</div>


</div>
</body>
</html>