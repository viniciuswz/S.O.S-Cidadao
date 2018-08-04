<?php
namespace Action;
use Model\ComentarioDenunciaM;

class ComentarioDenunciaA extends ComentarioDenunciaM{
    private $sqlRegistro = "SELECT cod_denun_comen, motivo_denun_comen, dataHora_denun_comen, comen_denun.cod_usu, comen_denun.cod_comen
        FROM comen_denun INNER JOIN comentario ON (comen_denun.cod_comen = comentario.cod_comen)
                          INNER JOIN usuario ON (comen_denun.cod_usu = usuario.cod_usu)
        WHERE comen_denun.cod_usu = '%s' AND comen_denun.cod_comen = '%s' AND status_denun_comen = 'A' 
                                          AND status_comen = 'A' AND status_usu = 'A'";

    private $sqlInsert = "INSERT INTO comen_denun(motivo_denun_comen, dataHora_denun_comen, cod_usu, cod_comen) 
        VALUES('%s',NOW(),'%s','%s')";

    private $verificarSeJaDenuncio = "SELECT COUNT(*) FROM comen_denun INNER JOIN usuario ON (comen_denun.cod_usu = usuario.cod_usu)    
        WHERE comen_denun.cod_comen = '%s' AND comen_denun.cod_usu = '%s' AND status_denun_comen = 'A' AND status_usu = 'A'";


private $sqlVerifyDonoComen = "SELECT COUNT(*) FROM comentario WHERE  status_comen = 'A' AND cod_usu = '%s' AND cod_comen = '%s'";
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

    public function verificarDonoComen(){
        $sql = sprintf(
                        $this->sqlVerifyDonoComen,
                        $this->getCodUsu(),
                        $this->getCodComen()
        );
        $res = $this->runSelect($sql);
        $quantidade = $res[0]['COUNT(*)'];
        if($quantidade > 0){//Se for maior q zero é pq ele é o dono
            return TRUE;
        }
            return FALSE;
    }

    public function inserirDenuncia(){ // Inserir a denuncia
        $verificar = $this->verificarSeDenunciou(); // SE for true é pq ja denunciou
        $verificarDonoComen = $this->verificarDonoComen();// SE for true é pq ele é o no
        if($verificarDonoComen or $verificar){ // Se ele for o dono nao faz nada           
            throw new \Exception("Você nao pode denunciar está publicação",14);
        }
         $sql = sprintf(
                $this->sqlInsert,
                $this->getMotivoDenunComen(),                    
                $this->getCodUsu(),
                $this->getCodComen()
        );
        $inserir = $this->runQuery($sql);            
        if(!$inserir->rowCount()){
            throw new \Exception("Erro ao denunciar!!",14);
        }
            return;       
    }
}