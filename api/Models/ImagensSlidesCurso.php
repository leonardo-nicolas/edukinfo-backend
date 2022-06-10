<?php

namespace EdukInfo\Models;


use Iterator;
use JetBrains\PhpStorm\ArrayShape;

class ImagensSlidesCurso implements Iterator
{
    private int $posicaoAtualArray = 0, $totalItens = 0;
    /** @var ImagemSlideCurso[] $arraysTelefone */
    private array $arraysImgSlideCursos = [];
    /**
     * Return the current element
     * @link https://php.net/manual/en/iterator.current.php
     * @return ImagemSlideCurso Can return any type.
     */
    public function current(): ImagemSlideCurso {
        return $this->arraysImgSlideCursos[$this->posicaoAtualArray];
    }

    /**
     * Move forward to next element
     * @link https://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next(): void {
        ++$this->posicaoAtualArray;
    }

    /**
     * Return the key of the current element
     * @link https://php.net/manual/en/iterator.key.php
     * @return int TKey on success, or null on failure.
     */
    public function key(): int {
        return $this->posicaoAtualArray;
    }

    /**
     * Checks if current position is valid
     * @link https://php.net/manual/en/iterator.valid.php
     * @return bool The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid(): bool {
        return isset($this->arraysImgSlideCursos[$this->posicaoAtualArray]);
    }

    /**
     * Rewind the Iterator to the first element
     * @link https://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind(): void {
        $this->posicaoAtualArray = 0;
    }

    public function add(ImagemSlideCurso ...$slidesCurso): void {
        foreach ($slidesCurso as $slideCurso) {
            $this->arraysImgSlideCursos[] = $slideCurso;
            ++$this->totalItens;
        }
    }

    public function length(): int {
        return $this->totalItens;
    }

    public function removeAt(int $posicao): void {
        array_splice($this->arraysImgSlideCursos,$posicao,1);
        --$this->totalItens;
    }

    public function elementAt(int $posicao): ?ImagemSlideCurso {
        foreach ($this->arraysImgSlideCursos as $indice => $val) {
            if($indice === $posicao) {
                return $val;
            }
        }
        return null;
    }

    public function remove(ImagemSlideCurso $elemento): bool {
        foreach ($this->arraysImgSlideCursos as $indice => $val) {
            if($val === $elemento) {
                $this->removeAt($indice);
                return true;
            }
        }
        return false;
    }

    #[ArrayShape([[
        "url"=>"string",
        "altTxt"=>"string",
        "descricao"=>"string"
    ]])]
    public function toJsonArray(): array {
        $arrays = [];
        foreach ($this->arraysImgSlideCursos as $val) {
            $arrays[] = [
                "url"=>$val->src,
                "altTxt"=>$val->altTxt,
                "descricao"=>$val->descricao
            ];
        }
        return $arrays;
    }
    public function __destruct() {
        foreach ($this->arraysImgSlideCursos as $val) {
            unset($val);
        }
        unset(
            $this->arraysTelefone,
            $this->posicaoAtualArray
        );
    }
}