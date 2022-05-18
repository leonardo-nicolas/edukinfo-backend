<?php

namespace EdukInfo\Models;

class InfoCarrossel
{
    public function __construct(
        public readonly ?string $caption,
        public readonly ?string $subcaption,
        public readonly ?string $htmlContent,
        public readonly ?string $textContent
    )
    { }
}