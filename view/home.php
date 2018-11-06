<?php
    session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    
    use Core\Usuario;    
    try{        
        Usuario::verificarLogin(0);  // Vai estourar um erro se ele ja estiver logado, ou se ele nao for adm
        
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
        <div id="container">
           <section class="landing-dobra">
                <h1>Sua opinião é importante!</h1>
                <div>
                    <p>
                        O S.O.S Cidadão é a melhor maneira de ficar sabendo o que esta
                        acontecento em Barueri, compartilhe sua experiência na cidade com outras pessoas!
                    </p>
                    <a class="cta" href="cadastro.php">Eu quero participar</a>
                    <a href="login.php">ou faça login se já tem cadastro</a>
                </div>
                
           </section>
           <section class="landing-funcionalidades">
                <div class="landing-item" >
                    <div>
                        <img src="imagens/carapistola.jpg">
                    </div>
                    <h3>Reclamações</h3>
                    <p>
                    Uma reclamação é uma forma de expressar a insatisfação pública. 
                        Aqui no sos cidadão você pode mostrar sua opinião sobre o que acontece 
                        na cidade de Barueri e buscar uma solução para os problemas. 
                    </p>
                    <a class="cta">Tente agora mesmo!</a>
                </div>
                <div class="landing-item" >
                    <div>
                        <img src="imagens/pessaos-comunidade.jpg">
                    </div>
                    <h3>Colabore</h3>
                    <p>
                        Colabore com outros moradores! O sos cidadao é a melhor maneira de 
                        saber como andam as coisas em nossa cidade. Existem muitas maneiras
                        de se ajudar em conjunto, então compartilhe suas experiências.

                    </p>
                    <a class="cta">Participar</a>
                </div>                
           </section>
           <section class="landing-prefeitura">
                <h1>A prefeitura responde?</h1>
                <p>
                    A partir do momento em que estiver online, a Prefeitura tera a possibilidade de
                    responder a reclamação, daremos ela essa possibilidade, caso ela não queira sua
                    imagem manchada ela tera como responder de forma publica
                </p>
           </section>
           <footer class="landing-rodape">
                <h1>Não perca o que acontece na sua cidade</h1>
                <a class="cta" href="todasreclamacoes.php">ver agora</a>
           </footer>
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
            echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
            break;             
    }              
}