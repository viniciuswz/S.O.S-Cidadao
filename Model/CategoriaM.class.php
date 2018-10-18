<?php 

namespace Model;
use Db\DbConnection;

class CategoriaM extends DbConnection{        
    private $descricao;
    private $codCate;

    public function getDescCate(){
        return $this->descricao;
    }

    public function getCodCate(){
        return $this->codCate;
    }

    public function setDescCate($categoria){
        $this->descricao = filter_var($categoria, FILTER_SANITIZE_STRING);
    }

    public function setCodCate($cod){
        $this->codCate = $cod;
    }
}



