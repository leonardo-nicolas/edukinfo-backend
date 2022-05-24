<?php

namespace EdukInfo\Models;

use JetBrains\PhpStorm\ArrayShape;
use mysqli;
if(!class_exists(Enderecos::class)) {
    require 'Enderecos.php';
}

class Unidades extends Enderecos {
    #[ArrayShape([[
        "cep" => "string",
        "endereco" => "string",
        "numero" => "int",
        "bairro" => "string",
        "municipio" => "string",
        "estado" => "string",
        "complement" => "string",
        "descricao" => "string"
    ]])]
    public function toJsonArray(): array
    {
        $arrays = [];
        foreach ($this as $val) {
            $arrays[] = [
                "cep" => $val->getCep(),
                "endereco" => $val->getEndereco(),
                "numero" => $val->getNumero(),
                "bairro" => $val->getBairro(),
                "municipio" => $val->getCidade(),
                "estado" => $val->getEstado()->value,
                "complement" => $val->getComplemento(),
                "descricao" => $val->getDescricao()
            ];
        }
        return $arrays;
    }

    public static function getAllUnidades():Unidades{
        /** @var mysqli $db */
        $db = require(__DIR__ . '/../db.php');
        $unidadeDB = $db->prepare("SELECT * FROM Unidades ORDER BY RAND()");
        $unidadeDB->execute();
        $unidadeResultado = $unidadeDB->get_result();
        $retorno = new Unidades();
        while($unidadeLn = $unidadeResultado->fetch_assoc()){
            $retorno->add(
                (new Endereco())
                    ->setCep(strval($unidadeLn["cep"]))
                    ->setEndereco(strval($unidadeLn["endereco"]))
                    ->setNumero(intval($unidadeLn["numero"]))
                    ->setBairro(strval($unidadeLn["bairro"]))
                    ->setCidade(strval($unidadeLn["municipio"]))
                    ->setEstado(Estado::parse($unidadeLn["descricao"]))
                    ->setComplemento(strval($unidadeLn["complemento"]))
                    ->setDescricao(strval($unidadeLn["descricao"]))
            );
        }
        return $retorno;
    }
}