<?php
namespace Action;
use Model\UsuarioM;
use Classes\Paginacao;
class UsuarioA extends UsuarioM{

    private $sqlSelectLogar = "SELECT usuario.cod_usu, descri_tipo_usu, senha_usu,status_usu 
                                    FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    WHERE status_tipo_usu = 'A' AND email_usu = '%s'";       

    private $sqlPegarDados = "SELECT usuario.cod_usu, nome_usu, email_usu, 
                                    img_perfil_usu, img_capa_usu, descri_tipo_usu,senha_usu,dataHora_cadastro_usu
                                    FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    WHERE status_usu = 'A' AND status_tipo_usu = 'A' AND usuario.cod_usu = '%s'";

    private $sqlInsert  = "INSERT INTO usuario(nome_usu, email_usu, senha_usu, img_capa_usu, img_perfil_usu, cod_tipo_usu, dataHora_cadastro_usu)
                                VALUES('%s','%s','%s','%s','%s','%s',now())";
                                
    private $sqlVerifiEmail = "SELECT cod_usu,nome_usu FROM usuario WHERE email_usu = '%s'";

    private $sqlTipoUsu = "SELECT descri_tipo_usu FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                            WHERE usuario.cod_usu = '%s'";

    private $sqlUpdateEmailUsu = "UPDATE usuario SET email_usu = '%s', nome_usu = '%s' WHERE cod_usu = '%s'";

    private $sqlUpdateSenha = "UPDATE usuario SET senha_usu = '%s' WHERE cod_usu = '%s'";

    private $sqlSelectDados2 = "SELECT usuario.cod_usu, nome_usu, email_usu, 
                                    descri_tipo_usu, dataHora_cadastro_usu
                                    FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    WHERE status_usu = 'A' AND status_tipo_usu = 'A' AND descri_tipo_usu %s %s ";
    
    private $countSqlSelectDados2 = "SELECT COUNT(*)
                                        FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                        WHERE status_usu = 'A' AND status_tipo_usu = 'A' AND descri_tipo_usu %s";
    
    private $sqlSelectCodTipoUsu = "SELECT cod_tipo_usu FROM tipo_usuario WHERE descri_tipo_usu = '%s' ";

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

    public function cadastrarUser($indAdm){// Cadastrar Usuario
        if(!empty($this->verificarEmail())){
            throw new \Exception("Não foi possível realizar o cadastro(Email ja existente)",3);
        } 
        $this->getCodTipoUsuSelect();
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
        if($indAdm == TRUE){
            return 1; // Inserido pelo adm
        }
        $id = $this->last();
        $tipo = $this->getDescTipo($this->setCodUsu($id));

        $_SESSION['id_user'] = $id;
        $_SESSION['tipo_usu'] = $tipo;        
        return 2; // Nao foi inserido por adm   
        
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

    public function getCodTipoUsuSelect(){ // Pega o cod tipo usu e defini as imagens padrao
        $sql = sprintf($this->sqlSelectCodTipoUsu,                         
                            $this->getDescriTipoUsu()                                                        
                        );
        $consulta = $this->runSelect($sql);
            if(empty($consulta)){
                throw new \Exception("Não foi possível realizar o cadastro tipo usu nao encontrado",3);
            }   
        switch($this->getDescriTipoUsu()){ // Imagens padrao, se quiser mudar é aqui
            case 'Prefeitura':
            case 'Funcionario':
                $this->setImgCapaUsu('concursobarueri4.jpg');// Imagem padrao prefeitura
                $this->setImgPerfilUsu('concursobarueri4.jpg'); // Imagem padrao prefeitura
                break;
            default:
                $this->setImgCapaUsu('imgcapapadrao.jpg');// Imagem padrao user comum
                $this->setImgPerfilUsu('imgperfilpadrao.jpg'); // Imagem padrao comum
            break;
        }
        $this->setCodTipoUsu($consulta[0]['cod_tipo_usu']);
        return;
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

    public function getDadosUsuByTipoUsu($tipos = array(),$pagina = null){
        $in = $this->gerarIn($tipos);
        $sqlLimite = $this->controlarPaginacao($in, $pagina);
        $sql = sprintf(
            $this->sqlSelectDados2,
            $in,
            $sqlLimite
        );
        $consulta =  $this->runSelect($sql);
        $DadosTratados = $this->tratarInformacoesListagem($consulta);
        return $DadosTratados;
        
    }

    public function gerarIn($tipos = array()){// gerar o in, exemplo in('adm','moderador')
        $in = "in( ";
        $contador = 1;
        foreach ($tipos as $valor){
            if($contador == count($tipos)){
                $in.= "'$valor'" . ' )';
            }else{
                $in.= "'$valor'".', ';
            }
            $contador++;            
        }
        return $in;
    }

    public function tratarInformacoesListagem($dados){//Quando for listados os usuarios

        $contador = 0;               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa            
            $dados[$contador]['dataHora_cadastro_usu'] = $this->tratarData($dados[$contador]['dataHora_cadastro_usu']);//Calcular o tempo           
            //$dados[$contador]['LinkVisita'] = $this->LinkParaVisita($dados[$contador]['Tipo'],$dados[$contador]['cod_publi_denun']);//Calcular o tempo    
            //$dados[$contador]['LinkApagarPubli'] = $this->LinkParaDeletar($dados[$contador]['Tipo'],$dados[$contador]['cod_publi_denun']);//Calcular o tempo      
            $dados[$contador]['LinkApagarUsu'] = $this->LinkParaDeletar('Usuario',$dados[$contador]['cod_usu']);//Calcular o tempo                                  
            $contador++;
        }          
        return $dados;
    }

    public function tratarData($data){
        $novaData = new \DateTime($data);
        return $novaData->format('d-m-Y H:i');
    }

    public function LinkParaDeletar($palavra,$cod){ // Deletar Usuario
        $semAcento = strtolower(preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $palavra )));       
        $tirarEspacos = str_replace(" ", "", $semAcento);
        $semAcentos = ucfirst($tirarEspacos);
        return $link = '../Apagar'.$semAcentos.'.php?ID='.$cod;
    }

    public function quantidadeTotalPubli($in = array()){ // Quantidade total de usuarios
        $sql = sprintf(
            $this->countSqlSelectDados2,
            $in
        );
        
        $res = $this->runSelect($sql);        
        return $res[0]['COUNT(*)'];
    }

    public function controlarPaginacao($in,$pagina = null){ // Fazer o controle da paginacao       
        $paginacao = new Paginacao(); //Instancinado a classe
        $paginacao->setQtdPubliPaginas(2); //Quantos comentarios quero por pagina       
        $quantidadeTotalPubli = $this->quantidadeTotalPubli($in); //total de comentarios
        $sqlPaginacao = $paginacao->prapararSql('dataHora_cadastro_usu','desc', $pagina, $quantidadeTotalPubli);//Prepare o sql
        $this->setQuantidadePaginas($paginacao->getQuantidadePaginas());//Seta a quantidade de paginas no total
        $this->setPaginaAtual($paginacao->getPaginaAtual()); // Seta a pagina atual
        return $sqlPaginacao;
        
    }

    
 }