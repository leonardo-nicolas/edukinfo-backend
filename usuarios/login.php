<?php
namespace EdukInfo;
use DateInterval;
use DateTime;
use DateTimeInterface;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\Usuario;
use Firebase\JWT\JWT;


require_once "../inicializador.php";


header('content-type:application/json;charset=utf-8');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $statusCode = StatusCodes::MethodNotAllowed;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "login somente via POST"
    ],$statusCode,$buscaUsuario,$input,$statusCode);
}

$input = json_decode(file_get_contents('php://input'));

$objUsuario = Usuario::getUsuarioByEmail($_POST['email']);

if($objUsuario === null) {
    $statusCode = StatusCodes::NotFound;
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "Usuário não encontrado!"
    ],$statusCode,$buscaUsuario,$input);
} elseif(!$objUsuario->veracidadeSenha($_POST['senha'])) {
    $statusCode = StatusCodes::Unauthorized;
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "Desculpe " . $objUsuario->getNome() . ", mas sua senha está inválida!"
    ], $statusCode, $resultado, $objUsuario, $buscaUsuario, $input, $statusCode);
} else {
    if(isset($_POST['validade'])) {
        $duracao = new DateInterval("P" . strtoupper($_POST["validade"]));
    } else {
        $duracao = new DateInterval("P7D");
    }
    $mais7dias = (new DateTime())->add($duracao);
    $validade = $mais7dias->format(DateTimeInterface::W3C);
    $jwt = JWT::encode([
        "idUsuario"=>$objUsuario->getId() ?? -1,
        "validade"=>str_replace('-03:00','',$validade)
    ],'chave_tosca','HS256');
    $resultado = [
        "jwt" => $jwt,
        "validade" => str_replace('-03:00','',$validade),
        "usuario"=>$objUsuario->toJsonArray()
    ];
    echo json_encode($resultado);
}
