<?php
namespace Action;
use Model\BairroM;

class BairroA extends BairroM{
    private $sqlSelect = "SELECT cod_bai FROM bairro WHERE nome_bai = '%s' AND status_bai = 'A'";
    
    private $sqlInsert = "INSERT INTO bairro(nome_bai) VALUES('%s')";

    public function select(){        
        $sql = sprintf($this->sqlSelect, $this->getNomeBai());
        $res = $this->runSelect($sql);

        if(empty($res)){ // Se nao existir o bairro ele vai inserir
           return $this->inserirBairro();            
        }
        return $res[0]['cod_bai']; // Se existir ele vai me retornar o codigo
        
    }

    public function inserirBairro(){
        $sql = sprintf($this->sqlInsert, $this->getNomeBai());
        
        $inserir = $this->runQuery($sql);

        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro do bairro",7);   
        }  
        return $this->last();//Retornar o id        
      
    }


}