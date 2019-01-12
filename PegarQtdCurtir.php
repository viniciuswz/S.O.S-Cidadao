<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');


use Classes\ValidarCampos;
use Core\Publicacao;
session_start();
try{   
    
    $nomesCampos = array('ID');// Nomes dos campos que receberei da url, ID = da publicacao
    $validar = new ValidarCampos($nomesCampos, $_GET);//Verificar se eles existem, se nao existir estoura um erro
    $publi = new Publicacao();
    $validar->verificarTipoInt($nomesCampos, $_GET);     
    $ja = $publi->getQuantCurtidas($_GET['ID']);   
    
    echo $ja;  

}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){             
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
            break;             
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
    }   
    
}
