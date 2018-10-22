<?php
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
    use Core\Usuario;
    use Core\PublicacaoSalva;
    
try{        
        $tipoUsuPermi = array('Prefeitura','Adm','Funcionario','Moderador','Comum');
        Usuario::verificarLogin(1,$tipoUsuPermi);  // Tem q estar logado         
        
        //$usu = new Usuario();        
        //$usu->setCodUsu($_SESSION['id_user']);
        //$resultado = $usu->getDadosUser();
        $tipoUsu = $_SESSION['tipo_usu'];
        
        $publiSalva = new PublicacaoSalva();
        $publiSalva->setCodUsu($_SESSION['id_user']);
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;   
        $resposta = $publiSalva->SelectPubliSalvaByIdUser($_GET['pagina']);        
        $quantidadePaginas = $publiSalva->getQuantidadePaginas();
        //$pagina = $publiSalva->getPaginaAtual();   

        if($_GET['pagina'] > $quantidadePaginas) {        
            echo 'Maior';
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
                $resposta[$contador]['LinkApagar'] = "../ApagarPublicacao.php?ID=".$resposta[$contador]['cod_publi'];
                $resposta[$contador]['LinkUpdate'] = "reclamacao-update.php?ID=".$resposta[$contador]['cod_publi'];
            }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                $resposta[$contador]['LinkApagar'] = "../ApagarPublicacao.php?ID=".$resposta[$contador]['cod_publi'];
                $resposta[$contador]['LinkUpdate'] = "reclamacao-update.php?ID=".$resposta[$contador]['cod_publi'];
            }else{
                $resposta[$contador]['LinkApagar'] = FALSE;
                $resposta[$contador]['LinkUpdate'] = FALSE;
            }
            
           
            $resposta[$contador]['LinkSalvar'] = "../SalvarPublicacao.php?ID=".$resposta[$contador]['cod_publi'];
            $resposta[$contador]['TextoLinkSalvar'] = "Salvo";           
    
            if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos
                $resposta[$contador]['indCarregarModalDenun'] = TRUE;
            }else{
                $resposta[$contador]['indCarregarModalDenun'] = FALSE;
            }
            $indDenun = false;  
            $contador++;
        }
    
        ///var_dump($resposta);
        echo json_encode($resposta);
        //$pagina = $publi->getPaginaAtual();   


}catch (Exception $exc){     
    $erro = $exc->getCode();   
    $mensagem = $exc->getMessage();
    switch($erro){
        case 2://Ja esta logado  
        case 6://Ja esta logado 
            echo "<script> alert('$mensagem');javascript:window.location='index.php';</script>";
            break;
    
    }      
}
?>