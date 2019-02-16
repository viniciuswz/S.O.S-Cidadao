<?php
    if(!file_exists('Config/Config.php')){        
        echo "<script>javascript:window.location='todasreclamacoes';</script>";       
    }
    session_start();    
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');       
    use Core\Usuario;
    try{        
        Usuario::verificarLogin(0); // Nao pode estar logado
        $dadosUrl = explode('/', $_GET['url']);
        if(count($dadosUrl) > 1){ // injetou parametros
            throw new \Exception('Não foi possível achar o debate',45);
        }
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>Login</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Faça um login para interagir com nossa comunidade!">
        <meta name=keywords content="Reclamação, Barueri, login, Reclamar"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI3A'>
        <meta name="theme-color" content="#089E8E" />

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
    <body class="login-bg">
            <?php
                if(isset($_SESSION['recuperar_senha']) AND $_SESSION['recuperar_senha'] == 1){
                    echo '<script>alerta("Certo","Senha Atualizada")</script>';
                    unset($_SESSION['recuperar_senha']);
                }
            ?>
           <div class="form-icone">
               <section>
                   <div>
                   <h1>S.O.S Cidadão</h1>
                   <p>conecte-se com a nossa comunidade e colabore</p>
                   </div>
                   
                    <form id="login" method="POST">
                        <h3>login</h3>
                        <div class="campo-texto-icone"  >
                            <label for="email" ><i class="icone-mail"></i></label>
                            <input type="email" name="email" id="email" placeholder="E-mail">
                        </div>
                        <div class="campo-texto-icone">
                            <label for="senha"><i class="icone-senha"></i></label>
                            <input type="password" name="senha" id="senha" placeholder="Senha">
                        </div>
                        
                        <div class="aviso-form-inicial ">
                            <p>O campo tal e pa</p>
                        </div>

                        <button type="submit">login</button>
                        <span>
                            <a href="enviar-redefinir" style="font-weight:bold">Recuperar senha</a>
                            <a href="cadastro" >Sem conta? <strong>Inscreva-se!</strong></a>
                        </span>
                        

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
                echo "<script>javascript:window.location='home';</script>";
                break;           
            case 45://Digitou um numero maior de parametros 
                unset($dadosUrl[0]);
                $contador = 1;
                $voltar = "";
                while($contador <= count($dadosUrl)){
                    $voltar .= "../";
                    $contador++;
                }
                echo "<script>javascript:window.location='".$voltar."login';</script>";
            break;
        }         
    }
?>