<?php /* Smarty version Smarty-3.0.8, created on 2019-09-05 20:44:34
         compiled from "tpls/main.html" */ ?>
<?php /*%%SmartyHeaderCode:2150979075d719de23cb288-01188903%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '82a5c3110e78adcfa93f0d0e72aa46af02e1cdd5' => 
    array (
      0 => 'tpls/main.html',
      1 => 1567104625,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2150979075d719de23cb288-01188903',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/workspace/checkbusca.com/App/lib/Smarty/libs/plugins/modifier.date_format.php';
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $_smarty_tpl->getVariable('Pagina')->value;?>
 - ckeckbusca | solu&ccedil;&atilde;o facil em localiza&ccedil;&atilde;o e consultas de cr&eacute;dito.</title>
<link href="css/css.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" language="javascript" src="<?php echo $_smarty_tpl->getVariable('PATCH')->value;?>
/js/jquery.1.6.2.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function()
{
	$('a.window').click(function()
	{
		var dimensions = (this.rel) 
			? this.rel
			: '998x600';
		dimensions = dimensions.split('x');
		var width = dimensions[0];
		var height = dimensions[1];
		var bWindow = window.open(this.href, this.id, 'width=' + width + ',height=' + height + ',left=' + (((screen.width - width) / 2) - 20) + ',top=' + (((screen.height - height) / 2) - 20) + ',scrollbars=yes,resizable=yes,toolbars=no');
		bWindow.focus();
		return false; 
	});
});
</script>

<script type="text/javascript" language="javascript">

setInterval(function(){jQuery.ajax({ url: './Painel?online', success: function(new_list_data){}});}, 1000*30);

</script>
</head>
<body>
<?php if ($_smarty_tpl->getVariable('pagrec')->value=="renovar"){?>
<div id="ligcap" class="lightbox captcha" style="display: block;">
		<div class="whitebox">
			<h1>Aten&ccedil;&atilde;o sua conta esta vencendo! não deixe para última hora!</h1>
            <p>Vencimento: <strong><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('inPlano')->value['vencimento'],"%d/%m/%Y");?>
</strong> ,Falta apenas <strong><?php echo $_smarty_tpl->getVariable('CountVencimento')->value;?>
</strong> Dias</p>
   <br />
            <h1><a href="./FormaPagamento?renovar">Renove agora clicando aqui (pagar)</a></h1><h1><a href="./Faleconosco">Outras formas de pagamento clique (aqui)</a></h1>
			
            <center>
			<br />
            <span style="margin-bottom:10px"><a href="javascript::void(0);" onclick="document.getElementById('ligcap').style.display='none';">Fechar</a></span>
            </center>
		</div>
	</div>
<?php }?>
<div id="Container">
 <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('Container')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
   <?php $_template = new Smarty_Internal_Template($_smarty_tpl->getVariable('Destaque')->value, $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate(); $_template->rendered_content = null;?><?php unset($_template);?>
</div>


</body>
</html>