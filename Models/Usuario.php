<?php

namespace EdukInfo\Models;

use Bcrypt\Bcrypt;
use DateTime;
use DateTimeInterface;
use EdukInfo\Exceptions\ArgumentoMuitoLongoException;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Functions\Validacao;
use Exception;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use LengthException;
use mysqli;
use mysqli_stmt;

class Usuario
{
    private const TRABALHOS_SENHA_BCRYPT = 7;

    private string
        $nome = '',
        $sobrenome = '',
        $documento = '',
        $email = '',
        $senha = '';
    private TipoCliente $tipoCliente;
    private Genero $genero;
    private DateTime $aniversario;
    private TelefonesUsuarios $telefonesUsuario;
    private EnderecosUsuario $enderecosUsuario;

    public function __construct(
        private ?int $id = null
    ) {
        $this->tipoCliente = TipoCliente::PessoaFisica;
        $this->genero = Genero::outros;
        $this->telefonesUsuario = new TelefonesUsuarios();
        $this->enderecosUsuario = new EnderecosUsuario();
    }

    public function getTelefonesUsuario(): TelefonesUsuarios {
        return $this->telefonesUsuario;
    }

    public function setTelefonesUsuario(TelefoneUsuario ...$telefones): Usuario{
        foreach($telefones as $tel) {
            $this->telefonesUsuario->add($tel);
        }
        return  $this;
    }

    public function setEnderecosUsuario(EnderecoUsuario ...$telefones): Usuario{
        foreach($telefones as $tel) {
            $this->enderecosUsuario->add($tel);
        }
        return  $this;
    }

