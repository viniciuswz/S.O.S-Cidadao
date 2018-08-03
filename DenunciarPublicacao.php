<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\PublicacaoDenuncia;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    Usuario::verificarLogin(2);//Tem q estar logado
    Usuario::verificarLogin(8);//Apenas user comum, prefeitura e func 
    $nomesCampos = array('id_publi','texto');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_POST);

    if(!is_numeric(intval($_POST['id_publi']))){
        echo 'nao é um numero';
    }
    $denuncia = new PublicacaoDenuncia();   
    $denuncia->setCodPubli($_POST['id_publi']);
    $denuncia->setCodUsu($_SESSION['id_user']);
    $denuncia->setMotivoDenunPubli($_POST['texto']);
    $denuncia->inserirDenuncia();
        
}catch(Exception $exc){  
            
            echo $exc->getMessage();
}    



