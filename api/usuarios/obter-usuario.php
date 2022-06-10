<?php
namespace EdukInfo;

use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\ErrosRecuperacaoSenha;
use EdukInfo\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once __DIR__ . "/../inicializador.php";


header('content-type:application/json;charset=utf-8');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: *');


$gotHeaders = apache_request_headers();
$header = [];
foreach($gotHeaders as $jwtCifrado=> $valor) {
    $header[strtolower($jwtCifrado)] = strtolower($jwtCifrado) === 'authorization' ? $valor : strtolower($valor);
}

if($_SERVER['REQUEST_METHOD'] !== 'GET'){
    $statusCode = StatusCodes::MethodNotAllowed;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$buscaUsuario,$input);
}elseif(!(isset($_GET['id']) || isset($header['authorization']) || isset($_GET['token']))){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Era esperado a passagem do ID no argumento de query-string ou".
	        " do http-header 'Authorization' com o token bearer!"
    ],$statusCode);
}
if(isset($header['authorization'])){
	$jwtCifrado = str_replace('Bearer ', '', $header['authorization']);
	$chave = new Key('chave_tosca', 'HS256');
    $objJWT = JWT::decode($jwtCifrado, $chave);
	$id = $objJWT->idUsuario;
	unset($jwtCifrado,$objJWT,$chave);
} elseif(isset($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_GET['token'])){
	$token = base64_decode($_GET['token']);
	$id = Usuario::getIdUsuarioByToken($token);
	$possivelErro = match ($id){
		ErrosRecuperacaoSenha::TokenVencido => [
			"erro"=>StatusCodes::Forbidden,
			"mensagem"=>"Este token para troca de senha foi expirado!"
		],
		ErrosRecuperacaoSenha::TokenNaoEncontrado => [
			"erro"=>StatusCodes::NotFound,
			"mensagem"=>"Token para recuperação de senha NÃO ENCONTRADO ou INVÁLIDO!"
		],
		default => null
	};
	if($id instanceof ErrosRecuperacaoSenha && $possivelErro !== null) {
		FuncoesDiversas::devolverJsonErro($possivelErro, $id, $possivelErro,$token);
	}
} else {
	// Este bloco de "else" é apenas para suprimir algum eventual erro
	// de servidor e também para suprimir erro de IDE. Porém, chegar neste bloco é pouquíssimo provável.
	// Mas, como a IDE não reconhece a existência de $id, se não for declarado, fora do "else", ela acusa erro...
	// Porém, se por algum motivo chegar aqui, já evitará erros do tipo 'undefined' similar ao JavaScript.
	$id = -1;
}
$usuario = Usuario::getUsuarioById($id);

if($usuario === null){
    $statusCode = StatusCodes::NotFound;
    FuncoesDiversas::devolverJsonErro([
        "erro"=>$statusCode,
        "mensagem"=>"Não foi possível encontrar o usuário com este identificador interno..."
    ],$statusCode,$usuario,$id);
} else {
    echo json_encode(["dados"=>$usuario->toJsonArray()]);
}
unset($usuario,$id);