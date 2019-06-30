<?php 

namespace Model;
use Db\DbConnection;

class ComentarioM extends DbConnection{        
    private $codComen;
    private $textoComen;
    private $dataHora;
    private $indvisuDono;
    private $statusComen;
    private $codUsu;
    private $codPubli;
    private $indUltimaResposta;
    private $indResposta;
    private $notaResposta;
   
    private $qtdPaginas;
    private $PaginaAtual;

    public function getCodComen(){
        return $this->codComen;
    }

    public function getTextoComen(){
        return $this->textoComen;
    }

    public function getDataHora(){
        return $this->dataHora;
    }

    public function getIndvisuDono(){
        return $this->indvisuDono;
    }

    public function getStatusComen(){
        return $this->statusComen;
    }

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getCodPubli(){
        return $this->codPubli;
    }

    public function getIndUltimaResposta(){
        return $this->indUltimaResposta;
    }

    public function getIndResposta(){
        return $this->indResposta;
    }

    public function getNotaResposta(){
        return $this->notaResposta;
    }



    public function setCodComen($cod){
        $this->codComen = $cod;
    }

    public function setTextoComen($texto){
        $this->textoComen = ucfirst(filter_var($texto, FILTER_SANITIZE_STRING));
    }

    public function setDataHora($data){
        $this->dataHora = $data;
    }

    public function setIndvisuDono($ind){
        $this->indvisuDono = $ind;
    }

    public function setStatusComen($status){
        $this->statusComen = $status;
    }

    public function setCodUsu($cod){
        $this->codUsu = $cod;
    }

    public function setCodPubli($cod){
        $this->codPubli = $cod;
    }

    public function setIndUltimaResposta($ind){
        $this->indUltimaResposta = $ind;
    }

    public function setIndResposta($ind){
        $this->indResposta = $ind;
    }

    public function setNotaResposta($nota){
        $this->notaResposta = $nota;
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
        if($this->PaginaAtual == null){
            return 1;
        }
        return $this->PaginaAtual;
    }
    



}






