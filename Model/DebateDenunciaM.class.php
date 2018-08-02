<?php 

namespace Model;
use Db\DbConnection;

class DebateDenunciaM extends DbConnection{
    private $codDenunDeba;
    private $indVisuAdmDenunDeba;
    private $statusDenunDeba;
    private $motivoDenunDeba;
    private $dataHoraDenunDeba;
    private $codUsu;
    private $codDeba;

    public function getCodDenunDeba(){
        return $this->codDenunDeba;
    }

    public function getIndVisuAdmDenunDeba(){
        return $this->indVisuAdmDenunDeba;
    }

    public function getStatusDenunDeba(){
        return $this->statusDenunDeba;
    }

    public function getMotivoDenunDeba(){
        return $this->motivoDenunDeba;
    }

    public function getDataHoraDenunDeba(){
        return $this->dataHoraDenunDeba;
    }

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getCodDeba(){
        return $this->codDeba;
    }

    public function setCodDenunDeba($codDenunD){
        $this->codDenunDeba = $codDenunD;
    }
    
    public function setIndVisuAdmDenunDeba($indVisuAdmDenunD){
        $this->indVisuAdmDenunDeba = $indVisuAdmDenunD;
    }

    public function setStatusDenunDeba($stDenunD){
        $this->statusDenunDeba = $stDenunD;
    }

    public function setMotivoDenunDeba($mtvDenunD){
        $this->motivoDenunDeba = $mtvDenunD;
    }

    public function setDataHoraDenunDeba($dtDenunD){
        $this->dataHoraDenunDeba = $dtDenunD;
    }

    public function setCodUsu($codU){
        $this->codUsu = $codU;
    }

    public function setCodDeba($codD){
        $this->codDeba = $codD;
    }
}