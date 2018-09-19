<?php
session_start();    
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
       
    use Core\Usuario;
    try{        
        Usuario::verificarLogin(0); // Nao pode estar logado
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>S.O.S Cidadão</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Site de reclamações para a cidade de Barueri">
        <meta name=keywords content="Reclamação, Barueri"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI3A'>

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="css/style1025.css">

        <!-- JS-->

        <script src="lib/_jquery/jquery.js"></script>
        <script src="js/js.js"></script>

    </head>
    <body>
           <div class="form-icone">
               <section>
                   <div>
                   <h1>S.O.S Cidadão</h1>
                   <p>conecte-se com a nossa comunidade e colabore</p>
                   </div>                   
                    <form action="../Login.php" id="login" method="POST">
                        <h3>login</h3>
                        <div class="campo-texto-icone"  >
                            <label for="email" ><i class="icone-mail"></i></label>
                            <input type="email" name="email" id="email" placeholder="E-mail">

                        </div>
                        <div class="campo-texto-icone">
                            <label for="senha"><i class="icone-senha"></i></label>
                            <input type="password" name="senha" id="senha" placeholder="Senha">
                        </div>
                        <div class="aviso-form-inicial">
                            <p>O campo tal e pa</p>
                        </div>
                        <button type="submit">login</button>

                    </form>
               </section>                
           </div>        
    </body>
</html>
<?php
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();
        switch($erro){
            case 2://Ja esta logado  
            case 6://Ja esta logado 
                echo "<script> alert('$mensagem');javascript:window.location='home.php';</script>";
                break;
           
        }         
    }
?>