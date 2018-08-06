<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    Usuario::verificarLogin(2);//Tem q estar logado
    //Usuario::verificarLogin(6);//Apenas user comum, adm e moderador 
    $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_GET);
    $validar->verificarTipoInt(array('ID'),$_GET); // Verificar se é um numero
    
    $usu = new Usuario();   
    $usu->setCodUsu($_GET['ID']);//Usuario q esta sendo apagado
    //$usu->setCodUsuApagador($_SESSION['id_user']);   // Usuario q esta apagando
    $usu->updateStatusUsu('I', $_SESSION['id_user']);

    echo "<script> alert('Status mudado');javascript:window.location='./Templates/starter.php';</script>";
        
}catch(Exception $exc){  
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            break;
        case 6://Não é usuario comum, prefeitura ou func
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
            break;
        case 12://Mexeu no insprnsionar elemento, ou nao tem valores validos
        case 9://Erro no ao fazer a insercao
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
    }    
}    



