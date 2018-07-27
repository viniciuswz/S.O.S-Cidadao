<?php
namespace Classes;

class ValidarCampos{    

    function verificarExistencia($campos = array(), $dadosFormulario = array()){
        foreach($campos as $chave => $nomeCampo){
            if(!isset($dadosFormulario[$nomeCampo])){                
                throw new \Exception("Mexeu no inspecionar elemento",7); 
            }
        }
    }

}