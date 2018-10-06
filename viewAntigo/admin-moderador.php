<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    
    try{
        

        $tipoUsuPermi = array('Adm');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         
        $usu = new Usuario();
        $usu->setCodUsu($_SESSION['id_user']);
        $resultado = $usu->getDadosUser(true);
        $tipos = array();
        
        if(!isset($_GET['tipo']) AND empty($_GET['tipo'])){
            $tipos[] = 'moderador';
            $parametro = 'moderador';
        }else{           
            $parametro = "";
            $contador = 1;
            foreach($_GET as $chaves => $valores){    
                if($chaves == 'tipo'){
                    foreach($valores as $chave => $valor){
                        $tipos[] = $valor;
                        if($contador < count($_GET)){
                            $parametro .= 'tipo[]=';
                            $parametro .= $valor.'&';
                        }else{                            
                            $parametro .= 'tipo[]=';
                            $parametro .= $valor;
                        }
                        $parametro .= '&';
                        $contador++;  
                    }
                }
                
            }
        }
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;  
        $res = $usu->getDadosUsuByTipoUsu($tipos,$_GET['pagina']);        
        $quantidadePaginas = $usu->getQuantidadePaginas();
        $pagina = $usu->getPaginaAtual();
        if(empty($res)){
            echo 'Não há nenhuma denuncia para verificar<br>';
        }
       
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
        <script src="../teste.js"></script>

    </head>
    <body>
        <header>
            <img src="imagens/logo_oficial.png" alt="logo">
            <form action="pesquisa.php" method="get">
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
                    <li><a href="todasreclamacoes.php"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="todosdebates.php"><i class="icone-debate"></i>Debates</a></li>
                </ul>
            </nav>       
            <?php
                if(!isset($resultado)){
                    echo '<a href="login.php"><i class="icone-user" id="abrir"></i></a>';
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
                    <img src="../Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>" alt="perfil">
                </div>    
                    <img src="../Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
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

                <div class="filtro-admin ">
                    <i class="icone-filtro "></i>
                    <form>
                        <i class="icone-fechar"></i>
                        <h3>Tipo de usuario</h3>
                        <div>    
                                    
                            <label class="container"> Moderador 
                                <input type="checkbox"  name="tipo[]"checked="checked" value="Moderador">
                                <span class="checkmark"></span>
                            </label>
                                
                            <label class="container"> Prefeitura 
                                <input type="checkbox"  name="tipo[]" value="Prefeitura">
                                <span class="checkmark"></span>
                            </label>
                               
                                
                        </div>
                                <input type="submit" class="botao-filtro" value="Filtrar">
                                
                    </form>
                </div>

            <div class="tabelinha-admin" >
                    <table>
                            <tr>
                              <th>Usuario</th>
                              <th>Tipo</th>
                              <th>Data</th>
                            </tr>
                            <tr>
                            <td  colspan="3" class="cad-adm"><div>+</div><p>Cadastrar</p></td>
                            </tr> 
                            <?php
                                $contador = 0;
                                $contador2 = 0;
                                while($contador < count($res)){
                                    echo '<tr>';  
                                        echo '<td>'.$res[$contador]['nome_usu'].'</td>';
                                        echo '<td>'.$res[$contador]['descri_tipo_usu'].'</td>';
                                        echo '<td>'.$res[$contador]['dataHora_cadastro_usu'].'</td>';                        
                                        //echo '<td>'.$res[$contador]['LinkApagarUsu'].'</td>'; 
                                    echo '</tr>';
                                    $contador++;
                                    $contador2 = 0;
                                }
                            ?>
                       
                          </table>
                    </div>      
        </div>
        <ul>
        <?php
            if($quantidadePaginas != 1){
                $contador = 1;
                while($contador <= $quantidadePaginas){
                    if(isset($pagina) AND $pagina == $contador){
                        echo '<li class="jaca"><a href="admin-moderador.php?'.$parametro.'&pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;  
                    }else{
                        echo '<li><a href="admin-moderador.php?'.$parametro.'&pagina='.$contador.'">Pagina'.$contador.'</a></li>'  ;
                    }                    
                    $contador++;        
                }
            }            
        ?>
        </ul>
    </body>
    <?php
        
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 2://Nao esta logado    
                echo "<script> alert('$mensagem');javascript:window.location='login.php';</script>";
                break;
            case 6://Não é usuario prefeitura ou func  
                echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
                break; 
            case 9://Não foi possivel achar a publicacao  
                echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes.php';</script>";
        }   
    }
    
    ?>