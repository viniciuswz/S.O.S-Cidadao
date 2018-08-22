<?php
namespace Classes;

class TratarDataHora{

    private $dataHoraEnvio;
    private $dataHoraAgora;

    public function __construct($dataHoraEnvio){
        // Configurar a data para pt-br
        // Assim q a classe for instanciada é configurada
        date_default_timezone_set("America/Sao_Paulo");
        setlocale(LC_ALL, 'pt_BR');        
        $this->dataHoraEnvio = new \DateTime($dataHoraEnvio);
        $this->dataHoraAgora = new \DateTime('now');    
        
    }


    public function listaAdmEPrefe(){ // Tratar como a dataHora será mostrada na lista dos denunciados e dos usuarios e dos funcionarios da prefei

    }


    public function calcularSegun(){
        $segundos1 = strtotime($this->dataHoraEnvio->format('d-m-Y H:i:s')); //transforma a data em segundos        
        $segundos2 = strtotime($this->dataHoraAgora->format('d-m-Y H:i:s'));        
        $diferenca = $segundos2 - $segundos1;        
        return $diferenca;
    }


    public function calcularMin(){
        $diferencaSegundos = $this->calcularSegun();
        $minutos = $diferencaSegundos / 60;
        return intval($minutos);
    }


    public function calcularHoras(){
        $minutos = $this->calcularMin();
        $hora = intval($minutos/60);
        return $hora;
    }


    public function mensagemDebaNaoAberto($mensagem){
        $msg = "Debate criado " . $mensagem;
        return $msg;
    }


    public function mensagemPadrao($mensagem){
        if($mensagem == "agora"){
            $msg = "Enviado agora";
        }else{
            $msg = ucfirst($mensagem);
        }
        return $msg;
    }
    

    public function calcularTempo($tipoPubli,$indAberta){ // Indicar se a publicacao esta aberta ou nao
        $horas = $this->calcularHoras();
        $minutos = $this->calcularMin();
        if($horas < 24){ // Menor que 1 dia
            if($minutos <= 60){ // Menor ou igual a 1 hora
                if($minutos == 0){ // Enviado agora mesmo
                    $msg = "agora";
                }else if($minutos <= 59){ // Menor que 1 hora
                    if($minutos == 1){ 
                        $msg =  "há 1 minuto";
                    }else if($minutos >= 2 && $minutos <= 59){
                        $msg =  "há ". $minutos ." minutos";
                    }else{ // Se os minutos forem menor que 0
                        $msg = "em " . str_replace("/", " de ", $this->dataHoraEnvio->format('d/M/Y')) . " às " . $this->dataHoraEnvio->format('H:i');
                    }
                }else{ // Igual a 1 hora
                    $msg =  "há 1 hora";
                }
            }else{ // Maior que 1 hora
                if($horas == 1){
                    $msg =  "há 1 hora";
                }else{
                    
                    $msg =  "há $horas horas";
                }
                
            }
        }else{ // Maior que um dia
            if($horas >= 24 && $horas <= 48){ // menor q dois dias de diferenca
                $diasDiferenca = $this->dataHoraAgora->format('d') -  $this->dataHoraEnvio->format('d');
                if($diasDiferenca == 1){
                    $msg =  "ontem às " . $this->dataHoraEnvio->format('H:i'); 
                }else{                    
                    $msg =  "em " . str_replace("/", " de ", $this->dataHoraEnvio->format('d/M')) . " às " . $this->dataHoraEnvio->format('H:i');
                }               
            }else if($this->dataHoraEnvio->format('Y') == $this->dataHoraAgora->format('Y')){ // Maior que dois dias e do mesmo ano               
                $msg =  "em " . str_replace("/", " de ", $this->dataHoraEnvio->format('d/M')) . " às " . $this->dataHoraEnvio->format('H:i');
            }else{ // De outro ano
                $msg = "em " . str_replace("/", " de ", $this->dataHoraEnvio->format('d/M/Y')) . " às " . $this->dataHoraEnvio->format('H:i');
            }
        }


        if($tipoPubli == "debate" && $indAberta == "N"){ // So cai nesse if se for debate e se nao estiver aberto       
                $mensagem = $this->mensagemDebaNaoAberto($msg);            
        }else{// se estiver aberto
            $mensagem = $this->mensagemPadrao($msg);
        }           
        return $mensagem; 
    }
}

// "debate", "N"
// "debate", "S"
// So vai mudar alguma coisa se for "debate", "N"
// Caso contrario nao vai mudar nada no resultado