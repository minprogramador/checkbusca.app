<?php

class Sistema_Senhas extends Sistema_Db_Abstract
{
    protected $_table      = 'con_serasa';
    private   $bureau      = null;
    private   $concentre   = null;
    private   $completa    = null;
    private   $identifica  = null;
    private   $infoBusca   = null;
    private   $relato      = null;
    private   $sinaliza    = null;
    private   $crednet     = null;
    private   $status      = null;
    
    public function getBureau(){ return $this->bureau; }

    public function setBureau($bureau){ $this->bureau = $bureau; }

    public function getConcentre(){ return $this->concentre; }

    public function setConcentre($concentre){ $this->concentre = $concentre; }
   
    public function getCompleta(){ return $this->completa; }

    public function setCompleta($completa){ $this->completa = $completa; }
   
    public function getIdentifica(){ return $this->identifica; }

    public function setIdentifica($identifica){ $this->identifica = $identifica; }
   
    public function getInfoBusca(){ return $this->infoBusca; }

    public function setInfoBusca($infobusca){ $this->infoBusca = $infobusca; }
   
    public function getRelato(){ return $this->relato; }

    public function setRelato($relato){ $this->relato = $relato; }
   
    public function getSinaliza(){ return $this->sinaliza; }

    public function setSinaliza($sinaliza){ $this->sinaliza = $sinaliza; }
   

    public function getCrednet(){ return $this->crednet; }

    public function setCrednet($cred){ $this->crednet = $cred; }


    public function getStatus(){ return $this->status; }

    public function setStatus($status){ $this->status = $status; }
   

    protected function _insert()
    {
        $db  = $this->getDb();
        $stm = $db->prepare(' insert into '.$this->_table.' (Bureau,Concentre,Completa,Identifica,InfoBusca,Relato,Sinaliza,Crednet,status)
		 Values (:bureau,:concentre,:completa,:identifica,:infobusca,:relato,:sinaliza,:crednet,:status)');
		
        $stm->bindValue(':bureau',     $this->getBureau());
        $stm->bindValue(':concentre',  $this->getConcentre());
        $stm->bindValue(':completa',   $this->getCompleta());
        $stm->bindValue(':identifica', $this->getIdentifica());
        $stm->bindValue(':infobusca',  $this->getInfoBusca());
        $stm->bindValue(':relato',     $this->getRelato());
        $stm->bindValue(':sinaliza',   $this->getSinaliza());
        $stm->bindValue(':crednet',   $this->getCrednet());
        $stm->bindValue(':status',     $this->getStatus());

        return $stm->execute();
    }
    
    protected function _update()
    {
        $db = $this->getDb();
        $stm = $db->prepare(" update $this->_table set Bureau=:bureau, Concentre=:concentre, Completa=:completa, Identifica=:identifica, InfoBusca=:infobusca, Relato=:relato, Sinaliza=:sinaliza, Crednet=:Crednet, status=:status where id=:id");

        $stm->bindValue(':id', 	       $this->getId());
        $stm->bindValue(':bureau',     $this->getBureau());
        $stm->bindValue(':concentre',  $this->getConcentre());
        $stm->bindValue(':completa',   $this->getCompleta());
        $stm->bindValue(':identifica', $this->getIdentifica());
        $stm->bindValue(':infobusca',  $this->getInfoBusca());
        $stm->bindValue(':relato',     $this->getRelato());
        $stm->bindValue(':sinaliza',   $this->getSinaliza());
        $stm->bindValue(':Crednet',   $this->getCrednet());
        $stm->bindValue(':status',     $this->getStatus());
        return $stm->execute();
    }
    
	public function getList()
	{
		$db  = $this->getDb();
        $stm = $db->prepare("select * from $this->_table where id=:id");
        $stm->bindValue(':id', $this->getId());
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);  
		return $result;  
	}
	
	public function getCon()
	{
		$db  = $this->getDb();
        $stm = $db->prepare("select * from $this->_table where id=:id");
        $stm->bindValue(':id', $this->getId());

        $stm->execute();
        $result = $stm->fetch(PDO::FETCH_ASSOC);  
		return $result;  
	}
	
	public function listarSenhas()
	{
		$db  = $this->getDb();
        $stm = $db->prepare("select * from `senhas` where servico=:serv");
        $stm->bindValue(':serv', 'Serasa');
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);  
		return $result;  
	}
	
    public function altStatus($status,$id)
    {
        $db = $this->getDb();
        $stm = $db->prepare(" update `senhas` status=:status where id=:id");
        $stm->bindValue(':id',     $id);
        $stm->bindValue(':status', $status);
        return $stm->execute();
    }

    public function listarSenhaSv($Servico)
    {
        $db  = $this->getDb();
        $stm = $db->prepare("select * from `senhas` where servico=:serv");
        $stm->bindValue(':serv', $Servico);
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);  
        return $result;  
    }

	public function listarCc()
	{
		$db  = $this->getDb();
        $stm = $db->prepare("select * from `fat_cc` where status=:status");
        $stm->bindValue(':status', '1');
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);  
		return $result;  
	}
	
	public function getFull()
	{
		$db  = $this->getDb();
        $stm = $db->prepare("select `con_serasa`.id,`senhas`.`id`,`senhas`.`servico`,`senhas`.`usuario` FROM `con_serasa` INNER JOIN `senhas` ON `con_serasa`.`id` = `senhas`.`id` ORDER BY `con_serasa`.`id` DESC");
        #$stm->bindValue(':id', $this->getId());
        $stm->execute();
        $result = $stm->fetchAll(PDO::FETCH_ASSOC);  
		return $result;  
	}
    
}