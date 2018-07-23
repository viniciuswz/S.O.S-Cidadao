<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR);
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;

session_start();
if(isset($_POST) AND !empty($_POST)){//Verificaçao se ele entrou pela url 
    if(isset($_POST['email']) AND isset($_POST['nome'])){//Verificacao se existe esses campos
        try{
            $usuario = new Usuario();
            $usuario->setCodUsu($_SESSION['id_user']);
            $usuario->setEmail($_POST['email']);       
            $usuario->setNomeUsu($_POST['nome']);        
            $usuario->updateEmailNome();
            echo "<script> alert('Alteração realizada com sucesso');javascript:window.location='Templates/starter.php';</script>";
    
        }catch (Exception $exc){
            $mensagem = $exc->getMessage();  
            echo "<script> alert('$mensagem');javascript:window.location='Templates/UpdateNomeEmailTemplate.php';</script>";
        }
    }
    echo "<script> alert('Caba safado para de modificar no inspecionar elemento');javascript:window.location='Templates/UpdateNomeEmailTemplate.php';</script>";
    
}else{
    echo 'Caba safado nao entre pela url';
}