<?php
namespace Action;
use Model\PublicacaoM;
use Core\Logradouro;
use Classes\TratarImg;
use Classes\TratarDataHora;
class PublicacaoA extends PublicacaoM{
    
    private $sqlInsert = "INSERT INTO publicacao(texto_publi, img_publi, titulo_publi, cod_usu, cod_cate, cep_logra,dataHora_publi)
                            VALUES('%s','%s','%s','%s','%s','%s',now())";

    private $sqlSelect = "SELECT usuario.cod_usu,usuario.nome_usu, img_perfil_usu, img_publi,titulo_publi, cod_publi, 
                                    texto_publi, dataHora_publi, descri_cate,categoria.cod_cate, endere_logra, nome_bai, logradouro.cep_logra      
                                    FROM usuario INNER JOIN publicacao on (usuario.cod_usu = publicacao.cod_usu) 
                                    INNER JOIN categoria ON (publicacao.cod_cate = categoria.cod_cate)
                                    INNER JOIN logradouro ON (publicacao.cep_logra = logradouro.cep_logra) 
                                    INNER JOIN bairro ON (logradouro.cod_bai = bairro.cod_bai) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                    WHERE descri_tipo_usu = 'Comum' AND %s  %s ";
    
    private $whereListFromALL = "status_publi = 'A'  AND status_usu = 'A' ";
    
    private $whereIdUser = " AND usuario.cod_usu = '%s' ";

    private $limite = " order by dataHora_publi desc limit 0,6";

    private $sqlSelectQuantCurti = "SELECT COUNT(*) FROM publicacao_curtida WHERE cod_publi = '%s' AND status_publi_curti = 'A'";

    private $sqlSelectQuantComen = "SELECT COUNT(*) FROM comentario WHERE cod_publi = '%s' AND status_comen = 'A'";

    private $sqlSelectVerifyCurti = "SELECT COUNT(*) FROM publicacao_curtida WHERE cod_publi = '%s' AND cod_usu = '%s' AND status_publi_curti = 'A'";
   

    public function cadastrarPublicacao($bairro, $local){
        $this->cadastrarLocal($bairro, $local);
        $this->tratarImagem();
        $sql = sprintf($this->sqlInsert, 
                        $this->getTextoPubli(),
                        $this->getImgPubli(),
                        $this->getTituloPubli(),
                        $this->getCodUsu(),
                        $this->getCodCate(),
                        $this->getCepLogra()
                    );
        $inserir = $this->runQuery($sql);
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro da publicacao",9);   
        }
        return TRUE;

    }

    public function cadastrarLocal($bairro, $local){        
        $logradouto = new Logradouro();
        $logradouto->setEndereLogra($local);
        $logradouto->setCepLogra($this->getCepLogra());             
        $logradouto->selectCep($bairro);
    }

    public function tratarImagem(){ // Mexer depois nessa funcao
        //Fazer a parada da thumb
        if(empty($this->getImgPubli())){
            $this->setImgPubli(NULL);
            return;
        }
        $tratar = new TratarImg();
        $novoNome = $tratar->tratarImagem($this->getImgPubli(), 'publicacao');
        $this->setImgPubli($novoNome);
        return;
    } 

    public function ListFromALL(){ // Listar todas as publicacoes
        $sql = sprintf($this->sqlSelect,
                        $this->whereListFromALL,
                       // '1=1' // colocar um 1=1 pq nao tem mais nada, se nao colocar da pau
                       $this->limite
        );        
        $res = $this->runSelect($sql);
        return $dadosTratados = $this->tratarInformacoes($res);
    }

    public function ListByIdUser(){ //Listar publicacoes de um usuario       
        $sql = sprintf($this->sqlSelect,
                    $this->whereListFromALL,
                    sprintf($this->whereIdUser, $this->getCodUsu())
        );  
        $res = $this->runSelect($sql);        
        $dadosTratados = $this->tratarInformacoes($res);
    }

    public function tratarInformacoes($dados){        
        $contador = 0;
               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa
            $texto = ""; //Limpar a variavel
            $dados[$contador]['dataHora_publi'] = $this->tratarHora($dados[$contador]['dataHora_publi']);//Calcular o tempo
            $cepComTraco = substr($dados[$contador]['cep_logra'],0,5) . '-' . substr($dados[$contador]['cep_logra'],5,8); //Colocar o - no cep 

            $texto .=  $dados[$contador]['nome_bai'] . ', ';   
            $texto .=  $dados[$contador]['endere_logra'];  
            $dados[$contador]['endereco_organizado_fechado'] = $texto; // Nesse campo fica o endereco sem o cep
            $texto .=  ', ';
            $texto .=  $cepComTraco; 
            //$texto = Endereço formatado
            $dados[$contador]['endereco_organizado_aberto'] = $texto; //Cria um novo campo na array, com o endereço organizado com o cep 

            $dados[$contador]['quantidade_curtidas'] =  $this->getQuantCurtidas($dados[$contador]['cod_publi']); //Pegar quantidade de curtidas
            $dados[$contador]['quantidade_comen'] =  $this->getQuantComen($dados[$contador]['cod_publi']); //Pegar quantidade de comentarios    
            if(!empty($this->getCodUsu())){//Só entar aqui se ele estiver logado
                $dados[$contador]['indCurtidaDoUser'] =  $this->getVerifyCurti($dados[$contador]['cod_publi']);//Verificar se ele curtiu a publicacao
                //Me retorna um bollenao
            }
            
            $contador++;
        }     
        
        return $dados;       
        
    }
    
    public function tratarHora($hora){ 
        $tratarHoras = new TratarDataHora($hora);
        return $tratarHoras->calcularTempo('publicacao','N');
    }

    public function getQuantCurtidas($idPubli) { // Pegar quantidades de curtidas na publicacao
        $sql = sprintf($this->sqlSelectQuantCurti,
                                $idPubli);  
        $res = $this->runSelect($sql);         
        return $res[0]['COUNT(*)'];

    }

    public function getQuantComen($idPubli) { // Pegar quantidade de comentarios na publicacao
        $sql = sprintf($this->sqlSelectQuantComen,
                                $idPubli);          
        $res = $this->runSelect($sql);         
        return $res[0]['COUNT(*)'];
    }

    public function getVerifyCurti($idPubli){ //Verificar se o usuario ja curtiu a publicacao
        $sql = sprintf($this->sqlSelectVerifyCurti,
                        $idPubli,
                        $this->getCodUsu());          
        $res = $this->runSelect($sql);
        $quantidade = $res[0]['COUNT(*)'];
        if($quantidade > 0){ //Se for maior q zero é pq ele curtiu
            return TRUE;
        }
        return FALSE;
    }

}