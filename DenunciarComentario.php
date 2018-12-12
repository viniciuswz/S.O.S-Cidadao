<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\ComentarioDenuncia;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{   
    
    $tipoUsuPermi = array('Comum','Funcionario','Prefeitura');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 
    
    $nomesCampos = array('id','texto');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_POST);
    $validar->verificarTipoInt(array('id'),$_POST); // Verificar se é um numero
    
    $denuncia = new ComentarioDenuncia();   
    $denuncia->setCodComen($_POST['id']);
    $denuncia->setCodUsu($_SESSION['id_user']);
    $denuncia->setMotivoDenunComen($_POST['texto']);
    
    $denuncia->inserirDenuncia();

    //echo "<script> alert('Denuncia realizada com sucesso');javascript:window.location='./view/reclamacao.php?ID=".$_POST['id_publi']."';</script>";
        
}catch(Exception $exc){  
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo 'NLogado';  
            //echo "<script> alert('$mensagem');javascript:window.location='./view/login.php';</script>";
            break;
        case 6://Não é usuario comum, prefeitura ou func
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;
        case 12://Mexeu no insprnsionar elemento, ou nao tem valores validos
        case 14://Erro no ao fazer a insercao
            echo "<script> alert('$mensagem');javascript:window.location='./view/todasreclamacoes.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
    }    
}    



