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
            $tipoAceitos = array('LikeComen', 'LikePubli', 'ResSalva', 'ResPrefei', 'ComentaPubli',);
            if(in_array($tipo, $tipoAceitos)){ // Verifica se o valor do paramentro é aceito
                switch($tipo){
                    case 'LikeComen':
                            $sqlUpdate = "UPDATE comen_curtida INNER JOIN comentario ON (comen_curtida.cod_comen = comentario.cod_comen) 
                                                SET comen_curtida.ind_visu_dono_publi = 'V'   
                                                WHERE comen_curtida.ind_visu_dono_publi != 'V' 
                                                AND comentario.cod_publi = '%s' AND comentario.cod_usu = '%s'";
                            $sql = sprintf(
                                $sqlUpdate,  
                                $idPubli,                     
                                $codUsu                                
                            );   
                            
                        break;
                    case 'ResPrefei':// Feito
                            $sqlUpdate = "UPDATE comentario INNER JOIN usuario ON (comentario.cod_usu = usuario.cod_usu)
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    INNER JOIN publicacao ON (comentario.cod_publi = publicacao.cod_publi)
                                    SET ind_visu_dono_publi = 'V'                                                                   
                                    WHERE ind_visu_dono_publi != 'V' AND comentario.cod_publi = '%s'
                                    AND publicacao.cod_usu = '%s'
                                    AND (descri_tipo_usu = 'Prefeitura' or descri_tipo_usu = 'Funcionario') ";
                            $sql = sprintf(
                                $sqlUpdate,
                                $idPubli,
                                $codUsu
                            );
                            $executar = $this->runQuery($sql);  
                        break;
                    case 'LikePubli':     
                                   
                            $sqlUpdate = "UPDATE publicacao_curtida INNER JOIN publicacao ON 
                                                (publicacao_curtida.cod_publi = publicacao.cod_publi)
                                           SET publicacao_curtida.ind_visu_dono_publi = 'V'
                                           WHERE publicacao_curtida.cod_publi = '%s' AND publicacao.cod_usu = '%s' AND
                                           publicacao_curtida.ind_visu_dono_publi != 'V' ";
                            $sql = sprintf(
                                $sqlUpdate,
                                $idPubli,
                                $codUsu
                            );
                            
                        break;
                    case 'ResSalva': // Feito
                        $sqlUpdate = "UPDATE publicacao_salva 
                                SET ind_visu_respos_prefei = 'V'                                                                   
                                WHERE ind_visu_respos_prefei != 'V'
                                AND cod_usu = '%s' AND cod_publi = '%s'"; 
                        $sql = sprintf(
                            $sqlUpdate,                            
                            $codUsu,
                            $idPubli
                        );                         
                        
                        break;
                    case 'ComentaPubli': // Feito
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
                $executar = $this->runQuery($sql);
            }
                      
        }
}