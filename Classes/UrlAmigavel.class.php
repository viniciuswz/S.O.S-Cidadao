<?php
namespace Classes;

class UrlAmigavel{    
    private $url;
    public $partesUrl;
    public $indRetornar = false;

    public function __construct($url){
        $this->url = $url;       
        $this->retirarRaiz();              
        $this->partesUrl = explode('/', $this->url);
        unset($this->partesUrl[0]); // Não preciso dele   
        $this->verificarExistencia();
    }

    

    public function retirarRaiz(){           
        $urlInteira = SITE_ROOT;
        $urlInteira = str_replace('\\','/', str_replace(ROOT,'',$urlInteira));
        $this->url = str_replace('.php','',str_replace($urlInteira, '', $this->url));
        return;
    }

    public function verificarExistencia(){
        if(empty($this->partesUrl[1])){ // se nao for digitado nada
            //echo 'Não digitou nada na URL <br>';
            $this->partesUrl[1] = 'home.php';
            return;
        }

        if(is_dir($this->partesUrl[1])){ // verificar se existe pasta
            //echo 'é pasta';
            if($this->partesUrl[1] == 'requisicoes'){ // se for a requisicoes
                if(empty($this->partesUrl[2])){ // se nao for digitado nenhum arquivo
                    //echo 'Não digitou nada na URL Pasta<br>';
                    $this->partesUrl[1] = 'home.php';
                    $this->indRetornar = True;
                    return;
                }else{            
                    $this->indRetornar = True;       
                    $this->partesUrl[1] = $this->quebrarParametros($this->partesUrl[2]);
                    if(file_exists('requisicoes' . DIRECTORY_SEPARATOR . $this->partesUrl[2] . '.php')){
                        $this->partesUrl[1] = $this->partesUrl[2];
                    }else{
                        $this->partesUrl[1] = 'home.php';
                    }                    
                    return;
                }
            }else{

            }
        }else{ 
            $this->partesUrl[1] = $this->quebrarParametros($this->partesUrl[1]);
            if(file_exists('requisicoes' . DIRECTORY_SEPARATOR . $this->partesUrl[1] . '.php')){
                $this->partesUrl[1] .=  '.php';
            }else{
                $this->partesUrl[1] = 'home.php';
            }
            return;      
        }
       

    }
   
    public function quebrarParametros($url){ // retorna apenas o nome do arquivo
        if(strstr($this->partesUrl[1],'?')){ // quebrar a string quando tiver parametros
            $quebrarParame = explode('?', $this->partesUrl[1]);            
            return $quebrarParame[0];                        
        }else{
            return $url;
        }
    }

}