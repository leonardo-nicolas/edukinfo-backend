<?php

namespace EdukInfo\Models;
use EdukInfo\Exceptions\ArgumentoMuitoLongoException;
use EdukInfo\Functions\Validacao;
use InvalidArgumentException;

class TelefoneUsuario
{
    private string $descricao = "";
    private int $ddd = 0;
    private string $telefone = "";
    private bool
        $whatsapp = false,
        $telegram = false,
        $wechat = false,
        $sms = false,
        $chamadas = false;

    public function __construct(
        private ?int $id = null
    ) {
        //Aqui não existe regra de negócios! Pois, é apenas para
        //declarações feitas direto no construtor.
        //Estes comentários são apenas para suprimir alguns dos
        //supostos "erros" em que a IDE JetBrains PhpStorm estava acusando...
    }

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescricao(): string {
        return $this->descricao;
    }

    /**
     * @param string $descricao
     * @return $this
     * @throws ArgumentoMuitoLongoException Ocorre quando *$descricao* possui mais de 50 caractéres.
     */
    public function setDescricao(string $descricao): TelefoneUsuario {
        if(strlen($descricao)>50) {
            throw new ArgumentoMuitoLongoException('$descricao', 50);
        }
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * @return int
     */
    public function getDDD(): int {
        return $this->ddd;
    }

    /**
     * @param int $ddd
     * @return $this
     */
    public function setDDD(int $ddd): TelefoneUsuario {
        $this->ddd = $ddd;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelefone(): string {
        return $this->telefone;
    }

    /**
     * @param string $telefone
     * @return $this
     * @throws InvalidArgumentException Ocorre quando o telefone não é um número de telefone fixo válido ou celular não é um número de celular válido.
     */
    public function setTelefone(string $telefone): TelefoneUsuario {
        $tel = preg_replace("/\D/im","",$telefone);
        $lenTel = strlen($tel);
        if(!($lenTel >= 8 && $lenTel <= 9)){
            throw new InvalidArgumentException("O telefone fixo DEVE ter OBRIGATÓRIAMENTE 8 dígitos e o celular DEVE ter OBRIGATÓRIAMENTE 9 dígitos!");
        }elseif($lenTel === 9 && !Validacao::Telefone($tel,true)){
            throw new InvalidArgumentException("O telefone celular DEVE ter OBRIGATÓRIAMENTE 9 dígitos");
        }elseif($lenTel === 8 && !Validacao::Telefone($tel,false)){
            throw new InvalidArgumentException("O telefone fixo DEVE ter OBRIGATÓRIAMENTE 8 dígitos");
        }
        $this->telefone = $tel;
        return $this;
    }

    /**
     * @return bool
     */
    public function isWhatsApp(): bool {
        return $this->whatsapp;
    }

    /**
     * @param bool $whatsapp
     * @return $this
     */
    public function setWhatsApp(bool $whatsapp): TelefoneUsuario {
        $this->whatsapp = $whatsapp;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTelegram(): bool {
        return $this->telegram;
    }

    /**
     * @param bool $telegram
     * @return $this
     */
    public function setTelegram(bool $telegram): TelefoneUsuario {
        $this->telegram = $telegram;
        return $this;
    }

    /**
     * @return bool
     */
    public function isWeChat(): bool {
        return $this->wechat;
    }

    /**
     * @param bool $wechat
     * @return $this
     */
    public function setWeChat(bool $wechat): TelefoneUsuario {
        $this->wechat = $wechat;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSMS(): bool {
        return $this->sms;
    }

    /**
     * @param bool $sms
     * @return $this
     */
    public function setSMS(bool $sms): TelefoneUsuario {
        $this->sms = $sms;
        return $this;
    }

    /**
     * @return bool
     */
    public function isChamadas(): bool {
        return $this->chamadas;
    }

    /**
     * @param bool $chamadas
     * @return $this
     */
    public function setChamadas(bool $chamadas): TelefoneUsuario {
        $this->chamadas = $chamadas;
        return $this;
    }

    function __toString(): string {
        $numLen = strlen($this->telefone);
        $numMask = substr($this->telefone, 0, $numLen === 8 ? 4 : 5);
        $numMask .= "-";
        $numMask .= substr($this->telefone, $numLen === 8 ? 4 : 5, 4);
        return  "$this->descricao: ($this->ddd) $numMask";
    }

    function __destruct() {
        unset(
          $this->id,
          $this->descricao,
          $this->telefone,
          $this->whatsapp,
          $this->wechat,
          $this->telegram,
          $this->sms,
          $this->ddd,
          $this->chamadas
        );
    }
}