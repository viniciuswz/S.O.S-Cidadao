<?php
header("Content-type: text/html; charset=utf-8");



require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');  
use Classes\UrlAmigavel;
try{    
    $url = new UrlAmigavel($_SERVER['REQUEST_URI']);
    $nome = $url->partesUrl[1];
    $ind = $url->indRetornar;    
    if(!$ind && $nome != "home.php"){ // nao precisa voltar
        if(is_file('requisicoes/' . $nome)){
            require_once('requisicoes/' . $nome);
        }
    }else{ // precisa voltar   
        http_response_code(404);               
        throw new \Exception("Caminho da requisição errado", 5001);
    }   
}catch(Exception $exc){
    echo json_encode(["ind_sucesso" => "false","cod_erro" => $exc->getCode(), "messagem" => $exc->getMessage()]);
}



