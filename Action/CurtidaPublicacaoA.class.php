<?php
namespace Action;
use Model\CurtidaPublicacaoM;

class CurtidaPublicacaoA extends CurtidaPublicacaoM{
    private $sqlSelect = "SELECT status_publi_curti FROM publicacao_curtida WHERE cod_usu = '%s' AND cod_publi = '%s"

    public function select(){
      $sql = sprintf($this->sqlSelect,
                     $this->getCodUsu(),
                     $this->getCodPubli());
    }
}