<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR);
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;

session_start();

    if(isset($_POST) AND !empty($_POST)){  
        try{
            $usuario = new Usuario();  
            $usuario->setEmail($_POST['email']);
            $usuario->setSenha($_POST['senha']);
            $resultado = $usuario->logar();
            if($resultado[0]['descri_tipo_usu'] == 'Comum'){
                //echo 'comum';
                header("Location: ./Templates/starter.php"); // Joga pra index
            }else if($resultado[0]['descri_tipo_usu'] == 'Adm' or $resultado[0]['descri_tipo_usu'] == 'Moderador'){
                //echo 'administracao';
                //header("Location: ./Templates/indexTemplate.php");
                header("Location: ./Templates/starter.php");
            }else if($resultado[0]['descri_tipo_usu'] == 'Prefeitura' or $resultado[0]['descri_tipo_usu'] == 'Funcionario'){
                //echo 'prefeitura';
                //header("Location: ./Templates/indexTemplate.php");
                header("Location: ./Templates/starter.php");
            }
    
    
        }catch (Exception $exc){
           if($exc->getCode() == 1){  //Se der as informações de login estiverem erradas
                $mensagem = $exc->getMessage();  
                echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";            
            }
        }
    
    }else{
        echo 'caba safado para entrar pela url';
    }




