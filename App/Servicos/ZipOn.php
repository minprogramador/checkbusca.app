<?php

#die('Fora do ar');

require_once('config.php');
require_once("checkAuth.php");

$servico = new Sistema_Servicos();
$servico->setServico('ZipOn');


$control = new Sistema_ControlGeral();
    $control->setServico('ZipOn');
$control->setIdUser($_SESSION['getId']);

if($control->Permissao() != true){
    echo "permissao negada";
    //header('Location: ../Painel?negado');
    die;
}
else
{
    $a = $control->getLimites();

    if($a['status'] != '1'){ $erroy = true; }
    if($a['usado'] >= $a['limite']){ $erroy = true; }
}


if(isset($erroy)){
    die('Seu limite no Servico <strong>'.$control->getServico().'</strong>, acabou, para adquirir mais entre em contato!');
}

function curl($url,$cookies,$post,$referer=null,$header=1,$follow=false,$xmlhttps=null)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, $header);
    if ($cookies) curl_setopt($ch, CURLOPT_COOKIE, $cookies);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.9; rv:27.0) Gecko/20100101 Firefox/27.0');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $follow);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLhttpsRequest"));
    if(isset($referer)){ curl_setopt($ch, CURLOPT_REFERER,$referer); }
    
    else{ curl_setopt($ch, CURLOPT_REFERER,$url); }
    if ($post)
    {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 
    }
    if($xmlhttps == true){ curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLhttpsRequest")); }
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); 
    curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 30);

    $res = curl_exec( $ch); 
    curl_close($ch); 
    return $res;
}

function corta($str, $left, $right) 
{
    $str      = substr (stristr ($str, $left), strlen ($left));
    @$leftLen = strlen (stristr ($str, $right));
    $leftLen  = $leftLen ? - ($leftLen) : strlen ($str);
    $str      = substr ($str, 0, $leftLen);
    return $str;
}

function getCookies($get)
{
    preg_match_all('/Set-Cookie: (.*);/U',$get,$temp);
    $cookie = $temp[1];
    $cookies = implode('; ',$cookie);
    return $cookies;
}

function clearStrs($res){
    $rem = corta($res, 'HTTP/1.1', '<!DOCTYPE');
    $res = str_replace($rem, '', $res);
    $res = str_replace('HTTP/1.1<', '<', $res);
    $res = str_replace('https://ziponline.zipcode.com.br', '#', $res);
    return $res;
}

//$url_base = 'http://104.248.127.128/zipOn/zipcode.php?token=apizipja2018';
$url_base = 'http://181.215.238.197/apistemp/zipOn/zipcode.php?token=apizipja2018';


if(isset($_REQUEST['telefoneok']) and strlen($_REQUEST['telefoneok']) > 6){
    $post = http_build_query($_POST);
    $ver = curl($url_base, null, $post, null, false);
}elseif(isset($_REQUEST['nome'])){
    $post = http_build_query($_POST);
    $ver = curl($url_base, null, $post, null, false);
}elseif(isset($_GET['doc'])){
    $post = null;
    $url_base = $url_base . '&doc=' . $_GET['doc'];
    $ver  = curl($url_base, null, $post, null, false);
}elseif(isset($_REQUEST['dados'])){
    $post = http_build_query($_POST);
    $ver = curl($url_base, null, $post, null, false);
}elseif(isset($_REQUEST['end'])){
    $post = http_build_query($_POST);
    $ver = curl($url_base, null, $post, null, false);

  
}elseif(isset($_REQUEST['open'])){
    $post = null;
    $url_base = $url_base . '&open=' . $_REQUEST['open'];
    $ver  = curl($url_base, null, $post, null, false);
}

if(isset($ver)){

    if(stristr($ver, 'nome') AND stristr($ver, 'idade')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('ZipOn');
        $comp->Computa();        
    }

    echo $ver;
}else{
    $tpl = file_get_contents(__DIR__.'/tpls/zipOn/main.html');
    $tpl = str_replace('zipcode.php', 'ZipOn', $tpl);
    echo $tpl;
}

