<?php
namespace Classes;

class TratarImg{

    public function tratarImagem($dadosImagem, $pastaDestino){ // Mexer depois nessa funcao       //Fazer a parada da thumb 
        
        if($dadosImagem['size'] >= 5000000){
            throw new \Exception("Imagem muito pesada",10);  
        }               
        $novoNome = $this->gerarNome($dadosImagem['name']);
        $mover = move_uploaded_file($dadosImagem['tmp_name'], 'IMG'. DIRECTORY_SEPARATOR . $pastaDestino . DIRECTORY_SEPARATOR. $novoNome);
        if(!$mover){
            throw new \Exception("Erro ao enviar a imagem",10);  
        }        
        return $novoNome;
    }

    public function gerarNome($nomeAntigo){
        $tipo = strrchr($nomeAntigo, '.'); //Pegar a ultima ocorrencia
        return $novoNome =  uniqid(mt_rand(), true) . $tipo; 
    }
}