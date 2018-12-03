<?php
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');    
    use Core\Usuario;    
    use Core\Comentario;    
    use Classes\ValidarCampos;    
    try{        
        
        $comentario = new Comentario();
       
        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){            
            $comentario->setCodUsu($_SESSION['id_user']);             
            $tipoUsu = $_SESSION['tipo_usu'];                        
        }             

        $nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        $validar = new ValidarCampos($nomesCampos, $_GET);
        $validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero
        
        
        $comentario->setCodPubli($_GET['ID']);             
        
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;  
        
        
        $comentarioPrefei = $comentario->SelecionarComentariosUserPrefei(TRUE);        
                   
                                   
        if(isset($_SESSION['id_user'])){              
            if(isset($_GET['IdComen']) AND is_numeric($_GET['IdComen'])){
                $idNoti = $_GET['IdComen'];
                $comentario->setCodComen($idNoti);
                $comentarioComum = $comentario->getDadosComenByIdComen(); // preciso do comenantario denunciado                    
            }else{                                        
                $idNoti = $_GET['ID'];
            }                
        }                  
       

        if(isset($_SESSION['id_user']) AND isset($_GET['IdComen']) AND is_numeric($_GET['IdComen']) AND (isset($tipoUsu) AND ($tipoUsu == 'Adm' OR $tipoUsu == 'Moderador'))){            
            $comentario->setCodComen($idNoti);
            $comentarioComum = $comentario->getDadosComenByIdComen(); // preciso do comenantario denunciado            
        }else{ // quero todos os comentários
            $comentarioComum = $comentario->SelecionarComentariosUserComum($_GET['pagina']); // quero todos os comenatários
        }
        $quantidadePaginas = $comentario->getQuantidadePaginas();
        
        //$pagina = $comentario->getPaginaAtual(); 
        if(isset($_GET['IdComen']) AND empty($_GET['IdComen'])) { // se nao for um comentario denunciado    
            if($_GET['pagina'] > $quantidadePaginas){
                if($quantidadePaginas == 0 OR $comentarioComum == null){
                    if(!isset($tipoUsu)){
                        echo 'Vazio.NLogado';
                    }else{
                        echo 'Vazio.'.$tipoUsu;
                    }                    
                }else{
                    echo 'Maior';                    
                }
                exit();               
            }                
        }else{
            if($_GET['pagina'] > 1){
                echo 'Maior';
                exit();
            }
        }
       
        $indDenun = false;
        $contador = 0;
        while($contador < count($comentarioComum)){
                    $comentarioComum[$contador]['texto_comen'] = str_replace("<br/>","\n",$comentarioComum[$contador]['texto_comen']);//tira os <br>

                    if(isset($comentarioComum[$contador]['indDenunComen']) AND $comentarioComum[$contador]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                        $comentarioComum[$contador]['indDenun'] = TRUE;  
                    }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $comentarioComum[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                        if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){
                            $comentarioComum[$contador]['indDenun'] = FALSE; // N Denunciou
                            $indDenun = TRUE; // = carregar modal da denucia
                        }                    
                    }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                        $comentarioComum[$contador]['indDenun'] = FALSE; // N Denunciou
                        $indDenun = TRUE; // = carregar modal da denucia
                    }


                    if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $comentarioComum[$contador]['cod_usu']){
                        $comentarioComum[$contador]['LinkApagar'] = "../ApagarComentario.php?ID=".$comentarioComum[$contador]['cod_comen'];
                        $comentarioComum[$contador]['LinkUpdate'] = "#";
                        $indEditarComen = true;
                    }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){            
                        $comentarioComum[$contador]['LinkApagar'] = "../ApagarComentario.php?ID=".$comentarioComum[$contador]['cod_comen']; 
                        $comentarioComum[$contador]['LinkUpdate'] = FALSE;                         
                        //Remover usuario ADM    
                    }else{
                        $comentarioComum[$contador]['LinkApagar'] = FALSE;
                        $comentarioComum[$contador]['LinkUpdate'] = FALSE;
                    }


                    if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos
                        $comentarioComum[$contador]['indCarregarModalDenun'] = TRUE;
                    }else{
                        $comentarioComum[$contador]['indCarregarModalDenun'] = FALSE;
                    }

                    if(isset($indEditarComen) AND $indEditarComen == TRUE) { // so quero q carregue em alguns casos
                        $comentarioComum[$contador]['indCarregarModalEditar'] = TRUE;
                    }else{
                        $comentarioComum[$contador]['indCarregarModalEditar'] = FALSE;
                    }
                $indDenun = false;
                $indEditarComen = false;
                $contador++;
            }
            echo json_encode($comentarioComum);
}catch (Exception $exc){
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();  
    switch($erro){
        case 9://Não foi possivel achar a publicacao  
            echo "<script> alert('$mensagem');javascript:window.location='view/todasreclamacoes.php';</script>";
            break; 
        case 22:
            echo "Maior";
            break;
        default: //Qualquer outro erro cai aqui
            echo "<script> alert('$mensagem');javascript:window.location='view/todasreclamacoes.php';</script>";
    }   
}  
    
    