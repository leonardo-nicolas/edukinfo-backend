<?php

namespace EdukInfo\Models;

use EdukInfo\Exceptions\ArgumentoMuitoLongoException;
use EdukInfo\Functions\Validacao;
use InvalidArgumentException;

class Endereco
{
    private string
        $descricao="",
        $finalidade="",
        $endereco="",
        $bairro="",
        $cidade="",
        $cep="";
    private ?string $complemento = null;
    private Estado $estado = Estado::desconhecido;
    private ?int $numero = null;
    public function __construct(
        private ?int $id = null
    ) {
        //Aqui não existe regra de negócios! Pois, é apenas para
        //declarações feitas direto no construtor.
        //Estes comentários são apenas para suprimir alguns dos
        //supostos "erros" em que a IDE JetBrains PhpStorm estava acusando...
    }

    /**
     * Obtém a descrição definido pelo usuário, caso se aplique
     * @return string
     */
    public function getDescricao(): string {
        return $this->descricao;
    }

    /**
     * Define a descrição do endereço
     * @param string $descricao
     * @return Endereco
     * @throws ArgumentoMuitoLongoException Ocorre quando *$descricao* foi passado com mais de 50 caractéres.
     */
    public function setDescricao(string $descricao): Endereco {
        if(strlen($descricao) > 50){
            throw new ArgumentoMuitoLongoException('$descricao',50);
        }
        $this->descricao = $descricao;
        return $this;
    }

    /**
     * Obtém a finalidade do endereço (ex.: cobrança) definido pelo usuário, caso se aplique
     * @return string
     */
    public function getFinalidade(): string {
        return $this->finalidade;
    }

    /**
     * Define a finalidade deste endereço (Como por exemplo, "cobrança")
     * @param string $finalidade
     * @return Endereco
     * @throws ArgumentoMuitoLongoException Acontece quando o argumento `$finalidade` passa de 20 caractéres.
     */
    public function setFinalidade(string $finalidade): Endereco {
        if(strlen($finalidade) > 20){
            throw new ArgumentoMuitoLongoException('$finalidade',20);
        }
        $this->finalidade = $finalidade;
        return $this;
    }

    /**
     * Obtém o endereço definido pelo usuário, caso se aplique
     * @return string
     */
    public function getEndereco(): string {
        return $this->endereco;
    }

    /**
     * Define o endereço
     * @param string $endereco
     * @return Endereco
     * @throws ArgumentoMuitoLongoException Ocorre quando *$endereco* foi passado com mais de 200 caractéres.
     */
    public function setEndereco(string $endereco): Endereco {
        if(strlen($endereco) > 200){
            throw new ArgumentoMuitoLongoException('$endereco',200);
        }
        $this->endereco = $endereco;
        return $this;
    }

    /**
     * Obtém o complemento definido pelo usuário, caso se aplique.
     * @return string|null
     */
    public function getComplemento(): ?string {
        return $this->complemento;
    }

    /**
     * Define o complemento
     * @param string $complemento
     * @return Endereco
     * @throws ArgumentoMuitoLongoException Ocorre quando *$complemento* foi passado com mais de 60 caractéres.
     */
    public function setComplemento(string $complemento): Endereco {
        if(strlen($complemento) > 60){
            throw new ArgumentoMuitoLongoException('$complemento',60);
        }
        $this->complemento = $complemento;
        return $this;
    }

    /**
     * Obtém o bairro definido pelo usuário, caso se aplique
     * @return string
     */
    public function getBairro(): string {
        return $this->bairro;
    }

    /**
     * Define o bairro
     * @param string $bairro
     * @return Endereco
     * @throws ArgumentoMuitoLongoException Ocorre quando *$bairro* foi passado com mais de 50 caractéres.
     */
    public function setBairro(string $bairro): Endereco {
        if(strlen($bairro) > 50){
            throw new ArgumentoMuitoLongoException('$bairro',50);
        }
        $this->bairro = $bairro;
        return $this;
    }

    /**
     * Obtém a cidade definido pelo usuário, caso se aplique
     * @return string
     */
    public function getCidade(): string {
        return $this->cidade;
    }

    /**
     * Define a cidade
     * @param string $cidade
     * @return Endereco
     * @throws ArgumentoMuitoLongoException Ocorre quando *$cidade* foi passado com mais de 50 caractéres.
     */
    public function setCidade(string $cidade): Endereco {
        if(strlen($cidade) > 50){
            throw new ArgumentoMuitoLongoException('$cidade',50);
        }
        $this->cidade = $cidade;
        return $this;
    }

    /**
     * Obtém o CEP definido pelo usuário, caso se aplique
     * @return string
     */
    public function getCep(): string {
        return $this->cep;
    }

    /**
     * Define o CEP
     * @param string $cep
     * @return Endereco
     * @throws ArgumentoMuitoLongoException Ocorre quando *$cep* foi passado com mais de 10 caractéres.
     * @throws InvalidArgumentException Ocorre quando o CEP é inválido
     */
    public function setCep(string $cep): Endereco {
        if(strlen($cep) > 10){
            throw new ArgumentoMuitoLongoException('$cep',10);
        }
        if(!Validacao::CEP($cep)){
            throw new InvalidArgumentException("CEP inválido!");
        }
        $this->cep = $cep;
        return $this;
    }

    /**
     * Obtém o estado definido pelo usuário, caso se aplique
     * @return Estado
     */
    public function getEstado(): Estado {
        return $this->estado;
    }

    /**
     * Define o estado
     * @param Estado $estado
     * @return Endereco
     */
    public function setEstado(Estado $estado): Endereco {
        $this->estado = $estado;
        return $this;
    }

    /**
     * Obtém o ID deste endereço armazenado no banco de dados, caso se aplique
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Obtém o número da casa/empresa localizada no endereço, definido pelo usuário, caso se aplique.
     * @return int|null
     */
    public function getNumero(): ?int {
        return $this->numero;
    }

    /**
     * Define o número da casa/empresa localizada no endereço, definido pelo usuário, caso se aplique.
     * @param int $numero
     * @return Endereco
     */
    public function setNumero(int $numero): Endereco {
        $this->numero = $numero;
        return $this;
    }

    function __destruct() {
        unset(
          $this->estado,
          $this->complemento,
          $this->cidade,
          $this->bairro,
          $this->id,
          $this->numero,
          $this->finalidade,
          $this->descricao,
          $this->endereco,
          $this->cep
        );
    }

    function __toString(): string {
        $cepFormatado = preg_replace('/\D+/','',$this->cep);
        $cepFormatado = substr($cepFormatado,0,5) . "-" . substr($cepFormatado,5,3);
        return
            $this->endereco . ", " .
            ($this->numero !== null ? $this->numero : "s/n") . " - " .
            ($this->complemento !== null ? $this->complemento  : "") . " - " .
            $this->bairro . " - " .
            $this->cidade . " - " .
            $this->estado->value . " - CEP:" . $cepFormatado;
    }
}