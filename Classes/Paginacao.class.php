<?php
namespace Classes;
use Classes\Model\PaginacaoM;

class Paginacao extends PaginacaoM{
    private $limite = " order by %s %s limit %s,%s";  


    public function prapararSql($atributo,$ordenar,  $pagina, int $quantidadeTotal){        
        
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
