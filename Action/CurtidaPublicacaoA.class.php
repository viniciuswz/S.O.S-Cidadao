<?php
namespace Action;
use Model\CurtidaPublicacaoM;

class CurtidaPublicacaoA extends CurtidaPublicacaoM{
    private $sqlSelect = "SELECT status_publi_curti FROM publicacao_curtida WHERE cod_usu = '%s' AND cod_publi = '%s'";

    public function select(){
     echo $sql = sprintf($this->sqlSelect,
                     $this->getCodUsu(),
                     $this->getCodPubli());
        $resultado = $this->runSelect($sql);
        var_dump($resultado);

        if(empty($resultado)){

        }else if($resultado[0]['status_publi_curti'] == A){

        }else{

        }
    }

    public function update($statusCurtida, $indVisuDono){

    }
}