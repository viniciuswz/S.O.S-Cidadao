<?php
session_start();
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');

use Core\Usuario;  
use Classes\ValidarCampos;
use Classes\Pesquisa;
try{
    //Usuario::verificarLogin(1);  // Vai estourar um erro se ele ja estiver logado
    $nomesCampos = array('pesquisa');// Nomes dos campos que receberei da URL    
    $validar = new ValidarCampos($nomesCampos, $_GET);       
    $pes = new Pesquisa();

    if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){           
        $tipoUsu = $_SESSION['tipo_usu'];
        $pes->setCodUsu($_SESSION['id_user']);
    }           
    $_GET['pesquisa'] = str_replace("+"," ", $_GET['pesquisa']);
    $pes->setTextoPesqui($_GET['pesquisa']);       
    
    isset($_GET['pagina']) ?: $_GET['pagina'] = null;
    //isset($_GET['tipo']) ?: $_GET['tipo'] = null;
    $parametro = "";
    if(isset($_GET['tipo'])){            
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
    }else{
        $_GET['tipo'][0] = "Deba";
        $_GET['tipo'][1] = "Publi";
    }   
    $resPes = $pes->pesquisar($_GET['pagina'],$_GET['tipo']);
    $quantidadePaginas = $pes->getQuantidadeTotalPaginas();
    //$pagina = $pes->getPaginaAtual();  

    if($_GET['pagina'] > $quantidadePaginas) {        
        echo 'Maior';
        exit();
    }
    $contador = 0;
    while($contador < count($resPes)){
        if($resPes[$contador]['tipo'] == 'Publicacao'){
            if(isset($resPes[$contador]['indDenunPubli']) AND $resPes[$contador]['indDenunPubli'] == TRUE){ // Aparecer quando o user ja denunciou            
                $resPes[$contador]['indDenun'] = TRUE;        // Denunciou
            }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resPes[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){                                                             
                    $resPes[$contador]['indDenun'] = FALSE; // N Denunciou
                    $indDenun = TRUE; // = carregar modal da denucia
                }                    
            }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado                                            
                $resPes[$contador]['indDenun'] = FALSE; // N Denunciou
                $indDenun = TRUE; // = carregar modal da denucia
            }else{
                $resPes[$contador]['indDenun'] = "nao";
            } 
    
            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resPes[$contador]['cod_usu']){            
                $resPes[$contador]['LinkApagar'] = "../ApagarPublicacao.php?ID=".$resPes[$contador]['cod_publi'];
                $resPes[$contador]['LinkUpdate'] = "reclamacao-update.php?ID=".$resPes[$contador]['cod_publi'];
            }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                $resPes[$contador]['LinkApagar'] = "../ApagarPublicacao.php?ID=".$resPes[$contador]['cod_publi'];
                $resPes[$contador]['LinkUpdate'] = "reclamacao-update.php?ID=".$resPes[$contador]['cod_publi'];
            }else{
                $resPes[$contador]['LinkApagar'] = FALSE;
                $resPes[$contador]['LinkUpdate'] = FALSE;
            }
            
            if(isset($_SESSION['id_user']) AND isset($resPes[$contador]['indSalvaPubli']) AND $resPes[$contador]['indSalvaPubli'] == TRUE){//Salvou            
                $resPes[$contador]['LinkSalvar'] = "../SalvarPublicacao.php?ID=".$resPes[$contador]['cod_publi'];
                $resPes[$contador]['TextoLinkSalvar'] = "Salvo";
            }else if(isset($_SESSION['id_user']) AND isset($resPes[$contador]['indSalvaPubli']) AND $resPes[$contador]['indSalvaPubli'] == FALSE){//Nao salvou
                $resPes[$contador]['LinkSalvar'] = "../SalvarPublicacao.php?ID=".$resPes[$contador]['cod_publi'];
                $resPes[$contador]['TextoLinkSalvar'] = "Salvar";
            }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado
                $resPes[$contador]['LinkSalvar'] = "../SalvarPublicacao.php?ID=".$resPes[$contador]['cod_publi'];
                $resPes[$contador]['TextoLinkSalvar'] = "Salvar";
            }  
    
           
        }else{
            if(isset($resPes[$contador]['indDenunComen']) AND $resPes[$contador]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                $resPes[$contador]['indDenun'] = TRUE;         
            }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resPes[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){                                                       
                    $resPes[$contador]['indDenun'] = FALSE; // N Denunciou
                    $indDenun = TRUE; // = carregar modal da denucia
                }                    
            }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado]
                $resPes[$contador]['indDenun'] = FALSE; // N Denunciou
                $indDenun = TRUE; // = carregar modal da denucia
            }else{
                $resPes[$contador]['indDenun'] = "nao";
            } 
            
            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resPes[$contador]['cod_usu']){                 
                $resPes[$contador]['LinkApagar'] = "../ApagarDebate.php?ID=".$resPes[$contador]['cod_deba'];
                $resPes[$contador]['LinkUpdate'] = "debate-update.php?ID=".$resPes[$contador]['cod_deba'];
            }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){                
                // Icone para apagar usuaario                
                $resPes[$contador]['LinkApagar'] = "../ApagarDebate.php?ID=".$resPes[$contador]['cod_deba'];
                $resPes[$contador]['LinkUpdate'] = "debate-update.php?ID=".$resPes[$contador]['cod_deba'];
            }else{
                $resPes[$contador]['LinkApagar'] = FALSE;
                $resPes[$contador]['LinkUpdate'] = FALSE;
            }           
        }

        if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos
            $resPes[$contador]['indCarregarModalDenun'] = TRUE;
        }else{
            $resPes[$contador]['indCarregarModalDenun'] = FALSE;
        }

        $indDenun = false; 
        $contador++;
    }
    echo json_encode($resPes);
}catch (Exception $exc){
    echo $exc->getMessage();
}

?>