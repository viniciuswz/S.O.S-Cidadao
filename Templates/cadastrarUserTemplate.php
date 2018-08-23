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
        $tipoUsuPermi = array('Adm');
        Usuario::verificarLogin(0,$tipoUsuPermi);  // Vai estourar um erro se ele ja estiver logado, ou se ele nao for adm

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){ // Aqui so vai entrar adm, por causa do Usuario::verificarLogin
            // ou seja ou ele nao vai estar logado, ou ele vai ser adm
            $indUsu = 'Adm';
        }
?>
<html>
    <form action="../CadastrarUser.php" method="post">
        <label>Nome: <input type="text" name="nome" required></label>
            <br/>       
        <label>Email: <input type="email" name="email" required></label>
            <br/>  
        <label>Senha: <input type="password" name="senha" required></label>
            <br/>
        <?php if(isset($indUsu)){
                echo '
                    <input type="radio" id="dewey" name="tipo" value="Prefeitura" />
                    <label for="dewey">Prefeitura</label>   
                        <br>
                    <input type="radio" id="dewey" name="tipo" value="Comum" />
                    <label for="dewey">Comum</label>   
                        <br>
                    <input type="radio" id="dewey" name="tipo" value="Adm" />
                    <label for="dewey">Adm</label>   
                        <br>
                    <input type="radio" id="dewey" name="tipo" value="Moderador" />
                    <label for="dewey">Moderador</label>   
                        <br>
                    
                
                
                ';    
        }    
            ?>   
        <input type="submit" value="Enviar">
    </form>
</html>
<?php
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();

    switch($erro){
        case 2://Se ja estiver logado   
        case 6://nao  tem permissao de adm
            echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
            break;  
           
    }    
          
}