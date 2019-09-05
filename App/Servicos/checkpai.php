<?php

require_once('config.php');
require_once("checkAuth.php");
error_reporting(0);

$appName = 'CheckPai';

$servico = new Sistema_Servicos();
$servico->setServico('checkpai');

if($servico->PermissaoPai() != true){
    header('Location: ../Painel?negado');
    die;
}

$full   = new Sistema_FullBusk();
$full->setId($_SESSION['getId']);
$pontos = $full->listPontosPai();

if($pontos['status'] != '1'){ $msg = 'Voce nao possui acesso a esse serviço.'; }
if($pontos['usado'] >= $pontos['limite']){ $msg = 'Pontos acabaram, entre em contato para renovar.'; }

if(!isset($msg)) {
	if(date('H') >= 23) {
		if(date('H') == 23) {
			if(date('i') >= 59) {
				$msg = 'Horario de funcionamento, 08:00 até 23:59!';
			}
		}else{
			$msg = 'Horario de funcionamento, 08:00 até 23:59!';
		}
	}elseif(date('H') < 8) {
			$msg = 'Horario de funcionamento, 08:00 até 23:59!';
	}
}

if(isset($msg)){

    $tpl = file_get_contents('tpls/basen/msg.html');
    $tpl = str_replace(array('  ', "    ", "\t", "\r", "\n", "\r\n"), '', $tpl);
    $tpl = str_replace('{{appname}}', $appName, $tpl);
    $tpl = str_replace('{{logo}}', "./imgn/{$appName}.png", $tpl);
    $tpl = str_replace('{{msg}}', $msg, $tpl);
	$tpl = str_replace(array("\n", "\r", "\t", "  ", "	"), '', $tpl);
	echo $tpl;
	die;
}

function xss($data, $problem='') {
	if(!is_string($data)) {
		return $data;
	}

	$data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = strip_tags($data);
	if ($problem && strlen($data) == 0) {
		return ($problem);
	}
    return $data;
}

function curl($url, $cook=null, $post=null, $header=null, $ref=null, $proxy=null, $timeout=null, $token=null) {
	$useragent = 'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)';

	if(!isset($url)) {
		return false;
	}

	if($ref != null) {
		$ref = $url;
	}

	if($timeout != null) {
		$timeout = 15;
	}

	if($header != null) {
		$header = false;
	}

	$options = array(
		CURLOPT_URL 	  => $url,
		CURLOPT_HEADER    => $header,
		CURLOPT_USERAGENT => $useragent,
		CURLOPT_REFERER   => $ref,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_FOLLOWLOCATION => false,
		CURLOPT_SSL_VERIFYHOST => false,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_CONNECTTIMEOUT => $timeout,
		CURLOPT_TIMEOUT => $timeout
	);

	if(isset($cook)) {
		$options[CURLOPT_COOKIE] = $cook;
	}

	if(isset($post)) {
		$options[CURLOPT_POST] = true;
		$options[CURLOPT_POSTFIELDS] = $post;
	}

	if(isset($proxy)) {
		$options[CURLOPT_PROXY] = $proxy;
	}

	if(isset($token)) {
		$options[CURLOPT_HTTPHEADER] = array("Authorization: Bearer ".$token);
	}

	$ch = curl_init();
	curl_setopt_array($ch, $options);
	$res = curl_exec($ch);
	curl_close($ch);
	return $res;
}


function consultarok($url, $payload=null, $token=null) {

    $dados = curl($url, null, null, null, null, null, 60, $token);
    if(stristr($dados, '{')) {
        $dados = json_decode($dados, true);
        return $dados;
    }elseif(strlen($dados) > 100) {
    	return $dados;
    }else{
        $dados = curl($url, null, null, null, null, null, 60, $token);
        if(stristr($dados, '{')) {
            $dados = json_decode($dados, true);
            return $dados;
        }
        return $dados;
    }
} 



define('URLAPI', 'http://139.162.78.155:8080/consultar/');
define('TOKENAPI', null);

if(isset($_POST['value'])) {

    //sleep(2);
    header("Content-type:application/json");
    $doc = xss($_POST['value']);
    $doc = str_replace(array('.', ',', '-', '/', ' ', "\n", "\r", "\t"), '', $doc);

    if(strlen($doc) < 11) {
        $error = ['msg' => 'DOC invalido!'];
    }elseif(strlen($doc) > 14) {
        $error = ['msg' => 'DOC invalido!'];
    } else {
        $error = null;
    }

    if(!isset($error)) {
        $url   = URLAPI . $doc;
        $dados = consultarok($url, null, null);
        if(array_key_exists('pai', $dados)){

            if(strlen($dados['pai']) > 5) {
                if($dados['pai'] != 'NADA CONSTA') {
					$plano = new Sistema_Planos();
					$servico->CountPontospai();	
                }
            }
            $ndados = array(
                'Resultado.' => array(
                    'CPF' => $dados['doc'],
                    'Data nascimento' => date('d/m/Y',  strtotime($dados['nascimento'])),
                    'Nome Completo' => $dados['nome'],
                    'Nome Mãe' => $dados['mae'],
                    'Nome Pai' => $dados['pai']
                )
            );
            $dados = $ndados;
        }elseif(array_key_exists('msg', $dados)){
            $dados = ['msg' => $dados['msg']];        	
        }else{
            $dados = ['msg' => 'indisponivel'];
        }
    }else{
        $dados = $error;
    }
    echo json_encode($dados);
    die;
}else{

    $tpl = file_get_contents('tpls/basen/index.html');
    $tpl = str_replace(array('  ', "    ", "\t", "\r", "\n", "\r\n"), '', $tpl);
    $tpl = str_replace('{{appname}}', $appName, $tpl);
    $tpl = str_replace('{{logo}}', "./imgn/{$appName}.png", $tpl);
    $tpl = str_replace('{{urlfrm}}', "./checkpai.php", $tpl);
    $tpl = str_replace('{{timeout}}', 30000, $tpl);
    $tpl = str_replace('{{limite}}', $pontos['limite'], $tpl);
    $tpl = str_replace('{{usado}}', $pontos['usado'], $tpl);
    $tpl = str_replace('{{dadosTitle}}', 'CPF', $tpl);
    echo $tpl;
}
