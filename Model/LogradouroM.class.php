<?php 

namespace Model;
use Db\DbConnection;


class LogradouroM extends DbConnection{        
    private $cepLogra;
    private $endereLogra;
    private $codBai;

    public function getCepLogra(){
        return $this->cepLogra;
    }

    public function getEndereLogra(){
        return $this->endereLogra;
    }

    public function getCodBai(){
        return $this->codBai;
    }

    public function setCepLogra($cep){
        $this->cepLogra = $cep;
    }

    public function setEndereLogra($ende){
        $this->endereLogra = filter_var($ende, FILTER_SANITIZE_STRING);
    }

    public function setCodBai($cod){
        $this->codBai = $cod;
    }
}



