<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Comentario;
//if(isset($_POST) AND !empty($_POST)){  
    session_start();
    try{        
       $comentario = new Comentario();
       $comentario->setTextoComen('JACA');
       $comentario->setCodUsu($_SESSION['id_user']);
       $comentario->setCodPubli(17);
       $comentario->inserirComen();
    }catch (Exception $exc){
        
    }
//}else{
  //  echo 'caba safado para entrar pela url';
//}

