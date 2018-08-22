<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR);
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Usuario;
use Classes\ValidarCampos;

session_start();

try{
    $tipoUsuPermi = array('Comum','Funcionario','Prefeitura','Moderador','Adm');;
    Usuario::verificarLogin(1);//Não pode estar logado

    //$nomesCampos = array('email','senha'); // Nomes dos campos que receberei do formulario
    //$validar = new ValidarCampos($nomesCampos, $_POST); //Verificar se eles existem, se nao existir estoura um erro

    //$usuario = new Usuario();  
    
}catch (Exception $exc){
    $erro = $exc->getCode();   
    
    echo $mensagem = $exc->getMessage();
    
    
}
    
   




