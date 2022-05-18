<?php

namespace EdukInfo\Models;

use JetBrains\PhpStorm\ArrayShape;

class EnderecosUsuario
{
    private $posicaoAtualArray = 0;
    private $arraysEndereco = [];
    /**
     * Obtém o elemento atual.
     * @link https://php.net/manual/en/iterator.current.php
     * @return EnderecoUsuario Can return any type.
     */
    public function current(): EnderecoUsuario {
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

    public function add(EnderecoUsuario ...$telefoneUsuario): void {
        $this->arraysEndereco[] = $telefoneUsuario;
    }

    public function removeAt(int $posicao): void {
        array_splice($this->arraysEndereco,$posicao,1);
    }

    public function elementAt(int $posicao): ?EnderecoUsuario {
        foreach ($this->arraysEndereco as $indice => $val) {
            foreach ((object)($val) as $val2) {
                if($indice === $posicao) {
                    return $val2;
                }
            }
        }
        return null;
    }

    public function remove(EnderecoUsuario $elemento): bool {
        foreach ($this->arraysEndereco as $indice => $val) {
            foreach ((object)($val) as $val2) {
                if($val2 === $elemento) {
                    $this->removeAt($indice);
                    return true;
                }
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
            foreach ((object)($val) as $val2) {
                $arrays[] = [
                    "id" => $val2->getId(),
                    "descricao" => $val2->getDescricao(),
                    "finalidade" => $val2->getFinalidade(),
                    "endereco" => $val2->getEndereco(),
                    "numero" => $val2->getNumero(),
                    "complemento" => $val2->getComplemento(),
                    "bairro" => $val2->getBairro(),
                    "cidade" => $val2->getCidade(),
                    "estado" => $val2->getEstado()->value,
                    "cep" => $val2->getCep()
                ];
            }
        }
        return $arrays;
    }
    function __destruct() {
        foreach ($this->arraysEndereco as $val) {
            foreach ((object)($val) as $val2) {
                unset($val2);
            }
            unset($val);
        }
        unset(
            $this->arraysEndereco,
            $this->posicaoAtualArray
        );
    }
}