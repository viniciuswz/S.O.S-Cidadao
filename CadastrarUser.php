<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR); 
require_once(WWW_ROOT.DS.'autoload.php');//
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
try{        
    $tipoPermi = array('Adm','Prefeitura');
    Usuario::verificarLogin(0,$tipoPermi);//Nao pode estar logado ou for adm
    
    $nomesCampos = array('nome', 'email','senha');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro
   
    $tipoUsu = isset($_SESSION['tipo_usu']) ? $_SESSION['tipo_usu'] : false;
    $usuario = new Usuario();    
    $usuario->setNomeUsu($_POST['nome']);
    $usuario->setEmail($_POST['email']);
    $usuario->setSenha($usuario->gerarHash($_POST['senha']));// gerar hash da senha   
    if(isset($_POST['tipo'])){
        $usuario->setDescriTipoUsu($_POST['tipo']);
    }else{
        $usuario->setDescriTipoUsu('comum');
    }   
    $resultado = $usuario->cadastrarUser($tipoUsu);        
   
    //Pra disparar email ele vai aqui
    if($resultado == 1){ // Adm q cadastrou
        echo "<script> alert('Cadastro realizado com sucesso!!!');javascript:window.location='./Templates/VerUsuariosTemplate.php?tipo1=Adm&tipo2=Moderador&tipo3=Prefeitura&tipo4=Funcionario';</script>";
    }else if($resultado == 2){
        echo "<script> alert('Funcionario cadastrado com sucesso!!!');javascript:window.location='./Templates/VerFuncionariosTemplate.php';</script>";
    }else{ // Usuario nao cadastrado
        echo "<script> alert('Cadastro realizado com sucesso!!!');javascript:window.location='./Templates/starter.php';</script>";
    }
    
    
       
}catch (Exception $exc){
    $erro = $exc->getCode();   
    echo $mensagem = $exc->getMessage();

    switch($erro){
        case 2://Esta logado 
        case 6://Esta logado 
           echo "<script> alert('$mensagem');javascript:window.location='./Templates/starter.php';</script>";
            break;       
        case 3://Erro ao cadastrar usuario
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/cadastrarUserTemplate.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./Templates/loginTemplate.php';</script>";
    }    
    
}


