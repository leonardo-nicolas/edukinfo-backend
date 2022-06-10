<?php

namespace EdukInfo\Models;
use JetBrains\PhpStorm\ArrayShape;

if(!class_exists(Endereco::class)){ require_once __DIR__ . '/Endereco.php'; }
if(!class_exists(ImagemSlideCurso::class)) { require_once __DIR__ . '/ImagemSlideCurso.php'; }
class Unidade extends Endereco
{
    public readonly ImagensSlidesCurso $imagensSlide;
    public function __construct(?int $id = null) {
        parent::__construct($id);
        $this->imagensSlide = new ImagensSlidesCurso();
    }

    public function add(ImagemSlideCurso ...$imagemSlide): Unidade{
        foreach($imagemSlide as $imagem) {
            $this->imagensSlide->add($imagem);
        }
        return $this;
    }

    #[ArrayShape([
        'id' => "int|null",
        'descricao' => "string",
        'cep' => "string",
        'endereco' => "string",
        'numero' => "int|null",
        'bairro' => "string",
        'municipio' => "string",
        'estado' => "string",
        'complemento' => "string|null",
        'fotos' => [[
            "url"=>"string",
            "altTxt"=>"string",
            "descricao"=>"string"
        ]],
    ])]
    public function toJsonArray(): array {
        return [
            'id' => $this->getId(),
            'descricao' => $this->getDescricao(),
            'cep' => $this->getCep(),
            'endereco' => $this->getEndereco(),
            'numero' => $this->getNumero(),
            'bairro' => $this->getBairro(),
            'municipio' => $this->getCidade(),
            'estado' => $this->getEstado(),
            'complemento' => $this->getComplemento(),
            'fotos' => $this->imagensSlide->toJsonArray()
        ];
    }

}