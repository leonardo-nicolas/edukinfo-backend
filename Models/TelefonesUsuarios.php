<?php

namespace EdukInfo\Models;

use Iterator;
use JetBrains\PhpStorm\ArrayShape;

class TelefonesUsuarios implements Iterator
{
    private $posicaoAtualArray = 0;
    private $arraysTelefone = [];
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
        $this->arraysTelefone[] = $telefoneUsuario;
    }

    public function removeAt(int $posicao): void {
        array_splice($this->arraysTelefone,$posicao,1);
    }

    public function elementAt(int $posicao): ?TelefoneUsuario {
        foreach ($this->arraysTelefone as $indice => $val) {
            foreach ((object)($val) as $val2) {
                if($indice === $posicao) {
                    return $val2;
                }
            }
        }
        return null;
    }

    public function remove(TelefoneUsuario $elemento): bool {
        foreach ($this->arraysTelefone as $indice => $val) {
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
        "ddd" => "int",
        "numero" => "string",
        "whatsapp" => "bool",
        "telegram" => "bool",
        "wechat" => "bool",
        "chamadas" => "bool",
        "sms" => "bool"
    ]])]
    public function toJsonArray(): array {
        $arrays = [];
        foreach ($this->arraysTelefone as $val) {
            foreach ((object)($val) as $val2) {
                $arrays[] = [
                    "id" => $val2->getId() ?? -1,
                    "descricao" => $val2->getDescricao(),
                    "ddd" => $val2->getDDD(),
                    "numero" => $val2->getTelefone(),
                    "whatsApp" => $val2->isWhatsApp(),
                    "telegram" => $val2->isTelegram(),
                    "weChat" => $val2->isWeChat(),
                    "chamadas" => $val2->isChamadas(),
                    "sms" => $val2->isSMS()
                ];
            }
        }
        return $arrays;
    }

    public function __destruct() {
        foreach ($this->arraysTelefone as $val) {
            foreach ((object)($val) as $val2) {
                unset($val2);
            }
            unset($val);
        }
        unset(
          $this->arraysTelefone,
          $this->posicaoAtualArray
        );
    }
}