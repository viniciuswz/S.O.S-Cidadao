<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Publicacao;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    $tipoUsuPermi = array('Comum','Adm','Moderador');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado
         

    $nomesCampos = array('titulo', 'categoria','texto','cep','bairro','local','imagem','id_publi');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST, $_FILES);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('categoria','id_publi'), $_POST); 
    
    $publicacao = new Publicacao();
    $publicacao->setTituloPubli($_POST['titulo']);
    $publicacao->setCodCate($_POST['categoria']);
    $publicacao->setTextoPubli($_POST['texto']);
    $publicacao->setCepLogra($_POST['cep']);
    $publicacao->setCodUsu($_SESSION['id_user']);
    $publicacao->setCodPubli($_POST['id_publi']);
    if(isset($_FILES['imagem']) AND !empty($_FILES['imagem']['name'])){
        $publicacao->setImgPubli($_FILES['imagem']);
    }            
    $publicacao->updatePublicacao($_POST['bairro'], $_POST['local']);    
    echo "<script> alert('Publicacao edita com sucesso');javascript:window.location='./view/reclamacao.php?ID=".$_POST['id_publi']."';</script>";
        
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./view/login.php';</script>";
            break;
        case 6://Não é usuario comum  
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;
        case 9:// Se der erro ao cadastrar
        case 12://Mexeu no insprnsionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
           echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
    }   
            
            
}    



