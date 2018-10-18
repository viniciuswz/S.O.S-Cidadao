<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Publicacao;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    $tipoUsuPermi = array('Comum');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado
         

    $nomesCampos = array('titulo', 'categoria','texto','cep','bairro','local','base64');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('categoria'), $_POST); 
        
    $publicacao = new Publicacao();
    $publicacao->setTituloPubli($_POST['titulo']);
    $publicacao->setCodCate($_POST['categoria']);
    $publicacao->setTextoPubli($_POST['texto']);
    $publicacao->setCepLogra($_POST['cep']);
    $publicacao->setCodUsu($_SESSION['id_user']);
    $publicacao->setImgPubli($_POST['base64']);    
    
    /*
    if(isset($_FILES['imagem']) AND !empty($_FILES['imagem']['name'])){
        $publicacao->setImgPubli($_POST['base64']);
    }     
    */   
          
    $publicacao->cadastrarPublicacao($_POST['bairro'], $_POST['local']);  
    $idPubli = $publicacao->last(); 
    echo "<script> alert('Publicacao enviada com sucesso');javascript:window.location='./view/reclamacao.php?ID=".$idPubli."';</script>";
        
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./view/loginTemplate.php';</script>";
            break;
        case 6://Não é usuario comum  
            echo "<script> alert('$mensagem');javascript:window.location='./view/starter.php';</script>";
            break;
        case 8:// Se der erro ao cadastrar
        case 12://Mexeu no insprnsionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='./view/Formulario-reclamacao.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./view/Formulario-reclamacao.php';</script>";
    }   
            
            
}    



