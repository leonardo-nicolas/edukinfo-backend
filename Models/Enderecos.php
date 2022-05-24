<?php

namespace EdukInfo\Models;

use Iterator;
use JetBrains\PhpStorm\ArrayShape;

class Enderecos implements Iterator
{
    private int $posicaoAtualArray = 0;
    private int $totalItens = 0;
    /** @var Endereco[] */
    private array $arraysEndereco = [];
    /**
     * Obtém o elemento atual.
     * @link https://php.net/manual/en/iterator.current.php
     * @return Endereco Can return any type.
     */
    public function current(): Endereco {
        return $this->arraysEndereco[$this->posicaoAtualArray];
    }

    /**
     * Avança para o próximo elemento, enquanto existir alguma coisa.
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next(): void {
        ++$this->posicaoAtualArray;
    }

    /**
     * Retorna a posição atual do elemento
     * @link https://php.net/manual/en/iterator.key.php
     * @return int TKey on success, or null on failure.
     */
    public function key(): int {
        return $this->posicaoAtualArray;
    }

    /**
     * Verifica se existe algum próximo elemento
     * @link https://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid(): bool {
        return isset($this->arraysEndereco[$this->posicaoAtualArray]);
    }

    /**
     * Retoma a posição do iterador para a posição zero.
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind(): void {
        $this->posicaoAtualArray = 0;
    }

    public function add(Endereco ...$enderecosUsuario): void {
        foreach ($enderecosUsuario as $endUsuario) {
            $this->arraysEndereco[] = $endUsuario;
            ++$this->totalItens;
        }
    }

    public function removeAt(int $posicao): void {
        array_splice($this->arraysEndereco,$posicao,1);
    }

    public function elementAt(int $posicao): ?Endereco {
        foreach ($this->arraysEndereco as $indice => $val) {
            if($indice === $posicao) {
                return $val;
            }
        }
        return null;
    }

    public function remove(Endereco $elemento): bool {
        foreach ($this->arraysEndereco as $indice => $val) {
            if($elemento === $val) {
                $this->removeAt($indice);
                return true;
            }
        }
        return false;
    }

    #[ArrayShape([[
        "id" => "int",
        "descricao" => "string",
        "finalidade" => "string",
        "endereco" => "string",
        "numero" => "int",
        "complemento" => "string",
        "bairro" => "string",
        "cidade" => "string",
        "estado" => "string",
        "cep" => "string"
    ]])]
    public function toJsonArray(): array {
        $arrays = [];
        foreach ($this->arraysEndereco as $val) {
            $arrays[] = [
                "id" => $val->getId(),
                "descricao" => $val->getDescricao(),
                "finalidade" => $val->getFinalidade(),
                "endereco" => $val->getEndereco(),
                "numero" => $val->getNumero(),
                "complemento" => $val->getComplemento(),
                "bairro" => $val->getBairro(),
                "municipio" => $val->getCidade(),
                "estado" => $val->getEstado()->value,
                "cep" => $val->getCep()
            ];
        }
        return $arrays;
    }
    function __destruct() {
        for($i = 0; $i < $this->totalItens; ++$i){
            unset($this->arraysEndereco[$i]);
        }
        unset(
            $this->arraysEndereco,
            $this->posicaoAtualArray
        );
    }
}