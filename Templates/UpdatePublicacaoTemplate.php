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
    use Classes\ValidarCampos;
    use Core\Categoria;
    try{        

        $tipoUsuPermi = array('Comum','Adm','Moderador');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado

        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL  
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero

        $tipoUsu = $_SESSION['tipo_usu'];        
        $publi = new Publicacao();        
        $publi->setCodUsu($_SESSION['id_user']);
        $publi->setCodPubli($_GET['ID']);
        $resposta = $publi->listByIdPubli(TRUE);  // True = Tem q ser o dono da publicacao  

        $cate = new Categoria();
        $categorias = $cate->gerarOptions($resposta[0]['descri_cate']);        
?>

<html>
    <head>  
        <title>Editar Publicacao</title>
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
            echo '<a href="starter.php">Home</a>';        
        ?>
        <h1>Editar !!!</h1>
        <div id="topo">
            <div class="cabecalho">                  
                <img src="../Img/perfil/<?php echo $resposta[0]['img_perfil_usu']?>" class="perfil">
                <div class="informacoesCabe">
                    <span class="nomeUsu"><?php echo $resposta[0]['nome_usu']?></span>
                    <span class="dataHora"><?php echo $resposta[0]['dataHora_publi']?></span>
                </div>                    
            </div>
            <div class="conteudo">
            <form action="../UpdatePublicacao.php" method="post" enctype="multipart/form-data">
                <div class="subConteudo"> 
                    <div class="descri">
                        <h2>Titulo: <input type="text" name="titulo" value="<?php echo $resposta[0]['titulo_publi']?>"></h2>
                        <h3>Categoria: 
                            <select name="categoria">
                                <?php
                                    foreach($categorias as $valor){
                                        echo $valor;
                                    }
                                ?>
                            </select>
                        </h3>
                        <textarea cols="70" rows="10" name="texto">
<?php echo trim($resposta[0]['texto_publi']) ?>
                        </textarea>
                        
                    </div>                    
                    <figure>
                        <h2>Imagem atual:</h2>
                        <img src="../Img/publicacao/<?php echo $resposta[0]['img_publi']?>" class="imgPubli">
                        <figcaption>
                                <br >
                            <input type="file" name="imagem" accept="image/png, image/jpeg" />                                                  
                                <br>
                            <label>Local: <input type="text" name="local" value="<?php echo $resposta[0]['endere_logra']?>"></label>
                                <br >
                            <label>Bairro: <input type="text" name="bairro" value="<?php echo $resposta[0]['nome_bai']?>"></label>
                                <br >
                            <label>Cep: <input type="text" name="cep" value="<?php echo $resposta[0]['cep_logra']?>"></label>                           
                        </figcaption>
                    </figure>  
                </div>                
                <br>
                <input type="hidden" name="id_publi" value="<?php echo $_GET['ID']?>">
                <input type="submit" value="Editar !!!">
            </form>       
                
            </div>   
        </div>          
    </body>
</html>
<?php


    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 9://Não foi possivel achar a publicacao  
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
        }   
    }  
?>