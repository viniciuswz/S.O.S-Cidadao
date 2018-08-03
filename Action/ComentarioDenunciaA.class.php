<?php
namespace Action;
use Model\ComentarioDenunciaM;

class ComentarioDenunciaA extends ComentarioDenunciaM{
    private $verificarSeJaDenuncio = "SELECT COUNT(*) FROM comen_denun INNER JOIN usuario ON (comen_denun.cod_usu = usuario.cod_usu)    
        WHERE comen_denun.cod_comen = '%s' AND comen_denun.cod_usu = '%s' AND status_denun_comen = 'A' AND status_usu = 'A'";

    public function verificarSeDenunciou(){ // Verificar se o dono ja denunciou a publicacao
        $sql = sprintf(
                    $this->verificarSeJaDenuncio,
                    $this->getCodComen(),
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