<?php

namespace EdukInfo\Models;

class ImagemSlideCurso
{
    public function __construct(
        public readonly string $src,
        public readonly string $altTxt,
        public readonly string $descricao
    ){}
}