<?php
namespace Action;
use Model\PublicacaoSalvaM;
use Core\Publicacao;
use Core\Usuario;
class PublicacaoSalvaA extends PublicacaoSalvaM{      
    private $sqlSelect = "SELECT ind_visu_respos_prefei, status_publi_sal FROM publicacao_salva 
                                INNER JOIN publicacao ON (publicacao_salva.cod_publi = publicacao.cod_publi) 
                                INNER JOIN usuario ON (publicacao.cod_usu = usuario.cod_usu)
                                WHERE publicacao_salva.cod_publi = '%s' AND publicacao_salva.cod_usu = '%s' 
                                AND status_publi = 'A' AND status_usu = 'A'";

    private $sqlInsert = "INSERT INTO publicacao_salva(cod_usu, cod_publi,ind_visu_respos_prefei) VALUES ('%s','%s','%s')";

    private $sqlUpdate = "UPDATE publicacao_salva SET status_publi_sal = '%s' WHERE cod_publi = '%s' AND cod_usu = '%s'";
    
    public function indSalva($indRes = null){
        $sql = sprintf(
            $this->sqlSelect,
             $this->getCodPubli(),
             $this->getCodUsu()
              
         );
         
        $res = $this->runSelect($sql);  
        if($indRes == null){ // Nao preciso de dados de retorno
            if(empty($res) OR (!empty($res) AND $res[0]['status_publi_sal'] == 'I')){
                return false;
            }
            return true;

        }else{ // Preciso de dados de retorno            
            if(empty($res)){
                return false;
            }
            return $res;
        } 
    } 

    public function salvar(){
        $indSalva = $this->indSalva('S');        
        $publicacao = new Publicacao(); 
        $usuario = new Usuario();

        $publicacao->setCodPubli($this->getCodPubli());
        $publicacao->setCodUsu($this->getCodUsu());
        $usuario->setCodUsu($this->getCodUsu());

        $indComenPrefei = $publicacao->getVerifyResPrefei($this->getCodPubli());  
        $verificarDono = $publicacao->verificarDonoPubli();
        $tipoUsu = $usuario->getDescTipo();
        if($verificarDono OR ($tipoUsu == 'Prefeitura' OR $tipoUsu == 'Funcionario')){ // é o dono ou é funcionario ou prefeira nao precisa ser notificado 
            $indVisuRes = 'I';
        }else if(empty($indComenPrefei)){ // Nao tem resposta
            $indVisuRes = 'N';
        }else{//Tem resposta
            $indVisuRes = 'V';
        }      
        
        if(!$indSalva){ // nunca salvou a publicacao Antes            
            $sql = sprintf(
                $this->sqlInsert,
                $this->getCodUsu(),
                $this->getCodPubli(),
                $indVisuRes
            );
            
        }else if($indSalva[0]['status_publi_sal'] == 'A'){ // Parar de Salvar
            $sql = sprintf(
                $this->sqlUpdate,
                'I',
                $this->getCodPubli(),
                $this->getCodUsu()
                
            );
        }else{ // Salvar            
            $sql = sprintf(
                $this->sqlUpdate,
                'A',
                $this->getCodPubli(),
                $this->getCodUsu()
            );
        }  
        //echo $sql;           
        $res = $this->runQuery($sql);
        if($res->rowCount() <= 0){
            throw new \Exception("Erro ao salvar publicacao",17);
        }
        return;
        
    }

}