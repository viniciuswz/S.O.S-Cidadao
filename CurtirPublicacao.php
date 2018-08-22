<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Core\CurtidaPublicacao;
use Classes\ValidarCampos;
session_start();
try{
    $tipoUsuPermi = array('Comum','Funcionario','Prefeitura','Moderador','Adm');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 

    
    $nomesCampos = array('ID');// Nomes dos campos que receberei da url, ID = da publicacao
    $validar = new ValidarCampos($nomesCampos, $_GET);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt($nomesCampos, $_GET); 

    $curtidaPub = new CurtidaPublicacao();
    $curtidaPub->setCodUsu($_SESSION['id_user']);
    $curtidaPub->setCodPubli($_GET['ID']);
    $curtidaPub->select();    
    if(isset($_GET['pagina'])){ //Ta curtindo atraves da listagem de todas as publicaçoess
        echo "<script> javascript:window.location='Templates/VisualizarPublicacoesTemplate.php?pagina=".$_GET['pagina']."';</script>";
    }else{//Ta curtindo atreves da pagina de uma publicacoes especifica
        echo "<script> javascript:window.location='Templates/VerPublicacaoTemplate.php?ID=".$_GET['ID']."';</script>";
    }        

}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){
        case 2://Não está logado  
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            break;          
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/VisualizarPublicacoesTemplate.php';</script>";
            break;             
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/VisualizarPublicacoesTemplate.php';</script>";
    }   
    
}
