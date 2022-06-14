<?php
namespace EdukInfo;
require_once (__DIR__ . '/../vendor/autoload.php');

use Directory;

$dirs = [
    'Functions',
    'Exceptions',
    'Models',
    'Controllers',
];

foreach ($dirs as $dir) {
    if(file_exists(__DIR__ . '/' . $dir . '/')) {
        /** @var Directory $objDir */
        $objDir = dir(__DIR__ . '/' . $dir);
        while ($arquivo = $objDir->read()) {
            if (!is_dir($arquivo) && preg_match('/.*.php/i', $arquivo)) {
                require_once(__DIR__ . "/" . $dir . "/" . $arquivo);
            }
        }
    }
}

require_once (__DIR__ . '/config.php');
  
    // Dá a permissão de acesso de qualquer origem
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        // Decide se a origem em $_SERVER['HTTP_ORIGIN'] é única
        // Você precisa permitir, se for o caso:
        header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }
    
    // Cabeçalho HTTP 'Access-Control' são recebidos durante as requisições usando o método 'OPTIONS'
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
        
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'])) {
	        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, PATCH, HEAD, DELETE");
        }
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS'])) {
	        header("Access-Control-Allow-Headers: " . $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']);
        }
    
        exit(0);
    }

ini_set('default_charset','UTF-8');
header('Content-Type: charset=utf-8');
header("Access-Control-Allow-Origin: *");

header('Access-Control-Allow-Methods: GET, POST');
header("Access-Control-Allow-Headers: X-Requested-With");
