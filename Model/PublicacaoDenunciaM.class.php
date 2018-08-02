<?php 

namespace Model;
use Db\DbConnection;

class PublicacaoDenunciaM extends DbConnection{
    private $codDenunPubli;
    private $indVisuAdmDenunPubli;
    private $motivoDenunPubli;
    private $statusDenunPubli;
    private $dataHoraDenunPubli;
    private $codUsu;
    private $codPubli;

    public function getCodDenunPubli(){
        return $this->codDenunPubli;
    }

    public function getIndVisuAdmDenunPubli(){
        return $this->indVisuAdmDenunPubli;
    }

    public function getMotivoDenunPubli(){
        return $this->motivoDenunPubli;
    }

    public function getStatusDenunPubli(){
        return $this->statusDenunPubli;
    }

    public function getDataHoraDenunPubli(){
        return $this->dataHoraDenunPubli;
    }

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getCodPubli(){
        return $this->codPubli;
    }

    public function setCodDenunPubli($codDenunP){
        $this->codDenunPubli = $codDenunP;
    }

    public function setIndVisuAdmDenunPubli($indVisuAdmDenunP){
        $this->indVisuAdmDenunPubli = $indVisuAdmDenunP;
    }

    public function setMotivoDenunPubli($mtvDenunPubli){
        $this->motivoDenunPubli = $mtvDenunPubli;
    }

    public function setStatusDenunPubli($stDenunPubli){
        $this->statusDenunPubli = $stDenunPubli;
    }

    public function setDataHoraDenunPubli($dtDenunPubli){
        $this->dataHoraDenunPubli = $dtDenunPubli;
    }

    public function setCodUsu($codU){
        $this->codUsu = $codU;
    }

    public function setCodPubli($codP){
        $this->codPubli = $codP;
    }
}