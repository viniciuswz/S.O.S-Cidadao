<?php

define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Core\CurtirComentario;
session_start();

if(isset($_GET['ID'])){
    try{
        Usuario::verificarLogin(2);
        $curtidaComen = new CurtirComentario();
        $curtidaComen->setCodUsu($_SESSION['id_user']);
        $curtidaComen->setCodComen($_GET['ID']);
        $curtidaComen->select();
    }catch(Exception $exc){
        $mensagem = $exc->getMessage();
        if($exc->getCode() == 2){
            $mensagem = $exc->getMessage();
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
        }
    }
}else{
    echo "Não tem ID";
}