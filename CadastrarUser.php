<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;
if(isset($_POST) AND !empty($_POST)){  
    session_start();
    try{        
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
        if($exc->getCode() == 3 or $exc->getCode() == 12){  // 3 = Se der erro ao cadastrar
            $mensagem = $exc->getMessage();   // 12 = Mexer no inspecionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/cadastrarUserTemplate.php';</script>";            
        }
    }
}else{
    echo 'caba safado para entrar pela url';
}

