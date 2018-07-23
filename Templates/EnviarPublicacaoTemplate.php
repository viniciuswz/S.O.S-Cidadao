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
    use Core\Categoria;
    try{
        Usuario::verificarLogin(2);  // Tem q estar logado, todos tem permissao
        Usuario::verificarLogin(3); // Apenas user comum pode entrar aqui
        $cate = new Categoria();
        $categorias = $cate->gerarOptions();   
?>

<html>
    <head>
        <title>Formulario publicacao</title>
    </head>
    <body>
        <form action="../enviarPublicacao.php" method="post" enctype="multipart/form-data">
            <label>Titulo: <input type="text" name="titulo"></label>
                <br >
            <label>Local: <input type="text" name="local"></label>
                <br >
            <label>Bairro: <input type="text" name="bairro"></label>
                <br >
            <label>Cep: <input type="text" name="cep"></label>
                <br >
            <input type="file" name="imagem" accept="image/png, image/jpeg"/>
                <br />
            <select name="categoria">
                <?php
                    foreach($categorias as $valor){
                        echo $valor;
                    }
                ?>
            </select>
                <br>
            <textarea name="texto"></textarea>
                <br>
            <input type="submit" value="Enviar">
        </form>
    </body>    
</html>

<?php
    }catch (Exception $exc){
        $mensagem = $exc->getMessage();  
        if($exc->getCode() == 2){  // Se nao ja estiver logado
            echo "<script> alert('$mensagem');javascript:window.location='./loginTemplate.php';</script>";
        }    
        if($exc->getCode() == 6){  // Se for qualquer usuario q nao seja comum
            echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
        }       
    }finally{
    
    }
?>