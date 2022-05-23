<?php
namespace EdukInfo;
use mysqli;

/** @var mysqli $db */
$db = require(__DIR__ . '/../db.php');
$faqDB = $db->prepare("SELECT * FROM faq ORDER BY RAND()");
$faqDB->execute();
$faqResultado = $faqDB->get_result();
$faqJson = [];
header('content-type:application/json;charset=utf-8');
while($faqLinha = $faqResultado->fetch_assoc()){
    $faqJson[] = [
        "pergunta"=>strval($faqLinha["pergunta"]),
        "resposta"=>strval($faqLinha["resposta"])
    ];
}
unset($db,$faqDB,$faqResultado,$faqLinha);
echo json_encode($faqJson);