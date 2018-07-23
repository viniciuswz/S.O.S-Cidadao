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
                                    texto_publi, dataHora_publi, descri_cate,categoria.cod_cate, endere_logra, nome_bai     
                                    FROM usuario INNER JOIN publicacao on (usuario.cod_usu = publicacao.cod_usu) 
                                    INNER JOIN categoria ON (publicacao.cod_cate = categoria.cod_cate)
                                    INNER JOIN logradouro ON (publicacao.cep_logra = logradouro.cep_logra) 
                                    INNER JOIN bairro ON (logradouro.cod_bai = bairro.cod_bai) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                    WHERE descri_tipo_usu = 'Comum' AND %s AND %s ";

    private $whereListFromALL = "status_publi = 'A'  AND status_usu = 'A' ";
    private $whereIdUser = "usuario.cod_usu = '%s' ";

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
                        '1=1' // colocar um 1=1 pq nao tem mais nada, se nao colocar da pau
        );
        //return $sql;
        $res = $this->runSelect($sql);
        $this->tratarInformacoes($res);
    }
    public function ListByIdUser(){ //Listar publicacoes de um usuario       
        $sql = sprintf($this->sqlSelect,
                    $this->whereListFromALL,
                    sprintf($this->whereIdUser, $this->getCodUsu())
        );          
        //return $sql;
        $res = $this->runSelect($sql);
        //var_dump($res);
        $this->tratarInformacoes($res);
    }
    public function tratarInformacoes($dados){        
        $contador = 0;
        $tempo = array();
        while($contador < count($dados)){
            $dados[$contador]['dataHora_publi'] = $this->tratarHora($dados[$contador]['dataHora_publi']);            
            $contador++;
        }
        var_dump($dados);
        
    }
    public function tratarHora($hora){ 
        $tratarHoras = new TratarDataHora($hora);
        return $tratarHoras->calcularTempo('publicacao','N');
    }
    

}