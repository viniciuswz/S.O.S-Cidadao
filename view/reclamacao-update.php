<?php
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    use Core\Categoria;
    use Core\Publicacao;    
    use Classes\ValidarCampos;
    try{       
        $tipoUsuPermi = array('Comum','Adm','Moderador');
        Usuario::verificarLogin(1,$tipoUsuPermi);

        $dadosUrl = explode('/', $_GET['url']);
        
        if(count($dadosUrl) >= 3){ // ingetou parametros
            throw new \Exception('Não foi possível achar o debate',45);
        }else if(!isset($dadosUrl[1])){ // nao tem id
            throw new \Exception('Não foi possível achar o debate',25);
        }

        $_GET['ID'] = $dadosUrl[1];
        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL  
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero
        
        $tipoUsu = $_SESSION['tipo_usu'];        
        $publi = new Publicacao();        
        $publi->setCodUsu($_SESSION['id_user']);
        $publi->setCodPubli($_GET['ID']);
        $resposta = $publi->listByIdPubli(TRUE);// True = Tem q ser o dono da publicacao  
        $voltar = "../";
        $cate = new Categoria();
        $categorias = $cate->gerarOptions($resposta[0]['descri_cate']);   

        $dados = new Usuario();
        $dados->setCodUsu($_SESSION['id_user']);
        $resultado = $dados->getDadosUser();    
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>Editar Reclamação</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Aqui é onde você consegue editar a sua publicação!">
        <meta name=keywords content="Reclamação, Barueri"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI3A'>
        <meta name="theme-color" content="#089E8E" />

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="../view/imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="../view/css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="../view/css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="../view/css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="../view/css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="../view/css/style1025.css">

        <!-- JS-->

        <script src="../view/lib/_jquery/jquery.js"></script>
        <script src="../view/lib/_jquery/jquery.mask177.min.js"></script>
        <script src="../view/js/js.js"></script>
        <script src="../teste.js"></script>

        <script>
            $(document).ready(function(){
                $("#cep").mask("99999-999");
            });
        </script>
        <!-- cropp-->

        <link rel="stylesheet" href="../view/lib/_croppie-master/croppie.css">
        <script src="../view/lib/_croppie-master/croppie.js"></script>
        <script src="../view/lib/_croppie-master/exif.js"></script>
    </head>
    </head>
    <body>
        <header>
            <a href="../todasreclamacoes">
                <img src="../view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="../view/pesquisa" method="post" id="form-pesquisa">
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
                    <li><a href="../todasreclamacoes"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="../todosdebates"><i class="icone-debate"></i>Debates</a></li>
                </ul>
            </nav> 
            <?php
                if(!isset($resultado)){
                    echo '<a href="../view/login"><i class="icone-user" id="abrir"></i></a>';
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

            
            <form class="formulario reclamaForm" action="../UpdatePublicacao.php" method="POST" enctype="multipart/form-data" id="elenao">
            <!--FORMULARIO ENVIO TITULO E TEMA-->
                <div class="informacoes">
                    <h3>Informações importantes</h3>
                    <hr>
                        <div class="campo-envio">
                            <label for="titulo">Título<p></p></label>
                            <input type="text" id="titulo" name="titulo" placeholder="ex. arvore caidar" autocomplete="off" value="<?php echo $resposta[0]['titulo_publi']?>">
                            <span></span>
                
                    </div>

                    <div class="campo-envio">
                            <label for="cep">CEP<p></p></label>
                            <input type="text" id="cep" name="cep" placeholder="00000-000" value="<?php echo $resposta[0]['cep_logra']?>">
                            
                            <span></span>
                        </div>

                        <div class="campo-envio">
                            <label for="local">local<p></p></label>
                            <input type="text" id="input-disabled-local" name="local" placeholder="rua, Avenida..." autocomplete="off" value="<?php echo $resposta[0]['endere_logra']?> " disabled>
                            <input type="hidden" id="local" name="local" autocomplete="off" value="<?php echo $resposta[0]['endere_logra']?> " >
                            <span></span>
                        </div>

                        <div class="campo-envio">
                                <label for="bairro">Bairro<p></p></label>
                                <input type="text" id="input-disabled-bairro" name="bairro" placeholder="Parque dos Churros" autocomplete="off" value="<?php echo $resposta[0]['nome_bai']?> " disabled>
                                <input type="hidden" id="bairro" name="bairro" autocomplete="off" value="<?php echo $resposta[0]['nome_bai']?> " >
                                <span></span>
                            </div>
                </div>
                        
            <!--FORMULARIO ENVIO DA FOTO-->           
                <div class="imagem">
                            <h3>Escolha uma foto para a reclamação</h3>
                            <hr>
                        <div class="envio-img">
                            
                             <input type="file" accept="image/*" name="imagem" id="fotoReclamacao">
                            <label id="colocar-foto-reclamacao"><p><i class="icone-camera"></i>Escolha foto</p>
                            <input type="hidden" id="base64" name="base64" value="banana">
                        
                        <div>
                            <img src="../Img/publicacao/<?php echo $resposta[0]['img_publi']?>" id="imgPreview">
                        </div>
                    </label>
                    
                </div>
                <p></p>
                </div>
            <!-- FORMULARIO CATEGORIAS-->
                <div class="categorias">
                    <h3>Sobre o que vai reclamar?</h3>
                    <hr>
                    <p></p>
                    <div>
                            <?php
                                foreach($categorias as $valor){
                                    echo $valor;
                                }
                            ?>
                        <!--
                        <div>
                            <input type="radio" name="categoria" id="categoria-1" value="categoria1">
                            <label for="categoria-1"><i class="icone-mail"></i><span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span></label>
                        </div>
                        <div>   
                            <input type="radio" name="categoria" id="categoria-2" value="categoria2">
                            <label for="categoria-2"> <i class="icone-adm"></i><span>aaaaaaaaaaaaaa</span></label>
                        </div>
                        <div>
                            <input type="radio" name="categoria" id="categoria-1" value="categoria1">
                            <label for="categoria-1"><i class="icone-mail"></i><span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span></label>
                        </div>
                        <div>   
                            <input type="radio" name="categoria" id="categoria-2" value="categoria2">
                            <label for="categoria-2"> <i class="icone-adm"></i><span>aaaaaaaaaaaaaa</span></label>
                        </div>
                        <div>
                            <input type="radio" name="categoria" id="categoria-1" value="categoria1">
                            <label for="categoria-1"><i class="icone-mail"></i><span>aaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span></label>
                        </div>
                        <div>   
                            <input type="radio" name="categoria" id="categoria-2" value="categoria2">
                            <label for="categoria-2"> <i class="icone-adm"></i><span>aaaaaaaaaaaaaa</span></label>
                        </div>
                        -->
                    </div>
                </div>
            <!--FORMULARIO DESCRIÇÃO DO DEBATE--> 
                <div class="campo-texto"> 
                    <h3>sobre o que vai debater ?</h3>
                    <hr>
                    <textarea placeholder="escreva aqui" id="sobre" name="texto">
<?php echo trim($resposta[0]['texto_publi']) ?>
                    </textarea>
                    <input type="hidden" name="id_publi" value="<?php echo $_GET['ID']?>">
                    <p></p>
                    <input type="submit" value="alterar publicação" class="cta">
                </div>     
            </form>


        </div>
        <div class="modal-troca-foto-reclamacao">
            <div class="modal-troca-foto-reclamacao-fundo"></div>
            <div class="box-troca-foto-reclamacao">
                <div class="modal-titulo">
                    <h1>escolha uma foto para a reclamação</h1>
                    <span class="fechar-troca-foto-reclamacao">&times;</span>
                </div>
                <div class="img-reclamacao-corta">
                   <img src="">
                </div>
                <div>  
                <div class="aviso-form-inicial ">
                        <p>O campo tal e pa</p>
                    </div>               
                   
                        <label for="fotoReclamacao"><p>Escolher foto</p></label>
                    
                    <button id="cortarReclamacao">Cortar foto</button>
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
                echo "<script>javascript:window.location='login.php';</script>";
                break;
            case 6://Não é usuario comum  
                echo "<script>javascript:window.location='index.php';</script>";
            default:
                echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
                break;            
        }            
    }
?>
