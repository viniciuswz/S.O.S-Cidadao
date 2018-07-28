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
        Usuario::verificarLogin(1);  // Vai estourar um erro se ele ja estiver logado
?>
<html>
    <form action="../CadastrarUser.php" method="post">
        <label>Nome: <input type="text" name="nome" required></label>
            <br/>       
        <label>Email: <input type="email" name="email" required></label>
            <br/>  
        <label>Senha: <input type="password" name="senha" required></label>
            <br/>
        <input type="submit" value="Enviar">
    </form>
</html>
<?php
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();

    switch($erro){
        case 2://Se ja estiver logado   
            echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
            break;         
    }    
          
}