<?php

define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Core\PublicacaoSalva;
use Classes\ValidarCampos;
session_start();
try{
    $tipoUsuPermi = array('Comum','Funcionario','Prefeitura','Moderador','Adm');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 
    
    $nomesCampos = array('ID');// Nomes dos campos que receberei da url, ID = do comentario
    $validar = new ValidarCampos($nomesCampos, $_GET);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt($nomesCampos, $_GET); 
    //var_dump($_GET);

    $publicacoSalva = new PublicacaoSalva();   
    
    $publicacoSalva->setCodUsu($_SESSION['id_user']);
    $publicacoSalva->setCodPubli($_GET['ID']);
    $publicacoSalva->salvar();
    
    echo "<script> javascript:window.location='Templates/VerPublicacaoTemplate.php?ID=".$_GET['ID']."';</script>";
    
        
}catch(Exception $exc){
    $erro = $exc->getCode();   
    echo $mensagem = $exc->getMessage();  
    switch($erro){
        case 2://Não está logado  
            //echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            break;          
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            //echo "<script> alert('$mensagem');javascript:window.location='./Templates/VisualizarPublicacoesTemplate.php';</script>";
            break;             
        default: //Qualquer outro erro cai aqui
            //echo "<script> alert('$mensagem');javascript:window.location='./Templates/VisualizarPublicacoesTemplate.php';</script>";
    }   
}
