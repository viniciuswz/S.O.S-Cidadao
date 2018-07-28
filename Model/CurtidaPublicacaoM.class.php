<?php 

namespace Model;
use Db\DbConnection;

class CurtidaPublicacaoM extends DbConnection{        
    private $codUsu;
    private $codPubli;
    private $statusPubliCurti;
    private $indVisuDonoPubli;

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getCodPubli(){
        return $this->codPubli;
    }

    public function getStatusPubliCurti(){
        return $this->statusPubliCurti;
    }

    public function getIndVisuDonoPubli(){
        return $this->indVisuDonoPubli;
    }

    public function setCodUsu($codU){
        $this->codUsu = $codU;
    }

    public function setCodPubli($codP){
        $this->codPubli = $codP;
    }

    public function setStatusPubliCurti($statusP){
        $this->statusPubliCurti = $statusP;
    }

    public function setIndVisuDonoPubli($visuDono){
        $this->indVisuDonoPubli = $visuDono;
    }
}



