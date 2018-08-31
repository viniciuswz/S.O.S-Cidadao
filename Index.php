<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');

use Notificacoes\GerenNotiComum;

session_start();
//$_SESSION['id'] = 1;

if(isset($_POST['indVisu'])){
    $indVisu = 'B';
}else{
    $indVisu = null;
}

$idUser = (int)$_SESSION['id_user'];
$jaca = new GerenNotiComum($idUser,'B');

$resultado = $jaca->notificacoes();

echo json_encode($resultado);
//var_dump($resultado);
/*s
foreach($resultado as $chaves => $valores){
    foreach($valores as $chave => $valor){
        if($chave == 'notificacao'){
            echo $valor . "<br>";
        }
    }s
}
*/
?>

