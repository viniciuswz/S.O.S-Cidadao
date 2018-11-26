<?php
    session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    use Core\Usuario;
    use Core\Debate;
    use Classes\ValidarCampos;
    use Core\Publicacao;
    try{        
        $usuPerfil = new Usuario();
        if(isset($_SESSION['id_user'])){ // se estiver logado   
            $usu = new Usuario();  
            $usu->setCodUsu($_SESSION['id_user']);         
            $resultado = $usu->getDadosUser();

            $tipoUsu = $_SESSION['tipo_usu'];
            if(isset($_GET['ID'])){ // quando for ver perfil de outras pessoas
                $validar = new ValidarCampos(array('ID'), $_GET);
                $validar->verificarTipoInt(array('ID'), $_GET); // Verificar se o parametro da url é um numero
                $id = $_GET['ID'];
                $usuPerfil->setCodUsu($_GET['ID']); 
                $dadosPerfil =  $usuPerfil->getDadosUser();     
            }else{ // seu propio perfil
                $id = $_SESSION['id_user'];                
                $dadosPerfil = $resultado;                            
            }      
        }else{ // Nao esta logado
            $validar = new ValidarCampos(array('ID'), $_GET);
            $validar->verificarTipoInt(array('ID'), $_GET); // Verificar se o parametro da url é um numero
            $id = $_GET['ID'];   
            $usuPerfil->setCodUsu($_GET['ID']);    
            $dadosPerfil =  $usuPerfil->getDadosUser();     
        }
        $descPerfilVisu = $dadosPerfil[0]['descri_tipo_usu'];
        if($descPerfilVisu != 'Comum' AND $descPerfilVisu != 'Prefeitura'){ // Vendo perfil restrito
            if(!isset($_SESSION['id_user'])){ // Não esta logado
                throw new \Exception("Você nao tem permissao para este perfil12",1);
            }

            if($_SESSION['id_user'] != $dadosPerfil[0]['cod_usu']){// Logado, e nao esta no seu perfil
                switch($tipoUsu){
                    case 'Comum':
                    case 'Funcionario':
                        throw new \Exception("Você nao tem permissao para este perfil13",1);
                        break;
                    case 'Prefeitura':
                        if($descPerfilVisu != 'Funcionario'){
                            throw new \Exception("Você nao tem permissao para este perfil14",1);
                        }
                        break; 
                }
        }}    
               
        
        isset($_GET['pagina']) ?: $_GET['pagina'] = null; 
        if($descPerfilVisu == 'Prefeitura'){
            $publi = new Publicacao();    
            $publi->setCodUsu($_SESSION['id_user']);
            $nomeLink1 = 'Respondidas';
            $nomeLink2 = 'Sem resposta'; 

            $resposta = $publi->getPubliRespo($_GET['pagina'], TRUE);  
            //var_dump($resposta);
            $quantidadePaginas = $publi->getQuantidadePaginas();
            $pagina = $publi->getPaginaAtual();  
         }else{
            $debate = new Debate();
            $debate->setCodUsu($id);
             isset($_SESSION['id_user']) ? $idVisualizador = $_SESSION['id_user'] : $idVisualizador = null;
             $nomeLink1 = 'Debate';
             $nomeLink2 = 'Reclamação';
             
             $resposta = $debate->ListByIdUser($_GET['pagina'], $idVisualizador);
             
             $quantidadePaginas = $debate->getQuantidadePaginas();
             $pagina = $debate->getPaginaAtual();      
         }
           
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
        <script src="../teste.js"></script>
        <?php
            if($descPerfilVisu == 'Prefeitura'){ 
        ?>
                <script src="js/PegarPubliPerfPrefei.js"></script>
        <?php
            }else{
        ?>
                <script src="js/PegarDebaPerfil.js"></script>
        <?php
            }
        ?>
        
        <!-- cropp-->

        <link rel="stylesheet" href="lib/_croppie-master/croppie.css">
        <script src="lib/_croppie-master/croppie.js"></script>
        <script src="lib/_croppie-master/exif.js"></script>
    </head>
    <body onload="jaquinha()">
        <header>
            <a href="todasreclamacoes.php">
                <img src="imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="pesquisa.php" method="get" id="form-pesquisa">
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
        <input type="hidden" id="IDPefil" value="<?php echo $id?>">
            <section class="perfil-base" id="baconP">
                
                <div class="perfil">
                        <?php 
                            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $dadosPerfil[0]['cod_usu']){
                                // vinicius esqueceu o formulario
                        ?>
                            <i class="icone-edit-full" id="trocar-capa" title="Alterar a foto de capa"></i>
                        <?php 
                            }
                        ?>
                    <img src="../Img/capa/<?php echo $dadosPerfil[0]['img_capa_usu'] ?>"> 
                   

                    
                </div>
                <div class="perfil-info">
                        <p><?php echo $dadosPerfil[0]['nome_usu'] ?></p>
                        <div>
                            <img src="../Img/perfil/<?php echo $dadosPerfil[0]['img_perfil_usu'] ?>">
                        </div>

                        <?php 
                            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $dadosPerfil[0]['cod_usu'] 
                            AND isset($tipoUsu) AND $tipoUsu != "Funcionario"){
                                // vinicius esqueceu o formulario
                        ?>
                                <i class="icone-edit-full" id="trocar-perfil" title="Alterar a foto de perfil"></i>
                        <?php 
                            }
                        ?>
                </div>

               
            </section>
            <nav class="menu-perfil">
                <ul class="espacos">

                    <?php 
                        if(isset($_GET['ID'])){                    
                            echo '<li><a href="perfil_reclamacao.php?ID='.$dadosPerfil[0]['cod_usu'].'">'.$nomeLink2.'</a></li>';
                        }else{
                            echo '<li><a href="perfil_reclamacao.php">'.$nomeLink2.'</a></li>';
                        }
                    ?>

                    <li class="ativo"><a href="#d"><?php echo $nomeLink1 ?></a></li>
                    
                </ul>
            </nav>
            <section class="alinha-item" id="pa">
                <div class="modal-denunciar">
                    <div class="modal-denunciar-fundo"></div>
                    <div class="box-denunciar">
                        <div>
                            <h1>Qual o motivo da denuncia?</h1>
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


            <?php
                if(empty($resposta)){
                    echo '';
                    //exit();
                }            
                /*    
                $contador = 0;
                while($contador < count($resposta)){ 
                    if($descPerfilVisu != 'Prefeitura'){               
            ?> 
                <div class="item-publicacao">
                        <div class="item-topo">
                            <a href="#">
                            <div>
                                <img src="../Img/perfil/<?php echo $resposta[$contador]['img_perfil_usu']?>">
                            </div>
                            <p><span class="negrito"><?php echo $resposta[$contador]['nome_usu']?></a></span><time><?php echo $resposta[$contador]['dataHora_deba']?></time></p>
                            <div class="mini-menu-item">
                                <i class="icone-3pontos"></i>
                                <div>
                                    <ul>
                                                <?php
                                                    if(isset($resposta[$contador]['indDenunComen']) AND $resposta[$contador]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                                                        echo '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';        
                                                    }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                                        if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){                                                       
                                                            echo '<li class="denunciar-item"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                            $indDenun = TRUE; // = carregar modal da denucia
                                                        }                    
                                                    }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado]
                                                        echo '<li class="denunciar-item"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                        $indDenun = TRUE; // = carregar modal da denucia
                                                    } 
                                                ?>

                                                <?php
                                                    if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[$contador]['cod_usu']){
                                                        echo '<li><a href="../ApagarDebate.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                        echo '<li><a href="debate-update.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                                                    }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                                        echo '<li><a href="../ApagarDebate.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                        // Icone para apagar usuaario
                                                        //echo '<a href="../ApagarUsuario.php?ID='.$resposta[0]['cod_usu'].'">Apagar Usuario</a>';                                                       
                                                        echo '<li><a href="debate-update.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                                                    }
                                                ?>   
                                    </ul>
                                </div>
                                <?php if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos?>
                                            <div class="modal-denunciar">
                                                <div class="modal-denunciar-fundo"></div>
                                                <div class="box-denunciar">
                                                    <div>
                                                        <h1>Qual o motivo da denuncia?</h1>
                                                        <span class="fechar-denuncia">&times;</span>
                                                    </div>
                                            
                                                    <form form method="post" action="../DenunciarDebate.php">
                                                        <textarea placeholder="Qual o motivo?" id="motivo" name="texto"></textarea>
                                                        <input type="hidden" name="id_deba" value="<?php echo $resposta[$contador]['cod_deba'] ?>">                
                                                        <button type="submit"> Denunciar</button>
                                                    </form>                                        
                                                </div>
                                            </div>
                                <?php } ?>
                            </div>
                        </div>
                        <a href="Pagina-debate.php?ID=<?php echo $resposta[$contador]['cod_deba'] ?>">
                            <figure>
                                <img src="../Img/debate/<?php echo $resposta[$contador]['img_deba']?>">
                            </figure>
                            <div class="legenda">
                                    <p><?php echo $resposta[$contador]['nome_deba']?></p><p><?php echo $resposta[$contador]['qtdParticipantes']?></p><i class="icone-grupo"></i>
                            </div>
                            
                        </a>
                </div>
                <?php  
                    }else{   
                ?>
                    <div class="item-publicacao">
                        <div class="item-topo">
                            <a href="#">
                            <div>
                                <img src="../Img/perfil/<?php echo $resposta[$contador]['img_perfil_usu']?>">
                            </div>
                            <p><span class="negrito"><?php echo $resposta[$contador]['nome_usu']?></a></span><time><?php echo $resposta[$contador]['dataHora_publi']?></time></p>
                            <div class="mini-menu-item">
                                <i class="icone-3pontos"></i>
                                <div>
                                    <ul>
                                    <?php
                                            if(isset($resposta[$contador]['indDenunPubli']) AND $resposta[$contador]['indDenunPubli'] == TRUE){ // Aparecer quando o user ja denunciou            
                                                echo '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';        
                                            }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                                if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){                                                             
                                                    echo '<li class="denunciar-item"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                    $indDenun = TRUE; // = carregar modal da denucia
                                                }                    
                                            }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado                                            
                                                echo '<li class="denunciar-item"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                $indDenun = TRUE; // = carregar modal da denucia
                                            } 
                                        ?>

                                        <?php
                                            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[$contador]['cod_usu']){
                                                echo '<li><a href="../ApagarPublicacao.php?ID='.$resposta[$contador]['cod_publi'].'"><i class="icone-fechar"></i></i>Remover</a></li>';                                            
                                                echo '<li><a href="reclamacao-update.php?ID='.$resposta[$contador]['cod_publi'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                            }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                                echo '<li><a href="../ApagarPublicacao.php?ID='.$resposta[$contador]['cod_publi'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                // Icone para apagar usuaario
                                                //echo '<a href="../ApagarUsuario.php?ID='.$resposta[0]['cod_usu'].'">Apagar Usuario</a>'; 
                                                echo '<li><a href="reclamacao-update.php?ID='.$resposta[$contador]['cod_publi'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                            }
                                        ?> 

                                        <?php
                                            if(isset($_SESSION['id_user']) AND isset($resposta[$contador]['indSalvaPubli']) AND $resposta[$contador]['indSalvaPubli'] == TRUE){//Salvou
                                                echo '<li><a href="../SalvarPublicacao.php?ID='.$resposta[$contador]['cod_publi'].'"><i class="icone-salvar-full"></i>Salvo</a></li>';
                                            }else if(isset($_SESSION['id_user']) AND isset($resposta[$contador]['indSalvaPubli']) AND $resposta[$contador]['indSalvaPubli'] == FALSE){//Nao salvou
                                                echo '<li><a href="../SalvarPublicacao.php?ID='.$resposta[$contador]['cod_publi'].'"><i class="icone-salvar"></i>Salvar</a></li>';
                                            }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                                                echo '<li><a href="../SalvarPublicacao.php?ID='.$resposta[$contador]['cod_publi'].'"><i class="icone-salvar"></i>Salvar</a></li>';
                                            } 
                                        ?>                                                                         
                                    </ul>
                                </div>
                                <?php if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos?>
                                    <div class="modal-denunciar">
                                        <div class="modal-denunciar-fundo"></div>
                                        <div class="box-denunciar">
                                            <div>
                                                <h1>Qual o motivo da denuncia?</h1>
                                                <span class="fechar-denuncia">&times;</span>
                                            </div>
                                            
                                            <form form method="post" action="../DenunciarPublicacao.php">
                                                <textarea placeholder="Qual o motivo?" id="motivo" name="texto"></textarea>
                                                <input type="hidden" name="id_publi" value="<?php echo $resposta[$contador]['cod_publi'] ?>">                
                                                <button type="submit"> Denunciar</button>
                                            </form>
                                                
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                    </div>
                    <a href="reclamacao.php?ID=<?php echo $resposta[$contador]['cod_publi'] ?>">
                        <?php
                            if(!empty($resposta[$contador]['img_publi'])){
                        ?>
                            <figure>
                                <img src="../Img/publicacao/<?php echo $resposta[$contador]['img_publi']?>">
                            </figure>  
                        <?php
                            }
                        ?>  
                            <p><?php echo $resposta[$contador]['titulo_publi']?></p>
                            </a>
                            <div class="item-baixo">   
                                <i class="icone-local"></i><p><?php echo $resposta[$contador]['endereco_organizado_fechado']?></p>
                                <div>    
                                    <span><?php echo $resposta[$contador]['quantidade_curtidas']?></span><i class="icone-like"></i>
                                    <span><?php echo $resposta[$contador]['quantidade_comen']?></span><i class="icone-comentario"></i>
                                </div>
                            </div>
                    </div>
                <?php
                    }
                    $indDenun = false;
                    $contador++;
                    }
                ?>              

            </section>
                
        </div>
        <ul>
        <?php
            if($quantidadePaginas != 1){
                $contador = 1;
                while($contador <= $quantidadePaginas){
                    if(isset($pagina) AND $pagina == $contador){
                        if(isset($_GET['ID'])){
                            echo '<li class="jaca"><a href="perfil_debate.php?pagina='.$contador.'&ID='.$_GET['ID'].'">Pagina'.$contador.'</a></li>'  ; 
                        }else{
                            echo '<li class="jaca"><a href="perfil_debate.php?pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ; 
                        }                         
                    }else{
                        if(isset($_GET['ID'])){
                            echo '<li class="jaca"><a href="perfil_debate.php?pagina='.$contador.'&ID='.$_GET['ID'].'">Pagina'.$contador.'</a></li>'  ; 
                        }else{
                            echo '<li class="jaca"><a href="perfil_debate.php?pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ; 
                        }                         
                    }          
                    
                    $contador++;        
                }
            }
            */
        ?>
        </ul>

        <div class="modal-troca-foto">
            <div class="modal-troca-foto-fundo"></div>
            <div class="box-troca-foto">
                <div class="modal-titulo">
                    <h1>trocar foto de capa</h1>
                    <span class="fechar-troca-foto">&times;</span>
                </div>
                <div class="img-capa-corta">
                   <img src="">
                </div>
                <div>  
                <div class="aviso-form-inicial ">
                        <p>O campo tal e pa</p>
                    </div>               
                    <form id="trocarcapa">
                        <label for="fotoCapa"><p>Escolher foto</p></label>
                        <input type="file" accept="image/*" name="fotocapa" id="fotoCapa">
                        <input type="hidden" name="base64FotoCapa" id="base64FotoCapa" value="jaca">
                    </form>
                    <button id="cortar">Cortar foto</button>
                </div>
            </div>
        </div> 

        <div class="modal-troca-foto-previa">
            <div class="modal-troca-foto-previa-fundo"></div>
            <div class="box-troca-foto-previa">
                <div>
                    <h1>Gostou?</h1>
                    <span class="fechar-troca-foto-previa">&times;</span>
                </div>
                <div>                 
                    <img src="" class="previewCapa" style="width: 100%">
                    <button class="alterar-capa">enviar foto</button>

                    <button class="outra-capa">tentar de novo</button>
                </div>
            </div>
        </div>

        <div class="modal-troca-foto-perfil">
                <div class="modal-troca-foto-perfil-fundo"></div>
                <div class="box-troca-foto-perfil">
                    <div class="modal-titulo">
                        <h1>trocar foto de perfil</h1>
                        <span class="fechar-troca-foto-perfil">&times;</span>
                    </div>
                    <div class="img-perfil-corta">
                       <img src="">
                    </div>
                    <div>  
                    <div class="aviso-form-inicial ">
                            <p>O campo tal e pa</p>
                        </div>               
                        <form id="trocarperfil">
                            <label for="fotoPerfil"><p>Escolher foto</p></label>
                            <input type="file" accept="image/*" name="fotoperfil" id="fotoPerfil">
                            <input type="hidden" name="base64FotoPerfil" id="base64FotoPerfil" value="banana">
                        </form>
                        <button id="cortarPerfil">Cortar foto</button>
                    </div>
                </div>
            </div> 
    
            <div class="modal-troca-foto-perfil-previa">
                <div class="modal-troca-foto-perfil-previa-fundo"></div>
                <div class="box-troca-foto-perfil-previa">
                    <div>
                        <h1>Gostou?</h1>
                        <span class="fechar-troca-foto-perfil-previa">&times;</span>
                    </div>
                    <div>                 
                    <img src="" class="previewPerfil" style="width: 180px;border-radius: 50%;">
                        <button class="alterar-perfil">enviar foto</button>
                        <button class="outra-perfil">tentar de novo</button>
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
                  var  $uploadCrop = $('.img-capa-corta').croppie({
 
                    enableExif: true,
                    enforceBoundary:true,
                    enableOrientation:true,
                    enableResize:false,
                    viewport: {
                      width: 320,
                      height: 150,
                      
                    },
                    boundary: {
                      width: tela,
                      height: 200
                    },
                  });

var  $uploadCropPerfil = $('.img-perfil-corta').croppie({
                    
                    enableExif: true,
                    enforceBoundary:true,
                    enableOrientation:true,
                    enableResize:false,
                    viewport: {
                      width: 200,
                      height: 200,
                      type: 'circle'
                      
                    },
                    boundary: {
                      width: tela,
                      height: 300
                    },
                  });


            
            // $('#x').click(function(){
                //     var d = $uploadCrop.croppie().get();
                
                //     $('#result').html(JSON.stringify(d));
                // });
                

            </script>
    </body>
</html>
<?php

}catch (Exception $exc){     
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Ja esta logado  
        case 6://Ja esta logado 
        case 1:
            echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
            break;
        default:
            echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
    }      
}