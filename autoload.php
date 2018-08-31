<?php
//Inclusao Automatica

class AutoLoader{    
    public static function register(){
        spl_autoload_register(function ($class){
            $cl = SITE_ROOT . DS . str_replace('\\', DS, $class) . '.class.php';            
            if(!file_exists($cl)){                
                throw new \Exception("Arquivo '{$cl}' não encontrado!");

            }else{
                require_once($cl);
            }
        });        
    }  
}


AutoLoader::register();
