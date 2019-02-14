<?php
    if(!file_exists('Config/Config.php')){        
        echo "<script>javascript:window.location='todasreclamacoes';</script>";       
    }

    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');
    
    use Classes\Denuncias;
    use Core\Usuario;
    
    try{
        
        $tipoUsuPermi = array('Moderador','Adm');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado 

        $dadosUrl = explode('/', $_GET['url']);
        if(count($dadosUrl) > 1){ // injetou parametros
            throw new \Exception('Não foi possível achar o debate',45);
        }

        $dados = new Usuario();
        $dados->setCodUsu($_SESSION['id_user']);
        $resultado = $dados->getDadosUser();
        $denun = new Denuncias();

        $tipos = array();
        if(!isset($_GET['tipo']) AND empty($_GET['tipo'])){
            $tipos[] = 'Comen';
            $_GET['tipo'][0] = 'Comen';
            $_GET['tipo'][1] = 'Debate';
            $_GET['tipo'][2] = 'Publi';
            $tipos = array('Comen','Debate','Publi');
            $parametro = "tipo[]=Comen&tipo[]=Debate&tipo[]=Publi";            
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
        //$tipos = array('Publi','Debate','Comen');         
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;                      
        $res = $denun->select($tipos,$_GET['pagina']);   
        //var_dump($res);
        $quantidadePaginas = $denun->getQuantidadePaginas();
        $pagina = $denun->getPaginaAtual();            
?>
<!DOCTYPE html>
<html lang=pt-br>
<head>
    <title>Área de administrador</title>
    
    <meta charset=UTF-8> <!-- ISO-8859-1 -->
    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <meta name=description content="Área restrita a usuários autorizados">
   
    <meta name=author content='equipe 4 INI3A'>
    
    <!-- favicon, arquivo de imagem podendo ser 8x8 - 16x16 - 32x32px com extensão .ico -->
    <link rel="shortcut icon" href="view/imagens/favicon.ico" type="image/x-icon">
    
    <!-- CSS PADRÃO -->
    <link href="view/css/default.css" rel=stylesheet>
    
    <!-- Telas Responsivas -->
    <link rel=stylesheet media="screen and (max-width:480px)" href="view/css/style480.css">
    <link rel=stylesheet media="screen and (min-width:481px) and (max-width:768px)" href="view/css/style768.css">
    <link rel=stylesheet media="screen and (min-width:769px) and (max-width:1024px)" href="view/css/style1024.css">
    <link rel=stylesheet media="screen and (min-width:1025px)" href="view/css/style1025.css">
    <meta name="theme-color" content="#089E8E" />
    
    <!-- JS-->
    
    <script src="view/lib/_jquery/jquery.js"></script>
    <script src="view/js/js.js"></script>
    <script src="teste.js"></script>
    
</head>
<body class="sempre-branco">
        <header>
            <a href="todasreclamacoes">
                <img src="view/imagens/logo_oficial.png" alt="logo">
            </a>   
            <i class="icone-pesquisa pesquisa-mobile" id="abrir-pesquisa"></i>
        <form action="pesquisa" method="get" id="form-pesquisa">
            <input type="text" name="pesquisa" id="pesquisa" placeholder="Pesquisar">
            <button type="submit"><i class="icone-pesquisa"></i></button>
        </form>
        <nav class="menu">
                <ul>
                    <li><nav class="notificacoes">
                        <h3>notificações<span id="not-fechado">x</span></h3>
                        <ul id="menu23">
                            
                            <li>
                        </ul>
                    </nav><a href="#" id="abrir-not"><i class="icone-notificacao" id="noti"></i>Notificações</a></li>
                    <li><a href="todasreclamacoes"><i class="icone-reclamacao"></i>Reclamações</a></li>
                    <li><a href="todosdebates"><i class="icone-debate"></i>Debates</a></li>
                </ul>
        </nav>
            <?php
                if(!isset($resultado)){
                    echo '<a href="login"><i class="icone-user" id="abrir"></i></a>';
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
                        <img src="Img/perfil/<?php echo $resultado[0]['img_perfil_usu'] ?>" alt="perfil">
                    </div>    
                    <img src="Img/capa/<?php echo $resultado[0]['img_capa_usu'] ?>" alt="capa">
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
            
            
            <div class="filtro-admin">
                <i class="icone-filtro "></i>
                <form>
                    <span id="fechar-filtro">&times;</span>
                    <h3>Tipo de Denuncia</h3>
                    <div>
                        <label class="container"> Comentários
                            <?php if(isset($_GET['tipo']) AND in_array('Comen',$_GET['tipo'])) { ?>
                                        <input type="checkbox" checked="checked" name="tipo[]" value="Comen" >
                            <?php }else{  ?>
                                        <input type="checkbox" name="tipo[]" value="Comen" >
                            <?php }  ?>
                            <span class="checkmark"></span>
                        </label>
                        
                        <label class="container"> Debates                         
                                <?php if(isset($_GET['tipo']) AND in_array('Debate',$_GET['tipo'])) { ?>
                                                <input type="checkbox" checked="checked" name="tipo[]" value="Debate">
                                <?php }else{  ?>
                                                <input type="checkbox" name="tipo[]" value="Debate">
                                <?php }  ?>
                            <span class="checkmark"></span>
                        </label>
                        
                        <label class="container"> Reclamações
                            <?php if(isset($_GET['tipo']) AND in_array('Publi',$_GET['tipo'])) { ?>
                                <input type="checkbox" checked="checked" name="tipo[]" value="Publi">
                            <?php }else{  ?>
                                <input type="checkbox" name="tipo[]" value="Publi">
                            <?php }  ?>
                            <span class="checkmark"></span>
                        </label>
                        
                    </div>
                    <input type="submit" class="botao-filtro" value="Filtrar">
                </form>
            </div>
            <div class="tabelinha-admin" >
                <table>
                    <tr>
                        <th><p>Denunciado</p></th>
                        <th><p>Tipo</p></th>
                        <th><p>Data</p></th>
                        
                    </tr>  
                    <?php
                      
                                $contador = 0;
                                $contador2 = 0;
                                while($contador < count($res)){
                                    echo '<tr class="tabelinha-linha">    
                                    <td>
                                    <div class="mini-menu-adm">
                                        <ul>
                                            <li><a href="#" class="motivo-ativar">Motivo</a></li>
                                            <li><a href="'.$res[$contador]['LinkVisita'].'">Visitar página</a></li>
                                            <li><a href="'.$res[$contador]['LinkApagarPubli'].'&tipo=retornar">Remover '.$res[$contador]['Tipo'].'</a></li>
                                            <li><a href="'.$res[$contador]['LinkApagarUsu'].'">Bloquear usuário</a></li>
                                            <li><a href="RemoverDenuncia.php?ID='.$res[$contador]['cod_denun'].'&tipo='.$res[$contador]['tipoSemAcento'].'">Remover denúncia</a></li>
                                        </ul>                                        
                                    </div>
                                    <div class="motivo">
                                        <div class="motivo-fundo"></div>
                                        <div class="motivo-box">
                                            <div>
                                                <h1>Motivo</h1>
                                                <span class="fechar-motivo">&times;</span>
                                            </div>
                                            <span>'.$res[$contador]['motivo'].'</span>
                                        </div>
                                    </div>
                                    <p>'.$res[$contador]['nome_denunciado'].'</p>
                                </td>
                                <td><p>'.$res[$contador]['Tipo'].'</p></td>
                                <td><p>'.$res[$contador]['dataHora'].'</td>
                                </tr>';
                                
                                    $contador++;
                                    $contador2 = 0;
                                }
                     ?>                      
                 </table>
                 <?php
                        if(empty($res)){
                            echo 'Não há nenhuma denuncia para verificar';
                         } 
                 ?>
            </div>      
        </div>
        <ul class="paginacao">
            <?php
                if($quantidadePaginas != 1){
                    $contador = 1;
                    while($contador <= $quantidadePaginas){
                        if(isset($pagina) AND $pagina == $contador){
                            echo '<li class="jaca"><a href="admin-denuncia?'.$parametro.'&pagina='.$contador.'">'.$contador.'</a></li>'  ;  
                        }else{
                            echo '<li><a href="admin-denuncia?'.$parametro.'&pagina='.$contador.'">'.$contador.'</a></li>'  ;
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
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){
        case 2://Nao esta logado    
            echo "<script>javascript:window.location='../login';</script>";
            break;
        case 6://Não é usuario prefeitura ou func  
            echo "<script>javascript:window.location='../todasreclamacoes';</script>";
            break; 
        case 9://Não foi possivel achar a publicacao  
            echo "<script> alert('$mensagem');javascript:window.location='../todasreclamacoes';</script>";
            break; 
        case 45://Digitou um numero maior de parametros 
            unset($dadosUrl[0]);
            $contador = 1;
            $voltar = "";
            while($contador <= count($dadosUrl)){
                $voltar .= "../";
                $contador++;
            }
             echo "<script> alert('$mensagem');javascript:window.location='".$voltar."todasreclamacoes';</script>";
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='../todasreclamacoes';</script>";
    }   
}

?>