<?php
session_start();
    $NomeArquivo = dirname(__FILE__);
    $posicao = strripos($NomeArquivo, "\Templates");
    if($posicao){
        $NomeArquivo = substr($NomeArquivo, 0, $posicao);
    }
    define ('WWW_ROOT', $NomeArquivo); 
    define ('DS', DIRECTORY_SEPARATOR);    
    require_once('../autoload.php');
    
    use Core\Usuario;
    try{
        Usuario::verificarLogin(2);  // Vai estourar um erro se ele nao estiver logado
        Usuario::verificarLogin(3);  // apenas user comum
?>

<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <form method="post" action="../EnviarDebate.php" enctype="multipart/form-data">
            <input type="text" name="titulo" placeholder="Titulo">
                <br />
            <input type="text" name="tema" placeholder="Tema">
                <br />
            <input type="file" name="imagem" accept="image/png, image/jpeg"/>
                <br />
            <textarea name="descricao" cols="75" rows="10" placeholder="Escreva uma descrição"></textarea>
                <br />
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>

<?php
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 2://Nao esta logado    
                echo "<script> alert('$mensagem');javascript:window.location='./loginTemplate.php';</script>";
                break;
            case 6://Não é usuario comum  
                echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
                break;            
        }        
    }
?>