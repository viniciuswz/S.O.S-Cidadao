<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');    
    
    use Core\Usuario;    
    use Core\Debate;
    use Classes\ValidarCampos;
    try{        

        $tipoUsuPermi = array('Prefeitura','Adm','Funcionario','Moderador','Comum');
        Usuario::verificarLogin(1,$tipoUsuPermi);

        $debate = new Debate();        

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $debate->setCodUsu($_SESSION['id_user']); 
            $tipoUsu = $_SESSION['tipo_usu'];      
        }
        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero     
        $debate->setCodDeba($_GET['ID']);   
        
        
        $resposta = $debate->listByIdDeba('sqlListDebaQuandoAberto');
        $debate->verificarSeParticipaOuNao($_GET['ID'], TRUE);       

        $participantes = $debate->listarParticipantes();
        $listDeba = $debate->listarDebatesQpartcipo();
        
        //var_dump($resposta);
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

        <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
        <link rel="shortcut icon" href="imagens/favicon.ico" type="image/x-icon">

        <!-- CSS PADRÃO -->
        <link href="css/default.css" rel=stylesheet>

        <!-- Telas Responsivas -->
        <link rel=stylesheet media="screen and (max-width:480px)" href="css/style480.css">
        <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="css/style768.css">
        <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="css/style1024.css">
        <link rel=stylesheet media="screen and (min-width:1025px)" href="css/style1025.css">

        <!-- JS-->

        <script src="lib/_jquery/jquery.js"></script>
        <script src="js/js.js"></script>

    </head>
    <body>
        

        <div id="container">
        
        <section class="debate-full">
               
          
                <aside class="usuarios-debate-info">
                        <span id="fechar-debate-info">&times;</span>
                        <div class="moldura-debate">
                            <div>
                                <div>
                                    <img src="../Img/debate/<?php echo $resposta[0]['img_deba']?>">
                                </div>
                                <?php 
                                    if($resposta[0]['cod_usu'] == $_SESSION['id_user']){
                                ?>
                                    <form>
                                        <label for="imagem"><i class="icone-edit-full" title="Alterar a foto de perfil"></i></label>
                                        <input type="file" id="imagem">
                                    </form>
                                <?php 
                                    }
                                ?>
                            </div>
                            
                        </div>
                        <div class="infos">
                            <h3><?php echo $resposta[0]['nome_deba']?></h3>
                            <p>Criado por <span><?php echo $resposta[0]['nome_usu']?></span></p>
                        </div>
                        <div class="participantes">
                            <h4>Participantes (<?php echo $resposta[0]['qtdParticipantes']?>)</h4>
                            <?php
                                $contador = 0;
                                while($contador < count($participantes)){
                            ?>                                   
                                    <div>
                                        <a href="perfil_reclamacao.php?ID=<?php echo $participantes[$contador]['cod_usu'] ?>">
                                            <div class='img-participante'>
                                                <img src='../Img/perfil/<?php echo $participantes[$contador]['img_perfil_usu'] ?>'>
                                            </div>
                                        </a>
                                                <p><?php echo $participantes[$contador]['nome_usu'] ?></p>
                                                <?php
                                                    if($participantes[$contador]['ind_visu_criador'] == 'I'){
                                                        echo 'dono';
                                                    }
                                                ?>
                                        
                                    </div>                                
                            <?php
                                    $contador++;
                                }
                            ?>             
                </aside>
                <aside class="contatos">
                    <header class="">
                            <h3>Suas conversas</h3>
                            <p id="fechar-contatos">&times;</p>
                    </header>
                        <nav>
                            <?php
                                $contador = 0;
                                while($contador < count($listDeba)){
                            ?>
                                <div class="contatinhos">
                                    <a href="debate_mensagens.php?ID=<?php echo $listDeba[$contador]['cod_deba'] ?>">
                                        <div class="img-debate">
                                            <img src="../Img/debate/<?php echo $listDeba[$contador]['img_deba']?>" alt="debate">
                                        </div>
                                    </a>
                                    <div class="status-debate">
                                        <?php
                                            if($_GET['ID'] == $listDeba[$contador]['cod_deba']){
                                                echo '<p><span class="negrito">'.$listDeba[$contador]['nome_deba'] . '</span></p>';
                                            }else{
                                                echo '<p>'.$listDeba[$contador]['nome_deba'].'</p>';
                                            }
                                        ?>                                      
                                        
                                    </div>
                                </div>
                            <?php
                                    $contador++;
                                }
                            ?>                             
                        </nav>
                </aside>                
        
           <div class="batepapo">
                <header>
                    <div>
                        <img src="../Img/debate/<?php echo $resposta[0]['img_deba']?>" alt="debate">
                    </div>
                    <h4><?php echo $resposta[0]['nome_deba']?></h4>
                    <div class="mini-menu-item">
                            <i class="icone-3pontos"></i>
                            <div>
                                <ul>
                                    <li id="abrir-debate-info"><span>Dados do grupo</span></li>
                                    <?php
                                        if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[0]['cod_usu']){
                                            echo '<li><a href="../SairDebate.php?ID='. $resposta[0]['cod_deba'].'"><span>Apagar grupo</span></a></li>';
                                        }else if($_SESSION['tipo_usu'] == 'Comum'){
                                            echo '<li><a href="../SairDebate.php?ID='. $resposta[0]['cod_deba'].'"><span>Sair do grupo</span></a></li>';
                                        }else if($_SESSION['tipo_usu'] == 'Adm' OR $_SESSION['tipo_usu'] == 'Moderador'){
                                            echo '<li><a href="../SairDebate.php?ID='. $resposta[0]['cod_deba'].'"><span>Apagar Grupo</span></a></li>';
                                        }
                                    ?>
                                    
                                    <li id="abrir-contatos"><span>Suas conversas</span></li>
                                </ul>
                            </div>
                    </div>
                </header>
                <div class="mensagens">

                    <div class="linha-mensagem_padrao">
                        <div class="usuario-msg-foto">
                            <img src="imagens/perfil.jpg">
                        </div>
                        <div class="mensagem_padrao">
                            <span class="nome">Péricles alexandre santoaaaaaaaaaaaaaaaaaaaaaaaaaaas</span>
                            <span >
                                teseeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>

                    <div class="linha-mensagem_usuario">
                        <div>
                            <span >
                                teeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>

                    <div class="linha-mensagem_sistema">
                        <div>
                            <span >
                                HOJEaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                            </span>
                        </div>
                    </div>
                    <div class="linha-mensagem_padrao">
                            <div class="usuario-msg-foto">
                                <img src="imagens/perfil.jpg">
                            </div>
                    <div class="mensagem_padrao">
                        <span class="nome">Péricles alexandre santoaaaaaaaaaaaaaaaaaaaaaaaaaaas</span>
                            <span >
                                teseeeeeeeeeeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
    
                    <div class="linha-mensagem_usuario">
                        <div>
                            <span >
                                teeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
                    <div class="linha-mensagem_padrao">
                            <div class="usuario-msg-foto">
                                <img src="imagens/perfil.jpg">
                            </div>
                    <div class="mensagem_padrao">
                        <span class="nome">Péricles alexandre santoaaaaaaaaaaaaaaaaaaaaaaaaaaas</span>
                            <span >
                                teseeeeeeeeeeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
    
                    <div class="linha-mensagem_usuario">
                        <div>
                            <span >
                                teeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
                    <div class="linha-mensagem_padrao">
                            <div class="usuario-msg-foto">
                                <img src="imagens/perfil.jpg">
                            </div>
                    <div class="mensagem_padrao">
                        <span class="nome">Péricles alexandre santoaaaaaaaaaaaaaaaaaaaaaaaaaaas</span>
                            <span >
                                teseeeeeeeeeeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
    
                    <div class="linha-mensagem_usuario">
                        <div>
                            <span >
                                teeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
                    <div class="linha-mensagem_padrao">
                            <div class="usuario-msg-foto">
                                <img src="imagens/perfil.jpg">
                            </div>
                    <div class="mensagem_padrao">
                        <span class="nome">Péricles alexandre santoaaaaaaaaaaaaaaaaaaaaaaaaaaas</span>
                            <span >
                                teseeeeeeeeeeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
    
                    <div class="linha-mensagem_usuario">
                        <div>
                            <span >
                                teeeeeeeeeeeeeeeee<sub>16:55</sub>
                            </span>
                        </div>
                    </div>
                        
                </div>

                     
               <form>
                   <input type="text" placeholder="digite aqui..." ><button type="submit"> ></button> 
               </form>      
           </div>
        </section>
        </div>
    </body>
</html>
<?php
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 9://Não foi possivel achar a publicacao  
                echo "<script> alert('$mensagem');javascript:window.location='todosdebates.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='todosdebates.php';</script>";
        }   
    }  
?> 
