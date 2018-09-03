<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    use Core\Publicacao;
    use Core\Comentario;
    use Core\PublicacaoSalva;
    use Classes\ValidarCampos;
    try{        
        $publi = new Publicacao();
        $comentario = new Comentario();
       
        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $publi->setCodUsu($_SESSION['id_user']);
            $comentario->setCodUsu($_SESSION['id_user']);
            
            $publiSalva = new PublicacaoSalva();
            $publiSalva->setCodUsu($_SESSION['id_user']);
            $publiSalva->setCodPubli($_GET['ID']);  
            $indSalva = $publiSalva->indSalva();

            $dados = new Usuario();
            $dados->setCodUsu($_SESSION['id_user']);
            $resultado = $dados->getDadosUser();

            $tipoUsu = $_SESSION['tipo_usu'];            
        }

        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero
        
        $publi->setCodPubli($_GET['ID']);
        $comentario->setCodPubli($_GET['ID']);   
          
        
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;
                  
        $comentarioComum = $comentario->SelecionarComentariosUserComum($_GET['pagina']);
        
        $resposta = $publi->listByIdPubli(); 
        $comentarioPrefei = $comentario->SelecionarComentariosUserPrefei();

        $quantidadePaginas = $comentario->getQuantidadePaginas();
        $pagina = $comentario->getPaginaAtual();        
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
                if(isset($resultado)){   
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
                    <li><a href="perfil.html"><i class="icone-user"></i>Meu perfil</a></li>
                    <li><a href="#"><i class="icone-salvar"></i>Salvos</a></li>
                    <hr>
                    <?php
                        require_once('opcoes.php');                           
                    ?>                     
                    <li><a href="configuracoes.php"><i class="icone-config"></i>Configurações</a></li>
                    <li><a href="../sair.php"><i class="icone-logout"></i>Log out</a></li>

                </ul>
            </nav>
            
        </div>       
        <?php
            }
        ?>

        <div id="container">
            <section class="pag-reclamacao">
                <div class="Reclamacao">   
                        <div class="publicacao-topo-aberta">
                                <div>
                                    <img src="../Img/perfil/<?php echo $resposta[0]['img_perfil_usu']?>">
                                </div>
                                <p><span class="negrito"><?php echo $resposta[0]['nome_usu']?></span><time><?php echo $resposta[0]['dataHora_publi']?></time></p>
                                <div class="mini-menu-item ">
                                    
                                    <i class="icone-3pontos"></i>
                                        <div>
                                            <ul>
                                            <?php
                                                if(isset($resposta[0]['indDenunPubli']) AND $resposta[0]['indDenunPubli'] == TRUE){ // Aparecer quando o user ja denunciou            
                                                    echo '<li><i class="icone-bandeira"></i><b>Denunciado</b></li>';        
                                                }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[0]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                                    if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                                                        echo '<li><a href="../Templates/DenunciarPublicacaoTemplate.php?ID='.$_GET['ID'].'"><i class="icone-bandeira"></i>Denunciar</a></li>';                                                        
                                                    }                    
                                                }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                                                    echo '<li><a href="../Templates/DenunciarPublicacaoTemplate.php?ID='.$_GET['ID'].'"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                } 
                                            ?>
                                            <?php
                                                if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[0]['cod_usu']){
                                                    echo '<li><a href="../ApagarPublicacao.php?ID='.$_GET['ID'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                    echo '<li><a href="../Templates/UpdatePublicacaoTemplate.php?ID='.$_GET['ID'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                                                }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                                    echo '<li><a href="../ApagarPublicacao.php?ID='.$_GET['ID'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                    // Icone para apagar usuaario
                                                    //echo '<a href="../ApagarUsuario.php?ID='.$resposta[0]['cod_usu'].'">Apagar Usuario</a>';                                                       
                                                    echo '<li><a href="../Templates/UpdatePublicacaoTemplate.php?ID='.$_GET['ID'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                                                }
                                            ?> 
                                            </ul>
                                        </div>
                                </div>
                        </div>
                        <div class="publicacao-conteudo">
                            <h2><?php echo $resposta[0]['titulo_publi']?></h2>
                            <h5><?php echo $resposta[0]['descri_cate']?></h5>

                            <div>
                                <p>
<?php  echo nl2br($resposta[0]['texto_publi'])?>
                                </p>
                            </div>
                        </div>        
                </div>
            <div class="img-publicacao">
                
                <figure>
                    <img src="../Img/publicacao/<?php echo $resposta[0]['img_publi']?>">
                </figure>
                                    
                <div class="item-baixo-publicacao">   
                    <i class="icone-local"></i><p><?php echo $resposta[0]['endereco_organizado_aberto']?></p>
                </div>         

            </div> 

            </section> 

            <?php         
                if(!empty($comentarioPrefei)){                
            ?>
            <section class="prefeitura-publicacao">
                <div class="topo-prefeitura-publicacao">
                    <div>
                        <img src="../Img/perfil/<?php echo $comentarioPrefei[0]['img_perfil_usu']?>">
                    </div>
                    <p><span class="negrito"><?php echo $comentarioPrefei[0]['nome_usu']?></span><time><?php echo $comentarioPrefei[0]['dataHora_comen']?></time></p>  
                </div> 
                <div class="conteudo-resposta">
                    <span>
<?php echo nl2br($comentarioPrefei[0]['texto_comen'])?>
                    </span>
                </div>
            
            </section>
            <?php
                }
            ?>
            <div class="barra-curtir-publicacao"> 
                    <div>
                        <span><?php echo $resposta[0]['quantidade_comen']?></span><i class="icone-comentario-full"></i>
                        <span><?php echo $resposta[0]['quantidade_curtidas']?></span><i class="icone-like"></i>
                    </div>
                    <a href="#"> 
                        <i class="icone-like"></i> Like
                    </a>
                
            </div>
            <?php
                if(isset($tipoUsu) AND ($tipoUsu == 'Funcionario' or $tipoUsu == 'Prefeitura')){
                    if(empty($comentarioPrefei)){
            ?>
                        <section class="enviar-comentario-publicacao">
                            <h3>
                                Envie um comentario
                            </h3>
                            <form action="../Comentario.php" method="post">
                                <textarea placeholder="Escreva um comentário" name="texto"></textarea>
                                <input type="hidden" value="<?php echo $_GET['ID']?>" name="id">
                                <input type="submit" value="Enviar Comentário">
                            </form>  
                        </section>
            <?php
                    }
            }else if(isset($tipoUsu) AND ($tipoUsu == 'Comum')){  
            ?>
                <section class="enviar-comentario-publicacao">
                    <h3>
                        Envie um comentario
                    </h3>
                    <form action="../Comentario.php" method="post">
                        <textarea placeholder="Escreva um comentário" name="texto"></textarea>
                        <input type="hidden" value="<?php echo $_GET['ID']?>" name="id">
                        <input type="submit" value="Enviar Comentário">
                    </form>  
                </section>
            <?php
            }
            ?>
            <section class="comentarios">
                <h3>
                    comentarios
                </h3>
                <?php 
                    $contador = 0;
                    while($contador < count($comentarioComum)){
                ?>   
                <div class="comentario-user">
                    <div class="publicacao-topo-aberta">
                        <div>
                            <img src="../Img/perfil/<?php echo $comentarioComum[$contador]['img_perfil_usu']?>">
                        </div>
                        <p><span class="negrito"><?php echo $comentarioComum[$contador]['nome_usu']?></span><?php echo $comentarioComum[$contador]['dataHora_comen']?></p>
                        <div class="mini-menu-item ">
                            <i class="icone-3pontos"></i>
                            <div>
                                <ul>
                                <?php
                                    if(isset($comentarioComum[$contador]['indDenunComen']) AND $comentarioComum[$contador]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                                        echo '<li><i class="icone-bandeira"></i><b>Denunciado</b></li>';            
                                    }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $comentarioComum[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                        if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                                            echo '<li><a href="../Templates/DenunciarComentarioTemplate.php?ID='.$comentarioComum[$contador]['cod_comen'].'&IDPubli='.$_GET['ID'].'&pagina='. $pagina.'"><i class="icone-bandeira"></i>Denunciar</a></li>';                                            
                                        }                    
                                    }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                                        echo '<li><a href="../Templates/DenunciarComentarioTemplate.php?ID='.$comentarioComum[$contador]['cod_comen'].'&IDPubli='.$_GET['ID'].'&pagina='. $pagina.'"><i class="icone-bandeira"></i>Denunciar</a></li>';                                            
                                    }
                                ?>

                                <?php
                                    if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $comentarioComum[$contador]['cod_usu']){
                                        echo '<li><a href="../ApagarComentario.php?ID='.$comentarioComum[$contador]['cod_comen'].'"><i class="icone-fechar"></i></i>Remover</a></li>';                                       
                                        echo '<li><a href="../Templates/UpdateComentarioTemplate.php?ID='.$comentarioComum[$contador]['cod_comen'].'&IDPubli='.$_GET['ID'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                        
                                    }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                        echo '<li><a href="../ApagarComentario.php?ID='.$comentarioComum[$contador]['cod_comen'].'"><i class="icone-fechar"></i></i>Remover</a></li>';                                       
                                        //Remover usuario ADM    
                                        //echo '<a href="../ApagarUsuario.php?ID='.$comentarioComum[$contador]['cod_usu'].'">Apagar Usuario</a>';                            
                                    }
                                ?>                                    
                                </ul>
                            </div>
                        </div>
                    </div>  
                    <p>
                    <?php echo nl2br($comentarioComum[$contador]['texto_comen'])?>
                    </p>                
                </div>
                <?php
                    $contador++;
                }
                ?>
                <ul>
                <?php
                    if($quantidadePaginas != 1){
                        $contador = 1;
                        while($contador <= $quantidadePaginas){
                            if(isset($pagina) AND $pagina == $contador){
                                echo '<li class="jaca"><a href="reclamacao.php?ID='.$_GET['ID'].'&pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;  
                            }else{
                                echo '<li><a href="reclamacao.php?ID='.$_GET['ID'].'&pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;
                            }                            
                            $contador++;        
                        }
                    }            
                ?>
                </ul>                
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
                echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes.php';</script>";
        }   
    }  
?>
