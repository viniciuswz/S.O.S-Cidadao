<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Comentario;
use Core\Usuario;
if(isset($_POST) AND !empty($_POST)){  
    session_start();
    try{        
       
       Usuario::verificarLogin(2);// Tem q estar logado
       $texto = $_POST['texto'];
       $idPubli = $_POST['id'];
       $comentario = new Comentario();
       $comentario->setTextoComen($texto);
       $comentario->setCodUsu($_SESSION['id_user']);
       $comentario->setCodPubli($idPubli);
       $comentario->inserirComen();

       echo "<script> javascript:window.location='Templates/VerPublicacaoTemplate.php?ID=".$idPubli."';</script>";

    }catch (Exception $exc){
        echo $exc->getMessage();
    }
}else{
    echo 'caba safado para entrar pela url';
}

