<?php
namespace Action;
use Model\RecuperarSenhaM;
use Core\Usuario;

class RecuperarSenhaA extends RecuperarSenhaM{
    
    private $sqlInsertPedido = "INSERT recuperar_senha(status_recuperar_senha, data_hora_solicitacao, cod_usu)
                                    VALUES('%s', '%s', '%s')";

    private $sqlVerificarExistencPedido = "SELECT cod_recupe_senha, TIMEDIFF('%s', time_format(data_hora_solicitacao, '%s')) AS tempoPassado FROM recuperar_senha 
                                            WHERE DATEDIFF('%s',data_hora_solicitacao) = '0' AND cod_usu = '%s' 
                                            AND status_recuperar_senha = 'A' 
                                            AND TIMEDIFF('%s', time_format(data_hora_solicitacao, '%s')) <= time('00:15:00')";

    private $sqlSelectPedido = "SELECT cod_recupe_senha, data_hora_solicitacao FROM recuperar_senha 
                                            WHERE DATEDIFF('%s',data_hora_solicitacao) = '0' AND cod_usu = '%s' 
                                            AND status_recuperar_senha = 'A' 
                                            AND TIMEDIFF('%s', time_format(data_hora_solicitacao, '%s')) <= time('00:15:00')";
    private $sqlUpdateStatus = "UPDATE recuperar_senha SET status_recuperar_senha = 'I' WHERE cod_usu = '%s'";

    private $usuariObj;
    



    public function __construct(){
        $this->usuariObj = new Usuario();
    }

    public function inserirPedido(){
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 

        $this->usuariObj->setEmail($this->getEmail());
        $dadosUsuario = $this->usuariObj->verificarEmail(); // pegar dados do usuario
        if(empty($dadosUsuario)){
            throw new \Exception("Email inexistente", 10);            
        }               
        $this->setCodUsu($dadosUsuario[0]['cod_usu']); 
        $dadosExistencia = $this->verificarExistenciaPedido(TRUE);       

        if(!$dadosExistencia){ // ainda nao fez a solicitacao
            $sql = sprintf(
                $this->sqlInsertPedido,
                'A',
                $DataHoraFormatadaAmerica,
                $this->getCodUsu()
            );
            $inserir = $this->runQuery($sql);            
            if(!$inserir->rowCount()){  // Se der erro cai nesse if          
                throw new \Exception("Não foi possível recuperar a senha",11);   
            }             
            return $this->gerarHash();
        }else{ // ja realizou a solicitacao e ta pedindo de novo
            if($dadosExistencia[0]['minutosPassado'] <= 15){ // ja foi realizado um pedido
                //return 'Proxima Etapa';
                throw new \Exception("Já foi realizado um pedido de recuperar senha, verifique seu email",20);   
            }
        }
        
    }

    public function verificarExistenciaPedido(){
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 
        $hora = $DataHora->format('H:i:s'); 
        $sql = sprintf(
            $this->sqlVerificarExistencPedido,
            $hora,
            '%H:%i',
            $DataHoraFormatadaAmerica,
            $this->getCodUsu(),
            $hora,
            '%H:%i'
        );
        $consulta = $this->runSelect($sql);
        if(empty($consulta)){ // nenhum dado encontrado
            return FALSE;
        }
        $DataHora = new \DateTime($consulta[0]['tempoPassado']);
        $minutos = $DataHora->format('i'); // pegar apenas minutos
        $tempo = intval($minutos); // converter pra int
        $consulta[0]['minutosPassado'] = $tempo;   
        return $consulta;
    }

    public function baseHash(){        
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 
        $hora = $DataHora->format('H:i:s'); 
        $sql = sprintf(
            $this->sqlSelectPedido,
            $DataHoraFormatadaAmerica,
            $this->getCodUsu(),
            $hora,
            '%H:%i'
        );
        $res = $this->runSelect($sql);
        if(empty($res)){
            throw new \Exception("Código inválido",130); // mexeu no id
        }
        $DataHora = new \DateTime($res[0]['data_hora_solicitacao']);
        return $tempo = $res[0]['cod_recupe_senha'] + ( ($DataHora->format('Y') * $res[0]['cod_recupe_senha']) + $DataHora->format('m') - $DataHora->format('d') + ($DataHora->format('H') * $res[0]['cod_recupe_senha']) - $DataHora->format('i') - $DataHora->format('s') ) - 649; // fazer calculo doido        
    }

    public function gerarHash(){
        $tempo = $this->baseHash();
        $hash = str_replace('/','$$$',password_hash($tempo, PASSWORD_DEFAULT, array("cost"=>12))) . '-;' . $this->getCodUsu();
        return $hash;
    }

    public function verificarHash($hash){
        $hashInteiro = str_replace('$$$','/',$hash);
        $hash = explode('-;',$hashInteiro);   // o que vier depois do -; é o id do usuario      
        if(isset($hash[1])){
            $this->setCodUsu($hash[1]); 
        }               
        if(!password_verify($this->baseHash(), $hash[0])){ // Verifico se o hash é igual ao codigo digitado
            throw new \Exception("Código invalido", 130);
        }         
        return $hash[1]; // retorna id
    }

    public function mudarSenha($senha){ 
        $this->usuariObj->setCodUsu($this->getCodUsu());
        $this->usuariObj->updateSenha($senha, TRUE);
        $sql = sprintf(
            $this->sqlUpdateStatus,
            $this->getCodUsu()
        );
        $inserir = $this->runQuery($sql);
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possivel mudar a senha",11);   
        } 
        return 'OK';
    }


}