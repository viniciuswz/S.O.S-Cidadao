<?php
namespace Action;
use Model\CategoriaM;

class CategoriaA extends CategoriaM{
    private $sqlSelect = "SELECT cod_cate, descri_cate FROM categoria WHERE status_cate = 'A'";

    public function select(){ 
        return $this->runSelect($this->sqlSelect);
    }

    public function gerarOptions($selecionadoPadrao = null){ //Gerar Options do select para a pagina publicaçoes
        $res = $this->select();
        $input = '';
        $label = '';
        $options = array();
        $contador = 1;
        foreach($res as $chaves=>$valores){
            $input = '
            <div>
                <input type="radio" name="categoria" ';
            $id = 'categoria-'.$contador;
            $input .= 'id="'.$id.'"';
            $label = '<label for='.$id.'> ';
            foreach($valores as $chave => $valor){                
                if($chave == 'cod_cate'){
                    $input .= 'value="'.$valor .'"
                    
                    ';
                }
                if($chave == 'descri_cate'){
                    // quando for colocar os icones oficiais usar este de baixo
                    //$label .= '<i class="'.$this->tirarAcentos($valor).'" ></i><span>'.$valor.'</span></label></div> '; 
                    $label .= '<i class="icone-mail"></i><span>'.$valor.'</span></label></div> '; 
                    if($selecionadoPadrao == $valor){                        
                        $input .= ' checked >';
                    }else{
                        $input .='>                        
                        ';
                        
                    }                           
                }   
            }             
            $options[] = $input; 
            $options[] = $label;
            $contador++;    
        }        
        return $options;

    }

    public function tirarAcentos($palavra){ // Tirar acentos de palavras
        $semAcento = strtolower(preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $palavra )));       
        $tirarEspacos = str_replace(" ", "", $semAcento);
        return $tirarEspacos;
    }


}