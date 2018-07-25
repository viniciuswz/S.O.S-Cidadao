<?php
namespace Classes;
class Paginacao{
    private $limite = " order by %s %s limit %s,%s";


    private $qtdPubliPaginas;
    private $qtdPaginas;
    private $paginaAtual;

    public function getQtdPubliPaginas(){//Pega a quantidade de publicacoes por pagina
        return $this->qtdPubliPaginas;
    }

    public function setQtdPubliPaginas($quantidadePorPagina){ // Seta a quantiade de publicacoes por pagina
        if(!is_numeric($quantidadePorPagina) or $quantidadePorPagina <= 0 ){
            $this->qtdPubliPaginas = 3;
            return;
        }
        $this->qtdPubliPaginas = $quantidadePorPagina; 
    }

    public function setQuantidadePaginas($quantidadeTotal, $quantidadePorPagina){ // Seta a quantidade de paginas no total

        return $this->qtdPaginas = ceil($quantidadeTotal / $quantidadePorPagina);

    }

    public function getQuantidadePaginas(){// Pega a quantidade de paginas no total
        return $this->qtdPaginas;
    }

    public function getPaginaAtual(){
        return $this->paginaAtual;
    }

    public function setPaginaAtual($pagina){
        $this->paginaAtual = $pagina;
    }

    public function prapararSql($atributo,$ordenar, int $quantidadePorPagina,  $pagina, int $quantidadeTotal){

        $this->setQtdPubliPaginas($quantidadePorPagina);
        
        $quantidadePorPagina = $this->getQtdPubliPaginas();  

        if(!is_numeric($pagina) or $pagina <= 0 or $pagina == null){
            $pagina = 1;
        }     
        
        $this->setQuantidadePaginas($quantidadeTotal, $quantidadePorPagina);//Arrendonda pra cima, e seta

        $quantidadePaginas = $this->getQuantidadePaginas();//Retorna

        if($pagina <= $quantidadePaginas){
            $this->setPaginaAtual($pagina);
            $inicio = $pagina * $quantidadePorPagina; // Até qual linha
            $linhaInicio = $inicio - $quantidadePorPagina; // Linha de inicio        
        }else{ // Se a pgina informada for maior que a quantidade de paginas no total
            $this->setPaginaAtual($quantidadePaginas);
            $linhaInicio = ($quantidadePorPagina * $quantidadePaginas) - $quantidadePorPagina;
        }

        return $sql = sprintf($this->limite, 
                $atributo,
                $ordenar, 
                $linhaInicio, // A partir de qual linha
                $quantidadePorPagina // quantos registros tem q pegar
            );
        
    }    
}
