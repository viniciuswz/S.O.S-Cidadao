<?php
    if(!file_exists('Config/Config.php')){        
        echo "<script>javascript:window.location='todasreclamacoes';</script>";       
    }
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    use Core\Publicacao;
    
    try{
        $tipoUsuPermi = array('Funcionario','Prefeitura');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado
        $dadosUrl = explode('/', $_GET['url']);

        $voltar = "";
        if(count($dadosUrl) >= 3){ // ingetou parametros
            throw new \Exception('Não foi possível achar a listagem',45);
        }else if(isset($dadosUrl[1])){ // tem pagina
            $voltar = "../";
            $_GET['pagina'] = $dadosUrl[1];
        }

        $dados = new Usuario();
        $dados->setCodUsu($_SESSION['id_user']);
        $resultado = $dados->getDadosUser();  

        $publi = new Publicacao();       
        $publi->setCodUsu($_SESSION['id_user']);         
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;
        $resposta = $publi->getPubliNRespo($_GET['pagina']);
        $quantidadePaginas = $publi->getQuantidadePaginas();
        $pagina = $publi->getPaginaAtual();
        
        if(empty($resposta)){
            echo 'Não há nenhuma publicacao para responder<br>';
        }
        
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>Área da Prefeitura</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Área restrita a usuários autorizados">
      
        <meta name=author content='equipe 4 INI3A'>
        <meta name="theme-color" content="#089E8E" />

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="<?php echo $voltar?>view/imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="<?php echo $voltar?>view/css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="<?php echo $voltar?>view/css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="<?php echo $voltar?>view/css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="<?php echo $voltar?>view/css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="<?php echo $voltar?>view/css/style1025.css">

        <!-- JS-->

        <script src="<?php echo $voltar?>view/lib/_jquery/jquery.js"></script>
        <script src="<?php echo $voltar?>view/js/js.js"></script>
        <script src="<?php echo $voltar?>teste.js"></script>

    </head>
    <body class="sempre-branco">
        <header>
            <a href="<?php echo $voltar?>todasreclamacoes">
                <img src="<?php echo $voltar?>view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="<?php echo $voltar?>pesquisa" method="get" id="form-pesquisa">
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
                    <li><a href="<?php echo $voltar?>todasreclamacoes"><i class="icone-reclamacao"></i>Publicações</a></li>
                    <li><a href="<?php echo $voltar?>view/todosdebates"><i class="icone-debate"></i>Fórum</a></li>
                </ul>
            </nav>
            <?php
                if(!isset($resultado)){
                    echo '<a href="'.$voltar.'login"><i class="icone-user" id="abrir"></i></a>';
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
                    <img src="<?php echo $voltar?>Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>" alt="perfil">
                </div>    
                    <img src="<?php echo $voltar?>Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
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


            <section class="tabelinha-admin" >
                <table>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Usuário</th>
                    </tr>
                    <?php
                        $contador = 0;
                        while($contador < count($resposta)){                           
                            echo '<tr class="tabelinha-linha">';  
                                echo '<td>
                                <div class="mini-menu-adm">
                                    <ul>
                                    <li><a href="'.$voltar.'reclamacao/'.$resposta[$contador]['cod_publi'].'">Visitar Página</a>
                                    </ul>
                                </div>
                                <p>'.$resposta[$contador]['titulo_publi'].'</p>
                                </td>';                      
                                echo '<td><p>'.$resposta[$contador]['descri_cate'].'</p></td>'; 
                                echo '<td><p>'.$resposta[$contador]['nome_usu'].'</p></td>'; 
                            echo '</tr>';                            
                            $contador++;                            
                            }
                    ?>                    
                </table>
            </section>   
            <ul class="paginacao">
                <?php
                    if($quantidadePaginas != 1){
                        $contador = 1;
                        while($contador <= $quantidadePaginas){
                            if(isset($pagina) AND $pagina == $contador){
                                echo '<li class="jaca"><a href="'.$voltar.'prefeitura-reclamacao/'.$contador.'">'.$contador.'</a></li>'  ;  
                            }else{
                                echo '<li><a href="'.$voltar.'prefeitura-reclamacao/'.$contador.'">'.$contador.'</a></li>'  ;
                            }
                            
                            $contador++;        
                        }
                    }
                    
                ?>
        </ul>   
        </div>
</body>
<?php
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){
        case 2://Nao esta logado           
            echo "<script>javascript:window.location='../login';</script>";
            break;
        case 6://Não é usuario prefeitura ou func  
            echo "<script>javascript:window.location='../todasreclamacoes';</script>";
            break; 
        case 9://Não foi possivel achar a publicacao  
            echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
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
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='../todasreclamacoes';</script>";
    }   
}

?>