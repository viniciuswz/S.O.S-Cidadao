<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Mensagens;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    $tipoUsuPermi = array('Comum');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         

    $nomesCampos = array('texto','ID','pagina');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('ID'), $_POST); 

    $mensagem = new Mensagens($_POST['ID']);
    $mensagem->setCodUsu($_SESSION['id_user']);
    $mensagem->setCodDeba($_POST['ID']);
    $mensagem->setTextoMensa($_POST['texto']);
    $mensagem->inserirMensagem();    
    $mensagem->visualizarMensagem();
    echo "<script>javascript:window.location='./view/debate_mensagens.php?ID=".$_POST['ID']."&pagina=".$_POST['pagina']."';</script>";    
        
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='view/login.php';</script>";
            break;
        case 6://Não é usuario comum  
            echo "<script> alert('$mensagem');javascript:window.location='view/index.php';</script>";
            break;
        case 8:// Se der erro ao cadastrar
        case 12://Mexeu no insprnsionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='view/todosdebates.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='view/todosdebates.php';</script>";
    }   
            
            
}    



