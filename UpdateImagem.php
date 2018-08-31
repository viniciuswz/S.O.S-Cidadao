<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;

session_start();

try{
    $tipoUsuPermi = array('Comum','Adm','Moderador','Prefeitura','Funcionario');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 

    $nomesCampos = array('imagem','tipo');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST, $_FILES);//Verificar se eles existem, se nao existir estoura um erro   

    $usuario = new Usuario();
    $usuario->setCodUsu($_SESSION['id_user']);    
    $usuario->updateImage($_FILES['imagem'],$_POST['tipo']);
    
    echo "<script> alert('Imagem alterada com sucesso');javascript:window.location='Templates/starter.php';</script>";
    
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Esta logado 
        case 6://Esta logado 
           echo "<script> alert('$mensagem');javascript:window.location='Templates/starter.php';</script>";
            break;   
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='Templates/starter.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='Templates/starter.php';</script>";  
    }   
            
}   
    
