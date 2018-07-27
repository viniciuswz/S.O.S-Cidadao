<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Publicacao;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();

if(isset($_POST) AND !empty($_POST)){    
        try{                     
            Usuario::verificarLogin(2);//Tem q estar logado
            Usuario::verificarLogin(3);//Apenas user comum tem acesso           

            $nomesCampos = array('titulo', 'categoria','texto','cep','bairro','local');// Nomes dos campos que receberei do formulario
            $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro

            $publicacao = new Publicacao();
            $publicacao->setTituloPubli($_POST['titulo']);
            $publicacao->setCodCate($_POST['categoria']);
            $publicacao->setTextoPubli($_POST['texto']);
            $publicacao->setCepLogra($_POST['cep']);
            $publicacao->setCodUsu($_SESSION['id_user']);
            if(isset($_FILES['imagem']) AND !empty($_FILES['imagem']['name'])){
                $publicacao->setImgPubli($_FILES['imagem']);
            }            
            $publicacao->cadastrarPublicacao($_POST['bairro'], $_POST['local']);
            echo "<script> alert('Publicacao enviada com sucesso');javascript:window.location='Templates/starter.php';</script>";
        }catch(Exception $exc){
            $mensagem = $exc->getMessage(); 
            if($exc->getCode() == 8 or $exc->getCode() == 12){  // 8 = Se der erro ao cadastrar
                $mensagem = $exc->getMessage();   // 12 = Mexer no inspecionar elemento
                echo "<script> alert('$mensagem');javascript:window.location='./Templates/EnviarPublicacaoTemplate.php';</script>";            
            }
            if($exc->getCode() == 2){//Nao esta logado
                $mensagem = $exc->getMessage();   
                echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            }
            if($exc->getCode() == 6){//Não é usuario comum
                $mensagem = $exc->getMessage();  
                echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
            }
        }    
}else{
    echo 'Caba safado para de entrar pela url';
}


