<?php
    if(!file_exists('Config/Config.php')){        
        echo "<script>javascript:window.location='todasreclamacoes';</script>";       
    }
    session_start();
    require_once('Config/Config.php');
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
        $_GET['pesquisa'] = str_replace(";","", $_GET['pesquisa']);
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
        <link rel="shortcut icon" href="view/imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="view/css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="view/css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="view/css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="view/css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="view/css/style1025.css">

        <!-- JS-->

        <script src="view/lib/_jquery/jquery.js"></script>
        <script src="view/js/js.js"></script>
        <script src="view/js/PegarPesquisa.js"></script>
        <script src="teste.js"></script>

    </head>
    <body onload="jaquinha()">
        <header>
            <a href="todasreclamacoes">
                <img src="view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="pesquisa" method="get" id="form-pesquisa"> 
                <?php if(isset($_GET['pesquisa'])){?>
                    <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar" value="<?php echo filter_var($_GET['pesquisa'], FILTER_SANITIZE_STRING) ?>">
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
                    <li><a href="todasreclamacoes"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="todosdebates"><i class="icone-debate"></i>Debates</a></li>
                </ul>
            </nav>
            <?php
                if(!isset($resultado)){  
                    echo '<a href="login"><i class="icone-user" id="abrir"></i></a>';
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
                                <img src="Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>" alt="perfil">
                            </div>    
                                <img src="Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
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

            
                <section class="filtro-admin" style="background-color:white">
                    <!-- <div>
                        <h3>você pesquisou por:</h3><p>Churroooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooooos</p>
                    </div> -->
                    <i class="icone-filtro "></i>
                    <form action="pesquisa">
                        <span id="fechar-filtro">&times;</span>
                        <h3>estou procurando:</h3>
                        <div>

                            <?php
                                if(isset($_GET['pesquisa'])){
                                    $pl = strtolower(preg_replace( '/[`,^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $_GET['pesquisa'] )));   
                                    $pl = filter_var($pl, FILTER_SANITIZE_STRING);   
                                    echo '<input type="hidden" name="pesquisa" value='.urlencode($pl).'>';
                                }
                            ?>

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
                </section>                     
        </div>
    </body>
</html>
<?php
}catch (Exception $exc){
         echo $exc->getMessage();
}

?>
