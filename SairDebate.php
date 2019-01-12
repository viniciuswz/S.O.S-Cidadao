<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Debate;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    $tipoUsuPermi = array('Comum','Adm','Moderador');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         

    $nomesCampos = array('ID');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_GET);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('ID'), $_GET); 

    $debate = new Debate();
    $debate->setCodUsu($_SESSION['id_user']);
    $debate->setCodDeba($_GET['ID']);    

    if(isset($_GET['IDUsu'])){
        $validar = new ValidarCampos($nomesCampos, $_GET);//Verificar se eles existem, se nao existir estoura um erro
        $validar->verificarTipoInt(array('IDUsu'), $_GET); 
        $ind = $debate->sairDebate(TRUE,$_GET['IDUsu']); // dono ou adm removendo usuario
    }else{
        $ind = $debate->sairDebate();
    }
    
    if($ind == 1){ // adm removeu
        $_SESSION['atu'] = 2;
        echo "<script>javascript:window.location='debate_mensagens/".$_GET['ID']."';</script>";    
    }else if($ind == 2){ // dono removeu        
        $_SESSION['atu'] = 2;
        echo "<script>javascript:window.location='debate_mensagens/".$_GET['ID']."';</script>";        
    }else if($ind == 3){ // usuario saiu ou dono saiu     
        $_SESSION['atu'] = 1;   
        echo "<script>javascript:window.location='todosdebates';</script>";    
    }else{
        $_SESSION['atu'] = 2;   
        echo "<script>javascript:window.location='todosdebates';</script>";    
    }
    
        
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='login';</script>";
            break;
        case 6://Não é usuario comum  
            echo "<script> alert('$mensagem');javascript:window.location='todosdebates';</script>";
            break;
        case 8:// Se der erro ao cadastrar
        case 12://Mexeu no insprnsionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='todosdebates';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='todosdebates';</script>";
    }   
            
            
}    



