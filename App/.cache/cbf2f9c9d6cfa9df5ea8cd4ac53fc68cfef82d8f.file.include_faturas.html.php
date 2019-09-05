<?php /* Smarty version Smarty-3.0.8, created on 2019-09-05 20:48:28
         compiled from "tpls/include_faturas.html" */ ?>
<?php /*%%SmartyHeaderCode:18893182245d719ecc4fd5d7-49651580%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cbf2f9c9d6cfa9df5ea8cd4ac53fc68cfef82d8f' => 
    array (
      0 => 'tpls/include_faturas.html',
      1 => 1567727307,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18893182245d719ecc4fd5d7-49651580',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_modifier_date_format')) include '/workspace/checkbusca.com/App/lib/Smarty/libs/plugins/modifier.date_format.php';
?><?php if ($_smarty_tpl->getVariable('Pg')->value=="Fatura"){?>
<style type="text/css">
.wrapper {
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    border-radius: 6px 6px 6px 6px;
    margin: 0 auto;
    padding: 10px 20px 70px;
    width: 600px;
	margin-left:auto;
	margin-right:auto;
}
.wrapper a{
	font-family:Arial, Helvetica, sans-serif;
	font-size:18px;
	color:#333;
	text-decoration:none;
}
.wrapper a:hover{
	border-bottom:2px solid #333;
}
.header {
    margin: 0 0 15px;
    width: 100%;
}
table.items {
    background-color: #CCCCCC;
    border-collapse: separate;
    border-left: 1px solid #CCCCCC;
    border-spacing: 0;
    width: 100%;
}
table.items {
    border-collapse: separate;
    border-spacing: 0;
}
.row {
    margin: 15px 0;
}
table.items {
    background-color: #CCCCCC;
    border-collapse: separate;
    border-left: 1px solid #CCCCCC;
    border-spacing: 0;
    width: 100%;
}
body, td, input, select {
    color: #000000;
    font-family: Tahoma;
    font-size: 15px;
}
.paid {
    background: none repeat scroll 0 0 #779500;
    border: 1px solid #878787;
    border-radius: 3px 3px 3px 3px;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
    padding: 10px;
}
.unpaid {
    background: none repeat scroll 0 0 #CC0000;
    border: 1px solid #878787;
    border-radius: 3px 3px 3px 3px;
    color: #FFFFFF;
    font-size: 16px;
    font-weight: bold;
    margin-bottom: 10px;
    padding: 10px;
}
.refunded {
    font-size: 16px;
    color: #224488;
    font-weight: bold;
}

.cancelled {
    font-size: 16px;
    color: #cccccc;
    font-weight: bold;
}

.addressbox {
    background-color: #FFFFFF;
    border: 1px solid #CCCCCC;
    color: #000000;
    height: 60px;
    overflow: auto;
    padding: 10px;
}
table.items td {
    line-height: 15px;
}
table.items tr:last-child td {
    border-bottom: 1px solid #CCCCCC;
}
table.items td {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #FFFFFF;
    border-color: #CCCCCC #CCCCCC -moz-use-text-color -moz-use-text-color;
    border-image: none;
    border-style: solid solid none none;
    border-width: 1px 1px 0 0;
    line-height: 15px;
    margin: 0;
    padding: 2px;
}
table.items tr.title td {
    -moz-border-bottom-colors: none;
    -moz-border-left-colors: none;
    -moz-border-right-colors: none;
    -moz-border-top-colors: none;
    background-color: #EFEFEF;
    border-color: #CCCCCC #CCCCCC -moz-use-text-color -moz-use-text-color;
    border-image: none;
    border-style: solid solid none none;
    border-width: 1px 1px 0 0;
    font-size: 12px;
    font-weight: bold;
    line-height: 16px;
    margin: 0;
    padding: 2px 5px;
}
.title {
    font-size: 16px;
    font-weight: bold;
}
.textcenter {
    text-align: center;
}
.formapg{
	width:242px;
	overflow:hidden;
	margin-top:15px;
}
.img{
	float:left; overflow:hidden;
	width:317px;
	height:50px;
	margin-right:31px;
}
.img a{
	text-decoration:none;
}

.infor{
	overflow:hidden;
	text-align:right;
	margin-right:5px;
}
.bntPgg{
	overflow:hidden;
	width:188px;
	height:58px;
	margin-left:auto;
	margin-right:auto;
	margin-top:15px;
}
.bntPgg a:hover{
	text-decoration:none;
}
.bntPgg img:hover{
	text-decoration:none;
	border:0;
}
</style>
<div class="wrapper">
<table class="header">
    <tbody>
      <tr>
        
        <td align="center" width="50%"><br>
          <br>
    
          <?php if ($_smarty_tpl->getVariable('fats')->value['status']=="0"){?> <font class="unpaid">Liberado de 1 a 2 dias uteis,ou apos envio do comprovante.</font><br><br />
          <strong><?php echo $_smarty_tpl->getVariable('fats')->value['metodo_pagamento'];?>
</strong><br />
          <?php }elseif($_smarty_tpl->getVariable('fats')->value['status']=="1"){?> <font class="paid">Pago</font><br /><br />
          <strong><?php echo $_smarty_tpl->getVariable('fats')->value['metodo_pagamento'];?>
</strong><br />
          (<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('fats')->value['data_pagamento'],"%d/%m/%Y %H:%M");?>
)
         
          <?php }elseif($_smarty_tpl->getVariable('fats')->value['status']=="2"){?> <font class="paid">Pago</font><br /><br />
          <strong><?php echo $_smarty_tpl->getVariable('fats')->value['metodo_pagamento'];?>
</strong><br />
          (<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('fats')->value['data_pagamento'],"%d/%m/%Y %H:%M");?>
)
         
          <?php }elseif($_smarty_tpl->getVariable('fats')->value['status']=="5"){?> <font class="refunded">Em analise</font>
          
          <?php }elseif($_smarty_tpl->getVariable('fats')->value['status']=="3"){?> <font class="unpaid">Em aberto</font>
          <strong><?php echo $_smarty_tpl->getVariable('fats')->value['metodo_pagamento'];?>
</strong><br />
          <?php }else{ ?>
          <font class="unpaid">Em aberto</font><br>
          <?php }?>
		  
          <?php if ($_smarty_tpl->getVariable('fats')->value['status']=="0"||$_smarty_tpl->getVariable('fats')->value['status']=="3"){?>
          <br><br>
          
          <form method="post" action="<?php echo $_smarty_tpl->getVariable('PATCH')->value;?>
/FormaPagamento?id=<?php echo $_smarty_tpl->getVariable('id')->value;?>
">
            <select name="gateway" onchange="submit()" id="gateway">
             <?php if ($_smarty_tpl->getVariable('Forma')->value==1){?>
              <option value="1" selected="selected">Boleto Banc&aacute;rio</option>
              
            <?php }?>
            </select>
            <input type="hidden" name="id" id="id" value="<?php echo $_smarty_tpl->getVariable('id')->value;?>
">
          </form>
        
          <br>
          Valor da Fatura: <b>R$ <?php echo $_smarty_tpl->getVariable('fats')->value['valor'];?>
</b> <br>
          Valor &agrave; Pagar: <b>R$ <?php echo $_smarty_tpl->getVariable('fats')->value['valor'];?>
 </b> <br>
          <br>

        
          
          <?php if ($_smarty_tpl->getVariable('Forma')->value=="2"){?>
          <form method="get" action="<?php echo $_smarty_tpl->getVariable('PATCH')->value;?>
/FormaPagamento?id=<?php echo $_smarty_tpl->getVariable('id')->value;?>
&banco=">
          
          
          
                      <p>
            </p>
            <?php if (isset($_GET['banco'])){?>  <div class="bntPgg" title="Clique aqui para concluir o pagamento."><a href="<?php echo $_smarty_tpl->getVariable('Link')->value;?>
"><img alt="Clique aqui para concluir o pagamento." src="images/BntPagar-002.jpg" width="188" height="58" /></a></div> <?php }?>

          <?php }elseif($_smarty_tpl->getVariable('Forma')->value=="1"){?>
          
           <div class="bntPgg" title="Clique aqui para concluir o pagamento."><a href="<?php echo $_smarty_tpl->getVariable('Link')->value;?>
" target="_blank"><img alt="Clique aqui para concluir o pagamento." src="images/BntPagar-001.jpg" width="188" height="58" /></a></div>


          <?php }else{ ?>
   <!--       <img src="images/pagseguro-fatura.jpg" width="192" height="90"><br>-->
          <br>
          <!--<a href="<?php echo $_smarty_tpl->getVariable('linkPg')->value;?>
" id="pgPagseguro" target="_blank" title="Pagar agora"><img src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/pagamentos/209x48-pagar-assina.gif"></a> <br>-->
          <?php }?> <br>
       <?php }?>
            </td>
      </tr>
    </tbody>
  </table>




  <!--<table class="header">
    <tbody>
      <tr>
        <td nowrap="nowrap">
        <div class="img"><img src="images/LOGOS.png" width="317" height="50" /></div>
        <div class="formapg">
          <strong style="float:left; margin-right:8px;">Forma de Pagamento:</strong>
          <form action="./FormaPagamento?id=<?php echo $_smarty_tpl->getVariable('id')->value;?>
" method="post">
            <select id="gateway" onChange="submit()" name="gateway">
             <?php if ($_smarty_tpl->getVariable('Forma')->value==1){?>
              <option value="1" selected="selected">Boleto Banc&aacute;rio</option>
              <option value="2">D&eacute;bito Banc&aacute;rio</option>
              <?php }else{ ?>		
              <option value="1">Boleto Banc&aacute;rio</option>
              <option value="2"  selected="selected">D&eacute;bito Banc&aacute;rio</option>
            <?php }?>
            </select>
            <input type="hidden" value="<?php echo $_smarty_tpl->getVariable('id')->value;?>
" id="id" name="id">
          </form></div>
          <div class="infor">
          Valor da Fatura:&nbsp;&nbsp;<b>R$ <?php echo $_smarty_tpl->getVariable('fats')->value['valor'];?>
</b> <br>
          Valor &agrave; Pagar:&nbsp;&nbsp;<b>R$ <?php echo $_smarty_tpl->getVariable('fats')->value['valor'];?>
</b> </div>
          <br>
          <form method="post" action="javascript:void(0);">
            <div class="addressConclusion" id="addresses">
              <div id="res"> </div>
            </div>
            <div class="bntPg"> <a href="<?php echo $_smarty_tpl->getVariable('Link')->value;?>
"><img src="images/BntPagar.png" width="188" height="58" /></a>
            </div>
          </form>
          <br></td>
      </tr>
    </tbody>
  </table> -->
  
  <table class="items">
    <tbody>
      <tr>
        <td width="50%"><div class="addressbox"> <strong>Faturado para</strong><br>
            Nome:&nbsp;<?php echo $_smarty_tpl->getVariable('infUser')->value['nome'];?>
<br>
            E-mail:&nbsp;<?php echo $_smarty_tpl->getVariable('infUser')->value['email'];?>
<br>
          </div></td>
        <td width="50%"><div class="addressbox"> <strong>Pagar a</strong><br>
            <?php echo $_smarty_tpl->getVariable('NOMESITE')->value;?>
<br>
            <?php echo $_smarty_tpl->getVariable('EmailInfo')->value;?>
<br>
          </div></td>
      </tr>
    </tbody>
  </table>
  <div class="row"> <span class="title">Fatura [ <?php echo $_smarty_tpl->getVariable('fats')->value['id'];?>
 ]</span><br>
    Data da Fatura:&nbsp;<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('fats')->value['data'],"%d/%m/%Y");?>
<br>
    Vencimento:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('fats')->value['data_vencimento'],"%d/%m/%Y");?>
</div>
  <table class="items">
    <tbody>
      <tr class="title textcenter">
        <td width="70%">Descri&ccedil;&atilde;o</td>
        <td width="30%">Valor</td>
      </tr>
      <tr>
        <td>Periodo <?php echo $_smarty_tpl->getVariable('fats')->value['periodo'];?>
 Dias</td>
        <td class="textcenter">R$ <?php echo $_smarty_tpl->getVariable('fats')->value['valor'];?>
 </td>
      </tr>
      <tr class="title">
        <td class="textright">Sub Total:</td>
        <td class="textcenter">R$ <?php echo $_smarty_tpl->getVariable('fats')->value['valor'];?>
 </td>
      </tr>
      <tr class="title">
        <td class="textright">Total:</td>
        <td class="textcenter">R$ <?php echo $_smarty_tpl->getVariable('fats')->value['valor'];?>
</td>
      </tr>
    </tbody>
  </table><br />
  <center><a href="./FormaPagamento">Voltar</a></center>
  <center><br /><strong><a href="Faleconosco"><font face="arial" size=2 color="#FF0000" > Precisa de ajuda? clique (aqui)</strong></p><br /><br /></center>
  <br>
</div>
<?php }else{ ?>
<style type="text/css">
table {
	border-collapse: collapse;
	margin: 1em;
	margin-left:0;
	width:670px;
	margin-left:auto;
	margin-right:auto;
	font-family:Arial, Helvetica, sans-serif;
	font-size:15px;
	color:#333;
}
table thead {
	background: none repeat scroll 0 0 #ECECEC;
}
table tbody {
	background: none repeat scroll 0 0 #FDFDFD;
}
table td, th {
	border: 1px solid #CCCCCC;
	padding: 0.3em;
	line-height: 1.5em;
}
</style>
<table style="width:670px">
  <thead>
    <tr>
      <th>ID</th>
      <th>DATA</th>
      <th>PERIODO</th>
      <th>VALOR</th>
      <th>GATEWAY</th>
      <th>TIPO</th>
      <th>STATUS</th>
      <th>Ação</th>
    </tr>
  </thead>
  <tbody>
  
  <?php unset($_smarty_tpl->tpl_vars['smarty']->value['section']['i']);
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['name'] = 'i';
$_smarty_tpl->tpl_vars['smarty']->value['section']['i']['loop'] = is_array($_loop=$_smarty_tpl->getVariable('fats')->value) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
  <tr align="center" style="font-size:15px;">
    <td><?php echo $_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
</td>
    <td><?php echo smarty_modifier_date_format($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['data'],"%d/%m/%Y");?>
</td>
    <td><?php echo $_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['periodo'];?>
&nbsp;Dias</td>
    <td>R$:&nbsp;<?php echo $_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['valor'];?>
</td>
    <td> <?php if ($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['forma_pagamento']==1){?>
      Moip
      <?php }else{ ?>
      Debito bancario
      <?php }?> </td>
    <td> <?php if ($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['tipo']==1){?>
      Contratacao
      <?php }else{ ?>
      Renovacao
      <?php }?> </td>
    <td> <?php if ($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==0){?>
      <font color="#ff0000">Pendente !
      <?php }elseif($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==1){?>
      <font color="#228b22">Paga v
      <?php }elseif($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==2){?>
      Paga
      <?php }elseif($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==3){?>
      Boleto Impresso
      <?php }elseif($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==4){?>
      Concluido
      <?php }elseif($_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['status']==5){?>
      Em analise
      <?php }?> </td>
    <td><a href="./FormaPagamento?id=<?php echo $_smarty_tpl->getVariable('fats')->value[$_smarty_tpl->getVariable('smarty')->value['section']['i']['index']]['id'];?>
" class="window"><font color="#025ec7"><strong> PAGAR</strong></font></a></td>
  </tr>
  <?php endfor; endif; ?>
    </tbody>
  
</table>
            

 
<center>

   
<h2>Após efetuar o pagamento aguarde de 1 a 2 dias úteis ou
envie o comprovante de pagamento!</h2><br /><strong>
  <a href="Confirmar-pagamento" class="window"><font face="arial" size=2 color="#FF0000" > Enviar comprovante clique (aqui)</strong></p><br /><br /></center>


<?php }?>