    #[ArrayShape([
        "id" => "int",
        "nome" => "string",
        "sobrenome" => "string",
        "documento" => "string",
        "email" => "string",
        "tipoDeCliente" => "string",
        "genero" => "string",
        "aniversario" => "date",
        "telefones" => "array",
        "enderecos" => "array"
    ])]
    public function toJsonArray(): array {
        $tipoCli = $this->tipoCliente === TipoCliente::PessoaFisica ? 'PF' : 'PJ';
        return [
          "id"=>$this->id ?? -1,
          "nome"=>$this->nome,
          "sobrenome"=>$this->sobrenome,
          "documento"=>$this->documento,
          "email"=>$this->email,
          "tipoDeCliente"=>$tipoCli,
          "genero"=>strtoupper(substr($this->genero->name,0,1)),
          "aniversario"=>$this->aniversario->format(DateTimeInterface::ATOM),
          "telefones"=>$this->telefonesUsuario->toJsonArray(),
          "enderecos"=>$this->enderecosUsuario->toJsonArray()
        ];
    }

    /**
     * Obtém o primeiro nome do usuário desta instância.
     *
     * @return string
     */
    public function getNome(): string {
        return $this->nome;
    }

    /**
     * Define o primeiro nome do usuário nesta instância.
     *
     * @param string $nome
     * @return $this
     * @throws ArgumentoMuitoLongoException Acontece quando o argumento `$nome` passa de 150 caractéres...
     */
    public function setNome(string $nome): Usuario {
        if(strlen($nome) >= 150) {
            throw new ArgumentoMuitoLongoException('$nome',150);
        }
        $this->nome = $nome;
        return $this;
    }

    /**
     * Obtém o sobrenome do cliente ou então o nome fantasia (em caso de PJ)
     *
     * @return string
     */
    public function getSobrenome(): string {
        return $this->sobrenome;
    }

    /**
     * Define o sobrenome do cliente ou então o nome fantasia (Em caso de PJ)
     *
     * @param string $sobrenome
     * @return $this
     * @throws ArgumentoMuitoLongoException Acontece quando o argumento `$sobrenome` passa de 150 caractéres...
     */
    public function setSobrenome(string $sobrenome): Usuario {
        if(strlen($sobrenome) >= 150) {
            throw new ArgumentoMuitoLongoException('$sobrenome',150);
        }
        $this->sobrenome = $sobrenome;
        return $this;
    }

    /**
     * Obtém o CPF ou o CNPJ do cliente
     * @return string
     */
    public function getDocumento(): string {
        return $this->documento;
    }

    /**
     * Define o CPF caso `$tipoCliente` seja pessoa física ou CNPJ caso `$tipoCliente` seja pessoa jurídica.
     * @param string $documento
     * @return $this
     * @throws ArgumentoMuitoLongoException Ocorre quando o *$documento* não possui 11 dígitos para CPF ou 14 dígitos para CNPJ.
     * @throws InvalidArgumentException Ocorre quando não foi possível descobrir se o *$documento* é CPF ou CNPJ...
     */
    public function setDocumento(string $documento): Usuario {
        $docNum = preg_replace("/\D/im","",$documento);
        $lenDoc = strlen($docNum);
        if($this->tipoCliente === TipoCliente::PessoaFisica && $lenDoc !== 11) {
            throw new ArgumentoMuitoLongoException('$documento (CPF)',11);
        } elseif($this->tipoCliente === TipoCliente::PessoaJuridica && $lenDoc !== 14) {
            throw new ArgumentoMuitoLongoException('$sobrenome (CNPJ)',14);
        }

        if(str_contains(strtolower($documento),'pf') && Validacao::CPF($docNum)){
            $this->tipoCliente = TipoCliente::PessoaFisica;
        } elseif(str_contains(strtolower($documento),'pj') && Validacao::CNPJ($docNum)) {
            $this->tipoCliente = TipoCliente::PessoaJuridica;
        } else {
            throw new InvalidArgumentException('Não foi possível distinguir pessoa física de pessoa jurídica!');
        }

        $this->documento = $docNum;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string {
        return $this->email;
    }

    /**
     * @param string $email
     * @return $this
     * @throws InvalidArgumentException Ocorre quando o *$email* é um endereço de e-mail inválido!
     * @throws ArgumentoMuitoLongoException Ocorre quando o *$email* foi passado com mais de 255 caractéres.
     */
    public function setEmail(string $email): Usuario {
        if(strlen($email) > 255){
            throw new ArgumentoMuitoLongoException('$email',255);
        }
        if(!Validacao::Email($email)) {
            throw new InvalidArgumentException("E-mail inválido!");
        }
        $this->email = $email;
        return $this;
    }

    /**
     * @return Genero
     */
    public function getGenero(): Genero {
        return $this->genero;
    }

    /**
     * @param Genero $genero
     * @return $this
     */
    public function setGenero(Genero $genero): Usuario {
        $this->genero = $genero;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getAniversario(): DateTime {
        return $this->aniversario;
    }

    /**
     * @param DateTime $aniversario
     * @return $this
     */
    public function setAniversario(DateTime $aniversario): Usuario {
        $this->aniversario = $aniversario;
        return $this;
    }

    /**
     * Criptografa a senha com o algoritmo **BCrypt**, ao qual até o momento se mostrou mais eficaz.
     * @param string $senha
     * @return Usuario
     */
    public function setSenha(string $senha): Usuario {
        $this->senha = Bcrypt::encrypt($senha,"2y",self::TRABALHOS_SENHA_BCRYPT);
        return $this;
    }

    /**
     * Criptografa a senha com o algoritmo **BCrypt**, ao qual até o momento se mostrou mais eficaz.
     * @param string $senha
     * @return Usuario
     */
    private function setSenhaDoDB(string $senha): Usuario {
        $this->senha = $senha;
        return $this;
    }

    /**
     * Testa se a senha informada bate com a senha criptografada com o algoritmo **BCrypt**.
     * @param string $senha
     * @return bool
     */
    public function veracidadeSenha(string $senha): bool {
        return Bcrypt::verify($senha,$this->senha);
    }

    /**
     * Retorna o nome e sobrenome
     * @return string
     */
    function __toString(): string {
        return $this->nome . " " . $this->sobrenome;
    }

    /**
     * Libera a memória, fazendo a coleta de lixo.
     */
    function __destruct() {
        unset(
            $this->id,
            $this->nome,
            $this->sobrenome,
            $this->documento,
            $this->email,
            $this->senha,
            $this->aniversario,
            $this->telefonesUsuario,
            $this->tipoCliente,
            $this->genero
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int {
        return $this->id;
    }

    public static function getUsuarioById(int $id):?Usuario{
        /** @var mysqli $db */
        $db = require("../db.php");
        $buscaUsuario = $db->prepare("SELECT * FROM Usuarios WHERE id = ?");
        // O primeiro parâmetro do método'bind_param' (o $types), só aceita os seguintes argumentos:
        // s -> String (para cadeia de caractéres longa)
        // i -> Inteiro (para números inteiros)
        // d -> Duplo (para números decimais por exemplo)
        // b -> Booliano (para True ou False)
        $buscaUsuario->bind_param("s",$id);
        return self::fillDados($buscaUsuario,$db);
    }
    public static function getUsuarioByEmail(string $email):?Usuario{
        /** @var mysqli $db */
        $db = require("../db.php");
        $buscaUsuario = $db->prepare("SELECT * FROM Usuarios WHERE email = ?");
        // O primeiro parâmetro do método'bind_param' (o $types), só aceita os seguintes argumentos:
        // s -> String (para cadeia de caractéres longa)
        // i -> Inteiro (para números inteiros)
        // d -> Duplo (para números decimais por exemplo)
        // b -> Booliano (para True ou False)
        $buscaUsuario->bind_param("s",$email);
        return self::fillDados($buscaUsuario,$db);
    }
    private static function fillDados(mysqli_stmt &$buscaUsuario,mysqli &$db): ?Usuario{
        $buscaUsuario->execute();
        $resultadoBusca = $buscaUsuario->get_result();
        if($resultadoBusca->num_rows === 0) { return null; }
        $resultado = $resultadoBusca->fetch_assoc();
        $objUsuario = (new Usuario(intval($resultado['id'])))
            ->setNome((string)$resultado['nome'])
            ->setSobrenome((string)$resultado['sobrenome'])
            ->setDocumento((string)$resultado['documento'])
            ->setGenero(Genero::parse($resultado['genero']))
            ->setAniversario(new DateTime((string)$resultado['aniversario']))
            ->setEmail((string)$resultado['email'])
            ->setSenhaDoDB((string)$resultado['senha']);

        $buscaEndereco = $db->prepare("SELECT * FROM Endereco_usuarios WHERE id_usuario = " . $objUsuario->getId() . " ORDER BY id DESC");
        $buscaEndereco->execute();
        $resultadoEnderecos = $buscaEndereco->get_result();
        while($linhasEnd = $resultadoEnderecos->fetch_assoc()){
            $objUsuario->setEnderecosUsuario(
                (new EnderecoUsuario(intval($linhasEnd['id'])))
                    ->setDescricao((string)$linhasEnd['descricao'])
                    ->setFinalidade((string)$linhasEnd['finalidade'])
                    ->setEndereco((string)$linhasEnd['endereco'])
                    ->setNumero(intval($linhasEnd['numero']))
                    ->setComplemento((string)$linhasEnd['complemento'])
                    ->setBairro((string)$linhasEnd['bairro'])
                    ->setCidade((string)$linhasEnd['cidade'])
                    ->setEstado(Estado::parse( $linhasEnd['estado']))
                    ->setCep((string)$linhasEnd['cep'])
            );
        }
        $buscaTelefone = $db->prepare("SELECT * FROM Telefones_usuarios WHERE id_usuario = " . $objUsuario->getId() . " ORDER BY id DESC");
        $buscaTelefone->execute();
        $resultadoEnderecos = $buscaTelefone->get_result();
        while($linhasEnd = $resultadoEnderecos->fetch_assoc()){
            $objUsuario->setTelefonesUsuario(
                (new TelefoneUsuario(intval($linhasEnd['id'])))
                    ->setDescricao((string)$linhasEnd['descricao'])
                    ->setDDD(intval($linhasEnd['ddd']))
                    ->setTelefone((string)$linhasEnd['telefone'])
                    ->setWhatsApp(boolval($linhasEnd['whatsapp']))
                    ->setTelegram(boolval($linhasEnd['telegram']))
                    ->setWeChat(boolval($linhasEnd['wechat']))
                    ->setSMS(boolval($linhasEnd['sms']))
                    ->setChamadas(boolval($linhasEnd['chamadas']))
            );
        }
        unset($buscaTelefone,$buscaEndereco,$buscaUsuario,$resultadoBusca,$db);
        return $objUsuario;
    }
}