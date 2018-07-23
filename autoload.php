<?php
//Inclusao Automatica

function __autoload($class){
    $cl = WWW_ROOT. DS . str_replace('\\', DS, $class) . '.class.php';    
    //var_dump($cl);
    //echo '<br>';
    if(!file_exists($cl)){
        throw new \Exception("Arquivo '{$cl}' não encontrado!");
    }else{
        require_once($cl);
    }


}