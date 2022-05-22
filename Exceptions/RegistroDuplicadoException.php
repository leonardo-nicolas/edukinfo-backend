<?php

namespace EdukInfo\Exceptions;

use JetBrains\PhpStorm\Internal\LanguageLevelTypeAware;

class RegistroDuplicadoException extends \Exception {
    public function __construct(string $email = "") {
        $this->email = $email;
        parent::__construct("Existe um usuário cadastrado com o e-mail '$email'.");
    }
    public readonly string $email;
}