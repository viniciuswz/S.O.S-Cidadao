<?php
if(!defined('DS')){
    define('DS',DIRECTORY_SEPARATOR);
}
if(!defined('ROOT')){
    define('ROOT',str_replace('/','\\',$_SERVER['DOCUMENT_ROOT'])); //$_SERVER['DOCUMENT_ROOT'] = Pega a raiz do servidor
}
if(!defined('SITE_ROOT')){
    define('SITE_ROOT',ROOT.DS.'RepositorioTCC' .DIRECTORY_SEPARATOR. 'TCC');
}

