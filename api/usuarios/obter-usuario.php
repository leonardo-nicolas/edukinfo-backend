<?php
namespace EdukInfo;

use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Functions\Validacao;
use EdukInfo\Models\ErrosRecuperacaoSenha;
use EdukInfo\Models\Usuario;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use InvalidArgumentException;
use PHPMailer\PHPMailer\Exception;

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
        "codigo" => $statusCode,
        "mensagem" => "Por favor, utilize o método GET para esta requisição!"
    ],$statusCode,$buscaUsuario,$input);
}elseif(!(isset($_GET['id']) || isset($header['authorization']) || isset($_GET['token']))){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "codigo" => $statusCode,
        "mensagem"=>"Era esperado a passagem do ID no argumento de query-string ou".
	        " do http-header 'Authorization' com o token bearer!"
    ],$statusCode);
}
if(isset($header['authorization'])){
	$jwtCifrado = str_replace('Bearer ', '', $header['authorization']);
	$config = new Config();
	$chave = new Key($config->jwt->chave, $config->jwt->algoritmo);
    $objJWT = JWT::decode($jwtCifrado, $chave);
	$id = $objJWT->idUsuario;
	unset($jwtCifrado,$objJWT,$chave);
} elseif(isset($_GET['id'])) {
    $id = intval($_GET['id']);
} elseif (isset($_GET['token'])){
	function token_invalido(StatusCodes $statusCode,$mensagem):never {
		FuncoesDiversas::devolverJsonErro([
			"codigo" => $statusCode,
			"mensagem" => $mensagem
		],$statusCode);
	}
	try {
		$token = FuncoesDiversas::decodificar_base64($_GET['token']);
	} catch (InvalidArgumentException){
		token_invalido(StatusCodes::InternalServerError,"O token não pode ser decodificado");
	}

	if(!preg_match('/^[\da-f]+.?[\da-f]+$/im',$token)){
		token_invalido(StatusCodes::BadRequest,"O token não é um token válido!");
	}
	$id = Usuario::getIdUsuarioByToken($token);
	if($id instanceof ErrosRecuperacaoSenha)
	{
		$forcarIdUsuarioPorToken = Usuario::getIdUsuarioByToken($token,true);
		$usuarioTemp = Usuario::getUsuarioById($forcarIdUsuarioPorToken);
		$respostaJson = [
			"codigo" => match ($id) {
				ErrosRecuperacaoSenha::ErroInterno => StatusCodes::BadRequest,
				ErrosRecuperacaoSenha::TokenNaoEncontrado => StatusCodes::NotFound,
				ErrosRecuperacaoSenha::TokenVencido, ErrosRecuperacaoSenha::TokenUsado => StatusCodes::Forbidden,
			},
			"mensagem" => match ($id) {
				ErrosRecuperacaoSenha::ErroInterno => "Ocorreu um erro interno ao tentar obter o token!",
				ErrosRecuperacaoSenha::TokenNaoEncontrado => "Desculpe, mas o token não foi encontrado...",
				ErrosRecuperacaoSenha::TokenVencido => "Desculpe {$usuarioTemp?->getNome()}, mas o token expirou...",
				ErrosRecuperacaoSenha::TokenUsado => "Desculpe {$usuarioTemp?->getNome()}, mas você já usou este " .
					"token. Por favor, solicite uma nova recuperação de senha!",
			},
			"dados" => match($id) {
				ErrosRecuperacaoSenha::TokenVencido,ErrosRecuperacaoSenha::TokenUsado=> $usuarioTemp?->toJsonArray(),
				default => null,
			}
		];
		unset($usuarioTemp,$forcarIdUsuarioPorToken);
		FuncoesDiversas::devolverJsonErro($respostaJson,$usuarioTemp,$forcarIdUsuarioPorToken,$id);
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
        "codigo"=>$statusCode,
        "mensagem"=>"Não foi possível encontrar o usuário com este identificador interno..."
    ],$statusCode,$usuario,$id);
} else {
    echo json_encode([
			"codigo" => StatusCodes::Ok,
			"dados"=>$usuario->toJsonArray()
		]);
}
unset($usuario,$id);
