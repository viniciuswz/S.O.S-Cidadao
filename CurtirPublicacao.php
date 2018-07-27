<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Core\CurtidaPublicacao;
session_start();

if(isset($_GET['ID'])){
    try{
        Usuario::verificarLogin(2);//Tem q estar logado, vai estourar um erro se nao estiver logado
        $curtidaPub = new CurtidaPublicacao();
        $curtidaPub->setCodUsu($_SESSION['id_user']);
        $curtidaPub->setCodPubli($_GET['ID']);
        $curtidaPub->select();
       

    }catch(Exception $exc){
            $mensagem = $exc->getMessage();  
    }
}else{
    echo 'Não tem ID';
}