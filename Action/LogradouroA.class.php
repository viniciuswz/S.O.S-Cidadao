<?php
namespace Action;
use Model\LogradouroM;
use Core\Bairro;

class LogradouroA extends LogradouroM{
    private $sqlSelect = "SELECT * FROM logradouro WHERE cep_logra = '%s'";

    private $sqlInsert = "INSERT INTO logradouro(cep_logra, endere_logra, cod_bai) VALUES ('%s','%s','%s')";

    public function selectCep($bairro){
        $sql = sprintf($this->sqlSelect, $this->getCepLogra());
        
        $res = $this->runSelect($sql);

        if(empty($res)){ // Se nao existir o cep ele vai inserir
            
           return $this->inserirCep($bairro);            
        }
        return $res[0]['cep_logra']; // Se existir ele vai me retornar o codigo
    }

    public function inserirCep($NomeBai){       
        $bairro = new Bairro();
        $bairro->setNomeBai($NomeBai);       
        $codigoBai = $bairro->select();

        $sql = sprintf($this->sqlInsert, 
                        $this->getCepLogra(),
                        $this->getEndereLogra(),
                        $codigoBai
                    );
                  
        $inserir = $this->runQuery($sql);

        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro do logradouro",8);   
        }  
        return $this->last();        
        
    }
}