<?php 
namespace Model;
use Db\DbConnection;

class PublicacaoSalvaM extends DbConnection{        
    private $codUsu;
    private $codPubli;
    private $statusPubli;


    private $qtdPaginas;
    private $PaginaAtual;

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



