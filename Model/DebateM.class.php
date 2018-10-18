<?php 

namespace Model;
use Db\DbConnection;


class DebateM extends DbConnection{        

    private $codDeba;
    private $imgDeba;
    private $nomeDeba;
    private $dataHora;
    private $statusDeba;
    private $temaDeba;
    private $descriDeba;
    private $codUsu;

    private $qtdPaginas;
    private $PaginaAtual;

    public function getCodDeba(){
        return $this->codDeba;
    }
    public function getImgDeba(){
        return $this->imgDeba;
    }
    public function getNomeDeba(){
        return $this->nomeDeba;
    }
    public function getDataHora(){
        return $this->dataHora;
    }
    public function getStatusDeba(){
        return $this->statusDeba;
    }
    public function getTemaDeba(){
        return $this->temaDeba;
    }
    public function getDescriDeba(){
        return $this->descriDeba;
    }
    public function getCodUsu(){
        return $this->codUsu;
    }



    public function setCodDeba($cod){
        $this->codDeba = $cod;
    }
    public function setImgDeba($img){
        $this->imgDeba = $img;
    }
    public function setNomeDeba($nome){
        $this->nomeDeba = ucfirst(filter_var($nome, FILTER_SANITIZE_STRING));
    }
    public function setDataHora($hora){
        $this->dataHora = $hora;
    }
    public function setStatusDeba($status){
        $this->statusDeba = $status;
    }
    public function setTemaDeba($tema){
        $this->temaDeba =  ucfirst(filter_var($tema, FILTER_SANITIZE_STRING));
    }
    public function setDescriDeba($descri){
        $this->descriDeba =  ucfirst(filter_var($descri, FILTER_SANITIZE_STRING));
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



