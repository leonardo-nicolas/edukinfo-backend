<?php

namespace EdukInfo;

use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\Usuario;

require_once __DIR__ . "/../inicializador.php";

header('Content-type:application/json;charset=utf-8');

if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    $statusCode = StatusCodes::MethodNotAllowed;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$statusCode);
} elseif(!(isset($_GET['email']) || isset($_GET['documento']))){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Era esperado a passagem de e-mail ou de CPF/CNPJ no argumento de query-string!"
    ],$statusCode,$statusCode);
}

if(isset($_GET['email'])) {
    $usuario = Usuario::getUsuarioByEmail($_GET['email']);
}
elseif (isset($_GET['documento'])) {
    $usuario = Usuario::getUsuarioByDocumento($_GET['documento']);
}
else {
    $usuario = null;
}
$userName = "";
if(isset($_GET['documento']) && $usuario !== null) {
    $splitEmail = explode('@', $usuario->getEmail());
    $splitEmail2 = explode('.', $splitEmail[1]);
    $extensoesIgnoradas = ['com','br','edu','gov','online','eng','en','us'];
    $contador = count($splitEmail2);
    for ($i = 0; $i < $contador; ++$i) {
        if (in_array(strtolower($splitEmail2[$i]),$extensoesIgnoradas,true)) {
            break;
        }
        $comprimentoProtecao = strlen($splitEmail[$i]) < 3 ? 1 : 2;
        $splitEmail2[$i] = substr($splitEmail2[$i], 0, $comprimentoProtecao) . str_repeat('*', strlen($splitEmail2[$i]) - $comprimentoProtecao);
        unset($comprimentoProtecao);
    }
    $comprimentoProtecao = strlen($splitEmail[0]) <= 3 ? 1 : 3;
    $userName = substr($splitEmail[0], 0, $comprimentoProtecao);
    $userName .= str_repeat('*', strlen($splitEmail[0]) - $comprimentoProtecao - 3);
    $userName .= substr($splitEmail[0],-3);
    $userName .= "@" . implode(".", $splitEmail2);
    unset($comprimentoProtecao,$splitEmail,$splitEmail2,$contador,$extensoesIgnoradas,$comprimentoProtecao);
} elseif(isset($_GET['email']) && $usuario !== null){
    $userName = $usuario->getEmail();
}
echo json_encode([
    'userName' => $userName,
    'exists' => $usuario !== null
]);
