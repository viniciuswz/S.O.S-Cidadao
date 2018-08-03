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
        } 
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;        
        
        $resposta = $debate->ListFromALL($_GET['pagina']);       
        $quantidadePaginas = $debate->getQuantidadePaginas();
        $pagina = $debate->getPaginaAtual();
        
       
        
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
                    <a href="VerDebateTemplate.php?ID=<?php echo $resposta[$contador]['cod_deba'] ?>">
                        <div class="cabecalho">                  
                            <img src="../Img/perfil/<?php echo $resposta[$contador]['img_perfil_usu']?>" class="perfil">
                            <div class="informacoesCabe">
                                <span class="nomeUsu"><?php echo $resposta[$contador]['nome_usu']?></span>
                                <span class="dataHora"><?php echo $resposta[$contador]['dataHora_deba']?></span>
                            </div>                    
                        </div>
                    </a> 
                        <img src="../Img/debate/<?php echo $resposta[$contador]['img_deba']?>" class="capa">
                        
                    
                    <div class="rodape">
                        <span class="titulo"><?php echo $resposta[$contador]['nome_deba']?></span>                        
                        <?php
                            if(isset($resposta[$contador]['indParticipa']) AND $resposta[$contador]['indParticipa'] == TRUE){ 
                        ?>      
                            <span>Participantes: <?php echo $resposta[$contador]['qtdParticipantes']?> <b>Você já participa</b></span>                   
                                                  
                        <?php  
                            }else{
                        ?>
                            <span>Participantes: <?php echo $resposta[$contador]['qtdParticipantes']?></span>                       
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
                        echo '<li class="jaca"><a href="VisualizarDebatesTemplate.php?pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;  
                    }else{
                        echo '<li><a href="VisualizarDebatesTemplate.php?pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;
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