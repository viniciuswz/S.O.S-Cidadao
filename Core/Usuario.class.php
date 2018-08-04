<?php
namespace Core;

use Action\UsuarioA;

class Usuario extends UsuarioA{

    public static function verificarLogin($permissao){//Niveis de permissao

        if($permissao == 1){// Nao pode estar logado
            if(isset($_SESSION['id_user']) AND !empty($_SESSION['id_user'])){
                throw new \Exception("Ja está logado",2);  
            }
        }

        if($permissao == 2){// Tem q estar logado, nao importa o tipo_usu
            if(!isset($_SESSION['id_user']) AND empty($_SESSION['id_user'])  
                AND !isset($_SESSION['tipo_usu']) AND empty($_SESSION['tipo_usu'])){
                throw new \Exception("Não está logado",2);  
            }
        }

        if($permissao == 3){//Apenas user comum tem acesso
            if($_SESSION['tipo_usu'] != 'Comum'){
                throw new \Exception("Apenas user comum tem acesso",6);
            }
        }

        if($permissao == 4){// Tem q estar logado, apenas prefeitura, func
            if($_SESSION['tipo_usu'] != 'Funcionario' AND $_SESSION['tipo_usu'] != 'Prefeitura'){  // Estoura um erro
                throw new \Exception("Apenas user funcionarios ou prefeitura",6);
            }
        }

        if($permissao == 5){// Tem q estar logado, apenas prefeitura
            if($_SESSION['tipo_usu'] != 'Prefeitura'){  // Estoura um erro
                throw new \Exception("Apenas user prefeitura",6);
            }
        }

        if($permissao == 6){// Tem q estar logado, apenas adm, moderador
            if($_SESSION['tipo_usu'] != 'Moderador' AND $_SESSION['tipo_usu'] != 'Adm'){  // Estoura um erro
                throw new \Exception("Apenas user moderador ou Adm",6);
            }
        }

        if($permissao == 7){// Tem q estar logado, apenas adm, moderador
            if($_SESSION['tipo_usu'] != 'Adm'){  // Estoura um erro
                    throw new \Exception("Apenas user ADM",6);
            }
        }   
        
        if($permissao == 8){// Tem q estar logado, apenas prefeitura, func,comum
            if($_SESSION['tipo_usu'] != 'Prefeitura' AND $_SESSION['tipo_usu'] != 'Funcionario' AND $_SESSION['tipo_usu'] != 'Comum'){  // Estoura um erro
                throw new \Exception("Apenas user Comum, func, e prefei",6);
            }
        }   

    }
    
    
}