<?php 

namespace Notificacoes\Action;
use Notificacoes\Model\GenericaM;

class VisualizarNotificacaoA extends GenericaM{ 

    private $cod_usu;

    private $sqlUpdatePublicacao = "UPDATE publicacao_curtida SET ind_visu_dono_publi = '%s' WHERE cod_publi %s";
    private $sqlUpdateComenCurti = "UPDATE comen_curtida SET ind_visu_dono_publi = '%s' WHERE cod_comen %s";
    private $sqlUpdateComen = "UPDATE comentario SET ind_visu_dono_publi = '%s' WHERE cod_comen %s";
    private $sqlUpdatePubliSalvas = "UPDATE publicacao_salva SET ind_visu_respos_prefei = '%s' WHERE cod_usu = '%s' AND cod_publi %s";
    private $sqlUpdateComenPrefei = "UPDATE comentario SET ind_visu_dono_publi = '%s' WHERE cod_comen %s";


    public function __construct($ids,$tipoInd,$codUsu){  
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

    public function gerarIn($tipos = array()){// gerar o in, exemplo in('adm','moderador')
        $in = "in( ";
        $contador = 1;        
        foreach ($tipos as $valores){
            foreach($valores as $chave => $valor){
                if($chave != 'ind_visu_respos_prefei'){
                    if($contador == count($tipos)){
                        $in.= "'$valor'" . ' )';
                    }else{
                        $in.= "'$valor'".', ';
                    }
                }                
            }            
            $contador++;            
        }
        return $in;
    }
}