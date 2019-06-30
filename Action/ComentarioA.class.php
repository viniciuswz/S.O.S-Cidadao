<?php
namespace Action;
use Model\ComentarioM;
use Classes\TratarDataHora;
use Classes\Paginacao;
use Core\ComentarioDenuncia;
use Core\Usuario;
class ComentarioA extends ComentarioM{
    private $sqlVerifyDonoPubli = "SELECT cod_publi FROM publicacao WHERE cod_usu = '%s' AND cod_publi = '%s'";

    private $sqlSelectCodPubli = " SELECT cod_publi FROM comentario WHERE cod_comen = '%s' ";

    private $sqlInsert = "INSERT INTO comentario(texto_comen, dataHora_comen, ind_visu_dono_publi, cod_usu, cod_publi, cod_tipo_comentario, nota_resposta) VALUES ('%s', '%s', '%s', '%s','%s', '%s', '%s')";

    private $sqlSelectComen = "SELECT usuario.nome_usu, usuario.cod_usu, cod_comen, img_perfil_usu,texto_comen,dataHora_comen,descri_tipo_usu, publicacao.cod_publi
                                    FROM usuario INNER JOIN comentario ON (usuario.cod_usu = comentario.cod_usu) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                    INNER JOIN publicacao ON (publicacao.cod_publi = comentario.cod_publi) 
                                    LEFT JOIN tipo_comentario AS tipo_comen ON (tipo_comen.cod_tipo_comen = comentario.cod_tipo_comentario)
                                    WHERE 1=1 AND status_comen = 'A' AND %s ";

    private $whereUserComum = " publicacao.cod_publi = '%s' AND descri_tipo_usu = 'Comum' AND status_usu = 'A' %s ";

    private $wherePrefeiFunc =  " publicacao.cod_publi = '%s' AND (descri_tipo_usu = 'Prefeitura' or descri_tipo_usu = 'Funcionario') AND status_usu = 'A'";

    private $whereCodComen = " comentario.cod_comen = '%s' AND status_usu = 'A' %s";
    
    private $sqlSelectVerifyCurti = "SELECT COUNT(*) FROM comen_curtida WHERE cod_comen = '%s' AND cod_usu = '%s' AND status_curte = 'A'";

    private $sqlQtdComenComum = "SELECT COUNT(*) FROM comentario INNER JOIN usuario ON (usuario.cod_usu = comentario.cod_usu) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu)
                                    LEFT JOIN tipo_comentario AS tipo_comen ON (tipo_comen.cod_tipo_comen = comentario.cod_tipo_comentario) 
                                    WHERE  cod_publi = '%s' AND status_comen = 'A' AND descri_tipo_usu = 'Comum'
                                        AND status_usu = 'A' AND %s";

    private $sqlQuantCurtidaComentario = "SELECT COUNT(*) FROM comen_curtida WHERE cod_comen = '%s' AND status_curte = 'A'";


    private $sqlUpdateStatusComen = "UPDATE comentario SET status_comen = '%s' WHERE cod_comen = '%s' AND cod_usu = '%s'";

    private $sqlUpdateComen = "UPDATE comentario SET texto_comen = '%s' WHERE cod_comen = '%s' %s";

    private $sqlSelectAllCodTipoComen = "SELECT cod_tipo_comen, nome_tipo_comen FROM tipo_comentario WHERE status_tipo_comen = 'A' %s";

    private $sqlVerifyUltimaResposta = "SELECT COUNT(*) FROM comentario AS comen INNER JOIN tipo_comentario AS tipo ON(tipo.cod_tipo_comen = comen.cod_tipo_comentario) 
                                            INNER JOIN publicacao AS publi ON (publi.cod_publi = comen.cod_publi)
                                            WHERE comen.cod_tipo_comentario = '%s' AND comen.status_comen = 'A' AND tipo.status_tipo_comen = 'A' AND comen.cod_publi = '%s'";

    private $sqlSelectUltimaResposta = "SELECT cod_comen, texto_comen, dataHora_comen, comen.cod_usu, comen.cod_publi, nota_resposta, nome_usu, img_perfil_usu  FROM comentario AS comen 
                                                INNER JOIN tipo_comentario AS tipo ON(tipo.cod_tipo_comen = comen.cod_tipo_comentario) 
                                                INNER JOIN publicacao AS publi ON (publi.cod_publi = comen.cod_publi)
                                                INNER JOIN usuario AS usu ON (usu.cod_usu = comen.cod_usu)
                                                WHERE comen.cod_tipo_comentario = '%s' AND comen.status_comen = 'A' AND tipo.status_tipo_comen = 'A' AND comen.cod_publi = '%s'";

