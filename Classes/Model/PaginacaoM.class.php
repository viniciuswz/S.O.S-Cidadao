<?php 

namespace Classes\Model;
//use Db\DbConnection;

class PaginacaoM {        
    private $qtdPubliPaginas;
    private $qtdPaginas;
    private $PaginaAtual;

    public function getQtdPubliPaginas(){//Pega a quantidade de publicacoes por pagina
        return $this->qtdPubliPaginas;
    }

    public function setQtdPubliPaginas($quantidadePorPagina = 6){//Pega a quantidade de publicacoes por pagina
        if(!is_numeric($quantidadePorPagina) or $quantidadePorPagina <= 0 ){
            $this->qtdPubliPaginas = 3;
            return;
        }
        $this->qtdPubliPaginas = $quantidadePorPagina; 
    }
    
    public function setQuantidadePaginas($quantidadeTotal, $quantidadePorPagina){// Seta a quantidade de paginas no total
        return $this->qtdPaginas = ceil($quantidadeTotal / $quantidadePorPagina);
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



