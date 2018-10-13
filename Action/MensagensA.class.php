<?php
namespace Action;
use Core\Usuario;
use Core\Debate;
use Model\MensagensM;
use Classes\Paginacao;

class MensagensA extends MensagensM{
    private $sqlInsertMensa = "INSERT INTO mensagem(texto_mensa, dataHora_mensa, cod_usu, cod_deba)
                                    VALUES('%s','%s','%s','%s')";
    private $sqlVerificarMensagemDia = "SELECT count(*) FROM mensagem WHERE cod_deba = '%s' AND DATEDIFF('%s',dataHora_mensa) = '0'";

    private $sqlSelectCount = "SELECT count(*) FROM mensagem INNER JOIN debate ON(debate.cod_deba = mensagem.cod_deba)
                                                INNER JOIN mensagem_visualizacao ON(mensagem_visualizacao.cod_mensa = mensagem.cod_mensa)
                                                WHERE mensagem.cod_deba = '%s' AND status_deba = 'A' %s";
    
    private $sqlSelectMensagens = "SELECT texto_mensa,TIME_FORMAT(dataHora_mensa, '%s') AS hora, 
                                        mensagem.cod_usu, nome_usu, descri_tipo_usu,img_perfil_usu, %s
                                        DATEDIFF('%s',dataHora_mensa) AS diferenca, TIME_FORMAT(dataHora_mensa, '%s') AS data
                                        FROM mensagem INNER JOIN usuario ON(mensagem.cod_usu = usuario.cod_usu)
                                        %s
                                        INNER JOIN tipo_usuario ON(usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                        WHERE status_mensa = 'A' 
                                        AND mensagem.cod_deba = '%s'  %s  %s";
    private $sqlInsertMensaVisu = "INSERT INTO mensagem_visualizacao(cod_usu, cod_mensa,status_visu,dataHora_mensa_visu)
                                        VALUES %s";

    private $sqlSelectDonoDeba = "SELECT cod_usu FROM debate WHERE cod_deba = '%s'";

    private $sqlUpdateMensagemVisu = "UPDATE mensagem_visualizacao INNER JOIN mensagem ON(mensagem_visualizacao.cod_mensa = mensagem.cod_mensa)
                                            SET status_visu = 'A' WHERE mensagem.cod_deba = '%s' AND mensagem_visualizacao.cod_usu = '%s'
                                            AND status_visu = 'I'";
    
    private $sqlQuantNVisu = "SELECT COUNT(*) FROM mensagem INNER JOIN mensagem_visualizacao
                                        ON(mensagem_visualizacao.cod_mensa = mensagem.cod_mensa)
                                        WHERE mensagem.cod_deba = '%s' AND mensagem_visualizacao.cod_usu = '%s'
                                        AND status_visu = 'I'";
    
    private $sqlPaginaAtual;

    private $codDono;

    private $inIdsPartici;

    public function __construct($codDeba = null){
        if($codDeba != null){ // setar o id do dono do debate
            $sql = sprintf(
                $this->sqlSelectDonoDeba,
                $codDeba            
            );
            $res = $this->runSelect($sql);              
            $this->codDono = $res[0]['cod_usu'];
        }  
        
        $debate = new Debate();
        $debate->setCodDeba($codDeba);
        $ids = $debate->listarParticipantes('usuario.cod_usu'); 
        $this->inIdsPartici =  $this->gerarValue($ids, 3);           
        
    }
 
    public function inserirMensagem($indSistema = null){
        $veri = $this->verificarMensagemDia();
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 
        if(!$veri){
            $codUsuSitema = $this->getDadosUsuSistema();
            $sql = sprintf(
                $this->sqlInsertMensa,
                'Primeira mensagem do dia',
                $DataHoraFormatadaAmerica,
                $codUsuSitema,
                $this->getCodDeba()
            );
            $res = $this->runQuery($sql); 
            $this->insertMensagemVisualizacao($this->last());
        }
        if($indSistema == null){
            $this->verificarSeParticipa();
        }        
        $sql = sprintf(
            $this->sqlInsertMensa,
            $this->getTextoMensa(),
            $DataHoraFormatadaAmerica,
            $this->getCodUsu(),
            $this->getCodDeba()
        );
        $res2 = $this->runQuery($sql);
        $this->insertMensagemVisualizacao($this->last());
        return;
    }

    public function getDadosUsuSistema(){ // pegar dados do sistema
        $usuario = new Usuario();        
        $tirar = array('in',')','(',"'");// tirar a parte q eu nao quero
        return $codUsuSistema = str_replace($tirar,"",$usuario->getCodUsuByTipoUsu("in('Sistema')")); // pegar id do usuario sistema       
    }

    public function verificarMensagemDia(){ // verificar se alguma mensagem foi enviada neste dia
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 

        $sql = sprintf(
            $this->sqlVerificarMensagemDia,            
            $this->getCodDeba(),
            $DataHoraFormatadaAmerica
        );
        $res = $this->runSelect($sql);        
        if($res[0]['count(*)'] > 0){ // Ja existe uma mensagem hj
            return TRUE;
        }
        return FALSE; // nao existe uma mensagem hj
    }

    public function getMensagens($pagina = null){
        //mensagem_visualizacao.cod_usu = '%s'
        $usuario = new Usuario();
        $usuario->setCodUsu($this->getCodUsu());
        $tipo = $usuario->getDescTipo();

        $paginacao = $this->controlarPaginacao($pagina);
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 
        $sql = sprintf(
            $this->sqlSelectMensagens,
            '%s',            
            '%s', 
            $DataHoraFormatadaAmerica,
            '%s',
            '%s',            
            $this->getCodDeba(),
            "%s",
            $paginacao
        );
        
        if($tipo == 'Adm' OR $tipo == 'Moderador'){
            $sql = sprintf(
                $sql,
                '%H:%i', // comando do sql pra data vir formatada
                '',
                '%e/%c',
                '', // comando do sql pra data vir formatada
                ' '
            );
        }else{
            $sql = sprintf(
                $sql,
                '%H:%i', // comando do sql pra data vir formatada
                ' status_visu, ',
                '%e/%c', // comando do sql pra data vir formatada
                'INNER JOIN mensagem_visualizacao ON(mensagem_visualizacao.cod_mensa = mensagem.cod_mensa)',
                " AND mensagem_visualizacao.cod_usu = '".$this->getCodUsu()."' "
            );
        }        
        $res = $this->runSelect($sql); 
        $dados =   $this->getTratarMensagens($res,$tipo);               
        return $dados;
    }

    public function getTratarMensagens($dados, $tipoUsu){
        $contador = 0;               
        $contador2 = 0;
        $dados2 = array();
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa    
            if(isset($dados[$contador]['status_visu']) AND $dados[$contador]['status_visu'] == 'I' AND !isset($indVisu) AND ($tipoUsu != 'Adm' AND $tipoUsu != 'Moderador')){ // if pra escrever uma mensagem com o texto "tanta mensagens nao lidas"
                $quat = $this->getQuantMensaNVIsu(); // so entra uma vez nesse if
                if($quat == 1){
                    $comple = " mensagem nao lida";
                }else if($quat >= 2){
                    $comple = " mensagens nao lidas";
                }                
                $dados2[$contador2]['texto_mensa'] = "$quat  $comple";
                $dados2[$contador2]['classe'] = 'linha-mensagem_sistema';
                $dados2[$contador2]['data'] = "";
                $dados2[$contador2]['hora'] = "";
                $indVisu = TRUE;
                $contador2++;
            }
            $dados2[$contador2] = $dados[$contador];
            if($dados[$contador]['descri_tipo_usu'] == 'Sistema'){
                $dados2[$contador2]['classe'] = 'linha-mensagem_sistema';     
                if($dados[$contador]['texto_mensa'] == 'Primeira mensagem do dia'){
                    $dados2[$contador2]['hora'] = ""; // nao quero q mostre a hora
                    if($dados[$contador]['diferenca'] == 0){
                        $dados2[$contador2]['texto_mensa'] = 'HOJE';
                    }else if($dados[$contador]['diferenca'] == 1){
                        $dados2[$contador2]['texto_mensa'] = 'ONTEM';
                    }else{
                        $dados2[$contador2]['texto_mensa'] = $dados[$contador]['data']; // quando for maior q um dia coloca a data
                    }                    
                }         
            }else if($this->codDono == $this->getCodUsu()){ // dono do debate
                if($this->codDono != $dados[$contador]['cod_usu']){ // Não é o dono
                    $dados2[$contador2]['classe'] = 'linha-mensagem_padrao';                   
                }else if($this->codDono == $dados[$contador]['cod_usu']){ // se for o dono
                    $dados2[$contador2]['classe'] = 'linha-mensagem_usuario';                   
                }  
            }else{ // nao é o dono do debate
                if($this->getCodUsu() == $dados[$contador]['cod_usu']){ // dono da mensagem
                    $dados2[$contador2]['classe'] = 'linha-mensagem_usuario';                    
                }else if($this->getCodUsu() != $dados[$contador]['cod_usu']){ //nao é o dono
                    $dados2[$contador2]['classe'] = 'linha-mensagem_padrao';                   
                }  
            }   
            
            
            $contador2++;
            $contador++;
        }                 
        return $dados2;
    }