    public function inserirComen(){        
        $indVisuDono = $this->verifyDonoPubli(); // verificar se é o dono da publicacao
        $DataHora = new \DateTime('NOW');
        $DataHoraFormatadaAmerica = $DataHora->format('Y-m-d H:i:s');    
        
        $codTipoComen = 0;
        $notaResposta = $this->getNotaResposta();
        if($this->verifyDonoPubli() == "N"){ // nao é o dono
            if($_SESSION['tipo_usu'] == 'Prefeitura' OR $_SESSION['tipo_usu'] == 'Funcionario'){
                if($this->getIndUltimaResposta() == "true"){ // Resposta da prefeitura e é a ultima                   
                    if($this->verifyUltimaResposta("Resposta final da prefeitura") > 0){
                        throw new \Exception("Ja existe uma resposta final para está publicação", 1000);                        
                    }
                    $codTipoComen = $this->getCodTipoComen("Resposta final da prefeitura");
                }else{ // Resposta da prefeitura mas nao é a ultima
                    $codTipoComen = $this->getCodTipoComen("Resposta prefeitura");
                }               
            }else{
                $codTipoComen = $this->getCodTipoComen("Comentário comum");
            }   
        }else{ // é o dono
            if($this->getIndUltimaResposta() == "true"){ // ultima resposta do dono da publicação
                if($this->verifyUltimaResposta("Resposta final do dono da publicação") > 0){
                    throw new \Exception("Ja existe uma resposta final para está publicação", 1000);                        
                }               
                $codTipoComen = $this->getCodTipoComen("Resposta final do dono da publicação");
            }else{
                $codTipoComen = $this->getCodTipoComen("Comentário comum");
            }           
        }

        if($notaResposta > 5 OR $notaResposta < 0){
            $notaResposta = 0;
        }
        
        $sql = sprintf($this->sqlInsert,
                        $this->getTextoComen(),
                        $DataHoraFormatadaAmerica,
                        $indVisuDono,
                        $this->getCodUsu(),
                        $this->getCodPubli(),
                        $codTipoComen,
                        $notaResposta
                    );        
        $inserir = $this->runQuery($sql); 
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o comentario",11);   
        }          
        
    }

    public function verifyDonoPubli(){ // Verificar se quem esta comentando é o dono da publicacao
        $sql = sprintf($this->sqlVerifyDonoPubli,                        
                        $this->getCodUsu(),
                        $this->getCodPubli()
        );
        $consulta = $this->runSelect($sql); 
        if(empty($consulta)){ //Quer dizer que nao é o dono da publicacao
            //entao coloca N, para o dono ser notificado
            return "N";            
        }
        return "I"; //Quer dizer que é o dono da publicacao
        //entao coloca I, para o dono nao ser notificado
    }

    public function SelecionarComentariosUserComum($pagina = null){
        $limite = $this->controlarPaginacao($pagina);

        $codigoRespostaComum = $this->getCodTipoComen("Resposta dono publicação");
        $codigoRespotaFinal = $this->getCodTipoComen("Resposta final do dono da publicação");
        $where = " comentario.cod_tipo_comentario != '" . $codigoRespostaComum ."' AND comentario.cod_tipo_comentario != '" . $codigoRespotaFinal ."' AND ";

        $where .= sprintf($this->whereUserComum,
                            $this->getCodPubli(),
                            $limite
                );              
        $sql = sprintf($this->sqlSelectComen,
                        $where       
        );       
        
        $consulta = $this->runSelect($sql); // Executa
        

        return $resultado = $this->tratarDados($consulta);
        //var_dump($resultado);
    }

    public function SelecionarComentariosUserPrefei($indIdPref = null){
        $where = sprintf($this->wherePrefeiFunc,
                            $this->getCodPubli(),
                            'AND 1=1'
                );               
        $sql = sprintf($this->sqlSelectComen,
                        $where       
        );

        $consulta = $this->runSelect($sql); // Executa         
        if(!empty($consulta) AND $consulta[0]['descri_tipo_usu'] == 'Funcionario' AND $indIdPref != null){// Alem do id do funcionario precisso do id da prefeitura
            $sql2 = "SELECT nome_usu, usuario.cod_usu FROM usuario                         
                        INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                        WHERE descri_tipo_usu = 'Prefeitura'";
            $consulta2 =  $this->runSelect($sql2);
            if(!empty($consulta2)){
                $contador = 0;
                while($contador < count($consulta)){
                    $consulta[$contador]['cod_usu_prefei'] = $consulta2[0]['cod_usu'];
                    $consulta[$contador]['nome_usu_prefei'] = $consulta2[0]['nome_usu'];
                    $contador++;
                }                
            }
        }else if(!empty($consulta)){ // Aqui pra usuario de prefeitura mantem o mesmo
            $contador = 0;
            while($contador < count($consulta)){
                $consulta[$contador]['cod_usu_prefei'] = $consulta[0]['cod_usu'];
                $consulta[$contador]['nome_usu_prefei'] = $consulta[0]['nome_usu'];
                $contador++;
            }              
        }        
        return $resultado = $this->tratarDados($consulta);       
    }

    public function tratarDados($dados){
        $contador = 0;
               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa
            
            $dados[$contador]['dataHora_comen'] = $this->tratarHora($dados[$contador]['dataHora_comen']);//Calcular o tempo            
            $dados[$contador]['qtdCurtidas'] =  $this->getQuantCurtiComen($dados[$contador]['cod_comen']);//Verificar se ele curtiu a publicacao
                //Me retorna um bollenao   
            if(!empty($this->getCodUsu())){//Só entar aqui se ele estiver logado
                $dados[$contador]['indCurtidaDoUser'] =  $this->getVerifyCurti($dados[$contador]['cod_comen']);//Verificar se ele curtiu a publicacao
                $dados[$contador]['indDenunComen'] =  $this->getVerificarSeDenunciou($dados[$contador]['cod_comen']);//Verificar se ele denunciou a publicacao
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
    public function getQuantCurtiComen($idComen){ //Verificar se o usuario ja curtiu a publicacao
        $sql = sprintf($this->sqlQuantCurtidaComentario,
                            $idComen    
           );
        $res = $this->runSelect($sql);
        return $res[0]['COUNT(*)'];
    }

    public function getVerifyCurti($idComen){ //Verificar se o usuario ja curtiu a publicacao
        $sql = sprintf($this->sqlSelectVerifyCurti,
                        $idComen,
                        $this->getCodUsu());          
        $res = $this->runSelect($sql);
        $quantidade = $res[0]['COUNT(*)'];
        if($quantidade > 0){ //Se for maior q zero é pq ele curtiu
            return TRUE;
        }
        return FALSE;
    }    
    public function quantidadeTotalPubli(){//Comentarios comum
        $codigoRespostaComum = $this->getCodTipoComen("Resposta dono publicação");
        $codigoRespotaFinal = $this->getCodTipoComen("Resposta final do dono da publicação");
        $where = " comentario.cod_tipo_comentario != '" . $codigoRespostaComum ."' AND comentario.cod_tipo_comentario != '" . $codigoRespotaFinal ."' ";
        $sql = sprintf($this->sqlQtdComenComum,
                                $this->getCodPubli(),
                                $where
                            
        );
        $res = $this->runSelect($sql);
        return $res[0]['COUNT(*)'];
    }

    public function getVerificarSeDenunciou($idComen){
        $idUser = $this->getCodUsu();

        $denun = new ComentarioDenuncia();
        $denun->setCodComen($idComen);
        $denun->setCodUsu($idUser);
        return $denun->verificarSeDenunciou();
    }

    public function controlarPaginacao($pagina = null){ // Fazer o controle da paginacao       
        $paginacao = new Paginacao(); //Instancinado a classe
        $paginacao->setQtdPubliPaginas(6); //Quantos comentarios quero por pagina       
        $quantidadeTotalPubli = $this->quantidadeTotalPubli(); //total de comentarios
        $sqlPaginacao = $paginacao->prapararSql('dataHora_comen','desc', $pagina, $quantidadeTotalPubli);//Prepare o sql
        $this->setQuantidadePaginas($paginacao->getQuantidadePaginas());//Seta a quantidade de paginas no total
        $this->setPaginaAtual($paginacao->getPaginaAtual()); // Seta a pagina atual
        return $sqlPaginacao;
        
    }

    public function getCodPubliByComen(){ // pegar id da publicacao pelo comentario
        $sqlSelect = sprintf(
            $this->sqlSelectCodPubli,
            $this->getCodComen()
        );
        $res = $this->runSelect($sqlSelect);
        $this->setCodPubli($res[0]['cod_publi']);
        return;
    }   

    public function updateStatusComen($status){        
        $usuario = new Usuario();
        $usuario->setCodUsu($this->getCodUsu());
        $tipo = $usuario->getDescTipo();       
        $this->getCodPubliByComen();
        if($tipo == 'Adm' or $tipo == 'Moderador'){
            $sqlUpdateComen = "UPDATE comentario SET status_comen = '%s' WHERE cod_comen = '%s'"; //
            $sql = sprintf(
                $sqlUpdateComen,
                $status,
                $this->getCodComen()                
            );
        }else{
            $sql = sprintf(
                $this->sqlUpdateStatusComen,
                $status,
                $this->getCodComen(),
                $this->getCodUsu()
            );
        }    
        $resposta = $this->runQuery($sql);
        if(!$resposta->rowCount()){
            throw new \Exception("Não foi possível mudar o status",9);
        }

        return;
    }

    public function getDadosComenByIdComen($indErro = false){ // Pegar dados do comentario
        
        $usuario = new Usuario();
        $usuario->setCodUsu($this->getCodUsu());
        $tipoUsu = $usuario->getDescTipo();
        $sql = sprintf(
            $this->sqlSelectComen,
            sprintf(
                $this->whereCodComen,
                $this->getCodComen(),
                " %s " // Coloquei esse coringa para podelo usar nos outros sprintf
            )
        );        

        if($tipoUsu == 'Prefeitura'){ // Prefeitura pode alterar sem se o dono do comentario
            //SO pode editar de respostas
            $sql = sprintf(
                $sql,
                " AND (descri_tipo_usu = 'Prefeitura' or descri_tipo_usu = 'Funcionario')"
            );
            $erro = "Você nao pode editar este comentario";
            $indErro = 16;
        }else if($tipoUsu == 'Adm' OR $tipoUsu == 'Moderador'){ // adm
            $sql = sprintf(
                $sql,
                " AND 1=1 "
            );
            $indDadosTratados = TRUE; // necessito q os dados sejam tratados
            $erro = "Erro ao selecionar o comentário denunciado";
            $indErro = 22;
        }else{ // Se cair nesse if ele tem q ser o dono do comentario
            $whereVerifyDono = " AND comentario.cod_usu = '%s' ";
            $sql = sprintf(
                $sql,
                sprintf(
                    $whereVerifyDono,
                    $this->getCodUsu()
                )
            );
            $erro = "Você nao pode editar este comentario";
            $indErro = 16;
        }
        $res = $this->runSelect($sql);
        if(empty($res)){
            throw new \Exception($erro,$indErro);
        }
        if(isset($indDadosTratados)){ // preciso q os dados sejam tratados
            $res = $this->tratarDados($res);
        }
        return $res;        
    }
    
    public function updateComentario(){ // Editar Comentario
        $dados = $this->getDadosComenByIdComen(); // Verificar se o usuario nao mudou o id via inspecionar elemento
        $usuario = new Usuario();
        $usuario->setCodUsu($this->getCodUsu());
        $tipoUsu = $usuario->getDescTipo();
        $sql = sprintf(
            $this->sqlUpdateComen,
            $this->getTextoComen(),
            $this->getCodComen(),
            ' %s '
        );
        if($tipoUsu == 'Prefeitura'){
            $sql = sprintf(
                $sql,
                ''
            );
        }else{
            $whereVerifyDono = " AND cod_usu = '%s' ";
            $sql = sprintf(
                $sql,
                sprintf(
                    $whereVerifyDono,
                    $this->getCodUsu()
                )
            );
        }

        $res = $this->runQuery($sql);
        if(!$res->rowCount()){            
            if($this->getTextoComen() != $dados[0]['texto_comen']){ // por algum motivo se for igual os dados o update da como 0 linhas afetadas
                // Por isso esse if, so estou o erro se for diferente
                throw new \Exception("Erro ao fazer o update",16);
            }
            
        }

        return $dados[0]['cod_publi']; // Retorna o codigo da publicacao
        
    }

    public function getCodTipoComen($tipo){
        $sql = sprintf(
            $this->sqlSelectAllCodTipoComen,
            "AND 1=1"
        );
        $res = $this->runSelect($sql);
        if(empty($res)){
            return null;
        }        
        $dados = array();
        foreach($res as $array){
            foreach($array as $chave => $vlr){
                $dados[$array['cod_tipo_comen']] = $array['nome_tipo_comen'];
            }
        }

        $codTipoComen = array_search($tipo, $dados);

        if($codTipoComen <= 0){
           return false;
        }
        
        return $codTipoComen;
    }

    public function verifyUltimaResposta($tipo){ // verificar se existe ultima resposta
        $codTipoComen = $this->getCodTipoComen($tipo);
        $sql = sprintf(
            $this->sqlVerifyUltimaResposta,
            $codTipoComen,
            $this->getCodPubli()
        );
        $res = $this->runSelect($sql);
        if(empty($res)){
            return 0;
        }
        return $res[0]['COUNT(*)'];
    }

    public function selectRespostaFinal($tipo){
        if($this->verifyUltimaResposta($tipo) < 0){
            return null;       
        }
        $codTipoComen = $this->getCodTipoComen($tipo);
        $sql = sprintf(
            $this->sqlSelectUltimaResposta,
            $codTipoComen,
            $this->getCodPubli()
        );
        $res = $this->runSelect($sql);
        return $this->tratarDados($res);
    }
}