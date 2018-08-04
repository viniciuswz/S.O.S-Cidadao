<?php
namespace Action;
use Model\UsuarioM;

class UsuarioA extends UsuarioM{

    private $sqlSelectLogar = "SELECT usuario.cod_usu, descri_tipo_usu, senha_usu,status_usu 
                                    FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    WHERE status_tipo_usu = 'A' AND email_usu = '%s'";       

    private $sqlPegarDados = "SELECT usuario.cod_usu, nome_usu, email_usu, 
                                    img_perfil_usu, img_capa_usu, descri_tipo_usu,senha_usu
                                    FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    WHERE status_usu = 'A' AND status_tipo_usu = 'A' AND usuario.cod_usu = '%s'";

    private $sqlInsert  = "INSERT INTO usuario(nome_usu, email_usu, senha_usu, img_capa_usu, img_perfil_usu, cod_tipo_usu, dataHora_cadastro_usu)
                                VALUES('%s','%s','%s','%s','%s','%s',now())";
                                
    private $sqlVerifiEmail = "SELECT cod_usu,nome_usu FROM usuario WHERE email_usu = '%s'";

    private $sqlTipoUsu = "SELECT descri_tipo_usu FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                            WHERE usuario.cod_usu = '%s'";

    private $sqlUpdateEmailUsu = "UPDATE usuario SET email_usu = '%s', nome_usu = '%s' WHERE cod_usu = '%s'";

    private $sqlUpdateSenha = "UPDATE usuario SET senha_usu = '%s' WHERE cod_usu = '%s'";

    public function logar(){ //Logar       
        $sql = sprintf($this->sqlSelectLogar, // Junta o wher com o outra parte do select
                            $this->getEmail()                              
                    );
        $consulta = $this->runSelect($sql); // Executa
        if(empty($consulta)){ // Se nao retorna nada estoura um erro
            throw new \Exception("Email ou senha invalidos(Nenhum registro)",1);            
        }

        if(count($consulta) == 1){
            if($consulta[0]['status_usu'] != 'A'){
                throw new \Exception("Sua conta foi bloquada, se acha que foi um engano entre em contato conosco",1);
            }
            $hash = $consulta[0]['senha_usu']; // Pego o hash q esta no banco
            if(!password_verify($this->getSenha(), $hash)){ // Verifico se o hash é igual a senha digitada
                throw new \Exception("Email ou senha invalidos(Hash invalido)",1);
            }
                
            $_SESSION['id_user'] = $consulta[0]['cod_usu'];
            $_SESSION['tipo_usu'] = $consulta[0]['descri_tipo_usu'];
            return $consulta;

                
        }else{ // Se por um acaso vir mais de um registro estoura um erro
            throw new \Exception("Email ou senha invalidos(Mais de um registro)",1); 
        }
        
    }      

    public function getDadosUser(){//PEgar dados do usuario        
        $sql = sprintf($this->sqlPegarDados,
                            $this->getCodUsu()                            
                        );
        return $consulta = $this->runSelect($sql);
    }

    public function gerarHash($senha){//Gerar hash
       return password_hash($senha, PASSWORD_DEFAULT, array("cost"=>12));
    }

    public function cadastrarUser(){// Cadastrar Usuario
        if(!empty($this->verificarEmail())){
            throw new \Exception("Não foi possível realizar o cadastro(Email ja existente)",3);
       } 
       $sql = sprintf($this->sqlInsert, // Junta o wher com o outra parte do select
                            $this->getNomeUsu(),
                            $this->getEmail(),
                            $this->getSenha(),
                            $this->getImgCapaUsu(),
                            $this->getImgPerfilUsu(),
                            $this->getCodTipoUsu()                                                        
                        );

        $inserir = $this->runQuery($sql); // Executad a query

        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro",3);   
        }   
        $id = $this->last();
        $tipo = $this->getDescTipo($this->setCodUsu($id));
        
        $_SESSION['id_user'] = $id;
        $_SESSION['tipo_usu'] = $tipo;
        
    }
    
    public function verificarEmail(){//Verficar se ja existe o email
        $sql = sprintf($this->sqlVerifiEmail,
                            $this->getEmail()                            
                        );
        $consulta = $this->runSelect($sql);
        if(empty($consulta)){
            return; // So pra parar a execução
        }

        return $consulta;
    }

    public function getDescTipo(){ //Pegar o tipo usuario
        $sql = sprintf($this->sqlTipoUsu,
                            $this->getCodUsu()                             
                    );
        $consulta = $this->runSelect($sql);
        return $consulta[0]['descri_tipo_usu'];
    }

    public function updateEmailNome(){//Alterar nome e email
        $verifiEmail = $this->verificarEmail();        
        $codUsu = $this->getCodUsu();
        if(!empty($verifiEmail) or $verifiEmail == TRUE){//Se ja existir o email do update            
            if($verifiEmail[0]['cod_usu'] != $codUsu){ // SE o cod_usu da consulta for diferente ao codigo usu da sessao, entao ele nao pode usar esse email
                throw new \Exception("Não foi possível realizar a alteracao(Email ja existente)",4);
            }
            if($verifiEmail[0]['nome_usu'] == $this->getNomeUsu()){ // Cai nesse if se ele nao modificou nada em nenhuma opcao
                return;                                                 //se ele nao modificou nao precisa alterar
            }
        }
        $sql = sprintf($this->sqlUpdateEmailUsu,
                            $this->getEmail(),
                            $this->getNomeUsu(),
                            $codUsu
                        );
        $alterar = $this->runQuery($sql);        
        if($alterar->rowCount() <= 0){
            throw new \Exception("Ops, erro ao alterar, asd",4);
        }
    }

    public function updateSenha($novaSenha){//Altarar Senha
        $dados = $this->getDadosUser();
        $hashUsu = $dados[0]['senha_usu'];
        $senhaAntiga = $this->getSenha();
        if(!password_verify($senhaAntiga, $hashUsu)){
            throw new \Exception("Senha Incorreta",5);
        }
        if(empty($novaSenha)){
            throw new \Exception("Nova senha vazia",5);
        }        
        $novoHash = $this->gerarHash($novaSenha);

        $sql = sprintf($this->sqlUpdateSenha,
                            $novoHash,
                            $this->getCodUsu()
                        );
        $alterar = $this->runQuery($sql);
        if($alterar->rowCount() <= 0){
            throw new \Exception("Ops, erro ao alterar",5);
        }
    }
    
 }