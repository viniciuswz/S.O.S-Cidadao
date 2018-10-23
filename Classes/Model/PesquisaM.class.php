<?php 

namespace Classes\Model;
use Db\DbConnection;

class PesquisaM extends DbConnection{        
    private $qtdPaginas;
    private $PaginaAtual;
    private $textoPesqui;
    private $codUsu;
    private $vlrMaiorqtd = 0;

    public function setTextoPesqui($texto){
        $this->textoPesqui = filter_var($texto, FILTER_SANITIZE_STRING);
    }

    public function setCodUsu($cod){
        $this->codUsu = $cod;
    }
    public function setQuantidadePaginas($quantidade){// Seta a quantidade de paginas no total
        $this->qtdPaginas = $quantidade;
    }
    public function setMaiorQuant($qtd){ // preciso guardar a maior qtd de paginass
        if($qtd > $this->vlrMaiorqtd){
            $this->vlrMaiorqtd = $qtd;
        }
    }

    public function getTextoPesqui(){
        return $this->textoPesqui;
    }

    public function getCodUsu(){
        return $this->codUsu;
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

    public function getQuantidadeTotalPaginas(){
        return $this->vlrMaiorqtd;
    }
    
}



