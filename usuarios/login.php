<?php
namespace EdukInfo;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\Usuario;


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
    ],$statusCode,$buscaUsuario,$input,$statusCode);
} else if(!$objUsuario?->veracidadeSenha($_POST['senha'])) {
    $statusCode = StatusCodes::Unauthorized;
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "Desculpe " . $objUsuario->getNome() . ", mas sua senha está inválida!"
    ], $statusCode, $resultado, $objUsuario, $buscaUsuario, $input, $statusCode);
} else {
    echo json_encode($objUsuario?->toJsonArray());
}
