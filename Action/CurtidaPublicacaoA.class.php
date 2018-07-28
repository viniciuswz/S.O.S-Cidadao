<?php
namespace Action;
use Model\CurtidaPublicacaoM;

class CurtidaPublicacaoA extends CurtidaPublicacaoM{
    private $sqlSelect = "SELECT status_publi_curti FROM publicacao_curtida WHERE cod_usu = '%s' AND cod_publi = '%s'";

    private $sqlUpdate = "UPDATE publicacao_curtida SET status_publi_curti = '%s',
                                                        ind_visu_dono_publi = '%s' WHERE cod_usu = '%s' AND cod_publi='%s'";
    
    private $sqlInsert = "INSERT into publicacao_curtida(cod_usu, cod_publi, ind_visu_dono_publi) VALUES('%s', '%s', '%s')";
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
            $this->update("I", $verificacaoDono);
        }else{
            $this->update("A", $verificacaoDono);
        }
    }

    public function update($statusCurtida, $indVisuDonoPubli){
        $sql = sprintf($this->sqlUpdate,
                       $statusCurtida,
                       $indVisuDonoPubli,
                       $this->getCodUsu(),
                       $this->getCodPubli());
            $resultado=$this->runQuery($sql);
    }

    public function selectDonoPubli(){
        $sql = sprintf($this->selectCodUsu,
                       $this->getCodPubli(),
                       $this->getCodUsu());
            $resultado=$this->runSelect($sql);
          if(empty($resultado)){
              return "N";
          }else{
              return "I";
          }
    }

    public function insert(){
        $sql = sprintf($this->sqlInsert,
                       $this->getCodUsu(),
                       $this->getCodPubli(),
                       $this->selectDonoPubli());
            $resultado=$this->runQuery($sql);
    }
}