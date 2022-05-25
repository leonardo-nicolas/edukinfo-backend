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
        "complemento" => "string",
        "descricao" => "string"
    ]])]
    public function toJsonArray(): array
    {
        $arrays = [];
        /** @var Unidade $val */
        foreach ($this as $val) {
            $arrays[] = [
                "cep" => $val->getCep(),
                "endereco" => $val->getEndereco(),
                "numero" => $val->getNumero(),
                "bairro" => $val->getBairro(),
                "municipio" => $val->getCidade(),
                "estado" => $val->getEstado()->value,
                "complemento" => $val->getComplemento(),
                "descricao" => $val->getDescricao(),
                "fotos" => $val->imagensSlide->toJsonArray()
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
            $unidade = new Unidade();
            $unidade->setCep(strval($unidadeLn["cep"]));
            $unidade->setEndereco(strval($unidadeLn["endereco"]));
            $unidade->setNumero(intval($unidadeLn["numero"]));
            $unidade->setBairro(strval($unidadeLn["bairro"]));
            $unidade->setCidade(strval($unidadeLn["municipio"]));
            $unidade->setEstado(Estado::parse($unidadeLn["descricao"]));
            $unidade->setComplemento(strval($unidadeLn["complemento"]));
            $unidade->setDescricao(strval($unidadeLn["descricao"]));

            $fotoInteriorUnidade = $db->prepare("SELECT * FROM Fotos_unidade_interior WHERE id_unidade = ? ORDER BY RAND()");
            $fotoInteriorUnidade->bind_param("i", $unidadeLn['id']);
            $fotoInteriorUnidade->execute();
            $fotoInteriorUnidadeResultado = $fotoInteriorUnidade->get_result();

            while ($fotoInteriorUnidadeLn = $fotoInteriorUnidadeResultado->fetch_assoc()) {
                $unidade->imagensSlide->add(
                    new ImagemSlideCurso(
                        strval($fotoInteriorUnidadeLn["image_url"]),
                        strval($fotoInteriorUnidadeLn["image_txt"]),
                        strval($fotoInteriorUnidadeLn["descricao_curta"])
                    )
                );
            }
            $retorno->add($unidade);
        }
        return $retorno;
    }
}