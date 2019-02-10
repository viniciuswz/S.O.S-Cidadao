<?php
//session_start();
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');  
use Classes\UrlAmigavel;
try{
    $url = new UrlAmigavel($_SERVER['REQUEST_URI']);
    $nome = $url->partesUrl[1];
    $ind = $url->indRetornar;
    if(!$ind){ // nao precisa voltar
        if(is_file('view/' . $nome)){
            require_once('view/' . $nome);
        }
    }else{ // precisa voltar        
        header("Location: ../$nome");
    }   
}catch(Exception $exc){
    echo $exc->getMessage();
}



