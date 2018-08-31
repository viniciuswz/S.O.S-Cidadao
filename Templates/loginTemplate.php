<?php
session_start();    
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
       
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
            case 6://Ja esta logado 
                echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
                break;
           
        }         
    }
?>