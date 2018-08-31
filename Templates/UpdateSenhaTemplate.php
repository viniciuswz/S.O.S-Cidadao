<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    try{
        $tipoUsuPermi = array('Comum','Funcionario','Prefeitura','Moderador','Adm');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 
        echo '<a href="starter.php">Home</a>';     
?>
<form action="../updateSenha.php" method="post">
    <label>Senha Antiga:<input type="password" name="senhaAntiga"></label>
        <br>
    <label>Nova Senha:<input type="password" name="novaSenha"></label>
        <br>
    <input type="submit" value="Enviar">
</form>
<?php
    }catch (Exception $exc){
        if($exc->getCode() == 2){  // Se nao estiver logado
            $mensagem = $exc->getMessage();  
            echo "<script> alert('$mensagem');javascript:window.location='./loginTemplate.php';</script>";
        }        
    }
?>