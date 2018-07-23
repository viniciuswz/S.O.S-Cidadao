<?php
namespace Action;
use Model\CategoriaM;

class CategoriaA extends CategoriaM{
    private $sqlSelect = "SELECT cod_cate, descri_cate FROM categoria WHERE status_cate = 'A'";

    public function select(){ 
        return $this->runSelect($this->sqlSelect);
    }

    public function gerarOptions(){ //Gerar Options do select para a pagina publicaçoes
        $res = $this->select();
        $option = '';
        $options = array();
        foreach($res as $chaves=>$valores){
            $option = '<option ';
            foreach($valores as $chave => $valor){
                if($chave == 'cod_cate'){
                $option .= 'value="'.$valor .'"';
                }
                if($chave == 'descri_cate'){
                    $option .= 'class="'.$this->tirarAcentos($valor).'"';
                    $option .= ' >'.$valor;
                    $option .= ' </option>';
                    
                }
                    
            }
            $options[] = $option;            
        }
        return $options;

    }

    public function tirarAcentos($palavra){ // Tirar acentos de palavras
        $semAcento = strtolower(preg_replace( '/[`^~\'"]/', null, iconv( 'UTF-8', 'ASCII//TRANSLIT', $palavra )));       
        $tirarEspacos = str_replace(" ", "", $semAcento);
        return $tirarEspacos;
    }


}