<?php
namespace Action;
use Model\PublicacaoDenunciaM;

class PublicacaoDenunciaA extends PublicacaoDenunciaM{
    private $sqlRegistro = "SELECT cod_denun_publi, motivo_denun_publi, dataHora_denun_publi, publi_denun.cod_usu, publi_denun.cod_publi 
                        FROM publi_denun INNER JOIN publicacao ON (publi_denun.cod_publi = publicacao.cod_publi)
                        INNER JOIN usuario ON (publi_denun.cod_usu = usuario.cod_usu)
                        WHERE publi_denun.cod_usu = '%s' AND publi_denun.cod_publi = '%s' AND status_denun_publi = 'A' AND
                        status_publi = 'A'  AND status_usu = 'A'";                        

    private $verificarSeJaDenuncio = "SELECT COUNT(*) FROM publi_denun INNER JOIN usuario ON (publi_denun.cod_usu = usuario.cod_usu)    
        WHERE publi_denun.cod_publi = '%s' AND publi_denun.cod_usu = '%s' AND status_denun_publi = 'A' AND status_usu = 'A'";

    private $sqlInsert = "INSERT INTO publi_denun(motivo_denun_publi, dataHora_denun_publi, cod_usu, cod_publi) 
        VALUES('%s',NOW(),'%s','%s')";

    private $sqlVerifyDonoPubli = "SELECT COUNT(*) FROM publicacao WHERE  status_publi = 'A' AND cod_usu = '%s' AND cod_publi = '%s'";

    public function verificarSeDenunciou(){ // Verificar se o dono ja denunciou a publicacao
        $sql = sprintf(
                    $this->verificarSeJaDenuncio,
                    $this->getCodPubli(),
                    $this->getCodUsu()
        );
        $res = $this->runSelect($sql);
        $quantidade = $res[0]['COUNT(*)'];
        if($quantidade > 0){ //Se for maior q zero é pq ele ja denunciou
            return TRUE;
        }
        return FALSE;        
    }

    public function verificarDonoPubli(){ // Verificar se o dono ja denunciou a publicacao
        $sql = sprintf(
                    $this->sqlVerifyDonoPubli,                    
                    $this->getCodUsu(),
                    $this->getCodPubli()
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
        $verificarDonoPubli = $this->verificarDonoPubli();// SE for true é pq ele é o no
        if($verificarDonoPubli or $verificar){ // Se ele for o dono nao faz nada           
            throw new \Exception("Você nao pode denunciar está publicação",14);
        }
         $sql = sprintf(
                $this->sqlInsert,
                $this->getMotivoDenunPubli(),                    
                $this->getCodUsu(),
                $this->getCodPubli()
        );
        $inserir = $this->runQuery($sql);            
        if(!$inserir->rowCount()){
            throw new \Exception("Erro ao denunciar!!",14);
        }
            return;       
    }
    
}