<?php
/*
* Pagina Config - Mysql e informacoes do site.
* Responsavel por gerir os dados de login do Mysql
* Versao: 1.1
* criada em 14/10/2011 / atualizado em 24/09/2012
* Desenvolvedor: Brunno duarte.
* contato: brunos.duarte@hotmail.com
*/


//define("PATCH",     "https://checkbusca.com"); # Url do site.
define("PATCH",     "http://localhost"); # Url do site.

$config['adapter']  = 'mysql';
$config['hostname'] = 'localhost';
$config['dbname']   = 'checkbus_novo'; # Nome Banco de dados - Mysql
$config['user']     = 'checkbus_root'; # Usuario Mysql
$config['password'] = 'QZGB(]WcmPPk';      # Senha Mysql


define("NOMESITE",  "Check Busca"); # Nome do site
define("LOGON",     1);             # Pedir login   1 == sim  ? 2 == nao
define("CAPTCHA",   1);             # Pedir captcha 1 == sim  ? 2 == nao
define("EmailInfo", "consultasja@hotmail.com"); # E-mail para onde vai o contato e info de cadastro

# Define Informacoes do site #