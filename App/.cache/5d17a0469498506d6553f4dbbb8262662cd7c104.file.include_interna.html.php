<?php /* Smarty version Smarty-3.0.8, created on 2019-09-05 20:44:34
         compiled from "tpls/include_interna.html" */ ?>
<?php /*%%SmartyHeaderCode:1934363135d719de247bcf5-90184694%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d17a0469498506d6553f4dbbb8262662cd7c104' => 
    array (
      0 => 'tpls/include_interna.html',
      1 => 1567104622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1934363135d719de247bcf5-90184694',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div id="Topo">
<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('Topo')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
</div>
<div id="Content">
  <div class="TopoCon">
    <h2><?php echo $_smarty_tpl->getVariable('Titulo_interna')->value;?>
</h2>
  </div>
  <div class="MioloCon">
<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('Miolo')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
  </div>
</div>
<div id="Lateral">
<?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('Lateral')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
</div>

