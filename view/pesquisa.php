<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;  
    use Classes\ValidarCampos;
    use Classes\Pesquisa;
    try{
        //Usuario::verificarLogin(1);  // Vai estourar um erro se ele ja estiver logado
        $nomesCampos = array('pesquisa');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);       
        $pes = new Pesquisa();

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){           
            $tipoUsu = $_SESSION['tipo_usu'];
            $dados = new Usuario();
            $dados->setCodUsu($_SESSION['id_user']);
            $resultado = $dados->getDadosUser();
            $pes->setCodUsu($_SESSION['id_user']);
        }           
        $_GET['pesquisa'] = str_replace("+"," ", $_GET['pesquisa']);
        $pes->setTextoPesqui($_GET['pesquisa']);       
        
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;
        //isset($_GET['tipo']) ?: $_GET['tipo'] = null;
        $parametro = "";
        if(isset($_GET['tipo'])){            
            $contador = 1;
            foreach($_GET as $chaves => $valores){    
                    if($chaves == 'tipo'){
                        foreach($valores as $chave => $valor){
                            $tipos[] = $valor;
                            if($contador < count($_GET)){
                                $parametro .= 'tipo[]=';
                                $parametro .= $valor.'&';
                            }else{                            
                                $parametro .= 'tipo[]=';
                                $parametro .= $valor;
                            }
                            $parametro .= '&';
                            $contador++;  
                        }
                    }                    
            }
        }else{
            $_GET['tipo'][0] = "Deba";
            $_GET['tipo'][1] = "Publi";
            $parametro = "tipo[]=Deba&tipo[]=Publi";
        }   
        $resPes = $pes->pesquisar($_GET['pagina'],$_GET['tipo']);
        $quantidadePaginas = $pes->getQuantidadePaginas();
        $pagina = $pes->getPaginaAtual();        
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
        <script src="js/PegarPesquisa.js"></script>
        <script src="../teste.js"></script>

    </head>
    <body onload="jaquinha()">
        <header>
            <a href="todasreclamacoes.php">
                <img src="imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="pesquisa.php" method="get" id="form-pesquisa">
                <?php if(isset($_GET['pesquisa'])){?>
                    <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar" value="<?php echo $_GET['pesquisa'] ?>">
                <?php }else{ ?>
                    <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
                <?php } ?>
                <button type="submit"><i class="icone-pesquisa"></i></button>
            </form>
            <nav class="menu">
                <ul>
                    <li><nav class="notificacoes">
                        <h3>notificações</h3>
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

            
                <section class="filtro-admin">
                    <!-- <div>
                        <h3>você pesquisou por:</h3><p>Churroooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooos</p>
                    </div> -->
                    <i class="icone-filtro "></i>
                    <form action="pesquisa.php">
                        <span id="fechar-filtro">&times;</span>
                        <h3>estou procurando:</h3>
                        <div>
                                    
                            <label class="container"> Debates 
                            <?php if(isset($_GET['tipo']) AND in_array('Deba',$_GET['tipo'])) { ?>
                                <input type="checkbox" name="tipo[]" checked="checked" value="Deba">
                            <?php }else{ ?>
                                <input type="checkbox" name="tipo[]" value="Deba">
                            <?php } ?>
                                <span class="checkmark"></span>
                            </label>

                            <label class="container"> Reclamações
                            <?php if(isset($_GET['tipo']) AND in_array('Publi',$_GET['tipo'])) { ?>
                                <input type="checkbox" name="tipo[]" checked="checked" value="Publi">
                            <?php }else{ ?>
                                <input type="checkbox" name="tipo[]" value="Publi">
                            <?php } ?>
                                <span class="checkmark"></span>
                            </label>
                            <?php
                                if(isset($_GET['pesquisa'])){
                                    $pl = $_GET['pesquisa'];
                                    echo '<input type="hidden" name="pesquisa" value='.urlencode($pl).'>';
                                }
                            ?>

                        </div>
                        <input type="submit" class="botao-filtro" value="Filtrar">
                    </form>
                </section>
                <section class="alinha-item" id="pa">
                    <input type="hidden" id="parametros" value="<?php echo $parametro?>">
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
                    /*
                    $contador = 0;
                    while($contador < count($resPes)){       
                        if($resPes[$contador]['tipo'] == 'Debate'){
                    ?> 
                    <div class="item-publicacao db">
                        <div class="item-topo">
                            <a href="perfil_debate.php?ID=<?php echo $resPes[$contador]['cod_usu']?>">
                                <div>
                                    <img src="../Img/perfil/<?php echo $resPes[$contador]['img_perfil_usu']?>">
                                </div>
                                <p><span class="negrito"><?php echo $resPes[$contador]['nome_usu']?></a></span><time><?php echo $resPes[$contador]['dataHora_deba']?></time></p>
                                <div class="mini-menu-item">
                                    <i class="icone-3pontos"></i>
                                    <div>
                                        <ul>
                                        <?php
                                                    if(isset($resPes[$contador]['indDenunComen']) AND $resPes[$contador]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                                                        echo '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';        
                                                    }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resPes[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
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
                                                    if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resPes[$contador]['cod_usu']){
                                                        echo '<li><a href="../ApagarDebate.php?ID='.$resPes[$contador]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                        echo '<li><a href="debate-update.php?ID='.$resPes[$contador]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                                                    }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                                        echo '<li><a href="../ApagarDebate.php?ID='.$resPes[$contador]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                        // Icone para apagar usuaario
                                                        //echo '<a href="../ApagarUsuario.php?ID='.$resPes[0]['cod_usu'].'">Apagar Usuario</a>';                                                       
                                                        echo '<li><a href="debate-update.php?ID='.$resPes[$contador]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
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
                                                        <input type="hidden" name="id_deba" value="<?php echo $resPes[$contador]['cod_deba'] ?>">                
                                                        <button type="submit"> Denunciar</button>
                                                    </form>                                        
                                                </div>
                                            </div>
                                    <?php } ?>
                                </div>
                            </div>
                            <a href="Pagina-debate.php?ID=<?php echo $resPes[$contador]['cod_deba'] ?>">
                                <figure>
                                    <img src="../Img/debate/<?php echo $resPes[$contador]['img_deba']?>">
                                </figure>
                                <div class="legenda">
                                    <p><?php echo $resPes[$contador]['nome_deba']?></p><p><?php echo $resPes[$contador]['qtdParticipantes']?></p><i class="icone-grupo"></i>
                                </div>                                
                            </a>
                        </div>
                        <?php                  
                            }else if($resPes[$contador]['tipo'] == 'Publicacao'){
                        ?>               
                        <div class="item-publicacao rc">
                                <div class="item-topo">
                                    <a href="perfil_reclamacao.php?ID=<?php echo $resPes[$contador]['cod_usu'] ?>">
                                    <div>
                                        <img src="../Img/perfil/<?php echo $resPes[$contador]['img_perfil_usu']?>">
                                    </div>
                                    <p><span class="negrito"><?php echo $resPes[$contador]['nome_usu']?></a></span><time><?php echo $resPes[$contador]['dataHora_publi']?></time></p>
                                    <div class="mini-menu-item">
                                        <i class="icone-3pontos"></i>
                                        <div>
                                            <ul>
                                            <?php
                                                if(isset($resPes[$contador]['indDenunPubli']) AND $resPes[$contador]['indDenunPubli'] == TRUE){ // Aparecer quando o user ja denunciou            
                                                    echo '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';        
                                                }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resPes[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
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
                                                if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resPes[$contador]['cod_usu']){
                                                    echo '<li><a href="../ApagarPublicacao.php?ID='.$resPes[$contador]['cod_publi'].'"><i class="icone-fechar"></i></i>Remover</a></li>';                                            
                                                    echo '<li><a href="reclamacao-update.php?ID='.$resPes[$contador]['cod_publi'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                                }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                                    echo '<li><a href="../ApagarPublicacao.php?ID='.$resPes[$contador]['cod_publi'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                    // Icone para apagar usuaario
                                                    //echo '<a href="../ApagarUsuario.php?ID='.$resPes[0]['cod_usu'].'">Apagar Usuario</a>'; 
                                                    echo '<li><a href="reclamacao-update.php?ID='.$resPes[$contador]['cod_publi'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';
                                                }
                                            ?> 

                                            <?php
                                                if(isset($_SESSION['id_user']) AND isset($resPes[$contador]['indSalvaPubli']) AND $resPes[$contador]['indSalvaPubli'] == TRUE){//Salvou
                                                    echo '<li><a href="../SalvarPublicacao.php?ID='.$resPes[$contador]['cod_publi'].'"><i class="icone-salvar-full"></i>Salvo</a></li>';
                                                }else if(isset($_SESSION['id_user']) AND isset($resPes[$contador]['indSalvaPubli']) AND $resPes[$contador]['indSalvaPubli'] == FALSE){//Nao salvou
                                                    echo '<li><a href="../SalvarPublicacao.php?ID='.$resPes[$contador]['cod_publi'].'"><i class="icone-salvar"></i>Salvar</a></li>';
                                                }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                                                    echo '<li><a href="../SalvarPublicacao.php?ID='.$resPes[$contador]['cod_publi'].'"><i class="icone-salvar"></i>Salvar</a></li>';
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
                                                        <input type="hidden" name="id_publi" value="<?php echo $resPes[$contador]['cod_publi'] ?>">                
                                                        <button type="submit"> Denunciar</button>
                                                    </form>
                                                        
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <a href="reclamacao.php?ID=<?php echo $resPes[$contador]['cod_publi'] ?>">
                                <?php
                                    if(!empty($resPes[$contador]['img_publi'])){
                                ?>
                                    <figure>
                                        <img src="../Img/publicacao/<?php echo $resPes[$contador]['img_publi']?>">
                                    </figure>   
                                <?php
                                    }
                                ?>   
                                    <p><?php echo $resPes[$contador]['titulo_publi']?></p>
                                    </a>
                                    <div class="item-baixo">   
                                        <i class="icone-local"></i><p><?php echo $resPes[$contador]['endereco_organizado_fechado']?></p>
                                        <div>    
                                            <span><?php echo $resPes[$contador]['quantidade_curtidas']?></span><i class="icone-like"></i>
                                            <span><?php echo $resPes[$contador]['quantidade_comen']?></span><i class="icone-comentario"></i>
                                        </div>
                                    </div>
                            </div>
                            <?php   
                                }
                                $indDenun = false;
                                $contador++;
                                }
                                */
                            ?>    
                    </section>
                    <ul>
                            <?php
                            /*
                                if($quantidadePaginas != 1){
                                    $contador = 1;
                                    while($contador <= $quantidadePaginas){
                                        if(isset($pagina) AND $pagina == $contador){
                                            echo '<li class="jaca"><a href="pesquisa.php?pagina='.$contador.'&pesquisa='.$_GET['pesquisa'].'&'.$parametro.'">Pagina'.$contador.'</a></li>'  ;  
                                        }else{
                                            echo '<li><a href="pesquisa.php?pagina='.$contador.'&pesquisa='.$_GET['pesquisa'].'&'.$parametro.'">Pagina'.$contador.'</a></li>'  ;
                                        }
                                        
                                        $contador++;        
                                    }
                                }
                                */
                            ?>
                    </ul>                  
        </div>
    </body>
</html>
<?php
}catch (Exception $exc){
         echo $exc->getMessage();
}

?>
