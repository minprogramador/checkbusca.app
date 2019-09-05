coisas em comum dos servicos.
//Mapa para modularizar essa porra.

- verifica se existe.   -----> checkService   ( nome url == nome sv + bd lay )

- verificar permissao. 	-----> checkPermissao ( id + servico )
- verificar limite. 	-----> getLimites 	  ( id + servico )


- pagina main/layout. 	-----> getMain		  ( pagina com os campos send )
- consultar.			-----> sendDados 	  ( payload a ser enviado )  
- pagina resultado.		-----> getDados 	  ( pagina retorno consultar )



- mensagem de erro caso nao tenha permissao de acesso ou consumo excedido.



- function curl
- function corta
- function getCookies
- function clearStr



- salvar log
	log de acesso ao servico ( qualquer visita a pagina, post ou get..)
	log de consumo do servico (logs de acertos e erros).


- UrlBase
	http://181.215.238.197/apistemp/zipOn/zipcode.php?token=apizipja2018

- envia payload para UrlBase  ---------------> sendDados ( envia post ou get )
- UrlBaseGet 				  ---------------> getDados  ( pelo id / doc )

- retornar dados e computar uso. (acrescenta +1 em usado).