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
    use Classes\ValidarCampos;
    try{        
        $publi = new Publicacao();
        $comentario = new Comentario();

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $publi->setCodUsu($_SESSION['id_user']);
            $comentario->setCodUsu($_SESSION['id_user']);
            $tipoUsu = $_SESSION['tipo_usu'];
        }

        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero
        
        $publi->setCodPubli($_GET['ID']);
        $comentario->setCodPubli($_GET['ID']);        
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;
                  
        $comentarioComum = $comentario->SelecionarComentariosUserComum($_GET['pagina']);
        
        $resposta = $publi->listByIdPubli();   
        $comentarioPrefei = $comentario->SelecionarComentariosUserPrefei();

        $quantidadePaginas = $comentario->getQuantidadePaginas();
        $pagina = $comentario->getPaginaAtual();
        
        //var_dump($resposta);
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
                    echo '<br>';
                if(isset($resposta[0]['indDenunPubli']) AND $resposta[0]['indDenunPubli'] == TRUE){ // Aparecer quando o user ja denunciou            
                    echo '<b>Denunciado</b>';            
                }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[0]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                        if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                            echo '<a href="DenunciarPublicacaoTemplate.php?ID='.$_GET['ID'].'">Denunciar</a>';
                        }                    
                }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                    echo '<a href="DenunciarPublicacaoTemplate.php?ID='.$_GET['ID'].'">Denunciar</a>';
                }            
                
                if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[0]['cod_usu']){
                    echo '<a href="../ApagarPublicacao.php?ID='.$_GET['ID'].'">Apagar Publicacao</a>';
                }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                    echo '<a href="../ApagarPublicacao.php?ID='.$_GET['ID'].'">Apagar Publicacao</a>';
                        echo '<br>';
                    echo '<a href="../ApagarUsuario.php?ID='.$resposta[0]['cod_usu'].'">Apagar Usuario</a>';
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
                    <p><?php echo nl2br($comentarioPrefei[0]['texto_comen'])?></p>
                    <?php
                        if(isset($comentarioPrefei[0]['indCurtidaDoUser']) AND $comentarioPrefei[0]['indCurtidaDoUser'] == TRUE){            
                            echo '<a href="../CurtirComentario.php?ID='.$comentarioPrefei[0]['cod_comen'].'&pagina='. $pagina.'&IDPubli='.$_GET['ID'].'">Descurtir</a>';            
                        }else{                     
                            echo '<a href="../CurtirComentario.php?ID='.$comentarioPrefei[0]['cod_comen'].'&pagina='. $pagina.'&IDPubli='.$_GET['ID'].'">Curtir</a>';  
                        }

                    ?>
                    <h3><?php echo $comentarioPrefei[0]['qtdCurtidas'] ?></h3>
                    <?php
                        if(isset($comentarioPrefei[0]['indDenunComen']) AND $comentarioPrefei[0]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                            echo '<b>Denunciado</b>';            
                        }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $comentarioPrefei[0]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                                    echo '<a href="DenunciarComentarioTemplate.php?ID='.$comentarioPrefei[0]['cod_comen'].'&IDPubli='.$_GET['ID'].'&pagina='. $pagina.'">Denunciar</a>';
                                }                    
                        }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                            echo '<a href="DenunciarComentarioTemplate.php?ID='.$comentarioPrefei[0]['cod_comen'].'&IDPubli='.$_GET['ID'].'&pagina='. $pagina.'">Denunciar</a>';
                        }

                        if(isset($tipoUsu)){
                            if($tipoUsu == 'Prefeitura'){ // SE for tipo prefeitura pode editar qualquer comenentario
                                echo '<br><br>';
                                echo '<a href="UpdateComentarioTemplate.php?ID='.$comentarioPrefei[0]['cod_comen'].'&IDPubli='.$_GET['ID'].'">Editar</a>';
                            }else if($tipoUsu == 'Funcionario' AND $_SESSION['id_user'] == $comentarioPrefei[0]['cod_usu']){ // se for tipo funcionario so pode editar as suas respostas
                                echo '<a href="UpdateComentarioTemplate.php?ID='.$comentarioPrefei[0]['cod_comen'].'&IDPubli='.$_GET['ID'].'">Editar</a>';
                            }
                        }


                    ?>
                    
                </div>
                
        <?php
            }
            
            if(isset($tipoUsu) AND ($tipoUsu == 'Funcionario' or $tipoUsu == 'Prefeitura')){
                if(empty($comentarioPrefei)){
                    echo '
                        <div>
                            <form action="../Comentario.php" method="post">
                                <h1>Envie seu comentario!!:</h1>
                                <textarea cols="70" rows="5" name="texto"></textarea>
                                <input type="hidden" value=" '. $_GET['ID'].'" name="id">
                                <input type="submit" value="Enviar">
                            </form>        
                       </div>   
                    ';
                }              


            }else if(isset($tipoUsu) AND ($tipoUsu == 'Comum')){            
        ?>
            
        <div>
                <form action="../Comentario.php" method="post">
                    <h1>Envie seu comentario!!:</h1>
                    <textarea cols="70" rows="5" name="texto"></textarea>
                    <input type="hidden" value="<?php echo $_GET['ID']?>" name="id">
                    <input type="submit" value="Enviar">
                </form>

        </div>
                
         <?php 
            }
            echo "<h3>Curtidas: ".$resposta[0]['quantidade_curtidas']."</h3>"; 
            echo "<h3>Comenatarios: ".$resposta[0]['quantidade_comen']."</h3>";  
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
                    <p><?php echo nl2br($comentarioComum[$contador]['texto_comen'])?></p>
                    <?php
                        if(isset($comentarioComum[$contador]['indCurtidaDoUser']) AND $comentarioComum[$contador]['indCurtidaDoUser'] == TRUE){            
                            echo '<a href="../CurtirComentario.php?ID='.$comentarioComum[$contador]['cod_comen'].'&pagina='. $pagina.'&IDPubli='.$_GET['ID'].'">Descurtir</a>';           
                        }else{                     
                            echo '<a href="../CurtirComentario.php?ID='.$comentarioComum[$contador]['cod_comen'].'&pagina='. $pagina.'&IDPubli='.$_GET['ID'].'">Curtir</a>';  
                        }                       

                    ?>
                    <h3><?php echo $comentarioComum[$contador]['qtdCurtidas'] ?></h3>
                    <?php 
                        if(isset($comentarioComum[$contador]['indDenunComen']) AND $comentarioComum[$contador]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                            echo '<b>Denunciado</b>';            
                        }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $comentarioComum[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                                if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                                    echo '<a href="DenunciarComentarioTemplate.php?ID='.$comentarioComum[$contador]['cod_comen'].'&IDPubli='.$_GET['ID'].'&pagina='. $pagina.'">Denunciar</a>';
                                }                    
                        }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                            echo '<a href="DenunciarComentarioTemplate.php?ID='.$comentarioComum[$contador]['cod_comen'].'&IDPubli='.$_GET['ID'].'&pagina='. $pagina.'">Denunciar</a>';
                        }

                        if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $comentarioComum[$contador]['cod_usu']){
                            echo '<a href="../ApagarComentario.php?ID='.$comentarioComum[$contador]['cod_comen'].'">Apagar Comentario</a>';
                        }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                            echo '<a href="../ApagarComentario.php?ID='.$comentarioComum[$contador]['cod_comen'].'">Apagar Comentario</a>';
                                echo '<br>';
                            echo '<a href="../ApagarUsuario.php?ID='.$comentarioComum[$contador]['cod_usu'].'">Apagar Usuario</a>';
                        }
                    ?>
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