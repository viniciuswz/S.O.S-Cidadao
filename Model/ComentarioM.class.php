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
    



}






