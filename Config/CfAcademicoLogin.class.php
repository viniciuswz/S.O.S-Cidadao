<?php
// Todas as configuraçoes aqui

namespace Config; //Agrupamento de classes
// visando evitar o conflito entre nomes


class CfAcademicoLogin{
    public function __construct(){
        date_default_timezone_set("America/Sao_Paulo");
        setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese'); 
    }    
}