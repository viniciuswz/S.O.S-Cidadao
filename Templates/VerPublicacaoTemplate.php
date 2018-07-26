<?php
session_start();
    $NomeArquivo = dirname(__FILE__);
    $posicao = strripos($NomeArquivo, "\Templates");
    if($posicao){
        $NomeArquivo = substr($NomeArquivo, 0, $posicao);
    }
    define ('WWW_ROOT', $NomeArquivo); 
    define ('DS', DIRECTORY_SEPARATOR);    
    require_once('../autoload.php');
    
    use Core\Usuario;
    use Core\Publicacao;
    use Core\Comentario;
    
    try{        
        $publi = new Publicacao();
        $comentario = new Comentario();

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $publi->setCodUsu($_SESSION['id_user']);
            $comentario->setCodUsu($_SESSION['id_user']);
        }
        if(isset($_GET['ID'])){
            $publi->setCodPubli($_GET['ID']);
            $comentario->setCodPubli($_GET['ID']);
        }
        $resposta = $publi->listByIdPubli();
        //
        //$comentarioComum = $comentario->SelecionarComentariosUserComum();
        //$comentarioPrefei = $comentario->SelecionarComentariosUserPrefei();
        //var_dump($resposta);
?>

<html>
    <head>  
        <title>Ver publicacao</title>
        <style type="text/css">
            #topo{
                width:100%;
                height: 600px;
                background-color:red;
            }

            img.capa{
                width:100%;
                height:50%;
                //background-color:pink;
                
            }
            div.cabecalho{
                width:100%;
                height:25%;
                border-bottom: 5px solid yellow;
                //background-color: yellow;
            }
            img.perfil{
                width: 15%;
                height: 60%;
                //background-color: pink;
                position: relative;
                left: 0px;
                display: inline-block;
            }  
            .informacoesCabe{
                display: inline-block;
                width: 70%;
            }
            .conteudo{
                height: 75%;
                background-color: pink;
            }      
            .subConteudo{
                display:flex;
            }    
            figure{                
               
                display: inline-block;                
            }
            figcaption{
                font-weight: bold;
            }
            .imgPubli{
                height:300px;
                
            }
            p{
                width:width: 100%;
            }
            div.comenPrefei{
                padding-top:20px;
                width:100%;
                height:400px;
                background-color: red;
            }
            span{
                display: inline-block;
                width:50%;
            }
        </style>
    </head> 
    <body>
        <?php
            if(!isset($_SESSION['id_user'])){
                echo '<a href="loginTemplate.php">Fazer Login</a>';
            }else{
                echo '<a href="starter.php">Home</a>';
            }
        ?>
        <div id="topo">
            <div class="cabecalho">                  
                <img src="../Img/perfil/<?php echo $resposta[0]['img_perfil_usu']?>" class="perfil">
                <div class="informacoesCabe">
                    <span class="nomeUsu"><?php echo $resposta[0]['nome_usu']?></span>
                    <span class="dataHora"><?php echo $resposta[0]['dataHora_publi']?></span>
                </div>                    
            </div>
            <div class="conteudo">
                <div class="subConteudo"> 
                    <div class="descri">
                        <h2><?php echo $resposta[0]['titulo_publi']?></h2>
                        <h3><?php echo $resposta[0]['descri_cate']?></h3>
                        <p><?php  echo nl2br($resposta[0]['texto_publi'])?></p>
                    </div>                    
                    <figure>
                        <img src="../Img/publicacao/<?php echo $resposta[0]['img_publi']?>" class="imgPubli">
                        <figcaption>
                        <?php echo $resposta[0]['endereco_organizado_aberto']?>
                        </figcaption>
                    </figure>  
                </div>                
                <?php
                
                if(isset($resposta[0]['indCurtidaDoUser']) AND $resposta[0]['indCurtidaDoUser'] == TRUE){            
                    echo '<a href="../CurtirPublicacao.php?ID='.$_GET['ID'].'">Descurtir</a>';            
                }else{                     
                    echo '<a href="../CurtirPublicacao.php?ID='.$_GET['ID'].'">Curtir</a>';  
                }
            
                ?>              
            </div>   
        </div>  
        <?php 
            if(!empty($comentarioPrefei)){
        ?>
                <div class="comenPrefei">
                    <h1>Resposta Prefeitura:</h1>
                    <img src="../Img/perfil/<?php echo $comentarioPrefei[0]['img_perfil_usu']?>" class="perfil">
                    <div>
                    <span class="nomeUsu"><?php echo $comentarioPrefei[0]['nome_usu']?></span>
                    <span class="dataHora"><?php echo $comentarioPrefei[0]['dataHora_comen']?></span>
                    </div>
                    <p><?php echo $comentarioPrefei[0]['texto_comen']?></p>
                </div>
        <?php
            }
        ?>
        
    </body>
</html>
<?php


    }catch (Exception $exc){
        echo $exc->getMessage();
    }  
?>