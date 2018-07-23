<?php 

namespace Notificacoes\Action;
use Notificacoes\Model\GenericaM;

class SelectComenA extends GenericaM{ 
    // ind_visu_dono_publi = I (Nao notificar, pois o dono curtiu sua própia notificacao)
    // ind_visu_dono_publi = N (Notificar, ainda nao visualizou)
    // ind_visu_dono_publi = V (Nao notificar, pois ja foi visualizado) 

    private $sqlSelectComen = "SELECT usuario.nome_usu, cod_comen, titulo_publi, usuario.cod_usu, publicacao.cod_publi 
                            FROM usuario INNER JOIN comentario ON (usuario.cod_usu = comentario.cod_usu) 
                            INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                            INNER JOIN publicacao ON (publicacao.cod_publi = comentario.cod_publi) 
                            WHERE 1=1 AND  ind_visu_dono_publi = 'N' AND status_comen = 'A' AND %s %s";

    // Selecionar os comentarios realizados que nao foram visualiados pelo dono da publicacao
    // E que nao foram realizados pela prefeitura e pelos funcionarios
    private $whereUserComum = " publicacao.cod_publi = '%s' AND descri_tipo_usu != 'Prefeitura'  AND descri_tipo_usu != 'Funcionario'";

    // Selecionar os comentarios que foram realizados pela prefeitura ou pelos funcionarios e que nao foram visualizados pelo dono da publicacao
    private $wherePrefeiFunc =  " publicacao.cod_publi = '%s' AND (descri_tipo_usu = 'Prefeitura' or descri_tipo_usu = 'Funcionario')";

    //fica
    public function getWhereUserComum(){   // Ta no esquema
        $ids = $this->getCodPubli();        
        $sql = array();
        $contador = 0;
        foreach($ids as $chaves => $valores){
            foreach($valores as $chave => $id){
                $sql[$contador]['where'] = sprintf($this->whereUserComum, $id);
                $sql[$contador]['id_publi'] = $id;
            }
            $contador++;
        }     
        //echo "<br><br><br><br><strong>getWhereUserComum : :: IDS PUBLICACOES DO USUARIO: <br><br><br></strong>";
        //var_dump($sql);
        //$sql = sprintf($this->whereUserComum, $this->getCodPubli());
        return $sql;
    }
    //fica
    public function getWherePrefeiFunc(){
        $ids = $this->getCodPubli();          
        $sql = array();
        $contador = 0;
        foreach($ids as $chaves => $valores){
            foreach($valores as $chave => $id){
                $sql[$contador]['where'] = sprintf($this->wherePrefeiFunc, $id);
                $sql[$contador]['id_publi'] = $id;
            }
            $contador++;
        }  
        //echo "<br><br><br><br><strong>getWherePrefeiFunc : :: IDS PUBLICACOES DO USUARIO: <br><br><br></strong>";
        //var_dump($sql);
        //$sql = sprintf($this->wherePrefeiFunc, $this->getCodPubli());
        return $sql;
    }

    
    //fica
    public function selectComen($wheres='', $order=''){ // Ta no esquema
        $resultadoTemp = array();
        $resultadoFinal = array(); 
        foreach($wheres as $chaves => $valores){
            foreach($valores as $chave => $valor){
                if($chave == 'where'){
                    $sql = sprintf($this->sqlSelectComen,$valor,$order);   
                    
                    if(empty($this->runSelect($sql))){ // SE por um acaso nao retornar nada, nao joga nada na array
                       
                    }else{
                        $resultadoFinal[] = $this->runSelect($sql); //So vai entrar nesse array se tiver alguma coisa
                    }
                    
                } 
            } // Me retorna uma array tridimensional
        }
        //echo "<br><br><br><br><strong>Dados do comentario<br><br><br></strong>";
        //var_dump($resultadoFinal);             
        return $resultadoFinal;
    }

    //fica
    public function retirarComentariosIguais($lista){
        $Novalista = array();
        $listaAux = array();
        $contador = 0;        
        $contador2= 0;
        foreach($lista as $chaves => $valores){
            foreach($valores as $chaves2 => $valores2){
                foreach($valores2 as $chave => $valor){
                    if($chave == 'cod_usu'){   

                       $seraPesqui = 'IdUser=' . $valores2['cod_usu'] . ' da publi=' . $valores2['titulo_publi'];       
                       // Tive q fazer esse texto pra dar pra pesquisar na array     
                        
                        $pesquisa = in_array($seraPesqui, $listaAux);
                        if($pesquisa == false){   // Se por um acaso nao achar na pesquisa cai nesse if                         
                            $listaAux[] = $seraPesqui; // Coloca o valor pesquisado dentro da array                            
                            $Novalista[$contador2][$contador]['nome_usu'] = $valores2['nome_usu'];
                            $Novalista[$contador2][$contador]['titulo_publi'] = $valores2['titulo_publi'];
                            $Novalista[$contador2][$contador]['cod_publi'] = $valores2['cod_publi'];
                            $contador++;
                        }
                        
                    }
                    
                }
                //$contador++;
            }
            $contador = 0;
            $contador2++;
            
        }

        //var_dump($listaAux);
        //echo "<br><br><br>Nova lista <br><br><br>";         
        //var_dump($Novalista);
        return $Novalista;
        
    }

    
}

