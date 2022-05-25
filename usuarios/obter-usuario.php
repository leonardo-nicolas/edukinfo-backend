<?php


use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . "/../inicializador.php";


header('content-type:application/json;charset=utf-8');

$gotHeaders = apache_request_headers();
$header = [];
foreach($gotHeaders as $chave=>$valor) {
    $header[strtolower($chave)] = strtolower($chave) === 'authorization' ? $valor : strtolower($valor);
}

if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    $statusCode = StatusCodes::MethodNotAllowed;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$buscaUsuario,$input);
}elseif(!(isset($_GET['id']) || isset($header['authorization']))){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Era esperado a passagem do ID no argumento de query-string ou do http-header 'Authorization' com o token bearer!"
    ],$statusCode);
}
if(isset($header['authorization'])){
    $id = JWT::decode(str_replace('Bearer ', '', $header['authorization']),new Key('chave_tosca','HS256'))->idUsuario;
} else {
    $id = intval($_GET['id']);
}
$usuario = Usuario::getUsuarioById($id);

if($usuario === null){
    $statusCode = StatusCodes::NotFound;
    FuncoesDiversas::devolverJsonErro([
        "erro"=>$statusCode,
        "mensagem"=>"Não foi possível encontrar o usuário com este identificador interno..."
    ],$statusCode,$usuario);
} else {
    echo json_encode($usuario->toJsonArray());
}
