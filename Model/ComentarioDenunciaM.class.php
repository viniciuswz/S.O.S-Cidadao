<?php 
namespace Model;
use Db\DbConnection;
class ComentarioDenunciaM extends DbConnection{
    private $codDenunComen;
    private $dataHoraDenunComen;
    private $statusDenunComen;
    private $motivoDenunComen;
    private $indVisuAdm;
    private $codUsu;
    private $codComen;
    public function getCodDenunComen(){
        return $this->codDenunComen;
    }
    public function getDataHoraDenunComen(){
        return $this->dataHoraDenunComen;
    }
    public function getStatusDenunComen(){
        return $this->statusDenunComen;
    }
    public function getMotivoDenunComen(){
        return $this->motivoDenunComen;
    }
    public function getIndVisuAdm(){
        return $this->indVisuAdm;
    }
    public function getCodUsu(){
        return $this->codUsu;
    }
    public function getCodComen(){
        return $this->codComen;
    }
    public function setCodDenunComen($codDenunC){
        $this->codDenunComen = $codDenunC;
    }
    public function setDataHoraDenunComen($dtDenunC){
        $this->dataHoraDenunComen = $dtDenunC;
    }
    public function setStatusDenunComen($stDenunC){
        $this->statusDenunComen = $stDenunC;
    }
    public function setMotivoDenunComen($mtvDenunC){
        $this->motivoDenunComen = filter_var($mtvDenunC, FILTER_SANITIZE_STRING);
    }
    public function setIndVisuAdm($indVisuAdm){
        $this->indVisuAdm = $indVisuAdm;
    }
    public function setCodUsu($codU){
        $this->codUsu = $codU;
    }
    public function setCodComen($codC){
        $this->codComen = $codC;
    }
}