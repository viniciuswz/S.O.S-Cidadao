<?php 

namespace Action;
use Model\CurtirComentarioM;

class CurtirComentarioA extends CurtirComentarioM{
    private $sqlSelect = "SELECT status_curte FROM comen_curtida WHERE cod_usu = '%s' AND cod_comen = '%s'";

    private $sqlUpdate = "UPDATE comen_curtida SET status_curte = '%s', ind_visu_dono_publi = '%s'
                                               WHERE cod_usu = '%s' AND cod_comen = '%s'";

    private $sqlInsert = "INSERT into comen_curtida(cod_usu, cod_comen, ind_visu_dono_publi) VALUES ('%s', '%s', '%s')";

    private $selectCodUsu = "SELECT cod_usu FROM comentario WHERE cod_comen = '%s' AND cod_usu = '%s'";


    public function select(){
        $sql = sprintf($this->sqlSelect,
                       $this->getCodUsu(),
                       $this->getCodComen());
          $resultado = $this->runSelect($sql);
          $verificacaoDono = $this->selectDonoComen();

          var_dump($resultado);
          if(empty($resultado)){
              $this->insert();
              echo "Inserido";
          }else if($resultado[0]['status_curte'] == "A"){ 
              $this->update("I", $verificacaoDono);//se for A(like) atualiza pra I(deslike)
          }else{
              $this->update("A", $verificacaoDono);//se for I(deslike) atualiza pra A(like)
          }
      }

      

      public function update($statusCurte, $indVisuDonoPubli){ //se já tiver inserido, atualiza pra A/I no banco
        $sql = sprintf($this->sqlUpdate,
                       $statusCurte,
                       $indVisuDonoPubli,
                       $this->getCodUsu(),
                       $this->getCodComen());
            $resultado=$this->runQuery($sql);
    }

    public function selectDonoComen(){
        $sql = sprintf($this->selectCodUsu,
                       $this->getCodComen(),
                       $this->getCodUsu());
            $resultado=$this->runSelect($sql);
          if(empty($resultado)){
              return "N"; //se for vazio, quem tá curtindo não é o dono
          }else{
              return "I"; //se não for vazio, é o dono
          }}

          public function insert(){ // se o usuario não tiver dado like, insere no banco
            $sql = sprintf($this->sqlInsert,
                           $this->getCodUsu(),
                           $this->getCodComen(),
                           $this->selectDonoComen());
                $resultado=$this->runQuery($sql);
        }
    
}