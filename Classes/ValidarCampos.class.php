<?php
namespace Classes;

class ValidarCampos{    

    public function __construct($campos = array(), $dadosFormulario = array(), $dadosImagem = null){
        $this->verificarExistencia($campos, $dadosFormulario,$dadosImagem);
    }

    public function verificarExistencia($campos, $dadosFormulario, $dadosImagem){
        foreach($campos as $chave => $nomeCampo){
            if(!isset($dadosFormulario[$nomeCampo])){ // Primeiro pergunta nos dados do POST
               if($dadosImagem != null AND (!isset($dadosImagem[$nomeCampo])) ){ // Depois nos dados do FILE se for dirente de null é pq tem q ter imagem                       
                    throw new \Exception("Mexeu no inspecionar elemento",12); // Se nao existir estoura um erro
                }else if(!isset($dadosImagem[$nomeCampo])){                                     
                    throw new \Exception("Mexeu no inspecionar elemento",12); // Se nao existir estoura um erro
                }                
            }
        }
    }

    public function verificarTipoInt($campos = array(), $dadosFormulario = array()){
        foreach($campos as $chave => $nomeCampo){
            $valor = $dadosFormulario[$nomeCampo];
            if(!is_numeric($valor) or $valor <= 0){
                throw new \Exception("Não é um numero",12); // Se nao for numero
            }
        }
    }

}