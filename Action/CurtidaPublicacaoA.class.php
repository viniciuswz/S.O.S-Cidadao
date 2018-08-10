<?php
namespace Action;
use Model\CurtidaPublicacaoM;

class CurtidaPublicacaoA extends CurtidaPublicacaoM{
    private $sqlSelect = "SELECT status_publi_curti FROM publicacao_curtida WHERE cod_usu = '%s' AND cod_publi = '%s'";

    private $sqlUpdate = "UPDATE publicacao_curtida SET status_publi_curti = '%s',
                                                        ind_visu_dono_publi = '%s',
                                                        dataHora_publi_curti = now()
                                                        WHERE cod_usu = '%s' AND cod_publi='%s'";
    
    private $sqlInsert = "INSERT into publicacao_curtida(cod_usu, cod_publi, ind_visu_dono_publi,dataHora_publi_curti) VALUES('%s', '%s', '%s',NOW())";
    private $selectCodUsu ="SELECT cod_usu FROM publicacao WHERE cod_publi = '%s' AND cod_usu = '%s'";
    public function select(){
      $sql = sprintf($this->sqlSelect,
                     $this->getCodUsu(),
                     $this->getCodPubli());
        $resultado = $this->runSelect($sql);
        $verificacaoDono = $this->selectDonoPubli();
        if(empty($resultado)){
            $this->insert();
        }else if($resultado[0]['status_publi_curti'] == "A"){ 
            $this->update("I", $verificacaoDono);//se for A(like) atualiza pra I(deslike)
        }else{
            $this->update("A", $verificacaoDono);//se for I(deslike) atualiza pra A(like)
        }
    }

    public function update($statusCurtida, $indVisuDonoPubli){ //se já tiver inserido, atualiza pra A/I no banco
        $sql = sprintf($this->sqlUpdate,
                       $statusCurtida,
                       $indVisuDonoPubli,
                       $this->getCodUsu(),
                       $this->getCodPubli());
        $resultado = $this->runQuery($sql);
    }

    public function selectDonoPubli(){
        $sql = sprintf($this->selectCodUsu,
                       $this->getCodPubli(),
                       $this->getCodUsu());
            $resultado=$this->runSelect($sql);
          if(empty($resultado)){
              return "N"; //se for vazio, quem tá curtindo não é o dono
          }else{
              return "I"; //se não for vazio, é o dono
          }
    }

    public function insert(){ // se o usuario não tiver dado like, insere no banco
        $sql = sprintf($this->sqlInsert,
                       $this->getCodUsu(),
                       $this->getCodPubli(),
                       $this->selectDonoPubli());
        $resultado = $this->runQuery($sql);
    }
}