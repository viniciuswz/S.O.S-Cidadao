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
        Usuario::verificarLogin(0); // Nao pode estar logado
?>

<html>
    <head>
        <title>Login</title>
    </head>
    <body>
        <form method="post" action="../Login.php">
            <label>Email: <input type="email" name="email" required></label>
                <br>
            <label>Senha: <input type="password" name="senha" required></label>
                <br>
            <input type="submit" value="Enviar">
        </form>
    </body>
</html>

<?php
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();
        switch($erro){
            case 2://Ja esta logado   
                echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
                break;
           
        }         
    }
?>