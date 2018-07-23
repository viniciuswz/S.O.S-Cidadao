<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR);
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;

session_start();
if(isset($_POST) AND !empty($_POST)){ 
    if(isset($_POST['senhaAntiga']) AND isset($_POST['novaSenha'])){
        try{
            $usuario = new Usuario();
            $usuario->setCodUsu($_SESSION['id_user']);             
            $usuario->setSenha($_POST['senhaAntiga']);        
            $usuario->updateSenha($_POST['novaSenha']);
            echo "<script> alert('Alteração realizada com sucesso');javascript:window.location='Templates/starter.php';</script>";
    
        }catch (Exception $exc){
            $mensagem = $exc->getMessage();  
            echo "<script> alert('$mensagem');javascript:window.location='Templates/UpdateSenhaTemplate.php';</script>";
        }
    }
    echo "<script> alert('Caba safado para de modificar no inspecionar elemento');javascript:window.location='Templates/UpdateSenhaTemplate.php';</script>";
    
}else{
    echo 'Caba safado nao entre pela url';
}