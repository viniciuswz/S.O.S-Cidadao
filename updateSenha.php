<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{
    $tipoUsuPermi = array('Comum','Funcionario','Prefeitura','Moderador','Adm');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 

    $nomesCampos = array('senhaAntiga', 'novaSenha');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro

    $usuario = new Usuario();
    $usuario->setCodUsu($_SESSION['id_user']);             
    $usuario->setSenha($_POST['senhaAntiga']);        
    $usuario->updateSenha($_POST['novaSenha']);
    //echo "<script> alert('Alteração realizada com sucesso');javascript:window.location='view/index.php';</script>";
    echo 1;
    
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();     
    switch($erro){
        case 1://Erro ao fazer update 
            echo $mensagem;       
            //echo "<script> alert('$mensagem');javascript:window.location='./view/configuracoes2.php';</script>";
            break;
        case 5://Senha errada
            echo 5;  
            //echo "<script> alert('$mensagem');javascript:window.location='./view/configuracoes2.php';</script>";
            break;
        case 2://Não esta logado  
            echo "<script> alert('$mensagem');javascript:window.location='./view/login.php';</script>";
            break; 
        case 12://Mexeu no insprnsionar elemento  ou entrou pela url
            echo "<script> alert('$mensagem');javascript:window.location='./view/configuracoes2.php';</script>";
            break;       
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./view/configuracoes2.php';</script>";
    }   
}   
            
