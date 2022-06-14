<?php
namespace EdukInfo\Functions;

class Validacao {
    public static function CPF(string $cpf):bool {
        $cpf = preg_replace('/\D+/', '', $cpf);
        // Valida o tamanho ou Verifica se todos os digitos são iguais
        if (strlen($cpf) !== 11 || preg_match('/(\d)\1{11}/', $cpf)) {
            unset($cpf);
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
        $cnpj = preg_replace('/\D+/', '', (string) $cnpj);
        // Valida o tamanho ou Verifica se todos os digitos são iguais
        if (strlen($cnpj) !== 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
            unset($cnpj);
            return false;
        }

        // Valida primeiro dígito verificador
        $soma = 0;
        for ($posicao = 0, $j = 5; $posicao < 12; ++$posicao) {
            $soma += intval(substr($cnpj,$posicao,1)) * $j;
            $j = ($j === 2) ? 9 : $j - 1;
        }

        $resto1 = $soma % 11;
        $sucesso = [];
        $sucesso[] = intval(substr($cnpj,12,1)) === ($resto1 < 2 ? 0 : 11 - $resto1);
        unset($soma);

        // Valida segundo dígito verificador
        $soma=0;
        for ($posicao = 0, $l = 6; $posicao < 13; ++$posicao) {
            $soma += intval(substr($cnpj,$posicao,1)) * $l;
            $l = ($l === 2) ? 9 : $l - 1;
        }
        $resto2 = $soma % 11;
        $sucesso[] = intval(substr($cnpj,13,1)) === ($resto2 < 2 ? 0 : 11 - $resto2);
        unset($posicao,$resto1,$resto2,$soma,$cnpj,$j,$l);
        return $sucesso[0] && $sucesso[1];
    }

    public static function Email(string $email):bool{
        return (bool)filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function Telefone(string $numero, bool $isCelular): bool {
        if($isCelular){
            return preg_match('/^((9[6-9])\d{3})-?\d{4}$/',$numero);
        } else {
            return preg_match('/^([2-4]\d{3})-?\d{4}$/i',$numero);
        }
    }

    public static function CEP($cep):bool {
        return preg_match('/\d{5}-?\d{3}/',$cep);
    }

	public static function is_base64($s):bool {
		return (bool) preg_match('/^[a-zA-Z\d\/\r\n+]*={0,2}$/', $s);
	}
}