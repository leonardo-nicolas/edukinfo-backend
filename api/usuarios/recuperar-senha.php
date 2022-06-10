<?php
namespace EdukInfo;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\ErrosRecuperacaoSenha;
use EdukInfo\Models\Genero;
use EdukInfo\Models\TipoCliente;
use EdukInfo\Models\Usuario;
use PHPMailer\PHPMailer\PHPMailer;

require_once __DIR__ . "/../inicializador.php";


header('content-type:application/json;charset=utf-8');

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    $statusCode = StatusCodes::MethodNotAllowed;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "codErro" => $statusCode,
        "mensagem" => "Esta página só trabalha apenas via método POST"
    ],$statusCode,$buscaUsuario,$input,$statusCode);
}

$dadosNecessarios = [
	isset($_POST['email']),
	isset($_POST['senha']),
	isset($_POST['id']),
	isset($_POST['token'])
];
if(!in_array(true,$dadosNecessarios,true)){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Não recebemos o e-mail do usuário a recuperar a senha ou a senha para alterar..."
    ],$statusCode,$statusCode,$dadosNecessarios);
}
if(isset($_POST['email'])) {
	$usuario = Usuario::getUsuarioByEmail($_POST['email']);

	if ($usuario === null) {
		FuncoesDiversas::devolverJsonErro(["codigo" => 404],$dadosNecessarios,$usuario);
	}

	/** @var PHPMailer $mail */
	$mail = require(__DIR__ . '/../mail.php');

	$mail->addAddress($usuario->getEmail(), $usuario->getNome());
	$tratamentoPessoa = match ($usuario->getGenero()) {
		Genero::masculino => "sr ",
		Genero::feminino => "sra ",
		default => ""
	};
	$mail->isHTML(true);
	$boasVindas = $usuario->getGenero() === Genero::feminino ? 'bem-vinda' : 'bem-vindo';
	$cumprimentaUsuario = ($usuario->getTipoCliente() === TipoCliente::PessoaJuridica ?
		('Representande da ' . $usuario->getNome()) :
		($tratamentoPessoa . $usuario->getNome())
	);
//("Olá $cumprimentaUsuario! Segue o link para recuperar senha http://localhost/");

	$tokenDB = Usuario::recuperarSenha();
	if($tokenDB !== null) {
		$tokenDB = base64_encode($tokenDB);
		$tokenDB = urlencode($tokenDB);
		$mail->Subject = "Redefinição de senha!";
		$mail->Body = '<!doctype html>';
		$mail->Body .= '<html lang="pt-br">';
		$mail->Body .= "<head><title>Seja muito $boasVindas! Vamos recuperar a senha!</title></head><body>";
		$mail->Body .= "<h1>Olá $cumprimentaUsuario!</h1>";
		$mail->Body .= "<h3><a href=\"http://edukinfo.localhost/login/recuperarSenha?token=$tokenDB\">Clique aqui</a>";
		$mail->Body .= "para recuperar sua senha! Ou copie o link abaixo no link abaixo!</h3>";
		$mail->Body .= "<strong>Caso não funcione</strong>, copie e cole em seu navegador (Google Chrome,";
		$mail->Body .= " Samsung Internet, Microsoft Edge, Opera, Brave, etc): ";
		$mail->Body .= '<p style="background: rgb(27,27,27); color:#FFF font-size: 14pt; margin: 0; padding: 0 2px;">';
		$mail->Body .= "http://edukinfo.localhost/login/recuperarSenha?token=$tokenDB</p>";
		$mail->Body .= "</body></html>";
		echo json_encode([
			"codigo" => $mail->send() ? 200 : 400
		]);
	}
}

if (isset($_POST['senha']) && (isset($_POST['id']) || isset($_POST['token']))) {
	$token = isset($_POST['token']) ? base64_decode(strval($_POST['token'])) : null;
	$idUsuario = $token !== null ?
		Usuario::getIdUsuarioByToken($token) :
		Usuario::getUsuarioById($_POST['id'])?->getId() ?? ErrosRecuperacaoSenha::ErroInterno;
	if($idUsuario instanceof ErrosRecuperacaoSenha) {
		$respostaJson = [
			"codigo" => match ($idUsuario) {
				ErrosRecuperacaoSenha::ErroInterno => StatusCodes::BadRequest,
				ErrosRecuperacaoSenha::TokenNaoEncontrado => StatusCodes::NotFound,
				ErrosRecuperacaoSenha::TokenVencido => StatusCodes::Forbidden,
			}
		];
	} else {
		if(Usuario::trocarSenha($idUsuario, $_POST['senha'])) {
			$respostaTrocaSenha = StatusCodes::Ok;
		} else {
			$respostaTrocaSenha = StatusCodes::BadRequest;
		}
		$respostaJson = ["codigo" => $respostaTrocaSenha];
		unset($respostaTrocaSenha);
	}

	echo json_encode($respostaJson);
	unset($idUsuario,$token,$respostaJson);
}

unset($dadosNecessarios);
