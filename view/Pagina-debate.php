<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;    
    use Core\Debate;
    use Classes\ValidarCampos;
    try{        
        $debate = new Debate();        

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $debate->setCodUsu($_SESSION['id_user']);            
            $tipoUsu = $_SESSION['tipo_usu'];
        }

        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero        

        $debate->setCodDeba($_GET['ID']);        
        $resposta = $debate->listByIdDeba();   
        
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
        <header>
            <img src="imagens/Ativo2.png" alt="logo">
            <form>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
                <button type="submit"><i class="icone-pesquisa"></i></button>
            </form>
            <nav class="menu">
                <ul>
                    <li><nav class="notificacoes">
                        <h3>notificações</h3>
                        <ul>
                            <li>
                                <a href="#">
                                <div><i class="icone-comentario"></i></div>
                                <span class="">
                                    <span class="negrito">Corno do seu pai</span> , <span class="negrito">Rogerinho</span><span> E outras 4 pessoas comentaram na sua publicação</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-like-full"></i></div>
                                <span class="">
                                    <span class="negrito">Corno do seu pai</span> , <span class="negrito">Rogerinho</span><span> E outras 4 pessoas curtiram sua publicação aaaaaaaaaaaaaaaaaaa</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri" aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"cortaram meu pau por acidente no SAMEB era só marca de batom quero meu pau de voltaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"quero café"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                        </ul>
                    </nav><a href="#" id="abrir-not"><i class="icone-notificacao"><span>99+</span></i>Notificações</a></li>
                    <li><a href="todasreclamacoes.php"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="todosdebates.php"><i class="icone-debate"></i>Debates</a></li>
                </ul>
            </nav>
            <i class="icone-user" id="abrir"></i>
        </header>
        <div class="user-menu">
            <a href="javascript:void(0)" class="fechar">&times;</a>
            <div class="mini-perfil">
                <div>    
                    <img src="imagens/perfil.jpg" alt="perfil">
                </div>    
                    <img src="imagens/capa.png" alt="capa">
                    <p>Pericles</p>
            </div>
            <nav>
                <ul>
                    <li><a href="#"><i class="icone-user"></i>Meu perfil</a></li>
                    <li><a href="#"><i class="icone-salvar"></i>Salvos</a></li>
                    <hr>
                    <li><a href="#"><i class="icone-adm"></i>Area de administrador</a></li>
                    <li><a href="#"><i class="icone-salvar"></i>Area da prefeitura </a></li>
                    <hr>
                    <li><a href="#"><i class="icone-config"></i>Configurações</a></li>
                    <li><a href="#"><i class="icone-logout"></i>Log out</a></li>

                </ul>
            </nav>
        </div>

        <div id="container">
                <section class="pag-debate">
                    <div class="debate">   
                        <div class="publicacao-topo-aberta">
                            <div>
                                <img src="../Img/perfil/<?php echo $resposta[0]['img_perfil_usu']?>">
                            </div>
                            <p><span class="negrito"><?php echo $resposta[0]['nome_usu']?></span><time><?php echo $resposta[0]['dataHora_deba']?></time></p>
                            <div class="mini-menu-item ">
                                
                            <i class="icone-3pontos"></i>
                                <div>
                                    <ul>
                                        <li><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>
                                        <li><a href="#"><i class="icone-fechar"></i></i>Remover</a></li>
                                        <li><a href="#"><i class="icone-edit-full"></i></i>Alterar</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="publicacao-conteudo-debate">
                            <img src="../Img/debate/<?php echo $resposta[0]['img_deba']?>">
                        </div>        
                    </div>
                    <div class="debate-publicacao">    
                        <h3><?php echo $resposta[0]['nome_deba']?></h3>
                        <div> 
                            <p>
<?php  echo nl2br($resposta[0]['descri_deba'])?>
                            </p>
                        </div>

                        <div class="debate-status">
                            <div>
                               <i class="icone-grupo"></i><span><span class="negrito"><?php echo $resposta[0]['qtdParticipantes']?></span> participante(s)</span>
                            </div>
                            <div>
                                <i class="icone-categoria-debate"></i><span><?php echo $resposta[0]['tema_deba']?></span>
                            </div>
                        </div>   
                            <a href="#">Entrar no debate</a>
                    </div>
                    
        
                    </section>
                    
        </div>
    </body>
</html>
<?php


    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 9://Não foi possivel achar a publicacao  
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarDebatesTemplate.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarDebatesTemplate.php';</script>";
        }   
    }  
?>