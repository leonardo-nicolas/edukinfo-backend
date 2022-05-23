<?php

namespace EdukInfo\Models;

use Iterator;
use JetBrains\PhpStorm\ArrayShape;

class TelefonesUsuarios implements Iterator
{
    private int $posicaoAtualArray = 0, $totalItens = 0;
    /** @var TelefoneUsuario[] $arraysTelefone */
    private array $arraysTelefone = [];
    /**
     * Obtém o elemento atual.
     * @link https://php.net/manual/en/iterator.current.php
     * @return TelefoneUsuario Can return any type.
     */
    public function current(): TelefoneUsuario {
        return $this->arraysTelefone[$this->posicaoAtualArray];
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
        return isset($this->arraysTelefone[$this->posicaoAtualArray]);
    }

    /**
     * Retoma a posição do iterador para a posição zero.
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind(): void {
        $this->posicaoAtualArray = 0;
    }

    public function add(TelefoneUsuario ...$telefoneUsuario): void {
        foreach ($telefoneUsuario as $telUser) {
            $this->arraysTelefone[] = $telUser;
            ++$this->totalItens;
        }
    }

    public function length(): int {
        return $this->totalItens;
    }

    public function removeAt(int $posicao): void {
        array_splice($this->arraysTelefone,$posicao,1);
        --$this->totalItens;
    }

    public function elementAt(int $posicao): ?TelefoneUsuario {
        foreach ($this->arraysTelefone as $indice => $val) {
            if($indice === $posicao) {
                return $val;
            }
        }
        return null;
    }

    public function remove(TelefoneUsuario $elemento): bool {
        foreach ($this->arraysTelefone as $indice => $val) {
            if($val === $elemento) {
                $this->removeAt($indice);
                return true;
            }
        }
        return false;
    }

    #[ArrayShape([[
        "id" => "int",
        "descricao" => "string",
        "codigoArea" => "int",
        "numero" => "string",
        "appsMensageiros" => [
            "whatsApp" => "bool",
            "telegram" => "bool",
            "weChat" => "bool",
            "mensagemTexto" => "bool"
        ],
        "chamadas" => "bool"
    ]])]
    public function toJsonArray(): array {
        $arrays = [];
        foreach ($this->arraysTelefone as $val) {
            $arrays[] = [
                "id" => $val->getId() ?? -1,
                "descricao" => $val->getDescricao(),
                "codigoArea" => $val->getDDD(),
                "numero" => $val->getTelefone(),
                "appsMensageiros" => [
                    "whatsApp" => $val->isWhatsApp(),
                    "telegram" => $val->isTelegram(),
                    "weChat" => $val->isWeChat(),
                    "mensagemTexto" => $val->isSMS()
                ],
                "chamadas" => $val->isChamadas(),
            ];
        }
        return $arrays;
    }

    public function __destruct() {
        for($i = 0; $i < $this->totalItens; ++$i){
            unset($this->arraysTelefone[$i]);
        }
        unset(
          $this->arraysTelefone,
          $this->posicaoAtualArray,
          $i
        );
    }
}