<?php
namespace Action;
use Model\UsuarioM;
use Classes\Paginacao;
use Classes\TratarImg;
use Classes\TratarDataHora;

class UsuarioA extends UsuarioM{

    private $sqlSelectLogar = "SELECT usuario.cod_usu, descri_tipo_usu, senha_usu,status_usu 
                                    FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    WHERE status_tipo_usu = 'A' AND email_usu = '%s'";       

    private $sqlPegarDados = "SELECT usuario.cod_usu, nome_usu, email_usu, 
                                    img_perfil_usu, img_capa_usu, descri_tipo_usu,senha_usu,dataHora_cadastro_usu
                                    FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    WHERE status_usu = 'A' AND status_tipo_usu = 'A' AND usuario.cod_usu = '%s'";

    private $sqlInsert  = "INSERT INTO usuario(nome_usu, email_usu, senha_usu, img_capa_usu, img_perfil_usu, cod_tipo_usu, dataHora_cadastro_usu)
                                VALUES('%s','%s','%s','%s','%s','%s','%s')";
                                
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

    private $sqlDeleteUsu = "UPDATE usuario SET status_usu = '%s' WHERE cod_usu = '%s'";

    private $sqlUpdateImagem = "UPDATE usuario SET %s WHERE %s";

    private $sqlSelectCodUsuByTipoUsu = "SELECT cod_usu FROM usuario INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                            WHERE tipo_usuario.descri_tipo_usu %s";


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
                $this->setCodUsu($consulta[0]['cod_usu']); // Setar o codigo do usuario
                $tipoUsu = $this->getDescTipo(); // Selecionar o tipo de usuario
                if($tipoUsu == 'Funcionario'){ // Se a conta desativada for de funcionario
                    throw new \Exception("Infelizmente você nao faz mais parte do time de funcionarios da Prefeitura",1);
                }
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

    public function getDadosUser($tempoDeCadastro = false, $indPerfil = false){//PEgar dados do usuario        
        $sql = sprintf($this->sqlPegarDados,
                            $this->getCodUsu()                            
                        );
        
        $consulta = $this->runSelect($sql);
        if(empty($consulta)){            
            if(isset($_SESSION['id_user']) AND $indPerfil == false){ // Se por um acaso a conta dele for desativa e ele estiver logado, é pra desativar
                session_destroy();
            }else{
                throw new \Exception("Não há registros",1);
            }            
        }
        if($tempoDeCadastro){
            $data = $this->tratarData($consulta[0]['dataHora_cadastro_usu']);
            $consulta[0]['dataHora_cadastro_usu'] = $data;
        }
            return $consulta;
        

        
    }

    public function gerarHash($senha){//Gerar hash
       return password_hash($senha, PASSWORD_DEFAULT, array("cost"=>12));
    }

    public function cadastrarUser($tipoUsuCadastrador){// Cadastrar Usuario
        if(!empty($this->verificarEmail())){
            throw new \Exception("Não foi possível realizar o cadastro(Email ja existente)",3);
        } 
        $this->getCodTipoUsuSelect();

        if($this->verifyExistContPrefei() == TRUE AND $this->getDescriTipoUsu() == 'Prefeitura'){
            throw new \Exception("Não foi possível realizar o cadastro, pois ja existe conta de prefeitura",3);  
        }
        
        if($tipoUsuCadastrador == 'Prefeitura' AND $this->getDescriTipoUsu() != 'Funcionario'){
            throw new \Exception("Não foi possível realizar o cadastro, pois você só tem permissao de cadastrar funcionario",3);
        }

        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 

        $sql = sprintf($this->sqlInsert, // Junta o wher com o outra parte do select
                            $this->getNomeUsu(),
                            $this->getEmail(),
                            $this->getSenha(),
                            $this->getImgCapaUsu(),
                            $this->getImgPerfilUsu(),
                            $this->getCodTipoUsu(),    
                            $DataHoraFormatadaAmerica                                                    
                        );
        

        $inserir = $this->runQuery($sql); // Executad a query
        
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro",3);   
        }  

        if($tipoUsuCadastrador == 'Adm'){// Inserido pelo adm
            return 1; 
        }

