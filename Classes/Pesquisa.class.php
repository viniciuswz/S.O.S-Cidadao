<?php
namespace Classes;
use Classes\Model\PesquisaM;
use Classes\Paginacao;
use Core\PublicacaoSalva;
use Core\Publicacao;
use Core\Debate;
class Pesquisa extends PesquisaM{
    private $sqlPesqPubli = "SELECT 'Publicacao' AS tipo, usuario.cod_usu,usuario.nome_usu, img_perfil_usu, img_publi,titulo_publi, cod_publi, 
                                dataHora_publi AS dataHora, descri_cate, endere_logra, nome_bai, logradouro.cep_logra      
                                %s";

    private $countPesq = " SELECT count(*) %s";

    private $complePesqPubli = "FROM usuario INNER JOIN publicacao on (usuario.cod_usu = publicacao.cod_usu) 
                                    INNER JOIN categoria ON (publicacao.cod_cate = categoria.cod_cate)
                                    INNER JOIN logradouro ON (publicacao.cep_logra = logradouro.cep_logra) 
                                    INNER JOIN bairro ON (logradouro.cod_bai = bairro.cod_bai) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                    WHERE descri_tipo_usu = 'Comum' AND status_publi = 'A' AND status_usu = 'A'
                                    AND (titulo_publi LIKE '%s' OR nome_bai LIKE '%s' OR endere_logra LIKE '%s' OR descri_cate LIKE '%s')
                                    %s %s";


    private $sqlPesqDeba = "SELECT 'Debate' AS tipo, cod_deba, img_deba, nome_deba, dataHora_deba AS dataHora, tema_deba, descri_deba, 
                                debate.cod_usu,nome_usu, img_perfil_usu %s "; 

    private $complePesqDeba = "FROM debate INNER JOIN usuario ON (usuario.cod_usu = debate.cod_usu) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                    WHERE descri_tipo_usu = 'Comum' AND status_usu = 'A' AND status_deba = 'A' 
                                    AND (tema_deba LIKE '%s' OR descri_deba LIKE '%s' OR nome_deba LIKE '%s' %s)
                                    %s %s";
    private $resultados = array();             
    
    private $qtdDd;
    private $qtdPubli;

    public function pesquisar($pagina = null,$filtro = array()){
        if(empty($filtro)){ // nao quero filtos
            $this->pesquisarPubli($pagina);                    
            $this->pesquisarDeba($pagina);
                   
            //return;
        }else{
            $permitidos = array('Deba','Publi');
            foreach($filtro as $valor){
                if(in_array($valor,$permitidos)){
                    $this->{'pesquisar'.$valor}($pagina);
                }            
            }
        }


        $this->resultados = $this->ordenarArray(); // ordenar array por dataHora   
        return $this->resultados;
    }


    public function pesquisarPubli($pagina){
        $paginacao = $this->controlarPaginacao('Publi',$pagina); // paginacao
        $this->setMaiorQuant($this->getQuantidadePaginas()); // setar quantidade de paginas
        if($pagina > $this->getQuantidadePaginas()){ // exemplo pra publi so tem 7, mas pra deva tem 10 paginas, quando eu estiver na 8
            return; // vai ficar carregando as publicacoes da pgina 9 da publi, ou seja repete, nao quero isso
        }// por isso faco parar a execucao
            $sql = sprintf( // sql da publicacao
                $this->sqlPesqPubli,
                sprintf(
                    $this->complePesqPubli,
                    '%'.$this->getTextoPesqui().'%',
                    '%'.$this->getTextoPesqui().'%',
                    '%'.$this->getTextoPesqui().'%',
                    '%'.$this->getTextoPesqui().'%',
                    'GROUP BY cod_publi',
                    $paginacao
                )                
            );
            $res = $this->runSelect($sql); // faz o select   
            if(!empty($res)){ // se for selecionado alguma coisa joga no atributo
                $resTrat = $this->tratarInformacoesPubli($res);
                $this->resultados = array_merge_recursive($this->resultados, $resTrat); 
            } 
            return;
    }

    public function pesquisarDeba($pagina){        
        $paginacao = $this->controlarPaginacao('Deba',$pagina); // paginacao
        $this->setMaiorQuant($this->getQuantidadePaginas());
        if($pagina > $this->getQuantidadePaginas()){ // exemplo pra publi so tem 7, mas pra deva tem 10 paginas, quando eu estiver na 8
            return; // vai ficar carregando as publicacoes da pgina 9 da publi, ou seja repete, nao quero isso
        }// por isso faco parar a execucao
            $sql = sprintf( // sql do debate
                $this->sqlPesqDeba,
                sprintf(
                    $this->complePesqDeba,
                    '%'.$this->getTextoPesqui().'%',
                    '%'.$this->getTextoPesqui().'%',
                    '%'.$this->getTextoPesqui().'%',
                    ' ',
                    'GROUP BY cod_deba',
                    $paginacao
                )                            
            );
            $res = $this->runSelect($sql);
            if(!empty($res)){// se for selecionado alguma coisa joga no atributo
                $resTrat = $this->tratarInformacoesDeba($res);
                $this->resultados = array_merge_recursive($this->resultados, $resTrat); 
            }               
            return;
    }

