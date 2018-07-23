<?php 

namespace Notificacoes\Action;
use Notificacoes\Model\GenericaM;

class SelectPubliSalvaA extends GenericaM{  

    private $sqlSelect = "SELECT usuario.nome_usu, cod_comen, titulo_publi, usuario.cod_usu, publicacao.cod_publi 
                            FROM usuario INNER JOIN comentario ON (usuario.cod_usu = comentario.cod_usu) 
                            INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                            INNER JOIN publicacao ON (publicacao.cod_publi = comentario.cod_publi) 
                            WHERE status_comen = 'A' AND  status_publi = 'A' AND publicacao.cod_publi = '%s' AND (descri_tipo_usu = 'Prefeitura' or descri_tipo_usu = 'Funcionario')";



    public function getWherePubli(){   // Ta no esquema
        $ids = $this->getCodSalvos();        
        $sql = array();
        //$contador = 0;
        foreach($ids as $chaves => $valores){
            foreach($valores as $chave => $id){
                $sql[] = sprintf($this->sqlSelect, $id);                
            }          
        }     
        //echo "<br><br><br><br><strong>getWhereUserComum : :: IDS PUBLICACOES DO USUARIO: <br><br><br></strong>";
        //var_dump($sql);
        //$sql = sprintf($this->whereUserComum, $this->getCodPubli());
        return $sql;
    }
    public function selectComen($query){ // Ta no esquema
        $resultadoTemp = array();
        $resultadoFinal = array(); 
        foreach($query as $chave => $sql){
                    if(empty($this->runSelect($sql))){ // SE por um acaso nao retornar nada, nao joga nada na array
                       
                    }else{
                        $resultadoFinal[] = $this->runSelect($sql); //So vai entrar nesse array se tiver alguma coisa
                    }
             // Me retorna uma array tridimensional
        }
        //echo "<br><br><br><br><strong>Dados do comentario<br><br><br></strong>";
        //var_dump($resultadoFinal);             
        return $resultadoFinal;
    }
    
}