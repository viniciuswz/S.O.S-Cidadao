<?php
namespace Notificacoes;

use Notificacoes\Model\GenericaM;
use Classes\Denuncias;

class GerenNotiAdm extends GenericaM{
    
        
    private $countDenunDebate = " %s SELECT %s debate_denun.cod_deba AS ID, 
                                        dataHora_denun_deba as DataHora,
                                        nome_deba as Nome,
                                        ind_visu_adm_denun_deba AS ind
                                        FROM debate_denun                                    
                                        INNER JOIN debate ON (debate_denun.cod_deba = debate.cod_deba)
                                        INNER JOIN usuario ON (debate.cod_usu = usuario.cod_usu)
                                        WHERE status_denun_deba = 'A' AND status_deba = 'A' AND
                                        ind_visu_adm_denun_deba != 'V' %s";
    private $countDenunPubli = " %s SELECT %s publi_denun.cod_publi AS ID, 
                                            dataHora_denun_publi AS DataHora,
                                            titulo_publi AS Nome,
                                            ind_visu_adm_denun_publi AS ind
                                            FROM publi_denun                                             
                                            INNER JOIN publicacao ON (publi_denun.cod_publi = publicacao.cod_publi)
                                            INNER JOIN usuario ON (publicacao.cod_usu = usuario.cod_usu)
                                            WHERE status_denun_publi = 'A' AND status_publi = 'A'  AND
                                            ind_visu_adm_denun_publi != 'V' %s";
    private $countDenunComen = " %s SELECT %s comen_denun.cod_comen AS ID, 
                                              comentario.cod_publi AS IDPubli,
                                              dataHora_denun_comen AS DataHora, 
                                              nome_usu AS Nome,
                                              titulo_publi AS Titulo,
                                              ind_visu_adm AS ind
                                            FROM comen_denun
                                            INNER JOIN comentario ON (comen_denun.cod_comen = comentario.cod_comen)
                                            INNER JOIN publicacao ON (comentario.cod_publi = publicacao.cod_publi)
                                            INNER JOIN usuario ON (comentario.cod_usu = usuario.cod_usu)
                                            WHERE status_denun_comen = 'A' AND status_comen = 'A' AND
                                            ind_visu_adm != 'V' %s";
    
    private $resultados = array();  
    private $indVisu;

    public function __contruct($indVisu = null){
        $this->indVisu = $indVisu;
    }
    
    public function SelectDenunPubli(){ // Feito
        $ids = $this->selectIdsCoisasDenunciadas('countDenun', array('Publi'), "ID", "dataHora_denun_publi");
        $dados = $this->selectQuantDenun('countDenun', array('Publi'),' AND publicacao.cod_publi = ', $ids);     
        $resultado = $this->gerarMensagem($dados, 'a publicação ','Publicacacao', 'DenunPubli');
        $this->resultados = array_merge_recursive($this->resultados, $resultado);        
        return $resultado;

    }

    public function SelectDenunDebate(){
        $ids = $this->selectIdsCoisasDenunciadas('countDenun', array('Debate'), 'ID', 'dataHora_denun_deba');        
        $dados = $this->selectQuantDenun('countDenun', array('Debate'),' AND debate.cod_deba = ', $ids);     
        $resultado = $this->gerarMensagem($dados, 'o debate ','Debate', 'DenunDeba');        
        $this->resultados = array_merge_recursive($this->resultados, $resultado);        
        return $resultado;
    }

    public function SelectDenunComen(){
        $ids = $this->selectIdsCoisasDenunciadas('countDenun', array('Comen'), 'ID', 'dataHora_denun_comen');        
        $dados = $this->selectQuantDenun('countDenun', array('Comen'),' AND comentario.cod_comen = ', $ids);     
        $resultado = $this->gerarMensagem($dados, 'o comentario de ','Comentário', 'DenunComen');        
        $this->resultados = array_merge_recursive($this->resultados, $resultado);        
        return $resultado;
    }

    public function selectIdsCoisasDenunciadas($comecoQuery, $tabelas = array(), $grop, $order, $nomeSelect = ""){
        $sql = $this->gerarSql($comecoQuery,$tabelas , "", "", " GROUP BY $grop ORDER BY $order DESC ");
        $res = $this->runSelect($sql);          
        return $res;
    }
    
