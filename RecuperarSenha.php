<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\RecuperarSenha;
use Core\Usuario;
session_start();
try{
    Usuario::verificarLogin(0);  // Nao Tem q estar logado     
    
      
    $recuperarSenha = new RecuperarSenha(); 
    $recuperarSenha->setCodUsu($_POST['id']);
    $recuperarSenha->mudarSenha($_POST['senha']);
    $_SESSION['recuperar_senha'] = 1;
    echo 1;
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){
        case 6://Não está logado  
            echo "<script>javascript:window.location='todasreclamacoes';</script>";
            break;          
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
            break;             
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
    }   
}
