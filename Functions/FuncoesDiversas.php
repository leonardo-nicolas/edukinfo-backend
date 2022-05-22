<?php

namespace EdukInfo\Functions;

use InvalidArgumentException;
use JetBrains\PhpStorm\Immutable;

class FuncoesDiversas {
    public static function devolverJsonErro(mixed $objErro, mixed &...$objParaGC): never {
        if($objErro === null) {
            throw new InvalidArgumentException('$objErro NÃO PODE ser passado como NULL!');
        }
        unset($objParaGC);
        exit(json_encode($objErro));
    }
}