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
    use Core\Debate;
    
    try{        
        $debate = new Debate();        

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $debate->setCodUsu($_SESSION['id_user']);            
            $tipoUsu = $_SESSION['tipo_usu'];
        }

        if(isset($_GET['ID'])){
            $debate->setCodDeba($_GET['ID']);
            
        }
        $resposta = $debate->listByIdDeba();   
        
        
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
                    <span class="dataHora"><?php echo $resposta[0]['dataHora_deba']?></span>
                </div>                    
            </div>
            <div class="conteudo">
                <div class="subConteudo"> 
                    <div class="descri">
                        <h2><?php echo $resposta[0]['nome_deba']?></h2>
                        <h3><?php echo $resposta[0]['tema_deba']?></h3>
                        <p><?php  echo nl2br($resposta[0]['descri_deba'])?></p>
                    </div>       
                    <?php
                            if(isset($resposta[0]['indParticipa']) AND $resposta[0]['indParticipa'] == TRUE){ 
                        ?>      
                            <span>Participantes: <?php echo $resposta[0]['qtdParticipantes']?> <b>Você já participa</b></span>                   
                                                  
                        <?php  
                            }else{
                        ?>
                            <span>Participantes: <?php echo $resposta[0]['qtdParticipantes']?></span>                       
                        <?php  
                            }
                        ?>                 
                    <figure>
                        <img src="../Img/debate/<?php echo $resposta[0]['img_deba']?>" class="imgPubli">
                    </figure>                 
        </div>                
      
                
        
    </body>
</html>
<?php


    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 9://Não foi possivel achar a publicacao  
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarDebatesTemplate.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='VisualizarDebatesTemplate.php';</script>";
        }   
    }  
?>