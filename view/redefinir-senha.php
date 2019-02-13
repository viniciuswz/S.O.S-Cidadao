<?php
    if(!file_exists('Config/Config.php')){        
        echo "<script>javascript:window.location='todasreclamacoes';</script>";       
    }
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');  
    use Core\Usuario;    
    try{        
        Usuario::verificarLogin(0);  // Vai estourar um erro se ele ja estiver logado, ou se ele nao for adm
        $dadosUrl = explode('/', $_GET['url']);
        if(count($dadosUrl) > 1){ // injetou parametros
            throw new \Exception('Não foi possível achar o debate',45);
        }
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>Redefinir senha</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Esqueceu a sua senha?">
        <meta name=keywords content="Reclamação, Barueri, Cadastro, Novo Usuário, Reclamar"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI3A'>

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="view/imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="view/css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="view/css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="view/css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="view/css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="view/css/style1025.css">

        <!-- JS-->

        <script src="view/lib/_jquery/jquery.js"></script>
        <script src="view/js/js.js"></script>

    </head>
    <body>
    <div id="container">
        <div class="form-cad" style="background-color:#009688">
                 <form action="" id="" method="POST">
                     <h3>Redefinir senha</h3>
                     
                     <div class="campo-texto-icone">
                             <label for="senha"><i class="icone-senha"></i></label>
                             <input type="password" name="senha" id="senha" placeholder="Nova senha">
                     </div>
                     <div class="campo-texto-icone">
                             <label for="senhaC"><i class="icone-senha"></i> </label>
                             <input type="password" name="senhaC" id="senhaC" placeholder="Confirmar senha">
                     </div>
                     <div class="aviso-form-inicial">
                         <p>O campo tal e pa</p>
                     </div>
                     <button type="submit">Alterar senha</button>
                     
                 </form>
        </div>

     </div>
</body>
</html>
<?php
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Se ja estiver logado   
        case 6://nao  tem permissao de adm
            echo "<script>javascript:window.location='todasreclamacoes';</script>";
            break;
        case 45://Digitou um numero maior de parametros 
            unset($dadosUrl[0]);
            $contador = 1;
            $voltar = "";
            while($contador <= count($dadosUrl)){
                $voltar .= "../";
                $contador++;
            }
            echo "<script>javascript:window.location='".$voltar."cadastro';</script>";
            break;
    }              
}