<?php
namespace EdukInfo;
use mysqli;
require_once(__DIR__ . '/../inicializador.php');
/** @var mysqli $db */
$db = require(__DIR__ . '/../db.php');
$linhaTempoDB = $db->prepare("SELECT * FROM Linha_do_tempo ORDER BY data_ocorrencia DESC");
$linhaTempoDB->execute();
$linhaTempoResultado = $linhaTempoDB->get_result();
$linhaTempoJson = [];
header('content-type:application/json;charset=utf-8');
while($linhaTempoLinha = $linhaTempoResultado->fetch_assoc()){
    $linhaTempoJson[] = [
        "imagem"=>strval($linhaTempoLinha["url_imagem"]),
        "altImg"=>strval($linhaTempoLinha["txt_alternativo"]),
        "tituloImg"=>strval($linhaTempoLinha["img_titulo"]),
        "titulo"=>strval($linhaTempoLinha["titulo"]),
        "texto"=>strval($linhaTempoLinha["texto"]),
    ];
}
unset($db,$linhaTempoDB,$linhaTempoResultado,$linhaTempoLinha);
echo json_encode($linhaTempoJson);
