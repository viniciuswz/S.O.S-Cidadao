<?php 

namespace Classes\Model;
use Db\DbConnection;

class DenunciasM extends DbConnection{        
    private $qtdPaginas;
    private $PaginaAtual;


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



