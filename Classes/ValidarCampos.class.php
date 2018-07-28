<?php
namespace Classes;

class ValidarCampos{    

    function __construct($campos = array(), $dadosFormulario = array()){
        $this->verificarExistencia($campos, $dadosFormulario);
    }

    function verificarExistencia($campos = array(), $dadosFormulario = array()){
        foreach($campos as $chave => $nomeCampo){
            if(!isset($dadosFormulario[$nomeCampo])){                
                throw new \Exception("Mexeu no inspecionar elemento",12); 
            }
        }
    }

}