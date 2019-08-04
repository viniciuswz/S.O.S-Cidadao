<?php
header("Content-type: text/html; charset=utf-8");
try{
    http_response_code(404);               
    throw new \Exception("Caminho da requisição errado", 5001);  
}catch(Exception $exc){
    echo json_encode(["ind_sucesso" => false,"cod_erro" => $exc->getCode(), "messagem" => $exc->getMessage(), "dados" => null]);
}



