<?php

/*
	#busca localizacao do ip, armazena os dados se for do brasil para ser salvo no banco de dados.
*/
class Sistema_GetIp
{
    private $ip = null;
	
	public function setIp($ip){ $this->ip = $ip; }
	public function getIp()   { return $this->ip; }
	
	public function get()
	{
		$util = new Sistema_Util();
		$res  = $util->curl('http://www.geoiptool.com/pt/?IP='.$this->ip,null,null,null,null,null);
		$host = strip_tags($util->corta($res,'<td align="right"><span class="arial">Nome do Host:</span></td>','</td>'));
		$host = str_replace(' ','',$host);
		$host = str_replace("\n",'',$host);
		$pais = strip_tags($util->corta($res,'<td align="right"><span class="arial">Pa&iacute;s:</span></td>','</a>'));
		$pais = str_replace(' ','',$pais);
		$pais = str_replace("\n",'',$pais);
		$estado = strip_tags(trim(rtrim($util->corta($res,'<td align="right"><span class="arial">Regi&atilde;o:</span></td>','</a>'))));
		$estado = str_replace('  ','',$estado);
		$estado = str_replace("\n",'',$estado);
		$cidade = strip_tags(trim(rtrim($util->corta($res,'<td align="right"><span class="arial">Cidade:</span></td>','</td>'))));
		$cidade = str_replace('  ','',$cidade);
		$cidade = str_replace("\n",'',$cidade);

		$_SESSION['localizacao']['cidade'] = $cidade;
		$_SESSION['localizacao']['estado'] = $estado;
		$_SESSION['localizacao']['pais']   = $pais;
		$_SESSION['localizacao']['host']   = $host;

		if(strlen($pais) < 2)
		{
			return true;
		}
		else
		{
			$pais = strip_tags($pais);
			$pais = str_replace(' ','',$pais);
			$pais = str_replace("\n",'',$pais);
			
			if($pais == 'Brazil')
			{
				return true;
			}
			else{ return false; }
		}
	}
}

//http://www.geoiptool.com/pt/?IP=187.39.114.166