    public function getQuantMensagem(){ // pegar a quantidade de mensagens
        $usuario = new Usuario();
        $usuario->setCodUsu($this->getCodUsu());
        $tipo = $usuario->getDescTipo();
        if($tipo == 'Moderador' OR $tipo == 'Adm'){            
            $comple = "";
        }else{
            $codUsu = $this->getCodUsu();
            $comple = " AND mensagem_visualizacao.cod_usu = '$codUsu'";
        }
        $sql = sprintf(
            $this->sqlSelectCount,
            $this->getCodDeba(),
            $comple
        );        
        $res = $this->runSelect($sql);               
        return $res[0]['count(*)'];
    }

    public function verificarSeParticipa(){
        $debate = new Debate();
        $debate->setCodUsu($this->getCodUsu());
        $debate->verificarSeParticipaOuNao($this->getCodDeba(),true);
        return;
    }       

    public function gerarValue($tipos = array(), $qtdCaracCoringa){
        $in = array();
        $contador = 1;
        $contador2 = 0;   
        $in2 = "";
        while($qtdCaracCoringa > 0){
            if($qtdCaracCoringa == 1){ // exemplo '%s','%s','%s',
                $in2 .= "'%s'";
            }else{
                $in2 .= "'%s',";
            }
            $qtdCaracCoringa --;
        }
        foreach ($tipos as $valores){  
            $in[$contador2] = "(";
            foreach($valores as $valor){
                $in[$contador2] .= "'".$valor."'," . $in2;
                if($contador != count($tipos)){
                    $in[$contador2] .= "),";
                }else{
                    $in[$contador2] .= ")";
                }               
                $contador2++;              
            }            
            $contador++;  
        }
        return $in;
    }

