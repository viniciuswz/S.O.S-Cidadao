<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{       
    
    $tipoUsuPermi = array('Comum','Moderador','Adm','Prefeitura');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 
         
    $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_GET);
    $validar->verificarTipoInt(array('ID'),$_GET); // Verificar se é um numero
    
    $usu = new Usuario();   
    $usu->setCodUsu($_GET['ID']);//Usuario q esta sendo apagado
    //$usu->setCodUsuApagador($_SESSION['id_user']);   // Usuario q esta apagando
    $resul = $usu->updateStatusUsu('I', $_SESSION['id_user']);

    if($resul == 1){ // Prefeitura apagou funcionario
        echo '1';
        //echo "<script> alert('A funcão de funcionario para este usuario foi removida');javascript:window.location='./view/prefeitura-admin.php';</script>";
    }else if($resul == 2){
        echo '1';
        //echo "<script> alert('Status mudado');javascript:window.location='./view/admin-moderador.php?tipo1=Adm&tipo2=Moderador&tipo3=Prefeitura&tipo4=Funcionario';</script>";
    }else{
        echo "<script> alert('Status mudado');javascript:window.location='./view/index.php';</script>";
    }
    
        
}catch(Exception $exc){  
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./view/login.php';</script>";
            break;
        case 6://Não é usuario comum, prefeitura ou func
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;
        case 12://Mexeu no insprnsionar elemento, ou nao tem valores validos
        case 9://Erro no ao fazer a insercao
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
    }    
}    



