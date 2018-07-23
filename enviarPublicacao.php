<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Publicacao;
use Core\Usuario;
session_start();

if(isset($_POST) AND !empty($_POST)){
    if(isset($_POST['titulo']) 
        AND
        isset($_POST['local'])
        AND
        isset($_POST['bairro'])
        AND 
        isset($_POST['cep'])
        AND 
        isset($_POST['categoria'])
        AND
        isset($_POST['texto'])
    ){
        try{
            
          
            Usuario::verificarLogin(2);//Tem q estar logado
            Usuario::verificarLogin(3);//Apenas user comum tem acesso
            //header("Content-Type: image/png");
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
        }
        
        

    }

    echo "<script> alert('Caba safado para de modificar no inspecionar elemento');javascript:window.location='Templates/EnviarPublicacaoTemplate.php';</script>";
}else{
    echo 'Caba safado para de entrar pela url';
}


