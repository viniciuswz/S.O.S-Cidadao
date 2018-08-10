<?php 

namespace Notificacoes\Action;
use Notificacoes\Model\GenericaM;

class SelectComenCurtidoA extends GenericaM{  

    private $sqlSelect = "SELECT titulo_publi, nome_usu, comen_curtida.cod_comen, publicacao.cod_publi, dataHora_comen_curti, comen_curtida.ind_visu_dono_publi
                            FROM comen_curtida INNER JOIN comentario ON (comen_curtida.cod_comen = comentario.cod_comen)
                            INNER JOIN publicacao ON (comentario.cod_publi = publicacao.cod_publi)
                            INNER JOIN usuario on (comen_curtida.cod_usu = usuario.cod_usu)
                            WHERE status_curte = 'A' AND (comen_curtida.ind_visu_dono_publi = 'N' or comen_curtida.ind_visu_dono_publi = 'B')
                            AND status_comen = 'A' AND status_publi = 'A' AND comen_curtida.cod_comen = '%s'
                            ORDER BY dataHora_comen_curti DESC, ind_visu_dono_publi DESC ";    

    // ind_visu_dono_publi = N (Não visualizado)
    // ind_visu_dono_publi = V (Visualizado)
    // ind_visu_dono_publi = I (Não notificar pois o dono da publicacao curtiu sua propia publicacao)                    
    // Pegar a quantidade de vezes que a publicacao foi curtida e nao foi visualizada

    public function select():array{ // Ja ta no esquema
        $ids = $this->getCodComen();   
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