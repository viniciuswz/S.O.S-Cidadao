<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR);
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
if(isset($_POST) AND !empty($_POST)){    
        try{
            $nomesCampos = array('senhaAntiga', 'novaSenha');// Nomes dos campos que receberei do formulario
            $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro

            $usuario = new Usuario();
            $usuario->setCodUsu($_SESSION['id_user']);             
            $usuario->setSenha($_POST['senhaAntiga']);        
            $usuario->updateSenha($_POST['novaSenha']);
            echo "<script> alert('Alteração realizada com sucesso');javascript:window.location='Templates/starter.php';</script>";
    
        }catch (Exception $exc){
            $mensagem = $exc->getMessage();  
            if($exc->getCode() == 1 or $exc->getCode() == 12){  // 1 = Se der erro ao cadastrar
                $mensagem = $exc->getMessage();   // 12 = Mexer no inspecionar elemento
                echo "<script> alert('$mensagem');javascript:window.location='Templates/UpdateNomeEmailTemplate.php';</script>";            
            } 
        }   
            
}else{
    echo 'Caba safado nao entre pela url';
}