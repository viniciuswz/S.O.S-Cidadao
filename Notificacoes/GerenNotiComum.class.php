<?php
namespace Notificacoes;

use Notificacoes\Model\GenericaM;
use Notificacoes\Core\SelectRegis;
use Notificacoes\Core\SelectComenCurtido;
use Notificacoes\Core\SelectPubliCurti;
use Notificacoes\Core\SelectPubliSalva;
use Notificacoes\Core\SelectComen;
use Notificacoes\Core\VisualizarNotificacao;
class GerenNotiComum extends GenericaM{

    private $resultados = array();
    private $indVisu;
    private $idUser;
   
    public function __construct($idUser,$indVisu = null){ // ASsim q for instanciado ele vai pegar todos os ids de publicacoes
        $publicacoes = new SelectRegis(); // Que o usuario envio, e dos comentarios tambem
        $publicacoes->setCodUsu($idUser); 
        $this->indVisu = $indVisu;
        $this->idUser = $idUser;
        $this->setCodPubli($publicacoes->selectPubli());
        $this->setCodComen($publicacoes->selectComen()); 
        $this->setCodSalvos($publicacoes->selectSalvos());       
        
        //$this->visualizarNotificacao($indVisu,$idUser);
    }

    //Feito
    public function curtidasComen(){ 
        $registros = new SelectComenCurtido();
        $registros->setCodComen($this->getCodComen());
        $listaRegistros = $registros->select(); // Não preciso me preocupar com registros duplicados        
        //var_dump($listaRegistros); 
        if(count($listaRegistros) > 0){
            $resultado = $this->Mensagem($listaRegistros, "curtiu", "curtiram" ,"seu comentario na publicacao", "icone-like-full", "LikeComen");   
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
            $resultado = $this->Mensagem($lista_de_curtidores, "curtiu", "curtiram" ,"a publicação", "icone-like-full", "LikePubli"); 
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
                $resultado[$contador]['notificacao'] = "A publicação salva <span class='negrito'> " . $listaResposta[$contador][0]['titulo_publi'] . "</span> foi respondida pela prefeitura";
                $resultado[$contador]['id_publi'] = $listaResposta[$contador][0]['cod_publi']; 
                $resultado[$contador]['tipo'] = 'icone-mail';
                $resultado[$contador]['indTipo'] = 'ResSalva'; //dasdasdasdasdasdasd
                $resultado[$contador]['classe'] = $this->nomeClasse($listaResposta[$contador][0]['indicador']);
                $resultado[$contador]['Hora'] = strtotime($listaResposta[$contador][0]['dataHora']);
                $resultado[$contador]['DataHora'] = $listaResposta[$contador][0]['dataHora'];
                $resultado[$contador]['link'] = 'reclamacao';
                
                $contador++;
            }
        }
        $this->resultados = array_merge_recursive($this->resultados, $resultado);
        //var_dump($resultado);
        return $resultado;        
    }
    // Feito
    public function respostaPrefei($getIdsComen = null){
        $resposta = new SelectComen();
        $resposta->setCodPubli($this->getCodPubli());
        $listaResposta = $resposta->selectComen($resposta->getWherePrefeiFunc()); // Faz o select 
        //var_dump($listaResposta); 
        $quantidade = count($listaResposta); // quantidade de publicacaoes que foram respondidas
        $resultado = array();
        $idsComen = array();
        if($quantidade > 0){
            $contador = 0; 
            while($contador < count($listaResposta)){
                if($getIdsComen != null){
                    $idsComen[$contador]['cod_comen'] = $listaResposta[$contador][0]['cod_comen'];       
                }else{
                    $resultado[$contador]['notificacao'] = " A prefeitura respondeu a publição <span class='negrito'> " . $listaResposta[$contador][0]['titulo_publi'] . "</span>";
                    $resultado[$contador]['id_publi'] = $listaResposta[$contador][0]['cod_publi']; 
                    $resultado[$contador]['tipo'] = 'icone-mail';
                    $resultado[$contador]['indTipo'] = 'ResPrefei'; //dasdasdasdasdasdasd
                    $resultado[$contador]['Hora'] = strtotime($listaResposta[$contador][0]['dataHora']);  
                    $resultado[$contador]['DataHora'] = $listaResposta[$contador][0]['dataHora'];               
                    $resultado[$contador]['classe'] = $this->nomeClasse($listaResposta[$contador][0]['ind_visu_dono_publi']);     
                    $resultado[$contador]['link'] = 'reclamacao';                    
                }    
                $contador++;
            }
        }
        $this->resultados = array_merge_recursive($this->resultados, $resultado);
        
        if($getIdsComen != null){
            return $idsComen; 
        }else{
            return $resultado; 
        }
            
    
    }
    // Feito
    public function comentarioComum($getIdsComen = null){
        $publicacaoComentario = new SelectComen();
        $publicacaoComentario->setCodPubli($this->getCodPubli());
        $listaComentarios = $publicacaoComentario->selectComen($publicacaoComentario->getWhereUserComum());    
        //var_dump($listaComentarios);   
        if($getIdsComen != null){
            $idsComen = array();
            $contador = 0;
            $contador2 = 0;
            $contador3 = 0;
            while($contador < count($listaComentarios)){
                while($contador2 < count($listaComentarios[$contador])){
                    $idsComen[$contador3]['cod_comen'] = $listaComentarios[$contador][$contador2]['cod_comen'];                                        
                    $contador2++;
                    $contador3++;  
                }          
                $contador2 =0;    
                $contador++;
            }
            
            return $idsComen;
        }
        if(count($listaComentarios) > 0){
            $novaLista = $publicacaoComentario->retirarComentariosIguais($listaComentarios);  
            //var_dump($novaLista);          
            $resultado = $this->Mensagem($novaLista, "comentou", "comentaram" ,"na sua publicacao", "icone-comentario","ComentaPubli"); 
            $this->resultados = array_merge_recursive($this->resultados, $resultado);
            return $resultado;
        }
        
    }
    //Feito
    public function Mensagem($listaCurtidores = array(), $singular, $plural, $complemento, $tipoPubli, $indtipo){ 
        if(count($listaCurtidores) > 0){
            $contador = 0;
            $singular = trim($singular);
            $plural = trim($plural);
            $complemento = trim($complemento);
            while($contador < count($listaCurtidores)){// = Quantidade de comentarios Curtidas                
                $quantidadeCurtidoresComen = count($listaCurtidores[$contador]);
                $texto = "";
                if($quantidadeCurtidoresComen == 1){
                    $resultado[$contador]['notificacao'] = $listaCurtidores[$contador][0]['nome_usu'] . " $singular $complemento  <span class='negrito'>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</span>";
                    $resultado[$contador]['id_publi'] = $listaCurtidores[$contador][0]['cod_publi'];
                    $resultado[$contador]['tipo'] = $tipoPubli;
                    $resultado[$contador]['indTipo'] = $indtipo; //dasdasdasdasdasdasd
                    $resultado[$contador]['classe'] = $this->nomeClasse($listaCurtidores[$contador][0]['ind_visu_dono_publi']);
                    $resultado[$contador]['Hora'] = strtotime($listaCurtidores[$contador][0]['dataHora']);
                    $resultado[$contador]['DataHora'] = $listaCurtidores[$contador][0]['dataHora'];
                    $resultado[$contador]['link'] = 'reclamacao';
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
                    $resultado[$contador]['notificacao'] = $texto . " $plural $complemento  <span class='negrito'>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</span>";
                    $resultado[$contador]['id_publi'] = $listaCurtidores[$contador][0]['cod_publi'];
                    $resultado[$contador]['tipo'] = $tipoPubli;
                    $resultado[$contador]['indTipo'] = $indtipo; //dasdasdasdasdasdasd
                    $resultado[$contador]['classe'] = $this->nomeClasse($listaCurtidores[$contador][0]['ind_visu_dono_publi']);
                    $resultado[$contador]['notificacao'];
                    $resultado[$contador]['Hora'] = strtotime($listaCurtidores[$contador][0]['dataHora']);
                    $resultado[$contador]['DataHora'] = $listaCurtidores[$contador][0]['dataHora'];
                    $resultado[$contador]['link'] = 'reclamacao';
                    
                    
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
                        $resultado[$contador]['notificacao'] = $texto . " e outra ". $diferenca ." pessoa $plural $complemento   <span class='negrito'>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</span>";                        
                    }else{
                        $resultado[$contador]['notificacao'] = $texto . " e outras ". $diferenca ." pessoas $plural $complemento  <span class='negrito'>" .  $listaCurtidores[$contador][0]['titulo_publi'] . "</span>";
                    }                    
                    $resultado[$contador]['id_publi'] = $listaCurtidores[$contador][0]['cod_publi'];
                    $resultado[$contador]['tipo'] = $tipoPubli;
                    $resultado[$contador]['indTipo'] = $indtipo; //dasdasdasdasdasdasd
                    $resultado[$contador]['classe'] = $this->nomeClasse($listaCurtidores[$contador][0]['ind_visu_dono_publi']);
                    $resultado[$contador]['Hora'] = strtotime($listaCurtidores[$contador][0]['dataHora']);
                    $resultado[$contador]['DataHora'] = $listaCurtidores[$contador][0]['dataHora'];
                    $resultado[$contador]['link'] = 'reclamacao';

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
        
        
        $this->visualizarNotificacao($this->indVisu,$this->idUser);
        $this->resultados = $this->ordenarArray();
        return $this->resultados;
    }

    public function ordenarArray(){ //Parei aqui, ordenar uma array
        
        $HoraOrganizada = array();
        $newArray = array();
        $dados = $this->resultados;        
        $contador = 0;
        while($contador < count($dados)){
            $segundos = $dados[$contador]['Hora']; // Esta em segundos
            $HoraOrganizada[$contador] = $segundos . '.'.$contador;      //Colocar a data e Hora em um vetor concatenado com a posicao da notificacao
            $contador++;
        }
        sort($HoraOrganizada,SORT_NUMERIC );//Ordenar o vetor, so ordena do menor pro maior
        foreach($HoraOrganizada as $valor){
            $posicaoPonto = strpos($valor, '.'); // Achar a posicao do ponto
            $indice = substr($valor, $posicaoPonto + 1); //Nao comecar a pegar a partir do ponto
            $newArray[] = $dados[$indice];
        }
        $OrderMaiorMenor = array_reverse($newArray); //Inverter a array;
        
        //var_dump($OrderMaiorMenor);
        return $OrderMaiorMenor;
    }

    public function nomeClasse($ind){
        if($ind == 'B'){
            return 'Visualizado';
        }else if($ind == 'N'){
            return 'NVisualizado';
        }
    }

    public function visualizarNotificacao($indVisu, $idUser){
        if($indVisu != null){
            if($indVisu == 'B'){            
                $ids = array();
                $ids['Publicacao'][] = $this->getCodPubli();
                $ids['Comen'][] = $this->comentarioComum('QueroOsIds');
                $ids['ComenCurti'][] = $this->getCodComen();
                $ids['ComenPrefei'][] = $this->respostaPrefei('QueroOsIds');                 
                $ids['PubliSalvas'][] = $this->getCodSalvos();
                
                $visualizar = new VisualizarNotificacao();
                $visualizar->updateClickNoti($ids,$indVisu,$idUser);
            }     
        }
        return;        
    }
}