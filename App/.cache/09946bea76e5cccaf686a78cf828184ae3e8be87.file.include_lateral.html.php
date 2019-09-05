<?php /* Smarty version Smarty-3.0.8, created on 2019-09-05 20:45:02
         compiled from "tpls/include_lateral.html" */ ?>
<?php /*%%SmartyHeaderCode:8002233785d719dfed1fbb2-40974975%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '09946bea76e5cccaf686a78cf828184ae3e8be87' => 
    array (
      0 => 'tpls/include_lateral.html',
      1 => 1567104623,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8002233785d719dfed1fbb2-40974975',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/workspace/checkbusca.com/App/lib/Smarty/libs/plugins/modifier.date_format.php';
?><div class="TopoCon">
  <h2>Informações do Cliente</h2>
</div>
<div class="MioloLat">
  <p><strong>Usuário:&nbsp;</strong><?php echo $_SESSION['getNome'];?>
</p>
  <p><strong>Sistema Operacional:&nbsp;</strong><?php echo $_smarty_tpl->getVariable('getBrowser')->value['platform'];?>
</p>
  <p><strong>Navegador:&nbsp;</strong><?php echo $_smarty_tpl->getVariable('getBrowser')->value['name'];?>
</p>
  <p><strong>Valor Pago:</strong> R$ <?php echo $_smarty_tpl->getVariable('inPlano')->value['valor'];?>
</p>
  <p><strong>Horário:&nbsp;</strong><?php echo smarty_modifier_date_format(time(),"%H:%M:%S");?>
</p>
  <p><strong>Situação atual:&nbsp;</strong><?php if ($_SESSION['getStatus']==8){?>Aguardando Pagamento<?php }else{ ?><font color ="#32CD32">OK</font><?php }?></p>
  <p><strong>Vencimento:&nbsp;</strong><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('inPlano')->value['vencimento'],"%d/%m/%Y");?>
</p>
  <?php if ($_smarty_tpl->getVariable('inPlano')->value['limite']!=0){?>

  <br />
  <?php }?>
  <p>&nbsp;&nbsp;<strong><a href="./FormaPagamento">       </a></strong></p>
</div>
<?php if ($_SESSION['getStatus']==4||$_SESSION['getStatus']==8){?>

<?php }else{ ?>
<?php if ($_smarty_tpl->getVariable('CountVencimento')->value<=2){?>
<br />
<div class="TopoCon">
  <h2>Recado Pessoal</h2>
</div>
<div class="MioloLat">
  <p><center><img src="images//icons/avisox.png" /><br>
    Olá <strong><?php echo $_SESSION['getNome'];?>
</strong><font face="arial" size=2 color="#FF0000" ><blink> ATENÇÃO!</blink> sua conta esta vencendo!<br> </font> <strong></strong> <strong> </strong></p>
</div>
<?php }?>
<br />
<div class="TopoCon">
  <h2>Recado Check busca</h2>
</div>
<div class="MioloLat">
 <p> <?php if ($_smarty_tpl->getVariable('Recado')->value['status']==1){?>
    <?php echo utf8_encode(htmlspecialchars_decode($_smarty_tpl->getVariable('Recado')->value['mensagem']));?>

    <p><br /><strong>Atualizado em:</strong>&nbsp;<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('Recado')->value['data'],"%d/%m/%Y");?>
 </p><?php }else{ ?> <strong>Sem Avisos no Momento</strong> <?php }?> </p>
</div>
<?php }?>
