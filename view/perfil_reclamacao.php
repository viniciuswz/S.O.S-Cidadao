<?php
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    use Core\Usuario;
    //use Core\Publicacao;
    use Classes\ValidarCampos;
    
    try{   
        //$_SESSION['indNovaConta']  = true;
        if(isset($_SESSION['indNovaConta'])){ // se por um acaso for usuario novo
            unset($_SESSION['indNovaConta']);           
        }
        
        if(isset($_GET['url'])){
            $dadosUrl = explode('/', $_GET['url']);
            $voltar = '../';
            if(count($dadosUrl) > 2){ // injetou parametros
                throw new \Exception('Não foi possível achar o perfil',45);
            }else if(isset($dadosUrl[1])){          
                $numVoltar = count($dadosUrl) - 1;
                $_GET['ID'] = $dadosUrl[1];
            }else{
                $numVoltar = 0;
                $voltar = "";
            }
        }


        $usuPerfil = new Usuario();
        if(isset($_SESSION['id_user'])){ // se estiver logado   
            $usu = new Usuario();  
            $usu->setCodUsu($_SESSION['id_user']);         
            $resultado = $usu->getDadosUser(false,true);

            $tipoUsu = $_SESSION['tipo_usu'];
            if(isset($_GET['ID'])){ // quando for ver perfil de outras pessoas
                $validar = new ValidarCampos(array('ID'), $_GET);
                $validar->verificarTipoInt(array('ID'), $_GET); // Verificar se o parametro da url é um numero
                $id = $_GET['ID'];
                $usuPerfil->setCodUsu($_GET['ID']); 
                $dadosPerfil =  $usuPerfil->getDadosUser(false,true);     
            }else{ // seu propio perfil
                $id = $_SESSION['id_user'];                
                $dadosPerfil = $resultado;                            
            }      
        }else{ // Nao esta logado
            $validar = new ValidarCampos(array('ID'), $_GET);
            $validar->verificarTipoInt(array('ID'), $_GET); // Verificar se o parametro da url é um numero
            $id = $_GET['ID'];   
            $usuPerfil->setCodUsu($_GET['ID']);    
            $dadosPerfil =  $usuPerfil->getDadosUser(false,true);     
        }        
        $descPerfilVisu = $dadosPerfil[0]['descri_tipo_usu'];
        if($descPerfilVisu != 'Comum' AND $descPerfilVisu != 'Prefeitura'){ // Vendo perfil restrito
            if(!isset($_SESSION['id_user'])){ // Não esta logado
                throw new \Exception("Você nao tem permissao para este perfil12",1);
            }

            if($_SESSION['id_user'] != $dadosPerfil[0]['cod_usu']){// Logado, e nao esta no seu perfil
                switch($tipoUsu){
                    case 'Comum':
                    case 'Funcionario':
                        throw new \Exception("Você nao tem permissao para este perfil13",1);
                        break;
                    case 'Prefeitura':
                        if($descPerfilVisu != 'Funcionario'){
                            throw new \Exception("Você nao tem permissao para este perfil14",1);
                        }
                        break; 
                }
        }}    

        //$publi = new Publicacao();    
        //$publi->setCodUsu($id);
        isset($_GET['pagina']) ?: $_GET['pagina'] = null; 

        if($descPerfilVisu == 'Prefeitura'){
            $nomeLink2 = 'Respondidas';
            $nomeLink1 = 'Sem resposta'; 
           //$resposta = $publi->getPubliNRespo($_GET['pagina'], TRUE);  
        }else{
            isset($_SESSION['id_user']) ? $idVisualizador = $_SESSION['id_user'] : $idVisualizador = null;
            $nomeLink1 = 'Reclamação';
            $nomeLink2 = 'Debate';
            //$resposta = $publi->ListByIdUser($_GET['pagina'], $idVisualizador);  
        }      
          
        //$quantidadePaginas = $publi->getQuantidadePaginas();
        //$pagina = $publi->getPaginaAtual();
        
?>
<!DOCTYPE html>
<html lang=pt-br>
    <head>
        <title>S.O.S Cidadão</title>

        <meta charset=UTF-8> <!-- ISO-8859-1 -->
        <meta name=viewport content="width=device-width, initial-scale=1.0">
        <meta name=description content="Site de reclamações para a cidade de Barueri">
        <meta name=keywords content="Reclamação, Barueri"> <!-- Opcional -->
        <meta name=author content='equipe 4 INI3A'>
        <meta name="theme-color" content="#089E8E" />

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="<?php echo $voltar?>view/imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="<?php echo $voltar?>view/css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="<?php echo $voltar?>view/css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="<?php echo $voltar?>view/css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="<?php echo $voltar?>view/css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="<?php echo $voltar?>view/css/style1025.css">

        <!-- JS-->

        <script src="<?php echo $voltar?>view/lib/_jquery/jquery.js"></script>
        <script src="<?php echo $voltar?>view/js/js.js"></script>
        <script src="<?php echo $voltar?>view/js/PegarPubliPerfil.js"></script>
        <script src="<?php echo $voltar?>teste.js"></script>

                
        <!-- cropp-->

        <link rel="stylesheet" href="<?php echo $voltar?>view/lib/_croppie-master/croppie.css">
        <script src="<?php echo $voltar?>view/lib/_croppie-master/croppie.js"></script>
        <script src="<?php echo $voltar?>view/lib/_croppie-master/exif.js"></script>

    </head>
    <body onload="jaquinha()">
        <header>
            <a href="todasreclamacoes">
                <img src="<?php echo $voltar?>view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
            <form action="<?php echo $voltar?>pesquisa" method="post" id="form-pesquisa">
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
                <button type="submit"><i class="icone-pesquisa"></i></button>
            </form>
            <nav class="menu">
                <ul>
                    <li><nav class="notificacoes">
                        <h3>notificações<span id="not-fechado"></span></h3>
                        <ul id="menu23">
                            
                            <li>
                        </ul>
                    </nav><a href="#" id="abrir-not"><i class="icone-notificacao" id="noti"></i>Notificações</a></li>
                    <li><a href="<?php echo $voltar?>todasreclamacoes"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="<?php echo $voltar?>todosdebates"><i class="icone-debate"></i>Debates</a></li>
                </ul>
            </nav>
            <?php
                if(!isset($resultado)){
                    echo '<a href="'.$voltar.'login"><i class="icone-user" id="abrir"></i></a>';
                }else{
                    echo '<i class="icone-user" id="abrir"></i>';
                }
            ?>
        </header>
        <?php
            if(isset($resultado) AND !empty($resultado)){
        ?>
                <div class="user-menu">
                    <a href="javascript:void(0)" class="fechar">&times;</a>
                    <div class="mini-perfil">
                        <div>    
                            <img src="<?php echo $voltar?>Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>" alt="perfil">
                        </div>    
                            <img src="<?php echo $voltar?>Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
                            <p><?php echo $resultado[0]['nome_usu'] ?></p>
                    </div>
                    <nav>
                    <ul>
                        <?php
                            require_once('opcoes.php');                        
                        ?>
                    </ul>
                </nav>
                </div>
        <?php
           }
       ?>

        <div id="container">
        <input type="hidden" id="IDPefil" value="<?php echo $id?>,<?php echo $numVoltar?>">
        <section class="perfil-base" id="baconP">
                
                <div class="perfil">
                        <?php 
                            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $dadosPerfil[0]['cod_usu']){
                                // vinicius esqueceu o formulario
                        ?>
                            <i class="icone-edit-full" id="trocar-capa" title="Alterar a foto de capa"></i>
                        <?php 
                            }
                        ?>
                    <img src="<?php echo $voltar?>Img/capa/<?php echo $dadosPerfil[0]['img_capa_usu'] ?>"> 
                   

                    
                </div>
                <div class="perfil-info">
                        <p><?php echo $dadosPerfil[0]['nome_usu'] ?></p>
                        <div>
                            <img src="<?php echo $voltar?>Img/perfil/<?php echo $dadosPerfil[0]['img_perfil_usu'] ?>">
                        </div>

                        <?php 
                            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $dadosPerfil[0]['cod_usu'] 
                            AND isset($tipoUsu) AND $tipoUsu != "Funcionario"){
                                // vinicius esqueceu o formulario
                        ?>
                                <i class="icone-edit-full" id="trocar-perfil" title="Alterar a foto de perfil"></i>
                        <?php 
                            }
                        ?>
                </div>

               
            </section>
            <nav class="menu-perfil">
                <ul class="espacos">

                    <li class="ativo"><a href="#r"><?php echo $nomeLink1 ?></a></li>

                    <?php 
                        if(isset($_GET['ID'])){                    
                            echo '<li><a href="'.$voltar.'perfil_debate/'.$dadosPerfil[0]['cod_usu'].'">'.$nomeLink2.'</a></li>';
                        }else{
                            echo '<li><a href="'.$voltar.'perfil_debate">'.$nomeLink2.'</a></li>';
                        }
                    ?>   
                    
                </ul>
            </nav>
            <section class="alinha-item" id="pa">

                <div class="modal-denunciar">
                    <div class="modal-denunciar-fundo"></div>
                    <div class="box-denunciar">
                        <div>
                            <h1>Qual o motivo da denúncia?</h1>
                            <span class="fechar-denuncia">&times;</span>
                        </div>
                        
                        <form id="formdenuncia">
                            <textarea placeholder="Qual o motivo?" id="motivo"></textarea>
                            <input type="hidden" name="id_publi" value="">
                            <div class="aviso-form-inicial ">
                                <p>O campo tal e pa</p>
                            </div>
                            <button type="submit"> Denunciar</button>
                        </form>
                    </div>
                </div>
                       
            </section>            
        </div>
        
        <div class="modal-troca-foto">
            <div class="modal-troca-foto-fundo"></div>
            <div class="box-troca-foto">
                <div class="modal-titulo">
                    <h1>Trocar foto de capa</h1>
                    <span class="fechar-troca-foto">&times;</span>
                </div>
                <div class="img-capa-corta">
                   <img src="">
                </div>
                <div>  
                <div class="aviso-form-inicial ">
                        <p>O campo tal e pa</p>
                    </div>               
                    <form id="trocarcapa">
                        <label for="fotoCapa"><p>Escolher foto</p></label>
                        <input type="file" accept="image/*" name="fotocapa" id="fotoCapa">
                        <input type="hidden" name="base64FotoCapa" id="base64FotoCapa" value="jaca">
                    </form>
                    <button id="cortar">Cortar foto</button>
                </div>
            </div>
        </div> 

        <div class="modal-troca-foto-previa">
            <div class="modal-troca-foto-previa-fundo"></div>
            <div class="box-troca-foto-previa">
                <div>
                    <h1>Gostou?</h1>
                    <span class="fechar-troca-foto-previa">&times;</span>
                </div>
                <div>                 
                    <img src="" class="previewCapa" style="width: 100%">
                    <button class="alterar-capa">enviar foto</button>

                    <button class="outra-capa">tentar de novo</button>
                </div>
            </div>
        </div>

        <div class="modal-troca-foto-perfil">
                <div class="modal-troca-foto-perfil-fundo"></div>
                <div class="box-troca-foto-perfil">
                    <div class="modal-titulo">
                        <h1>Trocar foto de perfil</h1>
                        <span class="fechar-troca-foto-perfil">&times;</span>
                    </div>
                    <div class="img-perfil-corta">
                       <img src="">
                    </div>
                    <div>  
                    <div class="aviso-form-inicial ">
                            <p>O campo tal e pa</p>
                        </div>               
                        <form id="trocarperfil">
                            <label for="fotoPerfil"><p>Escolher foto</p></label>
                            <input type="file" accept="image/*" name="fotoperfil"  id="fotoPerfil">
                            <input type="hidden" name="base64FotoPerfil" id="base64FotoPerfil" value="banana">
                        </form>
                        <button id="cortarPerfil">Cortar foto</button>
                    </div>
                </div>
            </div> 
    
            <div class="modal-troca-foto-perfil-previa">
                <div class="modal-troca-foto-perfil-previa-fundo"></div>
                <div class="box-troca-foto-perfil-previa">
                    <div>
                        <h1>Gostou?</h1>
                        <span class="fechar-troca-foto-perfil-previa">&times;</span>
                    </div>
                    <div>                 
                        <img src="" class="previewPerfil" style="width: 180px;border-radius: 50%;">
                        <button class="alterar-perfil">enviar foto</button>
                        <button class="outra-perfil">tentar de novo</button>
                    </div>
                </div>
            </div>
        <script>
    
    var largura= $(document).width();
                  if(largura < 420){
                    var tela= $(document).width();
                  }else{
                    var tela= 420
                  }
                  var  $uploadCrop = $('.img-capa-corta').croppie({
 
                    enableExif: true,
                    enforceBoundary:true,
                    enableOrientation:true,
                    enableResize:false,
                    viewport: {
                      width: 320,
                      height: 150,
                      
                    },
                    boundary: {
                      width: tela,
                      height: 200
                    },
                  });

var  $uploadCropPerfil = $('.img-perfil-corta').croppie({
                    
                    enableExif: true,
                    enforceBoundary:true,
                    enableOrientation:true,
                    enableResize:false,
                    viewport: {
                      width: 200,
                      height: 200,
                      type: 'circle'
                      
                    },
                    boundary: {
                      width: tela,
                      height: 300
                    },
                  });


            
            // $('#x').click(function(){
                //     var d = $uploadCrop.croppie().get();
                
                //     $('#result').html(JSON.stringify(d));
                // });
                

            </script>
    </body>
</html>
<?php
}catch (Exception $exc){     
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Ja esta logado  
        case 6://Ja esta logado 
        case 1:
            echo "<script> alert('$mensagem');javascript:window.location='../view/todasreclamacoes';</script>";
            break;
        case 45://Digitou um numero maior de parametros 
            unset($dadosUrl[0]);
            $contador = 1;
            $voltar = "";
            while($contador <= count($dadosUrl)){
                $voltar .= "../";
                $contador++;
            }
            echo "<script>javascript:window.location='".$voltar."todasreclamacoes';</script>";
            break;
        default:
            echo "<script> alert('$mensagem');javascript:window.location='../view/todasreclamacoes';</script>";
    }      
}