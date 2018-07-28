<?php
namespace Action;
use Model\DebateM;
use Classes\TratarImg;
class DebateA extends DebateM{
    
    private $sqlInsert = "INSERT INTO debate(img_deba, nome_deba, dataHora_deba, tema_deba, descri_deba, cod_usu) 
                VALUES ('%s','%s',now(),'%s','%s','%s')";

    public function tratarImagem(){ // Mexer depois nessa funcao
        //Fazer a parada da thumb       
        $tratar = new TratarImg();
        $novoNome = $tratar->tratarImagem($this->getImgDeba(), 'debate');
        $this->setImgDeba($novoNome);
        return;
    } 

    public function insert(){
        $this->tratarImagem();
        $sql = sprintf($this->sqlInsert,
                        $this->getImgDeba(),
                        $this->getNomeDeba(),
                        $this->getTemaDeba(),
                        $this->getDescriDeba(),
                        $this->getCodUsu()
        );

        $inserir = $this->runQuery($sql);
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro da publicacao",13);   
        }
        return;        
    }
}