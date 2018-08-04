<?php
namespace Action;
use Model\DebateDenunciaM;

class DebateDenunciaA extends DebateDenunciaM{
    private $verificarSeJaDenuncio = "SELECT COUNT(*) FROM debate_denun INNER JOIN usuario ON (debate_denun.cod_usu = usuario.cod_usu)    
        WHERE debate_denun.cod_deba = '%s' AND debate_denun.cod_usu = '%s' AND status_denun_deba = 'A' AND status_usu = 'A'";

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
}