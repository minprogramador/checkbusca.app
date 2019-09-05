<?php
/*
 * Pagina Config
 * Responsavel por gerir o sistema
 * Versao: 1.0
 * criada em 28/02/2012 | update 10/03
 * Desenvolvedor: Brunno duarte.
 * contato: brunos.duarte@hotmail.com
 */

error_reporting(0); 
set_include_path("../lib/" . PATH_SEPARATOR . "../lib/Sistema/" . PATH_SEPARATOR . "../config/" . PATH_SEPARATOR . get_include_path());

// Fix Session
ini_set('session.cache_expire', 180);
ini_set('session.cookie_httponly', true);
ini_set('session.use_only_cookie', 1);

session_start();

if(strpos(strtolower($_SERVER['REQUEST_URI']), 'phpsessid') !== false)
{
	session_destroy();
	session_start();
	session_regenerate_id();
}

# formato data
setlocale(LC_ALL, 'pt_BR');
date_default_timezone_set('Brazil/East');
setlocale(LC_ALL,'ptb');

require_once("loader.php");

$util = new Sistema_Util();

require_once("config.php");

if(isset($_SESSION['getStatus']))
{
    if($_SESSION['getStatus'] != 5)
    {
        header("Location: ".PATCH);
        die;
    }
}
else
{
    header("Location: ".PATCH);
    die;
}

require_once("Smarty/libs/Smarty.class.php");

$smarty = new Smarty();
$smarty->template_dir = "../tpls/admin";
$smarty->compile_dir  = "../.cache";
spl_autoload_register('__autoload');

$smarty->assign('PATCH',PATCH);
$smarty->assign('NOMESITE',NOMESITE);

if(isset($_SESSION['AlertMng']))
{
    $smarty->assign('IconAlert',$_SESSION['IconAler']);
    $smarty->assign('error',$_SESSION['AlertMng']);
    unset($_SESSION['AlertMng']);
    unset($_SESSION['IconAler']);
}

$util = new Sistema_Util();

if(isset($_GET['id']))
{
    $id = $util->xss($_GET['id']);
}

$Usuario = new Sistema_Usuarios();
$Online  = new Sistema_Online();

$smarty->assign('countUs',count($Usuario->fetchAll()));
$smarty->assign('CountOnline',count($Online->fetchAll()));
