<?php
namespace Action;
use Model\MensagensM;

class MensagensA extends MensagensM{
    private $sqlInsertMensa = "INSERT INTO mensagem(texto_mensa, dataHora_mensa, cod_usu, cod_deba)
                                    VALUES('%s',NOW(),'%s','%s')";
    
    public function inserirMensagem(){
        $sql = sprintf(
            $this->sqlInsertMensa,
            $this->getTextoMensa(),
            $this->getCodUsu(),
            $this->getCodDeba()
        );
        $res = $this->runQuery($sql);
        return;
    }
}