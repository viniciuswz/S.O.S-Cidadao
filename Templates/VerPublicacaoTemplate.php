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
    
    try{        
        $publi = new Publicacao();        
        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $publi->setCodUsu($_SESSION['id_user']);
        }
        if(isset($_GET['ID'])){
            $publi->setCodPubli($_GET['ID']);
        }
        $resposta = $publi->listByIdPubli();
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
            .conteudo{
                height: 75%;
                background-color: pink;
            }          
            figure{
                position: relative;
                left: calc(270vh/2);
                top:-150px
            }
            figcaption{
                font-weight: bold;
            }
            .imgPubli{
                height:80%;
                
            }
        </style>
    </head> 
    <body>
        <div id="topo">
            <div class="cabecalho">                  
                <img src="../Img/perfil/<?php echo $resposta[0]['img_perfil_usu']?>" class="perfil">
                <div class="informacoesCabe">
                    <span class="nomeUsu"><?php echo $resposta[0]['nome_usu']?></span>
                    <span class="dataHora"><?php echo $resposta[0]['dataHora_publi']?></span>
                </div>                    
            </div>
            <div class="conteudo">
                <h2><?php echo $resposta[0]['titulo_publi']?></h2>
                <h3><?php echo $resposta[0]['descri_cate']?></h3>
                <p><?php  echo nl2br($resposta[0]['texto_publi'])?></p>
                <figure>
                    <img src="../Img/publicacao/<?php echo $resposta[0]['img_publi']?>" class="imgPubli">
                    <figcaption>
                    <?php echo $resposta[0]['endereco_organizado_aberto']?>
                    </figcaption>
                </figure>                
            </div>
        </div>
    </body>
</html>
<?php


    }catch (Exception $exc){
        echo $exc->getMessage();
    }  
?>