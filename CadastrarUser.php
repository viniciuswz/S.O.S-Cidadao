<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
require_once(WWW_ROOT.DS.'autoload.php');//
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
try{        
    Usuario::verificarLogin(1);//Nao pode estar logado
    
    $nomesCampos = array('nome', 'email','senha');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro
    $usuario = new Usuario();
    $usuario->setNomeUsu($_POST['nome']);
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha($usuario->gerarHash($_POST['senha']));// gerar hash da senha
    $usuario->setImgCapaUsu('imgcapapadrao.jpg');// Imagem padrao
    $usuario->setImgPerfilUsu('imgperfilpadrao.jpg'); // Imagem padrao
    $usuario->setCodTipoUsu('5'); // User comum        
    $usuario->cadastrarUser();
    //Pra disparar email ele vai aqui
    echo "<script> alert('Cadastro realizado com sucesso!!!');javascript:window.location='./Templates/starter.php';</script>";
       
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();

    switch($erro){
        case 2://Esta logado  
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
            break;       
        case 3://Erro ao cadastrar usuario
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/cadastrarUserTemplate.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
    }    
    
}


