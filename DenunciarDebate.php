<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\DebateDenuncia;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    Usuario::verificarLogin(2);//Tem q estar logado
    Usuario::verificarLogin(8);//Apenas user comum, prefeitura e func 
    $nomesCampos = array('texto','id_deba');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_POST);
    $validar->verificarTipoInt(array('id_deba'),$_POST); // Verificar se é um numero
    
    $denuncia = new DebateDenuncia();   
    $denuncia->setCodDeba($_POST['id_deba']);
    $denuncia->setCodUsu($_SESSION['id_user']);
    $denuncia->setMotivoDenunPubli($_POST['texto']);
    
    $denuncia->inserirDenuncia();

    echo "<script> alert('Denuncia realizada com sucesso');javascript:window.location='./Templates/VerDebateTemplate.php?ID=".$_POST['id_deba']."';</script>";
        
}catch(Exception $exc){  
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            break;
        case 6://Não é usuario comum, prefeitura ou func
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
            break;
        case 12://Mexeu no insprnsionar elemento, ou nao tem valores validos
        case 14://Erro no ao fazer a insercao
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/VisualizarDebatesTemplate.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
    }    
}    



