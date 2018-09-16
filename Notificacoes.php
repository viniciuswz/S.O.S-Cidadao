<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');

use Notificacoes\GerenNotiComum;
use Notificacoes\GerenNotiAdm;
session_start();
if(isset($_SESSION['id_user']) AND isset($_SESSION['tipo_usu'])){
    if(isset($_POST['indVisu'])){
        $indVisu = 'B';
    }else{
        $indVisu = null;
    }
    
    $idUser = (int)$_SESSION['id_user'];
    if($_SESSION['tipo_usu'] == 'Comum'){
        $jaca = new GerenNotiComum($idUser,$indVisu);
        $resultado = $jaca->notificacoes();
        echo json_encode($resultado);
    }else if($_SESSION['tipo_usu'] == 'Adm' OR $_SESSION['tipo_usu'] == 'Moderador'){
        $jaca = new GerenNotiAdm();
        //$das = $jaca->SelectDenunPubli();
        $das2 = $jaca->notificacoes();
        //var_dump($das);
        var_dump($das2);
        //resultado = $jaca->notificacoes();
    }
}

?>

