<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    use Core\Publicacao;
    
    try{
        //Usuario::verificarLogin(1);  // Vai estourar um erro se ele ja estiver logado
        $publi = new Publicacao();        
        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $publi->setCodUsu($_SESSION['id_user']);
        }    
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;    
                   
        $resposta = $publi->ListFromALL($_GET['pagina']);
        
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
            a.curtidas, span.comen{
                display: inline-block;
                width: auto;
                margin-left: 5px;
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
                            if(isset($resposta[$contador]['indCurtidaDoUser']) AND $resposta[$contador]['indCurtidaDoUser'] == TRUE){ 
                        ?>      
                            <a href='../CurtirPublicacao.php?ID=<?php echo $resposta[$contador]['cod_publi']?>&pagina=<?php echo $pagina?>' class="curtidas">Descurtir<b> (Você ja curtiu):<?php echo $resposta[$contador]['quantidade_curtidas']?></b></a>                   
                                                  
                        <?php  
                            }else{
                        ?>
                            <a href='../CurtirPublicacao.php?ID=<?php echo $resposta[$contador]['cod_publi']?>&pagina=<?php echo $pagina?>'  class="curtidas">Curtir<b>: <?php echo $resposta[$contador]['quantidade_curtidas']?></b></a>                       
                        <?php  
                            }
                        ?>

                         <?php
                            if(isset($resposta[$contador]['indResPrefei']) AND $resposta[$contador]['indResPrefei'] == TRUE){ 
                        ?>      
                            <span class="comen">Comentario: <?php echo $resposta[$contador]['quantidade_comen']?> (<b>Respondida</b>)</span>                   
                                                  
                        <?php  
                            }else{
                        ?>
                            <span class="comen">Comentario: <?php echo $resposta[$contador]['quantidade_comen']?></span>                       
                        <?php  
                            }
                        ?>
                        
                        
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