<?php
//session_start();
require_once('../Config/Config.php');
require_once(SITE_ROOT.DS.'autoload.php');  
use Classes\UrlAmigavel;

$url = new UrlAmigavel($_SERVER['REQUEST_URI']);
$nome = $url->partesUrl[1];
//require_once("view/$nome.php");
