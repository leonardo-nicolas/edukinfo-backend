<?php

namespace EdukInfo;

use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\Usuario;

require_once "../inicializador.php";

header('Content-type:application/json;charset=utf-8');

if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    $statusCode = StatusCodes::MethodNotAllowed;
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$statusCode);
} else if(!isset($_GET['email'])){
    $statusCode = StatusCodes::BadRequest;
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Era esperado a passagem de e-mail no argumento de query-string!"
    ],$statusCode,$statusCode);
}

echo json_encode([
    'userName' => $_GET['email'],
    'exists' => Usuario::getUsuarioByEmail($_GET['email']) !== null
]);