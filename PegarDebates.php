<?php
    session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');   
       
    use Core\Debate;    
    try{
        $debate = new Debate();
        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $debate->setCodUsu($_SESSION['id_user']);
            $tipoUsu = $_SESSION['tipo_usu'];

            //$dados = new Usuario();
            //$dados->setCodUsu($_SESSION['id_user']);
            //$resultado = $dados->getDadosUser();
        } 
        isset($_GET['pagina']) ?: $_GET['pagina'] = null;        
        
        $resposta = $debate->ListFromALL($_GET['pagina']);       
        $quantidadePaginas = $debate->getQuantidadePaginas();
        

        if($_GET['pagina'] > $quantidadePaginas) {        
            echo 'Maior';
            exit();
        }       
        

        $contador = 0;
        while($contador < count($resposta)){

            if(isset($resposta[$contador]['indDenunComen']) AND $resposta[$contador]['indDenunComen'] == TRUE){ // Aparecer quando o user ja denunciou            
                $resposta[$contador]['indDenun'] = TRUE;         
            }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $resposta[$contador]['cod_usu']){ // Aparecer apenas naspublicaçoes q nao é do usuario
                if($tipoUsu == 'Comum' or $tipoUsu == 'Prefeitura' or $tipoUsu == 'Funcionario'){                                                       
                    $resposta[$contador]['indDenun'] = FALSE; // N Denunciou
                    $indDenun = TRUE; // = carregar modal da denucia
                }                    
            }else if(!isset($_SESSION['id_user'])){ // aparecer parar os usuario nao logado]
                $resposta[$contador]['indDenun'] = FALSE; // N Denunciou
                $indDenun = TRUE; // = carregar modal da denucia
            }else{
                $resposta[$contador]['indDenun'] = "nao";
            } 
            
            if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[$contador]['cod_usu']){
                //echo '<li><a href="../ApagarDebate.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                //echo '<li><a href="debate-update.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';   
                $resposta[$contador]['LinkApagar'] = "../ApagarDebate.php?ID=".$resposta[$contador]['cod_deba'];
                $resposta[$contador]['LinkUpdate'] = "debate-update.php?ID=".$resposta[$contador]['cod_deba'];
            }else if(isset($tipoUsu) AND ($tipoUsu == 'Adm' or $tipoUsu == 'Moderador')){
                //echo '<li><a href="../ApagarDebate.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-fechar"></i></i>Remover</a></li>';
                // Icone para apagar usuaario
                //echo '<a href="../ApagarUsuario.php?ID='.$resposta[0]['cod_usu'].'">Apagar Usuario</a>';                                                       
                //echo '<li><a href="debate-update.php?ID='.$resposta[$contador]['cod_deba'].'"><i class="icone-edit-full"></i></i>Alterar</a></li>';                                                    
                $resposta[$contador]['LinkApagar'] = "../ApagarDebate.php?ID=".$resposta[$contador]['cod_deba'];
                $resposta[$contador]['LinkUpdate'] = "debate-update.php?ID=".$resposta[$contador]['cod_deba'];
            }else{
                $resposta[$contador]['LinkApagar'] = FALSE;
                $resposta[$contador]['LinkUpdate'] = FALSE;
            }

            if(isset($indDenun) AND $indDenun == TRUE) { // so quero q carregue em alguns casos
                $resposta[$contador]['indCarregarModalDenun'] = TRUE;
            }else{
                $resposta[$contador]['indCarregarModalDenun'] = FALSE;
            }
            $indDenun = false; 
            $contador++;
        }

        echo json_encode($resposta);
       
}catch (Exception $exc){
             
}
?>