    public function insertMensagemVisualizacao($codMensa){ 
        $contador = 0;        
        $in = "";
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s'); 

        while($contador < count($this->inIdsPartici)){
            $in .= sprintf(
                $this->inIdsPartici[$contador],
                $codMensa,                
                'I',
                $DataHoraFormatadaAmerica
            );
            $contador++;
        }
       $sql = sprintf(
           $this->sqlInsertMensaVisu,
           $in
       );
       $this->runQuery($sql);
       return;
    }

    public function getQuantMensaNVIsu(){
        $sql = sprintf(
            $this->sqlQuantNVisu,
            $this->getCodDeba(),
            $this->getCodUsu()
        );
        $res = $this->runSelect($sql);        
        return $res[0]['COUNT(*)'];
    }

    public function visualizarMensagem(){ // mudar status para visualizado na mensagem
        $sql = sprintf(
            $this->sqlUpdateMensagemVisu,
            $this->getCodDeba(),
            $this->getCodUsu()
        );
        $this->runQuery($sql);
    }

    public function controlarPaginacao($pagina = null){ // Fazer o controle da paginacao       
        $paginacao = new Paginacao(); 
        $paginacao->setQtdPubliPaginas(10); // Setar a quantidade de publicacoes por pagina
        
        $quantidadeTotalPubli = $this->getQuantMensagem();   //Pega a quantidade de publicacoes no total          
        $QuantNVisu = $this->getQuantMensaNVIsu();
        $sqlPaginacao = $paginacao->prapararSqlDebateMensa('dataHora_mensa, mensagem.cod_mensa','ASC', $pagina, $quantidadeTotalPubli, $QuantNVisu);//Prepare o sql
        $this->setQuantidadePaginas($paginacao->getQuantidadePaginas());//Seta a quantidade de paginas no total
        $this->setPaginaAtual($paginacao->getPaginaAtual());
        return $sqlPaginacao;
        
    }
}