<?php
namespace Db;
use Config\CfAcademicoLogin; // Usar uma namespace

class DbConnection extends CfAcademicoLogin{ //Extender de uma classe é com extends

    private $conn;
    private $user = 'root';
    private $pass = '';
    private $host = 'localhost';
    private $port = '3306';
    private $database = 'reclama1';
    private $lastId;

    // Método para esta estabelecer a conexão com o banco
    private function connect(){
        try{
            $this->conn = new \PDO("mysql:host=$this->host;port=$this->port;dbname=$this->database", $this->user, $this->pass); // Barra invertida significa q a classe nao é sua
            if(isset($this->conn)){
                $this->conn->exec("set names utf8"); // Metodo utf-8
                return $this->conn;
            }    
        
        }catch(\PDOException $exc){
            //echo $exc->getTraceAsString();
            throw new \Exception($exc->getCode()); // Lançar o código do erro
        }
    }

    // Método para ações com o banco (insert, update e delete)
    public function runQuery($sql){
        $this->conn = $this->connect(); // Abrir conexao
        $this->conn->beginTransaction(); // iniciando uma transação
        $stm = $this->conn->prepare($sql); // preparando o sql para evitar sql-injection (sql malicioso)
        $stm->execute(); // executando o sql

        if($stm){            
            $this->lastId = $this->conn->lastInsertId();
            $this->conn->commit(); // retificadpo "confirmado" a operacao                        
        }else{            
            $this->conn->rollBack(); // desfazendo as operações anteriores para manter a integridade do banco
            
        }
        
        //$stm->lastInsertId();
        return $stm;
    }

    // Retorno para ações de select
    public function runSelect($sql){
        $this->conn = $this->connect(); // Abrir conexao
        $stm = $this->conn->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    public function last(){
        return $this->lastId;
    }
    // Método para encerrar a conexão com o banco
    public function closeConnection(){
        $this->conn = NULL; // Fechar conexao
    }


}