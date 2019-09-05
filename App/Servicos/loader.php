<?php



function newautoload($class)
{
	$class = __DIR__.'/../lib/'.str_replace("_","/",$class).".php";

	if(stristr($class, 'Db')) {
		if(is_file($class)){
		    require_once($class);	
		}
	}

	if(!stristr($class, 'Internal/Data.php')){
    	require_once($class);	
	}
}

spl_autoload_register('newautoload');