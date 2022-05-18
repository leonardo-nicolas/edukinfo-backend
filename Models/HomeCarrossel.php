<?php

namespace EdukInfo\Models;

class HomeCarrossel
{
    function __construct(
        public readonly ?ImagemCarrossel $imagemCarrossel,
        public readonly ?InfoCarrossel $infoCarrossel
    )
    { }
}