<?php


use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\Usuario;

require_once __DIR__ . "/../inicializador.php";


header('content-type:application/json;charset=utf-8');

if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    $statusCode = StatusCodes::MethodNotAllowed;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$buscaUsuario,$input);
}elseif(!isset($_GET['id'])){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Era esperado a passagem de e-mail ou de CPF/CNPJ no argumento de query-string!"
    ],$statusCode);
}

$usuario = Usuario::getUsuarioById($_GET['id']);

if($usuario === null){
    $statusCode = StatusCodes::NotFound;
    FuncoesDiversas::devolverJsonErro([
        "erro"=>$statusCode,
        "mensagem"=>"Não foi possível encontrar o usuário com este identificador interno..."
    ],$statusCode,$usuario);
} else {
    echo json_encode($usuario->toJsonArray());
}