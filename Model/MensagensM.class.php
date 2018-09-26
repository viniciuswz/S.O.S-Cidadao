<?php 

namespace Model;
use Db\DbConnection;


class MensagensM extends DbConnection{        
    
    private $codMensa;
    private $textoMensa;
    private $status;
    private $dataHora;
    private $codUsu;
    private $codDeba;

    private $qtdPaginas;
    private $PaginaAtual;

    public function getCodMensa(){
        return $this->codMensa;
    }
    public function getTextoMensa(){
        return $this->textoMensa;
    }
    public function getStatus(){
        return $this->status;
    }
    public function getDataHora(){
        return $this->dataHora;
    }
    public function getCodUsu(){
        return $this->codUsu;
    }
    public function getCodDeba(){
        return $this->codDeba;
    }


    public function setCodMensa($cod){
        $this->codMensa = $cod;
    }
    public function setTextoMensa($texto){
        $this->textoMensa = ucfirst(filter_var($texto, FILTER_SANITIZE_STRING));
    }
    public function setStatus($status){
        $this->status = $status;
    }
    public function setDataHora($data){
        $this->dataHora = $data;
    }
    public function setCodUsu($cod){
        $this->codUsu = $cod;
    }
    public function setCodDeba($cod){
        $this->codDeba = $cod;
    }

    public function setQuantidadePaginas($quantidade){// Seta a quantidade de paginas no total
        $this->qtdPaginas = $quantidade;
    }

    public function getQuantidadePaginas(){ // Pega a quantidade de paginas no total 
       return $this->qtdPaginas;
    }

    public function setPaginaAtual($pagina){// Seta a pagina atual
        $this->PaginaAtual = $pagina;
    }

    public function getPaginaAtual(){// Pega a pagina atual
        return $this->PaginaAtual;
    }

}



