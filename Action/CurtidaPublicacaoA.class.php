<?php
namespace Action;
use Model\CurtidaPublicacaoM;

class CurtidaPublicacaoA extends CurtidaPublicacaoM{
    private $sqlSelect = "SELECT status_publi_curti FROM publicacao_curtida WHERE cod_usu = '%s' AND cod_publi = '%s'";

    private $sqlUpdate = "UPDATE publicacao_curtida SET status_publi_curti = '%s',
                                                        ind_visu_dono_publi = '%s' WHERE cod_usu = '%s' AND cod_publi='%s'";
    
    private $selectCodUsu ="SELECT cod_usu FROM publicacao WHERE cod_publi = '%s'";
    public function select(){
     echo $sql = sprintf($this->sqlSelect,
                     $this->getCodUsu(),
                     $this->getCodPubli());
        $resultado = $this->runSelect($sql);
        var_dump($resultado);
        $verificacaoDono = $this->selectDonoPubli();
        if(empty($resultado)){
            echo 'insert';
        }else if($resultado[0]['status_publi_curti'] == "A"){
            echo 'descurtir';
            $this->update("I", $verificacaoDono);
        }else{
            echo 'curtir';
        }
    }

    public function update($statusCurtida, $indVisuDono){
        $sql = sprintf($this->sqlUpdate,
                       $statusCurtida,
                       $indVisuDono,
                       $this->getCodUsu(),
                       $this->getCodPubli());
            $resultado=$this->runQuery($sql);
    }

    public function selectDonoPubli(){
        $sql = sprintf($this->selectCodUsu(),
                       $this->codPubli;
          $resultado = $this->runSelect($sql);
          if(empty($resultado)){
              return "A";
          }else{
              return "I";
          }
    }
}