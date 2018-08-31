<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;
use Core\Comentario;
session_start();

try{
    $tipoUsuPermi = array('Comum','Funcionario','Prefeitura');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 

    $nomesCampos = array('texto', 'id');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('id'), $_POST); // Verificar se o parametro da url é um numero

    $comentario = new Comentario();
    $comentario->setCodUsu($_SESSION['id_user']);
    $comentario->setTextoComen($_POST['texto']);
    $comentario->setCodComen($_POST['id']);
    $idPubli = $comentario->updateComentario();
    
    echo "<script> alert('Alteração realizada com sucesso');javascript:window.location='Templates/VerPublicacaoTemplate.php?ID=".$idPubli."';</script>";
    
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
    
