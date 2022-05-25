<?php
namespace EdukInfo;
require_once (__DIR__ . '/vendor/autoload.php');

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

ini_set('default_charset','UTF-8');
header('Content-Type: charset=utf-8');
header("Access-Control-Allow-Origin:*");