<?php
namespace Classes;
use Classes\Model\DenunciasM;
use Classes\Paginacao;
class Denuncias extends DenunciasM{
    private $sqlDenunDebate = " %s SELECT 'Debate' AS Tipo,
                                cod_denun_deba AS cod_denun, motivo_denun_deba AS motivo, 
                                dataHora_denun_deba AS dataHora, 
                                debate.cod_usu AS cod_usu_denunciado, 
                                debate_denun.cod_deba AS cod_publi_denun, 
                                debate_denun.cod_usu AS cod_usu_denunciador,
                                nome_usu AS nome_denunciado
                                FROM debate_denun 
                                INNER JOIN debate ON (debate_denun.cod_deba = debate.cod_deba)
                                INNER JOIN usuario ON (debate.cod_usu = usuario.cod_usu)
                                WHERE status_denun_deba = 'A' ";
    private $sqlDenunPubli = " %s SELECT 'Publicação' AS Tipo, 
                                cod_denun_publi AS cod_denun, motivo_denun_publi AS motivo, 
                                dataHora_denun_publi AS dataHora, publicacao.cod_usu AS cod_usu_denunciado, 
                                publicacao.cod_publi AS cod_publi_denun, 
                                publi_denun.cod_usu AS cod_usu_denunciador,
                                nome_usu AS nome_denunciado
                                FROM publi_denun INNER JOIN publicacao ON (publi_denun.cod_publi = publicacao.cod_publi)
                                INNER JOIN usuario ON (publicacao.cod_usu = usuario.cod_usu)
                                WHERE status_denun_publi = 'A' ";

    private $sqlDenunComen = " %s SELECT 'Comentário' AS Tipo, 
                                cod_denun_comen AS cod_denun, motivo_denun_comen AS motivo , 
                                dataHora_denun_comen AS dataHora, comentario.cod_usu AS cod_usu_denunciado, 
                                comen_denun.cod_comen AS cod_publi_denun, comen_denun.cod_usu AS cod_usu_denunciador,
                                nome_usu AS nome_denunciado
                                FROM comen_denun INNER JOIN comentario ON (comen_denun.cod_comen = comentario.cod_comen)
                                INNER JOIN usuario ON (comentario.cod_usu = usuario.cod_usu)
                                WHERE status_denun_comen = 'A' ";
    private $countDenunDebate = " %s SELECT 'Debate' AS Tipo, cod_deba FROM debate_denun WHERE status_denun_deba = 'A' ";
    private $countDenunPubli = " %s SELECT 'Publicação' AS Tipo, cod_publi FROM publi_denun WHERE status_denun_publi = 'A' ";
    private $countDenunComen = " %s SELECT 'Comentário' AS Tipo, cod_comen FROM comen_denun WHERE status_denun_comen = 'A' ";

    public function select($tabelas = array(), $pagina = null){
        $sqlLimite = $this->controlarPaginacao($tabelas,$pagina);
        $sqlNPrepa = $this->gerarSql('sqlDenun',$tabelas);        
        $sqlNPrepa .= " %s";    
        
        $sql = sprintf(
            $sqlNPrepa,
            $sqlLimite
        );
        $res = $this->runSelect($sql); 
        return $this->tratarInformacoes($res);
       
    }
    public function quantidadeTotalPubli($tabelas = array()){
        $sql = $this->gerarSql('countDenun',$tabelas, 'SELECT COUNT(*)  FROM (');
        $sql .= ") as Total";
        
        $res = $this->runSelect($sql);
        
        return $res[0]['COUNT(*)'];
    }

    public function gerarSql($comecoQuery,$tabelas = array(), $priCoringa = " "){
        $sqlNPrepa = "";
        $contador = 0;
        foreach ($tabelas as $valor){
            if($contador == 0){ // Colocar alguma coisa no primeiro %s
                $sqlNPrepa .=  sprintf($this->{$comecoQuery.$valor},$priCoringa); // $this->{$comecoQuery.$valor} gerar o nome do atributo dinamico
            }else{
                $sqlNPrepa .= sprintf($this->{$comecoQuery.$valor}," UNION ");
            }              
            $contador++;
        }
        return $sqlNPrepa;
    }

    public function tratarInformacoes($dados){

        $contador = 0;               
        while($contador < count($dados)){//Nesse while so entra a parte q me interresa            
            $dados[$contador]['dataHora'] = $this->tratarData($dados[$contador]['dataHora']);//Calcular o tempo           
            $dados[$contador]['LinkVisita'] = $this->LinkParaVisita($dados[$contador]['Tipo'],$dados[$contador]['cod_publi_denun']);//Calcular o tempo    
            $dados[$contador]['LinkApagarPubli'] = $this->LinkParaDeletar($dados[$contador]['Tipo'],$dados[$contador]['cod_publi_denun']);//Calcular o tempo      
            $dados[$contador]['LinkApagarUsu'] = $this->LinkParaDeletar('Usuario',$dados[$contador]['cod_usu_denunciado']);//Calcular o tempo                                  
            $contador++;
        }          
        return $dados;
    }

    public function tratarData($data){
        $novaData = new \DateTime($data);
        return $novaData->format('d/m/Y');
    }

    public function LinkParaVisita($palavra,$cod){ // Gerar o link, para ser redirecionado
        $semAcento = strtolower(preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $palavra )));       
        $tirarEspacos = str_replace(" ", "", $semAcento);
        if($tirarEspacos == 'comentario'){ 
            $codPubli = $this->acharPubliDoComen($cod);
            $link = 'VerPublicacaoTemplate.php?ID='.$codPubli.'%IdComen='.$cod;
        }else{
            $semAcentos = ucfirst($tirarEspacos);
            $link = 'Ver'.$semAcentos.'Template.php?ID='.$cod;
        }        
        return $link;
    }

    public function LinkParaDeletar($palavra,$cod){
        $semAcento = strtolower(preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $palavra )));       
        $tirarEspacos = str_replace(" ", "", $semAcento);
        $semAcentos = ucfirst($tirarEspacos);
        return $link = '../Apagar'.$semAcentos.'.php?ID='.$cod;
    }

    public function acharPubliDoComen($cod){ // Achar qual é o cod da publicacao do comentario
        $sql = "SELECT cod_publi FROM comentario WHERE cod_comen = '$cod'";
        $res = $this->runSelect($sql);
        return $res[0]['cod_publi'];        
    }

    public function controlarPaginacao($tabelas,$pagina = null){ // Fazer o controle da paginacao       
        $paginacao = new Paginacao(); //Instancinado a classe
        $paginacao->setQtdPubliPaginas(6); //Quantos comentarios quero por pagina       
        $quantidadeTotalPubli = $this->quantidadeTotalPubli($tabelas); //total de comentarios
        $sqlPaginacao = $paginacao->prapararSql('dataHora','desc', $pagina, $quantidadeTotalPubli);//Prepare o sql
        $this->setQuantidadePaginas($paginacao->getQuantidadePaginas());//Seta a quantidade de paginas no total
        $this->setPaginaAtual($paginacao->getPaginaAtual()); // Seta a pagina atual
        return $sqlPaginacao;
        
    }
}
