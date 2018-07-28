<?php
define ('WWW_ROOT', dirname(__FILE__)); 
define ('DS', DIRECTORY_SEPARATOR);
require_once(WWW_ROOT.DS.'autoload.php');
use Core\Debate;
use Classes\ValidarCampos;
session_start();
//if(isset($_POST) AND !empty($_POST)){//Verificaçao se ele entrou pela url     
        try{
            $nomesCampos = array('imagem','titulo', 'tema','descricao');// Nomes dos campos que receberei do formulario
            $validar = new ValidarCampos($nomesCampos, $_POST, $_FILES);//Verificar se eles existem, se nao existir estoura um erro
            $debate = new Debate();
            $debate->setNomeDeba($_POST['titulo']);
            $debate->setTemaDeba($_POST['tema']);
            $debate->setDescriDeba($_POST['descricao']);            
            $debate->setImgDeba($_FILES['imagem']);
            
            var_dump($_POST);
    
        }catch (Exception $exc){
            echo $exc->getMessage();            
        }   
    
//}else{
 //   echo 'Caba safado nao entre pela url';
//}