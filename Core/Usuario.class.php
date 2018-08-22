<?php
namespace Core;

use Action\UsuarioA;

class Usuario extends UsuarioA{  
    public static function verificarLogin($inLogado, $usuariosPermi = array()){
        if($inLogado == 1){ // Tem q estar logado
            if(!isset($_SESSION['id_user']) AND empty($_SESSION['id_user'])  
                AND !isset($_SESSION['tipo_usu']) AND empty($_SESSION['tipo_usu'])){ // Estou um erro se ele nao estiver com a sessao iniciada
                throw new \Exception("Não está logado",2);  
            }
            $ind = 0;
            foreach($usuariosPermi as $valor){ // Percorre a array com os tipo_usu permitidos
                if($_SESSION['tipo_usu'] != $valor){
                    $ind++;//Cada vez que nao for igual adiciona um
                }
            }

            if($ind == count($usuariosPermi)){ // Se o indicador for igual a quantidade de pessoa permitidas,
                // significa que o usuario nao tem permissao
                throw new \Exception("Você nao tem permissão para esta página !!",6);
            }  
        }else{ // Nao pode estar logado
            if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
                throw new \Exception("Ja está logado",2);  
            }
        }
    }
    
}