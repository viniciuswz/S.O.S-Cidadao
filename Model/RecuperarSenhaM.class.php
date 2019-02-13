<?php 

namespace Model;
use Db\DbConnection;

class RecuperarSenhaM extends DbConnection{        
    private $email;
    private $novaSenha;
    private $codUsu;
    private $statusRecuperacao;
    private $dataHoraRecuperacao;
    private $codRecuperacao;  

    public function getEmail(){
        return $this->email;
    }

    public function getNovaSenha(){
        return $this->novaSenha;
    }

    public function getCodUsu(){
        return $this->codUsu;
    }

    public function getStatusRecuperacao(){
        return $this->statusRecuperacao;
    }
    
    public function getDataHoraRecuperacao(){
        return $this->dataHoraRecuperacao;
    }

    public function getCodRecuperacao(){
        return $this->codRecuperacao;
    }

    public function SetEmail($email){
        $this->email = ucfirst(filter_var($email, FILTER_SANITIZE_STRING));;
    }

    public function setNovaSenha($senha){
        $this->novaSenha = $senha;
    }

    public function setCodUsu($cod){
        $this->codUsu = $cod;
    }

    public function setStatusRecuperacao($status){
        $this->statusRecuperacao = $status;
    }
    
    public function setDataHoraRecuperacao($dataHora){
       $this->dataHoraRecuperacao = $dataHora;
    }

    public function setCodRecuperacao($cod){
        $this->codRecuperacao = $cod;
    }

}


