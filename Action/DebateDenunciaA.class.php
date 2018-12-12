<?php
namespace Action;
use Model\DebateDenunciaM;

class DebateDenunciaA extends DebateDenunciaM{
    private $sqlRegistro = "SELECT cod_denun_deba, motivo_denun_deba, dataHora_denun_deba, debate_denun.cod_usu, debate_denun.cod_deba
        FROM debate_denun INNER JOIN debate ON (debate_denun.cod_deba = debate.cod_deba)
                          INNER JOIN usuario ON (debate_denun.cod_usu = usuario.cod_usu)
        WHERE debate_denun.cod_usu = '%s' AND debate_denun.cod_deba = '%s' AND status_denun_deba = 'A' 
                                          AND status_deba = 'A' AND status_usu = 'A'";

    private $verificarSeJaDenuncio = "SELECT COUNT(*) FROM debate_denun INNER JOIN usuario ON (debate_denun.cod_usu = usuario.cod_usu)    
        WHERE debate_denun.cod_deba = '%s' AND debate_denun.cod_usu = '%s' AND status_denun_deba = 'A' AND status_usu = 'A'";


    private $sqlInsert = "INSERT INTO debate_denun(motivo_denun_deba, dataHora_denun_deba, cod_usu, cod_deba) 
        VALUES('%s','%s','%s','%s')";

    private $sqlVerifyDonoDeba = "SELECT COUNT(*) FROM debate WHERE  status_deba = 'A' AND cod_usu = '%s' AND cod_deba = '%s'";
    public function verificarSeDenunciou(){ // Verificar se o dono ja denunciou a publicacao
        $sql = sprintf(
                    $this->verificarSeJaDenuncio,
                    $this->getCodDeba(),
                    $this->getCodUsu()
        );
        $res = $this->runSelect($sql);
        $quantidade = $res[0]['COUNT(*)'];
        if($quantidade > 0){ //Se for maior q zero é pq ele ja denunciou
            return TRUE;
        }
        return FALSE;        
    }

    public function verificarDonoDeba(){ // Verificar se o dono ja denunciou a publicacao
        $sql = sprintf(
                    $this->sqlVerifyDonoDeba,                    
                    $this->getCodUsu(),
                    $this->getCodDeba()
        );
        $res = $this->runSelect($sql);
        $quantidade = $res[0]['COUNT(*)'];
        if($quantidade > 0){ //Se for maior q zero é pq ele é o dono
            return TRUE;
        }
        return FALSE;        
    }

    public function inserirDenuncia(){ // Inserir a denuncia
        $verificar = $this->verificarSeDenunciou(); // SE for true é pq ja denunciou
        $verificarDonoDeba = $this->verificarDonoDeba();// SE for true é pq ele é o no
        if($verificarDonoDeba or $verificar){ // Se ele for o dono nao faz nada           
            throw new \Exception("Você nao pode denunciar está publicação",14);
        }
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 
        $sql = sprintf(
                $this->sqlInsert,
                $this->getMotivoDenunDeba(),     
                $DataHoraFormatadaAmerica,               
                $this->getCodUsu(),
                $this->getCodDeba()
        );
        $inserir = $this->runQuery($sql);            
        if(!$inserir->rowCount()){
            throw new \Exception("Erro ao denunciar!!",14);
        }
            return;       
    }
}