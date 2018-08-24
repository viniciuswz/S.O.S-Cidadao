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
    Use Core\Comentario;
    try{
        $tipoUsuPermi = array('Comum','Funcionario','Prefeitura');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado

        $nomesCampos = array('ID','IDPubli');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero

        $comentario = new Comentario();
        $comentario->setCodPubli($_GET['IDPubli']);
        $comentario->setCodComen($_GET['ID']);
        $comentario->setCodUsu($_SESSION['id_user']);        
        $dadosComentario = $comentario->getDadosComenByIdComen();       
         
       echo '<a href="starter.php">Home</a>';     
?>

 <form action="../UpdateComentario.php" method="post">
    <h1>Editar!!:</h1>
    <textarea cols="70" rows="5" name="texto">
<?php echo trim($dadosComentario[0]['texto_comen']) ?>
    </textarea>
    <input type="hidden" value="<?php echo $_GET['ID'] ?>" name="id">
    <input type="submit" value="Enviar">
</form>  

<?php
        
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();

        switch($erro){

        case 2://Esta logado 
        case 6://Esta logado 
           echo "<script> alert('$mensagem');javascript:window.location='starter.php';</script>";
            break;   
            case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script> alert('$mensagem');javascript:window.location='starter.php';</script>";
            break;        
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='starter.php';</script>";    
    }
}

    
?>