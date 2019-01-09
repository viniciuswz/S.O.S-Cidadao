<?php
if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
if(!defined('ROOT')){
    //define('ROOT',$_SERVER['DOCUMENT_ROOT']);//,str_replace('/','\\',$_SERVER['DOCUMENT_ROOT'])); //$_SERVER['DOCUMENT_ROOT'] = Pega a raiz do servidor
    define('ROOT',str_replace('/','\\',$_SERVER['DOCUMENT_ROOT']));
}
if(!defined('SITE_ROOT')){
    define('SITE_ROOT',ROOT.DS.'RepositorioTcc' .DIRECTORY_SEPARATOR. 'TCC');
}

