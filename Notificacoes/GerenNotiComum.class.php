<?php
namespace Notificacoes;

use Notificacoes\Model\GenericaM;
use Notificacoes\Core\SelectRegis;
use Notificacoes\Core\SelectComenCurtido;
use Notificacoes\Core\SelectPubliCurti;
use Notificacoes\Core\SelectPubliSalva;
use Notificacoes\Core\SelectComen;
class GerenNotiComum extends GenericaM{

    private $resultados = array();

    public function __construct($idUser){ // ASsim q for instanciado ele vai pegar todos os ids de publicacoes
        $publicacoes = new SelectRegis(); // Que o usuario envio, e dos comentarios tambem
        $publicacoes->setCodUsu($idUser);        
        $this->setCodPubli($publicacoes->selectPubli());
        $this->setCodComen($publicacoes->selectComen()); 
        $this->setCodSalvos($publicacoes->selectSalvos());        
    }

    //Feito
    public function curtidasComen(){ 
        $registros = new SelectComenCurtido();
        $registros->setCodComen($this->getCodComen());
        $listaRegistros = $registros->select(); // Não preciso me preocupar com registros duplicados        
        //var_dump($listaRegistros); 
        if(count($listaRegistros) > 0){
            $resultado = $this->Mensagem($listaRegistros, "curtiu", "curtiram" ,"seu comentario na publicacao", "curtida");   
            $this->resultados = array_merge_recursive($this->resultados, $resultado);        
            return $resultado;
        }       
        
    }
    // Feito
    public function curtidasPubli(){
        $publicacoes = new SelectPubliCurti();
        $publicacoes->setCodPubli($this->getCodPubli());
        $lista_de_curtidores = $publicacoes->select();     
        if(count($lista_de_curtidores) > 0){
            $resultado = $this->Mensagem($lista_de_curtidores, "curtiu", "curtiram" ,"a publicação", "curtida"); 
            $this->resultados = array_merge_recursive($this->resultados, $resultado);
            return $resultado;
        }           
    }
    //Feito
    public function respostaPubliSalva(){
        $resposta = new SelectPubliSalva();
        $resposta->setCodSalvos($this->getCodSalvos());
        
        $listaResposta = $resposta->selectComen($resposta->getWherePubli());
        $quantidade = count($listaResposta); // quantidade de publicacaoes que foram respondidas
        $resultado = array();
        if($quantidade > 0){
            $contador = 0;
            while($contador < count($listaResposta)){                
                $resultado[$contador]['notificacao'] = "A publicação salva <strong> " . $listaResposta[$contador][0]['titulo_publi'] . "</strong> foi respondida pela prefeitura";
                $resultado[$contador]['id_publi'] = $listaResposta[$contador][0]['cod_publi']; 
                $resultado[$contador]['tipo'] = 'resposta';
                $resultado[$contador]['classe'] = $this->nomeClasse($listaResposta[$contador][0]['indicador']);
                $contador++;
            }
        }
        $this->resultados = array_merge_recursive($this->resultados, $resultado);
        return $resultado;        
    }
    // Feito
    public function respostaPrefei(){
        $resposta = new SelectComen();
        $resposta->setCodPubli($this->getCodPubli());
        $listaResposta = $resposta->selectComen($resposta->getWherePrefeiFunc()); // Faz o select  
        $quantidade = count($listaResposta); // quantidade de publicacaoes que foram respondidas
        $resultado = array();
        if($quantidade > 0){
            $contador = 0;            
            while($contador < count($listaResposta)){
                $resultado[$contador]['notificacao'] = " A prefeitura respondeu a publição <strong> " . $listaResposta[$contador][0]['titulo_publi'] . "</strong>";
                $resultado[$contador]['id_publi'] = $listaResposta[$contador][0]['cod_publi']; 
                $resultado[$contador]['tipo'] = 'resposta'; 
                $resultado[$contador]['classe'] = $this->nomeClasse($listaResposta[$contador][0]['ind_visu_dono_publi']);               
                $contador++;
            }
        }
        $this->resultados = array_merge_recursive($this->resultados, $resultado);
        return $resultado;     
    
    }
    // Feito
    public function comentarioComum(){
        $publicacaoComentario = new SelectComen();
        $publicacaoComentario->setCodPubli($this->getCodPubli());
        $listaComentarios = $publicacaoComentario->selectComen($publicacaoComentario->getWhereUserComum());

        if(count($listaComentarios) > 0){
            $novaLista = $publicacaoComentario->retirarComentariosIguais($listaComentarios);
            $resultado = $this->Mensagem($novaLista, "comentou", "comentaram" ,"na sua publicacao", "comentario"); 
            $this->resultados = array_merge_recursive($this->resultados, $resultado);
            return $resultado;
        }
    }
    //Feito
    public function Mensagem($listaCurtidores = array(), $singular, $plural, $complemento, $tipoPubli){        
        if(count($listaCurtidores) > 0){
            $contador = 0;
            $singular = trim($singular);
            $plural = trim($plural);
            $complemento = trim($complemento);
            while($contador < count($listaCurtidores)){// = Quantidade de comentarios Curtidas
                $quantidadeCurtidoresComen = count($listaCurtidores[$contador]);
                $texto = "";
                if($quantidadeCurtidoresComen == 1){
                    $resultado[$contador]['notificacao'] = $listaCurtidores[$contador][0]['nome_usu'] . " $singular $complemento  <strong>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</strong>";
                    $resultado[$contador]['id_publi'] = $listaCurtidores[$contador][0]['cod_publi'];
                    $resultado[$contador]['tipo'] = $tipoPubli;
                    $resultado[$contador]['classe'] = $this->nomeClasse($listaCurtidores[$contador][0]['ind_visu_dono_publi']);
                }else if($quantidadeCurtidoresComen == 2){                        
                    $contador2 = 0;
                    $texto = "";
                    while($contador2 < $quantidadeCurtidoresComen){ // Só vai executar duas vezes
                        if($contador2 > 0){
                            $texto .= " e ";
                        }
                        $texto .= $listaCurtidores[$contador][$contador2]['nome_usu'];
                        $contador2++;
                    }
                    $resultado[$contador]['notificacao'] = $texto . " $plural $complemento  <strong>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</strong>";
                    $resultado[$contador]['id_publi'] = $listaCurtidores[$contador][0]['cod_publi'];
                    $resultado[$contador]['tipo'] = $tipoPubli;
                    $resultado[$contador]['classe'] = $this->nomeClasse($listaCurtidores[$contador][0]['ind_visu_dono_publi']);
                    
                }else{
                    $contador2 = 0;
                    $texto = "";
                    while($contador2 < 2){ // só quero q execute duas vezes
                        if($contador2 > 0){
                            $texto .= ", ";
                        }
                        $texto .= $listaCurtidores[$contador][$contador2]['nome_usu'];
                        $contador2++;
                    }
                    $diferenca = $quantidadeCurtidoresComen - 2;
                    if($diferenca == 1){
                        $resultado[$contador]['notificacao'] = $texto . " e outra ". $diferenca ." pessoa $plural $complemento   <strong>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</strong>";                        
                    }else{
                        $resultado[$contador]['notificacao'] = $texto . " e outras ". $diferenca ." pessoas $plural $complemento  <strong>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</strong>";
                    }                    
                    $resultado[$contador]['id_publi'] = $listaCurtidores[$contador][0]['cod_publi'];
                    $resultado[$contador]['tipo'] = $tipoPubli;
                    $resultado[$contador]['classe'] = $this->nomeClasse($listaCurtidores[$contador][0]['ind_visu_dono_publi']);

                }
                $contador++;
            }
            return $resultado;
        }        
    }

    public function notificacoes(){
            
        $curtidasComen = $this->curtidasComen();
        $curtidasPubli = $this->curtidasPubli();
        $respostaPubliSalva = $this->respostaPubliSalva();
        $respostaPrefei = $this->respostaPrefei();
        $comentarioComum = $this->comentarioComum();
        return $this->resultados ;
    }

    public function nomeClasse($ind){
        if($ind == 'B'){
            return 'Visualizado';
        }else if($ind == 'N'){
            return 'NVisualizado';
        }
    }
}