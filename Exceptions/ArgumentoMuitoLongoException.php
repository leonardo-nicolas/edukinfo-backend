<?php

namespace EdukInfo\Exceptions;
use Exception;
use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;
use Throwable;

class ArgumentoMuitoLongoException extends Exception {
    public function __construct(string $field = "", int $maxField=1, int $code = 0, ?Throwable $previous = null) {
        parent::__construct("O campo $field está com seu valor muito longo, onde o máximo permitido é ${$field}!", $code, $previous);
    }
}