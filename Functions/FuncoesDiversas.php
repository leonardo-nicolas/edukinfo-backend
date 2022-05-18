<?php

namespace EdukInfo\Functions;

use InvalidArgumentException;
use JetBrains\PhpStorm\Immutable;

class FuncoesDiversas {
    public static function devolverJsonErro(mixed $objErro,StatusCodes $statusCode, mixed &...$objParaGC): void {
        if($objErro === null) {
            throw new InvalidArgumentException('$objErro NÃO PODE ser passado como NULL!');
        }
        http_response_code($statusCode->value);
        unset($statusCode,$objParaGC);
        exit(json_encode($objErro));
    }
}