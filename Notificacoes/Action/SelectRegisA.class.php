<?php 

namespace Notificacoes\Action;
use Notificacoes\Model\GenericaM;

class SelectRegisA extends GenericaM{ 

    private $sqlSelect = "SELECT cod_publi FROM publicacao WHERE cod_usu = '%s' AND status_publi = 'A'";

    private $sqlSelectComen = "SELECT cod_comen FROM comentario WHERE cod_usu = '%s' AND status_comen = 'A'";

    private $sqlSelectSalvos = "SELECT cod_publi,ind_visu_respos_prefei from publicacao_salva where cod_usu = '%s' AND status_publi_sal = 'A' AND (ind_visu_respos_prefei = 'N' or ind_visu_respos_prefei = 'B')";

    //private $sqlComenPrefei = "SELECT cod_publi,ind_visu_respos_prefei from publicacao_salva where cod_usu = '%s' AND status_publi_sal = 'A' AND (ind_visu_respos_prefei = 'N' or ind_visu_respos_prefei = 'B')";

    public function selectPubli():array{
        $sql = sprintf( $this->sqlSelect,
                        $this->getCodUsu()
                    );

        return $this->runSelect($sql); // Retorna uma array Bidimensional
    }

    public function selectComen():array{
        
        $sql = sprintf( $this->sqlSelectComen,
                        $this->getCodUsu()
                    );

        return $this->runSelect($sql);// Retorna uma array Bidimensional
    }
    public function selectSalvos():array{
        
        $sql = sprintf( $this->sqlSelectSalvos,
                        $this->getCodUsu()
                    );

        return $this->runSelect($sql);// Retorna uma array Bidimensional
    }
}