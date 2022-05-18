<?php
namespace EdukInfo\Functions;

class Validacao {
    public static function CPF(string $cpf):bool {
        $cpf = preg_replace('/\D+/', '', $cpf);
        $invalidos = [
            "00000000000",
            "11111111111",
            "22222222222",
            "33333333333",
            "44444444444",
            "55555555555",
            "66666666666",
            "77777777777",
            "88888888888",
            "99999999999"
        ];
        // Elimina CPFs inválidos conhecidos
        if ($cpf === '' || in_array($cpf,$invalidos,  true)) {
            return false;
        }
        $soma = 0;
        for ($peso1 = 1; $peso1 <= 9; $peso1++) {
            $soma += intval(substr($cpf, $peso1 - 1, 1)) * (11 - $peso1);
        }
        $resto1 = ($soma * 10) % 11;
        if ($resto1 >= 10) {
            $resto1 = 0;
        }

        $soma = 0;
        for ($peso2 = 1; $peso2 <= 10; $peso2++) {
            $soma = $soma + intval(substr($cpf, $peso2 - 1, 1)) * (12 - $peso2);
        }
        $resto2 = ($soma * 10) % 11;
        if ($resto2 >= 10) {
            $resto2 = 0;
        }
        return $resto2 === intval(substr($cpf, 10, 1)) && $resto1 === intval(substr($cpf, 9, 1));
    }

    public static function CNPJ(string $cnpj):bool {
        $cnpj = preg_replace('/\D+/', '', $cnpj);
        $invalidos = [
            "00000000000000",
            "11111111111111",
            "22222222222222",
            "33333333333333",
            "44444444444444",
            "55555555555555",
            "66666666666666",
            "77777777777777",
            "88888888888888",
            "99999999999999"
        ];
        // Elimina CNPJs invalidos conhecidos
        if ($cnpj === '' || strlen($cnpj) !== 14 || in_array($cnpj,$invalidos,  true)) {
            return false;
        }

        // Valida DVs
        $tamanho = strlen($cnpj) - 2;
        $numeros = substr($cnpj, 0, $tamanho);
        $digitos = substr($cnpj, $tamanho);
        $soma = 0;
        $pos = $tamanho - 7;
        for ($indice = $tamanho; $indice >= 1; $indice--) {
            $soma += intval(substr($numeros, $tamanho - $indice, 1)) * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        $resultado1 = $soma % 11 < 2 ? 0 : 11 - $soma % 11;

        $tamanho += 1;
        $soma *= 0;
        $pos *= 0;
        $pos += $tamanho - 7;
        for ($indice = $tamanho; $indice >= 1; $indice--) {
            $soma += intval(substr($numeros, $tamanho - $indice, 1)) * $pos--;
            if ($pos < 2) {
                $pos = 9;
            }
        }
        $resultado2 = $soma % 11 < 2 ? 0 : 11 - $soma % 11;
        return $resultado2 === intval(substr($digitos, 1, 1)) && $resultado1 === intval(substr($digitos, 0, 1));
    }

    public static function Email(string $email):bool{
        return preg_match('/^[a-z\d\-._+&#]+@[a-z\d]+(.[a-z]{2,8})+$/i',$email);
    }

    public static function Telefone(string $numero, bool $isCelular): bool {
        if($isCelular){
            return preg_match('/^([2-4]\d{3})-?\d{4}$/i',$numero);
        } else {
            return preg_match('/^((9[6-9])\d{3})-?\d{4}$/',$numero);
        }
    }

    public static function CEP($cep):bool {
        return preg_match('/\d{5}-?\d{3}/',$cep);
    }
}