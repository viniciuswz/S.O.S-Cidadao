<?php
    session_start();    
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    use Classes\ValidarCampos;
    try{        
        $tipoUsuPermi = array('Comum','Moderador','Adm','Prefeitura');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 

        $nomesCampos = array('indNovaConta');//verificar se a conta é nova
        $validar = new ValidarCampos($nomesCampos, $_SESSION);//Verificar se eles existem, se nao existir estoura um erro
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
        <meta name="theme-color" content="#089E8E" />

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


 
           
        <section class="agradecimento">
           
                <div>   
                    <div>
                        <img src="imagens/TOPO.png" >
                        <h2>Bem vindo ao SOS Cidadão!</h2>
                        <p>Agora você faz parte do povo e poderá contribuir com a cidade, envie sua reclamação, ou crie um debate!</p> 
                    </div> 
                   

                    <a href="perfil_reclamacao.php">Continuar</a>
                </div> 
           

        </section>

        
    </body>
</html>
<?php
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Não está logado  
            echo "<script>javascript:window.location='login.php';</script>";
            break; 
        case 6://Ja esta logado 
            echo "<script>javascript:window.location='index.php';</script>";
            break;
        case 11:// Erro no comentario
        case 12://Mexeu no insprnsionar elemento ou nao submeteu o formulario      
            echo "<script>javascript:window.location='index.php';</script>";
            break;             
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
    } 
}