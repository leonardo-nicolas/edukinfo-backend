<?php

namespace EdukInfo\Models;

use Bcrypt\Bcrypt;
use DateTime;
use DateTimeInterface;
use EdukInfo\Exceptions\ArgumentoMuitoLongoException;
use EdukInfo\Exceptions\RegistroDuplicadoException;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Functions\Validacao;
use Exception;
use InvalidArgumentException;
use JetBrains\PhpStorm\ArrayShape;
use LengthException;
use mysqli;
use mysqli_sql_exception;
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
        $docNum = preg_replace("/\D+/im","",$documento);
        $lenDoc = strlen($docNum);
        if($this->tipoCliente === TipoCliente::PessoaFisica && $lenDoc !== 11) {
            throw new ArgumentoMuitoLongoException('$documento (CPF)',11);
        } elseif($this->tipoCliente === TipoCliente::PessoaJuridica && $lenDoc !== 14) {
            throw new ArgumentoMuitoLongoException('$sobrenome (CNPJ)',14);
        }
        // str_contains(strtolower($documento),'pf')
        if(strlen($docNum) === 11 && Validacao::CPF($docNum)){
            $this->tipoCliente = TipoCliente::PessoaFisica;
        }
        // str_contains(strtolower($documento),'pj')
        elseif(strlen($docNum) === 14 && Validacao::CNPJ($docNum)) {
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

    // O primeiro parâmetro do método'bind_param' (o $types), só aceita os seguintes argumentos:
    // s -> String (para cadeia de caractéres longa)
    // i -> Inteiro (para números inteiros)
    // d -> Duplo (para números decimais por exemplo)
    // b -> Booliano (para True ou False)

    /**
     * Obtém algum usuário, apenas informando o CPF ou CNPJ.
     * @param string $documento Informe com 'PF' seguido do número do CPF ou 'PJ' seguido do número do CNPJ.
     * @return Usuario|null O resultado pronto. Podendo trazer todas as informações do usuário...
     * @throws ArgumentoMuitoLongoException Raro de acontecer, pois os dados já são cadastrados no banco de dados com todas as validações devidas...
     */
    public static function getUsuarioByDocumento(string $documento): ?Usuario {
        /** @var mysqli $db */
        $db = require("../db.php");
        $buscaUsuario = $db->prepare("SELECT * FROM Usuarios WHERE documento = ?");
        $documento = strtoupper($documento);
        $buscaUsuario->bind_param("s",$documento);
        return self::fillDadosAfterGet($buscaUsuario,$db);
    }

    /**
     * Obtém algum usuário informando o ID desse usuário...
     * @param int $id Informe o ID do usuário
     * @return Usuario|null O resultado pronto. Podendo trazer todas as informações do usuário...
     * @throws ArgumentoMuitoLongoException Raro de acontecer, pois os dados já são cadastrados no banco de dados com todas as validações devidas...
     */
    public static function getUsuarioById(int $id):?Usuario{
        /** @var mysqli $db */
        $db = require("../db.php");
        $buscaUsuario = $db->prepare("SELECT * FROM Usuarios WHERE id = ?");
        $buscaUsuario->bind_param("s",$id);
        return self::fillDadosAfterGet($buscaUsuario,$db);
    }

    /**
     * Obtém algum usuário informando o e-mail.
     * @param string $email Informe o email em que deseja obter o usuário.
     * @return Usuario|null O resultado pronto. Podendo trazer todas as informações do usuário...
     * @throws ArgumentoMuitoLongoException Raro de acontecer, pois os dados já são cadastrados no banco de dados com todas as validações devidas...
     */
    public static function getUsuarioByEmail(string $email):?Usuario{
        /** @var mysqli $db */
        $db = require("../db.php");
        $buscaUsuario = $db->prepare("SELECT * FROM Usuarios WHERE email = ?");
        $buscaUsuario->bind_param("s",$email);
        return self::fillDadosAfterGet($buscaUsuario,$db);
    }

    /**
     * Método apenas para a auxiliação dos métodos `getUsuarioById`, `getUsuarioByEmail` e `getUsuarioByDocumento`.
     * @param mysqli_stmt $buscaUsuario O objeto com a query preparada
     * @param mysqli $db O objeto do banco de dados
     * @return Usuario|null O resultado pronto. Podendo trazer todas as informações do usuário...
     * @throws ArgumentoMuitoLongoException Raro de acontecer, pois os dados já são cadastrados no banco de dados com todas as validações devidas...
     */
    private static function fillDadosAfterGet(mysqli_stmt &$buscaUsuario, mysqli &$db): ?Usuario{
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

        $buscaEndereco = $db->prepare("SELECT * FROM Endereco_usuarios WHERE id_usuario = " . $objUsuario->getId() . " ORDER BY rand(id) DESC");
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
        $buscaTelefone = $db->prepare("SELECT * FROM Telefones_usuarios WHERE id_usuario = " . $objUsuario->getId() . " ORDER BY rand(id) DESC");
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

    /**
     * Realiza a inserção de um novo usuário, na tabela 'Usuarios' do banco de dados, assim como a inserção dos
     * telefones e dos endereços, informado pelo usuário...
     * @throws ArgumentoMuitoLongoException
     * @throws RegistroDuplicadoException Ocorre quando já existe algum usuário cadastrado no banco de dados.
     * @throws mysqli_sql_exception Ocorre com algum eventual erro do MySQL...
     */
    public static function novoUsuario(Usuario $usuario): Usuario {
        /** @var mysqli $db */
        $existencia = [
            self::getUsuarioByEmail($usuario->email),
            self::getUsuarioByDocumento(($usuario->tipoCliente === TipoCliente::PessoaFisica ? 'pf' : 'pj') . $usuario->documento)
        ];
        if(!in_array(null,$existencia)) {
            throw new RegistroDuplicadoException($usuario->email);
        }
        $db = require('../db.php');
        $db->autocommit(false);
        $insert = $db->prepare('INSERT INTO Usuarios(nome, sobrenome, documento, genero, aniversario, email, senha) VALUES (?,?,?,?,?,?,?)');
        $documento = $usuario->tipoCliente === TipoCliente::PessoaFisica ? 'PF' : 'PJ' ;
        $documento .= $usuario->documento;
        $generoStr = $usuario->genero === Genero::feminino ? 'F' : 'M';
        $aniversarioStr = $usuario->aniversario->format('Y\\-m\\-d');
        $insert->bind_param("sssssss",
            $usuario->nome,
            $usuario->sobrenome,
            $documento,
            $generoStr,
            $aniversarioStr,
            $usuario->email,
            $usuario->senha,
        );
        if(!$insert->execute()) {
            unset($insert,$documento,$generoStr,$aniversarioStr);
            throw new mysqli_sql_exception("Ocorreu algum erro desconhecido com o MySQL.");
        }
        $idNovoUsuario = $db->insert_id;
        $usuarioRet = (new Usuario($idNovoUsuario))
            ->setNome($usuario->nome)
            ->setSobrenome($usuario->sobrenome)
            ->setDocumento($usuario->documento)
            ->setGenero($usuario->genero)
            ->setSenhaDoDB($usuario->senha)
            ->setAniversario($usuario->aniversario)
            ->setEmail($usuario->email);
        unset($insert);

        foreach ($usuario->enderecosUsuario as $endUsuarios){ //Adiciona cada endereço informado pelo usuário
            $insert = $db->prepare('INSERT INTO Endereco_usuarios (id_usuario,descricao,finalidade,endereco,numero,complemento,bairro,cidade,estado,cep) VALUES (?,?,?,?,?,?,?,?,?,?)');
            $desc = $endUsuarios->getDescricao();
            $fin = $endUsuarios->getFinalidade();
            $end = $endUsuarios->getEndereco();
            $num = $endUsuarios->getNumero();
            $comp = $endUsuarios->getComplemento();
            $bai = $endUsuarios->getBairro();
            $cid = $endUsuarios->getCidade();
            $objEstado = $endUsuarios->getEstado();
            $estd = $objEstado->value;
            $cep = $endUsuarios->getCep();
            // string, int, decimal, bool
            $insert->bind_param("isssisssss",$idNovoUsuario,$desc,$fin,$end,$num,$comp,$bai,$cid,$estd,$cep);
            if(!$insert->execute()) {
                $db->rollback();
                unset($desc,$fin,$end,$num,$comp,$bai,$cid,$estd,$cep,$insert,$documento,$generoStr,$usuario,$usuarioRet);
                throw new mysqli_sql_exception("Ocorreu algum erro desconhecido com o MySQL");
            }
            $usuarioRet->setEnderecosUsuario(
                (new EnderecoUsuario($db->insert_id))
                    ->setDescricao($desc)
                    ->setFinalidade($fin)
                    ->setEndereco($end)
                    ->setNumero($num)
                    ->setComplemento($comp)
                    ->setBairro($bai)
                    ->setCidade($cid)
                    ->setEstado($objEstado)
                    ->setCep($cep)
            );
            unset($desc,$fin,$end,$num,$comp,$bai,$cid,$estd,$cep,$insert);
        }
        foreach ($usuario->telefonesUsuario as $telUsuario){ //Adiciona cada telefone informado pelo usuário
            $insert = $db->prepare('INSERT INTO Telefones_usuarios (id_usuario, descricao, ddd, telefone, whatsapp, telegram, wechat, sms, chamadas) VALUES (?,?,?,?,?,?,?,?,?)');
            $desc = $telUsuario->getDescricao();
            $ddd = $telUsuario->getDDD();
            $tel = $telUsuario->getTelefone();
            $wpp = $telUsuario->isWhatsApp();
            $tgr = $telUsuario->isTelegram();
            $wch = $telUsuario->isWeChat();
            $sms = $telUsuario->isSMS();
            $cham = $telUsuario->isChamadas();
            // string, int, decimal, bool
            $insert->bind_param("isisbbbbb",$idNovoUsuario,$desc,$ddd,$tel,$wpp,$tgr,$wch,$sms,$cham);
            if(!$insert->execute()) {
                $db->rollback();
                unset($desc,$ddd,$tel,$wpp,$tgr,$wch,$sms,$cham,$insert,$documento,$generoStr,$usuario,$usuarioRet);
                throw new mysqli_sql_exception("Ocorreu algum erro desconhecido com o MySQL");
            }
            $usuarioRet->setTelefonesUsuario(
                (new TelefoneUsuario($db->insert_id))
                    ->setDescricao($desc)
                    ->setDDD($ddd)
                    ->setTelefone($tel)
                    ->setWhatsApp($wpp)
                    ->setTelegram($tgr)
                    ->setWeChat($wch)
                    ->setSMS($sms)
                    ->setChamadas($cham)
            );
            unset($desc,$ddd,$tel,$wpp,$tgr,$wch,$sms,$cham,$insert);
        }
        $db->commit();
        unset($documento,$generoStr,$usuario);//Liberação de memória
        $db->autocommit(true);
        return $usuarioRet;
    }
}