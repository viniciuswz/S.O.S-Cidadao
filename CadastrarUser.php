<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
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
        $hora = $usuario->tratarData($usuario->getDataHoraCadastro());
        echo '1.' . $usuario->last() . ',' . $hora;
        //echo "<script> alert('Cadastro realizado com sucesso!!!');javascript:window.location='./view/admin-moderador.php?tipo[]=Moderador&tipo[]=Prefeitura';</script>";
    }else if($resultado == 2){
        $hora = $usuario->tratarData($usuario->getDataHoraCadastro());
        echo '2.' . $usuario->last() . ',' . $hora;;
        //echo "<script> alert('Funcionario cadastrado com sucesso!!!');javascript:window.location='./view/prefeitura-admin.php';</script>";
    }else{ // Usuario nao cadastrado
        //echo "<script> alert('Cadastro realizado com sucesso!!!');javascript:window.location='./view/Pagina-agradecimento.php';</script>";
        echo 1;
    }
    
    
       
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Esta logado 
        case 6://Esta logado 
           echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
            break;       
        case 3://Erro ao cadastrar usuario
            echo $mensagem;
            break;
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario
            echo "<script> alert('$mensagem');javascript:window.location='cadastro';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='login';</script>";
    }    
    
}


