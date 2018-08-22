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
    use Classes\ValidarCampos;
    try{        
        $tipoUsuPermi = array('Comum','Prefeitura','Funcionario');
        Usuario::verificarLogin(1,$tipoUsuPermi);
        $nomesCampos = array('ID','IDPubli','pagina');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero        
?>

<html>
    <head>
        <title>Denunciar Publicacao</title>
    </head>
    <body>
        <form method="post" action="../DenunciarComentario.php">
            <textarea type="text" name="texto" required cols="75" rows="10" placeholder="Escreva uma descrição"></textarea>
                <br>
            <input type="hidden" name="id_comen" value="<?php echo $_GET['ID'] ?>">  
            <input type="hidden" name="id_publi" value="<?php echo $_GET['IDPubli'] ?>"> 
            <input type="hidden" name="pagina" value="<?php echo $_GET['pagina'] ?>">              
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
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
            break; 
           
        }         
    }
?>