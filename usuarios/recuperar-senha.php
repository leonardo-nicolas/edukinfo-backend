<?php
namespace EdukInfo;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
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
        "mensagem" => "login somente via POST"
    ],$statusCode,$buscaUsuario,$input,$statusCode);
}
if(!isset($_POST['email'])){
    $statusCode = StatusCodes::BadRequest;
    http_response_code($statusCode->value);
    FuncoesDiversas::devolverJsonErro([
        "erro" => $statusCode,
        "mensagem"=>"Não recebemos o e-mail do usuário a recuperar a senha..."
    ],$statusCode,$statusCode);
}

$usuario = Usuario::getUsuarioByEmail($_POST['email']);

if($usuario === null){
    FuncoesDiversas::devolverJsonErro([ "codigo" => 404 ]);
}

/** @var PHPMailer $mail */
$mail = require(__DIR__.'/../mail.php');

$mail->addAddress($usuario->getEmail(),$usuario->getNome());
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
$token = uniqid(rand(), true);
$mail->Subject = "Redefinição de senha!";
$mail->Body = '<!doctype html>';
$mail->Body .= '<html lang="pt-br">';
$mail->Body .= '<head>'."<title>Seja muito $boasVindas! Vamos recuperar a senha!</title>".'</head><body>';
$mail->Body .= "<h1>Olá $cumprimentaUsuario!</h1>";
$mail->Body .= "<h3><a href=\"http://edukinfo.com.br/senha-nova?token=$token\">Clique aqui</a> para recuperar sua senha! Ou copie o link abaixo no link abaixo!</h3>";
$mail->Body .= 'Utilize sempre seu e-mail \'' . $usuario->getEmail() . "' para fazer seu login e a senha em que você usou no cadastro.</a>";
$mail->Body .= "</body></html>";
echo json_encode([
    "codigo" => $mail->send() ? 200 : 400
]);