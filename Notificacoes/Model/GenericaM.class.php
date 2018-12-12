<?php 

namespace Notificacoes\Model;
use Db\DbConnection;


// Teste da Publicacao Curtida
class GenericaM extends DbConnection{    
    private $codUsu;    
    private $codPubli;  
    private $codComen;
    private $codSalvo;

    public function getCodUsu():int{
        return $this->codUsu;
    }


    public function getCodPubli():array{
        return $this->codPubli;
    }  

    public function getCodComen():array{
        return $this->codComen;
    } 

    public function getCodSalvos():array{
        return $this->codSalvo;
    } 


    public function setCodUsu($CodUsu) {
        $this->codUsu = $CodUsu;
    }

    public function setCodPubli($codPubli) {
        $this->codPubli = $codPubli;
    }

    public function setCodComen($codComen) {
        $this->codComen = $codComen;
    }

    public function setCodSalvos($codSalvos) {
        $this->codSalvo = $codSalvos;
    }

    
}



