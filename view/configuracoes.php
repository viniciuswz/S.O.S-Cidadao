<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    use Core\Usuario;
    
    try{
        $tipoUsuPermi = array('Prefeitura','Adm','Funcionario','Moderador','Comum');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         
        $usu = new Usuario(); 
        $usu->setCodUsu($_SESSION['id_user']);
        $resultado = $usu->getDadosUser(true);  
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
            <img src="imagens/logo_oficial.png" alt="logo">
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
                <section class="perfil-base">
                        <h3>Configurações da conta</h3>
                        <div class="perfil" id="config">
                            
                                <div>
                                        <span><?php echo $resultado[0]['dataHora_cadastro_usu'] ?></span>
                                        
                                        <div>
                                            <img src="../Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>">
                                        </div>
                                    </div>
                                </div>
                       
                    </section>
            <nav class="menu-perfil">
                <ul class="espacos">
                    <li class="ativo"><a href="configuracoes.php">pessoais</a></li>

            <li><a href="configuracoes2.php">Segurança</a></li>

                    
                    
                </ul>
            </nav>
            <section class="form-config">
                
                <form action="../updateNomeEmail.php" method="post">
                    <div class="campo-texto-config">
                            <label for="user">Nome</label>
                            <input type="text" name="nome" id="user" placeholder="Nome" autocomplete ="off" value="<?php echo $resultado[0]['nome_usu'] ?>">
                        </div>
                        <div class="campo-texto-config">
                            <label for="email">E-mail</i></label>
                            <input type="email" name="email" id="email" placeholder="E-mail" value="<?php echo $resultado[0]['email_usu'] ?>">
                    </div>
                    <button type="submit">Alterar</button>
                    <span class="desativar-btn">
                            Desativar conta
                    </span>
                </form>
                <div class="modal-desativar">
                    <div class="modal-desativar-fundo"></div>
                    <div class="box-desativar">
                        <div>
                            <h1>Vai desativar a conta?</h1>
                            <span class="fechar-desativar">&times;</span>
                        </div>
                        <div>
                            <p>Depois que confirmar, <strong style="text-transform :uppercase" >não</strong> vai mais poder recuperar sua conta de nenhuma forma, ainda quer desativar sua conta?</p>
                            <a href="#">Desativar conta</a>
                        </div>
                    </div>
                </div>
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
            echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
            break;
       
    }      
}finally{

}