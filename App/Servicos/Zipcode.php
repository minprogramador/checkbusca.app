<?php

require_once('config.php');
require_once("checkAuth.php");
$servico = new Sistema_Servicos();
$servico->setServico('Zipcode');


$control = new Sistema_ControlGeral();
    $control->setServico('Zipcode');
$control->setIdUser($_SESSION['getId']);

if($control->Permissao() != true){ header('Location: ../Painel?negado'); die; }
else
{
    $a = $control->getLimites();

    if($a['status'] != '1'){ $erroy = true; }
    if($a['usado'] >= $a['limite']){ $erroy = true; }
}


if(isset($erroy)){ die('Seu limite no Servico <strong>'.$control->getServico().'</strong>, acabou, para adquirir mais entre em contato!'); }

if($dads['status'] == '0')
{
    die('Indisponivel no momento!');
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

$url_base = 'consultasgold.com/Servicos/api_zip.php?token=apizipja2018';

if(isset($_GET['ListaCidadesPorEstado']))
{
    $url = $url_base . '&ListaCidadesPorEstado=true';
    $cookie = $_SESSION['cookie2'];
    $loga = curl($url, $cookie, null, null, false);
    if(stristr($loga, 'Sua pesquisa retornou mais de')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    echo clearStrs($loga);
    die;
}

if(isset($_GET['ConsultaPJCompleta']) && isset($_GET['idBase']))
{
    $url = $url_base . '&ConsultaPJCompleta=true&idBase=' . $_GET['idBase'];
    $cookie = $_SESSION['cookie2'];
    $loga = curl($url, $cookie, null, null, false);

    if(stristr($loga, 'Sua pesquisa retornou mais de')) { 
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }elseif(stristr($loga,'A sua Consulta retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    elseif(stristr($loga,'A Consulta Procon informa o')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'O CPF pesquisado possui a'))  {
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'Sua pesquisa retornou')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'sua consulta, o sistema retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }

    echo clearStrs($loga);
    die;
}

if(isset($_GET['idBase']) && isset($_GET['abre']))
{
    $url = $url_base . '&abre=true&idBase=' . $_GET['idBase'];
    $cookie = $_SESSION['cookie2'];
    $loga = curl($url, $cookie, null, null, false);
    if(stristr($loga, 'Sua pesquisa retornou mais de')) { 
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }elseif(stristr($loga,'A sua Consulta retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    elseif(stristr($loga,'A Consulta Procon informa o')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'O CPF pesquisado possui a'))  {
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'Sua pesquisa retornou')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'sua consulta, o sistema retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }


    echo clearStrs($loga);
    die;
}

if(isset($_GET['PessoaJuridicax']) && isset($_GET['idBase']))
{
    $url = $url_base . '&PessoaJuridicax=true&idBase=' . $_GET['idBase'];
    $cookie = $_SESSION['cookie2'];
    $loga = curl($url, $cookie, null, null, false);
    if(stristr($loga, 'Sua pesquisa retornou mais de')) { 
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }elseif(stristr($loga,'A sua Consulta retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    elseif(stristr($loga,'A Consulta Procon informa o')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'O CPF pesquisado possui a'))  {
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'Sua pesquisa retornou')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'sua consulta, o sistema retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }


    echo clearStrs($loga);
    die;

}

if(isset($_GET['BuscaPF']))
{
    $url = $url_base . '&BuscaPF=true';
    $cookie = $_SESSION['cookie2'];
    $loga = curl($url, $cookie, null, null, false);


    if(stristr($loga, 'Sua pesquisa retornou mais de')) { 
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }elseif(stristr($loga,'A sua Consulta retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    elseif(stristr($loga,'A Consulta Procon informa o')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'O CPF pesquisado possui a'))  {
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'Sua pesquisa retornou')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'sua consulta, o sistema retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }


    echo clearStrs($loga);
    die;
}

if(isset($_GET['BuscaPJ']))
{
    $url = $url_base . '&BuscaPJ=true';
    $cookie = $_SESSION['cookie2'];
    $loga = curl($url, $cookie, null, null, false);


    if(stristr($loga, 'Sua pesquisa retornou mais de')) { 
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }elseif(stristr($loga,'A sua Consulta retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    elseif(stristr($loga,'A Consulta Procon informa o')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'O CPF pesquisado possui a'))  {
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'Sua pesquisa retornou')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'sua consulta, o sistema retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }

    echo clearStrs($loga);
    die;
}

if(isset($_GET['resultado']))
{

    $re = $_SESSION['resultx'];

    if(stristr($re, 'Sua pesquisa retornou mais de')) { 
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }elseif(stristr($re,'A sua Consulta retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    elseif(stristr($re,'A Consulta Procon informa o')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($re,'O CPF pesquisado possui a'))  {
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($re,'Sua pesquisa retornou')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($re,'sua consulta, o sistema retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }

    echo clearStrs($re);
    die;
}

if(strlen(http_build_query($_POST)) >= 10)
{
    if(isset($_SESSION['resultx'])){ unset($_SESSION['resultx']); }
    $cookie = $_SESSION['cookie'];

    if(isset($_GET['ConsultaPJ']))
    {
        $url = $url_base . '&ConsultaPJ=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }
    elseif(isset($_GET['ConsultaTelefone']))
    {
        $url = $url_base . '&ConsultaTelefone=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }
    elseif(isset($_GET['ConsultaPROCON']))
    {
        $url = $url_base . '&ConsultaPROCON=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }
    elseif(isset($_GET['ConsultaSociosEAdministradores']))
    {
        $url = $url_base . '&ConsultaSociosEAdministradores=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }   
    elseif(isset($_GET['ConsultaNome']))
    {
        $url = $url_base . '&ConsultaNome=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }   
    elseif(isset($_GET['ConsultaEndereco']))
    {
        $url = $url_base . '&ConsultaEndereco=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }
    elseif(isset($_GET['ConsultaPF']))
    {
        $url = $url_base . '&ConsultaPF=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }
    else
    {
        $url = $url_base . '&ConsultaPJ=true';
        $loga = curl($url, $cookie, http_build_query($_POST), null, false);
    }
    
    if(stristr($loga, 'window.location'))
    {
        echo 'Erro interno, tente novamente em breve..';
        die;
    }
    

    
    if(stristr($loga, 'Sua pesquisa retornou mais de')) { 
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }elseif(stristr($loga,'A sua Consulta retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();
    }
    elseif(stristr($loga,'A Consulta Procon informa o')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'O CPF pesquisado possui a'))  {
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'Sua pesquisa retornou')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }
    elseif(stristr($loga,'sua consulta, o sistema retornou os resultados abaixo')){
        $control->saveConsulta();
        $comp = new Sistema_Verificacao();
        $comp->setServico('Zipcode');
        $comp->Computa();        
    }

    echo clearStrs($loga);
    die;    
}

if(isset($_SESSION['cookie'])){ $cookie = $_SESSION['cookie']; $_SESSION['cookie2'] = $cookie; }else{ $cookie = ''; unset($_SESSION['cookie']); }


if(isset($_GET['ConsultaPF']))
{
    $url = $url_base . '&ConsultaPF=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
elseif(isset($_GET['ConsultaPFPJ']))
{
    $url = $url_base . '&ConsultaPFPJ=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
elseif(isset($_GET['ConsultaPJ']))
{
    $url = $url_base . '&ConsultaPJ=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
elseif(isset($_GET['ConsultaTelefone']))
{
    $url = $url_base . '&ConsultaTelefone=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
elseif(isset($_GET['ConsultaPROCON']))
{
    $url = $url_base . '&ConsultaPROCON=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
elseif(isset($_GET['ConsultaSociosEAdministradores']))
{
    $url = $url_base . '&ConsultaSociosEAdministradores=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
elseif(isset($_GET['ConsultaNome']))
{
    $url = $url_base . '&ConsultaNome=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
elseif(isset($_GET['ConsultaEndereco']))
{
    $url = $url_base . '&ConsultaEndereco=true';
    $res = curl($url, $cookie, null, null, false);
    echo $res;
}
else
{
    if(isset($_SESSION['cookie']))
    {
        $cookie = $_SESSION['cookie'];
        $url = $url_base;
        $loga = curl($url, $cookie, null, null, true);

        if(!stristr($loga, 'Account/LogOn?ReturnUrl='))
        {
            unset($_SESSION['cookie']);
            header("Location: ./Zipcode");
            die;
        } else {
            echo clearStrs($loga);
            die;
        }
    }
    else
    {
        $url = $url_base;
        $loga = curl($url, $cookie, null, null, true);
        $cookie = getCookies($loga);
        $_SESSION['cookie'] = $cookie;
        echo clearStrs($loga);
        die;
    }
}
