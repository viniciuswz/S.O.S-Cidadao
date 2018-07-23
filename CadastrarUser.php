<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
if(isset($_POST) AND !empty($_POST)){  
    session_start();
    try{        
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
        if($exc->getCode() == 3){  //Se der erro ao cadastrar
            $mensagem = $exc->getMessage();  
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/cadastrarUserTemplate.php';</script>";            
        }
    }
}else{
    echo 'caba safado para entrar pela url';
}

