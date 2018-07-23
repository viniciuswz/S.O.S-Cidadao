<?php 

namespace Model;
use Db\DbConnection;

class BairroM extends DbConnection{        
    private $statusBai;
    private $NomeBai;
    private $codBai;

    public function getStatusBai(){
        return $this->statusBai;
    }

    public function getNomeBai(){
        return $this->NomeBai;
    }

    public function getCodBai(){
        return $this->codBai;
    }

    public function setStatusBai($status){
        $this->statusBai = $status;
    }

    public function setNomeBai($nome){        
       $this->NomeBai = filter_var($nome, FILTER_SANITIZE_STRING);
    }

    public function setCodBai($cod){
        $this->codBai = $cod;
    }
}



