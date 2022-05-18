<?php
namespace EdukInfo;
use EdukInfo\Functions\FuncoesDiversas;
use EdukInfo\Functions\StatusCodes;
use EdukInfo\Models\EnderecoUsuario;
use EdukInfo\Models\Estado;
use EdukInfo\Models\Genero;
use EdukInfo\Models\TelefoneUsuario;
use EdukInfo\Models\Usuario;
use Exception;
use mysqli;
use DateTime;


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
//
///** @var mysqli $db */
//$db = require("../db.php");
//
//$buscaUsuario = $db->prepare("SELECT * FROM Usuarios WHERE email = ?");
//// O primeiro parâmetro do método'bind_param' (o $types), só aceita os seguintes argumentos:
//// s -> String (para cadeia de caractéres longa)
//// i -> Inteiro (para números inteiros)
//// d -> Duplo (para números decimais por exemplo)
//// b -> Booliano (para True ou False)
//$buscaUsuario->bind_param("s",$_POST['email']);
//$buscaUsuario->execute();
//
//$resultadoBusca = $buscaUsuario->get_result();
//if($resultadoBusca->num_rows === 0) {
//
//}
//$resultado = $resultadoBusca->fetch_assoc();
//$objUsuario = new Usuario(intval($resultado['id']));
//try {
//    $objUsuario
//        ->setAniversario(new DateTime((string)$resultado['aniversario']))
//        ->setEmail((string)$resultado['email'])
//        ->setGenero(Genero::parse($resultado['genero']))
//        ->setDocumento((string)$resultado['documento'])
//        ->setSenhaDoDB((string)$resultado['senha']);
//} catch (Exception $ex) {
//    $statusCode = StatusCodes::InternalServerError;
//    FuncoesDiversas::devolverJsonErro([
//        "codErro" => $statusCode,
//        "mensagem" => "O erro " . get_class($ex) ." foi obtido, com a mensagem '" . $ex->getMessage() ."'."
//    ],$statusCode,$resultado,$objUsuario,$buscaUsuario,$input,$statusCode);
//}
//if(isset($objUsuario) && !$objUsuario->veracidadeSenha($_POST['senha'])){

//}
//$buscaEndereco = $db->prepare("SELECT * FROM Endereco_usuarios WHERE id_usuario = " . $objUsuario->getId() . " ORDER BY id DESC");
//$buscaEndereco->execute();
//$resultadoEnderecos = $buscaEndereco->get_result();
//while($linhasEnd = $resultadoEnderecos->fetch_assoc()){
//    $objUsuario->setEnderecosUsuario(
//        (new EnderecoUsuario(intval($linhasEnd['id'])))
//            ->setDescricao((string)$linhasEnd['descricao'])
//            ->setFinalidade((string)$linhasEnd['finalidade'])
//            ->setEndereco((string)$linhasEnd['endereco'])
//            ->setNumero(intval($linhasEnd['numero']))
//            ->setComplemento((string)$linhasEnd['complemento'])
//            ->setBairro((string)$linhasEnd['bairro'])
//            ->setCidade((string)$linhasEnd['cidade'])
//            ->setEstado(Estado::parse( $linhasEnd['Estado']))
//            ->setCep((string)$linhasEnd['cep'])
//    );
//}
//$buscaTelefone = $db->prepare("SELECT * FROM Telefones_usuarios WHERE id_usuario = " . $objUsuario->getId() . " ORDER BY id DESC");
//$buscaTelefone->execute();
//$resultadoEnderecos = $buscaTelefone->get_result();
//while($linhasEnd = $resultadoEnderecos->fetch_assoc()){
//    $objUsuario->setTelefonesUsuario(
//        (new TelefoneUsuario(intval($linhasEnd['id'])))
//            ->setDescricao((string)$linhasEnd['descricao'])
//            ->setDDD(intval($linhasEnd['ddd']))
//            ->setTelefone((string)$linhasEnd['telefone'])
//            ->setWhatsApp(boolval($linhasEnd['whatsapp']))
//            ->setTelegram(boolval($linhasEnd['telegram']))
//            ->setWeChat(boolval($linhasEnd['wechat']))
//            ->setSMS(boolval($linhasEnd['sms']))
//            ->setChamadas(boolval($linhasEnd['chamadas']))
//    );
//}


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