    public function selectQuantDenun($comecoQuery, $tabelas = array(), $fimSelect = "", $dados = array()){ // quantidade de vezes que foi dununciado    
        $quantidade = array();  
        $contador = 0;
        foreach($dados as $chaves => $valores){
            foreach($valores as $chave => $valor){
                if($chave == 'ID'){ // so quero que execute esse  if quando a variavel $valor se referir ao indice ID
                    $fimSelect2 = $fimSelect ."'$valor'";
                    $sql = $this->gerarSql($comecoQuery,$tabelas, " SELECT COUNT(*)  FROM ( ", " ",  $fimSelect2);
                    $sql .= ") as Total";
                    $res = $this->runSelect($sql); 
                    $sql = "";
                    $fimSelect2 = "";   
                    $contador++;                 
                }                
                if($chave == 'DataHora'){
                    $quantidade[$contador]['DataHora'] = $valor;                    
                }else if($chave == 'Nome'){
                    $quantidade[$contador]['Nome'] = $valor;     
                }else if($chave == 'Titulo'){ // Apenas no select do comentario vai ter titulo, quando tiver ele vai concaternar
                    $quantidade[$contador]['Nome'] = $quantidade[$contador]['Nome'] . " na publicação " . $valor;     
                }else if($chave == 'ind'){
                    $quantidade[$contador]['ind'] = $valor;
                }else if($chave == 'IDPubli'){
                    $quantidade[$contador]['IDPubli'] = $valor;
                }else{
                    $quantidade[$contador]['id'] = $valor;
                    $quantidade[$contador]['qtd'] = $res[0]["COUNT(*)"];
                    
                }
                
            }      
                   
        }   
        //var_dump($quantidade);
        return $quantidade;
    }

    public function gerarSql($comecoQuery,$tabelas = array(), $priCoringa = " ", $nomeSelect = "", $fimSelect = ""){
        $sqlNPrepa = ""; //exemplo $nomeSelect = 'Comentário' AS Tipo
        $contador = 0;
        foreach ($tabelas as $valor){
            if($contador == 0){ // Colocar alguma coisa no primeiro %s                
                $sqlNPrepa .=  sprintf($this->{$comecoQuery.$valor},$priCoringa,$nomeSelect, $fimSelect); // $this->{$comecoQuery.$valor} gerar o nome do atributo dinamico
            }else{                
                $sqlNPrepa .= sprintf($this->{$comecoQuery.$valor}," UNION ", $nomeSelect, $fimSelect);
            }              
            $contador++;
        }     
        return $sqlNPrepa;
    }

    public function gerarMensagem($dados, $complemento, $tipoNoti, $indTipo){
        if(count($dados) > 0){
            $contador = 1; // por algum motivo teve q comecar com um
            $contador2 = 0;
            while($contador <= count($dados)){
                $quantidadeCurtidores = $dados[$contador]['qtd'];
                if($quantidadeCurtidores == 1){
                    $resultado[$contador]['notificacao'] = " 1 denúncia relacionada com " . $complemento .  "<span class='negrito'>". $dados[$contador]['Nome'] . "</span>";
                    
                }else if($quantidadeCurtidores >= 2){
                    $resultado[$contador]['notificacao'] = $quantidadeCurtidores ." denúncias relacionada com " . $complemento . " <span class='negrito'>" . $dados[$contador]['Nome']. "</span>";
                }
                    if(isset($dados[$contador]['IDPubli'])){ // Preciso inverter os valores quando for uma denuncia de comentario
                        $idComen = $dados[$contador]['id'];
                        $dados[$contador]['id'] = $dados[$contador]['IDPubli'] . "&IdComen=" . $idComen;                        
                    }
                    $resultado[$contador]['id_publi'] = $dados[$contador]['id'];
                    $resultado[$contador]['tipo'] = $tipoNoti;
                    $resultado[$contador]['indTipo'] = $indTipo; //dasdasdasdasdasdasd
                    $resultado[$contador]['classe'] = $this->nomeClasse($dados[$contador]['ind']);
                    //$resultado[$contador]['Hora'] = strtotime($listaCurtidores[$contador][0]['dataHora']);
                    $resultado[$contador]['DataHora'] = $dados[$contador]['DataHora'];
                $contador++;
            }
        }        
        return $resultado;        
    }

    public function notificacoes(){
            
        $publi = $this->SelectDenunPubli();        
        $debate = $this->SelectDenunDebate();
        $comentario = $this->SelectDenunComen();  

        //$this->visualizarNotificacao($this->indVisu);
        $this->resultados = $this->ordenarArray();
        return $this->resultados;
    }
    
    public function ordenarArray(){ //Parei aqui, ordenar uma array
        
        $HoraOrganizada = array();
        $newArray = array();
        $dados = $this->resultados;  
        $contador = 0;
        while($contador < count($dados)){
            $segundos = strtotime($dados[$contador]['DataHora']); // Esta em segundos
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
                
                //$visualizar = new VisualizarNotificacao();
                //$visualizar->updateClickNoti($ids,$indVisu,$idUser);
            }     
        }
        return;        
    }
   
}