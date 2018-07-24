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
        $resposta = $publi->ListFromALL();
        //var_dump($resposta);
        
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
                height: 300px;
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
        </style>
    </head>
    <body>
        <div class="agrupa">
        <?php
            $contador = 0;
            while($contador < count($resposta)){
                
        ?>  
                <div class="item">  
                    <a href="">
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
    </body>
</html>

<?php
}catch (Exception $exc){
         
}

?>