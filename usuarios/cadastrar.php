<?php
namespace EdukInfo;
require_once "../inicializador.php";
$input = json_decode(file_get_contents('php://input'));
var_dump($input);

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    die("Cadastro somente via POST");
}

echo'Vamos cadastrar';