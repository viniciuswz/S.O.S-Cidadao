<?php
    if(!file_exists('Config/Config.php')){        
        echo "<script>javascript:window.location='todasreclamacoes';</script>";       
    }
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    use Core\Usuario;
    
    try{
        $tipoUsuPermi = array('Prefeitura','Adm','Funcionario','Moderador','Comum');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         
        $usu = new Usuario(); 
        $usu->setCodUsu($_SESSION['id_user']);
        $resultado = $usu->getDadosUser(true);  
        $dadosUrl = explode('/', $_GET['url']);
        if(count($dadosUrl) > 1){ // injetou parametros
            throw new \Exception('Não foi possível achar o debate',45);
        }
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>Configurações do seu perfil</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="altere seu perfil, um nome ou email, você que sabe.">
        <meta name=keywords content="Reclamação, Barueri, Conta, Configuração, Editar perfil"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI3A'>
        <meta name="theme-color" content="#089E8E"/>

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="view/imagens/favicon.ico" type="view/image/x-icon">

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
        <script src="teste.js"></script>

    </head>
    <body style="background-color:white">
        <header>
            <a href="todasreclamacoes">
                <img src="view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="pesquisa" method="get" id="form-pesquisa">
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
            <section class="perfil-base" >
                <h3>Configurações da conta</h3>
                <div class="perfil" id="config">
                <img src="Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
                </div>
                <div class="perfil-info">
                    <span><?php echo $resultado[0]['dataHora_cadastro_usu'] ?></span>
                        <div>
                        <img src="Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>">
                        </div> 
                </div>
               
            </section>
            <nav class="menu-perfil">
                <ul class="espacos">
                    <li class="ativo"><a href="configuracoes">Pessoais</a></li>

            <li><a href="configuracoes2">Segurança</a></li>

                    
                    
                </ul>
            </nav>
            <section class="form-config">
                
                <form id="FormUpdateNomeEmail" method="post">
                    <div class="campo-texto-config">
                            <label for="user">Nome</label>
                            <input type="text" name="nome" id="user" placeholder="Nome" autocomplete ="off" value="<?php echo $resultado[0]['nome_usu'] ?>">
                        </div>
                        <div class="campo-texto-config">
                            <label for="email">E-mail</i></label>
                            <input type="email" name="email" id="email" placeholder="E-mail" value="<?php echo $resultado[0]['email_usu'] ?>">
                    </div>
                    <div class="aviso-form-inicial">
                        <p>O campo tal e pa</p>
                    </div>
                    <button type="submit">Alterar</button>
                    <?php if ($_SESSION['tipo_usu'] != 'Prefeitura' AND $_SESSION['tipo_usu'] != 'Funcionario'){ ?>
                        <span class="desativar-btn">
                                Desativar conta
                        </span>
                    <?php } ?>
                </form>
                <?php if ($_SESSION['tipo_usu'] != 'Prefeitura' AND $_SESSION['tipo_usu'] != 'Funcionario'){ ?>
                        <div class="modal-desativar">
                            <div class="modal-desativar-fundo"></div>
                            <div class="box-desativar">
                                <div>
                                    <h1>Vai desativar a conta?</h1>
                                    <span class="fechar-desativar">&times;</span>
                                </div>
                                <div>
                                    <p>Depois que confirmar, <strong style="text-transform :uppercase" >não</strong> vai mais poder recuperar sua conta de nenhuma forma, ainda quer desativar sua conta?</p>
                                    <a href="ApagarUsuario.php?ID=<?php echo$_SESSION['id_user']?>">Desativar conta</a>
                                </div>
                            </div>
                        </div>
                <?php } ?>
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
        case 2://Ja esta logado  
        case 6://Ja esta logado 
            echo "<script>javascript:window.location='todasreclamacoes';</script>";
            break;       
        case 45://Digitou um numero maior de parametros 
            unset($dadosUrl[0]);
            $contador = 1;
            $voltar = "";
            while($contador <= count($dadosUrl)){
                $voltar .= "../";
                $contador++;
            }
            echo "<script>javascript:window.location='".$voltar."configuracoes';</script>";
            break;
    }      
}