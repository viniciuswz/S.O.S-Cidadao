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

        if(isset($_GET['pagina'])){            
            $comentarioComum = $comentario->SelecionarComentariosUserComum($_GET['pagina']);
        }else{            
            $comentarioComum = $comentario->SelecionarComentariosUserComum();
        }
        $resposta = $publi->listByIdPubli();   
        $comentarioPrefei = $comentario->SelecionarComentariosUserPrefei();

        $quantidadePaginas = $comentario->getQuantidadePaginas();
        $pagina = $comentario->getPaginaAtual();
        //var_dump($comentarioComum);
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
            div.comenComum{
                padding-top:20px;
                width:100%;
                height:400px;
                background-color: pink;
            }
            span{
                display: inline-block;
                width:50%;
            }
            img.prefei{
                width: 15%;
                height: 30%;
                //background-color: pink;
                position: relative;
                left: 0px;
                display: inline-block;
            }  
            ul{
                text-align: center;
            }
            ul li{
                display: inline-block;
                margin-left: 10px;
                background-color: pink;
                width: 100px
            }
            ul li:hover{
                background-color: red;
            }
            ul li a{
                text-decoration: none;
                color: black;
                font-size: 20px;
            }
            .jaca {
                background-color:green;
            }
            .arruma{
                display:flex;                
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
                    <img src="../Img/perfil/<?php echo $comentarioPrefei[0]['img_perfil_usu']?>" class="prefei">
                    <div class="informacoesCabe">
                        <span class="nomeUsu"><?php echo $comentarioPrefei[0]['nome_usu']?></span>
                        <span class="dataHora"><?php echo $comentarioPrefei[0]['dataHora_comen']?></span>
                    </div>
                    <p><?php echo $comentarioPrefei[0]['texto_comen']?></p>
                </div>
        <?php
            }
        ?>

         <?php 
            if(!empty($comentarioComum)){
        ?>      
            <h1>Comentarios</h1> 
            <div class="arruma">
               
        <?php 
                $contador = 0;
                while($contador < count($comentarioComum)){
        ?>        
                <div class="comenComum">
                   

                    <img src="../Img/perfil/<?php echo $comentarioComum[$contador]['img_perfil_usu']?>" class="prefei">
                    <div class="informacoesCabe">
                        <span class="nomeUsu"><?php echo $comentarioComum[$contador]['nome_usu']?></span>
                        <span class="dataHora"><?php echo $comentarioComum[$contador]['dataHora_comen']?></span>
                    </div>
                    <p><?php echo $comentarioComum[$contador]['texto_comen']?></p>
                </div>
        <?php
                    $contador++;
                }
        echo '</div>';
        echo '<ul>';
        
            if($quantidadePaginas != 1){
                $contador = 1;
                while($contador <= $quantidadePaginas){
                    if(isset($pagina) AND $pagina == $contador){
                        echo '<li class="jaca"><a href="VerPublicacaoTemplate.php?ID='.$_GET['ID'].'&pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;  
                    }else{
                        echo '<li><a href="VerPublicacaoTemplate.php?ID='.$_GET['ID'].'&pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;
                    }
                    
                    $contador++;        
                }
            }
            
        
        echo '</ul>';
            }
        ?>
        
    </body>
</html>
<?php


    }catch (Exception $exc){
        echo $exc->getMessage();
    }  
?>