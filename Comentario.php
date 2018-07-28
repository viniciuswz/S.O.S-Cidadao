<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Comentario;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
try{            
    Usuario::verificarLogin(2);// Tem q estar logado

    $nomesCampos = array('texto', 'id');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro
       
    $texto = $_POST['texto'];
    $idPubli = $_POST['id'];
    $comentario = new Comentario();
    $comentario->setTextoComen($texto);
    $comentario->setCodUsu($_SESSION['id_user']);
    $comentario->setCodPubli($idPubli);
    $comentario->inserirComen();

    echo "<script> javascript:window.location='Templates/VerPublicacaoTemplate.php?ID=".$idPubli."';</script>";

}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Não está logado  
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            break;  
        case 11:// Erro no comentario
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/VisualizarPublicacoesTemplate.php';</script>";
            break;             
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/VisualizarPublicacoesTemplate.php';</script>";
    }    
    
}


