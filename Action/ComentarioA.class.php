<?php
namespace Action;
use Model\ComentarioM;
use Classes\TratarDataHora;
use Classes\Paginacao;
class ComentarioA extends ComentarioM{
    private $sqlVerifyDonoPubli = "SELECT cod_publi FROM publicacao WHERE cod_usu = '%s' AND cod_publi = '%s'";

    private $sqlInsert = "INSERT INTO comentario(texto_comen, dataHora_comen, ind_visu_dono_publi, cod_usu, cod_publi) VALUES ('%s', now(), '%s', '%s','%s')";

    private $sqlSelectComen = "SELECT usuario.nome_usu, usuario.cod_usu, cod_comen, img_perfil_usu,texto_comen,dataHora_comen
                                    FROM usuario INNER JOIN comentario ON (usuario.cod_usu = comentario.cod_usu) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                    INNER JOIN publicacao ON (publicacao.cod_publi = comentario.cod_publi) 
                                    WHERE 1=1 AND status_comen = 'A' AND %s ";

    private $whereUserComum = " publicacao.cod_publi = '%s' AND descri_tipo_usu = 'Comum' AND status_usu = 'A' %s ";

    private $wherePrefeiFunc =  " publicacao.cod_publi = '%s' AND (descri_tipo_usu = 'Prefeitura' or descri_tipo_usu = 'Funcionario') AND status_usu = 'A'";

    private $sqlSelectVerifyCurti = "SELECT COUNT(*) FROM comen_curtida WHERE cod_comen = '%s' AND cod_usu = '%s' AND status_curte = 'A'";

    private $sqlQtdComenComum = "SELECT COUNT(*) FROM comentario INNER JOIN usuario ON (usuario.cod_usu = comentario.cod_usu) 
                                    INNER JOIN tipo_usuario ON (usuario.cod_tipo_usu = tipo_usuario.cod_tipo_usu) 
                                    WHERE  cod_publi = '%s' AND status_comen = 'A' AND descri_tipo_usu = 'Comum'
                                        AND status_usu = 'A'";

    public function inserirComen(){
        $indVisuDono = $this->verifyDonoPubli();

        $sql = sprintf($this->sqlInsert,
                        $this->getTextoComen(),
                        $indVisuDono,
                        $this->getCodUsu(),
                        $this->getCodPubli()
        );

        $inserir = $this->runQuery($sql); 
        if(!$inserir->rowCount()){  // Se der erro cai nesse if          
            throw new \Exception("Não foi possível realizar o comentario",11);   
        }   
        $this->SelecionarComentariosUserComum();
        $this->SelecionarComentariosUserPrefei();
        
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
        $where = sprintf($this->whereUserComum,
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

    public function SelecionarComentariosUserPrefei(){
        $where = sprintf($this->wherePrefeiFunc,
                            $this->getCodPubli(),
                            'AND 1=1'
                );               
        $sql = sprintf($this->sqlSelectComen,
                        $where       
        );

        $consulta = $this->runSelect($sql); // Executa      
        return $resultado = $this->tratarDados($consulta);
        //var_dump($resultado);
    }

    public function tratarDados($dados){
        $contador = 0;
               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa
            
            $dados[$contador]['dataHora_comen'] = $this->tratarHora($dados[$contador]['dataHora_comen']);//Calcular o tempo
            $dados[$contador]['indCurtidaDoUser'] =  $this->getVerifyCurti($dados[$contador]['cod_comen']);//Verificar se ele curtiu a publicacao
                //Me retorna um bollenao   
            $contador++;
        }  
        
        return $dados;
    }

    public function tratarHora($hora){ 
        $tratarHoras = new TratarDataHora($hora);
        return $tratarHoras->calcularTempo('publicacao','N');
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
        $sql = sprintf($this->sqlQtdComenComum,
                                $this->getCodPubli()
                            
        );
        $res = $this->runSelect($sql);
        return $res[0]['COUNT(*)'];
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
}