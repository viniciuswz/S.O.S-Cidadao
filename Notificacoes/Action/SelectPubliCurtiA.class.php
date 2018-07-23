<?php 

namespace Notificacoes\Action;
use Notificacoes\Model\GenericaM;

class SelectPubliCurtiA extends GenericaM{  
    private $sqlSelect = "SELECT usuario.nome_usu, titulo_publi, publicacao_curtida.cod_publi 
                            FROM publicacao_curtida INNER JOIN usuario ON(publicacao_curtida.cod_usu = usuario.cod_usu)
                            INNER JOIN publicacao ON (publicacao_curtida.cod_publi = publicacao.cod_publi) 
                            WHERE ind_visu_dono_publi = 'N' AND status_publi_curti = 'A' AND publicacao_curtida.cod_publi = '%s' 
                            AND publicacao.status_publi = 'A'";

    public function select():array{ // Ja ta no esquema
        $ids = $this->getCodPubli();   
        //echo "<strong>IDS PUBLICACOES DO USUARIO: <br><br><br></strong>";
        //var_dump($ids);     
        $resultadoFinal = array();  
        $contador = 0;      
        
        foreach($ids as $chave => $id){ // Execucao = Quantidade de comentarios curtidos                 
            foreach($id as  $id2){ 
                $sql = sprintf( $this->sqlSelect, $id2); // parada de colocar o id no lugar do %s, como os ids estao em uma array tive q colocar dentro de um foreach
                $resultadoTemp = $this->runSelect($sql); // O resultado do select, vai ficar armazenado em array, pois sao varios slecet de publicacoes diferentes, me retorna uma array tridimensional
                foreach($resultadoTemp as $valor){ // esse foreach organiza para uma array bidimensional
                    $resultadoFinal[$contador][] = $valor;
                }
                if(!empty($resultadoTemp)){
                    $contador++;
                }
            }// $resultado = tridimensional   
                
        }        

        return $resultadoFinal;
    }                            
}