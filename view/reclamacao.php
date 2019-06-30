<?php    
    if(!file_exists('Config/Config.php')){        
        echo "<script>javascript:window.location='todasreclamacoes';</script>";       
    }
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');    
    use Core\Usuario;
    use Core\Publicacao;
    use Core\Comentario;
    use Core\PublicacaoSalva;
    use Classes\ValidarCampos;
    use Notificacoes\Core\VisualizarNotificacao;
    try{        
        $publi = new Publicacao();
        $comentario = new Comentario();
        
        $dadosUrl = explode('/',$_GET['url']);
        //var_dump($dadosUrl);     
        if(!isset($dadosUrl[1])){
            throw new \Exception('Não foi possível achar o debate',9);
        }else if(isset($dadosUrl[4])){ //não pode ter mais de tres parametros
            throw new \Exception('Não foi possível achar o debate',45);
        }  
        $voltar = "../";
        $numVoltar = 1;
        $_GET['ID'] = $dadosUrl[1];


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

            $dadosPrefei = $dados->getDadosUsuByTipoUsu(array('Prefeitura'));   
            
        }      
        
        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero           
        

        $publi->setCodPubli($_GET['ID']);
        $comentario->setCodPubli($_GET['ID']);             
        
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;  
        
        $resposta = $publi->listByIdPubli(); 
        $comentarioPrefei = $comentario->SelecionarComentariosUserPrefei(TRUE);        
        
        if(isset($dadosUrl[2]) AND isset($_SESSION['id_user'])){
            $_GET['com'] = $dadosUrl[2];        
            $voltar .= "../";                     
            $numVoltar++;
            $visualizar = new VisualizarNotificacao();
            if(isset($dadosUrl[3])){
                $_GET['com'] = $dadosUrl[3];
                $idNoti = $dadosUrl[2];  
                $voltar .="../";
                $_GET['IdComen'] = $dadosUrl[2];  
                $numVoltar++;
                $comentario->setCodComen($idNoti);
                $comentarioComum = $comentario->getDadosComenByIdComen(); // preciso do comenantario denunciado   
            }else{
                $idNoti = $dadosUrl[1];
            }
            $visualizar->visualizarNotificacao($_GET['com'], $idNoti, $_SESSION['id_user']);
        }else if(isset($dadosUrl[2]) AND !isset($_SESSION['id_user'])){
            throw new \Exception('Não foi possível achar o debate',45);
        }
        

        if(isset($_SESSION['id_user']) AND isset($_GET['IdComen']) AND isset($tipoUsu) AND ($tipoUsu == 'Adm' OR $tipoUsu == 'Moderador')){            
            $idNoti = $_GET['IdComen'];
            $comentario->setCodComen($idNoti);
            //$comentarioComum = $comentario->getDadosComenByIdComen(); // preciso do comenantario denunciado  
            $complemento = "Comentário Denunciado: ";
        }else{ // quero todos os comentários
            $comentarioComum = $comentario->SelecionarComentariosUserComum($_GET['pagina']); // quero todos os comenatários
            if(empty($comentarioComum) AND (isset($tipoUsu) AND $tipoUsu == 'Comum' )){
                $complemento = "";
            }else if(!empty($comentarioComum)){
                $complemento = "Comentários";
            }else{
                $complemento = "";
            }            
            $_GET['IdComen'] = "";
        }

        $indUltimaRespostaPrefeitura = $comentario->verifyUltimaResposta("Resposta final da prefeitura");
        $indUltimaRespostaDono = $comentario->verifyUltimaResposta("Resposta final do dono da publicação");        

        $ultimaRespotaDono = $comentario->selectRespostaFinal("Resposta final do dono da publicação");        
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title><?php echo $resposta[0]['titulo_publi']?>, em Barueri</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Site de reclamações para a cidade de Barueri">
        <meta name=keywords content="Reclamação, Barueri"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI2A'>
        <meta name="theme-color" content="#089E8E" />

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="<?php echo $voltar ?>view/imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="<?php echo $voltar ?>view/css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="<?php echo $voltar ?>view/css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="<?php echo $voltar ?>view/css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="<?php echo $voltar ?>view/css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="<?php echo $voltar ?>view/css/style1025.css">

        <!-- JS-->

        <script src="<?php echo $voltar ?>view/lib/_jquery/jquery.js"></script>
        <script src="<?php echo $voltar ?>view/js/js.js"></script>
        <script src="<?php echo $voltar ?>view/js/PegarComen.js"></script>
        <script src="<?php echo $voltar ?>teste.js"></script>
        <!-- <script>
            $("document").ready(function(){
                $("title").text($(".publicacao-conteudo").find("h2").text() +" "+ "em Barueri")
                //$(".publicacao-conteudo").find("h2").text();
            })
        </script> -->

       

    </head>
    <body style="background-color:white" onload="jaquinha()">
        <header>
            <a href="<?php echo $voltar ?>todasreclamacoes">
                <img src="<?php echo $voltar ?>view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="<?php echo $voltar ?>pesquisa" method="get" id="form-pesquisa">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">                
                <button type="submit"><i class="icone-pesquisa"></i></button>
            </form>
            <nav class="menu">                
                <ul>
                    <li><nav class="notificacoes">
                        <h3>notificações<span id="not-fechado">x</span></h3>
                        <ul id="menu23">
                            
                            <li>
                        </ul>
                    </nav><a href="#" id="abrir-not"><i class="icone-notificacao" id="noti"></i>Notificações</a></li>
                    <li><a href="<?php echo $voltar ?>todasreclamacoes"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="<?php echo $voltar ?>todosdebates"><i class="icone-debate"></i>Debates</a></li>
                </ul>            
            </nav>  
            <?php
                if(!isset($resultado)){
                    echo '<a href="'.$voltar.'login"><i class="icone-user" id="abrir"></i></a>';
                }else{
                    echo '<i class="icone-user" id="abrir"></i>';
                }

                if(!empty($_SESSION['atu'])){
                    echo '<script>alerta("Certo","Atualizado")</script>';
                    unset($_SESSION['atu']);
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
                                <img src="<?php echo $voltar ?>Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>" alt="perfil">
                            </div>    
                                <img src="<?php echo $voltar ?>Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
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
            <input type="hidden" id="IdPublis" value="<?php echo $_GET['ID'] ?>">
            <input type="hidden" id="IdComen" value="<?php echo $_GET['IdComen'] ?>">
            <input type="hidden" id="nomePref" value="<?php echo $dadosPrefei[0]['nome_usu'] ?>">
            <section class="pag-reclamacao">
                <div class="Reclamacao">   
                        <div class="publicacao-topo-aberta">
                                <a href="<?php echo $voltar ?>perfil_reclamacao/<?php echo $resposta[0]['cod_usu'] ?>">
                                <div>
                                    <img src="<?php echo $voltar ?>Img/perfil/<?php echo $resposta[0]['img_perfil_usu']?>">
                                </div>
                                
                                <p><span class="negrito"><?php echo $resposta[0]['nome_usu']?></span></a><time><?php echo $resposta[0]['dataHora_publi']?></time></p>
                                
                                <div class="mini-menu-item">
                                    <i class="icone-3pontos"></i>
                                    <div><!--DA PRA TIRAR A DIV-->
                                        <ul>
                                                <?php
                                                    if(isset($resposta[0]['indDenunPubli']) AND $resposta[0]['indDenunPubli'] == TRUE){ // Aparecer quando o user ja denunciou            
                                                        echo '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</b></li>';        
                                                    }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[0]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                                        if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                                                            echo '<li class="denunciar-item" data-id="'.$_GET['ID'].'.Publicacao,'.$numVoltar.'"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';    
                                                            $indDenun = TRUE; // = carregar modal da denucia
                                                        }                    
                                                    }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                                                        echo '<li class="denunciar-item" data-id="'.$_GET['ID'].'.Publicacao,'.$numVoltar.'"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                        $indDenun = TRUE; // = carregar modal da denucia
                                                    } 
                                                ?>
                                                <?php
                                                    if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[0]['cod_usu']){
                                                        echo '<li><a href="../ApagarPublicacao.php?ID='.$_GET['ID'].'"><i class="icone-fechar"></i></i>Remover</a></li>';                                                                                                           
                                                        echo '<li><a href="'.$voltar.'reclamacao-update/'.$_GET['ID'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                                    }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                                        echo '<li><a href="../ApagarPublicacao.php?ID='.$_GET['ID'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                        // Icone para apagar usuaario
                                                        //echo '<a href="../ApagarUsuario.php?ID='.$resposta[0]['cod_usu'].'">Apagar Usuario</a>';  
                                                        echo '<li><a href="'.$voltar.'reclamacao-update/'.$_GET['ID'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                
                                                    }
                                                ?> 
                                                <?php                                             
                                                    if(isset($indSalva) AND !$indSalva){
                                                        echo '<li><a class="salvar" href="../SalvarPublicacao.php?ID='.$_GET['ID'].','.$numVoltar.'"><i class="icone-salvar"></i>Salvar</a></li>';
                                                    }else if(isset($indSalva) AND $indSalva){
                                                        echo '<li><a class="salvar" href="../SalvarPublicacao.php?ID='.$_GET['ID'].','.$numVoltar.'"><i class="icone-salvar-full"></i>Salvo</a></li>';
                                                    }else{
                                                        echo '<li><a class="salvar" href="../SalvarPublicacao.php?ID='.$_GET['ID'].','.$numVoltar.'"><i class="icone-salvar"></i>Salvar</a></li>';
                                                    }
                                                ?>
                                        </ul>
                                    </div>
                                    
                                        <div class="modal-denunciar">
                                            <div class="modal-denunciar-fundo"></div>
                                            <div class="box-denunciar">
                                                <div>
                                                    <h1>Qual o motivo da denúncia?</h1>
                                                    <span class="fechar-denuncia">&times;</span>
                                                </div>
                                                
                                                <form id="formdenuncia">
                                                    <textarea placeholder="Qual o motivo?" id="motivo"></textarea>
                                                    <input type="hidden" name="id_publi" value="">
                                                    <div class="aviso-form-inicial ">
                                                        <p>O campo tal e pa</p>
                                                    </div>
                                                    <button type="submit"> Denunciar</button>
                                                </form>
                                            </div>
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
                    <img src="<?php echo $voltar ?>Img/publicacao/<?php echo $resposta[0]['img_publi']?>" alt="<?php echo $resposta[0]['titulo_publi']?>">
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
                    <?php
                        $contador = 0;
                        while($contador < count($comentarioPrefei)){
                    ?>
                        <div class="topo-prefeitura-publicacao">
                            <a href="<?php echo $voltar ?>perfil_reclamacao/<?php echo $comentarioPrefei[$contador]['cod_usu_prefei'] ?>">
                            <div>
                                <img src="<?php echo $voltar ?>Img/perfil/<?php echo $comentarioPrefei[$contador]['img_perfil_usu']?>">
                            </div>
                            <p><span class="negrito"><?php echo $comentarioPrefei[$contador]['nome_usu_prefei']?></span></a><time><?php echo $comentarioPrefei[$contador]['dataHora_comen']?></time></p>  
                        </div> 
                        <div class="conteudo-resposta">
                            <span>
<?php echo nl2br($comentarioPrefei[$contador]['texto_comen'])?>
                            </span>
                        </div>
                    <?php
                        $contador++;
                        }
                        if(!empty($ultimaRespotaDono)){
                    ?>
                    <div class="topo-prefeitura-publicacao">
                            <a href="<?php echo $voltar ?>perfil_reclamacao/<?php echo $ultimaRespotaDono[0]['cod_usu'] ?>">
                            <div>
                                <img src="<?php echo $voltar ?>Img/perfil/<?php echo $ultimaRespotaDono[0]['img_perfil_usu']?>">
                            </div>
                            <p><span class="negrito"><?php echo $ultimaRespotaDono[0]['nome_usu']?></span></a><time><?php echo $ultimaRespotaDono[0]['dataHora_comen']?></time></p>  
                        </div> 
                        <div class="conteudo-resposta">
                            <span>
<?php echo nl2br($ultimaRespotaDono[0]['texto_comen'])?>
                            </span>
                            <br>
                            <span>
<strong>NOTA:<strong> <?php echo nl2br($ultimaRespotaDono[0]['nota_resposta'])?>
                            </span>
                    </div>
                    <?php
                        }                        
                    ?>

                    </section>
            <?php
                }
            ?>
            <div class="barra-curtir-publicacao"> 
                    <div>
                        <span id="qtd_comen"><?php echo $resposta[0]['quantidade_comen']?></span><i class="icone-comentario-full"></i>
                        <span id="qtd_likes"><?php echo $resposta[0]['quantidade_curtidas']?></span><i class="icone-like"></i>
                    </div>
                    <?php
                        if(isset($resposta[0]['indCurtidaDoUser']) AND $resposta[0]['indCurtidaDoUser'] == TRUE){            
                            echo '<a href="../CurtirPublicacao.php?ID='.$_GET['ID'].'" id="deiLike"><i class="icone-like-full"></i> Like</a>';            
                        }else{                     
                            echo '<a href="../CurtirPublicacao.php?ID='.$_GET['ID'].'" id="deiLike"><i class="icone-like"></i> Like</a>';  
                        }
                    ?>
                
            </div> 
            <?php
                if(isset($tipoUsu) AND ($tipoUsu == 'Funcionario' or $tipoUsu == 'Prefeitura')){
                    if($indUltimaRespostaPrefeitura <= 0){
                        // ARRUMAR FORM PRA ENVIAR REPOSTA TEM Q TER OS IND REPOSTA
                        // COMO INPUT TYPE HIDDEN
            ?>
                        <section class="enviar-comentario-publicacao">
                            <h3>
                                Envie uma resposta
                            </h3>
                            <!-- <form id="enviar_comentario"> -->
                            <form action="../Comentario.php" method="post">
                                <textarea placeholder="Escreva uma resposta" name="texto" id="comentarioTxt"></textarea>
                                <input type="hidden" value="<?php echo $_GET['ID']?>" name="id" id="idPubli">
                                <input type="radio" name="indUltimaResposta" value=true>Ultima Resposta
                                <input type="radio" name="indUltimaResposta" value=false>Não ultima Resposta
                                <input type="submit" id="btn-reclama" value="Enviar Resposta" disabled>
                            </form>  
                        </section>
            <?php
                    }
            }else if(isset($tipoUsu) AND ($tipoUsu == 'Comum')){  
            ?>
                        <section class="enviar-comentario-publicacao">
                                    <h3>
                                        Envie um comentário
                                    </h3>
                                    <form id="enviar_comentario">
                                        <textarea placeholder="Escreva um comentário" name="texto" id="comentarioTxt" ></textarea>
                                        <input type="hidden" value="<?php echo $_GET['ID']?>" name="id" id="idPubli">
                                        <input type="submit" id="btn-reclama" value="Enviar Comentário" disabled>
                                        <div class="aviso-form-inicial " style="margin-top:10px;">
                                        <p>O campo tal e pa</p>
                                    </div>
                                    </form>  
                        </section>
            <?php
                }                           
                if($indUltimaRespostaDono <= 0 && $indUltimaRespostaPrefeitura > 0 && isset($tipoUsu) AND ($tipoUsu == 'Comum')){
            ?>
                <section class="enviar-comentario-publicacao">
                    <h3>
                        Envie um feedBack
                    </h3>
                    <form action="../Comentario.php" method="post">
                        <textarea placeholder="Escreva um comentário" name="texto" id="comentarioTxt" ></textarea>
                        <input type="hidden" value="<?php echo $_GET['ID']?>" name="id" id="idPubli">
                        <input type="hidden" value="true" name="indUltimaResposta">
                        <input type="text" name="nota" style="background-color: white; border: 1px solid black; color: black;" placeholder="Nota">
                        <input type="submit" value="Enviar Comentário">
                        <div class="aviso-form-inicial " style="margin-top:10px;">
                            <p>O campo tal e pa</p>
                        </div>
                    </form>  
                </section>
            <?php
                }
            ?>

            <section class="comentarios" id="pa">
                        <div class="modal-editar-comentario">
                            <div class="modal-editar-comentario-fundo"></div>
                            <div class="box-editar-comentario">
                                <div>
                                    <h1>Editar comentário</h1>
                                    <span class="fechar-editar-comentario">&times;</span>
                                </div>                     
                                <form action="../UpdateComentario.php" method="post" id="editarComentario">
                                    <textarea placeholder="Qual o motivo?" id="motivoT" name="texto"> </textarea>
                                    <input type="hidden" id="idEditar" value="" name="id">
                                    <div class="aviso-form-inicial " style="margin-top:10px;">
                                        <p>O campo tal e pa</p>
                                    </div>
                                    <button type="submit">Editar</button>
                                </form>
                            </div>
                        </div>         
                <h3 style="display: flex;order: -2;">
                    <?php echo $complemento ?>
                </h3>
            </section>     
        </div>
        <input type="hidden" id="voltar" value="<?php echo $numVoltar?>">
        <script src="<?php echo $voltar ?>view/js/like.js"></script>
    </body>
</html>
<?php
}catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 9://Não foi possivel achar a publicacao  
                echo "<script> alert('$mensagem');javascript:window.location='".$voltar."todasreclamacoes';</script>";
                break; 
            case 45://Digitou um numero maior de parametros 
                unset($dadosUrl[0]);
                $contador = 1;
                $voltar = "";
                while($contador <= count($dadosUrl)){
                    $voltar .= "../";
                    $contador++;
                }
                echo "<script> alert('$mensagem');javascript:window.location='".$voltar."todasreclamacoes';</script>";
                break;
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='".$voltar."todasreclamacoes';</script>";
        }   
    }  
?>


