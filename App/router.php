<?php

$filePath = ltrim($_SERVER["REQUEST_URI"], '/');

if(stristr($filePath, '?')) {
	$filePathCort = explode('?', $filePath);
	$filePath = urldecode($filePathCort[0]);
}

if (preg_match('/\.(?:png|jpg|jpeg|gif|css)$/', $_SERVER["REQUEST_URI"])) {
	return false;
} else {
	$filePath = str_replace('.php', '', $filePath);

	if(is_file($filePath.".php")) {
    	include $filePath . '.php';
	}else{
		if(strlen($filePath) == 0) {
			include 'index.php';
		}else{

			if(stristr($filePath, 'Servicos/tpls')) {

				if(is_file($filePath)){
					return false;
				}

				// $filePathPart = explode('/',$filePath);
				// var_dump($filePathPart);
				// die;
			}

			$res = "404 not found";
			die($res);
		}
	}
}
