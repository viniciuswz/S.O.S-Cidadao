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
    use Core\Publicacao;
    
    try{
        //Usuario::verificarLogin(1);  // Vai estourar um erro se ele ja estiver logado
        $publi = new Publicacao();
        //$publi->setCodUsu(1);
        //$publi->selectPubli();
        $publi->ListFromALL();
        //echo '<br><br><br>';
        //$publi->ListByIdUser();
?>
<html>
    <head>
        <title>Publicações</title>
    </head>
    <body>
        
    </body>
</html>

<?php
}catch (Exception $exc){
         
}

?>