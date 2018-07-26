<?php 
namespace Model;
use Db\DbConnection;
class PublicacaoM extends DbConnection{        
    private $codPubli;
    private $statusPubli;
    private $textoPubli;
    private $imgPubli;
    private $tituloPubli;
    private $dataHoraPubli;
    private $codUsu;
    private $codCate;
    private $cepLogra;

    private $qtdPubliPaginas = 6;
    private $qtdPaginas;
    private $PaginaAtual;

    public function getCodPubli(){
        return $this->codPubli;
    }

    public function getStatusPubli(){
        return $this->statusPubli;
    }

    public function getTextoPubli(){
        return $this->textoPubli;
    }

    public function getImgPubli(){//Me retorna um array
        return $this->imgPubli;
    }

    public function getTituloPubli(){
        return $this->tituloPubli;
    }

    public function getDataHoraPubli(){
        return $this->dataHoraPubli;
    }

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getCodCate(){
        return $this->codCate;
    }

    public function getCepLogra(){
        return $this->cepLogra;
    }
    
    public function setCodPubli($cod){
        $this->codPubli = $cod;
    }

    public function setStatusPubli($status){
        $this->statusPubli = $status;
    }

    public function setTextoPubli($texto){
        $this->textoPubli = ucfirst(filter_var($texto, FILTER_SANITIZE_STRING));
    }

    public function setImgPubli($img){
        $this->imgPubli = $img;
    }

    public function setTituloPubli($titulo){
        $this->tituloPubli = ucfirst(filter_var($titulo, FILTER_SANITIZE_STRING));
    }

    public function setDataHoraPubli($data){
        $this->dataHoraPubli = $data;
    }

    public function setCodUsu($cod){
        $this->codUsu = $cod;
    }

    public function setCodCate($cod){
        $this->codCate = $cod;
    }

    public function setCepLogra($cep){
        $this->cepLogra = filter_var($cep, FILTER_SANITIZE_STRING);
    }

    public function getQtdPubliPaginas(){//Pega a quantidade de publicacoes por pagina
        return $this->qtdPubliPaginas;
    }

    public function setQtdPubliPaginas($quantidade){//Pega a quantidade de publicacoes por pagina
        $this->qtdPubliPaginas = $quantidade;
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



