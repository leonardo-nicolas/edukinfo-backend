<?php
namespace EdukInfo;

require_once (__DIR__ . '/vendor/autoload.php');

$dirs = [
    'Functions',
    'Exceptions',
    'Models',
    'Controllers',
];

foreach ($dirs as $dir) {
    if(file_exists(__DIR__ . '/' . $dir . '/')) {
        $ojDir = dir(__DIR__ . '/' . $dir);
        while ($arquivo = $ojDir->read()) {
            if (!is_dir($arquivo) && preg_match('/.*.php/', $arquivo)) {
                require_once(__DIR__ . "/" . $dir . "/" . $arquivo);
            }
        }
    }
}

header('Content-Type: charset=utf-8');
header("Access-Control-Allow-Origin:*");