<?php 

namespace Model;
use Db\DbConnection;

class CurtirComentarioM extends DbConnection{
    private $codUsu;
    private $codComen;
    private $statusCurte;
    private $indVisuDonoPubli;

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getCodComen(){
        return $this->codComen;
    }

    public function getStatusCurte(){
        return $this->statusCurte;
    }

    public function getIndVisuDonoPubli(){
        return $this->indVisuDonoPubli;
    }

    public function setCodUsu($codU){
        $this->codUsu = $codU;
    }

    public function setCodComen($codC){
        $this->codComen = $codC;
    }

    public function setStatusCurte($statusC){
        $this->statusCurte = $statusC;
    }

    public function setIndVisuDonoPubli($visuDono){
        $this->indVisuDonoPubli = $visuDono;
    }
}