<?php
//session_start();
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');  
use Classes\UrlAmigavel;

$url = new UrlAmigavel($_SERVER['REQUEST_URI']);
$nome = $url->partesUrl[1];
$ind = $url->indRetornar;
if(!$ind){ // nao precisa voltar
    //echo 'das';
    //echo 'Dar require';
    require_once('view/' . $nome);
}else{ // precisa voltar
    //echo 'das';
    header("Location: ../$nome");
}
// if(!$nome){
//     //header("Location: ../");
//     echo 'aqui';
    
// }else{
//     echo 'Dar require';
//     require_once($nome);
// }


