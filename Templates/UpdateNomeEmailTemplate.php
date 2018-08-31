<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    try{
        $tipoUsuPermi = array('Comum','Funcionario','Prefeitura','Moderador','Adm');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado
       $usuario = new Usuario();
       $usuario->setCodUsu($_SESSION['id_user']);
       $dados = $usuario->getDadosUser();  
       echo '<a href="starter.php">Home</a>';     
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
    }
?>