<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;  
    use Classes\ValidarCampos;
    try{    
        $tipoUsuPermi = array('Comum','Adm','Moderador','Prefeitura','Funcionario');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado  
        
        $nomesCampos = array('tipo');// Nomes dos campos que receberei do formulario
        $validar = new ValidarCampos($nomesCampos, $_GET);//Verificar se eles existem, se nao existir estoura um erro
?>

<html>
    <head>  
        <title>Editar Imagem</title>
    </head> 
    <body>
        <?php            
            echo '<a href="starter.php">Home</a>';        
        ?>
        <h1>Editar !!!</h1>        
            <form action="../UpdateImagem.php" method="post" enctype="multipart/form-data">  
                <?php 
                    if($_GET['tipo'] == 'capa' or $_SESSION['tipo_usu'] == 'Funcionario'){
                        echo '
                        <h1>Capa: </h1> 
                        <input type="file" name="imagem" accept="image/png, image/jpeg" />                         
                        ';
                    }else if($_SESSION['tipo_usu'] != 'Funcionario'){
                        echo '
                        <h1>Perfil: </h1>
                        <input type="file" name="imagem" accept="image/png, image/jpeg" />    
                        ';
                    }
                ?>   
                <input type="hidden" value="<?php echo $_GET['tipo']?>" name="tipo">
                <input type="submit" value="Editar !!!">
            </form>     
    </body>
</html>
<?php


    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 2:  
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
        }   
    }  
?>