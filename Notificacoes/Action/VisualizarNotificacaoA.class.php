<?php 

namespace Notificacoes\Action;
use Notificacoes\Model\GenericaM;

class VisualizarNotificacaoA extends GenericaM{ 

    private $cod_usu;

    private $sqlUpdatePublicacao = "UPDATE publicacao_curtida SET ind_visu_dono_publi = '%s' WHERE ind_visu_dono_publi != 'I' AND cod_publi %s";
    private $sqlUpdateComenCurti = "UPDATE comen_curtida SET ind_visu_dono_publi = '%s' WHERE ind_visu_dono_publi != 'I' AND cod_comen %s";
    private $sqlUpdateComen = "UPDATE comentario SET ind_visu_dono_publi = '%s' WHERE ind_visu_dono_publi != 'I' AND cod_comen %s";
    private $sqlUpdatePubliSalvas = "UPDATE publicacao_salva SET ind_visu_respos_prefei = '%s' WHERE ind_visu_respos_prefei != 'I' AND cod_usu = '%s' AND cod_publi %s";
    private $sqlUpdateComenPrefei = "UPDATE comentario SET ind_visu_dono_publi = '%s' WHERE ind_visu_dono_publi != 'I' AND cod_comen %s";


    public function gerarIn($tipos = array()){// gerar o in, exemplo in('adm','moderador')
        $in = "in(";
        $contador = 1;        
        foreach ($tipos as $valores){
            foreach($valores as $chave => $valor){
                if($chave != 'ind_visu_respos_prefei'){
                    if($contador == count($tipos)){
                        $in.= "'$valor'" . ')';
                    }else{
                        $in.= "'$valor'".', ';
                    }
                }                
            }            
            $contador++;            
        }
        return $in;
    }

    public function updateClickNoti($ids,$tipoInd,$codUsu){ // Quando o usuario clicar no icone notificacao mas nao abriu
        //$tipoInd = 'N';
        $res = array();
        $this->codUsu = $codUsu;
        foreach($ids as $chavePrincipal =>$valores){
            foreach($valores as $chave => $valor){
                $inId = $this->gerarIn($valor);
                if($chavePrincipal == 'PubliSalvas'){
                    $prapararSql = sprintf($this->{'sqlUpdate'.$chavePrincipal},$tipoInd,$codUsu,$inId);
                }else{
                    $prapararSql = sprintf($this->{'sqlUpdate'.$chavePrincipal},$tipoInd,$inId);
                }  
                
                $update = $this->runQuery($prapararSql);                
            }            
        }
    }

    public function visualizarNotificacao($tipo, $idPubli, $codUsu){ // Quando o usuario clicou no icone notificacao
            $tipoAceitos = array('icone-like-full', 'icone-mail', 'icone-comentario');
            if(in_array($tipo, $tipoAceitos)){ // Verifica se o valor do paramentro é aceito
                switch($tipo){
                    case 'icone-like-full':
                            $sql = "UPDATE comen_curtida INNER JOIN comentario ON (comen_curtida.cod_comen = comentario.cod_comen) 
                                        SET comen_curtida.ind_visu_dono_publi = 'V'                                                                   
                                        WHERE comen_curtida.ind_visu_dono_publi != 'V' AND comentario.cod_publi = '%s'";
                        break;
                    case 'icone-mail':

                        break;
                    case 'icone-comentario': // Feito
                            $sqlUpdate = "UPDATE comentario INNER JOIN usuario ON (comentario.cod_usu = usuario.cod_usu)
                                        INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                        INNER JOIN publicacao ON (comentario.cod_publi = publicacao.cod_publi)
                                        SET ind_visu_dono_publi = 'V'                                                                   
                                        WHERE ind_visu_dono_publi != 'V' AND comentario.cod_publi = '%s'
                                        AND publicacao.cod_usu = '%s'
                                        AND descri_tipo_usu != 'Prefeitura'  AND descri_tipo_usu != 'Funcionario' ";
                            $sql = sprintf(
                                $sqlUpdate,
                                $idPubli,
                                $codUsu
                            );
                            $executar = $this->runQuery($sql);   
                        break;
                }
            }
            /*
            if($executar->rowCount() <= 0){
                echo 'erro';
            }else{
                echo 'certo';
            }  
            */
            //$sqlUpdateComenCurti = "UPDATE comen_curtida SET ind_visu_dono_publi = '%s' WHERE ind_visu_dono_publi != 'I' AND cod_publi %s";
            //$sqlUpdateComen = "UPDATE comentario SET ind_visu_dono_publi = '%s' WHERE ind_visu_dono_publi != 'I' AND cod_publi %s";
            
    
    
    
        }
}