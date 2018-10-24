<?php
session_start();
    require_once('Config/Config.php');
    require_once(SITE_ROOT.DS.'autoload.php');    
    
    use Core\Usuario;    
    use Core\Debate;
    use Core\Mensagens;
    use Classes\ValidarCampos;
    try{        

        $tipoUsuPermi = array('Prefeitura','Adm','Funcionario','Moderador','Comum');
        Usuario::verificarLogin(1,$tipoUsuPermi);

        $debate = new Debate();
         
        $mensagemObj = new Mensagens($_GET['ID']);       

        if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
            $debate->setCodUsu($_SESSION['id_user']); 
            $tipoUsu = $_SESSION['tipo_usu'];      
        }
         
        //$nomesCampos = array('ID');// Nomes dos campos que receberei da URL    
        //$validar = new ValidarCampos($nomesCampos, $_GET);
        //$validar->verificarTipoInt($nomesCampos, $_GET); // Verificar se o parametro da url é um numero     
        $debate->setCodDeba($_GET['ID']);   
        $mensagemObj->setCodDeba($_GET['ID']);   
                
        $resposta = $debate->listByIdDeba('sqlListDebaQuandoAberto');
        $debate->verificarSeParticipaOuNao($_GET['ID'], TRUE);       

        $participantes = $debate->listarParticipantes(' usuario.cod_usu, nome_usu, img_perfil_usu, ind_visu_criador ');
        $mensagemObj->setCodUsu($_SESSION['id_user']);       
        

        $listDeba = $debate->listarDebatesQpartcipo();        
        isset($_GET['pagina']) ?: $_GET['pagina'] = 'ultima'; 
        $mensagem = $mensagemObj->getMensagens($_GET['pagina']); 
        if($_GET['pagina'] < 0){
            $_GET['pagina'] = $_GET['pagina'] * -1;
        }
        $mensagem = $mensagemObj->getMensagens($_GET['pagina']);        
        $mensagemObj->visualizarMensagem();
        $quantidadePaginas = $mensagemObj->getQuantidadePaginas();
        $pagina = $mensagemObj->getPaginaAtual();      
        
        if($_GET['pagina'] > $quantidadePaginas){
            echo 'Maximo';
        }
        
        $resposta[0]['sair'] = "../SairDebate.php?ID=".$resposta[0]['cod_deba'];
        if($resposta[0]['cod_usu'] == $_SESSION['id_user']){
            $resposta[0]['dono'] = TRUE; // verificar se é dono do debate
            $resposta[0]['txtSair'] = "Apagar grupo";
        }else{
            $resposta[0]['dono'] = FALSE;
            if($_SESSION['tipo_usu'] == 'Comum'){                       
                $resposta[0]['txtSair'] = "Sair do grupo";
            }else if($_SESSION['tipo_usu'] == 'Adm' OR $_SESSION['tipo_usu'] == 'Moderador'){                     
                $resposta[0]['txtSair'] = "Apagar Grupo";
            }
        }  
        $contador = 0;
        while($contador < count($participantes)){
                if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] == $resposta[0]['cod_usu'] AND $_SESSION['id_user'] != $participantes[$contador]['cod_usu']
                    OR ($tipoUsu == 'Adm' OR $tipoUsu == 'Moderador')){ // parei aqui link pra apagar
                    if(($tipoUsu == 'Adm' OR $tipoUsu == 'Moderador') AND $participantes[$contador]['cod_usu'] != $resposta[0]['cod_usu']){ // nao aparece a opcao remover participante quando que estiver logo for adm e o usario participante o dono
                        $participantes[$contador]['remover'] = '"..SairDebate.php?ID='. $resposta[0]['cod_deba'].'&IDUsu='.$participantes[$contador]['cod_usu'].'';
                    }else if($tipoUsu == 'Comum'){                        
                        $participantes[$contador]['remover'] = "..SairDebate.php?ID=". $resposta[0]['cod_deba'].'&IDUsu='.$participantes[$contador]['cod_usu'].'';
                    } 
                    $participantes[$contador]['perfil'] = "perfil_reclamacao.php?ID=". $participantes[$contador]['cod_usu'];
                }else if(isset($_SESSION['id_user']) AND $_SESSION['id_user'] != $participantes[$contador]['cod_usu']){
                    $participantes[$contador]['remover'] = "";                    
                    $participantes[$contador]['perfil'] = "perfil_reclamacao.php?ID=". $participantes[$contador]['cod_usu']."'";
                }else{
                    $participantes[$contador]['remover'] = "";
                    $participantes[$contador]['perfil'] = "";
                }        
            $contador++;
        }      
        $uniao[0]['dadosDeba'] = $resposta;
        $uniao[1]['participantes'] = $participantes;
        $uniao[2]['debateQParticipa'] = $listDeba;
        $uniao[3]['mensagens'] = $mensagem;

        echo json_encode($uniao);
?>


<?php
    }catch (Exception $exc){
        $erro = $exc->getCode();   
        $mensagem = $exc->getMessage();  
        switch($erro){
            case 9://Não foi possivel achar a publicacao  
                echo "<script> alert('$mensagem');javascript:window.location='view/todosdebates.php';</script>";
                break; 
            default: //Qualquer outro erro cai aqui
                echo "<script> alert('$mensagem');javascript:window.location='view/todosdebates.php';</script>";
        }   
    }  
?> 

 
