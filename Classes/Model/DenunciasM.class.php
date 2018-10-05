<?php 

namespace Classes\Model;
use Db\DbConnection;

class DenunciasM extends DbConnection{        
    private $qtdPaginas;
    private $PaginaAtual;
    private $codDenun;

    public function setQuantidadePaginas($quantidade){// Seta a quantidade de paginas no total
        $this->qtdPaginas = $quantidade;
    }

    public function setCodDenun($cod){
        $this->codDenun = $cod;
    }

    public function getCodDenun(){
        return $this->codDenun;
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



