<?php 

namespace Model;
use Db\DbConnection;

class UsuarioM extends DbConnection{        
    private $email;
    private $senha;
    private $codUsu;
    private $nomeUsu;
    private $imgCapaUsu;
    private $imgPerfilUsu;
    private $codTipoUsu;
    private $dataHoraCadastro;

    public function getEmail(){
        return $this->email;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getNomeUsu(){
        return $this->nomeUsu;
    }

    public function getImgCapaUsu(){
        return $this->imgCapaUsu;
    }

    public function getImgPerfilUsu(){
        return $this->imgPerfilUsu;
    }

    public function getCodTipoUsu(){
        return $this->codTipoUsu;
    }

    public function getDataHoraCadastro(){
        return $this->dataHoraCadastro;
    }
    


    public function setEmail($email){
        $this->email = $email;
    }

    public function setCodUsu($codUsu){
        $this->codUsu = $codUsu;
    }
    
    public function setSenha($senha){
        $this->senha = $senha;
    }    

    public function setNomeUsu($nomeUsu){        
        $this->nomeUsu = filter_var($nomeUsu, FILTER_SANITIZE_STRING);
    }

    public function setImgCapaUsu($imgCapaUsu){
        $this->imgCapaUsu = $imgCapaUsu;
    }

    public function setImgPerfilUsu($imgPerfilUsu){
        $this->imgPerfilUsu = $imgPerfilUsu;
    }

    public function setCodTipoUsu($codTipoUsu){
        $this->codTipoUsu = $codTipoUsu;
    }

    public function setDataHoraCadastro($dataHoraCadastro){
        $this->dataHoraCadastro = $dataHoraCadastro;
    }

}



