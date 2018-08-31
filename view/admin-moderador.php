<?php
session_start();
    require_once('../Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Core\Usuario;
    
    try{
        

        $tipoUsuPermi = array('Moderador','Adm');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         
        $usu = new Usuario();    
        $tipos = array();
        
        if(!isset($_GET['tipo']) AND empty($_GET['tipo'])){
            $tipos[] = 'moderador';
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

    </head>
    <body>
        <header>
            <img src="imagens/Ativo2.png" alt="logo">
            <form>
                <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
                <button type="submit"><i class="icone-pesquisa"></i></button>
            </form>
            <nav class="menu">
                <ul>
                    <li><nav class="notificacoes">
                        <h3>notificações</h3>
                        <ul>
                            <li>
                                <a href="#">
                                <div><i class="icone-comentario"></i></div>
                                <span class="">
                                    <span class="negrito">Corno do seu pai</span> , <span class="negrito">Rogerinho</span><span> E outras 4 pessoas comentaram na sua publicação</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-like-full"></i></div>
                                <span class="">
                                    <span class="negrito">Corno do seu pai</span> , <span class="negrito">Rogerinho</span><span> E outras 4 pessoas curtiram sua publicação aaaaaaaaaaaaaaaaaaa</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri" aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"associação dos cadeirantes de Barueri"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"cortaram meu pau por acidente no SAMEB era só marca de batom quero meu pau de voltaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                <div><i class="icone-mail"></i></div>
                                <span class="">
                                    A <span class="negrito">prefeitura </span>respondeu sua publicação:"quero café"</span>
                                </span>
                                </a>
                            </li>
                            <li>
                        </ul>
                    </nav><a href="#" id="abrir-not"><i class="icone-notificacao"><span>99+</span></i>Notificações</a></li>
                    <li><a href="todasreclamacoes.php"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="todosdebates.php"><i class="icone-debate"></i>Debates</a></li>
                </ul>
            </nav>
            <i class="icone-user" id="abrir"></i>
        </header>
        <div class="user-menu">
            <a href="javascript:void(0)" class="fechar">&times;</a>
            <div class="mini-perfil">
                <div>    
                    <img src="imagens/perfil.jpg" alt="perfil">
                </div>    
                    <img src="imagens/capa.png" alt="capa">
                    <p>Pericles</p>
            </div>
            <nav>
                <ul>
                    <li><a href="#"><i class="icone-user"></i>Meu perfil</a></li>
                    <li><a href="#"><i class="icone-salvar"></i>Salvos</a></li>
                    <hr>
                    <li><a href="#"><i class="icone-adm"></i>Area de administrador</a></li>
                    <li><a href="#"><i class="icone-salvar"></i>Area da prefeitura </a></li>
                    <hr>
                    <li><a href="#"><i class="icone-config"></i>Configurações</a></li>
                    <li><a href="#"><i class="icone-logout"></i>Log out</a></li>

                </ul>
            </nav>
        </div>

        <div id="container">

                <div class="filtro-admin ">
                    <i class="icone-filtro "></i>
                    <form action="admin-moderador.php" method="get">
                        <i class="icone-fechar"></i>
                        <h3>Tipo de usuario</h3>
                        <div>    
                                    
                            <label class="container"> Moderador 
                                <input type="checkbox"  name="tipo[]" checked value="Moderador">
                                <span class="checkmark"></span>
                            </label>
                                
                            <label class="container"> Prefeitura 
                                <input type="checkbox" name="tipo[]" value="Prefeitura">
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
                                        echo '<td>'.$res[$contador]['LinkApagarUsu'].'</td>'; 
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
            echo "<script> alert('$mensagem');javascript:window.location='./loginTemplate.php';</script>";
            break;
        case 6://Não é usuario prefeitura ou func  
            echo "<script> alert('$mensagem');javascript:window.location='./starter.php';</script>";
            break; 
        case 9://Não foi possivel achar a publicacao  
            echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
            break; 
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='VisualizarPublicacoesTemplate.php';</script>";
    }   
}

?>