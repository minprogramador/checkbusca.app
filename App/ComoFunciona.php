<?php
require_once('config/index.php');




$smarty->assign("Pagina","Como Funciona");
    
$smarty->assign('Topo','include_topo.html');
$smarty->assign('Container','include_como_funciona.html');


$smarty->display('mainFront.html');
