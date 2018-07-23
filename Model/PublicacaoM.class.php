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
        $this->textoPubli = filter_var($texto, FILTER_SANITIZE_STRING);
    }

    public function setImgPubli($img){
        $this->imgPubli = $img;
    }

    public function setTituloPubli($titulo){
        $this->tituloPubli = filter_var($titulo, FILTER_SANITIZE_STRING);
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

}



