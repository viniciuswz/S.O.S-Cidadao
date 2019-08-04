<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');


require_once(SITE_ROOT.DS.'Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');    
use Core\Publicacao;
use Classes\ValidarCampos;

// http_response_code(200); RESPOSTA OK
try{
    $publi = new Publicacao();

    $dadosUrl = explode('/',$_GET['url']);
        //var_dump($dadosUrl);     
    if(!isset($dadosUrl[1])){
        throw new \Exception('Código identificador não informado',5002);
    }else if(isset($dadosUrl[2])){ //não pode ter mais de tres parametros
        throw new \Exception('Mais informações do que o necessário',5003);
    }  
    $_GET['ID'] = $dadosUrl[1];

    $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_GET);
    $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero
    $publi->setCodPubli($_GET['ID']);
    
    $resposta = $publi->listByIdPubli(null, true);
    

    
    echo json_encode($resposta);

}catch (Exception $exc){       
    $erro = $exc->getCode();
    $mensagem = $exc->getMessage();
    switch($erro){
        case '9':
            $erro = 5003;
            $mensagem = "Publicação não encontrada";
            break;
        case '12':
            $erro = 5004;
            $mensagem = "Código informado não é numérico";
            break;
    }
    echo json_encode(["ind_sucesso" => "false","cod_erro" => $erro, "messagem" => $mensagem]);
}  