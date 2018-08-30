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
        $tipoUsuPermi = array('Comum','Funcionario','Prefeitura','Moderador','Adm');
        Usuario::verificarLogin(1,$tipoUsuPermi);
        
        echo '<a href="starter.php">Home</a>';  
?>
<html>
    <head>
        <title>Editar Perfil</title>
    </head>
    <body>
    <br>
        <a href="UpdateNomeEmailTemplate.php">Update Email e Nome</a>
          <br>
        <a href="UpdateSenhaTemplate.php">Update Senha</a>
          <br>
        <?php
            if($_SESSION['tipo_usu'] == 'Funcionario'){
                echo '<a href="UpdateImagemTemplate.php?tipo=capa">Update Imagem de Capa</a>';
            }else{
                echo '<a href="UpdateImagemTemplate.php?tipo=capa">Update Imagem de Capa</a>';
                    echo '<br>';
                echo '<a href="UpdateImagemTemplate.php?tipo=perfil">Update Imagem Perfil</a>';
            }
        ?>
        
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