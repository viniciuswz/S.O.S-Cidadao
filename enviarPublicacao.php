<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');
use Core\Publicacao;
use Core\Usuario;
use Classes\ValidarCampos;
session_start();
  
try{                     
    $tipoUsuPermi = array('Comum');
    Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado
         

    $nomesCampos = array('titulo', 'categoria','texto','cep','bairro','local');// Nomes dos campos que receberei do formulario
    $validar = new ValidarCampos($nomesCampos, $_POST);//Verificar se eles existem, se nao existir estoura um erro
    $validar->verificarTipoInt(array('categoria'), $_POST); 
    
    $publicacao = new Publicacao();
    $publicacao->setTituloPubli($_POST['titulo']);
    $publicacao->setCodCate($_POST['categoria']);
    $publicacao->setTextoPubli($_POST['texto']);
    $publicacao->setCepLogra($_POST['cep']);
    $publicacao->setCodUsu($_SESSION['id_user']);
    if(isset($_FILES['imagem']) AND !empty($_FILES['imagem']['name'])){
        $publicacao->setImgPubli($_POST['base64']);
    }            
    $publicacao->cadastrarPublicacao($_POST['bairro'], $_POST['local']);

    //$baseFromJavascript = "data:image/png;base64,BBBFBfj42Pj4"; // $_POST['base64']; //your data in base64 'data:image/png....';
    // We need to remove the "data:image/png;base64,"
    //$base_to_php = explode(',', $_POST["base64"]);
    // the 2nd item in the base_to_php array contains the content of the image
    //$data = base64_decode($base_to_php[1]);
    // here you can detect if type is png or jpg if you want
    //$filepath = "/path/to/my-files/image.png"; // or image.jpg
    
    // Save the image in a defined path
    //file_put_contents("/Img/Capa/.'image.jpg'",$data.".png");

    // define('UPLOAD_DIR', 'Img/publicacao/');
    // $img = $_POST['base64'] . 'asdfasdf';
    // $img = str_replace('data:image/png;base64,', '', $img);
    // $img = str_replace(' ', '+', $img);
    // $data = base64_decode($img);
    // $file = UPLOAD_DIR . uniqid() . '.png';
    // $success = file_put_contents($file, $data);
    // print $success ? $file : 'Unable to save the file.';

    $idPubli = $publicacao->last(); 
    echo "<script> alert('Publicacao enviada com sucesso');javascript:window.location='./view/reclamacao.php?ID=".$idPubli."';</script>";
        
}catch(Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Nao esta logado    
            echo "<script> alert('$mensagem');javascript:window.location='./view/loginTemplate.php';</script>";
            break;
        case 6://Não é usuario comum  
            echo "<script> alert('$mensagem');javascript:window.location='./view/starter.php';</script>";
            break;
        case 8:// Se der erro ao cadastrar
        case 12://Mexeu no insprnsionar elemento
            echo "<script> alert('$mensagem');javascript:window.location='./view/Formulario-reclamacao.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='./view/Formulario-reclamacao.php';</script>";
    }   
            
            
}    



