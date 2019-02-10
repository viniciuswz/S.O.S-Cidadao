<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Debate;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();

try{              
           
    $tipoUsuPermi = array('Comum','Moderador','Adm');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 

    $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_GET);
    $validar->verificarTipoInt(array('ID'),$_GET); // Verificar se é um numero
    
    $publi = new Debate();   
    $publi->setCodDeba($_GET['ID']);
    $publi->setCodUsu($_SESSION['id_user']);   
    $publi->updateStatusDeba('I');
    if(isset($_GET['indNoti'])){
        $_SESSION['atu'] = 1;
    }else{
        $_SESSION['atu'] = 3;   
    }

    if(isset($_GET['tipo'])){
        echo "<script> alert('Debate Removido');javascript:window.location='admin-denuncia';</script>";
    }else{
        echo "<script>javascript:window.location='todosdebates';</script>";    
    }

    
        
}catch(Exception $exc){  
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script>javascript:window.location='login';</script>";
            break;        
        case 6://Não é usuario comum, prefeitura ou func        
        case 9://Erro no ao fazer a insercao
        case 12://Mexeu no insprnsionar elemento, ou nao tem valores validos
            echo "<script> alert('$mensagem');javascript:window.location='todosdebates';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script>javascript:window.location='login';</script>";
    }    
}    



