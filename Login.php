<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR);
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;

session_start();

try{
    Usuario::verificarLogin(1);//Não pode estar logado

    $nomesCampos = array('email','senha'); // Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST); //Verificar se eles existem, se nao existir estoura um erro

    $usuario = new Usuario();  
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha($_POST['senha']);
    $resultado = $usuario->logar();
    if($resultado[0]['descri_tipo_usu'] == 'Comum'){
        //echo 'comum';
        header("Location: ./Templates/starter.php"); // Joga pra index
    }else if($resultado[0]['descri_tipo_usu'] == 'Adm' or $resultado[0]['descri_tipo_usu'] == 'Moderador'){
        //echo 'administracao';
        //header("Location: ./Templates/indexTemplate.php");
        header("Location: ./Templates/starter.php");
    }else if($resultado[0]['descri_tipo_usu'] == 'Prefeitura' or $resultado[0]['descri_tipo_usu'] == 'Funcionario'){
        //echo 'prefeitura';
        //header("Location: ./Templates/indexTemplate.php");
        header("Location: ./Templates/starter.php");
    }
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 1://Erro ao fazer login   
        case 12://Mexeu no insprnsionar elemento  ou entrou pela url
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            break;
        case 2://Está logado  
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
    }   
    
}
    
   




