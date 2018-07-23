<?php 

namespace Model;
use Db\DbConnection;

class GenericaM extends DbConnection{    
    
    private $dados = array();

    public function __call($jaca, $jaquinha = array()){        
        $acao = strtolower(substr($jaca,0,3)); //ficar tudo minusculo
        $nomeMetodo = strtolower(substr($jaca,3,strlen($jaca)));// ficar tudo minusculo    
        
        switch($acao){
            case 'set': 
                foreach($jaquinha as $chaves => $valores){
                    foreach($valores as $chave => $valor){                        
                        $this->dados[$nomeMetodo][$chave] = $valor;
                    }                                        
                } 
                break;
            case 'get':
                $data = array();
                foreach($this->dados as $chaves => $valores){
                    foreach($valores as $chave => $valor){
                        $data[] = $this->dados[$chaves][$chave][$nomeMetodo];
                    }  
                }
                return $data;
                break;
        }       
        
    } 
    
    public function getValores(){
        return $this->dados;
    }

}



