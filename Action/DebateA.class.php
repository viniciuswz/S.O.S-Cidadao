<?php
namespace Action;
use Model\DebateM;
use Classes\TratarImg;
use Classes\Paginacao;
use Classes\TratarDataHora;
class DebateA extends DebateM{
    
    private $sqlInsert = "INSERT INTO debate(img_deba, nome_deba, dataHora_deba, tema_deba, descri_deba, cod_usu) 
                VALUES ('%s','%s',now(),'%s','%s','%s')";

    private $sqlInserirPartici = "INSERT INTO debate_participante(cod_deba, cod_usu, data_inicio_lista, data_fim_lista, ind_visu_criador)
                                        VALUES ('%s','%s',now(),null,'%s')";

    private $sqlSelect = "SELECT cod_deba, img_deba, nome_deba, dataHora_deba, tema_deba, descri_deba, 
                                        debate.cod_usu,nome_usu, img_perfil_usu
                                FROM debate INNER JOIN usuario ON (usuario.cod_usu = debate.cod_usu) 
                                INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                WHERE descri_tipo_usu = 'Comum' AND %s  %s %s";

    private $sqlSelectQuantDeba = "SELECT COUNT(*) FROM debate INNER JOIN usuario ON (usuario.cod_usu = debate.cod_usu) 
                                        INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)      
                                        WHERE status_deba = 'A' AND descri_tipo_usu = 'Comum'  AND status_usu = 'A' %s";

    private $sqlSelectQuantPart = "SELECT COUNT(*) FROM debate_participante INNER JOIN usuario ON (usuario.cod_usu = debate_participante.cod_usu) 
                                        INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)      
                                        WHERE status_lista = 'A' AND descri_tipo_usu = 'Comum' AND data_fim_lista is null AND status_usu = 'A' AND cod_deba = '%s'";

    private $sqlVerificarSeEstaParticipando = "SELECT COUNT(*) FROM debate_participante 
                                                    INNER JOIN usuario ON (usuario.cod_usu = debate_participante.cod_usu)
                                                    INNER JOIN debate ON (debate_participante.cod_deba = debate.cod_deba)    
                                                    WHERE data_fim_lista is null AND debate_participante.cod_deba = '%s' 
                                                    AND debate_participante.cod_usu = '%s' AND     
                                                    debate.cod_usu != debate_participante.cod_usu";

    private $whereListFromALL = "status_usu = 'A' AND status_deba = 'A' ";

    private $whereIdDeba = "AND cod_deba = '%s'";
   
    private $sqlPaginaAtual;

    public function tratarImagem(){ // Mexer depois nessa funcao
        //Fazer a parada da thumb       
        $tratar = new TratarImg();
        $novoNome = $tratar->tratarImagem($this->getImgDeba(), 'debate');
        $this->setImgDeba($novoNome);
        return;
    } 

    public function insert(){
        $this->tratarImagem();
        $sql = sprintf($this->sqlInsert,
                        $this->getImgDeba(),
                        $this->getNomeDeba(),
                        $this->getTemaDeba(),
                        $this->getDescriDeba(),
                        $this->getCodUsu()
        );

        $inserir = $this->runQuery($sql);
        $idInserido = $this->last();
        $this->setCodDeba($idInserido);
        $this->inserirParticipante('I');//Aqui vai inserir o dono
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro da publicacao",13);   
        }
        return;        
    }

    public function ListFromALL($pagina = null){ // Listar todas as debates
       
        $sqlPaginacao = $this->controlarPaginacao($pagina, null);
        $sql = sprintf($this->sqlSelect,
                        $this->whereListFromALL,                       
                       ' AND 1=1', //colocar um AND 1=1 pq nao tem mais nada, se nao colocar da pau
                       $sqlPaginacao                       
                       
        );        
        $res = $this->runSelect($sql);
        
        $dadosTratados = $this->tratarDados($res);
        //var_dump($dadosTratados);
        return $dadosTratados;
    }

    public function listByIdDeba(){ // Listar pelo id da publicacao
        $prepararWherePubli = sprintf($this->whereIdDeba, $this->getCodDeba());         
        $sql = sprintf($this->sqlSelect,
                        $this->whereListFromALL,
                        $prepararWherePubli,
                        ' AND 1=1'
        );  
        $res = $this->runSelect($sql);
        if(empty($res)){
            throw new \Exception("Não foi possível fazer o select",9); 
        }        
        $dadosTratados = $this->tratarDados($res); 
        //var_dump($dadosTratados);
        return $dadosTratados;
        
    }

    public function tratarDados($dados){
        $contador = 0;
               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa
            
            $dados[$contador]['dataHora_deba'] = $this->tratarHora($dados[$contador]['dataHora_deba']);//Calcular o tempo
            $dados[$contador]['qtdParticipantes'] = $this->quantidadeTotalParticipantes($dados[$contador]['cod_deba']);//Calcular o total de participantes
            $dados[$contador]['indParticipa'] =  $this->verificarSeParticipaOuNao($dados[$contador]['cod_deba']);//Verificar se ele participa do debate
              
            $contador++;
        }  
        
        return $dados;
    }

    public function tratarHora($hora){ 
        $tratarHoras = new TratarDataHora($hora);
        return $tratarHoras->calcularTempo('debate','N');
    }

    public function quantidadeTotalParticipantes($cod){ // Pegar quantidade total de participantes
        
        $sql = sprintf($this->sqlSelectQuantPart,                             
                        $cod
                    );        
          
        $res = $this->runSelect($sql);
        return $res[0]['COUNT(*)'];
    }

    public function verificarSeParticipaOuNao($codDeba){ //Verifica se o usuario ja esta participando
        $sql = sprintf($this->sqlVerificarSeEstaParticipando,
                        $codDeba,
                        $this->getCodUsu());          
        $res = $this->runSelect($sql);
        $quantidade = $res[0]['COUNT(*)'];
        if($quantidade > 0){ //Se for maior q zero é pq ele curtiu
            return TRUE;
        }
        return FALSE;
    }

    public function quantidadeTotalPubli($where){//Pegar a quantidade de debates
        if($where != null){ // Se for passado o paramentro null, nao tem restriçoes retorna todas as debates
            $sql = sprintf($this->sqlSelectQuantDeba,
                                $where); 
        }else{
            $sql = sprintf($this->sqlSelectQuantDeba,
                                'AND 1=1');
        }
          
        $res = $this->runSelect($sql);
        return $res[0]['COUNT(*)'];
    }

    public function controlarPaginacao($pagina = null, $where){ // Fazer o controle da paginacao       
        $paginacao = new Paginacao(); 
        $paginacao->setQtdPubliPaginas(3); // Setar a quantidade de publicacoes por pagina
        
        $quantidadeTotalPubli = $this->quantidadeTotalPubli($where);   //Pega a quantidade de publicacoes no total          
        
        $sqlPaginacao = $paginacao->prapararSql('dataHora_deba','desc', $pagina, $quantidadeTotalPubli);//Prepare o sql
        $this->setQuantidadePaginas($paginacao->getQuantidadePaginas());//Seta a quantidade de paginas no total
        $this->setPaginaAtual($paginacao->getPaginaAtual());
        return $sqlPaginacao;
        
    }

    public function inserirParticipante($status){
        $sql = sprintf($this->sqlInserirPartici,
                        $this->getCodDeba(),
                        $this->getCodUsu(),
                        $status
        );
        $inserir = $this->runQuery($sql);
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o cadastro da publicacao",13);   
        }
    }
}