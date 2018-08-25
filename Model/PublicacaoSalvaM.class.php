<?php 
namespace Model;
use Db\DbConnection;

class PublicacaoSalvaM extends DbConnection{        
    private $codUsu;
    private $codPubli;
    private $statusPubli;

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getCodPubli(){
        return $this->codPubli;
    }

    public function getStatusPubli(){
        return $this->statusPubli;
    }

    public function setStatusPubli($status){
        $this->statusPubli = $status;
    }

    public function setCodPubli($cod){        
       $this->codPubli = $cod;
    }

    public function setCodUsu($cod){
        $this->codUsu = $cod;
    }
}



