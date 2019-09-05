<?php /* Smarty version Smarty-3.0.8, created on 2019-09-05 20:45:02
         compiled from "tpls/include_painel.html" */ ?>
<?php /*%%SmartyHeaderCode:13839959005d719dfecb5e23-36271589%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd15668280f7e0bfec29347a15ff771fd85a521bc' => 
    array (
      0 => 'tpls/include_painel.html',
      1 => 1567104624,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13839959005d719dfecb5e23-36271589',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<div align="top"><center><img src="images/icons/46.jpg">&nbsp;</div><?php if ($_smarty_tpl->getVariable('LOGON')->value==2){?>
    <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('Servicos')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = true;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['max'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] = 1;
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'] > 0 ? 0 : $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop']-1;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']) {
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'];
    if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] == 0)
        $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show'] = false;
} else
    $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'] = 0;
if ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['show']):

            for ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['start'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] = 1;
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] <= $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total'];
                 $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] += $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'], $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration']++):
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['rownum'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_prev'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] - $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index_next'] = $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['index'] + $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['step'];
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['first']      = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == 1);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['last']       = ($_smarty_tpl->tpl_vars['smarty']->value['section']['i']['iteration'] == $_smarty_tpl->tpl_vars['smarty']->value['section']['i']['total']);
?>
         <p><a href="./<?php echo $_smarty_tpl->getVariable('Servicos')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['servico'];?>
" class="window"> <img src="images/icons/<?php echo $_smarty_tpl->getVariable('Servicos')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['imagem'];?>
" alt="<?php echo $_smarty_tpl->getVariable('Servicos')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['servico'];?>
" title="<?php echo $_smarty_tpl->getVariable('Servicos')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['servico'];?>
" /> </a> </p>
    <?php endfor; endif; ?>
<?php }else{ ?>
    <?php  $_smarty_tpl->tpl_vars['res'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('Servicos')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['res']->key => $_smarty_tpl->tpl_vars['res']->value){
?>
        <?php if (strlen($_smarty_tpl->tpl_vars['res']->value)>2){?>
            <p> <a href="./Servicos/<?php echo $_smarty_tpl->tpl_vars['res']->value;?>
" class="window"> <img src="images/icons/<?php echo $_smarty_tpl->tpl_vars['res']->value;?>
.jpg" alt="Servi&ccedil;o - <?php echo $_smarty_tpl->tpl_vars['res']->value;?>
" title="Servi&ccedil;o - <?php echo $_smarty_tpl->tpl_vars['res']->value;?>
" /> </a> </p>
        <?php }?>
    <?php }} ?>
<?php }?>


