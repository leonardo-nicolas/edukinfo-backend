<?php

namespace EdukInfo\Models;

enum Genero : int
{
    case masculino = 0;
    case feminino = 1;
    case outros = 2;
    public static function parse(mixed $val) : Genero{
        if($val === null) {
            return Genero::outros;
        }
        $val = substr((string)$val,0,1);
        $val = strtolower($val);
        return match ($val){
            'f' => Genero::feminino,
            'm' => Genero::masculino,
            default => Genero::outros
        };
    }
}