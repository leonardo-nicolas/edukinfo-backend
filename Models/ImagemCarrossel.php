<?php

namespace EdukInfo\Models;

class ImagemCarrossel
{
    public function __construct(
        public readonly string          $src,
        public readonly string          $alt,
        public readonly string|int|null $number,
        public readonly string|int|null $height
    )
    { }
}