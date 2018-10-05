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
         

    $nomesCampos = array('titulo', 'tema','imagem','descricao','ID');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST, $_FILES);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('ID'), $_POST); 
    
    $debate = new Debate();
    $debate->setNomeDeba($_POST['titulo']);    
    $debate->setTemaDeba($_POST['tema']);
    $debate->setDescriDeba($_POST['descricao']);
    $debate->setCodUsu($_SESSION['id_user']);
    $debate->setImgDeba($_FILES['imagem']);
    $debate->setCodDeba($_POST['ID']);    
    $debate->updateDebate();
      
      
    echo "<script> alert('Debate editado com sucesso');javascript:window.location='./view/Pagina-debate.php?ID=".$_POST['ID']."';</script>";
        
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
        case 13:// Se der erro ao cadastrar
        case 12://Mexeu no insprnsionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
           echo "<script> alert('$mensagem');javascript:window.location='./view/index.php';</script>";
    }   
            
            
}    



