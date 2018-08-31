<?php
require_once('Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');

use Notificacoes\GerenNotiComum;
use Core\Publicacao;
session_start();
//$_SESSION['id'] = 1;

$idUser = (int)$_SESSION['id_user'];
$jaca = new GerenNotiComum($idUser);

$resultado = $jaca->notificacoes();

echo json_encode($resultado);

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

