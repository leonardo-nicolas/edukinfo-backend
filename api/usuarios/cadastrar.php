<?php
namespace EdukInfo;
use DateInterval;
use DateTime;
use DateTimeInterface;
use EdukInfo\Exceptions\ArgumentoMuitoLongoException;
use EdukInfo\Exceptions\RegistroDuplicadoException;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\Endereco;
use EdukInfo\Models\Estado;
use EdukInfo\Models\Genero;
use EdukInfo\Models\TelefoneUsuario;
use EdukInfo\Models\TipoCliente;
use EdukInfo\Models\Usuario;
use Exception;
use Firebase\JWT\JWT;
use InvalidArgumentException;
use PHPMailer\PHPMailer\PHPMailer;

require_once "../inicializador.php";

header('content-type: application/json;charset=utf-8');
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $statusCode = StatusCodes::MethodNotAllowed;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$statusCode);
}

$input = json_decode(file_get_contents('php://input'));
$gotHeaders = apache_request_headers();
$gotHeaders2 = [];
foreach($gotHeaders as $chave=>$valor){
    $gotHeaders2[strtolower($chave)] = strtolower($valor);
}
if(!isset($gotHeaders2['content-type'])){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Por favor, passe o header 'Content-Type' como 'application/json'!"
    ],$statusCode,$statusCode);
}

if(!isset($input)){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Nada foi recebido!"
    ],$statusCode,$statusCode);
}
$objUsuario = new Usuario();
try {
    $objUsuario->setNome($input?->user?->name);
    $objUsuario->setSobrenome($input?->user?->surname);
    $objUsuario->setEmail($input?->user?->mail);
    $objUsuario->setGenero(Genero::parse($input?->user?->genre));
    $objUsuario->setDocumento(strtoupper($input?->user?->document?->type) . $input?->user?->document?->number);
    $objUsuario->setAniversario(new DateTime($input?->user?->birthday));
    $objUsuario->setSenha($input?->password);
    if(!isset($input->phones)) { throw new InvalidArgumentException("Era esperado o objeto 'phones'."); }
    foreach ($input?->phones as $phone) {
        $objUsuario->setTelefonesUsuario(
            (new TelefoneUsuario())
                ->setDDD(intval($phone?->ddd))
                ->setTelefone($phone?->number)
                ->setWhatsApp(boolval($phone?->messaging?->isWhatsApp))
                ->setTelegram(boolval($phone?->messaging?->isTelegram))
                ->setWeChat(boolval($phone?->messaging?->isWeChat))
                ->setSMS(boolval($phone?->messaging?->isSMS))
                ->setChamadas(boolval($phone?->canCall))
                ->setDescricao($phone?->description)
        );
    }
    if(!isset($input->addresses)) { throw new InvalidArgumentException("Era esperado o objeto 'addresses'."); }
    foreach ($input?->addresses as $addr) {
        $objUsuario->setEnderecosUsuario(
            (new Endereco())
                ->setCep($addr?->zipCode)
                ->setEndereco($addr?->address)
                ->setBairro($addr?->neighbor)
                ->setCidade($addr?->city)
                ->setEstado(Estado::parse($addr?->state))
                ->setFinalidade($addr?->purpose)
                ->setDescricao($addr?->description)
                ->setComplemento($addr?->complement)
                ->setNumero(intval($addr?->number))
        );
    }
} catch (ArgumentoMuitoLongoException|InvalidArgumentException $ex) {
    $classeErro = get_class($ex);
    http_response_code(StatusCodes::Ok->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => StatusCodes::BadRequest,
        "mensagem"=>"Foi ocorrido o erro ${$classeErro}, onde gerou a mensagem: " . $ex->getMessage()
    ],$ex,$classeErro);
} catch (Exception $ex) {
    $classeErro = get_class($ex);
    http_response_code(StatusCodes::Ok->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => StatusCodes::InternalServerError,
        "mensagem"=>"Foi ocorrido o erro ${$classeErro}, onde gerou a mensagem: " . $ex->getMessage()
    ],$ex,$classeErro);
}

header('Content-Type:application/json;charset=utf-8');
try {
    $objUsuario = Usuario::novoUsuario($objUsuario);
} catch (RegistroDuplicadoException $ex) {
    http_response_code(StatusCodes::Ok->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => StatusCodes::Conflict,
        "mensagem"=>"Já existe um usuário cadastrado com este e-mail ou CPF '" . $ex->email . "'! Por favor, tente recuperar sua seha ou use um outro e-mail!"
    ],$ex,$classeErro);
}
$hoje = new DateTime();
$duracao = new DateInterval("P1D");
$mais7dias = $hoje->add($duracao);
$validade = $mais7dias->format(DateTimeInterface::W3C);

$jwt = JWT::encode([
    "idUsuario"=>$objUsuario->getId() ?? -1,
    "validade"=>$validade
],'chave_tosca','HS256');
$resultado = [
    "jwt" => $jwt,
    "validade" => $validade,
    "usuario" => $objUsuario->toJsonArray()
];
/** @var PHPMailer $phpmailer */
$phpmailer = require(__DIR__.'/../mail.php');
$phpmailer->addAddress($objUsuario->getEmail(),$objUsuario->getNome());
$tratamentoPessoa = match ($objUsuario->getGenero()) {
    Genero::masculino => "sr ",
    Genero::feminino => "sra ",
    default => ""
};
$phpmailer->isHTML(true);
$boasVindas = ($objUsuario->getGenero() === Genero::feminino ? 'bem-vinda' : 'bem-vindo');
$cumprimentaUsuario = ($objUsuario->getTipoCliente() === TipoCliente::PessoaJuridica ?
	('Representande da ' . $objUsuario->getNome()) :
    ($tratamentoPessoa . $objUsuario->getNome())
);
$phpmailer->Subject = "Olá $cumprimentaUsuario, seja muito $boasVindas";
$phpmailer->Body = '<!doctype html>';
$phpmailer->Body .= '<html lang="pt-br">';
$phpmailer->Body .= "<head><title>$boasVindas</title></head>";
$phpmailer->Body .= "<body>";
$phpmailer->Body .= "<h1>Seja muito $boasVindas $tratamentoPessoa!</h1> ao nosso site!";
$phpmailer->Body .= "<h3>Esperamos que aprenda bastante com nossos cursos!</h3>";
$emailUsuario = $objUsuario->getEmail();
$phpmailer->Body .= "<h6>Utilize sempre seu e-mail $emailUsuario para fazer seu login e a senha em que você usou no cadastro.</h6>";
$phpmailer->Body .= "</body></html>";
try {
    $phpmailer->send();
} catch (Exception) {}

echo json_encode($resultado);
