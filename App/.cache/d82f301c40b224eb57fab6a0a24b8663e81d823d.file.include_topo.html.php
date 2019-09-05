<?php /* Smarty version Smarty-3.0.8, created on 2019-09-05 20:44:34
         compiled from "tpls/include_topo.html" */ ?>
<?php /*%%SmartyHeaderCode:13402712695d719de24b1610-39083992%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd82f301c40b224eb57fab6a0a24b8663e81d823d' => 
    array (
      0 => 'tpls/include_topo.html',
      1 => 1567104624,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13402712695d719de24b1610-39083992',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<h1><a href="./"><img src="images/Logo.png" /></a></h1>
<?php if (isset($_SESSION['getNome'])){?>
<div class="Infos">
  <p title=""><strong>&nbsp;&nbsp;</strong>&nbsp;&nbsp;&nbsp;</p>
  <p></p>
  <p title=""><strong>&nbsp;&nbsp;</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
  <p></p>
  <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong> </p>
  <?php if ($_SESSION['getStatus']==5){?>
   <p></p>
 <p><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="Admin">Admin</a></strong></p>
  <?php }?>
  
 <span style="float:right"><a href="Sair"><img src="https://checkbusca.com/Servicos/images/button05.png" /></a></span>

</div>
<?php }?>