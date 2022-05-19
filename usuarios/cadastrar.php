<?php
namespace EdukInfo;
use DateTime;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\EnderecoUsuario;
use EdukInfo\Models\Estado;
use EdukInfo\Models\Genero;
use EdukInfo\Models\TelefoneUsuario;
use EdukInfo\Models\Usuario;
use Exception;
use InvalidArgumentException;

require_once "../inicializador.php";


if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $statusCode = StatusCodes::MethodNotAllowed;
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$statusCode);
}

$input = json_decode(file_get_contents('php://input'));
var_dump($input);
$gotHeaders = apache_request_headers();
$gotHeaders2 = [];
foreach($gotHeaders as $chave=>$valor){
    $gotHeaders2[strtolower($chave)] = strtolower($valor);
}
if(!isset($gotHeaders2['content-type'])){
    $statusCode = StatusCodes::BadRequest;
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Por favor, passe o header 'Content-Type' como 'application/json'!"
    ],$statusCode,$statusCode);
}

if(!isset($input)){
    $statusCode = StatusCodes::BadRequest;
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
    $objUsuario->setDocumento($input?->user?->document?->type . $input?->user?->document?->number);
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
            (new EnderecoUsuario())
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
} catch (Exception $ex) {
    $statusCode = StatusCodes::InternalServerError;
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Foi ocorrido o erro " . get_class($ex) . ", no qual gerou a mensagem: " . $ex->getMessage() . "!"
    ],$statusCode,$statusCode);
}

$objUsuario = Usuario::novoUsuario($objUsuario);

var_dump($objUsuario);