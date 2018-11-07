<?php
    session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
        
    use Core\Usuario;
    try{
        $tipoUsuPermi = array('Comum');        
        Usuario::verificarLogin(1,$tipoUsuPermi);  // 1 = tem q estar logado
        
        $dados = new Usuario();
        $dados->setCodUsu($_SESSION['id_user']);
        $resultado = $dados->getDadosUser();    
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
        <script src="../teste.js"></script>

        <!-- cropp-->

        <link rel="stylesheet" href="lib/_croppie-master/croppie.css">
        <script src="lib/_croppie-master/croppie.js"></script>
        <script src="lib/_croppie-master/exif.js"></script>

    </head>
    <body>
        <header>
            <img src="imagens/logo_oficial.png" alt="logo">
            <form action="pesquisa.php" method="get">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
                <button type="submit"><i class="icone-pesquisa"></i></button>
            </form>
            <nav class="menu">
                <ul>
                    <li><nav class="notificacoes">
                        <h3>notificações<span id="not-fechado"></span></h3>
                        <ul id="menu23">
                            
                            <li>
                        </ul>
                    </nav><a href="#" id="abrir-not"><i class="icone-notificacao" id="noti"></i>Notificações</a></li>
                    <li><a href="todasreclamacoes.php"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="todosdebates.php"><i class="icone-debate"></i>Debates</a></li>
                </ul>
            </nav>  
            <?php
                if(!isset($resultado)){
                    echo '<a href="login.php"><i class="icone-user" id="abrir"></i></a>';
                }else{
                    echo '<i class="icone-user" id="abrir"></i>';
                }
            ?>
        </header>
        <?php
            if(isset($resultado) AND !empty($resultado)){  
        ?>
                <div class="user-menu">
                    <a href="javascript:void(0)" class="fechar">&times;</a>
                    <div class="mini-perfil">
                        <div>    
                            <img src="../Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>" alt="perfil">
                        </div>    
                            <img src="../Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
                            <p><?php echo $resultado[0]['nome_usu'] ?></p>
                    </div>
                    <nav>
                        <ul>
                            <?php
                            require_once('opcoes.php');                        
                            ?>
                        </ul>
                    </nav>
                </div>
        <?php
            }
        ?>

        <div id="container">

   
            <form class="formulario" name="envio debate" method="post" action="../EnviarDebate.php" enctype="multipart/form-data">
                <!--FORMULARIO ENVIO TITULO E TEMA-->
                <div class="informacoes">
                    <h3 id="bacon">Informações importantes</h3>
                    <hr>
                        <div class="campo-envio">
                            <label for="titulo">Título<p></p></label>
                            <input type="text" id="titulo" name="titulo" placeholder="fora temer" autocomplete="off">
                            <span></span>
                
                    </div>
                        
                        <div class="campo-envio">
                            <label for="tema">Tema<p></p></label>
                            <input type="text" id="tema" name="tema" placeholder="algum tema ai" autocomplete="off">
                            <span></span>
                
                        </div>
                    </div>
                            
                    <!--FORMULARIO ENVIO DA FOTO-->           
                    <div class="imagem">
                        <h3>Escolha uma foto para o debate</h3>
                        <hr>
                        <div class="envio-img">
                                            
                            <input type="file" id="imagemDebateInput">
                            <label id="abrir-cortar"><p><i class="icone-camera"></i>Escolha foto</p>
                            <input type="hidden" id="base64" name="base64" value="banana">
                                
                        <div>
                            <img src="imagens/capa.png" id="imgPreview">
                        </div>
                            </label>
                        </div>
                        <p></p>
                    </div>
                                
                    <!--FORMULARIO DESCRIÇÃO DO DEBATE--> 
                        <div class="campo-texto"> 
                            <h3>sobre o que vai debater ?</h3>
                        
                        <hr>
                    
                        
                            <textarea placeholder="escreva aqui" id="sobre" name="descricao"></textarea>
                                <p></p>
                                <input type="submit" value="iniciar debate" class="cta">
                    
                        </div>     
            </form>

 

        </div>
        <div class="modal-troca-foto-reclamacao">
            <div class="modal-troca-foto-reclamacao-fundo"></div>
            <div class="box-troca-foto-reclamacao">
                <div class="modal-titulo">
                    <h1>escolha uma foto para o debate</h1>
                    <span class="fechar-troca-foto-reclamacao">&times;</span>
                </div>
                <div class="img-reclamacao-corta">
                   <img src="">
                </div>
                <div>  
                <div class="aviso-form-inicial ">
                    <p>O campo tal e pa</p>
                </div>               
                   
                        <label for="imagemDebateInput"><p>Escolher foto</p></label>
                    
                    <button id="cortarDebate">Cortar foto</button>
                </div>
            </div>
        </div> 

        <div class="modal-troca-foto-reclamacao-previa">
            <div class="modal-troca-foto-reclamacao-previa-fundo"></div>
            <div class="box-troca-foto-reclamacao-previa">
                <div>
                    <h1>Gostou?</h1>
                    <span class="fechar-troca-foto-reclamacao-previa">&times;</span>
                </div>
                <div>                 
                    <img src="" class="previewReclamacao" style="width: 100%">
                    <button class="alterar-reclamacao">Gostei</button>

                    <button class="outra-reclamacao">tentar de novo</button>
                </div>
            </div>
        </div>
        <script>
            
            var largura= $(document).width();
            if(largura < 420){
                var tela= $(document).width();
            }else{
                var tela= 420
            }
            
            var  $uploadCropReclamacao = $('.img-reclamacao-corta').croppie({
                
                enableExif: true,
                enforceBoundary:true,
                enableOrientation:true,
                enableResize:false,
                viewport: {
                    width: 280,
                    height: 190,
                    
                },
                boundary: {
                    width: tela,
                    height: 300
                },
            });
        </script> 
    </body>
</html>
<?php
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 2://Nao esta logado   
                echo "<script> alert('$mensagem');javascript:window.location='login.php';</script>";
                break;
            case 6://Não é usuario comum                 
                echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
                break;            
        }        
    }
?>
 