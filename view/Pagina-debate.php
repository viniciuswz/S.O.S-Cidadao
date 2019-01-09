<?php
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    
    use Core\Usuario;    
    use Core\Debate;
    use Classes\ValidarCampos;
    use Notificacoes\Core\VisualizarNotificacao;
    try{        
        $debate = new Debate();        

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $debate->setCodUsu($_SESSION['id_user']); 
            $tipoUsu = $_SESSION['tipo_usu'];
            $dados = new Usuario();
            $dados->setCodUsu($_SESSION['id_user']); 
            $resultado = $dados->getDadosUser();
        }
        
        $dadosUrl = explode('/', $_GET['url']);
        if(!isset($dadosUrl[1])){
            throw new \Exception('Não foi possível achar o debate',9);
        }
        $voltar = '../';
        $_GET['ID'] = $dadosUrl[1]; // passando o id pra variavel GET
        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero        

        $debate->setCodDeba($_GET['ID']);        
        $resposta = $debate->listByIdDeba();          
        
        if(isset($resposta[0]['indParticipa']) AND $resposta[0]['indParticipa'] === 'Banido' ){
            $txtButton = 'Você foi Banido';
            $link = '#';
        }else if(isset($resposta[0]['indParticipa']) AND $resposta[0]['indParticipa'] == TRUE
        OR isset($tipoUsu) AND ($tipoUsu == 'Adm' OR $tipoUsu == 'Moderador' OR $tipoUsu == 'Prefeitura' OR $tipoUsu == 'Funcionario')){            
            $txtButton = 'Entrar no debate';
            $link = 'debate_mensagens.php';
        }else{
            $txtButton = 'Participar do debate';
            $link = '../InserirParticipante.php';
        }        

        if(isset($dadosUrl[2])){
            $voltar .= '../';      
            if(isset($_SESSION['id_user'])){ 
                $_GET['com'] = $dadosUrl[2];  
                        
                $visualizar = new VisualizarNotificacao();                
                $idNoti = $_GET['ID'];                
                $visualizar->visualizarNotificacao($_GET['com'], $idNoti, $_SESSION['id_user']);
            }                  
        }   

        if(isset($dadosUrl[3])){ //não pode ter mais de dois parametros
            throw new \Exception('Não foi possível achar o debate',9);
        }
       
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title><?php echo $resposta[0]['nome_deba']?>, Em Barueri</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Site de reclamações para a cidade de Barueri">
        <meta name=keywords content="Reclamação, Barueri, Debate, Grupo, Forum, Discussão"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI3A'>
        <meta name="theme-color" content="#089E8E" />

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="<?php echo $voltar ?>imagens/favicon.ico" type="image/x-icon">

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
        <script src="<?php echo $voltar ?>teste.js"></script>

    </head>
    <body style="background-color:white">
        <header>
            <a href="<?php echo $voltar ?>todasreclamacoes">
                <img src="<?php echo $voltar ?>view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="pesquisa" method="post" id="form-pesquisa">
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

                if(isset($_GET['atu']) AND $_GET['atu'] == '1' AND !empty($_SESSION['atu'])){
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
                    <<nav>
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
                <section class="pag-debate">
                    <div class="debate">   
                        <div class="publicacao-topo-aberta">
                            <a href="">
                            <div>
                                <img src="<?php echo $voltar ?>Img/perfil/<?php echo $resposta[0]['img_perfil_usu']?>">
                            </div>
                            <p><span class="negrito"><?php echo $resposta[0]['nome_usu']?></span></a><time><?php echo $resposta[0]['dataHora_deba']?></time></p>
                            <div class="mini-menu-item ">
                                
                            <i class="icone-3pontos"></i>
                                <div>
                                <ul>
                                        <?php
                                            if(isset($resposta[0]['indDenunComen']) AND $resposta[0]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                                                echo '<li><i class="icone-bandeira"></i><span class="negrito">Denunciado</span></li>';        
                                            }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[0]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                                if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                                                    echo '<li class="denunciar-item" data-id="'.$resposta[0]['cod_deba'].'.Debate"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                    $indDenun = TRUE; // = carregar modal da denucia                                                    
                                                }                    
                                            }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                                                echo '<li class="denunciar-item" data-id="'.$resposta[0]['cod_deba'].'.Debate"><a href="#"><i class="icone-bandeira"></i>Denunciar</a></li>';
                                                $indDenun = TRUE; // = carregar modal da denucia
                                            } 
                                        ?>
                                        <?php
                                            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[0]['cod_usu']){
                                                echo '<li><a href="ApagarDebate.php?ID='.$resposta[0]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                echo '<li><a href="debate-update.php?ID='.$resposta[0]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                                            }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                                                echo '<li><a href="ApagarDebate.php?ID='.$resposta[0]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                                                // Icone para apagar usuaario
                                                //echo '<a href="../ApagarUsuario.php?ID='.$resposta[0]['cod_usu'].'">Apagar Usuario</a>';                                                       
                                                echo '<li><a href="debate-update.php?ID='.$resposta[0]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                                            }
                                        ?> 
                                    </ul>
                                </div>
                                <?php if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos?>
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
                                <?php } ?>
                            </div>
                        </div>
                        <div class="publicacao-conteudo-debate">
                            <img src="<?php echo $voltar ?>Img/debate/<?php echo $resposta[0]['img_deba']?>">
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
                            <a href="<?php echo $link ?>?ID=<?php echo $_GET['ID']?>&pagina=ultima"><?php echo $txtButton ?></a>
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
                echo "<script> alert('$mensagem');javascript:window.location='todosdebates.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='todosdebates.php';</script>";
        }   
    }  
?>
