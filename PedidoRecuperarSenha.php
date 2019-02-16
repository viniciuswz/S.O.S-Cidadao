<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\RecuperarSenha;
use Core\Usuario;
//use Classes\ValidarCampos;
session_start();
try{    
    Usuario::verificarLogin(0);  // Nao Tem q estar logado     
      
    $recuperarSenha = new RecuperarSenha();
    $recuperarSenha->setEmail($_POST['email']);
    $hash = $recuperarSenha->inserirPedido();    
    echo '1';
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){
        case 6://está logado          
            echo "<script>javascript:window.location='todasreclamacoes';</script>";
        break; 
        case 20:
            echo $mensagem;
            break;        
        case 1123:
            echo $mensagem;
            break;
        default:
            echo $mensagem;
    }   
}
