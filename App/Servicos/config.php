<?php

session_start();
error_reporting(E_ALL); 

// Fix Session
// ini_set('session.cache_expire', 180);
// ini_set('session.cookie_httponly', true);
// ini_set('session.use_only_cookie', 1);

require_once(__DIR__."/loader.php");

if($_SESSION['getStatus'] == 4)
{
	header("Location: ../FormaPagamento");
	die;
}
elseif($_SESSION['getStatus'] == 8)
{
	header("Location: ../FormaPagamento");
	die;
}

if(!isset($_GET['sistema']))
{
	if(strpos(strtolower($_SERVER['REQUEST_URI']), 'phpsessid') !== false)
	{
		session_destroy();
		session_start();
		session_regenerate_id();
	}
}
# formato data
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('Brazil/East');
setlocale(LC_ALL,'ptb');



$util = new Sistema_Util();
$url  = $util->UrlPatch();
define("PATCH",   'https://checkbusca.com/Servicos');
require_once("config.php");


// $conf = new Sistema_Configuracao();
// $site = $conf->getDados();
$site = [];
/*Define*/
define("NOMESITE",'https://checkbusca.com');
define("LOGON",   1);
define("CAPTCHA", 1);

require_once(__DIR__."/../lib/Smarty/libs/Smarty.class.php");
include_once(__DIR__."/../lib/Sistema/Util.php");
$util = new Sistema_Util();
$smarty = new Smarty();
$smarty->template_dir = "../tpls/admin";
$smarty->compile_dir  = "../.cache";


$smarty->assign('PATCH','https://checkbusca.com');
$smarty->assign('LOGON',1);
$smarty->assign('NOMESITE',1);

if(isset($_SESSION['AlertMng']))
{
    $smarty->assign('IconAlert',$_SESSION['IconAler']);
    $smarty->assign('error',$_SESSION['AlertMng']);
    unset($_SESSION['AlertMng']);
    unset($_SESSION['IconAler']);
}



if(isset($_GET['id']))
{
    $id = $util->xss($_GET['id']);
}

$mensagemControle = "Este sistema esta em manutencao volta em  24 horas! tente outras opcoes.";


$urltoken = 'http://upverify.net/api/consulta/consultar';
$token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpYXQiOjE1NTQ5MzQ0NjksImV4cCI6NDEwMjQ1MTk5OSwiZGF0YSI6IjE3OCJ9.PzsdkbzEVKtOgull2om14ATL6DJNsqfJR5LLUsT8gLc';
