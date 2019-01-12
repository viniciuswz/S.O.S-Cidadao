<?php
session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    use Core\Usuario;
    use Core\Publicacao;
    use Classes\ValidarCampos;
    
    try{   
        //$_SESSION['indNovaConta']  = true;        
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
        $descPerfilVisu = $dadosPerfil[0]['descri_tipo_usu']; // tipo de perfil q esta sendo visualizado
        
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
        }
    }    

    if(isset($_GET['voltar']) AND $_GET['voltar'] > 0){
        $voltar = '../';
        $quantVoltar = 1;
    }else{
        $voltar = '';
        $quantVoltar = 0;
    }

    $publi = new Publicacao();    
    $publi->setCodUsu($id);
    isset($_GET['pagina']) ?: $_GET['pagina'] = null;
    
    if($descPerfilVisu == 'Prefeitura'){       
        if(isset($_SESSION['id_user'])){
            $publi->setCodUsu($_SESSION['id_user']);
        }        
        $resposta = $publi->getPubliNRespo($_GET['pagina'], TRUE);  
     }else{
         isset($_SESSION['id_user']) ? $idVisualizador = $_SESSION['id_user'] : $idVisualizador = null;        
         $resposta = $publi->ListByIdUser($_GET['pagina'], $idVisualizador);  
     }      

     $quantidadePaginas = $publi->getQuantidadePaginas();

    if($_GET['pagina'] > $quantidadePaginas OR $resposta == null) {        
        if($quantidadePaginas == 0 OR $resposta == null){
            if(!isset($tipoUsu)){
                $tipoUsu = 'Comum';
            }
            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $id){
                echo 'Vazio.'.$tipoUsu.',Dono';
            }else{
                echo 'Vazio.'.$tipoUsu.',NDono';
            }  
        }else{
            echo 'Maior';
        } 
       
        exit();
    }

    $contador = 0;
    while($contador < count($resposta)){
        if(isset($resposta[$contador]['indDenunPubli']) AND $resposta[$contador]['indDenunPubli'] == TRUE){ // Aparecer quando o user ja denunciou            
            $resposta[$contador]['indDenun'] = TRUE;        // Denunciou            
        }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
            if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){                                                             
                $resposta[$contador]['indDenun'] = FALSE; // N Denunciou
                $indDenun = TRUE; // = carregar modal da denucia
            }                    
        }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado                                            
            $resposta[$contador]['indDenun'] = FALSE; // N Denunciou
            $indDenun = TRUE; // = carregar modal da denucia
        }else{
            $resposta[$contador]['indDenun'] = "nao";
        } 

        if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[$contador]['cod_usu']){            
            $resposta[$contador]['LinkApagar'] = $voltar ."ApagarPublicacao.php?ID=".$resposta[$contador]['cod_publi'];
            $resposta[$contador]['LinkUpdate'] = $voltar . "reclamacao-update/".$resposta[$contador]['cod_publi'];
        }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
            $resposta[$contador]['LinkApagar'] = $voltar . "ApagarPublicacao.php?ID=".$resposta[$contador]['cod_publi'];
            $resposta[$contador]['LinkUpdate'] = $voltar . "reclamacao-update/".$resposta[$contador]['cod_publi'];
        }else{
            $resposta[$contador]['LinkApagar'] = FALSE;
            $resposta[$contador]['LinkUpdate'] = FALSE;
        }
        
        if(isset($_SESSION['id_user']) AND isset($resposta[$contador]['indSalvaPubli']) AND $resposta[$contador]['indSalvaPubli'] == TRUE){//Salvou            
            $resposta[$contador]['LinkSalvar'] = $voltar . "SalvarPublicacao.php?ID=".$resposta[$contador]['cod_publi']. "," .$quantVoltar ;
            $resposta[$contador]['TextoLinkSalvar'] = "Salvo";
        }else if(isset($_SESSION['id_user']) AND isset($resposta[$contador]['indSalvaPubli']) AND $resposta[$contador]['indSalvaPubli'] == FALSE){//Nao salvou
            $resposta[$contador]['LinkSalvar'] = $voltar . "SalvarPublicacao.php?ID=".$resposta[$contador]['cod_publi']. "," .$quantVoltar;
            $resposta[$contador]['TextoLinkSalvar'] = "Salvar";
        }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
            $resposta[$contador]['LinkSalvar'] = $voltar . "SalvarPublicacao.php?ID=".$resposta[$contador]['cod_publi']. "," .$quantVoltar;
            $resposta[$contador]['TextoLinkSalvar'] = "Salvar";
        }  

        if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos
            $resposta[$contador]['indCarregarModalDenun'] = TRUE;
        }else{
            $resposta[$contador]['indCarregarModalDenun'] = FALSE;
        }
        $indDenun = false;  
        $contador++;
    }

    //var_dump($resposta);
    
    echo json_encode($resposta);
    //$pagina = $publi->getPaginaAtual();   
    


}catch (Exception $exc){     
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Ja esta logado  
        case 6://Ja esta logado 
        case 1:
            echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
            break;
        default:
            echo "<script> alert('$mensagem');javascript:window.location='todasreclamacoes';</script>";
    }      
}