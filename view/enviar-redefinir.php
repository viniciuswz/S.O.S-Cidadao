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
            throw new \Exception('Injetou parametros',45);
        }
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>E-mail redefinir senha</title>

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
        <?php
            if(isset($_SESSION['codigo_invalido'])){
                echo '<script>alerta("Errado","Código Inválido")</script>';
                unset($_SESSION['codigo_invalido']);
            }
        ?>
        <div class="form-cad" style="background-color:#009688">
                 <form action="" id="enviar-redefinir-senha" method="POST" style="padding: 40px 20px;">
                     <div class="tit-txt">
                        <h3 style="width:100%">Troque sua senha</h3>
                        <p>Digite seu e-mail de usuário, vamos te enviar um link para digitar uma nova senha.</p>
                    </div>
                     <div class="campo-texto-icone">
                        <label for="email"><i class="icone-mail"></i></label>
                        <input type="email" name="email" id="email" placeholder="E-mail">
                     </div>
                      
                     
                     <div class="aviso-form-inicial">
                         <p>O campo tal e pa</p>
                     </div>
                     <button type="submit">Redefinir senha</button>
                     
                 </form>
        </div>

     </div>
     <div class="email-ok">
        
        <div>
            <img src="view/imagens/emailok.svg" alt="email">
            <h1>Vamos entrar em contato</h1>
            <p>Enviamos um e-mail para você com instruções de como redefinir a sua senha.</p>
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