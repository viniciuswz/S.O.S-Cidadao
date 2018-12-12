<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;
use Classes\Denuncias;
session_start();
  
try{       
    
    $tipoUsuPermi = array('Moderador','Adm');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 
         
    $nomesCampos = array('ID','tipo');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_GET);
    $validar->verificarTipoInt(array('ID'),$_GET); // Verificar se é um numero
    
    $denuncia = new Denuncias();
    $denuncia->setCodDenun($_GET['ID']);
    $denuncia->deletarDenun($_GET['tipo']);     
    
    echo "<script> alert('Denuncia removida com sucesso');javascript:window.location='view/admin-denuncia.php';</script>";
        
}catch(Exception $exc){  
    $erro = $exc->getCode();   
    echo $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./view/login.php';</script>";
            break;
        case 6://Não é usuario comum, prefeitura ou func
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;
        case 12://Mexeu no insprnsionar elemento, ou nao tem valores validos
        case 9://Erro no ao fazer a insercao
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;  
        case 20://Erro no ao fazer a update
            echo "<script> alert('$mensagem');javascript:window.location='./view/admin-denuncia.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
    }    
}    



