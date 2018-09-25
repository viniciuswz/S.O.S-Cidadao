<?php
namespace Action;
use Core\Usuario;
use Model\MensagensM;

class MensagensA extends MensagensM{
    private $sqlInsertMensa = "INSERT INTO mensagem(texto_mensa, dataHora_mensa, cod_usu, cod_deba)
                                    VALUES('%s',NOW(),'%s','%s')";
    private $sqlVerificarMensagemDia = "SELECT count(*) FROM mensagem WHERE cod_deba = '%s' AND DATEDIFF(dataHora_mensa, NOW()) = '0'";
 
    public function inserirMensagem(){
        $veri = $this->verificarMensagemDia();
        if(!$veri){
            $codUsuSitema = $this->getDadosUsuSistema();
            $sql = sprintf(
                $this->sqlInsertMensa,
                'Primeira mensagem do dia',
                $codUsuSitema,
                $this->getCodDeba()
            );
            $res = $this->runQuery($sql);
        }
        $sql = sprintf(
            $this->sqlInsertMensa,
            $this->getTextoMensa(),
            $this->getCodUsu(),
            $this->getCodDeba()
        );
        $res2 = $this->runQuery($sql);
        return;
    }

    public function getDadosUsuSistema(){ // pegar dados do sistema
        $usuario = new Usuario();        
        $tirar = array('in',')','(',"'");// tirar a parte q eu nao quero
        return $codUsuSistema = str_replace($tirar,"",$usuario->getCodUsuByTipoUsu("in('Sistema')")); // pegar id do usuario sistema       
    }

    public function verificarMensagemDia(){
        $sql = sprintf(
            $this->sqlVerificarMensagemDia,
            $this->getCodDeba()
        );
        $res = $this->runSelect($sql);        
        if($res[0]['count(*)'] > 0){ // Ja existe uma mensagem hj
            return TRUE;
        }
        return FALSE; // nao existe uma mensagem hj
    }
}