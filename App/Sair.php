<?php
include("config/index.php");
require_once("checkAuth.php");

if(isset($_SESSION['getUsuario']))
{
    $online = new Sistema_Online();
    $online->setUsuario($_SESSION['getUsuario']);
    $online->logout();
	
    foreach( $_SESSION as $Index => $Data)
    {
    	unset($_SESSION[$Index]);
    }
    
    foreach( $_COOKIE as $Index => $Data )
    {
    	setcookie($Index, '', time()-172800);
    }
    
    header("Location: ".PATCH);
    die;
}
else
{
    foreach( $_SESSION as $Index => $Data )
    {
        unset($_SESSION[$Index]);
    }

    foreach( $_COOKIE as $Index => $Data )
    {
    setcookie($Index, '', time()-172800);
    }
    header("Location: ".PATCH);
    die;
}