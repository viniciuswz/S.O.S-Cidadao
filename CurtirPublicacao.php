<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 

require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Core\CurtidaPublicacao;
session_start();

if(isset($_GET['ID'])){
    try{
        Usuario::verificarLogin(2);//Tem q estar logado, vai estourar um erro se nao estiver logado
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
            $mensagem = $exc->getMessage();  
            if($exc->getCode() == 2){//Nao esta logado
                $mensagem = $exc->getMessage();   
                echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
            }
    }
}else{
    echo 'Não tem ID';
}