        if($tipoUsuCadastrador == 'Prefeitura'){// Inserido pelo prefeitura
            return 2; 
        }
        // Inserido por um user nao cadastrado
            $id = $this->last();
            $tipo = $this->getDescTipo($this->setCodUsu($id));

            $_SESSION['id_user'] = $id;
            $_SESSION['tipo_usu'] = $tipo;      
            $_SESSION['indNovaConta'] = true;  
            return 3; 
        
        
                  
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
                $this->setImgCapaUsu('imgcapapadrao.png');// Imagem padrao user comum
                $this->setImgPerfilUsu('imgperfilpadrao.jpg'); // Imagem padrao comum
            break;
        }
        $this->setCodTipoUsu($consulta[0]['cod_tipo_usu']);
        return;
    }

    public function getCodUsuByTipoUsu($in){ // Pegar os ids do usuario pelo tipo usuario
        $sql = sprintf(
            $this->sqlSelectCodUsuByTipoUsu,
            $in
        );
        $resultado = $this->runSelect($sql);        
        if(empty($resultado)){
            return false;
        }
        $ids = array();
        foreach($resultado as $chaves => $valor){ // Transformar em vetor
            foreach($valor as $chave => $vlr){
                if($chave == 'cod_usu'){
                    $ids[] = $vlr;
                }
            }
        }
        return $this->gerarIn($ids);
    }

    public function verifyExistContPrefei(){ // Verificar se ja existe conta de prefeitura
        $sql = sprintf(
            $this->countSqlSelectDados2,
            ' = "Prefeitura"',
            ' '
        );
        $res = $this->runSelect($sql);        
        $quant = $res[0]['COUNT(*)'];
        if($quant > 0){
            return true;
        }else{
            return false;
        }
    }    

    public function getDadosUsuByTipoUsu($tipos = array(),$pagina = null, $indTabePrefei = null){
        $in = $this->gerarIn($tipos);
        $sqlLimite = $this->controlarPaginacao($in, $pagina);
        $sql = sprintf(
            $this->sqlSelectDados2,
            $in,
            $sqlLimite
        );
        $consulta =  $this->runSelect($sql);
        $DadosTratados = $this->tratarInformacoesListagem($consulta,$indTabePrefei);
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

    public function tratarInformacoesListagem($dados, $indTabe = null){//Quando for listados os usuarios

        $contador = 0;               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa            
            $dados[$contador]['dataHora_cadastro_usu'] = $this->tratarData($dados[$contador]['dataHora_cadastro_usu'], $indTabe);//Calcular o tempo           
            //$dados[$contador]['LinkVisita'] = $this->LinkParaVisita($dados[$contador]['Tipo'],$dados[$contador]['cod_publi_denun']);//Calcular o tempo    
            //$dados[$contador]['LinkApagarPubli'] = $this->LinkParaDeletar($dados[$contador]['Tipo'],$dados[$contador]['cod_publi_denun']);//Calcular o tempo      
            $dados[$contador]['LinkApagarUsu'] = $this->LinkParaDeletar('Usuario',$dados[$contador]['cod_usu']);//Calcular o tempo                                  
            $contador++;
        }          
        return $dados;
    }

    public function tratarData($data,$indTabe = null){
        $novaData = new TratarDataHora($data);     
        if($indTabe == null){ // quero a data com o texto
            return $novaData->tempoDeCadastro();
        }else{ // so quero a dara
            return $novaData->tempoDeCadastroTabelinha();
        }   
        
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
        $paginacao->setQtdPubliPaginas(5); //Quantos comentarios quero por pagina       
        $quantidadeTotalPubli = $this->quantidadeTotalPubli($in); //total de comentarios
        $sqlPaginacao = $paginacao->prapararSql('dataHora_cadastro_usu','desc', $pagina, $quantidadeTotalPubli);//Prepare o sql
        $this->setQuantidadePaginas($paginacao->getQuantidadePaginas());//Seta a quantidade de paginas no total
        $this->setPaginaAtual($paginacao->getPaginaAtual()); // Seta a pagina atual
        return $sqlPaginacao;
        
    }

    public function tratarImagem($imagem,$pasta){ // Mexer depois nessa funcao
        //Fazer a parada da thumb        
        $tratar = new TratarImg();
        $novoNome = $tratar->tratarImagem($imagem, $pasta);
        return $novoNome;        
    }     
    
    public function updateStatusUsu($status, $codUsuApagador){       
        
        $codApagar = $this->getCodUsu(); // Codigo do usuario q sera apagado
        $tipoUserApagado = $this->getDescTipo(); // Status usuario q sera apagado

        $this->setCodUsu($codUsuApagador); // Redefinir p setCodUsu, para o cod do usuario q esta apagando o outro
        $tipo = $this->getDescTipo(); //Verificar o tipo do usuario que esta apagando o outro

        if($tipo == 'Prefeitura'){ // Prefeitura esta apagando o funcionario   
            if($tipoUserApagado != 'Funcionario'){                
                throw new \Exception("Não foi possível mudar o status, pois voce so pode apagar funcionario",9);
            }    

            $sql = sprintf(
                $this->sqlDeleteUsu,
                $status,
                $codApagar                
            );           
            $codReturn = 1; // Prefeitura q esta apagando
        }else if($tipo == 'Adm' or $tipo == 'Moderador'){   //Se for adm executa         
            $sql = sprintf(
                $this->sqlDeleteUsu,
                $status,
                $codApagar                
            );
            $codReturn = 2; // Adm ou moderador q esta apagando
        }else{ // Se nao cair no primeiro if, é pq é o dono da conta q esta apagando. mas temos q ter certeza, por isso q colamos outro comando sql
            $sqlUpdatePubli = "UPDATE usuario SET status_usu = '%s' WHERE (cod_usu = '%s' AND cod_usu = '%s')";
            $sql = sprintf(
                $sqlUpdatePubli,
                $status,    
                $codApagar,  //cod_usu = '%s'         
                $codUsuApagador //AND cod_usu = '%s' 
            );            
            $codReturn = 3; // usuario comum q esta apagando sua conta
        }    
        $resposta = $this->runQuery($sql);
        if(!$resposta->rowCount()){
            throw new \Exception("Não foi possível mudar o status",9);
        }
        if($codReturn == 3){ // 3 = dono da conta q esta apagando
            session_destroy(); // destruir sessao
        }
        return $codReturn;
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

    public function updateImage($imagem,$tipo){ // Alterar imagem de capa ou de perfil
        $tipoUsu = $this->getDescTipo();
               
        if($tipo == 'capa'){
            $campo = " img_capa_usu = '%s' ";
            $nomeImagem = $this->tratarImagem($imagem,'capa');
            $erro = "Não foi possível alterar a imagem de capa";
        }else if($tipo == 'perfil' AND $tipoUsu != 'Funcionario'){
            $campo = " img_perfil_usu = '%s' ";
            $nomeImagem = $this->tratarImagem($imagem,'perfil');
            $erro = "Não foi possível alterar a imagem de perfil";
        }else{
            throw new \Exception('nao tem esse tipo ou voce nao tem autorizacao',5);
        }
       
        $sql = sprintf(
            $this->sqlUpdateImagem,
            $campo,
            '  %s '
        );       
        
        if($tipoUsu == 'Prefeitura'){
            if($tipo == 'perfil'){ // Se for perfil muda de todos os funcionarios
                $inTipo = $this->gerarIn(array('Prefeitura','Funcionario'));            
                $ids = $this->getCodUsuByTipoUsu($inTipo);
            }else{// sE for capa muda so o dele
                $ids = $this->gerarIn(array($this->getCodUsu()));
            }                         
            $sql = sprintf(
                $sql,
                $nomeImagem,
                ' cod_usu '.$ids
            );            
        }else{ // Qualquer um 
            $sql = sprintf(
                $sql,
                $nomeImagem,
                ' cod_usu = '. $this->getCodUsu()
            );
        } 
        $resultado = $this->runQuery($sql);
        if($resultado->rowCount() <= 0 ){
            throw new \Exception($erro,5);           
        }        
        return;       
    }
 }