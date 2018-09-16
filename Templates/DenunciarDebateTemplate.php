<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    use Classes\ValidarCampos;
    try{        
        $tipoUsuPermi = array('Comum','Prefeitura','Funcionario');
        Usuario::verificarLogin(1,$tipoUsuPermi);
        
        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero   
        echo '<a href="starter.php">Home</a>';     
?>

<html>
    <head>
        <title>Denunciar Debate</title>
    </head>
    <body>
        <form method="post" action="../DenunciarDebate.php">
            <textarea type="text" name="texto" required cols="75" rows="10" placeholder="Escreva uma descrição"></textarea>
                <br>
            <input type="hidden" name="id_deba" value="<?php echo $_GET['ID'] ?>">                
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
                echo "<script> alert('$mensagem');javascript:window.location='starter.php';</script>";
                break;
            case 6: // Não esta autorizado
            case 12://Mexeu no insprnsionar elemento, ou mexeu no valor do id           
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarDebatesTemplate.php';</script>";
            break; 
           
        }         
    }
?>