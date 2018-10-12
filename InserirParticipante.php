<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Debate;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    $tipoUsuPermi = array('Comum');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         

    $nomesCampos = array('ID');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_GET);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('ID'), $_GET); 

    $debate = new Debate();
    $debate->setCodUsu($_SESSION['id_user']);
    $debate->setCodDeba($_GET['ID']);
    $debate->entrarDebate();
    echo "<script> alert('Bem-vindo ao debate');javascript:window.location='./view/debate_mensagens.php?ID=".$_GET['ID']."&pagina=ultima';</script>";    
        
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='view/login.php';</script>";
            break;
        case 6://Não é usuario comum  
            echo "<script> alert('$mensagem');javascript:window.location='view/index.php';</script>";
            break;
        case 8:// Se der erro ao cadastrar
        case 12://Mexeu no insprnsionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='view/todosdebates.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='view/todosdebates.php';</script>";
    }   
            
            
}    



