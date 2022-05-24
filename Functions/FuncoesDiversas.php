<?php

namespace EdukInfo\Functions;

use InvalidArgumentException;

class FuncoesDiversas {
    public static function devolverJsonErro(mixed $objErro, mixed &...$objParaGC): never {
        if($objErro === null) {
            throw new InvalidArgumentException('$objErro NÃO PODE ser passado como NULL!');
        }
        unset($objParaGC);
        exit(json_encode($objErro));
    }
    public static function removerAcentos(string $str):string {
        $arrAcentos[] = '/(á|à|ã|â|ä)/';
        $arrAcentos[] = '/(Á|À|Ã|Â|Ä)/';
        $arrAcentos[] = '/(é|è|ê|ë)/';
        $arrAcentos[] = '/(É|È|Ê|Ë)/';
        $arrAcentos[] = '/(í|ì|î|ï)/';
        $arrAcentos[] = '/(Í|Ì|Î|Ï)/';
        $arrAcentos[] = '/(ó|ò|õ|ô|ö)/';
        $arrAcentos[] = '/(Ó|Ò|Õ|Ô|Ö)/';
        $arrAcentos[] = '/(ú|ù|û|ü)/';
        $arrAcentos[] = '/(Ú|Ù|Û|Ü)/';
        $arrAcentos[] = '/(ñ)/';
        $arrAcentos[] = '/(Ñ)/';
        return preg_replace($arrAcentos,explode(" ","a A e E i I o O u U n N"),$str);
    }
}