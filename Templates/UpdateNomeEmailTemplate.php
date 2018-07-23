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
       Usuario::verificarLogin(2);  // Tem q estar logado, todos tem permissao
       $usuario = new Usuario();
       $usuario->setCodUsu($_SESSION['id_user']);
       $dados = $usuario->getDadosUser();       
?>
<form action="../updateNomeEmail.php" method="post">
    <label>Nome:<input type="text" name="nome" value="<?php echo $dados[0]['nome_usu'] ?>"></label>
        <br>
    <label>Email:<input type="text" name="email" value="<?php echo $dados[0]['email_usu'] ?>"></label>
        <br>
    <input type="submit" value="Enviar">
</form>
<?php
    }catch (Exception $exc){
        if($exc->getCode() == 2){  // Se nao  estiver logado
            $mensagem = $exc->getMessage();  
            echo "<script> alert('$mensagem');javascript:window.location='./loginTemplate.php';</script>";
        }        
    }finally{
    
    }
?>