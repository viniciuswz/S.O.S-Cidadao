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
        //Usuario::verificarLogin(1);  // Vai estourar um erro se ele ja estiver logado
        $publi = new Publicacao();        
        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $publi->setCodUsu($_SESSION['id_user']);
        }        
        if(isset($_GET['pagina'])){            
            $resposta = $publi->ListFromALL($_GET['pagina']);
        }else{            
            $resposta = $publi->ListFromALL();
        }
            $quantidadePaginas = $publi->getQuantidadePaginas();
            $pagina = $publi->getPaginaAtual();
        
        
?>

<html>
    <head>
        <title>Publicações</title>
        <style type="text/css">                   
                       
            div.agrupa{
                display:flex;
                flex-wrap: wrap;
                justify-content: center;
            }
            div.item{
                //background-color:red;
                width:  400px;
                height: 270px;
                margin: 10px;
                border: 2px solid red;
            }              
            img.capa{
                width:100%;
                height:50%;
                //background-color:pink;
                
            }
            div.cabecalho{
                width:100%;
                height:25%;
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
            div.rodape{
                width:100%;
                height:25%;
                //background-color: blue;
            }
            div.informacoesCabe{
                width:80%;
                // background-color: pink;
                display: inline-block;
            }
            
            span{
                width:85%;
                display:block;
            }
            span.nomeUsu{
                font-size:20px;
            }
            span.titulo{
                font-size:20px;
            }
            span.curtidas, span.comen{
                display: inline-block;
                width: auto;
                margin-left: 20px;
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
        <div class="agrupa">
        <?php
            $contador = 0;
            while($contador < count($resposta)){
                
        ?>  
                <div class="item">  
                    <a href="VerPublicacaoTemplate.php?ID=<?php echo $resposta[$contador]['cod_publi'] ?>">
                        <div class="cabecalho">                  
                            <img src="../Img/perfil/<?php echo $resposta[$contador]['img_perfil_usu']?>" class="perfil">
                            <div class="informacoesCabe">
                                <span class="nomeUsu"><?php echo $resposta[$contador]['nome_usu']?></span>
                                <span class="dataHora"><?php echo $resposta[$contador]['dataHora_publi']?></span>
                            </div>                    
                        </div>
                    </a> 
                    <?php
                        if(!empty($resposta[$contador]['img_publi'])){
                    ?>  
                            <img src="../Img/publicacao/<?php echo $resposta[$contador]['img_publi']?>" class="capa">
                        
                    <?php
                        }
                    ?>
                    <div class="rodape">
                        <span class="titulo"><?php echo $resposta[$contador]['titulo_publi']?></span>
                        <span class="endereco"><?php echo $resposta[$contador]['endereco_organizado_fechado']?></span>
                        <?php
                            if($resposta[$contador]['indCurtidaDoUser']){ 
                        ?>                             
                            <span class="curtidas">Curtidas<b> (Você ja curtiu):</b> <?php echo $resposta[$contador]['quantidade_curtidas']?></span>                       
                        <?php  
                            }else{
                        ?>
                            <span class="curtidas">Curtidas: <?php echo $resposta[$contador]['quantidade_curtidas']?></span>                     
                        <?php  
                            }
                        ?>
                        <span class="comen">Comentario: <?php echo $resposta[$contador]['quantidade_comen']?></span>
                        
                    </div>
                </div> 
              
        <?php
                  
                $contador++;
            }
        ?>        
        </div>      
        <ul>
        <?php
            if($quantidadePaginas != 1){
                $contador = 1;
                while($contador <= $quantidadePaginas){
                    if(isset($pagina) AND $pagina == $contador){
                        echo '<li class="jaca"><a href="VisualizarPublicacoesTemplate.php?pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;  
                    }else{
                        echo '<li><a href="VisualizarPublicacoesTemplate.php?pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;
                    }
                    
                    $contador++;        
                }
            }
            
        ?>
        </ul>
    </body>
</html>

<?php
}catch (Exception $exc){
         
}

?>