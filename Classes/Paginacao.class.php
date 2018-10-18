<?php
namespace Classes;
use Classes\Model\PaginacaoM;

class Paginacao extends PaginacaoM{
    private $limite = " order by %s %s limit %s,%s";  


    public function prapararSql($atributo,$ordenar,  $pagina, int $quantidadeTotal){        
        
        $quantidadePorPagina = $this->getQtdPubliPaginas();  
    
        if(!is_numeric($pagina) or $pagina <= 0 or $pagina == null){
            $texto = $pagina; // guardar o texto, pra ser usado posteriomente
            $pagina = 1;
        }     
        
        $this->setQuantidadePaginas($quantidadeTotal, $quantidadePorPagina);//Arrendonda pra cima, e seta        
        $quantidadePaginas = $this->getQuantidadePaginas();//Retorna

        if(isset($texto) AND $texto == 'ultima'){ // quero q ele va pra ultima pagina quando for escrito ultima
            $pagina = $quantidadePaginas;
        }

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

    public function prapararSqlDebateMensa($atributo,$ordenar,  $pagina, int $quantidadeTotal, int $quantidadeTotalMensaNVisu){
        $quantidadePorPagina = $this->getQtdPubliPaginas(); // quantidade de mensagens por pagina
        if(!is_numeric($pagina) or $pagina <= 0 or $pagina == null){
            $texto = $pagina; // guardar o texto, pra ser usado posteriomente
            $pagina = 1;
        }  

        if($quantidadeTotalMensaNVisu > $quantidadePorPagina){ 
            $linhaInicio = ($quantidadeTotal - $quantidadeTotalMensaNVisu); // exemplo (100 -80) - 2; comecar a pegar a partir da menagem 18
            $this->setQtdPubliPaginas($quantidadeTotalMensaNVisu); // quantidade de mensagens que quero
            $quantidadePorPagina = $this->getQtdPubliPaginas(); // quantidade de mensagens por pagina       
            $indMaior = true;     
        }

        $this->setQuantidadePaginas($quantidadeTotal, $quantidadePorPagina);//Arrendonda pra cima, e seta  
        $quantidadePaginas = $this->getQuantidadePaginas();//Retorna

        if(isset($texto) AND $texto == 'ultima'){ // quero q ele va pra ultima pagina quando for escrito ultima
            $pagina = $quantidadePaginas;
        }
        
        if($pagina <= $quantidadePaginas AND !isset($indMaior)){
            $this->setPaginaAtual($pagina);
            $inicio = $pagina * $quantidadePorPagina; // Até qual linha
            $linhaInicio = $inicio - $quantidadePorPagina; // Linha de inicio        
        }else if(!isset($indMaior)){ // Se a pgina informada for maior que a quantidade de paginas no total            
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