    public function getQuantPes($tabela){ // quantidade de itens pesquisados
        if($tabela == 'Publi'){
            $comple = '%'.$this->getTextoPesqui().'%';
        }else{
            $comple = ' ';
        }      
        $sql = sprintf(
            $this->countPesq,
            sprintf(
                $this->{'complePesq'.$tabela},
                '%'.$this->getTextoPesqui().'%',
                '%'.$this->getTextoPesqui().'%',
                '%'.$this->getTextoPesqui().'%',
                $comple,
                ' ',
                ' '
            )
        );
        $total = $this->runSelect($sql);   
        return $total[0]['count(*)'];
    }

    public function ordenarArray(){ //Parei aqui, ordenar uma array
        
        $HoraOrganizada = array();
        $newArray = array();
        $dados = $this->resultados;  
        $contador = 0;
        while($contador < count($dados)){
            $segundos = strtotime($dados[$contador]['dataHora']); // Esta em segundos
            $HoraOrganizada[$contador] = $segundos . '.'.$contador;      //Colocar a data e Hora em um vetor concatenado com a posicao da notificacao
            $contador++;
        }
        sort($HoraOrganizada,SORT_NUMERIC );//Ordenar o vetor, so ordena do menor pro maior
        foreach($HoraOrganizada as $valor){
            $posicaoPonto = strpos($valor, '.'); // Achar a posicao do ponto
            $indice = substr($valor, $posicaoPonto + 1); //Nao comecar a pegar a partir do ponto
            $newArray[] = $dados[$indice];
        }
        $OrderMaiorMenor = array_reverse($newArray); //Inverter a array;
        
        //var_dump($OrderMaiorMenor);
        return $OrderMaiorMenor;
    }

    public function tratarInformacoesPubli($dados){        
       
        $publicacao = new Publicacao();
        if(!empty($this->getCodUsu())){
            $publicacaoSalva = new PublicacaoSalva();
            $publicacaoSalva->setCodUsu($this->getCodUsu());            
            $publicacao->setCodUsu($this->getCodUsu());
        }        
        $contador = 0;               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa
            $texto = ""; //Limpar a variavel
            $dados[$contador]['dataHora_publi'] = $publicacao ->tratarHora($dados[$contador]['dataHora']);//Calcular o tempo
            $cepComTraco = substr($dados[$contador]['cep_logra'],0,5) . '-' . substr($dados[$contador]['cep_logra'],5,8); //Colocar o - no cep 

            $texto .=  $dados[$contador]['nome_bai'] . ', ';   
            $texto .=  $dados[$contador]['endere_logra'];  
            $dados[$contador]['endereco_organizado_fechado'] = $texto; // Nesse campo fica o endereco sem o cep
            $texto .=  ', ';
            $texto .=  $cepComTraco; 
            //$texto = Endereço formatado          

            $dados[$contador]['quantidade_curtidas'] =  $publicacao->getQuantCurtidas($dados[$contador]['cod_publi']); //Pegar quantidade de curtidas
            $dados[$contador]['quantidade_comen'] =  $publicacao->getQuantComen($dados[$contador]['cod_publi']); //Pegar quantidade de comentarios
            //$dados[$contador]['indResPrefei'] =  $this->getVerifyResPrefei($dados[$contador]['cod_publi']); //Veficar resposta da prefeitura   
            if(!empty($this->getCodUsu())){//Só entar aqui se ele estiver logado                
                $dados[$contador]['indDenunPubli'] =  $publicacao->getVerificarSeDenunciou($dados[$contador]['cod_publi']);//Verificar se ele denunciou a publicacao               
                $dados[$contador]['indSalvaPubli'] = $publicacao ->getVerificarSeSalvou($publicacaoSalva, $dados[$contador]['cod_publi']);
                //Me retorna um bollenao                
            }
            
            $contador++;
        }     
        
        return $dados;       
        
    }

    public function tratarInformacoesDeba($dados){
        $contador = 0;
        $debate = new Debate();     
        if(!empty($this->getCodUsu())){
            $debate->setCodUsu($this->getCodUsu());
        }
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa
            
            $dados[$contador]['dataHora_deba'] = $debate->tratarHora($dados[$contador]['dataHora']);//Calcular o tempo
            $dados[$contador]['qtdParticipantes'] = $debate->quantidadeTotalParticipantes($dados[$contador]['cod_deba']);//Calcular o total de participantes
            
            
            if(!empty($this->getCodUsu())){//Só entar aqui se ele estiver logado
                $dados[$contador]['indParticipa'] =  $debate->verificarSeParticipaOuNao($dados[$contador]['cod_deba']);//Verificar se ele participa do debate
                $dados[$contador]['indDenunComen'] =  $debate->getVerificarSeDenunciou($dados[$contador]['cod_deba']);//Verificar se ele denunciou o debate
                //Me retorna um bollenao
            }
            $contador++;
        }  
        
        return $dados;
    }

    public function controlarPaginacao($tabelas,$pagina = null){ // Fazer o controle da paginacao       
        $paginacao = new Paginacao(); //Instancinado a classe
        $paginacao->setQtdPubliPaginas(4); //Quantos comentarios quero por pagina       
        $quantidadeTotalPubli = $this->getQuantPes($tabelas); //total de comentarios
        $sqlPaginacao = $paginacao->prapararSql('dataHora','desc', $pagina, $quantidadeTotalPubli);//Prepare o sql
        $this->setQuantidadePaginas($paginacao->getQuantidadePaginas());//Seta a quantidade de paginas no total
        $this->setPaginaAtual($paginacao->getPaginaAtual()); // Seta a pagina atual
        return $sqlPaginacao;
        
    }
}
